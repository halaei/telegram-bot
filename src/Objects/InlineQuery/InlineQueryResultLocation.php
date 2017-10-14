<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultLocation
 *
 * <code>
 * $params = [
 *    'id'                      => '',
 *    'latitude'                => '',
 *    'longitude'               => '',
 *    'title'                   => '',
 *    'live_period'             => '',
 *    'reply_markup'            => '',
 *    'input_message_content'   => '',
 *    'thumb_url'               => '',
 *    'thumb_width'             => '',
 *    'thumb_height'            => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultlocation
 *
 * @method $this setId($string)                     Unique identifier for this result, 1-64 Bytes
 * @method $this setLatitude($float)                Location latitude in degrees
 * @method $this setLongitude($float)               Location longitude in degrees
 * @method $this setTitle($string)                  Location title
 * @method $this setLivePeriod($int)                 	Optional. Period in seconds for which the location can be updated, should be between 60 and 86400.
 * @method $this setReplyMarkup($object)            Optional. Inline keyboard attached to the message
 * @method $this setInputMessageContent($object)    Optional. Content of the message to be sent instead of the location
 * @method $this setThumbUrl($string)               Optional. Url of the thumbnail for the result
 * @method $this setThumbWidth($int)                Optional. Thumbnail width
 * @method $this setThumbHeight($int)               Optional. Thumbnail height */
class InlineQueryResultLocation extends InlineQueryResult
{
    public function __construct($params = [])
    {
        parent::__construct($params);
        $this->put('type', 'location');
    }
}
