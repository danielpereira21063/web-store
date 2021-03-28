<?php

$router = $di->getRouter();

// Define your routes here

// DEFAULT
$router->add('/', ['controller' => 'index', 'action' => 'index']);

$router->add('/usuario/signup', ['controller' => 'usuario', 'action' => 'signup']);
$router->add('/usuario/login', ['controller' => 'usuario', 'action' => 'login']);
$router->add('/usuario/signup_sucesso', ['controller' => 'usuario', 'action' => 'signup_sucesso']);

$router->handle();
