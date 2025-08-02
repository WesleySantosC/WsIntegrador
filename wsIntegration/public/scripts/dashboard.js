$(document).ready(function() {
    $(".deactivate").on("click", function() {
        let idRealty = $(this).data("id");

        $.post(
            wwwroot + 'dashboard/desativaImovel',
            { id: idRealty },
            function(result) {
                if(result.status === 'success') {
                    Swal.fire({
                        title: 'Imóvel Desativado!',
                        text: 'O imóvel foi desativado!',
                        icon: 'success'
                    }).then(() => {
                        window.location.href=wwwroot + 'dashboard'
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

    $(".active").click(function() {
        let realtyId = $(this).data("id");

        $.post(
            wwwroot + 'dashboard/activeRealty',
            { id: realtyId },
            function(result) {
                if(result.status == 'success') {
                    Swal.fire({
                        title: 'Imóvel Ativado!',
                        text : 'Imóvel ativado com sucesso!',
                        icon : 'success'
                    }).then(() => {
                        window.location.href=wwwroot + 'dashboard'
                    });;
                } else {
                        Swal.fire({
                        title: 'Error',
                        text : result.error,
                        icon : 'error'
                    });
                }
            }
        );
    });

    $("#openModal").click(function() {
        $("#modal").show();
    });

    $("#close").click(function() {
        $("#modal").hide();
    });

    $("#logout").on("click", function() {
        $.post(
            wwwroot + 'login/logout', {}, function() {
                console.log("Sessão Destruida");
            }
        )
    });

});
