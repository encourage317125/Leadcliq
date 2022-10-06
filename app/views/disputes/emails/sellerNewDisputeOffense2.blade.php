<div style="color: #555;">

	Dear {{ $user->first_name }}, <br>
	<p>
		A dispute has been filed against a contact that you sold. 
		The contact was {{ $contact->first_name }} {{ $contact->last_name }}.  
		We have deducted points from your account in the amount equal to what the buyer 
		paid for the contact. If the dispute is not valid, we will credit these points back. 
		If the dispute is found to be valid, no points will be credited back.
	</p>

	<p>
		We're sure this was an innocent mistake but we still must look in to it. 
		Thanks so much for your continued business!
	</p>

	<br>
	<br>
	
	<div style="font-size: smaller;">
		Sincerely,<br>
		The Leadcliq Team.
	</div>
</div>
