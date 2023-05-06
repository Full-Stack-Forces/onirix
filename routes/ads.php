<?php

use Webcup\View;

$routes['/ads'] = new View('Liste des publicités', '/ads/list-ads.php', array(), View::IS_ADMIN);

$routes['/ads/new'] = new View('Créer une publicité', '/ads/new-ads.php', array(
    'private_controller' => '/ads/new-ads.php'
), View::IS_ADMIN);

$routes['/ads/edit'] = new View('Mettre à jour une publicité', '/ads/edit-ads.php', array(
    'private_controller' => '/ads/edit-ads.php'
), View::IS_ADMIN);

$routes['/ads/delete'] = new View('Supprimer une publicité', '', array(
    'private_controller' => '/ads/delete-ads.php'
), View::IS_ADMIN);
