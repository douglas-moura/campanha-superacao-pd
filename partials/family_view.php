<?php
    $_familyCount = count($_family);
    if ($_familyCount > 0) {
        for ($i = 0; $i < $_familyCount; $i++) {
?>
    <div class="lista-familia">
        <strong><?php if (isset($_family[$i]['name'])) echo $_family[$i]['name']; ?></strong>
        <?php if (isset($_family[$i]['kinship'])) echo '(' . $_family[$i]['kinship'] . ')'; ?><br />
        <?php if (isset($_family[$i]['age'])) echo 'Idade: ' . $_family[$i]['age']; ?> -
        <?php if (isset($_family[$i]['gender'])) echo 'Genero: ' . $_family[$i]['gender']; ?><br />
        <a href="#" onclick="removeFamily(<?php if (isset($_family[$i]['id'])) echo $_family[$i]['id']; ?>)"> Remover </a>
    </div>
<?php
        }
    }
?>