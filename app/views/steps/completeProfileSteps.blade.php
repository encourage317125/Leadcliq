<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LeadCliq | Complete profile</title>
    <meta name="description" content="">
    @include('layouts.bootstrap.head')
    <link rel="stylesheet" href="/assets/css/complete-steps.css">
    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.2/leaflet.css" />
    <link rel="stylesheet" href="{{asset("css/geo-search.css")}}" />
    <link rel="stylesheet" href="{{asset("css/leaflet-draw.css")}}" />
    <link rel="stylesheet" href="{{asset("css/mapObjects.css")}}" />
</head>
<body>
<div class="content-wrap clear-fix">
    <div class="container">
        <div class="row top-bar">
            <div class="col-md-10 col-md-offset-1">
                <img src="assets/images/logo.png" class="pull-left logo">
                <h2 class="pull-right">Complete Profile</h2>
            </div>
        </div>
    </div>
    <br>

    <div>
        <div id="step1" class="">@include('steps.step1')</div>
        <div id="step2" class="display-none">@include('steps.step2')</div>
        <div id="step3" class="display-none">@include('steps.step3')</div>
        <div id="step4" class="display-none">@include('steps.step4')</div>
        <div id="step5" class="display-none">@include('steps.step5')</div>
    </div>
</div>
@include('layouts.bootstrap.footer')
@include('layouts.bootstrap.scripts')


{{ HTML::script('js/profile-complete.js') }}

<script src="{{asset("js/leaflet.js")}}"></script>
<script src="{{asset("js/geo-search.js")}}"></script>
<script src="{{asset("js/geosearch-prov.js")}}"></script>
<script src="{{asset("js/leaflet-draw/leaflet-draw.js")}}"></script>
<script src="{{asset("js/terraformer.js")}}"></script>
<script src="{{asset("js/terraformer-wkt.js")}}"></script>
<script src="{{asset("js/mapRegister.js")}}"></script>
<script src="{{asset("js/user_areas.js")}}"></script>

</body>
</html>