<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= base_url('scripts/mask.js'); ?>"></script>
<script src="<?= base_url("scripts/payment.js"); ?>"></script>
<link rel="stylesheet" href="<?= base_url("Styles/stylePayment.css"); ?>">

<div class="card">
    <h3>Pagamento do plano: <?= esc($plan['name']) ?> </h3>
    <p>Valor: <?= !$plan['price'] ? "R$ " . number_format($plan['price'], 2, ',', '.') : " Gratuito"?> </p>
    <p>Duração: <?= "∞" //$plan['duration_days'] ?></p>
    <p>Qtd Anúncios: <?= "∞" //$plan['qtd_anuncio'] ?> </p>
    <!--<p>Qtd Destaques: <?php //$plan['qtd_destaque'] ?> </p>-->
</div>

<form id="frm_payment">
    <input type="hidden" name="plano_id" value="<?= $plan['id'] ?>">
    <input type="hidden" name="valor" value="<?= $plan['price'] ?>">

    <div class="form-group">
        <label for="nome">Nome do titular</label>
        <input type="text" name="nome" id="nome" class="form-control" autocomplete="off" required>
    </div>

    <div class="form-group">
        <label for="email">E-mail para confirmação</label>
        <input type="email" name="email" id="email" class="form-control" autocorrect="off" autocapitalize="off" spellcheck="false" autocomplete="off" required>
    </div>

    <div class="form-group">
        <label for="telefone">Numero Telefone</label>
        <input type="text" name="telefone" id="telefone" class="form-control" autocomplete="off" required>
    </div>

    <div class="form-group">
        <label for="cpfCnpj">CPF / CNPJ</label>
        <input type="text" name="cpfCnpj" id="cpfCnpj" class="form-control" autocomplete="off" required>
    </div>

    <div class="form-group">
        <label for="tipo_pagamento">Tipo Pagamento</label>
        <select name="tipo_pagamento" id="tipo_pagamento" class="form-control">
            <option value="">Selecione</option>
            <?php foreach ($payments as $payment): ?>
                <option value="<?= esc($payment['nome']) ?>">
                    <?= esc($payment['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="cep">CEP</label>
        <input type="text" name="cep" id="cep" class="form-control" autocomplete="off" required>
    </div>

    <button type="submit" class="btn btn-primary" id="submitPlanClient">Pagar</button>
</form>
