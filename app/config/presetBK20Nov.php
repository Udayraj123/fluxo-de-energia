<?php
return [
'names'=>array(
	'Santosh Biswas',
	'Chandan Karfa',
	'Tony Jacob',
	'Santosh',
	'Chandan',
	'Tony'
	),
'types'=>array('teacher','student'),
'hostels'=>['KAPILI','KAMENG','SIANG','MANAS','BARAK','UMIAM','DHANSIRI','SUBANSIRI','BRAHMAPUTRA','DIHING'],
'departments'=>['CSE','CST','MNC','EE'],
'department_roles'=>['hod','dept_librarian','lab_supervisor1','lab_supervisor2','lab_supervisor3','dept_thesis'],
'hostel_roles'=>['caretaker','warden'],
'is_qip_roles'=>['qip_coord'],
'table_fields'=>['full_name','roll','ac_no','is_qip','is_day_scholar'],
'roles'=>array(
	'stud_affairs',
	'hod',
	'dept_librarian',
	'lab_supervisor1',
	'lab_supervisor2',
	'lab_supervisor3',
	'dept_thesis',
	'supervisor_guide',
	'caretaker',
	'warden',
	'lib_thesis',
	'dy_librarian',
	'ast_librarian',
	'librarian',
	'cc_incharge',
	'mech_workshop',
	'dy_account_sec',
	'ast_account_sec',
	'account_sec',
	'dy_acad_reg',
	'ast_acad_reg',
	'acad_reg',
	'gymkhana',
	'qip_coord',
	),

'signfields'=>array(
	'role' => ['list','of','fields','in student table'],
	'stud_affairs'=>['stud_affairs','hostel_stud_affairs'],
	'hod' 	=> ['hod'],
	'dept_librarian' =>	['dept_lib'],
	'lab_supervisor1' => ['lab1'],
	'lab_supervisor2' => ['lab2'],
	'lab_supervisor3' => ['lab3'],
	'dept_thesis' => ['dept_thesis'],
	'supervisor_guide' =>['supervisor_guide'],
	'caretaker'  =>['caretaker'],
	'warden' 	=>['warden'],
	'dy_librarian' => ['dy_ast_librarian'],
	'ast_librarian' => ['dy_ast_librarian'],
	'librarian'	=>['dy_ast_librarian'],
	'cc_incharge'=>['cc_incharge'],
	'mech_workshop'=>['mech_workshop'],
	'dy_account_sec'=>['dy_ast_account_sec'],
	'ast_account_sec'=>['dy_ast_account_sec'],
	'account_sec' =>['dy_ast_account_sec'],
	'dy_acad_reg'=>['dy_ast_acad_reg'],
	'ast_acad_reg'=>['dy_ast_acad_reg'],
	'acad_reg'=>['dy_ast_acad_reg'],
	'gymkhana'=>['gymkhana'],
	'qip_coord'=>['qip_coord'],
	'lib_thesis'=>['lib_thesis']
	),

'studfields'=>array(
	'string'=>['full_name'],
	'integer'=>['user_id','roll'],
	'bigInteger'=>['ac_no'],
	'tinyinteger'=>[
	'lab1',
	'lab2',
	'lab3',
	'dept_lib',
	'hod',
	'dept_thesis',
	'supervisor_guide',
	'lib_thesis',
	'dy_ast_librarian',
	'is_day_scholar',
	'hostel_stud_affairs',
	'caretaker',
	'warden',
	'cc_incharge',
	'cc_online',
	'mech_workshop',
	'stud_affairs',
	'dy_ast_account_sec',
	'is_qip',
	'qip_coord',
	'stud_signature',
	'dy_ast_acad_reg'
	],
	),

'checks'=>array(
	'role' => ['fields','to be checked nonzero'],
	//A
	//level1 - no checks => check if id > 0
	'caretaker'  =>['id'],
	//level2
	'warden' 	=>['caretaker'],
	
	//B
	//level1
	'gymkhana'=>['id'],
	//A+B level3
	'ast_acad_reg'=>['gymkhana','warden'],'dy_acad_reg'=>['gymkhana','warden'],'acad_reg'=>['gymkhana','warden'],

	//C
	//level1
	'lib_thesis'=>['id'],
	//level2
	'librarian'	=>['lib_thesis'],'dy_librarian' => ['lib_thesis'],'ast_librarian' => ['lib_thesis'],
	
	//D
	//level1
	'cc_online'=>['id'],
	//level2
	'cc_incharge'=>['cc_online'],

	//E
	'dept_librarian' =>	['id'],
	'lab_supervisor1' => ['id'],
	'lab_supervisor2' => ['id'],
	'lab_supervisor3' => ['id'],
			//for dept thesis
	'dept_thesis' => ['id'],
	'mech_workshop'=>['id'],

	//All level4
	'hod' 	=> ['dept_lib','lab1','lab2','lab3','dept_thesis','mech_workshop'],
	//All level5
	'account_sec' =>['hod'],'dy_account_sec'=>['hod'],'ast_account_sec'=>['hod'],

//others
	'supervisor_guide' =>['id'],
	'stud_affairs'=>['id'],
	'qip_coord'=>['id'],

	),
];
?>