@extends('layouts.bootstrap')

@section('content')

{{-- See https://docs.balancedpayments.com/1.1/guides/balanced-js/ --}}
{{-- here we're not submitting via Ajax though (as they do in that tutorial) --}}
{{-- javascript is currently in scripts.blade.php (need to figure out better place) --}}

<h1>Add a New Card</h1>
<br/>

{{Former::open()->action(route('credit-cards.store'))->id('addCard')}}

    {{Former::text('name on card')->id('cc-name')->autocomplete('off')->placeholder('John Doe')}}

    {{Former::text('card number')->name('last_four')->id('cc-number')->autocomplete('off')->placeholder('4111111111111111')->maxlength(16)}}

    {{Former::select('card type')->name('brand')->id('brand')->options(array('MasterCard'=>'MasterCard','VISA'=>'VISA','AMEX'=>'American Express'))}}

    {{Former::text('expiration month')->id('cc-ex-month')->autocomplete('off')->placeholder('01')->maxlength(2)}}

    {{Former::text('expiration year')->id('cc-ex-year')->autocomplete('off')->placeholder('2016')->maxlength(4)}}

    {{Former::text('security code (CVV)')->id('ex-csc')->autocomplete('off')->placeholder('453')->maxlength(4)}}

    {{Former::hidden('uri')}}

    {{Former::hidden('redirect')->value($redirect)}}

    {{Former::submit('add card')->id('cc-submit')->class('btn btn-primary btn-lg')}}

{{Former::close()}}

<script type="text/javascript" src="https://js.balancedpayments.com/1.1/balanced.js"></script>
@stop