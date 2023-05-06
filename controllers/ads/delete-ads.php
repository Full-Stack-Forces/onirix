<?php

use Webcup\AdsService;

if (!isset($_GET['id']) || !AdsService::exist($_GET['id'])) {
    // TODO: manage errors
    redirect('/');
}

AdsService::delete($_GET['id']);
redirect('/ads');