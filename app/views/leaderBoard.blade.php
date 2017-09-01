@extends('master_home')

<!-- titles array -->
@section('headContent')
<title>Leaderboard</title>
<style type="text/css">
.progress-text{
	font-size: 25px
}
.yellowstyle{
	background:#ffc61a;margin:5%0%0%5%;border-radius:10px;opacity:0.85
}
</style>
@stop

<!-- bg sources array -->
@section('bgsource')
god.jpg
@stop
@section('bodyContent')
<div id="stats">
	<div class="row">
		<div class="col-md-4 yellowstyle">
			<div class="row">
				<p align="center" style="font-size:28px	">
					<strong>Top Movers in last {{C::get('game.leaderBoardRate')}} seconds</strong>
				</p>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?php 
					$topMoverG = User::where('is_moderator',0)->where('category','god')->orderBy('change_percent','desc')->first();
					$topMoverF = User::where('is_moderator',0)->where('category','farmer')->orderBy('change_percent','desc')->first();
					$topMoverI = User::where('is_moderator',0)->where('category','investor')->orderBy('change_percent','desc')->first();
					?>
					<div class="row" style="font-size:25px">
						<div class="col-md-4"> In Gods </div>
						<div class="col-md-4"> In Investors </div>
						<div class="col-md-4"> In Farmers </div>
					</div>
					<div class="row" style="font-size:25px">
						<div class="col-md-4"> {{ $topMoverG->namelink() }} : {{ $topMoverG->change_percent }}% </div>
						<div class="col-md-4"> {{ $topMoverF->namelink() }} : {{ $topMoverF->change_percent }}% </div>
						<div class="col-md-4"> {{ $topMoverI->namelink() }} : {{ $topMoverI->change_percent }}% </div>
					</div>
				</div>
			</div>
			<div class="row">
				<p align="center" style="font-size:28px	">
					<strong>Your Change : {{Auth::user()->get()->change_percent}} %</strong>
				</p>
			</div>
		</div>
		<div class="col-md-6 yellowstyle">
			<div class="row">
				<p align="center" style="font-size:28px	">
					<strong>Life Energy Leaderboard</strong>
				</p>
			</div>
			<div class="row" style="padding:30px">
				@foreach ($leaders as $i=>$u)
				{{--
				@if( $i > 0 && $leaders[$i-1]['category'] != $leaders[$i]['category'])
				<div class="col-md-4" class="bg-blue">
					<hr>
				</div>
				@endif
				--}}

				<div class="col-md-6 bg-{{$u['invcolor']}}" style="border:10px solid goldenrod;">
					<div class="progress-group">
						<span class="progress-text">
							{{$u['name']}} | {{$u['category']}}
						</span>
						<span class="progress-number">
							{{$u['le']}}/{{$u['uCat']}}
						</span>

						<div class="progress sm">
							<div class="progress-bar progress-{{$u['color']}}" style="width:{{$u['width']}}%">
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
		<div class="col-md-2"></div>
	</div>
</div>
@stop