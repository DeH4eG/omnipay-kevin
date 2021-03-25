<?php

namespace Omnipay\Kevin\Message;

use Omnipay\Common\Message\AbstractResponse as OmnipayAbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Class AbstractResponse
 * @package Omnipay\Kevin\Message
 */
abstract class AbstractResponse extends OmnipayAbstractResponse
{
    /**
     * @var int
     */
    private const STATUS_CODE_OK = 200;

    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var string
     */
    private $reasonPhrase;

    /**
     * AbstractResponse constructor.
     * @param RequestInterface $request
     * @param mixed $data
     * @param int $statusCode
     * @param string $reasonPhrase
     */
    public function __construct(RequestInterface $request, $data, int $statusCode, string $reasonPhrase)
    {
        parent::__construct($request, json_decode($data, true));

        $this->statusCode = $statusCode;
        $this->reasonPhrase = $reasonPhrase;
    }

    /**
     * @return bool
     */
    public function isStatusCodeOk(): bool
    {
        return $this->getStatusCode() === self::STATUS_CODE_OK;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->getValueFromData('error.description') ?? $this->getReasonPhrase();
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    protected function getValueFromData(string $key, $default = null)
    {
        $data = $this->getData();

        if (strpos($key, '.') === false) {
            return $data[$key] ?? $default;
        }

        foreach (explode('.', $key) as $segment) {
            if (array_key_exists($segment, $data)) {
                $data = $data[$segment];
            } else {
                return $default;
            }
        }

        return $data;
    }

    /**
     * @return string
     */
    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->getValueFromData('error.code');
    }
}
