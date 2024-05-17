<form class="form-register-profile" id='register_profile' name='register_profile' method="post" action="<?php if (isset($config['baseUrl'])) echo '//' . $config['baseUrl']; ?>/api/profile_post.php" novalidate>
    <fieldset>
        <h3>Editar perfil </h3>
        <div class="form-perfil">
            <div class="linha-form">
                <label class="" for="nameu">Nome</label>
                <input value="<?php if (isset($nameu)) echo $nameu; ?>" name="nameu" id="nameu" class="" required maxlength="100" type="text">
            </div>
        </div>
        <div class="form-perfil">
            <div class="linha-form">
                <label class="form-label" for="alias">Apelido <span>Nome que gosta de ser chamado</span></label>
                <input value="<?php if (isset($alias)) echo $alias; ?>" name="alias" id="alias" class="form-control " required maxlength="100" type="text">
            </div>
        </div>

        <div class="form-perfil">
            <div class="linha-form">
                <label for="birthday" class="form-label">Data de nascimento</label>
                <input value="<?php if (isset($birthday)) echo $birthday; ?>" placeholder="__/__/____" name="birthday" id="birthday" class="form-control " required maxlength="10" type="text">
            </div>
            <div class="linha-form">
                <label for="phone" class="form-label">Celular</label>
                <input value="<?php if (isset($phone)) echo $phone; ?>" placeholder="(__) ____._____" name="phone" id="phone" class="form-control " required maxlength="15" type="text">
            </div>
        </div>

        <div class="form-perfil">
            <div class="linha-form">
                <label class="form-label" for="password">Senha para troca de prêmios</label>
                <input name="password" id="password" class="form-control " required maxlength="12" type="password">
            </div>
            <div class="linha-form">
                <label class="form-label" for="password-confirm">Senha confirmação</label>
                <input name="password_confirm" id="password_confirm" class="form-control " required maxlength="12" type="password">
            </div>
        </div>

        <button class="btn_prim btn_padrao" type="submit">Atualizar perfil</button>
    </fieldset>
</form>