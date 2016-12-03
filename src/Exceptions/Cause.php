<?php

namespace Telegram\Bot\Exceptions;

use Illuminate\Support\Str;

class Cause
{
    public static function userBlocked(\Exception $e)
    {
        return $e instanceof TelegramSDKException &&
        Str::contains($e->getMessage(), 'blocked');
    }

    public static function botWasKicked(\Exception $e)
    {
        return $e instanceof TelegramSDKException &&
        Str::contains($e->getMessage(), 'bot was kicked');
    }

    public static function botWasBlockedOrKicked(\Exception $e)
    {
        return self::userBlocked($e) or self::botWasKicked($e);
    }

    public static function invalidChat(\Exception $e)
    {
        return $e instanceof TelegramSDKException &&
        Str::contains($e->getMessage(), '[Error]: Bad Request: chat not found');
    }

    public static function invalidFileId(\Exception $e)
    {
        return $e instanceof TelegramSDKException &&
        Str::contains($e->getMessage(), 'Wrong file identifier');
    }
}
