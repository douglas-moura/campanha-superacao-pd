<?php
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    session_start();
    include_once __DIR__ . "/../config.php";
    include_once __DIR__ . "/../partials/head.php";
    include_once __DIR__ . "/../partials/header-home.php";
?>
<div class="site-wrapper form-cadastro">
    <?php include_once __DIR__ . "/../partials/cadastrar_participante.php"; ?>
</div>
<?php
    include_once __DIR__ . "/../partials/footer.php";
    include_once __DIR__ . "/../partials/foot.php";
?>