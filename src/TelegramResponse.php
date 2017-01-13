<?php

namespace Telegram\Bot;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;
use Telegram\Bot\Exceptions\TelegramResponseException;
use Telegram\Bot\Exceptions\TelegramSDKException;

/**
 * Class TelegramResponse.
 *
 * Handles the response from Telegram API.
 */
class TelegramResponse
{
    /**
     * @var string The body string of the API response
     */
    protected $body = null;

    /**
     * @var array The decoded body of the API response.
     */
    protected $decodedBody = null;

    /**
     * @var TelegramRequest The original request that returned this response.
     */
    protected $request;

    /**
     * @var PromiseInterface|ResponseInterface
     */
    protected $response;

    /**
     * @var RequestException
     */
    protected $requestException;

    /**
     * Gets the relevant data from the Http client.
     *
     * @param TelegramRequest                    $request
     * @param PromiseInterface $response
     */
    public function __construct(TelegramRequest $request, PromiseInterface $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Return the original request that returned this response.
     *
     * @return TelegramRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Gets the HTTP status code.
     *
     * @return int
     */
    public function getHttpStatusCode()
    {
        $this->wait();

        return $this->response instanceof ResponseInterface ? $this->response->getStatusCode() : 0;
    }

    /**
     * Return the bot access token that was used for this request.
     *
     * @return string|null
     */
    public function getAccessToken()
    {
        return $this->request->getAccessToken();
    }

    /**
     * Return the HTTP headers for this response.
     *
     * @return array|null
     */
    public function getHeaders()
    {
        $this->wait();

        return $this->response instanceof ResponseInterface ? $this->response->getHeaders() : [];
    }

    /**
     * Return the raw body response.
     *
     * @return string
     */
    public function getBody()
    {
        if (is_null($this->body)) {
            $this->wait();

            $this->body = $this->response instanceof ResponseInterface ? (string) $this->response->getBody() : '';
        }

        return $this->body;
    }

    /**
     * Return the decoded body response.
     *
     * @return array
     */
    public function getDecodedBody()
    {
        if (is_null($this->decodedBody)) {
            $this->decodeBody();
        }

        return $this->decodedBody;
    }

    /**
     * Return the result.
     *
     * @return mixed
     */
    public function getResult()
    {
        return $this->getDecodedBody()['result'];
    }

    /**
     * @return RequestException
     */
    public function getRequestException()
    {
        return $this->requestException;
    }

    /**
     * Checks if response is an error.
     *
     * @return bool
     */
    public function isError()
    {
        $body = $this->getDecodedBody();

        return $this->getRequestException() || ! isset($body['ok']) || ($body['ok'] !== true) || ! isset($body['result']);
    }

    /**
     * Throws a TelegramResponseException exception if this is an error.
     *
     * @throws TelegramSDKException
     *
     * @return $this
     */
    public function throwException()
    {
        if ($this->isError()) {
            throw TelegramResponseException::create($this);
        }

        return $this;
    }

    /**
     * Converts raw API response to proper decoded response.
     */
    protected function decodeBody()
    {
        $this->wait();

        $this->decodedBody = json_decode($body = $this->getBody(), true);

        if (! is_array($this->decodedBody)) {
            $this->decodedBody = [];
        }
    }

    /**
     * Wait for the promise
     *
     * @return $this
     */
    public function wait()
    {
        if (! $this->ready()) {
            try {
                $this->response = $this->response->wait();
            } catch (RequestException $e) {
                $this->requestException = $e;
                $this->response = $e->getResponse();
            }
        }

        return $this;
    }

    /**
     * Whether the response has already been waited for.
     *
     * @return bool
     */
    public function ready()
    {
        return ! $this->response instanceof PromiseInterface;
    }
}
