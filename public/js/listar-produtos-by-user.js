let dados = null;
let nome_produto = null;
let quant = null;
let preco = null;
let foto = null;
let desc = null;
let dataAdicao = null;
const rowProduto = document.getElementById('row-produtos');

$.ajax({
    url: 'http://127.0.0.1/web-store/produtos/meus',
    type: 'POST',
    success: function(r) {
        dados = JSON.parse(r);
        console.log(dados);
        //verificar o tamanho do array dados e dizer se o user possui produtos ou não
        dados.forEach(produto => {
            rowProduto.innerHTML += `
                <div class="col-md-4 col-sm-6 col-xl-3">
                    <div class="card mt-3">
                        <div class="produto-div align-items-center p-2 text-center">
                        <img src="http://127.0.0.1/web-store/files/produtos/${produto['foto']}" alt="${produto['nome_produto']}" class="rounded" width="160px">
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
});

`

`
