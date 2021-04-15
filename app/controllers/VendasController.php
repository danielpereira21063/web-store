<?php
class VendasController extends ControllerBase {

    public function indexAction() {
        $this->controleAcesso();
        

        $this->view->tituloPagina = 'Minhas vendas';
        $this->view->iconePagina = '';
        $venda = new Venda();
        $id_usuario = $this->session->get('id_usuario');
        $this->view->vendas = $venda->listarVendaUsuario($id_usuario);
    }

}
