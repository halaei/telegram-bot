<?php
/**
 * Created by PhpStorm.
 * User: afshin
 * Date: 2/18/18
 * Time: 9:48 AM
 */


namespace Tests\Unit;

use Telegram\Bot\Api;
use Telegram\Bot\Objects\InputMedia;
use Tests\TestCase;


class TelegramTest extends TestCase
{

    public function testSendMessage(){
        $this->createApplication();
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $photo1=[
            "type" => "photo",
            "media" => "AgADBAADKawxG8ueQVD7nE6BQ_ZF0olGJhoABJEUbwaiUREpWK8DAAEC",
            "caption" => "this is a test1"
        ];

        $photo2=[
            "type" => "photo",
            "media" => "AgADBAADKawxG8ueQVD7nE6BQ_ZF0olGJhoABEeU1_VonKqxV68DAAEC",
            "caption" => "this is a test"
        ];

//        $photo1=new InputMedia();
//        $photo2=new InputMedia();

        $media=[$photo1,$photo2];
        $chat_id=123909455;

        $data=[
            "chat_id" => $chat_id,
            "media" => json_encode($media),
        ];

        dd($telegram->sendMediaGroup($data));

    }

}