<?php
    $kinships = [
        'Cônjuge',
        'Filho (a)',
        'Pai ou Mãe',
        'Irmão (a)',
        'Outro'
    ];

    $genders = ['F', 'M'];
?>

<div class="familia">
    <form class="" id='register_family' name='register_family' method="post" action="<?php if (isset($config['baseUrl'])) echo '//' . $config['baseUrl']; ?>/api/family_post.php" novalidate>
        
        <fieldset>
            <h3>Família <!--<span> - Informação para sugestão de prêmios</span>--></h3>

            <div class="linha-form">
                <label class=""> Criar novo familiar </label>
            </div>

            <div class="linha-form">
                <label for="kinship">Parentesco</label>
                <select id="kinship" name="kinship" class="">
                    <option value=""> </option>
                    <?php
                        $countKinships = count($kinships);
                        for ($i = 0; $i < $countKinships; $i++) {
                            echo '<option value="' . $kinships[$i] . '" >' . $kinships[$i] . '</option>';
                        }
                    ?>
                </select>
            </div>

            <div class="linha-form">
                <label for="name">Nome</label>
                <input type="text" value="<?php if (isset($name)) echo $name; ?>" class="" id="name" name="name">
            </div>

            <div class="linha-form">
                <label for="gender">Sexo</label>
                <select id="gender" name="gender" class="">
                    <option value=""> </option>
                    <option value="F" <?php if (isset($gender) && $gender === 'F') echo 'selected'; ?>>F</option>
                    <option value="M" <?php if (isset($gender) && $gender === 'M') echo 'selected'; ?>>M</option>
                </select>
            </div>

            <div class="linha-form">
                <label for="age">Idade</label>
                <input value="<?php if (isset($age)) echo $age; ?>" min="0" max="99" type="number" class="" name="age" id="age">
            </div>

            <button class="btn_prim btn_padrao" type="submit">Cadastrar familiar</button>

        </fieldset>
        <div class="familiares">
            <?php include_once __DIR__ . "/family_view.php"; ?>
        </div>
    </form>
</div>