<?php

namespace App\Responses;

class Bye {
    public function __invoke($update) {
        $data = json_decode(json_encode($update->data), true);
        $name = $data['message']['from']['username'];
        return "Пока, $name";
    }
}