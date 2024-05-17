<?php
$order = getOrder();

if ($order) {
    $query = getQuery($order);
    $_products = $db->select($query);
    $productsOrder = populateOrder($order, $_products);
    $_total = getTotal($productsOrder);
    $freightRules = getFreightRules($address, $db);
    $freightValue = calculateFreight($freightRules, $productsOrder);
    $freightTotal = ($freightValue * 100);

    function hasPoints($totalPoints)
    {
        return isset($_SESSION['user']['balance'])
            && isset($totalPoints)
            && ((int) $_SESSION['user']['balance'] > (int) $totalPoints);
    }

    $_hasPoints = hasPoints($_total + $freightTotal);

    if (hasOrder() && $productsOrder) {

        if (!$_hasPoints) {
            echo '<div class="alert alert-danger">';
            echo 'Saldo de pontos insuficiente, altere seu pedido.';
            echo '</div>';
        }

        echo '<h3>Itens do pedido</h3>';

        foreach ($productsOrder as $item) :
            echo '     
                    <div class="product-cart">
                        <picture class="product-cart-img">
                            <img src="../img/p/' . $item['cod'] . '.jpg" width="100" alt="" />
                        </picture>
                        <div class="product-cart-description" >
                            <h4>' . $item['title'] . ' ' . $item['voltage'] . '</h4>
                            <p class="text">' . $item['description'] . '</p>
                            <p class="text">
                                <button class="btn btn-default js-remove-cart" data-cod="' . $item['cod'] . '" >Remover</button>
                            </p>
                        </div>
                        <div class="product-cart-points" >
                            <p class="points">' . number_format($item['points'], 0, ',', '.') . ' pontos</p>
                        </div>
                    </div>
                ';
        endforeach;

        echo '
                <div class="detalhes_pedido">
                    <div class="product-cart-subtotal">
                        <p class="product-cart-total-points">
                            <span>Subtotal </span>
                            <b>' . number_format($_total, 0, ',', '.') . ' pontos </b>
                        </p>
                        <p class="product-cart-total-points aling-right">
                            <span>Frete </span>
                            <b>' . number_format($freightTotal, 0, ',', '.') . ' pontos </b>
                        </p> 
                    </div>
                    <div class="product-cart-total">
                        <p class="product-cart-total-points">
                            <span>Total </span>
                            <b>' . number_format(($freightTotal + $_total), 0, ',', '.') . ' pontos </b>
                        </p>
                    </div>
            ';

        if ($_hasPoints) {
            echo '
                    <form class="form-order" id="register_order" name="register_order" method="post" action="';
            if (isset($config['baseUrl'])) echo '//' . $config['baseUrl'] . '/api/order_post.php">
                        <input type="hidden" value="order">
                        <input class="btn_sec btn_padrao" type="submit" value="Finalizar pedido">
                    </form>
                </div>
                ';
        }
    }
} else {
    echo '<h3>Sem itens no pedido</h3>';
}
?>

<?php $footerIncludes = '
    <script src="//' . $config['assets'] . 'js/jquery.cookie.js?version=' . $config['version'] . '"></script>
    <script src="//' . $config['assets'] . 'js/catalog.js?version=' . $config['version'] . '"></script>
    ';
?>
