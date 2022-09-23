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
    private const PAYMENT_STATUS_GROUP_COMPLETED = 'completed';

    /**
     * @inheritDoc
     */
    public function isSuccessful(): bool
    {
        return $this->isStatusCodeOk() && $this->getPaymentGroup();
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
    public function isPaymentCompleted(): bool
    {
        return $this->getPaymentGroup() === self::PAYMENT_STATUS_GROUP_COMPLETED;
    }
}
