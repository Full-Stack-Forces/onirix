<?php

if (!isset($_SESSION['user'])) {
    redirect('/login');
    die();
}

if ($view->isAdmin() && !$_SESSION['user']->isAdmin()) {
    redirect('/');
    die();
}
