<?php

class HomeController extends IndexController {
    public function initialize() {
        if(!$this->session->has('id_usuario')) { //se não existir a sessão de usuário
            $this->session->set('acesso_negado', 'Acesso negado! Faça login para ter acesso ao sistema.');
            $this->response->redirect( BASE_URL . '/usuario/login');
        }
    }
    public function indexAction() {
        $this->view->iconePagina = 'home.png';
        $this->view->tituloPagina = 'Início';
    }
}
