<?php

namespace Telegram\Bot\Tests;

use Telegram\Bot\Api;

class SendPollTest extends \PHPUnit_Framework_TestCase
{
    private function get_token()
    {
        if (! $token = getenv('TOKEN')) {
            $this->markTestSkipped();
        }

        return $token;
    }

    public function test_send_poll()
    {
        $telegram = new Api($this->get_token());

        $message = $telegram->sendPoll([
            'chat_id' => getenv('CHANNEL_ID'),
            'question' => 'Is this an awesome package?',
            'options' => json_encode(['Yes', 'No']),
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        [
                            'text' => 'halaei/telegram-bot',
                            'url' => 'https://github.com/halaei/telegram-bot',
                        ],
                    ],
                ]
            ]),
        ]);
        $poll = $telegram->stopPoll([
            'chat_id' => $message->getChat()->getId(),
            'message_id' => $message->getMessageId(),
        ]);
        $this->assertTrue($poll->getIsClosed());
    }
}
