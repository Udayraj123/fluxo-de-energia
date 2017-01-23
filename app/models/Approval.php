<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Approval extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
    public $timestamps = true;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'approvals';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');


	function student() {
	    return $this->belongsTo('Student');
	}
	function teacher() {
	    return $this->belongsTo('Teacher');
	}
	function users() {
	    return $this->belongsToMany('User');
	}

}
