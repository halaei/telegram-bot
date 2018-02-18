<?php

namespace Tests\Unit;

use Telegram\Bot\Api;
use Telegram\Bot\Objects\InputMedia;
use Telegram\Bot\Objects\Message;

class SendMediaGroupTest extends \PHPUnit_Framework_TestCase
{
    private function get_token()
    {
        if (! $token = getenv('TOKEN')) {
            $this->markTestSkipped();
        }

        return $token;
    }

    public function test_send_2_photos_by_id()
    {
        $telegram = new Api($this->get_token());

        $result = $telegram->sendMediaGroup([
            'chat_id' => getenv('CHAT_ID'),
            'media' => [
                [
                    'type' => 'photo',
                    'media' => getenv('PHOTO_ID_1'),
                    'caption' => 'Test 1',
                ],
                [
                    'type' => 'video',
                    'media' => getenv('VIDEO_ID_1'),
                    'caption' => 'Test 2',
                ],
            ],
        ]);

        $this->assertCount(2, $result);
        $this->assertInstanceOf(Message::class, $result[0]);
        $this->assertInstanceOf(Message::class, $result[1]);
    }

    public function test_input_media()
    {
        $file = fopen(__DIR__ . '/files/photo1.png', 'r');
        $media = new InputMedia([
            'type' => 'photo',
            'media' => $file,
            'caption' => 'Test 1',
        ]);
        $this->assertEquals([
            'name' => 'file1',
            'contents' => $file,
        ], $media->extractAttachment('file1'));
        $this->assertEquals([
            'type' => 'photo',
            'media' => 'attach://file1',
            'caption' => 'Test 1',
        ], $media->toArray());
    }

    public function test_send_2_photos_by_file()
    {
        $telegram = new Api($this->get_token());

        $result = $telegram->sendMediaGroup([
            'chat_id' => getenv('CHAT_ID') ?: 123909455,
            'media' => [
                new InputMedia([
                    'type' => 'photo',
                    'media' => fopen(__DIR__.'/files/photo1.png', 'r'),
                    'caption' => 'Test 1',
                ]),
                new InputMedia([
                    'type' => 'photo',
                    'media' => fopen(__DIR__.'/files/photo2.png', 'r'),
                    'caption' => 'Test 2'
                ]),
            ],
        ]);

        $this->assertCount(2, $result);
        $this->assertInstanceOf(Message::class, $result[0]);
        $this->assertInstanceOf(Message::class, $result[1]);
    }
}
