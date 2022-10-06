<div class="modal fade" id="change-password-window">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Change password</h4>
			</div>
			<div class="modal-body">
				{{ Form::model($user, array('method' => 'POST', 'route' => array('profile.updatePassword'))) }}
					<div class="left-label">New Password</div>
					<input type="password" name="password" class="form-control">
					<br>
					{{ Form::submit('Save', array('class' => 'btn btn-info')) }}
				{{ Form::close() }}
			</div>
			<div class="modal-footer">
				<a href="javascript:closePassword()">Cancel</a>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
	function openPassword(){
		$('#change-password-window').modal('show');
	}

	function closePassword(){
		$('#change-password-window').modal('hide');
	}
</script>