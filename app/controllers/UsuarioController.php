<?php
class UsuarioController extends ControllerBase {

    public function indexAction() {
        return $this->response->redirect(BASE_URL . '/usuario/login');
    }

    public function signupAction() {
        
        if($this->request->isPost()) {
            $dados = $this->request->getPost();

            $this->view->dados = $dados;

            /* VERIFICA SE OS CAMPOS DO FORMULÁRIO ESTÃO VAZIOS */

            if(in_array('', $dados)) {
                if(empty($dados['nome'])) {
                    $this->view->nome_erro = 'Insira seu nome para prosseguir';
                }
                if(empty($dados['email'])) {
                    $this->view->email_erro = 'Insira seu e-mail para prosseguir';
                }
                if(empty($dados['senha'])) {
                    $this->view->senha_erro = 'Insira uma senha para prosseguir';
                }
                if(empty($dados['confirm_senha'])) {
                    $this->view->confirm_senha_erro = 'Confirme sua senha para prosseguir';
                }
                return;
            }
            /* ----------------------------------------------------------- */

            $user = new Usuarios();
            /* VERIFICA SE OS CAMPOS DO FORMULÁRIO SÃO Válidos */
            // ======================= validações ==========================
            if($user->emailExiste($dados['email'])) {
                $this->view->email_erro = 'O e-mail informado já foi cadastrado';
                return;
            }

            if(!$user->nomeValido($dados['nome'])) {
                $this->view->nome_erro = 'Nome inválido';
                return;
            }

            if(!$user->emailValido($dados['email'])) {//se retornar false cairá nessa condição
                $this->view->email_erro = 'E-mail inválido';
                return;
            }

            if(!$user->senhaValida($dados['senha'])) {
                $this->view->senha_erro = 'A senha deve ter no mínimo 6 caracteres';
                return;
            }

            if(!$user->senhasConferem($dados['senha'], $dados['confirm_senha'])) {
                $this->view->confirm_senha_erro = 'As senhas não conferem';
                return;
            }


            //================== tudo pronto para armazenar os dados =========================
            if(!in_array('', $dados)) { //se não existirem campos vazios
                if($user->signupArmazenar($dados)) {
                    //redirecionar para a página de 'conta criada com sucesso'
                    $this->session->set('signup_sucesso', 'Seu cadastro foi realizado com sucesso!');
                    $this->response->redirect(BASE_URL . '/usuario/signup_sucesso');
                    return;
                }
                $this->view->mensagem = 'Erro ao armazenar dados';
            } else {
                $this->view->mensagem = 'Ooops! parece que existem alguns campos em branco. Preencha-os para prosseguir com seu cadastro.';
            }
        }
    }

    public function loginAction() {

        if($this->request->isPost()) {
            $dados = $this->request->getPost();

            $this->view->dados = $dados;

            if(in_array('', $dados)) {
                if(empty($dados['email'])) {
                    $this->view->email_erro = 'E-mail inválido';
                }
                if(empty($dados['senha'])) {
                    $this->view->senha_erro = 'Senha inválida';
                }
                return;
            }

            $user = new Usuarios();
            if(!$user->login($dados)) { //se email ou senha estiverem incorretos
                $this->view->login_invalido = 'E-mail ou senha incorretos';
            }
        }
    }

    public function signup_sucessoAction() {
        if(!$this->session->has('signup_sucesso')) { //se não existir sessão
            return $this->response->redirect(BASE_URL . '/usuario/login');
        }
    }
}