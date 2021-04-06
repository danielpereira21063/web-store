<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    
    protected function initialize() {
        if($this->session->has('id_usuario')) {
            $user = new Usuario();
            $idUsuario = $this->session->get('id_usuario');
            $this->view->fotoPerfil = $user::findFirstById_usuario($idUsuario)->profile_picture;
            $this->view->saldo = '200,35';
        }
    }
}
