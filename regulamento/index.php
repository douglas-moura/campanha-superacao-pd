<?php
include_once __DIR__ . "/../config.php";
include_once __DIR__ . "/../partials/check.php";
include_once __DIR__ . "/../partials/db.php";
include_once __DIR__ . "/../partials/head.php";

$db = new Db($config);
if ($_SESSION['user']['public']) {
    $rules = $db->select("SELECT r.* FROM `rules` as r WHERE r.public = '" . $_SESSION['user']['public'] . "'");
}

$page = [
    'name' => 'rules',
    'title' => 'Regulamento'
];

include_once __DIR__ . "/../partials/header-internal.php";
?>

<section class="wrapper">
        <?php if ($_SESSION['user']['public'] && isset($rules[0]['text']) && !empty($rules[0]['text'])) { ?>
            <div class="container wrap-rules">
                <?php echo $rules[0]['text']; ?>
            </div>
        <?php
            } else {
                echo "<p class='nao-divulgado'>Regulamento não definido.</p>";
            }
        ?>
</section>

<?php
include_once __DIR__ . "/../partials/footer.php";
include_once __DIR__ . "/../partials/foot.php";
?>