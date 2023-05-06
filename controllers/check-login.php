<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use Webcup\UserService;
use Webcup\User;

if (isset($_POST['username']) && isset($_POST['password'])) {
    $userId = UserService::checkLogin($_POST['username'], $_POST['password']);

    if ($userId > 0) {
        $_SESSION['user'] = new User($userId);

        redirect('/');
        exit;
    }
}

$_SESSION['login_error'] = $_POST['username'] ?? '';

redirect('/login');
die();
