<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected $saldoUsuario;

    protected function initialize() {
        if($this->session->has('id_usuario')) {
            $user = new Usuario();
            $idUsuario = $this->session->get('id_usuario');
            $this->view->fotoPerfil = $user::findFirstById_usuario($idUsuario)->profile_picture;
            $saldo = new Saldo();
            $this->saldoUsuario = $saldo->saldoUsuario($idUsuario);
        }
    }

    protected function controleAcesso() {
        if(!$this->session->has('id_usuario')) { //se não existir a sessão de usuário
            $this->session->set('acesso_negado', 'Acesso negado! Faça login para ter acesso ao sistema.');
            $this->response->redirect( BASE_URL . '/usuario/login');
        }
    }

}
