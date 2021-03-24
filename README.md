# Omnipay: Kevin Gateway

Omnipay Kevin Gateway is a payment processing library for PHP. It's based on [Omnipay package](https://github.com/thephpleague/omnipay)

[![Latest Stable Version](https://poser.pugx.org/deh4eg/omnipay-kevin/v)](//packagist.org/packages/deh4eg/omnipay-kevin) [![Total Downloads](https://poser.pugx.org/deh4eg/omnipay-kevin/downloads)](//packagist.org/packages/deh4eg/omnipay-kevin) [![Latest Unstable Version](https://poser.pugx.org/deh4eg/omnipay-kevin/v/unstable)](//packagist.org/packages/deh4eg/omnipay-kevin) [![License](https://poser.pugx.org/deh4eg/omnipay-kevin/license)](//packagist.org/packages/deh4eg/omnipay-kevin)

## Installation

Omnipay is installed via [Composer](https://getcomposer.org/). To install, simply require `league/omnipay` and `deh4eg/omnipay-kevin` with Composer:

`composer require league/omnipay deh4eg/omnipay-kevin`

## API docs

> Note! Currently, library supports v0.2 of API

Kevin gateway API documentation you can find [here](https://docs.getkevin.eu/public/platform/v0.2)

## Usage

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay) repository.

Currently, library implements 2 endpoints:
1. [Initiate payment](#1-initiate-payment)
2. [Get payment status](#2-get-payment-status)

## Code Examples

### 1. Initiate payment

|Method|Endpoint|
|---|---|
|`POST`|[/pis/payment](https://docs.getkevin.eu/public/platform/v0.2#operation/initiatePayment)|

```php
use Omnipay\Kevin\Gateway;
use Omnipay\Kevin\Message\Response\PurchaseResponse;
use Omnipay\Omnipay;

/** @var Gateway $gateway */
$gateway = Omnipay::create(Gateway::getGatewayShortName());

$gateway
    ->setClientId('123456789')
    ->setClientSecret('123456789abcdefg');

$options = [
    'amount' => '12.34',
    'currencyCode' => 'EUR', // 3 letter currency code (ISO 4217)
    'creditorName' => 'Name Surname',
    'endToEndId' => '123456789', // Max 32 symbols
    'informationUnstructured' => 'order-123', // Max 140 characters; Regex Pattern - /^[a-zA-Z0-9/?:().,'+ -]{1,140}$/
    'creditorAccount' => [ // Must contains at least one of (iban,bban,sortCodeAccountNumber) 
        'iban' => '123456789',
        'bban' => '123456789',
        'sortCodeAccountNumber' => '12345612345678', // Regex Pattern - ^[0-9]{6}[0-9]{8}$
        'currencyCode' => 'EUR' // (optional) 3 letter currency code (ISO 4217)
    ],
    'identifier' => [
        'email' => 'email@email.com'
    ],
    'redirectUrl' => 'https://example.com/result.php?gateway=Kevin',
    'language' => 'lv', // (optional) Gateway UI language; Available - (en, lt, lv, et, fi, se, ru); Default - en
    'webhookUrl' => 'https://example.com/webhook.php?gateway=Kevin' // (optional) For more details please see https://docs.getkevin.eu/public/platform/v0.2#operation/initiatePayment
];

/** @var PurchaseResponse $response */
$response = $gateway->completePurchase($options)->send();

if ($response->isRedirect()) {
    $response->redirect();
}
```

### 2. Get payment status

|Method|Endpoint|
|---|---|
|`GET`|[/pis/payment/{paymentId}/status](https://docs.getkevin.eu/public/platform/v0.2#operation/getPaymentStatus)|

```php
use Omnipay\Kevin\Gateway;
use Omnipay\Kevin\Message\Response\FetchTransactionResponse;
use Omnipay\Omnipay;

/** @var Gateway $gateway */
$gateway = Omnipay::create(Gateway::getGatewayShortName());

$gateway
    ->setClientId('123456789')
    ->setClientSecret('123456789abcdefg');

$options = [
    'paymentId' => '13', // Payment identification from 'Initiate payment' response
    'psuIpAddress' => '127.0.0.1',
    'psuUserAgent' => $_SERVER['HTTP_USER_AGENT'],
    'psuIpPort' => $_SERVER['SERVER_PORT'],
    'psuDeviceId' => '123',
];

/** @var FetchTransactionResponse $response */
$response = $gateway->fetchTransaction($options)->send();

if ($response->isSuccessful() && $response->isPaymentReceived()) {
    // TODO: Payment received
}
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.