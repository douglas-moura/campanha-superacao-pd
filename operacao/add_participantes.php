<?php
    include_once __DIR__ . "/../partials/header-operacao.php";
    function _include($post, $db, $errors) {}

    $errors = [];
    $success = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (!isset($_POST['email']) || !isset($_POST['cpf'])) {
            $errors[] = 'Participante Inválido';
        } else {
            $email = $_POST['email'];
            $cpf = preg_replace("/\D+/", "", $_POST['cpf']);
            $name = $_POST['name'];
            $query = "INSERT INTO users (
                                    email,
                                    cpf,
                                    name
                                        ) VALUES (
                                            '$email',
                                            '$cpf',
                                            '$name'
                                                )";

            $result = $db->query($query);

            if (!$result) {
                $errors[] = 'Não foi possível salvar, verifique os dados do participante';
            } else {
                $success[] = 'Participante criado';
                $email = '';
                $cpf = '';
                $name = '';
            }
        }
    }
?>

<section class="wrapper" style="width:100%;overflow-x:auto;">
    <form class="form-signin" id='signin' name='signin' method="post" novalidate>
        <h4 class="form-signin-heading">Cadastro Simples de Participantes Maxx Prêmios</h4>

        <?php
            if (count($errors) > 0) {
                echo '<div class="alert alert-danger">';
                foreach ($errors as $error) {
                    echo '<p class="error">' . $error . '</p>';
                }
                echo '</div>';
            }
        ?>

        <?php
            if (count($success) > 0) {
                echo '<div class="alert alert-success">';
                foreach ($success as $successItem) {
                    echo '<p class="error">' . $successItem . '</p>';
                }
                echo '</div>';
            }
        ?>

        <div class="row">
            <div class="form-group">
                <label class="form-label" for="email">Nome
                </label>
                <input name="name" id="name" class="form-control" title="Preencha o nome" required minlength="9" maxlength="100" placeholder="josé da silva" value="<?php if (isset($name)) echo $name; ?>" type="text" />
            </div>

            <div class="form-group">
                <label class="form-label" for="email">E-mail
                </label>
                <input name="email" id="email" class="form-control" title="Preencha o e-mail" required minlength="9" maxlength="100" placeholder="partcipante.email@exemplo.com.br" value="<?php if (isset($email)) echo $email; ?>" type="email" />
            </div>

            <div class="form-group">
                <label class="form-label" for="cpf">CPF</label>
                <input name="cpf" id="cpf" class="form-control " title="Preencha o cpf" required minlength="9" maxlength="15" placeholder="___.___.___-__" value="<?php if (isset($cpf)) echo $cpf; ?>" type="tel">
            </div>

            <button class="btn btn-lg btn-primary btn-block btn-login" type="submit">Cadastrar participante</button>
        </div>
    </form>
</section>



<?php
    $footerIncludes = '
        <script src="//' . $config['assets'] . 'js/jquery.validate.min.js"></script>
        <script src="//' . $config['assets'] . 'js/jquery.maskx.js"></script>
        <script src="//' . $config['assets'] . 'js/singup.js"></script>
    ';

    include_once __DIR__ . "/../partials/footer.php";
    include_once __DIR__ . "/../partials/foot.php";
?>