<?php
namespace App\Responses;

use unreal4u\TelegramAPI\Telegram\Methods\SendMessage;
use App\Models\Reminder;

class ReminderSaveText {
    public function __invoke($update, $user, $chat) {
        global $entityManager;
        global $tgLog;

        $data = json_decode(json_encode($update->data), true);

        $reminder = new Reminder();
        $reminder->text = $data['message']['text'];
        $reminder->user = $user;
        $entityManager->persist($reminder);
        $user->state = 'getReminderTime';
        $entityManager->persist($user);
        $entityManager->flush();

        $name = $user->data['username'];
        $responseText = 
"Когда тебе это напомнить?";
        $sendMessage = new SendMessage();
        $sendMessage->chat_id = $chat->id;
        $sendMessage->text = $responseText;
        $tgLog->performApiRequest($sendMessage);
    }
}