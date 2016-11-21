<?php

namespace Telegram\Bot\Tests;

use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Update;

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
}
