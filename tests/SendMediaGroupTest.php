<?php

namespace Tests\Unit;

use Telegram\Bot\Api;
use Telegram\Bot\Objects\Message;

class SendMediaGroupTest extends \PHPUnit_Framework_TestCase
{
    public function test_send_message()
    {
        $token = getenv('TOKEN');

        if (! $token) {
            $this->markTestSkipped();
        }

        $telegram = new Api($token);

        $result = $telegram->sendMediaGroup([
            'chat_id' => getenv('CHAT_ID') ?: 123909455,
            'media' => json_encode([[
                'type' => 'photo',
                'media' => getenv('PHOTO_ID_1') ?: 'AgADBAADKawxG8ueQVD7nE6BQ_ZF0olGJhoABJEUbwaiUREpWK8DAAEC',
                'caption' => 'Test 1',
            ], [
                'type' => 'photo',
                'media' => getenv('PHOTO_ID_2') ?: 'AgADBAADKawxG8ueQVD7nE6BQ_ZF0olGJhoABEeU1_VonKqxV68DAAEC',
                'caption' => 'Test 2'
            ]]),
        ]);

        $this->assertCount(2, $result);
        $this->assertInstanceOf(Message::class, $result[0]);
        $this->assertInstanceOf(Message::class, $result[1]);
    }
}
