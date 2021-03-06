<?php

namespace Telegram\Bot\Tests;

use PHPUnit\Framework\TestCase;
use Telegram\Bot\Objects\File;

class FileTest extends TestCase
{
    public function test_get_url()
    {
        $file = new File([
            'file_id'   => 'someRandomString',
            'file_size' => '1024',
            'file_path' => '<file_path>',
        ]);
        $this->assertEquals('https://api.telegram.org/file/bot<token>/<file_path>', $file->getUrl('<token>'));
    }
}
