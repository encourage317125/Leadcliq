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