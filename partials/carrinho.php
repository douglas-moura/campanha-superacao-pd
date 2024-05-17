<section class="carrinho wrapper">
    <div class="descr">
        <h2>Carrinho</h2>
        <p>Confira os prêmios que você escolheu e fique dentro do seu saldo de pontos.</p>
        <h4>Endereço de Envio:</h4>
        <ul>
            <li><?php echo ($address['street']) . ", " . ($address['number']) ?></li>
            <li><?php echo ($address['complement']) ?></li>
            <li><?php echo ($address['postal_code']) . " - " . ($address['district']) ?></li>
            <li><?php echo ($address['city']) . "/" . ($address['region']) ?></li>
            <li></li>
            <li><?php echo ($address['reference']) ?></li>
        </ul>
        <a href="<?php echo "//" . $config['baseUrl'] ?>/cadastro/#register_address"> Editar </a>
    </div>
    <div class="produtos_cart">
        <?php include_once __DIR__ . "/../partials/cart.php"; ?>
    </div>
</section>