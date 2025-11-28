<?= view('headerAdminClient'); ?>
<link rel="stylesheet" href="<?= base_url('Styles/styleGenerateLinkXml.css'); ?>">
<script src="<?= base_url('scripts/xmlLink.js'); ?>"></script>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body>

    <div class="generate-xml-container">
        <span>Clique para gerar o seu XML</span>

        <form id="generateXMLClient">
            <button type="submit" id="generate-btn">Gerar XML</button>
        </form>
    </div>

    <?php if($linkXml) {  ?>
        <div class="generate-xml-container">
            <label>Link XML</label><br>
            <div class="copy-box">
                <input type="text" id="xmlLink" value="<?= $linkXml ?>" readonly>
                <button id="copyBtn"><i class="fa-regular fa-copy"></i></button>
            </div><br>
    
            <span id="copyMsg" style="display:none;">Copiado!</span>
        </div>
    <?php } else { ?>
        <div class="generate-xml-container">
            <div class="copy-box">
                <input type="text" id="xmlLink" style="text-align: center;" value="Nenhum XML foi gerado!" readonly>
            </div>
        </div>
    <?php } ?>

</body>

</html>
