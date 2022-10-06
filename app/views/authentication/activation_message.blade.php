@extends('layouts.bootstrap') 


@section('content')

<div>
	<h3>Welcome to Leadcliq</h3>
	<p>
		Welcome message welcoming you to leadcliq.com
	</p>
	<p>
		To continue, please check your email({{$user->email}}) for the activation code. For now simply click on <a href="{{url('user/activate')}}?code={{$activationCode}}">this link</a> to activate your account.
	</p>	
</div>
@stop