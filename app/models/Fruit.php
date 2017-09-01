<?php

class Fruit extends Eloquent {
    // use SoftDeletingTrait; //not keeping the deleted_at column
    public $timestamps = true;
    protected $table='fruits';

    function farmer() {
        //this is unnecessary when we have the seed table
        //but convenient as to the analogy of product with god
        return $this->belongsTo('Farmer');
    }
    
    function purchase() {
        return $this->belongsTo('Purchase');
    }
    
    // function fruitbills() {
    //     return $this->belongsTo('Fruitbill');
    // }

    function seed() {
        return $this->belongsTo('Purchase'); //looksfor seed_id in fruit to match with id of a Purchase
        //IT DOES NOT LOOKUP THE MODEL NAME!
    }

//my req- purchases whose product category is land | seed | fert => query

    function purchased_land() {
        return $this->belongsTo('Purchase','land_id','id'); //land_id in fruit needs to be equal to purchase id of it
    }

    function purchased_fertilizer() {
    	return $this->belongsTo('Purchase','fertilizer_id','id');
    }

} 