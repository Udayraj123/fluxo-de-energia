

<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
// Route::post('queue/offmail', function() { return Queue::marshal(); });

//any url will do like thresholdHandle as we are accessing by name


//test/practices
Route::get('/test',function(){return View::make('test');});
Route::get('/testfn', ['as' => 'testfn', 'uses' => 'IC@testfn']);
Route::get('/testFruitRel', ['as' => 'testFruitRel', 'uses' => 'FC@testFruitRel']);

Route::get('/testAMG', ['as' => 'testAMG', 'uses' => 'AmoghController@testAMG']);

//debugs
Route::get('/login/{id?}', ['as' => 'login', 'uses' => 'UC@login']);
Route::get ('/boost', ['as' => 'boostLE', 'uses' => 'admin@boostLE']);
Route::get ('/updateUsers', ['as' => 'updateUsers', 'uses' => 'admin@updateUsers']);
Route::get ('/plantSeedLands', ['as' => 'plantSeedLands', 'uses' => 'admin@plantSeedLands']);
Route::get ('/resetUsers', ['as' => 'resetUsers', 'uses' => 'admin@resetUsers']);
Route::get ('/resetProducts/{launch?}', ['as' => 'resetProducts', 'uses' => 'admin@resetProducts']);
Route::get ('/resetFruits', ['as' => 'resetFruits', 'uses' => 'admin@resetFruits']);



Route::group(array('before' => 'user'), function()
{
	Route::get('/', function(){return View::make('home')->with('user',Auth::user()->get());});
	Route::post('/redeemLife', ['as' => 'redeemLife', 'uses' => 'UC@redeemLife']);
	Route::post('/decayHandle', ['as' => 'decayHandle', 'uses' => 'UC@decayHandle']); //gives user le & decay
	Route::post('/thresholdHandle', ['as' => 'thresholdHandle', 'uses' => 'UC@thresholdHandle']); //gives current Thresholds.
	Route::get('/logout', ['as' => 'logout', 'uses' => 'UC@logout']);
});

Route::group(array('before' => 'investor'), function()
{
	Route::get('godProducts', ['as' => 'godProducts', 'uses' => 'IC@godProducts']);
	
	Route::get('/makeInvestment', function(){return View::make('invest') 
		->with('products',Product::where('being_funded',1) ->where('avl_shares','>',0) 
			->orderBy('id','desc') ->get());});
	
	Route::post('/bidHandle', ['as' => 'bidHandle', 'uses' => 'IC@bidHandle']);
	Route::post('/makeInvestment', ['as' => 'makeInvestment', 'uses' => 'IC@makeInvestment']);

	Route::get('/buyFruit', function(){return View::make('buyFruit')
		->with('fruits',Fruit::where('launched',1)->where('avl_units','>',0) 
			->orderBy('id','desc') ->get());}); //latest first

	Route::post('/priceHandle', ['as' => 'priceHandle', 'uses' => 'IC@priceHandle']);
	Route::post('/buyFruit', ['as' => 'buyFruit', 'uses' => 'IC@buyFruit'] );

});



Route::group(array('before' => 'god'), function()
{
Route::get('listFunds','PC@listFunds'); //may remove this later

Route::get('selfProducts', ['as' => 'selfProducts', 'uses' => 'GC@selfProducts']); //this gives FUNDING BAR
Route::get('/createProduct', function(){return View::make('createProd')
	->with('c1',Config::get('game.baseC1'))
	->with('c2',Config::get('game.baseC2'))
	->with('c3',Config::get('game.baseC3'))
	->with('c4',Config::get('game.baseC4'))
	->with('k',Config::get('game.basePrices'));
});

Route::post('/createProduct', ['as' => 'createProduct', 'uses' => 'GC@createProduct']);
});
Route::group(array('before' => 'farmer'), function()
{

	Route::get('/buyProduct', function(){return View::make('buyProduct')
		->with('products',Product::where('being_funded',0)
			->where('avl_units','>',0)
			->orderBy('id','desc')
			->get());
		;});
	Route::post('/buyProduct', ['as' => 'buyProduct', 'uses' => 'FC@buyProduct'] );

	Route::get('/showLand', ['as' => 'showLand', 'uses' => 'FC@showLand'] );
	
	Route::post('/getStates', ['as' => 'getStates', 'uses' => 'FC@getStates'] );
	Route::post('/applyPurch', ['as' => 'applyPurch', 'uses' => 'FC@applyPurch'] );
	Route::post('/launchFruit', ['as' => 'launchFruit', 'uses' => 'FC@launchFruit'] );
	Route::post('/fetchFruit', ['as' => 'fetchFruit', 'uses' => 'FC@fetchFruit'] );
	
});

?>


