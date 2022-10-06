<div class="modal fade" id="step-2">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Welcome to Leadcliq: Step 2</h4>
			</div>
			<div class="modal-body">
				<p>Join a circle to boost your sales!</p>

				<p>{{ link_to_route('circles.create', 'Add new circle') }}</p>

				@if ($circles->count() > 0)
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>Name</th>
						</tr>
					</thead>

					<tbody>
						@foreach ($circles as $circle)
							@if($user->belongsToCircle($circle->id) == false)
								<tr>
									<td>{{{ $circle->name }}}</td>
		
		
									<td>{{ Form::open(array('method' => 'POST', 'route' => array('circles.join', $circle->id))) }} {{ Form::submit('Join', array('class' => 'btn btn-default')) }} {{ Form::close() }}</td>
		
									<td>{{ link_to_route('circles.edit', 'Edit', array($circle->id), array('class' => 'btn btn-info')) }}</td>
		
									<td>{{ Form::open(array('method' => 'DELETE', 'route' => array('circles.destroy', $circle->id))) }} {{ Form::submit('Delete', array('class' => 'btn btn-default')) }} {{ Form::close() }}</td>
								</tr>
							@endif
						@endforeach
					</tbody>
				</table>
				@else
				<p>There are no circles</p>
				@endif
			</div>
			<div class="modal-footer">
				<a href="javascript:nextStep(2)">I'm done</a>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

