<?php

class ProdutosController extends ControllerBase {
    private function controleAcesso() {
        if(!$this->session->has('id_usuario')) { //se não existir a sessão de usuário
            $this->session->set('acesso_negado', 'Acesso negado! Faça login para ter acesso ao sistema.');
            $this->response->redirect( BASE_URL . '/usuario/login');
        }
    }
    
    public function indexAction() {
        $this->controleAcesso();
    }

    public function meusAction() {
        $this->controleAcesso();

        $this->view->tituloPagina = 'Meus produtos';
        $this->view->iconePagina = '';
        $produto = new Produto();
        $this->view->produtos = $produto->listarPorId($this->session->get('id_usuario'));
    }

    public function adicionarAction() {
        $this->controleAcesso();

        $this->view->tituloPagina = 'Adicionar produto';
        $this->view->iconePagina = '';

        if($this->request->isPost()) {
            $produto = new Produto();
            if(!empty($_FILES['img_produto']['name'])) { //se for feito o upload de uma imagem
                //fazer o upload da imagem do produto
                $maxWidth = 1024;
                $maxHeight = 1024;
                $maxSize = 524288; //aproximadamente 512kb
                $imgProduto = $_FILES['img_produto'];
                var_dump($imgProduto);
                if(!preg_match("/^image\/(jpg|png|jpeg|pjpg)$/", $imgProduto['type'])) { //se o arquivo não for uma imagem
                    $this->response->setContent('O tipo de arquivo enviado não é permitido');
                    return false;
                }
                //verifica se as dimensões da imagem são válidas
                $dimensoesProduto = getimagesize($imgProduto['tmp_name']);
                if($dimensoesProduto[0] > $maxWidth || $dimensoesProduto[1] > $maxHeight) {
                    $this->response->setContent('As dimensões da imagem excedem o tamanho máximo permitido');
                    return false;
                }
                
                //verifica o tamanho do arquivo
                if($imgProduto['size'] >  $maxSize) {
                    $this->response->setContent('O tamanho da imagem excede o tamanho máximo permitido');
                    return false;
                }

                $nomeImgProduto = uniqid().'_'.$imgProduto['name'];
                if($produto->adicionarImagem($nomeImgProduto)) {
                    move_uploaded_file($imgProduto['tmp_name'], '/files/produtos');
                } else {
                    $this->response->setContent('Erro ao armazenar imagem do produto');
                }

                return false;
            }
            var_dump($_FILES['img_produto']);
            //name
            //type
            //tmp_name
            //error
            //size
            exit;
        }
    }

    public function editarAction($id) {
        $this->controleAcesso();

        $this->view->tituloPagina = 'Editar produto';
        $this->view->iconePagina = '';
        if($id) {
            if(is_int($id)) {

            }
            
        }
    }

    public function excluirAction($id = null) {
        $this->controleAcesso();
        var_dump($id);
        if(!$id) {
            
            return false;
        }
        $produto = new Produto();
        if($produto->excluir($id)) {
            $produto->excluir($id);
            return false;
        }
    }
}