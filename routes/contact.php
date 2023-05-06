<?php
use Webcup\View;

$routes['/contact'] = new View('Contactez-nous', '/contact.php', array(
    'public_controller' => '/contact.php'
), View::IS_PUBLIC);