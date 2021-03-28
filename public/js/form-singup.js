$(document).ready(function(){
    $('#nome').val('Daniel');
    $('#email').val('daniel.com');
    $('#senha').val('121212');
    $('#confirm-senha').val('121212');

    $('#btn-signup').on('click', function(){
        let nome = $('#nome');
        let email = $('#email');
        let senha = $('#senha');
        let confirm_senha = $('#confirm-senha');
        let erros = 0;

        if(nome.val() == '') {
            erros ++;
            nome.addClass('is-invalid');
            $('#nome-erro').html('O campo nome é obrigatório');
        } else {
            nome.removeClass('is-invalid');
            $('#nome-erro').html('');
        }

        if(email.val() == '') {
            erros ++;
            email.addClass('is-invalid');
            $('#email-erro').html('O campo e-mail é obrigatório');
        } else {
            email.removeClass('is-invalid');
            $('#email-erro').html('')
        }

        if(senha.val() == '') {
            erros ++;
            senha.addClass('is-invalid');
            $('#senha-erro').html('Preencha o campo senha');
        } else {
            senha.removeClass('is-invalid');
            $('#senha-erro').html('');
        }

        if(confirm_senha.val() == '') {
            erros ++;
            confirm_senha.addClass('is-invalid');
            $('#confirm-senha-erro').html('Confirme sua senha');
        } else {
            confirm_senha.removeClass('is-invalid');
            $('#confirm-senha-erro').html('');
        }

        if( erros == 0 ) {
            //se não existirem erros entrará nessa condição
            erros = 0;

            /*
            
            IMPORTANTE!!!!! 
            
            FAZER UMA VALIDAÇÃO DE NOME E E-MAIL USANDO JAVASCRIPT
            
            */


           
            if(!senhasConferem(senha.val(), confirm_senha.val())) { //se as senhas forem diferentes
                erros ++;
                confirm_senha.addClass('is-invalid');
                senha.addClass('is-invalid');
                $('#confirm-senha-erro').html('As senhas não conferem');
            }
            if(senhaValida(senha.val())) { //se a senha for menor do que 6 caracteres
                erros ++;
                senha.addClass('is-invalid');
                $('#senha-erro').html('Sua senha deve ter no mínimo 6 caracteres');
            } else {
                senha.removeClass('is-invalid');
                $('#senha-erro').html('');
            }

            /* SUBMIT DO FORMULÁRIO */
            if(erros == 0) {
                let urlDestino = 'http://127.0.0.1/web-store/usuario/signup';
                $.ajax({
                    // dataType: 'json',
                    type: 'POST',
                    data: {
                        nome: nome.val(),
                        email: email.val(),
                        senha: senha.val()
                    },
                    url: urlDestino,
                    async: true,
                    success: function(r) {
                        if(r) {
                            console.log('ok');
                        } else {
                            alert('não');
                        }
                    }
                });
            }
        }
    });
});


function senhaValida(senha) {
    if(senha.length < 6) {
        return true;
    } else {
        return false;
    }
}

function senhasConferem(senha1, senha2) {
    if(senha1 === senha2) {
        return true;
    } else {
        return false;
    }
}