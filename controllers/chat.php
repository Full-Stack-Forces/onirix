<?php
use Webcup\DreamService;

if (isset($_POST['content']) && $_POST['content'] != '') {
    $content = stripslashes($_POST['content']);

    $lastId = DreamService::save([
        'title' => 'Chat',
        'user' => $_SESSION['user']->id() ? $_SESSION['user']->id() : null,
        'content' => $content,
        'is_complete' => false,
        'theme' => null
    ]);

    redirect('/result?id=' + $lastId);
}