$(document).ready(function() {
    $(".deactivate").on("click", function() {
        let idRealty = $(this).data("id");

        Swal.fire({
            title: "Tem certeza?",
            text: "Você realmente deseja desativar este imóvel?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sim, desativar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {

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
                                window.location.href = wwwroot + 'dashboard';
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
            }
        });
    });

    $(".active").click(function() {
        let realtyId = $(this).data("id");

        Swal.fire({
            title: "Ativar imóvel?",
            text: "Deseja ativar este imóvel?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sim, ativar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {

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
                                window.location.href = wwwroot + 'dashboard';
                            });
                        } else {
                                Swal.fire({
                                title: 'Erro',
                                text : result.error,
                                icon : 'error'
                            });
                        }
                    }
                );
            }
        });
    });

    $(".highlights").click(function() {
        let realtyId = $(this).data("id");
        
        Swal.fire({
            title: 'Destacar Imóvel?',
            text : 'Você deseja destacar este imóvel?',
            icon : 'question',
            showCancelButton : true,
            confirmButtonText: 'Sim, destacar',
            cancelButtonText : 'Cancelar'
        }).then((result) => {
            if(result.isConfirmed) {
                $.post(
                    wwwroot + 'dashboard/highlightsProperty',
                    { id: realtyId },
                    function(result) {
                        if(result.status == 'success') {
                            Swal.fire({
                                title: 'Imóvel destacado!',
                                text : 'Imóvel destacado com sucesso!',
                                icon : 'success'
                            }).then(() => {
                                window.location.href = wwwroot + 'dashboard';
                            });
                        } else {
                                Swal.fire({
                                title: 'Erro',
                                text : result.error,
                                icon : 'error'
                            });
                        }
                    }
            );
            }
        });
    });

    $(".remove_highlights").click(function() {
        let realtyId = $(this).data("id");
        
        Swal.fire({
            title: 'Remover Destaque Deste Imóvel?',
            text : 'Você deseja remover o destaque deste imóvel?',
            icon : 'question',
            showCancelButton : true,
            confirmButtonText: 'Sim, remover destaque',
            cancelButtonText : 'Cancelar'
        }).then((result) => {
            if(result.isConfirmed) {
                $.post(
                    wwwroot + 'dashboard/removeHighlightsProperty',
                    { id: realtyId },
                    function(result) {
                        if(result.status == 'success') {
                            Swal.fire({
                                title: 'Imóvel destacado!',
                                text : 'Imóvel destacado com sucesso!',
                                icon : 'success'
                            }).then(() => {
                                window.location.href = wwwroot + 'dashboard';
                            });
                        } else {
                                Swal.fire({
                                title: 'Erro',
                                text : result.error,
                                icon : 'error'
                            });
                        }
                    }
            );
            }
        });
    });

    $(".edit").click(function() {
        let realtyId = $(this).data("id");
        window.location.href = wwwroot + "edit/" + realtyId;
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
