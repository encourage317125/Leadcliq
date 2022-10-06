@extends('layouts.bootstrap')

@section('content')

{{-- See https://docs.balancedpayments.com/1.1/guides/balanced-js/ --}}
{{-- here we're not submitting via Ajax though (as they do in that tutorial) --}}
{{-- javascript is currently in scripts.blade.php (need to figure out better place) --}}

<h1>Add a New Bank Account</h1>
<br/>

{{Former::open()->action(route('bank-accounts.store'))->id('addAccount')}}

    {{Former::text('name on account')->id('ba-name')->autocomplete('off')->placeholder('John Doe')}}

    {{Former::text('account number')->name('account_number')->id('ba-number')->autocomplete('off')->placeholder('9900000000')}}

    {{Former::text('routing number')->id('ba-routing')->autocomplete('off')->placeholder('322271627')}}

    {{Former::hidden('uri')}}

    {{Former::hidden('redirect')->value($redirect)}}

    {{Former::submit('add account')->id('ba-submit')->class('btn btn-primary btn-lg')}}

{{Former::close()}}

<script type="text/javascript" src="https://js.balancedpayments.com/1.1/balanced.js"></script>
@stop