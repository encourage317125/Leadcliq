	<div class="container form-wizard">
		<div class="row">
			<div class="modal-box modal-box-shadow col-md-10 col-md-offset-1">
				<div class="modal-box modal-box-2">
					<div class="profile-modal modal-box modal-box-2">
						<div class="profile-modal-header">
							<h2 class="profile-modal-header-title"><span class="title-step">Step 2</span>Professional Information</h2>
						</div>
						<div class="profile-modal-body">
							<div class="add-photo add-photo-lg">
								<a href="javascript:chooseImgAndUpload()">
									<span class="add-photo-img">
										<span>
										@if(!is_null($user->photo) && strlen($user->photo) > 2)
										<img src="{{$user->photo}}" alt="" class="profile-round-img">
										@else
										<img src="http://placehold.it/140x140&text=no-image" alt="">
										@endif
										</span>
									</span>
								</a>
							</div>
							<br>

							<form id="step2-form" method="POST" action="{{ URL::route('profile.updateOnly') }}" class="form-profile form-inline" role="form">
								<div class="row">

									<div class="form-group col-sm-4">
										<label for="currentCompany" class="sitting-label">Company: </label>
									    <select id="currentCompany" name="company" class="required" placeholder="Company">
									    @if ( $user->company )
                                            <option value='{{$user->company->id}}' selected="selected">{{$user->company->name}}</option>
                                        @endif
									    </select>
									</div>
									<div class="form-group col-sm-4">
										<label for="currentTitle" class="sitting-label">Title: </label>								    
									    <select id="currentTitle" name="title" class="required" placeholder="Title">
									    @if ( $user->title )
                                            <option value='{{$user->title->id}}' selected="selected">{{$user->title->name}}</option>
                                        @endif
									    </select>
									</div>
                                    <div class="form-group col-sm-4">
                                    	<label for="currentIndustry" class="sitting-label">Industry: </label>
                                        <select id="currentIndustry" name="industry" class="required" placeholder="Industry">
									    @if ( $user->industry )
                                            <option value='{{$user->industry->id}}' selected="selected">{{$user->industry->name}}</option>
                                        @endif
									    </select>
                                    </div>
                                    <div class="form-group col-sm-12">
                                    	<label for="offersServices" class="sitting-label">Products/services offered: </label>
                                        <select id="offersServices" name="offers_services[]" multiple="multiple" class="required" placeholder="Products/services offered">
                                        </select>
                                    </div>
									<div class="form-group col-sm-12">
										<label for="companiesWorkedWith" class="sitting-label">Notable companies work/ed with: </label>
                                        <select id="companiesWorkedWith" name="companies_worked_with[]" multiple="multiple" class="required" placeholder="Notable companies work/ed with">
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-12">
                                    	<label for="successStory" class="sitting-label">Your success story: </label>
                                        <textarea id="successStory" type="text" class="form-control required" name="success_story" placeholder="Your success story">{{ $user->success_story }}</textarea>
                                    </div>

                                    <div class="col-sm-12 well">
                                        <p>Your personal information will always remain private unless you release it to a buyer, however some of your professional information will be available for credibility purposes if you leave this checked.</p>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="isPublic" name="is_public" checked="checked" value="1" style="margin-right:10px;">
                                                My professional information is public
                                            </label>
                                        </div>
                                    </div>

								</div>
							</form>
						</div>

						<div class="fill-all text-center text-danger display-none">Please fill all the fileds before moving on, thanks!</div>

						<div class="profile-modal-footer">
							<div class="row">
								<div class="col-sm-2">
									<button class="btn btn-default btn-lg" onclick="showPrevStep(2)">PREVIOUS</button>
								</div>
								<div class="col-sm-8">
									<ul class="slide-step list-unstyled list-inline">
										<li><span class="step"></span></li>
										<li><span class="step active"></span></li>
										<li><span class="step"></span></li>
										<li><span class="step"></span></li>
									</ul>
								</div>
								<div class="col-sm-2" id="button-next2-wrap">
									<button class="btn btn-primary btn-lg pull-right" onclick="showNextStep(2, 'step2-form', 'button-next2-wrap')">NEXT <i class="icon-arrow"></i></button>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>