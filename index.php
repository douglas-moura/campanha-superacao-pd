<?php
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    session_start();
    include_once __DIR__ . "/config.php";
    include_once __DIR__ . "/partials/head.php";
?>
    <main class="site-wrapper wrapper-login">
        <?php include_once __DIR__ . "/partials/home-singup.php"; ?>
    </main>
<?php
    include_once __DIR__ . "/partials/foot.php";
?>