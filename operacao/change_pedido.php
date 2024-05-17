<?php
  include_once __DIR__ . "/../partials/header-operacao.php";

  if (
    isset($_GET['id'])
    && is_numeric($_GET['id'])
    && isset($_GET['status'])
    && ($_GET['status'] === 'Enviado' || $_GET['status'] === 'Cancelado')
    ) {
    $orderId = $_GET['id'];
  } else {
    $redirect = "./pedidos.php?erro=Ação Inválida";
    header("location:$redirect");
  }

  $newStatus = $_GET['status'];
  $orderId = $_GET['id'];

  $query_change_order = "UPDATE `order` set `status` = '$newStatus' WHERE id = $orderId;";

  $result = $db->query($query_change_order);
  $errors = '';
  $success = '';

  if(!$result) {
    $errors = 'Não foi possível atualizar o pedido';
  } else {
    $success = 'Pedido atualizado';
  }

  $redirect = "./pedidos.php?errors=$errors&success=$success";
  header("location:$redirect");
