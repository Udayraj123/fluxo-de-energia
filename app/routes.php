

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
	//user filter checks existence of user & its category
{
	//aliases
	Route::get('/main',array('as'=>'energy',function(){return View::make('main')->with('user',Auth::user()->get());}));
	Route::get('/energy',array('as'=>'energy1',function(){return View::make('main')->with('user',Auth::user()->get());}));

	Route::get('/logout', ['as' => 'logout', 'uses' => 'UC@logout']);
//remove
	Route::get('/',array('as'=>'home',function(){return View::make('home')->with('user',Auth::user()->get());}));
	
	Route::post('/redeemLife', ['as' => 'redeemLife', 'uses' => 'UC@redeemLife']);
	Route::post('/decayHandle', ['as' => 'decayHandle', 'uses' => 'UC@decayHandle']); //gives user le & decay
	Route::post('/thresholdHandle', ['as' => 'thresholdHandle', 'uses' => 'UC@thresholdHandle']); //gives current Thresholds.
});

	// For rest it checks LE above THR
	//if not, it blocks the URL access & makes view to debug.reset page
//but post requests are not redirected
Route::group(array('before' => 'investor'), function()
{
	Route::get('/makeInvestment',array('as'=>'makeInvestment','uses'=>'IC@makeInvestment'));
	Route::get('/listInvestments',array('as'=>'listInvestments','uses'=>'IC@listInvestments'));
	Route::get('/buyFruit',array('as'=>'buyFruit','uses'=>'IC@buyFruit'));

	Route::post('/makeInvestment', ['as' => 'makeInvestment', 'uses' => 'IC@postmakeInvestment']);
	Route::post('/buyFruit', ['as' => 'buyFruit', 'uses' => 'IC@postBuyFruit'] );
	Route::post('/bidHandle', ['as' => 'bidHandle', 'uses' => 'IC@bidHandle']);
	Route::post('/priceHandle', ['as' => 'priceHandle', 'uses' => 'IC@priceHandle']);

});

//gets invester details -----------------------------------------------

Route::post('/getInvDetail',['as' => 'getInvDetail', 'uses' => 'IC@getInvDetail']);
Route::post('/newsUpdate',['as' => 'newsUpdate', 'uses' => 'UC@newsUpdate']);

//---------------------------------------------------------------------


Route::group(array('before' => 'god'), function()	{
	// Route::get('selfProducts', ['as' => 'selfProducts', 'uses' => 'GC@selfProducts']); 	
	Route::get('/fundingBar', ['as' => 'fundingBar', 'uses'=>'GC@fundingBar']);
	Route::get('/createProduct', ['as'=>'createProduct','uses'=>'GC@createProduct']);
	Route::post('/createProduct', ['as' => 'createProduct', 'uses' => 'GC@postCreateProduct']);
});
Route::group(array('before' => 'farmer'), function()
{

	Route::get('/showLand', ['as' => 'showLand', 'uses' => 'FC@showLand'] );
	Route::get('/buyProduct',array('as'=>'buyProduct', 'uses'=>'FC@buyProduct'));
	Route::post('/buyProduct', ['as' => 'buyProduct', 'uses' => 'FC@postbuyProduct'] );
	Route::post('/productPriceHandle', ['as' => 'productPriceHandle', 'uses' => 'FC@productPriceHandle'] );
	
	//make these ajax!
	Route::post('/getStates', ['as' => 'getStates', 'uses' => 'FC@getStates'] );
	Route::post('/applyPurch', ['as' => 'applyPurch', 'uses' => 'FC@applyPurch'] );
	Route::post('/launchFruit', ['as' => 'launchFruit', 'uses' => 'FC@launchFruit'] );
	Route::post('/fetchFruit', ['as' => 'fetchFruit', 'uses' => 'FC@fetchFruit'] );
	
});

?>


