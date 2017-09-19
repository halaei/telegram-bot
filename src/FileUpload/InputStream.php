<?php

namespace Telegram\Bot\FileUpload;

use Illuminate\Support\Str;

class InputStream extends InputFile
{
    public function __construct($string, $uri = null)
    {
        parent::__construct($this->wrap($string), $this->prepareUri($uri));
    }

    protected function wrap($string)
    {
        $stream = fopen('php://memory','r+');
        fwrite($stream, $string);
        rewind($stream);
        return $stream;
    }

    protected function prepareUri($uri)
    {
        return is_null($uri) ? Str::random() : $uri;
    }
}
