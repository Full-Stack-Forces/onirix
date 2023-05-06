<?php

use Webcup\View;

$routes['/chat'] = new View('Chat', '/chat.php', array(
    'public_controller' => '/chat.php'
), View::IS_PUBLIC);