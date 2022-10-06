<!doctype html>
<html lang="en" ng-app="Leadcliq">
<head>
	<meta charset="UTF-8">
	<title>LeadCliq</title>
	<meta name="description" content="">
	@include('layouts.bootstrap.head')
</head>
<body>
	
	@include('layouts.bootstrap.header')

	<div class="container">
		@if (Session::has('message'))
			<div id="session-message" class="flash alert">
				<button class="pull-right btn btn-info btn-sm" onclick="closeSessionMessage();">OK</button>
				<p>{{ Session::get('message') }}</p>
			</div>
		
		@endif
		
		@if(Session::has('error'))
			<div class="alert alert-error"> <p>{{Session::get('error')}}</p></div>
		@endif
		@if(Session::has('success'))
			<div class="alert alert-success"> <p>{{Session::get('success')}}</p></div>
		@endif
		@if(Session::has('info'))
			<div class="alert alert-info"> <p>{{Session::get('info')}}</p></div>
		@endif
	</div>

	@yield('home-carousel')
	
	<div class="container" id="wrap">
        <div class="main-content">
		    @yield('content')
        </div>
	</div>

	<div id="footer">
		@include('layouts.bootstrap.footer')
	</div>

	@include('layouts.bootstrap.scripts')
	@yield('extra-scripts')
	
	<script>
		$('.dashboad-graphics .carousel').carousel({
		  interval: false
		});
	</script>
	@yield('scripts')
	<div class="modal fade" id="new-modal-window"></div>

	<div class="modal fade" id="modal-window">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="modal-title"></h4>
				</div>

				<div class="modal-body" id="modal-body"></div>

				<div class="modal-footer">
					<button type="button" class="btn btn-warning" data-dismiss="modal" aria-hidden="true">OK</button>
				</div>
			</div>
		</div>
	</div>

</body>
</html>