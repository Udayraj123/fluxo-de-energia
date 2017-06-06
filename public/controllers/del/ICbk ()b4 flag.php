		<?php
		class IC extends \BaseController {

		//list of products(being funded) by all gods-
		//make Array of this later
			public function godProducts(){
				$user=Auth::user()->get();
				if(!$user)return "Please log in again.";
				if($user->category!='investor')return "You are not Investor!";
				$gods= God::all();
				foreach ($gods as $god) {
					echo " God : ".$god->user->username."<br>";
		$products = $god->products->all(); // $products = Product::where('being_funded',1)->where('god_id',$god->id);// var_dump($products);
		foreach ($products as $product) {
			if($product->being_funded == 1){
				echo $product->id;
				echo " -> ";
		echo $product->name; //currently Null
		echo "<br>";
	}
}
echo "<br>";
}
}

public function testFilter(){
	$user=Auth::user()->get();
	echo $user->category;
}


public function buyFruit(){
		//IMPLEMENT THIS AFTER createFruit by farmer
}


public function check($input){
		//Life Energy price check
		// RFT positive check
		// avl_shares check
		//investor id,bid_price, set at backend

		$user= Auth::user()->get();  //THIS CHECK MAYBE NOT REQ.//Get user again in case someone goes back and resends form data-
		// if($user->investor){ 

		$investor=$user->investor;

		if(!($input['num_shares']&& $input['product_id']))return false;

		$p=Product::find($input['product_id']); //other way is to reach thru saved $i
		if(!$p){echo "prod not found";return false;}
		if(!$p->being_funded){echo "Product is not being funded. <BR>";return false;}

		$god=$p->god; //accessed to increase god LE
		$ctime=time();
		// $time_passed = ($ctime - $p->time_when_created)/60;//
		$time_passed = (strtotime($p->created_at)-$ctime)/60;

		//show RFT also
		$RFT = $p->FT - $time_passed; //Minutes
		echo "RFT ".$p->FT." - ".$time_passed." = ".$RFT."<BR>";

		if($RFT<=0){ //THIS SHOULD NOT COME
			echo "RFT is over. ".$p->FT." - ".$ctime." = ".$RFT."<BR>";

			return false;
		}


		if($p->avl_shares < (int)$input['num_shares']){ echo "Insufficient shares. Available shares(".$p->avl_shares.")"; return false;}
		else {
			$p->avl_shares -= (int)($input['num_shares']);						$p->save();
			$num_shares = (int)($input['num_shares']);
			$price= $num_shares * (int)($p->bid_price);


			//REAL TIME THR 
		$total=Config::get('game.sysLE'); //CHECK IF THIS WORKS ALL TIME
		$facFI = Config::get('game.facFI');

		$LE=$investor->le;
		$THR= $facFI* $total; //this factor may depend on number of users ?!

		if($LE - $price > $THR)
		{
			$investor->le -= $price;				$investor->save();
		//GIVE BACK decay LE to God
			$excess_bid = $p->bid_price - $p->unit_price;
			$godReturns = Config::get('game.godReturns');
			$god->le += $godReturns*$num_shares*$excess_bid; 					$god->save();
			return true;
		}
		else {echo $THR." >  ".$LE."-".$price." - > Insufficient LE. ";return false;}
	}
		// }
		// else echo "Don't play fool with me !"; //Should not reach here . 
}


		//BID PRICE -> return LE part to god
public function makeInvestment(){
		//from POST request by Investor
	$input = Input::except('_token');
	$user= Auth::user()->get();
		//investor id,bid_price, set at backend

	if($user->category=='investor'){


		$investor=$user->investor;
		echo "Current LE = ".$investor->le."<BR>";

		if($this->check($input)){ //THIS WILL ALREADY REDUCE LE, make sure the product gets Added
			$i=new Investment();
			$i->investor_id = $investor->id;
		$p=Product::find($input['product_id']); //other way is to reach thru saved $i
		$i->bid_price = $p->bid_price;
		foreach(array_keys($input) as $field){
			echo $field." -> ".$input[$field];
		$i->$field=$input[$field]; 				// if(property_exists($p,$field))
		if($i->$field)echo " added.";echo "<br>";			
	}
	$i->save();	

	echo "Success. Now LE = ".$investor->le;
}
else echo "<BR>Transaction failed. ";
}



else echo " Not Investor. Don't play fool with me !";

} 

public function makeInvestmentForm(){
	if(!Auth::user()->get())return Config::get('debug.login');
		// if($user->category=='investor'){
	return View::make('invest');
		// }
		// else return "You are not Investor! -".$user->username;
} 


}	

