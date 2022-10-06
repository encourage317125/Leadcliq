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

<div id="circles" class="container">
	<h2>Circles I belong to</h2>

	@if($user->circles->count() > 0)
		<table class="table table-striped">
		    <tbody>
		    	@foreach ($user->circles as $circle)
		    	    <tr valign="middle">
		            	<td>{{{ $circle->name }}}</td>
		            	
		            	<td align="center" >{{ link_to_route('circles.show', 'Show', array($circle->id)) }}</td>

		            	@if(Sentry::getUser()->is_admin)
		            		<td align="center" >
			            	{{ Form::open(array('method' => 'DELETE', 'route' => array('circles.destroy', $circle->id))) }}
		                            {{ Form::submit('Delete', array('class' => 'btn btn-default')) }}
		                    {{ Form::close() }}
			            	</td>
		            	@endif
		            	

		            	<td align="center" >
	                        {{ Form::open(array('method' => 'POST', 'route' => array('circles.leave', $circle->id))) }}
	                            {{ Form::submit('Leave', array('class' => 'btn btn-default')) }}
	                        {{ Form::close() }}
	                    </td>           
		        	</tr>
				@endforeach
		    </tbody>
		</table>
	@else
		<h5>You currently belong to no circles. Please select Join Circle button and select circles.</h5>
	@endif
	
	
</div><!-- End #circles -->

@stop



						