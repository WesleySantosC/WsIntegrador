<link rel="stylesheet" href="<?= base_url('Styles/StyleHeaderAdminClient.css'); ?>">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const wwwroot = "<?= base_url() ?>";
</script>
<div class="sidebar">
    <div class="logo">
        <h1>Ws Integrações</h1>
    </div>
    <div class="greeting">
        Olá, <?php if (isset($infoClients[0])) { $nome = $infoClients[0]['nome']; } else { $nome = $infoClients['nome']; } echo $nome;?>
    </div>
    <nav class="menu">
        <h2>Menu</h2>
        <ul class="menu-list">
            <li><a href="<?= site_url('/dashboard') ?>" class="menu-item"><i class="fas fa-database"></i> Home</a></li>
            <li><a href="<?= site_url('/dataClient') ?>" class="menu-item"><i class="fas fa-database"></i> Dados</a></li>
            <li><a href="<?= site_url('/cadastrarImovel') ?>" class="menu-item"><i class="fas fa-stethoscope"></i>Cadastrar Imoveis</a></li>
            <li><a href="<?= site_url('/generateLinkXml') ?>" class="menu-item"><i class="fas fa-stethoscope"></i>Gerar XML</a></li>
            <li><a href="<?= site_url('/') ?>" class="menu-item" id="logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </nav>
</div>