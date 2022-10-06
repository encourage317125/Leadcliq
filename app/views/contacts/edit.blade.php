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
			<a href="/buy-contacts" class="submenu_item">Buy Contacts</a>
		</center>
	</ul>
	<div class="small_right_menu_style"></div>
</div>
@stop 

@section('content')


<div>
	<div class="breadcrumb">
		<h1>Edit Contact</h1>
	</div>

	{{ Form::model($contact, array('class' => 'validate-form', 'method' => 'PATCH', 'route' => array('contacts.update', $contact->id))) }}
	    <div class="row rowspace">
					<div class="col-md-6">
						<label>First Name</label>
						<input class="form-control" value="{{$contact->first_name}}" required name="first_name" placeholder="First Name" ></input>
					</div>
					<div class="col-md-6">
						<label>Last Name</label>		
						<input class="form-control" value="{{$contact->last_name}}" required name="last_name" placeholder="Last Name" ></input>
					</div>
				</div>

				<div class="row rowspace">
					<div class="col-md-6">
						<label>Company</label>
						<input class="form-control" value="{{$contact->company}}" required name="company" placeholder="Company" ></input>
					</div>
					<div class="col-md-6">
						<label>Title</label>
						<input class="form-control" value="{{$contact->title}}" required name="title" placeholder="Title" ></input>
					</div>
				</div>

				<div class="row rowspace">
					<div class="col-md-6">
						<label>Phone</label>
						<input class="form-control phoneinput" value="{{$contact->direct}}" required name="direct" placeholder="Direct Phone" ></input>
					</div>
					<div class="col-md-6">
						<label>Phone Extension</label>
						<input class="form-control" value="{{$contact->direct_ext}}" name="direct_ext" placeholder="Extension" ></input>
					</div>
				</div>

				<div class="row rowspace">
					<div class="col-md-6">
						<label>Cell Phone</label>
						<input class="form-control phoneinput" value="{{$contact->cell}}" name="cell" placeholder="Cell Phone" ></input>
					</div>
					<div class="col-md-6">
						<label>Email</label>
						<input type="email" class="form-control" value="{{$contact->email}}" required name="email" placeholder="Email" ></input>
					</div>
				</div>

				<div class="row rowspace">
					<div class="col-md-4">
						<input class="form-control" onblur="getCity(this.value)" value="{{$contact->zip}}" required id="zip" name="zip" placeholder="Zip Code" ></input>
					</div>
					<div class="col-md-4">
						<input class="form-control" value="{{$contact->city}}" required id="city" name="city" placeholder="City" readonly=""></input>
					</div>
					<div class="col-md-4">
						<input class="form-control" value="{{$contact->state}}" required id="state" name="state" placeholder="State" readonly=""></input>
					</div>
				</div>

				<div class="row rowspace">
					<div class="col-md-12">
						<label>Notes about this contact (will be shared with buyers)</label>
						<textarea class="form-control" name="notes" placeholder="Notes about this contact (will be shared with buyers)">{{$contact->notes}}</textarea>
					</div>
				</div>

	        	
				<div class="row rowspace">
					<div class="col-md-12">
	            		{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
						<a class="btn btn-danger pull-right" href="javascript:toggleContent('delete-contact-div')">Delete this contact</a>        	
					</div>
				</div>

	{{ Form::close() }}
	
	@if ($errors->any())
	    <ul>
	        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
	    </ul>
	@endif
</div>


<br>

<div id="delete-contact-div" class="display-none">
	<div class="alert alert-warning">
		<span class="pull-right selectable glyphicon glyphicon-remove-circle" onclick='toggleContent("delete-contact-div");'></span>
		<div >
			<p>Are you sure sure you want to delete this contact? You can't take it back.</p>
			<form action="/delete-contact/{{$contact->id}}" method="POST">
				<button type="submit" class="btn btn-danger">Yes delete</button>
			</form>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default text-center">
			<div class="panel-heading">
				<weak>Current Status:</weak> <strong>{{ $contact->getStatus() }}</strong>
			</div>
			<div class="panel-body">
				@if($contact->getRawStatus() == ContactTransaction::$CONTACT_FOR_SELL)
					{{ Form::open(array('route' => array('put-private', $contact->id))) }}
						{{ Form::submit('Remove from market', array('class' => 'btn btn-default')) }}
					{{ Form::close() }}
				@endif

				@if($contact->getRawStatus() == ContactTransaction::$CONTACT_PRIVATE)
					<a class="btn btn-default" href="{{ URL::route('sell-contact-how', $contact->id)}}">Put it for sale!</a>
				@endif

			</div>
			@if($contact->getRawStatus() == ContactTransaction::$CONTACT_PRIVATE)
				<div class="panel-footer">
					<h5><small>Only you are able to view this contact's information.</small></h5>
				</div>
			@endif
		</div>
	</div>
</div>

</div>


<script>
	var metrics = [	
    	[ '#first_name', 'min-length:2', 'Must be at least 2 characters long' ],
        [ '#last_name', 'min-length:2', 'Must be at least 2 characters long' ]
    ];
</script>

@stop