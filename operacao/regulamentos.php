<?php
include_once __DIR__ . "/../partials/header-operacao.php";

$query = 'select * FROM `vb_rules`';

$rows = $db -> select($query);
$count = count($rows[0]);
if ($rows && $count > 0) {
  $fields = array_keys($rows[0]);

?>

<section class="wrapper" style="width:100%;overflow-x:auto;">
<table class="table" id="sortable">
  <thead>
    <tr>
      <?php foreach ($fields as $field) {
        echo "<th scope='col'> $field </th>";
      } ?>
    </tr>
  </thead>
  <tbody>

    <?php
    for ($i=0; $i < $count; $i++) {
      echo "<tr>";
      foreach ($rows[$i] as $key => $value) {
        if ($key == 'id') {
          echo "<th scope='col'>
            <a href='./edit_regulamento.php?id=$value'>editar</a>
           </th>";
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
echo 'Sem regulamentos';
}


  include_once __DIR__ . "/../partials/footer.php";
  include_once __DIR__ . "/../partials/foot.php";
?>
