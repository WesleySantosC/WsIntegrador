<?= view('headerAdminClient'); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Dados</title>
    <link rel="stylesheet" href="<?= base_url('Styles/styleDataClient.css'); ?>">
    <script src="<?= base_url('scripts/DataClient.js'); ?>"></script>
</head>
<body>
    <div class="content">
        <div class="container">
            <div class="info-grid">
                <div class="info-item">
                    <span class="label">ID</span>
                    <span class="value" id="id"><?= $infoClients['id'] ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Nome</span>
                    <span class="value" id="nome"><?= $infoClients['nome'] ?></span>
                </div>
                <div class="info-item">
                    <span class="label">E-mail</span>
                    <span class="value" id="email"><?= $infoClients['email'] ?></span>
                </div>
                <div class="info-item">
                    <span class="label">CPF/CNPJ</span>
                    <span class="value" id="cpf_cnpj"><?= $infoClients['cpf_cnpj'] ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Telefone</span>
                    <span class="value" id="telefone"><?= $infoClients['telefone'] ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Cidade</span>
                    <span class="value" id="cidade"><?= $infoClients['cidade'] ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Estado</span>
                    <span class="value" id="estado"><?= $infoClients['estado'] ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Endereço</span>
                    <span class="value" id="endereco"><?= $infoClients['endereco'] ?></span>
                </div>
                <div class="info-item">
                    <span class="label">CEP</span>
                    <span class="value" id="cep"><?= $infoClients['cep'] ?></span>
                </div>
            </div>

            <div class="bottom-actions">
                <a href="<?= site_url('dashboard') ?>" class="back-link">Voltar ao Painel</a>
            </div>
        </div>
    </div>
</body>
</html>