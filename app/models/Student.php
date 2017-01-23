<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Student extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
	public $timestamps = true;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'students';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	function deptfacs(){
		return $this->belongsToMany('Teacher','dept_approvals')->withPivot('approved');
	}

	function facs(){
		return $this->belongsToMany('Teacher','approvals')->withPivot('approved');
	}

	function approvals(){
		return $this->hasMany('Approval')->where('approved','>',0);
		// return $this->hasMany('DeptApproval');
	}

	function rejections(){
		return $this->hasMany('Approval')->where('approved','==',0);
		// return $this->hasMany('DeptApproval');
	}
	function user() {
		return $this->belongsTo('User');
	}


}
