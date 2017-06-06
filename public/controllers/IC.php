<?php
class IC extends \BaseController {
//redeem LE will be accessible anywhere i.e. UC.php

		//make Array of this later
	public function godProducts(){
		echo "All products being funded :";
		$gods= God::all();
		foreach ($gods as $god) {
			echo " God : ".$god->user->username."<br>";
			$products = $god->products->all(); // $products = Product::where('being_funded',1)->where('god_id',$god->id);// var_dump($products);
			foreach ($products as $product) {
				if($product->being_funded == 1){
					echo $product->id;
					echo " name:";
					echo $product->name; 
					echo " ET:";
					echo $product->ET; 
					echo " FT:";
					echo $product->FT; 
					echo " avl_units:";
					echo $product->avl_units; 
					echo " num_shares:";
					echo $product->num_shares; 
					echo " quality:";
					echo $product->quality; 
					echo " total_cost:";
					echo $product->total_cost; 
					echo " being_funded:";
					echo $product->being_funded; 
					echo " description :";
					echo $product->description; 
					echo " category:";
					echo $product->category; 
					echo "<br>";
				}
			}
			echo "<br>";
		}
	}

	//playing with pivot
	public function testfn(){
		$inv = Auth::user()->get()->investor;
		if(!$inv){
			echo "User not yet investor! Choosing default. ";
			$inv = Investor::find(1);
		}
		$prod = $inv->products->first();

		$total_shares = $prod->total_shares;
		$prodname = $prod->category." ".$prod->id;
		echo $prodname." is first product invested by ".$inv->user->username;
		echo "<BR>Now lets get all investors who invested in this prod (same name can repeat if thee invested repeated)<BR>";
		$investors= $prod->investors;
		foreach ($investors as $inv) {
			$invname= $inv->user->username;
			echo "<BR><BR>".$invname." invested in ".$prodname." at  ";

			$num_shares = $inv->pivot->num_shares;
			$bid_price = $inv->pivot->bid_price;
			echo $num_shares." / ".$total_shares." -> ".$bid_price."<BR><BR>" ;

			echo "selfInvestments by ".$invname." are - <BR><BR>";
		$prods = $inv->products()->orderBy('id','asc')->get(); //where $inv = $prod->investors
		foreach ($prods as $p) {
			echo $p->category." ".$p->id." ----- ";
			$num_shares= $p->pivot->num_shares;
			$bid_price= $p->pivot->bid_price;
			echo $num_shares." shares at price ".$bid_price."<BR>";
		}			
		echo "<BR><BR>";

	}
}


/* buy Fruit here */

	public function calcFruitPrice($p){ //$p is fruit here
		if(!($p->ET>0 && $p->avl_units>0))return 0; //division by zero
		$time_elapsed= (time()-($p->launched_at))/60; //Minutes
	  	$RET = $p->ET - $time_elapsed; //Minutes
	  	if($RET<=0){
            $p->launched= -1; $p->save(); //expiry time is over now          <-- What's correct place to update this?
            return 0;
        }
        $loss=  $p->farmer->decay * $p->ET;
        
        $num= $p->avl_units;//$p->total_cost/$p->unit_price;
        $farmerRecovery=Config::get('game.farmerRecovery');
        $buy_price= $p->unit_price + $farmerRecovery*($loss)/($num)*($time_elapsed)/($p->ET);
        return  $buy_price;
    }


//ajax like for bidHandle
    public function priceHandle(){
    	$id=(int)Input::get('fruit_id');
    	$p = Fruit::find($id);
    	if(!$p || $p->launched!=1 || !$p->farmer)return array('buy_price'=>0,'RET'=>0);
    	$buy_price= $this->calcFruitPrice($p);
		//may change this created at to created_time later.
		$time_elapsed= (time()-($p->launched_at))/60; //Minutes
		$RET = $p->ET - $time_elapsed; //Minutes
		return array('buy_price'=>$buy_price,'RET'=>$RET);
	}

	public function buyFruit(){
			//request comes here from listProducts-
		echo "Bazar : lets go. ";
		$input = Input::except('_token');
		if(!($input['num_units'] && $input['fruit_id']))
			return "Input not read.";
		$num_units = (int)($input['num_units']);

		$user = Auth::user()->get();
		$LE=$user->le; echo "Current LE = ".$LE."<BR>";

//maybe put this into a function
		$p=Fruit::find($input['fruit_id']);
		if(!$p)							return "fruit not found";
		if(!$p->launched==1)		return "(launched!=1 : $p->launched)Fruit is not being sold. <BR>";
		if($p->avl_units<0){
			$p->launched=-1;$p->save(); return "0 avl units";
			//expired. place to update this?
		}
		if(!$p->farmer)					return "This fruit doesn't have an owner!"; //
		$farmer=$p->farmer; //accessed to increase f's LE
		$buy_price= $this->calcFruitPrice($p);// RFT positive check here. 
		if($buy_price==0)				return "buy_price is 0 => ET/RET/avl_units problem!";
		if($p->avl_units < $num_units){ 
			echo " Buying available units(".$p->avl_units.")"; 
			$num_units=$p->avl_units;
		}
		$price=$num_units* $buy_price;
		$total=Config::get('game.sysLE'); //CHECK IF THIS WORKS ALL TIME
		$THR= $total * Config::get('game.facF'); //this factor may depend on number of users ?!
		
		//Life Energy price check /successful here.
		if($LE - $price > $THR) {
		// fruit's avl units cut
			$p->avl_units -= $num_units; 						$p->save();
			$farmer->user->le += $price;									$farmer->user->save();
			$user->le -= $price;
			$user->stored_LE += $p->storage_le;			$user->save();
			$p->save();

		//Notes this in purchases table
			$pch = new Fruitbill(); //new model
			$pch->investor_id = $user->investor->id;
			$pch->fruit_id = $p->id;
			$pch->num_units = $num_units;
			$pch->avl_units = $num_units;
			$pch->buy_price = $buy_price;// $prod_price; //should be $buy_price !
			$pch->save();
			echo $pch->id." Success. Now LE = ".$user->le;
		}
		else 								return " Insufficient LE : $LE - $price < $THR ";
	}

	/*Make investment here */

	public function calcBidPrice($p){
		if(!($p->FT>0 && $p->total_shares>0))return 0;
		$time_elapsed= (time()-strtotime($p->created_at))/60; //Minutes
	  	$RFT = $p->FT - $time_elapsed; //Minutes
	  	if($RFT<=0){
            $p->being_funded=0; $p->save(); //time is over now          <-- What's correct place to update this?
            return 0;
        }

        $loss=  $p->god->decay * $p->FT;
        $base_share=($p->total_cost/$p->total_shares)*(1-Config::get('game.godPercent'));
        $godReturns = Config::get('game.godReturns');
        $bid_price= $base_share + $godReturns*($loss/$p->total_shares)*($time_elapsed/$p->FT);

		$p->bid_price=$bid_price; $p->save(); //update bid price here ?!

		return  $bid_price;
	}

	public function bidHandle(){
		$id=(int)Input::get('product_id');
		$p = Product::find($id);
		if(!$p || !$p->being_funded || !$p->god)return array('bid_price'=>0,'RFT'=>0);;
		$bid_price= $this->calcBidPrice($p);
		//may change this created at to created_time later.
		$time_elapsed= (time()-strtotime($p->created_at))/60; //Minutes
		$RFT = $p->FT - $time_elapsed; //Minutes
		return array('bid_price'=>$bid_price,'RFT'=>$RFT);
	}
		//from POST request by Investor
	public function makeInvestment(){
		$input = Input::except('_token');
		if(!(array_key_exists('num_shares', $input) && array_key_exists('product_id', $input))) return "Input not read.";
		
		$num_shares = (int)($input['num_shares']);
		$user= Auth::user()->get();
		$LE=$user->le; echo "Current LE = ".$LE."<BR>";
		$p=Product::find($input['product_id']);

		if(!$p)return "prod not found";
		if($p->being_funded==0)								return "(FT is over) Product is not being funded. <BR>";  

		if(!$p->avl_shares){$p->being_funded=0; $p->save(); return "0 avl shares";
		//shares are over now          <-- What's correct place to update this?
	}
		$god=$p->god; //accessed to increase god LE
		if(!$god)											return "This product doesn't have an owner!"; //you may safe delete this products
		
		// RFT positive check here. 
		$bid_price=$this->calcBidPrice($p); //this also updates to latest bid price & being_funded.
		if($bid_price==0)									return "Err in bid price (0)!";

		// avl_shares check
		if($p->avl_shares < $num_shares){ 
			echo " Buying available shares(".$p->avl_shares.")"; 
			$num_shares = $p->avl_shares;
		}
		
		echo " bid_price ".$bid_price;
		$price= $num_shares * $bid_price;

		$total=Config::get('game.sysLE'); //CHECK IF THIS WORKS ALL TIME
		$THR= $total * Config::get('game.facFI'); //this factor may depend on number of users ?!
		//Life Energy price check /successful here.
		if($LE - $price > $THR)
		{
		// product's avl shares cut
			$p->avl_shares -=  $num_shares; 				
		//Investor's le cut
			$user->le -= $price;									$user->save();
		//GIVE BACK decay LE to God
			$base_share=($p->total_cost/$p->total_shares)*(1-Config::get('game.godPercent'));
			$excess_bid = $bid_price - $base_share; //changed to base_share from unit_price
			$god->user->le += $num_shares*$excess_bid; 					$god->user->save();$god->save();
			
			$p->save();
//FLAG REMOVED

		//NOTODO ? -	
		 //HERE ADD A CONDITION IF $user->investor already has purchase of same prod id, 
			//if yes, simply increment its num_shares (no bid_price issue since its removed)
			$i=new Investment();
			$i->investor_id = $user->investor->id;
			$i->product_id = $p->id;
			$i->num_shares = $num_shares;
			$i->bid_price = $p->bid_price; //to be removed, but still need to show some other way
			$i->save();	
			echo $i->id." Success. Now LE = ".$user->le;

		}
		else 												return " Insufficient LE : ".$THR." >  ".$LE."-".$price;

	} 


}	

