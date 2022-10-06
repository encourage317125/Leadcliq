<p>Dear {{$user->first_name}} {{$user->last_name}},</p>

<p>You have succeffuly placed a bid on {{$appointment->title}}</p>

<h3>Bid details</h3>
<table>
	<tbody>
		<tr>			
			<td>Location:</td>
			<td>
				{{$appointment->location}} 
				@if(isset($appointment->city))
				{{$appointment->zip}}, {{$appointment->city->name}} {{$appointment->city->state_code}}
				@endif
			</td>
		</tr>

		<tr>
			<td>Date:</td>
			<td>{{$appointment->date}} {{$appointment->time}}</td>
		</tr>
		<tr>
			<td>Manager:</td>
			<td>{{$appointment->manager_title}}</td>
		</tr>
		<tr>
			<td>Size:</td>
			<td>{{$appointment->size}}</td>
		</tr>
		<tr>
			<td>Owner:</td>
			<td>{{$appointment->owner->first_name}} {{$appointment->owner->last_name}}</td>
		</tr>
		<tr>
			<td>Status:</td>
			<td></td>
		</tr>
	</tbody>
</table>

