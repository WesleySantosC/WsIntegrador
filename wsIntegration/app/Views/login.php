<link rel="stylesheet" href="<?= base_url('Styles/styleLogin.css'); ?>">
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="<?= site_url('login/verifyUsers') ?>" method="post">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
        <br><br>

        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required>
        <br><br>

        <button type="submit">Entrar</button>
        <br><br>
        
        Esqueceu a sua senha? <a href="<?= site_url('resetPassword') ?>">Clique para redefinir</a>

        <?php if (session()->has('erro')): ?>
            <p style="color: red;"><?php echo session('erro'); ?></p>
            <?php endif; ?>
    </form>
</body>
</html>