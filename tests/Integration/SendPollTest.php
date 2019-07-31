<?php

namespace Telegram\Bot\Tests\Integration;

use PHPUnit\Framework\TestCase;

class SendPollTest extends TestCase
{
    use GetsToken;

    public function test_send_poll()
    {
        $telegram = $this->get_api();

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
