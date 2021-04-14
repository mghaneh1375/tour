@extends('layouts.bodyPlace')

<?php
$total = $rates['5'] + $rates['1'] + $rates['2'] + $rates['3'] + $rates['4'];
$total = $total == 0 ? 1 : $total;

$seoTitle = isset($place->seoTitle) ? $place->seoTitle : "کوچیتا | " . $city->name . " | " . $place->name;
?>
@section('head')
    <meta property="article:author " content="کوچیتا"/>

    <meta content="article" property="og:type"/>
    <meta property="og:title" content="{{$seoTitle}}"/>
    <meta property="title" content="{{$seoTitle}}"/>
    <meta name="twitter:title" content="{{$seoTitle}}"/>
    <meta name="twitter:card" content="{{$place->meta}}"/>
    <meta name="description" content="{{$place->meta}}"/>
    <meta name="twitter:description" content="{{$place->meta}}"/>
    <meta property="og:description" content="{{$place->meta}}"/>
    <meta property="article:section" content="{{$placeMode}}"/>
    <meta name="keywords" content="{{$place->keyword}}">
    <meta property="og:url" content="{{Request::url()}}"/>

    @if(isset($place->mainPic))
        <meta property="og:image" content="{{$place->mainPic}}"/>
        <meta property="og:image:secure_url" content="{{$place->mainPic}}"/>
        <meta name="twitter:image" content="{{$place->mainPic}}"/>
        <meta property="og:image:width" content="550"/>
        <meta property="og:image:height" content="367"/>
    @endif

    @if(isset($place->C) && isset($place->D))
        <meta NAME="geo.position" CONTENT="{{$place->C}}; {{$place->D}}">
    @endif
    @foreach($place->tags as $item)
        <meta property="article:tag" content="{{$item}}"/>
    @endforeach

    <title>{{isset($place->seoTitle) ? $place->seoTitle : $place->name}} </title>

    <link rel="stylesheet" href="{{URL::asset('css/shazdeDesigns/hotelDetail.css?v='.$fileVersions)}}">
    <link rel="stylesheet" href="{{URL::asset('js/emoji/area/emojionearea.css?v='.$fileVersions)}}">

    <script>

        var hotelDetails;
        var hotelDetailsInAskQuestionMode;
        var hotelDetailsInAnsMode;
        var hotelDetailsInSaveToTripMode;

        var thisUrl = '{{Request::url()}}';
        var userCode = '{{$userCode}}';
        var userPic = '{{$userPic}}';
        var placeId = '{{$place->id}}';
        var placeMode = '{{$placeMode}}';
        var placeMode = '{{$placeMode}}';
        var kindPlaceId = '{{$kindPlaceId}}';
        var yourRateForThisPlace = '{{$yourRate}}';

        var likeLog = '{{route('likeLog')}}';
        var sendAnsDir = '{{route('sendAns')}}';
        var getPhotosDir = '{{route('getPhotos')}}';
        var opOnComment = '{{route('opOnComment')}}';
        var showAllAnsDir = '{{route('showAllAns')}}';
        var getQuestions = '{{route('getQuestions')}}';
        var askQuestionDir = '{{route('askQuestion')}}';
        var getPlacePicsUrl = '{{route("place.getPics")}}';
        var filterComments = '{{route('filterComments')}}';
        var getPhotoFilter = '{{route('getPhotoFilter')}}';
        var getCommentsCount = '{{route('getCommentsCount')}}';
        var showUserBriefDetail = '{{route('showUserBriefDetail')}}';

        var reviewUploadFileURLInPlaceDetails = '{{route("upload.review.uploadFile")}}';
        var reviewUploadPic = '{{route('upload.reviewUploadPic')}}';
        var doEditReviewPic = '{{route('upload.doEditReviewPic')}}';
        var deleteReviewPicUrl = '{{route('upload.deleteReviewPic')}}';

    </script>

    <script defer src="{{URL::asset('js/emoji/area/emojionearea.js')}}"></script>
    <script defer src="{{URL::asset('js/hotelDetails/hoteldetails_2.js')}}"></script>

@stop


@section('main')
    @include('general.schema')

    <div class="hideOnPhone">
        @include('pages.secondHeader')
    </div>

    @if($place->needMap)
        @include('component.mapMenu')
    @endif

    <div id="comeDownHeader" class="topHeaderShowDown hideOnScreen">
        <div class="inOneRow">
            <div class="name">{{$place->name}}</div>
            <div class="buttonsH">
                <div class="circlePlaceDetailButtons" onclick="addPlaceToBookMark()">
                    <div class="icon saveAsBookmarkIcon  {{$bookMark ? "BookMarkIcon" : "BookMarkIconEmpty"}}"></div>
                </div>
                <div class="circlePlaceDetailButtons" onclick="$(this).find('.sharesButtons').toggleClass('open')">
                    <div class="icon" style="z-index: 10;">
                        <img src="{{URL::asset('images/icons/shareIcon.svg')}}" style="margin-right: 3px;width: 18px;">
                    </div>
                    <div class="sharesButtons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{Request::url()}}" target="_blank" class="share">
                            <img src="{{URL::asset("images/shareBoxImg/facebook.png")}}">
                        </a>
                        <a href="https://twitter.com/home?status={{Request::url()}}" target="_blank" class="share">
                            <img src="{{URL::asset("images/shareBoxImg/twitter.png")}}">
                        </a>
                        <a href="#" class="share whatsappLink whatsappLinkMobilePlaceDetails">
                            <img src="{{URL::asset("images/shareBoxImg/whatsapp.png")}}">
                        </a>
                        <a href="https://telegram.me/share/url?url={{Request::url()}}" target="_blank" class="share">
                            <img src="{{URL::asset("images/shareBoxImg/telegram.png")}}">
                        </a>
                        <span class="share" style="color: black;" onclick="copyLinkAddress()"> کپی </span>
                    </div>
                </div>
                <div class="circlePlaceDetailButtons" onclick="addThisPlaceToTrip()" >
                    <div class="icon MyTripsIcon"></div>
                </div>
            </div>
        </div>

        <div class="tabs">
            @if($placeMode == 'mahaliFood')
                <div class="tabLinkMainWrap generalDescBtnTopBar" onclick="changeTabBarColor(this, 'generalDescLinkRel')">مواد لازم</div>
                <div class="tabLinkMainWrap recipeDescBtnTopBar" onclick="changeTabBarColor(this, 'recepieForFood')">دستور پخت</div>
            @elseif($placeMode == 'drinks')
                <div class="tabLinkMainWrap recipeDescBtnTopBar" onclick="changeTabBarColor(this, 'drinkRecipes')">طرز تهیه</div>
                <div class="tabLinkMainWrap generalDescBtnTopBar" onclick="changeTabBarColor(this, 'materialNeededSection')">مواد لازم</div>
            @else
                <div class="tabLinkMainWrap generalDescBtnTopBar" onclick="changeTabBarColor(this, 'generalDescLinkRel')">معرفی کلی</div>
                @if($placeMode != 'sogatSanaies')
                    <div class="tabLinkMainWrap mapBtnTopBar" onclick="changeTabBarColor(this, 'goToMapSection')">نقشه</div>
                @else
                    <div class="tabLinkMainWrap mapBtnTopBar" onclick="changeTabBarColor(this, 'goToMapSection')">ویژگی ها</div>
                @endif
            @endif
            <div class="tabLinkMainWrap postsBtnTopBar" onclick="changeTabBarColor(this, 'mainDivPlacePost')">نظرات</div>
                <div class="tabLinkMainWrap QAndAsBtnTopBar" onclick="changeTabBarColor(this,'QAndAMainDivId')">پرسش و پاسخ</div>
            @if($place->similarPlace)
                <div class="tabLinkMainWrap similarLocationsBtnTopBar" onclick="changeTabBarColor(this,'topPlacesSection')">مکان های مشابه</div>
            @endif
        </div>
    </div>

    <div class="setScoreForThisPlaceComeUp hidden hideOnScreen" onclick="openRateBoxForPlace()">به {{$place->name}} امتیاز دهید</div>

    <div id="userRateToPlaceModal" class="userRateToPlaceModal modalBlackBack fullCenter">
        <div class="modalBody">
            <div class="topIcon">
                <img src="{{URL::asset('images/icons/koochitaPlaceRate.svg?v=1')}}" style="width: 88px">
            </div>
            <div class="header">امتیاز شما به {{$place->name}} چیست؟</div>
            <div class="body">
                <div class="emptyStarRating ratingStar1" data-star="1" data-selected="0" onclick="ratingToPlace(1)"></div>
                <div class="emptyStarRating ratingStar2" data-star="2" data-selected="0" onclick="ratingToPlace(2)"></div>
                <div class="emptyStarRating ratingStar3" data-star="3" data-selected="0" onclick="ratingToPlace(3)"></div>
                <div class="emptyStarRating ratingStar4" data-star="4" data-selected="0" onclick="ratingToPlace(4)"></div>
                <div class="emptyStarRating ratingStar5" data-star="5" data-selected="0" onclick="ratingToPlace(5)"></div>
            </div>
            <div class="footer">
                <button onclick="submitRating()">ثبت امتیاز</button>
            </div>
        </div>
    </div>

    <div class="ppr_rup ppr_priv_hr_atf_north_star_nostalgic position-relative">

        <div class="hideOnPhone" style="background: white; width: 100%; padding-top: 15px;">
            <div class="container">
                <a href="{{route('festival.cook')}}" class="topPageAd">
                    <img src="{{URL::asset('images/esitrevda/bannerlong.webp')}}" >
                </a>
            </div>
        </div>

        <div class="hideOnPhone">
            @include('layouts.placeMainBodyHeader')
        </div>

        <div class="atf_meta_and_photos_wrapper position-relative">
            <div class="greyBackground"></div>
            <div class="atf_meta_and_photos ui_container is-mobile easyClear position-relative">

                @if(auth()->check())
                    @include('pages.placeDetails.component.writeReviewSection')
                @else
                    <script>
                        function newPostModal(kind = '') {
                            checkLogin();
                        }
                    </script>
                @endif

                <div id="bestPrice" class="meta koochitaTvSection position-relative" style="@if(session('goDate') != null && session('backDate') != null) display: none @endif ">
                    <div id="targetHelp_9" class="targets float-left">
                        <div id="bestPriceInnerDiv" class="tvSection">
                            <a href="https://koochitatv.com" class="tvLogoDiv" target="_blank">
                                <img src="{{URL::asset('images/mainPics/vodLobo.webp')}}" style="max-height: 100%; max-width: 100%;">
                            </a>
                            <div class="tvContentDiv">
                                <div class="tvContentText"> کوچیتا تی وی برای تماشای آنلاین و زنده محتواهای بصری و صوتی در تمامی حوزه های گردشگری و سفر </div>
                                <div class="tvContentVideo">
                                    <a href="#" class="tvVideoPic fullHeight" target="_blank">
                                        <div class="tvImgHover">
                                            <img src="{{URL::asset('images/icons/play.webp')}}" style="width: 50px">
                                        </div>
                                        <div class="tvOverPic hidden tvSeenSection">
                                            <span class="koochitaTvSeen">0</span>
                                            <img src="{{URL::asset('images/icons/eye.png')}}" style="height: 15px; margin-right: 5px">
                                        </div>
                                        <div class="tvOverPic hidden tvLikeSection">
                                            <div class="tvLike">
                                                <span class="koochitaTvDisLikeCount">0</span>
                                                <i class="DisLikeIcon"></i>
                                            </div>
                                            <div class="tvLike" style="margin-right: 10px">
                                                <span class="koochitaTvLikeCount">0</span>
                                                <i class="LikeIcon"></i>
                                            </div>
                                        </div>
                                        <img src="{{URL::asset('images/mainPics/koochitatvdefault.webp')}}" class="koochitaTvImg resizeImgClass" style="width: 100%" onload="fitThisImg(this)">
                                    </a>
                                    <a href="#" class="tvVideoName showLessText" target="_blank"></a>
                                    <div class="tvUserContentDiv hidden">
                                        <div class="tvUserPic">
                                            <img  class="koochitaTvUserImg resizeImgClass" style="width: 100%" onload="fitThisImg(this)">
                                        </div>
                                        <div class="tvUserInfo">
                                            <div class="tvUserName"></div>
                                            <div class="tvUserTime"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="https://koochitatv.com" class="tvSeeMore" target="_blank">
                                <div class="tvSeeMoreIcons">
                                    <i class="leftArrowIcon"></i>
                                    <i class="leftArrowIcon"></i>
                                </div>
                                {{__('بیشتر ببینید')}}
                            </a>
                        </div>
                    </div>

                    <div class="clear-both"></div>
                    <div id="targetHelp_8" class="wideScreen targets float-left col-xs-6 pd-0">
                        <span onclick="addPlaceToBookMark()" class="ui_button save-location-7306673 saveAsBookmarkMainDiv">
                            <div id="bookMarkIcon" class="saveAsBookmarkIcon {{$bookMark ? "BookMarkIcon" : "BookMarkIconEmpty"}}"></div>
                            <div class="saveAsBookmarkLabel">ذخیره این صفحه</div>
                        </span>
                    </div>

                    <div id="share_pic" class="wideScreen targets float-left col-xs-6 pd-0">
                        <span class="ui_button save-location-7306673 sharePageMainDiv">
                            <div class="shareIconDiv sharePageIcon first"></div>
                            <div class="sharePageLabel">اشتراک‌گذاری صفحه</div>
                        </span>
                    </div>
                    @include('layouts.shareBox', ['urlInThisShareBox' => Request::url()])
                </div>

                <div class="prw_rup prw_common_location_photos photos position-relative">
                    <div id="targetHelp_10" class="targets mainSliderPlaceDetails">
                        <div class="inner">
                            <div class="primaryWrap">
                                <div class="prw_rup prw_common_mercury_photo_carousel">
                                    <div id="mainSliderPlaceHolderSectionPlaceDetail" class="placeHolderAnime"></div>
                                    <div id="mainSliderSectionPlaceDetail" class="carousel bignav hidden">
                                        <div class="carousel_images carousel_images_header">
                                            <div id="photographerAlbum" onclick=showPhotoAlbum('sliderPic')>
                                                <div id="mainSlider" class="swiper-container">
                                                    <div id="mainSliderWrapper" class="swiper-wrapper"></div>
                                                </div>
                                                <div id="allPlacePicturesCount" class="hideOnScreen fullCameraIcon allPictureOnMainSlider"></div>
                                            </div>
                                            <a id="photographersLink" class="hideOnPhone" onclick="isPhotographer()"> عکاس هستید؟ کلیک کنید </a>
                                        </div>
                                        <div class="left-nav left-nav-header swiper-button-next mainSliderNavBut"></div>
                                        <div class="right-nav right-nav-header swiper-button-prev mainSliderNavBut"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="secondaryWrap sideSliderPicsSection hideOnPhone">

                                <div id="sideSliderSite" class="sideSecPicRow">
                                    <div class="mainContent hidden" onclick="showPhotoAlbum('sitePics')">
                                        <img src="{{URL::asset('images/mainPics/nopictext1.jpg')}}" class="resizeImgClass centeredImg" width="100%" onload="fitThisImg(this)"/>
                                        <div class="moreContent">
                                            <span class="ui_icon camera">&nbsp;</span>
                                            <span>عکس‌های سایت -</span>
                                            <span class="countOfPic">0</span>
                                        </div>
                                    </div>
                                    <div class="placeHolderAnime"></div>
                                </div>
                                <div id="sideSliderUsers" class="sideSecPicRow">
                                    <div class="mainContent hidden" onclick="showPhotoAlbum('userPics')">
                                        <img src="{{URL::asset('images/mainPics/nopictext1.jpg')}}" class="resizeImgClass centeredImg" width="100%" onload="fitThisImg(this)"/>
                                        <div class="moreContent">
                                            <span class="ui_icon camera">&nbsp;</span>
                                            <span>عکس‌های کاربران -</span>
                                            <span class="countOfPic">0</span>
                                        </div>
                                    </div>
                                    <div class="placeHolderAnime"></div>
                                </div>
                                <div id="sideSliderVideos" class="sideSecPicRow">
                                    <div class="mainContent hidden" onclick="showPhotoAlbum('userVideo')">
                                        <img src="{{URL::asset('images/mainPics/nopictext1.jpg')}}" class="resizeImgClass centeredImg" width="100%" onload="fitThisImg(this)"/>
                                        <div class="moreContent">
                                            <span class="ui_icon camera">&nbsp;</span>
                                            <span>ویدیو و فیلم 360 -</span>
                                            <span class="countOfPic">0</span>
                                        </div>
                                    </div>
                                    <div class="placeHolderAnime"></div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="hSectionInPlaceDetail hideOnScreen">
                        @if($placeMode == 'mahaliFood')
                            <div class="tabLinkMainWrap generalDescBtnTopBar tab" onclick="changeTabBarColor(this, 'generalDescLinkRel')">مواد لازم</div>
                            <div class="tabLinkMainWrap recipeDescBtnTopBar tab" onclick="changeTabBarColor(this, 'recepieForFood')">دستور پخت</div>
                        @elseif($placeMode == 'drinks')
                            <div class="tabLinkMainWrap recipeDescBtnTopBar tab" onclick="changeTabBarColor(this, 'drinkRecipes')">طرز تهیه</div>
                                <div class="tabLinkMainWrap generalDescBtnTopBar tab" onclick="changeTabBarColor(this, 'materialNeededSection')">مواد لازم</div>
                        @else
                            <div class="tabLinkMainWrap generalDescBtnTopBar tab" onclick="changeTabBarColor(this, 'generalDescLinkRel')">معرفی کلی</div>
                            @if($placeMode != 'sogatSanaies')
                                <div class="tabLinkMainWrap mapBtnTopBar tab" onclick="changeTabBarColor(this, 'goToMapSection')">نقشه</div>
                            @else
                                <div class="tabLinkMainWrap mapBtnTopBar tab" onclick="changeTabBarColor(this, 'goToMapSection')">ویژگی ها</div>
                            @endif
                        @endif

                        <div class="tabLinkMainWrap postsBtnTopBar tab" onclick="changeTabBarColor(this, 'mainDivPlacePost')">نظرات</div>
                        <div class="tabLinkMainWrap QAndAsBtnTopBar tab" onclick="changeTabBarColor(this, 'QAndAMainDivId')">پرسش و پاسخ</div>

                        @if($place->similarPlace)
                            <div class="tabLinkMainWrap similarLocationsBtnTopBar tab" onclick="changeTabBarColor(this, 'topPlacesSection')">مکان های مشابه</div>
                        @endif
                    </div>

                    <div id="indicForShowDown" class="hideOnScreen">
                        @include('layouts.placeMainBodyHeader')
                    </div>

                    <a class="postLink topAndBottomBorderAndMargin hideOnPhone" href="#reviewMainDivDetails">
                        <div id="mainStoreReviewDiv" class="postMainDiv">
                            <div class="postMainDivHeader">  {{__('نظر شما')}}  </div>
                            <div id="commentInputMainDiv">
                                <div class="inputBoxGeneralInfo inputBox postInputBox" id="commentInputBox" onclick="newPostModal('textarea')">
                                    <div id="profilePicForComment" class="fullyCenterContent profilePicForPost circleBase type2" style="overflow: hidden; border-radius: 50%;">
                                        <img src="{{ $userPic }}" alt="userPicture" class="resizeImgClass" style="width: 100%;" onload="fitThisImg(this)">
                                    </div>
                                    <textarea type="text"
                                              class="inputBoxInput inputBoxInputComment showNewTextReviewArea"
                                              placeholder="{{auth()->check() ? auth()->user()->username : ''}} نظرت رو نسبت به این {{$kindPlace->name}} به اشتراک بگذار"
                                              onclick="newPostModal('textarea')" readonly></textarea>
                                    <img src="{{URL::asset('images/smile.png')}}" class="commentSmileyIcon" alt="emoji"/>
                                </div>
                            </div>
                            <div class="commentMoreSettingBar">
                                <div class="commentOptionsBoxes">
                                    <label {{auth()->check() ? 'for=picReviewInput0 onclick=newPostModal()' : 'onclick=newPostModal()'}}>
                                        <span class="icons addPhotoCommentIcon"></span>
                                        <span class="commentOptionsText">{{__('افزودن عکس')}}</span>
                                    </label>
                                </div>
                                <div class="commentOptionsBoxes">
                                    <label {{auth()->check() ? 'for=videoReviewInput onclick=newPostModal()' : 'onclick=newPostModal()'}}>
                                        <span class="icons addVideoCommentIcon"></span>
                                        <span class="commentOptionsText">{{__('افزودن ویدیو')}}</span>
                                    </label>
                                </div>
                                <div class="commentOptionsBoxes">
                                    <label {{auth()->check() ? 'for=video360ReviewInput onclick=newPostModal()' : 'onclick=newPostModal()'}}>
                                        <span class="add360VideoCommentIcon"></span>
                                        <span class="commentOptionsText">{{__('افزودن ویدیو 360')}}</span>
                                    </label>
                                </div>
                                <div class="commentOptionsBoxes">
                                    <label {{auth()->check() ? '' : 'onclick=newPostModal("tag")'}}>
                                        <span class="tagFriendCommentIcon"></span>
                                        <span class="commentOptionsText">{{__('افزودن دوست')}}</span>
                                    </label>
                                </div>

{{--                                <div class="commentOptionsBoxes">--}}
{{--                                    <label {{auth()->check() ? ' onclick=newPostModal("tag")' : 'onclick=newPostModal("tag")'}}>--}}
{{--                                        <span class="icons addMemberIcon"></span>--}}
{{--                                        <span class="commentOptionsText">{{__('افزودن دوست')}}</span>--}}
{{--                                    </label>--}}
{{--                                </div>--}}
                                <div class="commentOptionsBoxes moreSettingPostManDiv" onclick="newPostModal()">
                                    <span class="moreSettingPost"></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </div>


    <div class="seperatorSections"></div>

    <div id="MAINWRAP" class="full_meta_photos_v3  full_meta_photos_v4  big_pic_mainwrap_tweaks horizontal_xsell ui_container is-mobile position-relative">
        <div id="MAIN" class="Hotel_Review prodp13n_jfy_overflow_visible position-relative">
            <div id="BODYCON" class="col easyClear bodLHN poolB adjust_padding new_meta_chevron new_meta_chevron_v2 position-relative">
                @if($placeMode == 'mahaliFood' || $placeMode == 'drinks')
                    <nav id="sticky" class="tabLinkMainWrapMainDIV navbar navbar-inverse hideOnPhone">
                        <div class="container-fluid tabLinkMainWrapMainDiv tabLinkMainWrapMainDiv_Food">
                            <div class="collapse navbar-collapse" id="myNavbar">
                                <ul class="nav navbar-nav">
                                    <li>
                                        <a class="tabLinkMainWrap QAndAsBtnTopBar" href="#QAndAMainDivId" onclick="changeTabBarColor(this)"> پرسش و پاسخ </a>
                                    </li>
                                    <li>
                                        <a id="pcPostButton" class="tabLinkMainWrap postsBtnTopBar" href="#mainDivPlacePost" onclick="changeTabBarColor(this)"> نظرات </a>
                                    </li>
                                    <li>
                                        @if($placeMode == 'drinks')
                                            <a class="tabLinkMainWrap generalDescBtnTopBar" href="#drinkRecipes" onclick="changeTabBarColor(this)">طرز تهیه</a>
                                        @else
                                            <a class="tabLinkMainWrap generalDescBtnTopBar" href="#generalDescLinkRel" onclick="changeTabBarColor(this)">دستور پخت</a>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                @else
                    <nav id="sticky" class="tabLinkMainWrapMainDIV navbar navbar-inverse hideOnPhone">
                        <div class="container-fluid tabLinkMainWrapMainDiv">
                            <div class="collapse navbar-collapse" id="myNavbar">
                                <ul class="nav navbar-nav">
                                    <li>
                                        <a class="tabLinkMainWrap similarLocationsBtnTopBar similarLocationsBtnTopBar" href="#topPlacesSection" onclick="changeTabBarColor(this)"> مکان‌های مشابه </a>
                                    </li>
                                    <li>
                                        <a class="tabLinkMainWrap QAndAsBtnTopBar" href="#QAndAMainDivId" onclick="changeTabBarColor(this)">پرسش و پاسخ</a>
                                    </li>
                                    <li>
                                        <a id="pcPostButton" class="tabLinkMainWrap postsBtnTopBar" href="#mainDivPlacePost" onclick="changeTabBarColor(this)"> نظرات </a>
                                    </li>
                                    <li>
                                        <a class="tabLinkMainWrap generalDescBtnTopBar" href="#generalDescLinkRel" onclick="changeTabBarColor(this)"> معرفی کلی </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                @endif

                <div class="exceptQAndADiv" id="generalDescLinkRel" style="display: inline-block">
                    <div class="hr_btf_wrap position-relative topAndBottomBorderAndMargin">
                        <div id="introduction" class="ppr_rup ppr_priv_location_detail_overview">
                            <div class="block_wrap" data-tab="TABS_OVERVIEW">
                                <div class="overviewContent">
                                    <div id="mobileIntroductionMainDivId" class="mobileIntroductionMainDiv tabContentMainWrap ">
{{--                                        @if($placeMode == 'mahaliFood')--}}
{{--                                            <div class="tabLinkMainDiv hideOnPhone">--}}
{{--                                                <button class="tabLink" onclick="openCity('commentsAndAddressMobile', this)">دستور پخت</button>--}}
{{--                                                <button class="tabLink" onclick="openCity('detailsAndFeaturesMobile', this)">کالری</button>--}}
{{--                                                <button id="defaultOpen" class="tabLink" onclick="openCity('generalDescriptionMobile', this)"> مواد لازم </button>--}}
{{--                                            </div>--}}
{{--                                        @elseif($placeMode !== 'drinks')--}}
{{--                                            <div class="tabLinkMainDiv hideOnPhone">--}}
{{--                                                <button class="tabLink" onclick="openCity('commentsAndAddressMobile', this)"> نظرات و آدرس</button>--}}
{{--                                                <button class="tabLink" onclick="openCity('detailsAndFeaturesMobile', this)"> امکانات و ویژگی‌ها </button>--}}
{{--                                                <button id="defaultOpen" class="tabLink" onclick="openCity('generalDescriptionMobile', this)"> معرفی کلی</button>--}}
{{--                                            </div>--}}
{{--                                        @endif--}}

                                        <?php
                                        if ($kindPlaceId == 4 ||$kindPlaceId == 12) {
                                            $showInfo = 12;
                                            $showReviewRate = 4;
                                            $showFeatures = 8;
                                            $mainInfoClass = '';
                                        } else {
                                            $showInfo = 4;
                                            $showReviewRate = 4;
                                            $showFeatures = 4;
                                            $mainInfoClass = 'mainInfo';
                                        }
                                        ?>

                                        @if($placeMode == 'mahaliFood')
                                            @include('pages.placeDetails.tables.mahalifood-details-table')
                                        @elseif($placeMode === 'drinks')
                                            @include('pages.placeDetails.tables.drinks-details-table')
                                        @else
                                            <div class="ui_columns is-multiline is-mobile reviewsAndDetails direction-rtlImp">
                                                <div id="generalDescriptionMobile"
                                                     class="ui_column is-{{$showInfo}} generalDescription tabContent">
                                                    <div class="block_header">
                                                        <div class="titlesPlaceDetail">
                                                            <h3 class="block_title">{{__('معرفی کلی')}} </h3>
                                                        </div>
                                                    </div>
                                                    <div class="toggleDescription" style="position: relative">
                                                        <div id="introductionText" class="unselectedText overviewContent descriptionOfPlaceMiddleContent">
                                                            {!! $place->description !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="detailsAndFeaturesMobile"
                                                     class="ui_column is-{{$showFeatures}} details tabContent {{$mainInfoClass}} featureOfPlaceMiddle">
                                                    <div class="direction-rtl featureOfPlaceMiddleContent row"
                                                         style="margin: 0px">
                                                        <?php $k = -1; ?>

                                                        @if($placeMode == "hotels")
                                                            @include('pages.placeDetails.tables.hotel-details-table')
                                                        @elseif($placeMode == "amaken")
                                                            @include('pages.placeDetails.tables.amaken-details-table')
                                                        @elseif($placeMode == "restaurant")
                                                            @include('pages.placeDetails.tables.restaurant-details-table')
                                                        @elseif($placeMode == "majara")
                                                            @include('pages.placeDetails.tables.majara-details-table')
                                                        @elseif($placeMode == "sogatSanaies")
                                                            @include('pages.placeDetails.tables.sogatsanaie-details-table')
                                                        @elseif($placeMode == "boomgardies")
                                                            @include('pages.placeDetails.tables.boomgardies-details-table')
                                                        @endif
                                                    </div>
                                                </div>
                                                <div id="commentsAndAddressMobile" class="ui_column is-{{$showReviewRate}} reviews tabContent hideOnTablet rateOfPlaceMiddle">
                                                    <div class="rateOfPlaceMiddleContent row" style="margin: 0px;">
                                                        @include('pages.placeDetails.component.PlaceDetailRateSection')
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="seperatorSections"></div>

                    <div class="rateOfPlaceMiddleContent topAndBottomBorderAndMargin seperateRates showOnTablet">
                        @include('pages.placeDetails.component.PlaceDetailRateSection')
                    </div>

                    <div class="seperatorSections"></div>

                    @if($placeMode != 'sogatSanaies' && $placeMode != 'mahaliFood' && $placeMode != 'drinks')

                        <div id="goToMapSection" class="topMainMapDiv topAndBottomBorderAndMargin">
                            <div id="mainMap" class="mainMap placeHolderAnime"></div>
                        </div>

                        <div class="seperatorSections"></div>

{{--                        <div class="topAndBottomBorderAndMargin">--}}
{{--                            <div class="topPageAd" style="margin: 10px auto">--}}
{{--                                <img src="{{URL::asset('images/festival/cookFestival/gitcooking.webp')}}" >--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        @include('pages.placeDetails.component.extendedMap')
                        <div class="seperatorSections"></div>

                    @endif


                    <div id="mainDivPlacePost" class="tabContentMainWrap" style="display: flex; direction: rtl; flex-direction: column;">

                        <div class="postMainDiv hideOnScreen">
                            <div class="postMainDivHeader"> {{__('نظر شما')}} </div>
                            <div id="commentInputMainDiv">
                                <div class="inputBoxGeneralInfo inputBox postInputBox" id="commentInputBox" onclick="newPostModal('textarea')">
                                    <div id="profilePicForComment" class="fullyCenterContent profilePicForPost circleBase type2" style="overflow: hidden; border-radius: 50%;">
                                        <img src="{{ $userPic }}" alt="userPicture" class="resizeImgClass" style="width: 100%;" onload="fitThisImg(this)">
                                    </div>
                                    <textarea type="text"
                                              class="inputBoxInput inputBoxInputComment showNewTextReviewArea"
                                              placeholder="{{auth()->check() ? auth()->user()->username : ''}} نظرت رو نسبت به این {{$kindPlace->name}} به اشتراک بگذار"
                                              onclick="newPostModal('textarea')" readonly></textarea>
                                    <img src="{{URL::asset('images/smile.png')}}" class="commentSmileyIcon" alt="emoji"/>
                                </div>
                            </div>
                            <div class="commentMoreSettingBar">
                                <div class="commentOptionsBoxes">
                                    <label {{auth()->check() ? 'for=picReviewInput0 onclick=newPostModal()' : 'onclick=newPostModal()'}}>
                                        <span class="icons addPhotoCommentIcon"></span>
                                        <span class="commentOptionsText">{{__('افزودن عکس')}}</span>
                                    </label>
                                </div>
                                <div class="commentOptionsBoxes">
                                    <label {{auth()->check() ? 'for=videoReviewInput onclick=newPostModal()' : 'onclick=newPostModal()'}}>
                                        <span class="icons addVideoCommentIcon"></span>
                                        <span class="commentOptionsText">{{__('افزودن ویدیو')}}</span>
                                    </label>
                                </div>
                                <div class="commentOptionsBoxes">
                                    <label {{auth()->check() ? 'for=video360ReviewInput onclick=newPostModal()' : 'onclick=newPostModal()'}}>
                                        <span class="add360VideoCommentIcon"></span>
                                        <span class="commentOptionsText">{{__('افزودن ویدیو 360')}}</span>
                                    </label>
                                </div>
                                <div class="commentOptionsBoxes">
                                    <label {{auth()->check() ? '' : 'onclick=newPostModal("tag")'}}>
                                        <span class="tagFriendCommentIcon"></span>
                                        <span class="commentOptionsText">{{__('افزودن دوست')}}</span>
                                    </label>
                                </div>

                                {{--<div class="commentOptionsBoxes">--}}
                                {{--    <label {{auth()->check() ? ' onclick=newPostModal("tag")' : 'onclick=newPostModal("tag")'}}>--}}
                                {{--        <span class="icons addMemberIcon"></span>--}}
                                {{--        <span class="commentOptionsText">{{__('افزودن دوست')}}</span>--}}
                                {{--    </label>--}}
                                {{--</div>--}}
                                <div class="commentOptionsBoxes moreSettingPostManDiv" onclick="newPostModal()">
                                    <span class="moreSettingPost"></span>
                                </div>
                            </div>
                        </div>

                        <div class="topBarContainerPosts display-none"></div>

                        <div class="col-md-5 col-xs-12 pd-0 pd-rt-10Imp leftColMainWrap" style="display: none;">
                            @include('pages.placeDetails.filterSection')
                        </div>

                        @include('pages.placeDetails.reviewSection')
                    </div>

                    <div style="margin-top: 15px">
                        <div id="pos-article-display-16123"></div>
                    </div>

                    <div class="Ad3InRowPc" style="display: none">
                        <div id="pos-article-display-16123"></div>
                    </div>

                    @include('pages.placeDetails.questionSection')
                </div>

                @if($placeMode != 'sogatSanaies' && $placeMode != 'mahaliFood' && $placeMode != 'drinks')
                    <div id="topPlacesSection">
                        @include('component.rowSuggestion')
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if(isset($video) && $video != null && false)
        {{--vr--}}
        <link rel="stylesheet" href="{{URL::asset('vr2/video-js.css?v='.$fileVersions)}}">
        <link rel="stylesheet" href="{{URL::asset('vr2/videojs-vr.css?v='.$fileVersions)}}">
        <script defer src="{{URL::asset('vr2/video.js')}}"></script>
        <script defer src="{{URL::asset('vr2/videojs-vr.js')}}" onload="loadVRPlayer();"></script>

        <div class="modal" id="videojsModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- Modal body -->
                    <div class="modal-body" style="justify-content: center; display: flex;">
                        <video id="my-video" class="video-js vjs-default-skin" controls style=" max-height: 80vh;">
                            <source src="{{URL::asset('vr2/contents/' . $video)}}" type="video/mp4">
                        </video>
                        ویدیویی برای نمایش موجود
                    </div>
                </div>
            </div>
        </div>

        <script>
            var player;
            function loadVRPlayer() {
                (function (window, videojs) {
                    player = window.player = videojs('my-video');
                    player.mediainfo = player.mediainfo || {};
                    player.mediainfo.projection = '360';

                    // AUTO is the default and looks at mediainfo
                    var vr = window.vr = player.vr({projection: '360', debug: false, forceCardboard: false});
                }(window, window.videojs));
            }
            $('#videojsModal').on('hidden.bs.modal', () => player.pause());

            function showModal() {
                $('#videojsModal').modal('toggle');
                player.play();
            }
        </script>
    @endif

    @if($placeMode != 'sogatSanaies' && $placeMode != 'mahaliFood' && $placeMode != 'drinks')
        <script>
            var topPlacesSections = [
                {
                    name: '{{__('بوم گردی های نزدیک')}}',
                    id: 'nearDivboomgardy',
                    url: '#'
                },
                {
                    name: '{{__('جاذبه های نزدیک')}}',
                    id: 'nearDivamaken',
                    url: '#'
                },
                {
                    name: '{{__('محبوب‌ترین رستوران‌ها')}}',
                    id: 'nearDivrestaurant',
                    url: '#'
                },
                {
                    name: '{{__('اقامتگاه های نزدیک')}}',
                    id: 'nearDivhotels',
                    url: '#'
                },
                {
                    name: '{{__('طبیعت گردی های نزدیک')}}',
                    id: 'nearDivmajara',
                    url: '#'
                },
                {
                    name: '{{__('سفرنامه ها')}}',
                    id: 'articleSuggestion',
                    url: '#'
                },
            ];

            function initNearbySwiper() {
                new Swiper('.mainSuggestion', {
                    breakpoints: {
                        768: {
                            slidesPerView: 'auto',
                            spaceBetween: 10,
                            loop: false,
                        },
                         992: {
                            slidesPerView: 3,
                            spaceBetween: 20,
                        },
                        10000: {
                            slidesPerView: 4,
                            spaceBetween: 20,
                        }
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    // autoplay: {
                    //     delay: 4000,
                    // },
                });
            }

            function getNearbyToPlace(){
                // getNearby
                $.ajax({
                    type: 'post',
                    url: '{{route("getNearby")}}',
                    data: {
                        placeId: placeId,
                        kindPlaceId : kindPlaceId,
                        count : 10,
                    },
                    success: function(response){
                        let center = {
                            hasMarker: true,
                            x: '{{$place->C}}',
                            y: '{{$place->D}}'
                        };
                        createSuggestionRowWithData(response.places);
                        createArticleRowWithData(response.safarnameh);

                        createMapInBlade('mainMap', center, response.places, true);
                    }
                });
            }

            function createSuggestionRowWithData(_result){
                let fk = Object.keys(_result);
                for (let x of fk) {
                    if(_result[x].length > 4)
                        createSuggestionPack(`nearDiv${x}Content`, _result[x], () => {
                            $(`#nearDiv${x}Content`).find('.suggestionPackDiv').addClass('swiper-slide'); /**in suggestionPack.blade.php**/
                        });
                    else
                        $(`#nearDiv${x}`).remove();
                }
                initNearbySwiper();
            }

            function createArticleRowWithData(_articles){

                createSuggestionPack('articleSuggestionContent', _articles, function () { // in component.suggestionPack.blade.php
                    $('#articleSuggestionContent').find('.suggestionPackDiv').addClass('swiper-slide');
                    initNearbySwiper();
                });
            }

           $(document).ready(() => {
               initPlaceRowSection(topPlacesSections); // component.rowSuggestion
               getNearbyToPlace();
           });

        </script>
    @endif

    <script>
        var placeId = '{{$place->id}}';
        var cityNamePlaceDetails = '{{$city->name}}';
        var placeNamePlaceDetail = '{{$place->name}}';
        var noPicUrl = "{{URL::asset('images/mainPics/nopictext1.jpg')}}";

        var setPlacetoBookMarkUrl = '{{route("setBookMark")}}';
        var koochitaTvUrl = "{{route('getVideosFromKoochitaTv')}}";
        var setRateToPlaceUrl = '{{route("places.setRateToPlaces")}}';
        var addPhotoToPlaceUrl = '{{route("upload.photographer.uploadFile")}}';


        $(window).ready(() => {
            var encodeurlShareBox = encodeURIComponent('{{Request::url()}}');
            var textShareBox = 'whatsapp://send?text=';
            textShareBox += 'در کوچیتا ببینید:' + ' %0a ' + encodeurlShareBox;
            $('.whatsappLinkMobilePlaceDetails').attr('href', textShareBox);
        })
    </script>

    <script src="{{URL::asset('js/pages/placeDetails/placeDetails.js?v='.$fileVersions)}}"></script>
@stop

