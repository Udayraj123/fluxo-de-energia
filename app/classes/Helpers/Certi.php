<?php
namespace Helpers;
use PDF; use DB; use Auth;

Class Certi{
	public static function makecerti($user,$which){
		$cat = 'p';
		if($user->mode == 2){
            $resp = DB::table('results_2016_kv')->where('roll', $user->roll)->whereError(0)->first();
            if($resp){
                if($resp->rank<=5)
                    $cat = 'g';
                else if($resp->rank<=25)
                    $cat = 's';
            }
        }
        else{
            $resp = DB::table('results_2016')->where('roll', $user->roll)->whereError(0)->first();
            if($resp){
                if($resp->rank<=50)
                    $cat = 'g';
                else if($resp->rank<=250)
                    $cat = 's';
            }
        }
        $data = array('name' => $user->{'name'.$which}, 'rank' => $resp->rank, 'squad' => $user->squad, 'cat' => $cat);
        $pdf = PDF::loadView('user.certi',$data)->setPaper('a4', 'landscape');
        return $pdf;
		// return 'xyz';
	}
}