@extends('layouts.bootstrap') 
@section('content')
	
	{{ Form::open(array('url' => 'user/reset-password', 'id' => 'page-login-form','class'=>'form-horizontal')) }}
	<div class="">
		<h3>Reset Password</h3>	
		<p>
			{{$user->first_name}}, please enter your new password
		</p>
		@if($errors->has('password'))
		<p class="alert alert-errors">
			The following validation errors occurred:
			@foreach ($errors->get('password') as $error)
			<br>- {{$error}}
			@endforeach
		</p>
		@endif</div>
	{{Form::hidden('code',$code)}}
	<div class="form-group">
			{{ Form::label('password', 'New Password', array('class'=>'col-sm-2  control-label')) }}
			<div class="col-sm-10 col-md-4"> 
				{{ Form::password('password', array('class'=>'form-control')) }}
			</div>
		</div>
	<div class="form-group">
			{{ Form::label('password_confirmation', 'Confirm Password', array('class'=>'col-sm-2  control-label')) }}
			<div class="col-sm-10 col-md-4"> 
				{{ Form::password('password_confirmation', array('class'=>'form-control')) }}
			</div>
		</div>
		<div class="form-group">
    		<div class="col-sm-offset-2 col-sm-10 col-md-4">
			{{ Form::submit('Sign in', array('class' => 'btn btn-primary')) }}
			</div>
		</div>
	
	</form>
	




@stop


