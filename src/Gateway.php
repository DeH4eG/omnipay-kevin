<?php

namespace Omnipay\Kevin;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Helper;
use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Kevin\Message\Request\PurchaseRequest;
use Omnipay\Kevin\Traits\ApiCredentialsTrait;

/**
 * @method NotificationInterface acceptNotification(array $options = [])
 * @method RequestInterface authorize(array $options = [])
 * @method RequestInterface completeAuthorize(array $options = [])
 * @method RequestInterface capture(array $options = [])
 * @method RequestInterface purchase(array $options = [])
 * @method RequestInterface refund(array $options = [])
 * @method RequestInterface fetchTransaction(array $options = [])
 * @method RequestInterface void(array $options = [])
 * @method RequestInterface createCard(array $options = [])
 * @method RequestInterface updateCard(array $options = [])
 * @method RequestInterface deleteCard(array $options = [])
 */
class Gateway extends AbstractGateway
{
    use ApiCredentialsTrait;

    /**
     * @var string
     */
    private const NAME = 'Kevin gateway';

    /**
     * @return string
     */
    public static function getGatewayShortName(): string
    {
        return Helper::getGatewayShortName(static::class);
    }

    /**
     * @return string[]
     */
    public function getDefaultParameters(): array
    {
        return [
            ApiCredentialsTrait::getClientIdKey() => '',
            ApiCredentialsTrait::getClientSecretKey() => ''
        ];
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @param array<string,string> $options
     * @return RequestInterface
     */
    public function completePurchase(array $options = []): RequestInterface
    {
        return $this->createRequest(PurchaseRequest::class, $options);
    }
}
