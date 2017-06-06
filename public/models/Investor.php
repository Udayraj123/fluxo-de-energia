<?php
/**
 * Created by PhpStorm.
 * User: aneeshdash
 * Date: 27/11/14
 * Time: 10:43 AM
 */
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Investor extends Eloquent implements UserInterface {

	use UserTrait;

	protected $table='investors';

	public $timestamps = true;

	function user() {
		return $this->belongsTo('User');
		//UName  = $inv->user->username;
	}

	function investments() {
		return $this->hasMany('Investment');
	}

	function products(){
        return $this->belongsToMany('Product','investments')->withPivot('bid_price','num_shares');
	}
	

} 