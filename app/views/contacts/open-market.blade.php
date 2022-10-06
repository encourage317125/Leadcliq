@extends('layouts.bootstrap')

@section('submenu')
<div class="small_menu_container_style">
	<div class="small_left_menu_style"></div>
	<ul class="text7_style">

		<center>{{ link_to_route('contacts.create', 'New Contact',array(), array('class' => 'submenu_item')) }}</center>
		<li class="small_orange_menu_divider_style"></li>

		<center>
			<a href="/my-contacts" class="submenu_item">My Contacts</a>
		</center>
		<li class="small_orange_menu_divider_style"></li>
		<center>
			<a href="/sell-contacts" class="submenu_item">Sell Contacts</a>
		</center>
		<li class="small_orange_menu_divider_style"></li>
		<center>
			<a href="/buy-contacts" class="submenu_item active">Buy Contacts</a>
		</center>
	</ul>
	<div class="small_right_menu_style"></div>
</div>
@stop 

@section('content')

<div class="">

	<h3>Open Market of Contacts</h3>

		<br><br>

		<table class="table table-bordered tablesorter tablepaginator">
			<thead>
				<tr>
					<th>Name</th>
					<th>Title</th>
					<th>Company</th>
					<th>City</th>
					<th>State</th>
					<th width="50">Drop Name</th>
					<th width="50">Live Opportunity</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
	
			@foreach ($contacts as $contact)
				<tr class='{{{ ($contact->intro_available == 1) ? 'intro-avail' : '' }}}'>
					<td align="center">X</td>
					<td>{{{ $contact->title }}}</td>
					<td>{{{ $contact->company }}}</td>
					<td>{{{ $contact->city }}}</td>
					<td>{{{ $contact->state }}}</td>
					<td align="center">{{{ ($contact->intro_available == 1) ? 'Yes' : 'No' }}}</td>
					<td align="center">{{{ ($contact->opportunity == 1) ? 'Yes' : 'No' }}}</td>
					
					@if($contact->user_id != $user->id)
						<td align="center">
	                        {{ Form::open(array('method' => 'POST', 'route' => array('buy-contact', $contact->id, 0))) }}
	                            {{ Form::submit('Buy', array('class' => 'btn btn-success')) }}
	                        {{ Form::close() }}
	                    </td>
	                 @else
	                 	<td align="center" class="text-info">Owner</td>
	                 @endif
				</tr>
			@endforeach
	
			</tbody>
		</table>

</div>

@stop
