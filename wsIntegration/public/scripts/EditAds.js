$(document).ready(function () {

    let imagesToDelete = [];

    $(document).on("click", ".remove-btn", function () {
        const wrapper = $(this).closest(".image-wrapper");

        const imgPath = wrapper.attr("data-image");

        if (!imgPath) return;

        const normalized = imgPath.replace(/^\/+/, '');

        if (!imagesToDelete.includes(normalized)) {
            imagesToDelete.push(normalized);
        }

        $("#images_to_delete").val(JSON.stringify(imagesToDelete));

        wrapper.fadeOut(180, function () {
            $(this).remove();
        });
    });

    function maskInputs(valueRealty, valueIPTU, valueCond, cep, footage) {
        const financialFields = [
            { field: valueRealty, maskFn: window.maskCoin },
            { field: valueIPTU, maskFn: window.maskCoin },
            { field: valueCond, maskFn: window.maskCoin },
            { field: footage, maskFn: window.maskfootage },
            { field: cep, maskFn: window.maskCEP }
        ];

        financialFields.forEach(item => {
            const field = item.field;
            const maskFn = item.maskFn;

            if (!field || field.length === 0) return;

            field.on('focus', function () {
                $(this).val(window.unmaskValue($(this).val()));
            });
            field.on('input', function () {
                $(this).val(maskFn($(this).val()));
            });
            field.on('blur', function () {
                $(this).val(maskFn($(this).val()));
            });
        });
    }

    let form = $("#frmzDataRealty");
    let valueRealty = $("#value");
    let valueIPTU = $("#iptu");
    let valueCond = $("#condominium");
    let cep = $("#cep");
    let footage = $("#footage");

    const ROUTE = 'edit/editAds';
    const HOME = wwwroot + 'index.php/dashboard';

    maskInputs(valueRealty, valueIPTU, valueCond, cep, footage);

    // CEP auto-fill
    cep.on("input", function () {
        let cleaned = $(this).val().replace(/\D/g, "");
        if (cleaned.length === 8) {
            getAddress(cleaned, [
                $("#address"),
                $("#neighborhood"),
                $("#complement"),
                $("#city"),
                $("#state")
            ]);
        }
    });

    form.submit(function (e) {
        e.preventDefault();

        // Remove máscaras antes de enviar
        if (valueRealty.length) valueRealty.val(window.unmaskValue(valueRealty.val()));
        if (valueIPTU.length) valueIPTU.val(window.unmaskValue(valueIPTU.val()));
        if (valueCond.length) valueCond.val(window.unmaskValue(valueCond.val()));
        if (footage.length) footage.val(window.unmaskValue(footage.val()));
        if (cep.length) cep.val(window.unmaskValue(cep.val()));

        $("#images_to_delete").val(JSON.stringify(imagesToDelete));

        let formData = new FormData(form[0]);

        $.ajax({
            url: wwwroot + ROUTE,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        title: 'Imóvel Alterado!',
                        text: 'Imóvel alterado com sucesso!',
                        icon: 'success'
                    }).then(() => window.location.href = HOME);
                } else {
                    Swal.fire({
                        title: 'Erro!',
                        text: response.error,
                        icon: 'error'
                    });
                }
            },
            error: function () {
                Swal.fire("Erro", "Não foi possível enviar o formulário.", "error");
            }
        });
    });

    $("#logout").on("click", function () {
        $.post(wwwroot + 'login/logout', {}, function () {
            console.log("Sessão destruída");
        });
    });

});