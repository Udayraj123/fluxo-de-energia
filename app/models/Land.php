<?php

class Land extends Eloquent {
    
    protected $table='lands';

    public $timestamps = true;
        // return $this->belongsTo('Product');

    function purchase() { 
        //FUNCTION NAME IS LOOKED UP ! IT DOES NOT LOOKUP THE MODEL NAME!
        return $this->belongsTo('Purchase','purchase_id','id');//this is what we do when different function name
    }

    function seed() {
        return $this->belongsTo('Purchase','seed_id','id'); //we provided extra args as table name Purchase is not matching with seed
    }

    function fertilizer() {
        return $this->belongsTo('Purchase','fert_id','id');
    }

    //may come useful later
    function abc() { 
        return $this->belongsToMany('Fruit','lands','id','fruit_id');
    }

    function farmer() {
        return $this->belongsTo('Farmer');
        // return $this->belongsTo('Farmer','farmer_id','id');//this will work but we don't have farmer column directly
       // return $this->belongsToMany('Investor','investments')->withPivot('bid_price','num_shares'); //Requires a separate table, Nope.
    }

} 