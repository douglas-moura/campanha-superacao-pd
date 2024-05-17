<?php
  include_once __DIR__ . "/../partials/header-operacao.php";
  $query = 'select *
    FROM `catalog`';

    $rows = $db -> select($query);
    $count = count($rows[0]);
    if ($count > 0) {
      $fields = array_keys($rows[0]);

?>

  <section class="wrapper" style="width:100%;overflow-x:auto;margin:10px;">
    <table class="table" id="sortable">
      <thead>
        <tr>
          <?php foreach ($fields as $field) {
            if ($field == 'cod') {
              echo "<th scope='col'> photo </th>";
            }
            echo "<th scope='col'> $field </th>";
          } ?>
        </tr>
      </thead>
      <tbody>

        <?php
        $versionAssets = $config['versionAssets'];

        for ($i=0; $i < $count; $i++) {
          echo "<tr>";
          foreach ($rows[$i] as $key => $value) {
            if ($key == 'cod') {
              echo "<td><a href='http://res.cloudinary.com/maxxpremios/image/upload/f_auto,q_auto/v$versionAssets/p/$value.jpg' target='_blank'> <img src='http://res.cloudinary.com/maxxpremios/image/upload/c_scale,f_auto,q_auto,w_300/v$versionAssets/p/$value.jpg' width='100' alt='' /></a></td>";
            }
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
  echo 'Não foi possível listas os participantes';
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
