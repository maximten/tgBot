<?php
namespace App\Responses;

use unreal4u\TelegramAPI\Telegram\Methods\SendMessage;

class Stop {
    public function __invoke($update, $user, $chat) {
        global $entityManager;
        global $tgLog;

        $user->state = 'init';
        $entityManager->persist($user);
        $entityManager->flush();

        $responseText = "Я тебя понял";
        $sendMessage = new SendMessage();
        $sendMessage->chat_id = $chat->id;
        $sendMessage->text = $responseText;
        $tgLog->performApiRequest($sendMessage);
    }
}