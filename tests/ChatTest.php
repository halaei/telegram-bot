<?php

namespace Telegram\Bot\Tests;

use Telegram\Bot\Objects\Chat;

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
}
