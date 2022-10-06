@extends('layouts.bootstrap')


@section('content')


	{{ Form::model($user, array('class'=>'form-horizontal','method' => 'POST', 'route' => array('profile.update'))) }}
		<div class="row">
			<!-- Left Column-->	
			<div class="col-md-6">

			<!-- Photo -->
				<div class="row extra-bottom">
					<div class="col-md-12">
						<div class="color-box">
							{{ Form::open(array('files'=>'true', 'url' => array('profile/update/picture'))) }}
								@if(!is_null($user->photo) && strlen($user->photo) > 2)
								<img src="{{$user->photo}}" alt="">
								<a class="pull-right" href="{{url('profile/update/picture/delete')}}">Delete Photo</a>
								@else
								<img src="http://placehold.it/140x140&text=no-image" alt="">
								@endif
								<p>You can upload a JPG, GIF or PNG file (File size limit is 4 MB).</p>
								{{Form::file('photo')}}
								<hr>
								<input type="submit" value="Upload Photo" class="btn btn-primary">
								<br><br>
								<small>By clicking “Upload Photo,” you certify that you have the right to distribute this photo and that it does not violate the User Agreement.</small>
							</form>
						</div>			
					</div>
				</div>

				<!-- Contact -->
				<div class="row extra-bottom">
					<div class="col-md-12">
						<div class="color-box">
							<h3>Contact</h3>
							<br />
							<input class="form-control" value="{{$user->email}}" id="email" name="email" readonly="">

							<br>
							<div class="input">
								@if($errors->has('phone'))
									@foreach($errors->get('phone') as $msg)
									<span class="help-block error">{{$msg}}</span>
									@endforeach
								@endif
								<div class="text-muted">Phone*</div> 
									{{ Form::text('phone',null,array('class'=>'phoneinput form-control text-line')) }}
								</div>	
							<div class="input">
								@if($errors->has('extension'))
									@foreach($errors->get('extension') as $msg)
									<span class="help-block error">{{$msg}}</span>
									@endforeach
								@endif
								<div class="text-muted">Extension</div> 
								{{ Form::text('extension', null, array('class' => 'form-control text-line')) }}
							</div>	
							<div class="input">		
								<div class="text-muted">Directory Visibility</div>
								<select name="directory_status">
									<option {{ ($user->directory_status == User::$VISIBLE_ONLY_HIM) ? 'selected="selected"' : '' }} value="{{User::$VISIBLE_ONLY_HIM}}">Not visible</option>
									<option {{ ($user->directory_status == User::$VISIBLE_ONLY_MY_CIRCLES) ? 'selected="selected"' : '' }} value="{{User::$VISIBLE_ONLY_MY_CIRCLES}}">Only to my circles</option>
									<option {{ ($user->directory_status == User::$VISIBLE_FOR_ALL) ? 'selected="selected"' : '' }} value="{{User::$VISIBLE_FOR_ALL}}">Visible for all</option>
								</select>
							</div>
						</div>
					</div>
				</div>

				<!-- Location -->
				<div class="row extra-bottom">
					<div class="col-md-12">
						<div class="color-box">
							<h3>Location</h3>
							<br>
							<div class="row rowspace">
								<div class="col-md-4">
									<input class="form-control" onblur="getCity(this.value)" value="{{$user->zip}}" required id="zip" name="zip" placeholder="Zip Code" >
								</div>
								<div class="col-md-4">
									<input class="form-control" value="{{$user->city}}" required id="city" name="city" placeholder="City" readonly="">
								</div>
								<div class="col-md-4">
									<input class="form-control" value="{{$user->state}}" required id="state" name="state" placeholder="State" readonly="">
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row extra-bottom">
					<div class="col-md-12">
						<div class="">
							{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
							{{ link_to_route('profile', 'Cancel', null,array('class' => 'btn btn-danger')) }}
						</div>
					</div>
				</div>

			</div>


			<!-- Right Column-->	
			<div class="col-md-6">
				<div class="row extra-bottom">
					<div class="col-md-12">
						<div class="color-box">
							<h3>Basic Info</h3>
							<br>
							<div class="input">
							@if($errors->has('first_name'))
								@foreach($errors->get('first_name') as $msg)
								<span class="help-block error">{{$msg}}</span>
								@endforeach
							@endif
							<div class="text-muted">First Name*</div> 
							{{ Form::text('first_name', null, array('class' => 'form-control text-line')) }}
							</div>
							<div class="input">
								@if($errors->has('last_name'))
									@foreach($errors->get('last_name') as $msg)
									<span class="help-block error">{{$msg}}</span>
									@endforeach
								@endif
								<div class="text-muted">Last  Name*</div> 
								{{ Form::text('last_name', null, array('class' => 'form-control text-line')) }}
							</div>
							<a href="javascript:openPassword()">Change password</a>
						</div>
					</div>
				</div>

				<!-- Industry -->
				<div class="row extra-bottom">
					<div class="col-md-12">
						<div class="color-box">
						<h3>Industry</h3>
						<br>
						<div class="input">
							@if($errors->has('company'))
								@foreach($errors->get('company') as $msg)
								<span class="help-block error">{{$msg}}</span>
								@endforeach
							@endif
							<div class="text-muted">Company*</div> 
							{{ Form::text('company', null, array('class' => 'form-control text-line')) }}
						</div>		
						<div class="input">
							@if($errors->has('title'))
								@foreach($errors->get('title') as $msg)
								<span class="help-block error">{{$msg}}</span>
								@endforeach
							@endif
							<div class="text-muted">Title*</div> 
							{{ Form::text('title', null, array('class' => 'form-control text-line')) }}
						</div>
						<div class="input">
							@if($errors->has('services_provide'))
								@foreach($errors->get('services_provide') as $msg)
								<span class="help-block error">{{$msg}}</span>
								@endforeach
							@endif
							<div class="text-muted">What type of services do you provide?*</div> 
							{{ Form::text('services_provide', null, array('class' => 'form-control text-line')) }}
						</div>
							<div class="input">
							@if($errors->has('industry'))
								@foreach($errors->get('industry') as $msg)
								<span class="help-block error">{{$msg}}</span>
								@endforeach
							@endif
							<div class="text-muted">Industry*</div> 
							{{ Form::text('industry', null, array('class' => 'form-control text-line')) }}		
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	{{ Form::close() }}	
	
	@include('users.modal.change-password')

@stop