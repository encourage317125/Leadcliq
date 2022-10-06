@extends('layouts.bootstrap')
@section('content')
<div class="row">
    <div class="col-md-3">
        <!--TODO: This should be subtemplate-->
        <div class="well">
            <ul class="nav nav-pills nav-stacked">
                <li><a href="{{route("message.compose")}}">New Message</a></li>
                <li><a href="{{route("message.draft")}}">Drafts</a></li>
                <li><a href="{{route("message.sent")}}">Sent</a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-4">
        <div>
            <h2>{{$message->subject}}</h2>
            <p class="strong">To: {{$message->toUser->alias}}, From: {{$message->fromUser->alias}}</p>
            <p>{{$message->message}}</p>
        </div>
    </div>
</div>
@stop

