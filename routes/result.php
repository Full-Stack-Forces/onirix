<?php

use Webcup\View;

$routes['/result'] = new View('Résultat', '/result.php', array(
    'public_controller' => '/result.php'
), View::IS_PUBLIC);