$(document).ready(function() {
    const nomeProduto = $('#nome-produto');
    const descricao = $('#desc-produto');
    const quant = $('#quant');
    const preco = $('#preco');
    
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


        if(erros == 0) {
            if(!isNumber(preco.val())) {
                preco.addClass('is-invalid');
                $('#preco-erro').html('O valor inserido não é um número');
                return;
            }
            //enviar dados
            // const urlDestino = 'http://127.0.0.1/web-store/produtos/adicionar';
            // return;
            // $.ajax({
            //     type: 'POST',
            //     url: urlDestino,
            //     data: $('#form-adicionar-produto').serialize(),
            //     // contentType: false,
            //     // proccessData: false,
            //     success: function(r) {
            //         // JSON.parse(r);
            //         console.log(r);
            //     }
            // });
            $('#form-adicionar-produto').submit();
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