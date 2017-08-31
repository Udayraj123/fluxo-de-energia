<?php
class IC extends \BaseController {
//redeem LE will be accessible anywhere i.e. UC.php
	//---------------------------------------------------------------


	public function getInvDetail(){
		$user=Auth::user()->get();
		//log::info($user);
		$inv = $user->investor;
		// $inv=DB::table('investors')->where('user_id',$user->id)->first();
		$is=$inv->investments;
		$inv_table=[];
		$m=0;
		foreach ($is as $i){
			$m = (int)($i->bid_price) * (int)( $i->num_shares);
			
			$currInv=[];
			$currInv['pid']=$i->product_id;
			$currInv['pname']=$i->product->name;
			$currInv['pcategory']=$i->product->category;
			$currInv['gname']=$i->product->god->user->username;
			$currInv['invested']=$m;
			$currInv['returned']=$i->amt_ret;
			array_push($inv_table, $currInv);
		}
		
		return $inv_table ;

	}

	//---------------------------------------------------------------

	/* buy Fruit here */
	public function calcFruitPrice	($p){ //$p is fruit here
		if(!($p->ET>0 && $p->avl_units>0))return 0; //division by zero
		$time_elapsed= (time()-($p->launched_at))/60; //Minutes
	  	$RET = $p->ET - $time_elapsed; //Minutes
	  	if($RET<=0){
            $p->launched= -1; $p->save(); //expiry time is over now          <-- What's correct place to update this?
            return 0;
        }
        $loss=  $p->farmer->decay * $p->ET;
        
        $num= $p->avl_units;//$p->total_cost/$p->unit_price;
        $farmerRecovery=C::get('game.farmerRecovery');
        $buy_price= $p->unit_price + $farmerRecovery*($loss)/($num)*($time_elapsed)/($p->ET);
        return  $buy_price;
    }


//ajax like bidHandle for fruit price 
    public function priceHandle(){
    	$id=(int)Input::get('fruit_id');
    	$p = Fruit::find($id);
    	if(!$p || $p->launched!=1 || !$p->farmer)return array('buy_price'=>0,'RET'=>0);
    	$buy_price= $this->calcFruitPrice($p);
    	
    	$RET = Game::getRET($p);
    	return array('buy_price'=>$buy_price,'RET'=>$RET);
    }

    public function postBuyFruit(){
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
		$total=Game::sysLE(); 
		$THR= $total * C::get('game.facFI'); //this factor may depend on number of users ?!
		
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
		$RFT = Game::getRFT($p);
		if($RFT<=0){
	  		//Nope - Launching is in control of god?
	  		// Launch automatically to be fair.
			Game::launchProd($p);
			return 0;
		}

		$loss=  $p->god->decay * $p->FT;
		$base_share=($p->total_cost/$p->total_shares)*(1-C::get('game.godPercent'));
		$godReturns = C::get('game.godReturns');
		$time_elapsed= (time()-strtotime($p->created_at))/60; //Minutes
		$bid_price= $base_share + $godReturns*($loss/$p->total_shares)*($time_elapsed/$p->FT);

		$p->bid_price=$bid_price; $p->save(); //update bid price here ?!

		return  $bid_price;
	}

	public function bidHandle(){
		$id=(int)Input::get('product_id');
		$p = Product::find($id);
		if(!$p || $p->being_funded!=1)return array('bid_price'=>0,'RFT'=>0);;
		$bid_price= $this->calcBidPrice($p);
		$RFT = Game::getRFT($p);
		return array('bid_price'=>$bid_price,'RFT'=>$RFT,'avl_shares'=>$p->avl_shares);
	}
	public function buyFruit(){
		$user=Auth::user()->get();
		return View::make('buyFruit')
		->with('boughtFruits',$user->investor->fruits)
		->with('fruits',Fruit::where('launched',1)->where('avl_units','>',0) 
			->orderBy('id','desc') ->get());

	}
	public function listInvestments(){
		$user=Auth::user()->get(); 
		return View::make('listInvestments') ->with('products',$user->investor->products);

	}
	public function makeInvestment(){
		$products=Product::where('being_funded',1) 
		->where('avl_shares','>',0) 
		->orderBy('id','desc') ->get();
		return View::make('makeInvestment') 
		->with('products',$products);
	}
		//from POST request by Investor
	public function postmakeInvestment(){
		$input = Input::except('_token');
		if(!(array_key_exists('num_shares', $input) && array_key_exists('product_id', $input))) return "Input not read.";
		
		$num_shares = (int)($input['num_shares']);
		$user= Auth::user()->get();
		$LE=$user->le; echo "Current LE = ".$LE."<BR>";
		$p=Product::find($input['product_id']);

		if(!$p)return "prod not found";
		if($p->being_funded==0)								return "(FT is over) Product is not being funded. <BR>";  

		if(!$p->avl_shares){
			//Over funding is not currently supported. 
			Game::launchProd($p);
			return "0 avl shares";
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

		// $thrData=(UC::thresholdHandle());
		// $THR=$thrData['lowerTHR'];
		
		//SUM LE is costly, if it is slowing down, use UC::thresholdHandle
		$total=Game::sysLE(); 
		$THR= $total * C::get('game.facFI'); //this factor may depend on number of users ?!
		 //Life Energy price check /successful here.
		if($LE - $price > $THR)
		{
		// product's avl shares cut
			$p->avl_shares -=  $num_shares; 				
		//Investor's le cut
			$user->le -= $price;									$user->save();
		//GIVE BACK decay LE to God
			$base_share=($p->total_cost/$p->total_shares)*(1-C::get('game.godPercent'));
			$excess_bid = $bid_price - $base_share; //changed to base_share from unit_price
			
//Need feedback to notify god that thee LE increased investor bought at bid price
			$god->user->le += $num_shares*$excess_bid; 					$god->user->save();$god->save();
			
			$p->save();
			$i=new Investment();
			$i->investor_id = $user->investor->id;
			$i->product_id = $p->id;
			$i->amt_ret = 0;
			$i->num_shares = $num_shares;
			$i->bid_price = $p->bid_price; //to be removed, but still need to show some other way
			$i->save();	
			echo $i->id." Success. Now LE = ".$user->le;

		}
		else 												return " Insufficient LE : ".$THR." >  ".$LE."-".$price;

	} 


}	

