
<?php

class studentController extends \BaseController {
	public function toList($variable,$table_fields){//in sequence of the fields
		$arr=[]; foreach ($table_fields as $key) array_push($arr, $variable[$key]); return $arr;
	}
	public function panel_student() {
		$user=Auth::user();
		$student=$user->student;
		return View::make('panel_student');
	}
	
	public function status() {
		$user=Auth::user();
		$one_fields=Config::get('preset.one_fields');;
		$s=$user->student;
		$status=1;
		foreach ($one_fields as $f)
			if($s->$f <= 0)$status=0;
		if(!($s->warden || ($s->daysch==1 && $s->daysch_affairs==1)))$status=0;

//hod to check all faculty of dept

		return $status?'<span class="text-success">Approved </span>':'Yet to be Approved';
	}

	public function getApprList() {
		$u=Auth::user();
		$s=$u->student;
		$err=array('status'=>$this->status(),'approvals'=>[['id'=>'empty','empty'=>'No rejections/approvals!']],'table_fields'=>['empty'],'table_fields2'=>['empty']); 
		if(!($u->student && Input::has('selected_type')))return $err;
		$type=Input::get('selected_type');
		if(!(array_search($type,['approvals','rejections','self_details'])>-1))return $err;
		//might need - 
		$table_stud_fields1=Config::get('preset.table_stud_fields1');
		$table_stud_fields2=Config::get('preset.table_stud_fields2');
		$stud_headers=Config::get('preset.stud_headers');
		$signfield=Config::get('preset.signfield');

		//add type to see dept teacher list & self fields 

		$fields=Config::get('preset.table_fields2');
		$table_fields2=$this->toList(Config::get('preset.approval_headers'),$fields);

		if($type=='self_details'){
			//here we'd send only student name			
			$table_fields2=$this->toList($stud_headers,$table_stud_fields2);	
			return array('status'=>$this->status(),'approvals'=>$u->student()->get($table_stud_fields2),'table_fields'=>$table_stud_fields2,'table_fields2'=>$table_fields2);
		}

		$approvals=$s->$type;
		// if(!$approvals) return $err;
		return array('status'=>$this->status(),'approvals'=>$approvals,'table_fields'=>$fields,'table_fields2'=>$table_fields2); 
	}
}
