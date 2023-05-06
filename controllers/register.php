<?php

use Webcup\UserService;

if (isset($_SESSION['user'])) {
    redirect('/');
}

if (isset($_GET['clear'])) {
    unset($_SESSION['register_values']);
    reload();
}

if (count($_POST) > 0) {
    $errors = array();

    if (isset($_SESSION['register_values']) && is_array($_SESSION['register_values'])) {
        // TODO: send confirmation mail to active account
        $data = array(
            'email' => $_SESSION['register_values']['email'],
            'password' => $_SESSION['register_values']['password'],
            'first_name' => stripslashes($_POST['first_name']),
            'last_name' => stripslashes($_POST['last_name']),
            'gender' => $_POST['gender'],
            'birthdate' => sqlDate($_POST['birthdate'])
        );
        $userId = UserService::save($data);

        if ($userId != 0) {
            unset($_SESSION['register_values']);

            // TODO: add successful message
            redirect('/login');
            exit;
        } else {
            $errors[] = 'Création impossible.';
        }
    } else {
        if (UserService::emailIsUsed($_POST['email'])) {
            $errors[] = 'Email est déjà utilisé.';
        }

        if ($_POST['password'] != $_POST['password_verify']) {
            $errors[] = 'Les mots de passe sont différents.';
        }

        if (count($errors) == 0) {
            $_SESSION['register_values'] = array(
                'email' => $_POST['email'],
                'password' => $_POST['password']
            );
            reload();
        }
    }
}