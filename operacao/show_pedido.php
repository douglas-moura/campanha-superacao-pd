<?php
    include_once __DIR__ . "/../partials/header-operacao.php";

        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $orderId = $_GET['id'];
        } else {
            exit('Erro. Usuário inválido');
        }

        $query_order = "SELECT
                            o.id,
                            u.cpf,
                            u.name,
                            u.email,
                            o.postal_code,
                            o.street,
                            o.city,
                            o.region,
                            o.complement,
                            o.district,
                            o.number,
                            o.reference,
                            o.data,
                            o.subtotal,
                            o.frete,
                            o.total,
                            o.status,
                            o.count,
                            i.id,
                            i.cod,
                            i.title,
                            i.value,
                            i.points,
                            i.voltage,
                            i.freight,
                            i.status as item_status
                                FROM `order` AS o
                                LEFT JOIN `order_item` AS i ON o.id = i.order_id
                                LEFT JOIN `users` AS u ON u.cpf = o.user_cod
                                AND o.id = $orderId;";

        $rows = $db -> select($query_order);

        // var_dump($rows);
        // exit;

        if ( count($rows[0]) > 0 && isset($rows[0]['id']) ) {
            $order = $rows[0];
  ?>
                <section class="wrapper" >
                    <div class="container" >
                    <div class="row">
                        <div class="wrap-ranking">

                        <div class="account-box" >
                        <div class="order-resume account-box" >
                            <ul class="box" >
                            <li class="orders-resume-item orders-resume-item-number">
                                <p class="orders-resume-orderId" >Pedido: <?php echo $order['id'];?></p>
                                <p class="order-resume-status">Status: <?php echo $order['status'];?></p>
                            </li>
                            <li class="orders-resume-item">
                                <p class="order-resume-title"><?php echo $order['name'];?></p>
                                <p class="order-resume-status"><?php echo $order['email'];?></p>
                                <p class="order-resume-status">CPF: <?php echo $order['cpf'];?></p>
                            </li>
                            <li class="orders-resume-item orders-resume-item-address" >
                                <p class="order-resume-title">Endereço de entrega</p>
                                <address class="order-resume-text-info">
                                    <?php echo($order['street']) ?>
                                    <?php echo($order['number']) ?>
                                    <br />
                                    <?php echo($order['postal_code']) ?> -
                                    <?php echo($order['complement']) ?> -
                                    <?php echo($order['district']) ?>
                                    <br />
                                    <?php echo($order['region']) ?> -
                                    <?php echo($order['city']) ?>
                                    <br />
                                    <?php echo($order['reference']) ?>
                                </address>
                            </li>
                            </ul>
                        </div>

                        <?php foreach ($rows[0] as $key => $product): ?>
                        <div class="order-resume account-box" >
                            <ul class="box" >
                        <div class="order-product" >
                            <div class="order-info order-thumbnail" >
                            <img src="../img/p/<?php echo $products['cod'] ?>.jpg" width="50" alt="" />
                            </div>

                            <div class="order-info-text" >
                            <div class="order-info order-name">
                                <p class="order-product-info order-product-info-brand"  ><?php echo  $product['title'] ?></p>
                            </div>

                            <div class="order-info order-price">
                                <p class="order-cell" ><?php echo number_format($product['points'], 0, ',', '.') ?> pontos</p>
                            </div>

                            </div>
                        </div>
                        </ul>
                        </div>
                        <?php endforeach; ?>

                        </div>
                    </div>
                    </div>
                    </div>
  <?php } ?>



<?php
  $footerIncludes = '
      <script src="//' . $config['assets'] . 'js/jquery.validate.min.js"></script>
      <script src="//' . $config['assets'] . 'js/jquery.maskx.js"></script>
      <script src="//' . $config['assets'] . 'js/register.js"></script>
    ';

  include_once __DIR__ . "/../partials/footer.php";
  include_once __DIR__ . "/../partials/foot.php";
?>
