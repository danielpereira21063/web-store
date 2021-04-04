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

        $this->view->tituloPagina = 'Produtos';
        $this->view->iconePagina = '';

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

        if($this->request->isPost()) {
            $produto = new Produto();
            $idUsuario = $this->session->get('id_usuario');
            $produtos = $produto->listarPorIdUsuario($idUsuario);
            echo json_encode($produtos);
            return false;
        }
    }

    public function adicionarAction() {
        $this->controleAcesso();

        $this->view->tituloPagina = 'Adicionar produto';
        $this->view->iconePagina = '';

        if($this->request->isPost()) {
            $produto = new Produto();
            $dados = $this->request->getPost();
            $dados['id_usuario'] = $this->session->get('id_usuario');
            
            if(!$produto->adicionar($dados)) {
                $this->view->erro = '<p class="alert alert-danger">Erro ao adicionar produto</p>'; //se não cadastrar o produto
            }

            if(!empty($_FILES['img_produto']['name'])) { //se for feito o upload de uma imagem
                //fazer o upload da imagem do produto
                $maxWidth = 1024;
                $maxHeight = 1024;
                $maxSize = 524288; //aproximadamente 512kb
                $imgProduto = $_FILES['img_produto'];
                if(!preg_match("/^image\/(jpg|png|jpeg|pjpg)$/", $imgProduto['type'])) { //se o arquivo não for uma imagem
                    $this->view->erro = '<p class="alert alert-danger">O tipo de arquivo enviado não é permitido</p>';
                    return false;
                }
    
                //verifica se as dimensões da imagem são válidas
                $dimensoesProduto = getimagesize($imgProduto['tmp_name']);
                if($dimensoesProduto[0] > $maxWidth || $dimensoesProduto[1] > $maxHeight) {
                    $this->view->erro = '<p class="alert alert-danger">As dimensões do arquivo excedem o tamanho máximo permitido</p>';
                    return false;
                }
                
                //verifica se o tamanho do arquivo é válido
                if($imgProduto['size'] >  $maxSize) {
                    $this->view->erro = '<p class="alert alert-danger">O arquivo enviado excede o tamanho máximo permitido</p>';
                    return false;
                }
    
                //armazena a imagem do produto na base de dados
                $nomeImgProduto = uniqid() . '_' . $imgProduto['name'];
                $produto->atualizarImagemProduto($nomeImgProduto);
                move_uploaded_file($imgProduto['tmp_name'], 'files/produtos/'.$nomeImgProduto);
            }
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

    public function atualizarFoto() {
        $this->controleAcesso();

        if($this->request->isPost()) {
            $produto = new Produto();
            /*if(!empty($_FILES['img_produto']['name'])) { //se for feito o upload de uma imagem
                //fazer o upload da imagem do produto
                $maxWidth = 1024;
                $maxHeight = 1024;
                $maxSize = 524288; //aproximadamente 512kb
                $imgProduto = $_FILES['img_produto'];
                if(!preg_match("/^image\/(jpg|png|jpeg|pjpg)$/", $imgProduto['type'])) { //se o arquivo não for uma imagem
                    $this->response->setContent('tipo_nao_permitido');
                    return false;
                }
    
                //verifica se as dimensões da imagem são válidas
                $dimensoesProduto = getimagesize($imgProduto['tmp_name']);
                if($dimensoesProduto[0] > $maxWidth || $dimensoesProduto[1] > $maxHeight) {
                    $this->response->setContent('demensao_excede');
                    return false;
                }
                
                //verifica se o tamanho do arquivo é válido
                if($imgProduto['size'] >  $maxSize) {
                    $this->response->setContent('tamanho_excede');
                    return false;
                }
    
                //armazena a imagem do produto na base de dados
                $nomeImgProduto = uniqid() . '_' . $imgProduto['name'];
                if(!$produto->atualizarImagemProduto($nomeImgProduto)) {
                    move_uploaded_file($imgProduto['tmp_name'], './files/produtos/'.$nomeImgProduto);
                    $this->response->setContent('erro_armazenar');
                    return false;
                }
    
                
                //cadastro efetuado com sucesso
                $this->response->setContent('foto_atualizada_sucesso');
            }
            return false;
            */
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