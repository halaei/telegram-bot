<?php

namespace Telegram\Bot;

use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\HttpClients\GuzzleHttpClient;

/**
 * Class TelegramClient.
 */
class TelegramClient
{
    /**
     * @const string Telegram Bot API URL.
     */
    const BASE_BOT_URL = 'https://api.telegram.org/bot';

    /**
     * @var GuzzleHttpClient HTTP Client
     */
    protected $httpClientHandler;

    /**
     * Instantiates a new TelegramClient object.
     *
     * @param GuzzleHttpClient|null $httpClientHandler
     */
    public function __construct(GuzzleHttpClient $httpClientHandler = null)
    {
        $this->httpClientHandler = $httpClientHandler ?: new GuzzleHttpClient();
    }

    /**
     * Returns the HTTP client handler.
     *
     * @return GuzzleHttpClient
     */
    public function getHttpClientHandler()
    {
        return $this->httpClientHandler;
    }

    /**
     * Returns the base Bot URL.
     *
     * @return string
     */
    public function getBaseBotUrl()
    {
        return static::BASE_BOT_URL;
    }

    /**
     * Prepares the API request for sending to the client handler.
     *
     * @param TelegramRequest $request
     *
     * @return array
     */
    protected function prepareRequest(TelegramRequest $request)
    {
        $url = $this->getBaseBotUrl().$request->getAccessToken().'/'.$request->getEndpoint();

        return [
            $url,
            $request->getHeaders(),
            $request->isAsyncRequest(),
        ];
    }

    /**
     * Send an API request and process the result.
     *
     * @param TelegramRequest $request
     *
     * @throws TelegramSDKException
     *
     * @return PromiseInterface
     */
    public function sendRequest(TelegramRequest $request)
    {
        list($url, $headers, $isAsyncRequest) = $this->prepareRequest($request);

        $timeOut = $request->getTimeOut();
        $connectTimeOut = $request->getConnectTimeOut();

        $options = $request->getParams();

        return $this->httpClientHandler->send($url, $headers, $options, $timeOut, $isAsyncRequest, $connectTimeOut);
    }

    /**
     * Creates response object.
     *
     * @param TelegramRequest                    $request
     * @param ResponseInterface|PromiseInterface $response
     *
     * @return TelegramResponse
     */
    protected function getResponse(TelegramRequest $request, $response)
    {
        return new TelegramResponse($request, $response);
    }
}
