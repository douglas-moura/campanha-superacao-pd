<?php
    include_once __DIR__ . "/../partials/db.php";
    $db = new Db($config);

    $msg = '';
    $result = NULL;
    $alertCPF = '';
    $alertEmail = '';

    $nome = isset($_POST['nome']) ? $_POST['nome'] : 0;
    $sobrenome = isset($_POST['sobrenome']) ? $_POST['sobrenome'] : 0;
    $cpf = isset($_POST['cpf']) ? preg_replace("/[^0-9]/", "", $_POST['cpf']) : 0;
    $sexo = isset($_POST['sexo']) ? $_POST['sexo'] : 0;
    $cargo = isset($_POST['cargo']) ? $_POST['cargo'] : 0;
    $email = isset($_POST['email_resp']) ? $_POST['email_resp'] : 0;
    $tel = isset($_POST['phone']) ? $_POST['phone'] : 0;

    $query_verific = $db->select("SELECT * FROM users WHERE cpf = '$cpf' OR email = '$email'");

    $numeros = count($query_verific);

    /*
        echo "<pre>";
        echo print_r($numeros) . '<br>';
        echo print_r($query_verific) . '<br>';
        echo "</pre>";
    */

    if ($nome == 0 && $cpf == 0) {
        $result = NULL;
    } else {
        if ($numeros > 0) {
            if ($query_verific[0]['email'] == $email) {
                $msg = 'E-mail já cadastrado';
                $alertEmail = 'alertEmail';
            }

            if ($query_verific[0]['cpf'] == $cpf) {
                $msg = 'CPF já cadastrado';
                $alertCPF = 'alertCPF';
            }

            $alerta = 'alert-danger';
            $result = 1;
        } else {
            if (empty($_POST['nome']) || empty($_POST['email_resp']) || empty($_POST['cpf'])) {
                $alerta = 'alert-danger';
                $msg = 'Preencha todos os campos';
                $result = 1;
            } else {
                $msg = '
                    <p style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">Cadastro realizado com sucesso!</p>
                    <p style="font-size: .8rem;">Cadastro realizado com sucesso! <a href="//' . $config['baseUrl'] . '/"><h4>Entre e complete seu cadastro</h4></a></p>
                ';
                $alerta = 'alert-success';
                $sql = "INSERT INTO users (email, cpf, name, name_extension, gender, type, phone, autorizacao_LGPD) VALUES ('$email' , '$cpf', '$nome', '$sobrenome', '$sexo', '$cargo', '$tel', true)";
                $result = $db->query($sql);

                
                $to = "douglas@gtx100.com.br";
                $subject = "Novo Usuário Cadastrado - " . $config['nomeCamp'];
                $txt = '
                    <p>' . $cpf . '</p>
                    <p>' . $nome . ' ' . $sobrenome . '</p>
                    <p>' . $email . '</p>
                    <p>' . $tel . '</p>
                    <p>' . $cargo . '</p>
                    <p>' . $sexo . '</p>
                ';

                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= "From: remetente@seudominio.com\r\n";

                mail($to, $subject, $txt, $headers);
            }
        }
    }
?>

<style>
    @media (max-width: 768px) {
  #img-form {
    display: none;
  }

  .campos-form {
    width: 100% !important;
    padding: 1.5rem !important;
    transform: scale(1) !important;
  }

  .wrapper {
    transform: scale(1) !important  ;
  }

  #logo-campanha {
    max-width: 180px !important;
  }
}
</style>

<form class="wrapper" id='signin' name='signin' method="post" style="display: flex; padding: 0 !important; transform: scale(.9); width: 80% !important; margin: 0 auto !important;" novalidate>
    <div class="campos-form" style="width: 60%; padding: 3rem;">
        <?php
        if (!$result) {
            echo '';
        } else {
            echo '
                    <div class="alert ' . $alerta . '">
                        <p>' . $msg . '</p>
                ';
            //echo $msg == 'Cadastro realizado com sucesso!' ? '<a href="//' . $config['baseUrl'] . '/"><h4>Entre e complete seu cadastro</h4></a>' : '';
            echo '
                    </div>
                    <style>.form-group,.btn {display: none;}</style>
                ';
        }
        ?>
        <img id="logo-campanha" src="../img/c/logo-campanha.png" alt="" style="max-width: 300px; margin: 25px auto; display: block; filter: drop-shadow(.2rem .2rem .15rem #bbb);">
        <h3 style="margin: 3rem auto !important; color: #888; width: 80%;">Garanta sua participação: inscreva-se na campanha agora mesmo!</h3>
        <!--
        <p class="voltar">
            <a class="" href="<?php echo '//' . $config['baseUrl']; ?>">Voltar</a>
        </p>
        -->
        <div class="linha-form">
            <div class="coluna-form">
                <div>
                    <label class="" for="nome">Nome</label>
                    <input name="nome" id="nome" class="" title="" required placeholder="Ex.: José" value="" type="text" />
                </div>
                <div>
                    <label class="" for="sobrenome">Sobrenome</label>
                    <input name="sobrenome" id="sobrenome" class="" title="" required placeholder="Ex.: da Silva" value="" type="text" />
                </div>
            </div>
        </div>

        <div class="linha-form <?php echo $alertCPF; ?>">
            <label class="" for="cpf">CPF</label>
            <input name="cpf" id="cpf" class="" title="" required placeholder="123.456.789-10" value="" type="text">
        </div>

        <div class="linha-form">
            <div class="coluna-form">
                <div>
                    <label name="cargo" class="" for="cargo" title="" required placeholder="Público" value="">Cargo</label>
                    <select class="" id="cargo" name="cargo">
                        <option disabled selected> </option>
                        <option value="gerente">Gerente</option>
                        <option value="supervisor">Supervisor</option>
                        <option value="representante">Representante</option>
                    </select>
                </div>
                <div>
                    <label name="sexo" class="" for="sexo" title="" required placeholder="Sexo" value="">Sexo</label>
                    <select class="" id="sexo" name="sexo">
                        <option disabled selected> </option>
                        <option value="f">Feminino</option>
                        <option value="m">Masculino</option>
                        <option value="m">Não informar</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="linha-form">
            <label class="" for="tel">Telefone</label>
            <input name="phone" id="telefone" class="" title="" required placeholder="(11) 98765-4321" value="" type="tel" />
        </div>

        <div class="linha-form <?php echo $alertEmail; ?>">
            <label class="" for="email">E-mail</label>
            <input name="email_resp" id="email" class="" title="" required placeholder="exemplo@email.com" value="" type="email" />
        </div>

        <h6 style="margin-bottom: 1rem !important;">
            <input id="check_01" type="checkbox" class="check_form_cad <?php echo $alertCheck; ?>" name="autoriza" value="autoriza">
            <p>Li e concordo com os <a target="_blank" href="../Termo%20de%20Uso%20de%20Dados%20-%20GTX100.pdf">Termos de Privacidade e LGPD</a> da GTX100</p>
        </h6>
        <!--
        <h6 style="margin-top: 5px !important;">
            <input id="check_02" type="checkbox" class="check_form_cad <?php echo $alertCheck; ?>" name="" value="">
            <p>Li e concordo com os <a target="_blank" href="https://theraskin.com.br/politica-de-privacidade">Política de Privacidade</a> e os <a target="_blank" href="https://theraskin.com.br/termos-de-uso">Termos de Uso</a> da TheraSkin</p>
        </h6>
        -->
        <button disabled class="btn_cadastrar btn_padrao" type="submit">Cadastrar</button>
    </div>
    <img id="img-form" src="../img/equipe-rafit.jpg" alt="" style="width: 40%; object-fit: cover;">
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
    var checkbox_g = $(".campos-form #check_01");
    //var checkbox_t = $(".campos-form #check_02");
    var button = $(".campos-form .btn_cadastrar");

    checkbox_g.change(function(event) {
        var checkbox_g = event.target;

        if (checkbox_g.checked) {
            button.addClass('ativado');
            button.addClass('btn_prim');
            button.removeClass('desativado');
            button.removeAttr("disabled");
        } else {
            button.addClass('desativado');
            button.removeClass('ativado');
            button.attr('disabled', true);
        }
    });

    /*
    checkbox_g.change(function(event) {
        var checkbox_g = event.target;

        if (checkbox_t[0].checked) {
            button.addClass('ativado');
            button.addClass('btn_prim');
            button.removeClass('desativado');
            button.removeAttr("disabled");
        } else {
            button.addClass('desativado');
            button.removeClass('ativado');
            button.attr('disabled', true);
        }
    });
    checkbox_t.change(function(event) {
        var checkbox_t = event.target;

        if (checkbox_g[0].checked) {
            button.addClass('ativado');
            button.addClass('btn_prim');
            button.removeClass('desativado');
            button.removeAttr("disabled");
        } else {
            button.addClass('desativado');
            button.removeClass('ativado');
            button.attr('disabled', true);
        }
    });
    */
</script>