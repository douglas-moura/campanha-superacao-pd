<?php
    include_once __DIR__ . "/../config.php";
    session_start();
    session_destroy();
    $redirect = '//' . $config['baseUrl'];
    header("location:$redirect");
?>
