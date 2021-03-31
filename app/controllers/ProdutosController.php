<?php

class ProdutosController extends ControllerBase {
    public function indexAction() {

    }
    public function meusAction() {
        $this->view->tituloPagina = 'Meus produtos';
        $this->view->iconePagina = '';
    }
}