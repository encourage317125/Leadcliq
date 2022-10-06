@extends('layouts.bootstrap')

@section('submenu')
<div class="small_menu_container_style">
	<div class="small_left_menu_style"></div>
	<ul class="text7_style">
		<center>
			{{ link_to_route('circles.index', 'Join Circles',array(), array('class' => 'submenu_item active')) }}
		</center>
		<li class="small_orange_menu_divider_style"></li>
	</ul>
	<div class="small_right_menu_style"></div>
</div>
@stop 

@section('content')

<h2>All Available Circles</h2>

@if ($circles->count())
    <table class="table table-striped">
        <tbody>
            @foreach ($circles as $circle)
            	@if($user->belongsToCircle($circle->id) == false)
	                <tr>
	                    <td>{{{ $circle->name }}}</td>
	         			<td align="center">
	                        {{ Form::open(array('method' => 'POST', 'route' => array('circles.join', $circle->id))) }}
	                            {{ Form::submit('Join', array('class' => 'btn btn-default')) }}
	                        {{ Form::close() }}
	                    </td>           
	                </tr>
	        	@endif
            @endforeach
        </tbody>
    </table>
@else
    There are no circles
@endif

@stop