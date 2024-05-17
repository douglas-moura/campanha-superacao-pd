<?php
    session_start();
    session_destroy();
    header('Content-Type: text/html; charset=utf-8');
    include_once __DIR__ . "/../config.php";

    include_once __DIR__ . "/../partials/head.php";
    include_once __DIR__ . "/../partials/header-home.php";
?>
<div class="site-wrapper">
    <section class="box-login">
        <h4>Parabéns! Agora seu cadastro está atualizado e foi enviado para análise.</h4>
        <br>
        <p>Em alguns dias, suas metas serão divulgadas no site da campanha e você receberá em seu endereço cadastrado o Material da Campanha.</p><br><br>
        <p>Em caso de dúvidas: <?php echo $config['emailCamp'] ?></p><br>
        <a class="btn_prim btn_padrao" href="<?php echo '//' . $config['baseUrl'] ?>">Entrar</a>
    </section>
</div>

<?php
    include_once __DIR__ . "/../partials/footer.php";
    include_once __DIR__ . "/../partials/foot.php";
?>