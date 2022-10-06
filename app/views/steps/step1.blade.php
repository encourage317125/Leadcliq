<div class="container form-wizard">
    <div class="row">
        <div class="modal-box modal-box-shadow col-md-10 col-md-offset-1">
            <div class="modal-box modal-box-2">
                <div class="profile-modal modal-box modal-box-2">
                    <div class="profile-modal-header">
                        <h2 class="profile-modal-header-title"><span class="title-step">Step 1</span>Let’s get started with your profile</h2>
                    </div>
                    <div class="profile-modal-body">
                        {{ Form::open(array('id'=>'update-image-form', 'files'=>'true', 'url' => array('profile/update/picture'))) }}
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <div class="add-photo add-photo-lg">
                                    <a href="javascript:chooseImgAndUpload()">
                                        <span class="btn-upload">Add Photo</span>
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
                                    {{Form::file('photo', array('id'=>'img-open-file', 'class'=>'hidden'))}}
                                </div>
                            </div>
                            </form>
                            <form id="step1-form" method="POST" action="{{ URL::route('profile.updateOnly') }}" class="form-profile form-inline" role="form">
                                <div class="col-sm-12">
                                    <div class="row well">
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="alias" placeholder="Alias" value="{{ $user->alias }}" ext="required">
                                        </div>
                                        <div class="col-sm-6">
                                            <b>This will identify you in our system.</b>
                                            <br/>
                                            We will always keep your name confidential unless you choose to release it on lead sale
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <input type="text" class="form-control" name="first_name" placeholder="First Name" value="{{ $user->first_name }}" required="required">
                                </div>
                                <div class="form-group col-sm-6">
                                    <input type="text" class="form-control" name="last_name" placeholder="Last Name" value="{{ $user->last_name }}" required="required">
                                </div>
                                <div class="form-group col-sm-6">
                                    <input type="text" class="form-control phoneinput" name="phone" placeholder="Phone 1" value="{{ $user->phone }}" required="required">
                                </div>
                                <div class="form-group col-sm-6">
                                    <input type="number" class="form-control extinput" name="extension" placeholder="Ext 1" value="{{ $user->extension }}">
                                </div>
                                <div class="form-group col-sm-6">
                                    <input type="text" class="form-control phoneinput" name="phone2" placeholder="Phone 2" value="{{ $user->phone2 }}">
                                </div>
                                <div class="form-group col-sm-6">
                                    <input type="number" class="form-control extinput" name="extension2" placeholder="Ext 2" value="{{ $user->extension2 }}">
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control required" onblur="getCity(this.value)" value="{{ $user->zip }}" id="zip" name="zip" placeholder="Zip Code" >
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control required" value="{{ $user->city }}" id="city" name="city" placeholder="City" readonly="">
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control" value="{{ $user->state }}" required id="state" name="state" placeholder="State" readonly="">
                                </div>
                                <!--
                                <div class="form-group col-sm-6">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> Agree to terms of service
                                        </label>
                                    </div>
                                </div>
                                -->
                        </div>
                        </form>

                        <div class="fill-all text-center text-danger display-none">Please fill all the fileds before moving on, thanks!</div>

                    </div>


                    <div class="profile-modal-footer">
                        <div class="row">
                            <div class="col-sm-2">

                            </div>
                            <div class="col-sm-8">
                                <ul class="slide-step list-unstyled list-inline">
                                    <li><span class="step active"></span></li>
                                    <li><span class="step"></span></li>
                                    <li><span class="step"></span></li>
                                    <li><span class="step"></span></li>
                                </ul>
                            </div>
                            <div class="col-sm-2" id="button-next1-wrap">
                                <button class="btn btn-primary btn-lg pull-right" onclick="showNextStep(1, 'step1-form', 'button-next1-wrap')">NEXT <i class="icon-arrow"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function chooseImgAndUpload(){
        document.getElementById('img-open-file').click();
    }
</script>






