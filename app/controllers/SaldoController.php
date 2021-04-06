<?php

class SaldoController extends ControllerBase {
    public function indexAction() {
        //dashboard com hisórico de saldo
        $this->view->tituloPagina = 'Saldo';
        $this->view->iconePagina = '';
    }

    public function adicionarAction() {
        $this->view->tituloPagina = 'Adicionar dinheiro';
        $this->view->iconePagina = '';
    }
}