@extends('master_home')

@section('bodyContent')
<script type="text/javascript">
	getUC();
var X;
	function getUC(){
		var fruit_id=document.getElementById('fruit_id').value;
		console.log(fruit_id);
		$.ajax({
			method: "POST",
			url: "{{ route('priceHandle') }}",
			data: {'fruit_id':fruit_id},
			success: function(data) {
				console.log(data);
				$('#buy_price').val(parseInt(data['buy_price']));
				$('#RET').val(parseInt(data['RET']));
			},

  			error: function(data){		// ERROR NOT HANDLING ?
				console.log(data);
				X=data;
  				alert('error updating bp, check type X in console'); 
  			}
  		});

	}
</script>
<br>
{{{ $name or 'Default' }}}


<pre>
	{{ Form::open(array('url' => route("buyFruit"))) }}

	All Fields are required : 
	<label>CHOOSE fruit: <select name='fruit_id' id='fruit_id'>
		@foreach ($fruits as $f)
		<option value="{{ $f->id }}">{{ $f->farmer->user->username or 'FARMER'}}'s' {{ $f->name }}({{ $f->id }},{{ $f->avl_units }})</option>
		@endforeach
	</select></label><br>
	<label>buy_price : <input disabled="true" type='number' id='buy_price' value=1472 /></label><br>
	<label>RET : <input disabled="true" type='number' id='RET' value=5 /></label><br>
	<label>num_units : <input type='number' name='num_units' value=10 /></label><br>
	<input type='submit' value="SAVE" />
	{{ Form::close() }}
	<button onclick="getUC()" >get buy_price</button><br>
</pre>
<br>
@endsection
