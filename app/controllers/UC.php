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

        ////////////////////////////////////////////////////////////////////////////////

        public function leaderBoard(){
          $users = User::orderBy('le','desc')->where('is_moderator',0)->get();
          $leaders=[];

          $godThresholds  = Game::thresholdsFor('god');
          $investorThresholds  = Game::thresholdsFor('investor');
          $farmerThresholds  = Game::thresholdsFor('farmer');
          $allTHRs = [
          'lowerG'=>$godThresholds['lowerTHR'],
          'lowerF'=>$farmerThresholds['lowerTHR'],
          'lowerI'=>$investorThresholds['lowerTHR'],
          'upperG'=>$godThresholds['upperTHR'],
          'upperI'=>$investorThresholds['upperTHR'],
          'upperF'=>$farmerThresholds['upperTHR'],
          ];

          foreach ($users as $u) {
            $luser = [];
            $luser['name']=$u->username;
            $luser['category']=$u->category;
            // $luser['highest_LE']=$u->highest_LE;
            $luser['le']=$u->le;
            $lCat= $allTHRs['lower'.strtoupper($u->category[0])];
            $uCat= $allTHRs['upper'.strtoupper($u->category[0])];
            $luser['lCat']=round($lCat);
            $luser['uCat']=round($uCat);
            $diff1 = $u->le - $lCat;
            $diff2 = $uCat - $lCat;
            $luser['width']= ($diff1/$diff2) * 100;
            $luser['color']=($diff1*2 > $diff2)?'green':'danger';
            $luser['invcolor']=($u->category=='god')?'black':(($u->category=='farmer')?'green':'red');
            $leaders[]=$luser;
          }
          return View::make('leaderBoard')->with('leaders',$leaders);
        }

        ////////////////////////////////////////////////////////////////////////////////

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
       //////////////////////////////////////Profile////////////////////////////////
       
       public function profile($id){
        $puser = User::find($id);
        if($puser){
          $total = $this->fruitbill($puser);
          return View::make('profile')->with(['puser'=>$puser,'total'=>$total]);
        }
        else{
          return 'User Not Found';
        }
      }

      public function fruitbill($puser){
        $total[0]=0;
        $total[1]=0;
        foreach ($puser->farmer->fruits as $p){
          foreach( Fruitbill::where('fruit_id',$p->id)->get() as $q){
            $total[0] += $q->num_units;
            $total[1] += ($q->num_units) * ($q->buy_price);
          }
        }
        return $total;
      }

       //////////////////////////////////////Profile////////////////////////////////
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


      public function decayHandle(){
        $user=Auth::user()->get();
        //------------------------------------------------------------------------------------------------
        if($user->highest_LE<$user->le)
          $user->highest_LE=$user->le;
        //------------------------------------------------------------------------------------------------

        if(!$user->prev_time){
          $user->prev_time=time();$user->save();
        }
        if(!$user->prev_LE_time){
          $user->prev_LE_time=time();$user->save();
        }

        $active_cat = $user->category; // Not Null in table
        $char= $user->$active_cat; //required for decay value ?!
        
        $leaderBoardRate=C::get('game.leaderBoardRate');
        $time_leader_passed = time()-$user->prev_LE_time;
        if($time_leader_passed>=$leaderBoardRate){
          if($user->prev_LE)
          {
            $user->change_percent = (float)($user->le-$user->prev_LE)/$user->prev_LE*100.0;
          }
          $user->prev_LE_time=time();
          $user->prev_LE=$user->le;
          $user->save();
        }

        $minRefreshRate=C::get('game.minRefreshRate');
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
      return array('reload'=>'0','le'=>$user->le,'stored_LE'=>$user->stored_LE,'decay'=>$char->decay,'active_cat'=>$active_cat);
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
      $user=User::find($id); 
      if($user){Auth::user()->login($user); return View::make('goback');} else 
      return View::make('admin.login'); 
    }
    public function loginCat($cat,$force=0){
      $authuser = Auth::user()->get();
      if($authuser && $force==0)return "already logged in ";

        
      $user = User::where('is_moderator','0')
      ->where('logged_in','0')
      ->where('category',$cat)
      ->first();

      if($user){
        if($authuser){
          $authuser->logged_in=0;
          $authuser->save();
          Auth::user()->logout(); 
        }
        Auth::user()->login($user); 
        $user->logged_in = 1; $user->save(); 
        return View::make('goback');
      } 
      else 
        return "No user available to login!" ;

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
