<?= view('header') ?>
<title>Ws Integrações</title>
<link rel="stylesheet" href="<?= base_url('Styles/styleContact.css'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="<?= base_url('scripts/contact.js'); ?>"></script>
<script src="<?= base_url('scripts/mask.js'); ?>"></script>
<body>
    <div class="intro">
        <p>Envie seu e-mail com dúvidas ou solicitação de atendimento, e em breve entraremos em contato!</p>
    </div>
    <main>
        <form id="frm_registerContact">
            <div class="form-group">
                <label for="nome">Digite seu nome: </label>
                <input type="text" name="nome" id="nome" placeholder="Ex: João" required>
            </div>
            <div class="form-group">
                <label for="email">Digite seu E-mail: </label>
                <input type="email" name="email" id="email" placeholder="Ex: joao@email.com" required>
            </div>
            <div class="form-group">
                <label for="phone">Digite o seu telefone: </label>
                <input type="text" name="phone" id="phone" placeholder="00 00000-0000"  maxlength="11" required>
            </div>
            <div class="form-group">
                <label for="question">Solicitação: </label>
                <textarea name="question" id="question" placeholder="Sua mensagem"></textarea>
            </div>
            <div class="test">
                <input type="submit" value="Enviar" id="send">
            </div>
        </form>
    </main>
    <?= view('footer') ?>
</body>
</html>