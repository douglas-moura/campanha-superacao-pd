<?php
include_once __DIR__ . "/../partials/header-operacao.php";
echo '<div class="container wrap-rules box">';
  $publicos =
    ['agendadores',
    'back-office',
    'executivo-de-vendas',
    'gerente',
    'implantacao',
    'marketing'];

  if(isset($_GET['publico']) && $_GET['publico'] && in_array($_GET['publico'], $publicos)) {
    $public = $_GET['publico'];
   include_once __DIR__ .'/../regulamento/'. $public .".php";

} else {
  echo 'Não foi possível encontrar o regulamento';
}
echo '</div>';
  include_once __DIR__ . "/../partials/footer.php";
  include_once __DIR__ . "/../partials/foot.php";
?>
