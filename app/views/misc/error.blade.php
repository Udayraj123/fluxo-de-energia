@extends('misc.master')
@section('head')
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    @endsection
@section('description')
    Server Error!
    @endsection
@section('title')
    Server Error!
@endsection
@section('body')
    <section class="wet-asphalt no-margin" style="height: 100%">
        <div class="container"  style="padding:6% 40px">
            <div>
                <div style="height: 100%;" class="col-md-12 center">
                    <img src="{{ asset('images/error.png') }}" alt="" />
                </div>
                <div style="margin-top: 10px" class="col-md-12 center">
                    <p class="lead">Oops! There seems to be an error from the server.<br>
                        Please try again later.<br>
                        You can go to <span><a href="{{ route('home') }}">Home</a></span> or <span><a href="javascript:history.go(-1)">Return</a></span> to the previous page
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection