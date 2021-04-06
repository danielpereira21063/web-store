<?php

class IndexController extends ControllerBase {
    
    public function indexAction() {
        if($this->session->has('id_usuario')) {
            //se houver sessão redirecionar o usuário para home
            $this->response->redirect( BASE_URL . '/home');
        }
        
        $this->view->tituloPagina = 'Início';
        $this->view->iconePagina = 'logo.png';
        
    }

}

