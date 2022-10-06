@extends('layouts.bootstrap')
@section('content')
<div class="container" data-ng-controller="ApptShares">
	<span>
		<h1 class="pull-left">@{{list_title}}</h1>
		<span class="pull-right" style="text-align:center">
			<p>
				<a href="{{url("apptshares/create")}}" class="btn btn-primary">New ApptShare</a>
			</p>
			<p>
				<div class="form-group">{{Former::select(null)->label('Select Item')->options(Sentry::getUser()->circles()->lists("name","circle_id"))->addOption("Open Market","open")->addOption("My Apptshares",-1)->placeholder("Select Circle/Market")->id("circle_list")->data_ng_change("changeList()")->data_ng_model("list_type")}}</div>
			</p>
		</span>	</span>
	<table id="apptlist" class="table table-striped">
		<thead>
			<tr>
				<th>Title</th>
				<th>Location</th>
				<th>Date</th>
				<th>Title</th>
				<th>Size</th>
				<th>User</th>
				<th>Pay With</th>
				<th>Bid</th>
			</tr>
		</thead>
		<tbody>
			<tr data-ng-repeat="appt in apptshares">
				<td>@{{appt.title}}</td>
				<td>@{{appt.gen_address_info}}</td>
				<td>@{{appt.appt_datetime}}</td>
				<td>@{{appt.manager_title}}</td>
				<td>@{{appt.project_size}}</td>
				<td>@{{appt.owner.first_name}} @{{appt.owner.last_name}}</td>
				<td>
					@{{appt.sell_for}} 
					<span data-ng-if="appt.pay_option == 'one_price'">(Single Payment)</span>
					<span data-ng-if="appt.pay_option == 'multiple_payout'">(Several Checkpoints)</span>
				</td>
				<td>
					<span data-ng-if="appt.is_owner">
						<a href="{{url("apptshares")}}/@{{appt.id}}" class="details">View</a>
						<a href="{{url("apptshares")}}/@{{appt.id}}/edit" class="details">Edit</a>
					</span>
					<span data-ng-if="appt.is_bidder">
						<a href="{{url("apptshares")}}/@{{appt.id}}" class="details">View Bid</a>
					</span>
					<span data-ng-if="!appt.is_owner && !appt.is_bidder">
					<a href="{{url("apptshares")}}/@{{appt.id}}" class="details">Details</a>
					</span>
				</td>
			</tr>
			<tr data-ng-if="apptshares.length == 0">
				<td colspan="8">No Apptshares Available. Select a different circle or the open market</td>
			</tr>
		</tbody>
	</table>

	<div id="mybids" data-ng-if="list_title == 'My ApptShares'">
		<h2>My Bids</h2>
		<table id="apptlist" class="table table-striped">
			<thead>
				<tr>
					<th>Title</th>
					<th>Bidding Ends</th>
					<th>User</th>
					<th>Pay With</th>
					<th>Status</th>					
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr data-ng-repeat="bid in bids">
					<td>@{{bid.apptshare.title}}</td>
					<td>@{{bid.apptshare.ends_in}}</td>
					<td>@{{bid.apptshare.owner.full_name}}</td>
					<td>
						@{{bid.apptshare.sell_for}} 
						<span data-ng-if="bid.apptshare.pay_option == 'one_price'">(Single Payment)</span>
						<span data-ng-if="bid.apptshare.pay_option == 'multiple_payout'">(Several Checkpoints)</span>
					</td>
					<td>
						@{{bid.status}}
					</td>
					<td>
						<a href="{{url("apptshares")}}/@{{bid.apptshare.id}}" class="details">View Bid</a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	
	<div id="bid-modal" class="modal fade">
	  <div class="modal-dialog">
	  	{{Former::vertical_open()}}
	    	<div class="modal-content">
	    	  <div class="modal-header">
	    	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    	    <h4 class="modal-title">Bid on</h4>
	    	  </div>
	    	  <div class="modal-body">
	    	  	<strong style="font-size:18px">Apptshare Details</strong>
	    	  	<div class="details">
	    	  		<div id="owner" class="detail" style="margin:7px auto">
	    	  			<strong>Owner: </strong>
	    	  			<span class="value"></span>
	    	  		</div>
	    	  		<div class="row">
	    	  			<div id="pay-with" class="detail col-md-6" style="margin:7px auto">
	    	  				<strong>Pay with: </strong>
	    	  				<span class="value"></span>
	    	  			</div>
	    	  			<div id="amount" class="detail col-md-6" style="margin:7px auto">
	    	  				<strong>Amount: </strong>
	    	  				<span class="value"></span>
	    	  			</div>
	    	  		</div>
	    	  	</div>
	    	  	<hr>
	    	  	<p>Write a special message to go with your bid</p>
	    	  	{{Former::hidden('appt-id')}}
	    	    {{Former::textarea('message')}}
	    	    {{Former::checkbox('accept')->label(null)->text('Accept terms and conditions')}}
	    	  </div>
	    	  <div class="modal-footer">
	    	    
	    	    {{Former::button('Bid')->icon('thumbs-up')->class('btn btn-default confirm-bid disabled')}}
	    	    <button type="button" class="btn" data-dismiss="modal">Close</button>
	    	  </div>
	    	</div><!-- /.modal-content -->
	    </form>
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</div>
@stop

@section('scripts')

<script>
	$(document).ready(function(){
		$(".bid").click(function()
		{
			console.log('bid modal show');
			id = $(this).attr('data-id');
			$('#bid-modal').find('[name="appt-id"]').val(id);
			$('#bid-modal').find('.modal-title').html('<strong>Bidding on:</strong> '+$(this).attr('data-title'));
			$('#bid-modal').find('#owner .value').text($(this).attr('data-owner'));
			$('#bid-modal').find('#pay-with .value').text($(this).attr('data-currency'));
			$('#bid-modal').find('#amount .value').text($(this).attr('data-amount'));
			$('#bid-modal').modal();
			return false;
		});
		$('.confirm-bid').click(function()
		{
			var id = $(this).parents('form').find('[name="appt-id"]').val();;
			var message = $(this).parents('form').find('#message').val();
			
			var request = $.post( "{{url("apptshares")}}/"+id+"/bid",{apptshare_id: id, bidder_id: {{Sentry::getUser()->id}}, message: message} );
			request.done(function(data)
			{
				console.log(data.id);
				location.reload();
				row = $('a[data-id="'+data.id+'"]').parents('tr');
				row.addClass('bidded-on');
				console.log(row);
				row.find('a.details').text('View Bid').attr('href',"{{url("apptshares")}}/"+id).siblings().remove();
				$('#bid-modal').modal('hide');
			});
	
			request.fail(function(data)
			{
				error = '<div class"alert alert-error">There was an error</div>';
				$('#bid-modal').find('.modal-content').prepend(error);
			});
			
		});
	});
</script>
<script>
	var app = angular.module('Leadcliq',[]);
	var base_url = "{{url("/")}}";

	app.controller('ApptShares', function($scope, $http)
	{
		$scope.list_title = "{{isset($page_title)?$page_title:"My ApptShares"}}";
		$scope.apptshares = {{$appts}};
		@if(isset($bids))
		$scope.bids = {{$bids}};
		@endif
		$scope.list_type = 0;
		$scope.circles = {{Sentry::getUser()->circles}};
		$scope.changeList = function()
		{
			if($scope.list_type == "open")
			{
				link = base_url+'/apptshares/market';
				$scope.list_title = "Open Market";
			}
			else if($scope.list_type > 0)
			{
				link = base_url+'/apptshares/circle/'+$scope.list_type;
				$scope.list_title = "Circle: "+getCircleName();
			}
			else
			{
				$scope.list_title = "My ApptShares"
				link = base_url+'/apptshares';
			}
					
			
			
			if(typeof link != 'undefined')
			{
				$http.get(link).success(function(data, status, header)
				{
					$scope.apptshares = data;
				});
				if($scope.list_title == "My ApptShares")
				{
					$http.get(base_url+'/apptshares/mybids').success(function(data, status, header)
				{
					$scope.bids = data;
				});
				}
			}
		};
		window.scope = $scope;
	});

	function getCircleName ()
	{
		return $('#circle_list option:selected').text();
	}

	

	$('#accept').change(function()
	{
		btn = $('.confirm-bid');
	    this.checked ? btn.removeClass('disabled') : btn.addClass('disabled') ;
	    
	});

	
</script>

@stop


@section('styles')
<style>
	.btn.disabled{background-color: #F66C06;}
</style>

@stop