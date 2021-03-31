<?php

$router = $di->getRouter();

// Define your routes here

// DEFAULT
$router->add('/', ['controller' => 'index', 'action' => 'index']);

//controller usuario
$router->add('/usuario/signup', ['controller' => 'usuario', 'action' => 'signup']);
$router->add('/usuario/login', ['controller' => 'usuario', 'action' => 'login']);
$router->add('/usuario/logout', ['controller' => 'usuario', 'action' => 'logout']);
$router->add('/usuario/signup/sucesso', ['controller' => 'usuario', 'action' => 'signup_sucesso']);
$router->add('/usuario/perfil', ['controller' => 'usuario', 'action' => 'perfil']);
$router->add('/usuario/perfil/editar', ['controller' => 'usuario', 'action' => 'editar']);
$router->add('/usuario/perfil/excluir', ['controller' => 'usuario', 'action' => 'excluir']);
//=========================================================

//controller home
$router->add('/home', ['controller' => 'home', 'action' => 'index']);
//==========================================================


//controller pagina
$router->add('/pagina/sobre', ['controller' => 'pagina', 'action' => 'sobre']);

$router->handle();
