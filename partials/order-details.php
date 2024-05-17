<h4 class="page-title">Detalhes do pedido</h4>

<div class="account-box">
    <div class="order-resume account-box">
        <ul class="">
            <li class="orders-resume-item orders-resume-item-number">
                <p class="order-resume-title">Número do pedido</p>
                <p class="orders-resume-orderId"><?php echo $saveOrder['order']['id']; ?></p>
            </li>
            <li class="orders-resume-item">
                <p class="order-resume-title">Status</p>
                <p class="order-resume-status"><?php echo $saveOrder['order']['status']; ?></p>
            </li>
            <li class="orders-resume-item orders-resume-item-address">
                <p class="order-resume-title">Endereço de entrega</p>
                <address class="order-resume-text-info">
                    <ul>
                        <li><?php echo ($saveOrder['order']['street']) . ', ' . ($saveOrder['order']['number']) ?></li>
                        <li><?php echo ($saveOrder['order']['complement']) ?></li>
                        <li><?php echo ($saveOrder['order']['postal_code']) . ' - ' . ($saveOrder['order']['district']) ?></li>
                        <li><?php echo ($saveOrder['order']['city']) . '/' . ($saveOrder['order']['region']) ?></li>
                        <li><?php echo ($saveOrder['order']['reference']) ?></li>
                    </ul>
                </address>
            </li>
        </ul>
    </div>

    <h4 class="page-title">Itens do pedido</h4>
    <div class="order-package">
        <div class="order-products">

            <?php foreach ($saveOrder['items'] as $key => $product) : ?>
                <div class="order-product">
                    <div class="order-info order-thumbnail">
                        <img src="../img/p/<?php echo $product['cod'] ?>.jpg" width="50" alt="" />
                    </div>

                    <div class="order-info-text">
                        <div class="order-info order-name">
                            <p class="order-product-info order-product-info-brand"><?php echo  $product['title'] ?></p>
                        </div>

                        <div class="order-info order-price">
                            <p class="order-cell"><?php echo number_format($product['points'], 0, ',', '.') ?> pontos</p>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
    <hr />