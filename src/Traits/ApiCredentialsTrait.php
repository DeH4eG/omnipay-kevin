<?php

namespace Omnipay\Kevin\Traits;

/**
 * Trait ApiCredentialsTrait
 * @package Omnipay\Kevin\Traits
 */
trait ApiCredentialsTrait
{
    /**
     * @var string
     */
    private static $clientIdKey = 'clientId';

    /**
     * @var string
     */
    private static $clientSecretKey = 'clientSecret';

    /**
     * @return string
     */
    public static function getClientIdKey(): string
    {
        return self::$clientIdKey;
    }

    /**
     * @return string
     */
    public static function getClientSecretKey(): string
    {
        return self::$clientSecretKey;
    }

    /**
     * @param string $clientId
     * @return $this
     */
    public function setClientId(string $clientId): self
    {
        return $this->setParameter(self::$clientIdKey, $clientId);
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->getParameter(self::$clientIdKey);
    }

    /**
     * @param string $clientSecret
     * @return $this
     */
    public function setClientSecret(string $clientSecret): self
    {
        return $this->setParameter(self::$clientSecretKey, $clientSecret);
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->getParameter(self::$clientSecretKey);
    }
}
