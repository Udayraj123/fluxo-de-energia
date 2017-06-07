@extends('master_home')

<!-- titles array -->
@section('headContent')
<title>My Investments</title>
@stop

<!-- bg sources array -->
@section('bgsource')
god.jpg
@stop


@section('bodyContent') 

<script type="text/javascript">
	var X;
	function getUC(){
		var product_id=document.getElementById('product_id').value;
		//send ajax here.
		$.ajax({
			method: "POST",
			url: "{{ route('bidHandle') }}",
			data: {'product_id':product_id},
			success: function(data) {
				console.log(data);
				$('#bid_price').val(parseInt(data['bid_price']));
				$('#RFT').val(parseInt(data['RFT']));
			},

  			error: function(){// Server Disconnected
  				X=data;	
  				alert('error updating bp, check type X in console'); 
  			}
  		});

	}
</script>
<br>
<div class="row"  style="background:#66ff66;border-radius:10px;margin:5%2%0%2%;opacity:0.85">
	<div class="col-md-6">
		<div id="myInvestments" class="container" style="overflow-y:auto;height:75%;background:#66ff66;border-radius:10px;width:100%;opacity:0.85">
			<div class="box-header with-border">
				<h3 class="box-title"> Your Investments </h3>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div id="detailInvesments" class="container" style="overflow-y:auto;height:75%;background:#66ff66;border-radius:10px;width:100%;opacity:0.85">
			<div class="box-header with-border">
				<h3 class="box-title"> Product Performance </h3>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	var cellData=[];
	var cellData2=[];
	var currRow=[];
	var firstRow=['#','id','product','Owner','num_shares','bought for','quality','FT','name','description'];
	var firstRow2=['#','id','product','name','num_shares','bought for','sell returns'];
	var counter=0;
	cellData.push(firstRow);
	cellData2.push(firstRow);
	@foreach ($products as $prod)
	currRow=[];
	counter++;
	currRow.push(counter.toString());
	currRow.push('{{ $prod->id }}');
	currRow.push('{{ $prod->category }}');
	currRow.push('{{ $prod->god->user->username }}');
	currRow.push('{{ $prod->pivot->num_shares }}');
	currRow.push('{{ $prod->pivot->bid_price }}');
	currRow.push('{{ $prod->quality }}');
	currRow.push('{{ $prod->FT }}');
	currRow.push('{{ $prod->name }}');
	currRow.push('{{ $prod->description }}');
	@if($prod->being_funded==1)
	cellData.push(currRow);
	@else
	//launched or expired
	cellData2.push(currRow);
	@endif
	@endforeach

	insertTable(cellData,"myInvestments",1);
	insertTable(cellData2,"detailInvesments",1);
	
</script>

@stop