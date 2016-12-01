<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * @method $this setId($string)                  Unique identifier for this result, 1-64 Bytes
 * @method $this setInputMessageContent($object) Content of the message to be sent.
 * @method $this setReplyMarkup($object)         Optional. Inline keyboard attached to the message
 */
abstract class InlineQueryResult extends InlineBaseObject
{
}
