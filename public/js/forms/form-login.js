$(document).ready(function() {
    const email = $('#email');
    const senha = $('#senha');
    $('#ver-senha').on('click', function(){
        if(senha.prop('type') == 'password') {
            senha.attr('type', 'text');
            $('#ver-senha').children().removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            senha.attr('type', 'password')
            $('#ver-senha').children().removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
    $('#btn-login').on('click', function() {
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
                    // setTimeout(function() {
                    //     $('#mensagem').html('');
                    // }, 3000);
                    email.on('click', function() {
                        email.removeClass('is-invalid');
                    });
                    senha.on('click', function() {
                        senha.removeClass('is-invalid');
                    });
        
                } else {
                    location.href = 'http://127.0.0.1/web-store/home';
                }
            }
        });
    });
});