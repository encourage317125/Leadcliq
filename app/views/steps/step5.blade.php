	<div class="container">
		<div class="row">
			<div class="modal-box modal-box-shadow col-md-10 col-md-offset-1">
				<div class="modal-box modal-box-2">
					<div class="profile-modal modal-box modal-box-2">
						<div class="profile-modal-header">
							<h2 class="profile-modal-header-title"><span class="title-step">Step 5</span>Circles</h2>
						</div>
						<div class="profile-modal-body">
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
									</div>
								</div>

							<form class="form-profile form-inline" role="form" >
								<div class="row">
								
									<div class="form-group col-sm-6">
									    <input type="text" class="form-control input-search" id=""
									    onkeyup="searchTable(this.value, 'available-circles')" placeholder="Join an existing circle...">
									</div>
									<div class="form-group col-sm-6">
										<div class="input-append row">
											<div class="col-sm-10">
												<input type="text" class="form-control" id="" disabled="" placeholder="Name of new Circle">
												<h6 class="text-center">Yet not available</h6>
											</div>
											<div class="col-sm-2" style="padding-left:0;">
												<button disabled="" class="btn btn-success btn-lg">+</button>
											</div>
									    </div>
									</div>
								</div>
							</form>
							@if ($circles->count())
							    <table id="available-circles" class="table table-striped">
							    	<thead>
										<tr>
											<th>Name</th>
											<th></th>
										</tr>
									</thead>
							        <tbody>
							            @foreach ($circles as $circle)
							            	@if($user->belongsToCircle($circle->id) == false)
								                <tr>
								                    <td class="name">{{{ $circle->name }}}</td>
								
								         			<td align="center">
								                        {{ Form::open(array('class' => 'ajax-join-circle', 'method' => 'POST', 'route' => array('circles.join', $circle->id))) }}
								                            {{ Form::submit('Join', array('class' => 'btn btn-default')) }}
								                        {{ Form::close() }}
								                    </td>           
								                </tr>
								        	@endif
							            @endforeach
							        </tbody>
							    </table>
							@else
							    <h5>There are no circles</h5>
							@endif
						</div>

						<script>
							var targetTable = document.getElementById('available-circles');
						</script>

						<div class="profile-modal-footer">
							<div class="row">
								<div class="col-sm-2">
									<button class="btn btn-default btn-lg" onclick="showPrevStep(5)">PREVIOUS</button>
								</div>
								<div class="col-sm-8">
									<ul class="slide-step list-unstyled list-inline">
										<li><span class="step"></span></li>
										<li><span class="step"></span></li>
										<li><span class="step"></span></li>
										<li><span class="step active"></span></li>
									</ul>
								</div>
								<div class="col-sm-2">
									<a href="{{ URL::route('profile') }}">
										<button class="btn btn-primary btn-lg pull-right" id="steps-finish-button" disabled="disabled">
												FINISHED <i class="icon-like"></i>		
										</button>
									</a>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>