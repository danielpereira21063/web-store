<?php
class UsuarioController extends ControllerBase {
    public function indexAction() {
        $this->controleAcesso();
        $this->response->redirect(BASE_URL . '/usuario/ver' );
    }
    
    public function signupAction() {
        $this->view->tituloPagina = 'Criar conta';
        $this->view->iconePagina = 'sign-in.png';
        
        if($this->request->isPost()) {
            $dados = $this->request->getPost();
            //================== IMPORANTÍSSIMO ==============================
            // ============ FAZER VALIDAÇÕES AO LADO DO SERVIDOR ===============
            //=====================================================================
            /* VERIFICA SE OS CAMPOS DO FORMULÁRIO ESTÃO VAZIOS */
            if(in_array('', $dados)) {
                $this->response->setContent('campos_vazios');
                return false;
            }
            /* ----------------------------------------------------------- */
            
            $user = new Usuario();
            // ======================= validações ==========================
            /* VERIFICA SE OS CAMPOS DO FORMULÁRIO SÃO Válidos */
            if($user->emailExiste($dados['email'])) {
                $this->response->setContent('email_existe');
                return false;
            }
            
            if(!$user->nomeValido($dados['nome'])) {
                $this->response->setContent('nome_invalido');
                return false;
            }
            
            if(!$user->emailValido($dados['email'])) {
                $this->response->setContent('email_invalido');
                return false;
            }
            
            if(!$user->senhaValida($dados['senha'])) {
                $this->response->setContent('senha_invalida');
                return false;
            }
            
            if(!$user->senhasConferem($dados['senha'], $dados['confirm_senha'])) {
                $this->response->setContent('senhas_nao_conferem');
                return false;
            }


            //================== tudo pronto para armazenar os dados =========================
            if($user->signupArmazenar($dados)) {
                //redirecionar para a página de 'conta criada com sucesso'
                $this->session->set('signup_sucesso', 'Seu cadastro foi realizado com sucesso!');
                $this->response->setContent('1');
                return false;
            } else {
                $this->response->setContent('erro_armazenar');
                return false;
            }
            return false;
        }
    }


    public function loginAction() {
        $this->view->tituloPagina = 'Login';
        $this->view->iconePagina = 'login.png';

        if($this->request->isPost()) {
            $user = new Usuario();
            $dados = $this->request->getPost();

            if(in_array('', $dados)) {
                return false;
            }

            if($user->login($dados)) { //se email ou senha estiverem corretos
                $dadosParaSessao = $user::findFirstByEmail($dados['email']);
                if($this->session->has('id_usuario')) { //se já existir sessão, remove os dados da sessão ativa
                    $this->session->remove('id_usuario');
                    $this->session->remove('usuario');
                    $this->session->remove('email');
                }
                $this->session->set('id_usuario', $dadosParaSessao->id_usuario);
                $this->session->set('usuario', $dadosParaSessao->nome);
                $this->session->set('email', $dadosParaSessao->email);

                $this->response->setContent('1');
            } else {
                return false;
            }
        }
    }

    public function signup_sucessoAction() {
        if(!$this->session->has('signup_sucesso')) { //se não existir sessão
            $this->response->redirect(BASE_URL . '/usuario/signup');
        }
        $this->view->tituloPagina = 'Conta criada com sucesso';
        $this->view->iconePagina = 'sign-in.png';
    }

    public function logoutAction() {
        $this->session->remove('id_usuario');
        $this->session->remove('usuario');
        $this->session->remove('email');
        $this->response->redirect(BASE_URL);
    }

    public function perfilAction() {
        $this->controleAcesso();

        $this->view->tituloPagina = 'Perfil';
        $this->view->iconePagina = 'user.png';
    }
    
    public function editarAction() {
        $this->controleAcesso();

        $this->view->tituloPagina = 'Editar perfil';
        $this->view->iconePagina = 'user.png';
        $idUsuario = $this->session->get('id_usuario');
        
        if($this->request->isPost()) {
            $user = new Usuario();
            if(!empty($_FILES['profile_picture']['name'])) {
                $maxWidth = 1024;
                $maxHeight = 1024;
                $maxSize = 524288; //aproximadamente 512kb
                $fotoPerfil = $_FILES['profile_picture'];
                if(!preg_match("/^image\/(jpg|png|jpeg|pjpg)$/", $fotoPerfil['type'])) { //se o arquivo não for uma imagem
                    $this->view->erro = '<p class="alert alert-danger">O tipo de arquivo enviado não é permitido</p>';
                    return false;
                }
                
                //verifica se as dimensões da imagem são válidas
                $dimensoesProduto = getimagesize($fotoPerfil['tmp_name']);
                if($dimensoesProduto[0] > $maxWidth || $dimensoesProduto[1] > $maxHeight) {
                    $this->view->erro = '<p class="alert alert-danger">As dimensões do arquivo excedem o tamanho máximo permitido</p>';
                    return false;
                }

                //verifica se o tamanho do arquivo é válido
                if($fotoPerfil['size'] >  $maxSize) {
                    $this->view->erro = '<p class="alert alert-danger">O arquivo enviado excede o tamanho máximo permitido</p>';
                    return false;
                }

                //armazena a imagem do produto na base de dados
                $nomefotoPerfil = uniqid() . '_' . $fotoPerfil['name'];
                $user->atualizarImagemPerfil($nomefotoPerfil, $idUsuario);
                move_uploaded_file($fotoPerfil['tmp_name'], 'files/usuarios/perfil/'.$nomefotoPerfil);
            }
            $this->session->set('perfil_atualizado', true);
            $this->response->redirect(BASE_URL . '/usuario/perfil');
        }
    }
    
    public function verAction($id = null) {
        $this->view->tituloPagina = 'Listar usuário(s)';
        $this->view->iconePagina = '';
        $usuario = new Usuario();
        $this->view->allUsers = true;
        if($id == null) {
            if($this->request->isPost()) {
                $nome = $this->request->getPost('pesquisa');
                $usuario = new Usuario();
                $result = $usuario->pesquisarUsuario($nome);
                echo json_encode($result);
                return false;
            }
        }

        if($id != null) {
            $this->view->allUsers = false;
            $this->view->dados = $usuario::findFirstById_usuario($id);
        }
    }

    public function excluirAction() {
        
    }


}