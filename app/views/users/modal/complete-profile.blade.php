 <div class="modal fade" id="step-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">          
          <h4 class="modal-title">Welcome to Leadcliq: Step 1</h4>
        </div>
        <div class="modal-body">
          <p>Complete your profile to make the most out of <strong>Leadcliq</strong></p>
          @include('users.profile_edit_form')->with('errors',$errors)->with('user',$user)
        </div>
        <div class="modal-footer">
          {{ Form::submit('Save', array('class' => 'btn btn-info')) }}    		
		  {{ Form::close() }}
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  
  
<script>
	$('#step-1').modal('show');
</script>









