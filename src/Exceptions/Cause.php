<?php

namespace Telegram\Bot\Exceptions;

use Illuminate\Support\Str;

class Cause
{
    public static function userBlocked(\Exception $e)
    {
        return $e instanceof TelegramResponseException &&
        Str::contains($e->getMessage(), ['blocked', 'User is deactivated']);
    }

    public static function botWasKicked(\Exception $e)
    {
        return $e instanceof TelegramResponseException &&
        Str::contains($e->getMessage(), 'bot was kicked');
    }

    public static function botWasBlockedOrKicked(\Exception $e)
    {
        return self::userBlocked($e) or self::botWasKicked($e);
    }

    public static function invalidChat(\Exception $e)
    {
        return $e instanceof TelegramResponseException &&
        Str::contains($e->getMessage(), '[Error]: Bad Request: chat not found');
    }

    public static function invalidFileId(\Exception $e)
    {
        return $e instanceof TelegramResponseException &&
        Str::contains($e->getMessage(), 'Wrong file identifier');
    }

    public static function messageNotModified(\Exception $e)
    {
        return $e instanceof TelegramResponseException &&
        Str::contains($e->getMessage(), 'message is not modified');
    }
}
