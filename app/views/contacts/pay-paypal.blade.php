@extends('layouts.bootstrap')
@section('content')
<h1>Buy Contact: {{$contact->title}}</h1>
<br/>
<p class="alert alert-warning">
    <strong>Important!: </strong>Transactions taking place on “merit system”. <br/>
    Any violation of this merit system will immediately result in your account termination. <br/>
    You will have to click a buy now button to be taken to Paypal. After you send money via Paypal it will be up to the buyer mark as paid and release the contact. Other users will still be able to bid on the contact until the seller marks it as paid. The seller will be responsible for accepting ONLY ONE payment from potential bidders (if he accidentally accept too many he may need to refund the payment). If the seller does not release the contact or return your payment within two days they will be kicked off our system.<br/>
    We are currently implementing a smoother payment system.
</p>
<form name="_xclick" action="https://www.paypal.com/us/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value="{{$seller->email}}">
    <input type="hidden" name="business" value="britleggett@mac.com">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="return" value="{{URL::route('finish-pay-contact-paypal', $contact->id)}}">
    <input type="hidden" name="cancel_return" value="{{URL::route('show-pay-contact-paypal', $contact->id)}}">
    <input type="hidden" name="rm" value="2">
    <input type="hidden" name="item_name" value="Leadcliq Contact: {{$contact->title}}">
<!--    <input type="hidden" name="amount" value="{{$contact->price}}">-->
    <input type="hidden" name="amount" value="1">

    <input type="image" src="http://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>
@stop