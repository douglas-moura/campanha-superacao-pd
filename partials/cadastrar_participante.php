<?php
include_once __DIR__ . "/../partials/db.php";
$db = new Db($config);

$erro = '';
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
            $erro = 'E-mail já cadastrado';
            $alertEmail = 'alertEmail';
        }

        if ($query_verific[0]['cpf'] == $cpf) {
            $erro = 'CPF já cadastrado';
            $alertCPF = 'alertCPF';
        }

        $alerta = 'alert-danger';
        $result = 1;
    } else {
        if (empty($_POST['nome']) || empty($_POST['email_resp']) || empty($_POST['cpf'])) {
            $alerta = 'alert-danger';
            $erro = 'Preencha todos os campos';
            $result = 1;
        } else {
            $erro = 'Cadastro realizado com sucesso!';
            $alerta = 'alert-success';
            $sql = "INSERT INTO users (email, cpf, name, name_extension, gender, type, phone, autorizacao_LGPD) VALUES ('$email' , '$cpf', '$nome', '$sobrenome', '$sexo', '$cargo', '$tel', true)";
            $result = $db->query($sql);

            $to = "douglas@gtx100.com.br";
            $subject = "Novo Usuário Cadastrado - " . $config['nomeCamp'];
            $txt = $cpf;

            mail($to, $subject, $txt);
        }
    }
}
?>

<form class="wrapper" id='signin' name='signin' method="post" novalidate>
    <div class="campos-form">
        <?php
        if (!$result) {
            echo '';
        } else {
            echo '
                    <div class="alert ' . $alerta . '">
                        <p>' . $erro . '</p>
                ';
            echo $erro == 'Cadastro realizado com sucesso!' ? '<a href="//' . $config['baseUrl'] . '/"><h4>Entre e complete seu cadastro</h4></a>' : '';
            echo '
                    </div>
                    <style>.form-group,.btn {display: none;}</style>
                ';
        }
        ?>
        <h3>Cadastre-se agora na<br><strong><?php echo $config['nomeCamp']; ?></strong></h3>
        <p class="voltar">
            <a class="" href="<?php echo '//' . $config['baseUrl']; ?>">Voltar</a>
        </p>
        <div class="linha-form">
            <div class="coluna-form">
                <div>
                    <label class="" for="nome">Nome</label>
                    <input name="nome" id="nome" class="" title="" required placeholder="José" value="" type="text" />
                </div>
                <div>
                    <label class="" for="sobrenome">Sobrenome</label>
                    <input name="sobrenome" id="sobrenome" class="" title="" required placeholder="Silva" value="" type="text" />
                </div>
            </div>
        </div>

        <div class="linha-form <?php echo $alertCPF; ?>">
            <label class="" for="cpf">CPF</label>
            <input name="cpf" id="cpf" class="" title="" required placeholder="123.456.789-10" value="" type="text">
        </div>

        <div class="linha-form">
            <label name="cargo" class="" for="cargo" title="" required placeholder="Público" value="">Público</label>
            <!--
            <select class="" id="cargo" name="cargo">
                <option disabled selected> </option>
                <option value="Gerente de Contas">Gerente de Contas</option>
                <option value="Gerente de Produtos Senior">Gerente de Produtos Sênior</option>
                <option value="Gerente de Produtos Pleno">Gerente de Produtos Pleno</option>
                <option value="Gerente Distrital de Demanda Junior">Gerente Distrital de Demanda Junior</option>
                <option value="Gerente Distrital de Demanda Senior">Gerente Distrital de Demanda Sênior</option>
                <option value="Consultor de PDV Junior">Consultor de PDV Junior</option>
                <option value="Consultor de PDV Junior">Consultor de PDV Pleno</option>
                <option value="Coordenador Tecnico Cientifico">Coordenador Técnico Ciêntífico</option>
                <option value="Coordenador de Trade e Execucao">Coordenador de Trade e Execução</option>
                <option value="Propagandista Junior">Propagandista Junior</option>
                <option value="Propagandista Pleno">Propagandista Pleno</option>
                <option value="Propagandista Senior">Propagandista Senior</option>
                <option value="Representante Digital">Representante Digital</option>
                <option value="Televendas">Televendas</option>
            </select>
            -->
            
            <select class="" id="cargo" name="cargo">
                <option disabled selected> </option>
                <option value="Gerente Distrital">Gerente Distrital</option>
                <option value="Representante Propagandista">Representante Propagandista</option>
                <option value="Coordenador Tecnico Cientifico Digital">Coordenador Técnico Ciêntifico Digital</option>
                <option value="Representante Digital">Representante Digital</option>
                <option value="Coordenador Trade">Coordenador Trade</option>
                <option value="Consultor de Trade Marketing">Consultor de Trade Marketing</option>
                <option value="Gerente de Produto">Gerente de Produto</option>
                <option value="Gerente de Contas">Gerente de Contas</option>
                <option value="Televendas">Televendas</option>
            </select>
            
        </div>

        <div class="linha-form">
            <label name="sexo" class="" for="sexo" title="" required placeholder="Sexo" value="">Sexo</label>
            <select class="" id="sexo" name="sexo">
                <option disabled selected> </option>
                <option value="f">Feminino</option>
                <option value="m">Masculino</option>
                <option value="m">Não informar</option>
            </select>
        </div>

        <div class="linha-form">
            <label class="" for="tel">Telefone</label>
            <input name="phone" id="telefone" class="" title="" required placeholder="(11) 98765-4321" value="" type="tel" />
        </div>

        <div class="linha-form <?php echo $alertEmail; ?>">
            <label class="" for="email">E-mail</label>
            <input name="email_resp" id="email" class="" title="" required placeholder="nome@empresa.com.br" value="" type="email" />
        </div>

        <h6 style="margin-bottom: 5px !important;">
            <input id="check_01" type="checkbox" class="check_form_cad <?php echo $alertCheck; ?>" name="autoriza" value="autoriza">
            <p>Li e concordo com os <a target="_blank" href="../Termo%20de%20Uso%20de%20Dados%20-%20GTX100.pdf">Termos de Privacidade e LGPD</a> da GTX100</p>
        </h6>
        <h6 style="margin-top: 5px !important;">
            <input id="check_02" type="checkbox" class="check_form_cad <?php echo $alertCheck; ?>" name="" value="">
            <p>Li e concordo com os <a target="_blank" href="https://theraskin.com.br/politica-de-privacidade">Política de Privacidade</a> e os <a target="_blank" href="https://theraskin.com.br/termos-de-uso">Termos de Uso</a> da TheraSkin</p>
        </h6>

        <button disabled class="btn_cadastrar btn_padrao" type="submit">Cadastrar</button>
    </div>
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
    var checkbox_g = $(".campos-form #check_01");
    var checkbox_t = $(".campos-form #check_02");
    var button = $(".campos-form .btn_cadastrar");

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
</script>