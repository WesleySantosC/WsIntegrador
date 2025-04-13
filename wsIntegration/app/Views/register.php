<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="<?= base_url('Styles/styleLogin.css'); ?>">
</head>
<body>
    <h1>Cadastro</h1>
    <form action="<?= site_url('register/store') ?>" method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        <br><br>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
        <br><br>

        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required>
        <br><br>

        <button type="submit">Cadastrar</button>
        <br><br>

        Já tem uma conta? <a href="<?= site_url('login') ?>">Faça login</a>

        <?php if (session()->has('erro')): ?>
            <p style="color: red;"><?php echo session('erro'); ?></p>
        <?php endif; ?>
    </form>
</body>
</html>
