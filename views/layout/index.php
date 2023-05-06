<?php

use Webcup\View;

require __DIR__ . '/../../controllers/check-cookie.php';

if (!isset($view)) {
    $view = new View('Page introuvable', '/404.php');
}
else if (!checkCookie()) {
    if (CURRENT_LINK !== '/policy' && CURRENT_LINK !== '/') {
        redirect('/');
    }
}

if (session_status() == PHP_SESSION_NONE) {
    $lifetime = 2678400; // 1 mois
    session_start();
    setcookie(session_name(), session_id(), time() + $lifetime);
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Onirix, Institut Internation des Rêves, IIR, IIR x Onirix, interprétation des rêves, dictionnaire des rêves, analyse des rêves, rêves lucides">
    <meta name="description" content="IIR x Onirix est un projet de l'Institut International des Rêves en partenariat avec Onirix. Il s'agit d'un dictionnaire des rêves qui permet d'interpréter les rêves et de les analyser.">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" integrity="sha512-c42qTSw/wPZ3/5LBzD+Bw5f7bSF2oxou6wEb+I/lqeaKV5FDIfMvvRp772y4jcJLKuGUOpbJMdg/BTl50fJYAw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/daisyui/2.51.6/full.css" integrity="sha512-/2ELar91QbGVG+hv9oiEis94FmU9c2F5mah029EV39VO3baOfrOU4GYd5wS9Ozfl9SQ3lONAVPHkDMoNgedG/Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" href="https://picsum.photos/50/50" type="image/jpg">
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

    if (!checkCookie()) {
        require __DIR__ . '/cookie.php';
    }

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
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.3.0/chart.min.js" integrity="sha512-mlz/Fs1VtBou2TrUkGzX4VoGvybkD9nkeXWJm3rle0DPHssYYx4j+8kIS15T78ttGfmOjH0lLaBXGcShaVkdkg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>