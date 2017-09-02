<?php
namespace App\Controllers;

use unreal4u\TelegramAPI\Telegram\Methods\SendMessage;
use unreal4u\TelegramAPI\Telegram\Methods\GetUpdates;
use unreal4u\TelegramAPI\Abstracts\TraversableCustomType;
use unreal4u\TelegramAPI\Telegram\Types\User;

class UpdateController {
    public function handle($tgLog) {
        $getUpdates = new GetUpdates();
        $promise = $tgLog->performApiRequest($getUpdates);
        $promise->then(
            function (TraversableCustomType $updatesArray) {
                foreach ($updatesArray as $update) {
                    var_dump($update->update_id);
                }
            },
            function (Exception $e) {
                echo $e->getMessage();
            }
        );
    }
}