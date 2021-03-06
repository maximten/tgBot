<?php
namespace App\States;

use App\Models\User;
use App\Models\Chat;

class GetReminderText {
    protected $user;
    protected $chat;
    public function __construct(User $user, Chat $chat) {
        $this->user = $user;
        $this->chat = $chat;
    }
    public function getMessageMap() {
        return [
            '/stop' => \App\Responses\Stop::class,
            'default' => \App\Responses\ReminderSaveText::class
        ];
    }
}