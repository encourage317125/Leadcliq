<p>Dear {{$appointment->owner->first_name}} {{$appointment->owner->last_name}},</p>

<p>Thank you for accepting {{$bidder->first_name}} {{$bidder->last_name}}'s  bid on "{{$appointment->title}}"</p>

<p>We have sent the following details to {{$bidder->first_name}}</p>

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

<p>
	We expect {{$bidder->first_name}} to contact you through your email (<a href="mailto:{{$appointment->owner->email}}">{{$appointment->owner->email}}</a>). If you have any other information that would help {{$bidder->first_name}} make the most out of this appointment, please send the details to <a href="mailto:{{$bidder->email}}">{{$bidder->email}}</a>.
</p>

<p>Thank you for your bid</p>

<p>Leadcliq</p>

