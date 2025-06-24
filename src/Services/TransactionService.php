<?php

namespace Orbitapay\Services;

use Orbitapay\OrbitapayClient;

class TransactionService
{
    protected $client;

    public function __construct(OrbitapayClient $client)
    {
        $this->client = $client->getClient();
    }

    public function createPixTransaction(array $data)
    {
        $response = $this->client->post('transactions', [
            'json' => $data
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
