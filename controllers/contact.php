<?php
use Webcup\ContactService;

$error = [];

if (count($_POST) > 0) {
    $data = [];

    if ((!isset($_POST['last_name']) || empty($_POST['last_name'])) && (!isset($_POST['first_name']) || empty($_POST['first_name'])) && (!isset($_POST['email']) || empty($_POST['email'])) && (!isset($_POST['subject']) || empty($_POST['subject'])) && (!isset($_POST['content']) || empty($_POST['content']))) {
        $error['message'] = 'Veuillez remplir tous les champs obligatoires.';
    } else {
        $data['last_name'] = stripslashes($_POST['last_name']);
        $data['first_name'] = stripslashes($_POST['first_name']);
        $data['email'] = stripslashes($_POST['email']);
        $data['phone'] = stripslashes($_POST['phone']);
        $data['subject'] = stripslashes($_POST['subject']);
        $data['content'] = stripslashes($_POST['content']);

        if (isset($_POST['phone']) && !empty($_POST['phone'])) {
            $data['phone'] = stripslashes($_POST['phone']);
        } else {
            $data['phone'] = '';
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $error['email'] = 'Veuillez entrer une adresse email valide.';
        }

        $result = ContactService::save($data);

        if ($result) {
            redirect('/contact?success');
        } else {
            $error['message'] = 'Une erreur est survenue lors de l\'envoi du message.';
        }
    }
}