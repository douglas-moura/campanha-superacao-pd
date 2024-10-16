<?php
include_once __DIR__ . "/../partials/db.php";

function checkPublic($type) {
    $public = [
        'type' => '',
        'travel' => true,
    ];

    switch ($_SESSION['user']['type']) {
        case 'Consultor de PDV Junior':
        case 'Consultor de PDV Pleno':
        case 'Consultor Trade':
        case 'Consultor de Trade Marketing':
            $public['type'] = 'consultor-trade';
            break;

        case 'Coordenador Técnico Ciêntífico':
        case 'Coordenador Técnico Ciêntifico Digital':
        case 'Coordenador Digital':
            $public['type'] = 'coordenador-digital';
            break;

        case 'Coordenador de Trade e Execução':
        case 'Coordenador Trade':
            $public['type'] = 'coordenador-trade';
            break;

        case 'Teste':
        case 'Gerente de Contas':
            $public['type'] = 'gerente-de-contas';
            break;

        case 'Gerente de Produtos Sênior':
        case 'Gerente de Produtos Pleno':
        case 'Gerente de Produto':
            $public['type'] = 'gerente-de-produto';
            break;

        case 'Gerente Distrital de Demanda Junior':
        case 'Gerente Distrital de Demanda Sênior':
        case 'Gerente Distrital':
            $public['type'] = 'gerente-distrital';
            break;

        case 'Propagandista Junior':
        case 'Propagandista Pleno':
        case 'Propagandista Senior':
        case 'Representante Propagandista':
            $public['type'] = 'representante-propagandista';
            break;

        case 'Representante Digital':
            $public['type'] = 'representante-digital';
            break;

        case 'Televendas':
            $public['type'] = 'televendas';
            $public['travel'] = false;
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
                                u.cadastro,
                                    (SELECT
                                        p.points_e1_1 +/*
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
                                        p.points_e1_12 +*/
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
                                        p.points_e2_12 /*+
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
        $_SESSION['user']['password'] = (isset($rows[0]['password']) && !empty($rows[0]['password']));
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
            <center>
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1417.3 1417.3" style="enable-background:new 0 0 1417.3 1417.3;" xml:space="preserve">
                    <g>
                        <path class="st0" d="M1343.5,532.1C1205.7,140.8,890.6,62.8,773,67.5c-114,4.5-339-3.8-611.8,475.7
                        c-250.8,440.7-108.1,623-83.4,649.6c2.4,2.6,4.4,5.3,6.2,8.4c19,32.1,137.9,209.5,405.1,127.4c141.6-43.5,361.6-188.6,559.4-195.7
                        c135.1-4.8,193.3-9.5,242.5-46.8C1339.7,1049.1,1481.3,923.5,1343.5,532.1z M1018.5,499.4h59.3l50.4,83l49.3-83h58.8l-78.1,125.4
                        l85.8,132.8h-61.1l-55.7-89.3l-55.8,89.3h-60.8l85.8-134.7L1018.5,499.4z M620.9,499.4h53.6l100.5,258.2h-55.1L698,698.9H597.6
                        l-20.7,58.6h-53.8L620.9,499.4z M645.9,796.8h-5.1l-26.5-31.4l-25.5,31.4h-5.1l29.1-35.4h3.9L645.9,796.8z M380.4,882.1
                        c-2.9,6.2-7,11.4-12.1,15.5c-5.1,4.2-11.3,7.3-18.4,9.4c-7.1,2.1-15,3.2-23.5,3.2h-66.6v82.9h-5.1v-182h74.4
                        c17.7,0,31.4,4.2,41.2,12.5c9.8,8.3,14.7,20.7,14.7,37.2C384.8,868.8,383.3,875.9,380.4,882.1z M352.5,757.6l-49.7-203.3v203.3
                        h-47.1V499.4h75.9l45.6,176.1l45-176.1h76v258.2h-47.1V554.3l-49.9,203.3H352.5z M529.1,993.1c-0.9-1.9-1.5-4.4-2.1-7.5
                        c-0.5-3.1-0.9-6.5-1.2-10.1c-0.3-3.6-0.4-7.2-0.5-10.8c-0.1-3.7-0.1-6.9-0.1-9.8c0-7.5-0.6-14.2-1.7-20c-1.1-5.9-3.4-10.8-6.8-14.8
                        c-3.4-4-8.3-7-14.7-9.2c-6.3-2.1-14.8-3.2-25.5-3.2h-69.2v85.4h-5.1v-182h75.1c19.2,0,33.3,3.8,42.2,11.4
                        c8.9,7.6,13.5,19.3,13.9,35.3c0.3,12.2-2.9,22.4-9.8,30.5c-6.9,8.1-16.7,13.5-29.6,16.4v0.5c7.7,1,14,2.8,18.8,5.5
                        c4.8,2.6,8.5,6.1,11.1,10.3c2.6,4.3,4.3,9.3,5.1,15c0.9,5.8,1.3,12.3,1.3,19.6c0,2.6,0.1,5.7,0.3,9.6c0.2,3.8,0.4,7.6,0.8,11.3
                        c0.3,3.8,0.8,7.1,1.3,10.2c0.5,3.1,1.2,5.2,2.1,6.4H529.1z M682.4,993.1h-123v-182h122v5.1H564.6v79.5h109.9v5.1H564.6V988h117.8
                        V993.1z M870.5,993.1h-5.2V817.4h-0.5l-78,175.7h-5.7l-78-175.7h-0.5v175.7h-5.1v-182h8.5l77.7,175.4h0.5L862,811.1h8.5V993.1z
                        M837.3,757.6h-60.8l85.8-134.7l-77.8-123.5h59.3l50.4,83l49.3-83h58.8l-78.1,125.4l85.8,132.8h-61.2l-55.7-89.3L837.3,757.6z
                        M903.5,993.1h-5.1v-182h5.1V993.1z M1089.4,938.8c-3.7,11.6-9.1,21.7-16.2,30.3c-7.1,8.7-15.9,15.5-26.5,20.5
                        c-10.5,5-22.7,7.5-36.4,7.5c-13.7,0-25.9-2.5-36.4-7.5c-10.5-5-19.4-11.8-26.5-20.5c-7.1-8.7-12.5-18.8-16.2-30.3
                        s-5.5-23.8-5.5-36.7c0-12.9,1.8-25.2,5.5-36.7s9.1-21.7,16.2-30.3c7.1-8.7,16-15.6,26.5-20.7s22.7-7.7,36.4-7.7
                        c13.7,0,25.9,2.6,36.4,7.7c10.6,5.1,19.4,12,26.5,20.7c7.1,8.7,12.5,18.8,16.2,30.3c3.7,11.6,5.5,23.8,5.5,36.7
                        C1094.9,915,1093,927.2,1089.4,938.8z M1242.6,970.6c-3.8,6.1-8.8,11.2-14.9,15.2c-6.2,4-13.1,6.9-20.8,8.7
                        c-7.7,1.8-15.5,2.7-23.4,2.7c-10.5,0-20.1-1.2-28.9-3.6c-8.8-2.4-16.5-6.2-22.9-11.3c-6.4-5.2-11.4-11.8-14.9-20
                        c-3.5-8.2-5.2-18-5-29.6h5.1c0,10.9,1.6,20.1,4.9,27.7c3.3,7.6,7.8,13.7,13.8,18.5c5.9,4.8,13,8.2,21.1,10.3
                        c8.2,2.1,17.1,3.2,26.9,3.2c7.2,0,14.4-0.8,21.5-2.4c7.1-1.6,13.5-4.2,19.2-7.8c5.7-3.6,10.3-8.1,13.8-13.8
                        c3.5-5.6,5.3-12.3,5.3-20.1c0-9.2-2-16.4-6.1-21.8c-4-5.4-9.2-9.6-15.4-12.7c-6.3-3.1-13.2-5.5-20.9-7.1c-7.6-1.6-15-3.3-22-5
                        c-7.4-1.7-14.8-3.5-22.1-5.3c-7.4-1.9-14-4.5-19.9-7.8s-10.7-7.7-14.3-13.3c-3.6-5.5-5.4-12.7-5.4-21.5c0-9,1.9-16.5,5.7-22.6
                        c3.8-6,8.7-10.8,14.7-14.4c6-3.6,12.7-6.1,20.2-7.6c7.5-1.5,14.9-2.3,22.3-2.3c9.1,0,17.5,1,25.1,2.9c7.6,2,14.3,5.1,20.1,9.4
                        c5.7,4.3,10.3,10,13.8,17.1c3.4,7,5.4,15.7,5.9,25.9h-5.1c-0.4-9.3-2.1-17.2-5.3-23.6c-3.2-6.4-7.4-11.6-12.6-15.6
                        c-5.2-4-11.5-6.8-18.7-8.5c-7.2-1.7-14.9-2.5-23.2-2.5c-6.3,0-13,0.6-19.8,1.9c-6.9,1.3-13.1,3.5-18.7,6.8
                        c-5.6,3.2-10.2,7.5-13.8,12.9c-3.6,5.4-5.4,12.1-5.4,20.3c0,8.2,1.8,14.7,5.5,19.6s8.5,8.9,14.4,12c5.9,3.1,12.7,5.5,20.2,7.1
                        c7.5,1.7,15.3,3.5,23.2,5.3c8.6,2.2,16.7,4.3,24.3,6.4c7.6,2,14.3,4.8,19.9,8.2c5.7,3.4,10.2,7.9,13.5,13.5c3.3,5.6,5,13.2,5,22.7
                        C1248.2,957.1,1246.3,964.5,1242.6,970.6z" />
                        <polygon class="st0" points="681.7,655.4 613.2,655.4 647.1,559.6 	" />
                        <path class="st0" d="M379.6,860.8c0,7.1-1.3,13.4-3.9,18.9c-2.6,5.4-6.1,10.1-10.7,13.9c-4.5,3.8-9.9,6.7-16.1,8.7
                        c-6.2,2-12.9,2.9-20.1,2.9h-69.2v-89h69.2c17.1,0,29.9,3.8,38.2,11.5C375.4,835.3,379.6,846.3,379.6,860.8z" />
                        <path class="st0" d="M528.3,857.2c0,8-1.5,14.8-4.4,20.5c-2.9,5.7-6.8,10.4-11.6,14.1c-4.8,3.7-10.3,6.5-16.6,8.2
                        c-6.3,1.7-12.8,2.5-19.7,2.5h-68.7v-86.4h71.3c17.5,0,30.1,3.6,37.8,10.8C524.2,834.2,528.2,844.3,528.3,857.2z" />
                        <path class="st0" d="M1089.7,902.1c-0.2,13.1-2.1,25.2-5.8,36.2c-3.7,11-8.9,20.6-15.7,28.5c-6.8,8-15,14.2-24.8,18.7
                        c-9.8,4.5-20.8,6.8-33.2,6.8c-12.4,0-23.4-2.3-33.2-6.8c-9.8-4.5-18.1-10.8-24.8-18.7c-6.8-8-12-17.5-15.7-28.5s-5.6-23.1-5.8-36.2
                        c0.2-13.1,2.1-25.2,5.8-36.2c3.7-11,8.9-20.6,15.7-28.5c6.8-8,15-14.2,24.8-18.7c9.8-4.5,20.8-6.8,33.2-6.8
                        c12.3,0,23.4,2.3,33.2,6.8c9.8,4.5,18.1,10.8,24.8,18.7c6.8,8,12,17.5,15.7,28.5C1087.6,876.9,1089.6,889,1089.7,902.1z" />
                    </g>
                    <text transform="matrix(1 0 0 1 697.0934 775.6308)" class="st1 st2 st3">PRÊMIOS</text>
                    <text transform="matrix(1 0 0 1 705.5675 832.9199)" class="st4">
                        <tspan x="0" y="0" class="st5 st2 st6">LEVANDO PESSOAS COMUNS,</tspan>
                        <tspan x="0" y="48.6" class="st5 st2 st6">A RESULTADOS EXCEPCIONAIS.</tspan>
                    </text>
                </svg>
                <img src=<?php echo '//' . $config['baseUrl'] . '/img/c/logo_campanha.png'; ?>>
            </center>
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