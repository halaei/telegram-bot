<?php

namespace Telegram\Bot\Objects;

/**
 * @method string getText()         Option text, 1-100 characters.
 * @method int    getVoterCount()   Number of users that voted for this option.
 */
class PollOption extends BaseObject
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
