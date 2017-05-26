<?php

namespace Telegram\Bot\Tests;

use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\PhotoSize;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Objects\VideoNote;

class UpdateTest extends \PHPUnit_Framework_TestCase
{
    public function test_channel_post()
    {
        $update = new Update([
            'update_id' => 1234,
            'channel_post' => [
                'message_id' => 2,
                'from' => ['id' => 3],
                'chat' => [],
                'text' => 'txt',
            ]
        ]);
        $this->assertInstanceOf(Message::class, $update->getChannelPost());
        $this->assertEquals('channel_post', $update->detectType());
        $this->assertEquals(2, $update->getRelatedMessage()->getMessageId());
        $this->assertEquals(3, $update->getFrom()->getId());
        $this->assertEquals('txt', $update->getRelatedMessage()->getText());
    }

    public function test_edited_channel_post()
    {
        $update = new Update([
            'update_id' => 1234,
            'edited_channel_post' => [
                'message_id' => 2,
                'from' => ['id' => 3],
                'chat' => [],
                'text' => 'txt2',
            ]
        ]);
        $this->assertInstanceOf(Message::class, $update->getEditedChannelPost());
        $this->assertEquals('edited_channel_post', $update->detectType());
        $this->assertEquals(2, $update->getRelatedMessage()->getMessageId());
        $this->assertEquals(3, $update->getFrom()->getId());
        $this->assertEquals('txt2', $update->getRelatedMessage()->getText());
    }

    public function test_video_note()
    {
        $update = new Update([
            'update_id' => 674138757,
            'message' => [
                'message_id' => 11868,
                'from' => [
                    'id' => 1234,
                    'first_name' => 'Hamid',
                    'last_name' => 'Alaei V.',
                    'username' => 'halaeiv',
                    'language_code' => 'en-US',
                ],
                'chat' => [
                    'id' => 1234,
                    'first_name' => 'Hamid',
                    'last_name' => 'Alaei V.',
                    'username' => 'halaeiv',
                    'type' => 'private',
                  ],
                'date' => 1495788382,
                'video_note' => [
                    'duration' => 3,
                    'length' => 240,
                    'thumb' => [
                        'file_id' => 'AAQEABO2m7sZAATvW_pnQIvAI9eEAAIC',
                        'file_size' => 1717,
                        'width' => 90,
                        'height' => 90,
                    ],
                    'file_id' => 'DQADBAADoAADfEVBUXtKv2_NPqXgAg',
                    'file_size' => 92860,
                    ],
                ],
            ]
        );
        $this->assertEquals('video_note', $update->getMessage()->detectType());
        $this->assertInstanceOf(VideoNote::class, $update->getMessage()->getVideoNote());
        $this->assertEquals('DQADBAADoAADfEVBUXtKv2_NPqXgAg', $update->getMessage()->getFileId());
        $this->assertEquals('DQADBAADoAADfEVBUXtKv2_NPqXgAg', $update->getMessage()->getVideoNote()->getFileId());
        $this->assertEquals(3, $update->getMessage()->getVideoNote()->getDuration());
        $this->assertEquals(240, $update->getMessage()->getVideoNote()->getLength());
        $this->assertEquals(92860, $update->getMessage()->getVideoNote()->getFileSize());
        $this->assertInstanceOf(PhotoSize::class, $update->getMessage()->getVideoNote()->getThumb());
        $this->assertEquals('en-US', $update->getFrom()->getLanguageCode());
    }
}
