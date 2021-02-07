<style>
    [contentEditable=true]:empty:not(:focus):before{
        content:attr(data-ph);
        color:grey;
        font-style:italic;
    }

    [contentEditable=true] .linkInTextArea{
        pointer-events: none;
    }

    .linkInTextArea{
        display: inline-block;
        direction: rtl;
    }

</style>
<div id="newReviewSection" class="modalBlackBack fullCenter writeNewReviewModal" style="z-index: 9999;">
    <div class="modalBody">
        <div class="inputReviewBodies">
            <div class="bodySec">
                <span class="closeModal iconClose fullyCenterContent" onclick="closeMyModal('newReviewSection')"></span>
                <h2 class="yourReviewHeader EmptyCommentIcon"> پست جدید </h2>
                <div class="inputReviewSec">
                    <div class="firsRow">
                        <div class="fullyCenterContent uPic50">
                            <img src="{{isset($authUserInfos->pic) ? $authUserInfos->pic : ''}}" class="resizeImgClass" onload="fitThisImg(this)" style="width: 100%" >
                        </div>
                        <div id="inputNewReviewText" class="inputNewReviewDiv" data-ph="{{$authUserInfos->username ?? 'کاربر'}} چه فکر یا احساسی داری..." contenteditable="true"></div>
{{--                        <textarea id="inputNewReviewText" class="autoResizeTextArea Inp" placeholder="{{$authUserInfos->username ?? 'کاربر'}} چه فکر یا احساسی داری..."></textarea>--}}
                    </div>
                    <div class="uploadedFiles"></div>
                    <div class="searchYouFriendReviewSectionDiv">
                        <div class="friendAddedSection results"></div>
                        <div class="placeHolderText" onclick="openUserSearchForNewReview()">با چه کسانی بودید؟ نام کاربری را وارد نمایید</div>
                    </div>
                </div>
            </div>
            <div class="bodySec">
                <div class="reviewButs">
                    <label for="reviewPictureInput" class="but addPhotoIcon"> عکس اضافه کنید.</label>
                    <label for="reviewVideoInput" class="but addVideoIcon">ویدیو اضافه کنید.</label>
                    <div id="addPlaceButtonNewReview" class="but atractionIcon" onclick="addPlaceToNewReview()">محل پست را مشخص کنید</div>
{{--                    <label for="review360VideoInput" class="but addVideo360Icon">ویدیو 360 اضافه کنید.</label>--}}
                    <div class="but addFriendIcon" onclick="openUserSearchForNewReview()">دوستنتان را TAG کنید.</div>

                    <input type="file" id="reviewPictureInput" accept="image/png,image/jpeg,image/jpg,image/webp" style="display: none;" onchange="uploadFileForNewReview(this, 'image')">
                    <input type="file" id="reviewVideoInput" accept="video/*" style="display: none;" onchange="uploadFileForNewReview(this, 'video')">
                    <input type="file" id="review360VideoInput" accept="video/*" style="display: none;" onchange="uploadFileForNewReview(this, '360Video')">

                    <input type="hidden" id="kindPlaceIdNewReview" value="0">
                    <input type="hidden" id="placeIdNewReview" value="0">
                </div>
                <div class="reviewQues showWhenNeed" style="display: none;"></div>
                <div class="reviewSubmit showWhenNeed" onclick="storeNewReview(this)">ارسال دیدگاه</div>
                <div class="reviewSubmit showWhenNeed hidden" style="cursor: not-allowed">
                    <img src="{{URL::asset('images/icons/mGear.svg')}}" style="width: 30px; height: 30px;">
                    درحال ارسال دیدگاه
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    var searchPlaceForNewReviewUrl = '{{route("search.place")}}';
    var reviewUploadFileUrl = '{{route("review.uploadFile")}}';
    var uploadNewReviewPicUrl = '{{route("reviewUploadPic")}}';
    var deleteNewReviewPicUrl = '{{route("deleteReviewPic")}}';
    var storeNewReviewUrl = '{{route("storeReview")}}';
    var userProfileUrl_newReview = '{{url("profile/index")}}';
    var getNewCodeForUploadNewReviewURl = '{{route("review.getNewCodeForUploadNewReview")}}';
    var newReviewDataForUpload = {
        code: false,
        files: [],
    };

</script>

<script defer src='{{URL::asset('js/component/writeReview.js?v='.$fileVersions)}}'></script>
<script src="{{URL::asset('js/uploadLargFile.js?v='.$fileVersions)}}"></script>
