<?php

namespace Orbitapay;

use GuzzleHttp\Client;

class OrbitapayClient
{
    protected $client;
    protected $secretKey;

    public function __construct(string $secretKey)
    {
        $this->secretKey = $secretKey;

        $this->client = new Client([
            'base_uri' => 'https://api.dashboard.orbitapay.com.br/v1/',
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode("{$this->secretKey}:x"),
                'Content-Type' => 'application/json'
            ]
        ]);
    }

    public function getClient()
    {
        return $this->client;
    }
}
