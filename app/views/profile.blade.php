@extends('master_home')

<!-- titles array -->
@section('headContent')
<title>{{$puser->username}}'s Profile</title>
@stop

<!-- bg sources array -->
@section('bgsource')
god.jpg
@stop
@section('bodyContent')

<script type="text/javascript">
function convertDictToArr(dict){
  arr = [];
  for (var d in dict){
    arr.push(dict[d]);
  }
  return arr;
}
function inv_detail(){

  $.ajax({
    method: "POST",
    url: "{{ route('getInvDetail') }}",
      //data: { '': redeemLE },
    })
  .success(function( data1 ) {
      // console.log(convertDictToArr(data1[0]));
      var cellData=[];
      var firstRow=['Product ID','Product Name','Product Category','God Name','Total Invested', 'Total Received'];
      var counter=0;
      cellData.push(firstRow);
      for(var i=0; i<data1.length ;i++){
        cellData.push(convertDictToArr(data1[i]));
      }
      if(!cellData)
      {    
        insertTable(cellData,'inv_table',1);
      }

    });
}
window.onload=inv_detail;
</script>

<!-- ------------ -->
<div class='col-xs-12' id='p_perchng'>
  <h1> Welcome to {{$puser->username}}'s Flux.</h1>
</div>

<div class="col-xs-6" id="tot_inv"> 
  <h4>Total Amount Invested as an Investor is <strong>{{$totinv[0]}}</strong>.</h4>
</div>
<div class="col-xs-6" id="tot_rec"> 
  <h4>Total Amount Received as an Investor is <strong>{{$totinv[1]}}</strong>.</h4>
</div>

<div class='col-xs-6' id='p_highle'>
  <h4>All time highest Life Energy was <strong>{{$puser->highest_LE}}.</strong></h4>
</div>
<!-- ------------ -->
<!-- ------------ -->
<!-- ------------ -->
<div class='col-xs-6' id='p_perchng'>
  <h4>The Change in Life Energy in last one minute is <strong>{{$puser->change_percent}}.</strong> percent</h4>
</div>
<!-- ------------ -->
<!-- ------------ -->
<!-- ------------ -->
<div class='col-xs-6' id='p_perchng'>
  <h4>The current Life Energy is <strong>{{$puser->le}}.</strong></h4>
</div>

<div class='col-xs-6' id='p_perchng'>
  <h4>The current role played by {{$puser->username}} is <strong>{{$puser->category}}.</strong></h4>
</div>

<div class="col-xs-6" id="p_fruit">
  <h4>Fruits Grown Till Date : <strong>{{Fruit::where('launched','1')->where('farmer_id',$puser->farmer->id)->count()}}.</strong></h4>
</div>

<div class="col-xs-6" id="p_fruit">
  <h4>Fruits Sold Till Date : <strong>{{$total[0]}}. </strong></h4>
</div>
<div class="col-xs-6" id="p_fruit">
  <h4>Money Earned from selling fruits : <strong>{{$total[1]}}. </strong></h4>
</div>
<div class="col-xs-6" id="p_fruit">
<!-- ------------ -->
<!-- ------------ -->
<!-- ------------ -->
  @foreach(['farmer','investor','god'] as $cat)
  <h4>Playtime as {{$cat}} : <strong>{{ $puser->$cat->play_time + (($cat==$puser->category)?time()-$puser->$cat->switch_time:0)}} </strong> seconds.</h4>
  @endforeach

  <!-- ------------ -->
  <!-- ------------ -->
  <!-- ------------ -->
</div>

<div class="col-xs-6" id="inv_table">
</div>

<!-- ------------ -->

@stop