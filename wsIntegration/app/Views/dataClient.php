<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Dados</title>
    <link rel="stylesheet" href="<?= base_url('Styles/styleDataClient.css'); ?>">
</head>
<body>

<div class="sidebar">
        <div class="logo">
            <h1>Ws Integrações</h1>
        </div>
        <div class="greeting">
            Olá, <?= $infoClients["nome"] ?>
        </div><br>
        <nav class="menu">
            <h2>Menu</h2>
            <ul class="menu-list">
                <li><a href="<?= site_url('/dataClient') ?>" class="menu-item"><i class="fas fa-database"></i> Dados</a></li>
                <li><a href="<?= site_url('/cadastrarImovel') ?>" class="menu-item"><i class="fas fa-stethoscope"></i>Cadastrar imoveis</a></li>
                <li><a href="<?= site_url('/') ?>" class="menu-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>
    </div>
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

</body>
</html>
