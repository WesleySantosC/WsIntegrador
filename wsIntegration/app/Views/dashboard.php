<?= view('headerAdminClient'); ?>
<link rel="stylesheet" href="<?= base_url('Styles/styleDashboard.css'); ?>">
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="<?= base_url('scripts/dashboard.js') ?>"></script>
</head>
<body>

    <div class="content">
        <div class="header-content">
            <h1>Bem-vindo ao Dashboard</h1>
        </div>
        <div class="dashboard-stats">
            <div class="card">
                <i class="fas fa-calendar-check"></i>
                <h3>Total de Imóveis</h3>
                <p>Quantidade: <?= $realtyCount->total_imoveis ?: "Nenhum Imóvel cadastrado" ?></p>
            </div>
            <div class="card">
                <i class="fas fa-chart-line"></i>
                <h3>Valor total em Imóveis</h3>
                <p>R$ <?= number_format($realtyValue->total_valor, 2, ",", ".") ?: "Nenhum valor encontrado!" ?></p>
            </div>
        </div>
    </div>

    <div>
        <input type="submit" value="Imóveis Desativados" style="margin-left: 15%; background-color: #FFC107; border: none; height: 3%; width: 8%; border-radius: 5px; cursor: pointer;" name=">openModal" id="openModal">
    </div>


    <div id="modal">
    <div class="modal-content">
        <span id="close" title="Fechar">&times;</span>
        <h2 style="text-align: center;">Imóveis Desativados</h2>

        <?php if (!empty($realtyDisabled) && is_iterable($realtyDisabled)): ?>
            <?php foreach ($realtyDisabled as $disabled): ?>
                <div class="realty-list">
                    <div class="cardRealty">
                        <h3><?= $disabled->tipo_venda . " " . $disabled->tipo . " com " . $disabled->quantidade_quartos . " quartos em " . $disabled->cidade ?></h3>
                        <p><?= $disabled->descricao ?></p>
                        <p>R$ <?= number_format($disabled->valor, 2, ',', '.') ?></p>

                        <?php
                        $imagens = json_decode($disabled->imagens, true);
                        if (is_array($imagens) && !empty($imagens)):
                            foreach ($imagens as $imagem):
                                if (strpos($imagem, 'uploads/') === false) {
                                    $imagem = 'uploads/' . $imagem;
                                }
                                $imagemUrl = base_url($imagem);
                        ?>
                                <img src="<?= $imagemUrl ?>" alt="Imagem do imóvel">
                        <?php endforeach;
                        endif; ?>

                        <div class="action-buttons">
                            <input type="button" class="btn active" data-id="<?= $disabled->id ?>" value="Ativar">
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center;">Nenhum imóvel desativado encontrado.</p>
        <?php endif; ?>

    </div>
</div>

    <?php foreach ($realtyClient as $realty): ?>
        <div class="realty-list">
            <div class="cardRealty">
                <h3><?= $realty->tipo_venda . " " . $realty->tipo . " com " . $realty->quantidade_quartos . " quartos " . " em " . $realty->cidade ?></h3>
                <p><?= $realty->descricao ?></p>
                <p>R$ <?= number_format($realty->valor, 2, ',', '.') ?></p>

                <?php
                $imagens = json_decode($realty->imagens, true);

                if (is_array($imagens) && !empty($imagens)):
                    foreach ($imagens as $imagem):

                        if (strpos($imagem, 'uploads/') === false) {
                            $imagem = 'uploads/' . $imagem;
                        }

                        $imagemUrl = base_url($imagem);
                ?>

                        <img src="<?= $imagemUrl ?>" alt="Imagem do imóvel">

                <?php endforeach;
                endif; ?>
                <div class="action-buttons">
                    <a href="#" class="btn edit" data-id="<?= $realty->id_imovel ?>">Editar</a>
                    <input type="button" class="btn deactivate" data-id="<?= $realty->id_imovel ?>" value="Desativar">
                </div>
            </div>
        </div>
    <?php endforeach; ?>

</body>

</html>