<header class="header"  ng-controller='HeaderController'>
    <nav class="navbar navbar-default" role="navigation" style="margin-bottom:0;font-size:16px;">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{URL::route('home')}}" style="padding:8px 0 0 0;">
                    <img src="/assets/images/logo.png" alt="LeadCliq" style="max-height:100%;"/>
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                @if(Sentry::check())
                <ul class="nav navbar-nav navbar-right">
                    <li class="disabled"><a href="#"><span class="glyphicon glyphicon-cloud-download"></span> Buy Leads</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cloud-upload"></span> Sell Leads<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            {{-- TODO: replace these with more laravelish syntax --}}
                            <li><a href="/listings/create?listing_type=apptshare"><span class="glyphicon glyphicon-map-marker"></span> ApptShare</a></li>
                            <li><a href="/listings/create?listing_type=contact"><span class="glyphicon glyphicon-user"></span> Contact</a></li>
                            <li class="disabled"><a href="#"><span class="glyphicon glyphicon-flash"></span> Opportunity</a></li>
                        </ul>
                    </li>

                    <!--Points Dropdown-->
                    <li class="dropdown" id="pointsDropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            {{Sentry::getUser()->totalPointsAllCircles()}} <span class="">points</span> <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu" style="padding:10px;color:white;width:300px;max-height:300px;overflow-y:auto;">
                            <h4 style="margin:0 0 10px;">Points Per Circle</h4>
                            @foreach(Sentry::getUser()->points as $points)
                            @if ($points->circle)
                            <p style="border-top:1px solid #555;padding-top:10px;">{{$points->circle->name}}: {{$points->sum}}</p>
                            @endif
                            @endforeach
                        </div>
                    </li>

                    <!--Profile Dropdown-->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding:5px">
                            <img alt="" src="{{Sentry::getUser()->photo}}" class="media-object" style="height:35px;width:auto;">
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="/circles">Circles</a></li>
                            <li><a href="{{ URL::route('my-contacts') }}">Published Leads</a></li>
                            <li class="disabled"><a href="#">Purchased Leads</a></li>
                            <li><a href="{{ URL::route('profile')}}">My Profile</a></li>
                            <li class="disabled"><a href="#">Billing and Transactions</a></li>
                            <li><a href="{{URL::route('logout')}}">Log Out</a></li>
                        </ul>
                    </li>

                    <!--Notification (Messages) Dropdown-->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"  ng-click="hideEnvelope()">
                            <span class="glyphicon glyphicon-envelope"></span>
                            @if(Sentry::getUser()->inbox()->count())
                             <span class="label label-info" style="position: relative;top: -3px;border-radius: 3px;padding: 2px 9px;" ng-show="isEnvelope">{{Sentry::getUser()->inbox()->count()}}</span>
                            @endif
                        </a>
                        <div class="dropdown-menu" style="width:300px;max-height:400px;padding:10px;color:white;">
                            <h2 style="margin-top:0;">Notifications</h2>
                            @if(Sentry::getUser()->allMessages()->count())
                            @foreach (Sentry::getUser()->allMessages as $message)
                            <hr/>
                            <h4> {{$message->subject}} </h4>
                            <p>{{$message->message}}</p>
                            @endforeach
                            @endif
                            @if(!Sentry::getUser()->inbox()->count())
                            <p>No notifications</p>
                            @endif
                        </div>
                    </li>

                    @endif
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    
    <!-- Include Alert -->
    @include('layouts.bootstrap.header_alert')
    
</header>         
