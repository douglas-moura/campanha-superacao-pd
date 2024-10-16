<section class="carrinho wrapper">
    <div class="descr">
        <h2>Carrinho</h2>
        <p>Confira os prêmios que você escolheu e fique dentro do seu saldo de pontos.</p>
        <h4>Endereço de Envio:</h4>
        <?php
            if(count($address) > 0){
                if(
                    isset($address['street']) &&
                    isset($address['postal_code']) &&
                    isset($address['district']) &&
                    isset($address['city']) &&
                    isset($address['region']) &&
                    $address['city'] != "" &&
                    $address['region'] != ""
                ) {
                    echo '<ul>
                        <li>' . ($address['street']) . ", " . ($address['number']) . '</li>
                        <li>' . ($address['complement']) . '</li>
                        <li>CEP ' . ($address['postal_code']) . '</li>
                        <li>Bairro ' . ($address['district']) . '</li>
                        <li>' . ($address['city']) . " - " . ($address['region']) . '</li>
                        <li></li>
                        <li>' . ($address['reference']) . '</li>
                    </ul>';
                } else {
                    echo '<p class="alert alert-danger">Endereço incompleto</p>';
                }
            } else {
                echo '<p class="alert alert-danger">Endereço não cadastrado</p>';
            }
        ?>
        <a href="<?php echo "//" . $config['baseUrl'] ?>/cadastro/#register_address"> Editar </a>
    </div>
    <div class="produtos_cart">
        <?php include_once __DIR__ . "/../partials/cart.php"; ?>
    </div>
</section>