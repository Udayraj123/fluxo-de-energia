<?php
namespace Helpers;
use \App\Models;
use C,User,Common,Log;

class Game
{
	public static function swap($user1, $user2){
	  $cat1=$user1->category;
	  $cat2=$user2->category;
	  $user1->category= $cat2;
	  $user2->category= $cat1;
	  $user1->save();
	  $user2->save();
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
	              if($user2->le > $common2->upperTHR)
	                return 4; //normal Swap
	                // UC::swap($user,$user2);
	              else{
	              //Stuck - giveE option here.
	              }
	            }
	            else{
	              //farmer with too low E. No decay. If don't play good, will die.
	            }
	            // TODO :-  NEED TO REDIRECT/RELOAD ATLEAST ! 
	            return 2; //level down.
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