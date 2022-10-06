@extends('layouts.bootstrap')
@section('content-menu')
@stop
@section('content')
<div class="profile_form_container_style">
	<h3>Create an account</h3>
	<div id="register-page">
			<p>Registering for this site is easy, just fill in the fields below and we'll get a new account set up for you in no time.</p>
			{{ Form::open(array('route' => 'register', 'class'=>'form-horizontal', 'role'=>"form")) }}
			    
			    	<div class="form-group">
		            	{{ Form::label('first_name', 'First name*', array('class'=>'col-sm-3 col-md-2  control-label')) }}
		            	<div class="col-sm-9 col-md-4">
		            		{{ Form::text('first_name',Input::old('first_name'), array('class'=>'form-control','required'=>'required')) }}
		            	</div>
		            </div>			        
			        <div class="form-group">
			            {{ Form::label('last_name', 'Last name*', array('class'=>'col-sm-3 col-md-2  control-label')) }}
			            <div class="col-sm-9 col-md-4">
			            {{ Form::text('last_name',Input::old('last_name'), array('class'=>'form-control','required'=>'required')) }}
			        	</div>
			        </div>
                    <div class="form-group">
                        {{ Form::label('alias', 'Alias*', array('class'=>'col-sm-3 col-md-2  control-label')) }}
                        <div class="col-sm-9 col-md-4">
                            {{ Form::text('alias',Input::old('alias'), array('class'=>'form-control','required'=>'required')) }}
                        </div>
                    </div>
			        <div class="form-group">
			            {{ Form::label('email', 'Email*', array('class'=>'col-sm-3 col-md-2  control-label')) }}
			            <div class="col-sm-9 col-md-4">
			            {{ Form::email('email',Input::old('email'), array('class'=>'form-control','required'=>'required')) }}
			            </div>
			        </div>
			       	<div class="form-group">
			            {{ Form::label('phone', 'Phone', array('class'=>'col-sm-3 col-md-2  control-label')) }}
			            <div class="col-sm-9 col-md-4">
			            	{{ Form::text('phone', Input::old('phone'), array('class' => 'phoneinput form-control')) }}
			            </div>
			        </div>
					<div class="form-group">
			            {{ Form::label('extension', 'Extension', array('class'=>'col-sm-3 col-md-2  control-label')) }}
			            <div class="col-sm-9 col-md-4">
			            	{{ Form::text('extension', Input::old('extension'), array('class' => 'form-control')) }}
			            </div>
			        </div>
			        <div class="form-group">
			            {{ Form::label('password', 'Password*', array('class'=>'col-sm-3 col-md-2  control-label','required'=>'required')) }}
			            <div class="col-sm-9 col-md-4">
			            {{ Form::password('password', array('class'=>'form-control')) }}
			            </div>
			        </div>
			        <div class="form-group">
    					<div class="col-sm-offset-2 col-sm-9 col-md-4">
			            {{ Form::submit('Register', array('class' => 'btn btn-primary')) }}
			            </div>
			        </div>
			    
			{{ Form::close() }}
			@if ($errors->any())
			    <ul>
			        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
			    </ul>
			@endif
	</div>
</div>
@stop