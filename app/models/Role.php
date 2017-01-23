<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Role extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
    public $timestamps = true;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'roles';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');


/*Investor.php
	function products(){
		return $this->belongsToMany('Product','investments')->withPivot('bid_price','num_shares');
	}
	*/
	function users() {
	    return $this->belongsToMany('User');
	}

}
