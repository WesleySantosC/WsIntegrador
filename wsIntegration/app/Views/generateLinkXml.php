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

</body>

</html>
