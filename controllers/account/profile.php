<?php

use Webcup\UserService;

if (isset($_GET['id'])) {
    // TODO: manage error

    if (!UserService::exist($_GET['id'])) {
        redirect('/');
    }

    if (!$_SESSION['user']->isAdmin() && $_GET['id'] != $_SESSION['user']->id()) {
        redirect('/');
    }
} else {
    $_GET['id'] = $_SESSION['user']->id();
}