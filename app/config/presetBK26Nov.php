<?php
$non_fac_dept = [
'hod',
'dept_librarian',
'lab_supervisor1',
'lab_supervisor2',
'lab_supervisor3',
'dept_thesis'];

//still these names need to be updated at about 4 places
$other_roles=[
'stud_affairs',
'supervisor_guide',//would have a dept
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
];

$dept_roles = array_merge(['faculty'],$non_fac_dept);
$hostel_roles=['caretaker','warden'];
$qip_roles=['qip_coord'];
$daysch_roles=['daysch_affairs'];
$spl_roles=array_merge($dept_roles,$hostel_roles,$qip_roles,$daysch_roles);
$roles=array_merge($spl_roles,$other_roles);
$teacher_names=[
'Santosh Biswas',
'Chandan Karfa',
'Tony Jacob',
'Amit Awekar',
'Arijit Sur',
'Arnab Sarkar',
'Aryabartta Sahu',
'Ashish Anand',
'Benny George K',
'Deepanjan Kesh',
'Diganta Goswami',
'G. Sajith',
'Gautam Barua',
'Hemangee K. Kapoor',
'Jatindra Kumar Deka',
'John Jose',
'Pinaki Mitra',
'Pradip Kr. Das',
'Purandar Bhaduri',
'R. Inkulu',
'Rashmi Dutta Baruah',
'S. V. Rao',
'Samit Bhattacharya',
'Sanasam Ranbir Singh',
'Shivashankar B. Nair',
'Sukumar Nandi',
'Sushanta Karmakar',
'T. Venkatesh',
'V. Vijaya Saradhi',
];
$admin_names=array(
	'admin',
	'Santosh Biswas',
	);
$student_names=array(
	'Udayraj',
	'Anurag',
	'Ayush',
	'Gurudev',
	'Mukul'
	);
return [
'teacher_names'=>$teacher_names,
'student_names'=>$student_names,
'admin_names'=>$admin_names,
'names'=>array_merge($teacher_names,$student_names),
'types'=>['teacher','student'],
'hostels'=>['KAPILI','KAMENG','SIANG','MANAS','BARAK','UMIAM','DHANSIRI','SUBANSIRI','BRAHMAPUTRA','DIHING'],
'departments'=>['CSE','CST','CL','EE','EP','ME','MNC'],
'table_fields'=>['id','roll','full_name','department','hostel','ac_no','is_qip','is_daysch'],
'table_fields2'=>['id','teacher_name','role','domain_val','domain_field','created_at'],
'approval_headers'=>array(
	'student_name'=>'Student Name',
	'teacher_name'=>'Teacher Name',
	'domain_field'=>'Domain',
	'domain_val'=>'Details',
	'student_id'=>'Student_id',
	'teacher_id'=>'Teacher_id',
	'approved'=>'Approval Status',
	),
'stud_headers'=>array(
	'id'=>'Id',
	'roll'=>'Roll',
	'full_name'=>'Full_name',
	'department'=>'Department',
	'hostel'=>'Hostel',
	'ac_no'=>'Ac_no',
	'is_qip'=>'Is_qip',
	'is_daysch'=>'Is_daysch',
	),

//role is to field relation
'signfield'=>array(
	'stud_affairs'=>'stud_affairs',
	// for Day Scholar student approvals - 
	'daysch_affairs'=>'daysch_affairs', 
	'faculty' 	=> 'faculty',
	'hod' 	=> 'hod',
	'dept_librarian' =>	'dept_lib',
	'lab_supervisor1' => 'lab1',
	'lab_supervisor2' => 'lab2',
	'lab_supervisor3' => 'lab3',
	'dept_thesis' => 'dept_thesis',
	'supervisor_guide' =>'supervisor_guide',
	'caretaker'  =>'caretaker',
	'warden' 	=>'warden',
	'dy_librarian' => 'dy_ast_librarian',
	'ast_librarian' => 'dy_ast_librarian',
	'librarian'	=>'dy_ast_librarian',
	'cc_incharge'=>'cc_incharge',
	'mech_workshop'=>'mech_workshop',
	'dy_account_sec'=>'dy_ast_account_sec',
	'ast_account_sec'=>'dy_ast_account_sec',
	'account_sec' =>'dy_ast_account_sec',
	'dy_acad_reg'=>'dy_ast_acad_reg',
	'ast_acad_reg'=>'dy_ast_acad_reg',
	'acad_reg'=>'dy_ast_acad_reg',
	'gymkhana'=>'gymkhana',
	'qip_coord'=>'qip_coord',
	'lib_thesis'=>'lib_thesis'
	),

'approval_fields'=>array(
	'string'=>['student_name','teacher_name','domain_field','domain_val'],
	'integer'=>['student_id','teacher_id'],
	'tinyinteger'=>['approved',]
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
	'faculty',
	'dept_thesis',
	'supervisor_guide',
	'lib_thesis',
	'dy_ast_librarian',
	'caretaker',
	'warden',
	'cc_incharge',
	'cc_online',
	'mech_workshop',
	'stud_affairs',
	'dy_ast_account_sec',
	'is_daysch',
	'daysch_affairs', //actually this is stud affair's role
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
	'faculty' =>	['id'],
	'dept_librarian' =>	['id'],
	'lab_supervisor1' => ['id'],
	'lab_supervisor2' => ['id'],
	'lab_supervisor3' => ['id'],
			//for dept thesis
	'dept_thesis' => ['id'],
	'mech_workshop'=>['id'],

	//All level4
	'hod' 	=> ['dept_lib','lab1','lab2','lab3','dept_thesis','mech_workshop','faculty'],
	//All level5
	'account_sec' =>['hod'],'dy_account_sec'=>['hod'],'ast_account_sec'=>['hod'],

//others
	'supervisor_guide' =>['id'],
	'stud_affairs'=>['id'],
	'qip_coord'=>['id'],
	'daysch_affairs'=>['id'], //day scholar

	),

'non_fac_dept'=>$non_fac_dept,
'department_roles'=>$dept_roles,
'hostel_roles'=>$hostel_roles,
'qip_roles'=>$qip_roles,
'daysch_roles'=>$daysch_roles,
'other_roles'=>$other_roles,
'spl_roles'=>$spl_roles,
'roles'=>$roles,


];
?>