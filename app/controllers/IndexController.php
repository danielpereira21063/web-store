<?php

class IndexController extends ControllerBase {
    
    private function controle() {
        if($this->session->has('id_usuario')) {
            //se houver sessão redirecionar o usuário para home
            $this->response->redirect( BASE_URL . '/home');
        }
    }
    
    public function indexAction() {
        $this->controle();
        $this->view->tituloPagina = 'Início';
        $this->view->iconePagina = 'logo.png';
        
    }

}

