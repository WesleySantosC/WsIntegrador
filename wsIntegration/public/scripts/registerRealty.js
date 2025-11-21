$(document).ready(() => {
  let form = $("#form");
  let valueRealty = $("#value");
  let valueIPTU = $("#iptu");
  let valueCond = $("#condominium");
  let cep = $("#cep");
  let footage = $("#footage");
  let cep_val = cep.val();
  let address = $("#address");
  let neighborhood = $("#neighborhood");
  let complement = $("#complement");
  let city = $("#city");
  let state = $("#state");

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

  maskInputs(valueRealty, valueIPTU, valueCond, cep, footage);
  getAddress(cep_val, fieldsToFillIn);

  form.submit((e) => {
    e.preventDefault();
      let formData = new FormData(form[0]);
        $.ajax({
            url: wwwroot + "cadastrarImovel/validateField",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if(response.status == 'success') {
                    Swal.fire({
                        title: "Imóvel cadastrado com sucesso!",
                        text: "O imóvel foi cadastrado com sucesso!",
                        icon: response.status
                    }).then(function() {
                        window.location.href = wwwroot + 'dashboard'
                    });
                } else {
                    Swal.fire({
                      title: "Error!",
                      text: response.error,
                      icon: "error"
                    });
                }
            },
        });
      })

  $("#logout").on("click", function () {
    $.post(
      wwwroot + 'login/logout', {}, function () {
        console.log("Sessão Destruida");
      }
    )
  });
});

function maskInputs(valueRealty, valueIPTU, valueCond, cep, footage) {
  valueRealty.on('input', function () {
    $(this).val(window.maskCoin($(this).val()));
  });

  valueIPTU.on('input', function () {
    $(this).val(window.maskCoin($(this).val()));
  });

  valueCond.on('input', function () {
    $(this).val(window.maskCoin($(this).val()));
  });

  cep.on('input', function () {
    $(this).val(window.maskCEP($(this).val()));
  });

  footage.on('input', function () {
    $(this).val(window.maskfootage($(this).val()));
  });
}