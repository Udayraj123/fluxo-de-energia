<?php
class UC extends \BaseController {
	
	public function redeemLife(){
		$user = Auth::user()->get();
		$redeemLE = Input::get('redeemLE');
		if($redeemLE > $user->stored_LE)
			$redeemLE = $user->stored_LE;
		$user->le += $redeemLE; $user->stored_LE -= $redeemLE; $user->save(); 

		$stored_LE=$user->stored_LE;
		return array('respLE'=>$redeemLE,'stored_LE'=>$stored_LE);
	}

	public function thresholdHandle(){
		$total= Config::get('game.sysLE');

		$thresholdGI= Config::get('game.facGI')* $total; 
		$thresholdFI= Config::get('game.facFI')* $total;
		$thresholdF= Config::get('game.facF')* $total;
		//Send this data to the graph.
		return array('total'=>$total,'thresholdGI'=>$thresholdGI,'thresholdFI'=>$thresholdFI,'thresholdF'=>$thresholdF);
	}

	//	Decays & Threshold => SIGMOID FUNCTION MUST
	public function decayHandle(){
		$user=Auth::user()->get();

    	$active_cat = $user->category; // Not Null in table
    	$char= $user->$active_cat; //required for decay value ?!

    	if(!$user->prev_time){
    		$user->prev_time=time();$user->save();
    	}
    	$time_passed = time()-$user->prev_time;
    	$user->prev_time=time();$user->save();

    	if($char->decay)
    		$decay = $char->decay;
    	else return array('le'=>0,'decay'=>0);

	    //Update decay-
    	$new_decay=Config::get('game.facDecay')[$active_cat] * Config::get('game.sysLE');
    	if($new_decay>0)$char->decay=$new_decay; $char->save();

    	//TODO : rectify this bad condition 
    	$minLE=Config::get('game.minLE');
    	if($user->le - $decay*$time_passed > $minLE)

    		{	$user->le -= $decay*$time_passed;	    	$user->save();}
    	$user->save();
    	return array('le'=>$user->le,'decay'=>$decay);

    }


    public function login($id=42){$user=User::find($id); if($user){Auth::user()->login($user); return Redirect::back(); } else return Config::get('debug.login'); }

    public function logout(){$user= Auth::user()->get(); if($user){echo $user->username." logged out"; Auth::user()->logout(); return Redirect::back(); } 
    else echo "Already logged out <BR>".Config::get('debug.login'); } } 


#*** Admin Panel REQUIRED => in case light goes off OR server stops respondin, the decay will still go on due to timestamp stuff. !
# thresholdHandle -Done?
# >Make similar for fruit price setting
# > CHANGING CHARACTER THR CHeck   
# >Land mini game -> returning land blocks array.
