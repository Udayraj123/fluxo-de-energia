<?php


class FC extends \BaseController {


	//for Test
	public function checkGT($land_id){
		$l=Land::findOrFail($land_id);
		if(!$l){echo "$land_id <BR><BR>";return;}
		$time=time();
		echo "land $l->id ";
		if($l->seed_id<0)
			echo "Unused<BR>";
		else {
			$q=$l->purchase->product->quality;
			if($q==0)return "Unexpected Zero Quality fruit cannot grow ";
			$GT= C::get('game.seedGT') / $q;
			echo "RGT = $GT-($time - $l->planted_at)/60  = ".($GT-($time - $l->planted_at)/60)."<BR>";
		}
	}

	//for AJax
//input : id of single block. we can get its planted time & GT hence RGT.
//we return that RGT
//clean or fert-only lands will have seed_id = -1 , for these, return GT = C::get('game.maxGT');
//so return GT only for planted_seeds i.e. seed_id >0

	public function checkRGT($q,$planted_at){
	if($q==0)return C::get('game.maxGT');//this will never make it fruit
	$GT= C::get('game.seedGT') / $q;
	$RGT=($GT-(time() - $planted_at)/60); 
	return $RGT; //-ve if fruit.
}

//here comes the ajax
public function getStates(){
	$user= Auth::user()->get(); 
	$L = $user->farmer->lands;
	$states= array();
	$RGTs= array();
	$landIDs= array();
	foreach ($L as $l){
			$seed=0;
			$RGT=C::get('game.maxGT'); //check default btw
  			$fert=0; //clean lands
  			if($l->seed_id>-1)$seed=1; //seed there
			 else if(($RGT=$this->checkRGT($l->purchase->product->quality,$l->planted_at)) < 0 )$seed=2; //or fruit there
  			if($l->fert_id>-1)$fert=1; //fert there

  			array_push($states,$this->calcState($seed,$fert));
  			array_push($landIDs,$l->id);
  			array_push($RGTs,$RGT);

  		}
  		return array('states'=>$states,'RGTs'=>$RGTs,'landIDs'=>$landIDs);

  	}


// $stateText=['Unused','Seed ','Fert Only &nbsp','Fert & Seed'];
  	public function calcState($s,$f){
  		$state=0;
if($s==1 && $f)$state=3; // brown - Fert & Seed
if($s==0 && $f)$state=2; //Orange - Fert only 
if($s==1 && !$f)$state=1; // Green - Seed
if($s==0 && !$f)$state=0; // unused
if($s==2 )$state=4; // Fruit
return $state;
}

public function showLand(){
	$user= Auth::user()->get(); 
	$farmer=$user->farmer;

	$L =		 $farmer->lands;
	$purchases = $farmer->purchases; //->where('product is seed or fert') //not req
	$fruits=	 $farmer->fruits;
//Convert following into return array('key'=>'val'); to be handled by ajax
	//this shall be obtained from ajax since land updates with time

//can do a check here for GT, for now.
	foreach ($L as $l) {
		$this->checkGT($l->id);
	}
	

  		return View::make('showLand')
  		->with('purchases',$purchases)
  		->with('fruits',$fruits)
  		->with('c1',C::get('game.fruitC1'))
  		->with('c2',C::get('game.fruitC2'))
  		->with('c3',C::get('game.fruitC3'))
  		->with('c4',C::get('game.fruitC4'))
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


	public function plantFert(){
		$input=Input::all();
		$sel_lands=$input['land_ids'];
		var_dump($sel_lands);
		
		return "under dvlpment";
	}



	public function plantLand(){
		$input=Input::all();
		var_dump($input);
		
		return "under dvlpment";
	}
	public function plantSeed(){
		// $s->GT = $input['quality']*C::get('game.seedGT'); //seed GT shall later also depend on its sub-type
	//input : (unused)land selected, seed selected & fertilizer if any selected.
	//later check if this fert belongs to that farmer's purchase only & if is not used up.
		$input=Input::all();
		if(array_key_exists('fertilizer_id',$input))
			$fid = $input['fertilizer_id'];
		if(!array_key_exists('purchase_id',$input)) return "No purchase";
		$pch=Purchase::find($input['purchase_id']);
		if($pch->product->category=="seed")
		{
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
		}

//why exactly 
		$pchseed = Purchase::find($fruit->purchase_id);
		if(!$pchseed)
			return "Error in pchseeds";

//check
		$fruit_product = $fruit->purchase->product;
		$c1=C::get('game.fruitC1');
		$c2=C::get('game.fruitC2');

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
        $godRecovery=C::get('game.godRecovery');
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
		$total=C::get('game.sysLE'); //CHECK IF THIS WORKS ALL TIME
		$THR= $total * C::get('game.facF'); //this factor may depend on number of users ?!
		

		//Life Energy price check /successful here.
		if($LE - $price > $THR) {
		// product's avl shares cut
			$p->avl_units -= $num_units; 						$p->save();
		//Farmer's le cut
			$user->le -= $price;									$user->save();

		#Distribute acc to shares among investors & gods
			$god->user->le += C::get('game.godPercent') * $price;		$god->save();$god->user->save();
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
