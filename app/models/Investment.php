<?php
/**
 * Created by PhpStorm.
 * User: aneeshdash
 * Date: 27/11/14
 * Time: 10:34 AM
 */

class Investment extends Eloquent {
    
    
    protected $table='investments';

    public $timestamps = true;


    function product() {
        return $this->belongsTo('Product');
    }
    function investor() {
        return $this->belongsTo('Investor');
    }

//ONLY RELATIONS HERE   ( Or scopes also>) 
	// function inv(){
	// 	return $this->investor->name;
	// }
	// function prod(){
	// 	return $this->product->category;
	// }

} 