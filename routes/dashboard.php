<?php

use Webcup\View;

$routes['/dashboard'] = new View('Tableau de bord', '/dashboard/index.php', array(
    'private_controller' => '/dashboard/index.php'
), View::IS_ADMIN);

$routes['/dashboard/blog'] = new View('Tableau de bord - Blog', '/dashboard/blog.php', array(
    'private_controller' => '/dashboard/blog.php'
), View::IS_ADMIN);

$routes['/dashboard/user'] = new View('Tableau de bord - Utilisateur', '/dashboard/user.php', array(
    'private_controller' => '/dashboard/user.php'
), View::IS_ADMIN);