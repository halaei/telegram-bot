<?php

namespace Telegram\Bot\FileUpload;

/**
 * Provide Telegram with an HTTP URL for the file to be sent.
 * Telegram will download and send the file.
 * 5 MB max size for photos and 20 MB max for other types of content.
 */
class HttpUrl implements InputFileInterface
{
    protected $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function open()
    {
        return $this->url;
    }
}
