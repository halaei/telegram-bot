<?php

namespace Telegram\Bot\Exceptions;

use Telegram\Bot\TelegramResponse;

class TelegramMalformedResponseException extends TelegramSDKException
{
    /**
     * @var TelegramResponse
     */
    public $response;

    public function __construct(TelegramResponse $response, $message, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->response = $response;
    }
}
