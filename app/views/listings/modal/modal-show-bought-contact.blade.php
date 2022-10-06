<!-- <div class="modal fade" id="new-modal-window"> This is already on the Main layout and used by modal controller -->
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Bought Contact</h4>
			</div>
			<div class="modal-body">
			
				<div class="row rowspace">
					<div class="col-md-6">
						<label>First Name</label>
						<input class="form-control" value="{{$contact->first_name}}"  name="first_name" placeholder="First Name" >
					</div>
					<div class="col-md-6">
						<label>Last Name</label>		
						<input class="form-control" value="{{$contact->last_name}}"  name="last_name" placeholder="Last Name" >
					</div>
				</div>

				<div class="row rowspace">
					<div class="col-md-6">
						<label>Company</label>
						<input class="form-control" value="{{$contact->company}}"  name="company" placeholder="Company" >
					</div>
					<div class="col-md-6">
						<label>Title</label>
						<input class="form-control" value="{{$contact->title}}"  name="title" placeholder="Title" >
					</div>
				</div>

				<div class="row rowspace">
					<div class="col-md-6">
						<label>Phone</label>
						<input class="form-control phoneinput" value="{{$contact->direct}}"  name="direct" placeholder="Direct Phone" >
					</div>
					<div class="col-md-6">
						<label>Phone Extension</label>
						<input class="form-control" value="{{$contact->direct_ext}}" name="direct_ext" placeholder="Extension" >
					</div>
				</div>

				<div class="row rowspace">
					<div class="col-md-6">
						<label>Cell Phone</label>
						<input class="form-control phoneinput" value="{{$contact->cell}}" name="cell" placeholder="Cell Phone" >
					</div>
					<div class="col-md-6">
						<label>Email</label>
						<input type="email" class="form-control" value="{{$contact->email}}" name="email" placeholder="Email" >
					</div>
				</div>

				<div class="row rowspace">
					<div class="col-md-4">
						<input class="form-control" value="{{$contact->zip}}"  id="zip" name="zip" placeholder="Zip Code" >
					</div>
					<div class="col-md-4">
						<input class="form-control" value="{{$contact->city}}"  id="city" name="city" placeholder="City" >
					</div>
					<div class="col-md-4">
						<input class="form-control" value="{{$contact->state}}"  id="state" name="state" placeholder="State" >
					</div>
				</div>

				<div class="row rowspace">
					<div class="col-md-12">
						<label>Notes about this contact</label>
						<textarea class="form-control" name="notes">{{$contact->notes}}</textarea>
					</div>
				</div>		
				
				<div class="row rowspace">
					<div class="col-md-12">
						<div class="panel panel-success">
							<div class="panel-heading">
								Contact Feedback
							</div>
							<div class="panel-body">
								@if($feedback && $feedback->status === ContactFeedback::$STATUS_OPEN)
									<h6>You can add a feedback after assesing this contact, no rush, take your time.</h6>
									<br>

									<form onsubmit="ajaxSubmit(this.id, 'feedback-submit', afterFeedback)" id="feedback-form" action="{{ URL::route('add-contact-feedback', $feedback->id) }}" method="POST">
										<label for="points">This contact was: </label>
										<select name="points">
											<option value="{{ ContactFeedback::$FEEDBACK_EXCELLENT }}">Excellent</option>
											<option value="{{ ContactFeedback::$FEEDBACK_GOOD}}">Good</option>
											<option value="{{ ContactFeedback::$FEEDBACK_AVERAGE}}">Average</option>
											<option value="{{ ContactFeedback::$FEEDBACK_NOT_GOOD}}">Not Good</option>
										</select>
										<br>
										<textarea id="comments" name="comments" placeholder="Comment here" class="form-control"></textarea>
										<br>

										<div id="feedback-submit" class="pull-right">
											<button type="submit" class="btn btn-default">Send</button>
										</div>
									</form>
								@elseif ($feedback)
									<p>Your contact feedback was <span class="text-info">{{ $feedback->getPointsReadable() }}</span>.</p>
									<h6>Feedback date: {{ (new DateTime($feedback->created_at))->format('m-d-Y') }}</h6>
								@endif
							</div>
						</div>
					</div>
				</div>	

				<div class="row rowspace">
					<div class="col-md-12">
						<div class="panel panel-warning">
							<div class="panel-heading">
								Contact History
							</div>
							<div class="panel-body">
								@foreach($contact->transactions as $transaction)
									<div class="tl-entry">
									  	<div class="tl-date text-muted">{{ (new DateTime($transaction->created_at))->format('m-d-Y H:m') }}hs</div>
										<div>{{ $transaction->getReadable() }}</div>
									</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>		

				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-success">
							<div class="panel-heading">
								Live Opportunity information
							</div>
							<div class="panel-body">
								@if ($contact->opportunity)	
									<div class="tl-entry">
										<div class="row">
											<div class="col-md-4">
									  			<div class="tl-date text-muted">Opportunity Title</div>
											</div>
											<div class="col-md-8">
												<div>{{$contact->opportunity_title}}</div>
											</div>
										</div>
									</div>

									<div class="tl-entry">
										<div class="row">
											<div class="col-md-4">
									  			<div class="tl-date text-muted">Opportunity Description</div>
											</div>
											<div class="col-md-8">
												<div>{{$contact->opportunity_description}}</div>
											</div>
										</div>
									</div>

									<div class="tl-entry">
										<div class="row">
											<div class="col-md-4">
									  			<div class="tl-date text-muted">Expiration date of lead</div>
											</div>
											<div class="col-md-8">
												<div>{{$contact->expiration}}</div>
											</div>
										</div>
									</div>

									<div class="tl-entry">
										<div class="row">
											<div class="col-md-4">
									  			<div class="tl-date text-muted">Project size</div>
											</div>
											<div class="col-md-8">
												<div>{{$contact->project_size}}</div>
											</div>
										</div>
									</div>

									<div class="tl-entry">
										<div class="row">
											<div class="col-md-4">
									  			<div class="tl-date text-muted">Relationship</div>
											</div>
											<div class="col-md-8">
												<div>{{$contact->relationship}}</div>
											</div>
										</div>
									</div>
								@else
									<p><small>Name Live Opportunity is not available for this contact.</small></p>
								@endif
							</div>
						</div>
					</div>
				</div>


				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-info">
							<div class="panel-heading">
								Original owner information
							</div>
							<div class="panel-body">
							@if ($contact->intro_available)	
								<div class="row rowspace">
									<div class="col-md-6">
										<label>First Name</label>
										<input class="form-control" value="{{$owner->first_name}}"  name="first_name">
									</div>
									<div class="col-md-6">
										<label>Last Name</label>		
										<input class="form-control" value="{{$owner->last_name}}"  name="last_name">
									</div>
								</div>

								<div class="row rowspace">
									<div class="col-md-6">
										<label>Company</label>
										<input class="form-control" value="{{$owner->company}}"  name="company">
									</div>
									<div class="col-md-6">
										<label>Title</label>
										<input class="form-control" value="{{$owner->title}}"  name="title">
									</div>
								</div>

								<div class="row rowspace">
									<div class="col-md-4">
										<label>Phone</label>
										<input class="form-control phoneinput" value="{{$owner->phone}}"  name="direct">
									</div>
									<div class="col-md-2">
										<label>Ext.</label>
										<input class="form-control" value="{{$owner->extension}}" name="extension">
									</div>
									<div class="col-md-6">
										<label>Email</label>
										<input class="form-control phoneinput" value="{{$owner->email}}" name="email">
									</div>
								</div>

								<div class="row rowspace">
									<div class="col-md-4">
										<label>Zip</label>
										<input class="form-control" value="{{$owner->zip}}"  id="zip" name="zip">
									</div>
									<div class="col-md-4">
										<label>City</label>	
										<input class="form-control" value="{{$owner->city}}"  id="city" name="city">
									</div>
									<div class="col-md-4">
										<label>State</label>
										<input class="form-control" value="{{$owner->state}}"  id="state" name="state">
									</div>
								</div>

								<div class="row rowspace">
									<div class="col-md-4">
										<label>Industry</label>
										<input class="form-control" value="{{$owner->industry}}"  id="industry" name="industry">
									</div>
									<div class="col-md-8">
										<label>Services provided</label>
										<input class="form-control" value="{{$owner->services_provide}}"  id="services_provide" name="services_provide">
									</div>
								</div>
								
							@else
								<p><small>Name drop is not available for this contact.</small></p>
							@endif

								<h6><a class="text-danger pull-right" href="javascript:showModalContent('prepare-report-user/{{ $owner->id }}')">Report this user</a></h6>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a href="javascript:closeModal()">Close</a>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
	
<!-- </div> already on Main layout close-->
