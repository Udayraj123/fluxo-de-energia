<?php
class admins extends Seeder {
	public function run(){
		DB::table('admins')->truncate();
		$admin_names=Config::get('preset.admin_names');
		$modN=count($admin_names);
		$start=0;
		$dummies=[];
		for($i=$start;$i<$start+$modN;$i++){
			$dummy=[];
			$dummy['user_id']=$i+1;
			$dummy['full_name']=$admin_names[$i%$modN];
			array_push($dummies, $dummy);
		}

		DB::table('admins')->insert($dummies);
	}
}