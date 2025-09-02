<?= view('headerAdminClient'); ?>
<link rel="stylesheet" href="<?= base_url('Styles/StyleRealty.css'); ?>">
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Imóvel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  <div class="form-container">
    <h2>Cadastro de Imóvel</h2>
    <form method="post" action="<?= base_url('cadastrarImovel/validateField'); ?>" enctype="multipart/form-data">

      <!-- Seção 1 -->
      <div class="section">
        <h3>Informações do Imóvel</h3>
        <div class="grid grid-2">
          <div class="form-group">
            <label for="reference">Referencia</label>
            <input type="text" id="reference" name="reference" placeholder="Ex: ABC123">
          </div>
          <div class="form-group">
            <label for="type_realty">Tipo Imovel</label>
            <select id="type_realty" name="type_realty">
              <option value="">Selecione</option>
              <?php foreach ($listProperty as $property):?>
                <option value="<?= $property->id ?>"><?= $property->name ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="sale_type">Tipo Venda</label>
            <select name="sale_type" id="sale_type">
              <option value="">Selecione</option>
              <option value="vende-se">Venda</option>
              <option value="aluga-se">Alugar</option>
            </select>
          </div>
          <div class="form-group">
            <label for="value">Valor (R$)</label>
            <input type="number" id="value" name="value" placeholder="Ex: 450000">
          </div>
          <div class="form-group">
            <label for="iptu">IPTU (R$) <span class="optional">(opcional)</span></label>
            <input type="number" id="iptu" name="iptu">
          </div>
          <div class="form-group">
            <label for="condominium">Condomínio (R$) <span class="optional">(opcional)</span></label>
            <input type="number" id="condominium" name="condominium">
          </div>
          <div class="form-group">
            <label for="footage">Área total (m²)</label>
            <input type="number" id="footage" name="footage" value="<?= old('footage') ?>" placeholder="Ex: 120">
          </div>
        </div>
      </div>

      <!-- Seção 2 -->
      <div class="section">
        <h3>Localização</h3>
        <div class="grid grid-2">
          <div class="form-group">
            <label for="cep">CEP</label>
            <input type="text" id="cep" name="cep">
          </div>
          <div class="form-group">
            <label for="address">Endereço</label>
            <input type="text" id="address" name="address">
          </div>
          <div class="form-group">
            <label for="neighborhood">Bairro</label>
            <input type="text" id="neighborhood" name="neighborhood">
          </div>
          <div class="form-group">
            <label for="complement">Complemento</label>
            <input type="text" id="complement" name="complement">
          </div>
          <div class="form-group">
            <label for="city">Cidade</label>
            <select name="city" id="city">
              <option value="">Selecione</option>
              <?php foreach ($cities as $city): ?>
                <option value="<?= $city->id ?>"><?= $city->name ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="state">Estado</label>
            <select id="state" name="state">
              <option value="">Selecione</option>
              <?php foreach ($states as $state): ?>
                <option value="<?= $state->id ?>"><?= $state->code ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>

      <!-- Seção 3 -->
      <div class="section">
        <h3>Detalhes do Imóvel</h3>
        <div class="grid grid-2">
          <div class="form-group">
            <label for="rooms">Quartos</label>
            <input type="number" id="rooms" name="rooms">
          </div>
          <div class="form-group">
            <label for="suites">Suites</label>
            <input type="suites" id="suites" name="suites">
          </div>
          <div class="form-group">
            <label for="bathrooms">Banheiros</label>
            <input type="number" id="bathrooms" name="bathrooms">
          </div>
          <div class="form-group">
            <label for="garage">Vagas de garagem</label>
            <input type="number" id="garage" name="garage">
          </div>
        </div>
      </div>

      <div class="section">
        <h3>Imagens do Imóvel</h3>
        <div class="form-group">
          <label for="images">Selecione até 15 imagens</label>
          <input type="file" id="images" name="images[]" accept="image/*" multiple>
          <small class="optional">Apenas imagens (JPEG, PNG, etc.)</small>
        </div>
      </div>

      <!-- Seção 4 -->
      <div class="section">
        <h3>Informações adicionais</h3>
        <div class="grid grid-2">
          <div class="form-group" style="grid-column: span 2;">
            <label for="title">Título</label>
            <input type="text" id="title" name="title" value="<?= old('title') ?>" placeholder="Ex: Casa moderna com suíte">
          </div>
          <div class="form-group" style="grid-column: span 2;">
            <label for="description">Descrição</label>
            <textarea id="description" name="description" placeholder="Fale um pouco sobre o imóvel..."></textarea>
          </div>
        </div>
      </div>


      <button type="submit">Cadastrar Imóvel</button>
    </form>
  </div>

  <!-- Modal de Erro -->
  <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="errorModalLabel">Erro</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <?= session()->getFlashdata('error') ?>
        </div>
      </div>
    </div>
  </div>

  <?php if (session()->getFlashdata('error')): ?>
    <script src="<?= base_url('scripts/modalError.js') ?>"></script>
  <?php endif; ?>
</body>
</html>