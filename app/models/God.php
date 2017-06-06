<?php
/**
 * Created by PhpStorm.
 * User: Udayraj Deshmukh
 * Date: 11/10/16
 * Time: 8:29 AM
 */
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class God extends Eloquent implements UserInterface {

    use UserTrait;
   
    protected $table='gods';
    
    public $timestamps = true;

    function user() {
        return $this->belongsTo('User');
    }

    function products() {
        return $this->hasMany('Product');
    }

} 