<?php

namespace Telegram\Bot\FileUpload;

use Psr\Http\Message\StreamInterface;

interface InputFileInterface
{
    /**
     * @return string|resource|StreamInterface
     */
    public function open();
}
