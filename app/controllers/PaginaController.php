<?php

class PaginaController extends IndexController {

    public function initialize() {
        $this->view->iconePagina = 'about-me.png';
        $this->view->tituloPagina = 'Sobre o desenvolvedor';
    }

    public function sobreAction() {
    }
}
