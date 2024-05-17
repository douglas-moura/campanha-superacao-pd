<?php
    include_once __DIR__ . "/../config.php";
    include_once __DIR__ . "/../partials/check.php";

    include_once __DIR__ . "/../partials/db.php";
    $db = new Db($config);
    include_once __DIR__ . "/../partials/order.php";

    include_once __DIR__ . "/../partials/head.php";
    $page = [
    'name' => 'catalog',
    'title' => 'Prêmios'
    ];

    include_once __DIR__ . "/../partials/header-internal.php";
?>

<section class="wrapper">
    <?php
        if (isset($_GET['produto']) && is_numeric($_GET['produto'])) {
            $productCod = intval($_GET['produto']);
            include_once __DIR__ . "/../partials/product_detail.php";
        }
    ?>

    <?php include_once __DIR__ . "/../partials/products.php"; ?>
</section>

<?php
    include_once __DIR__ . "/../partials/footer.php";
    include_once __DIR__ . "/../partials/foot.php";
?>
