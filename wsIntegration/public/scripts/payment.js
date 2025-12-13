$(document).ready(function() {

    let phone    = $("#telefone");
    let cpf_cnpj = $("#cpfCnpj");
    let cep      = $("#cep");

    maskInputs(phone, cpf_cnpj, cep);

    $("#frm_payment").on("submit", function(e) {
        e.preventDefault();

        const WWWROOT = 'http://localhost:8080/';
        const ROUTE   = 'payment/returnStatus';
        let formData  = $(this).serialize();

        Swal.fire({
            title: 'Processando...',
            text: 'Aguarde enquanto finalizamos seu cadastro.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
            }
        });

        $.post(WWWROOT + ROUTE, formData, function(response) {
            if(response.status === 'success') {
                Swal.fire({
                    title: "Cadastro Finalizado!",
                    text : "Seu cadastro foi finalizado",
                    icon : 'success'
                }).then(() => {
                    window.location.href=WWWROOT + 'resetPassword'
                });
            } else {
                Swal.fire({
                    title: "Erro",
                    text : "Entre em contato com a nossa equipe, para que possamos ajudar!",
                    icon : "error"
                });
            }
        });
    });
});

function maskInputs(phone, cpf_cnpj, cep) {
    phone.on('input', function() {
        $(this).val(window.maskPhone($(this).val()));
    });
    cpf_cnpj.on('input', function() {
        $(this).val(window.maskCPF($(this).val()));
    });
    cep.on('input', function() {
        $(this).val(window.maskCEP($(this).val()));
    });
}
