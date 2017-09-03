<?php

namespace App\Models;

/**
 * @Entity @Table(name="chats")
 * @Entity @HasLifecycleCallbacks
 **/
class Chat {
    /** @Id @Column(type="integer") **/
    public $id;
    /** @Column(type="json_array") **/
    public $data;
}