<div class="modal fade" id="modal-mass-upload">
	<div class="modal-dialog" style="width: 95%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Select the columns to upload listings</h4>
				<p class="text-danger text-center" id="mass-upload-error"></p>
			</div>
            
			<div class="modal-body">
                
				@if (sizeof($data['header']) > 0)
				
				{{ Form::open(array('id' => 'mass-upload-form', 
                    'onsubmit' => 'return checkListingMassUploadHeaders()', 
                    'route' => 'save-mass-listings', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'role' => 'form')) 
                }}
				
				<input type="submit" class="btn btn-default" value="Save listings">

				<table class="table table-bordered" style="background: white;">
					<thead>
						<tr>
							<th style="width: 40px;"> # </th>
                            
							@foreach ($data['header'] as $key => $header)
								<th style="padding: 5px;">
									<select name="header[{{ $key }}]" style="padding: 0; margin: 0;">
										<optgroup label="Required">
											<option value="none_{{{$key}}}">--Select--</option>
                                            <option value="listing_type">Listing Type</option>                                            
                                            <option value="listing_title">Title</option>                                                                                        
                                            <option value="company_id">Company Id</option>
                                            <option value="zip">Zip</option>
                                            <option value="address">Street Address</option>
										</optgroup>
									    <optgroup label="Contact">
                                            <option value="contact_name">Contact Name</option>
                                            <option value="contact_email">Contact Email</option>                                                                                        
                                        </optgroup>
                                        
                                        <optgroup label="Optional">
                                            <option value="listing_ description">Description</option>
                                            <option value="is_published">Published</option>
                                            <option value="is_released">Released</option>
                                            <option value="can_bid">Can Bid</option>
                                            <option value="for_points">For points</option>
                                            <option value="has_checkpoints">Has Points</option>
                                            <option value="variable_price">Variable Price</option>
                                            <option value="listing_feedback">Listing Feedback</option>
                                            <option value="stars">Stars</option>
                                            <option value="gen_address_info">General Address Info</option>
                                            <option value="special_address_info">Special Address Info</option>
                                            <option value="is_conference">Is Conference</option>
                                            <option value="dialing_instructions">Dialing Instructions</option>                                            
                                            <option value="contact_phone1">Contact Phone1</option>
                                            <option value="contact_phone2">Contact Phone2</option>
                                            <option value="contact_cell">Contact Cell</option>
                                            <option value="contact_cell">Contact Relationship</option>
                                            <option value="notes">Notes</option>
                                            <option value="intro_available">Intro Available</option>
                                            <option value="opportunity_description">Opportunity Description</option>
                                            <option value="company_size">Company Size</option>
                                            <option value="industry_id">Industry Id</option>
                                            <option value="deal_size_tier_id">Deal Size Tier Id</option>
                                            <option value="deleted_at">Deleted</option>
                                            <option value="title_id">Title Id</option>                                            
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
						@foreach ($data['listings'] as $j => $listing)
							<tr>
								<td align="center">{{$j + 1}}</td>
								@foreach ($listing as $p => $data)
									<td>
										<input class="no-edition" type="text" name="listings[{{ $j }}][{{ $p }}]" value="{{{ $data }}}" readonly="readonly">  
									</td>
								@endforeach
							</tr>
						@endforeach
					</tbody>
				</table>
                {{ Form::close() }}
				@else
				<p>Error parsing file</p>
				@endif
		    </div>
			<div class="modal-footer">
				<button type="button" class="close" data-dismiss="modal">Close</button>
			</div>
		</div>
		        
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

