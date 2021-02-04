
<div id="newReviewSection" class="modalBlackBack fullCenter writeNewReviewModal" style="z-index: 9999;">
    <div class="modalBody">
        <div class="inputReviewBodies">
            <div class="bodySec">
                <h2 class="yourReviewHeader EmptyCommentIcon">
                    پست جدید
                    <span class="iconClose" onclick="closeMyModal('newReviewSection')"></span>
                </h2>
                <div class="inputReviewSec">
                    <div class="firsRow">
                        <div class="fullyCenterContent uPic50">
                            <img src="{{isset($authUserInfos->pic) ? $authUserInfos->pic : ''}}" class="resizeImgClass" onload="fitThisImg(this)" style="width: 100%" >
                        </div>
                        <textarea id="inputNewReviewText" class="autoResizeTextArea Inp" placeholder="{{$authUserInfos->username ?? 'کاربر'}} چه فکر یا احساسی داری..."></textarea>
                    </div>
                    <div class="uploadedFiles"></div>
                    <div id="friendAddedSection" class="searchYouFriendDiv" onclick="$('#friendSearchInput').focus()">
                        <input id="friendSearchInput"
                               type="text"
                               class="addFriendInputNewReview"
                               placeholder="با چه کسانی بودید؟ نام کاربری را وارد نمایید"
                               onkeyup="searchUserFriend(this)">
                        <div class="searchResultUserFriend"></div>
                    </div>
                </div>
            </div>
            <div class="bodySec">
                <div class="reviewButs">
                    <label for="reviewPictureInput" class="but addPhotoIcon"> عکس اضافه کنید.</label>
                    <label for="reviewVideoInput" class="but addVideoIcon">ویدیو اضافه کنید.</label>
                    <label for="review360VideoInput" class="but addVideo360Icon">ویدیو 360 اضافه کنید.</label>
                    <div class="but addFriendIcon" onclick="$('#friendSearchInput').focus();">دوستنتان را TAG کنید.</div>

                    <input type="file" id="reviewPictureInput" accept="image/png,image/jpeg,image/jpg,image/webp" style="display: none;" onchange="uploadFileForNewReview(this, 'image')">
                    <input type="file" id="reviewVideoInput" accept="video/*" style="display: none;" onchange="uploadFileForNewReview(this, 'video')">
                    <input type="file" id="review360VideoInput" accept="video/*" style="display: none;" onchange="uploadFileForNewReview(this, '360Video')">
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
    var reviewUploadFileUrl = '{{route("review.uploadFile")}}';
    var uploadNewReviewPicUrl = '{{route("reviewUploadPic")}}';
    var deleteNewReviewPicUrl = '{{route("deleteReviewPic")}}';
    var storeNewReviewUrl = '{{route("storeReview")}}';
    var getNewCodeForUploadNewReviewURl = '{{route("review.getNewCodeForUploadNewReview")}}';
    var newReviewDataForUpload = {
        code: false,
        userAssigned: [],
        files: [],
    };

</script>

<script defer src='{{URL::asset('js/component/writeReview.js?v='.$fileVersions)}}'></script>
<script src="{{URL::asset('js/uploadLargFile.js?v='.$fileVersions)}}"></script>
