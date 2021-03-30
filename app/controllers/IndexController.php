<?php

class IndexController extends ControllerBase
{
    private function controle() {
        if(!$this->session->has('id_usuario')) {
            
        }
    }

    public function indexAction() {
        $this->view->tituloPagina = 'Início';
        $this->view->iconePagina = 'logo.png';
    }

}

