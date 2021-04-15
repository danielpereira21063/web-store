let saldo = 0;

function atualizar() {
    $.ajax({
        type: 'POST',
        url : 'http://127.0.0.1/web-store/saldo/saldoUsuario',
        success: function(r){
            if(r) {
                dados = JSON.parse(r);
                saldo = dados['saldo'];
                console.log(dados);
                console.log(saldo);
                if(saldo > 0) {
                    $('#saldo-usuario').css('color', 'green');
                } else if(saldo < 0) {
                    $('#saldo-usuario').css('color', 'red');
                } else {
                    $('#saldo-usuario').css('color', 'orange');
                }
                $('#saldo-usuario').html(`R$${saldo}`);
            }
        }
    });
}

atualizar();