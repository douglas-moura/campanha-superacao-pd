<?php

function getAddress($_db)
{
    $userId = $_SESSION['user']['id'];
    $queryAddress = "SELECT * FROM `users_address` WHERE user_id = $userId ORDER BY id DESC LIMIT 0, 1";
    $rows = $_db->select($queryAddress);

    $address = [];

    if (count($rows) > 0) {
        $address = $rows[0];
    }

    return $address;
}

function getFreightRules($address, $_db)
{
    if (isset($address['city']) && !empty($address['city']) && isset($address['region']) && !empty($address['region'])) {
        $regionCity = $address['region'] . " - " . $address['city'];
        $region = $address['region'];
    } else {
        $regionCity = "none - city";
        $region = "none";
    }

    $queryFreight = "SELECT * FROM frete WHERE `estado-cidade` = '$regionCity' OR `estado-cidade` = '$region' ORDER BY LENGTH(`estado-cidade`) DESC LIMIT 0, 1;";

    $rows = $_db->select($queryFreight);

    if (count($rows) > 0) {
        return $rows[0];
    }

    return [];
}

function calculateProductWeight($product)
{
    $cubic = ((int) $product['height'] * (int) $product['length'] * (int) $product['width']) / 6000;
    $weight = (int) $product['weight'];

    if ($cubic > 5000 && $cubic > $weight) {
        $weight = $cubic;
    }

    return $weight;
}

function calculateProductWeight22($product)
{
    $taxa = 0;

    $cubic2 = (int) $product['height'] + (int) $product['length'] + (int) $product['width'];

    if ($cubic2 >= 150000) {
        $taxa = 138600;
    }

    return $taxa;
}

function calculateProductFreight($rules, $product)
{
    $weight44 = calculateProductWeight($product);
    $taxa = calculateProductWeight22($product);

    $weight = $weight44 + $taxa;

    return getFreightValue($rules, $weight);
}



function getFreightValue($rules, $weight)
{
    switch ($weight) {
        case $weight > 0 && $weight <= 1000:
            $freightValue = (float) $rules['1000'];
            break;

        case $weight >= 1000 && $weight <= 2000:
            $freightValue = (float) $rules['2000'];
            break;

        case $weight >= 2000 && $weight <= 3000:
            $freightValue = (float) $rules['3000'];
            break;

        case $weight >= 3000 && $weight <= 4000:
            $freightValue = (float) $rules['4000'];
            break;

        case $weight >= 4000 && $weight <= 5000:
            $freightValue = (float) $rules['5000'];
            break;

        case $weight >= 5000 && $weight <= 6000:
            $freightValue = (float) $rules['6000'];
            break;

        case $weight >= 6000 && $weight <= 7000:
            $freightValue = (float) $rules['7000'];
            break;

        case $weight >= 7000 && $weight <= 8000:
            $freightValue = (float) $rules['8000'];
            break;

        case $weight >= 8000 && $weight <= 9000:
            $freightValue = (float) $rules['9000'];
            break;

        case $weight >= 9000 && $weight <= 10000:
            $freightValue = (float) $rules['10000'];
            break;

        case $weight > 10000:
            /* valor para 10kg */
            $freteDezKilos = (float) $rules['10000'];

            /* valor para kg extra */
            $valorKiloAdicional = (float) $rules['0'];

            /* o "peso" meno 10kg divido por 10000 */
            $kilosAdicionais = ($weight - 10000) / 10000;
            
            $freightValue = $freteDezKilos + ($valorKiloAdicional * $kilosAdicionais);
            break;

        default:
            $freightValue = 20;
            break;
    }

    return $freightValue;
}

function calculateFreight($rules, $products)
{
    $totalFreight = 0;
    foreach ($products as $product) {
        $totalFreight += calculateProductFreight($rules, $product);
    }

    return $totalFreight;
}
