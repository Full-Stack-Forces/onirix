<?php

use Webcup\View;

$routes['/api'] = new View('API', '/api.php', array(
    'public_controller' => '/api.php'
), View::IS_PUBLIC);