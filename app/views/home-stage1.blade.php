@extends('layouts.bootstrap')
@section('content')
<div class="jumbotron box-resume" style="padding:0;border:none;background-color:transparent;text-align:center;">
    <h1 style="margin-bottom:20px">Kickstart Your Profile</h1>
    <p style="margin-bottom:30px">
        For your first 10 days you have can get 10 points per circle for each 20 leads you upload.
        <br/>
        Leads can be a mix of contacts, opportunities, and appshares.
    </p>
    <p>
        <a class="btn btn-default" href="/listings/create?listing_type=contact"><span class="glyphicon glyphicon-user"></span> Upload a Contact</a>
        <a class="btn btn-default" href="/listings/create?listing_type=apptshare"><span class="glyphicon glyphicon-map-marker"></span> Upload an ApptShare</a>
        <a class="btn btn-default" href=""><span class="glyphicon glyphicon-flash"></span> Upload an Opportunity</a></p>
</div>
<hr/>
<div class="row">
    <div class="col-sm-9">
        <h2>Welcome to Leadcliq</h2>
        <p>Leadcliq is the active market place for buying and selling leads.</p>
    </div>
    <div class="col-sm-3">
        <div class="box-resume box-resume-invite">
            <div class="box-resume-header">
                <h2>EARN A POINT TODAY!</h2>
            </div>
            <div class="box-resume-body">
                <form role="form" action="{{URL::route('invite-friends')}}" method="POST">
                    <div class="form-group">
                        <input type="text" class="form-control" id="" placeholder="Enter name" required>
                    </div>
                    <div class="form-group">
                        <input name="to" type="email" class="form-control" id="" placeholder="Enter email" required>
                    </div>
                    <button type="submit" class="btn btn-default btn-block"><strong>INVITE NOW!</strong></button>
                </form>
            </div>
        </div>
    </div>
</div>


@stop