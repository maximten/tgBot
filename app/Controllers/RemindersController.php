<?php
namespace App\Controllers;

use unreal4u\TelegramAPI\Telegram\Methods\SendMessage;
use App\Models\Reminder;
use Carbon\Carbon;

class RemindersController {
    public function checkReminders() {
        global $entityManager, $tgLog;

        $reminders = $entityManager->getRepository(Reminder::class)->findBy([
            'isSended' => false
        ]);

        foreach ($reminders as $reminder) {
            $datetime = $reminder->datetime;
            if ($datetime != null) {
                $user = $reminder->user;
                $reminderDatetime = Carbon::parse($datetime->format('Y-m-d H:i:s'), $user->timezone);
                $now = Carbon::now($user->timezone);
                $isTime = $reminderDatetime->lte($now);
                if ($isTime) {
                    $sendMessage = new SendMessage();
                    $sendMessage->chat_id = $reminder->user->id;
                    $sendMessage->text = 
"Твоя напоминалка:
{$reminder->text}";
                    $tgLog->performApiRequest($sendMessage);
                    $reminder->isSended = true;
                    $entityManager->persist($reminder);
                    $entityManager->flush();
                }
            }
        }
    }
}