$(document).ready(function () {

    let phone = $("#phone").val();

    $("#phone").on("keyup", function () {
        let value = $(this).val();
        $(this).val(window.maskPhone(value));
    });

    $("#phone").on("blur", function () {
        let value = $(this).val();
        $(this).val(window.maskPhone(value));
    });

    $("#send").on("click", function (e) {
        e.preventDefault();

        const ROUTE = 'contact/registerContact';
        var form = $('#frm_registerContact');
        var formData = form.serialize();

        $.post(
            wwwroot + ROUTE, formData, function (response) {
                if(response.status == 'success') {
                    Swal.fire({
                        title: 'Solicitação encaminhada!',
                        text: 'Sua solicitação foi encaminhada a um agente, em breve entraremos em contato!',
                        icon: 'success'
                    }).then(() => {
                        window.location.href= wwwroot + '/contact'
                    }); 
                } else{
                    Swal.fire({
                        title: 'Erro ao enviar solicitação!',
                        text: response.error,
                        icon: 'error'
                    })
                }
            }, 'json'
        );
    });
});