@extends('layouts.bootstrap')


@section('content')

	<div class="row">
		<div class="col-md-6">

		<div class="breadcrumb">
			<h1>
				Earn 1 Point!
			</h1>
			<p>
				for LIVE CONTACTS released within your network.
				Only "released" contacts earn points. This is when an active
				member has interest in your contact and an originator 
				releases a CONTACT.
			</p>
		</div>

			<form class="validate-form" action="{{URL::route('contacts.store')}}" method="POST">
				<div class="row rowspace">
					<div class="col-md-6">
						<input class="form-control" value="{{Input::old('first_name')}}" required name="first_name" placeholder="First Name" ></input>
					</div>
					<div class="col-md-6">
						<input class="form-control" value="{{Input::old('last_name')}}" required name="last_name" placeholder="Last Name" ></input>
					</div>
				</div>

				<div class="row rowspace">
					<div class="col-md-6">
						<input class="form-control" value="{{Input::old('company')}}" required name="company" placeholder="Company" ></input>
					</div>
					<div class="col-md-6">
						<input class="form-control" value="{{Input::old('title')}}" required name="title" placeholder="Title" ></input>
					</div>
				</div>

				<div class="row rowspace">
					<div class="col-md-6">
						<input class="form-control phoneinput" value="{{Input::old('direct')}}" required name="direct" placeholder="Direct Phone" ></input>
					</div>
					<div class="col-md-6">
						<input class="form-control" value="{{Input::old('direct_ext')}}" name="direct_ext" placeholder="Extension" ></input>
					</div>
				</div>

				<div class="row rowspace">
					<div class="col-md-6">
						<input class="form-control phoneinput" value="{{Input::old('cell')}}" name="cell" placeholder="Cell Phone" ></input>
					</div>
					<div class="col-md-6">
						<input type="email" class="form-control" value="{{Input::old('email')}}" required name="email" placeholder="Email" ></input>
					</div>
				</div>

				<div class="row rowspace">
					<div class="col-md-4">
						<input class="form-control" onblur="getCity(this.value)" value="{{Input::old('zip')}}" required id="zip" name="zip" placeholder="Zip Code" >
					</div>
					<div class="col-md-4">
						<input class="form-control" value="{{Input::old('city')}}" required id="city" name="city" placeholder="City" readonly="">
					</div>
					<div class="col-md-4">
						<input class="form-control" value="{{Input::old('state')}}" required id="state" name="state" placeholder="State" readonly="">
					</div>
				</div>

				<div class="row rowspace">
					<div class="col-md-12">
						<textarea class="form-control" value="{{Input::old('notes')}}" name="notes" placeholder="Notes about this contact (will be shared with buyers)"></textarea>
					</div>
				</div>

				<div class="row rowspace">
					<div class="col-md-12">
						<p>You are about to earn 1 point! Which circle do you want it to go to?</p>				
						<select name="circle_id" class="form-control" value="{{Input::old('first_name')}}" required>
							@foreach ($user->circles as $circle)
								<option value="{{ $circle->id }}">{{{ $circle->name }}}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="row rowspace">
					<div class="col-md-12">
				        <button type="submit" class="btn btn-default stretch">Create contact</button>
					</div>
				</div>
			</form>
			
			@if ($errors->any())
		    <ul>
		        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
		    </ul>
			@endif
		</div>		
	
		<div class="col-md-5 col-md-offset-1">

			<div class="row rowspace">
				<div class="col-md-12 soft-border">
					<img class="stretch" src="/images/two-dudes-handshake.jpg"> 
					<p>
						<strong>Anonymous? Or Not?</strong><br>
						LIVE CONTACTS in our databse have
						anonymous originators, unless REFERENCE
						or LIVE OPPORTUNITY options above are 
						chosen. The accuracy of LIVE CONTACTS
						that are released will direclty impact your
						credibility feedback.
					</p>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 strong-border">
					Have more than one contact to upload?
					<span><button class="btn btn-default" onclick="javascript:openModal();">Upload List</button></span>
				</div>
			</div>

		</div>

	</div>
	@include('contacts.modal.select-file-upload')

<script>
	var metrics = [	
    	[ '#first_name', 'min-length:2', 'Must be at least 2 characters long' ],
        [ '#last_name', 'min-length:2', 'Must be at least 2 characters long' ]
    ];

	var override_menu = 'sell-a-lead';
	var override_active_submenu = 'create-contact-link';
</script>

@stop


