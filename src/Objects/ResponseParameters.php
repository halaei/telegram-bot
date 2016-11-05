<?php

namespace Telegram\Bot\Objects;

/**
 * @method int  getMigrateToChatId()  (Optional). The group has been migrated to a supergroup with the specified identifier.
 * @method int  getRetryAfter()       (Optional). In case of exceeding flood control, the number of seconds left to wait before the request can be repeated.
 */
class ResponseParameters extends BaseObject
{
    /**
     * Property relations.
     *
     * @return array
     */
    public function relations()
    {
        return [];
    }
}
