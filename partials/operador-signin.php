<?php
function login($post, $errors)
{
    if (!isset($post['login']) || !isset($post['password'])) {
        $errors[] = 'Login Inválido';
        return $errors;
    }

    $login = $post['login'];
    $password = $post['password'];

    if ($login === 'operadormxx' && $password === 'xx@m9182') {
        $_SESSION['admin'] = true;
    } else {
        $errors[] = "Operador não encontrado";
        session_destroy();
        return $errors;
    }
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = login($_POST, $errors);
}

if (isset($_SESSION['admin'])) {
    echo "<script>window.location.href='../operacao'</script>";
}
?>

<section class="box-login">
    <form class="form-login" id='signin' name='signin' method="post" novalidate>
        <h2 class="">Operador Maxx Prêmios</h2>

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
                <label class="linha-form" for="login">Login</label>
                <input name="login" id="login" class="" title="Preencha o e-mail" required minlength="6" maxlength="100" value="<?php if (isset($login)) echo $login; ?>" type="login" />
            </div>

            <div class="form-group">
                <label class="" for="password">Senha</label>
                <input name="password" id="password" class="" title="Preencha o password" required minlength="6" maxlength="15" type="password">
            </div>

            <button class="" type="submit">Entrar</button>
        </div>
    </form>
</section>

<?php $footerIncludes = ''; ?>