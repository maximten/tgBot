<?php
namespace App\Responses;

use unreal4u\TelegramAPI\Telegram\Methods\SendMessage;
use App\Models\Reminder;
use App\Models\User;
use App\Responses\Error;
use Carbon\Carbon;
use Exception;

class ReminderSaveTime {
    public function __invoke($update, $user, $chat) {
        global $entityManager;
        global $tgLog;

        $data = json_decode(json_encode($update->data), true);

        try {
            $reminders = $entityManager->getRepository(Reminder::class)->findBy([
                'user' => $user
            ], [
                'id' => 'DESC'
            ]);
            $lastReminder = array_shift($reminders);
            $datetime = new Carbon($data['message']['text']);
            if (! $datetime) {
                throw new Exception('Wrong time format');
            }
            $lastReminder->datetime = $datetime;

            $user->state = 'init';
            $entityManager->persist($lastReminder);
            $entityManager->persist($user);
            $entityManager->flush();

            $responseText = "Я все запомнил";
            $sendMessage = new SendMessage();
            $sendMessage->chat_id = $chat->id;
            $sendMessage->text = $responseText;
            $tgLog->performApiRequest($sendMessage);
        } catch (Exception $e) {
            $error = new Error();
            $error($update, $user, $chat);
        }
    }
}