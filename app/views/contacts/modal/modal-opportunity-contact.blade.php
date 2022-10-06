<!-- <div class="modal fade" id="new-modal-window"> This is already on the Main layout and used by modal controller -->
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Please describe the live opportunity</h4>
			</div>
			{{ Form::model($contact, array('onsubmit' => 'return false;', 'class' => 'validate-form', 'id' => 'modal-edit-form', 'method' => 'POST', 'route' => array('contact-update', $contact->id))) }}
				<div class="modal-body">
					    <ul>
							<li>
					            {{ Form::label('opportunity_description', 'Opportunity Description') }}
					            {{ Form::textarea('opportunity_description') }}
					        </li>
					    </ul>
					<br>
					@if ($errors->any())
					    <ul>
					        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
					    </ul>
					@endif
				</div>
				<div class="modal-footer">
					<div id="modal-edit-submit" class="inline-button">
						<button type="submit" class="btn btn-default">Save</button>
					</div>
				</div>
			{{ Form::close() }}
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
	
<!-- </div> already on Main layout close-->
	
<script>
	var metrics = [
	    [ '#opportunity_description', 'presence', 'Can not be empty' ],	
        [ '#opportunity_description', 'min-length:40', 'Must be at least 40 characters long' ]
    ];
</script>





