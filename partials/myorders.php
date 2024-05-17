<?php

function getSaveOrder($orderId = '', $db) {
  $userCod = $_SESSION['user']['cpf'];

  $order = [];

  $queryOrder = "SELECT * FROM `order` WHERE id = $orderId and user_cod = $userCod order by id LIMIT 0, 1 ";
  $_order = $db->select($queryOrder);
  if(count($_order) && isset($_order[0])) {
    $order['order'] = $_order[0];
  }

  $queryOrderItem = "SELECT * FROM `order_item` WHERE order_id = $orderId and user_cod = $userCod order by id";
  $order['items'] = $db->select($queryOrderItem);

  return $order;
}

function getListSaveOrders($db) {
  $userCod = $_SESSION['user']['cpf'];

  $queryOrder = "SELECT * FROM `order` WHERE user_cod = $userCod order by id";
  $order = $db->select($queryOrder);

  return $order;
}
