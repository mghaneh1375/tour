<style>
    .reviewOptionMenuBar{
        display: none !important;
        flex-direction: column;
    }
    .reviewOptionMenuBar .modalBody div, .reviewOptionMenuBar .modalBody a {
        color: gray;
        border-bottom: solid 1px #cccccc;
        display: flex;
        justify-content: center;
        margin-bottom: 10px;
        padding-bottom: 10px;
    }
    .smallReviewMainPic.playIcon:before{
        position: absolute;
        width: 100%;
        height: 100%;
        background: #00000026;
        z-index: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        font-size: 70px;
    }
    @media (max-width: 767px){
        .reviewOptionMenuBar{
            display: unset;
        }
    }
    @media (max-width: 700px) {

        .fullReviewModal{
            align-items: center !important;
        }
        .fullReviewBody{
            width: 100%;
            max-height: 100%;
        }
    }



</style>

<div id="fullReviewModal" class="fullReviewModal modalBlackBack">
    <div id="fullReview" class="fullReviewBody"></div>
</div>

<div id="reviewOptionMenuBar" class="modalBlackBack fullCenter reviewOptionMenuBar">
    <div class="modalBody">
        <div class="reportReviwInOptionModal">گزارش پست </div>
        <a class="profileNameInReviewOptionModal" href="#"></a>
        <a href="{{route("policies")}}" target="_blank"> صفحه قوانین و مقررات </a>
        @if(auth()->check())
            <div id="deleteReviewOptionInModal" style="color: red; border-bottom: none"> حذف پست </div>
        @endif
    </div>
</div>

<script>
    var reviewSmallSample = `
        <div id="smallReviewHtml_##id##" class="smallReviewMainDivShown float-right position-relative">
            <div class="commentWriterDetailsShow">
                <a href="##userPageUrl##" class="circleBase type2 commentWriterPicShow">
                    <img src="##userPic##" alt="##userName##" class="resizeImgClass" onload="fitThisImg(this)">
                </a>
                <div class="commentWriterExperienceDetails" style="width: 100%">
                    <div style="display: flex; align-items: center">
                        <a href="##userPageUrl##" target="_blank" class="userProfileName" style="font-weight: bold">##userName##</a>
                        <span class="label label-success inConfirmLabel" style="display: ##isConfrim##">{{__('در انتظار تایید')}}</span>
                    </div>
                    <div style="font-size: 10px; display: ##showWhere##">
                        در
                        <a href="##placeUrl##" target="_blank">
                            <span class="commentWriterExperiencePlace">##where##</span>
                        </a>
                    </div>
                    <div class="userAssignedSmall" style="font-size: 11px">##userAssigned##</div>
                    <div style="font-size: 12px;">##timeAgo##</div>
                </div>
            </div>
            <div class="commentContentsShow position-relative">
                <div class="SummarizedPostTextShown" style="display: ##haveSummery##">
                    ##summery##
                    <span class="smallReviewshowMoreText" onclick="showSmallReviewMoreText(this)"></span>
                </div>
                <div class="completePostTextShown" style="display: none">
                    ##text##
                    <span class="showLessText" onclick="showSmallReviewLessText(this)">{{__('کمتر')}}</span>
                </div>
                <div class="completePostTextShown" style="display: ##notSummery##">##text##</div>
            </div>
            <div class="smallReviewcommentPhotosShow">
                <div class="photosCol col-xs-12" onclick="showSmallReviewPics(##id##)" style="display: ##havePic##; margin-bottom: 10px">
                    <div class="smallReviewMainPic ##isVideoClass##">
                        <img src="##mainPic##" class="resizeImgClass" style="position: absolute; width: 100%;" onload="fitThisImg(this)">
                    </div>
                    <div class="numberOfPhotosMainDiv" style="display: ##hasMorePic##">
                        <div class="numberOfPhotos">##picCount##+</div>
                        <div>{{__('عکس')}}</div>
                    </div>
                </div>
                <div class="quantityOfLikesSmallReview">
                    <div class="smallReviewShowMore" onclick="getSingleFullReview(##id##)">مشاهده</div>
                    <div class="reviewLikeNumber_##id## reviewLikeIcon_##id## LikeIconEmpty likedislikeAnsReviews ##likeClass##" onclick="likeReviewInFullReview(##id##, 1, this)">##like##</div>
                    <div class="reviewDisLikeNumber_##id## reviewDisLikeIcon_##id## DisLikeIconEmpty likedislikeAnsReviews ##disLikeClass##" onclick="likeReviewInFullReview(##id##, -1, this)">##disLike##</div>
                    <div style="font-size: 20px;" onclick="getSingleFullReview(##id##)">
                        <span>##answersCount##</span>
                        <span class="EmptyCommentIcon" style="font-size: 24px"></span>
                    </div>
                </div>
            </div>
            <div class="sampleOfAnsToReview" style="display: ##writeCommentSample##">
                <div class="picSec">
                    <img src="##userPic##" alt="##userName##" class="resizeImgClass" onload="fitThisImg(this)">
                </div>
                <div class="textSec" onclick="focusOnWriteComment(##id##)">
                    <div class="tex">شما چه نظری دارید؟</div>
                    <div class="sendBut">ارسال</div>
                </div>
            </div>
        </div>`;

    var smallReviewPlaceHolder = `<div class="smallReviewMainDivShown smallReviewPlaceHolder float-right position-relative">
                                    <div class="commentWriterDetailsShow" style="display: flex;">
                                        <div class="placeHolderAnime" style="width: 55px; height: 55px; float: right; border-radius: 50%"></div>
                                        <div class="commentWriterExperienceDetails" style="display: flex; flex-direction: column; padding-right: 10px">
                                            <div class="userProfileName placeHolderAnime resultLineAnim" style="width: 100px"></div>
                                            <div class="userProfileName placeHolderAnime resultLineAnim" style="width: 100px"> </div>
                                            <div class="userProfileName placeHolderAnime resultLineAnim" style="width: 100px"></div>
                                        </div>
                                    </div>
                                    <div class="commentContentsShowPlaceHolder position-relative">
                                        <div class="userProfileName placeHolderAnime resultLineAnim reviewPlaceHolderTextLineSmallReview"></div>
                                        <div class="userProfileName placeHolderAnime resultLineAnim reviewPlaceHolderTextLineSmallReview"></div>
                                        <div class="userProfileName placeHolderAnime resultLineAnim reviewPlaceHolderTextLineSmallReview" style="width: 60%"></div>
                                        <div class="userProfileName placeHolderAnime resultLineAnim reviewPlaceHolderTextLineSmallReview"></div>
                                        <div class="userProfileName placeHolderAnime resultLineAnim reviewPlaceHolderTextLineSmallReview" style="width: 90%"></div>
                                        <div class="userProfileName placeHolderAnime resultLineAnim reviewPlaceHolderTextLineSmallReview" style="width: 20%"></div>
                                        <div class="userProfileName placeHolderAnime resultLineAnim reviewPlaceHolderTextLineSmallReview"></div>
                                    </div>
                                    <div class="commentPhotosShow" style="border-top: 1px solid #e5e5e5; padding-top: 8px; margin-top: 5px;">
                                        <div class=" placeHolderAnime reviewPicPlaceHolder"></div>
                                    </div>
                                </div>`;

    var yourProfileUrlSmallShowReview = '{{url("profile/index")}}';
    var getSingleReviewUrl = '{{route("review.getSingleReview")}}';
    var policiRouteUrl = '{{route("policies")}}';
    var likeLogURL = '{{route('likeLog')}}';
    var ansReviewURL = '{{route('ansReview')}}';
    var deleteReviewURL = '{{route('upload.review.delete')}}';
    var deleteReviewPicInAlbumUrl = '{{route('upload.deleteReviewPic')}}';
    var reviewBookMarkURL = '{{route('review.bookMark')}}';

    var gearIconUrl = '{{URL::asset("images/icons/mGear.svg")}}';

    var isUserLoginCheckInSmall = '{{auth()->check()}}';
</script>

<script async src="{{URL::asset('js/component/showSmallReview.js?v'.$fileVersions)}}"></script>
