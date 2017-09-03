<?php

namespace App\Responses;

class Info {
    public function __invoke($update) {
        $data = json_decode(json_encode($update->data), true);
        $name = $data['message']['from']['username'];
        return "Привет, $name";
    }
}