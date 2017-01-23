<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function createUser() {
		if(Input::has('username','password','type','full_name')){
			$type=Input::get('type');
			$username=Input::get('username');
			$u0=User::where('username',$username)->get();
			if(count($u0) != 0)
				return array('resp'=>"Username Already exists $u0");

			$u=new User();
			$u->username=Input::get('username');
			$u->password=Hash::make(Input::get('password'));
			$u->type=$type;
			$u->save(); 

//student
			if($type=='student'){
				if(Input::has('full_name', 'roll', 'department', 'hostel', 'ac_no')){
				//take full_name, roll, department, hostel, ac_no
					$s = new Student();
					$s->user_id=$u->id;
					$s->full_name=Input::get('full_name');
					$s->roll=Input::get('roll');
					$s->department=Input::get('department');
					$s->hostel=Input::get('hostel');
					$s->ac_no=Input::get('ac_no');
					$s->save();
				}
			}
//teacher
			else if($type=='teacher'){
				if(Input::has('full_name','department')){
				//take full name, then add roles
					$t=new Teacher();
					$t->user_id=$u->id;
					$t->full_name=Input::get('full_name');
					$t->department=Input::get('department'); //no use so far
					$t->save();
				}
			}
			else return array('resp'=>"error in user type");
				return array('resp'=>'Created. Now Login');
		}
		return array('resp'=>'Invalid Input');
	}

	public function login()
	{
		if (Input::has('username','password') && Auth::attempt(array('username' =>Input::get('username'), 'password' => Input::get('password')),true)){
			$user=Auth::user();			
			if($user->student)
				return Redirect::route('panel_student');
			else if($user->teacher)
				return Redirect::route('panel_teacher');
			else if($user->admin)
				return Redirect::route('panel_admin');
			else return View::make('login')->with('errors',['No student/teacher linked to user']);
		}
		else {        
			return View::make('login')->with('errors',["Wrong Credentials"]);
		}
	}

}
