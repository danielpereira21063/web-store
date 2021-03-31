$(document).ready(function(){
    const nome = $('#nome');
    const email = $('#email');
    const senha = $('#senha');
    const confirm_senha = $('#confirm-senha');

    $('#ver-senha').on('click', function(){
        if(senha.prop('type') == 'password') {
            senha.attr('type', 'text');
            $('#ver-senha').children().removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            senha.attr('type', 'password')
            $('#ver-senha').children().removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    $('#ver-confirm-senha').on('click', function(){
        if(confirm_senha.prop('type') == 'password') {
            confirm_senha.attr('type', 'text');
            $('#ver-confirm-senha').children().removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            confirm_senha.attr('type', 'password')
            $('#ver-confirm-senha').children().removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
    
    $('#btn-signup').on('click', function(){
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
                const urlDestino = 'http://127.0.0.1/web-store/usuario/signup';
                $.ajax({
                    // dataType: 'json',
                    type: 'POST',
                    data: {
                        nome: nome.val(),
                        email: email.val(),
                        senha: senha.val(),
                        confirm_senha: confirm_senha.val()
                    },
                    url: urlDestino,
                    success: function(r) {
                        if(r != 1) {
                            console.log(r);
                            if(r == 'erro_armazenar') {
                                $('#mensagem').html('<p class="text-center alert alert-danger">Erro ao armazenar registro</p>');
                            }
                            
                            if(r == 'campos_vazios') {
                                $('#mensagem').html('<p class="text-center alert alert-danger">Preencha todos os campos para prosseguir</p>');
                            }
                            
                            
                            if(r == 'email_existe') {
                                email.addClass('is-invalid');
                                $('#email-erro').html('O e-mail informado já foi cadastrado');
                            } else if(r == 'email_invalido') {
                                email.addClass('is-invalid');
                                $('#email-erro').html('E-mail inválido');
                            } else {
                                email.removeClass('is-invalid');
                                $('#email-erro').html('');
                            }

                            if(r == 'nome_invalido') {
                                nome.addClass('is-invalid');
                                $('#nome-erro').html('Nome inválido');
                            } else {
                                nome.removeClass('is-invalid');
                                $('#nome-erro').html('');
                            }

                            if(r == 'senha_invalida') {
                                senha.addClass('is-invalid');
                                $('#senha-erro').html('Sua senha deve ter no mínimo 6 caracteres');
                            } else {
                                senha.removeClass('is-invalid');
                                $('#senha-erro').html('');
                            }

                            if(r == 'confirm_senha_invalida') {
                                confirm_senha.addClass('is-invalid');
                                senha.addClass('is-invalid');
                                $('#confirm_senha-erro').html('As senhas não conferem');
                            } else {
                                confirm_senha.removeClass('is-invalid');
                                senha.removeClass('is-invalid');
                                $('#senha-erro').html('');
                            }
                            
                        } else {
                            location.href = 'signup/sucesso';
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