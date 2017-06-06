<?php

class Fertilizer extends Eloquent {
    
    protected $table='fertilizers';

    public $timestamps = true;

    function product() {
        return $this->belongsTo('Product');
    }

} 