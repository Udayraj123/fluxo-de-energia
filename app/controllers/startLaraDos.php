<?php
/*
Admin.php
TODO : 
26 Nov 
	-Role names front end names
	-Faculty array for hod visiblity, admin panel control to maintain teachers array
	Done- Approval Status rules
	Done - Stud self forms
	Done - $t->approvals should show role & domain_field etc
	Done - Header names for signfields for teacher, for student.
	Done - Admin page to assign a role to a fac

Done>> NOW JUST MAKE VALIDATOR FOR THE STUD
	- all one except
	- is_qip && qip_coord
	- warden || is_daysch && daysch_affairs

>>> So now to make dept_approvals into approvals -
	-added the role,domain_field,domain_val,full_name to it
		-but this can cause incorrect data if stud id is changed or so.
	-test for $t->approvals, 
	**can't be in model as selected role depends
>>>Done. This is assuming that between a student and a specific role, there is only one approval
>> But then a faculty CSE dept role is very general, also then By field doesn't seem to be valid. Though it should be present for other roles.
	-KiM that in code its not a problem, as it is checked by teacher_id too in $t->approvals()


>Shall I add a oth_approvals table ? This eases the Signed by field.Also In case a teacher changes the role later, we'd see who had signed before and new name wont come there
	-then WHY NOT ADD APPROVALS TABLE DIRECTLY ?
		-then teacher->approvedstuds will work !
		-can also conveniently have a comments column there

> Add 3 tabs to see approved, rejected, all students
>>Test well the approvals list
	-that was checks, now also filter by signfield!

//in ShowStuds check for nonempty domain fields even for special roles, if it is so, give error
//currently if same role comes multiples, the most recent one will be taken up
> Select All button in stud list

>Can move roles to teachers. So that getting teacher name will be fool proof

>QIP students shall BE VISIBLE to normal roles/hods ? ANy such restriction on Day scholars ?
	-> currently only add limit to qip_coord who will see only is_QIP students
>"Create student" shall have is_qip & is_daysch option
	-> it will be there in student panel just like add role
> make Display array to replace frontend Text

>>TRY :
	- make appr use of $u->dept_roles (by whereIn call)
		> Think about using alias for frequent stuff
	- filter function,
	- where calls in Models
	-THis : :
				$k=$f2->fruits()->select('quality_factor','id');
				$k2=$f2->purchases;
				foreach ($k2 as $iterator_key => $kp) {
					$k3=$kp->fruits();
					print_r($k3->lists('id'));
					echo "<BR>$iterator_key<BR>";
				}

>> NEWS
 - HOD checks has to have approval from all faculties of the department (28 in CSE)
 	-This obv cannot be put in columns of the student.
 	Have a table of dept faculty members' approvals : fac_id stud_id department approved (28 * 80 entries for CSE) 
 		-> so it'd be better to have a separate tab for checking approvals from each faculty,
 		- so have a DeptFac model, student->dept_facs shall return the approvals list, teacher->dept_studs shall return all dept students with their approval status.

 		- but then is it not ok to have requests table for every request ?
 			-> No, running a NoDues sequence check for a student will be tough.
				-is it ? we can have a signfield name in the table, this makes it equally easy, plus role_name can also be added

 			-> It is clear that this is an extension of the Nodues form, so have a new model !
		- hod_filter, apart from nonzero checks, this can be added as a 'special case'

--> added condition to check if role already exists, then override it (as to edit the domain_val field)


//Auth attempt already hashes the password to match with entry //New user entry = //User::create(array('username'=>$username,'password'=>Hash::make($password)));

What all roles are involved here -
// Now there will be one function that shows all students -> that Tick mark table
		//But this function will have a parameter $role, which will pass into 
		//$domains array, giving the domain to show.
		//also the $checks array, giving which fields should already be 1.
		//

 dept wise
 	-hod 	=> dept_hod
 	-dept_librarian =>	'dept_lib'
 	-lab_supervisor1 => lab1
 	-lab_supervisor2 => lab2
 	-lab_supervisor3 => lab3

DOUBTS UNKNOWNS => 'dept_office' //the e-bound thesis,
 'Ast Reg vs Ast Acad Reg', 'dept nodues'

 	-'supervisor_guide' =>supervisor_guide

hostel wise
	-caretaker  =>caretaker
	-warden 	=>warden

all
	-dy_librarian,ast_librarian,librarian	'dy_ast_librarian'
	-'stud_affairs'=>'stud_affairs','hostel_stud_affairs',
	-'comp_centre'=>'comp_centre'
	-'mech_workshop'=>'mech_workshop'
	-dy_account_sec,ast_account_sec,account_sec=>'dy_ast_account_sec'
	-dy_acad_reg,ast_acad_reg,acad_reg=>'dy_ast_acad_reg'

>whether these submitted, then get sign of dept_office 
$table->tinyInteger('bound_copy')->default('0'); $table->tinyInteger('electronic_copy')->default('0');
*/



laraStartDos
KIMS-
js injection is not escaped in views - {{ $auther->name }} => {{ HTML::entities($auther->name) }} or shorthand {{ e($auther->name) }} 

migration points 
- make DB without SQL, only PHP
- version control easy - the UP & DOWN method
-> create Tables - Schema::create
-> add To Tables - 
DB::table('teachers')->insert(array(
'name'=>'Santosh Biswas',
'department'=>'CSE',
'created_at'=>date('Y-m-d H:m:s')
'updated_at'=>date('Y-m-d H:m:s')
));
-> everything sql does


KIMs for migrations
-do not manually delete the migration files, causes prob in rollbacks
-

> setup database
	- Access Denied for user root @localhost => enter correct details in database.php
	- use migrate:install, 
	- php artisan migrate:make create_users_table (the name can be ANYTHING )
		-then after use Schema builder inside the up() method 

	-finally run php artisan migrate
		-if gives Nothing to migrate, maybe u refreshed it.

	- prefer mysql workbench for later stuff
> setup controllers
	- php artisan controller:make <Name>
> setup models
	- Enter




NEW COOLS-
Using new Teacher(Input::all()) safely
-> in Teacher model, add a parameter - 
public static $accessible = array('name','department'); //which will allow only these fields to be manipulated.
https://www.youtube.com/watch?v=kVbPdLvLxUQ&list=PL09BB956FCFB5C5FD&index=10