<?php
//header('Location: /superacao-pd/cadastrar/');
//exit;

include_once __DIR__ . "/../partials/db.php";

function checkPublic($type) {
    $public = [
        'type' => '',
        'travel' => true,
    ];

    switch ($_SESSION['user']['type']) {
        case 'representante':
            $public['type'] = 'rep';
            $public['travel'] = false;
            break;

        case 'supervisor':
            $public['type'] = 'sup';
            break;

        case 'gerente':
            $public['type'] = 'ger';
            break;

        default:
            $public['type'] = '';
            $public['travel'] = false;
            break;
    }

    return $public;
}

function loginEvent($db, $user) {
    $info = $_SERVER['HTTP_USER_AGENT'];
    $query = "INSERT INTO events (type, user_cod, info) VALUES ('LOGIN','$user','$info')";
    $db->query($query);
}

function login($post, $db, $errors) {
    if (!isset($post['email']) || !isset($post['cpf'])) {
        $errors[] = 'Login Inválido';
        return $errors;
    }

    $email = $post['email'];
    $cpf = preg_replace("/\D+/", "", $post['cpf']);

    if (!preg_match("/^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2,3}$/", $email)) {
        $errors[] = 'E-mail Inválido';
        return $errors;
    }

    if (strlen($cpf) < 11) {
        $errors[] = 'CPF Inválido';
        return $errors;
    }

    $rows = $db->select("SELECT
                                u.id,
                                u.codigo,
                                u.email,
                                u.cpf,
                                u.name,
                                u.alias,
                                u.gender,
                                u.name_extension,
                                u.phone,
                                u.birthday,
                                u.type,
                                u.password,
                                u.boss,
                                u.cadastro,
                                    (SELECT
                                        p.points_e1_1 +
                                        p.points_e1_2 +
                                        p.points_e1_3 +
                                        p.points_e1_4 +
                                        p.points_e1_5 +
                                        p.points_e1_6 +
                                        p.points_e1_7 +
                                        p.points_e1_8 +
                                        p.points_e1_9 +
                                        p.points_e1_10 +
                                        p.points_e1_11 +
                                        p.points_e1_12 +
                                        p.points_e1_13 /*+
                                        p.points_e2_1 +
                                        p.points_e2_2 +
                                        p.points_e2_3 +
                                        p.points_e2_4 +
                                        p.points_e2_5 +
                                        p.points_e2_6 +
                                        p.points_e2_7 +
                                        p.points_e2_8 +
                                        p.points_e2_9 +
                                        p.points_e2_10 +
                                        p.points_e2_11 +
                                        p.points_e2_12 +
                                        p.points_e3_1 +
                                        p.points_e3_2 +
                                        p.points_e3_3 +
                                        p.points_e3_4 +
                                        p.points_e3_5 +
                                        p.points_e3_6 +
                                        p.points_e3_7 +
                                        p.points_e3_8 +
                                        p.points_e3_9 +
                                        p.points_e3_10 +
                                        p.points_e3_11 +
                                        p.points_e3_12 */
                                            FROM `goals` as p WHERE p.cod = u.cpf) AS total,
                                            (SELECT sum(o.total) FROM `order` AS o WHERE o.status <> 'cancelado' AND o.user_cod = u.cpf) AS exchanged
                                            FROM `users` AS u WHERE u.email='$email' AND u.cpf='$cpf'");

    if (count($rows) > 0) {
        $_SESSION['user'] = $rows[0];
        $_SESSION['user']['password'] = $rows[0]['password'] ? $rows[0]['password'] : null;
        $_public = checkPublic($_SESSION['user']['type']);
        $_SESSION['user']['public'] = $_public['type'];
        $_SESSION['user']['travel'] = $_public['travel'];
        $_SESSION['user']['balance'] = (int)$rows[0]['total'] - (int)$rows[0]['exchanged'];

        loginEvent($db, $_SESSION['user']['cpf'] . ' - ' . $_SESSION['user']['email']);
    } else {
        $errors[] = "Participante não encontrado";
        session_destroy();
        return $errors;
    }
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Db($config);
    $errors = login($_POST, $db, $errors);
}

if (isset($_SESSION['user'])) {
    $nextPath = $_SESSION['user']['password'] ? '/home' : '/cadastro';
    $internal = '//' . $config['baseUrl'] . $nextPath;
    echo "<script>window.location.href='$internal'</script>";
}
?>

<section class="box-login">
    <header class="header-home">
        <a href="<?php echo '//' . $config['baseUrl']; ?>" class="logo-campanha">
            <img src="<?php echo '//' . $config['baseUrl'] . 'img/c/logo-campanha.png'; ?>" >
        </a>
    </header>
    <form class="form-login" id='signin' name='signin' method="post" novalidate>
        <!--<h3 class=""><strong><?php echo $config['nomeCamp'] ?></strong></h3>-->
        <?php

        if (count($errors) > 0) {
            echo '<div class="alert alert-danger">';
            foreach ($errors as $error) {
                echo '<p class="error">' . $error . '</p>';
            }
            echo '</div>';
        }
        ?>
        <div class="inputs">
            <div class="linha-form">
                <div class="form-grupo">
                    <label class="" for="email">E-mail</label>
                    <input name="email" id="email" class="" title="Preencha o e-mail" required minlength="9" maxlength="100" placeholder="nome@email.com.br" value="<?php if (isset($email)) echo $email; ?>" type="email" />
                </div>
            </div>
            <div class="linha-form">
                <div class="form-grupo">
                    <label class="" for="cpf">CPF</label>
                    <input name="cpf" id="cpf" class="" title="Preencha o cpf" required minlength="9" maxlength="15" placeholder="000.000.000-00" value="<?php if (isset($cpf)) echo $cpf; ?>" type="tel">
                </div>
            </div>
        </div>
        <button class="btn_prim btn_padrao" type="submit">Entrar</button>
        <p class="btn-cadastre">Lembre-se de cadastrar suas informações de acesso. <a href="<?php echo '//' . $config['baseUrl'] . 'cadastrar/'; ?>">Cadastre-se aqui</a></p>
    </form>
</section>