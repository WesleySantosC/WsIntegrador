<?= view('headerAdminClient'); ?>
<title>Mensalidades</title>
<link rel="stylesheet" href="<?= base_url('Styles/StyleMonthlyFee.css'); ?>">

<div class="mensalidades-container">
    <table class="mensalidades-table">
        <thead>
            <tr>
                <th>Data</th>
                <th>Plano</th>
                <th>Próxima Mensalidade</th>
                <th>Valor</th>
                <th>Status</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>

        <?php foreach ($monthlyFeeClient as $monthlyFee): ?>
            <?php 
                $due_date      = new DateTime($monthlyFee->due_date);
                $next_due_date = new DateTime($monthlyFee->next_due_date);

                if($monthlyFee->payment_status == 'PENDING') {
                    $status  = 'pendente';
                    $writing = 'Pendente';
                } elseif($monthlyFee->payment_status == 'CONFIRMED') {
                    $status = 'pago';
                    $writing = 'Pago';
                } elseif($monthlyFee->payment_status == 'OVERDUE') {
                    $status  = 'atrasado';
                    $writing = 'Atrasado';
                } else {
                    echo "Error! Entre em contato conosco!";
                }
            ?>
            <tr>
                <td><?= $due_date->format('d/m/Y'); ?></td>
                <td><?= $monthlyFee->qtd_anuncio ?> anúncios</td>
                <td><?= $next_due_date->format('d/m/Y') ?></td>
                <td>R$ <?= number_format($monthlyFee->value, 2, ",", "."); ?></td>
                <td><span class="status-<?= $status ?>"><?= $writing ?></span></td>
                <td>
                    <?php if($status == 'pago') { ?> 
                        <button class="pay" style="display: none;" onclick="window.open('<?= $monthlyFee->invoice_url; ?>')">
                            Pagar
                        </button>
                    <?php } else { ?>
                        <button class="pay" onclick="window.open('<?= $monthlyFee->invoice_url; ?>')">
                            Pagar
                        </button>
                    <?php } ?>
                </td>
            </tr>
        <?php endforeach ?>

        </tbody>
    </table>
</div>
