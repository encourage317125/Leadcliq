@extends('layouts.bootstrap')

@section('content')

<div class="breadcrumb">
	<div class="row">
		<div class="col-md-6">
			<h1>Buy a Contact</h1>
			<p>Buy a contact using points or real money.</p>
		</div>
		<div class="col-md-6">
			<form action="{{URL::route('buy-contacts')}}" method="GET" class="">
				<select name="circle" onchange="this.form.submit()" class="form-control select-cirlce">
					<option value="">Start Here: Select a Circle</option>
					<option {{ Input::get('circle') == 'open-market' ? "selected":""}} value="open-market">Open Market</option>
						@foreach($user->circles as $selectCircle)
							<option {{ $selectCircle->id == Input::get('circle') ? "selected" : "" }} value="{{ $selectCircle->id }}">{{ $selectCircle->name }}</option>
						@endforeach	
				</select>
			</form>
		</div>
	</div>
</div>

@if($circle_id)
		<weak>Available points in this circle: {{ $points }}</weak>
		<br><br>

		<table class="table table-bordered tablesorter tablepaginator">
			<thead>
				<tr>
					<th>Posted</th>
					<th>Title</th>
					<th>Company</th>
					<th>Location</th>

					<th width="30">Anonymous</th>
					<th width="30">Name Drop</th>
					<th width="30">Live Opportunity</th>

					<th>Price</th>
					<th>Buy</th>
					<th>Seller</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
	
			@foreach ($contacts as $contact)
				<tr>
					<td>{{ (new DateTime($contact->created_at))->format('m-d-Y') }}</td>
					<td>{{{ $contact->title }}}</td>
					<td>{{{ $contact->company }}}</td>
					<td>{{ $contact->city }}, {{ $contact->state }}</td>

					<td align="center"><span class="glyphicon {{($contact->intro_available) ? '':'glyphicon-ok'}}"></span></td>
					<td align="center"><span class="glyphicon {{($contact->intro_available) ? 'glyphicon-ok':''}}"></span></td>
					<td align="center"><span class="glyphicon {{($contact->opportunity) ? 'glyphicon-ok':''}}"></span></td>

					<td>{{{ $contact->price }}}</td>

					<td>{{($contact->sell_open_market) ? 'US$':'Points'}}</td>
					
					<td align="center">{{ $contact->owner->getScoreAsSeller() }}</td>

					@if($contact->user_id != $user->id)
						<td align="center">
							@if($contact->sell_open_market)
							<a class="btn btn-success" href="{{ URL::route('show-pay-contact-paypal', $contact->id) }}">Buy It</a>
							@else
								{{ Form::open(array('method' => 'POST', 'route' => array('buy-contact', $contact->id, $circle_id))) }}
			                    	{{ Form::submit('Buy', array('class' => 'btn btn-success')) }}
			                    {{ Form::close() }}
							@endif
						 </td>
	                 @else
	                 	<td align="center" class="text-info">owner</td>
	                 @endif

				</tr>
			@endforeach
	
			</tbody>
		</table>
@endif


<!-- 
This sections are not yet done, uncomment this when content is


<br><br><br><br><br>
<div class="row">
	<div class="col-md-4">
		<div class="strong-border text-center extra-padding">
			<span class="glyphicon glyphicon-folder-open gl-lg extra-bottom text-success"></span>
			<p class="text-muted extra-bottom">Need to dispute a contact?</p>
			<hr class="extra-bottom">
			<a href="#" class="btn btn-default">Learn more</a>
		</div>
	</div>

	<div class="col-md-4">
		<div class="strong-border text-center extra-padding">
			<span class="glyphicon glyphicon-question-sign gl-lg extra-bottom text-info"></span>
			<p class="text-muted extra-bottom">FAQ about buying contacts</p>
			<hr class="extra-bottom">
			<a href="#" class="btn btn-default">Learn more</a>
		</div>
	</div>

	<div class="col-md-4">
		<div class="strong-border text-center extra-padding">
			<span class="glyphicon glyphicon-plus-sign gl-lg extra-bottom"></span>
			<p class="text-muted extra-bottom">How can I earn POINTS?</p>
			<hr class="extra-bottom">
			<a href="#" class="btn btn-default">Learn more</a>
		</div>
	</div>
</div>
-->




<script>
	var override_menu = 'bid-appointments';
	var override_active_submenu = 'buy-contact-link';
</script>

@stop
