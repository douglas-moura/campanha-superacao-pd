
<div class="product_detail">

    <?php
        $queryDetail = "SELECT * FROM catalog where active = 1 and visible = 1 and cod = $productCod";
        $product = $db->select($queryDetail);
        if($product[0] && $product[0]['id']) {
    ?>
            <div class="box product-detail">
                <picture>
                    <img src="../img/p/<?php echo $products[$i]['cod'] ?>.jpg" width="500" alt="" />
                    teste
                </picture>
                <div class="product-detail-description" >
                    <h4><?php echo $product[0]['title'] ?></h4>
                    <p class="text"><?php echo $product[0]['description'] ?></p>
                    <p class="points"><?php echo number_format($product[0]['points'], 0, ',', '.') ?> pontos</p>
                    <!--<button class="btn btn-primary btn-buy">
                        <span>Pedir este prêmio</span>
                        <em><i class="ico-check">✓</i>Pedido efetuado</em></em>
                    </button>-->
                </div>
            </div>
    <?php
        }
    ?>

</div>
