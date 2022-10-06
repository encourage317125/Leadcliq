@extends('layouts.bootstrap')

@section('submenu')

@stop 


@section('content')

<div class="content">
	<h2>Open Market</h2>
	<a href="{{ route('open-market-contacts') }}" class="btn btn-lg btn-warning">Contacts</a>
	<a href="{{ route('open-market-appts') }}" class="btn btn-lg btn-warning">Appointment</a>
</div>

@stop



						