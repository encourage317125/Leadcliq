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

<h1>Edit Cricle</h1>
{{ Form::model($circle, array('method' => 'PATCH', 'route' => array('circles.update', $circle->id))) }}
    <ul>
        <li>
            {{ Form::label('name', 'Name:') }}
            {{ Form::text('name') }}
        </li>

        <li>
            {{ Form::submit('Update', array('class' => 'btn btn-info')) }}
            {{ link_to_route('circles.show', 'Cancel', $circle->id, array('class' => 'btn')) }}
        </li>
    </ul>
{{ Form::close() }}

@if ($errors->any())
    <ul>
        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
    </ul>
@endif

@stop