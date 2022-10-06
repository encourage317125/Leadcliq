@extends('layouts.bootstrap')
@section('content')
<table class="table table-striped table-advance table-hover">
	<thead>
		<tr>
			<th colspan="3">
				<input type="checkbox" class="mail-checkbox mail-group-checkbox">
				<div class="btn-group">
					<a class="btn mini blue" href="#" data-toggle="dropdown">
					More
					<i class="icon-angle-down "></i>
					</a>
					<ul class="dropdown-menu">
						<li><a href="#"><i class="icon-pencil"></i> Mark as Read</a></li>
						<li><a href="#"><i class="icon-ban-circle"></i> Spam</a></li>
						<li class="divider"></li>
						<li><a href="#"><i class="icon-trash"></i> Delete</a></li>
					</ul>
				</div>
			</th>
			<th class="text-right" colspan="3">
				<ul class="unstyled inline inbox-nav">

				</ul>
			</th>
		</tr>
	</thead>
	<tbody>
		@if(count($messages))
		@foreach($messages as $message)		
		<tr class="{{(isset($message['user']['status'])?$message['user']['status']:'')}}">
			<td class="inbox-small-cells">
				<input type="checkbox" class="mail-checkbox">
			</td>
			<td class="inbox-small-cells"><i class="icon-star"></i></td>
			<td class="view-message  hidden-phone">{{($message['from'] == $user->id?$message['to']:$message['from'])}}</td>
			<td class="view-message "><a href="{{$message->isSent()?route('messages.view',$message->id):route('message.compose')}}">{{($message->subject)}}</a></td>
			<td class="view-message  inbox-small-cells">
				@if(isset($message['attachments']))
				<i class="icon-paper-clip"></i>
				@endif
			</td>
			<td class="view-message  text-right">{{(is_null($message['sent_at'])?$message['sent_at']:$message['updated_at'])}}</td>
		</tr>
		@endforeach
		@else
			<tr>
				<td colspan="6" style="text-align:center; font-weight:bold"> No notifications</td>
			</tr>
		@endif
		
	</tbody>
</table>
@stop