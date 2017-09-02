<?php

namespace App\Models;

/**
 * @Entity @Table(name="updates")
 * @Entity @HasLifecycleCallbacks
 **/
class Update {
    /** @Id @Column(type="integer") **/
    protected $id;
    /** @Column(type="json_array") **/
    protected $data;
}