@extends('master_home')

@section('bodyContent')
<br>
<pre>
	{{ Form::open(array('url' => route("buyProduct"))) }}
	All Fields are required : 
	<label>num_units : <input type='number' name='num_units' value=10 /></label><br>

	<label>CHOOSE PRODUCT: <select name='product_id' id='product_id'>
		@foreach ($products as $prod)
		<option value="{{ $prod->id }}">{{ $prod->god->user->username or 'GOD'}}'s'  {{ $prod->category }} {{ $prod->name }} id: ({{ $prod->id }})</option>
		@endforeach
	</select></label><br>
	<label>buy_price : <input disabled="true" type='number' id='bid_price' value=1472 /></label><br>
	<label>RET : <input disabled="true" type='number' id='RFT' value=5 /></label><br>
	<input type='submit' value="SAVE" />
	
	{{ Form::close() }}
</pre>
<br>
@endsection
