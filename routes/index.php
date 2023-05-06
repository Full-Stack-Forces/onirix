<?php

$routes = array();

if ($handle = opendir(__DIR__)) {
    while (($file = readdir($handle)) !== false) {
        if ('.' === $file || '..' === $file || 'index.php' === $file) continue;

        require __DIR__ . '/' . $file;
    }

    closedir($handle);
}
