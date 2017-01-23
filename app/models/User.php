<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
	public $timestamps = true;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	function teacher() {
		return $this->hasOne('Teacher');
	}

	function student() {
		return $this->hasOne('Student');
	}
	function admin() {
		return $this->hasOne('Admin');
	}

//might complicate students a bit,
	function roles() {
		//this will be foreached, & then access $roll->domain
		return $this->hasMany('Role');
	}
	
//THIS WORKS WELL !
	function deptroles() {
		$dept_roles =Config::get('preset.department_roles');
		return $this->hasMany('Role')->whereIn('role',$dept_roles);
	}

	/*Investor.php
		function teachers(){
			return $this->belongsToMany('Teacher','roles')->withPivot('bid_price','num_shares');
		}
		*/



	}
