<!-- <div class="modal fade" id="new-modal-window"> This is already on the Main layout and used by modal controller -->
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Edit contact</h4>
			</div>
			
			{{ Form::model($contact, array('onsubmit' => 'return false', 'class' => 'validate-form', 'id' => 'modal-edit-form', 'method' => 'PATCH', 'route' => array('contacts.update', $contact->id))) }}
				<div class="modal-body">
					
				<div class="row rowspace">
					<div class="col-md-6">
						<label>First Name</label>
						<input class="form-control" value="{{$contact->first_name}}" required name="first_name" placeholder="First Name" ></input>
					</div>
					<div class="col-md-6">
						<label>Last Name</label>		
						<input class="form-control" value="{{$contact->last_name}}" required name="last_name" placeholder="Last Name" ></input>
					</div>
				</div>

				<div class="row rowspace">
					<div class="col-md-6">
						<label>Company</label>
						<input class="form-control" value="{{$contact->company}}" required name="company" placeholder="Company" ></input>
					</div>
					<div class="col-md-6">
						<label>Title</label>
						<input class="form-control" value="{{$contact->title}}" required name="title" placeholder="Title" ></input>
					</div>
				</div>

				<div class="row rowspace">
					<div class="col-md-6">
						<label>Phone</label>
						<input class="form-control phoneinput" value="{{$contact->direct}}" required name="direct" placeholder="Direct Phone" ></input>
					</div>
					<div class="col-md-6">
						<label>Phone Extension</label>
						<input class="form-control" value="{{$contact->direct_ext}}" name="direct_ext" placeholder="Extension" ></input>
					</div>
				</div>

				<div class="row rowspace">
					<div class="col-md-6">
						<label>Cell Phone</label>
						<input class="form-control phoneinput" value="{{$contact->cell}}" name="cell" placeholder="Cell Phone" ></input>
					</div>
					<div class="col-md-6">
						<label>Email</label>
						<input type="email" class="form-control" value="{{$contact->email}}" required name="email" placeholder="Email" ></input>
					</div>
				</div>

				<div class="row rowspace">
					<div class="col-md-4">
						<input class="form-control" onblur="getCity(this.value)" value="{{$contact->zip}}" required id="zip" name="zip" placeholder="Zip Code" ></input>
					</div>
					<div class="col-md-4">
						<input class="form-control" value="{{$contact->city}}" required id="city" name="city" placeholder="City" readonly=""></input>
					</div>
					<div class="col-md-4">
						<input class="form-control" value="{{$contact->state}}" required id="state" name="state" placeholder="State" readonly=""></input>
					</div>
				</div>

				<div class="row rowspace">
					<div class="col-md-12">
						<label>Notes about this contact (will be shared with buyers)</label>
						<textarea class="form-control" value="{{$contact->notes}}" name="notes" placeholder="Notes about this contact (will be shared with buyers)"></textarea>
					</div>
				</div>				        

				@if ($errors->any())
				    <ul>
				        {{ implode('', $errors->all('<li class="error">:message')) }}
				    </ul>
				@endif
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
    	[ '#first_name', 'presence', 'Can not be empty' ],
    	[ '#last_name', 'presence', 'Can not be empty' ],
    	[ '#first_name', 'min-length:2', 'Must be at least 2 characters long' ],
        [ '#last_name', 'min-length:2', 'Must be at least 2 characters long' ]
    ];
</script>
	
