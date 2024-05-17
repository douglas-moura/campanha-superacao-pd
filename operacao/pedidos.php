<?php
  include_once __DIR__ . "/../partials/header-operacao.php";

  $query = 'SELECT
  o.id as orderid,
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
  i.cod,
  i.title,
  i.value,
  i.points,
  i.voltage,
  i.freight,
  i.status as item_status
   FROM `order` as o
  LEFT JOIN `order_item` as i ON o.id = i.order_id
  LEFT JOIN `users` as u ON u.cpf = o.user_cod;';

  $rows = $db -> select($query);
  if (!$rows || count($rows[0]) < 1) {
    echo 'Não foi possível listas os pedidos';
    exit();
  }

  $fields = array_keys($rows[0]);

  $order = [];
  $items = [];

  foreach ($rows[0] as $key => $value) {
    if(!array_key_exists($value['orderid'], $order)){
      $order[$value['orderid']] = $value;
    }
    $items[$value['orderid']][] = $value;
  }

?>

<section class="wrapper" style="width:100%;overflow-x:auto;">

<?php foreach ($order as $key => $or): ?>

  <table class='table table-bordered'>
    <thead>
      <tr>
        <th > Numero</th>

        <th> cpf </th>
        <th> nome </th>
        <th> email </th>

        <th> CEP </th>
        <th> cidade </th>
        <th> UF </th>

        <th> data </th>
        <th> subtotal </th>
        <th> total </th>
        <th> status </th>
        <th> n itens </th>
      </tr>
    </thead>
    <tbody>

      <tr>
      <?php

        echo "<td>" . $or['orderid'] . "</td>";

        echo "<td>" . $or['cpf'] . "</td>";
        echo "<td>" . $or['name'] . "</td>";
        echo "<td>" . $or['email'] . "</td>";

        echo "<td>" . $or['postal_code'] . "</td>";
        echo "<td>" . $or['city'] . "</td>";
        echo "<td>" . $or['region'] . "</td>";

        echo "<td>" . $or['data'] . "</td>";
        echo "<td class='text-right'>" . number_format($or['subtotal'], 0, ',', '.') . "</td>";
        echo "<td class='text-right'>" . number_format($or['total'], 0, ',', '.') . "</td>";
        echo "<td>" . $or['status'] . "</td>";
        echo "<td>" . $or['count'] . "</td>";
      ?>
    </tr>

    <tr >

      <td colspan='1'>
        <a
          href='./show_pedido.php?id=<?php echo $or['orderid'] ?>'
          class="btn btn-primary btn-block"
        >Exibir</a>
        <?php if($or['status'] !== 'Enviado'): ?>
          <a
          href='./change_pedido.php?status=Enviado&id=<?php echo $or['orderid'] ?>'
          class="btn btn-success btn-block">Enviado</a>
        <?php endif; ?>
        <?php if($or['status'] !== 'Cancelado'): ?>
          <a
          href='./change_pedido.php?status=Cancelado&id=<?php echo $or['orderid'] ?>'
          class="btn btn-danger btn-block">Cancelado</a>
        <?php endif; ?>
      </td>
      <td colspan='12'>

        <table class="table table-bordered">
          <thead>
            <tr>
              <th  > </th>
              <th  > cod </th>

              <th > produto </th>
              <th class="text-right"> pontos </th>

              <th class="text-right"> valor </th>
              <th class="text-right"> frete estimado </th>

              <th> Voltagem </th>
              <th> Status </th>

            </tr>
          </thead>
          <tbody>

          <?php foreach ($items[$key] as $k => $i): ?>
            <tr>
              <td>
                <picture class="product-cart-img">
                  <img src="../img/p/<?php echo $i['cod'] ?>.jpg" width="100" alt="" />
                </picture>
              </td>
              <td><?php echo $i['cod']; ?></td>

              <td ><?php echo $i['title']; ?></td>
              <td class="text-right"><?php echo number_format($i['points'], 0, ',', '.'); ?></td>

              <td class="text-right">R$ <?php echo number_format($i['value'], 2, ',', '.'); ?></td>
              <td class="text-right">R$ <?php echo number_format($i['freight'], 2, ',', '.'); ?></td>

              <td><?php echo $i['voltage']; ?></td>
              <td><?php echo $i['status']; ?></td>
            </tr>
          <?php endforeach;//2 ?>

          </tbody>
        </table>
      </td>
    </tr>

    </tbody>
  </table>
<?php endforeach; //1 ?>

  </section>

<?php

 $footerIncludes = '
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.14/js/jquery.tablesorter.min.js"></script>
    <script >
    $(function(){
      $("#sortable").tablesorter();
    });
    </script>
  ';

  include_once __DIR__ . "/../partials/footer.php";
  include_once __DIR__ . "/../partials/foot.php";
?>
