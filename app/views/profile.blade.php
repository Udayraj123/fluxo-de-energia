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
      insertTable(cellData,'inv_table',1);

    });
  }
  window.onload=inv_detail;
</script>

<!-- ------------ -->
<div class='col-xs-6' id='p_perchng'>
<h1> Welcome to {{$puser->username}}'s Flux.</h1>
</div>

<div class="col-xs-3" id="tot_inv"> 
Total Amount Invested as an Investor is {{$totinv[0]}}.
</div>
<div class="col-xs-3" id="tot_rec"> 
Total Amount Received as an Investor is {{$totinv[1]}}.
</div>

<div class='col-xs-3' id='p_highle'>
All time highest Life Energy was {{$puser->highest_LE}}.
</div>

<div class='col-xs-3' id='p_perchng'>
The Change in Life Energy in last one minute is {{$puser->change_percent}}.
</div>

<div class='col-xs-3' id='p_perchng'>
The current Life Energy is {{$puser->le}}.
</div>

<div class='col-xs-3' id='p_perchng'>
The current role played by {{$puser->username}} is {{$puser->category}}.
</div>

<div class="col-xs-3" id="p_fruit">
Fruits Grown Till Date : {{Fruit::where('launched','1')->where('farmer_id',$puser->farmer->id)->count()}}.
</div>

<div class="col-xs-3" id="p_fruit">
Fruits Sold Till Date : {{$total[0]}}. 
</div>
<div class="col-xs-3" id="p_fruit">
Money Earned from selling fruits : {{$total[1]}}. 
</div>

<div class="col-xs-6" id="inv_table">
</div>

<!-- ------------ -->

@stop