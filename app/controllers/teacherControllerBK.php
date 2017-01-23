<?php

class teacherController extends \BaseController {
	
	public function addRole() {
		$all_roles =Config::get('preset.roles');
		$dept_roles =Config::get('preset.department_roles');
		$hostel_roles =Config::get('preset.hostel_roles');
		$qip_roles =Config::get('preset.qip_roles');
		$daysch_roles =Config::get('preset.daysch_roles');

		$u=Auth::user();
		if(!(Input::has('role') &&  array_search(Input::get('role'), $all_roles)>-1 && $u->teacher))return "invalid input";
		$role=Input::get('role');

		$curr_role=[];
		foreach($u->roles as $r)if($r->role==$role)$curr_role=$r;
		if($curr_role!=[])return array('status'=>'Role already exists!');

		$r=new Role();
		$r->user_id=$u->id;
		$r->role=$role;
		//special roles below-
		
		if(Input::has('domain_val')&& array_search($role, $dept_roles)>-1){
			$r->domain_field='department';
				$r->domain_val=Input::get('domain_val');//$u->teacher->department;
			}

			else if(Input::has('domain_val')&& array_search($role, $hostel_roles )>-1){
				$r->domain_field='hostel';
				$r->domain_val=Input::get('domain_val');
			}
			else if(array_search($role, $qip_roles )>-1){
				$r->domain_field='is_qip';
				$r->domain_val=1;//above column is checked for this value
			}
			else if(array_search($role, $daysch_roles )>-1){
				$r->domain_field='is_daysch';
				$r->domain_val=1;//above column is checked for this value
			}

			$r->save();
			return Redirect::route('panel_teacher');
		}

		public function approveStuds() {
			$u=Auth::user();
			$signfield=Config::get('preset.signfield');

			if(!($u->teacher && Input::has('studIDs','val','selected_role')))
				return array('status'=>'invalid input');
			$selected_role=Input::get('selected_role');
			$studIDs=Input::get('studIDs');
			$val=Input::get('val')>0?1:0;

			$curr_role=[];
			foreach($u->roles as $role)if($role->role==$selected_role)$curr_role=$role;
			if($curr_role==[])return array('status'=>'invalid role');

		//field the teacher would sign on signfield array
			$field = $signfield[$curr_role->role]; 

		//state change happens here.
			foreach ($studIDs as $id) {
				$l=Student::find($id);
				if($l){
					if($curr_role->role=='faculty'){
						$approv=$u->teacher->approvals()->where('student_id',$l->id)->first();
						if(count($approv)==0){
							//if no approval before
							$approv=new DeptApproval();
							$approv->teacher_id=$u->teacher->id;
							$approv->student_id=$l->id;
							$approv->approved=$val; $approv->save();
							// return array('status'=>'created new approval');
						}
						else if($approv->approved != $val){//if not already approved
							$approv->approved=$val;$approv->save();
						}
						//faculty count
						$l->$field = count($l->approvals()->where('approved','>','0')->get());
					}
					else {
						//general sign fields
						$l->$field=$val;
					}
					$l->save();
				}
			}
			return array('status'=>'Processed');
		}

		public function getStudList() {
//MVC pattern
		//common data
			$dept_roles =			Config::get('preset.department_roles');
			$hostel_roles =			Config::get('preset.hostel_roles');
			$qip_roles =			Config::get('preset.qip_roles');
			$daysch_roles =			Config::get('preset.daysch_roles');
			$table_fields=			Config::get('preset.table_fields');
			$signfield=				Config::get('preset.signfield');
			$checks=				Config::get('preset.checks');
			$err=array('alldomain_students'=>['Error in input Data !']); 
			$u=Auth::user();
//return array('approved_students'=>$u->deptroles,'rejected_students'=>$u->deptroles,'alldomain_students'=>$u->deptroles);

			if(!($u->teacher && Input::has('selected_role')))return $err;
			$selected_role=Input::get('selected_role');
			$fields=$checks[$selected_role];
			if(!$fields)return $err;

			$curr_role=[];
			foreach ($u->roles as $role)if($role->role==$selected_role)$curr_role=$role;
			if($curr_role==[])return array('alldomain_students'=>['Selected Role not found !'] );

		//also check for nonempty domain fields even for special roles, if it is so, give error

			$table_fields=array_merge([$signfield[$curr_role->role]],$table_fields);

//gather studlist to show
			$alldomain_studs=Student::all(); 
//faculty spl case - coz var no of facs per dept
			if($curr_role->role=='faculty'){
				// Log::info($curr_role);
				$alldomain_studs=Student::where($curr_role->domain_field,$curr_role->domain_val)->get($table_fields);
				$approved_students=$u->teacher->approvedstuds;
				$rejected_students=$u->teacher->rejstuds;

				return array('approved_students'=>$approved_students->toArray(),'rejected_students'=>$rejected_students->toArray(),'alldomain_students'=>$alldomain_studs->toArray(),'table_fields'=>$table_fields);
			}

//filterdown the list
			$spl_role=0;
		if(//can reduce a bit by array_merge
			(array_search($curr_role->role, $qip_roles) >-1  ||
				array_search($curr_role->role, $daysch_roles) >-1  ||
				array_search($curr_role->role, $dept_roles) >-1  ||
				array_search($curr_role->role, $hostel_roles )>-1 )
			&& $curr_role->domain_field && $curr_role->domain_val
			)
				$spl_role=1; //like a flag for repeated use

				if($spl_role==1)
					$alldomain_studs=
				Student::where($curr_role->domain_field,$curr_role->domain_val)->get($table_fields);

				$approved_studs=Student::where(function($q) use ($spl_role,$fields,$curr_role){
					if($spl_role==1)
						$q->where($curr_role->domain_field,$curr_role->domain_val);
					foreach ($fields as $field)
				//add faculty count here. only if it there in fields
						$q->where($field,'>',0);

				})->get($table_fields);

				$rejstuds=Student::where(function($q) use ($spl_role,$fields,$curr_role){
					if($spl_role==1)
						$q->where($curr_role->domain_field,$curr_role->domain_val);
					foreach ($fields as $field) 
					$q->where($field,'==',0); //make -1 later to distunguis from neutrals

			})->get($table_fields);

				return array('approved_students'=>$approved_studs->toArray(),'rejected_students'=>$rejstuds->toArray(),'alldomain_students'=>$alldomain_studs->toArray(),'table_fields'=>$table_fields);
			}


		}
