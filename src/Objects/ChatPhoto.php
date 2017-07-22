<?php

namespace Telegram\Bot\Objects;

/**
 * Class ChatPhoto.
 *
 * @method string getSmallFileId()  Unique file identifier of small (160x160) chat photo. This file_id can be used only for photo download.
 * @method string getBigFileId()    Unique file identifier of big (640x640) chat photo. This file_id can be used only for photo download.
 */
class ChatPhoto extends BaseObject
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
