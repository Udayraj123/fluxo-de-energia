<?php
class approvals extends Seeder {
	public function run(){
		DB::table('approvals')->truncate(); //delete & reset counter
		$time=date('Y-m-d H:m:s');
		foreach (Student::all() as $s)
			foreach (Teacher::where('department',$s->department)->get() as $t){
				//add default faculty approvals as 0
				DB::table('approvals')->insert(array(
					'student_id'=>$s->id,
					'teacher_id'=>$t->id,
					'teacher_name'=>$t->full_name,
					'student_name'=>$s->full_name,
					'role'=>'faculty',
					'domain_field'=>'department',
					'domain_val'=>$s->department,
					'created_at'=>$time,
					'updated_at'=>$time,
					));
			}			
		}
	}