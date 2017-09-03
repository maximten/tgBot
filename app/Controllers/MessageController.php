<?php
namespace App\Controllers;

use App\Models\Update;
use App\Models\User;
use App\Models\Chat;

class MessageController {
    public static $messageMap = [
        '/start' => \App\Responses\Start::class,
        '/bye' => \App\Responses\Bye::class,
        '/remind' => \App\Responses\Remind::class,
        'default' => \App\Responses\Start::class
    ];

    public function handle($update) {
        global $entityManager;
        global $tgLog;
        $data = json_decode(json_encode($update->data), true);
        $user = $data['message']['from'];
        $chat = $data['message']['chat'];
        $userRecord = $entityManager->getRepository(User::class)->find($user['id']);
        if (! $userRecord) {
            $userRecord = new User();
            $userRecord->id = $user['id'];
            $userRecord->data = $user;
            $userRecord->state = 'init';
            $entityManager->persist($userRecord);
        }
        $chatRecord = $entityManager->getRepository(Chat::class)->find($chat['id']);
        if (! $chatRecord) {
            $chatRecord = new Chat();
            $chatRecord->id = $chat['id'];
            $chatRecord->data = $chat;
            $entityManager->persist($chatRecord);
        }
        $entityManager->flush();
        $stateClass = "\App\States\\" . ucfirst($userRecord->state);
        $state = new $stateClass($userRecord, $chatRecord);
        $messageMap = $state->getMessageMap();
        if (isset($messageMap[$data['message']['text']])) {
            $responseClass = $messageMap[$data['message']['text']];
        } else {
            $responseClass = $messageMap['default'];
        }
        $response = new $responseClass(); 
        $response($update, $userRecord, $chatRecord);
    }
}