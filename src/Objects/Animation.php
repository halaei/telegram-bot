<?php

namespace Telegram\Bot\Objects;

/**
 * Class Animation.
 *
 *
 * @method string       getFileId()     Unique file identifier.
 * @method int          getWidth()      Video width as defined by sender.
 * @method int          getHeight()     Video height as defined by sender.
 * @method int          getDuration()   Duration of the video in seconds as defined by sender.
 * @method PhotoSize    getThumb()      (Optional). Document thumbnail as defined by sender.
 * @method string       getFileName()   (Optional). Original filename as defined by sender.
 * @method string       getMimeType()   (Optional). MIME type of the file as defined by sender.
 * @method int          getFileSize()   (Optional). File size.
 */
class Animation extends Document
{
}