<?php

namespace Telegram\Bot\HttpClients;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\RequestOptions;

/**
 * Class GuzzleHttpClient.
 */
class GuzzleHttpClient
{
    /**
     * HTTP client.
     *
     * @var Client
     */
    protected $client;

    /**
     * @param Client|null $client
     */
    public function __construct(Client $client = null)
    {
        $this->client = $client ?: new Client();
    }

    /**
     * @param            $url
     * @param array      $headers
     * @param array      $options
     * @param int        $timeOut
     * @param bool       $isAsyncRequest
     * @param int        $connectTimeOut
     *
     * @return PromiseInterface
     */
    public function send($url, array $headers, array $options, $timeOut, $isAsyncRequest, $connectTimeOut)
    {
        $body = isset($options['body']) ? $options['body'] : null;
        $options = $this->getOptions($headers, $body, $options, $timeOut, $isAsyncRequest, $connectTimeOut);
        return $this->client->requestAsync('POST', $url, $options);
    }

    /**
     * Prepares and returns request options.
     *
     * @param array $headers
     * @param       $body
     * @param       $options
     * @param       $timeOut
     * @param       $isAsyncRequest
     * @param int   $connectTimeOut
     *
     * @return array
     */
    protected function getOptions(array $headers, $body, $options, $timeOut, $isAsyncRequest, $connectTimeOut)
    {
        $default_options = [
            RequestOptions::HEADERS         => $headers,
            RequestOptions::BODY            => $body,
            RequestOptions::TIMEOUT         => $timeOut,
            RequestOptions::CONNECT_TIMEOUT => $connectTimeOut,
            RequestOptions::SYNCHRONOUS     => !$isAsyncRequest,
            RequestOptions::HTTP_ERRORS     => false,
        ];

        return array_merge($default_options, $options);
    }
}
