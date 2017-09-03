<?php
namespace App\Controllers;

use unreal4u\TelegramAPI\Telegram\Methods\SendMessage;
use unreal4u\TelegramAPI\Telegram\Methods\GetUpdates;
use unreal4u\TelegramAPI\Abstracts\TraversableCustomType;
use App\Models\Update;

class MessageController {
    public static $messageMap = [
        '/start' => \App\Responses\Start::class,
        '/bye' => \App\Responses\Bye::class,
        'default' => \App\Responses\Start::class
    ];

    public function handle($update) {
        global $entityManager;
        global $tgLog;
        $data = json_decode(json_encode($update->data), true);
        if (isset(static::$messageMap[$data['message']['text']])) {
            $responseClass = static::$messageMap[$data['message']['text']];
        } else {
            $responseClass = static::$messageMap['default'];
        }
        $response = new $responseClass(); 
        $responseText = $response($update);
        $sendMessage = new SendMessage();
        $sendMessage->chat_id = $data['message']['chat']['id'];
        $sendMessage->text = $responseText;
        $tgLog->performApiRequest($sendMessage);
    }
}