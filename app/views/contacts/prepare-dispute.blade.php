@extends('layouts.bootstrap')

@section('submenu')

@stop 

@section('content')

<div>
	<h3>Open Dispute over contact</h3>

	<div class="well">
		<div><strong>Name: </strong>{{ $contact->first_name }} {{ $contact->first_name }}</div>
		<div><strong>Email: </strong>{{ $contact->email }}</div>
		<div><strong>Purchased on: </strong>{{ (new DateTime($transaction->created_at))->format('m-d-Y') }}</div>
	</div>

	<form class="validate-form" action="/contact/{{$transaction->id}}/open-dispute" method="post" role="form">

		<div class="form-group">
			<label for="reason">Reason</label>
			<select class="form-control" name="reason" id="reason">
				<option value="{{ ContactDispute::$REASON_CONTACT_NOT_EXISTS }}">Contact doesn't exists</option>
				<option value="{{ ContactDispute::$REASON_CONTACT_NOT_IN_MY_BUSINESS }}">Contact not in my line of business</option>
				<option value="{{ ContactDispute::$REASON_OTHER }}">This contact is not valid for other reasons</option>
			</select>
		</div>

		<div class="form-group">
			<label for="reason_description">Please describe your issue with this contact</label>
			<textarea class="form-control" name="reason_description" id="reason_description"></textarea>
		</div>

		<input class="btn btn-danger" type="submit">
	</form>
	
	@if ($errors->any())
	    <ul>
	        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
	    </ul>
	@endif
</div>

<br>

<script>
	var metrics = [	
		[ '#reason_description', 'presence', 'Can not be empty' ],
	    [ '#reason_description', 'min-length:40', 'Must be at least 40 characters long' ],
    ];
</script>

@stop