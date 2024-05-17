<?php
  include_once __DIR__ . "/../partials/header-operacao.php";

  $errors = [];
  $success = [];
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (
      !isset($_POST['name']) ||
      empty($_POST['name']) ||
      !isset($_POST['birthday']) ||
      empty($_POST['birthday']) ||
      !isset($_POST['phone']) ||
      empty($_POST['phone']) ||
      !isset($_POST['alias']) ||
      empty($_POST['alias']) ||
      !isset($_POST['email']) ||
      empty($_POST['email']) ||
      !isset($_POST['cpf']) ||
      empty($_POST['cpf']) ||
      !isset($_POST['gender']) ||
      empty($_POST['gender']) ||
      !isset($_POST['ID']) ||
      empty($_POST['ID']) ||
      !isset($_POST['type']) ||
      empty($_POST['type'])
    ) {
      $errors[] = 'Participante Inválido';
      exit('Participante Inválido');

    } else {

      $userId = $_POST['ID'];
      $name = $_POST['name'];
      $birthday = $_POST['birthday'];
      $phone = $_POST['phone'];
      $alias = $_POST['alias'];
      $email = $_POST['email'];
      $cpf = preg_replace("/\D+/", "", $_POST['cpf']);
      $gender = $_POST['gender'];
      $type = $_POST['type'];

      $query = "
        UPDATE
          users
        SET
          name = '$name',
          birthday = '$birthday',
          phone = '$phone',
          alias = '$alias',
          email = '$email',
          cpf = '$cpf',
          gender = '$gender',
          type = '$type'
        WHERE
          id = $userId
      ";

      $result = $db->query($query);

      if(!$result) {
        $errors[] = 'Não foi possível atualizar, verifique os dados do participante';
      } else {
        $success[] = 'Participante atualizado';
      }

    }

  } else {

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
      $userId = $_GET['id'];
    } else {
      exit('Erro. Usuário inválido');
    }

    $query_address = "SELECT * FROM `users` WHERE id=$userId order by id desc limit 0, 1";
    $rows = $db -> select($query_address);

    if (count($rows[0]) > 0){
      $profile = $rows[0];

      $name = $profile['name'];
      $birthday = $profile['birthday'];
      $phone = $profile['phone'];
      $alias = $profile['alias'];
      $email = $profile['email'];
      $cpf = $profile['cpf'];
      $gender = $profile['gender'];
      $type = $profile['type'];
    }

  }

?>

  <section class="wrapper" >

    <form class="form-register-profile col-md-6" id='register_profile' name='register_profile' method="post"  novalidate>
      <input type="hidden" name="ID" value="<?php if (isset($userId)) echo $userId; ?>" />
      <fieldset>
        <legend>Perfil </legend>


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
              <label class="form-label"  for="name" >Nome Completo</label>
              <input
              value="<?php if (isset($name)) echo $name; ?>"
              name="name"  id="name" class="form-control " required maxlength="100" type="text">
            </div>
          </div>

          <div class="row">
            <div class="form-group col-xs-12"  >
              <label class="form-label"  for="alias" >Apelido <span>Nome que aparece no site</span></label>
              <input
              value="<?php if (isset($alias)) echo $alias; ?>"
              name="alias"  id="alias" class="form-control " required maxlength="100" type="text">
            </div>

          </div>


          <div class="row">
            <div class="form-group  col-md-6" >
                  <label class="form-label" for="email"
                      >E-mail
                  </label>
                  <input
                      name="email" id="email"
                      class="form-control"
                      title="Preencha o e-mail"
                      required
                      minlength="9"
                      maxlength="100"
                      placeholder="partcipante.email@exemplo.com.br"
                      value="<?php if (isset($email)) echo $email; ?>"
                      type="email" />
              </div>

              <div class="form-group  col-md-6" >
                  <label class="form-label" for="cpf">CPF</label>
                  <input
                    name="cpf"
                    id="cpf"
                    class="form-control "
                    title="Preencha o cpf"
                    required
                    minlength="9"
                    maxlength="15"
                    placeholder="___.___.___-__"
                    value="<?php if (isset($cpf)) echo $cpf; ?>"
                    type="tel">
              </div>
          </div>

          <div class="row">
            <div class="form-group col-md-6" >
                  <label class="form-label" for="gender"
                      >Genero
                  </label>
                  <input
                      name="gender" id="gender"
                      class="form-control"
                      title="F ou M"
                      required
                      minlength="1"
                      maxlength="1"
                      placeholder="F ou M"
                      value="<?php if (isset($gender)) echo $gender; ?>"
                      type="text" />
              </div>

              <div class="form-group col-md-6" >
                  <label class="form-label" for="type">Publico</label>
                  <input
                    name="type"
                    id="type"
                    class="form-control "
                    title="Preencha o publico"
                    required
                    minlength="3"
                    maxlength="150"
                    placeholder=""
                    value="<?php if (isset($type)) echo $type; ?>"
                    type="text">
              </div>
          </div>


          <div class="row">

            <div class="form-group  col-md-6">
              <label for="birthday" class="form-label">Data de nascimento</label>
              <input
                value="<?php if (isset($birthday)) echo $birthday; ?>"
                placeholder="__/__/____"
                name="birthday"  id="birthday" class="form-control " required maxlength="10" type="text">
            </div>

            <div class="form-group  col-md-6">
              <label for="phone" class="form-label">Celular</label>
              <input
                value="<?php if (isset($phone)) echo $phone; ?>"
                placeholder="(__) ____._____"
                name="phone"  id="phone" class="form-control "  required maxlength="15" type="text">
            </div>

          </div>


          <button class="btn btn-lg btn-primary btn-block btn-login" type="submit">Atualizar perfil</button>

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
