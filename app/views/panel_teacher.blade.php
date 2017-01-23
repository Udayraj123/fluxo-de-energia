@extends('master')

@section('headContent')
<title>
  Faculty Panel | NoDuesApp
</title>
@endsection
@section('bodyContent')
<script type="text/javascript">
  function updateTable(role_id){
    selected_role=document.getElementById(role_id).value;
    $.ajax({
      'url':"{{URL::route('getStudList')}}",
      'method':"post",
      'data': {'selected_role':selected_role},
      'success':function(data){
        console.log(data['alldomain_students']);
        console.log(data['table_fields2']);
      // insertSelTable(data['approved_students'],'data_table',role_id,data['table_fields'],data['table_fields2']);
      insertSelTable(1,data['alldomain_students'],'data_table',role_id,data['table_fields'],data['table_fields2']);
      insertSelTable(1,data['approved_students'],'data_table2',role_id,data['table_fields'],data['table_fields2']);
      insertSelTable(1,data['rejected_students'],'data_table3',role_id,data['table_fields'],data['table_fields2']);
    }
  });
  }

</script>
<div align="right"> <a href="{{URL::route('login')}}">Logout</a> </div>

<div class="box box-solid">
  <div class="box-header with-border">
    <h3 class="box-title">Name : {{{ Auth::user()->teacher->full_name }}}</h3></div>
    <h4 class="box-title">Select A Role</h4></div>
    <div style="display: block;" class="box-body no-padding">
      <ul class="nav nav-pills">
        @foreach(Auth::user()->roles as $r)
        <li><label class="text-primary" style="min-width:100px;">
          <input type="radio" name="selected_role" id="{{$r->role}}" onclick="updateTable(this.id)" value="{{$r->role}}"> 
          <a class="btn btn-info">
        {{$r->role}}, {{$r->domain_val}} {{$r->domain_field}} 
          </a>
        </input>
      </label></li>
      @endforeach
    </ul>
  </div>
  <!-- /.box-body -->
</div>

<div><h3>All student requests</h3>
  <div id="data_table" align="center"> <hr><span class="btn-block text-muted ">Please select a role above</span> </div>
</div>
<div><h3>Approved Student requests</h3>
  <div id="data_table2" align="center"><hr><span class="btn-block text-muted ">Please select a role above</span></div>
</div>
<div><h3>Rejected Student requests</h3>
  <div id="data_table3" align="center"><hr><span class="btn-block text-muted ">Please select a role above</span></div>
</div>
@endsection
