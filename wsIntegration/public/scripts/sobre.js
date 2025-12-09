$(document).ready(() => {
    const $menuToggle      = $('#menuToggle');
    const $mobileNav       = $('#mobileNav');
    const $backdrop        = $('#mobileBackdrop');
    const $firstMobileLink = $('.mobile-nav a').first();

    $("#phone").on("keyup", function () {
        let value = $(this).val();
        $(this).val(window.maskPhone(value));
    });

    $("#phone").on("blur", function () {
        let value = $(this).val();
        $(this).val(window.maskPhone(value));
    });

    function openMenu() {
        $menuToggle.addClass('active').attr('aria-expanded', 'true');
        $mobileNav.addClass('open').attr('aria-hidden', 'false');
        $backdrop.addClass('show').attr('aria-hidden', 'false');
        $('html, body').css('overflow', 'hidden');
    }

    function closeMenu() {
        $menuToggle.removeClass('active').attr('aria-expanded', 'false');
        $mobileNav.removeClass('open').attr('aria-hidden', 'true');
        $backdrop.removeClass('show').attr('aria-hidden', 'true');
        $('html, body').css('overflow', '');
    }

    $menuToggle.on('click', function () {
        if ($mobileNav.hasClass('open')) {
            closeMenu();
            $menuToggle.text("☰");
        } else {
            openMenu();
            $menuToggle.text("X");
            if ($firstMobileLink.length) {
                $firstMobileLink.focus();
            }
        }
    });

    $backdrop.on('click', function () {
        closeMenu();
    });

    $('.mobile-nav a, .mobile-link').on('click', function () {
        closeMenu();
    });

    $(document).on('keydown', function (e) {
        if (e.key === 'Escape' && $mobileNav.hasClass('open')) {
            closeMenu();
        }
    });

    $(".contact-form").submit((e) => {
        e.preventDefault();
        const route = 'contact/registerContact';
        var form = $('.contact-form');
        var formData = form.serialize();
        $.post(
            wwwroot + route, formData, function (response) {
                if(response.status == 'success') {
                    Swal.fire({
                        title: 'Solicitação encaminhada!',
                        text: 'Sua solicitação foi encaminhada a um agente, em breve entraremos em contato!',
                        icon: 'success'
                    }).then(() => {
                        window.location.href= wwwroot;
                    }); 
                } else{
                    Swal.fire({
                        title: 'Erro ao enviar solicitação!',
                        text: response.error,
                        icon: 'error'
                    })
                }
            }, 'json'
        );
    });
});