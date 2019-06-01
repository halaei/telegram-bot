<?php


namespace Telegram\Bot\Tests\Integration;

use Telegram\Bot\Api;

trait GetsToken
{
    private function get_token()
    {
        if (! $token = getenv('TOKEN')) {
            $this->markTestSkipped();
        }

        return $token;
    }

    private function get_api()
    {
        return new Api($this->get_token());
    }
}
