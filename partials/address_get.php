<?php

  $query_address = "SELECT * FROM `users_address` WHERE user_id=$userId order by id desc limit 0, 1";
  $rows = $db -> select($query_address);

  if (count($rows) > 0){
    $address = $rows[0];

    $addressId = $address['id'];
    $postalCode = $address['postal_code'];
    $street = $address['street'];
    $number = $address['number'];
    $complement = $address['complement'];
    $reference = $address['reference'];
    $city = $address['city'];
    $region = $address['region'];
    $district = $address['district'];

  }
