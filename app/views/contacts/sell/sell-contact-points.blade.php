@extends('layouts.bootstrap')

@section('content')

	<div class="breadcrumb">
		<h1>Selling <a href="javascript:showModalContent('/modal-contact-edit/{{$contact->id}}')">{{{ $contact->first_name }}} {{{ $contact->last_name }}}</a> for points</h1>
	</div>

	<h3></h3>

	<form class="validate-form" action="{{ URL::route('put-contact-sell-points', $contact->id) }}" method="POST">

		<div class="row rowspace">
			<div class="col-md-12">
				<h5>To which circles would you like to sell this contact?</h5>

				@foreach ($user->circles as $circle)
					<div>
						<input class='sell-circle-option' value="{{ $circle->id }}" name="circles_id[]" type="checkbox">
						<label>{{$circle->name}}</label>
					</div>
				@endforeach

			</div>
		</div>
		<hr>

		<div class="row">
			<div class="col-md-12">
				<input class="sell-type-option" type="checkbox"
				<label>I would like to sell this contact anonymously. My contact information will never be revealed to the buyer <strong>(2 point)</strong>.</label>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<input class="sell-type-option" onclick="showNameDrop()" id="intro_available" name="contact[intro_available]" type="checkbox" {{ $contact->intro_available ? 'checked' : '' }}>
				<label for="intro_available">I would like to sell this contact and reveal my name to the buyer so they can use it as a "name drop" <strong>(4 points).</strong></label>
			</div>
		</div>

		<div class="row rowspace">
			<div class="col-md-12">
				<input class="sell-type-option" onclick="showOpportDetails()" id="opportunity" name="contact[opportunity]" type="checkbox" {{ $contact->opportunity ? 'checked' : '' }}>
				<label for="opportunity">I would like to sell this contact, reveal my name to the buyer, and there is a live opportunity attached to it <strong>(5 points)</strong>.</label>
			</div>
		</div>

		<div class="row rowspace display-none" id="oppotunity-details1">
			<div class="col-md-12">
				<input class="form-control" name="contact[opportunity_title]" placeholder="Title of opportunity">
				<br>
				<textarea rows="10" class="form-control" name="contact[opportunity_description]" placeholder="Describe opportinuty in more than 40 characters"></textarea>
			</div>
		</div>

		<div class="row rowspace">
			<div class="col-md-3 display-none" id="relationship">
				<select name="contact[relationship]" class="form-control">
					<option value="Other">Relationship to Contact</option>
					<option value="Associate">Associate</option>
					<option value="Current Vendor">Current Vendor</option>	
					<option value="Perspective Client">Perspective Client</option>	
				</select>					
			</div>
			<div id="oppotunity-details2" class="display-none">
				<div class="col-md-3">
					<select name="contact[project_size]" class="form-control">
						<option value="Undetermined">Project Size</option>
						<option value="Undetermined">Undetermined</option>
						<option value="$1 - $5,000">$1 - $5,000</option>
						<option value="$5,001 - $25,000">$5,001 - $25,000</option>
						<option value="$25,001 - $100,000">$25,001 - $100,000</option>
						<option value="Over $100,000">Over $100,000</option>
					</select>
				</div>

				<div class="col-md-6">
					<input id="datepicker" class="form-control" type="text" name="contact[expiration]" placeholder="Expiration date of lead">
				</div>
			</div>
		</div>

		<button type="submit" class="btn btn-default">Finish and sell</button>
	</form>	

	<script>
		var override_menu = 'sell-a-lead';
		var override_active_submenu = 'sell-contact-link';

		var metrics = [
			['.sell-circle-option', function(x){ return atLeastOne(x, '.sell-circle-option'); }, 'You must select at least one circle'],
		    ['.sell-type-option', function(x){ return atLeastOne(x, '.sell-type-option'); }, 'You must select at least one option']
		];
	</script>
@stop
