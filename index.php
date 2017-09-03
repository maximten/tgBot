<?php

require(__DIR__ . '/bootstrap.php');

use unreal4u\TelegramAPI\HttpClientRequestHandler;
use unreal4u\TelegramAPI\TgLog;
use App\Controllers\UpdateController;

global $tgLog;

while (true) {
    $loop = \React\EventLoop\Factory::create();
    $handler = new HttpClientRequestHandler($loop);
    $tgLog = new TgLog($CONFIG['bot_token'], $handler);

    try {
        $controller = new UpdateController();
        $controller->handle();
    } catch (Exception $e) {
        $LOG->error($e->getMessage());
    }

    $loop->run();
    usleep(100);
}
