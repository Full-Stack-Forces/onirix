<?php

namespace Webcup;

class GPT {
    private string $link = 'https://api.openai.com/v1/completions';
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
            'model' => 'text-davinci-003',
            'prompt' => '',
            'temperature' => 0.9,
            'max_tokens' => 150,
            'top_p' => 1,
            'frequency_penalty' => 0.0,
            'presence_penalty' => 0.6,
            'stop' => [' Human:', ' AI:']
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
        $this->body['prompt'] = $this->prompt . ' AI:';
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