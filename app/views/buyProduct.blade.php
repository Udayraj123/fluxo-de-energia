@extends('master_home')

@section('bodyContent')

<!-- titles array -->
@section('headContent')
<title>Buy Product</title>
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
			url: "{{ route('productPriceHandle') }}",
			data: {'product_id':product_id},
			success: function(data) {
				console.log(data);
				$('#buy_price').val(parseInt(data['buy_price']));
				$('#RET').val(parseInt(data['RET']));
			},

  			error: function(){// Server Disconnected
  				X=data;	
  				alert('error updating bp, check type X in console'); 
  			}
  		});

	}
	setInterval("getUC()",{{C::get('game.msRefreshRate')}});
</script>

<div class="row"  style="background:#66ff66;border-radius:10px;width:30%;margin:5%0%0%2%;opacity:0.85">
	<div class="col-xs-12"  style="background:#66ff66;border-radius:10px;width:90%;margin:0%0%0%0%;opacity:0.85">
		<div class="box box-primary"  style="background:#66ff66;border-radius:10px;width:100%;margin:0%0%0%5%;opacity:0.85">
			<div class="box-header">
				<h3 class="box-title" style="font-size:28px;opacity:1">Buy Product</h3>
			</div>

			<div class="form-group">

				<table style="width:100%">
					{{ Form::open(array('url' => route("buyProduct"))) }}
					<tr>

						<td>
							<label for="product_id"> Product  : &nbsp;&nbsp;&nbsp; </label>
						</td>
						<td>
							<select class="form-control" name='product_id' onchange="getUC()" id='product_id'>
								@foreach ($products as $prod)
								<option value="{{ $prod->id }}">{{ $prod->god->user->username or 'GOD'}}'s'  {{ $prod->category }} {{ $prod->name }} id: ({{ $prod->id }})</option>
								@endforeach
							</select>
						</td> </tr><tr><td><br><br>

						<label>buy_price : </td><td><input disabled="true" id='buy_price' value=1472 /></label><br>
					</td></tr><tr><td><br><br>
					<label>RET : </td><td><input disabled="true" id='RET' value=5 /></label><br>
				</td></tr><tr><td><br><br>
				<label>num_units : </td><td><input type='number' name='num_units' value=10 /></label><br>
			</td></tr><tr><td><br><br>
			&nbsp;&nbsp;<div> <input type='submit' value="SAVE" /> </div>
		</td></tr>
		
		{{ Form::close() }}
	</table>

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
	<div id="boughtProducts" class="container" style="overflow-y:auto;height:75%;background:#66ff66;border-radius:10px;width:100%;margin:-51%0%0%80%;opacity:0.85">
		<div class="box-header with-border">
			<h3 class="box-title"> Available Products</h3>
		</div>
	</div>
</div>


<script type="text/javascript">
	var cellData=[];
	var currRow=[];
	var firstRow=['#','id','From','Product','description','num_units','avl_units','buy_price','quality','ET','bought_at'];
	var counter=0;
	cellData.push(firstRow);
	@foreach ($boughtProducts as $p)
	currRow=[];
	counter++;
	currRow.push(counter.toString());
	currRow.push('{{ $p->id }}');
	currRow.push('{{ $p->god->user->username }}');
	currRow.push('{{ $p->name }}');
	currRow.push('{{ $p->description }}');
	currRow.push('{{ $p->pivot->num_units }}');
	currRow.push('{{ $p->pivot->avl_units }}');
	currRow.push('{{ $p->pivot->buy_price }}');
	currRow.push('{{ $p->quality }}');
	currRow.push('{{ $p->ET }}');
	currRow.push('{{ $p->pivot->created_at }}');
	cellData.push(currRow);
	@endforeach

	var cellData=[];
	var firstRow=['#','id','From','Product','name','description', 'quality','ET','created_at'];
	var counter=0;
	cellData.push(firstRow);
	@foreach ($products as $p)
	currRow=[];
	counter++;
	currRow.push(counter.toString());
	currRow.push('{{ $p->id }}');
	currRow.push('{{ $p->god->user->username }}');
	currRow.push('{{ $p->category }}');
	currRow.push('{{ $p->name }}');
	currRow.push('{{ $p->description }}');
	currRow.push('{{ $p->quality }}');
	currRow.push('{{ $p->ET }}');
	currRow.push('{{ $p->created_at }}');
	cellData.push(currRow);
	@endforeach

	insertTable(cellData,"boughtProducts",1);
	
</script>


@stop