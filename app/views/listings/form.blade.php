
<div class="page-header">
{{-- Use a different title depending unpon the type of listing --}}
@if ($listing_type === 'apptshare')
<h1>Sell ApptShare</h1>
@elseif ($listing_type === 'opportunity')
<h1>Sell Live Opportunity</h1>
@else
<h1>Sell Contact</h1>
@endif
</div>


{{---- Create Wizard ----}}
<div id="apptsharewizard" class="wizard">

    {{-- Tab Titles --}}
	<ul>
		<li><a href="#general" data-toggle="tab"><span class="number">1</span> General Details</a></li>
		<li><a href="#opportunity" data-toggle="tab"><span class="number">2</span> Contact</a></li>
        <li><a href="#address" data-toggle="tab"><span class="number">3</span> Address</a></li>
        <li><a href="#pay-options" data-toggle="tab"><span class="number">4</span> Payment Options</a></li>
		<li><a href="#pay-details" data-toggle="tab"><span class="number">5</span> Payment Terms</a></li>
	</ul>

    {{-- Progress Bar --}}
	<div class="progress progress-striped active">
		<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="0" style="width: 0%;">
			<span class="sr-only">0% Complete</span>
		</div>
	</div>

    {{-- Tabs --}}
    <div class="tab-content">

        {{Former::hidden('listing_type')->value($listing_type)->required()}}
        {{Former::hidden('id')}}

        {{-- Pane 1 --}}
        {{--General Info--}}
        <div class="tab-pane" id="general">

        {{-- Custom for for Apptshare --}}
        {{-- Includes event date and custom placeholders/labels--}}

        @if ($listing_type==="apptshare")
		    {{Former::text('listing_title')->placeholder('E.g., Meeting with Fortune 500 Company seeking new ERP')->required()}}
            {{Former::textarea('listing_description')->required()}}
            <div class="row">
				<div class="form-group col-md-6">
					{{Form::label('event_at','Appointment Date*',array('class'=>'col-sm-5'))}}
					<div class="col-sm-7">
						{{Former::text('event_at')->label('')->class('datetimepicker')->required()}}
					</div>
				</div>
				<div class="form-group col-md-6">
					{{Form::label('expires_at','Bid Expiration*',array('class'=>'col-sm-5'))}}
					<div class="col-sm-7">
						{{Former::text('expires_at')->label(null)->class('datetimepicker')->required()}}
					</div>
				</div>
			</div>
			<hr>

        {{-- Custom for for Opportunity --}}
        {{-- Removes event date and has custom placeholders/labels--}}
        @elseif ($listing_type=="opportunity")
            {{Former::text('listing_title')->placeholder('E.g., CEO at Fortune 500 Hardware company seeks ERP solution')->required()}}
            {{Former::textarea('listing_description')->required()}}
            <div class="row">
                <div class="form-group col-md-6">
                    {{Form::label('expires_at','Bid Expiration*',array('class'=>'col-sm-5'))}}
                    <div class="col-sm-7">
                        {{Former::text('expires_at')->label(null)->class('datetimepicker')->required()}}
                    </div>
                </div>
            </div>
            <hr>

        {{-- Custom for for Contact --}}
        {{-- Removes event date and has custom placeholders/labels--}}
        @else
            {{Former::text('listing_title')->placeholder('E.g., CEO at Fortune 500 Hardware company')->required()}}
            {{Former::textarea('listing_description')->required()}}
            <div class="row">
                <div class="form-group col-md-6">
                    {{Form::label('expires_at','Bid Expiration*',array('class'=>'col-sm-5'))}}
                    <div class="col-sm-7">
                        {{Former::text('expires_at')->label(null)->class('datetimepicker')->required()}}
                    </div>
                </div>
                <div class="col-md-6">
                    {{Former::checkbox('introduction_available')->label('')->text("<strong>Introduction Available</strong>: Providing an introduction will gain you an additional point or allow you to charge more for a listing")}}</label>
                </div>
            </div>
            <hr>


        @endif

        {{-- Pane 2 --}}
        {{-- Contact Info --}}
        </div>
		<div class="tab-pane" id="opportunity">
			<div class="row">
				<div class="col-md-6 col-sm-6">
					{{Former::text('contact_name')->required()->placeholder('Manager Name')}}
				</div>
				<div class="col-md-6 col-sm-6">
                    {{Former::select('title')->name('title_id')->required()->options($titles,$listing?$listing->title_id:null)->placeholder('Contact Title')}}
				</div>
			</div>
            {{-- Only include phone & email if not an apptshare (they're selling the meeting not the contact) --}}
            @if ($listing_type!=="apptshare")
            <div class="row">
                <div class="col-sm-4 col-xs-8">
                    {{Former::number('contact_phone1')->label('Phone 1')->required()}}
                </div>
                <div class="col-sm-2 col-xs-4">
                    {{Former::number('contact_extension1')->label('Ext 1')}}
                </div>
                <div class="col-sm-4 col-xs-8">
                    {{Former::number('contact_phone2')->label('Phone 2')}}
                </div>
                <div class="col-sm-2 col-xs-4">
                    {{Former::number('contact_extension2')->label('Ext 2')}}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    {{Former::text('contact_email')->label('Email')->required()}}
                </div>
            </div>
            @endif
			<div class="row">
				<div class="col-md-4 col-sm-6">
					{{Former::select('company_size_tiers')->name('company_size_tier_id')->required()->options($companySizeTiers,$listing?$listing->company_size_tier_id:null)->class('col-sm-12')->placeholder('Company Size')}}
				</div>
				<div class="col-md-4 col-sm-6">
					{{Former::select('industry_id')->label('industry')->required()->options($industries, $listing?$listing->industry_id:null)->class('col-sm-12')->placeholder('Industry')}}
				</div>
				<div class="col-md-4 col-sm-12">
					{{Former::select('average_deal_size')->name('deal_size_tier_id')->required()->options($dealSizeTiers,  $listing?$listing->deal_size_tier_id:null)->class('col-sm-12')->placeholder('How large is this project')}}
				</div>
			</div>
		</div>

        {{-- Pane 3 --}}
        {{-- Address --}}
        <div class="tab-pane" id="address">
            @if($listing_type==="apptshare")
            <p>
                <em>Address Required for Location in Sales Territory (required even if it's a conference call)</em>
            </p>
            @endif
            <p>
            <div class="row">
                <div class="col-md-3">{{Former::text('address')->required()->class('col-sm-12')->placeholder('Address')}}</div>
                <div class="col-md-3">{{Former::text('zip')->name('zip')->value($listing && $listing->city ? $listing->city->zip:"")->autocomplete('off')->maxlength('5')->required()->class('col-sm-12')->placeholder('Zip')}}</div>
                {{Former::hidden('city_id')->id('city_id')->required()}}
                {{-- City/State fields are getting autofilled just for UI purposes --}}
                {{-- not getting sent back to server so we don't need inputs --}}
                <div class="col-md-3">
                    <label class="control-label">City (autofilled from zip)</label>
                    <div id="city">{{$listing && $listing->city ? $listing->city->name:""}}</div>
                </div>
                <div class="col-md-3">
                    <label class="control-label">State (autofilled from zip)</label>
                    <div id="state">{{$listing && $listing->city ? $listing->city->state:""}}</div>
                </div>
            </div>
            </p>
            <p>
            <div class="row">
                <div class="col-md-6">
                    {{Former::text('gen_address_info')->class('col-sm-12')->placeholder('General Description about Address')}}
                </div>
                <div class="col-md-6">
                    {{Former::text('special_address_info')->class('col-sm-12')->placeholder('Special notes about Address')}}
                </div>
            </div>
            </p>
            <div class="clearfix">&nbsp</div>
            @if ($listing_type==="apptshare")
            <div class="row">
                <div class="col-md-6">
                    {{Former::checkbox('is_conference')->text("This is a conference call, not a face to face meeting")}}</label>
                </div>
                <div class="col-md-6">
                    {{Former::text('dialing_instructions')->class('col-sm-12')->placeholder('Provide dial in instructions here')}}
                </div>
            </div>
            @endif
        </div>

        {{-- Pane 4 --}}
        {{-- Payment Method --}}
        <div class="tab-pane" id="pay-options">
			<div class="row btn-group" data-toggle="buttons">
				<div class="col-md-6">
					<div class="strong-border text-center extra-padding">
						<span class="glyphicon glyphicon-usd gl-lg extra-bottom text-success"></span>
						<p class="text-muted extra-bottom">Get paid in real money for this appointment</p>
						<hr class="extra-bottom">
						<label class="btn btn-default">
							<input id="sell_for" type="radio" name="for_points" value="0">Sell this appointment for money
						</label>
					</div>
				</div>
				<div class="col-md-6">
					<div class="strong-border text-center extra-padding">
						<span class="glyphicon glyphicon-heart gl-lg extra-bottom text-info"></span>
						<p class="text-muted extra-bottom">Get titles to use in Ledcliq and buy more leads</p>
						<hr class="extra-bottom">
						<label class="btn btn-default" for="sell_for">
							<input id="sell_for" type="radio" name="for_points" value="1">Sell this appointment for points
						</label>
					</div>
				</div>
			</div>
		</div>

        {{-- Pane 5 --}}
        {{-- Payment Details --}}
        {{-- Sell for Money or Sell for Points displayed based on Pane 4 selection --}}
		<div class="tab-pane" id="pay-details">

            {{-- Option 1 --}}
            {{-- Sell for Money --}}
            <div id="sell-money" style="display:none">
                {{Former::select('circle_id')->name('circle_ids[]')->multiple('multiple')->label('Share with circles:')->options($circles,$listing?$listing->circles()->lists('circle_id'):array())->placeholder('Select circle to share with')}}
                <p>Monetary values can be set by the seller. You can sell the appointment for one price, or establish multiple pay out points</p>
				<label for="one_price">
					{{Former::radio('pay_option')->value('one_price')->id('one_price')->label(null)}} Just sell this appointment for one price, redgardless of whether a sale is made off of it or not.</label>
					{{Former::text('price')->placeholder('Lead Price?')->style('display:none')}}
				<hr>
				<label for="multiple-payout">
					{{Former::radio('pay_option')->value('multiple-payout')->label(null)->id('multiple-payout')->text('Set custom lead price based on multiple check points.')}}</label>
				<div id="checkpoints" style="display:none">
					<a id="add-checkpoint" href="#" class="btn btn-sm btn-default">Add Another CheckPoint</a>
				</div>
				
			</div>

            {{-- Option 2 --}}
            {{-- Sell for Points --}}
			<div id="sell-points" style="display:none">
				{{Former::select('circle_id')->name('circle_ids[]')->multiple('multiple')->label('Share with circles:')->options($circles)->placeholder('Select circle to share with')}}
			</div>
		</div>

        {{-- Footer --}}
		<ul class="paging wizard">			
			<li class="previous"><a href="#" class="btn btn-info"><i class="glyphicon glyphicon-arrow-left"></i> Previous</a></li>
            <li class="next"><a href="#" class="btn btn-info">Next <i class="glyphicon glyphicon-arrow-right"></i></a></li>
            <li class="publish pull-right" style="display:none;">{{Form::submit('Publish',array('class'=>'btn btn-success','name'=>'submit','value'=>'publish'))}}</li>
            <li class="save-draft pull-right" style="position:relative;top:7px;margin-right:20px">{{Form::submit('Save Draft',array('class'=>'btn btn-warning btn-sm','name'=>'submit','value'=>'draft'))}}</li>
		</ul>
        <div class="clearfix"></div>
	</div>	
</div>
