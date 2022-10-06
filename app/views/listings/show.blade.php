@extends('layouts.bootstrap')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-sm-8">
            <h1>{{$listing->listing_title}}</h1>
            <br/>
        </div>`
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="color-box extra-bottom">
                <h2>General</h2>
                <br />
                <div class="row">
                    <div class="col-xs-4 text-muted">Appointment Date:</div>
                    <div class="col-xs-8">{{$listing->event_at}}</div>
                </div>
                <div class="row">
                    <div class="col-xs-4 text-muted">Status:</div>
                    <div class="col-xs-8">                    
                    {{{ $listing->is_published!==1 ? 'Draft' : 'Published' }}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4 text-muted">Bidding Stops:</div>
                    <div class="col-xs-8">{{$listing->event_at}}</div>
                </div>
<!--                <div class="row">-->
<!--                    <div class="col-xs-4 text-muted">Interest:</div>-->
<!--                    {{-- <div class="col-xs-8">{{$listing->offers->count()}} Offers</div> --}}-->
<!--                     -->
<!--                </div>-->
            </div>
            <div class="color-box extra-bottom">
                <h2>Address</h2>
                <br />
                <div class="row">
                    <div class="col-xs-4 text-muted">Address:</div>
                    <div class="col-xs-8">
                       {{ ($listing->seller_id==Sentry::getUser()->id ? $listing->address:'<em>Details available only after winning bid</em>') }} 
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4 text-muted">Zip:</div>
                    <div class="col-xs-8">{{isset($listing->city) ? $listing->city->zip: ""}}</div>
                </div>
                <div class="row">
                    <div class="col-xs-4 text-muted">City:</div>
                    <div class="col-xs-8">{{isset($listing->city) ? $listing->city->name: ""}}</div>
                </div>
                <div class="row">
                    <div class="col-xs-4 text-muted">State:</div>
                    <div class="col-xs-8">{{isset($listing->city)? $listing->city->state->name:"N/A"}}</div>
                </div>
                <div class="row">
                    <div class="col-xs-4 text-muted">General Details</div>
                    <div class="col-xs-8">
                        {{($listing->seller_id==Sentry::getUser()->id  ? $listing->gen_address_info:'<em>Details available only after winning bid</em>')}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4 text-muted">Special Notes</div>
                    <div class="col-xs-8">
                        {{ $listing->seller_id==Sentry::getUser()->id ?  $listing->special_address_info:'<em>Details available only after winning bid</em>' }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4 text-muted">Conference</div>
                    <div class="col-xs-8">{{$listing->is_conference}}</div>
                </div>
                <div class="row">
                    <div class="col-xs-4 text-muted">Dial Instructions</div>
                    <div class="col-xs-8">
                        {{$listing->seller_id==Sentry::getUser()->id ? $listing->dialing_instructions:'<em>Details available only after winning bid</em>'}}
                    </div>
                </div>
            </div>
        </div>
    <div class="col-sm-6">
        <div class="color-box extra-bottom">
            <h2>Opportunity Details</h2>
            <br />
            <div class="row">
                <div class="col-xs-4 text-muted">Manager Name</div>
                <div class="col-xs-8">
                  {{$listing->seller_id==Sentry::getUser()->id ? $listing->contact_name:'<em>Details available only after winning bid</em>'}}
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4 text-muted">Manager Title</div>
                <div class="col-xs-8">{{--$listing->contactTitle->name--}}</div>
            </div>
            <div class="row">
                <div class="col-xs-4 text-muted">Industry</div>
                <div class="col-xs-8">{{$listing->industry->name}}</div>
            </div>
            <div class="row">
                <div class="col-xs-4 text-muted">Company Size</div>
                <div class="col-xs-8">{{$listing->companySizeTier->name}}</div>
            </div>
            <div class="row">
                <div class="col-xs-4 text-muted">Project Size</div>
                <div class="col-xs-8">{{$listing->dealSizeTier->name}}</div>
            </div>
            <div class="row">
                <div class="col-xs-4 text-muted">Meeting Description</div>
                <div class="col-xs-8">
                    {{($listing->seller_id==Sentry::getUser()->id ? $listing->listing_description:'<em>Details available only after winning bid</em>')}}
                </div>
            </div>
        </div>
        <div class="color-box extra-bottom">
            <h2>Opportunity Terms</h2>
            <br />
            <div class="row">
                <div class="col-xs-4 text-muted">Sell for</div>
                <div class="col-xs-8">{{$listing->for_points?"Points":"Money"}}</div>
            </div>
            <div class="row">
                <div class="col-xs-4 text-muted">Price</div>
                <div class="col-xs-8">{{$listing->price}}</div>
            </div>
            <div class="row">
                <div class="col-xs-4 text-muted">Circles:</div>
                <div class="col-xs-8">{{implode($listing->circles()->lists('name'),', ')}}</div>
            </div>
        </div>
    </div>
</div>
</div>
@stop
@section('scripts')
@stop
