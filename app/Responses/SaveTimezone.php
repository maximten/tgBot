<?php
namespace App\Responses;

use unreal4u\TelegramAPI\Telegram\Methods\SendMessage;
use App\Responses\Remind;
use App\Responses\Error;

class SaveTimezone {
    public function __invoke($update, $user, $chat) {
        global $entityManager, $tgLog, $timezones;

        $data = json_decode(json_encode($update->data), true);
        $text = $data['message']['text'];
        $timezone = intval($text);

        if (is_numeric($text) && is_int($timezone)) {
            if ($timezone < 0 || $timezone > count($timezones)) {
                $sendMessage = new SendMessage();
                $sendMessage->chat_id = $chat->id;
                $sendMessage->text = "Неправильный формат временной зоны";
                $tgLog->performApiRequest($sendMessage);
            } else {
                $timezonesList = array_keys($timezones);
                $user->timezone = $timezonesList[$timezone];
                $entityManager->persist($user);
                $entityManager->flush();
                $responses = new Remind();
                $responses($update, $user, $chat);
            }
        } else {
            $responses = new Error();
            $responses($update, $user, $chat);
        }
    }
}