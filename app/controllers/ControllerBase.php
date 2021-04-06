<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    protected function fotoPerfil() {
        $user = new Usuario();
        $idUsuario = $this->session->get('id_usuario');
        return $user::findFirstById_usuario($idUsuario)->profile_picture;
    }
}
