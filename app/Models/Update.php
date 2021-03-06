<?php

namespace App\Models;

/**
 * @Entity @Table(name="updates")
 * @Entity @HasLifecycleCallbacks
 **/
class Update {
    /** @Id @Column(type="integer") **/
    public $update_id;
    /** @Column(type="json_array") **/
    public $data;
}