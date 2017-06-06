<?php

class AmoghController extends \BaseController {
	
	//call this function in master function that handles decay_LE ajax request of farmer
//NOT UPDATE WITH CHANGES-
	public function growthCheck($user){
		
		$purchases = $user->farmer->purchases;
		foreach ($purchases as $purchase) {
			if($purchase->product->category == 'seed'){
				$plants = Fruit::where('purchase_id',$purchase->id)->where('in_progress',1)->get();
				foreach ($plants as $plant) {
					$time_elapsed = time() - $plant->plant_time;
					$purchased_seed = Purchase::find($plant->purchase_id); 
					$expiry = $purchased_seed->product->seed->GT;					
					if(($time_elapsed) * $plant->growth_factor >= $expiry)
						$this->makeFruit($plant);
				}
			}
		}
	}

	/*****THese may not be required here, since we are updating them thru calcBidPrice / calcSellPrice etc**/

	//ajax of farmer
	public function fruitExpiry($user){
		$purchases = $user->farmer->purchases;
		foreach ($purchases as $purchase) {
			if($purchase->product->category == 'seed'){
				$fruits = Fruit::where('purchase_id',$purchase->id)->where('in_progress',0)->get();
				foreach ($fruits as $fruit){
					$expiry = $fruit->ET;
					$time_elapsed = time() - $fruit->ripe_time;
					if($time_elapsed >= $expiry*60)
						$fruit->delete();
				}
			}
		}
	}

	//ajax of god
	public function fundingCheck($user){
		$products = $user->god->products()->where('being_funded',1)->get();
		foreach ($products as $product) {			
			$expiry = $product->FT;
			$time_elapsed = time() - strtotime($product->created_at);
			if($time_elapsed >= $expiry*60){
				$product->being_funded = 0;
				if($product->investments)$shares_bought = $product->investments->sum('num_shares');
				else Log::info("NO investments");
				$product->num_units = ($product->num_units * $shares_bought) / $product->total_shares;
				$product->save();
			}
		}
	}

	//ajax of god
	public function productExpiry($user){
		$products = $user->god->products()->where('being_funded',0)->get();
		foreach ($products as $product) {			
			$expiry = $product->ET;
			$time_elapsed = time() -  $product->launched_at;
			if($time_elapsed >= $expiry*60){
				$category = $product->category;
				$specific = $product->{$category}->delete();
				$product->delete();
			}
		}
	}

	public function plantSeed(){
		$plant = new Fruit;
		$plant->purchase_id = Input::get('seed');
		$plant->land_id = Input::get('land')
		$plant->fertilizer_id = Input::get('fertilizer');
		$plant->quality_factor = Input::get('quality');
		$plant->ET = Input::get('et');
		$plant->in_progress = 1;
		$plant->plant_time = time();
		$plant_product = $plant->purchased_seed->product;
		$plant->unit_price = dosomething(quality,et); //calculate the unit_price
		$plant->storage_le = $plant->unit_price * $plant_product->quality;
		$plant->growth_factor = $plant->purchased_fertilizer->product->quality + $plant->purchased_land->product->quality;
		$plant->save();
		$land = $plant->purchased_land;
		$land->num_units--;
		$land->save();
		$seed = $plant->purchased_seed;
		$seed->num_units--;
		$seed->save();
		$fertilizer = $plant->purchased_fertilizer;
		$fertilizer->num_units--;
		$fertilizer->save();
	}

	public function makeFruit($plant){
		$land = $fruit->purchased_land;
		$land->num_units++;
		$land->save();
		$fruit = $plant;
		$fruit->ripe_time = time();
		$fruit->in_progress = 0;
		$fruit->save();
	}

	public function buyFruit(){
		$fruit = Fruit::find(Input::get('fruit'));
		if(Auth::user()->get()->category != 'investor')
			return "Not authorised";
		$investor = Auth::user()->get()->investor;
		$sp = dosomething()  //find the selling price
		$investor->le -= $sp;
		$investor->stored_le += $fruit->stored_le;
		$farmer = $fruit->purchased_seed->farmer;
		$farmer->le += $sp;
		$investor->save();
		$farmer->save();
		$fruit->delete();
 	}

 	public function redeemLife(){
 		if(Auth::user()->get()->category != 'investor')
			return "Not authorised";
 		$investor = Auth::user()->get()->investor;
 		$redeem = Input::get('redeem');
 		if($redeem > $investor->storage_le)
 			return "Insufficient supply of Life Energy";
 		$investor->le += $redeem;
 		$investor->storage_le -= $redeem;
 		$investor->save();
 	}

}