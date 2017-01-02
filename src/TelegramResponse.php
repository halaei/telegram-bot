<?php

namespace Telegram\Bot;

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
     * @var array The decoded body of the API response.
     */
    protected $decodedBody = null;

    /**
     * @var string API Endpoint used to make the request.
     */
    protected $endPoint;

    /**
     * @var TelegramRequest The original request that returned this response.
     */
    protected $request;

    /**
     * @var PromiseInterface|ResponseInterface
     */
    protected $response;

    /**
     * @var TelegramSDKException The exception thrown by this request.
     */
    protected $thrownException;

    /**
     * Gets the relevant data from the Http client.
     *
     * @param TelegramRequest                    $request
     * @param ResponseInterface|PromiseInterface $response
     */
    public function __construct(TelegramRequest $request, $response)
    {
        $this->request = $request;
        $this->endPoint = (string) $request->getEndpoint();
        $this->response = $response;

        if ($response instanceof ResponseInterface) {
        } elseif ($response instanceof PromiseInterface) {
        } else {
            throw new \InvalidArgumentException(
                'Second constructor argument "response" must be instance of ResponseInterface or PromiseInterface'
            );
        }
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
     * Returns NULL if the request was asynchronous since we are not waiting for the response.
     *
     * @return null|int
     */
    public function getHttpStatusCode()
    {
        $this->wait();

        return $this->response->getStatusCode();
    }

    /**
     * Gets the Request Endpoint used to get the response.
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endPoint;
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
     * @return array
     */
    public function getHeaders()
    {
        $this->wait();

        return $this->response->getHeaders();
    }

    /**
     * Return the raw body response.
     *
     * @return string
     */
    public function getBody()
    {
        $this->wait();

        return $this->response->getBody()->getContents();
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
     * Checks if response is an error.
     *
     * @return bool
     */
    public function isError()
    {
        $body = $this->getDecodedBody();

        return ! isset($body['ok']) || ($body['ok'] !== true) || ! isset($body['result']);
    }

    /**
     * Throws the exception.
     *
     * @throws TelegramSDKException
     */
    public function throwException()
    {
        throw $this->thrownException;
    }

    /**
     * Instantiates an exception to be thrown later.
     */
    public function makeException()
    {
        $this->thrownException = TelegramResponseException::create($this);
    }

    /**
     * Returns the exception that was thrown for this request.
     *
     * @return TelegramSDKException
     */
    public function getThrownException()
    {
        return $this->thrownException;
    }

    /**
     * Converts raw API response to proper decoded response.
     */
    protected function decodeBody()
    {
        $this->wait();

        $this->decodedBody = json_decode($body = $this->response->getBody()->getContents(), true);

        if ($this->decodedBody === null) {
            $this->decodedBody = [];
            parse_str($body, $this->decodedBody);
        }

        if (!is_array($this->decodedBody)) {
            $this->decodedBody = [];
        }

        if ($this->isError()) {
            $this->makeException();
        }
    }

    /**
     * Wait for the promise
     */
    protected function wait()
    {
        if ($this->response instanceof PromiseInterface) {
            $this->response = $this->response->wait();
        }
    }
}
