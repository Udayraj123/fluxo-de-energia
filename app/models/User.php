    
<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class User extends Eloquent implements UserInterface {

	use UserTrait;

	protected $table = 'users';

    function god() {
        return $this->hasOne('God');
    }

    function farmer() {
        return $this->hasOne('Farmer');
    }
    function namelink() {
        //  Dependency! 
        // return '<b> '.$this->username.' </b>';
        return '<a href="'.route('profile',['id'=>$this->id]).'">'.$this->username.' </a>';
    }
    function investor() {
        return $this->hasOne('Investor');
    }

	protected $hidden = array('password');

}
