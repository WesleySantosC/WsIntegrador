<?= view('headerAdminClient'); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Dados</title>
    <link rel="stylesheet" href="<?= base_url('Styles/styleDataClient.css'); ?>">
</head>
<body>
    <div class="content">
        <div class="header-content">
            <h1>Meus Dados</h1>
        </div>

        <div class="container">
            <div class="info-grid">
                <div class="info-item">
                    <span class="label">Nome</span>
                    <span class="value"><?= $infoClients['nome'] ?></span>
                </div>
                <div class="info-item">
                    <span class="label">E-mail</span>
                    <span class="value"><?= $infoClients['email'] ?></span>
                </div>
            </div>

            <div class="bottom-actions">
                <a href="<?= site_url('dashboard') ?>" class="back-link">Voltar ao Painel</a>
            </div>
        </div>
    </div>
</body>
</html>