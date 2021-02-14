<div class="col-md-7 col-xs-12 pd-0 float-right postsMainDivInRegularMode">

    <div id="showReviewsMain"></div>

    <div id="reviewsPagination" class="col-xs-12 postsMainDivFooter position-relative" style="margin-top: 10px;">
        <div class="col-xs-4 font-size-13 line-height-2 text-align-right" style="display: flex; direction: rtl; margin-left: auto">
            صفحه
            <div id="reviewPagination" style="margin-right: 10px;"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteReviewsModal" role="dialog" style="direction: rtl">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{__('پاک کردن نقد')}}</h4>
            </div>
            <div class="modal-body">
                <p>آیا از حذف نقد خود اطمینان دارید؟ در صورت حذف عکس ها و فیلم ها افزوده شده پاک می شوند و قابل بازیابی نمی باشد.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{__('لغو')}}</button>
                <button type="button" class="btn btn-danger" onclick="doDeleteReviewByUser()">{{__('بله، حذف شود')}}</button>
            </div>
        </div>
    </div>
</div>

<script>
    var getReviewForPlaceDetailsUrl = "{{route('getReviews')}}";
</script>

<script src="{{URL::asset('js/pages/placeDetails/showReviewPlaceDetails.js')}}"></script>
