@extends('layouts.bootstrap')

@section('content')

@if (isset($message))
<p class="alert alert-success">$message</p>
@endif
<div style="margin-bottom: 40px;">

	<table id="myTable" class="table table-bordered tablesorter tablepaginator">
		<thead>
			<tr>
				<th>Name</th>
				<th>Title</th>
				<th>City</th>
				<th>State</th>
				<th>Company</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>

			@foreach ($user->contacts as $contact)
			<tr class="{{{ $contact->getStatus() }}}">
				<td><a href="/contacts/{{$contact->id}}/edit">{{{ $contact->first_name }}} {{{ $contact->last_name }}}</a></td>
				<td>{{{ $contact->title }}}</td>
				<td>{{{ $contact->city }}}</td>
				<td>{{{ $contact->state }}}</td>
				<td>{{{ $contact->company }}}</td>
				
				<td><weak>{{{ $contact->getStatus() }}}</weak></td>
			</tr>
			@endforeach

		</tbody>
	</table>
	
</div>

<h3>Bought Contacts</h3>

<div>
	<table class="table table-bordered table-striped tablesorter tablepaginator">
		<thead>
			<tr>
				<th>Name</th>
				<th>Title</th>
				<th>City</th>
				<th>State</th>
				<th>Company</th>
				<th>Purchased</th>
				<th>Dispute</th>
			</tr>
		</thead>
		<tbody>

			@foreach ($user->boughtContacts as $t)
				@if(($contact = $t->contact($t->contact_id)) != false && $contact->getRawStatus() == ContactTransaction::$CONTACT_SOLD)
				<tr>
					<td><a href="javascript:showModalContent('/show-bougth-contact/{{$contact->id}}')">{{{ $contact->first_name }}} {{{ $contact->last_name }}}</a></td>
					<td>{{{ $contact->title }}}</td>
					<td>{{{ $contact->city }}}</td>
					<td>{{{ $contact->state }}}</td>
					<td>{{{ $contact->company }}}</td>
					<td align="center">{{ (new DateTime($t->created_at))->format('m-d-Y') }}</td>
					<td align="center">
						<a href="/contact/{{ $t->id }}/prepare-dispute">
							<span class="glyphicon glyphicon-bell"></span>
						</a>
					</td>
				</tr>
				@endif
			@endforeach

			@foreach ($user->disputes as $t)
				@if(($contact = $t->contact($t->contact_id)) != false)
				<tr>
					<td><a href="javascript:showModalContent('/show-bougth-contact/{{$contact->id}}')">{{{ $contact->first_name }}} {{{ $contact->last_name }}}</a></td>
					<td>{{{ $contact->title }}}</td>
					<td>{{{ $contact->city }}}</td>
					<td>{{{ $contact->state }}}</td>
					<td>{{{ $contact->company }}}</td>
					<td align="center">{{ (new DateTime($t->created_at))->format('m-d-Y') }}</td>
					<td align="center"><h6>{{ $t->getStatusReadable() }}</h6></td>
				</tr>
				@endif
			@endforeach

		</tbody>
	</table>

</div>


@stop
