<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

//No Cache filter for technopedia.
Route::filter('no-cache',function($route, $request, $response){
    $response->headers->set('Cache-Control','nocache, no-store, max-age=0, must-revalidate');
    $response->headers->set('Pragma','no-cache');
    $response->headers->set('Expires','Fri, 01 Jan 1990 00:00:00 GMT');
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

//GOod-
Route::filter('user', function() {
    $user= Auth::user()->get();
    if (!$user || !$user->category) {
        return Config::get('debug.login');
    }
});

function logBackIn(){
    $user= Auth::user()->get();
    return "Not allowed. $user->username $user->category <BR>".Config::get('debug.login');
}

function checkLE($factor){
    $user= Auth::user()->get();
    $total=User::all()->sum('le'); 
    if($user->le < $factor* $total)    {
        echo "Low LE, should transform.".$user->le." < ".$factor* $total ;
        return 0;
    }
    else{
        //this is making probs for post/get requests data
        // echo "$user->le >= $factor * $total  = ".$factor* $total." (from filters.php)<BR><BR>";
        return 1;
    }

}

Route::filter('god', function() {
    $user= Auth::user()->get();
    if(!$user)return Config::get('debug.login');
    if (!($user->god && $user->category=='god')) {
        return logBackIn();
    }
    
    if(checkLE(Config::get('game.facGI'))!=1)return Config::get('debug.reset');

});

Route::filter('investor', function() {
    $user= Auth::user()->get();
    if(!$user)return Config::get('debug.login');
    if (!($user->investor && $user->category=='investor')) {
        return logBackIn();
    }
    if(checkLE(Config::get('game.facFI'))!=1)return Config::get('debug.reset');
    
});

Route::filter('farmer', function() {
    $user= Auth::user()->get();
    if(!$user)return Config::get('debug.login');
    if (!($user->farmer && $user->category=='farmer')) {
        return logBackIn();
    }
    if(checkLE(Config::get('game.facF'))!=1)return Config::get('debug.reset');

});


/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
    if (Auth::check()) return Redirect::to('/');
});

Route::filter('auth.user', function() {
    if (Auth::user()->guest()) {
        return Redirect::guest('misc/login');
    }
});
/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
    if (Session::token() != Input::get('_token'))
    {
      throw new Illuminate\Session\TokenMismatchException;
  }
});
