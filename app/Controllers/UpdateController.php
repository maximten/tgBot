<?php
namespace App\Controllers;

use unreal4u\TelegramAPI\Telegram\Methods\SendMessage;
use unreal4u\TelegramAPI\Telegram\Methods\GetUpdates;
use unreal4u\TelegramAPI\Abstracts\TraversableCustomType;
use App\Models\Update;

class UpdateController {
    public function handle() {
        global $entityManager;
        global $tgLog;
        $list = $entityManager->getRepository(Update::class)->findBy([], [
            'update_id' => 'DESC'
        ]);
        $lastUpdate = array_shift($list);
        $getUpdates = new GetUpdates();

        if ($lastUpdate) {
            $getUpdates->offset = $lastUpdate->update_id;
        }
        $promise = $tgLog->performApiRequest($getUpdates);
        $promise->then(
            function (TraversableCustomType $updatesArray) use ($lastUpdate) {
                global $entityManager;
                global $LOG;
                foreach ($updatesArray as $update) {
                    if (is_null($lastUpdate) || $lastUpdate->update_id != $update->update_id) {
                        $updateRecord = new Update();
                        $updateRecord->update_id = $update->update_id;
                        $updateRecord->data = (array) $update;
                        $entityManager->persist($updateRecord);
                        $newUpdates[] = $updateRecord; 
                        $entityManager->flush();
                        $LOG->info("get update: {$update->update_id}");
                        $messageController = new MessageController();
                        $messageController->handle($updateRecord);
                    }
                }
            },
            function (Exception $e) {
                global $LOG;
                $LOG->error($e->getMessage());
            }
        );
    }
}