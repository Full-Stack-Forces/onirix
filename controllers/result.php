<?php

use Webcup\Dream;
use Webcup\Result;

if (isset($_SESSION['user']) && $_SESSION['user']->id() && isset($_GET['id']) && $_GET['id'] != '') {
    $tmpResult = new Result($_GET['id']);
    $checkDream = new Dream($tmpResult->dream()->id());

    if ($checkDream->user()->id() != $_SESSION['user']->id()) {
        redirect('/chat');
    } else {
        $result = $tmpResult;
    }
}
else if (isset($_GET['guest']) && isset($_SESSION['guest']) && $_SESSION['guest']) {
    $guest = $_SESSION['guest'];
} else {
    redirect('/chat');
}