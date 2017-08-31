<?php


class FC extends \BaseController {

//for Test
	public function checkGT($land_id){
		$l=Land::findOrFail($land_id);
		echo "land $l->id Seed $l->seed_id Fert $l->fert_id ";
		if($l->seed_id<0)
			echo "Unused<BR>";
		else {
			echo (	$GT= $this->getRGT($l))."<BR>";
		}
	}
	
	public function calcStorageLE($fruit){
		$maxQual=C::get('game.maxQual');
		$storage_fac=C::get('game.storage_fac');
//add complexity here.
		return $fruit->unit_price * (1 + $storage_fac*$fruit->seed->product->quality/$maxQual);
	}

	public function calcSellPrice($fruit){
		$sellC1=C::get('game.sellC1');
		$sellC2=C::get('game.sellC2');
		
		return $fruit->storage_le * ($sellC1*$fruit->quality_factor + $sellC2*$fruit->ET) ;
	}
	
	public function getUnitPrice($input){
		$quality=$input['quality_factor'];
		$GT=1;
		$ET=$input['ET'];
		$Tol=$input['Tol'];
		$c1=C::get('game.fruitC1');
		$c2=C::get('game.fruitC2');
		$c3=C::get('game.fruitC3');
		$c4=C::get('game.fruitC4');
		$bp=C::get('game.fruitBP');
		return $bp*($c1*$quality+$c2*$GT+$c3*$ET)*(1+$c4*$Tol);
	}

	

	//work on UI of this later
	public function launchFruit(){
		$input=Input::all();
		$f0=Fruit::find($input['storage_id']); //Fruit::where('seed_id',$l->seed_id)->where('launched',0)->first(); 
		$num_units = $f0->num_units; //to be transferred
		if($f0->launched != 0 || $num_units==0)
			return C::get('debug.dontFool');
		$f0->num_units=0; $f0->save(); //empty currently fetched fruits (This might be destructive ?!)
		
		$fruit = new Fruit();
		$fruit->seed_id = 			$f0->seed_id;
		$fruit->launched=1;
		$fruit->launched_at=time();
		$fruit->num_units=$num_units;		//this will vary after Investors buy the fruit.
		
		$fruit->avl_units=$num_units;		//confirm all go0d here
		
		$fruit->name = 				$input['name'];
		$fruit->description =		$input['description'];
		$fruit->quality_factor =	$input['quality_factor'];
		$fruit->ET =	 			$input['ET'];
		$fruit->unit_price = $this->getUnitPrice($input); 												  $fruit->save();
		$fruit->storage_le = $this->calcStorageLE($fruit); 												  $fruit->save();
		
		$fruit->sell_price =   $this->calcSellPrice($fruit); 	$fruit->save();

		echo "Success. newly Launched Fruit is fruit $fruit->name$fruit->id: with storage $fruit->storage_le<BR>";
	}


//another ajax on click
	public function fetchFruit(){
		$user= Auth::user()->get();		 
		$message="";
		$message.="Current LE = ".$user->le."<BR>"; 

		$land_id=Input::get('land_id');
		$l=Land::find($land_id);
		
		//these errors shall not be texts
		if(!$l)
			return "$land_id <BR><BR>";
		if($l->seed_id < 0 )
			return "no seed here !";
		
		//check fetchable
		if( $this->getRGT($l) < 0 ){
			$fruit  = Fruit::where('seed_id',$l->seed_id)->where('launched',0)->first(); 
  			//above fruit must exist as created when bought seeds -> if not, then FRUIT TABLE NOT CORRECT

			//Now we added it to "storage" (a fruit with launched = 0)
			$fruit->num_units++ ;
			$fruit->save();
			//RESET seed_id & fert_id = -1 , reset GT

			$l->seed_id=-1; $l->fert_id=-1; $l->GT=C::get('game.maxGT'); $l->save(); 

			$message.='Fruit added to storage, land is now unused. ';
			
			//recheck here
			$increase=C::get('game.fruitReturns') * $fruit->seed->product->quality;
			$user->le += $increase ; $user->save();

			$message.= "Now LE = ".$user->le."<BR>";
			return array('message' => $message);
		}
		else return array('message' =>C::get('debug.dontFool')); 
	}

//currently form, later can be ajax

	public function  applyPurch(){
		$input=Input::all();
		$sel_lands=$input['land_ids'];
		$purchase_id=$input['purchase_id'];

	$pch=Purchase::find($purchase_id); //can be a fert or a seed.
	if(!$pch->avl_units)return "0 avl units";
	$avl_units=$pch->avl_units;
	$num_lands= count($sel_lands);

//num_units is initialized by num_lands & is capped by avl_units. 
	//it is the final number of selected lands. Which should be maximal 
	// 8 June : num_units be changed if fert on already fert land (see below)
	$num_units=$num_lands;
	if($num_units>$avl_units){
		$num_units=$avl_units;
		echo "selecting less units = $num_units";
	}

//purches units are reduced at the end of this function

	if($pch->product->category=="land") {
		$user=Auth::user()->get();
		$fid=$user->farmer->id;
		$pid=$pch->id;

			//add available num of rows
		for($i=0;$i<$num_units;$i++){
			$land=new Land();
			$land->farmer_id=$fid;
			$land->purchase_id=$pid;
			$land->seed_id=-1;
			$land->fert_id=-1;
				// $land->planted_at=0;
			$land->save();
		}
		;
	}
	
	else if($pch->product->category=="seed") {

//Done- : here filter only those lands where seed not applied previously
		foreach ($sel_lands as $i=>$id) {
			$l=Land::find($id);
			if($l->seed_id>0){
				array_splice($sel_lands, $i,1);
				$num_lands--; //this will fit in below.
			}
		}
		//select first num_units lands
			if($num_lands > $num_units){ //effectively numunits is avl_units
				array_splice($sel_lands, $num_units);
			}

		//state change happens here.
			foreach ($sel_lands as $id) {
				//FOR EACH (SPLICED)SELECTED LANDS, DO THIS-
				$l=Land::find($id);
				$l->seed_id=$pch->id;		//update seed_id of sel land
				$l->save(); //This will affect the farmer's visuals of land
				
				//action - set new GT, set planted_at
				$l->GT=$this->getGT($l); $l->planted_at=time(); $l->save();

				//A bug here > 
				//Fruit was created since seed, Should not be null, should be unique
				$f= Fruit::where('seed_id',$l->seed_id)->where('launched',0)->first();
				$f->num_units++; 			// INCREMENT FRUIT NUM HERE WHOSE LAUNCHED=0
				$f->save();

			}

		}
		
		else if($pch->product->category=="fertilizer") {

//here filter only those lands where fert not applied previously
			foreach ($sel_lands as $i=>$id) {
				$l=Land::find($id);
				if($l->fert_id>0){
					array_splice($sel_lands, $i,1);

				$num_lands--; //this will fit in below.
				$num_units--; //added 8 June
			}
		}

		$maxFertSeeds= C::get('game.maxFertSeeds');
		if($num_lands > $maxFertSeeds){
			//break
			array_splice($sel_lands, $maxFertSeeds);
		}

		foreach ($sel_lands as $id) {
				//FOR EACH (SPLICED)SELECTED LANDS, DO THIS-
			$l=Land::find($id);
				$l->fert_id=$pch->id;		//update seed_id of sel land
				$l->save(); //This will affect the farmer's visuals of land

				
				//TODO - This shall count in the plant_time as well as 'fert_time'
				//action - set the new GT
				$l->GT=$this->getGT($l);$l->save(); 
			}
		}

		$pch->avl_units -= $num_units; 		 $pch->save();
		return View::make('goback');
	}


//this will be used only when planting seed. later, only RGT will be updated separately
	public function getGT($l){
		if($l->seed_id < 0 )return C::get('game.maxGT');
		$lq=$l->purchase->product->quality;
		$sq=$l->seed->product->quality;
		if($l->fert_id < 0)$fq=1; else $fq=$l->fertilizer->product->quality;

//pass seed's quality, fert's quality, land's quality.
	if($lq*$sq*$fq==0)return C::get('game.maxGT');//this will never make it fruit

	$lq *= C::get('game.landQual');
	$sq *= C::get('game.seedQual');
	$fq *= C::get('game.fertQual');

	$GT= C::get('game.seedGT') / (1 + $sq*$fq*$lq);

	$l->GT=$GT; $l->save();

	return $GT; 
}

//for AJax (thru getStates)
public function getRGT($l){
	return $this->getGT($l) - (time()-$l->planted_at)/60;	//-ve if fruit.
}

//here comes the ajax
public function getStates(){
	$user= Auth::user()->get(); 
	$L = $user->farmer->lands;
	$states= array();
	$RGTs= array();
	$landIDs= array();
	foreach ($L as $l){
			$RGT=C::get('game.maxGT'); //check default btw
			$fert=($l->fert_id>-1)?1:0; //fert there
			
			$seed=0;
			if($l->seed_id>-1) {
				$RGT=$this->getRGT($l);
  				$seed=1; //seed there
  				if($RGT  < 0 )$seed=2; //or fruit there.
  			}
  			
  			array_push($states,$this->calcState($seed,$fert));
  			array_push($landIDs,$l->id);
  			array_push($RGTs,$RGT);
  		}
  		return array('states'=>$states,'RGTs'=>$RGTs,'landIDs'=>$landIDs);

  	}


// $stateText=['Unused','Seed ','Fert Only &nbsp','Fert & Seed'];
  	public function calcState($s,$f){
  		$state=0;
if($s==1 && $f==1)$state=3; // brown - Fert & Seed
if($s==0 && $f==1)$state=2; //Orange - Fert only 
if($s==1 && $f==0)$state=1; // Green - Seed
if($s==0 && $f==0)$state=0; // unused
if($s==2 )$state=4; // Fruit
return $state;
}


public function showLand(){
	$user= Auth::user()->get(); 
	$farmer=$user->farmer;
	$L = $farmer->lands;
	$purchases = $farmer->purchases; //->where('product is seed or fert') //not req
	$fruits=	 $farmer->fruits;
	//Convert following into return array('key'=>'val'); to be handled by ajax
	//this shall be obtained from ajax since land updates with time

	// foreach ($L as $l)$this->checkGT($l->id);

	return View::make('showLand')
	->with(C::get('game.fruitCIs'))
	->with('purchases',$purchases)
	->with('fruits',$fruits)
	->with('seedGT',C::get('game.seedGT'))
	->with('fruitBP',C::get('game.fruitBP'));
}



public function QueryPractice(){

		//Helper functions- Func is alias for config/classes/Functions.php
		// echo Func::add('a');

	$f2=Farmer::find(1);

	echo $f2->user->username." is having following property<BR><BR>";
	echo "<BR>Lands<BR>";
	foreach ($f2->lands as $l => $f) {
		echo $l." ".$f."<BR><BR>";
		echo $f->purchase."<_seed <BR><BR>";
	}
	echo "<BR>Fruits<BR>";

	foreach ($f2->fruits as $l => $f) {
		echo $l." ".$f."<BR><BR>";
	}

	echo "<BR>Purchases<BR>";
	foreach ($f2->purchases as $l => $f) {
		echo $l." ".$f."<BR><BR>";
	}
	return;


	print_r($f2->purchase->product->god->products
		()->select('category','avl_units')->lists('category')
			// ()->where('category','land')->select('category','avl_units')->lists('category')
			// ()->where('category','land')->get(['category','avl_units'])
	// ->filter(function($item){return $item->category=='land';})->values()->lists('avl_units')
		);

// echo ($f2->purchases->filter(function($item){return $item->product->category=='seed';}));//->values());
	echo "<BR>";
	echo "<BR>";

	$k=$f2->fruits()->select('quality_factor','id');
	$k2=$f2->purchases;
	foreach ($k2 as $iterator_key => $kp) {
		$k3=$kp->fruits();
		print_r($k3->lists('id'));
		echo "<BR>$iterator_key<BR>";
	}
	echo "<BR>";
	echo "<BR>";
	print_r($k->lists('id'));
}
public function testFruitRel(){
	// return "lets check if fruit relates to its farmer";


	$f=Fruit::find(2);
	return $this->QueryPractice();

	$f=Farmer::find(15);
	foreach ($f->purchases as $p) {
		$v=$p->farmer->user->username;
		$v2=$p->product->category;

			$v3=$p->purchases;//->where('farmer_id',1);
			var_dump($v3);
			echo "$v $v2 $v3";
			echo "<br>";
		}
		echo "<br>";
		foreach ($f->fruits as $product) {
			echo " Id :";
			echo $product->id;
			echo " Farmer :";
			echo $product->farmer->user->username; 
			echo " name:";
			echo $product->name; //currently Null
			echo " ET:";
			echo $product->ET; //currently Null
			echo " GT:";
			echo $product->GT; //currently Null
			echo " quality:";
			echo $product->quality; //currently Null
			echo " in_progress:";
			echo $product->in_progress; //currently Null
			echo " description :";
			echo $product->category; //currently Null
			echo "<br>";

		}
	}


	/** buy product here -***/
	
	public function productPriceHandle(){
		$id=(int)Input::get('product_id');
		$p = Product::find($id);
		if(!$p || $p->being_funded!=0)
			return array('buy_price'=>0,'RET'=>0);;
		return $this->calcBuyPrice($p);
	}


//ajax on this too
	public function calcBuyPrice($p){
		$removeResp = array('buy_price'=>-1,'RET'=>-1);
		if(!($p->ET>0 && $p->total_cost>0))//Invalid product
		{
			Log::info('Invalid Prod, Debug em');
			Log::info($p);

			return $removeResp;
		}

		$RET = Game::getRET($p) ;
		if($RET<=0){
             //expiry time is over now : Game:: will take care of expiring it.          Done<-- What's correct place to update this?
			return $removeResp;
		}
		$time_elapsed= (time()-(int)$p->launched_at)/60; //Minutes
		
		$loss=  $p->god->decay * $p->ET;
		$num=$p->total_cost/$p->unit_price;
		$godRecovery=C::get('game.godRecovery');
		$buy_price= $p->unit_price + $godRecovery*($loss)/($num)*($time_elapsed)/($p->ET);
        // echo "Buy price = ".$buy_price."<BR>";
        // return  $buy_price;
		return array('buy_price'=>$buy_price,'RET'=>$RET);

	}
	public function buyProduct(){
		$user=Auth::user()->get();
		
		return View::make('buyProduct')
		->with('boughtProducts',$user->farmer->products)
		->with('products',
			Product::where('being_funded',0)->where('avl_units','>',0)
			->orderBy('id','desc')
			->get());
	}

	public function postbuyProduct(){
			//request comes here from listProducts-
		echo "lets go. ";
		$flag =0;
		$input = Input::except('_token');
		if(!($input['num_units'] && $input['product_id']))
			return "Input not read.";
		$num_units = (int)($input['num_units']);

		$user = Auth::user()->get();
		$LE=$user->le; echo "Current LE = ".$LE."<BR>";

//maybe put this into a function
		$p=Product::find($input['product_id']);
		if(!$p)							return "prod not found";
		if(!$p->being_funded==0)		return "(being_funded!=0 : $p->being_funded)Product is not being sold. <BR>";
		if(!$p->avl_units){
			$p->being_funded= -1;$p->save(); 
			return "0 avl units";
			//expired. place to update this?
		}
		// Shouldn't happen :  if(!$p->god)					return "This product doesn't have an owner!"; //
		$god=$p->god; //accessed to increase god LE
		$d=$this->calcBuyPrice($p);// RFT positive check here. 
		$buy_price= $d['buy_price'];
		if($buy_price==0)				return "buy_price is 0 => ET/total_cost problem!";
		if($p->avl_units < $num_units){ 
			echo " Buying available units(".$p->avl_units.")"; 
			$num_units=$p->avl_units;
		}
		$price=$num_units* $buy_price;
		$thr = Game::thresholdsFor($user->category);
		//Life Energy price check /successful here.
		if($LE - $price > $thr['lowerTHR']){
		// product's avl shares cut
			$p->avl_units -= $num_units; 						$p->save();
		//Farmer's le cut
			$user->le -= $price;									$user->save();


			$total_shares = $p->total_shares;

		#Distribute acc to shares among investors & gods
			$total_investments = Investment::where('product_id',$p->id)->sum('num_shares');
			
			$remPercent = ( 1-C::get('game.godPercent') )*(1- $total_investments/ $total_shares);

			$god->user->le += (C::get('game.godPercent')+$remPercent) * $price;		$god->save();$god->user->save();
			// Update 30Aug :  God shud get for more than 51% shares that were left after FT
			
			$investors= $p->investors;
			foreach ($investors as $inv) {

				$invms=	Investment::where('investor_id',$inv->id)->where('product_id',$p->id)->get();
				$inv_num_shares=0;
				foreach ($invms as $i) {
					$inv_num_shares += $i->num_shares;
					$percentage = $i->num_shares/$total_shares;
					$i->amt_ret += $percentage*$price;
				}
				
				// Investment::where('investor_id',$inv->id)->sum('amt_ret');

			// $inv_num_shares = $inv->pivot->num_shares; //We've not CLUbbed them, so discard this
				$inv_total_perc = $inv_num_shares/$total_shares;
				$inv->user->le += $inv_total_perc * $price;						$inv->save();$inv->user->save();

			}
			$p->save();


		//Notes this in purchases table
			$pch = new Purchase();
			$pch->farmer_id = $user->farmer->id;
			$pch->product_id = $p->id;
			$pch->num_units = $num_units;

			$pch->avl_units = $num_units; //This is for storing Quantity of Land/Seed/Fert // added on 8Oct, should have been since long!

			$pch->buy_price = $buy_price;// $prod_price; //should be $buy_price !
			$pch->save();



			$cat=$p->category;

			if($cat == 'seed' ){
				$f=new Fruit();
				$f->seed_id = $pch->id;
			$f->num_units = 0;//$pch->num_units; //ZERO AS WE WILL ADD IT TO THE TABLE ONLY ON CLICKING (fetchFruit)
			$f->launched = 0; //on launchFruit also, a new Fruit will be created with launched=1
			$f->farmer_id = $user->farmer->id;
			//GT moved to land !
				// $f->GT = C::get('game.seedGT') / $p->quality; //seed GT shall later also depend on its sub-type
					//quality_factor moved to FRUIT ! ->user input
			$f->save();
			echo "New fruit $f->id created. <BR>";
		}
			// else if($cat == 'fertilizer' ){
			// 	$s=new Fertilizer();
			// 	$s->product_id = $p->id;
			// 	$s->save();
			// }
			// else if($cat == 'land' ){
			// 	$l=new Land();
			// 	$l->farmer_id = $user->farmer->id;
			// 	$l->purchase_id = $pch->id;
			// 	$l->save();
			// }


		echo $pch->id." Success. Now LE = ".$user->le;
		$args = $pch;
		Event::fire('bought_product',$args);

	}

	else 								echo " Insufficient LE : $LE - $price < $THR, decrease no of units ";
	
	return C::get('debug.goBack');
}


}
	/**
	Now notify God & Investor that they got profits from a purchase.
	You can update this in purchase DB which will be sent to them.
	//following will be in GC & IC.
	for god = god->products->purchases
	for inv = foreach (investors->products->purchase) // inform multi investors
	**/
