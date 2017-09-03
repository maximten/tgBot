<?php

namespace App\Models;

/**
 * @Entity @Table(name="reminders")
 * @Entity @HasLifecycleCallbacks
 **/
class Reminder {
    /** @Id @Column(type="integer") @GeneratedValue **/
    public $id;
    /** @Column(type="text") **/
    public $text;
    /** @Column(type="datetime", nullable=true) **/
    public $datetime;
    /** @Column(type="boolean") **/
    public $isRepeated = false;
    /** @Column(type="boolean") **/
    public $isSended = false;
    /**
     * @ManyToOne(targetEntity="User", inversedBy="reminders")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    public $user;
}