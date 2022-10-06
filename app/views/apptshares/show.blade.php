@extends('layouts.bootstrap')
@section('content')
<div id="bid-modal" class="modal fade">
    <div class="modal-dialog">
        {{Former::vertical_open()}}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Bid on</h4>
            </div>
            <div class="modal-body">
                <strong style="font-size:18px">ApptShare Details</strong>
                <div class="details">
                    <div id="owner" class="detail" style="margin:7px auto">
                        <strong>Owner: </strong>
                        <span class="value"></span>
                    </div>
                    <div class="row">
                        <div id="pay-with" class="detail col-md-6" style="margin:7px auto">
                            <strong>Pay with: </strong>
                            <span class="value"></span>
                        </div>
                        <div id="amount" class="detail col-md-6" style="margin:7px auto">
                            <strong>Amount: </strong>
                            <span class="value"></span>
                        </div>
                    </div>
                </div>
                <hr>
                <p>Write a special message to go with your bid</p>
                {{Former::hidden('appt-id')}}
                {{Former::textarea('message')}}
            </div>
            <div class="modal-footer">

                {{Former::button('Bid')->icon('thumbs-up')->class('btn btn-default confirm-bid disabled')}}
                <button type="button" class="btn" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="container">
    <div class="row">
        <div class="col-sm-8">
            <h1>{{$appt['title']}}</h1>
            <br/>
        </div>
        <div class="col-sm-4">
            <div style="text-align:right;padding-top:2px;">
                @if($appt->isOwner)
                @if($appt->status != 'public')
                <a href="{{URL::route("apptshares.public",$appt->id)}}" class="btn btn-success"><span class=""></span>Make Public</a>
                @elseif($appt->status == 'public')
                <a href="{{URL::route("apptshares.private",$appt->id)}}" class="btn btn-info"><span class="glyphicon glyphicon-eye-close"></span> Make Private</a>
                @endif
                @if($appt->status != 'cancelled')
                <a href="{{URL::route("apptshares.cancel",$appt->id)}}" class="btn btn-warning"><span class="glyphicon glyphicon-trash"></span> Cancel</a>
                @endif
                <a href="{{URL::route("apptshares.edit",$appt->id)}}" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
                @else
                @if($appt->isBidder)
                <a href="javascript:;" class="btn btn-danger">Cancel Bid</a>
                @else
                <a href="javascript:;" data-id="{{$appt->id}}" data-title="{{$appt->title}}" data-owner="{{$appt->owner->full_name}}" data-currency="{{$appt->sell_for}}" data-amount="{{$appt->price}}" class="btn btn-primary bid">Place Bid</a>
                @endif
                @if($appt->Pending_payment)
                <a href="{{URL::route("apptshares.pay",$appt->id)}}" class="btn btn-danger">Pay Now</a>
                @endif
                @if($appt->isBidder)
                <a href="" class="btn btn-info"><span class="glyphicon glyphicon-envelope"></span> Email Owner</a>
                @endif
                @endif
            </div>
        </div>
    </div>
    @if($appt->status == 'private')
    <div class="alert alert-warning">
        <p><strong>Warning!</strong> Your ApptShare is not public and can't be viewed by other users. Make it public to start receiving bids</p>
    </div>
    @endif

    @if($appt->isOwner)
    <div class="color-box extra-bottom">
        <h2>Bids <a href="{{route('apptshares.reject_all',array($appt->id))}}" class="pull-right btn btn-danger {{$appt->pending_bids > 0 ?"":"disabled"}}"><span class="glyphicon glyphicon-thumbs-down"></span> Reject All Pending</a></h2>
        <br/>
        <table class="table">
            <thead>
            <tr>
                <th>Bidder</th>
                <th>Message</th>
                <th>Status</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($appt->bids as $bid)
            <tr>
                <td>{{$bid->bidder->first_name}} {{$bid->bidder->last_name}}</td>
                <td>{{$bid->message}}</td>
                <td>{{$bid->status}}</td>
                <td style="text-align:right">
                    <a href="{{route('apptshares.accept',array($bid->id))}}" class="btn btn-success {{$bid->status == "accepted"?"disabled":""}}"><span class="glyphicon glyphicon-thumbs-up"></span> Accept</a>
                    <a href="{{route('apptshares.reject',array($bid->id))}}" class="btn btn-danger {{$bid->status == "rejected"?"disabled":""}}"><span class="glyphicon glyphicon-thumbs-down"></span> Reject</a>
                    <a href="#message" class="btn btn-default"><span class="glyphicon glyphicon-envelope"></span> Send Message</a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif

    @if($appt->isBidder)
    <div class="color-box extra-bottom">
        <h2>My Bid</h2>
        <br />
        <div class="row">
            <div class="col-sm-2 col-xs-4 text-muted">
                Bid Date
            </div>
            <div class="col-sm-4 col-xs-8">
                {{$appt->myBids()->created_at}}
            </div>
            <div class="col-sm-2 col-xs-4 text-muted">
                Bid Status
            </div>
            <div class="col-sm-4 col-xs-8">
                {{$appt->myBids()->status}}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2 col-xs-4 text-muted">
                Message
            </div>
            <div class="col-sm-4 col-xs-8">
                {{$appt->myBids()->message}}
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-sm-6">
            <div class="color-box extra-bottom">
                <h2>General</h2>
                <br />
                <div class="row">
                    <div class="col-xs-4 text-muted">Appointment Date:</div>
                    <div class="col-xs-8">{{date('m/d/Y H:i',strtotime($appt->appt_datetime))}}</div>
                </div>
                <div class="row">
                    <div class="col-xs-4 text-muted">Status:</div>
                    <div class="col-xs-8">{{$appt->status}}</div>
                </div>
                <div class="row">
                    <div class="col-xs-4 text-muted">Bidding Stops:</div>
                    <div class="col-xs-8">{{date('m/d/Y H:i',strtotime($appt->bid_datetime))}}</div>
                </div>
                <div class="row">
                    <div class="col-xs-4 text-muted">Interest:</div>
                    <div class="col-xs-8">{{$appt->bids->count()}} Bids</div>
                </div>
            </div>
            <div class="color-box extra-bottom">
                <h2>Address</h2>
                <br />
                <div class="row">
                    <div class="col-xs-4 text-muted">Address:</div>
                    <div class="col-xs-8">{{($appt->isApproved()?$appt->address:'<em>Details available only after winning bid</em>')}}</div>
                </div>
                <div class="row">
                    <div class="col-xs-4 text-muted">Zip:</div>
                    <div class="col-xs-8">{{$appt->zip}}</div>
                </div>
                <div class="row">
                    <div class="col-xs-4 text-muted">City:</div>
                    <div class="col-xs-8">{{isset($appt->city)? $appt->city->name:"N/A"}}</div>
                </div>
                <div class="row">
                    <div class="col-xs-4 text-muted">State:</div>
                    <div class="col-xs-8">{{isset($appt->city)? $appt->city->state->name:"N/A"}}</div>
                </div>
                <div class="row">
                    <div class="col-xs-4 text-muted">General Details</div>
                    <div class="col-xs-8">{{($appt->isApproved()?$appt->gen_address_info:'<em>Details available only after winning bid</em>')}}</div>
                </div>
                <div class="row">
                    <div class="col-xs-4 text-muted">Special Notes</div>
                    <div class="col-xs-8">{{($appt->isApproved()?$appt->special_address_info:'<em>Details available only after winning bid</em>')}}</div>
                </div>
                <div class="row">
                    <div class="col-xs-4 text-muted">Conference</div>
                    <div class="col-xs-8">{{$appt->conference}}</div>
                </div>
                <div class="row">
                    <div class="col-xs-4 text-muted">Dial Instructions</div>
                    <div class="col-xs-8">{{($appt->isApproved()?$appt->dial_instructions:'<em>Details available only after winning bid</em>')}}</div>
                </div>
            </div>
        </div>
    <div class="col-sm-6">
        <div class="color-box extra-bottom">
            <h2>Opportunity Details</h2>
            <br />
            <div class="row">
                <div class="col-xs-4 text-muted">Manager Name</div>
                <div class="col-xs-8">{{($appt->isApproved()?$appt->manager_name:'<em>Details available only after winning bid</em>')}}</div>
            </div>
            <div class="row">
                <div class="col-xs-4 text-muted">Manager Title</div>
                <div class="col-xs-8">{{$appt->manager_title}}</div>
            </div>
            <div class="row">
                <div class="col-xs-4 text-muted">Industry</div>
                <div class="col-xs-8">{{$appt->industry}}</div>
            </div>
            <div class="row">
                <div class="col-xs-4 text-muted">Company Size</div>
                <div class="col-xs-8">{{Config::get('apptshares.company_size.'.$appt->company_size)}}</div>
            </div>
            <div class="row">
                <div class="col-xs-4 text-muted">Project Size</div>
                <div class="col-xs-8">{{$appt->project_size}}</div>
            </div>
            <div class="row">
                <div class="col-xs-4 text-muted">Meeting Description</div>
                <div class="col-xs-8">{{($appt->isApproved()?$appt->meeting_description:'<em>Details available only after winning bid</em>')}}</div>
            </div>
        </div>
        <div class="color-box extra-bottom">
            <h2>Opportunity Terms</h2>
            <br />
            @if($appt->sell_for == 'points')
            <div class="row">
                <div class="col-xs-4 text-muted">Sell for</div>
                <div class="col-xs-8">{{$appt->sell_for}}</div>
            </div>
            <div class="row">
                <div class="col-xs-4 text-muted">Circle</div>
                <div class="col-xs-8">{{$appt->circle->name}}</div>
            </div>
            @elseif($appt->pay_option == "one_price")
            <div class="row">
                <div class="col-xs-4 text-muted">Sell for</div>
                <div class="col-xs-8">{{$appt->sell_for}}</div>
            </div>
            <div class="row">
                <div class="col-xs-4 text-muted">Fixed Cost</div>
                <div class="col-xs-8">{{$appt->price}}</div>
            </div>
            @else
            <div class="row">
                <div class="col-xs-4 text-muted">Sell for</div>
                <div class="col-xs-8">{{$appt->sell_for}}</div>
            </div>
            <div class="row">
                <div class="col-xs-4 text-muted">Checkpoints</div>
                <div class="col-xs-8">{{$appt->checkpoints->count()}}</div>
            </div>
            @endif
        </div>
    </div>
</div>
@if($appt->checkpoints->count()>0)
<h2>Check Points</h2>
<div class="panel-group" id="checkpoints">
    @foreach($appt->checkpoints as $key => $checkpoint)
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#checkpoints" href="#checkpoint-{{$checkpoint->id}}">
                    {{($key+1).': '.$checkpoint->title}}
                </a>
                <span class="pull-right">$ {{$checkpoint->amount}}</span>
            </h4>
        </div>
        <div id="checkpoint-{{$checkpoint->id}}" class="panel-collapse collapse">
            <div class="panel-body">
                {{$checkpoint->description}}
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
</div>
@stop
@section('scripts')
<script>
    $(document).ready(function(){
        $(".bid").click(function()
        {
            console.log('bid modal show');
            id = $(this).data('id');
            $('#bid-modal').find('[name="appt-id"]').val(id);
            $('#bid-modal').find('.modal-title').html('<strong>Bidding on:</strong> '+$(this).data('title'));
            $('#bid-modal').find('#owner .value').text($(this).data('owner'));
            $('#bid-modal').find('#pay-with .value').text($(this).data('currency'));
            if($(this).data('currency') == 'points')
                $('#bid-modal').find('#amount .value').text('N/A');
            else
                $('#bid-modal').find('#amount .value').text($(this).data('amount'));
            $('#bid-modal').find('.confirm-bid').removeClass('disabled');
            $('#bid-modal').modal();
            return false;
        });
        $('.confirm-bid').click(function()
        {
            var id = $(this).parents('form').find('[name="appt-id"]').val();;
            var message = $(this).parents('form').find('#message').val();

            var request = $.post( "{{url("apptshares")}}/"+id+"/bid",{apptshare_id: id, bidder_id: {{Sentry::getUser()->id}}, message: message} );
    request.done(function(data)
    {
        console.log(data.id);
        location.reload();
        row = $('a[data-id="'+data.id+'"]').parents('tr');
        row.addClass('bidded-on');
        console.log(row);
        row.find('a.details').text('View Bid').attr('href',"{{url("apptshares")}}/"+id).siblings().remove();
        $('#bid-modal').modal('hide');
    });

    request.fail(function(data)
    {
        error = '<div class"alert alert-error">There was an error</div>';
        $('#bid-modal').find('.modal-content').prepend(error);
    });

    });
    });
</script>
@stop