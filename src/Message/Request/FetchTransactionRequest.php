<?php

namespace Omnipay\Kevin\Message\Request;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Kevin\Message\AbstractRequest;
use Omnipay\Kevin\Message\Response\FetchTransactionResponse;

/**
 * Class FetchTransactionRequest
 * @package Omnipay\Kevin\Message\Request
 */
class FetchTransactionRequest extends AbstractRequest
{
    /**
     * @var string
     */
    protected const HTTP_METHOD = 'GET';

    /**
     * @var string
     */
    private const ENDPOINT_METHOD = 'pis/payment/{paymentId}/status';

    /**
     * @var array<string,string>
     */
    private const REQUIRED_OPTIONS = [
        'paymentId' => '',
        'psuIpAddress' => '',
        'psuUserAgent' => '',
        'psuIpPort' => '',
        'psuDeviceId' => ''
    ];

    /**
     * @param string $ipAddress
     * @return FetchTransactionRequest
     */
    public function setPsuIpAddress(string $ipAddress): FetchTransactionRequest
    {
        return $this->setParameter('psuIpAddress', $ipAddress);
    }

    /**
     * @param string $userAgent
     * @return FetchTransactionRequest
     */
    public function setPsuUserAgent(string $userAgent): FetchTransactionRequest
    {
        return $this->setParameter('psuUserAgent', $userAgent);
    }

    /**
     * @param string $ipPort
     * @return FetchTransactionRequest
     */
    public function setPsuIpPort(string $ipPort): FetchTransactionRequest
    {
        return $this->setParameter('psuIpPort', $ipPort);
    }

    /**
     * @param string $deviceId
     * @return FetchTransactionRequest
     */
    public function setPsuDeviceId(string $deviceId): FetchTransactionRequest
    {
        return $this->setParameter('psuDeviceId', $deviceId);
    }

    /**
     * @inheritDoc
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate(self::REQUIRED_OPTIONS);

        return null;
    }

    /**
     * @param string $paymentId
     * @return FetchTransactionRequest
     */
    public function setPaymentId(string $paymentId): FetchTransactionRequest
    {
        return $this->setParameter('paymentId', $paymentId);
    }

    /**
     * @inheritDoc
     */
    protected function getEndpointMethod(): string
    {
        return str_replace('{paymentId}', $this->getPaymentId(), self::ENDPOINT_METHOD);
    }

    /**
     * @return string
     */
    public function getPaymentId(): string
    {
        return $this->getParameter('paymentId');
    }

    /**
     * @return string[]
     */
    protected function getAdditionalHeaders(): array
    {
        return [
            'PSU-IP-Address' => $this->getPsuIpAddress(),
            'PSU-User-Agent' => $this->getPsuUserAgent(),
            'PSU-IP-Port' => $this->getPsuIpPort(),
            'PSU-Device-ID' => $this->getPsuDeviceId()
        ];
    }

    /**
     * @return string
     */
    public function getPsuIpAddress(): string
    {
        return $this->getParameter('psuIpAddress');
    }

    /**
     * @return string
     */
    public function getPsuUserAgent(): string
    {
        return $this->getParameter('psuUserAgent');
    }

    /**
     * @return string
     */
    public function getPsuIpPort(): string
    {
        return $this->getParameter('psuIpPort');
    }

    /**
     * @return string
     */
    public function getPsuDeviceId(): string
    {
        return $this->getParameter('psuDeviceId');
    }

    /**
     * @inheritDoc
     */
    protected function makeResponse(string $data, int $statusCode): ResponseInterface
    {
        return $this->response = new FetchTransactionResponse($this, $data, $statusCode);
    }
}
