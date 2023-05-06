<?php

use Webcup\AdsService;

if (!isset($_GET['id']) || !AdsService::exist($_GET['id'])) {
    // TODO: manage errors
    redirect('/');
}

if (count($_POST) > 0) {
    $data = array(
        'is_active' => isset($_POST['is_active']),
        'priority' => $_POST['priority'],
        'title' => stripslashes($_POST['title']),
        'link' => stripslashes($_POST['link'])
    );

    // TODO: manage illustration

    AdsService::update($_GET['id'], $data);
}