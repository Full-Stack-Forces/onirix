<?php

use Webcup\AdsService;

if (count($_POST) > 0) {
    $data = array(
        'is_active' => 1,
        'priority' => $_POST['priority'],
        'title' => stripslashes($_POST['title']),
        'link' => stripslashes($_POST['link'])
    );

    // TODO: manage illustration

    AdsService::save($data);
}