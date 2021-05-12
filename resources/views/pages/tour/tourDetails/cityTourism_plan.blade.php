<link rel="stylesheet" href="{{URL::asset('packages/leaflet/leaflet.css')}}">
<link rel="stylesheet" href="{{URL::asset('css/pages/tours/tourShowPlan.css')}}">

<div class="row planSection">
    <div class="col-md-6 maxHeight90Vh">
        <div id="planMapDiv" class="mapSection"></div>
    </div>
    <div class="col-md-6 maxHeight90Vh" style="overflow: auto; padding-right: 0;">
        <div id="eventBoxSection" class="placeBoxesSection"></div>
    </div>
</div>
<script defer type="text/javascript" src="{{URL::asset('packages/leaflet/motion/leaflet.motion.js')}}"></script>

<script src="{{URL::asset('js/pages/tour/tourShow_plan.js?v='.$fileVersions)}}"></script>
