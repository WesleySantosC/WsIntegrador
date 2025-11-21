$(document).ready(() => {
    let cpf_cnpj = $("#cpf_cnpj").text().trim();
    let phone    = $("#telefone").text().trim();
    let cep      = $("#cep").text().trim();


    let formatado = window.maskCPF(cpf_cnpj);
    $("#cpf_cnpj").text(formatado);

    let foneformatado = window.maskPhone(phone);
    $("#telefone").text(foneformatado);

    let cepformatado = window.maskCEP(cep);
    $("#cep").text(cepformatado);

    $("#logout").on("click", function() {
        $.post(
            wwwroot + 'login/logout', {}, function() {
                console.log("Sessão Destruida");
            }
        )
    });
});
