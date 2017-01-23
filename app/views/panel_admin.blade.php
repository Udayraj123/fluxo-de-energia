@extends('master')

@section('headContent')
<title>
  Admin Panel | NoDuesApp
</title>
@endsection

@section('bodyContent')
<!-- Admin panel :  -->
{{Form::open(array('url'=>route("addRole"))) }}
<pre>
Add a role :

Select Person:            : <select name="sel_faculty" id="sel_faculty">
@foreach(Teacher::all() as $r)
<option value="{{$r->id}}">{{$r->full_name}}</option>
@endforeach
</select>

Select Role:              : <select name="role" id="role">
@foreach(Config::get('preset.roles') as $r)
<option value="{{$r}}">{{$r}}</option>
@endforeach
</select>

Hostel    (if applicable) : <select name="domain_val" id="domain_val">
@foreach(Config::get('preset.hostels') as $r)
<option value="{{$r}}">{{$r}}</option>
@endforeach
</select>

Department(if applicable) : <select name="domain_val2" id="domain_val2">
@foreach(Config::get('preset.departments') as $r)
<option value="{{$r}}">{{$r}}</option>
@endforeach
</select>

<input type="submit"  name="Submit" value="SUBMIT"/>
{{Form::close()}}      
</pre>
@endsection
