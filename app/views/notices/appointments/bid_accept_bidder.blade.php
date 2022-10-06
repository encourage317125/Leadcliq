<p>Dear {{$bidder->first_name}} {{$bidder->last_name}},</p>

<p>{{$appointment->owner->first_name}} {{$appointment->owner->last_name}} has accepted your bid on {{$appointment->title}}</p>

<h3>Appointment details</h3>
<table>
	<tbody>
		<tr>
			<td>Title</td>
			<td>{{$appointment->title}} </td>
		</tr>
		<tr>
			<td>Address 1:</td>
			<td>{{$appointment->address_1}} </td>
		</tr>
		<tr>
			<td>Address 2:</td>
			<td>{{$appointment->address_2}} </td>
		</tr>
		<tr>	
			<td>City:</td>
			<td>								
				{{$appointment->zip}}, {{$appointment->city->name}} {{$appointment->city->state_code}}
			</td>
		</tr>
		<tr>
			<td>Location</td>
			<td>{{$appointment->location}} </td>
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
			<td>Key Details:</td>
			<td>{{$appointment->extra_details}}</td>
		</tr>
		<tr>
			<td>Owner:</td>
			<td>{{$appointment->owner->first_name}} {{$appointment->owner->last_name}}</td>
		</tr>
	</tbody>
</table>

<p>For more information, feel free to contact {{$appointment->owner->first_name}} at <a href="mailto:{{$appointment->owner->email}}">{{$appointment->owner->email}}</a> </p>

<p>Thank you for your bid</p>

<p>Leadcliq</p>

