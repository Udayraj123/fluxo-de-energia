@extends('master_home')

<!-- titles array -->
@section('headContent')
<title>Leaderboard</title>
@stop

<!-- bg sources array -->
@section('bgsource')
god.jpg
@stop
@section('bodyContent')
@foreach ($users as $u)
<div class="progress-group">

<span class="progress-text">
	{{$u->username}} | {{$u->category}}
</span>
<span class="progress-number" id="progress-number{{$u->id}}">

</span>

<div class="progress sm"><div class="progress-bar progress-bar-green" id="progress{{$u->id}}" style="width:0%">
</div>
<script type="text/javascript">
	var THR = upper{{strtoupper($u->category[0])}};
	var lowerCat = lower{{strtoupper($u->category[0])}};
	curr_LE = {{$u->le}}
	diff1 = THR - curr_LE;
	diff2 = THR - lowerCat;
	width = 100*(diff1/diff2);
	$('#progress{{$u->id}}').width(width);
	$('#progress-number{{$u->id}}').html(curr_LE+'/'+THR);
</script>
</div>
</div>
@endforeach

<script type="text/javascript">
	$('#print').append(upperG);
	$('#print').append(upperI);
	$('#print').append(upperF);
	$('#print').append(lowerF);
	$('#print').append(lowerI);
	$('#print').append(lowerG);
</script>

<p id="printthr">Something</p>

@stop