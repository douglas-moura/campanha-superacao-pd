<?php
  		if (empty($_POST['nome'])) {
	  		echo '';
  		} else {
	 		$nome = $_POST['nome'];
	 		$cpf = $_POST['cpf'];
	 		$cargo = $_POST['cargo'];
	 		$email = $_POST['email_resp'];
	 		$tel = $_POST['phone'];
	 		$birthday = $_POST['birthday'];
	 		$password = $_POST['password'];
	 		 		
	 		$sql = "INSERT INTO users (email, cpf, name, type, phone, birthday, password) VALUES ('$email' , '$cpf', '$nome', '$cargo', '$tel', '$birthday', '$password')";
	 		
	 		$result = $db->query($sql); 
?>

<form class="form-signin2" id='signin' name='signin' method="post" novalidate>
    <fieldset>
 		<div class="form-group" >
			<label class="form-label" for="email" >Nome Completo</label>
			<input name="nome" id="email" class="form-control" title="" required placeholder="José da Silva" value="" type="email" />
		</div>
		
		<div class="form-group" >
			<label class="form-label" for="cpf">CPF</label>
			<input name="cpf" id="cpf" class="form-control" title="" required placeholder="___.___.___-__" value="" type="tel">
		</div>
		
		
		<div class="form-group" >
			<label class="form-label" for="email" >Cargo</label>
			<input name="cargo" id="email" class="form-control" title="" required placeholder="Ex.: Vendedor" value="" type="email" />
		</div>
				
		<div class="form-group" >
			<label class="form-label" for="email" >E-mail</label>
			<input name="email_resp" id="email" class="form-control" title="" required placeholder="seu.email@exemplo.com.br" value="" type="email" />
		</div>
				
		<div class="row">
			<div class="form-group col-xs-6">
				<label for="birthday" class="form-label">Data de nascimento</label>
				<input value="<?php if (isset($birthday)) echo $birthday; ?>" placeholder="__/__/____" name="birthday"  id="birthday" class="form-control " required maxlength="10" type="text">
			</div>

			<div class="form-group col-xs-6">
				<label for="phone" class="form-label">Celular</label>
				<input value="<?php if (isset($phone)) echo $phone; ?>" placeholder="(__) ____._____" name="phone"  id="phone" class="form-control "  required maxlength="15" type="text">
			</div>
		</div>
		
		<div class="row">
			<div class="form-group col-xs-6"  >
				<label class="form-label"  for="password" >Senha para troca de prêmios</label>
				<input name="password"  id="password" class="form-control " required maxlength="12" type="password">
			</div>

			<div class="form-group col-xs-6"  >
				<label class="form-label"  for="password-confirm" >Senha confirmação</label>
				<input name="password_confirm"  id="password_confirm" class="form-control " required maxlength="12" type="password">
			</div>
		</div>

        <button class="btn btn-lg btn-primary btn-block btn-login" type="submit">Atualizar perfil</button><br><br>
    </fieldset>
  </form>
