@extends('layouts.bootstrap')

@section('submenu')
<div class="small_menu_container_style">
	<div class="small_left_menu_style"></div>
	<ul class="text7_style">

		<center>
			<a href="/invite-friends" class="submenu_item active">Invite Friend</a>
		</center>
		<li class="small_orange_menu_divider_style"></li>
		
		<center>
			<a href="/my-referals" class="submenu_item">Sent invitations</a>
		</center>
		<li class="small_orange_menu_divider_style"></li>
		
	</ul>
	<div class="small_right_menu_style"></div>
</div>
@stop

@section('content')
<div id="contact-create">

	<h3>Invite Friends</h3>
	<hr>

	{{ Form::open(array('route' => 'send-invite-friends', 'method' => 'POST')) }}
	    <ul>
	    
	        <li>
	            {{ Form::label('from', 'From') }}
	            {{ Form::text('from', $user->email, array('required' => 'required', 'readonly' => 'readonly')) }}
	        </li>

	        <li>
	            {{ Form::label('to', 'To') }}
	            {{ Form::text('to', null, array('required' => 'required')) }}
	        </li>
	
	        <li>
	            {{ Form::label('subject', 'Subject') }}
	            {{ Form::text('subject', null, array('required' => 'required')) }}
	        </li>
	        
			<li>
	            {{ Form::label('message', 'Message') }}
	            {{ Form::textarea('message') }}
	        </li>
	        
	        
	        <li style="margin-left: 110px;">
	            {{ Form::submit('Send', array('class' => 'btn btn-default')) }}
	        </li>
	        
	    </ul>
	{{ Form::close() }}

	<br>
	<div class='panel'>
		<weak>(This will go after the message)</weak>
		<br>
		<br>
		Our portal connects members to contacts and opportunities that drive sales results 
		for businesses! The first active network! Working actively in our platform 
		will cut down your prospecting process by half the time, thereby 
		increasing your productivity!
		<br>
		<br>
		Our Site: <a href="www.leadcliq.com">www.leadcliq.com</a>
		<br>
		<br>
		Contact Us: support@leadcliq.com 
	</div>
	
	@if ($errors->any())
	    <ul>
	        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
	    </ul>
	@endif
</div>
@stop


