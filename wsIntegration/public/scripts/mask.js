window.maskCPF = function(cpf) {
    if (!cpf) {
        return "";
    } 

    cpf = cpf.replace(/\D/g, "");

    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
    cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2");

    return cpf;
};

window.maskPhone = function(phone) {
    if (!phone) {
        return "";
    } 

    phone = phone.replace(/\D/g, "");

    return phone.replace(/^(\d{2})(\d{5})(\d{4})$/, "($1) $2-$3");
};

window.maskCEP = function(cep) {
    if (!cep) {
        return "";
    } 

    cep = cep.replace(/\D/g, "");
    cep = cep.replace(/(\d{5})(\d{1,3})/, "$1-$2");

    return cep;
};

window.maskCoin = function(coin) {
    if (!coin) return "R$ ";

    coin = coin.replace("R$", "").trim();

    let value = coin.replace(/\D/g, "");

    if (value.length === 0) {
        return "R$ ";
    }

    value = value.replace(/(\d{2})$/, ",$1");
    value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");

    return "R$ " + value;
}

window.maskfootage = function(metragem) {
    if (!metragem) {
        return "";
    }

    let value = metragem.toString().replace(/\D/g, "");

    if (value.length === 0) {
        value = ""; 
    }

    value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
    value = value + " m²";

    return value;
}

window.unmaskValue = function(value) {
    if (!value) {
        return "";
    }
    // Remove todos os caracteres que não são dígitos.
    return value.toString().replace(/\D/g, ""); 
}