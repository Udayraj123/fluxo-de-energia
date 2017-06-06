<?php

class Seed extends Eloquent {
    
    protected $table='seeds';

    public $timestamps = true;

    function product() {
        return $this->belongsTo('Product');
    }

} 