<?php
return [
'facDecay' => array("god" => 1*(0.1*0.1/60),"investor" =>(0.1*0.01/60),"farmer" =>5*(0.1*0.001/60)),
'iniLE' => array("god" => 1000000,"investor" => 500000,"farmer" => 40000),
'stored_LE' => array("god" => 100000,"investor" => 50000,"farmer" => 4000),
'numGods'=>5,
'numInvs'=>15,
'minLE' => 1000,
'minRefreshRate'=>1,
'notifTime'=>60,

'basePrices' => array("seed" => 500,"fertilizer" => 2000,"land" => 7000),

//thresholds - better kept separate than in array now
'facGM' => 0.09, //F yeah mode
'facGI' => 0.005,
'facFI' => 0.0005,//this factor may depend on number of users ?!
'facF' => 0.00005,

// 'commonGod'=>Common::where('category','god')->first(),
// 'commonInvestor'=>Common::where('category','investor')->first(),
// 'commonFarmer'=>Common::where('category','farmer')->first(),

'godPercent'=>0.51,
'godReturns'=>0.81, //funding returns
'godRecovery'=>0.1, //selling returns (of ET decay)
'farmerRecovery'=>20, //selling fruit returns

'baseCIs'=>[
'c1'=>0.002,  //quality for product
'c2'=>0.005, //FT
'c3'=>0.002,  //ET
'c4'=>0.003,  //TOL
],


// $fruit->sell_price = $fruit->storage_le * ($c1*$fruit->quality_factor + $c2*$fruit->ET) ; //calculate the unit_price of fruit.
'fruitC1'=>0.008,  //quality for fruit
'fruitC2'=>0.005, //FT
'fruitC3'=>0.002,  //ET
'fruitC4'=>0.003,  //TOL
'fruitBP'=>500,  //later this wil be a factor from seed's price
'sellC1'=>0.002,
'sellC2'=>0.012,
'fruitReturns' => 20, //On fetch, directly dmultiplied by the quality  (num_units=1 at a time)
'storage_fac' => 0.5, //*goes to (storage_fac + 1)*unit_price at 100% quality


'seedGT' =>5 * 50,//50 quality shall have 5 min	//GT=seedGT/q;more qual, less GT. quality ranges from 1 to 100.
'maxGT'  =>999,//minutes. this is returned for unused lands in ajax req 
'maxFertSeeds' => 3,//
'maxQual' => 100,
'baseQual'=>50,
'seedQual'=>0.8, // *ly for GT ?!
'fertQual'=>0.18, // this reduces quality range to favourable
'landQual'=>0.18, 
];
?>