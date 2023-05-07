<?php

namespace Webcup;

class GPT {
    private string $link;
    private string $token = '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';
    private array $header;
    private array $body;
    private string $prompt;

    public function __construct()
    {
        $this->header = [
            'Content-type: application/json',
            'Authorization: Bearer ' . $this->token,
        ];
    }

    public function link(): string
    {
        return $this->link;
    }

    private function setLink(string $link): void
    {
        $this->link = $link;
    }

    public function body(): array
    {
        return $this->body;
    }

    private function setBody(array $body): void
    {
        $this->body = $body;
    }

    public function setPrompt(string $prompt): void
    {
        $this->prompt = $prompt;
    }

    public function getPrompt(): string
    {
        return $this->prompt;
    }
    public function getResponse(): mixed
    {
        $response = $this->sendRequest();
        
        return json_decode($response, true);
    }

    public function getImage(): mixed
    {
        $response = $this->sendRequest(true);

        return json_decode($response, true);
    }

    private function sendRequest(bool $isImage = false): string
    {
        if ($this->getPrompt() == '') {
            return '';
        }

        $curl = curl_init();

        if ($isImage) {
            $this->setLink('https://api.openai.com/v1/images/generations');
            $this->setBody([
                'prompt' => $this->getPrompt(),
                'n' => 1,
                'size' => '256x256',
                'response_format' => 'url'
            ]);
        } else {
            $this->setLink('https://api.openai.com/v1/chat/completions');
            $this->setBody([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'user',
                    'content' => $this->getPrompt()
                    ]
                ],
                'temperature' => 0.9,
            ]);
        }

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->link(),
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($this->body()),
            CURLOPT_HTTPHEADER => $this->header,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_CAINFO => __DIR__ . '/../secrets/cacert.pem'
        ]);

        $response = curl_exec($curl);

        if ($response === false || isset($response['error'])) {
            $error = curl_error($curl);
            curl_close($curl);
            throw new \Exception('Erreur CURL: ' . $error);
        }

        return $response;
    }
}