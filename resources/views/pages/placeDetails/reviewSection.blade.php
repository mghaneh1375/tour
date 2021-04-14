<div class="col-md-12 pd-0 float-right postsMainDivInRegularMode">
    <div id="showReviewsMain" class="row">
        <div id="showReviewMain_1" class="col-md-6" style="padding: 0px"></div>
        <div id="showReviewMain_2" class="col-md-6" style="padding: 0px"></div>
    </div>
</div>

<script>
    var getReviewForPlaceDetailsUrl = "{{route('getReviews')}}";
</script>

<script defer src="{{URL::asset('js/pages/placeDetails/showReviewPlaceDetails.js?v='.$fileVersions)}}"></script>
