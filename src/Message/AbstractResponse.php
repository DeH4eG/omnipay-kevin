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
     * AbstractResponse constructor.
     * @param RequestInterface $request
     * @param mixed $data
     * @param int $statusCode
     */
    public function __construct(RequestInterface $request, $data, int $statusCode)
    {
        parent::__construct($request, json_decode($data, true));

        $this->statusCode = $statusCode;
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
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    protected function getValueFromData(string $key, $default = null)
    {
        $data = $this->getData() ?? [];

        return array_key_exists($key, $data) ? $data[$key] : $default;
    }
}
