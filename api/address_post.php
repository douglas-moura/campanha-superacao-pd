<?php

  include_once __DIR__ . "/index.php";

  if (isset($_POST['postalCode'])
  && isset($_POST['number'])
  && isset($_POST['city'])
  && isset($_POST['region'])
  ) {
    $postalCode = $_POST['postalCode'];
    $street = $_POST['street'];
    $number = $_POST['number'];
    $complement = $_POST['complement'];
    $reference = $_POST['reference'];
    $city = $_POST['city'];
    $region = $_POST['region'];
    $district = $_POST['district'];

    if(isset($_POST['addressId']) && $_POST['addressId']) {
      $addressId = $_POST['addressId'];
      $query = "UPDATE users_address SET
        postal_code = '$postalCode',
        street = '$street',
        number = '$number',
        complement =   '$complement',
        reference = '$reference',
        city = '$city',
        region = '$region',
        district = '$district'
      WHERE
        id = $addressId
        and
        user_id = $userId";

    } else {

        $query = "INSERT INTO users_address (
          user_id,
          postal_code,
          street,
          number,
          complement,
          reference,
          city,
          region,
          district
        ) VALUES (
        $userId,
        '$postalCode',
        '$street',
        '$number',
        '$complement',
        '$reference',
        '$city',
        '$region',
        '$district'
      )";
    }

    $result = $db->query($query);

    if(!$result) {
      $errors = 'Não foi possível salvar, verifique os dados do endereço';
    } else {
      $success = 'Endereço atualizado';
    }

  } else {
    $errors = 'Verifique os dados do endereço';
  }

  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['erros' => $errors, 'success' => $success]);
  } else {
    $redirect = "http://" . $config['baseUrl'] . "/cadastro?errors=" . $errors . '&success=' . $success . '&cache=' . time();
    header("location: $redirect");
  }
