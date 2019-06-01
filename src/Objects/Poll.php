<?php

namespace Telegram\Bot\Objects;

/**
 * @method string       getId()         Unique poll identifier.
 * @method string       getQuestion()   Poll question, 1-255 characters.
 * @method PollOption[] getOptions() 	List of poll options.
 * @method bool         getIsClosed() 	True, if the poll is closed.
 */
class Poll extends BaseObject
{
    /**
     * Property relations.
     *
     * @return array
     */
    public function relations()
    {
        return [
            'options' => PollOption::class,
        ];
    }
}
