$(document).ready(function() {
    const WWWROOT = "http://localhost:8080/";
    const ROUTE   = "resetPassword";
    let form = $("#frmz_resetPassword");

    form.submit(function(e) {
        e.preventDefault();

        let formSerialize = form.serialize();
        
        $.post(
            WWWROOT + ROUTE, formSerialize, function(response) {
                console.log(response);
                if(response.status === 'success'){
                    Swal.fire('Sucesso', response.message, 'success');
                    form[0].reset();
                } else {
                    Swal.fire('Erro', response.message, 'error');
                }
            }, 'json'
        );
    });
});
