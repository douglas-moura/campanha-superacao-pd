<?php

    $query_address = "SELECT * FROM `users` WHERE id=$userId order by id desc limit 0, 1";
    $rows = $db->select($query_address);
    if (count($rows) > 0) {
        $profile = $rows[0];

        $nameu = $profile['name'];
        $sobrenome = $profile['name_extension'];
        $birthday = $profile['birthday'];
        $phone = $profile['phone'];
        $alias = $profile['alias'];
        $password = isset($profile['password']) && strlen($profile['password']) > 5;
    }
