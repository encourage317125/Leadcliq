@extends('layouts.bootstrap')

@section('submenu')

@stop 

@section('content')

<h3>Contacts Open Disputes</h3>

<div class="" style="margin-bottom: 40px;">

	<table class="table table-bordered table-striped tablesorter tablepaginator">
		<thead>
			<tr>
				<th>Name</th>
				<th>Title</th>
				<th>Company</th>
				<th>Purchased</th>
				<th>Reason</th>
				<th>Status</th>
				<th>Resolution</th>
			</tr>
		</thead>
		<tbody>

			@foreach ($disputes as $t)
				@if(($contact = $t->contact($t->contact_id)) != false)
				<tr>
					<td><a href="/admin/contact-dispute/{{ $t->id }}">{{{ $contact->first_name }}} {{{ $contact->last_name }}}</a></td>
					<td>{{{ $contact->title }}}</td>
					<td>{{{ $contact->company }}}</td>
					<td align="center">{{ (new DateTime($t->created_at))->format('m-d-Y') }}</td>
					<td>{{ $t->getReasonReadable() }}</td>
					<td align="center"><weak class="{{$t->getStatusReadable()}}">{{ $t->getStatusReadable() }}</weak></td>
					<td align="center"><weak class="{{$t->getResolutionReadable()}}">{{ $t->getResolutionReadable() }}</weak></td>
				</tr>
				@endif
			@endforeach

		</tbody>
	</table>

</div>


@stop
