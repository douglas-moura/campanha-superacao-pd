<?php
include_once __DIR__ . "/../config.php";
include_once __DIR__ . "/../partials/check.php";

include_once __DIR__ . "/../partials/db.php";
$db = new Db($config);
include_once __DIR__ . "/../partials/order.php";
include_once __DIR__ . "/../partials/freight.php";
include_once __DIR__ . "/../partials/head.php";

include_once __DIR__ . "/../partials/header-internal.php";
$address = getAddress($db);

if (isset($_GET['errors']) && strlen($_GET['errors']) > 3) {
    echo '<div class="alert alert-danger col-md-12"> ' . htmlentities($_GET['errors']) . '</div>';
}

include_once __DIR__ . "/../partials/carrinho.php";

include_once __DIR__ . "/../partials/footer.php";
include_once __DIR__ . "/../partials/foot.php";
