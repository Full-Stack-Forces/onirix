# Installation
>
> Créer un fichier ``secrets/database.php`` pour y insérer les informations de connexion à la base de données :

    <?php

    define('DB_HOST', '127.0.0.1');
    define('DB_NAME', 'sleepcolor');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');

## .htaccess
    RewriteEngine On
    RewriteBase /
    RewriteCond %{REQUEST_URI} !^/public/(.+)$
    RewriteRule . index.php [L]

## Token API local

15117b282328146ac6afebaa8acd80e7