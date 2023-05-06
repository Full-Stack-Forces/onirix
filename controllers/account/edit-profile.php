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

if (count($_POST) > 0) {
    $errors = array();

    if (UserService::emailIsUsed($_POST['email'], $_GET['id'])) {
        $errors[] = 'Email est déjà utilisé.';
    }

    if ($_POST['password'] != '' && $_POST['password'] != $_POST['password_verify']) {
        $errors[] = 'Les mots de passe sont différents.';
    }

    if (count($errors) === 0) {
        $data = array(
            'email' => $_POST['email'],
            'first_name' => stripslashes($_POST['first_name']),
            'last_name' => stripslashes($_POST['last_name']),
            'gender' => $_POST['gender'],
            'birthdate' => sqlDate($_POST['birthdate'])
        );

        if ($_POST['password'] != '') {
            $data['password'] = $_POST['password'];
        }

        UserService::update($_GET['id'], $data);
    }
}