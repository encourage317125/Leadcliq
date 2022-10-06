@extends('layouts.bootstrap')

@section('content')

	<div class="breadcrumb">
		<h1>Sell <a href="javascript:showModalContent('/modal-contact-edit/{{$contact->id}}')">{{{ $contact->first_name }}} {{{ $contact->last_name }}}</a> contact now!</h1>
		<p>You can sell this contact for points or money.</p>
	</div>


	<div class="row">
		<div class="col-md-6">
			<div class="strong-border text-center extra-padding">
				<span class="glyphicon glyphicon-usd gl-lg extra-bottom text-success"></span>
				<p class="text-muted extra-bottom">Get paid in real money for this contact</p>
				<hr class="extra-bottom">
				<a href="{{URL::route('sell-contact-money', $contact->id)}}" class="btn btn-default btn-lg">Sell this contact for money</a>
			</div>
		</div>

		<div class="col-md-6">
			<div class="strong-border text-center extra-padding">
				<span class="glyphicon glyphicon-heart gl-lg extra-bottom text-info"></span>
				<p class="text-muted extra-bottom">Get points to use in Ledcliq and buy more leads</p>
				<hr class="extra-bottom">
				<a href="{{URL::route('sell-contact-points', $contact->id)}}" class="btn btn-default btn-lg">Sell this contact for points</a>
			</div>
		</div>
	</div>

	</form>	

	<script>
		var override_menu = 'sell-a-lead';
		var override_active_submenu = 'sell-contact-link';
	</script>

@stop
