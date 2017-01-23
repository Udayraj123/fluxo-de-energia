<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Teacher extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
	public $timestamps = true;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'teachers';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

// DO NOT KEEP UNDERSCORES IN THE FUNCTION NAMES, THEY ARE INTERPRETED AS SOMETHING ELSE
	function approvalstuds(){
		// return $this->belongsToMany('Student','dept_approvals')
		return $this->belongsToMany('Student','approvals')
		->withPivot('approved','role','domain_field','domain_val');
	}

	function approvals(){
		return $this->hasMany('Approval');
		// return $this->hasMany('DeptApproval');
	}
	function user() {
		return $this->belongsTo('User');
	}


}
