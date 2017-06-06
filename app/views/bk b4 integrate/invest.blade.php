@extends('master')

@section('bodyContent')
<script type="text/javascript">
	getUC();
	var X;
	function getUC(){
		var product_id=document.getElementById('product_id').value;
		//Done-  var c1=products->get(id=product_id) HOW TO GET PRODUCT BY DIFF IDS FROM FRONTEND? 
		//We can send ajax request to a function that returns bid_price of the product selected 

		console.log(product_id);
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
{{{ $name or 'Default' }}}


<pre>
	{{ Form::open(array('url' => route("makeInvestment"))) }}

	All Fields are required : 
	<label>CHOOSE PRODUCT: <select name='product_id' id='product_id'>
		@foreach ($products as $prod)
		<option value="{{ $prod->id }}">{{ $prod->god->user->username or 'GOD'}}'s'  {{ $prod->category }} {{ $prod->name }} id: ({{ $prod->id }})</option>
		@endforeach
	</select></label><br>
	<label>bid_price : <input disabled="true" type='number' id='bid_price' value=1472 /></label><br>
	<label>RFT : <input disabled="true" type='number' id='RFT' value=5 /></label><br>
	<label>num_shares : <input type='number' name='num_shares' value=10 /></label><br>
	<input type='submit' value="SAVE" />
	{{ Form::close() }}
	<button onclick="getUC()" >get bid_price</button><br>
</pre>
<br>
@endsection
