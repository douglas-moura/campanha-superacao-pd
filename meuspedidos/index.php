<?php
include_once __DIR__ . "/../config.php";
include_once __DIR__ . "/../partials/check.php";

include_once __DIR__ . "/../partials/db.php";
$db = new Db($config);
include_once __DIR__ . "/../partials/myorders.php";
include_once __DIR__ . "/../partials/head.php";

$page = [
    'name' => 'pedidos',
    'title' => 'Pedidos'
];

include_once __DIR__ . "/../partials/header-internal.php";

?>

<section class="wrapper pedidos_feitos">
    <?php
    if (isset($_GET['success']) && strlen($_GET['success']) > 3) {
        echo '<div class="alert alert-success"> ' . htmlentities($_GET['success']) . '</div>';
    }
    ?>

    <div class="box-pedidos">
        <div class="descr">
            <p>Acompanhe seus pedidos e o status deles! Os itens dos pedidos podem chegar separadamente.</p>
        </div>
        <div class="lista-pedidos">
            <?php
            if (isset($_GET['pedido'])) {
                $pedido = $_GET['pedido'];
                $saveOrder = getSaveOrder($pedido, $db);
                if (isset($saveOrder['items']) && $saveOrder['items']) {
                    include_once __DIR__ . "/../partials/order-details.php";
                }
            }

            $orders = getListSaveOrders($db);

            if (count($orders) > 0) {
            ?>
                <h3 class="page-title">Lista de pedidos</h3>
                <table class="orders table">
                    <thead class="orders-header">
                        <tr>
                            <th id="pedido_nome">Pedido</th>
                            <th id="pedido_status">Status</th>
                            <th id="pedido_data">Data</th>
                            <th id="pedido_qtd" class="orders-column-collapsable">Quantidade</th>
                            <th id="pedido_vl" class="orders-column-collapsable">Valor</th>
                            <th id="pedido_vazio"></th>
                        </tr>
                    </thead>
                    <tbody class="orders-body">
                        <?php
                        foreach ($orders as $index => $order) {
                            if ($order['count']) {
                        ?>
                                <tr>
                                    <td id="pedido_nome"><?php echo $order['id']; ?></td>
                                    <td id="pedido_status"><?php echo $order['status']; ?></td>
                                    <td id="pedido_data"><?php echo date("d/m/Y", strtotime($order['data'])); ?></td>
                                    <td id="pedido_qtd" class="orders-column-collapsable">
                                        <?php echo $order['count']; ?>
                                        <span> <?php echo ((int) $order['count'] > 1) ? ' itens' : ' item'; ?> </span>
                                    </td>
                                    <td id="pedido_vl" class="orders-column-collapsable"> <?php echo number_format($order['total'], 0, ',', '.'); ?></td>
                                    <td id="pedido_vazio"><a class="btn_padrao btn_sec" href="<?php echo "//" . $config['baseUrl'] ?>/meuspedidos/?pedido=<?php echo $order['id']; ?>">Ver Mais</a></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>

                    </tbody>
                </table>
            <?php
            } else {
                echo '<h3 class="nao-divulgado">Não foram encontrados pedidos</h3>';
            }
            ?>
        </div>
    </div>
</section>
</div>

<?php
include_once __DIR__ . "/../partials/footer.php";
include_once __DIR__ . "/../partials/foot.php";
?>