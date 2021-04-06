<?php

class ComprasController extends ControllerBase {
    public function indexAction() {
        $this->view->tituloPagina = 'Minhas compras';
        $this->view->iconePagina = '';
        
        // $this->view->fotoPerfil = $this->fotoPerfil();
    }
}