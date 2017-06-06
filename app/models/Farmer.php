<?php

class Farmer extends Eloquent {
    
    protected $table='farmers';

    public $timestamps = true;

    function user() {
        return $this->belongsTo('User');
    }

    function purchases() {
        return $this->hasMany('Purchase');
    }

    function products(){
        return $this->belongsToMany('Product','purchases')->withPivot('buy_price','num_units','avl_units','created_at');
    }
    function lands() {
        return $this->hasMany('Land');
    }

    function fruits(){
        return $this->hasMany('Fruit');
    }

    function investors() {
        return $this->belongsToMany('Investor','fruitbills')->withPivot('buy_price','num_units'); //Many to Many using THROUHGH
    }


} 