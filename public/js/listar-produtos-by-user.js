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
        url: 'http://127.0.0.1/web-store/produtos/pesquisarPorUsuario',
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
                                <h3 class="text-dark text-center p-4">Nenhum resultado encontrado</h3>
                            </div>
                        </div>
                    </div>
                `
            } else {
                result.forEach(produto => {
                    rowProduto.innerHTML += `
                    <div class="col-md-4 col-sm-6 col-xl-3">
                        <div class="card mt-3">
                            <div class="produto-div align-items-center p-2 text-center">
                            <img src="http://127.0.0.1/web-store/files/produtos/${produto['foto']}" alt="${produto['nome_produto']}" class="img-fluid">
                            <h5>${produto['nome_produto']}</h5>
                            
                            <div class="preco mt-3 text-dark">
                                <span>R$ ${produto['preco']}</span>
                            </div>
                        </div>
                            <div class="p-3 produto mt-3" style="background-color: #eee;">
                                <a href="editar/${produto['id_produto']}" class="btn btn-sm btn-primary float-left"><i class="fa fa-pencil text-light mr-2"></i>Editar</a>
                                <a href="excluir/${produto['id_produto']}" class="btn btn-sm btn-danger float-right"><i class="fa fa-trash text-light mr-2"></i>Excluir</a>
                            </div>
                        </div>
                    </div>`;
                });
            }
        }
    });
});



$.ajax({
    url: 'http://127.0.0.1/web-store/produtos/meus',
    type: 'POST',
    success: function(r) {
        dados = JSON.parse(r);
        if(dados.length == 0) {
            rowProduto.innerHTML = `
                <div class="col-12 mt-2 mb-2">
                    <div class="mt-5 mb-5">
                        <div>
                            <h3 class="text-dark text-center p-5">Ooops, parece que você não tem nenhum produto cadastrado.</h3>
                        </div>
                    </div>
                </div>
            `
        } else {
            dados.forEach(produto => {
                rowProduto.innerHTML += `
                    <div class="col-md-4 col-sm-6 col-xl-3">
                        <div class="card mt-3">
                            <div class="produto-div align-items-center p-2 text-center">
                            <img src="http://127.0.0.1/web-store/files/produtos/${produto['foto']}" alt="${produto['nome_produto']}" class="img-fluid">
                            <h5>${produto['nome_produto']}</h5>
                            
                            <div class="preco mt-3 text-dark">
                                <span>R$ ${produto['preco']}</span>
                            </div>
                        </div>
                            <div class="p-3 produto mt-3" style="background-color: #eee;">
                                <a href="editar/${produto['id_produto']}" class="btn btn-sm btn-primary float-left"><i class="fa fa-pencil text-light mr-2"></i>Editar</a>
                                <a href="excluir/${produto['id_produto']}" class="btn btn-sm btn-danger float-right"><i class="fa fa-trash text-light mr-2"></i>Excluir</a>
                            </div>
                        </div>
                    </div>`;
            });
        }
        //verificar o tamanho do array dados e dizer se o user possui produtos ou não
    }
});


