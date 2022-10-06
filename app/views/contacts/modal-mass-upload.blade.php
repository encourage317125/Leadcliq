<div class="modal fade" id="modal-mass-upload">
	<div class="modal-dialog" style="width: 95%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Select the columns to upload contacts</h4>
				<p class="text-danger text-center" id="mass-upload-error"></p>
			</div>
			<div class="modal-body">
				@if (sizeof($data) > 0)
				
				{{ Form::open(array('id' => 'mass-upload-form', 'onsubmit' => 'return checkMassUploadHeaders()', 'route' => 'save-mass-contacts', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'role' => 'form')) }}
				
				<input type="submit" class="btn btn-default" value="Save contacts">

				<table class="table table-bordered" style="background: white;">
					<thead>
						<tr>
							<th style="width: 40px;"> # </th>
							@foreach ($data['header'] as $key => $header)
								<th style="padding: 5px;">
									<select name="header[{{ $key }}]" style="padding: 0; margin: 0;">
										<optgroup label="Required">
											<option value="none_{{{$key}}}">--Select--</option>
											<option value="first_name">First Name</option>
											<option value="last_name">Last Name</option>
											<option value="title">Title</option>
											<option value="company">Company</option>
											<option value="email">Email</option>
											<option value="direct">Direct Phone</option>
										</optgroup>
									
										<optgroup label="Optional">
											<option value="direct_ext">Direct Phone Ext.</option>
											<option value="cell">Cell Phone</option>
											<option value="general">General Phone</option>
											<option value="general_ext">General Phone Ext.</option>
											<option value="city">City</option>
											<option value="state">State</option>
										</optgroup>	
									</select>
									<div style="margin-top: 3px;">
										{{{ $header }}}
									</div>								
								</th>
							@endforeach
						</tr>
					</thead>
					<tbody>
						@foreach ($data['contacts'] as $j => $contact)
							<tr>
								<td align="center">{{$j + 1}}</td>
								@foreach ($contact as $p => $data)
									<td>
										<input class="no-edition" type="text" name="contacts[{{ $j }}][{{ $p }}]" value="{{{ $data }}}" readonly="readonly">  
									</td>
								@endforeach
							</tr>
						@endforeach
					</tbody>
				</table>
				@else
				<p>Error parsing file</p>
				@endif
			</div>
			<div class="modal-footer">
				<button type="button" class="close" data-dismiss="modal">Close</button>
			</div>
		</div>
		{{ Form::close() }}
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

