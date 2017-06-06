@extends('master_home')

<!-- titles array -->
@section('headContent')
<title>Energy</title>
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

  			error: function(){// ERROR NOT HANDLING ?
  				X=data;	
  				alert('error updating bp, check type X in console'); 
  			}
  		});

	}
</script>
<br>
<div class="row"  style="background:#66ff66;border-radius:10px;width:30%;margin:5%0%0%2%;opacity:0.85">
	<div class="col-xs-12"  style="background:#66ff66;border-radius:10px;width:90%;margin:0%0%0%0%;opacity:0.85">
		<div class="box box-primary"  style="background:#66ff66;border-radius:10px;width:100%;margin:0%0%0%5%;opacity:0.85">
			<div class="box-header">
				<h3 class="box-title" style="font-size:28px;opacity:1">Make Investment</h3>
			</div>

			<div class="form-group">

				<table style="width:100%">
					{{ Form::open(array('url' => route("makeInvestment"))) }}
					<tr>

						<td>
							<label for="product_id"> Product Type  : &nbsp;&nbsp;&nbsp; </label>
						</td>
						<td>
							<select class="form-control" name='product_id' id='product_id'>
								@foreach ($products as $prod)
								<option value="{{ $prod->id }}">{{ $prod->god->user->username or 'GOD'}}'s'  {{ $prod->category }} {{ $prod->name }} id: ({{ $prod->id }})
								</option>
								@endforeach
							</select>
						</td> </tr><tr><td><br><br>

						<label>bid_price : </td><td><input disabled="true" type='number' id='bid_price' value=1472 /></label><br>
					</td></tr><tr><td><br><br>
					<label>RFT : </td><td><input disabled="true" type='number' id='RFT' value=5 /></label><br>
				</td></tr><tr><td><br><br>
				<label>num_shares : </td><td><input type='number' name='num_shares' value=10 /></label><br>
			</td></tr><tr><td><br><br>
			&nbsp;&nbsp;<div> <input type='submit' value="SAVE" /> </div>
		</td></tr>
		{{ Form::close() }}
	</table>
<button onclick="getUC()" >get bid_price</button><br>
</div>

<!-- /.box-header -->

</div>
</div>
<!-- /.box-body -->
</div>
<!-- /.box -->
</div>
<!-- /.col -->
</div>

<div class="col-md-6">
	<div id="productLaunched" class="container" style="overflow-y:auto;height:75%;background:#66ff66;border-radius:10px;width:100%;margin:-51%0%0%80%;opacity:0.85">
		<div class="box-header with-border">
			<h3 class="box-title"> Upcoming Products</h3>
		</div>


		
	</div>
</div>


<script type="text/javascript">
	var cellData=[];
	var currRow=[];
	var firstRow=['#','id','product','Owner','name','description','bid price','quality','FT'];
	var counter=0;
	cellData.push(firstRow);
	@foreach ($products as $prod)
	currRow=[];
	counter++;
	currRow.push(counter.toString());
	currRow.push('{{ $prod->id }}');
	currRow.push('{{ $prod->category }}');
	currRow.push('{{ $prod->god->user->username }}');
	currRow.push('{{ $prod->name }}');
	currRow.push('{{ $prod->description }}');
	currRow.push('{{ $prod->bid_price }}');
	currRow.push('{{ $prod->quality }}');
	currRow.push('{{ $prod->FT }}');
	cellData.push(currRow);
	@endforeach

	insertTable(cellData,"productLaunched",1);
	
</script>

@stop