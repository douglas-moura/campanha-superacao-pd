<?php
    include_once __DIR__ . "/../config.php";
    include_once __DIR__ . "/../partials/check.php";

    include_once __DIR__ . "/../partials/db.php";
    $db = new Db($config);
    include_once __DIR__ . "/../partials/head.php";

    $page = [
        'name' => 'profile',
        'title' => 'Seus Dados'
    ];

    include_once __DIR__ . "/../partials/header-internal.php";
?>

<section class="wrapper wrapper-dados">
    <?php include_once __DIR__ . "/../partials/register.php"; ?>
</section>

<?php
    include_once __DIR__ . "/../partials/footer.php";
    include_once __DIR__ . "/../partials/foot.php";
?>