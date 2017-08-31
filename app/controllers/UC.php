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

//the display function
       public static function thresholdHandle(){

        $user=Auth::user()->get();
      //this swaps characters !
        $catThresholds  = Game::thresholdsFor($user->category);
        $msg=Game::thresholdCheck($catThresholds,$user); //will already swap the user.
        $reload=C::get('game.reloads')[$msg];

        $user=Auth::user()->get(); //get the updated user.
        return array_merge($catThresholds,['reload'=>$reload,'msg'=>$msg,'active_cat'=>$user->category,'le'=>$user->le]);
      }


      //---------------------------------------------------------------------
      public function leDifference()
      {
        $user=Auth::user()->get();
        $user->LE_diff=$user->le-$user->prev_LE;
        if($user->prev_LE)
          {$user->change_percent=(float)$user->LE_diff/$user->prev_LE*100.0;}
        $user->prev_LE_time=time();
        $user->prev_LE=$user->le;
        // $rowSQL=mysql_query("SELECT MAX(change_percent) AS max FROM 'users';");
        // $row=mysql_fetch_array($rowSQL);
        // $top_change=$row['max'];
        // Log::info($top_change);
      }
      //---------------------------------------------------------------------


      public function decayHandle(){
        //------------------------------------------------------------------------------------------------
        $user=Auth::user()->get();

        //Log::info($user->id."------".(int)($user->prev_time-$user->prev_LE_time));
        if ((int)($user->prev_time-$user->prev_LE_time)%5==0)//&&(($user->prev_time-$user->prev_LE_time)%60<=5))
{
  $this->leDifference();
}
if($user->highest_LE<$user->le)
  $user->highest_LE=$user->le;
        // Log::info('test');

        //------------------------------------------------------------------------------------------------

$minRefreshRate=C::get('game.minRefreshRate');
if(!$user->prev_time){
  $user->prev_time=time();$user->save();
}
        $active_cat = $user->category; // Not Null in table
        $char= $user->$active_cat; //required for decay value ?!
        
        $time_passed = time()-$user->prev_time;
        if($time_passed>=$minRefreshRate){
         $user->prev_time=time();
         $user->save();


	    //Update decay-
         $new_decay=C::get('game.facDecay')[$active_cat] * Game::sysLE();
         if($new_decay>0) 
        //just to make sure decay is nonzero if LE above minLE
          $char->decay=$new_decay; 

        if($user->le - $char->decay*$time_passed <= C::get('game.minLE'))
          $char->decay=C::get('game.minDecay');
        $char->save();
        
        if($user->is_moderator == 1)
          $user->le = C::get('game.iniLE')[$user->category]; 
        else
          $user->le -= $char->decay*$time_passed;	    	

        $user->save();
      }
      return array('reload'=>'0','le'=>$user->le,'decay'=>$char->decay,'active_cat'=>$active_cat);
    }


    public function newsUpdate(){
      $fileadrs = asset("news.txt");
      // log::info($fileadrs);
      try{
        $fcontent = file_get_contents($fileadrs);
      }catch(Exception $e){
        shell_exec('touch '.$fileadrs);
        $fcontent=" ";
      }
      // log::info($fcontent);
    }

    public function login($id=42){
      $user=User::find($id); if($user){Auth::user()->login($user); return View::make('goback');} else 
      return View::make('admin.login'); 
    }

    public function logout(){
      $user= Auth::user()->get(); if($user){echo $user->username." logged out"; Auth::user()->logout(); 
      return Redirect::route('login'); 
    }
    else echo "Already logged out <BR>".C::get('debug.login'); } } 


#*** Admin Panel REQUIRED => in case light goes off OR server stops respondin, the decay will still go on due to timestamp stuff. !
# thresholdHandle -Done?
# >Make similar for fruit price setting
# > CHANGING CHARACTER THR CHeck   
# >Land mini game -> returning land blocks array.
