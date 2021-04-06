let dados = null;
let nome_produto = null;
let quant = null;
let preco = null;
let foto = null;
let desc = null;
let dataAdicao = null;
const rowProduto = document.getElementById('row-produtos');

$('#pesquisar').on('keyup', ()=>{
    pesquisa = $('#pesquisar').val();
    $.ajax({
        url: 'http://127.0.0.1/web-store/produtos/pesquisar',
        type: 'POST',
        data: {
            pesquisa: $('#pesquisar').val()
        },
        success: function(r) {
            result = JSON.parse(r);
            rowProduto.innerHTML = '';
            if(result.length == 0) {
                rowProduto.innerHTML = `
                    <div class="col-12 mt-3 mb-5">
                        <div class="mt-5 mb-5">
                            <div>
                                <h3 class="text-dark text-center p-3">Nenhum resultado encontrado</h3>
                            </div>
                        </div>
                    </div>
                `
            } else {
                result.forEach(produto => {
                    rowProduto.innerHTML += `
                    <div class="col-sm-6 col-md-4 col-xl-3 col-lg-4 col-xs-6">
                        <div class="mt-2" style="background:#fff"; border-radius: 20px;">
                            <div class="card p-3" style="width: 100%;">
                                <img class="img-fluid" src="http://127.0.0.1/web-store/files/produtos/${produto['foto']}" alt="${produto['nome_produto']}">
                                <div class="caption text-center mt-1">
                                    <h4>${produto['nome_produto']}</h4>
                                    <!--  <small class="text-dark">${produto['descricao']}</small>  -->
                                    <p class="text-center text-success"><small><strong>${produto['quantidade']} Disponíveis</strong></small></p>
                                </div>
                                <p><small><span class="text-dark" style="font-weight: bold;">Vendido por </span>&nbsp;<img width="28px" class="rounded-circle" src="http://127.0.0.1/web-store/files/usuarios/perfil/${produto['foto_vendedor']}"><strong><a href="http://127.0.0.1/web-store/usuario/ver/${produto['id_usuario']}">&nbsp;${produto['vendedor']}</small></a></strong></p>
                                <div class="preco text-danger text-center">
                                    <h5>R$ ${produto['preco']}</h5>
                                </div>
                                <a class="btn btn-block btn-success text-center" href="http://127.0.0.1/web-store/produtos/comprar/${produto['id_produto']}">Comprar</a>
                                <a class="btn btn-sm btn-block btn-outline-primary text-center" href="http://127.0.0.1/web-store/produtos/detalhes/${produto['id_produto']}">Detalhes</a>
                            </div>
                        </div>
                    </div>`;
                });
            }
        }
    });
});

$.ajax({
    url: 'http://127.0.0.1/web-store/produtos',
    type: 'POST',
    success: function(r) {
        dados = JSON.parse(r);
        dados.forEach(produto => {
            rowProduto.innerHTML += `
                <div class="col-sm-6 col-md-4 col-xl-3 col-lg-4 col-xs-6">
                    <div class="mt-2" style="background:#fff"; border-radius: 20px;">
                        <div class="card p-3" style="width: 100%;">
                            <img class="img-fluid" src="http://127.0.0.1/web-store/files/produtos/${produto['foto']}" alt="${produto['nome_produto']}">
                            <div class="caption text-center mt-1">
                                <h4>${produto['nome_produto']}</h4>
                                <!--  <small class="text-dark">${produto['descricao']}</small>  -->
                                <p class="text-center text-success"><small><strong>${produto['quantidade']} Disponíveis</strong></small></p>
                            </div>
                            <p><small><span class="text-dark" style="font-weight: bold;">Vendido por </span>&nbsp;<img width="28px" class="rounded-circle" src="http://127.0.0.1/web-store/files/usuarios/perfil/${produto['foto_vendedor']}"><strong><a href="http://127.0.0.1/web-store/usuario/ver/${produto['id_usuario']}">&nbsp;${produto['vendedor']}</small></a></strong></p>
                            <div class="preco text-danger text-center">
                                <h5>R$ ${produto['preco']}</h5>
                            </div>
                            <a class="btn btn-block btn-success text-center" href="http://127.0.0.1/web-store/produtos/comprar/${produto['id_produto']}">Comprar</a>
                            <a class="btn btn-sm btn-block btn-outline-primary text-center" href="http://127.0.0.1/web-store/produtos/detalhes/${produto['id_produto']}">Detalhes</a>
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