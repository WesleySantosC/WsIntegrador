function maskInputs(valueRealty, valueIPTU, valueCond, cep, footage) {
    
    const financialFields = [
        { field: valueRealty, maskFn: window.maskCoin },
        { field: valueIPTU,  maskFn: window.maskCoin },
        { field: valueCond,  maskFn: window.maskCoin },
        { field: footage,    maskFn: window.maskfootage },
        { field: cep,        maskFn: window.maskCEP }
    ];

    financialFields.forEach(item => {
        const field = item.field;
        const maskFn = item.maskFn;

        field.on('focus', function() {
            $(this).val(window.unmaskValue($(this).val()));
        });

        field.on('input', function() {
            $(this).val(maskFn($(this).val()));
        });

        field.on('blur', function() {
            $(this).val(maskFn($(this).val()));
        });
    });
}

$(document).ready(function() {
    let form           = $("#frmzDataRealty");
    let valueRealty    = $("#value");
    let valueIPTU      = $("#iptu");
    let valueCond      = $("#condominium");
    let cep            = $("#cep");
    let footage        = $("#footage");
    let cep_val        = cep.val();
    let address        = $("#address");
    let neighborhood   = $("#neighborhood");
    let complement     = $("#complement");
    let city           = $("#city");
    let state          = $("#state");

    let fieldsToFillIn = [
        address,
        neighborhood,
        complement,
        city,
        state
    ];

    cep.on("input", function () {
        let cleaned = $(this).val().replace(/\D/g, "");

        if (cleaned.length === 8) {
            getAddress(cleaned, fieldsToFillIn);
        }
    });

    const ROUTE = 'edit/editAds'; 
    const HOME  = wwwroot + 'index.php/dashboard';

    maskInputs(valueRealty, valueIPTU, valueCond, cep, footage);

    if (cep_val) {
        getAddress(cep_val, fieldsToFillIn);
    }

    valueRealty.blur();
    valueIPTU.blur();
    valueCond.blur();
    footage.blur();
    cep.blur();

    form.submit(function(e) {
        e.preventDefault();

        valueRealty.val(window.unmaskValue(valueRealty.val()));
        valueIPTU.val(window.unmaskValue(valueIPTU.val()));
        valueCond.val(window.unmaskValue(valueCond.val()));
        footage.val(window.unmaskValue(footage.val()));
        cep.val(window.unmaskValue(cep.val()));

        let formData = new FormData(form[0]);

        $.ajax({
            url: wwwroot + ROUTE,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if(response.status == 'success') {
                    Swal.fire({
                        title: 'Imóvel Alterado!',
                        text : 'Imóvel Alterado com Sucesso!',
                        icon : 'success'
                    }).then(function() {
                        window.location.href = HOME;
                    });
                } else {
                    Swal.fire({
                        title: 'Erro ao editar o imóvel!',
                        text : response.error,
                        icon : 'error'
                    });
                }
            },

            error: function() {
                valueRealty.blur();
                valueIPTU.blur();
                valueCond.blur();
                footage.blur();
                cep.blur();
            }
        });
    });

    $("#logout").on("click", function() {
        $.post(
            window.wwwroot + 'login/logout', {}, function() {
            console.log("Sessão Destruída");
            }
        )
    });
});