<?php
namespace App\States;

use App\Models\User;
use App\Models\Chat;

class Init {
    protected $user;
    protected $chat;
    public function __construct(User $user, Chat $chat) {
        $this->user = $user;
        $this->chat = $chat;
    }
    public function getMessageMap() {
        return [
            '/start' => \App\Responses\Start::class,
            '/remind' => \App\Responses\Remind::class,
            'default' => \App\Responses\Error::class
        ];
    }
}