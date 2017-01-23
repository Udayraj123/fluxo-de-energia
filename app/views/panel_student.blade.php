@extends('master')

@section('headContent')
<title>
  Student Panel | NoDuesApp
</title>
@endsection

@section('bodyContent')
<script type="text/javascript">
  function updateTable(role_id){
    selected_type=document.getElementById(role_id).value;
    // alert(selected_type);
    $.ajax({
      'url':"{{URL::route('getApprList')}}",
      'method':"post",
      'data': {'selected_type':selected_type},
      'success':function(data){
        // console.log(data);
        $('#status').html(data['status']);
        if(selected_type=='self_details')
          insertVertTable(0,data['approvals'],'data_table',role_id,data['table_fields'],data['table_fields2']);
        else 
          insertStudTable(0,data['approvals'],'data_table',role_id,data['table_fields'],data['table_fields2']);
      }
    });
  }
//->is_QIP
</script>
<div align="right"> <a href="{{URL::route('login')}}">Logout</a> </div>

<div class="box-header with-border">
  <h3 class="box-title">Name : {{{ Auth::user()->student->full_name }}}</h3></div>
  <h4 class="box-title">Select A Choice</h4></div>
  <div style="display: block;" class="box-body no-padding">
  <ul class="nav nav-pills">
      <li><label class="text-primary" style="min-width:130px;">View:</label></li>
      
      <li><label class="text-primary" style="min-width:130px;">
        <input type="radio" onclick="updateTable(this.id)" name="choice" value="self_details" id="self_details" onclick="updateTable(this.id)">

        <a class="btn btn-info">
          Your Form 
        </a>
      </input>
    </label></li>

    <li><label class="text-primary" style="min-width:130px;">
      <input type="radio" onclick="updateTable(this.id)" name="choice" value="rejections" id="rejections" onclick="updateTable(this.id)">
      <a class="btn btn-info">
        Unclear
      </a>

    </input>
  </label></li>
  <li><label class="text-primary" style="min-width:130px;">
    <input type="radio" onclick="updateTable(this.id)" name="choice" value="approvals" id="approvals" onclick="updateTable(this.id)">
    <a class="btn btn-info">
      Approvals
    </a>

  </input>
</label></li>
<br>
<li><label class="text-primary" style="min-width:130px;">NoDues Status: </label></li>
<li><label class="text-primary" style="min-width:130px;" id="status"> - </label></li>

</ul>
</div>
</div>

<div><h3>All student requests</h3>
  <div id="data_table" align="center"> <hr><span class="btn-block text-muted ">Please select a choice above</span> </div>
</div>


@endsection
