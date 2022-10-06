

<h2>Sell Appointment Share</h2>


<div id="apptsharewizard" class="wizard">
	<ul>
		<li><a href="#general" data-toggle="tab"><span class="number">1</span> General Details</a></li>
		<li><a href="#address" data-toggle="tab"><span class="number">2</span> Appointment Address</a></li>
		<li><a href="#opportunity" data-toggle="tab"><span class="number">3</span> Opportunity Details</a></li>
		<li><a href="#pay-options" data-toggle="tab"><span class="number">4</span> Payment Options</a></li>
		<li><a href="#pay-details" data-toggle="tab"><span class="number">5</span> Payment Terms</a></li>
	</ul>
	<div class="progress progress-striped active">
		<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="0" style="width: 0%;">
			<span class="sr-only">0% Complete</span>
		</div>
	</div>
	<div class="tab-content">
		<div class="tab-pane" id="general">
		{{Former::text('title')->value(isset($appointment)?$appointment->title:Input::old('title'))->placeholder('Enter Apptshare title')->required()}}
			<div class="row">
				<div class="form-group col-md-6">
					{{Form::label('appt_datetime','Appointment Date*',array('class'=>'col-sm-5'))}}
					<div class="col-sm-7">
						{{Former::text('appt_datetime')->label('')->class('datetimepicker')->required()}}
					</div>
				</div>
				<div class="form-group col-md-6">
					{{Form::label('bid_datetime','Bid Expiration*',array('class'=>'col-sm-5'))}}
					<div class="col-sm-7">
						{{Former::text('bid_datetime')->label(null)->class('datetimepicker')->required()}}
					</div>
				</div>
			</div>
			<hr>
		</div>
		<div class="tab-pane" id="address">
			<p>
				<em>Address Required for Location in Sales Territory (required even if it's a conference call)</em>
			</p>
			<p>
				<div class="row">
					<div class="col-md-3">{{Former::text('address')->required()->value(isset($appointment)?$appointment->address:Input::old('address'))->class('col-sm-12')->placeholder('Address')}}</div>
					<div class="col-md-3">{{Former::text('zip')->required()->value(isset($appointment)?$appointment->zip:Input::old('zip'))->class('col-sm-12')->placeholder('Zip')}}</div>
					<div class="col-md-3">{{Former::text('city')->disabled()->name(null)->label('City')->value(isset($appointment)?$appointment->city->name:"")->id('city')->class('col-sm-12')->placeholder('City')}}</div>
					<div class="col-md-3">{{Former::text('state')->disabled()->name(null)->label('State')->value(isset($appointment)?$appointment->city->state->name:"")->id('state')->class('col-sm-12')->placeholder('State')}}</div>
				</div>
			</p>
			<p>
				<div class="row">
					<div class="col-md-6">
						{{Former::text('gen_address_info')->value(isset($appointment)?$appointment->address:Input::old('address'))->class('col-sm-12')->placeholder('General Description about Address')}}
					</div>
					<div class="col-md-6">
						{{Former::text('special_address_info')->value(isset($appointment)?$appointment->address:Input::old('address'))->class('col-sm-12')->placeholder('Special notes about Address')}}
					</div>
				</div>
			</p>
			<div class="clear">&nbsp</div>
			<div class="row">
				<div class="col-md-6">
					{{Former::checkbox('conference')->text("This is a conference call, not a face to face meeting")}}</label>
				</div>
				<div class="col-md-6">
					{{Former::text('dial_instructions')->value(isset($appointment)?$appointment->dial_instructions:Input::old('dial_instructions'))->class('col-sm-12')->placeholder('Provide dial in instructions here')}}
				</div>
			</div>
		</div>			
		<div class="tab-pane" id="opportunity">
			<div class="row">
				<div class="col-md-6 col-sm-6">
					{{Former::text('manager_name')->required()->value(isset($appointment)?$appointment->manager_name:Input::old('manager_name'))->class('col-sm-12')->placeholder('Manager Name')}}
				</div>
				<div class="col-md-6 col-sm-6">
					{{Former::text('manager_title')->required()->value(isset($appointment)?$appointment->manager_title:Input::old('manager_title'))->class('col-sm-12')->placeholder('Manager Title')}}
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 col-sm-6">
					{{Former::select('company_size')->required()->options(Config::get('apptshares.company_sizes'))->value(isset($appointment)?$appointment->company_size:Input::old('company_size'))->class('col-sm-12')->placeholder('Company Size')}}
				</div>
				<div class="col-md-4 col-sm-6">
					{{Former::text('industry')->required()->value(isset($appointment)?$appointment->industry:Input::old('industry'))->class('col-sm-12')->placeholder('Industry')}}
				</div>
				<div class="col-md-4 col-sm-12">
					{{Former::text('project_size')->required()->value(isset($appointment)?$appointment->project_size:Input::old('project_size'))->class('col-sm-12')->placeholder('How large is this project')}}
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					{{Former::textarea('meeting_description')->required()->value(isset($appointment)?$appointment->meeting_description:Input::old('meeting_description'))->class('col-sm-12')->placeholder('Meeting Description')}}
				</div>
			</div>
		</div>
		<div class="tab-pane" id="pay-options">
			<div class="row btn-group" data-toggle="buttons">
				<div class="col-md-6">
					<div class="strong-border text-center extra-padding">
						<span class="glyphicon glyphicon-usd gl-lg extra-bottom text-success"></span>
						<p class="text-muted extra-bottom">Get paid in real money for this appointment</p>
						<hr class="extra-bottom">
						<label class="btn btn-default {{(isset($apptshare) && ($apptshare->sell_for == "money")?"active":"")}}">
							<input id="sell_for" type="radio" name="sell_for" value="money" {{(isset($apptshare) && ($apptshare->sell_for == "money")?"checked":"")}}>Sell this appointment for money
						</label>
					</div>
				</div>
				<div class="col-md-6">
					<div class="strong-border text-center extra-padding">
						<span class="glyphicon glyphicon-heart gl-lg extra-bottom text-info"></span>
						<p class="text-muted extra-bottom">Get points to use in Ledcliq and buy more leads</p>
						<hr class="extra-bottom">
						<label class="btn btn-default {{(isset($apptshare) && ($apptshare->sell_for == "points")?"active":"")}}" for="sell_for">
							<input id="sell_for" type="radio" name="sell_for" value="points" {{(isset($apptshare) && ($apptshare->sell_for == "points")?"checked":"")}}>Sell this appointment for points
						</label>
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane" id="pay-details">
			<div id="sell-money" style="display:none">				
				<p>Monetary values can be set by the seller. You can sell the appointment for one price, or establish multiple pay out points</p>
				<label for="one_price">
					{{Former::radio('pay_option')->value('one_price')->id('one_price')->label(null)}} Just sell this appointment for one price, redgardless of whether a sale is made off of it or not.</label>
					{{Former::text('price')->value(isset($appointment)?$appointment->price:Input::old('price'))->placeholder('Lead Price?')->style('display:none')}}
				<hr>
				<label for="multiple-payout">
					{{Former::radio('pay_option')->value('multiple-payout')->label(null)->id('multiple-payout')->text('Set custom lead price based on multiple check points.')}}</label>
				<div id="checkpoints" style="display:none">
					<a id="add-checkpoint" href="#" class="btn btn-sm btn-default">Add Another CheckPoint</a>
				</div>
				
			</div>
			<div id="sell-points" style="display:none">
				{{Former::select('circle_id')->label('Shared with:')->options($circles)->placeholder('Select circle to share with')}}
			</div>
		</div>
		<ul class="paging wizard">			
			<li class="previous"><a href="#" class="btn btn-info"><i class="glyphicon glyphicon-arrow-left"></i> Previous</a></li>
			<li class="finish" style="display:none;">{{Form::submit('Save',array('class'=>'btn btn-info'))}}</li>
			<li class="next"><a href="#" class="btn btn-info">Next <i class="glyphicon glyphicon-arrow-right"></i></a></li>
		</ul>
	</div>	
</div>

{{Form::close()}}