<?php
namespace Helpers;
use PDF; use DB; use Auth; //aliases expand them

Class Functions{
    static private $array = array();

    public static function add($data){
        echo "the data is : ";
        array_push(self::$array,$data);
        print_r(self::$array);
		// return 'xyz';
    }

    public function test(){
        return count(self::$array);
    }
}