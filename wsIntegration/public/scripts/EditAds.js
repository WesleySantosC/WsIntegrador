$(document).ready(function() {
    let form = $("#frmzDataRealty");
    const ROUTE = 'edit/editAds'; 
    const HOME  = wwwroot + 'index.php/dashboard';

    form.submit(function(e) {
        e.preventDefault();

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
                        title: 'Imovel Alterado!',
                        text : 'Imovel Alterado com Sucesso!',
                        icon : 'success'
                    }).then(function() {
                        window.location.href= HOME;
                    });
                } else {
                    Swal.fire({
                        title: 'Erro ao editar o imóvel!',
                        text : response.error,
                        icon : 'error'
                    });
                }
            }
        });
    });
});
