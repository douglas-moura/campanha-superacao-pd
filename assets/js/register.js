jQuery.validator.addMethod("cepValidate", function (value, element) {
    return this.optional(element) || /\d{5}-?\d{3}/.test(value);
}, "Coloque um CEP válido");

jQuery.validator.addMethod("phoneValidate", function (value, element) {
    return this.optional(element) || /[0-9\(\) -]+/.test(value);
}, "Coloque um Celular válido");

jQuery.validator.addMethod("dateValidate", function (value, element) {
    return this.optional(element) || /[0-3][0-9]\/[0-1][0-9]\/\d{4}/.test(value);
}, "Coloque uma data válida");


$(function () {

    $("#register_address").validate({
        rules: {
            postalCode: { cepValidate: true },
            street: { required: true },
            city: { required: true },
            region: { required: true },
            number: { required: true }
        },
        messages: {
            postalCode: "Coloque um CEP válido",
            street: "Coloque um endereço válido",
            city: "Coloque uma cidade válida",
            region: "Coloque um estado válido",
            number: "Verifique o número"
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    $("#register_family").validate({
        rules: {
            name: { required: true },
            kinship: { required: true },
            age: { required: true },
            gender: { required: true }
        },
        messages: {
            name: "Coloque um nome válido",
            kinship: "Coloque um parentesco válido",
            age: "Coloque uma idade válida",
            gender: "Coloque um genero válido"
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    $("#register_profile").validate({
        rules: {
            nameu: { required: true },
            phone: { phoneValidate: true },
            birthday: { dateValidate: true },
            alias: { required: true },
            password: { minlength: 6 },
            password_confirm: {
                required: true,
                equalTo: "#password"
            }
        },
        messages: {
            nameu: "Coloque um nome válido",
            phone: "Coloque um celular válido",
            birthday: "Coloque uma data válida",
            alias: "Coloque um apelido válido",
            password: "A senha deve ter pelo menos 6 caracteres",
            password_confirm: "Deve ser igual a senha"
        },
        submitHandler: function (form) {
            form.submit();
        }
    });


});

jQuery('input[name="cpf"]').maskx({ maskx: 'cpf' });

jQuery('input[name="postalCode"]').maskx({ maskx: 'cep' });

jQuery('input[name="birthday"]').maskx({ maskx: 'dateBR' });

jQuery('input[name="phone"]').maskx({ maskx: 'phone' });

var isSameNumber = function (cpf) {
    var sameNumber = [];
    for (var i = 0; i < 10; i++) {
        sameNumber.push(Array(12).join('' + i))
    }
    return sameNumber.indexOf(cpf) > -1
}

var setChilds = $('#children')

setChilds.on('change', function () {
    for (var i = 1; i <= 5; i++) {
        if (i <= this.value) {
            $('#children' + i).show();
        } else {
            $('#children' + i).hide();
        }
    }
});


var showFormAddres = function () {
    $('.addres-view').hide();
    $('.addres-form').show();
}

var showFormProfile = function () {
    $('.profile-view').hide();
    $('.profile-form').show();
}

var showPace = function () {
    $('.pace').show();
}

var hidePace = function () {
    $('.pace').hide();
}

var removeFamily = function (familyId) {
    var deleteFamily = 'http://' + (maxx.baseUrl || '/') + '/api/family_delete.php?family=' + familyId;
    location.href = deleteFamily;
}


// $(function() {

//   var postAddres = 'http://' + (maxx.baseUrl || '/') + '/api/address_post.php';
//   var postFamily = 'http://' + (maxx.baseUrl || '/') + '/api/family_post.php';
//   //
//   // $("#register_address").ajaxForm({
//   //   url: postAddres,
//   //   type: 'post',
//   //   beforeSubmit: function(){ showPace() },
//   //   success: function(){ hidePace() }
//   // });
//   //
//   // $("#register_family").ajaxForm({
//   //   url: postFamily,
//   //   type: 'post',
//   //   beforeSubmit: function(){ showPace() },
//   //   success: function(){ hidePace() }
//   // });
//   //

// });
