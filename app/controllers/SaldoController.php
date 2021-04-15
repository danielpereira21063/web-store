<?php

class SaldoController extends ControllerBase {
    public function indexAction() {
        //dashboard com hisórico de saldo
        $this->controleAcesso();
        $this->view->tituloPagina = 'Saldo';
        $this->view->iconePagina = '';
    }

    public function adicionarAction() {
        $this->controleAcesso();
        $this->view->tituloPagina = 'Adicionar dinheiro';
        $this->view->iconePagina = '';
        if($this->request->isPost()) {
            $valor = $this->request->getPost('saldo');
            $idUsuario = $this->session->get('id_usuario');
            $saldo = new Saldo();
            $saldo->adicionar($valor, $idUsuario);
            return false;
        }
    }

    public function saldoUsuarioAction() {
        $this->controleAcesso();
        if($this->request->isPost()) {
            $saldo = new Saldo();
            $idUser = $this->session->get('id_usuario');
            $result = $saldo->saldoUsuario($idUser);
            echo json_encode($result);
            return false;
        }
    }
}