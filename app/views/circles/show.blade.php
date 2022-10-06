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

<h2>Cirlce <strong>{{{ $circle->name }}}</strong> members</h2>

                    
<table class="table table-bordered tablesorter tablepaginator">
    <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
        </tr>
    </thead>

    <tbody>
    	@foreach ($users as $user)
    	    <tr>
            	<td class="t2c2">{{{ $user->first_name }}}</td>
            	<td class="t2c2">{{{ $user->last_name }}}</td>
        	</tr>
		@endforeach
    </tbody>
</table>

@stop