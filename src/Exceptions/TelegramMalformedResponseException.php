<?php

namespace Telegram\Bot\Exceptions;

class TelegramMalformedResponseException extends TelegramResponseException
{
    public static $retryAfter = 5;

    /**
     * @return int
     */
    public function retryAfter()
    {
        return static::$retryAfter;
    }
}
