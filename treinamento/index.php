<?php
    include_once __DIR__ . "/../config.php";
    include_once __DIR__ . "/../partials/check.php";
    
    include_once __DIR__ . "/../partials/db.php";
    $db = new Db($config);
    include_once __DIR__ . "/../partials/order.php";
    
    include_once __DIR__ . "/../partials/head.php";
    $page = [
        'name' => 'training',
        'title' => 'Treinamento'
    ];
    
    include_once __DIR__ . "/../partials/header-internal.php";
?>

<section class="wrapper" id="treinament">
    <h3>Sem treinamentos por enquanto...</h3>
</section>

<?php
    include_once __DIR__ . "/../partials/footer.php";
    include_once __DIR__ . "/../partials/foot.php";
?>
