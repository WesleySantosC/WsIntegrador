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
</head>

<body>
  <div class="form-container">
    <h2 class="title">Cadastro de Imóvel</h2>
    <form id="frmzDataRealty" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $infoRealty->id ?>">

      <!-- Seção 1: Informações do Imóvel -->
      <div class="section">
        <h3>Informações do Imóvel</h3>
        <div class="grid grid-2">
          <div class="form-group">
            <label for="type_realty">Tipo Imóvel</label>
            <select id="type_realty" name="type_realty">
              <option value="">Selecione</option>
              <option value="casa" <?= (isset($infoRealty->type_realty) && $infoRealty->type_realty == 'casa') ? 'selected' : (old('type_realty') == 'casa' ? 'selected' : '') ?>>Casa</option>
              <option value="apartamento" <?= (isset($infoRealty->type_realty) && $infoRealty->type_realty == 'apartamento') ? 'selected' : (old('type_realty') == 'apartamento' ? 'selected' : '') ?>>Apartamento</option>
              <option value="terreno" <?= (isset($infoRealty->type_realty) && $infoRealty->type_realty == 'terreno') ? 'selected' : (old('type_realty') == 'terreno' ? 'selected' : '') ?>>Terreno</option>
            </select>
          </div>

          <div class="form-group">
            <label for="sale_type">Tipo Venda</label>
            <select id="sale_type" name="sale_type">
              <option value="">Selecione</option>
              <option value="vende-se" <?= (isset($infoRealty->sale_type) && $infoRealty->sale_type == 'vende-se') ? 'selected' : (old('sale_type') == 'vende-se' ? 'selected' : '') ?>>Venda</option>
              <option value="aluga-se" <?= (isset($infoRealty->sale_type) && $infoRealty->sale_type == 'aluga-se') ? 'selected' : (old('sale_type') == 'aluga-se' ? 'selected' : '') ?>>Alugar</option>
            </select>
          </div>

          <div class="form-group">
            <label for="value">Valor (R$)</label>
            <input type="text" id="value" name="value" value="<?= isset($infoRealty->value) ? number_format((float)$infoRealty->value, 2, ',', '.') : old('value') ?>" placeholder="Ex: 450.000,00">
          </div>

          <div class="form-group">
            <label for="iptu">IPTU (R$) <span class="optional">(opcional)</span></label>
            <input type="number" id="iptu" name="iptu" value="<?= isset($infoRealty->iptu) ? $infoRealty->iptu : old('iptu') ?>">
          </div>

          <div class="form-group">
            <label for="condominium">Condomínio (R$) <span class="optional">(opcional)</span></label>
            <input type="number" id="condominium" name="condominium" value="<?= isset($infoRealty->condominium) ? $infoRealty->condominium : old('condominium') ?>">
          </div>

          <div class="form-group">
            <label for="footage">Área total (m²)</label>
            <input type="text" id="footage" name="footage" value="<?= isset($infoRealty->footage) ? $infoRealty->footage : old('footage') ?>" placeholder="Ex: 120">
          </div>
        </div>
      </div>

      <!-- Seção 2: Localização -->
      <div class="section">
        <h3>Localização</h3>
        <div class="grid grid-2">
          <div class="form-group">
            <label for="address">Endereço</label>
            <input type="text" id="address" name="address" value="<?= isset($infoRealty->address) ? $infoRealty->address : old('address') ?>">
          </div>

          <div class="form-group">
            <label for="neighborhood">Bairro</label>
            <input type="text" id="neighborhood" name="neighborhood" value="<?= isset($infoRealty->neighborhood) ? $infoRealty->neighborhood : old('neighborhood') ?>">
          </div>

          <div class="form-group">
            <label for="city">Cidade</label>
            <input type="text" id="city" name="city" value="<?= isset($infoRealty->city) ? $infoRealty->city : old('city') ?>">
          </div>

          <div class="form-group">
            <label for="state">Estado</label>
            <select id="state" name="state">
              <option value="">Selecione</option>
              <option value="PR" <?= (isset($infoRealty->state) && $infoRealty->state == 'PR') ? 'selected' : (old('state') == 'PR' ? 'selected' : '') ?>>Paraná</option>
              <option value="SP" <?= (isset($infoRealty->state) && $infoRealty->state == 'SP') ? 'selected' : (old('state') == 'SP' ? 'selected' : '') ?>>São Paulo</option>
              <option value="RJ" <?= (isset($infoRealty->state) && $infoRealty->state == 'RJ') ? 'selected' : (old('state') == 'RJ' ? 'selected' : '') ?>>Rio de Janeiro</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Seção 3: Detalhes do Imóvel -->
      <div class="section">
        <h3>Detalhes do Imóvel</h3>
        <div class="grid grid-2">
          <div class="form-group">
            <label for="rooms">Quartos</label>
            <input type="number" id="rooms" name="rooms" value="<?= isset($infoRealty->rooms) ? $infoRealty->rooms : old('rooms') ?>">
          </div>

          <div class="form-group">
            <label for="bathrooms">Banheiros</label>
            <input type="number" id="bathrooms" name="bathrooms" value="<?= isset($infoRealty->bathrooms) ? $infoRealty->bathrooms : old('bathrooms') ?>">
          </div>

          <div class="form-group">
            <label for="garage">Vagas de garagem</label>
            <input type="number" id="garage" name="garage" value="<?= isset($infoRealty->garage) ? $infoRealty->garage : old('garage') ?>">
          </div>

          <div class="form-group">
            <label for="suites">Suítes</label>
            <input type="number" id="suites" name="suites" value="<?= isset($infoRealty->suites) ? $infoRealty->suites : old('suites') ?>">
          </div>
        </div>
      </div>

      <!-- Seção 4: Imagens -->
      <div class="section">
        <h3>Imagens do Imóvel</h3>
        <div class="form-group">
          <label for="images">Selecione até 15 imagens</label>
          <input type="file" id="images" name="images[]" accept="image/*" multiple>
          <small class="optional">Apenas imagens (JPEG, PNG, etc.)</small>
        </div>

        <?php if (isset($infoRealty->imagens) && !empty($infoRealty->imagens)): ?>
          <div class="preview-images" style="margin-top: 10px;">
            <?php
            $images = is_string($infoRealty->imagens) ? json_decode($infoRealty->imagens, true) : $infoRealty->imagens;
            if (!empty($images)) {
              foreach ($images as $img): ?>
                <img src="<?= base_url(trim($img)) ?>" alt="Imagem do imóvel" style="width:100px; margin-right:5px; margin-bottom:5px;">
            <?php endforeach; } ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- Seção 5: Informações adicionais -->
      <div class="section">
        <h3>Informações adicionais</h3>
        <div class="grid grid-2">
          <div class="form-group" style="grid-column: span 2;">
            <label for="title">Título</label>
            <input type="text" id="title" name="title" value="<?= isset($infoRealty->title) ? $infoRealty->title : old('title') ?>" placeholder="Ex: Casa moderna com suíte">
          </div>

          <div class="form-group" style="grid-column: span 2;">
            <label for="description">Descrição</label>
            <textarea id="description" name="description" placeholder="Fale um pouco sobre o imóvel..."><?= isset($infoRealty->description) ? $infoRealty->description : old('description') ?></textarea>
          </div>
        </div>
      </div>

      <button type="submit" id="save_update">Salvar Alterações</button>
    </form>
  </div>
</body>
</html>
