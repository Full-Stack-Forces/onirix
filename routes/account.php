<?php

use Webcup\View;

$routes['/profile'] = new View('Mon profil', '/account/profile.php', array(
    'private_controller' => '/account/profile.php'
), View::IS_PRIVATE);

$routes['/profile/edit'] = new View('Mettre à jour mon profil', '/account/edit-profile.php', array(
    'private_controller' => '/account/edit-profile.php'
), View::IS_PRIVATE);
