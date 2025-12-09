window.getAddress = async (cep, fieldsToFillIn) => {

  cep = String(cep).replace(/\D/g, "");

  if (cep.length !== 8) {
    return "CEP inválido ou vazio!";
  }

  let address      = fieldsToFillIn[0];
  let neighborhood = fieldsToFillIn[1];
  let complement   = fieldsToFillIn[2];
  let city         = fieldsToFillIn[3];
  let state        = fieldsToFillIn[4];
  let uf           = fieldsToFillIn[5];

  const apiUrl = `https://viacep.com.br/ws/${cep}/json/`;
  const response = await fetch(apiUrl);
  const data = await response.json();

  address.val(data.logradouro);
  neighborhood.val(data.bairro);
  complement.val(data.complemento);
  city.val(data.localidade);
  state.val(data.estado);
  uf.val(data.uf);
};
