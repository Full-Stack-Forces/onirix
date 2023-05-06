<?php

use Webcup\View;

$routes['/login'] = new View('Login', '/login.php', array(
    'public_controller' => '/login.php',
    'with_header' => false
), View::IS_PUBLIC);

$routes['/check-login'] = new View('Login', '', array(
    'public_controller' => '/check-login.php'
), View::IS_PUBLIC);

$routes['/logout'] = new View('Déconnexion', '', array(
    'private_controller' => '/logout.php'
), View::IS_PRIVATE);

$routes['/'] = new View('Page d\'accueil', '/home.php', array(), View::IS_PUBLIC);

$routes['/register'] = new View('Créer mon compte', '/register.php', array(
    'public_controller' => '/register.php'
), View::IS_PUBLIC);