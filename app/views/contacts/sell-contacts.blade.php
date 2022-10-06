@extends('layouts.bootstrap')

@section('content')

<div class="" style="margin-bottom: 40px;">

	<table class="table table-bordered tablesorter tablepaginator" width="100%">
		<thead>
			<tr>
				<th>Name</th>
				<th>Company</th>
				<th>Title</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>

			@foreach ($user->contacts as $contact)
				@if($contact->getRawStatus() == ContactTransaction::$CONTACT_PRIVATE)
					<tr class="{{{ $contact->getStatus() }}}">
						<td><a href="javascript:showModalContent('/modal-contact-edit/{{$contact->id}}')">{{{ $contact->first_name }}} {{{ $contact->last_name }}}</a></td>

						<td>{{{ $contact->company }}}</td>
						<td>{{{ $contact->title }}}</td>
						<td align="center"><a class="btn btn-default" href="{{ URL::route('sell-contact-how', $contact->id) }}">Sell</a></td>
					</tr>				
				@endif
			@endforeach

		</tbody>
	</table>
	

</div>

<script>
		var override_menu = 'sell-a-lead';
		var override_active_submenu = 'sell-contact-link';
	</script>

@stop
