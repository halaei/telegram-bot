<?php

namespace Telegram\Bot\Exceptions;

use Exception;
use Telegram\Bot\Objects\ResponseParameters;
use Telegram\Bot\TelegramResponse;

/**
 * Class TelegramResponseException.
 */
class TelegramResponseException extends TelegramSDKException
{
    /**
     * @var TelegramResponse The response that threw the exception.
     */
    protected $response;

    /**
     * @var array Decoded response.
     */
    protected $responseData;

    /**
     * Creates a TelegramResponseException.
     *
     * @param TelegramResponse $response The response that threw the exception.
     * @param string $message
     * @param int $code
     * @param Exception $previous
     */
    public function __construct(TelegramResponse $response, $message = "", $code = 0, Exception $previous = null)
    {
        $this->response = $response;
        $this->responseData = $response->getDecodedBody();

        parent::__construct($message, $code, $previous);
    }

    /**
     * A factory for creating the appropriate exception based on the response from Telegram.
     *
     * @param TelegramResponse $response The response that threw the exception.
     *
     * @return TelegramResponseException
     */
    public static function create(TelegramResponse $response)
    {
        $data = $response->getDecodedBody();

        if ( ! isset($data['ok']) || ($data['ok'] === true && ! isset($data['result']))) {
            return new TelegramMalformedResponseException($response, 'The ok/result fields are not set in the response', -2);
        }

        $code = isset($data['error_code']) ? $data['error_code'] : -1;
        $message = isset($data['description']) ? $data['description'] : 'Unknown error from API.';

        return new static($response, $message, $code);

    }

    /**
     * Checks isset and returns that or a default value.
     *
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    private function get($key, $default = null)
    {
        if (isset($this->responseData[$key])) {
            return $this->responseData[$key];
        }

        return $default;
    }

    /**
     * Returns the HTTP status code.
     *
     * @return int
     */
    public function getHttpStatusCode()
    {
        return $this->response->getHttpStatusCode();
    }

    /**
     * Returns the error type.
     *
     * @return string
     */
    public function getErrorType()
    {
        return $this->get('type', '');
    }

    /**
     * Returns the raw response used to create the exception.
     *
     * @return string
     */
    public function getRawResponse()
    {
        return $this->response->getBody();
    }

    /**
     * Returns the decoded response used to create the exception.
     *
     * @return array
     */
    public function getResponseData()
    {
        return $this->responseData;
    }

    /**
     * @return ResponseParameters
     */
    public function getResponseParameters()
    {
        return new ResponseParameters($this->get('parameters', null));
    }

    /**
     * Returns the response entity used to create the exception.
     *
     * @return TelegramResponse
     */
    public function getResponse()
    {
        return $this->response;
    }
}
