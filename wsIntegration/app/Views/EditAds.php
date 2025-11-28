<?= view('headerAdminClient'); ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Imóvel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('Styles/StyleRealty.css'); ?>">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url("scripts/EditAds.js"); ?>"></script>
  <script src="<?= base_url("scripts/api_cep.js") ?>"></script>
</head>

<body>
  <div class="form-container">
    <form id="frmzDataRealty" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $infoRealty->id ?>">

      <!-- Seção 1: Informações do Imóvel -->
      <div class="section">
        <h3>Informações do Imóvel</h3>
        <div class="grid grid-2">
          <div class="form-group">
            <label for="reference" class="group_label">Referencia</label>
            <input type="text" id="reference" name="reference" value="<?= isset($infoRealty->reference) ? $infoRealty->reference : old('reference') ?>" placeholder="Ex: ABC123">
          </div>
          
          <div class="form-group">
            <label for="type_realty" class="group_label">Tipo Imóvel</label>
            <select id="type_realty" name="type_realty">
              <option value="">Selecione</option>
              <?php foreach($listProperty as $property): ?>
                <option value="<?= $property->id ?>" <?= (isset($infoRealty->type_realty) && $infoRealty->type_realty == $property->id) ? 'selected' : '' ?>>
                  <?= $property->name ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label for="sale_type" class="group_label">Tipo Venda</label>
            <select id="sale_type" name="sale_type">
              <option value="">Selecione</option>
              <option value="vende-se" <?= (isset($infoRealty->sale_type) && $infoRealty->sale_type == 'vende-se') ? 'selected' : (old('sale_type') == 'vende-se' ? 'selected' : '') ?>>Venda</option>
              <option value="aluga-se" <?= (isset($infoRealty->sale_type) && $infoRealty->sale_type == 'aluga-se') ? 'selected' : (old('sale_type') == 'aluga-se' ? 'selected' : '') ?>>Alugar</option>
            </select>
          </div>

          <div class="form-group">
            <label for="value" class="group_label">Valor (R$)</label>
            <input type="text" id="value" name="value" value="<?= isset($infoRealty->value) ? number_format((float)$infoRealty->value, 2, ',', '.') : old('value') ?>" placeholder="Ex: 450.000,00">
          </div>

          <div class="form-group">
            <label for="iptu" class="group_label">IPTU (R$) <span class="optional">(opcional)</span></label>
            <input type="text" id="iptu" name="iptu" value="<?= isset($infoRealty->iptu) ? $infoRealty->iptu : old('iptu') ?>">
          </div>

          <div class="form-group">
            <label for="condominium" class="group_label">Condomínio (R$) <span class="optional">(opcional)</span></label>
            <input type="text" id="condominium" name="condominium" value="<?= isset($infoRealty->condominium) ? $infoRealty->condominium : old('condominium') ?>">
          </div>

          <div class="form-group">
            <label for="footage" class="group_label">Área total (m²)</label>
            <input type="text" id="footage" name="footage" value="<?= isset($infoRealty->footage) ? $infoRealty->footage : old('footage') ?>" placeholder="Ex: 120">
          </div>
        </div>
      </div>

      <!-- Seção 2: Localização -->
      <div class="section">
        <h3>Localização</h3>
        <div class="grid grid-2">
          <div class="form-group">
            <label for="address" class="group_label">CEP</label>
            <input type="text" id="cep" name="cep" value="<?= isset($infoRealty->cep) ? $infoRealty->cep : old('cep') ?>" maxlength="9">
          </div>

          <div class="form-group">
            <label for="address" class="group_label">Endereço</label>
            <input type="text" id="address" name="address" value="<?= isset($infoRealty->address) ? $infoRealty->address : old('address') ?>">
          </div>

          <div class="form-group">
            <label for="neighborhood" class="group_label">Bairro</label>
            <input type="text" id="neighborhood" name="neighborhood" value="<?= isset($infoRealty->neighborhood) ? $infoRealty->neighborhood : old('neighborhood') ?>">
          </div>

          <div class="form-group">
            <label for="complement" class="group_label">Complemento</label>
            <input type="text" id="complement" name="complement" value="<?= isset($infoRealty->complement) ? $infoRealty->complement : old('complement') ?>">
          </div>

        <div class="form-group">
          <label for="city" class="group_label">Cidade</label>
          <input type="text" id="city" name="city" placeholder="Ex: Curitiba" readonly>
        </div>



        <div class="form-group">
          <label for="state" class="group_label">Estado</label>
          <input type="text" name="state" id="state" placeholder="Ex: Paraná" readonly>
        </div>
      </div>

      <!-- Seção 3: Detalhes do Imóvel -->
      <div class="section">
        <h3>Detalhes do Imóvel</h3>
        <div class="grid grid-2">
          <div class="form-group">
            <label for="rooms" class="rooms" style="color: #f5f5f5;">Quartos</label>
            <div class="counter">
              <button type="button" class="btn-minus" id="buttons">-</button>
              <input type="number" id="rooms" name="rooms" value="<?= isset($infoRealty->rooms) ? $infoRealty->rooms : old('rooms') ?>" min="0">
              <button type="button" class="btn-plus" id="buttons">+</button>
            </div>

          </div>
          <div class="form-group">
            <label for="suites" class="suites" style="color: #f5f5f5;">Suites</label>

            <div class="counter">
              <button type="button" class="btn-minus" id="buttons">-</button>
              <input type="number" id="suites" name="suites" value="<?= isset($infoRealty->suites) ? $infoRealty->suites : old('suites') ?>" min="0">
              <button type="button" class="btn-plus" id="buttons">+</button>
            </div>
          </div>
          
          <div class="form-group">
            <label for="bathrooms" class="bathrooms" style="color: #f5f5f5;">Banheiros</label>
            <div class="counter">
              <button type="button" class="btn-minus" id="buttons">-</button>
              <input type="number" id="bathrooms" name="bathrooms" value="<?= isset($infoRealty->bathrooms) ? $infoRealty->bathrooms : old('bathrooms') ?>" minlength="0">
              <button type="button" class="btn-plus" id="buttons">+</button>
            </div>
          </div>
          <div class="form-group">
            <label for="garage" class="garage" style="color: #f5f5f5;">Vagas de garagem</label>
            <div class="counter">
              <button type="button" class="btn-minus" id="buttons">-</button>
              <input type="number" id="garage" name="garage" value="<?= isset($infoRealty->garage) ? $infoRealty->garage : old('garage') ?>" minlength="0">
              <button type="button" class="btn-plus" id="buttons">+</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Seção 4: Imagens -->
      <div class="section">
        <h3>Imagens do Imóvel</h3>
        <div class="form-group">
          <label for="images" class="group_label">Selecione até 15 imagens</label>
          <input type="file" id="images" name="images[]" accept="image/*" multiple>
          <small class="optional">Apenas imagens (JPEG, PNG, etc.)</small>
        </div>

        <input type="hidden" id="images_to_delete" name="images_to_delete" value="[]">
        <?php if (isset($infoRealty->imagens) && !empty($infoRealty->imagens)): ?>
        <div class="preview-images" style="margin-top: 10px;">
            <?php
            $images = is_string($infoRealty->imagens)
                ? json_decode($infoRealty->imagens, true)
                : $infoRealty->imagens;

            if (!empty($images)):
                foreach ($images as $img):
                    $imgPath = trim($img, " \t\n\r\0\x0B/");
            ?>
                <div class="image-wrapper" data-image="<?= esc($imgPath) ?>">
                    <img src="<?= base_url($imgPath) ?>" alt="Imagem do imóvel">
                    <span class="remove-btn" title="Remover imagem">✖</span>
                </div>
            <?php endforeach; endif; ?>
        </div>
        <?php endif; ?>
      </div>

      <!-- Seção 5: Informações adicionais -->
      <div class="section">
        <h3>Informações adicionais</h3>
        <div class="grid grid-2">
          <div class="form-group" style="grid-column: span 2;">
            <label for="title" class="group_label">Título</label>
            <input type="text" id="title" name="title" value="<?= isset($infoRealty->title) ? $infoRealty->title : old('title') ?>" placeholder="Ex: Casa moderna com suíte">
          </div>

          <div class="form-group" style="grid-column: span 2;">
            <label for="description" class="group_label">Descrição</label>
            <textarea id="description" name="description" placeholder="Fale um pouco sobre o imóvel..."><?= isset($infoRealty->description) ? $infoRealty->description : old('description') ?></textarea>
          </div>
        </div>
      </div>

      <button type="submit" id="save_update">Salvar Alterações</button>
    </form>
  </div>
</body>
</html>
