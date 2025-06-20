$(document).ready(function() {
    const WWWROOT = 'http://localhost:8080/';

    $("#generateXMLClient").on("submit", function(e) {
        e.preventDefault();

        $.post(WWWROOT + 'generateLinkXml/generate', {}, function(resposta) {
            if (resposta.status === 'success' && resposta.link) {
                Swal.fire({
                    title: 'XML Gerado!',
                    text: 'Clique em OK para abrir o arquivo.',
                    icon: 'success',
                    confirmButtonText: 'Abrir XML'
                }).then(() => {
                    window.location.href = resposta.link;
                });
            } else {
                Swal.fire({
                    title: 'Erro!',
                    text: 'Não foi possível gerar o XML.',
                    icon: 'error'
                });
            }
        }, 'json'
        );
    });
});
