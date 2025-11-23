<?= view('headerAdminClient'); ?>
<link rel="stylesheet" href="<?= base_url('Styles/styleDashboard.css'); ?>">
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?= base_url('scripts/dashboard.js') ?>"></script>
    <title>Dashboard</title>
</head>
<body>

    <div class="content">
        <div class="title_plan">
            <h5 class="desc_plan"><?php print_r("Plano: " . $planUsedClient->qtd_anuncio . " anúncios e "  . $planUsedClient->qtd_destaque . " destaques") ?></h5>
        </div>
            <div class="dashboard-stats">
            <div class="card">
                <i class="fas fa-calendar-check"></i>
                <h3>Imóveis Ativo</h3>

                <?= $realtyCount->total_realty ? "<p>Quantidade: $realtyCount->total_realty" : "<p>Nenhum Imóvel cadastrado.</p>" ?>
            </div>

            <div class="card">
                <i class="fas fa-calendar-check"></i>
                <h3>Imóveis Desativados</h3>

                <?= $realtyCountDisabled->total_realtyDisabled ? "<p>Quantidade: $realtyCountDisabled->total_realtyDisabled</p>" : "<p>Nenhum Imóvel desativado.</p>"?>
            </div>

            <div class="card">
                <i class="fas fa-chart-line"></i>
                <h3>value total em Imóveis</h3>
                <p>R$ <?= number_format($realtyValue->total_value, 2, ",", ".") ?: "Nenhum valor encontrado." ?></p>
            </div>

        </div>
    </div>

    <div class="realty_disabled_button">
        <input type="submit" value="Imóveis Desativados" name=">openModal" id="openModal">
    </div><br>


    <div id="modal">
    <div class="modal-content">
        <span id="close" title="Fechar">&times;</span>
        <h2 id="title_realty_disabled">Imóveis Desativados</h2><br>


        <?php if (!empty($realtyDisabled) && is_iterable($realtyDisabled)): ?>
            <?php foreach ($realtyDisabled as $disabled): ?>
                <div class="init_card_realty">
                    <div class="realty-list">
                        <div class="cardRealty">
                            <div>
                                <?php
                                $imagens = json_decode($disabled->imagens, true);
                                $imgPadrao = base_url("imgs/imagem_padrão_casa.png");

                                if (is_array($imagens) && !empty($imagens) && !empty($imagens[0])) {
                                    $imagemUrl = base_url($imagens[0]);
                                } else {
                                    $imagemUrl = $imgPadrao;
                                }
                                ?>

                                <img src="<?= $imagemUrl ?>" alt="Imagem do imóvel" title="Imagem do imóvel">
                            </div>

                            <div class="test">
                                <div class="title_ads">
                                    <h3><?= $disabled->sale_type . " " . $disabled->name . " com " . $disabled->rooms . " quartos em " . $disabled->neighborhood ?></h3>
                                </div>
                                
                                <div class="description_ads">
                                    <p><?= $disabled->description ?></p>
                                </div>

                                <div class="value_realty">
                                    <p>R$ <?= number_format($disabled->value, 2, ',', '.') ?></p>
                                </div>
                            </div>



                            <div class="action-buttons">
                                <input type="button" class="btn active" data-id="<?= $disabled->id_imovel ?>" value="Ativar">
                            </div>
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
        <div class="init_card_realty">
            <div class="realty-list">
                <div class="cardRealty">
                    <div>
                        <?php
                        $imagens = json_decode($realty->imagens, true);
                        $imgPadrao = base_url("imgs/imagem_padrão_casa.png");

                        if (is_array($imagens) && !empty($imagens) && !empty($imagens[0])) {
                            $imagemUrl = base_url($imagens[0]);
                        } else {
                            $imagemUrl = $imgPadrao;
                        }
                        ?>

                        <img src="<?= $imagemUrl ?>" alt="Imagem do imóvel" title="Imagem do imóvel">

                            <!--$imagens = json_decode($realty->imagens, true);

                            if (is_array($imagens) && !empty($imagens)):
                                foreach ($imagens as $imagem):

                                    if (strpos($imagem, 'uploads/') === false) {
                                        $imagem = 'uploads/' . $imagem;
                                    }

                                $imagemUrl = base_url($imagem);
                            ?>

                    <img src="<?php // $imagemUrl ?>" alt="Imagem do imóvel">

                            php endforeach;
                            endif;-->
                    </div>

                    <div class="test">
                        <div class="title_ads">
                            <h3><?= $realty->sale_type . " " . $realty->name . " com " . $realty->rooms . " quartos " . " em " . $realty->neighborhood ?></h3>
                        </div>
        
                        <div class="description_ads">
                            <p><?= $realty->description ?></p>
                        </div>
        
                        <div class="value_realty">
                            <p>R$ <?= number_format($realty->value, 2, ',', '.') ?></p>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <input type="button" class="btn edit" data-id="<?= $realty->id_imovel ?>" value="Editar"><br><br>
                        <input type="button" class="btn deactivate" data-id="<?= $realty->id_imovel ?>" value="Desativar">
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

</body>

</html>