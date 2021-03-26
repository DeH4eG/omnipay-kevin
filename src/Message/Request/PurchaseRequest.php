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
        'creditorName' => '',
        'amount' => '',
        'currencyCode' => '',
        'endToEndId' => '',
        'informationUnstructured' => '',
        'creditorAccount' => 'iban|bban|sortCodeAccountNumber'
    ];

    /**
     * @return array<string,string|array>
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate(self::REQUIRED_OPTIONS);

        return [
            'amount' => $this->getAmount(),
            'currencyCode' => $this->getCurrencyCode(),
            'creditorName' => $this->getCreditorName(),
            'endToEndId' => $this->getEndToEndId(),
            'informationUnstructured' => $this->getInformationUnstructured(),
            'creditorAccount' => $this->getCreditorAccount(),
            'identifier' => $this->getIdentifier()
        ];
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
    public function getCreditorName(): string
    {
        return $this->getParameter('creditorName');
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
    public function getCreditorAccount(): array
    {
        return $this->getParameter('creditorAccount');
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
     * @param string $informationUnstructured
     * @return PurchaseRequest
     */
    public function setInformationUnstructured(string $informationUnstructured): PurchaseRequest
    {
        return $this->setParameter('informationUnstructured', $informationUnstructured);
    }

    /**
     * @param array<string,string> $creditorAccount
     * @return PurchaseRequest
     */
    public function setCreditorAccount(array $creditorAccount): PurchaseRequest
    {
        return $this->setParameter('creditorAccount', $creditorAccount);
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
     * @param string $creditorName
     * @return PurchaseRequest
     */
    public function setCreditorName(string $creditorName): PurchaseRequest
    {
        return $this->setParameter('creditorName', $creditorName);
    }

    /**
     * @param string $endToEndId
     * @return PurchaseRequest
     */
    public function setEndToEndId(string $endToEndId): PurchaseRequest
    {
        return $this->setParameter('endToEndId', $endToEndId);
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
