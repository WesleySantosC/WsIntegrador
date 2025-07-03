$(document).ready(function () {
    $("#send").on("click", function (e) {
        e.preventDefault();

        const WWWROOT = 'http://localhost:8080/';
        const ROUTE = 'contact/registerContact';
        var form = $('#frm_registerContact');
        var formData = form.serialize();

        $.post(
            WWWROOT + ROUTE, formData, function (response) {
                if(response.status == 'success') {
                    Swal.fire({
                        title: 'Solicitação encaminhada!',
                        text: 'Sua solicitação foi encaminhada a um agente, em breve entraremos em contato!',
                        icon: 'success'
                    }).then(() => {
                        window.location.href=WWWROOT + '/contact'
                    }); 
                } else{
                    Swal.fire({
                        title: 'Erro ao enviar solicitação!',
                        text: 'Ocorreu um erro inesperado! Tente novamente mais tarde!',
                        icon: 'error'
                    })
                }
            }, 'json'
        );
    });
});