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

class Common extends Eloquent {

    use UserTrait;
   
    protected $table='commons';
    
    public $timestamps = true;


// no relations. its a commons table

} 