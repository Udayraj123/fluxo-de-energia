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
use Product;
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
    function funding_products() {
        return Product::where('god_id',$this->id)->where('being_funded',1);
    }

} 