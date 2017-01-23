@extends('master')

@section('headContent')
<title>
Create User
</title>
@endsection

@section('bodyContent')
<script type="text/javascript">
	A=['roll','hostel','ac_no'];
	function toggleInputs(){
		console.log('g');
		x=document.getElementById('type');
		if(x.value!="student"){
			for(i=0;i<A.length;i++)
				document.getElementById(A[i]).disabled="true";
		}
		else{
			for(i=0;i<A.length;i++)
				document.getElementById(A[i]).removeAttribute('disabled');	
		}
	}
	function SUBMIT(){
		x=document.getElementsByTagName('input');
		var data={};
		for(i=0;i<x.length;i++){
			data[x[i].name.toString()]=x[i].value;
		}
		$.ajax({
			'url': "{{ URL::route('createUser') }}",
			'method': "POST",
			'data': data,
			'success':function( resp) {
				alert(resp['resp']);
			}
		});
	}
</script>
<pre>
Create User
	{{Form::open(array('url'=>route("createUser"))) }}
		I am a <select name="type" id="type" onmouseup="toggleInputs()">
		<option value="student" >student</option>
		<option value="teacher" >teacher</option>
	</select>

	Username:  <input type="text" name="username" id="username" value="{{ $val or 'user' }}"> </input>
	Password:  <input type="password"  name="password" id="password" value="CSE"></input>
	full_name: <input type="text" name="full_name" id="full_name" value="{{ $val or 'userfullname' }}"> </input>
	
	<select name="department" id="department" onmouseup="toggleInputs()">
		@foreach(Config::get('preset.departments') as $r)
		<option value="{{$r}}">{{$r}}</option>
		@endforeach
	</select>

	<select name="hostel" id="hostel" onmouseup="toggleInputs()">
		@foreach(Config::get('preset.hostels') as $r)
		<option value="{{$r}}">{{$r}}</option>
		@endforeach
	</select>

	roll: <input type="number" name="roll" id="roll" value=""> </input>
	ac_no: <input type='number' name='ac_no' id='ac_no'></input>

	<button onclick="SUBMIT()"  name="Create">Create</button> 	

	<!-- <button  name="Create" onclick="newUser()">Create</button> -->
	{{Form::close()}}
</pre>
@endsection
