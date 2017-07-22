<?php

namespace Telegram\Bot\Objects;

use Illuminate\Support\Collection;

/**
 * Class StickerSet.\
 *
 * @method string               getName()      Sticker set name.
 * @method string               getTitle()     Sticker set title.
 * @method bool                 getIsMasks()   True, if the sticker set contains masks.
 * @method Sticker[]|Collection getStickers()  List of all set stickers.
 */
class StickerSet extends BaseObject
{
    /**
     * Property relations.
     *
     * @return array
     */
    public function relations()
    {
        return [
            'stickers' => Sticker::class,
        ];
    }
}
