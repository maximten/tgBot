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
    /** @Column(type="string") **/
    public $state;
    /** @Column(type="string", nullable=true) **/
    public $timezone;
    /**
     * @OneToMany(targetEntity="Reminder", mappedBy="user")
     */    
     public $reminders;
}