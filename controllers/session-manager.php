<?php

if (session_status() == PHP_SESSION_NONE) {
    $lifetime = 2678400; // 1 mois
    session_start();
    setcookie(session_name(), session_id(), time() + $lifetime);
}

if (!isset($_SESSION['user'])) {
    redirect('/login');
    die();
}

if ($view->isAdmin() && !$_SESSION['user']->isAdmin()) {
    redirect('/');
    die();
}
