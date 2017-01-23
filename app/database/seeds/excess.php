<?php
$departments=Config::get('preset.departments');
$hostels=Config::get('preset.hostels');
$time=date('Y-m-d H:m:s');

$roles=Config::get('preset.roles');
$modR=count($roles);
$modH=count($hostels); 
 $modD=count($departments);
$dummies=[];
$start=0;
$n=10;
for($i=0;$i<$n;$i++){
	$dummy=[];
	$dummy['user_id']=$i+1+$start;
	$dummy['role']=$roles[$i%$modR];

	//this is incorrect data, but the program should handle it;
	if($roles[$i%$modR] != 'caretaker' || $roles[$i%$modR] != 'warden'){
		$dummy['domain_field']='department';
		$dummy['domain_val']=$departments[$i%$modD];
	}
	else{
		$dummy['domain_field']='hostel';
		$dummy['domain_val']=$hostels[$i%$modD];
	}
	array_push($dummies, $dummy);
}