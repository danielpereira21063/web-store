$(document).ready(function() {
    $('#btn-login').on('click', function() {
        const email = $('#email');
        const senha = $('#senha');
        const urlDestino = 'http://127.0.0.1/web-store/usuario/login';
        $.ajax({
            type: 'POST',
            data: {
                email: email.val(),
                senha: senha.val()
            },
            url: urlDestino,
            success: function(r) {
                if(!r) {
                    $('#mensagem').html('<p class="text-center alert alert-danger">E-mail ou senha incorretos</p>');
                    email.addClass('is-invalid');
                    senha.addClass('is-invalid');
                } else {
                    location.href = 'http://127.0.0.1/web-store/';
                }
            }
        });
    });
});