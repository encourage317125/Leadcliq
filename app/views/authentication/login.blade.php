@extends('layouts.bootstrap') 

@section('content-menu')
@stop 

@section('content')

<div class="profile_form_container_style">
	<h3>Login</h3>

	{{ Form::open(array('route' => 'login', 'class' => 'form-horizontal')) }}	
		<div class="form-group">
			{{ Form::label('email', 'Email', array('class'=>'col-sm-2  control-label')) }} 
			<div class="col-sm-10 col-md-4">
				{{ Form::email('email', Input::old('email'), array('class'=>'form-control')) }}
			</div>
		</div>		
			
		<div class="form-group">
			{{ Form::label('password', 'Password', array('class'=>'col-sm-2  control-label')) }}
			<div class="col-sm-10 col-md-4"> 
				{{ Form::password('password', array('class'=>'form-control')) }}
			</div>
		</div>


		<div class="form-group">
    		<div class="col-sm-offset-2 col-sm-10 col-md-4">
			{{ Form::submit('Sign in', array('class' => 'btn btn-primary')) }}
			</div>
		</div>

<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10 col-md-4">
		<p>{{ link_to_route('forgot_password', 'Forgot password') }} or {{ link_to_route('register', 'Create a new account') }}</p>
	</div>
</div>
	
	
	{{ Form::close() }} @if ($errors->any())
	<ul>
		{{ implode('', $errors->all('
		<li class="error">:message</li>')) }}
	</ul>
	@endif

</div>


@stop


