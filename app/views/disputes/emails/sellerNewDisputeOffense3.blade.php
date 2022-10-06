<div style="color: #555;">

	Dear {{ $user->first_name }}, <br>
	<p>
		Another dispute has been filed against a contact that you sold. 
		This is the third instance of this. The contact was {{ $contact->first_name }} {{ $contact->last_name }}.  
		We have deducted points from your account in the amount equal to what the buyer paid for the contact. 
		If the dispute is not valid, we will credit these points back. 
		If the dispute is found to be valid, no points will be credited back.
	</p>

	<p>
		We are currently taking a closer look at this dispute. 
		We must let you know that one more disputed contact will 
		result in suspension of your account.
		Thanks for your understanding.
	</p>

	<br>
	<br>
	
	<div style="font-size: smaller;">
		Sincerely,<br>
		The Leadcliq Team.
	</div>
</div>
