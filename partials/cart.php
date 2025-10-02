<?php
    $order = getOrder();

    
    if ($order) {
        // busca os produtos do pedido no banco
        $query = getQuery($order);
        // produtos do pedido em array
        $_products = $db->select($query);

        $productsOrder = populateOrder($order, $_products);
        $_total = getTotal($productsOrder);
        $freightRules = getFreightRules($address, $db);
        $freightValue = calculateFreight($freightRules, $productsOrder);
        $freightTotal = ($freightValue * 100);

        function hasPoints($totalPoints) {
            return isset($_SESSION['user']['balance'])
            && isset($totalPoints)
            && ((int) $_SESSION['user']['balance'] > (int) $totalPoints);
        }

        // verifica se o usuário tem pontos suficientes
        $_hasPoints = hasPoints($_total + $freightTotal);

        if (hasOrder() && $productsOrder) {

            if (!$_hasPoints) {
                echo '<div class="alert alert-danger">';
                echo 'Saldo de pontos insuficiente, altere seu pedido.';
                echo '</div>';
            }

            echo '<h3>Itens do pedido</h3>';

            // lista renderizada de itens no pedido no carrinho
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

            // sessão de valor de frete e valor do total do pedido
            echo '
                <div class="detalhes_pedido">
                    <div class="product-cart-subtotal">
                        <p class="product-cart-total-points">
                            <span>Subtotal </span>
                            <b>' . number_format($_total, 0, ',', '.') . ' pontos </b>
                        </p>
                        <p class="product-cart-total-points aling-right">
                            <span>Frete </span>
                            <b>' . number_format(isset($address['street']) &&
                            isset($address['postal_code']) &&
                            isset($address['district']) &&
                            isset($address['city']) &&
                            isset($address['region'])&&
                            $address['city'] != "" &&
                            $address['region'] != "" ? $freightTotal : 0, 0, ',', '.') . ' pontos </b>
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
                        if(isset($config['baseUrl'])) echo '//' . $config['baseUrl'] . 'api/order_post.php">';
                        if(
                            isset($address['street']) &&
                            isset($address['postal_code']) &&
                            isset($address['district']) &&
                            isset($address['city']) &&
                            isset($address['region']) &&
                            $address['city'] != "" &&
                            $address['region'] != "") {
                                echo '
                                    <div class="rodape_cart" style="display: flex; flex-direction: row; width: 100%; padding: 1rem 0;">
                                        <span style="display: flex; width: 70%; justify-content: start; align-items: center;">
                                            <p style="margin: 0 !important;">Insira sua senha para <br> troca de pontos:</p>
                                            <input type="password" id="campo_senha_order" class="campo_senha_order" value="">
                                        </span>
                                        <span style="display: flex; width: 30%; justify-content: flex-end;">
                                            <input id="btn_fazer_pedido" class="btn_sec btn_padrao desativado" type="submit" value="Finalizar pedido" disabled>
                                        </span>
                                    </div>
                                ';
                            }
                        echo '
                    </form>
                </div>
                    ';
                  
                /*
                echo "<pre>";
                echo print_r($_SESSION['user']);
                echo "</pre>";
                */
            }
        }
    } else {
        echo '<h3>Sem itens no pedido</h3>';
    }
?>

<?php
    $footerIncludes = '
        <script src="//' . $config['assets'] . 'js/jquery.cookie.js?version=' . $config['version'] . '"></script>
        <script src="//' . $config['assets'] . 'js/catalog.js?version=' . $config['version'] . '"></script>
    ';
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        let senha_user = <?php echo json_encode($_SESSION['user']['password']); ?>;

        var input_senha = $("#campo_senha_order");
        var btn_finalizar = $("#btn_fazer_pedido");

        input_senha.on('input', function(event) {
            var input_senha = event.target;
            
            if (input_senha.value == senha_user) {
                btn_finalizar.addClass('ativado');
                btn_finalizar.addClass('btn_prim');
                btn_finalizar.removeClass('desativado');
                btn_finalizar.removeAttr("disabled");
                btn_finalizar.attr('disabled', false);
            } else {
                btn_finalizar.addClass('desativado');
                btn_finalizar.removeClass('ativado');
                btn_finalizar.attr('disabled', true);
            }
        });
    });
    
</script>