<?php

class teacherController extends \BaseController {
	public function toList($variable,$table_fields){//in sequence of the fields
		$arr=[]; foreach ($table_fields as $key) array_push($arr, $variable[$key]); return $arr;
	}

	public function err($text) {
		return array('approved_students'=>$text, 'rejected_students'=>$text, 'alldomain_students'=>$text, 'table_fields'=>$text, 'table_fields2'=>$text, );
	}

	public function approveStuds() {
		$u=Auth::user();
		$signfield=Config::get('preset.signfield');

		if(!($u->teacher && Input::has('studIDs','val','selected_role')))
			return array('status'=>'invalid input');
		$t=$u->teacher;
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
					// if($curr_role->role=='faculty'){
				$approv=$t->approvals()
				->where('role',$curr_role->role)
				->where('domain_field',$curr_role->domain_field)
				->where('domain_val',$curr_role->domain_val)
				->where('student_id',$l->id)
				->first();

						if(count($approv)==0){//if no approval before
							$approv=new Approval();
							$approv->approved=$val; 
							$approv->teacher_name=$t->full_name;
							$approv->student_name=$l->full_name;
							$approv->teacher_id=$t->id;
							$approv->student_id=$l->id;
							$approv->role=$curr_role->role;
							$approv->domain_field=$curr_role->domain_field;
							$approv->domain_val=$curr_role->domain_val;
							$approv->save();
						}
						else //if($approv->approved != $val)
						//if not already approved, maybe increase counter here if req
						$approv->approved=$val;$approv->save();
						$l->$field=$val;
						$l->save();
					}
				}
				return array('status'=>'Processed');
			}

			public function getStudList() {
//MVC pattern
		//common data
				$spl_roles =			Config::get('preset.spl_roles');
				$table_fields=			Config::get('preset.table_fields');
				$stud_headers=			Config::get('preset.stud_headers');
				$signfield=				Config::get('preset.signfield');
				$checks=				Config::get('preset.checks');

				$err=$this->err(['Error in input Data !']);	
				$u=Auth::user();
				if(!($u->teacher && Input::has('selected_role')))return $err;
				$selected_role=Input::get('selected_role');
				$t=$u->teacher;
				$fields=$checks[$selected_role];
				if(!$fields)return $err;

				$curr_role=[];
				foreach ($u->roles as $role)if($role->role==$selected_role)$curr_role=$role;
				if($curr_role==[])return $this->err(['Selected Role not found !']);
				
				//gather studlist to show
				$sign = $signfield[$curr_role->role];
				$table_fields=array_merge([$sign],$table_fields);
				$stud_headers=array_merge([$stud_headers[$sign]],$stud_headers);
				$table_fields2=$this->toList($stud_headers,$table_fields);

				$q1=Student::where('id','>',0);
				if(array_search($curr_role->role, $spl_roles)>-1
					&& $curr_role->domain_field && $curr_role->domain_val)
					$q1=$q1->where($curr_role->domain_field,$curr_role->domain_val);
			//The hierarchy for approvals applied
				foreach ($fields as $field)
					$q1->where($field,'>',0);
				$alldomain_studs=$q1->get($table_fields);

				//personally approved students
				$approved_students=$u->teacher->approvalstuds()
				->where('role',$curr_role->role)
				->where('domain_field',$curr_role->domain_field)
				->where('domain_val',$curr_role->domain_val)
				->where('approved','>','0')->get();
				//personally rejected students
				$rejected_students=$u->teacher->approvalstuds()
				->where('role',$curr_role->role)
				->where('domain_field',$curr_role->domain_field)
				->where('domain_val',$curr_role->domain_val)
				->where('approved','<=','0')->get();

				return array('approved_students'=>$approved_students->toArray(),'rejected_students'=>$rejected_students->toArray(),'alldomain_students'=>$alldomain_studs->toArray(),'table_fields'=>$table_fields,'table_fields2'=>$table_fields2); 
			}
		}
