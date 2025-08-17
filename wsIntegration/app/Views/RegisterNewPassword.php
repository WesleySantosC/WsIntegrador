<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= base_url('scripts/RegisterNewPassword.js'); ?>"></script>
    <link rel="stylesheet" href="<?= base_url('Styles/styleLogin.css'); ?>">
</head>
<body>
    <h1>Redefinir Senha</h1>
    <form id="frmz_resetPassword">
        <label for="email">E-mail:</label>
        <input type="text" id="email" name="email" required>
        <br><br>

        <label for="nova_senha">Nova Senha:</label>
        <input type="password" id="nova_senha" name="nova_senha" required>
        <br><br>

        <label for="confirmar_senha">Confirmar Senha:</label>
        <input type="password" id="confirmar_senha" name="confirmar_senha" required>
        <br><br>

        <button type="submit" id="redefinir">Redefinir Senha</button>
        <br><br>

        <a href="<?= base_url('login') ?>">Voltar ao login</a>

        <?php if (session()->has('erro')): ?>
            <p style="color: red;"><?php echo session('erro'); ?></p>
        <?php endif; ?>

        <?php if (session()->has('sucesso')): ?>
            <p style="color: green;"><?php echo session('sucesso'); ?></p>
        <?php endif; ?>
    </form>
</body>
</html>
