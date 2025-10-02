<?php
include_once __DIR__ . "/../config.php";
include_once __DIR__ . "/../partials/check.php";
include_once __DIR__ . "/../partials/db.php";

$db = new Db($config);
$cpf = $_SESSION['user']['cpf'];
$communications = $db->select("SELECT c.*, m.* FROM `communications` AS c LEFT JOIN communication_model AS m ON c.model = m.model WHERE c.cpf = '$cpf' ORDER BY c.id DESC");

include_once __DIR__ . "/../partials/head.php";
include_once __DIR__ . "/../partials/header-internal.php";
include_once __DIR__ . "/../partials/home.php";
include_once __DIR__ . "/../partials/footer.php";
include_once __DIR__ . "/../partials/foot.php";
