@extends('master_home')

@section('headContent')
<script src="{{asset('js/moment.js')}}"></script>
<!-- AdminLTE App -->

<title>
  Farming Land 
</title>
<style type="text/css">
.box-header{
  background:#094d00;
  margin: 20px;
  color:grey;
  opacity:0.85
}
</style>
@endsection
@section('bgsource')
Terrace-Farming-Paddy-Spinach.jpg
@endsection
@section('bodyContent')
<br>
<script>

var c1={{ $c1 }};
var c2={{ $c2 }};
var c3={{ $c3 }};
var c4={{ $c4 }};
var bp={{ $fruitBP }};

function getUC(){
  var ET=document.getElementById('ET').value;
  var GT=1;
  var Tol=document.getElementById('Tol').value;
  var quality=document.getElementById('quality_factor').value;
  return bp*(c1*quality+c2*GT+c3*ET)*(1+c4*Tol);
}
setInterval(function(){$('#unit_price').val(getUC());},{{C::get('game.msRefreshRate')}});


</script>
<div id="LandWrapper " class="row box-header with-border">  
  {{ Form::open(array('url' => route("applyPurch"))) }}
  <div class="col-md-6"> 
    <div class="row"> 
      <div class="row"> 
        <div class="col-md-12">  
          <h1 style="color:lightblue" align="center"> Your Land</h1>
        </div>
      </div>
      <div class="row">  
        <div class="col-md-12">  
          <div id="Land">  </div>
        </div>
      </div>
    </div>
    <div class="row">  
      <div id="status">  </div>
      <pre class="box-header">


        <label>CHOOSE SEED/FERT/LAND :   <select required name='purchase_id' id='purchase_id'>
          @foreach ($purchases as $purch)
          @if($purch->avl_units>0 &&  $purch->product)
          <option value="{{ $purch->id }}">({{$purch->avl_units}}){{ $purch->product->god->user->username or 'GOD'}}'s  {{ $purch->product->category }} {{ $purch->product->name }} ({{ $purch->id }})
          </option>
          @endif
          <?php
          if(!$purch->product)
            Log::info("No Owner for product ");
          Log::info($purch);
          ?>
          @endforeach
        </select>
      </label>
      <label style="position: relative;left:40%;top: 100%"><input type="submit" value="Apply"/></label><br>
      {{ Form::close() }}
    </pre>
  </div>
</div>
<div class="col-md-5">
  <pre class="box-header">
    {{ Form::open(array('url' => route("launchFruit"))) }}
    CHOOSE FRUIT STORAGE TO LAUNCH :
    <label>
      <select required name='storage_id' id='storage_id'>
        @foreach ($fruits as $l=>$f)
        @if($f->num_units>0 && $f->launched==0)
        <option value="{{ $f->id }}">
          Fruit-{{$f->id}}{{$f->name}} of seed{{$f->seed_id}} ({{$f->num_units}}) 
        </option>
        @endif
        @endforeach

      </select>
    </label>
    ENTER FRUIT DETAILS, All Fields below are required : 
    <label>name: <input type='text' name='name' id='name' value="myFruit" /></label><br>
    <label>description: <input type='text' name='description' id='description' value="description" /></label><br>
    <label>quality_factor : <input min="5" max="100" value="10" type="range" name='quality_factor' id='quality_factor'/></label><br>
    <label>ET : <input min="5" max="30" value="5" type="range" name='ET' id='ET'/></label><br>
    <label>Tolerance : <input min="0" max="100" type="range" name='Tol' id='Tol' value=4/></label><br>
    <label>unit_price: <input readonly="readonly" type='number' id='unit_price' name='unit_price' value="2000"/></label><br>
    <!-- Disabled ones are not sent, read only ones are sent -->
    <label style="position: relative;left:40%;top: 100%"><input type="submit" value="Deploy"/></label><br>
    {{ Form::close() }}
  </pre>
</div>
</div>
<script>
var stateUnused=0,stateSeed=1,stateFert=2,stateFertSeed=3,stateFruit=4;
var stateText = ['<i class="fa fa-plus-square"></i> Unused',
'<i class="fa fa-empire"></i> Seed ',
'<i class="fa fa-hourglass"></i> Fert Only &nbsp',
'<i class="fa fa-tree"></i> Fert & Seed',
'<i class="fa fa-apple"></i> Fruit'];
var colors = ['yellow','grey','blue','black','orange','green'];

function makeBox(state,id,index,check,RGTs){
    // console.log("makeBox",state,id,check,(check?'':'un')+'checked');
    var Icon='<span style="font-size:30px;">&nbsp '+stateText[state]+'</span> &nbsp <span style="font-size:30px;" id="status'+id+'">&nbsp'+RGTs[index]+'</span>';
    console.log(id)
    var block= '<input type="checkbox" '+(check?'':'un')+'checked name="land_ids[]" onclick="updateLands(this.id)" id="land'+id+'" value="'+id+'"/>'+Icon;
    if(state==stateFruit || state==stateFertSeed )
      block='<button type="button"'+(state==stateFruit?'':'')+'onclick="updateLands(this.id)" id="land'+id+'"/>'+Icon;
    block = '<label style="width:205px;height:105px;margin:10px" class="btn btn-app bg-'+colors[state]+'" >'+block+'</label>';

    return block;
  }

  function makeLand2(divID,states,landIDs,checks,RGTs){

    var cellCount=0
    var state=0;
    var check=0;
    var t=states.length;
    var tableContainer=document.getElementById(divID);
    if(t==0){
      tableContainer.innerHTML="<span class='box box-warning'>NO LAND! Buy from the <a href='{{route('buyProduct')}}'>store</a>! </span>";
      return;
    }
    var table1= document.createElement('table');
    table1.cellSpacing="40";//check class
    var tableHeight=t/4+1,tableWidth=4;
    for(var i=0;i<tableHeight ;i++){
      var current_row=table1.insertRow();
      for(var j=0; j<tableWidth && cellCount<t;j++){
        state=states[cellCount];
        land_id=landIDs[cellCount];
        check=checks['land'+land_id.toString()];
        check= typeof(check)=='undefined'?false:check; //default for buttons/ new lands

        var current_col=current_row.insertCell();
        // current_col.style="background:"+colors[state]+";color:lightgreen";

        var land_index=landIDs.indexOf(parseInt(land_id));

        current_col.innerHTML=makeBox(state,land_id,land_index,check,RGTs);
        cellCount++;
      }
    }
    tableContainer.innerHTML="";// erase old land, put new one
    tableContainer.appendChild(table1);
  }


  //FOR SEED=1 STATES 1 & 3
  function updateLands(x){
    x= typeof(x)=='undefined'?"land1":x; //default
    var land_id= parseInt(x.substr(x.indexOf("d")+1));
    //send ajax here.
    $.ajax({
      method: "POST",
      url: "{{ route('getStates') }}", // data: {'land_id':land_id},
      success: function(data) {
        var states=data['states'];
        var landIDs=data['landIDs'];
        var RGTs=data['RGTs'];
        
        console.log(landIDs,states,RGTs);

        var land_index=landIDs.indexOf(parseInt(land_id));
        var state=states[land_index];
        console.log(landIDs,states,RGTs);
        console.log(land_index);

      //This is reseting the checkBoxes too !
        //can do with cookie too, or pass array here. cookie seems better as you can keep track by id, but updating states can cause probs
        var checks=[];
        $(":checkbox").each(function(){checks[this.id]=this.checked; });

        makeLand2("Land",states,landIDs,checks,RGTs); //this removes previous land & replaces with new states

        //TODO put this following on onclick () directly
       // var text='Ajax:  land'+land_id+'state ' + state +' : will grow a fruit in '+RGTs[land_index]+' minutes !';
        
        if(state==stateFruit){
       //   text='Ajax: land'+land_id+' has grown fully, click to fetch the fruit';
          makeFetchable(land_id);
        }
      //  $("#status").html(text);
      },

  error: function(){// Server Disconnected
    alert('error updating RGT'); 
  }
});
}
updateLands();

function makeFetchable(land_id){
  //THIS will make the land clickable & onclick will send an ajax to increase num_units in Fruits while cleaning the land

//get that div box, change its onclick to call Fetch

Fetch(land_id);
}


function Fetch(land_id){
///SEND AJAX HERE to update fruit data & number & alter land SEED_ID = -1 (with backend check)
$.ajax({
  method: "POST",
  url: "{{ route('fetchFruit') }}", 
  data: {'land_id':land_id},
  success: function(data) {
//here we also increase Farmer's energy a bit    
console.log(data);
updateLands();
},
  error: function(){// Server Disconnected
    alert('error updating Fruit Land'); 
  }
});



}

</script>
<br>
@endsection
