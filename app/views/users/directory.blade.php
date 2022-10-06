@extends('layouts.bootstrap')

@section('submenu')
<div class="small_menu_container_style">
	<div class="small_left_menu_style"></div>
	<ul class="text7_style">
		<center>
			{{ link_to_route('directory', 'Directory',array(), array('class' => 'submenu_item active')) }}
		</center>
		<li class="small_orange_menu_divider_style"></li>
	</ul>
	<div class="small_right_menu_style"></div>
</div>
@stop 


@section('content')

	<div class="container">
		<h3>My Circles' Directory</h3>
		<table class="table table-bordered tablesorter tablepaginator">
			<thead>
				<tr>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Circles it belongs to</th>
				</tr>
			</thead>
			<tbody>
		
				@foreach ($userMyCircles as $visibleUser)
				<tr>
					<td align="center">{{ $visibleUser->id }}</td>
					<td>{{{ $visibleUser->first_name }}}</td>
					<td>{{{ $visibleUser->last_name }}}</td>
					
					<td>
					@foreach ($visibleUser->circles as $visibleUserCircle)
						{{{ $visibleUserCircle->name }}} 
					@endforeach
					</td>
				</tr>
				@endforeach
		
			</tbody>
		</table>
		
		<h3>Public Directory</h3>
		<table class="table table-bordered tablesorter tablepaginator">
			<thead>
				<tr>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Circles it belongs to</th>
				</tr>
			</thead>
			<tbody>
		
				@foreach ($users as $visibleUser)
				<tr>
					<td>{{{ $visibleUser->first_name }}}</td>
					<td>{{{ $visibleUser->last_name }}}</td>
					
					<td>
					@foreach ($visibleUser->circles as $visibleUserCircle)
						{{{ $visibleUserCircle->name }}} 
					@endforeach
					</td>
				</tr>
				@endforeach
		
			</tbody>
		</table>
	</div>

@stop



						