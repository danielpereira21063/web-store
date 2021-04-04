<?php
class VendasController extends ControllerBase {
    
    private function controleAcesso() {
        if(!$this->session->has('id_usuario')) { //se não existir a sessão de usuário
            $this->session->set('acesso_negado', 'Acesso negado! Faça login para ter acesso ao sistema.');
            $this->response->redirect( BASE_URL . '/usuario/login');
        }
    }

    public function indexAction() {
        $this->controleAcesso();

        $this->view->tituloPagina = 'Minhas vendas';
        $this->view->iconePagina = '';
    }

}
