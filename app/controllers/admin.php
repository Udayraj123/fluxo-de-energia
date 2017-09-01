\<?php
class admin extends \BaseController {
//CALL THIS FUNCTION EVERY 30MIN OR SO => To avoid Stucks
//MOVE THE FUNCTION BELOW TO SQL functions in Workbench
	

	function checkID(){
		echo "Life Origin overwired, task run";
		return 1;//for Debugs
		$user=Auth::user()->get();
		if($user && $user->id == 42){
			echo "Life Origin confirmed, task run";
			return 1;
		}
		else {
			echo "<a href='/login/42'> Login</a>";return 0;
		}
	}

	public function boostLE(){
		if(!$this->checkID())return;
		$boostG=1.2;
		$boostI=1.5;
		$boostF=1.8;
		$users=User::all();
		foreach ($users as $u) {
			$u->le *= $boostG;
			$u->save();
			echo $u->le." ";
		}

	}

	public function updateUsers(){
		//occur no LE loss. Run before letting them join in.
		if(!$this->checkID())return;
		$users=User::all();
		$t=time();
		foreach ($users as $u) {
			$u->prev_time =$t;
			$u->save();
		}
	}


	public function plantSeedLands(){
		if(!$this->checkID())return;
		$lands=Land::all();
		$t=time();
		foreach ($lands as $l) {
			if($l->seed_id>0){
				$l->planted_at =$t; $l->save();
			}
		}
	}
	

	public function resetUsers(){
		if(!$this->checkID())return;
		$users=User::all();
		$t=time();
		$ini=C::get('game.iniLE');
		$ng=C::get('game.numGods');
		$ni=$ng+C::get('game.numInvs');
		$landPrice = C::get('game.basePrices')['land'];
		$stored_LE=C::get('game.stored_LE');
		$models = ['Farmer','God','Investor'];

		foreach ($users as $c=> $u) {
			if($c <$ng)$u->category='god';
			else if($c <=$ni)$u->category='investor';
			else $u->category='farmer';

			foreach ($models as $m) {
				if($m::where('user_id',$u->id)->count()==0){
					echo ".";
					$f=new $m();
					$f->user_id=$u->id;
					$f->save();
				}
			}

			//----------------------------------------------------------------
			$u->prev_LE_time=time();
			//----------------------------------------------------------------
			$u->prev_time =$t;
			$u->le=$ini[$u->category];
			$u->stored_LE=$stored_LE[$u->category];
			$u->is_moderator=0;
			$u->save();
		}

		//Outside For Loop
		$mg=C::get('game.modGs');
		$mi=C::get('game.modIs');
		$mf=C::get('game.modFs');
		User::where('category','god')->take($mg)->update(['is_moderator'=>1]);
		User::where('category','investor')->take($mi)->update(['is_moderator'=>1]);
		User::where('category','farmer')->take($mf)->update(['is_moderator'=>1]);

		$gid = User::where('is_moderator',1)->where('category','god')->first()->god->id;
		$default_land = Product::where('god_id',$gid)->where('avl_units','>',60)->where('category','land')->first();
		if(!$default_land){
			DB::table('products')->insert([
				'god_id'=> $gid,
				'category'=>'land','description'=>'created by moderator',
				'being_funded'=> -1, 'launched_at'=>time(),
				'total_shares'=>50, 'avl_shares'=>0,
				'quality'=>50,
				'total_cost'=>100*$landPrice,
				'unit_price'=>$landPrice,
				'avl_units'=>100,
				'ET'=>5,'FT'=>5,
				]);
		}
		$default_land = Product::where('god_id',$gid)->where('avl_units','>',60)->where('category','land')->first();	
		$default_land->description='moderated';
		$default_land->save();

		foreach ($users as $c=> $u) {
// // Pasted from FC.php 30 Aug
			$num_units = 1;
			$buy_price = 0;
			$pch = Purchase::where('farmer_id',$u->farmer->id)->where('product_id',$default_land->id)->first();
			if(!$pch){
				$pch = new Purchase();
				$pch->farmer_id = $u->farmer->id;
				$pch->product_id = $default_land->id;
				$pch->num_units = $num_units;
				$pch->avl_units = $num_units;
				$pch->buy_price = $buy_price;
				$pch->save();
			}
			$land= Land::where('farmer_id',$u->farmer->id)->where('purchase_id',$pch->id)->first();
			if(!$land){
				$land=new Land();
				$land->farmer_id=$u->farmer->id;
				$land->purchase_id=$pch->id;
				// $land->planted_at=0;
			}
			//plain
			$land->seed_id=-1;
			$land->fert_id=-1;
			$land->save();
		}
	}

	public function resetProducts($launch=0){
		if(!$this->checkID())return;
		$ps=Product::all();
		$t=time();
		foreach ($ps as $p) {
			if($launch){
				$p->launched_at =$t;
				$p->being_funded=0;
			}
			else{
				$p->being_funded=1; $p->save(); //for updated_at
				$p->created_at=$p->updated_at; //this is not working correctly !
			}
			$p->ET = C::get('game.maxET');
			$p->FT = C::get('game.maxFT');
			$p->save();
		}
	}
	public function resetFruits(){
		if(!$this->checkID())return;
		$ps=Fruit::all();
		$t=time();
		foreach ($ps as $p) {
			if($p->launched==1 || $p->launched==-1)
				$p->launched=1;
			$p->launched_at =$t;
			$p->num_units=15;
			$p->avl_units=10;
			$p->save();
		}
	}

}