<title>Ws Integrações</title>
<link rel="stylesheet" href="<?= base_url('Styles/styleContact.css'); ?>">
<body>
    <nav class="navbar">
        <div class="logo">Ws Integrações</div>
        <ul class="menu">
            <li><a href="/">Home</a></li>
            <li><a href="/plans">Planos</a></li>
            <li><a href="/contatc">Contato</a></li>
            <li><a href="<?= base_url('login'); ?>">Entrar</a></li>
        </ul>
    </nav>

    <div class="intro">
        <p>Envie seu e-mail com dúvidas ou solicitação de atendimento, e em breve entraremos em contato!</p>
    </div>

    <main>
    <form method="post" action="<?= base_url('contact/submit'); ?>">
            <div class="form-group">
                <label for="nome">Digite seu nome: </label>
                <input type="text" name="nome" id="nome" required>
            </div>
            <div class="form-group">
                <label for="email">Digite seu E-mail: </label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Digite o seu telefone: </label>
                <input type="tel" name="phone" id="phone" required>
            </div>
            <div class="form-group">
                <label for="question">Solicitação: </label>
                <textarea name="question" id="question"></textarea>
            </div>
            <div>
                <input type="submit" value="Enviar">
            </div>
        </form>
    </main>

    <footer class="footer">
        <p>&copy; 2025 Ws Integrações - Todos os direitos reservados.</p>
    </footer>
</body>

</html>