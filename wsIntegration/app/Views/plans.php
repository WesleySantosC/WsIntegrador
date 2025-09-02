<?= view('header'); ?>
<link rel="stylesheet" href="<?= base_url('Styles/stylePlans.css') ?>">


<main>
    <div class="plans-container">
        <?php foreach ($plans as $plan): ?>
            <div class="plan-card <?= $plan->is_featured ? 'featured' : '' ?>">
                <h2><?= $plan->name ?></h2>
                <p><strong>Preço:</strong><?= !$plan->price ? "R$ " . number_format($plan->price, 2, ',', '.') : ' Gratuito'?></p>
                <p><strong>Duração:</strong> <?= "∞" //$plan->duration_days ?></p>
                <p><strong>Anúncios:</strong> <?= "∞" // $plan->qtd_anuncio ?></p>
                <!--<p><strong>Destaques:</strong> <?php //$plan->qtd_destaque ?></p> -->
                <!--<p><strong>Destaque permitido?</strong> <?php //$plan->is_featured ? 'Sim' : 'Não' ?></p>-->
                <button class="btn-escolher" onclick="location.href='<?= base_url('payment/' . $plan->id) ?>'">Escolher</button>
                </div>
        <?php endforeach; ?>
    </div>
</main>

<?= view('footer'); ?>
