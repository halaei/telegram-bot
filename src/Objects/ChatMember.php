<?php

namespace Telegram\Bot\Objects;

/**
 * Class ChatMember
 *
 *
 * @method User      getUser()        Information about the user.
 * @method string    getStatus()      The member's status in the chat. Can be "creator", "administrator", "member", "left" or "kicked".
 */
class ChatMember extends BaseObject
{
    /**
     * Property relations.
     *
     * @return array
     */
    public function relations()
    {
        return [
            'user' => User::class,
        ];
    }
}
