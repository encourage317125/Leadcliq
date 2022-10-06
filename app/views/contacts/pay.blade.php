@extends('layouts.bootstrap')
@section('content')
<h1>Buy Contact: {{$contact->title}}</h1>
<br/>
<a class="btn btn-default" href="{{route('credit-cards.index',array('redirect'=>Request::url()))}}">
    Manage Cards
</a>
    {{Former::open()->action(route('pay-contact',$contact->id))}}
    {{Former::select('card')->options(array('cards'=>$cards))}}
    {{Former::text('pay_option')->disabled()->value('Single Payment')}}
    {{Former::text('total_amount')->disabled()->value($contact->price)}}
    {{Former::submit('Pay Now')->class('btn btn-lg btn-primary')}}
    {{Former::close()}}
@stop