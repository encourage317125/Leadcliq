@extends('layouts.bootstrap')

@section('styles')
	<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.2/leaflet.css" />
	<link rel="stylesheet" href="{{asset("css/geo-search.css")}}" />
	<link rel="stylesheet" href="{{asset("css/leaflet-draw.css")}}" />
	<link rel="stylesheet" href="{{asset("css/mapObjects.css")}}" />
@stop

@section('home-carousel')
<section class="dashboad-graphics">
	<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner">
			<div class="item active">
				<div class="container">
					<div class="row">
						<div class="thumbnail-graphic col-md-3">
							<div class="thumbnail-graphic-frame">
								<span class="arrow pull-right"></span>
								<p class="thumbnail-graphic-number">
									{{Contact::count()}}
								</p>
							</div>
							<h2><a href="">Total Contacts (All Circles)</a></h2>
							<p>All contacts in all circles.</p>
						</div>
						<div class="thumbnail-graphic col-md-3">
							<div class="thumbnail-graphic-frame">
								<span class="arrow pull-right"></span>
								<p class="thumbnail-graphic-number">
									{{Contact::where('created_at','>',date('Y-m-d',strtotime('today')))->count()}}
								</p>
							</div>
							<h2><a href="">New Contacts (All Circles)</a></h2>
							<p>Number of new contacts that have been uploaded in all circles today.</p>
						</div>
						<div class="thumbnail-graphic graphic-success col-md-3">
							<div class="thumbnail-graphic-frame">
								<span class="arrow pull-right"></span>
								<p class="thumbnail-graphic-number">
									{{ContactTransaction::where('created_at','>',date('Y-m-d',strtotime('today')))->count()}}
								</p>
							</div>
							<h2><a href="">Contact Transactions (Today)</a></h2>
							<p>This number represents how active the appointments shares have been over the past 24 hours.</p>
						</div>
						<div class="thumbnail-graphic col-md-3">
							<div class="thumbnail-graphic-frame">
								<span class="arrow pull-right"></span>
								<p class="thumbnail-graphic-number">
									{{ContactTransaction::where('updated_at','>',date('Y-m-d',strtotime('today')))->where('operation',2)->count()}}
								</p>
							</div>
							<h2><a href="">Completed Transactions (Today)</a></h2>
							<p>Number of new (added today) appointment shares available for all circles.</p>
						</div>
					</div>
				</div>
			</div>
			<div class="item">
				<div class="container">
					<div class="row">
						<div class="thumbnail-graphic graphic-success col-md-3">
							<div class="thumbnail-graphic-frame">
								<span class="arrow pull-right"></span>
								<p class="thumbnail-graphic-number">
									{{ApptShare::where('created_at','>',date('Y-m-d'))->where('status','!=','cancelled')->where('status','!=','private')->count()}}
								</p>
							</div>
							<h2><a href="">ApptShares Added Today</a></h2>
							<p>All appointments created today and shared either in a circle or in the open market.</p>
						</div>
						<div class="thumbnail-graphic col-md-3">
							<div class="thumbnail-graphic-frame">
								<span class="arrow pull-right"></span>
								<p class="thumbnail-graphic-number">
									{{ApptShare::where('status','public')->count()}}
								</p>
							</div>
							<h2><a href="">Total Available ApptShares</a></h2>
							<p>All Apptshares available for bidding.</p>
						</div>
						<div class="thumbnail-graphic graphic-warning col-md-3">
							<div class="thumbnail-graphic-frame">
								<span class="arrow pull-right"></span>
								<p class="thumbnail-graphic-number">
									{{ApptShare::where('status','public')->where('bid_datetime','>',date('Y-m-d'))->where('bid_datetime','<',date('Y-m-d 23:59:59'))->count()}}
								</p>
							</div>
							<h2><a href="">ApptShares Expiring Today</a></h2>
							<p>This number represents how active the appointments shares have been over the past 24 hours.</p>
						</div>
						<div class="thumbnail-graphic graphic-success col-md-3">
							<div class="thumbnail-graphic-frame">
								<span class="arrow pull-right"></span>
								<p class="thumbnail-graphic-number">
									{{ApptShareBid::where('updated_at','>',date('Y-m-d'))->where('updated_at','<',date('Y-m-d 23:59:59'))->count()}}
								</p>
							</div>
							<h2><a href="">Apptshare Transactions Today</a></h2>
							<p>Number of ApptShares transactions carried out today</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
			&lsaquo;
		</a>
		<a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
			&rsaquo;
		</a>
	</div>
</section>
@stop
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-9">
			<div class="banner">
				<div id="top-carousel" class="carousel slide" data-ride="carousel">
				  <!-- Wrapper for slides -->
				  <div class="carousel-inner" id="carousel-0">

				    <div class="item active">
				      <img src="images/banner1.jpg" alt="img">
				    </div>

				    <div class="item" id="carousel-1">
				      <img src="images/banner2.jpg" alt="img">
				    </div>

				    <div class="item" id="carousel-2">
				      <a href="http://fastcall.com/" target="_blank">
					    <img src="images/banner3.jpg" alt="img">
					  </a>
				    </div>
				  </div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="box-resume box-resume-invite">
				<div class="box-resume-header">
					<h2>EARN A POINT TODAY!</h2>
				</div>
				<div class="box-resume-body">
					<form role="form" action="{{URL::route('invite-friends')}}" method="POST">
						<div class="form-group">
							<input type="text" class="form-control" id="" placeholder="Enter name" required>
						</div>
						<div class="form-group">
							<input name="to" type="email" class="form-control" id="" placeholder="Enter email" required>
						</div>
						<button type="submit" class="btn btn-entry"><strong>INVITE NOW!</strong></button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<section class="call-list-resume col-md-6">
			<a href="{{ URL::route('sell-contacts') }}" class="btn btn-action btn-lg noradius"><i class="iconleadcliq-handshake-48"></i>Sell a Lead<i class="iconleadcliq-arrowRight-32 pull-right"></i></a>
			<div class="box-resume">
				<div class="box-resume-header">
					<h2>Call List</h2>
				</div>
				<div class="box-resume-body">
					@foreach ($user->boughtContactsPreview as $t)
						@if(($contact = $t->contact($t->contact_id)) != false && $contact->getRawStatus() == ContactTransaction::$CONTACT_SOLD && $contact->call_list == Contact::$SHOW_CALL_LIST)
							<div id="contact-call-list{{ $contact->id }}">
							<div class="list-item">
								<input class="sell-type-option" onclick="removeFromCallList({{ $contact->id }})" type="checkbox">

								<a href="javascript:showModalContent('/show-bougth-contact/{{$contact->id}}')">
									{{{ $contact->first_name }}} {{{ $contact->last_name }}}, 
								</a>
									{{{ $contact->company }}}, {{{ $contact->email }}}, 
									{{{ $contact->direct }}} (ext {{{ $contact->direct_ext }}})
							</div>
							</div>
						@endif
					@endforeach
				</div>
			</div>
		</section>
		<section class="circle-resume col-md-6">
			<a href="{{ URL::route('buy-contacts') }}" class="btn btn-action btn-lg noradius"><i class="iconleadcliq-buy-48"></i>Buy a Lead<i class="iconleadcliq-arrowRight-32 pull-right"></i></a>			
			@foreach ($user->circles as $circle)	
									
					
			<div class="box-resume">
				<div class="box-resume-header">
					<h2>Circle: {{$circle->name}}</h2>
				</div>
				<div class="box-resume-body">
					<div class="row">
						<div class="media-list circle-media-list">	
						@foreach($circle->randomUsers(4) as $user)						
							<div class="media col-sm-6">
								<img alt="" src="{{$user->photo}}'" class="pull-left media-object img-thumbnail img-thumbnail-frame">
								<div class="media-body">
									<h3 style="color: orange;">{{$user->first_name}} {{$user->last_name}}</h3>
									<p><span class="text-muted">Joined:</span> {{date('m-d-Y',strtotime($user->created_at))}}</p>
								</div>
							</div>							
						@endforeach
						</div>
					</div>
				</div>
			</div>
				
			@endforeach
		</section>
	</div>
</div>

<section class="live-activity">
	<div class="container">
		<div class="live-activity-header col-md-12">
			<h2 style="text-align:center;">Live Activity in Territory</h2>
			<div class="live-activity-buttons pull-right">
				
			</div>
		</div>
		    <div id="mapContainer"></div>
            <div id="currentArea"></div>
            <div id="layerAreas"></div>
		</div>
	</div>
</section>

<section class="container">
	<div class="row">
		<article class="col-md-4">
			<div class="box-text">
				<h3><i class="li_bulb"></i> About Us </h3>
				<p>At LeadCliq, we’ve developed an innovative business development ecosystem.</p>
			</div>
		</article>
		<article class="col-md-4">
			<div class="box-text">
				<h3><i class="li_user"></i> Profile</h3>
				<p>Keep your profile up to date and complete, and stay connected with top business people.</p>
			</div>
		</article>
		<article class="col-md-4">
			<div class="box-text">
				<h3><i class="li_banknote"></i> Disputes</h3>
				<p>You can trust your network circle, but if you have a problem, we're here to help.</p>
			</div>
		</article>
	</div>
<div id="uid" class="hidden">{{ Sentry::getUser()->id }}</div>
</section>
@stop

@section('extra-scripts')
	<script src="{{asset("js/leaflet.js")}}"></script>
	<script src="{{asset("js/geo-search.js")}}"></script>
	<script src="{{asset("js/geosearch-prov.js")}}"></script>
	<script src="{{asset("js/leaflet-draw/leaflet-draw.js")}}"></script>
	<script src="{{asset("js/terraformer.js")}}"></script>
	<script src="{{asset("js/terraformer-wkt.js")}}"></script>
	<script src="{{asset("js/user_areas.js")}}"></script>

	<script>initDashboardMap();</script>

@stop