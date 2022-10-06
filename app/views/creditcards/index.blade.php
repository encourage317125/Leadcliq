@extends('layouts.bootstrap')

@section('content')

<h1>Credit Cards</h1>
<br/>
@if($creditcards->count())
<div class="row">
    <div class="col-xs-6 well">
        <ul class="list-group">
            @foreach($creditcards as $creditCard)
            <li class="list-group-item clear-fix">
                <span class="brand">{{$creditCard->brand}}:</span>
                <span class="number"> {{$creditCard->last_four}}</span>
                {{ Former::open()->action('/credit-cards/'.$creditCard->uri) }}
                {{ Former::hidden('_method', 'DELETE') }}
                {{ Former::submit('Delete Card')->class('pull-right btn btn-sm btn-warning')->style('margin-top:-25px') }}
                {{ Former::close() }}
            </li>
            @endforeach
        </ul>
    </div>
    <div class="col-xs-3">
        <div class="well">
            <a class="btn-primary btn btn-lg btn-block" href="{{route('credit-cards.create',array('redirect'=>$redirect))}}">Add a new Card</a>
        </div>
    </div>
</div>
@else
<p class="alert alert-info">You haven't added any credit cards. <a class="btn btn-primary" href="{{URL::route('credit-cards.create')}}">Add a Card</a></p>
@endif


<ul>

</ul>

@stop