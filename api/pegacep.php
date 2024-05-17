<?php
  header("Content-Type:application/json");
  header("HTTP/1.1 200");
  if(isset($_GET['cep']) && strlen($_GET['cep']) > 7) {
    $token = 'f87f1068ecc15972cdcc0175db397abd';
    $url = 'http://www.cepaberto.com/api/v2/ceps.json?cep=' . $_GET['cep'];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Token token="' . $token . '"'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    echo($output);
  }
