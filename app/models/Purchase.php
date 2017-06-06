<?php
/**
 * Created by PhpStorm.
 * User: aneeshdash
 * Date: 27/11/14
 * Time: 10:34 AM
 */

class Purchase extends Eloquent {
    
    protected $table='purchases';

    public $timestamps = true;

    function product() {
        return $this->belongsTo('Product');
    }
    
    function farmer() {
        return $this->belongsTo('Farmer');
    }


//we are not making many fruits, consider lands for this if required.
    // function fruits() { // <-- why? : because we are making many fruit objects when purchase is of a seed
    //     return $this->hasMany('Fruit');
    // }
} 