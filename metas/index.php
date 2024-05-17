<?php
  include_once __DIR__ . "/../config.php";
  include_once __DIR__ . "/../partials/check.php";

  include_once __DIR__ . "/../partials/db.php";

  include_once __DIR__ . "/../partials/head.php";
  $page = [
    'name' => 'performance',
    'title' => 'Metas e desempenho'
  ];

  include_once __DIR__ . "/../partials/header-internal.php";

    include_once __DIR__ . "/../partials/goals.php";

  include_once __DIR__ . "/../partials/footer.php";
  include_once __DIR__ . "/../partials/foot.php";
?>
