<link rel="stylesheet" href="<?= base_url('Styles/styleDashboard.css'); ?>">
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= base_url('scripts/dashboard.js') ?>"></script>
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
                <li><a href="<?= site_url('/') ?>" class="menu-item" id="logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
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

    <?php foreach ($realtyClient as $realty): ?>
        <div class="realty-list">
            <div class="cardRealty">
                <h3><?= $realty->tipo_venda . " " . $realty->tipo . " com " . $realty->quantidade_quartos . " quartos " . " em " . $realty->cidade ?></h3>
                <p><?= $realty->descricao ?></p>
                <p>R$ <?= number_format($realty->valor, 2, ',', '.') ?></p>

                <?php
                $imagens = json_decode($realty->imagens, true);

                if (is_array($imagens) && !empty($imagens)):
                    foreach ($imagens as $imagem):

                        if (strpos($imagem, 'uploads/') === false) {
                            $imagem = 'uploads/' . $imagem;
                        }

                        $imagemUrl = base_url($imagem);
                ?>

                        <img src="<?= $imagemUrl ?>" alt="Imagem do imóvel">

                <?php endforeach;
                endif; ?>
                <div class="action-buttons">
                    <a href="#" class="btn edit" data-id="<?= $realty->id_imovel ?>">Editar</a>
                    <input type="button" class="btn deactive" data-id="<?= $realty->id_imovel ?>" value="Desativar">
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    </div>
</body>
</html>