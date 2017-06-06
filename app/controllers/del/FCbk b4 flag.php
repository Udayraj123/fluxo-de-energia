	<?php
	

	class FC extends \BaseController {
		
		public function testFruitRel(){

			$f=Farmer::find(1);
			$fs=$f->fruits;
			foreach ($fs as $product) {
				echo $product->id;
				echo " name:";
				echo $product->name; //currently Null
				echo $product->farmer->user->username; //currently Null
				echo " ET:";
				echo $product->ET; //currently Null
				echo " GT:";
				echo $product->GT; //currently Null
				echo " quality_factor:";
				echo $product->quality_factor; //currently Null
				echo " in_progress:";
				echo $product->in_progress; //currently Null
				echo " description :";
				echo $product->category; //currently Null
				echo "<br>";
			}
	// return "lets check if fruit relates to its farmer";
		}

		public function showLand(){
			$user= Auth::user()->get(); 
			$farmer=$user->farmer;
			$total_land=16;
			$used_land=6;
			$ripe_land=$total_land-$used_land-7;
	$purchases = $farmer->purchases; //->where('product is seed or fert') //not req
	$fruits=$farmer->fruits;
	return View::make('showLand')
	->with('total_land',$total_land)
	->with('used_land',$used_land)
	->with('ripe_land',$ripe_land)
	->with('purchases',$purchases)
	->with('fruits',$fruits);
}

		//ajax request giving land selected, seed selected & fertilizer if any selected.
		//later check if this fert belongs to that farmer's purchase only & if is not used up.
public function plantSeed(){
	$fruit = new Fruit;
	$fruit->purchase_id = Input::get('purchase_id');
	$fruit->land_id = Input::get('land_id');
	$fruit->fertilizer_id = Input::get('fertilizer_id');
	$fruit->quality_factor = Input::get('quality_factor');
	$fruit->ET = Input::get('ET');
	$fruit->save();

	$seed = Purchase::find($fruit->purchase_id);
	if(!$seed)
		return "Error in seeds";

	$fruit->in_progress = 1;
	$fruit->fruit_time = time();
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

		$seed->num_units--;
		$seed->save();
	}





	/** buy product here -***/


	public function calcBuyPrice($p){
		if(!($p->ET>0 && $p->total_cost>0))return 0;
		$time_elapsed= (time()-($p->launched_at))/60; //Minutes
	  	$RET = $p->ET - $time_elapsed; //Minutes
	  	if($RET<=0){
            //DELETE PRODUCT HERE !
            $p->being_funded=-1; $p->save(); //expiry time is over now          <-- What's correct place to update this?
            return 0;
        }
        $loss=  $p->god->decay * $p->ET;
        $num=$p->total_cost/$p->unit_price;
        $godRecovery=C::get('game.godRecovery');
        $buy_price=$p->unit_price + $godRecovery*($loss)/($num)*($time_elapsed)/($p->ET);
        echo "Buy price = ".$buy_price." Num= ".$input['num_units']."<BR>";
        return  $buy_price;
    }

    public function check($input){
    	$user= Auth::user()->get(); 

    	$farmer=$user->farmer;

    	if(!($input['num_units']&& $input['product_id']))return false;

			// RET positive check
	$p=Product::find($input['product_id']); //other way is to reach thru saved $i
	if(!$p){echo "prod not found";return false;}
	if($p->being_funded!=0){ //bfunded either 1 or -1
		echo "Product is not being sold. <BR>";return false;}


		$timepassed=(time()-$p->launched_at)/60;
		Log::info($p->launched_at);
		$RET = $p->ET-$timepassed; //Minutes
		if($RET<=0){ 
			echo "RET is over. ".$p->ET." - ".$timepassed." = ".$RET."<BR>";
			return false;
		}

//CHECK
		if($p->num_units < (int)$input['num_units']){ 
			//UPDATE THIS ACC TO MAKE INVESTMENT
			echo "Insufficient Products. Available products(".$p->num_units.")"; return false;
		}
		else {
			$p->num_units -= (int)($input['num_units']); 				$p->save();
			$god = $p->god;
			$buy_price= $this->calcBuyPrice($p);

			$price= (int)($input['num_units'])* $buy_price;

							//REAL TIME THR <- repeated use. 
				$total=C::get('game.sysLE'); //CHECK IF THIS WORKS ALL TIME
				$facFI = C::get('game.facFI');

				$LE=$farmer->user->le;
			$THR= $facFI* $total; //this factor may depend on number of users ?!

			if($LE - $price > $THR)
			{
				$farmer->user->le -= $price;
				$farmer->save();
				$farmer->user->save();
				return true;
			}
			else {echo $THR." >  ".$LE."-".$price." - > Insufficient LE. ";return false;}
		}
	}

	public function buyProduct(){
			//request comes here from listProducts-
		echo "lets go. ";
		$input = Input::all();
		$user = Auth::user()->get();

			$farmer = $user->farmer; // opens farmer cat of user, ADD CONDITION ABOVE
			echo "Current LE = ".$farmer->user->le."<BR>";


			if($this->check($input)){ //THIS WILL ALREADY REDUCE LE, make sure the product gets Added

				$prod=Product::find($input['product_id']);
				$god = $prod->god;
				$num = $input['num_units'];
				$buy_price = $this->calcBuyPrice($prod,$god,$input);
				$prod_price	=$num * $buy_price;


			//Notes this in purchases table
				$newPurchase = new Purchase();
				$newPurchase->farmer_id = $farmer->id;
				$newPurchase->product_id = $prod->id;
				$newPurchase->num_units = $num;
				$newPurchase->buy_price = $buy_price;// $prod_price; //should be $buy_price !
				$newPurchase->save();

				$farmer->user->le -= $prod_price;						$farmer->save();$farmer->user->save();
				$prod->num_units -= $num; 									$prod->save();

			#Distribute the earnings among investors & gods
				$total_shares = $prod->total_shares;
				$investors= $prod->investors;
				foreach ($investors as $inv) {

					$num_shares = $inv->pivot->num_shares; //beware - same investor & same product can have multi investments
					//The above needs to be replaced with a loop on $investor->products()->where('id',product_id)

					$percentage = $num_shares/$total_shares;
					$inv->user->le+= $percentage * $prod_price;						$inv->save();$inv->user->save();
				}

				$god->user->le += C::get('game.godPercent') * $prod_price;		$god->save();$god->user->save();

				echo "Success. Now LE = ".$farmer->user->le;
			}
			else echo "<BR>Transaction failed. ";
		}


	}
	/**
	Now notify God & Investor that they got profits from a purchase.
	You can update this in purchase DB which will be sent to them.
	//following will be in GC & IC.
	for god = god->products->purchases
	for inv = foreach (investors->products->purchase) // inform multi investors
	**/
