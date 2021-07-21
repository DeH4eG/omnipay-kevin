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
     * @var string
     */
    private const PAYMENT_STATUS_GROUP_COMPLETED = 'completed';

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
     * @return string|null
     */
    public function getPaymentGroup(): ?string
    {
        return $this->getValueFromData('group');
    }

    /**
     * @return bool
     */
    public function isPaymentReceived(): bool
    {
        return $this->getPaymentStatus() === self::PAYMENT_RECEIVED;
    }

    /**
     * @return bool
     */
    public function isPaymentCompleted(): bool
    {
        return $this->getPaymentGroup() === self::PAYMENT_STATUS_GROUP_COMPLETED;
    }
}
