$(document).ready(function() {
    let form = $("#generateXMLClient");

    $("#generateXMLClient").on("submit", function(e) {
        let formSerialize = form.serialize();
        e.preventDefault();

        $.post(wwwroot + 'generateLinkXml/generate', formSerialize, function(resposta) {
            if (resposta.status === 'success' && resposta.link) {
                Swal.fire({
                    title: 'XML Gerado!',
                    text: 'Clique em OK para abrir o arquivo.',
                    icon: 'success',
                });

                $("#xmlLink").val(resposta.link);

                $("#copyMsg").fadeIn();
            } else {
                Swal.fire({
                    title: 'Erro!',
                    text: resposta.error,
                    icon: 'error'
                });
            }
        }, 'json');
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
        $.post(wwwroot + 'login/logout', {}, function() {
            console.log("Sessão Destruída");
        });
    });
});
