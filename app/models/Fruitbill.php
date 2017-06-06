<?php
/**
 * Created by PhpStorm.
 * User: aneeshdash
 * Date: 27/11/14
 * Time: 10:34 AM
 */

class Fruitbill extends Eloquent {
    
    protected $table='fruitbills';

    public $timestamps = true;

    function fruit() {
        return $this->belongsTo('Fruit');
    }
    
    function investor() {
        return $this->belongsTo('Investor');
    }

} 