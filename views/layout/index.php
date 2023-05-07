<?php

use Webcup\View;

require __DIR__ . '/../../controllers/check-cookie.php';

if (!isset($view)) {
    $view = new View('Page introuvable', '/404.php');
} else if (!checkCookie()) {
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
    <link rel="icon" type="image/png" href="public/favicon.png" />
    <base href="/">
    <title><?php echo $view->title(); ?></title>

    <link rel="stylesheet" type="text/css" href="/public/assets/css/main.css" />

    <?php
    foreach ($view->styles() as $style) {
        echo $style;
    }

    foreach ($view->styleLinks() as $style) {
        echo '<link rel="stylesheet" type="text/css" href="' . $style . '">';
    }
    ?>
</head>

<body class="overflow-x-hidden">
    <section id="page-loader" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; z-index: 999; background: white; display: flex; align-items: center; justify-content: center;">
        <div role="status">
            <svg aria-hidden="true" style="width: 2rem; height: 2rem;" class="mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
            </svg>
            <span class="sr-only">Loading...</span>
        </div>
    </section>

    <?php
    if ($view->withHeader()) {
        require __DIR__ . '/header.php';
    }

    echo '<main id="main" class="flex-1 flex flex-col text-white">';

    require $view->path();

    echo '</main>';

    if (!checkCookie()) {
        require __DIR__ . '/cookie.php';
    } else {
        require  __DIR__ . '/ads.php';
    }

    if ($view->withFooter()) {
        require __DIR__ . '/footer.php';
    }

    echo '<script type="text/javascript" src="/public/lib/jquery/3.6.4/jquery.min.js"></script>';
    echo '<script type="text/javascript" src="/public/assets/js/main.js"></script>';

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