<?= view('headerAdminClient'); ?>
<link rel="stylesheet" href="<?= base_url('Styles/StyleRealty.css'); ?>">
<script src="<?= base_url("scripts/registerRealty.js") ?>"></script>
<script src="<?= base_url("scripts/api_cep.js") ?>"></script>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Imóvel</title>
</head>
<body>
  <div class="form-container">
    <form id="form" enctype="multipart/form-data">

      <!-- Seção 1 -->
      <div class="section">
        <h3>Informações do Imóvel</h3>
        <div class="grid grid-2">
          <div class="form-group">
            <label for="reference" class="group_label">Referencia</label>
            <input type="text" id="reference" name="reference" placeholder="Ex: ABC123">
          </div>
          <div class="form-group">
            <label for="type_realty" class="group_label">Tipo Imovel</label>
            <select id="type_realty" name="type_realty">
              <option value="">Selecione</option>
              <?php foreach ($listProperty as $property):?>
                <option value="<?= $property->id ?>"><?= $property->name ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="sale_type" class="group_label">Tipo Venda</label>
            <select name="sale_type" id="sale_type">
              <option value="">Selecione</option>
              <option value="Vende-se">Venda</option>
              <option value="Aluga-se">Alugar</option>
            </select>
          </div>
          <div class="form-group">
            <label for="value" class="group_label">Valor (R$)</label>
            <input type="text" id="value" name="value" placeholder="Ex: 450000">
          </div>
          <div class="form-group">
            <label for="iptu" class="group_label">IPTU (R$) <span class="optional">(opcional)</span></label>
            <input type="text" id="iptu" name="iptu" placeholder="Ex: 300">
          </div>
          <div class="form-group">
            <label for="condominium" class="group_label">Condomínio (R$) <span class="optional">(opcional)</span></label>
            <input type="text" id="condominium" name="condominium" placeholder="Ex: 300">
          </div>
          <div class="form-group">
            <label for="footage" class="group_label">Área total (m²)</label>
            <input type="text" id="footage" name="footage" value="<?= old('footage') ?>" placeholder="Ex: 120">
          </div>
        </div>
      </div>

      <!-- Seção 2 -->
      <div class="section">
        <h3>Localização</h3>
        <div class="grid grid-2">
          <div class="form-group">
            <label for="cep" class="group_label">CEP</label>
            <input type="text" id="cep" name="cep" placeholder="Ex: 00000-000" maxlength="9">
          </div>
          <div class="form-group">
            <label for="address" class="group_label">Endereço</label>
            <input type="text" id="address" name="address" placeholder="Ex: Endereço do imóvel">
          </div>
          <div class="form-group">
            <label for="neighborhood" class="group_label">Bairro</label>
            <input type="text" id="neighborhood" name="neighborhood" placeholder="Ex: Água Verde">
          </div>
          <div class="form-group">
            <label for="complement" class="group_label">Complemento</label>
            <input type="text" id="complement" name="complement" placeholder="Ex: Casa">
          </div>
          <div class="form-group">
            <label for="city" class="group_label">Cidade</label>
            <input type="text" id="city" name="city" placeholder="Ex: Curitiba" readonly>
          </div>
          <div class="form-group">
            <label for="state" class="group_label">Estado</label>
            <input type="text" id="state" name="state" placeholder="Ex: Paraná" readonly>
          </div>
        </div>
      </div>

      <!-- Seção 3 -->
      <div class="section">
        <h3>Detalhes do Imóvel</h3>
        <div class="grid grid-2">
          <div class="form-group">
            
            <label for="rooms" class="rooms">Quartos</label>
            <div class="counter">
              <button type="button" class="btn-minus" id="buttons">-</button>
              <input type="number" id="rooms" name="rooms" value="0" min="0">
              <button type="button" class="btn-plus" id="buttons">+</button>
            </div>

          </div>
          <div class="form-group">
            <label for="suites" class="suites">Suites</label>

            <div class="counter">
              <button type="button" class="btn-minus" id="buttons">-</button>
              <input type="number" id="suites" name="suites" value="0" min="0">
              <button type="button" class="btn-plus" id="buttons">+</button>
            </div>
          </div>
          
          <div class="form-group">
            <label for="bathrooms" class="bathrooms">Banheiros</label>
            <div class="counter">
              <button type="button" class="btn-minus" id="buttons">-</button>
              <input type="number" id="bathrooms" name="bathrooms" value="0" minlength="0">
              <button type="button" class="btn-plus" id="buttons">+</button>
            </div>
          </div>
          <div class="form-group">
            <label for="garage" class="garage">Vagas de garagem</label>
            <div class="counter">
              <button type="button" class="btn-minus" id="buttons">-</button>
              <input type="number" id="garage" name="garage" value="0" minlength="0">
              <button type="button" class="btn-plus" id="buttons">+</button>
            </div>
          </div>
        </div>
      </div>

      <div class="section">
        <h3>Imagens do Imóvel</h3>
        <div class="form-group">
          <label for="images" class="group_label">Selecione até 15 imagens</label>
          <input type="file" id="images" name="images[]" accept="image/*" multiple>
          <small class="optional">Apenas imagens (JPEG, PNG, etc.)</small>
        </div>
      </div>

      <!-- Seção 4 -->
      <div class="section">
        <h3>Informações adicionais</h3>
        <div class="grid grid-2">
          <div class="form-group" style="grid-column: span 2;">
            <label for="title" class="group_label">Título</label>
            <input type="text" id="title" name="title" value="<?= old('title') ?>" placeholder="Ex: Casa moderna com suíte">
          </div>
          <div class="form-group" style="grid-column: span 2;">
            <label for="description" class="group_label">Descrição</label>
            <textarea id="description" name="description" placeholder="Fale um pouco sobre o imóvel..."></textarea>
          </div>
        </div>
        <button type="submit">Cadastrar Imóvel</button>
      </div><br><br>

    </form>
  </div>
</body>
</html>