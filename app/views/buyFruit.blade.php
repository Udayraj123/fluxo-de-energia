@extends('master_home')

<!-- titles array -->
@section('headContent')
<title>Buy Fruit</title>
@stop

<!-- bg sources array -->
@section('bgsource')
god.jpg
@stop


@section('bodyContent') 

<script type="text/javascript">
	var X;
	function getUC(){
		var fruit_id=document.getElementById('fruit_id').value;
		//send ajax here.
		$.ajax({
			method: "POST",
			url: "{{ route('priceHandle') }}",
			data: {'fruit_id':fruit_id},
			success: function(data) {
				console.log(data);
				$('#buy_price').val(parseInt(data['buy_price']));
				$('#RET').val(parseInt(data['RET']));
			},

  			error: function(){// Server Disconnected
  				X=data;	
  				console.log('error updating bp, check type X in console'); 
  			}
  		});

	}
</script>
<br>
<div class="row"  style="background:#66ff66;border-radius:10px;width:30%;margin:5%0%0%2%;opacity:0.85">
	<div class="col-xs-12"  style="background:#66ff66;border-radius:10px;width:90%;margin:0%0%0%0%;opacity:0.85">
		<div class="box box-primary"  style="background:#66ff66;border-radius:10px;width:100%;margin:0%0%0%5%;opacity:0.85">
			<div class="box-header">
				<h3 class="box-title" style="font-size:28px;opacity:1">Buy Fruit</h3>
			</div>

			<div class="form-group">

				<table style="width:100%">
					{{ Form::open(array('url' => route("buyFruit"))) }}
					<tr>

						<td>
							<label for="fruit_id"> Fruit  : &nbsp;&nbsp;&nbsp; </label>
						</td>
						<td>
							<select class="form-control" name='fruit_id' id='fruit_id'>
								@foreach ($fruits as $f)
								<option value="{{ $f->id }}">{{ $f->farmer->user->namelink() or 'FARMER'}}'s {{ $f->name }}({{ $f->id }},{{ $f->avl_units }})</option>
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
	<button onclick="getUC()" >get buy_price</button><br>
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
	<div id="boughtFruits" class="container" style="overflow-y:auto;height:75%;background:#66ff66;border-radius:10px;width:100%;margin:-51%0%0%80%;opacity:0.85">
		<div class="box-header with-border">
			<h3 class="box-title"> boughtFruits</h3>
		</div>


		
	</div>
</div>


<script type="text/javascript">
	var cellData=[];
	var currRow=[];
	var firstRow=['#','id','From','Fruit','description','num_units','buy_price','storage_le','quality','ET','bought_at'];
	var counter=0;
	cellData.push(firstRow);
	@foreach ($boughtFruits as $f)
	currRow=[];
	counter++;
	currRow.push(counter.toString());
	currRow.push('{{ $f->id }}');
	currRow.push('{{ $f->farmer->user->namelink() }}');
	currRow.push('{{ $f->name }}');
	currRow.push('{{ $f->description }}');
	currRow.push('{{ $f->pivot->num_units }}');
	currRow.push('{{ $f->pivot->buy_price }}');
	currRow.push('{{ $f->storage_le }}');
	currRow.push('{{ $f->quality_factor }}');
	currRow.push('{{ $f->ET }}');
	currRow.push('{{ $f->pivot->created_at }}');
	cellData.push(currRow);
	@endforeach

	insertTable(cellData,"boughtFruits",1);
	
</script>


@stop