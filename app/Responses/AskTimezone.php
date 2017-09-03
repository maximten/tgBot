<?php
namespace App\Responses;

use unreal4u\TelegramAPI\Telegram\Methods\SendMessage;
use Carbon\Carbon;

class AskTimezone {
    public function __invoke($update, $user, $chat) {
        global $entityManager, $tgLog, $timezones;
        
        $timezonesList = array_keys($timezones);
        
        $timezonesText = [];
        $now = Carbon::now();
        foreach ($timezonesList as $key => $item) {
            $now->setTimezone($item);
            $timeString = $now->toTimeString();
            $timezonesText[] = str_pad($key, 4, " ", STR_PAD_RIGHT) . " " . str_pad($item, 15, " ", STR_PAD_RIGHT) . " : $timeString";
        }
        $lastIndex = count($timezonesList) - 1;
        $responseText = "Какая твоя часовая зона? Выбери номер (0: $lastIndex)\n" . join("\n", $timezonesText);
        $sendMessage = new SendMessage();
        $sendMessage->chat_id = $chat->id;
        $sendMessage->text = $responseText;
        $tgLog->performApiRequest($sendMessage);
    }
}