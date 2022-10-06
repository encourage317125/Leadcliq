@extends('layouts.bootstrap')

@section('submenu')
<div class="small_menu_container_style">
	<div class="small_left_menu_style"></div>
	<ul class="text7_style">
		<center>
			{{ link_to_route('circles.index', 'Join Circles',array(), array('class' => 'submenu_item')) }}
		</center>
		<li class="small_orange_menu_divider_style"></li>
	</ul>
	<div class="small_right_menu_style"></div>
</div>
@stop 

@section('content')

<div style="margin-left: 300px;">
	<h2>New Circle</h2>
	
	{{ Form::open(array('route' => 'circles.store')) }}
	        {{ Form::label('name', 'Name') }}
	        <br>
	        {{ Form::text('name') }}
			<br>
	        {{ Form::submit('Create', array('class' => 'btn btn-default')) }}
	{{ Form::close() }}
	
	@if ($errors->any())
	    <ul>
	        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
	    </ul>
	@endif
</div>

@stop


