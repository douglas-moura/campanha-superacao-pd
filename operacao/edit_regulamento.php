<?php
  include_once __DIR__ . "/../partials/header-operacao.php";

  $errors = [];
  $success = [];
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (
      !isset($_POST['public']) ||
      empty($_POST['public']) ||
      !isset($_POST['text']) ||
      empty($_POST['text'])
    ) {
      $errors[] = 'Regulamento Inválido';
      exit('Regulamento Inválido');

    } else {

      $ruleId = $_POST['ID'];
      $public = $_POST['public'];
      $text = $_POST['text'];

      $query = "
        UPDATE
        vb_rules
        SET
        public = '$public',
        text = '$text'
        WHERE
          id = $ruleId
      ";

      $result = $db->query($query);

      if(!$result) {
        $errors[] = 'Não foi possível atualizar, verifique os dados do Regulamento';
      } else {
        $success[] = 'Regulamento atualizado';
      }

    }

  } else {

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
      $ruleId = $_GET['id'];
    } else {
      exit('Erro. Regulamento inválido');
    }

    $query_address = "SELECT * FROM `vb_rules` WHERE id=$ruleId order by id desc limit 0, 1";
    $rows = $db -> select($query_address);

    if (count($rows[0]) > 0){
      $result = $rows[0];
      $public = $result['public'];
      $text = $result['text'];
    }

  }

?>

  <section class="wrapper" >

    <form class="form-register-profile col-md-9" id='register_profile' name='register_profile' method="post"  novalidate>
      <input type="hidden" name="ID" value="<?php if (isset($ruleId)) echo $ruleId; ?>" />
      <fieldset>
        <legend>Regulamento </legend>


          <?php
            if(count($errors) > 0) {
              echo '<div class="alert alert-danger">';
              foreach ($errors as $error) {
                echo '<p class="error">' . $error . '</p>';
              }
              echo '</div>';
            }
          ?>

          <?php
            if(count($success) > 0) {
              echo '<div class="alert alert-success">';
              foreach ($success as $successItem) {
                echo '<p class="error">' . $successItem . '</p>';
              }
              echo '</div>';
            }
          ?>


          <div class="row">
            <div class="form-group col-xs-12"  >
              <label class="form-label"  for="public" >publico <span>(sem espaço ou caracteres especiais)</span></label>
              <input
              value="<?php if (isset($public)) echo $public; ?>"
              name="public"  id="public" class="form-control "
              required maxlength="100" type="text">
            </div>
          </div>

          <div class="row">
            <div class="form-group col-xs-12"  >
              <label class="form-label"  for="text" >Texto </label>

              <textarea name="text"  id="text" class="form-control ">
                <?php if (isset($text)) echo $text; ?>
              </textarea>
            </div>

          </div>




          <button class="btn btn-lg btn-primary btn-block btn-login" type="submit">Atualizar modelo de Regulamento</button>

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

<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
<script >

$(document).ready(function() {
  $('#text').summernote();
});


</script>
