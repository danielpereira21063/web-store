<?php

$router = $di->getRouter();

// Define your routes here

// DEFAULT
$router->add('/', ['controller' => 'index', 'action' => 'index']);

//controller usuario
$router->add('/usuario/signup', ['controller' => 'usuario', 'action' => 'signup']);
$router->add('/usuario/login', ['controller' => 'usuario', 'action' => 'login']);
$router->add('/usuario/signup/sucesso', ['controller' => 'usuario', 'action' => 'signup_sucesso']);

//controller home
$router->add('/home', ['controller' => 'home', 'action' => 'index']);

$router->handle();
