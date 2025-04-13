<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Imóvel</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
    }

    body {
      background-color: #f0f2f5;
      padding: 40px 20px;
      display: flex;
      justify-content: center;
    }

    .form-container {
      background: #fff;
      padding: 30px 40px;
      border-radius: 16px;
      max-width: 960px;
      width: 100%;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #222;
    }

    .section {
      margin-bottom: 40px;
      border: 1px solid #eee;
      border-radius: 12px;
      padding: 25px;
      background-color: #fafafa;
    }

    .section h3 {
      font-size: 18px;
      color: #444;
      margin-bottom: 20px;
      border-left: 4px solid #0077cc;
      padding-left: 10px;
    }

    .grid {
      display: grid;
      gap: 20px;
    }

    .grid-2 {
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    }

    .form-group {
      display: flex;
      flex-direction: column;
    }

    label {
      margin-bottom: 6px;
      font-size: 14px;
      color: #333;
    }

    input,
    select,
    textarea {
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-size: 15px;
      background-color: #fff;
      transition: border 0.3s ease;
    }

    input:focus,
    select:focus,
    textarea:focus {
      outline: none;
      border-color: #0077cc;
      background: #fdfdfd;
    }

    textarea {
      resize: vertical;
      min-height: 80px;
    }

    .optional {
      color: #888;
      font-size: 12px;
      margin-left: 6px;
    }

    button {
      background-color: #0077cc;
      color: white;
      padding: 15px;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      width: 100%;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background-color: #005fa3;
    }
  </style>
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
            <label for="type">Tipo</label>
            <select id="type" name="type">
              <option value="">Selecione</option>
              <option value="casa" <?= old('type') == 'casa' ? 'selected' : '' ?>>Casa</option>
              <option value="apartamento" <?= old('type') == 'apartamento' ? 'selected' : '' ?>>Apartamento</option>
              <option value="terreno" <?= old('type') == 'terreno' ? 'selected' : '' ?>>Terreno</option>
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
            <label for="address">Endereço</label>
            <input type="text" id="address" name="address">
          </div>
          <div class="form-group">
            <label for="neighborhood">Bairro</label>
            <input type="text" id="neighborhood" name="neighborhood">
          </div>
          <div class="form-group">
            <label for="city">Cidade</label>
            <input type="text" id="city" name="city">
          </div>
          <div class="form-group">
            <label for="state">Estado</label>
            <select id="state" name="state">
              <option value="">Selecione</option>
              <option value="PR">Paraná</option>
              <option value="SP">São Paulo</option>
              <option value="RJ">Rio de Janeiro</option>
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