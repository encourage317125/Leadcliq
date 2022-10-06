<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title">Create new report</h4>
		</div>
		
		<form action="{{ URL::route('send-report-user', $user_id) }}" method="POST">
			<div class="modal-body">
					<div class="row rowspace">
						<div class="col-md-12">
							<label>Describe the problem you have with this user</label>
							<textarea class="form-control" name="report_description" id="report_description" required></textarea>
						</div>
					</div>				        
			</div>

			<div class="modal-footer">
				<div id="modal-edit-submit" class="inline-button">
					<button type="submit" class="btn btn-danger">Report</button>
				</div>
			</div>
		</form>					
	</div>
</div>