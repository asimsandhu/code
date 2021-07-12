@extends('layouts.master')


@section('content')

    @if(Auth::guard('web')->check())
<div>
<h1>     -------------------      logged in as {{Auth::guard('web')->user()->name}}</h1>
</div>
    @endif
@endsection