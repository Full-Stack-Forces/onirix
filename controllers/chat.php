<?php

use Webcup\DreamMetaValueService;
use Webcup\DreamService;
use Webcup\GPT;
use Webcup\ResultService;

$error = [];

if (isset($_POST['action']) && $_POST['action'] === 'save_dream' && isset($_SESSION['api']['dream']) && !empty($_SESSION['api']['dream'])) {
    $dreamId = $_SESSION['api']['dream'];
    $contents = DreamMetaValueService::getAll(array(), 'dream = ' . $dreamId);
    $content = '';

    foreach ($contents as $c) {
        $content .= $c->value() . ' ';
    }

    if (isset($_SESSION['user']) && $_SESSION['user']->id()) {
        $gpt = new GPT();
        
        $gpt->setPrompt("En une réponse et en un mot à choisir entre positif et négatif, et seulement entre ces deux adjectifs, comment classerais-tu ces successions de phrases:\n " . $content);
        $responseIsGood = $gpt->getResponse();

        if (preg_match('/positif/', strtolower($responseIsGood['choices'][0]['message']['content']))) {
            $isGood = true;
        } else {
            $isGood = false;
        }

        DreamService::update($dreamId, [
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

        if ($isGood) {
            $gpt->setPrompt($content . "\n\n" . 'Comment pourrait-on interpréter ce rêve ?');
            $response = $gpt->getResponse();
        } else {
            $response = [];
            $response['choices'][0]['message']['content'] = 'Censuré';
        }

        if ($response == '' || (is_array($response) && count($response) == 0)) {
            $error['message'] = 'Error getting response';
        }

        $gpt->setPrompt($content . "\n\n" . 'Comment pourrait-on illustrer ce rêve ?');

        $resultId = ResultService::save([
            'dream' => $dreamId,
            'prediction' => $response['choices'][0]['message']['content'],
            'accuracy' => rand(1, 100),
            'illustration' => $isGood ? $gpt->getImage()['data'][0]['url'] : 'https://responsivereiding.files.wordpress.com/2013/07/forbidden.png',
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

        $gpt->setPrompt("En une réponse et en un mot à choisir entre positif et négatif, et seulement entre ces deux adjectifs, comment classerais-tu cette histoire:\n " . $content);
        $responseIsGood = $gpt->getResponse();

        if (preg_match('/positif/', strtolower($responseIsGood['choices'][0]['message']['content']))) {
            $isGood = true;
        } else {
            $isGood = false;
        }

        $_SESSION['guest']['dream']['content'] = $content;
        $_SESSION['guest']['result']['prediction'] = $isGood ? $response['choices'][0]['message']['content'] : 'Censuré';

        redirect('/result?guest=true');
    }
}
