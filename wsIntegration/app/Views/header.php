<link rel="stylesheet" href="<?= base_url('Styles/StyleHeader.css'); ?>">
<script>
    const wwwroot = "<?= base_url() ?>";
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<nav class="navbar">
    <div class="logo">Movy</div>
    <ul class="menu">
        <li><a href="/">Home</a></li>
        <li><a href="/plans">Planos</a></li>
        <li><a href="<?= base_url('contact'); ?>">Contato</a></li>
        <li><a href="<?= base_url('login'); ?>">Entrar</a></li>
    </ul>
</nav>