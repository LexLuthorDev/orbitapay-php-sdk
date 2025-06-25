<?php

namespace Orbitapay;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

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
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]
        ]);
    }

    public function getClient()
    {
        return $this->client;
    }

    /**
     * Obter saldo disponível
     *
     * @param int|null $recipientId
     * @return array
     * @throws \Exception
     */
    public function getAvailableBalance(int $recipientId = null): array
    {
        try {
            $options = [];
            if ($recipientId !== null) {
                $options['query'] = ['recipientId' => $recipientId];
            }

            $response = $this->client->get('balance/available', $options);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            $status = $e->getResponse() ? $e->getResponse()->getStatusCode() : 500;
            $body = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();
            throw new \Exception("Erro ao obter saldo disponível (HTTP $status): " . $body, $status);
        }
    }
}
