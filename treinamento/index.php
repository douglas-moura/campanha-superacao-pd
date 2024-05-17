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
    <!--
    <div class="box-treinamento">
        <a href="unifabra/../../treinamento/Treinamento_KALLIS.pdf" target="_blank">
            <h4 class="page-title">Treinamento KALLIS</h4>
            <img src="unifabra/../../img/treinamento/Treinamento_KALLIS_page-0001.jpg">
        </a>
    </div>
    <div class="box-treinamento">
        <a href="unifabra/../../treinamento/Treinamento_Familia_POLITABS.pdf" target="_blank">
            <h4 class="page-title">Treinamento Familia POLITABS</h4>
            <img src="unifabra/../../img/treinamento/Treinamento Familia POLITABS_page-0001.jpg">
        </a>
    </div>
    <div class="box-treinamento">
        <a href="unifabra/../../treinamento/Treinamneto_Material_de_apoio_DERMUNN.pdf" target="_blank">
            <h4 class="page-title">Treinamneto Material de apoio DERMUNN</h4>
            <img src="unifabra/../../img/treinamento/Treinamneto Material de apoio DERMUNN_page-0001.jpg">
        </a>
    </div>
    -->
    <h3>Sem treinamentos por enquanto...</h3>
</section>

<?php
    include_once __DIR__ . "/../partials/footer.php";
    include_once __DIR__ . "/../partials/foot.php";
?>
