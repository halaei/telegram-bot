<?php

namespace Telegram\Bot\Tests;

use Telegram\Bot\Objects\Chat;
use Telegram\Bot\Objects\ChatPhoto;

class ChatTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_is_private()
    {
        $this->assertTrue((new Chat(['type' => 'private']))->isPrivate());
    }

    public function test_it_is_not_private()
    {
        $this->assertFalse((new Chat(['type' => 'group']))->isPrivate());
    }

    public function test_chat_photo()
    {
        $chat = new Chat([
            'type' => 'channel',
            'photo' => [
                'small_file_id' => 'small',
                'big_file_id'   => 'big',
            ],
        ]);
        $this->assertInstanceOf(ChatPhoto::class, $chat->getPhoto());
        $this->assertEquals('small', $chat->getPhoto()->getSmallFileId());
        $this->assertEquals('big', $chat->getPhoto()->getBigFileId());
    }
}
