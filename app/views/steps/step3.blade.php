<div class="container form-wizard">
    <div class="row">
        <div class="modal-box modal-box-shadow col-md-10 col-md-offset-1">
            <div class="modal-box modal-box-2">
                <div class="profile-modal modal-box modal-box-2">
                    <div class="profile-modal-header">
                        <h2 class="profile-modal-header-title"><span class="title-step">Step 3</span>Additional Info</h2>
                    </div>
                    <div class="profile-modal-body">

                        <form id="step3-form" method="POST" action="{{ URL::route('profile.updateOnly') }}" class="form-profile form-inline" role="form">
                            <row>
                                <!--Deal Size Tier-->
                                <div class="form-group col-sm-12">
                                    <label for="dealSizeTier" class="sitting-label">Average Deal Size: </label>
                                    <select id="dealSizeTier" name="deal_size_tier_id" class="form-control required" placeholder="Average Deal Size">
                                        @foreach ($dealSizeTiers as $tier)
                                        <option value='{{$tier->id}}'{{$user->deal_size_tier_id==$tier->id?' selected="selected"':''}}>
                                        {{$tier->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--Seeking Titles-->
                                <div class="form-group col-sm-12">
                                    <label for="seekingTitles" class="sitting-label">Seeking Leads with Title: </label>
                                    <select id="seekingTitles" name="seeking_titles[]" multiple="multiple" class="required" placeholder="Seeking Leads with Title">
                                        @foreach ($user->seekingTitles as $title)
                                        <option value='{{$title->name}}' selected="selected">{{$title->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--Target Industries-->
                                <div class="form-group col-sm-12">
                                    <label for="targetIndustries" class="sitting-label">Seeking Leads in Industries: </label>
                                    <select id="targetIndustries" name="target_industries[]" multiple="multiple" class="required" placeholder="Seeking Leads in Industries">
                                        @foreach ($user->targetIndustries as $industry)
                                        <option value='{{$industry->name}}' selected="selected">{{$industry->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--Network with Titles-->
                                <div class="form-group col-sm-12">
                                    <label for="networksWithTitles" class="sitting-label">I network with the following (titles)</label>
                                    <select id="networksWithTitles" name="network_with_titles[]" multiple="multiple" class="required" placeholder="I network with the following (titles)">
                                        @foreach ($user->networksWithTitles as $title)
                                        <option value='{{$title->name}}' selected="selected">{{$title->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--Complementary Services-->
                                <div class="form-group col-sm-12">
                                    <label for="complementaryServices" class="sitting-label">Complementary Services</label>
                                    <select id="complementaryServices" name="complementary_services[]" multiple="multiple" class="required" placeholder="Complementary Services">
                                        @foreach ($user->complementaryServices as $service)
                                        <option value='{{$service->name}}' selected="selected">{{$service->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </row>
                        </form>
                    </div>
                </div>
                <div class="fill-all text-center text-danger display-none">Please fill all the fileds before moving on, thanks!</div>

                <div class="profile-modal-footer">
                    <div class="row">
                        <div class="col-sm-2">
                            <button class="btn btn-default btn-lg" onclick="showPrevStep(3)">PREVIOUS</button>
                        </div>
                        <div class="col-sm-8">
                            <ul class="slide-step list-unstyled list-inline">
                                <li><span class="step"></span></li>
                                <li><span class="step"></span></li>
                                <li><span class="step active"></span></li>
                                <li><span class="step"></span></li>
                            </ul>
                        </div>
                        <div class="col-sm-2" id="button-next3-wrap">
                            <button class="btn btn-primary btn-lg pull-right" onclick="showNextStep(3, 'step3-form', 'button-next3-wrap')">NEXT <i class="icon-arrow"></i></button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div id="uid">{{ Sentry::getUser()->id }}</div>
