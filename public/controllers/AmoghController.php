<?php

class AmoghController extends \BaseController {

	function testAMG(){
		$plant = new Fruit;
		$plant->purchase_id = 1;
		$plant->land_id = 2;
		$plant->fertilizer_id = 3;
		$plant->quality_factor = 10;
		$plant->save();

		print_r(Purchase::find($plant->land_id));
		print_r(Purchase::find($plant->fertilizer_id));
		print_r(Purchase::find($plant->product_id));
	}


//user filter
	public function GtoI($god){
		$investor = User::where('category','investor')->orderBy('le','desc')->first();
		if($investor->user->le >= $threshold_itog){
			$user_g = $god->user;
			$investor_new = $user_g->investor;
			if(!$investor_new){
				$investor_new = new Investor;
				$investor_new->save();
				$user_g->investor_id = Investor::orderBy('id','desc')->first()->id;
			}
			$user_g->category = 'investor';
			$user_g->save();

			$user_i = $investor->user;
			$god_new = $user_i->god;
			if(!$god_new){
				$god_new = new God;
				$god_new->save();
				$user_i->god_id = God::orderBy('id','desc')->first()->id;
			}
			$user_i->category = 'god';
			$user_i->save();
		}
	}

	public function ItoG($investor){
		$god = User::where('category','god')->orderBy('le')->first();
		if($god->user->le >= $threshold_itog){
			$user_i = $investor->user;
			$god_new = $user_i->god;
			if(!$god_new){
				$god_new = new God;
				$god_new->save();
				$user_i->god_id = God::orderBy('id','desc')->first()->id;
			}
			$user_i->category = 'god';
			$user_i->save();

			$user_g = $god->user;
			$investor_new = $user_g->god;
			if(!$investor_new){
				$investor_new = new God;
				$investor_new->save();
				$user_g->investor_id = Investor::orderBy('id','desc')->first()->id;
			}
			$user_g->category = 'god';
			$user_g->save();
		}
	}

	public function FtoI($farmer){
		$investor = User::where('category','investor')->orderBy('le')->first();
		if($investor->user->le >= $threshold_itog){
			$user_f = $farmer->user;
			$investor_new = $user_f->investor;
			if(!$investor_new){
				$investor_new = new Investor;
				$investor_new->save();
				$user_f->investor_id = Investor::orderBy('id','desc')->first()->id;
			}
			$user_f->category = 'investor';
			$user_f->save();

			$user_i = $investor->user;
			$farmer_new = $user_i->farmer;
			if(!$farmer_new){
				$farmer_new = new Farmer;
				$farmer_new->save();
				$user_i->farmer_id = Farmer::orderBy('id','desc')->first()->id;
			}
			$user_i->category = 'farmer';
			$user_i->save();
		}
	}

//this function plays on every request
	public function ItoF($investor){
		$farmer = User::where('category','farmer')->orderBy('le','desc')->first();
		if($farmer->user->le >= $threshold_itog){
			$user_i = $investor->user;
			$farmer_new = $user_i->farmer;
			if(!$farmer_new){
				$farmer_new = new Farmer;
				$farmer_new->save();
				$user_i->farmer_id = Farmer::orderBy('id','desc')->first()->id;
			}
			$user_i->category = 'farmer';
			$user_i->save();

			$user_f = $farmer->user;
			$investor_new = $user_f->farmer;
			if(!$investor_new){
				$investor_new = new Farmer;
				$investor_new->save();
				$user_f->investor_id = Investor::orderBy('id','desc')->first()->id;
			}
			$user_f->category = 'farmer';
			$user_f->save();
		}
	}

}