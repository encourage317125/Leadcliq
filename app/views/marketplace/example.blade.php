@extends('layouts.bootstrap')
@section('content')
<div class="container" data-ng-controller="MarketController">	
	<h1>Market Place Example</h1>
	<h2>Profile</h2>
	<table class="table">
		<tbody>
			<tr>
				<td>Activate</td>
				<td>@{{profile.market_active}}</td>
				<td>Balance</td>
				<td>@{{profile.balance}}</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</tbody>
	</table>
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
		<div class="row" data-ng-show="profile.market_active">
			<div id="creditcards" class="col-md-6">
				<h2>Credit Cards <span class="pull-right"><a href="" class="btn btn-info" data-toggle="modal" data-target="#addCard"><i class="glyphicon glyphicon-plus-sign"></i> Add Credit Card</a></span></h2>
				<table class="table table-striped table-condensed">
					<thead>
						<tr>
							<th>Name</th>
							<th>Card</th>
							<th>Brand</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr data-ng-repeat="card in profile.cards">
							<td>@{{card.name}}</td>
							<td>@{{card.last_four}}</td>
							<td>@{{card.brand}}</td>
							<td>
								<a href="" class="btn btn-danger" data-ng-click="deleteCard(card)"><i class="glyphicon glyphicon-trash"></i></a>
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
						<tr data-ng-repeat="bank in profile.banks">
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
	<div class="">
		<a class="btn btn-default btn-lg" href="#" data-ng-click="activate()" data-ng-hide="profile.market_active">Activate Account</a>
		<a class="btn btn-danger btn-lg" href="#" data-ng-click="deactivate()" data-ng-show="profile.market_active">Deactivate Account</a>
		<a class="btn btn-default btn-lg" href="#" data-ng-show="profile.market_active">Withdraw Balance</a>
	</div>

	<div data-ng-show="profile.market_active">
		<h2>Transactions</h2>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Type</th>
					<th>Date</th>
					<th>Particulars</th>
					<th>Amount</th>
					<th>Reference</th>
					<th>Status</th>
				</tr>			
			</thead>
			<tbody>
				<tr data-ng-repeat="payment in profile.payments">
					<td>@{{payment.type}}</td>
					<td>@{{payment.created_at}}</td>
					<td>@{{payment.description}}</td>
					<td>@{{payment.amount}}</td>
					
					<td>
						<a data-ng-if="payment.payment_type == 'Contact'" href="{{url("contacts")}}/@{{payment.payment_id}}">Contact Details</a>
						<a data-ng-if="payment.payment_type == 'ApptShare'" href="{{url("apptshares")}}/@{{payment.payment_id}}">Appt Details</a>
					</td>
					<td>@{{payment.status}}</td>
					<td>
						<a data-ng-if="payment.type == 'debit' && payment.status != 'refunded'" data-ng-click="requestRefund(payment)">Request Refund</a>
						<a data-ng-if="payment.type == 'credit' && payment.status != 'refunded'" data-ng-click="giveRefund()">Give Refund</a>
					</td>
				</tr>
			</tbody>
		</table>
		{{Former::open()}}
		{{Former::select('pick_a_card')->data_ng_model("selectedCard")->data_ng_options("card.uri as card.name for card in profile.cards")}}
		{{Former::close()}}
		<ul class="nav ">
			<li>
				<a data-ng-click="buyfixedContactExample()" class="selectCard btn btn-default" href="">Buy Contact for $500</a>
			</li>
			<li>
				<a data-ng-click="buyfixedApptExample()" class="selectCard btn btn-default" href="">Buy Appt for $300</a>
			</li>
			<li>
				<a data-ng-click="buycheckpointContactExample()" class="selectCard btn btn-default" href="">Buy Contact for with checkpoints worth $1500</a>
			</li>
			<li>
				<a data-ng-click="buycheckpointApptExample()" class="selectCard btn btn-default" href="">Buy Apptshare for with checkpoints worth $2500</a>
			</li>
			<li>
				<a data-ng-click="sellfixedContactExample()" class="selectCard btn btn-default" href="">Sell Contact for $250</a>
			</li>
			<li>
				<a data-ng-click="sellfixedApptExample()" class="selectCard btn btn-default" href="">Sell Appt for $600</a>
			</li>
			<li>
				<a data-ng-click="sellcheckpointContactExample()" class="selectCard btn btn-default" href="">Sell Contact for with checkpoints worth $750</a>
			</li>
			<li>
				<a data-ng-click="sellcheckpointApptExample()" class="selectCard btn btn-default" href="">Sell Apptshare for with checkpoints worth $3650</a>
			</li>
		</ul>
	</div>
</div>
@stop

@section('scripts')

<script type="text/javascript" src="{{asset("js/vendors/angular.min.js")}}"></script>
<script type="text/javascript" src="https://js.balancedpayments.com/1.1/balanced.js"></script>
<script type="text/javascript">

	var module = angular.module("Leadcliq",[]);
	var base_url = "{{url("/")}}/";
	module.controller('MarketController',function($scope, $http)
	{
		$http.get(base_url+'market/profile').success(function(data, status){
			$scope.profile = data;
			console.log($scope.profile);
		});

		$scope.activate = function()
		{
			$http.get(base_url+'market/activate').success(function(data, status, headers){
				$scope.profile = data;
			});
		}

		$scope.deactivate = function()
		{
			$http.get(base_url+'market/deactivate').success(function(data, status, headers){
				$scope.profile = data;
			});
		}

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

					$http.post(base_url+'market/addbank', response.data)
					.success(function(data, status, headers){
						$('#addBankBtn').button('complete');
						$scope.profile.banks.push(data);
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
				number: $scope.card_number,
				expiration_month: $scope.expiration_month,
				expiration_year: $scope.expiration_year,
				security_code: $scope.security_code
			};
			console.log(creditCardData);
			//add the card to balanced payments
			balanced.card.create(creditCardData, function(response) 
			{
				switch (response.status_code) 
				{
					case 201:
					console.log(response.data);
					var card = {
						name: creditCardData.name,
						uri: response.cards[0].href,
						last_four: creditCardData.number.substr(4,-1)
					}
					console.log(card);
					$http.post(base_url+'market/addcard',card)
					.success(function(data, status, headers, config){
						console.log(data);
						$('#addCardBtn').button('complete');
						$scope.profile.cards.push(data);
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
					console.log(response.error);
					break;
					default:
					console.log(response);
				}
			});

		}

		$scope.deleteCard = function(card)
		{
			$http.delete(base_url+'market/card/?uri='+card.uri).success(function(data)
			{
				index = $scope.profile.cards.indexOf(card);
				$scope.profile.cards.splice(index,1);
			});
		}

		$scope.requestRefund = function(payment)
		{
			console.log(payment);
			$http.get(base_url+'market/requestrefund/?uri='+payment.reference_uri).success(function(data){
				payment.status = 'refunded';
				$scope.profile.payments.push(data);
				$scope.profile.balance += data.amount;
			});
		}

		$scope.buyfixedContactExample = function()
		{
			$http.get(base_url+'market/buyfixedcontact/?card='+$scope.selectedCard).success(function(data){
				$scope.profile.payments.push(data);
				$scope.profile.balance += data.amount;
			});

		}
		$scope.buyfixedApptExample = function(){
			$http.get(base_url+'market/buyfixedappt/?card='+$scope.selectedCard).success(function(data){
				$scope.profile.payments.push(data);
				$scope.profile.balance += data.amount;
			});

		}
		$scope.buycheckpointContactExample = function(){
			$http.get(base_url+'market/buycheckpointcontact/?card='+$scope.selectedCard).success(function(data){
				$scope.profile.payments.push(data);
				$scope.profile.balance += data.amount;
			});

		}
		$scope.buycheckpointApptExample = function(){
			$http.get(base_url+'market/buycheckpointappt/?card='+$scope.selectedCard).success(function(data){
				$scope.profile.payments.push(data);
				$scope.profile.balance += data.amount;
			});

		}
		$scope.sellfixedContactExample = function(){
			$http.get(base_url+'market/sellfixedcontact/?card='+$scope.selectedCard).success(function(data){
				$scope.profile.payments.push(data);
				$scope.profile.balance += data.amount;
			});

		}
		$scope.sellfixedApptExample = function(){
			$http.get(base_url+'market/sellfixedappt/?card='+$scope.selectedCard).success(function(data){
				$scope.profile.payments.push(data);
				$scope.profile.balance += data.amount;
			});

		}
		$scope.sellcheckpointContactExample = function(){
			$http.get(base_url+'market/sellcheckpointcontact/?card='+$scope.selectedCard).success(function(data){
				$scope.profile.payments.push(data);
				$scope.profile.balance += data.amount;
			});

		}
		$scope.sellcheckpointApptExample = function(){
			$http.get(base_url+'market/sellcheckpointappt/?card='+$scope.selectedCard).success(function(data){
				$scope.profile.payments.push(data);
				$scope.profile.balance += data.amount;
			});

		}
		window.scope = $scope;
	});

	
</script>

@stop