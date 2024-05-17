<?php

include_once __DIR__ . "/index.php";
include_once __DIR__ . "/../config.php";
include_once __DIR__ . "/../partials/db.php";
include_once __DIR__ . "/../partials/order.php";
include_once __DIR__ . "/../partials/freight.php";
include_once __DIR__ . "/../partials/send_mail.php";
$db = new Db($config);

function updateExchanged($lastTotal)
{
    $exchanged = (int) $_SESSION['user']['exchanged'];
    $_SESSION['user']['exchanged'] = $exchanged + $lastTotal;
    $_SESSION['user']['balance'] = (int)$_SESSION['user']['total'] - ($exchanged + $lastTotal);
}

$userCod = $_SESSION['user']['cpf'];
$address = getAddress($db);

if (
    !isset($userCod)
    || !isset($address['postal_code'])
    || empty($address['postal_code'])
    || !isset($address['number'])
    || empty($address['number'])
) {
    $errors = 'Pedido não efetuado, problemas no endereço';
    $redirect = "http://" . $config['baseUrl'] . "/pedido?errors=" . $errors . '&cache=' . time();
    header("location:$redirect");
}

$street = $address['street'];
$number = $address['number'];
$postalCode = $address['postal_code'];
$complement = $address['complement'];
$district = $address['district'];
$region = $address['region'];
$city = $address['city'];
$reference = $address['reference'];

$order = getOrder();

if (!isset($order[0]->c)) {
    $errors = 'Pedido não efetuado';
    $redirect = "http://" . $config['baseUrl'] . "/pedido?errors=" . $errors . '&cache=' . time();
    header("location:$redirect");
}

$query = getQuery($order);
$_products = $db->select($query);
$productsOrder = populateOrder($order, $_products);
$subtotal = getTotal($productsOrder);

$freightRules = getFreightRules($address, $db);
$freightValue = calculateFreight($freightRules, $productsOrder);
$freightTotal = $freightValue * 100;
$total = ($subtotal + $freightTotal);

$count = count($order);
$status = 'Realizado';

if ($_SESSION['user']['total'] < $total) {
    $errors = 'Seu saldo de pontos não permite realizar o pedido.';
    $redirect = "http://" . $config['baseUrl'] . "/pedido?errors=" . $errors . '&cache=' . time();
    header("location:$redirect");
}

$orderQuery = "INSERT INTO `order` (
    `user_cod`,
    `postal_code`,
    `street`,
    `city`,
    `region`,
    `complement`,
    `district`,
    `number`,
    `reference`,
    `total`,
    `subtotal`,
    `frete`,
    `status`,
    `count`
    ) VALUES (
        '$userCod',
        '$postalCode',
        '$street',
        '$city',
        '$region',
        '$complement',
        '$district',
        '$number',
        '$reference',
        '$total',
        '$subtotal',
        '$freightTotal',
        '$status',
        '$count'
    )";

$orderId = $db->insert($orderQuery);

if (!$orderId || empty($orderId)) {
    $errors = 'Encontramos problema para salvar o pedido';
    $redirect = "http://" . $config['baseUrl'] . "/pedido?errors=" . $errors . '&cache=' . time();
    header("location:$redirect");
}

$itemsQuery = " INSERT INTO `order_item` (
    `cod`,
    `title`,
    `value`,
    `points`,
    `voltage`,
    `freight`,
    `status`,
    `order_id`,
    `user_cod`
) VALUES ";

$counter = 0;
foreach ($productsOrder as $key => $_product) {
    $counter++;
    $cod = $_product['cod'];
    $title = $_product['title'];
    $value = $_product['value'];
    $points = $_product['points'];
    $voltage = $_product['voltage'];
    $weight = calculateProductWeight($_product);
    $freight = calculateProductFreight($freightRules, $weight);

    $fildDivisor = ($count > $counter) ? ', ' : '';
    $itemsQuery .= "(
        '$cod',
        '$title',
        '$value',
        '$points',
        '$voltage',
        '$freight',
        '$status',
        '$orderId',
        '$userCod'
    ) $fildDivisor ";
}

$result = $db->query($itemsQuery);

if (!$result || empty($result)) {
    $errors = 'Encontramos problema para salvar os itens do pedido';
    $redirect = "http://" . $config['baseUrl'] . "/pedido?errors=" . $errors . '&cache=' . time();
    header("location:$redirect");
} else {
    deleteOrder();
    updateExchanged($total);

    $_email = $_SESSION['user']['email'];
    $_name = $_SESSION['user']['name'];
    $_date = date("m/d/Y");

    $_address = "$street, $number $complement <br />
    Bairro: $district - Cidade: $city - $region<br />
    CEP: $postalCode";
    $_total = number_format($total, 0, ',', '.');
    $_frete = number_format($freightTotal, 0, ',', '.');
    $_productsHtml = "";
    foreach ($productsOrder as $key => $_product) {
        $_productsHtml .= generateProductHtml($_product);
    }

    $mailBody = prepareOrder($_name, $_date, $_address, $_productsHtml, $_total, $_frete);
    $_body = $emailHeader . $mailBody . $emailFooter;

    $baseUrl = $config['baseUrl'];

    send_mail($_email, $_name, $config['emailCamp'], $config['nomeCamp'], "Pedido Efetuado - #$orderId - $baseUrl", $_body, $baseUrl);

    $redirect = "http://" . $config['baseUrl'] . "/meuspedidos?pedido=" . $orderId . "&success=Pedido realizado com sucesso";
    header("location:$redirect");
}
