<?php

use Webcup\View;

$routes['/my-dreams'] = new View('Mes rêves', '/my-dreams.php', array(
    // 'public_controller' => '/my-dreams.php'
), View::IS_PRIVATE);