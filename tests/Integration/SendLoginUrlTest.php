<?php

namespace Telegram\Bot\Tests\Integration;

use PHPUnit\Framework\TestCase;

class SendLoginUrlTest extends TestCase
{
    use GetsToken;

    public function test_send_login_url()
    {
        $telegram = $this->get_api();
        $message = $telegram->sendMessage([
            'chat_id' => getenv('CHAT_ID'),
            'text' => 'Please log in',
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        [
                            'text' => 'Log in!',
                            'login_url' => [
                                'url' => getenv('LOGIN_URL'),
                                'forward_text' => 'Pleas log in!',
                                'request_write_access' => true,
                            ],
                        ],
                    ],
                ],
            ])
        ]);
        var_dump($message->getReplyMarkup()[0]);die;
        $this->assertEquals([
            'text' => 'Log in!',
            'url' => getenv('LOGIN_URL'),
        ], $message->getReplyMarkup()[0][0]);
    }
}
