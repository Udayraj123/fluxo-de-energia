@extends('master')

@section('headContent')
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  -->

<script type="text/javascript">
var p =Math.pow(10,3); //precision
  function round(x,p){
   var x2=parseInt(x);
   var p2=parseInt(p);
   var m=Math.pow(10,p2);    
   return parseFloat((Math.round(x2*m))/m);
  }

  var catTHR=[];
  catTHR['god'] = 'thresholdGI';
  catTHR['investor'] = 'thresholdFI';
  catTHR['farmer'] = 'thresholdF';

  setInterval(function(){
   $.ajax({
    method: "POST",
    url: "{{ route('decayHandle') }}",
  // data: { 'name': "Johnny", 'location': "Boston" },
  success: function( data ) {
  	console.log("decay");
    var le=parseInt(data['le']);
    var decay=parseInt(data['decay']);
    $('#LE').val(le);
    $('#decay').val(decay);
    $('#active_cat').val(data['active_cat']);
    var id = catTHR[data['active_cat'].toString()];
    var currTHR=$("#"+id).val();
    var eta=(le-currTHR)/decay;
    eta=Math.round(eta*p)/p;
    etam=Math.round(eta/60*p)/p;
    $('#ETA').val(eta);
    $('#ETAmin').val(etam);
    $('#currTHR').val(currTHR);


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
      var now=parseInt(data['stored_LE']);
      console.log("Now stored_LE ",now);

      $('#stored_LE').val(now);
      $('#stored_LE_slide').attr("max",now);

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
  
  <input type='text' id='active_cat' value=0 /> active_cat
  <input type='number' id='sysLE' value=0 /> Sys LE

  <input type='number' id='thresholdGI' value=0 /> Thr GI
  <input type='number' id='thresholdFI' value=0 /> Thr FI        
  <input type='number' id='thresholdF' value=0 /> Thr F
  
  <input type='number' id='LE' value=0 /> User LE        
  <input type='number' id='decay' value=0 /> User decay
  <input type='number' id='currTHR' value=0 /> currTHR
  <input type='number' id='ETAmin' value=0 /> ETA (minutes)     <input type='number' id='ETA' value=0 /> ETA (seconds)
  
  <input type='number' id='stored_LE' value=0 /> Stored_LE
  <input type='range' min="0" max="{{$user->stored_LE or 1}}" id="stored_LE_slide" oninput="showredeemLE(this.value)" value=0 /> <input type='number' id='redeemLE' value=0 /> redeemLE

  <button onclick="reqRedeem()"> REDEEM</button>
  <!-- Returned data from server -->
  
</pre>
<br>
@endsection
