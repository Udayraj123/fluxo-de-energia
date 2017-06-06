@extends('misc.master')
@section('title')
    Technothlon | 404
@endsection
@section('body')
    <section class="wet-asphalt no-margin" style="height: 100%">
        <div class="container"  style="padding:40px 30px 40px 30px;">
            <div>
                <div style="height: 100%; padding-left: 200px;" class="col-md-6">
                    <img src="{{ asset('images/404.png') }}" alt="" height="450px"/>
                </div>
                <div style="display: inline-block; margin-top:175px" class="col-md-6 pull-left">
                    <p class="lead">The page you are looking for is not available. <br>If you think it should work please <a href="{{ route('home') }}" class="linkNormal"> report us.</a></p>
                </div>
            </div>
        </div>
    </section>
@endsection