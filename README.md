# Orbitapay PHP SDK

Este SDK facilita a integração com a API da Orbitapay para geração de transações Pix.

## Instalação

```bash
composer require lexluthordev/orbitapay-php-sdk
```

## Uso

```php
use Orbitapay\OrbitapayClient;
use Orbitapay\Services\TransactionService;

$client = new OrbitapayClient('SUA_SECRET_KEY');
$service = new TransactionService($client);

$response = $service->createPixTransaction([
    'amount' => 500,
    'paymentMethod' => 'pix',
    'customer' => [
        'name' => 'João da Silva',
        'email' => 'joao@email.com',
        'document' => '12345678900',
        'phone' => '11999999999'
    ],
    'items' => [[
        'name' => 'Produto Teste',
        'quantity' => 1,
        'unitPrice' => 500
    ]],
    'pix' => [
        'expiresIn' => 3600
    ],
    'postbackUrl' => 'https://seusite.com/postback',
    'metadata' => 'Pedido #123'
]);
```
