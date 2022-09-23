<?php

namespace Omnipay\Kevin\Message\Response;

use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Kevin\Message\AbstractResponse;

/**
 * Class PurchaseResponse
 * @package Omnipay\Kevin\Message\Response
 */
class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * @var string
     */
    private const STATUS_STARTED = 'STRD';

    /**
     * @return bool
     */
    public function isRedirect(): bool
    {
        return $this->isSuccessful() && $this->getRedirectUrl();
    }

    /**
     * @inheritDoc
     */
    public function isSuccessful(): bool
    {
        return $this->isStatusCodeOk() && $this->isPaymentStarted();
    }

    /**
     * @return bool
     */
    private function isPaymentStarted(): bool
    {
        return $this->getValueFromData('bankStatus') === self::STATUS_STARTED;
    }

    /**
     * @return string|null
     */
    public function getRedirectUrl(): ?string
    {
        return $this->getValueFromData('confirmLink');
    }

    /**
     * @return string|null
     */
    public function getTransactionReference(): ?string
    {
        return $this->getValueFromData('id');
    }
}
