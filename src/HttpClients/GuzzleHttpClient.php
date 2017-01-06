<?php

namespace Telegram\Bot\HttpClients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use Telegram\Bot\Exceptions\TelegramSDKException;

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
     * @var PromiseInterface[]
     */
    protected $promises = [];

    /**
     * @param Client|null $client
     */
    public function __construct(Client $client = null)
    {
        $this->client = $client ?: new Client();
    }

    /**
     * Unwrap Promises.
     */
    public function __destruct()
    {
        $this->unwrap();
    }

    /**
     * @param            $url
     * @param            $method
     * @param array      $headers
     * @param array      $options
     * @param int        $timeOut
     * @param bool       $isAsyncRequest
     * @param int        $connectTimeOut
     *
     * @throws TelegramSDKException
     *
     * @return PromiseInterface|ResponseInterface
     */
    public function send($url, $method, array $headers, array $options, $timeOut, $isAsyncRequest, $connectTimeOut)
    {
        $body = isset($options['body']) ? $options['body'] : null;
        $options = $this->getOptions($headers, $body, $options, $timeOut, $isAsyncRequest, $connectTimeOut);

        try {
            $response = $this->client->requestAsync($method, $url, $options);

            if ($isAsyncRequest) {
                $this->promises[] = $response;
            } else {
                $response = $response->wait();
            }
        } catch (RequestException $e) {
            $response = $e->getResponse();

            if (!$response instanceof ResponseInterface) {
                throw new TelegramSDKException($e->getMessage(), $e->getCode());
            }
        }

        return $response;
    }

    /**
     * Unwrap Promises.
     */
    public function unwrap()
    {
        try {
            return Promise\unwrap($this->promises);
        } finally {
            $this->promises = [];
        }
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
