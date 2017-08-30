<?php
Event::listen('bought_product',function($pch){
	Log::info('Noted purchase : Notify the God, or Push to the table which is fetched with ajax');
	// Log::info($pch->god->addNotice(""));
});