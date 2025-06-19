<link rel="stylesheet" href="<?= base_url('Styles/stylePlans.css') ?>">
<nav class="navbar">
    <div class="logo">Ws Integrações</div>
    <ul class="menu">
        <li><a href="/">Home</a></li>
        <li><a href="/plans">Planos</a></li>
        <li><a href="<?= base_url('contact'); ?>">Contato</a></li>
        <li><a href="<?= base_url('login'); ?>">Entrar</a></li>
    </ul>
</nav>

<main>
    <div class="plans-container">
        <?php foreach ($plans as $plan): ?>
            <div class="plan-card <?= $plan->is_featured ? 'featured' : '' ?>">
                <h2><?= $plan->name ?></h2>
                <p><strong>Preço:</strong> R$ <?= number_format($plan->price, 2, ',', '.') ?></p>
                <p><strong>Duração:</strong> <?= $plan->duration_days ?> dias</p>
                <p><strong>Anúncios:</strong> <?= $plan->qtd_anuncio ?></p>
                <p><strong>Destaques:</strong> <?= $plan->qtd_destaque ?></p>
                <p><strong>Destaque permitido?</strong> <?= $plan->is_featured ? 'Sim' : 'Não' ?></p>
                <button class="btn-escolher" onclick="location.href='<?= base_url('payment/' . $plan->id) ?>'">Escolher</button>
                </div>
        <?php endforeach; ?>
    </div>
</main>

<footer class="footer">
    <p>&copy; 2025 Ws Integrações - Todos os direitos reservados.</p>
</footer>
