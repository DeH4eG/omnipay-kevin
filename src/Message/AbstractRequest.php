<?php

namespace Omnipay\Kevin\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest as OmnipayAbstractRequest;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Kevin\Traits\ApiCredentialsTrait;

/**
 * Class AbstractRequest
 * @package Omnipay\Kevin\Message
 */
abstract class AbstractRequest extends OmnipayAbstractRequest
{
    use ApiCredentialsTrait;

    /**
     * @var string
     */
    private const API_URL = 'https://api.getkevin.eu/platform/v0.2/';

    /**
     * @var string
     */
    protected const HTTP_METHOD = 'POST';

    /**
     * @param mixed $data
     * @return ResponseInterface
     */
    public function sendData($data): ResponseInterface
    {
        $body = json_encode($data) ?: null;

        $response = $this->httpClient->request(
            static::HTTP_METHOD,
            $this->getEndpointUrl(),
            $this->getHeaders(),
            $body
        );

        return $this->makeResponse($response->getBody()->getContents(), $response->getStatusCode());
    }

    /**
     * @return string
     */
    private function getEndpointUrl(): string
    {
        return sprintf(
            '%s%s',
            self::API_URL,
            $this->getEndpointMethod()
        );
    }

    /**
     * @return string
     */
    abstract protected function getEndpointMethod(): string;

    /**
     * @return array<string,string>
     */
    private function getHeaders(): array
    {
        $baseHeaders = [
            'Client-Id' => $this->getClientId(),
            'Client-Secret' => $this->getClientSecret()
        ];

        return array_merge($this->getAdditionalHeaders(), $baseHeaders);
    }

    /**
     * @return array<string,string>
     */
    protected function getAdditionalHeaders(): array
    {
        return [];
    }

    /**
     * @param string $data
     * @param int $statusCode
     * @return ResponseInterface
     */
    abstract protected function makeResponse(
        string $data,
        int $statusCode
    ): ResponseInterface;

    /**
     * @param mixed ...$args
     * @throws InvalidRequestException
     */
    public function validate(...$args): void
    {
        foreach ($args as $arg) {
            if (is_string($arg)) {
                parent::validate($arg);
                continue;
            }

            foreach ($arg as $option => $mustContain) {
                if (empty($mustContain)) {
                    parent::validate($option);
                    continue;
                }

                $optionValue = $this->parameters->get($option);

                $optionExists = static function ($mustContainedOption) use ($mustContain) {
                    return in_array($mustContainedOption, explode('|', $mustContain), true);
                };

                $mustContainedOptions = array_filter(array_keys($optionValue), $optionExists);

                if (empty($mustContainedOptions)) {
                    $exceptionMessage = sprintf(
                        "The %s parameter must contain one of (%s) keys",
                        $option,
                        $mustContain
                    );
                    throw new InvalidRequestException($exceptionMessage);
                }
            }
        }
    }
}
