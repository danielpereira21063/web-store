$(document).ready(function() {
    const nomeProduto = $('#nome-produto');
    const descricao = $('#desc-produto');
    const quant = $('#quant');
    const preco = $('#preco');
    // nomeProduto.val('Cinto');
    // descricao.val('Esse é um belo cinto');
    // quant.val(12);
    // preco.val(22.99);

    $('#btn-adicionar-produto').on('click', function() {
        let erros = 4;

        if(nomeProduto.val() == '') {
            nomeProduto.addClass('is-invalid');
            $('#nome-erro').html('<p>Insira o nome do produto</p>');
        } else {
            nomeProduto.removeClass('is-invalid');
            $('#nome-erro').html('');
            erros--;
        }
        
        if(descricao.val() == '') {
            descricao.addClass('is-invalid')
            $('#desc-erro').html('<p>Insira a descrição do produto</p>');
        } else {
            descricao.removeClass('is-invalid')
            $('#desc-erro').html('');
            erros--;
        }

        if(quant.val() == '') {
            quant.addClass('is-invalid');
            $('#quant-erro').html('<p>Insira a quantidade</p>');
        } else {
            quant.removeClass('is-invalid');
            $('#quant-erro').html('');
            erros--;
        }

        if(preco.val() == '') {
            preco.addClass('is-invalid');
            $('#preco-erro').html('<p>Insira o preço do produto</p>');
        } else {
            preco.removeClass('is-invalid');
            $('#preco-erro').html('');
            erros--;
        }

        console.log(erros);


        if(erros == 0) {
            //envivar dados
            const urlDestino = 'http://127.0.0.1/web-store/produtos/adicionar';
            dados = $('#form-adicionar-produto').serialize();
            $.ajax({
                type: 'post',
                url: urlDestino,
                data: dados,
                success: function(r) {
                    if(r != 'sucesso') {
                        if(r == 'erro_adicionar') {
                            $('#mensagem').html('Erro ao adicionar produto');
                        }
                    } else {
                        alertify.success('Produto adicionado com sucesso');
                    }
                }
            });
        }

    });
});

function isNumber(val) {
    if(val <= 0 || val >= 1 ) {
        return true;
    } else {
        return false;
    }
}

function nomeValido(nome) {
    if(nome.lenght >= 2) {
        return true;
    } else {
        return false;
    }
}