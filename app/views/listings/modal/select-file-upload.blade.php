<div class="modal fade" id="new-modal-window">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Upload .CSV contacts file</h4>
			</div>
			<div class="modal-body">
					<p>			
					Required fields include contact's <strong>First Name, Last Name, Company, Title, Email and Direct phone</strong>. However you are 
					encouraged to include a a Cell Phone number, City and State. Lists are limited to 100 per upload.
					</p>
					
					{{ Form::open(array('route' => 'parse-listings-file', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'role' => 'form')) }}
				        <div>
					       	<label style="width: 100%;" for="file">Select .CSV file to upload</label>
							<input class='form-control' type="file" name="file" id="file" required="required">
				        </div>
						<button style="margin-top: 17px;" type="submit" class="btn btn-default">Upload File</button>
					{{ Form::close() }}
				
				
			</div>
			<div class="modal-footer">
				<a href="javascript:closeModal()">Cancel</a>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
	function openModal(){
		$('#new-modal-window').modal('show');
	}

	function closeModal(){
		$('#new-modal-window').modal('hide');
	}
</script>