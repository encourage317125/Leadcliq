{{--NOT IN USE--}}
@extends('layouts.bootstrap')
@section('content')
<div class="container" >
	<div data-ng-controller="CardController">
		
		<div class="modal fade" id="addCard" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				{{Former::open()->data_ng_submit("addCard()")->action("")->method("")}}
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">Add a credit card</h4>
					</div>
					<div class="modal-body">
						{{Former::text('card_name')->label('Name on  card')->data_ng_model("card_name")}}
						{{Former::text('card_number')->data_ng_model("card_number")}}
						{{Former::text('expiration_month')->data_ng_model("expiration_month")}}
						{{Former::text('expiration_year')->data_ng_model("expiration_year")}}
						{{Former::text('security_code')->data_ng_model("security_code")}}		
					</div>
					<div class="modal-footer">
						{{Former::submit('Add Credit Card')->class('btn btn-success')->id('addCardBtn')->data_loading_text('Saving...')->data_complete_text('Saved!')}}
					</div>
				</div>
				{{Former::close()}}
			</div>
		</div>
		<div class="row">
			<div id="creditcards" class="col-md-6">
				<h2>Credit Cards <span class="pull-right"><a href="" class="btn btn-info" data-toggle="modal" data-target="#addCard"><i class="glyphicon glyphicon-plus-sign"></i> Add Credit Card</a></span></h2>
				<table class="table table-striped table-condensed">
					<thead>
						<tr>
							<th>Card</th>
							<th>Brand</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr data-ng-repeat="card in user.cards">
							<td>@{{card.name}}</td>
							<td>XXXX-XXXX-XXXX-@{{card.last_four}}</td>
							<td>@{{card.brand}}</td>
							<td>
								<a href="" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div id="bankaccounts" class="col-md-6">
				<h2>Bank Accounts <span class="pull-right"><a href="" class="btn btn-info" data-toggle="modal" data-target="#addBank"><i class="glyphicon glyphicon-plus-sign"></i> Add Bank Account</a></span></h2>
				<div class="modal fade" id="addBank" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						{{Former::open()->data_ng_submit("addBank()")->action("")->method("")}}
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel">Add Bank Account</h4>
							</div>
							<div class="modal-body">
								{{Former::text('bank_name')->label('Account Name')->data_ng_model("bank_name")}}
								{{Former::text('routing_number')->data_ng_model("routing_number")}}
								{{Former::text('account_number')->data_ng_model("account_number")}}
								{{Former::select('type')->data_ng_model("type")->options(array('checking','savings'))->placeholder('Pick Account Type')}}
							</div>
							<div class="modal-footer">
								{{Former::submit('Add Bank Account')->class('btn btn-success')->id('addBankBtn')->data_loading_text('Saving...')->data_complete_text('Saved!')}}
							</div>
						</div>
						{{Former::close()}}
					</div>
				</div>
				<table class="table table-striped table-condensed">
					<thead>
						<tr>
							<th>Name</th>
							<th>No.</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr data-ng-repeat="bank in user.banks">
							<td>@{{bank.name}} - @{{bank.bank_name}}</td>
							<td>@{{bank.account_number}}</td>
							<td>
								<a href="" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h2>Transaction History</h2>
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Date</th>
							<th>Type</th>
							<th>Particulars</th>
							<th>Amount</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($transactions as $transaction)
						<tr>
							<td>{{$transaction->date}}</td>
							<td>{{$transaction->type}}</td>
							<td>{{$transaction->particulars}}</td>
							<td>{{$transaction->amount}}</td>
							<td><a href="{{$transaction->id}}" class="">Dispute</a></td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@stop
@section('scripts')
<script type="text/javascript" src="{{asset("js/vendors/angular.min.js")}}"></script>
<script type="text/javascript" src="https://js.balancedpayments.com/v1/balanced.js"></script>
<script type="text/javascript">
	balanced.init('/v1/marketplaces/TEST-MP57UjXi3RKsHRhIczHcdbav');
	
	var module = angular.module("Leadcliq",[]);
	var base_url = "{{url("/")}}";
	module.controller('CardController',function($scope, $http)
	{
		// $scope.cards = [{uri: "uri", brand: "tskj"}];
		$http.get(base_url +'/market/user').success(function(data, status, headers){
			console.log(data);
			$scope.user = data;

		});

		$scope.addBank = function()
		{
			$('#addBankBtn').button('loading');
			var bankData = {
				    name: $scope.bank_name,
				    routing_number: $scope.routing_number,
				    account_number: $scope.account_number,
				    type: $scope.type,
				};
			balanced.bankAccount.create(bankData, function(response) 
			{
				switch (response.status) 
				{
					case 201:

					$http.post(base_url+'/market/addbank', response.data)
						.success(function(data, status, headers){
							$('#addBankBtn').button('complete');
							$scope.user.banks.push(data);
							$('#addBank').modal('hide');

						});

					

					break;

					default:
					console.log(response.error);
				}
			});
		}
		
		$scope.addCard = function()
		{
			$('#addCardBtn').button('loading');
			var creditCardData = {
				name: $scope.card_name,
				card_number: $scope.card_number,
				expiration_month: $scope.expiration_month,
				expiration_year: $scope.expiration_year,
				security_code: $scope.security_code
			};
			console.log(creditCardData);
			//add the card to balanced payments
			balanced.card.create(creditCardData, function(response) 
			{
				switch (response.status) 
				{
					case 201:
					console.log(response.data);
					var card = {
						name: response.data.name,
						uri: response.data.uri,
						last_four: response.data.last_four,
						is_verified: response.data.is_verified,
						is_valid: response.data.is_valid,
						postal_code_check: response.data.postal_code_check,
						security_code_check: response.data.security_code_check,
						card_type: response.data.card_type,
						brand: response.data.brand}
						console.log(card);
						$http.post(base_url+'/market/addcard',card)
							.success(function(data, status, headers, config){
								console.log(data);
								$('#addCardBtn').button('complete');
								$scope.user.cards.push(data);
								$('#addCard').modal('hide');
							});
						
						break;
					case 400:
					// missing field - check response.error for details
					console.log(response.error);
					break;
					case 402:
					// we couldn't authorize the buyer's credit card
					// check response.error for details
					console.log(response.error);
					break
					case 404:
					// your marketplace URI is incorrect
					console.log(response.error);
					break;
					case 500:
					// Balanced did something bad, please retry the request
					break;
				}
			});
			
		}
	});

	$('.modal').on('show.bs.modal', function (e) 
	{
		$('#addCardBtn').val('Save');
		$('#addBankBtn').val('Save');
	  	$(this).find('form')[0].reset();
	});
</script>
@stop