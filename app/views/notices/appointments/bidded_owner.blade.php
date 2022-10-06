<p>Dear {{$appointment->owner->first_name}} {{$appointment->owner->last_name}},</p>

<p>
	{{$user->first_name}} has placed a bid on {{$appointment->title}}. Please <a href="{{url('appointments/'.$appointment->id.'/edit')}}">click here to review the bid</a>.
</p>

<h3>Appointment details</h3>
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
			<td>Manager</td>
			<td>{{$appointment->manager_title}}</td>
		</tr>
		<tr>
			<td>SizeManager</td>
			<td>{{$appointment->size}}</td>
		</tr>
		<tr>
			<td>Owner</td>
			<td>{{$appointment->owner->first_name}} {{$appointment->owner->last_name}}</td>
		</tr>
		<tr>
			<td>Status</td>
			<td></td>
		</tr>
	</tbody>
</table>

