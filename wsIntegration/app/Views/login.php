<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="<?= base_url('Styles/styleLogin.css'); ?>">

<title>Login</title>

<h1>Login</h1>
<form action="<?= site_url('login/verifyUsers') ?>" method="post">
    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" placeholder="Ex: Seu E-mail" autocomplete="off" required>
    <br><br>

    <label for="password">Senha:</label>
    <input type="password" id="password" name="password" placeholder="Sua Senha" autocomplete="off" required>
    <br><br>

    <button type="submit">Entrar</button>
    <br><br>

    Esqueceu a sua senha? <a href="<?= site_url('resetPassword') ?>">Clique para redefinir</a>

    <?php if (session()->has('erro')): ?>
        <p style="color: red;"><?php echo session('erro'); ?></p>
    <?php endif; ?>
</form>