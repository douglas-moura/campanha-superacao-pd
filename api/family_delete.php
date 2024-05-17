<?php

  include_once __DIR__ . "/index.php";

  $errors = '';
  $success = '';

  if (isset($_GET['family'])) {

    $familyId = $_GET['family'];
    $query = "DELETE from users_family where user_id = $userId and id = $familyId";

    $result = $db->query($query);
    if(!$result) {
      $errors = 'Não foi possível remover';
    } else {
      $success = 'Familiar removido com sucesso';
    }
    
  }

  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode([$errors, $success]);
  } else {
    $redirect = "http://" . $config['baseUrl'] . "/cadastro?errors=" . $errors . '&success=' . $success;
    header("location:$redirect");
  }
