<?php

use Webcup\DreamService;
use Webcup\GPT;
use Webcup\ResultService;

$error = [];

if (isset($_POST['content']) && $_POST['content'] != '') {
    $content = stripslashes($_POST['content']);

    if (isset($_SESSION['user']) && $_SESSION['user']->id()) {
        $dreamId = DreamService::save([
            'title' => 'Chat',
            'user' => $_SESSION['user']->id(),
            'content' => $content,
            'is_complete' => false,
            'theme' => null
        ]);

        if (!$dreamId) {
            $error['message'] = 'Error saving dream';
        }

        // middleware gpt
        $gpt = new GPT();
        $gpt->setPrompt($content);
        $response = $gpt->getResponse();

        if ($response == '' || (is_array($response) && count($response) == 0)) {
            $error['message'] = 'Error getting response';
        }

        $resultId = ResultService::save([
            'dream' => $dreamId,
            // 'prediction' => $response['choices'][0]['text'],
            'prediction' => 'ok',
            'accuracy' => rand(1, 100)
        ]);

        redirect('/result?id=' . $resultId);
    } else {
        $gpt = new GPT();
        $gpt->setPrompt($content);
        $response = $gpt->getResponse();

        if ($response == '' || (is_array($response) && count($response) == 0)) {
            $error['message'] = 'Error getting response';
        }

        $_SESSION['guest']['dream']['content'] = $content;
        $_SESSION['guest']['result']['prediction'] = 'ok'; // $response['choices'][0]['text']

        redirect('/result?guest=true');
    }
}
