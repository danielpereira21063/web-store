$(document).ready(function() {
    let perguntas = [];
    let respostas = [];
    let perguntasFeitas = 0;
    let valorPergunta = 5;
    let saldoGanho = 0;
    let alternativaCorreta = null;
    let quiz = null;
    let respostaCorreta = null;
    let respostaUsuario = '';
    let acertos = 0;
    let acertosSeguidos = 0;
    let erros = 0;
    // const btnResponder = $('.btn-responder');
    for(let i=0; i<=100; i++) {
        for(let j=1; j<=10; j++) {
            perguntas.push(`${i} x ${j}`);
        }
    }
    for(let i=0; i<=100; i++) {
        for(let j=1; j<=10; j++) {
            respostas.push(i*j);
        }
    }
    
    function principal() {
        limparCodigoHtml();
        quiz = gerarPergunta();
        perguntar(quiz);
        // $('#saldo-ganho').html(`+ R$${saldoGanho},00`);
        $('#valor-pergunta').html(`R$ ${valorPergunta},00`);
        $('#perguntas-feitas').html(`Foram feitas ${perguntasFeitas} perguntas`);
        $('#perguntas-resp-correta').html(`${acertos} acertos`);
        $('#erros').html(`${erros} erros`);
        
        respostaCorreta = respostas[quiz];
        console.log(`Resposta correta: ${respostaCorreta}`);
       
        let posAleatoria = Math.floor(Math.random() * 4);
        $('.p-alternativa')[posAleatoria].innerHTML += respostaCorreta;
        // $('.btn-responder')[posAleatoria].value = respostaCorreta;
        alternativaCorreta = $('.btn-responder')[posAleatoria].value;
        
        console.log('alt correta: '+alternativaCorreta);
        for(let i=0; i<=3; i++) {
            if(i != posAleatoria) {
                alternativa = gerarAlternativa();
                // $('.btn-responder')[i].value = alternativa;
                $('.p-alternativa')[i].innerHTML += alternativa;
            }
        }
    }
    
    $('.p-alternativa').on('click', function(event) {
        btn = event.target;
        respostaUsuario = btn.value;
        $('#resposta').val(respostaUsuario);
        for(let i=0; i <= 3; i++) {
            $('.btn-responder')[i].style.color = 'black';
            $('.btn-responder')[i].style.backgroundColor = '#ccc';
        }
        for(let i=0; i <= 3; i++) {
            if($('.btn-responder')[i] == btn) {
                $('.btn-responder')[i].style.color = '#fff';
                $('.btn-responder')[i].style.backgroundColor = 'green';
            }
        }
    });
    
    $('#responder').on('click', function() {
        if($('#resposta').val() == '') {
            alert('Resposta inválida');
            return;    
        }
        if($('#resposta').val() == alternativaCorreta) {
            perguntasFeitas++;
            saldoGanho = valorPergunta;
            acertos++;
            if(acertos <= 8) {
                valorPergunta += 2;
            } else if(acertos <= 15) {
                valorPergunta += 5;
            } else {
                valorPergunta += 10;
            }
            principal();
            $.ajax({
                type: 'POST',
                url: 'http://127.0.0.1/web-store/saldo/adicionar',
                data: {
                    saldo: saldoGanho,
                },
                success: function(r) {
                    console.log('sal env ', saldoGanho)
                    atualizarSaldoEmConta();
                }
            });
        } else {
            erros++;
            // 
            alert('Que pena, você errou!');
            saldoGanho -= valorPergunta;
            console.log(saldoGanho);
            $.ajax({
                type: 'POST',
                url: 'http://127.0.0.1/web-store/saldo/adicionar',
                data: {
                    saldo: saldoGanho,
                },
                success: function() {
                    console.log('sal env ', saldoGanho);
                    atualizarSaldoEmConta();
                    principal();
                }
            });
        }
    });
    
    function perguntar(quiz) {
        $('#pergunta').html(`Quanto é ${perguntas[quiz]}`);
    }
    function gerarPergunta() {
        return Math.floor(Math.random() * perguntas.length);
    }
    function gerarAlternativa() {
        return Math.floor(Math.random() * respostas.length);
    }
    function limparCodigoHtml() {
        $('.p-alternativa')[0].innerHTML = '<input type="button" class="btn btn-responder ml-2 mr-2" value="a">';
        $('.p-alternativa')[1].innerHTML = '<input type="button" class="btn btn-responder ml-2 mr-2" value="a">';
        $('.p-alternativa')[2].innerHTML = '<input type="button" class="btn btn-responder ml-2 mr-2" value="a">';
        $('.p-alternativa')[3].innerHTML = '<input type="button" class="btn btn-responder ml-2 mr-2" value="a">';
        $('.btn-responder')[0].value = 'a';
        $('.btn-responder')[1].value = 'b';
        $('.btn-responder')[2].value = 'c';
        $('.btn-responder')[3].value = 'd';
        resposta.value = '';
    }
    

    function atualizarSaldoEmConta() {
        $.ajax({
            type: 'POST',
            url: 'http://127.0.0.1/web-store/saldo/SaldoUsuario',
            success: function(r) {
                let dados = JSON.parse(r);
                saldoNaConta = dados['saldo'];
                // $('#saldo-ganho').html(`+ R$${saldoGanho},00`);
                $('#saldo-na-conta').html(`R$${saldoNaConta}`);
                $('#saldo-usuario').html(`R$${saldoNaConta}`);
            }
        });
    }
    atualizarSaldoEmConta();
    principal();
});