<?php
include_once __DIR__ . "/index.php";

$nameu = $_POST['nameu'];
$phone = $_POST['phone'];
$birthday = $_POST['birthday'];
$alias = $_POST['alias'];
$password = $_POST['password'];
$cod_user = $_SESSION['user']['cpf'];

if (isset($nameu) && strlen($nameu) > 2 && isset($password) && strlen($password) > 5) {
    $query = "UPDATE users SET name = '$nameu', alias = '$alias', phone = '$phone', birthday = '$birthday', password = '$password' WHERE id = $userId";
    $result = $db->query($query);

    if (!$result) {
        $errors = 'Não foi possível atualizar seu perfil';
    } else {
        $success = 'Perfil atualizado';
    }
} else {
    $errors = 'Verifique os dados do perfil';
}

if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['erros' => $errors, 'success' => $success]);
} else {
    $redirect = "http://" . $config['baseUrl'] . "/cadastro?errors=" . $errors . '&success=' . $success;
    header("location: $redirect");
}
