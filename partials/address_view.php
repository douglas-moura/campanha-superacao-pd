<fieldset class="addres-view">
	<h3>Endereço Residêncial</h3>
	<address>
		<p><?php if (isset($street)) echo $street; ?>, <?php if (isset($number)) echo $number; ?><span ng-if="address.complement"><?php if (isset($complement)) echo ' - ' . $complement; ?></span></p>		
		<p><?php if (isset($district)) echo '<strong>Bairro:</strong> ' . $district; ?></p>
		<p><?php if (isset($postalCode)) echo '<strong>CEP:</strong> ' . $postalCode; ?></p>
		<p><?php if (isset($city)) echo '<strong>Cidade:</strong> ' . $city; ?>, <?php if (isset($region)) echo $region; ?></p>
		<p><?php if (isset($reference)) echo '<strong>Referência:</strong> ' . $reference; ?></p>
	</address>
	<a href="#register_address" onclick="showFormAddres()"> Editar</a>
</fieldset>