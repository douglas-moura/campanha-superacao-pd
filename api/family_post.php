<?php

  include_once __DIR__ . "/index.php";

  function createFamilyQuery($userId, $name, $age, $gender, $kinship) {
    $query = "INSERT INTO users_family (
        user_id,
        kinship,
        age,
        gender,
        name
      ) VALUES (
      $userId,
      '$kinship',
      '$age',
      '$gender',
      '$name'
    )";
    return $query;
  }

  $errors = '';
  $success = '';

  if (isset($_POST['name']) && strlen($_POST['name']) > 2) {

    $name = $_POST['name'];
    $kinship = isset($_POST['kinship']) ? $_POST['kinship'] : 'outro';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : 'F';
    $age = isset($_POST['age']) ? $_POST['age'] : 1;
    $query = createFamilyQuery($userId, $name, $age, $gender, $kinship);
    $result = $db->query($query);

    if(!$result) {
      $errors = 'Não foi possível salvar, verifique os dados do familiar';
    } else {
      $success = 'Familiar cadastrado com sucesso';
    }
  }

  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['errors' => $errors, 'success' => $success]);
  } else {
    $redirect = "http://" . $config['baseUrl'] . "/cadastro?errors=" . $errors . '&success=' . $success . '&cache=' . time() . '#register_family';
    header("location:$redirect");
  }
