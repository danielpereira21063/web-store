<?php

class ComprasController extends ControllerBase {
    public function indexAction() {
        $this->view->tituloPagina = 'Minhas compras';
        $this->view->iconePagina = '';
        $compra = new Compra();
        $id_usuario = $this->session->get('id_usuario');
        $this->view->compras = $compra->listarCompraUsuario($id_usuario);
    }

}