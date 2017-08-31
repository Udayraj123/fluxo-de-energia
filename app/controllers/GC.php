<?php


class GC extends \BaseController {
	//****TODO   UPDATE THE ONES BELOW DOWN, ANALOGUS TO makeInvestment Check ****//

	public function test(){
		$user=Auth::user()->get();
		echo "User: $user->category - $user->username<BR>"; 
		

	}
	public function fundingBar(){

		$user=Auth::user()->get();
		$ps = Product::where('god_id',$user->god->id); //user->god_id isn't working ?!
		$fundingBarFields=['id', 'category', 'name', 'total_shares', 'avl_shares', 'FT', ];
		
		$funding_products = $ps->where('being_funded',1)->select($fundingBarFields)->get();
		$prev_products = $ps->where('being_funded',0)->select($fundingBarFields)->get();
		
//seems heavy-2
		$Info="Funding Details Here...";
		foreach ($funding_products as $i=>$prod){
			$Percentages=[];
			$InvestorNames=[];
			foreach ($prod->investors as $inv)
			{
				$num_shares=	Investment::where('investor_id',$inv->id)
				->where('product_id',$prod->id)
				->sum('num_shares');
				$total_shares=$prod->total_shares;
				$Percentages[] = $num_shares/$total_shares*100;
				$InvestorNames[] = Helper::getShortName($inv->user->username);
			}
			$funding_products[$i]['InvestorNames']=$InvestorNames;
			$funding_products[$i]['Percentages']=$Percentages;
			$funding_products[$i]['Info']=$Info;
		}
		$funding_products = $funding_products?		$funding_products->toArray()	:	[];
		$prev_products	  =    $prev_products?		$prev_products->toArray()		:	[];
		log::info($funding_products);
		return View::make('fundingBar')->with([
			'funding_products'=>$funding_products,
			'prev_products'=>$prev_products
			]);
	}
//More to come- sale stats
	public function selfProducts(){
		$user=Auth::user()->get();
		echo "User: God - $user->username<BR>"; 
		$products = $user->god->products->reverse();
		foreach ($products as $product) {
			echo $product->id;
			echo " name:";
				echo $product->name; //currently Null

				if($product->being_funded == 1){

					echo " ET:";
				echo $product->ET; //currently Null
				echo " FT:";
				echo $product->FT; //currently Null
				echo " avl_units:";
				echo $product->avl_units; //currently Null
				echo " quality:";
				echo $product->quality; //currently Null
				echo " total_cost:";
				echo $product->total_cost; //currently Null
				echo " being_funded:";
				echo $product->being_funded; //currently Null
				echo " description :";
				echo $product->description; //currently Null
				echo " category:";
				echo $product->category; //currently Null
				echo "<br>";


				echo "Total ".$product->total_shares." ";
				echo "Avl ".$product->avl_shares." ";
				$allinv=$product->investments()->orderBy('investor_id')->get();
				foreach($allinv as $invm){
					$invt= $invm->investor;
					if(!$invt->user){echo "nope "; continue;}
					echo $invt->user->username;
					echo "(";
					echo $invm->num_shares;
					echo " ";
					echo $invm->num_shares * $invm->bid_price;
					echo ")  ";
				}

				echo "<br>";
				echo "<br> purchases- ";
				$allpurch=$product->purchases()->orderBy('farmer_id')->get();
				foreach($allpurch as $purch){
					$farmer= $purch->farmer;
					if(!$farmer->user){echo "nope "; continue;}
					echo $farmer->user->username;
					echo "(num ";
					echo $purch->num_units;
					echo " cost : ";
					echo $purch->num_units * $purch->buy_price;
					echo " > ";
					echo $purch->avl_units;
					echo ")  ";	
				}
				echo "--<BR><BR>";
			}

			else {
				echo " &emsp; Funding over For the product, show sell stats using purchases here.<br>";
			}

		}
	}
	public function transactionCheck($user,$input){
		//FT ET positive check
		//$input['avl_units']

		if(!(array_key_exists('avl_units', $input)&&$input['category']&& $input['unit_price'] && $input['FT']>0 && $input['ET']>0 ))
		{
			echo "avl_units/category/unit_price/FT not ready";
			return false;
		}
		else {
			$category = $input['category'];
			if(!($category=="seed" ||$category=="fertilizer" ||$category=="land")){
				echo "Wrong category ";			return false;
			}
			$price= (int)($input['avl_units'])*(int)($input['unit_price']);
			$LE=$user->le;
			$thr = Game::thresholdsFor($user->category);
		//Life Energy price check
			return ($LE - $price > $thr['lowerTHR']);
		}
	}


	public function getBasePrice($quality,$FT,$ET,$Tol,$type){
	# quality, product_type, ini_sysLE
		$c=Config::get('game.baseCIs');
		$bps=Config::get('game.basePrices');
		$bp=$bps[$type];
		return $bp*($c['c1']*$quality + $c['c2']*$FT + $c['c3']*$ET)*(1 + $c['c4']*$Tol);
	}

	public function createProduct(){
		$user=Auth::user()->get();

		return View::make('createProd')
		->with(C::get('game.baseCIs'))
		->with('products',$user->god->products()->orderBy('id','desc')->get());
	}
	public function postCreateProduct(){
		//from POST submit request by God
		$input = Input::except('_token','Tol'); //,'unit_price' too ! but it is disabled
		//THOUGH it might get vulnerable if they send unit_price as input in request
		$user= Auth::user()->get();		 
		echo "Current LE = ".$user->le."<BR>";

		//Nope - THIS WILL ALREADY REDUCE GOD'S LE, make sure the product gets Added/
		if( $this->transactionCheck($user,$input) ){ 
			$p = new Product();
			$p->god_id = $user->god->id;
			$p->being_funded=1;
		// $p->create_time=time(); -> this might be used later.
			foreach(array_keys($input) as $field){
			$p->$field=Game::e($input[$field]); 				// if(property_exists($p,$field))
			echo $field." :".$input[$field];
			if($p->$field)echo " added.";echo "<br>";			
		}
		$unitPrice = $this->getBasePrice($p->quality,$p->FT,$p->ET,Input::get('Tol'),$p->category);
		$p->unit_price = $unitPrice;
		echo "Re: unit_price:".$unitPrice."<BR>";
		$p->total_cost = $unitPrice * $p->avl_units;
		$p->avl_shares = $p->total_shares;

		$p->bid_price = (1-C::get('game.godPercent'))*$p->total_cost/$p->total_shares;
		$p->save();
		$user->le -= $p->total_cost;
		$user->save();
		$p->save();
		$msg = ($p->created_at.' : '.$p->name.'is created in category of '.$p->category .' of quality '.$p->quality.' , the funding time for the product is '.$p->FT.' minutes and its expiry time is '.$p->ET.' minutes. The available quantity is '.$p->total_shares.' each prices at '.$p->unit_price.'. This Product is  created by '.$user->username.'. <br>'.'God says about his product :'.$p->description);

		Event::fire('all_news',$msg);
		echo "Now LE = ".$user->le."<BR>";
	}
	else return "Transaction Failed.";
} 

}


/*
 

//no need of below code now
	// 	$cat=$input['category'];
	// 	if($cat == 'seed' ){
	// 		$s=new Seed();
	// 		$s->product_id = $p->id;
	// 		$s->GT = $input['quality']*C::get('game.seedGT'); //seed GT shall later also depend on its sub-type
	// 	//quality_factor moved to FRUIT ! ->user input
	// 	$s->save();
	// }
	// else if($cat == 'fertilizer' ){
	// 	$s=new Fertilizer();
	// 	$s->product_id = $p->id;
	// 	$s->save();
	// }
	// else if($cat == 'land' ){
	// 	$s=new Land();
	// 	$s->product_id = $p->id;
	// 	$s->save();
	// }
	*/