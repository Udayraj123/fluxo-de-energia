<?php
Event::listen('bought_product',function($pch){
	
	Game::userLog($pch->farmer->user_id,' You purchased '.$pch->num_units.' units of '.$pch->product->god->user_id.' '.$pch->product->god->user->username.'\'s product '.
		$pch->product->name.' of description:  '.$pch->product->description.' priced at '.$pch->product->bid_price);
	// Game::userLog($pch->god->addNotice(""));
});

Event::listen('bought_product_g',function($args){
	// tell storageLE as well
	$pch = $args[0];
	$amt = $args[1];
	$userId = $args[2];
	Game::userLog($userId,'Farmer with id '.$pch->farmer->user_id.' and name '.$pch->farmer->user->username.'has purchased your product '.$pch->product->name.', and bought '.$pch->num_units.'units at price '.$pch->product->bid_price.' So the total amount received by you is '.$amt.'');
});

Event::listen('bought_product_i',function($args){
	// tell storageLE as well
	$pch = $args[0];
	$amt = $args[1];
	$userId = $args[2];
	Game::userLog($userId,'Farmer with id '.$pch->farmer->user_id.' and name '.$pch->farmer->user->username.'has purchased your product '.$pch->product->name.', and bought '.$pch->num_units.'units at price '.$pch->product->bid_price.' So the total amount received by you is '.$amt.'');
});


Event::listen('bought_fruit',function($fbill){
	// tell storageLE as well

	Game::userLog($fbill->investor->user_id,'You have successfully bought '.$fbill->num_units.' fruits priced at '.(int)($fbill->num_units)*(int)($fbill->buy_price).'. The Stored Le that you get is '.$fbill->fruit->storage_le.'. The farmer you bought from '.$fbill->fruit->farmer->user->username.' and id was '.$fbill->fruit->farmer->user_id);
	Game::userLog($fbill->fruit->farmer->user_id,'Your fruit '.$fbill->fruit->name.' has been sold. The quantity sold was '.$fbill->num_units.' priced at '.$fbill->buy_price.' So the total amount you received is '.(int)($fbill->num_units)*(int)($fbill->buy_price).'. Investor who invested'.$fbill->investor->user->username.' and id was '.$fbill->investor->user_id);
});

Event::listen('made_investment',function($invm){
	Game::userLog($invm->investor->user_id,'You have bought the product '.$invm->product->name.', created by '.$invm->product->god->user->username.' and id '.$invm->product->god->user_id.'. Bought at Buy Price'.$invm->bid_price.' the quantity you bought is '.$invm->num_shares.'. Total Amount you paid '.(int)($invm->num_shares)*(int)($invm->bid_price));
	Game::userLog($invm->product->god->user_id,'Your product '.$invm->product->name.' has been invested by '.$invm->investor->user->username.' and id '.$invm->investor->user_id.'. Bought at Buy Price'.$invm->bid_price.' the quantity taken is '.$invm->num_shares.'. So the remaining amount left is '.$invm->product->avl_shares.'Total Amount you recieved '.(int)($invm->num_shares)*(int)($invm->bid_price));
});

Event::listen('redeemed_LE',function($args){
	$user = $args[0];
	$redeemed_LE = $args[1];
	if($redeemed_LE!=0)Game::userLog($user->id,'User '.$user->id.' '.$user->username.' redeemed LE '.$redeemed_LE.' Now at LE '.$user->le);
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

