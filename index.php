<?php

require(__DIR__ . '/bootstrap.php');

use unreal4u\TelegramAPI\HttpClientRequestHandler;
use unreal4u\TelegramAPI\TgLog;
use App\Controllers\UpdateController;

$loop = \React\EventLoop\Factory::create();
$handler = new HttpClientRequestHandler($loop);
$tgLog = new TgLog($CONFIG['bot_token'], $handler);

try {
    $controller = new UpdateController();
    $controller->handle($tgLog);
} catch (Exception $e) {
    $LOG->error($e->getMessage());
}

$loop->run();