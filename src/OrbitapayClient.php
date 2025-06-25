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
            'headers'  => [
                'Authorization' => 'Basic ' . base64_encode("{$this->secretKey}:x"),
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
            ],
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
            $body   = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();
            throw new \Exception("Erro ao obter saldo disponível (HTTP $status): " . $body, $status);
        }
    }

    /**
     * Criar uma transferência via PIX
     *
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function createTransfer(array $data): array
    {
        try {
            $response = $this->client->post('transfers', [
                'json' => $data,
            ]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            $status = $e->getResponse() ? $e->getResponse()->getStatusCode() : 500;
            $body   = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();
            throw new \Exception("Erro ao criar transferência (HTTP $status): " . $body, $status);
        }
    }

    /**
     * Criar um novo recebedor
     *
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function createRecipient(array $data): array
    {
        try {
            $response = $this->client->post('recipients', [
                'json' => $data,
            ]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            $status = $e->getResponse() ? $e->getResponse()->getStatusCode() : 500;
            $body   = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();
            throw new \Exception("Erro ao criar recebedor (HTTP $status): " . $body, $status);
        }
    }

    /**
     * Listar recebedores cadastrados
     *
     * @return array
     * @throws \Exception
     */
    public function listRecipients(): array
    {
        try {
            $response = $this->client->get('recipients');
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            $status = $e->getResponse() ? $e->getResponse()->getStatusCode() : 500;
            $body   = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();
            throw new \Exception("Erro ao listar recebedores (HTTP $status): " . $body, $status);
        }
    }

/**
 * Buscar um recebedor pelo ID
 *
 * @param int $id
 * @return array
 * @throws \Exception
 */
    public function getRecipientById(int $id): array
    {
        try {
            $response = $this->client->get("recipients/{$id}");
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            $status = $e->getResponse() ? $e->getResponse()->getStatusCode() : 500;
            $body   = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();
            throw new \Exception("Erro ao buscar recebedor ID {$id} (HTTP $status): " . $body, $status);
        }
    }

    /**
     * Atualizar um recebedor
     *
     * @param int $id
     * @param string $legalName
     * @return array
     * @throws \Exception
     */
    public function updateRecipient(int $id, string $legalName): array
    {
        try {
            $response = $this->client->put("recipients/{$id}", [
                'json' => ['legalName' => $legalName],
            ]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            $status = $e->getResponse() ? $e->getResponse()->getStatusCode() : 500;
            $body   = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();
            throw new \Exception("Erro ao atualizar recebedor ID {$id} (HTTP $status): " . $body, $status);
        }
    }

}
