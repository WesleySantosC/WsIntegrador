$(document).ready(function() {
    $("#generateXMLClient").on("submit", function(e) {
        e.preventDefault();

        $.post( wwwroot + 'generateLinkXml/generate', {}, function(resposta) {
            if (resposta.status === 'success' && resposta.link) {
                Swal.fire({
                    title: 'XML Gerado!',
                    text: 'Clique em OK para abrir o arquivo.',
                    icon: 'success',
                    confirmButtonText: 'Abrir XML'
                }).then(() => {
                    window.open(resposta.link, '_blank');
                });
            } else {
                Swal.fire({
                    title: 'Erro!',
                    text: resposta.error,
                    icon: 'error'
                });
            }
        }, 'json'
        );
    });

    $("#copyBtn").click(() => {
        const input = $("#xmlLink")[0];

        input.select();
        document.execCommand("copy");

        $("#copyMsg").fadeIn();

        setTimeout(() => {
            $("#copyMsg").fadeOut();
        }, 1500);
    });


    $("#logout").on("click", function() {
        $.post(
            wwwroot + 'login/logout', {}, function() {
                console.log("Sessão Destruida");
            }
        )
    });
});
