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

<div class="well text-center">
	<weak>Current Status:</weak> <strong>{{ $contact->getStatus() }}</strong>
</div>

<div class="panel panel-default">
  <div class="panel-heading">Reason</div>
  <div class="panel-body">
  	<p>{{ $dispute->getReasonReadable() }}</p>
    <h6>{{ $dispute->reason_description }}</h6>
  </div>
</div>

<div>
	{{ Form::model($contact, array('class' => 'validate-form', 'method' => 'PATCH', 'route' => array('contacts.update', $contact->id))) }}
	    <ul>
	        <li>
	            {{ Form::label('first_name', 'First Name*') }}
	            {{ Form::text('first_name', null, array('required' => 'required')) }}
	        </li>

	        <li>
	            {{ Form::label('last_name', 'Last Name*') }}
	            {{ Form::text('last_name', null, array('required' => 'required')) }}
	        </li>
	
	        <li>
	            {{ Form::label('company', 'Company*') }}
	            {{ Form::text('company', null, array('required' => 'required')) }}
	        </li>
	        
	        <li>
	            {{ Form::label('title', 'Title*') }}
	            {{ Form::text('title', null, array('required' => 'required')) }}
	        </li>
	
	        <li>
	            {{ Form::label('email', 'Email*') }}
	            {{ Form::text('email', null, array('required' => 'required')) }}
	        </li>
	
	        <li>
	            {{ Form::label('direct', 'Direct Phone*') }}
	            {{ Form::text('direct', null, array('class' => 'phoneinput', 'required' => 'required')) }}
	        </li>
	        
	        <li>
	            {{ Form::label('direct_ext', 'Extension') }}
	            {{ Form::text('direct_ext') }}
	        </li>
	        
	        <li>
	            {{ Form::label('cell', 'Cell Phone') }}
	            {{ Form::text('cell') }}
	        </li>
	        
	        <li>
	            {{ Form::label('general', 'General Phone') }}
	            {{ Form::text('general') }}
	        </li>
	        
	        <li>
	            {{ Form::label('general_ext', 'Extension') }}
	            {{ Form::text('general_ext') }}
	        </li>
	        
	        <li>
	            {{ Form::label('state', 'State') }}
	            {{ Form::text('state') }}
	        </li>
	        
	        <li>
	            {{ Form::label('city', 'City') }}
	            {{ Form::text('city') }}
	        </li>
	
			<li>
	            {{ Form::label('notes', 'Notes') }}
	            {{ Form::textarea('notes') }}
	        </li>
	        
	        <li>
	            {{ Form::label('intro_available', 'Name Drop:') }}
	            {{Form::select('intro_available', array(0 => 'No',1 => 'Yes'), $contact->intro_available)}}
	        </li>
	        
	        <li>
	            {{ Form::label('opportunity', 'Live Opportunity:') }}
	            {{Form::select('opportunity', array(0 => 'No',1 => 'Yes'), $contact->opportunity)}}
	        </li>
	        
	        <li>
	            {{ Form::label('opportunity_description', 'Opportunity Description') }}
	            {{ Form::textarea('opportunity_description') }}
	        </li>
	        
	    </ul>
	{{ Form::close() }}
	
	<hr>
	<h3>Resolve dispute</h3>

	<p>Seller previous offenses: <strong>{{ $sellerPreviousOffenses }}</strong></p>

	<weak>Fill manually the report that will be attached to the seller and buyer emails</weak>
	<form action="/admin/resolve-dispute/{{ $dispute->id }}" method="post">
		<label for="report">Report</label>
		<textarea class="form-control" name="report"></textarea>

		<weak>Resolve this pending dispute</weak>
		<select class="form-control" name="resolution">
			<option value="{{ ContactDispute::$RESOLUTION_ACCEPTED }}">Accept</option>
			<option value="{{ ContactDispute::$RESOLUTION_DECLINED }}">Decline</option>
		</select>

		<button type="submit" class="btn btn-danger">Submit</button>
	</form>


</div>

<br>

@stop