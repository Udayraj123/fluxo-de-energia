<?php
Event::listen('bought_product',function($pch){
	Game::userLog($pch->product->god_id,'Farmer '.$pch->farmer_id.' '.$pch->farmer->user->username.
		' purchased your product '.$pch->product->name.'*'.$pch->num_units.' of id '.$pch->product->id);
	Game::userLog($pch->farmer_id,' You purchased '.$pch->num_units.' units of '.$pch->product->god_id.' '.$pch->product->god->user->username.'\'s product '.
		$pch->product->name.' of description:  '.$pch->product->description);
	// Game::userLog($pch->god->addNotice(""));
});

Event::listen('bought_fruit',function($fbill){
	// tell storageLE as well
	Game::userLog($fbill->investor_id,'Noted purchase : Notify the Farmer, or Push to the table which is fetched with ajax');
	Game::userLog($fbill->fruit->farmer_id,'Noted purchase : Notify the Farmer, or Push to the table which is fetched with ajax');
});

Event::listen('made_investment',function($invm){
	Game::userLog($invm->investor_id,'Noted purchase : Notify the Farmer, or Push to the table which is fetched with ajax');
	Game::userLog($invm->product->god_id,'Noted purchase : Notify the Farmer, or Push to the table which is fetched with ajax');
});

Event::listen('redeemed_LE',function($args){
	$user = $args[0];
	$redeemed_LE = $args[1];
	Game::userLog($user->id,'User '.$user->id.' '.$user->username.' redeemed LE '.$redeemed_LE.' Now at LE '.$user->le);
});

Event::listen('createProd',function($args){
	$user = $args[0];
	$p = $args[1];
	$msg = ($p->created_at.' : '.$p->name.' is created in category of '.$p->category .' of quality '.$p->quality.' , the funding time for the product is '.$p->FT.' minutes and its expiry time is '.$p->ET.' minutes. The available quantity is '.$p->total_shares.' each prices at '.$p->unit_price.'. This Product is  created by '.$user->username.'. <br>'.'Product Description :'.$p->description);
	Game::userLog($user->id,$msg);
	Event::fire('all_news',$msg);
	// Game::userLog($pch->god->addNotice(""));
});

Event::listen('createFruit',function($args){
	$user = $args[0];
	$p = $args[1];
	$msg = ($p->created_at.' : '.$p->name.' is created of quality '.$p->quality_factor.' , the expiry time for the fruit is '.$p->ET.' minutes. The available quantity is '.$p->avl_units.' each priced at '.$p->unit_price.'and sell price is'.$p->sell_price.'. This Product contains Storage LE of '.$p->storage_le.' This Product is  created by '.$user->username.'. <br>'.'Product Description :'.$p->description);
	Game::userLog($user->id,$msg);
	Event::fire('all_news',$msg);
	// Game::userLog($pch->god->addNotice(""));
});

Event::listen('all_news',function($msg){
	$msg = '<div class="news"> '.$msg.'</div><br>';
	shell_exec('echo touch '.public_path('news.txt'));
	shell_exec('echo "'.$msg. '" >> '.public_path('news.txt'));
	// Log::info($pch->god->addNotice(""));
});


Event::listen('user_boosted',function($args){
	$user=$args[0];
	$fac = $args[1];
	Game::userLog($user->id,' User '.$user->username.' got boosted by '.$fac.' now at LE '.$user->le);
});

