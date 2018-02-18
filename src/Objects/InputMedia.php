<?php

namespace Telegram\Bot\Objects;

use Psr\Http\Message\StreamInterface;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\FileUpload\InputFileInterface;

class InputMedia extends BaseObject
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

    /**
     * @param $name
     * @return array|null
     */
    public function extractAttachment($name)
    {
        $media = $this->getMedia();

        $validUrl = filter_var($media, FILTER_VALIDATE_URL);
        if (is_string($media) && (is_file($media) || $validUrl)) {
            $media = (new InputFile($media))->open();
        }

        if ($media instanceof InputFileInterface) {
            $media = $media->open();
        }

        if (is_resource($media) || $media instanceof StreamInterface) {
            $this['media'] = 'attach://'.$name;
            return [
                'name' => $name,
                'contents' => $media,
            ];
        }
        return null;
    }
}
