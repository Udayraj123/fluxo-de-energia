<?php

/*

8Oct
>rethought -(threshold handle) sysLE being requested by all users per second, it MUST be accessed from a table that updates only if prev_time is a second less. else it returns the table value. That table can also contain the varying decay %

Todo:: if($p->launched) shall be corrected to  $p->launched==1 since -1 is also getting here.
::added avl_units in fruit 
::CLARIFICATION2 : num_units of fruits varies initially thru Fetchfruit, but after launch it stays constant
::made a table fruitbills to store fruit purchases.
Good : return Redirect::back();


		if(!(array_key_exists('num_shares', $input) && array_key_exists('product_id', $input))) return "Input not read.";
		// $num_shares = (int)(Input::get('num_shares')); //return "input get is calm";

7Oct
TODO :: filter if land/fert already applied

>Now do investor : buy fruit (storage le interface too)
>Then remaining is TRANSITION. THAT'S ALL !

Clarification :le will increase in FetchFruit! (TODO- visually show how much LE increased -pass in ajax array)
Do later- calcStorage LE detailed function (also show it on front end)

Do later- Soon, confirm that backend rechecks whatever from frontend's js.


::KNOWN BUG
Do later -
currently we are updating locally from the land. this way it is giving correct initial GTs.
But there's one more variable needed.
the Fert can be applied from X minutes of planted_at. The GT should now 
should not be :  seedGT / ( 1 + quals)
it should be prev_GT
ELse
We shall keep a RGT column which gets divided on fert apply. and that's what gets updated & checked everytime.
-but it wil require a prev_time just like user->le. => Do it that way then


::confirmed quality_factor from fruit table is like quality of the product
::Moved GT to land table. Made it more flexible & easy for calc
::Removed planted_at from fruit
i.e. Growing thing is now separated for Land

TODO : modified checkRGT now


2Oct 
:: The GT itself shall be calculated by actual GT of fruit & the factor of fert !
 	>else we'd not be able to combine unlaunched fruits

ToDO::land object shall be created after added from purchases(like seed & fert) to here // currently made directly at time of purchase
TODO->later make GT logarithmic so that qual=10 & qual = 50 are not 5 times diff in magnitude

1Oct
::As GT is calculated for a fruit only when it is 'planted' on a land, the planted_at is more convinient in Land table.

::Land Menu requires-
	Purchase table, Lands table, Fruits table
	>Purchase is used to give no of seeds in inventory.
	>Lands contains individual objects for each block
	>Fruits is the products table

> Things will happen serially-
	Fruit Obj will be created AT THE TIME OF PURCHASE, with num_units=0;

	Done- Land => 16=avl_units land obj for one farmer,  (see QueryPractice function())
		each land has an id,seed_id & fert_id (them -1 means not applied)
			 seed_id = of currently applied seed
			 Fert_id =  of currently applied Fert (Though no need of adding now, keep it for the sake of sustainablity)

	Inventory => Browse thru farmer->purchases 4=avl_units seed 1  & 2=avl_units Fert 1 (not clubbing them!) 
		 	(One seed => One land)
		 	(Each fert can be applied to maxFert = 3 seeds.)
	
	Fruit obj will be having num_units just like products table, 
		it shall "Merge" fruits table by purchase ids & launched=0;

	( new! ) Fruit Storage- all fruits with launched=0 and num_units>0
	Launched fruits - you get it.

(apply simi to products now)=>
	(inv) showFruits - all farmers' fruits whos launched=1,RET>0 
	(inv) buyFruit - decrement avl_units of fruits table && storageLE will be added to buying user



//Helper functions- Func is alias for config/classes/Functions.php
		echo Func::add('a');		return;



TODO >> can reduce SUM(le) operations by keeping time()-updated_time > 30sec for each user req (thru filters.php)

> is LE check done thru filters ?? YUP >> ITS THE BEST WAY  (just check thru ajax if it updates _/ yup)!
TODO (think)>>Can we check ET/GT thru filters? yeah, but think once again.

Done -  modular functions in admin
*/

/*
* 30 sep updates >6:37pm showLand isn't properly working, will do it soon
* 27 sep updates >Some aliases in app.php are cool !
>TODO- change this types to array_key_exists-
	if(!($input['avl_units']&&$input['category']&& $input['unit_price'] && $input['FT']>0 && $input['ET']>0 ))

* 25 Sep updates 
:: IC makeInvestment - flag was redundant, removed & tested
:: renamed num_units to avl_units in Products table
TODO - Need corelation between bid_price & total_cost (1079 bid for vs 47.5 cost for one)
TODO(think) - * $p->bid_price can be eliminated as of now as it only updates the redundant bid_price in invm.
CAUTION * The created_at wherever used might change after $p->save() like bid_price. (though default not null saves it)
CAUTION * Filtering about being funded is done in the routes
UPDATE * $p->being_funded= -1 stands for deleted
TEMP* 'fruitBP'=>500,  //later this wil be a factor from seed's price

*/
/**
** No need to maintain seed, make a fruit on buying product-cat seed (eqv to migrating all columns of fruit into seed)

CLARIFICATIONS - 
//Got - 
    function purchased_land() {
//purchases whose id is same as land_id in fruit .
    	return $this->belongsTo('Purchase','land_id','id');  Fruit's land_id, purchase's id
    }

***UNIT_PRICE IS CONSTANT, 
BID_PRICE UPDATES.	$buy_price=$p->unit_price + $godRecovery*($loss)/($num)*($time_elapsed)/($p->ET);

NUM_UNITS CAN DECREASE
***Bid price is price of a share, it is given by total_cost/total_shares. It increases so as to return decay loss to god.

**any point of keeping bid_price in investment ? we are returning godReturns on the spot! while funding bar is seen by $base_share * num_shares
	-one point is when investor want to sell their own shares at "market price"				

PROBS-
> bid_price is to be removed from invm (to CLUB'em), but investor shall have data of his prev invm bid_prices
--> Now we are not clubbing em, then it shall be kept for inv to have track of thee expenses


>we need to get better formula for THR than simply % of total, something simpler Actually
	farmer THR needs a change (5.4 was thr once)
TODO : farmer's buyProduct shall check expiry !
lets go. Current LE = 41472
Buy price = -23968342.960167 Num= 10
Buy price = -23968342.960167 Num= 10
Success. Now LE = 479408331.20333

*/

class admin extends \BaseController {
//CALL THIS FUNCTION EVERY 30MIN OR SO => To avoid Stucks
//MOVE THE FUNCTION BELOW TO SQL functions in Workbench
	

	function checkID(){
		$user=Auth::user()->get();
		if($user->id == 42){
			echo "Life Origin confirmed, task run";
			return 1;
		}
		else {
			echo "<a href='/login/42'> Login</a>";return 0;
		}
	}

	public function boostLE(){
		if(!$this->checkID())return;
		$boostG=1.2;
		$boostI=1.5;
		$boostF=1.8;
		$users=User::all();
		foreach ($users as $u) {
			$u->le *= $boostG;
			$u->save();
			echo $u->le." ";
		}

	}

	public function updateUsers(){
		if(!$this->checkID())return;
		$users=User::all();
		$t=time();
		foreach ($users as $u) {
			$u->prev_time =$t;
			$u->save();
		}
	}


	public function plantSeedLands(){
		if(!$this->checkID())return;
		$lands=Land::all();
		$t=time();
		foreach ($lands as $l) {
			if($l->seed_id>0){
				$l->planted_at =$t; $l->save();
			}
		}
	}

	public function resetUsers(){
		if(!$this->checkID())return;

		$users=User::all();
		$t=time();
		$ini=Config::get('game.iniLE');
		foreach ($users as $u) {
			$u->prev_time =$t;
			$u->le=$ini[$u->category];
			$u->save();
		}

	}

	public function resetProducts($launch=0){
		if(!$this->checkID())return;
		$ps=Product::all();
		$t=time();
		foreach ($ps as $p) {
			if($launch){
				$p->launched_at =$t;
				$p->being_funded=0;
			}
			else{
				$p->being_funded=1; $p->save(); //for updated_at
				$p->created_at=$p->updated_at; //this is not working correctly !
			}
			$p->save();
		}
	}
	public function resetFruits(){
		if(!$this->checkID())return;
		$ps=Fruit::all();
		$t=time();
		foreach ($ps as $p) {
			if($p->launched==1 || $p->launched==-1)
				$p->launched=1;
				$p->launched_at =$t;
			$p->save();
		}
	}

}

/*
        // return $this->hasManyThrough('Investor','Investment','product_id','investment_id','product_id');//,'product_id','investor_id','id'); 

//pivot not well when multi investments between same ppl 
-- WE ARE not at all CLUBBING EM !
--we will run a loop on invm-inv_id, and return total profits
$num_shares = $inv->pivot->num_shares; - NOW WE ARE NOT ALLOWING MULTI //beware - same investor & same product can have multi investments

TODO-
//Discarded - LAND MENU : integrate & check amoghhController

//Make every created_at into Nullable default null - ELSE MAINTAIN A DIFF COLUMN - BEST

//seed GT shall later also depend on its sub-type

	if($p->avl_shares)$p->being_funded=0;		         <-- What's correct place to update this?

	Decays & Threshold => SIGMOID FUNCTION MUST
	REDIRECTS : Character transitions,create product makeinvestment,etc buy/make functions redirect after submit 


>>>THese may not be required here, since we are updating them thru calcBidPrice / calcSellPrice etc
	public function fruitExpiry($user){


/Tolerance should affect price thru a const, but thru the unit_price * (100+tol) 	- Done 
/all product parameters shall be confirmed positive before storing (price,FT(divides in bid_price) shall not be negative) - Sliders do that.
ALL KINDS OF SLIDERS SHALL NOT START FROM 0

SOLVED->
//BUT SAVING IS RESETING THE TIMESTAMP in buyProduct too num_units--
$p->save() is changing created_at timestamp also (seen thru phpmyadmin)

Done- **write ajax for bid_price by prod id -> *changed Default=NULL in table* 
Done- unit_price shall get calc at backend again. 

Show RFT in makeInvestment - Done
**Other handy method >?
	 {array-$change = array('key1' => $var1, 'key2' => $var2, 'key3' => $var3);return json_encode(change);}
				Then the jquery script ...
			$.post("location.php", function(data){var duce = jQuery.parseJSON(data);var art2 = duce.key2;});	
			**/


/*
EACH FUNCTION SHALL ADD AN IF CONDN TO CHECK IF USER IS GOD/FARMER/INV -Done
	//USER MIDDLEWARE for checking it is a farmer & all.


 TODO-
 #>Check if quality slider is under range at backend
# >Ajax for bid price? -> IMPLEMENT NOW 	


//USER MIDDLEWARE for checking it is a farmer & all.

#*** Admin Panel REQUIRED  boostLE/reset FT(time_when_created+= time passed) => the decay/FT/ET will still go on due to timestamp stuff in case server stops !


		    	// ->> CHANGED THIS to saving a column in user database.
#Target -

# >Make forms for Product class  (exclude necessary paras) -Done

# >Makeinvestment function. - Done

# >Make similar for fruit price setting 	-Done

# > buy fruit

#ajax for Decay & LE  - Done => but add it to master.

# thresholdHandle -Done
# decayHandle - Done

# >Ajax  CHANGING CHARACTER THR Check   

#> Ajax to update FT & GT. also do this inside makeInvestment


# >Land mini game -> returning land blocks array.

  // $k=Config::get('game.catTables');	 $le = $k[$active_cat]::where('user_id',$id)->first()->le;


    	// if(!Session::has('prev_time')){ //first time
		    	// 	Session::put('prev_time',$ctime);
		    	// }
		    	// $ptime = Session::get('prev_time');

s		    	// Log::info($ptime); // <--- THIS  is not taking the updated time 


//   $.ajax({
//   method: "POST",
//   url: "{{ route('home') }}",
//   data: { 'name': "Johnny", 'location': "Boston" },
// })
//   .success(function( data ) {
//     console.log(data);
//   });



**/

