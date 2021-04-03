let dados = null;
let nome_produto = null;
let quant = null;
let preco = null;
let foto = null;
let desc = null;
let dataAdicao = null;
const rowProduto = document.getElementById('row-produtos');

$.ajax({
    url: 'http://127.0.0.1/web-store/produtos',
    type: 'POST',
    success: function(r) {
        dados = JSON.parse(r);
        dados.forEach(produto => {
            rowProduto.innerHTML += `
                <div class="col-sm-6 col-md-3">
                    <div class="card mt-2 p-3">
                        <div class="thumbnail">
                            <img class="img-fluid" src="http://127.0.0.1/web-store/files/produtos/${produto['foto']}" alt="${produto['']}">
                            <div class="caption text-center">
                                <h3>${produto['nome_produto']}</h3>
                                <p><?//= $produto->descricao ?></p>
                                </div>
                            <p>Vendido por: <strong><a href="http://127.0.0.1/usuario/ver/${produto['id_usuario']}">${produto['vendedor']}</a></strong></p>
                            <p><a class="btn btn-block btn-outline-success text-center" href="">Comprar</a></p>
                        </div>
                    </div>
                </div>`;
        });
    }
});

// <div class="col-sm-6 col-md-3">
//             <div class="card mt-2">
//                 <div class="thumbnail">
//                     <img class="img-fluid" src="<?//= BASE_URL . '/files/produtos/' . $produto->foto ?>" alt="">
//                     <div class="caption text-center">
//                         <h3><?//= $produto->nome_produto ?></h3>
//                         <p><?//= $produto->descricao ?></p>
//                         <p>Vendido por: <strong><?//= $venderdor ?></strong></p>
//                         <p><a class="btn btn-primary" href="">Comprar</a></p>
//                     </div>
//                 </div>
//             </div>
//         </div>