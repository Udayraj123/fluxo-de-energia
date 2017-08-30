<?php
namespace Helpers;
use \App\Models;
use C,User,Common,Log,Session;

class Game
{
	public static function getRFT($p){
		//may change this created at to created_time later.
			$time_elapsed= (time()-strtotime($p->created_at))/60; //Minutes
		  	$RFT = $p->FT - $time_elapsed; //Minutes
		  	if($RFT<0){
		  		$p->being_funded = 0; $p->save();
		  	}
		  	return $RFT;
		  }
		  public static function getRET($p){
		//may change this created at to created_time later.
			$time_elapsed= (time()-(int)$p->launched_at)/60; //Minutes
		  	$RET = $p->ET - $time_elapsed; //Minutes
		  	if($RET<0){
// UPDATE * $p->being_funded= -1 stands for deleted
		  		$p->being_funded= -1; $p->save();
		  	}
		  	return $RET;
		  }
		  public static function launchProd($p){
		  	$p->being_funded=0; 
		  	$p->launched_at=time(); 
            $p->save(); //time is over now          <-- What's correct place to update this?

        }
        public static function swap($user1, $user2){
        	if(C::get('game.swapon')){
        		$cat1=$user1->category;
        		$cat2=$user2->category;
        		$user1->category= $cat2;
        		$user2->category= $cat1;
        		$user1->save();
        		$user2->save();
        		Log::info('Swapped '.$cat1.' user with '.$cat2.' user');
        	}
        }
	//this does the swapping
        public static function thresholdCheck($catThresholds,$user){
        	$diff1=$user->le - $catThresholds['lowerTHR'];
        	$diff2=$catThresholds['upperTHR'] - $user->le; 
        	$cat=$user->category;
        	if($diff1<=0){
	            //will cost a query  
        		if($cat!='farmer'){
        			$user2=User::where('category',($cat=='investor'?'farmer':'investor'))->orderBy('le','desc')->first();
        			$common2 = Common::where('category',$user2->category)->first();
        			if($user2->le > $common2->upperTHR){
        				Game::swap($user,$user2);
	                return 'swap_down'; //normal Swap down
	            }
	            else{
	            	//No one to swap with.
	              //Stuck - giveE option here.
	            	Log::info('stuck user' ,$user2->name);
		            return 'stuck_wait'; //level down but no swap
		        }
		    }
		    else{
	              //farmer with too low E. No decay. If don't play good, will die.
		    	return 'warn_die';
		    }
		}
		else if($diff2<=0){
          //SWAP only if somebody is below THR, will stay notified until somebody already 
            if($cat=='god') return 'f_yeah';//F yeah top level

            return 'class_topper'; //level up candidate
        }

        $notifTime=C::get('game.notifTime');
        $decay = max(C::get('game.minDecay'),$user->$cat->decay);
        if($diff1/floatval($decay)<= $notifTime) 
	          return 'warning_down'; //warning
        else return 'clean'; //clean
    }


    public static function e($message){
    	$tagsToStrip = array('@<script[^>]*?>.*?</script>@si'); // you can add more
    	$message = preg_replace($tagsToStrip, '', $message);
    	return $message;
    }

    public static function sysLE(){
    	return Game::thresholdsFor('god')['sysLE'];
    }

    public static function thresholdsFor($cat){
    	$t=C::get('game.minRefreshRate'); 
    	$time=time();
    	$common = Common::where('category',$cat)->first();

    	if($time - $common->prev_time < $t){
    		$sysLE = $common->sysLE;
    		$upperTHR = $common->upperTHR;
    		$lowerTHR = $common->lowerTHR;
    	}
    	else{
			//update after refreshrate
		    $f0= C::get('game.facGM'); //F yeah mode
		    $f1= C::get('game.facGI');
		    $f2= C::get('game.facFI');
		    $f3= C::get('game.facF');
		    if($cat=='god'){$fac1=$f0;$fac2=$f1;}
		    if($cat=='investor'){$fac1=$f1;$fac2=$f2;}
		    if($cat=='farmer'){$fac1=$f2;$fac2=$f3;}
		    $sysLE= User::all()->sum('le');
		    $upperTHR=$sysLE*$fac1;
		    $lowerTHR=$sysLE*$fac2;
	    //uodate in table
		    $common->sysLE=$sysLE;
		    $common->upperTHR=$upperTHR;
		    $common->lowerTHR=$lowerTHR;
		    $common->prev_time=$time; $common->save();
		}
		return ['sysLE'=>$sysLE,'upperTHR'=>$upperTHR, 'lowerTHR'=>$lowerTHR, 'time'=>$time];
	}
}