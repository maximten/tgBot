<?php
namespace App\Responses;

use unreal4u\TelegramAPI\Telegram\Methods\SendMessage;

class Start {
    public function __invoke($update, $user, $chat) {
        global $entityManager;
        global $tgLog;

        $name = $user->data['username'];
        $responseText = 
"Привет, $name \xE2\x9C\x8B
Это бот напоминатель.
Набери /remind для создания напоминания.";
        $sendMessage = new SendMessage();
        $sendMessage->chat_id = $chat->id;
        $sendMessage->text = $responseText;
        $tgLog->performApiRequest($sendMessage);
    }
}