<?php
class students extends Seeder {
	public function run(){
		DB::table('students')->truncate();
		
		$rollN=9; $acN=15;
		$admin_names=Config::get('preset.admin_names');
		$teacher_names=Config::get('preset.teacher_names');
		$student_names=Config::get('preset.student_names');
		$departments=Config::get('preset.departments');
		$hostels=Config::get('preset.hostels');
		$modN=count($student_names);$modD=count($departments);
		$modA=count($admin_names); 
		$modT=count($teacher_names);
		$start=$modA+$modT;
		$n=$modN;
		$dummies=[];
		for($i=0;$i<$n;$i++){
			$dummy=[];
			$dummy['user_id']=$i+1+$start;
			$dummy['full_name']=$student_names[$i%$modN];
			$dummy['department']=$departments[$i%$modD];
			$dummy['hostel']=$hostels[$i%$modD];
			$dummy['roll' ]= 1300*pow(10,$rollN-4) + rand(pow(10,$rollN-4),pow(10,$rollN-4+1));
			$dummy['ac_no']= rand(pow(10,$acN),pow(10,$acN+1));
			array_push($dummies, $dummy);
		}

		DB::table('students')->insert($dummies);
	}
}