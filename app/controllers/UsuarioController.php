<?php
class UsuarioController extends ControllerBase {

    public function indexAction() {
        return $this->response->redirect(BASE_URL . '/usuario/login');
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
                return $this->response->setContent('campos_vazios');
            }
            /* ----------------------------------------------------------- */
            
            $user = new Usuario();
            // exit;
            // ======================= validações ==========================
            /* VERIFICA SE OS CAMPOS DO FORMULÁRIO SÃO Válidos */
            if($user->emailExiste($dados['email'])) {
                return $this->response->setContent('email_existe');
                // return 'email_existe';
            }
            
            if(!$user->nomeValido($dados['nome'])) {
                return $this->response->setContent('nome_invalido');
            }
            
            if(!$user->emailValido($dados['email'])) {
                return $this->response->setContent('email_invalido');
            }
            
            if(!$user->senhaValida($dados['senha'])) {
                return $this->response->setContent('senha_invalida');
            }
            
            if(!$user->senhasConferem($dados['senha'], $dados['confirm_senha'])) {
                return $this->response->setContent('senhas_nao_conferem');
            }


            //================== tudo pronto para armazenar os dados =========================
            if($user->signupArmazenar($dados)) {
                //redirecionar para a página de 'conta criada com sucesso'
                $this->session->set('signup_sucesso', 'Seu cadastro foi realizado com sucesso!');
                return $this->response->setContent(1);
            } else {
                return $this->response->setContent('erro_armazenar');
            }
            return false;
        }
    }


    public function loginAction() {
        $this->view->tituloPagina = 'Login';
        $this->view->iconePagina = 'login.png';

        if($this->request->isPost()) {
            $dados = $this->request->getPost();

            $this->view->dados = $dados;

            if(in_array('', $dados)) {
                return false;
            }

            $user = new Usuario();
            if(!$user->login($dados)) { //se email ou senha estiverem incorretos
                return false;
            } else {
                return '1';
            }
            return false;
        }
    }

    public function signup_sucessoAction() {
        $this->view->tituloPagina = 'Conta criada com sucesso';
        $this->view->iconePagina = 'sign-in.png';
        if(!$this->session->has('signup_sucesso')) { //se não existir sessão
            return $this->response->redirect(BASE_URL . '/usuario/login');
        }
    }
}