@extends('layouts.bootstrap')


@section('content')

	<div class="row">
		<!-- Left Column -->
		<div class="col-md-6">

			<!-- Basic Info -->
			<div class="row extra-bottom">
				<div class="col-md-12">
					<div class="color-box">
						<h3>Basic Info</h3>
						<br>

						@if(!is_null($user->photo) && strlen($user->photo) > 2)
						<img src="{{$user->photo}}" alt="">			
						@else
						<img src="http://placehold.it/140x140&text=no-image" alt="">
						@endif
						<a href="{{url('profile.edit')}}">Edit</a>

						<br>
						<br>
						<div class="row text-line"><div class="col-md-4 text-muted">First Name</div><div class="col-md-8">{{ $user->first_name }}</div></div>
						<div class="row text-line"><div class="col-md-4 text-muted">Last Name</div><div class="col-md-8">{{ $user->last_name }}</div></div>
					</div>
				</div>		
			</div>

			<!-- Industry -->
			<div class="row extra-bottom">
				<div class="col-md-12">
					<div class="color-box">
						<h3>Indsutry</h3>
						<br>

						<div class="row text-line"><div class="col-md-4 text-muted">Company</div><div class="col-md-8">{{ $user->company->name }}</div></div>
						<div class="row text-line"><div class="col-md-4 text-muted">Title</div><div class="col-md-8">{{ $user->title->name }}</div></div>
						<div class="row text-line"><div class="col-md-4 text-muted">Services I provide</div><div class="col-md-8">{{ implode(', ',$user->offersServices()->lists('name')) }}</div></div>
						<div class="row text-line"><div class="col-md-4 text-muted">Industry</div><div class="col-md-8">{{ $user->industry->name }}</div></div>
					</div>
				</div>		
			</div>


		</div>

		<!-- Right Column -->
		<div class="col-md-6">

			<!-- Contact -->
			<div class="row extra-bottom">
				<div class="col-md-12">
					<div class="color-box">
						<h3>Contact</h3>
						<br>

						<div class="row text-line"><div class="col-md-4 text-muted">Email</div><div class="col-md-8">{{ $user->email }}</div></div>
						<div class="row text-line"><div class="col-md-4 text-muted">Phone</div><div class="col-md-8">{{ $user->phone }}</div></div>
						<div class="row text-line"><div class="col-md-4 text-muted">Extension</div><div class="col-md-8">{{ $user->extension }}</div></div>

						<div class="row text-line"><div class="col-md-4 text-muted">Directory Visibility</div><div class="col-md-8">{{ $user->getDirectoryStatus() }}</div></div>
					</div>
				</div>		
			</div>

			<!-- Location -->
			<div class="row extra-bottom">
				<div class="col-md-12">
					<div class="color-box">
						<h3>Location</h3>
						<br>

						<div class="row text-line"><div class="col-md-4 text-muted">Zip Code</div><div class="col-md-8">{{ $user->zip }}</div></div>
						<div class="row text-line"><div class="col-md-4 text-muted">City</div><div class="col-md-8">{{ (isset($user->city->name)?$user->city->name:'N/A') }}</div></div>
						<div class="row text-line"><div class="col-md-4 text-muted">State</div><div class="col-md-8"> {{ (isset($user->city->state->name)?$user->city->state->name:'N/A') }}</div></div>
					</div>
				</div>		
			</div>

		</div>
	</div>

	<div>{{ link_to_route('profile.destroy', 'Delete my account',array(), array('class' => 'pull-right')) }}</div>
	<div>{{ link_to_route('profile.edit', 	'Edit', 			array(), array('class' => 'btn btn-info')) }}</div>
	
@stop