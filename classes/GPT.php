<?php

namespace Webcup;

class GPT {
    private string $link = 'https://api.openai.com/v1/chat/completions';
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
        $this->body = [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user',
                'content' => ''
                ]
            ],
            'temperature' => 0.9,
        ];
    }

    public function setPrompt(string $prompt): void
    {
        $this->prompt = $prompt;
    }

    public function getPrompt(): string
    {
        return $this->prompt;
    }

    private function setPromptInBody(): void
    {
        $this->body['messages'][0]['content'] = $this->prompt;
    }

    public function getResponse(): mixed
    {
        $this->setPromptInBody();
        $response = $this->sendRequest();
        
        return $response;
    }

    private function sendRequest(): string
    {
        if ($this->getPrompt() == '') {
            return '';
        }

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->link,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($this->body),
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