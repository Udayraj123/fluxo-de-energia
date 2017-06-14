<?php
namespace Helpers;
use \App\Models;
use C,User,Common,Log,Session;

class Helper
{
	public static function getShortName($name){
		$words = explode(' ', $name);
		$extra = array_key_exists(1, $words)?($words[1][0].'.'):'';
		return $words[0][0].'.'.$extra; 
	}
}