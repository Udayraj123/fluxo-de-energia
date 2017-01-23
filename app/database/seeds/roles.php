<?php
class roles extends Seeder {
	public function run(){
		DB::table('roles')->truncate();
		$tc=10;
		$hc=3;
		$time=date('Y-m-d H:m:s');
		$non_fac_dept =			Config::get('preset.non_fac_dept');
		$hostel_roles=Config::get('preset.hostel_roles');
		$hostels=Config::get('preset.hostels');
		$other_roles=Config::get('preset.other_roles');
		$modR=count($non_fac_dept);
		$modH=count($hostel_roles);
		$modHs=count($hostels);
		$modO=count($other_roles);
		foreach (Teacher::all() as $counter=>$t){
			//everyone is a faculty in the dummy data
			DB::table('roles')->insert(array(
				'user_id'=>$t->user->id,
				'role'=>'faculty',
				'domain_field'=>'department',
				'domain_val'=>$t->department,
				'created_at'=>$time,
				'updated_at'=>$time,
				));

			//department roles
			if($counter < $tc){
				DB::table('roles')->insert(array(
					'user_id'=>$t->user->id,
					'role'=>$non_fac_dept[$counter%$modR],
					'domain_field'=>'department',
					'domain_val'=>$t->department,
					'created_at'=>$time,
					'updated_at'=>$time,
					));
			}
			//hostel roles
			else if ($counter < $tc+$hc){
				DB::table('roles')->insert(array(
					'user_id'=>$t->user->id,
					'role'=>$hostel_roles[$counter%$modH],
					'domain_field'=>'hostel',
					'domain_val'=>$hostels[$counter%$modHs],
					'created_at'=>$time,
					'updated_at'=>$time,
					));
			}
			//other roles
			else {
				DB::table('roles')->insert(array(
					'user_id'=>$t->user->id,
					'role'=>$other_roles[$counter%$modO],
					'created_at'=>$time,
					'updated_at'=>$time,
					));
			}
		};

	}
}
