<?php

use Webcup\User;
use Webcup\UserService;

if (isset($_GET['id']) && $_GET['id']) {
    $id = stripslashes($_GET['id']);

    if (!UserService::exist($id)) {
        redirect('/dashboard/user');
    }

    if (isset($_GET['delete'])) {
        UserService::delete($id);

        redirect('/dashboard/user');
    }

    if (isset($_GET['enabled'])) {

        if ($_GET['enabled'] == 'true') {
            UserService::update($id, ['is_active' => true]);
        } else {
            UserService::update($id, ['is_active' => false]);
        }
    }

    $user = new User($id);
} else {
    $users = UserService::getAll();
}
