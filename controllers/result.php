<?php
use Webcup\Result;
use Webcup\ResultService;

if (isset($_GET['id']) && $_GET['id'] != '') {
    // $check = ResultService::getIdFrom('dream', $_GET['id']);
    $check = 1;
    if ($check) {
        $result = new Result($check);

    } else {
        redirect('/chat');
    }
} else {
    redirect('/chat');
}