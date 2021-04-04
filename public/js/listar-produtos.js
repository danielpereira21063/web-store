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
                <div class="col-12 col-sm-6 col-md-4 col-xl-3 col-lg-4">
                    <div class="mt-2" style="background:#fff"; border-radius: 20px;">
                        <div class="card p-3" style="width: 100%;">
                            <img class="img-fluid" src="http://127.0.0.1/web-store/files/produtos/${produto['foto']}" alt="${produto['nome_produto']}">
                            <div class="caption text-center">
                                <h4>${produto['nome_produto']}</h4>
                                <!--  <small class="text-dark">${produto['descricao']}</small>  -->
                            </div>
                            <p><span class="text-dark" style="font-weight: bold;">Vendido por </span> <small><strong><a href="http://127.0.0.1/web-store/usuario/ver/${produto['id_usuario']}">${produto['vendedor']}</a></strong></small></p>
                            <div class="preco text-danger text-center">
                                <h4>R$ ${produto['preco']}</h4>
                            </div>
                            <p><a class="btn btn-block btn-success text-center" href="http://127.0.0.1/web-store/produtos/comprar/${produto['id_produto']}">Comprar</a></p>
                            <p><a class="btn btn-sm btn-block btn-outline-primary text-center" href="http://127.0.0.1/web-store/produtos/detalhes/${produto['id_produto']}">Detalhes</a></p>
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