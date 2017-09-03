<?php

namespace App\Models;

/**
 * @Entity @Table(name="users")
 * @Entity @HasLifecycleCallbacks
 **/
class User {
    /** @Id @Column(type="integer") **/
    public $id;
    /** @Column(type="json_array") **/
    public $data;
}