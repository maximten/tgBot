<?php
namespace App\Responses;

use unreal4u\TelegramAPI\Telegram\Methods\SendMessage;

class Error {
    public function __invoke($update, $user, $chat) {
        global $entityManager;
        global $tgLog;

        $responseText = "Я тебя не понял";
        $sendMessage = new SendMessage();
        $sendMessage->chat_id = $chat->id;
        $sendMessage->text = $responseText;
        $tgLog->performApiRequest($sendMessage);
    }
}