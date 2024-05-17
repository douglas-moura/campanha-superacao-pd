<?php
  include_once __DIR__ . "/../partials/header-operacao.php";
  $query = 'select
    u.`email`,
    u.`name`,
    u.`type`,
    p.*
    FROM `users` as u
    LEFT JOIN vb_goals as p
    on u.cpf = p.cod';

    $rows = $db -> select($query);
    $count = count($rows[0]);
    if ($count > 0 && isset($rows[0])) {
      $fields = array_keys($rows[0]);

?>

  <section class="wrapper" style="width:100%;overflow-x:auto;">
    <table class="table-bordered table-points" id="sortable">
      <thead>
        <tr>
          <?php foreach ($fields as $field) {
            $colspan = '';
            echo "<th scope='col' $colspan> $field </th>";
          } ?>
        </tr>
      </thead>
      <tbody>

        <?php
        for ($i=0; $i < $count; $i++) {
          echo "<tr>";
          foreach ($rows[$i] as $key => $value) {
            echo "<td>$value</td>";
          }
          echo "</tr>";
        }

        ?>

      </tbody>
    </table>


  </section>

  <?php

} else {
  echo 'Não foi possível listas os pontos dos participantes';
}


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
