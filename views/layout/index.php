<?php

use Webcup\View;

if (!isset($view)) {
    $view = new View('Page introuvable', __DIR__ . '/../404.php');
}

if (is_file($view->publicController())) {
    require $view->publicController();
}

if ($view->isPrivate()) {
    require __DIR__ . '/../../controllers/session-manager.php';
}

if (is_file($view->privateController())) {
    require $view->privateController();
}

if (!is_file($view->path())) {
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <base href="/">
        <title><?php echo $view->title(); ?></title>

        <?php
        foreach ($view->styles() as $style) {
            echo $style;
        }

        foreach ($view->styleLinks() as $style) {
            echo '<link rel="stylesheet" type="text/css" href="' . $style . '">';
        }
        ?>
    </head>
    <body>
        <?php
        if ($view->withHeader()) {
            require __DIR__ . '/header.php';
        }

        echo '<main id="main">';
        require $view->path();
        echo '</main>';

        if ($view->withFooter()) {
            require __DIR__ . '/footer.php';
        }

        foreach ($view->scripts() as $script) {
            echo $script;
        }

        foreach ($view->scriptLinks() as $script) {
            echo '<script type="text/javascript" src="' . $script . '"></script>';
        }
        ?>
    </body>
</html>