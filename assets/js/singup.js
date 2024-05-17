jQuery.validator.addMethod("cpfValidate", function(value, element) {
    return this.optional(element) || isValidCpf(value);
}, "Coloque um CPF válido");

$(function() {
    $("#signin").validate({
        rules: {
            cpf: { cpfValidate: true },
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            cpf: "Coloque um CPF válido",
            email: "Coloque um e-mail válido"
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});

jQuery('input[name="cpf"]').maskx({maskx: 'cpf'});

var isSameNumber = function(cpf) {
    var sameNumber = [];
    for (var i = 0; i < 10; i++) {
        sameNumber.push(Array(12).join('' + i))
    }
    return sameNumber.indexOf(cpf) > -1
}

var checkDigit = function(cpf, base) {
    var add = 0,
    rev = 0;

    for (i = 0; i < base; i++) {
        add += parseInt(cpf.charAt(i)) * (base + 1 - i);
    }
    
    rev = 11 - (add % 11);
    
    if (rev === 10 || rev === 11) {
        rev = 0;
    }

    if (rev !== parseInt(cpf.charAt(base))){
        return false;
    }
    
    return true;
}

var isValidCpf = function(cpfInput) {
    var cpf = (cpfInput || '').replace(/\D+/g, '');

    if((cpf || '').length !== 11 || isSameNumber(cpf)) {
        return false;
    }

    return checkDigit(cpf, 9) && checkDigit(cpf, 10)
}
