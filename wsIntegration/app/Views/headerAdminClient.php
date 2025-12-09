<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="<?= base_url('Styles/StyleHeaderAdminClient.css'); ?>">
<link rel="icon" href="<?= base_url('imgs/fivecon_muvy.png') ?>">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= base_url('scripts/mask.js'); ?>"></script>
<script>
    const wwwroot = "<?= base_url() ?>";
</script>
<script src="https://kit.fontawesome.com/b46ba83dad.js" crossorigin="anonymous"></script>
<div class="hamburger" id="hamburger">&#9776;</div><br><br><br>

<div class="sidebar">
    <div class="logo">
        <a href="<?= base_url("index.php/dashboard"); ?>">
            <img src="<?= base_url("/imgs/logo_muvy.png"); ?>" alt="Logo" class="logo_img">
        </a>
    </div>
    
    <div class="greeting">
        <p id="greeting"> Olá, <?php if (isset($infoClients[0])) { $nome = $infoClients[0]['nome']; } else { $nome = $infoClients['nome']; } echo $nome;?> </p>
    </div>

    <div hidden>
        <p id="id_client"> ID: <?php if (isset($infoClients[0]['id'])) { $nome = $infoClients[0]['id']; } else { $nome = $infoClients['id']; } echo $nome;?> </p>
    </div>

    <nav class="menu">
        <h2>Menu</h2>
        <ul class="menu-list">
            <li><a href="<?= site_url('/dashboard') ?>" class="menu-item">Home</a></li>
            <li><a href="<?= site_url('/dataClient') ?>" class="menu-item">Dados</a></li>
            <li><a href="<?= site_url('/monthlyFee') ?>" class="menu-item">Mensalidades</a></li>
            <li><a href="<?= site_url('/cadastrarImovel') ?>" class="menu-item">Cadastrar Imóveis</a></li>
            <li><a href="<?= site_url('/generateLinkXml') ?>" class="menu-item">Gerar XML</a></li>
            <li><a href="<?= site_url('/') ?>" class="menu-item" id="logout">Logout</a></li>
        </ul><br>
        <div id="div_whatsApp">
            <p style="color: #f5f5f5;">Dúvidas, entre em contato</p><br>
            <i class="fa-brands fa-whatsapp" id="icon_whatsApp"></i>
        </div>
    </nav>
</div>

<script>
$(document).ready(function () {
    $("#hamburger").click(function () {
        $(".sidebar").toggleClass("active");

        let atual = $(this).text().trim();

        if (atual === "☰") {
            $(this).text("X");
        } else {
            $(this).text("☰");
        }
    });

    $("#icon_whatsApp").click(() => {
        let input_text              = $("#greeting").text();
        let idClient                = $("#id_client").text();
        let transform_in_array_name = input_text.split(",");
        let transform_in_array_id   = idClient.split(":");
        const name                  = transform_in_array_name[1];
        const id                    = transform_in_array_id[1]; 
        const phone                 = '5541987932887';
        const message               = `Olá! Estou com dúvidas no uso do site e solicito suporte. Meu nome é: ${name} e o id da minha conta é: ${id}. Aguardo o retorno!`;

        const url = `https://wa.me/${phone}?text=${encodeURIComponent(message)}`;
        window.open(url, '_blank');
    });

    $(".menu-item").click(() => {
        $(".sidebar").removeClass("active");
        $("#hamburger").text("☰");
    });
});

</script>
