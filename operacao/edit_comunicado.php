<?php
    include_once __DIR__ . "/../partials/header-operacao.php";

    $errors = [];
    $success = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (!isset($_POST['model']) || empty($_POST['model']) || !isset($_POST['text']) || empty($_POST['text'])) {
            $errors[] = 'Comunicado Inválido';
            exit('Comunicado Inválido');
        } else {
            $comunicationId = $_POST['ID'];
            $model = $_POST['model'];
            $text = $_POST['text'];

            $query = "UPDATE vb_communication_model SET
                                            model = '$model',
                                            text = '$text'
                                            WHERE
                                            id = $comunicationId";

            $result = $db->query($query);

            if (!$result) {
                $errors[] = 'Não foi possível atualizar, verifique os dados do comunicado';
            } else {
                $success[] = 'Comunicado atualizado';
            }
        }
    } else {
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $comunicationId = $_GET['id'];
        } else {
            exit('Erro. Comunicado inválido');
        }

        $query_address = "SELECT * FROM `vb_communication_model` WHERE id=$comunicationId order by id desc limit 0, 1";
        $rows = $db->select($query_address);

        if (count($rows[0]) > 0) {
            $result = $rows[0];
            $model = $result['model'];
            $text = $result['text'];
        }
    }
?>

<section class="wrapper">
    <form class="form-register-profile col-md-9" id='register_profile' name='register_profile' method="post" novalidate>
        <input type="hidden" name="ID" value="<?php if (isset($comunicationId)) echo $comunicationId; ?>" />
        <fieldset>
            <legend>Comunicado </legend>
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
                <div class="form-group col-xs-12">
                    <label class="form-label" for="model">Modelo <span>(sem espaço ou caracteres especiais)</span></label>
                    <input value="<?php if (isset($model)) echo $model; ?>" name="model" id="model" class="form-control " required maxlength="100" type="text">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-xs-12">
                    <label class="form-label" for="text">Texto </label>

                    <textarea name="text" id="text" class="form-control ">
                <?php if (isset($text)) echo $text; ?>
              </textarea>
                </div>
            </div>
            <button class="btn btn-lg btn-primary btn-block btn-login" type="submit">Atualizar modelo de comunicado</button>
        </fieldset>
    </form>
</section>

<?php
    $footerIncludes = '
        <script src="//' . $config['assets'] . 'js/jquery.validate.min.js"></script>
        <script src="//' . $config['assets'] . 'js/jquery.maskx.js"></script>
        <script src="//' . $config['assets'] . 'js/register.js"></script>
    ';

    include_once __DIR__ . "/../partials/footer.php";
    include_once __DIR__ . "/../partials/foot.php";
?>

<link href="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
<script src="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
<script>
    $(document).ready(function() {
        $('#text').summernote();
    });
</script>