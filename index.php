<?php

// Set constants
define('CURRENT_LINK', explode('?', $_SERVER['REQUEST_URI'])[0]);
define('VIEWS_DIR', __DIR__ . '/views');
define('CONTROLLERS_DIR', __DIR__ . '/controllers');

// Autoload classes
spl_autoload_register(function ($class) {
    $namespace = substr($class, 0, strrpos($class, '\\'));
    $className = ($namespace != '' ? substr($class, strlen($namespace) + 1) : $class);
    $classFilename = '';

    if ($namespace == 'Webcup') {
        if (substr($className, -7) === 'Service') {
            $className = substr($className, 0, strlen($className) - 7);
        }

        $classFilename = 'classes/' . $className . '.php';
    }

    if (file_exists($classFilename)) {
        require $classFilename;
    }
});

// Init database
require 'secrets/database.php';
$DB = new \Webcup\Database(DB_HOST, DB_NAME, DB_USER, DB_PASSWORD);

require 'utilities.php';
require 'routes/index.php';

$routePaths = array();
$publicRoutePaths = array();

if (isset($routes)) {
    foreach ($routes as $r => $v) {
        $routePaths[] = $r;

        if ($v->isPublic()) {
            $publicRoutePaths[] = $r;
        }
    }
}

define('ROUTES', $routePaths);
define('PUBLIC_ROUTES', $publicRoutePaths);

if (isset($routes) && isset($routes[CURRENT_LINK]) && $routes[CURRENT_LINK] != null) {
    $view = $routes[CURRENT_LINK];
}

require VIEWS_DIR . '/layout/index.php';
