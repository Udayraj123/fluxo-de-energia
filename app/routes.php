

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
//any url will do like thresholdHandle as we are accessing by name


//test/practices
Route::get('/testFruitRel', ['as' => 'testFruitRel', 'uses' => 'FC@testFruitRel']);


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
	//filter checks existence of user & its category
	Route::get('/main',array('as'=>'energy',function(){return View::make('main')->with('user',Auth::user()->get());}));
	Route::get('/logout', ['as' => 'logout', 'uses' => 'UC@logout']);
//remove
	Route::get('/',array('as'=>'home',function(){return View::make('home')->with('user',Auth::user()->get());}));
	
	Route::post('/redeemLife', ['as' => 'redeemLife', 'uses' => 'UC@redeemLife']);
	Route::post('/decayHandle', ['as' => 'decayHandle', 'uses' => 'UC@decayHandle']); //gives user le & decay
	Route::post('/thresholdHandle2', ['as' => 'thresholdHandle2', 'uses' => 'UC@thresholdHandle2']); //gives current Thresholds.
});

	// For rest it checks LE above THR
	//if not, it blocks the URL access & makes view to debug.reset page
//but post requests are not redirected
Route::group(array('before' => 'investor'), function()
{
	Route::get('/makeInvestment',array('as'=>'makeInvestment',function(){return View::make('makeInvestment') ->with('products',Product::where('being_funded',1) ->where('avl_shares','>',0) ->orderBy('id','desc') ->get());}));
	
	Route::get('/listInvestments',array('as'=>'listInvestments',function(){
		$user=Auth::user()->get(); return View::make('listInvestment') ->with('products',$user->investor->products);
	}));

	Route::get('/buyFruit', array('as'=>'buyFruit',function(){
		$user=Auth::user()->get();
		return View::make('buyFruit')
		->with('boughtFruits',$user->investor->fruits)
		->with('fruits',Fruit::where('launched',1)->where('avl_units','>',0) 
			->orderBy('id','desc') ->get());})); //latest first

	Route::post('/makeInvestment', ['as' => 'makeInvestment', 'uses' => 'IC@makeInvestment']);
	Route::post('/buyFruit', ['as' => 'buyFruit', 'uses' => 'IC@buyFruit'] );
	Route::post('/bidHandle', ['as' => 'bidHandle', 'uses' => 'IC@bidHandle']);
	Route::post('/priceHandle', ['as' => 'priceHandle', 'uses' => 'IC@priceHandle']);

});



Route::group(array('before' => 'god'), function()	{

	Route::get('selfProducts', ['as' => 'selfProducts', 'uses' => 'GC@selfProducts']); 	//this gives FUNDING BAR
	Route::get('/fundingBar', ['as' => 'fundingBar', function(){
		$user=Auth::user()->get();
		$products = $user->god->products;
		return View::make('fundingBar')->with('products',$products);
	}]);
	Route::get('/createProduct', function(){
		$user=Auth::user()->get();
		$bp=json_encode(C::get('game.basePrices'));
		return View::make('createProd')
		->with(C::get('game.baseCIs'))
		->with('k',$bp )
		->with('products',$user->god->products()->orderBy('id','desc')->get())
		;
	});

	Route::post('/createProduct', ['as' => 'createProduct', 'uses' => 'GC@createProduct']);
});
Route::group(array('before' => 'farmer'), function()
{

	Route::get('/showLand', ['as' => 'showLand', 'uses' => 'FC@showLand'] );
	Route::get('/buyProduct',array('as'=>'buyProduct', function(){$user=Auth::user()->get();return View::make('buyProduct')
		->with('boughtProducts',$user->farmer->products)
		->with('products',Product::where('being_funded',0)
			->where('avl_units','>',0)
			->orderBy('id','desc')
			->get());
		;}));
	Route::post('/buyProduct', ['as' => 'buyProduct', 'uses' => 'FC@buyProduct'] );
	Route::post('/productPriceHandle', ['as' => 'productPriceHandle', 'uses' => 'FC@productPriceHandle'] );
	
	
	Route::post('/getStates', ['as' => 'getStates', 'uses' => 'FC@getStates'] );
	Route::post('/applyPurch', ['as' => 'applyPurch', 'uses' => 'FC@applyPurch'] );
	Route::post('/launchFruit', ['as' => 'launchFruit', 'uses' => 'FC@launchFruit'] );
	Route::post('/fetchFruit', ['as' => 'fetchFruit', 'uses' => 'FC@fetchFruit'] );
	
});

?>


