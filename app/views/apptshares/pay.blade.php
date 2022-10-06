@extends('layouts.bootstrap')
@section('content')
{{Former::open()->action(route('apptshares.pay',$appt->id))}}
{{Former::select('card')->options(array('cards'=>$cards))}}
{{Former::text('pay_option')->disabled()->value($appt->pay_option == 'one_price'?'Single Payment':'Several Chekpoints')}}
{{Former::text('total_amount')->disabled()->value($appt->pay_option=='one_price'? $appt->price: $appt->checkpoints()->sum('amount'))}}
{{Former::submit('Pay Now')}}
{{Former::close()}}
@stop