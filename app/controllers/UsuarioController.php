<?php
class UsuarioController extends ControllerBase {
    public function indexAction() {
        $this->response->redirect(BASE_URL . '/usuario/login');
    }

    private function controleAcesso() {
        if(!$this->session->has('id_usuario')) { //se não existir a sessão de usuário
            $this->session->set('acesso_negado', 'Acesso negado! Faça login para ter acesso ao sistema.');
            $this->response->redirect( BASE_URL . '/usuario/login');
        }
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
        }
    }


    public function loginAction() {
        $this->view->tituloPagina = 'Login';
        $this->view->iconePagina = 'login.png';

        if($this->request->isPost()) {
            $dados = $this->request->getPost();

            if(in_array('', $dados)) {
                return false;
            }

            $user = new Usuario();
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
        $this->view->tituloPagina = 'Conta criada com sucesso';
        $this->view->iconePagina = 'sign-in.png';
        if(!$this->session->has('signup_sucesso')) { //se não existir sessão
            $this->response->redirect(BASE_URL . '/usuario/signup');
        }
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
    }
    
    public function excluirAction() {
        
    }
}