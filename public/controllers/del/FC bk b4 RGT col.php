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



	public function launchFruit(){
	//check
		$fruit = new Fruit;
		if($fid)$fruit->fertilizer_id=$fid;
		$fruit->name = $input['name'];
		$fruit->description = $input['description'];
		$fruit->purchase_id = $input['purchase_id'];
		$fruit->quality_factor = $input['quality_factor'];
		$fruit->ET = $input['ET'];
			$fruit->in_progress = 1; //means not ripe
			$fruit->plant_time = time();
			$fruit->save();

			$fruit_product = $fruit->purchase->product;
			$c1=Config::get('game.fruitC1');
			$c2=Config::get('game.fruitC2');

		$fruit->sell_price = $fruit->storage_le * ($c1*$fruit->quality_factor + $c2*$fruit->ET) ; //calculate the unit_price of fruit.

		$fertilizer = Purchase::find($fruit->fertilizer_id);
		$fruit->storage_le = $fruit->unit_price * $fruit_product->quality;
		$fruit->growth_factor = 0;

		if($fertilizer){
			$fruit->growth_factor = $fertilizer->product->quality;
			$fertilizer->num_units--;
			$fertilizer->save();
		}
		$fruit->growth_factor +=  $land->product->quality; //why add ?
		$fruit->save();
		
		$land = Purchase::find($fruit->land_id);
		$land->num_units--;
		$land->save();

		$pchseed->num_units--;
		$pchseed->save();

	}


//another ajax on click
	public function fetchFruit(){
		$land_id=Input::get('land_id');
		$l=Land::find($land_id);
		if(!$l){echo "$land_id <BR><BR>";return;}
		if($l->seed_id < 0 )return "no seed here !";
		//check fetchable
		if( $this->getRGT($l) < 0 ){
  			$fruit  = Fruit::where('seed_id',$l->seed_id)->where('launched',0)->first(); 
  			//above fruit must exist as created when bought seeds

			//Now we added it to "storage" (a fruit with launched = 0)
  			$fruit->num_units++ ;
  			$fruit->save();
			//RESET seed_id & fert_id = -1 , reset GT

  			$l->seed_id=-1; $l->fert_id=-1; $l->GT=Config::get('game.maxGT'); $l->save(); 

  			return array('message' => 'Fruit added to storage, land is now unused');
  		}
  		else return array('message' =>Config::get('debug.dontFool')); 
  	}

  	public function plantLand(){
  		$input=Input::all();
  		$sel_lands=$input['land_ids'];
  		$purchase_id=$input['purchase_id'];
  		var_dump($sel_lands);
  		return "under dvlpment";
  	} 


//currently form, later can be ajax

  	public function    applyPurch(){
  		$input=Input::all();
  		$sel_lands=$input['land_ids'];
  		$purchase_id=$input['purchase_id'];

	$pch=Purchase::find($purchase_id); //can be a fert or a seed.
	if(!$pch->avl_units)return "0 avl units";
	$avl_units=$pch->avl_units;
	$num_lands= count($sel_lands);


	$num_units=$num_lands;
	if($num_units>$avl_units){
		$num_units=$avl_units;
		echo "selecting less units = $num_units";
	}

	if($pch->product->category=="seed") {

//TODO : here filter only those lands where seed not applied previously


//CHECK IF NUM OF LANDS SELECTED IS LESS THAN Num_units<=AVL_UNITS OF SEED.
			if($num_lands > $num_units){ //effectively numunits is avl_units
				//select first num_units lands
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

				//Should not be null, should be unique
				$f= Fruit::where('seed_id',$l->seed_id)->where('launched',0)->first();//->get(); //this can be first() if bugs
				$f->num_units++; 			// INCREMENT FRUIT NUM HERE WHOSE LAUNCHED=0
				$f->save();

			}

			$pch->avl_units -= $num_units;  $pch->save();
		}
		
		if($pch->product->category=="fertilizer") {

//here filter only those lands where fert not applied previously

			$maxFertSeeds= Config::get('game.maxFertSeeds');
			if($num_lands > $maxFertSeeds){
				array_splice($sel_lands, $maxFertSeeds);
			}

			foreach ($sel_lands as $id) {
				//FOR EACH (SPLICED)SELECTED LANDS, DO THIS-
				$l=Land::find($id);
				$l->fert_id=$pch->id;		//update seed_id of sel land
				$l->save(); //This will affect the farmer's visuals of land

				//action - set the new GT
				$l->GT=$this->getGT($l);$l->save(); 
			}
			$pch->avl_units -= $num_units; 		 $pch->save();
		}

	}



	public function getGT($l){
		
		$lq=$l->purchase->product->quality;
		$sq=$l->seed->product->quality;
		if($l->fert_id < 0)$fq=1; else $fq=$l->fertilizer->product->quality;

//pass seed's quality, fert's quality, land's quality.
	if($l->seed_id < 0 || $lq*$sq*$fq==0)return Config::get('game.maxGT');//this will never make it fruit

	$lq *= Config::get('game.landQual');
	$sq *= Config::get('game.seedQual');
	$fq *= Config::get('game.fertQual');

	$GT= Config::get('game.seedGT') / (1 + $sq*$fq*$lq);

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
			$RGT=Config::get('game.maxGT'); //check default btw
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


//The land menu 'View' goes from here-
public function showLand(){
	$user= Auth::user()->get(); 
	$farmer=$user->farmer;
	$L = $farmer->lands;
		$purchases = $farmer->purchases; //->where('product is seed or fert') //not req
		$fruits=	 $farmer->fruits;
	//Convert following into return array('key'=>'val'); to be handled by ajax
	//this shall be obtained from ajax since land updates with time

			//test for comparing
		foreach ($farmer->fruits as $l)echo " fruit $l->id ($l->num_units)";
		echo "<BR>";
		foreach ($L as $l)$this->checkGT($l->id);

		return View::make('showLand')
		->with('purchases',$purchases)
		->with('fruits',$fruits)
		->with('c1',Config::get('game.fruitC1'))
		->with('c2',Config::get('game.fruitC2'))
		->with('c3',Config::get('game.fruitC3'))
		->with('c4',Config::get('game.fruitC4'))
		->with('seedGT',Config::get('game.seedGT'))
		->with('fruitBP',Config::get('game.fruitBP'));
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

	public function calcBuyPrice($p){
		if(!($p->ET>0 && $p->total_cost>0))return 0;
		$time_elapsed= (time()-($p->launched_at))/60; //Minutes
	  	$RET = $p->ET - $time_elapsed; //Minutes
	  	if($RET<=0){
	  		echo "$RET = $p->ET - ($time_elapsed= (time()-($p->launched_at))/60<BR>";
            $p->being_funded= -1; $p->save(); //expiry time is over now          <-- What's correct place to update this?
            return 0;
        }
        $loss=  $p->god->decay * $p->ET;
        $num=$p->total_cost/$p->unit_price;
        $godRecovery=Config::get('game.godRecovery');
        $buy_price= $p->unit_price + $godRecovery*($loss)/($num)*($time_elapsed)/($p->ET);
        echo "Buy price = ".$buy_price."<BR>";
        return  $buy_price;
    }

    public function buyProduct(){
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
    		$p->being_funded=-1;$p->save(); return "0 avl units";
			//expired. place to update this?
    	}
		if(!$p->god)					return "This product doesn't have an owner!"; //

		$god=$p->god; //accessed to increase god LE

		$buy_price= $this->calcBuyPrice($p);// RFT positive check here. 
		if($buy_price==0)				return "buy_price is 0 => ET/total_cost problem!";
		if($p->avl_units < $num_units){ 
			echo " Buying available units(".$p->avl_units.")"; 
			$num_units=$p->avl_units;
		}
		$price=$num_units* $buy_price;
		$total=Config::get('game.sysLE'); //CHECK IF THIS WORKS ALL TIME
		$THR= $total * Config::get('game.facF'); //this factor may depend on number of users ?!
		

		//Life Energy price check /successful here.
		if($LE - $price > $THR) {
		// product's avl shares cut
			$p->avl_units -= $num_units; 						$p->save();
		//Farmer's le cut
			$user->le -= $price;									$user->save();

		#Distribute acc to shares among investors & gods
			$god->user->le += Config::get('game.godPercent') * $price;		$god->save();$god->user->save();
			$total_shares = $p->total_shares;
			
			$investors= $p->investors;
			foreach ($investors as $inv) {
				$invms=	Investment::where('investor_id',$inv->id)->where('product_id',$p->id)->get();
				$num_shares=0;

				foreach ($invms as $i) {
					$num_shares += $i->num_shares;
				}
				
			// $num_shares = $inv->pivot->num_shares; //We've not CLUbbed them, so discard this
				$percentage = $num_shares/$total_shares;
				$inv->user->le+= $percentage * $price;						$inv->save();$inv->user->save();
			}
			$p->save();


		//Notes this in purchases table
			$pch = new Purchase();
			$pch->farmer_id = $user->farmer->id;
			$pch->product_id = $p->id;
			$pch->num_units = $num_units;
		$pch->buy_price = $buy_price;// $prod_price; //should be $buy_price !
		$pch->save();



		$cat=$p->category;

		if($cat == 'seed' ){
			$f=new Fruit();
			$f->purchase_id = $pch->id;
			$f->num_units = 0;//$pch->num_units; //ZERO AS WE WILL ADD IT TO THE TABLE ONLY ON CLICKING (fetchFruit)
			$f->launched = 0; //on launchFruit also, a new Fruit will be created with launched=1
			$f->farmer_id = $user->farmer->id;
				$f->GT = Config::get('game.seedGT') / $p->quality; //seed GT shall later also depend on its sub-type
					//quality_factor moved to FRUIT ! ->user input
				$f->save();
			}
			// else if($cat == 'fertilizer' ){
			// 	$s=new Fertilizer();
			// 	$s->product_id = $p->id;
			// 	$s->save();
			// }
			else if($cat == 'land' ){
				$l=new Land();
				$l->farmer_id = $user->farmer->id;
				$l->purchase_id = $pch->id;
				$l->save();
			}


			echo $pch->id." Success. Now LE = ".$user->le;


		}

		else 								return " Insufficient LE : $LE - $price < $THR ";

	}


}
	/**
	Now notify God & Investor that they got profits from a purchase.
	You can update this in purchase DB which will be sent to them.
	//following will be in GC & IC.
	for god = god->products->purchases
	for inv = foreach (investors->products->purchase) // inform multi investors
	**/