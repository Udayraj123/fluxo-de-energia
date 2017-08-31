<?php
Event::listen('bought_product',function($pch){
	Log::info('Noted purchase : Notify the God, or Push to the table which is fetched with ajax');
	// Log::info($pch->god->addNotice(""));
});

Event::listen('createProd',function($args){
	$user = $args[0];
	$p = $args[1];
	$msg = ($p->created_at.' : '.$p->name.' is created in category of '.$p->category .' of quality '.$p->quality.' , the funding time for the product is '.$p->FT.' minutes and its expiry time is '.$p->ET.' minutes. The available quantity is '.$p->total_shares.' each prices at '.$p->unit_price.'. This Product is  created by '.$user->username.'. <br>'.'God says about his product :'.$p->description);
	Event::fire('all_news',$msg);
	// Log::info($pch->god->addNotice(""));
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
	Log::info(' User '.$user->username.' got boosted by '.$fac.' now at LE '.$user->le);
});