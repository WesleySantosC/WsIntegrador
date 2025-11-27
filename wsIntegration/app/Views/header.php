<link rel="stylesheet" href="<?= base_url('Styles/StyleHeader.css'); ?>">
<link rel="icon" href="<?= base_url('imgs/fivecon_muvy.png') ?>">
<script>
    const wwwroot = "<?= base_url() ?>";
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<nav class="navbar">
    <div class="logo">
        <a href="<?= base_url("/"); ?>">
        <img src="<?= base_url("imgs/logo_movy.png"); ?>" style="max-width: 20%;" alt="Logo">
        </a>
    </div>
    <ul class="menu">
        <li><a href="/">Home</a></li>
        <li><a href="/plans">Planos</a></li>
        <li><a href="<?= base_url('contact'); ?>">Contato</a></li>
        <li><a href="<?= base_url('login'); ?>">Entrar</a></li>
    </ul>
</nav>