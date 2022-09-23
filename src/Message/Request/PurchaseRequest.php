<?php

namespace Omnipay\Kevin\Message\Request;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Kevin\Message\AbstractRequest;
use Omnipay\Kevin\Message\Response\PurchaseResponse;

/**
 * Class PurchaseRequest
 * @package Omnipay\Kevin\Message\Request
 */
class PurchaseRequest extends AbstractRequest
{
    /**
     * @var string
     */
    private const ENDPOINT_METHOD = 'pis/payment';

    /**
     * @var string
     */
    private const REQUIRED_OPTIONS = [
        'redirectUrl' => '',
        'amount' => '',
        'currencyCode' => '',
        'bankPaymentMethod' => 'endToEndId|informationUnstructured|iban|creditorName|creditorAccount',
        'description' => ''
    ];

    /**
     * @return array<string,string|array>
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate(self::REQUIRED_OPTIONS);

        $data = [
            'amount' => $this->getAmount(),
            'currencyCode' => $this->getCurrencyCode(),
            'bankPaymentMethod' => $this->getBankPaymentMethod(),
            'identifier' => $this->getIdentifier(),
            'description' => $this->getDescription()
        ];

        if (($cardPaymentMethod = $this->getCardPaymentMethod()) !== null) {
            $data['cardPaymentMethod'] = $cardPaymentMethod;
        }

        return $data;
    }

    /**
     * @return array<string>|null
     */
    public function getCardPaymentMethod()
    {
        return $this->getParameter('cardPaymentMethod');
    }

    /**
     * @param array<string> $cardPaymentMethod
     * @return PurchaseRequest
     */
    public function setCardPaymentMethod(array $cardPaymentMethod = null): PurchaseRequest
    {
        return $this->setParameter('cardPaymentMethod', $cardPaymentMethod);
    }

    /**
     * @return string
     */
    public function getCurrencyCode(): string
    {
        return $this->getParameter('currencyCode');
    }

    /**
     * @return string
     */
    public function getEndToEndId(): string
    {
        return $this->getParameter('endToEndId');
    }

    /**
     * @return string
     */
    public function getInformationUnstructured(): string
    {
        return $this->getParameter('informationUnstructured');
    }

    /**
     * @return array<string,string>
     */
    public function getBankPaymentMethod(): array
    {
        return $this->getParameter('bankPaymentMethod');
    }

    /**
     * @return array<string,string>
     */
    public function getIdentifier(): array
    {
        return $this->getParameter('identifier');
    }

    /**
     * @param string $redirectUrl
     * @return PurchaseRequest
     */
    public function setRedirectUrl(string $redirectUrl): PurchaseRequest
    {
        return $this->setParameter('redirectUrl', $redirectUrl);
    }

    /**
     * @param array<string,string> $bankPaymentMethod
     * @return PurchaseRequest
     */
    public function setBankPaymentMethod(array $bankPaymentMethod): PurchaseRequest
    {
        return $this->setParameter('bankPaymentMethod', $bankPaymentMethod);
    }

    /**
     * @param string $bankId
     * @return PurchaseRequest
     */
    public function setBankId(string $bankId): PurchaseRequest
    {
        return $this->setParameter('bankId', $bankId);
    }

    /**
     * @param bool $isRedirectPreferred
     * @return PurchaseRequest
     */
    public function setRedirectPreferred(bool $isRedirectPreferred = false): PurchaseRequest
    {
        return $this->setParameter('redirectPreferred', $isRedirectPreferred);
    }

    /**
     * @param string $currencyCode
     * @return PurchaseRequest
     */
    public function setCurrencyCode(string $currencyCode): PurchaseRequest
    {
        return $this->setParameter('currencyCode', $currencyCode);
    }

    /**
     * @param array<string,string> $identifier
     * @return PurchaseRequest
     */
    public function setIdentifier(array $identifier): PurchaseRequest
    {
        return $this->setParameter('identifier', $identifier);
    }

    /**
     * @param string $lang
     * @return PurchaseRequest
     */
    public function setLanguage(string $lang): PurchaseRequest
    {
        return $this->setParameter('language', $lang);
    }

    /**
     * @param string $webHookUrl
     * @return PurchaseRequest
     */
    public function setWebhookUrl(string $webHookUrl): PurchaseRequest
    {
        return $this->setParameter('webhookUrl', $webHookUrl);
    }

    /**
     * @return array<string,string>
     */
    protected function getAdditionalHeaders(): array
    {
        $headers = [
            'Redirect-URL' => $this->getRedirectUrl(),
            'Content-Type' => 'application/json',
        ];

        if ($webhookUrl = $this->getWebhookUrl()) {
            $headers['Webhook-URL'] = $webhookUrl;
        }

        return $headers;
    }

    /**
     * @return string
     */
    public function getRedirectUrl(): string
    {
        return $this->getParameter('redirectUrl');
    }

    /**
     * @return string|null
     */
    public function getWebhookUrl(): ?string
    {
        return $this->getParameter('webhookUrl');
    }

    /**
     * @return string
     */
    protected function getEndpointMethod(): string
    {
        $query = [
            'bankId' => $this->getBankId(),
            'redirectPreferred' => $this->getRedirectPreferred() ? 'true' : 'false',
            'lang' => $this->getLanguage()
        ];

        return sprintf(
            '%s?%s',
            self::ENDPOINT_METHOD,
            http_build_query($query, '', '&')
        );
    }

    /**
     * @return string|null
     */
    public function getBankId(): ?string
    {
        return $this->getParameter('bankId');
    }

    /**
     * @return bool
     */
    public function getRedirectPreferred(): bool
    {
        return (bool)$this->getParameter('redirectPreferred');
    }

    /**
     * @return string|null
     */
    public function getLanguage(): ?string
    {
        return $this->getParameter('language');
    }

    /**
     * @param string $data
     * @param int $statusCode
     * @param string $reasonPhrase
     * @return ResponseInterface
     */
    protected function makeResponse(string $data, int $statusCode, string $reasonPhrase): ResponseInterface
    {
        return $this->response = new PurchaseResponse($this, $data, $statusCode, $reasonPhrase);
    }
}
