<?php

use Webcup\DreamService;
use Webcup\GPT;
use Webcup\ResultService;

$error = [];

if (isset($_POST['content']) && $_POST['content'] != '') {
    $content = stripslashes($_POST['content']);

    if (isset($_SESSION['user']) && $_SESSION['user']->id()) {
        $gpt = new GPT();
        
        $gpt->setPrompt("En une réponse et en un mot à choisir entre positif et négatif, comment classerais-tu cette histoire:\n " . $content);
        $responseIsGood = $gpt->getResponse();

        if (preg_match('/positif/', strtolower($responseIsGood['choices'][0]['text']))) {
            $isGood = true;
        }
        else if (preg_match('/négatif/', strtolower($responseIsGood['choices'][0]['text']))) {
            $isGood = false;
        } else {
            $isGood = rand(0, 1);
        }

        $dreamId = DreamService::save([
            'title' => 'Chat',
            'user' => $_SESSION['user']->id(),
            'content' => $content,
            'is_complete' => false,
            'theme' => null,
            'is_good' => $isGood
        ]);

        if (!$dreamId) {
            $error['message'] = 'Error saving dream';
        }

        $gpt->setPrompt($content);
        $response = $gpt->getResponse();

        if ($response == '' || (is_array($response) && count($response) == 0)) {
            $error['message'] = 'Error getting response';
        }

        $resultId = ResultService::save([
            'dream' => $dreamId,
            'prediction' => $response['choices'][0]['text'],
            'accuracy' => rand(1, 100)
        ]);

        if (!$resultId) {
            $error['message'] = 'Error saving result';
        } else {
            DreamService::update($dreamId, [
                'is_complete' => true
            ]);
        }

        redirect('/result?id=' . $resultId);
    } else {
        $gpt = new GPT();
        $gpt->setPrompt($content);
        $response = $gpt->getResponse();

        if ($response == '' || (is_array($response) && count($response) == 0)) {
            $error['message'] = 'Error getting response';
        }

        $_SESSION['guest']['dream']['content'] = $content;
        $_SESSION['guest']['result']['prediction'] = $response['choices'][0]['text'];

        redirect('/result?guest=true');
    }
}
