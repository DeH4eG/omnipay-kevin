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
        'paymentId' => ''
    ];

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
     * @inheritDoc
     */
    protected function makeResponse(string $data, int $statusCode, string $reasonPhrase): ResponseInterface
    {
        return $this->response = new FetchTransactionResponse($this, $data, $statusCode, $reasonPhrase);
    }
}
