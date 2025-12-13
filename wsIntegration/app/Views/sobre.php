<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Muvy - Plataforma de Integração Imobiliária</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/b46ba83dad.js" crossorigin="anonymous"></script>
    <script src="<?= base_url('/scripts/sobre.js'); ?>"></script>
    <script src="<?= base_url('scripts/mask.js'); ?>"></script>
    <link rel="stylesheet" href="<?= base_url('Styles/styleSobreNos.css'); ?>">
    <link rel="icon" href="<?= base_url('imgs/fivecon_muvy.png') ?>">
    <script>
        const wwwroot = "<?= getenv('WWWROOT') ?>";
    </script>
</head>

<body>

<header>
    <div class="header-inner">
        <div class="logo">
            <h1 style="margin:0;"><img src="<?= base_url('imgs/logo_muvy.png'); ?>" alt="Muvy"></h1>
        </div>

        <nav id="nav" aria-label="Navegação principal">
            <a href="#features">Funcionalidades</a>
            <a href="#plans">Planos</a>
            <a href="#about">Sobre</a>
            <a href="#contact">Contato</a>
            <a href="<?= base_url('login'); ?>" class="login">Login</a>
        </nav>

        <button class="menu-toggle" id="menuToggle" aria-label="Abrir menu" aria-expanded="false" aria-controls="mobileNav">
            ☰
        </button>
    </div>
</header>

<div class="mobile-backdrop" id="mobileBackdrop" aria-hidden="true"></div>

<nav class="mobile-nav" id="mobileNav" aria-label="Menu móvel" aria-hidden="true">
    <a href="#features" class="mobile-link">Funcionalidades</a>
    <a href="#plans" class="mobile-link">Planos</a>
    <a href="#about" class="mobile-link">Sobre</a>
    <a href="#contact" class="mobile-link">Contato</a>
    <a href="<?= base_url('login'); ?>" class="mobile-link">Login</a>
</nav>

<section class="hero fade-up">
    <h2>A Plataforma de Integração Imobiliária do Futuro</h2>
    <p>Automatize seus feeds, envie seus imóveis para qualquer portal, aumente sua produtividade e gerencie tudo em um único lugar.</p>
    <a href="#plans">
        <button class="glow-btn">Conheça nossos planos</button>
    </a>
</section>

<section class="features fade-up" id="features">
    <div class="card"><h3>Integração Instantânea</h3><p>Gere links XML com sincronização automática.</p></div>
    <div class="card"><h3>Integração</h3><p>Integração com qualquer portal.</p></div>
</section>

<section class="plans fade-up" id="plans">
    <h2>Planos para Todos</h2>
    <div class="plan-grid">
        <?php foreach ($plans as $plan): ?>
            <div class="plan">
                <h3><?= $plan->name; ?></h3>
                <p class="price">R$ <?= $plan->price; ?></p>
                <p>Duração: <?= $plan->duration_days; ?> dias</p>
                <p>Anúncios: <?= $plan->qtd_anuncio; ?></p>
                <button onclick="location.href='<?= base_url('payment/' . $plan->id) ?>'">Assinar</button>
            </div>
        <?php endforeach ?>
    </div>
</section>

<section class="about fade-up" id="about">
    <h2>Sobre Nós</h2>
    <p>
        O <strong>Muvy</strong> foi criado para facilitar a gestão e a divulgação de imóveis em múltiplos portais ao mesmo tempo.
        Profissionais do mercado podem cadastrar seus imóveis apenas uma vez e compartilhar com diversos sites parceiros via links personalizados.
    </p>
    <p>
        Focado em agilidade e automação, o Muvy elimina cadastros repetitivos e simplifica seu fluxo de trabalho diário.
    </p>
    <p><strong>🚀 Torne sua rotina muito mais eficiente com o Muvy!</strong></p>
</section>

<section class="contact fade-up" id="contact">
    <h2>Entre em Contato</h2>
    <p>Envie sua dúvida ou solicitação e retornaremos o mais breve possível.</p>

    <form class="contact-form" style="max-width:600px;margin:0 auto;text-align:left;">
        <label>Digite seu nome:</label>
        <input type="text" name="nome" id="nome" placeholder="Ex: João" style="width:100%;padding:14px;border-radius:10px;margin-bottom:15px;" required>

        <label>Digite seu e-mail:</label>
        <input type="email" name="email" id="email" placeholder="Ex: joao@email.com" style="width:100%;padding:14px;border-radius:10px;margin-bottom:15px;" required>

        <label>Telefone:</label>
        <input type="text" name="phone" id="phone" placeholder="00 00000-0000" style="width:100%;padding:14px;border-radius:10px;margin-bottom:15px;" required>

        <label>Sua solicitação:</label>
        <textarea placeholder="Descreva sua solicitação" name="question" id="question" style="width:100%;padding:14px;border-radius:10px;height:140px;margin-bottom:20px;" required></textarea>

        <button type="submit"
            style="padding:16px 40px;background:var(--green);color:#fff;border-radius:12px;border:none;font-size:20px;font-weight:700;cursor:pointer;width:100%">
            Enviar Mensagem
        </button>
    </form>
</section>

<footer>
    © 2025 Muvy - Todos os direitos reservados.<br>
    <!--<span style="margin-top:12px; display:block;">Email: contato@muvy.com</span>-->
    <span id="span_icon" onclick="window.open('https://www.instagram.com/movy_system/')"><i class="fa-brands fa-instagram" id="icon"></i></span>
</footer>
</body>
</html>