<fieldset class="">
    <h3>Perfil</h3>
    <div>
        <p><?php if (isset($nameu)) echo $nameu . ' ' . $sobrenome; ?> <?php if (isset($alias)) echo "($alias)"; ?></p>
        <p><?php if (isset($birthday)) echo '<strong>Nasc.:</strong> ' . $birthday; ?></p>
        <p><?php if (isset($phone)) echo '<strong>Celular:</strong> ' . $phone; ?></p>
    </div>
    <a href="#register_profile" onclick="showFormProfile()">Editar</a>
</fieldset>