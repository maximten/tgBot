<?php

require(__DIR__ . '/bootstrap.php');

use unreal4u\TelegramAPI\HttpClientRequestHandler;
use unreal4u\TelegramAPI\TgLog;
use App\Controllers\UpdateController;
use App\Controllers\RemindersController;

global $tgLog;

while (true) {
    $loop = \React\EventLoop\Factory::create();
    $handler = new HttpClientRequestHandler($loop);
    $tgLog = new TgLog($CONFIG['bot_token'], $handler);

    try {
        $updateController = new UpdateController();
        $updateController->handle();
        $remindersController = new RemindersController();
        $remindersController->checkReminders();
    } catch (Exception $e) {
        $LOG->error($e->getMessage());
    }

    $loop->run();
    usleep(100);
}
