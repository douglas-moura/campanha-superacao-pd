<?php
  include_once __DIR__ . "/../config.php";
  session_start();
  if (!isset($_SESSION['user'])) {
     $redirect = "//" . $config['baseUrl'];
     session_write_close();
     header("location: $redirect");
     exit();
  }
  header('Content-Type: text/html; charset=utf-8');
