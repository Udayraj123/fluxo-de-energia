<?php
class UC extends \BaseController {

//static is required to call fn within the class or outside

/*
>> Almost the same working until we find a conceptual flaw
//TRANSITIONS INVOLVE
    - that ETA will be calc in seconds : notification starts at 60secs
    
    - after below THR, decay continues (might get slower though?!)
    
        - then it will query over the lower class who are above threshold & get the top person (THIS QUERY SHALL RUN EVERYTIME AS MULTIPLE MAY TRANSITION AGAIN.)
        - that top person shall be above THR (& notified) already.
        - if there exists a guy above upperTHR, and this guys is below lowerTHR, swap (them)
            -swap will involve change of category, redirecting to the new interface
            -AS ALL THREE categorIES WILL EXIST FOR EACH USER, WE WON'T MAKE A new Investor()
        
        -If there is no one above THR, keep decaying.
        -TODO** HERE COMES THAT CHOICE OF GIVING A PART OF LE

        - the above might require a game.transitionTime
*/

      public function redeemLife(){
        $user = Auth::user()->get();
        $redeemLE = Input::get('redeemLE');
        if($redeemLE > $user->stored_LE)
         $redeemLE = $user->stored_LE;
       //LE_change
       $user->le += $redeemLE; $user->stored_LE -= $redeemLE; $user->save(); 

       $stored_LE=$user->stored_LE;
       return array('respLE'=>$redeemLE,'stored_LE'=>$stored_LE);
     }

//the personalized function
     public static function thresholdHandle(){
      $user=Auth::user()->get();
      $cat=$user->category;
      
      //this swaps characters !
      $catThresholds  = Game::thresholdsFor($cat);
      $msg=Game::thresholdCheck($catThresholds,$user);
    //Send this data to the graph.
      return array_merge($catThresholds,['msg'=>$msg,'active_cat'=>$cat,'le'=>$user->le]);
    }


//Decays & Threshold => SIGMOID FUNCTION MUST
    public function decayHandle(){
      $user=Auth::user()->get();
      $minRefreshRate=C::get('game.minRefreshRate');

    	$active_cat = $user->category; // Not Null in table
    	$char= $user->$active_cat; //required for decay value ?!

    	if(!$user->prev_time){
    		$user->prev_time=time();$user->save();
    	}
    	$time_passed = time()-$user->prev_time;
      if($time_passed>=$minRefreshRate)
       $user->prev_time=time();$user->save();

     if($char->decay)
      $decay = $char->decay;
    else return array('le'=>0,'decay'=>0);

	    //Update decay-
    $new_decay=C::get('game.facDecay')[$active_cat] * Game::sysLE();
    if($new_decay>0)$char->decay=$new_decay; $char->save();

    	//TODO : rectify this bad condition 
    $minLE=C::get('game.minLE');
    if($user->le - $decay*$time_passed > $minLE)
      if($time_passed>=$minRefreshRate) {	
         //LE_change
        $user->le -= $decay*$time_passed;	    	$user->save();
      }

      $user->save();
      return array('le'=>$user->le,'decay'=>$decay,'active_cat'=>$active_cat);
    }


    public function login($id=42){$user=User::find($id); if($user){Auth::user()->login($user); return View::make('goback');} else 
    return View::make('admin.login'); }

    public function logout(){$user= Auth::user()->get(); if($user){echo $user->username." logged out"; Auth::user()->logout(); 
    return Redirect::back(); }
    else echo "Already logged out <BR>".C::get('debug.login'); } } 


#*** Admin Panel REQUIRED => in case light goes off OR server stops respondin, the decay will still go on due to timestamp stuff. !
# thresholdHandle -Done?
# >Make similar for fruit price setting
# > CHANGING CHARACTER THR CHeck   
# >Land mini game -> returning land blocks array.
