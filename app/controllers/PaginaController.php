<?php

class PaginaController extends IndexController {
    public function sobreAction() {
        $this->view->iconePagina = 'about-me.png';
        $this->view->tituloPagina = 'Sobre o desenvolvedor';
    }
}
