<form class="form-register-address" id='register_address' name='register_address' method="post" action="<?php if (isset($config['baseUrl'])) echo '//' . $config['baseUrl']; ?>/api/address_post.php" novalidate>
    <input type="hidden" value="<?php if (isset($addressId)) echo $addressId; ?>" id="addressId" name="addressId" />

    <fieldset>
        <h3>Editar Endereço</h3>

        <div class="linha-form">
            <div class="">
                <label class="" for="postalCode">CEP</label>
                <input value="<?php if (isset($postalCode)) echo $postalCode; ?>" class="" id="postalCode" name="postalCode" maxlength="9" pattern="(\d{5}-\d{3})" placeholder="_____-___" required type="tel">
            </div>
            <span class="">
                <a href="#" class="form-address-help-link" onclick="window.open('http://www.buscacep.correios.com.br/sistemas/buscacep/', 'cep', 'width=600,height=500')"> Não sei meu cep</a>
            </span>
        </div>

        <div class="linha-form">
            <div class="">
                <label class="" for="street">Endereço</label>
                <input value="<?php if (isset($street)) echo $street; ?>" name="street" id="street" class="" required maxlength="100" type="text">
            </div>
            <div class="">
                <label class="" for="number">Número</label>
                <input value="<?php if (isset($number)) echo $number; ?>" name="number" id="number" class="" required maxlength="20" type="text">
            </div>
        </div>

        <div class="linha-form">
            <div class="">
                <label class="" for="district">Bairro</label>
                <input value="<?php if (isset($district)) echo $district; ?>" name="district" id="district" class="" maxlength="100" type="text">
            </div>

            <div class="">
                <label class="" for="complement">Complemento <span>(opcional)</span> </label>
                <input value="<?php if (isset($complement)) echo $complement; ?>" class="" name="complement" id="complement" placeholder="Ex: Apartamento, bloco" maxlength="50" type="text">
            </div>
        </div>

        <div class="linha-form">
            <div class="">
                <label class="" for="city">Cidade</label>
                <input value="<?php if (isset($city)) echo $city; ?>" name="city" id="city" class="" required maxlength="100" type="text">
            </div>

            <div class="">
                <label class="" for="region">UF</label>
                <select id="region" name="region" class="" required>
                    <option value="">UF</option>
                    <?php
                        foreach ($regions as $key => $value) {
                            $selected = (isset($region) && $value == $region) ? 'selected' : '';
                            echo "<option value='$value' $selected >$value</option>";
                        }
                    ?>
                </select>
            </div>

            <div class=" ">
                <label class="" for="reference">Ponto de referência <span>(opcional)</span> </label>
                <input value="<?php if (isset($reference)) echo $reference; ?>" class="" name="reference" id="reference" placeholder="Ex: Próximo à padaria" maxlength="50" type="text">
            </div>
        </div>

        <button class="btn_prim btn_padrao" type="submit">Atualizar Endereço</button>
    </fieldset>
</form>