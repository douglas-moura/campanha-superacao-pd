<?php

    $regions = [
        'AC',  'AL',  'AP',  'AM',
        'BA',  'CE',  'DF',  'ES',
        'GO',  'MA',  'MS',  'MT',
        'MG',  'PA',  'PB',  'PR',
        'PE',  'PI',  'RJ',  'RN',
        'RS',  'RO',  'RR',  'SC',
        'SP',  'SE',  'TO'];

    $userId = $_SESSION['user']['id'];
    $errors = [];

    include_once __DIR__ . "/address_get.php";
    
    include_once __DIR__ . "/profile_get.php";
    
    include_once __DIR__ . "/family_get.php";

?>

<script> <?php echo "window.maxx = {baseUrl: '" . $config['baseUrl'] . "'} "; ?> </script>

<div class="introducao-perfil">
    <p>
        Preencha os campos com atenção, principalmente os de sua família, pois eles são muito<br>importantes e podem te garantir mais pontos na campanha.
    </p>
</div>
<?php
    if(count($errors) > 0) {
        $showErros = array_unique($errors);
        foreach ($showErros as $error) {
            echo '<p class="error">' . $error . '</p>';
        }
    }

    if(isset($_GET['errors']) && strlen($_GET['errors']) > 3) {
        echo '<div class="alert alert-danger"> ' . htmlentities($_GET['errors']) . '</div>';
    }

    if(isset($_GET['success']) && strlen($_GET['success']) > 3) {
        echo '<div class="alert alert-success"> ' . htmlentities($_GET['success']) . '</div>';
    }
?>

<div class="formularios">
    <div class="coluna coluna-1">
        <div class="perfil">
            <?php
                $showProfile = '';
                if ($password) {
                    include_once __DIR__ . "/profile_view.php";
                    $showProfile = 'display:none;';
                }
                
                echo "<div class='profile-form' style='$showProfile'>";
                    include_once __DIR__ . "/profile_form.php";
                echo "</div>";
            ?>
        </div>
        
        <div class="endereco">
            <?php
                $showForm = '';
                if (isset($addressId)) {
                    include_once __DIR__ . "/address_view.php";
                    $showForm = 'display:none;';
                }
                
                echo "<div class='addres-form' style='$showForm'>";
                    include_once __DIR__ . "/address_form.php";
                echo "</div>";
            ?>
        </div>
    </div>
    
    <div class="coluna coluna-2">
        <?php
            include_once __DIR__ . "/family_form.php";
            if ($_SESSION['user']):
        ?>
    </div>
</div>

<a href="<?php echo '//' . $config['baseUrl'] ?>/finalizar" class="btn_prim btn_padrao"> Finalizar Atualização</a>

<?php
    endif;
    
    $footerIncludes = '
    <script src="//' . $config['assets'] . 'js/jquery.validate.min.js"></script>
    <script src="//' . $config['assets'] . 'js/jquery.form.min.js"></script>
    <script src="//' . $config['assets'] . 'js/jquery.maskx.js"></script>
    <script src="//' . $config['assets'] . 'js/register.js?version=' . $config['version'] . '"></script>
    ';
?>
