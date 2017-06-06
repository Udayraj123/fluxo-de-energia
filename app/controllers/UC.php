<?php
class UC extends \BaseController {


//static is required to call fn within the class
  public static function swap($user1, $user2){
    $cat1=$user1->category;
    $cat2=$user2->category;
    $user1->category= $cat2;
    $user2->category= $cat1;
    $user1->save();
    $user2->save();
  }

/*
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



//this does the swapping
        public static function thresholdCheck($common,$user){

          $diff1=$user->le - $common->lowerTHR;
          $diff2=$common->upperTHR - $user->le;
          $cat=$user->category;
          if($diff1<=0){
            //will cost a query  
            if($cat=='god') $user2=User::where('category','investor')->orderBy('le','desc')->first();
            else if($cat=='investor') $user2=User::where('category','farmer')->orderBy('le','desc')->first();
            if($cat!='farmer'){
              $common2 = Common::where('category',$user2->category)->first();
              if($user2->le > $common2->upperTHR)return 4;
            }
  //UC::swap($user,$user2);
   //CHECK : is changing category reflected everywhere ?
            // TODO :-  NEED TO REDIRECT/RELOAD ATLEAST ! 
            return 2; //level down
          }
          if($diff2<=0){
          //SWAP only if somebody is below THR, will stay notified until somebody already 
            if($cat=='god') return 5;//F yeah
            return 3; //level up
          }
          $notifTime=C::get('game.notifTime');
          if($diff1/($user->$cat->decay)<= $notifTime) return 1; //warning
        else return 0; //clean
      }

      public function redeemLife(){
        $user = Auth::user()->get();
        $redeemLE = Input::get('redeemLE');
        if($redeemLE > $user->stored_LE)
         $redeemLE = $user->stored_LE;
       $user->le += $redeemLE; $user->stored_LE -= $redeemLE; $user->save(); 

       $stored_LE=$user->stored_LE;
       return array('respLE'=>$redeemLE,'stored_LE'=>$stored_LE);
     }

//the personalized function
     public static function thresholdHandle2(){
      $user=Auth::user()->get();
      $t=C::get('game.minRefreshRate');
      $time=time();
      $cat=$user->category;
      $common = Common::where('category',$cat)->first();
      
      //this swaps characters !
      $msg=UC::thresholdCheck($common,$user);

      if($time - $common->prev_time < $t){
        $sysLE = $common->sysLE;
        $upperTHR = $common->upperTHR;
        $lowerTHR = $common->lowerTHR;
      }
      else{
          $f0= C::get('game.facGM'); //F yeah mode
          $f1= C::get('game.facGI');
          $f2= C::get('game.facFI');
          $f3= C::get('game.facF');
          if($cat=='god'){$fac1=$f0;$fac2=$f1;}
          if($cat=='investor'){$fac1=$f1;$fac2=$f2;}
          if($cat=='farmer'){$fac1=$f2;$fac2=$f3;}
          $sysLE= C::get('game.sysLE');
          $upperTHR=$sysLE*$fac1;
          $lowerTHR=$sysLE*$fac2;
          //uodate in table
          $common->sysLE=$sysLE;
          $common->upperTHR=$upperTHR;
          $common->lowerTHR=$lowerTHR;
          $common->prev_time=$time; $common->save();
        }
    //Send this data to the graph.
        return array('sysLE'=>$sysLE,'upperTHR'=>$upperTHR,'lowerTHR'=>$lowerTHR,'msg'=>$msg,'active_cat'=>$cat,'le'=>$user->le);
      }


//the Common function
      public function thresholdHandle(){
        $total= C::get('game.sysLE');
        $thresholdGI= C::get('game.facGI')* $total; 
        $thresholdFI= C::get('game.facFI')* $total;
        $thresholdF= C::get('game.facF')* $total;
    //Send this data to the graph.
        return array('total'=>$total,'thresholdGI'=>$thresholdGI,'thresholdFI'=>$thresholdFI,'thresholdF'=>$thresholdF);
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
    $new_decay=C::get('game.facDecay')[$active_cat] * C::get('game.sysLE');
    if($new_decay>0)$char->decay=$new_decay; $char->save();

    	//TODO : rectify this bad condition 
    $minLE=C::get('game.minLE');
    if($user->le - $decay*$time_passed > $minLE)
      if($time_passed>=$minRefreshRate) {	$user->le -= $decay*$time_passed;	    	$user->save();}
    
    $user->save();
    return array('le'=>$user->le,'decay'=>$decay,'active_cat'=>$active_cat);
  }


  public function login($id=42){$user=User::find($id); if($user){Auth::user()->login($user); } else return C::get('debug.login'); }

  public function logout(){$user= Auth::user()->get(); if($user){echo $user->username." logged out"; Auth::user()->logout(); 
  return Redirect::back(); }
  else echo "Already logged out <BR>".C::get('debug.login'); } } 


#*** Admin Panel REQUIRED => in case light goes off OR server stops respondin, the decay will still go on due to timestamp stuff. !
# thresholdHandle -Done?
# >Make similar for fruit price setting
# > CHANGING CHARACTER THR CHeck   
# >Land mini game -> returning land blocks array.
