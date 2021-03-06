<?php
class ProdutosController extends ControllerBase {

    public function indexAction() {
        $this->controleAcesso();

        $this->view->tituloPagina = 'Produtos';
        $this->view->iconePagina = '';
        // $this->view->fotoPerfil = $this->fotoPerfil();

        if($this->request->isPost()) {
            $idUsuario = $this->session->get('id_usuario');
            $produto = new Produto();
            $produtos = $produto->listarTodos($idUsuario);
            echo json_encode($produtos);
            return false;
        }
        
    }

    public function meusAction() {
        $this->controleAcesso();

        $this->view->tituloPagina = 'Meus produtos';
        $this->view->iconePagina = '';
        // $this->view->fotoPerfil = $this->fotoPerfil();

        if($this->request->isPost()) {
            $produto = new Produto();
            $idUsuario = $this->session->get('id_usuario');
            $produtos = $produto->listarPorIdUsuario($idUsuario);
            echo json_encode($produtos);
            return false;
        }
    }
    

    public function pesquisarAction() {
        $this->controleAcesso();

        if($this->request->isPost()) {
            $pesquisa = $this->request->getPost('pesquisa');
            $idUsuario = $this->session->get('id_usuario');
            $produto = new Produto();
            $resultado = $produto->pesquisar($pesquisa, $idUsuario);
            echo json_encode($resultado);
            return false;
        }
        
    }

    public function pesquisarPorUsuarioAction() {
        $this->controleAcesso();

        if($this->request->isPost()) {
            $pesquisa = $this->request->getPost('pesquisa');
            $idUsuario = $this->session->get('id_usuario');
            $produto = new Produto();
            $resultado = $produto->pesquisarPorUsuario($pesquisa, $idUsuario);
            echo json_encode($resultado);
            return false;
        }
    }
    

    public function adicionarAction() {
        $this->controleAcesso();

        $this->view->tituloPagina = 'Adicionar produto';
        $this->view->iconePagina = '';
        // $this->view->fotoPerfil = $this->fotoPerfil();

        if($this->request->isPost()) {
            $produto = new Produto();
            $dados = $this->request->getPost();
            $dados['id_usuario'] = $this->session->get('id_usuario');
            $sucesso = false;
            if(!$produto->adicionar($dados)) {
                return false;
            }
            $sucesso = true;
            if(!empty($_FILES['img_produto']['name'])) { //se for feito o upload de uma imagem
                //fazer o upload da imagem do produto
                $maxWidth = 1024;
                $maxHeight = 1024;
                $maxSize = 524288; //aproximadamente 512kb
                $imgProduto = $_FILES['img_produto'];
                if(!preg_match("/^image\/(jpg|png|jpeg|pjpg)$/", $imgProduto['type'])) { //se o arquivo n??o for uma imagem
                    $this->session->set('erro', '<p class="alert alert-danger text-center">O tipo de arquivo enviado n??o ?? permitido</p>');
                    $this->response->redirect(BASE_URL . '/produtos/meus' );
                    return false;
                }
                
                //verifica se as dimens??es da imagem s??o v??lidas
                $dimensoesProduto = getimagesize($imgProduto['tmp_name']);
                if($dimensoesProduto[0] > $maxWidth || $dimensoesProduto[1] > $maxHeight) {
                    $this->session->set('erro', '<p class="alert alert-danger text-center">As dimens??es do arquivo enviado excedem o tamanho m??ximo permitido</p>');
                    $this->response->redirect(BASE_URL . '/produtos/meus' );
                    return false;
                }
                
                //verifica se o tamanho do arquivo ?? v??lido
                if($imgProduto['size'] >  $maxSize) {
                    $this->view->erro = '<p class="alert alert-danger text-center">O arquivo enviado excede o tamanho m??ximo permitido</p>';
                    return false;
                }
                
                //armazena a imagem do produto na base de dados
                $nomeImgProduto = uniqid() . '_' . $imgProduto['name'];
                $produto->adicionarImagemProduto($nomeImgProduto);
                move_uploaded_file($imgProduto['tmp_name'], 'files/produtos/'.$nomeImgProduto);
                $sucesso = true;
            }
            if($sucesso) {
                $this->session->set('produto_adicionado', true);
            } else {
                $this->session->set('produto_adicionado', false);
            }
            $this->response->redirect(BASE_URL . '/produtos/meus');
        }
    }

    public function editarAction($id = null) {
        $this->controleAcesso();

        if(!$id) {
            $this->response->redirect(BASE_URL . '/produtos/meus');
            return false;
        }

        $this->view->tituloPagina = 'Editar produto';
        $this->view->iconePagina = '';
        // $this->view->fotoPerfil = $this->fotoPerfil();
        $produto = new Produto();
        $this->view->produto = $produto::findFirstById_produto($id);
        $sucesso = false;

        if($this->request->isPost()) {
            $dados = $this->request->getPost();
            if($produto->atualizarProduto($id, $dados)) {
                $sucesso = true;
            }
            if(!empty($_FILES['img_produto']['name'])) { //se for feito o upload de uma imagem
                $sucesso = false;
                //fazer o upload da imagem do produto
                $maxWidth = 1024;
                $maxHeight = 1024;
                $maxSize = 524288; //aproximadamente 512kb
                $imgProduto = $_FILES['img_produto'];
                if(!preg_match("/^image\/(jpg|png|jpeg|pjpg)$/", $imgProduto['type'])) { //se o arquivo n??o for uma imagem
                    $this->session->set('erro', '<p class="alert alert-danger text-center">O tipo de arquivo enviado n??o ?? permitido</p>');
                    $this->response->redirect(BASE_URL . '/produtos/meus' );
                    return false;
                }
                
                //verifica se as dimens??es da imagem s??o v??lidas
                $dimensoesProduto = getimagesize($imgProduto['tmp_name']);
                if($dimensoesProduto[0] > $maxWidth || $dimensoesProduto[1] > $maxHeight) {
                    $this->session->set('erro', '<p class="alert alert-danger text-center">As dimens??es do arquivo enviado excedem o tamanho m??ximo permitido</p>');
                    $this->response->redirect(BASE_URL . '/produtos/meus' );
                    return false;
                }
                
                //verifica se o tamanho do arquivo ?? v??lido
                if($imgProduto['size'] >  $maxSize) {
                    $this->session->set('erro', '<p class="alert alert-danger text-center">O arquivo enviado excede o tamanho m??ximo permitido</p>');
                    $this->response->redirect(BASE_URL . '/produtos/meus' );
                    return false;
                }
                
                //armazena a imagem do produto na base de dados
                $nomeImgProduto = uniqid() . '_' . $imgProduto['name'];
                $produto->atualizarImagemProduto($id, $nomeImgProduto);
                move_uploaded_file($imgProduto['tmp_name'], 'files/produtos/'.$nomeImgProduto);
                $sucesso = true;
            }
            if($sucesso) {
                $this->session->set('produto_atualizado', true);
                $this->response->redirect(BASE_URL . '/produtos/meus' );
            } else {
                $this->session->set('produto_atualizado', false);
                $this->response->redirect(BASE_URL . '/produtos/meus' );
            }
        }


    }

    public function excluirAction($id = null) {
        $this->controleAcesso();
        $this->view->tituloPagina = 'Excluir produto';
        $this->view->iconePagina = '';
        if(!$id) {
            return false;
        }
        $produto = new Produto();
        $idUserLogado = $this->session->get('id_usuario');
        $idUserCadastrado = $produto::findFirstById_produto($id)->id_usuario;
        $this->view->produto = $produto::findFirstById_produto($id);
        if($this->request->isPost()) {
            $confirm = $this->request->getPost('confirm');
            var_dump($this->request->getPost());
            if(!$confirm) {
                $this->session->set('cancelado', true);
                $this->response->redirect(BASE_URL . '/produtos/meus');
                return false;
            }
            if($idUserLogado != $idUserCadastrado) {
                $this->session->set('erro', '<p class="alert alert-danger text-center">Voc?? n??o tem permiss??o para excluir esse produto</p>');
                $this->response->redirect(BASE_URL . '/produtos/meus');
                return false;
            }
            if($produto->excluir($id)) {
                $produto->excluir($id);
                $this->session->set('produto_excluido', true);
                $this->response->redirect(BASE_URL . '/produtos/meus');
                return false;
            } else {
                $this->session->set('produto_excluido', false);
                $this->response->redirect(BASE_URL . '/produtos/meus');
                return false;
            }
        }
    }


    public function comprarAction($id = null) {
        $this->controleAcesso();
        $this->view->tituloPagina = 'Comprar';
        $this->view->iconePagina = '';

        if(!$id) {
            return false;
        }

        $produtoModel = new Produto();
        $produto = $produtoModel->listarPorIdProduto($id);
        $precoProduto = $produtoModel->listarPorIdProduto($id)['preco'];
        $saldoUser = $this->saldoUsuario['saldo'];
        $precoProduto = str_replace(',', '.', $precoProduto);
        $this->view->produto = $produto;
        $saldoAposCompra = str_replace('.',',', $saldoUser - $precoProduto);
        $this->view->saldoAposCompra = $saldoAposCompra;

        if(!$this->request->isPost()) {
            return;
        }
        $confirm = $this->request->getPost('confirm_compra');
        
        if($confirm) {
            $idUser = $this->session->get('id_usuario');
            $idVendedor = $produtoModel::findFirstById_produto($id)->id_usuario;
            $produtoModel->comprarProduto($idUser, $idVendedor, $id);
            $this->session->set('compra_realizada', true);
            $this->response->redirect(BASE_URL . '/produtos/compra_realizada/'.$id);
        }
    }


    public function compra_realizadaAction($id_produto) {
        $this->controleAcesso();
        $this->view->tituloPagina = 'Compra realizada';
        $this->view->iconePagina = '';
        $produto = new Produto();
        $this->view->produto = $produto::findFirstByIdProduto($id_produto);
    }


    public function detalhesAction($id) {
        $this->controleAcesso();
        $this->view->tituloPagina = 'Detalhes do produto';
        $this->view->iconePagina = '';
        $produto = new Produto();
        $this->view->produto = $produto->listarPorIdProduto($id);
    }
}