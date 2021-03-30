<?php

class HomeController extends IndexController {
    public function indexAction() {
        $this->view->iconePagina = 'home.png';
        $this->view->tituloPagina = 'Início';
    }
}
