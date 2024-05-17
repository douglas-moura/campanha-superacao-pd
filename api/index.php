<?php
  session_start();
  if (!isset($_SESSION['user'])){
     $redirect = "/";
     header("location:$redirect");
  }
  $userId = $_SESSION['user']['id'];
  include_once __DIR__ . "/../config.php";
  include_once __DIR__ . "/../partials/db.php";
  $db = new Db($config);
  $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
  $errors = '';
  $success = '';
