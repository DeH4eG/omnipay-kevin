<?php

namespace Omnipay\Kevin\Message\Response;

use Omnipay\Kevin\Message\AbstractResponse;

/**
 * Class FetchTransactionResponse
 * @package Omnipay\Kevin\Message\Response
 */
class FetchTransactionResponse extends AbstractResponse
{
    /**
     * @var string
     */
    private const PAYMENT_RECEIVED = 'RCVD';

    /**
     * @inheritDoc
     */
    public function isSuccessful(): bool
    {
        return $this->isStatusCodeOk() && $this->getPaymentStatus();
    }

    /**
     * @return string|null
     */
    public function getPaymentStatus(): ?string
    {
        return $this->getValueFromData('status');
    }

    /**
     * @return bool
     */
    public function isPaymentReceived(): bool
    {
        return $this->getPaymentStatus() === self::PAYMENT_RECEIVED;
    }
}
