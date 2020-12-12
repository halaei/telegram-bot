<?php

namespace Telegram\Bot\Exceptions;

use Illuminate\Support\Str;

class Cause
{
    public static function userBlocked(\Exception $e = null)
    {
        $closure = function (\Exception $e) {
            return $e instanceof TelegramResponseException &&
            Str::contains(mb_strtolower($e->getMessage()), ['blocked', 'user is deactivated', 'have no rights to send a message']);
        };

        return is_null($e) ? $closure : $closure($e);
    }

    public static function botWasKicked(\Exception $e = null)
    {
        $closure = function (\Exception $e) {
            return $e instanceof TelegramResponseException &&
            Str::contains(mb_strtolower($e->getMessage()), 'bot was kicked');
        };

        return is_null($e) ? $closure : $closure($e);
    }

    public static function botWasBlockedOrKicked(\Exception $e = null)
    {
        $closure = function (\Exception $e) {
            return self::userBlocked($e) or self::botWasKicked($e);
        };

        return is_null($e) ? $closure : $closure($e);
    }

    public static function invalidChat(\Exception $e = null)
    {
        $closure = function (\Exception $e) {
            return $e instanceof TelegramResponseException &&
            Str::contains(mb_strtolower($e->getMessage()), ['bad request: chat not found', 'group chat was upgraded to a supergroup chat']);
        };

        return is_null($e) ? $closure : $closure($e);
    }

    public static function invalidFileId(\Exception $e = null)
    {
        $closure = function (\Exception $e) {
            return $e instanceof TelegramResponseException &&
            Str::contains(mb_strtolower($e->getMessage()), ['wrong file identifier', 'wrong remote file id specified']);
        };

        return is_null($e) ? $closure : $closure($e);
    }

    public static function messageNotModified(\Exception $e = null)
    {
        $closure = function (\Exception $e) {
            return $e instanceof TelegramResponseException &&
            Str::contains(mb_strtolower($e->getMessage()), 'message is not modified');
        };

        return is_null($e) ? $closure : $closure($e);
    }

    public static function messageNotFound(\Exception $e = null)
    {
        $closure = function (\Exception $e) {
            return $e instanceof TelegramSDKException &&
                Str::contains(mb_strtolower($e->getMessage()), 'message to edit not found');
        };

        return is_null($e) ? $closure : $closure($e);
    }

    public static function tooManyRequests(\Exception $e = null)
    {
        $closure = function (\Exception $e) {
            return $e instanceof TelegramResponseException &&
                $e->retryAfter() > 0;
        };

        return is_null($e) ? $closure : $closure($e);
    }

    public static function fileIsTooBig(\Exception $e = null)
    {
        $closure = function (\Exception $e) {
            return
                $e instanceof TelegramResponseException &&
                Str::contains(strtolower($e->getMessage()), 'file is too big');
        };

        return is_null($e) ? $closure : $closure($e);
    }

    public static function invalidQueryId(\Exception $e = null)
    {
        $closure = function (\Exception $e) {
            return
                $e instanceof TelegramResponseException &&
                Str::contains(strtolower($e->getMessage()), 'query_id_invalid');
        };

        return is_null($e) ? $closure : $closure($e);
    }

    public static function queryIsOld(\Exception $e = null)
    {
        $closure = function (\Exception $e) {
            return
                $e instanceof TelegramResponseException &&
                Str::contains(strtolower($e->getMessage()), 'query is too old');
        };

        return is_null($e) ? $closure : $closure($e);
    }

    public static function emptyFile(\Exception $e = null)
    {
        $closure = function (\Exception $e) {
            return
                $e instanceof TelegramResponseException &&
                Str::contains(strtolower($e->getMessage()), 'file must be non-empty');
        };

        return is_null($e) ? $closure : $closure($e);
    }
}
