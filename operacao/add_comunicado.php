<?php
    include_once __DIR__ . "/../partials/header-operacao.php";

    $errors = [];
    $success = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['model']) || !isset($_POST['text'])) {
            $errors[] = 'Dodos Inválidos';
        } else {
            $model = $_POST['model'];
            $text = $_POST['text'];
            $query = "INSERT INTO vb_communication_model (
                                        `model`,
                                        `text`
                                            ) VALUES (
                                                '$model',
                                                '$text'
                                            )";

            $result = $db->query($query);

            if (!$result) {
                $errors[] = 'Não foi possível salvar, verifique os dados';
            } else {
                $success[] = 'Modelo criado';
                $model = '';
                $text = '';
            }
        }
    }
?>

<section class="wrapper" style="width:100%;overflow-x:auto;">
    <form class="form-register-profile col-md-9" id='signin' name='signin' method="post" novalidate>
        <h4 class="form-signin-heading">Cadastro modelo de comunicado</h4>
        <?php
            if (count($errors) > 0) {
                echo '<div class="alert alert-danger">';
                foreach ($errors as $error) {
                    echo '<p class="error">' . $error . '</p>';
                }
                echo '</div>';
            }
        
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
                <label class="form-label" for="model">Modelo
                </label>
                <input name="model" id="model" class="form-control" title="Preencha o nome do modelo" required minlength="1" maxlength="100" placeholder="um-bom-nome" value="<?php if (isset($model)) echo $model; ?>" type="model" />
            </div>

            <div class="form-group">
                <label class="form-label" for="text">texto</label>
                <textarea name="text" id="text" class="form-control ">
                <?php if (isset($text)) echo $text; ?>
              </textarea>
            </div>
            <button class="btn btn-lg btn-primary btn-block btn-login" type="submit">Cadastrar modelo de comunicado</button>
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

<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
<script>
    $(document).ready(function() {
        $('#text').summernote();
    });
</script>