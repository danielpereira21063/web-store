<?php
class UsuarioController extends ControllerBase {

    public function indexAction() {
        
    }

    public function signupAction() {
        if($this->request->isPost()) {
            $dados = [
                'nome'          => $this->request->getPost('nome'),
                'email'         => $this->request->getPost('email'),
                'senha'         => $this->request->getPost('senha'),
                'confirm_senha' => $this->request->getPost('confirm_senha')
            ];

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
            if(!$user->emailValido($dados['email'])) {//se retornar false cairá nessa condição
                $this->view->email_erro = 'E-mail inválido';
                return;
            }

            if(!$user->nomeValido($dados['nome'])) {
                $this->view->nome_erro = 'Nome inválido';
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
                }
            } else {
                $this->view->mensagem = 'Ooops! parece que existem alguns campos em branco. Preencha-os para prosseguir com seu cadastro.';
            }
        }
    }

    public function loginAction() {

    }
}