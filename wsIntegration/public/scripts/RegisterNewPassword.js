$(document).ready(function() {
    const ROUTE   = "resetPassword";
    let form      = $("#frmz_resetPassword");
    let wwwroot   = 'http://localhost:8080/';

    form.submit(function(e) {
        e.preventDefault();

        let formSerialize = form.serialize();

        Swal.fire({
            title: 'Enviando...',
            text: 'Aguarde enquanto processamos sua solicitação.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.post(
            wwwroot + ROUTE, formSerialize, function(response) {
                console.log(response);
                if(response.status === 'success'){
                    Swal.fire({
                        title: 'Sucesso', 
                        text : response.message, 
                        icon :'success'
                    }).then(function() {
                        window.location.href= wwwroot + "/login";
                    });
                    form[0].reset();
                } else {
                    Swal.fire({
                        title:'Erro', 
                        tetx :'Entre em contato com a nossa equipe, para que possamos ajudar!', 
                        icon :'error'
                });
                }
            }, 'json'
        ).fail(function(jqXHR, textStatus, errorThrown) {
            Swal.fire(
                'Erro na Conexão',
                'Não foi possível completar a requisição. Tente novamente.',
                'error'
            );
        });
    });
});
