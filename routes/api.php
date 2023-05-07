<?php

use Webcup\View;

$routes['/api'] = new View('API', '', array(
    'public_controller' => '/api.php'
), View::IS_PUBLIC);