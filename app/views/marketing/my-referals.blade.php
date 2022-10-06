@extends('layouts.bootstrap')

@section('submenu')
<div class="small_menu_container_style">
	<div class="small_left_menu_style"></div>
	<ul class="text7_style">

		<center>
			<a href="/invite-friends" class="submenu_item">Invite Friend</a>
		</center>
		<li class="small_orange_menu_divider_style"></li>
		
		<center>
			<a href="/my-referals" class="submenu_item active">Sent invitations</a>
		</center>
		<li class="small_orange_menu_divider_style"></li>
		
	</ul>
	<div class="small_right_menu_style"></div>
</div>
@stop 

@section('content')

<div class="" style="margin-bottom: 40px;">

	<table class="table table-bordered">
		<thead>
			<tr>
				<th>To</th>
				<th>Subject</th>
				<th>Message</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>

			@foreach ($user->referals as $referal)
				<td>{{{ $referal->to }}}</td>
				<td>{{{ $referal->subject }}}</td>
				<td>{{{ substr($referal->message, 0, 40) . '...' }}}</td>
				<td align="center">{{ $referal->getStatus() }}</td>
			@endforeach

		</tbody>
	</table>

</div>



@stop
