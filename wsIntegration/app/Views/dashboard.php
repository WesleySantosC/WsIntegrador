<link rel="stylesheet" href="<?= base_url('Styles/styleDashboard.css'); ?>">
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <h1>Ws Integrações</h1>
        </div>
        <div class="greeting">
            Olá, <?php print_r($infoClients[0]["nome"]) ?>
        </div>
        <nav class="menu">
            <h2>Menu</h2>
            <ul class="menu-list">
                <li><a href="<?= site_url('/dataClient') ?>" class="menu-item"><i class="fas fa-database"></i> Dados</a></li>
                <li><a href="<?= site_url('/cadastrarImovel') ?>" class="menu-item"><i class="fas fa-stethoscope"></i>Cadastrar Imoveis</a></li>
                <li><a href="<?= site_url('/generateLinkXml') ?>" class="menu-item"><i class="fas fa-stethoscope"></i>Gerar XML</a></li>
                <li><a href="<?= site_url('/') ?>" class="menu-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>
    </div>
    <div class="content">
        <div class="header-content">
            <h1>Bem-vindo ao Dashboard</h1>
        </div>
        <div class="dashboard-stats">
            <div class="card">
                <i class="fas fa-calendar-check"></i>
                <h3>Total de Imóveis</h3>
                <p>Quantidade: <?= $realtyCount->total_imoveis ?: "Nenhum Imóvel cadastrado" ?></p>
            </div>
            <div class="card">
                <i class="fas fa-chart-line"></i>
                <h3>Valor total em Imóveis</h3>
                <p>R$ <?= number_format($realtyValue->total_valor, 2, ",", ".") ?: "Nenhum valor encontrado!" ?></p>
            </div>
        </div>
    </div>
</body>
</html>
