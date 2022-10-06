@extends('layouts.bootstrap')

@section('content')

	<div class="breadcrumb">
		<h1>Selling <a href="javascript:showModalContent('/modal-contact-edit/{{$contact->id}}')">{{{ $contact->first_name }}} {{{ $contact->last_name }}}</a> for money</h1>
		<p>You can sell the contact for one price, or stablish multiple pay out points.</p>
        <p class="alert alert-warning">
            <strong>Important!: </strong>Transactions taking place on “merit system”. <br/>
            Any violation of this merit system will immediately result in your account termination. <br/>
            A buyer for your contact will have to click a buy now button to be taken to Paypal. After they send you money via Paypal it will be up to you to mark as paid and release the contact. Users will still be able to bid on it until you mark it as paid. You will be responsible for accepting ONLY ONE payment from potential bidders (if you accidentally accept too many you can additionally refund the payment). <br/>
            We are currently implementing a smoother payment system.
        </p>
	</div>

	<h3></h3>

	<form action="{{ URL::route('put-contact-sell-money', $contact->id) }}" method="POST">

		<div class="row">
			<div class="col-md-12">
				<input onclick="showOfferPrice()" id="anonymous_one_price" name="anonymous_one_price" type="checkbox">
				<label>Just sell this contact anonymously for one price, regardless of whether a sale is made off of it or not.</label>
			</div>
		</div>

		<div class="row rowspace">
			<div class="col-md-12">
				<input onclick="showOfferPrice()" id="intro_available" name="intro_available" type="checkbox">
				<label>Sell this contact and release my name to buyer, and the buyer is free to use my name ("name drop").</label>
			</div>
		</div>

		<div class="row rowspace display-none" id="price-wrap">
			<div class="col-md-4">
				<input type="number" class="form-control" name="price" placeholder="Lead Price?">
			</div>
		</div>

		<div class="row rowspace">
			<div class="col-md-12">
				<input onclick="selectCheckpoints()" id="has_checkpoints" name="has_checkpoints" type="checkbox">
				<label>Set custom lead price based on multiple check points.</label>
			</div>
		</div>

		<div class="row rowspace">
			<div class="col-md-10">
				<input id="is_anonymous" name="is_anonymous" type="checkbox">
				<label>I would like to remain anonymous in this referral.</label>
			</div>
		</div>


		<div class="display-none" id="checkpoints-wrap">
			<div id="checkpoint_1">
				<div class="row rowspace">
					<div class="col-md-2">
						<a href="#" class="btn btn-default">Check Point 1</a>
					</div>
					<div class="col-md-10">
						<input class="form-control" placeholder="Title" name="checkpoints[checkpoint_1[][title]]" type="text">
					</div>
				</div>

				<div class="row rowspace">
					<div class="col-md-12">
						<textarea rows="6" class="form-control" name="checkpoints[checkpoint_1[][description]]" placeholder="Describe agreemnt - Check Point 1"></textarea>
					</div>
				</div>

				<div class="row rowspace">
					<div class="col-md-6">
						<input type="number" class="form-control" name="checkpoints[checkpoint_1[][price]]" placeholder="Check Point 1 Price?">
					</div>
				</div>
			</div>

			<div class="row rowspace">
				<div class="col-md-6">
					<a href="javascript:addCheckpoint()">Add Another +</a>
				</div>
			</div>

		</div>

		<button type="submit" class="btn btn-default">Finish and sell</button>

	</form>	

	<script>
		var override_menu = 'sell-a-lead';
		var override_active_submenu = 'sell-contact-link';
	</script>
@stop
