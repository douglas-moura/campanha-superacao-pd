<?php
  session_start();

  header('Content-Type: text/html; charset=utf-8');
  include_once __DIR__ . "/../config.php";

  include_once __DIR__ . "/../partials/head.php";
  include_once __DIR__ . "/../partials/header-home.php";

  include_once __DIR__ . "/../partials/cliente-signin.php";

  include_once __DIR__ . "/../partials/footer.php";
  include_once __DIR__ . "/../partials/foot.php";
?>