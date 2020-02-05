<?php

namespace Telegram\Bot\Exceptions;

use Illuminate\Support\Str;

class Cause
{
    public static function userBlocked(\Exception $e = null)
    {
        $closure = function (\Exception $e) {
            return $e instanceof TelegramResponseException &&
            Str::contains(mb_strtolower($e->getMessage()), ['blocked', 'user is deactivated']);
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
            Str::contains(mb_strtolower($e->getMessage()), 'bad request: chat not found');
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
}
