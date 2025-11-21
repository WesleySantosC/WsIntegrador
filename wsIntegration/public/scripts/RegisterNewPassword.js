$(document).ready(function() {
    const ROUTE   = "resetPassword";
    let form      = $("#frmz_resetPassword");
    let wwwroot   = 'http://localhost:8080/';

    form.submit(function(e) {
        e.preventDefault();

        let formSerialize = form.serialize();
        
        $.post(
            wwwroot + ROUTE, formSerialize, function(response) {
                console.log(response);
                if(response.status === 'success'){
                    Swal.fire(
                        'Sucesso', 
                        response.message, 
                        'success'
                    ).then(function() {
                        window.location.href= wwwroot + "/login";
                    });
                    form[0].reset();
                } else {
                    Swal.fire('Erro', response.message, 'error');
                }
            }, 'json'
        );
    });
});
