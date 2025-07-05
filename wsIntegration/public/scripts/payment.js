$(document).ready(function() {
    $("#frm_payment").on("submit", function(e) {
        e.preventDefault();

        const WWWROOT = 'http://localhost:8080/';
        const ROUTE   = 'payment/returnStatus';
        let formData  = $(this).serialize();

        $.post(WWWROOT + ROUTE, formData, function(response) {
            if(response.status === 'success') {
                Swal.fire({
                    title: "Cadastro Finalizado!",
                    text : "Seu cadastro foi finalizado",
                    icon : 'success'
                }).then(() => {
                    window.location.href=WWWROOT
                });
            } else {
                Swal.fire({
                    title: "Erro",
                    text : "Erro ao finalizar o seu cadastro!",
                    icon : "error"
                });
            }
        });
    });
});
