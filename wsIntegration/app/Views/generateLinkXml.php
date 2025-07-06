<link rel="stylesheet" href="<?= base_url('Styles/styleGenerateLinkXml.css'); ?>">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= base_url('scripts/xmlLink.js'); ?>"></script>
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
            Olá, <?= $userInfo->nome ?>
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

    <div class="generate-xml-container">
        <span>Clique para gerar o seu XML</span>

        <form id="generateXMLClient">
            <button type="submit" id="generate-btn">Gerar XML</button>
        </form>
    </div>

</body>

</html>
