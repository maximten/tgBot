<?php
namespace App\Responses;

use unreal4u\TelegramAPI\Telegram\Methods\SendMessage;
use App\Responses\AskTimezone;

class Remind {
    public function __invoke($update, $user, $chat) {
        global $entityManager;
        global $tgLog;

        if (! $user->timezone) {
            $user->state = 'getTimezone';
            $entityManager->persist($user);
            $entityManager->flush();
            $response = new AskTimezone();
            $response($update, $user, $chat);
        } else {
            $user->state = 'getReminderText';
            $entityManager->persist($user);
            $entityManager->flush();

            $responseText = "Что тебе напомнить?";
            $sendMessage = new SendMessage();
            $sendMessage->chat_id = $chat->id;
            $sendMessage->text = $responseText;
            $tgLog->performApiRequest($sendMessage);
        }

    }
}