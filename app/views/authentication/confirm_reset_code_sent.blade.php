@extends('layouts.bootstrap') 

@section('content-menu')
@stop 

@section('content')

<div>
	<h3>Reset Password</h3>
	<p>
		An email should have been sent to your email ({{$email}}) with your reset code. However for now simply click <a href="{{url('user/reset-password')}}?code={{$resetCode}}">this link</a> to set a new password.
	</p>
</div>
@stop