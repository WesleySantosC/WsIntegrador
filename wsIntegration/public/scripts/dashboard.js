$(document).ready(function() {
    const WWWROOT = 'http://localhost:8080/';

    $(".deactive").on("click", function() {
        let idRealty = $(this).data("id");

        $.post(
            WWWROOT + 'dashboard/desativaImovel',
            { id: idRealty },
            function(result) {
                console.log(result);
                if(result.status === 'success') {
                    Swal.fire({
                        title: 'Imóvel Desativado!',
                        text: 'O imóvel foi desativado!',
                        icon: 'success'
                    }).then(() => {
                        window.location.href=WWWROOT + 'dashboard'
                    });
                } else {
                    Swal.fire({
                        title: 'Erro!',
                        text: 'Não foi possível desativar o imóvel.',
                        icon: 'error'
                    });
                }
            },
            'json'
        );
    });
});
