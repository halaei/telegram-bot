<?php

namespace Telegram\Bot\Tests\FileUpload;

use PHPUnit\Framework\TestCase;
use Telegram\Bot\FileUpload\FileId;
use Telegram\Bot\FileUpload\HttpUrl;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\FileUpload\InputStream;

class InputFileTest extends TestCase
{
    public function test_input_stream_open()
    {
        $file = new InputStream('This is test.');
        $stream = $file->open();
        $this->assertRegExp('/^([0-9a-zA-Z]{16})$/', $stream->getMetadata('uri'));
        $this->assertEquals('This is test.', $stream->getContents());
    }

    public function test_input_file_open()
    {
        $path = __DIR__ . '/test.txt';
        $file = new InputFile($path);
        $stream = $file->open();
        $this->assertEquals($path, $stream->getMetadata('uri'));
        $this->assertEquals('This is test!', $stream->getContents());
    }

    public function test_file_id_open()
    {
        $this->assertEquals(123, (new FileId(123))->open());
    }

    public function test_http_url_open()
    {
        $this->assertEquals('http://google.com', (new HttpUrl('http://google.com'))->open());
    }
}
