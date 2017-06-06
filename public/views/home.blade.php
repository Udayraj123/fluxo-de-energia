@extends('master')

@section('headContent')
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  -->

<script type="text/javascript">
setInterval(function(){
	$.ajax({
  method: "POST",
  url: "{{ route('decayHandle') }}",
  // data: { 'name': "Johnny", 'location': "Boston" },
  
  success: function( data ) {
  	console.log("decay");
    $('#LE').val(parseInt(data['le']));
    $('#decay').val(parseInt(data['decay']));
  },
  
  error: function(){// ERROR NOT HANDLING ?
    alert('user not in db'); 
  }


});

  $.ajax({
  method: "POST",
  url: "{{ route('thresholdHandle') }}",
  // data: { 'name': "Johnny", 'location': "Boston" },
})
  .success(function( data ) {
    console.log("sysLE and THR");
    $('#sysLE').val(parseInt(data['total']));
    $('#thresholdGI').val(parseInt(data['thresholdGI']));
    $('#thresholdFI').val(parseInt(data['thresholdFI']));
    $('#thresholdF').val(parseInt(data['thresholdF']));
  });


},1000);


function reqRedeem(){
  var redeemLE=$('#redeemLE').val();
    $.ajax({
  method: "POST",
  url: "{{ route('redeemLife') }}",
  data: { 'redeemLE': redeemLE },
})
  .success(function( data ) {
    console.log("REDEEMED ",data['respLE']);
    console.log("Now stored_LE ",data['stored_LE']);
    $('#stored_LE').val(parseInt(data['stored_LE']));
  });
}

function showredeemLE(val){
  $('#redeemLE').val(val);
}

</script>
@endsection
@section('bodyContent')
<br>
<pre>
{{$user}}

User : {{$user->username}} {{$user->category}} 
Stored_LE : {{$user->stored_LE or 0}}
  
    <input type='number' id='sysLE' value=0 /> Sys LE
    <input type='number' id='LE' value=0 /> User LE    <input type='number' id='decay' value=0 /> User decay
                                  Stored_LE <input type='number' id='stored_LE' value=0 /> 
    <input type='number' id='thresholdGI' value=0 /> Thr GI

    <input type='number' id='thresholdFI' value=0 /> Thr FI        
    <input type='number' id='thresholdF' value=0 /> Thr F
    <input type='range' min="0" max="{{$user->stored_LE or 1}}" oninput="showredeemLE(this.value)" value=0 /> <input type='number' id='redeemLE' value=0 /> redeemLE
    
    <button onclick="reqRedeem()"> REDEEM</button>
<!-- Returned data from server -->
  
</pre>
<br>
@endsection
