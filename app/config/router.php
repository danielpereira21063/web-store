<?php

$router = $di->getRouter();

// Define your routes here

// DEFAULT
$router->add('/', ['controller' => 'index', 'action' => 'index']);
$router->notFound(['controller' => 'index', 'action' => 'route404']);

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

//controller produtos
$router->add('/produtos/', ['controller' => 'produtos', 'action' => 'index']);
$router->add('/produtos/meus', ['controller' => 'produtos', 'action' => 'meus']);
$router->add('/produtos/editar', ['controller' => 'produtos', 'action' => 'editar']);
$router->add('/produtos/meus/adicionar', ['controller' => 'produtos', 'action' => 'adicionar']);
$router->add('/produtos/meus/excluir', ['controller' => 'produtos', 'action' => 'excluir']);

$router->handle();  
