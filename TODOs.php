<?php
"""
LAST MOMENT CALLS 
>> LOGGING EVERYTHING INTO USER FILES
showLand -> show quality on top
> upcoming Products
login allots


Final Call.
// save prev states into a file or something


KEEP NOTE OF USER:: queries -> check is_moderator=0

TEST TEST TEST
>> Farmer sellFruit and Returns

ALL WATCH THRU LOGS!

// some column values
	// Investment::where('investor_id',$inv->id)->sum('amt_ret');

>server setup

THINK THINK THINK
> Return events notify
>> Transaction Details Logs

_/ new Pages
_/ leaderBoard

REMOVE DEBUG LINES
> Product Name Ids from dropdown
> Team ID instead of Usernames in Funding Bar

FrontendDos- dataTables

BUG BUG
showLand land_ids is null

26 August 
Shall investment be in the God n not product??
- Nope, that's complicating it and making it just like vsm
- Also the code is established already to even think about that.
>> This is the point where the Game differs from VSM.
- And in reality there must be an analogy where people invest in the product and not company

Current procedure is an investor when buys the shares, they will automatically cash out when the product expires.

Things from below to cover today - selfProducts - Nope, its merged in createProd, newsBoard
start on Test files.

7 June : 
So the plan is : Try not doing it casually, give it finite time and finish the backend first.
List Major coding left :
1. Transitions
> Think of their stable movements
2. Ajax fill
3. Frontend :
>selfProducts
>Home Page Graphs

Get : What is maxFertSeeds for ?
Later : Write test files !
"""

TodayDos :
// 26 June
Thinking of Practical requirements : 
> Need to list Variety in products
> Converted ETs & FTs from 5 min to 60 Minutes. Kept seed GTs to 5 mins
> Add progress bar for Launching Products

Working on farmer side :
// UPDATE * $p->being_funded= -1 stands for deleted
>buyProd : 
If buy_price is -1, front end removes that expired product

// 14 June 
Now: Realised the workflow again - First make it fully functional, then add the GUI complexity. 
Currently just redirect back
>But still, the functioning of json arrays needs to be added - in listInvestments, buyFruit (tally with buyProduct)
REDIRECTS : Character transitions,create product makeinvestment,etc buy/make functions redirect after submit 

//make a function in GC to return the products array
//RFT - may change this created at to created_time later.

Later >Give GUI to the receipts : Notifs of Purchase & each LE Update : like a bank statement
Later >Fetch Fruit : here we also increase Farmers energy a bit    
<Thru Practical> How to reorder the purchases - by sales.
Decide order of prods shown for makeInvestment
How to highlight profits - update colors (use spl bootstrap template)

Nope if - only To keep the gap, itd be complicated - Decay = function (SIGMOID(time),Threshold)
/**********	**********	**********	**********	********************	**********	**********/

Done > Makeinvestment page : Limit by avl_shares,  ajax the bid price
Done >> master.blade.php should have a Links array (stored in game.php) to populate Navigation links;
Done >> sumLE was already improved. Just had to put it into Game::
NOPE - Think ::TRANSITIONS & WARNINGS IN FILTERS ? 
>> Yeah its prob. Gave bugs 'during' transacts. >> Adding Reloads
>> But. The ajax calls might cause trouble ?
Well, will they be handled by your functions?
-Yeah, and filters will not let it reach the function
>> So I am back to square one in this. Removing from filters.
Done > For ajax in threshold/decayHandle : add a parameter called reload. If its one, the frontend will reload the page.
Done > Indicator Arrows for Level Up/Down warnings.
// 10 June
Easy way to convert array in views:
var messages={{ json_encode(C::get('game.notifHTMLs')); }}

> The game is hard to play without knowing the updates. 
(Nope-  Tables are the best right now. - Though tables are there, I see notifs is required.)

> Notif I am choosing state based currently. If required, can add a new database just for that,
> Events will come handy here.
/**********	**********	********************	**********	**********/
AllToDos: 
12Oct
//Land Menu TODO - applyPurch(fert) This shall count in the plant_time as well as 'fert_time'
//create Product TODO - RFTs need to be updated with ajax along with the ones in makeInvestment. Else its too static for gods
7 Oct
TODO(think) - * $p->bid_price can be eliminated as of now as it only updates the redundant bid_price in invm.

2Oct
ToDO::land object shall be created after added from purchases(like seed & fert) to here // currently made directly at time of purchase
TODO->later make GT logarithmic so that qual=10 & qual = 50 are not 5 times diff in magnitude

SEPT : 
High-
->(think) - * $p->bid_price can be eliminated as of now as it only updates the redundant bid_price in invm.
->(think) Can we check ET/GT thru filters? yeah, but think once again.

Bug >
-> : farmers buyProduct shall check expiry ! : 
Log >> Current LE = 41472. Buy price = -23968342.960167 Num= 10Success. Now LE = 479408331.20333
TODO : modified checkRGT now

AntiHackDos: 
	#>Check if quality slider is under range at backend

Clarification :le will increase in FetchFruit! (->- visually show how much LE increased -pass in ajax array)
- Need corelation between bid_price & total_cost (1079 bid for vs 47.5 cost for one)

	*/
Later: 
//later use push to show more messages
// notifs.push(messages[m]);
$('#msg').html(messages[m]);

Do later- calcStorage LE detailed function (also show it on front end)
Do later & NOT NOW!- Soon, confirm that backend rechecks whatever from frontends js.
//seed GT shall later also depend on its sub-type
later make GT logarithmic so that qual=10 & qual = 50 are not 5 times diff in magnitude
Do later- server returns an array of past 100 LEs. OR the JS does it (maybe ajax doesn't destroy the vars)
::KNOWN  CONCEPT BUG'
Do later -
currently we are updating locally from the land. this way it is giving correct initial GTs.
But theres one more variable needed.
the Fert can be applied from X minutes of planted_at. The GT should now 
should not be :  seedGT / ( 1 + quals)
it should be prev_GT
ELse
We shall keep a RGT column which gets divided on fert apply. and thats what gets updated & checked everytime.
-but it wil require a prev_time just like user->le. => Do it that way then
	//TODO : rectify this bad condition 
$minLE=C::get('game.minLE');
if($user->le - $decay*$time_passed > $minLE)

	Done:: filter if land/fert already applied
Done -> >> can reduce SUM(le) operations by keeping time()-updated_time > 30sec for each user req (Nope - thru filters.php)
Done::->  if($p->launched) shall be corrected to  $p->launched==1 since -1 is also getting here.
Done::-> change this types to array_key_exists- if(!(array_key_exists('num_shares', $input) && array_key_exists('product_id', $input))) return "Input not read.";

Done:://Make every created_at into Nullable default null - ELSE MAINTAIN A DIFF COLUMN - BEST
Done:: -> Prefer using Input::get('num_shares')); //return "input get is calm";

/*
15Oct
Will listing products be done without array in ajax ?
->yeah, we anyways send php variables through it. so ajax don't seem a problem.


14 Oct
Doing Funding bar visuals now.
-> Found this out now ! {{
	This can also query on any database ! no need to pass stuff from ajax unneccessarily !
	Still we need ajax to get updated data, as this method processes static data only
	-> but this can reduce the server load. since sending this big object shall be made use of properly
}}

11oct

Look::Is it a bug ? -> we use $loss= $decay * $time elapsed, decay is for user. but if that user transforms, the decay should stay the same !
	-> the momental decay should be stored in the fruit/product table.

threshold swap activated, still need to check for bugs & drastic changes
>the filters can always check for THR. It could be a good choice since after that we'd not need special THR check for buyProduct types

::
//Need feedback to notify god that thee LE increased investor bought at bid price

10 oct 
added a common vals table - all users request to fetch data from a table. And to update that table, the same requests are used using prev_time & refreshRate
3 rows with category,sysLE,upperthr,lowerthr. (<- this is easier (no if conditions in THR check functinos))
OR Single row with sysLE, thresholdF.thresholdFI,thresholdGI,

FRONT END DOS 

Done Todo:: Now you have extracted 6 files to connect to backend, work upon them
Just list the correspondence here & work on it later-
	Done - home_god = master (sysLE graph,redeemLife will lie here, most ajax calls go from here)
	Done - investment_portal =  Funding Bar data of each product being funded
	Done - product_creator = createProduct & self Products which are launched
	Done - 	funding_list = makeInvestment & 
			Land_menu = showLand 
	Done - listInvestments = Investors own shares' stats
	Done - bazar_investor = listFruits & buyFruit

KIM Common Pages - 
farmer_stats god_stats investor_stats => Only Have  different styles (bg image)
home home_investor home_god => exact same (user it is)

::IMP Tip - If you avoid using foreach in front end, and send stuff thru arrays, you get lot more Flexiblity in modifying the representation
->like Fruits table in buyFruit page
->instead of return View::make with objects(larger data), process it into an array & send limited info.

Done>> Ajax to refresh lands in farmer land

8Oct
->Done- ::land object shall be created after added from purchases(like seed & fert) to here // currently made directly at time of purchase

Done >(threshold handle) sysLE being requested by all users per second, it MUST be accessed from a table that updates only if prev_time is a second less. else it returns the table value. 
	 >That table can also contain the varying decay %

::added avl_units in fruit 
::CLARIFICATION2 : num_units of fruits varies initially thru Fetchfruit, but after launch it stays constant
::made a table fruitbills to store fruit purchases.

Good snip: return Redirect::back();

	
7Oct

Done: >Now do investor : buy fruit (storage le interface too)

Clarification :le will increase in FetchFruit! (TODO- visually show how much LE increased -pass in ajax array)


::KNOWN BUG
Do later -
currently we are updating locally from the land. this way it is giving correct initial GTs.
But theres one more variable needed.
the Fert can be applied from X minutes of planted_at. The GT should now 
should not be :  seedGT / ( 1 + quals)
it should be prev_GT
ELse
We shall keep a RGT column which gets divided on fert apply. and thats what gets updated & checked everytime.
-but it wil require a prev_time just like user->le. => Do it that way then


::confirmed quality_factor from fruit table is like quality of the product
::Moved GT to land table. Made it more flexible & easy for calc
::Removed planted_at from fruit
i.e. Growing thing is now separated for Land



2Oct 
:: The GT itself shall be calculated by actual GT of fruit & the factor of fert !
 	>else we'd not be able to combine unlaunched fruits

1Oct
::As GT is calculated for a fruit only when it is 'planted' on a land, the planted_at is more convinient in Land table.

::Land Menu requires-
	Purchase table, Lands table, Fruits table
	>Purchase is used to give no of seeds in inventory.
	>Lands contains individual objects for each block
	>Fruits is the products table

> Things will happen serially-
	Fruit Obj will be created AT THE TIME OF PURCHASE, with num_units=0; & seed_id as pch_id

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



> is LE check done thru filters ?? YUP >> ITS THE BEST WAY  (just check thru ajax if it updates _/ yup)!

Done -  modular functions in admin
*/

/*
* 30 sep updates >6:37pm showLand isn't properly working, will do it soon
* 27 sep updates >Some aliases in app.php are cool !

* 25 Sep updates 
:: IC makeInvestment - flag was redundant, removed & tested
:: renamed num_units to avl_units in Products table

CAUTION * The created_at wherever used might change after $p->save() like bid_price. (though default not null saves it)
CAUTION * Filtering about being funded is done in the routes
UPDATE * $p->being_funded= -1 stands for deleted
TEMP* 'fruitBP'=>500,  //later this wil be a factor from seeds price

*/
/**
** No need to maintain seed, make a fruit on buying product-cat seed (eqv to migrating all columns of fruit into seed)

CLARIFICATIONS - 
//Got - 
    function purchased_land() {
//purchases whose id is same as land_id in fruit .
    	return $this->belongsTo('Purchase','land_id','id');  Fruits land_id, purchases id
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
*/
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

	if($p->avl_shares)$p->being_funded=0;		         <-- Whats correct place to update this?



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

  // $k=C::get('game.catTables');	 $le = $k[$active_cat]::where('user_id',$id)->first()->le;


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


$pchs=Purchase::all();
$user=Auth::user()->get();
foreach ($pchs as $p) {
if($p->product->category=="seed"){
	$f=new Fruit();
	$f->seed_id=$p->id;
	$f->num_units = 10;//$pch->num_units; //ZERO AS WE WILL ADD IT TO THE TABLE ONLY ON CLICKING (fetchFruit)
	$f->launched = 0; //on launchFruit also, a new Fruit will be created with launched=1
	$f->farmer_id = 1;
	$f->save();
	echo "New fruit $f->id created. <BR>";
}

}
**/

