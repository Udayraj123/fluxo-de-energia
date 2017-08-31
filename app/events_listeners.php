<?php
Event::listen('bought_product',function($pch){
	Log::info('Noted purchase : Notify the God, or Push to the table which is fetched with ajax');
	// Log::info($pch->god->addNotice(""));
});

Event::listen('all_news',function($msg){
	$msg = '<div class="news"> '.$msg.'</div><br>';
	shell_exec('echo touch ~/fluxo-de-energia/public/news.txt');
	shell_exec('echo "'.$msg. '" >> ~/fluxo-de-energia/public/news.txt');
	// Log::info($pch->god->addNotice(""));
});