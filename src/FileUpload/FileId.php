<?php

namespace Telegram\Bot\FileUpload;

/**
 * If the file is already stored somewhere on the Telegram servers, you don't need to reupload it:
 * each file object has a file_id field, simply pass this file_id as a parameter instead of uploading.
 * There are no limits for files sent this way.
 */
class FileId extends HttpUrl
{
    public function __construct($id)
    {
        parent::__construct($id);
    }
}
