@extends('layouts.main') 

@section('content-menu')
@stop 

@section('content')

<div>
	<h3>Activation Failed</h3>
	<p>
		Your activation has failed because "{{$reason}}"
	</p>
</div>
@stop\|