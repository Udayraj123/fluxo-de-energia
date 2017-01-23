@extends('master')

@section('headContent')
<title>
	Log In | NoDuesApp
</title>
@endsection

@section('bodyContent')

<div class="row" align="center">
	<div class="col-md-6">

	<div class="box box-info form-horizontal">
			<div class="box-header with-border">
				<h3 class="box-title">Log In</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			{{Form::open(array('url'=>route("login"))) }}

			@foreach($errors as $e)
			<span class="text-warning">
				{{{$e}}}
			</span><br>
			@endforeach

			<!-- <form class="form-horizontal"> -->
			<div class="box-body">
				<div class="form-group">
					<label for="username" class="col-sm-2 control-label">Username</label>
					<div class="col-sm-10">
						<input class="form-control" id="username" name="username" type="text">
					</div>
				</div>
				<div class="form-group">
					<label for="password" class="col-sm-2 control-label">Password</label>
					<div class="col-sm-10">
						<input pwfprops="," class="form-control" id="password" name="password" type="password">
					</div>
				</div>
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<button type="submit" class="btn btn-info pull-right">Sign in</button>
			</div>
			<!-- /.box-footer -->
			<!-- </form> -->
			{{Form::close()}}
		</div>

	</div>
</div>

@endsection
