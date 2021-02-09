@extends('layouts.bodyPlace')

<?php
$total = $rates['5'] + $rates['1'] + $rates['2'] + $rates['3'] + $rates['4'];
$total = $total == 0 ? 1 : $total;

$seoTitle = isset($place->seoTitle) ? $place->seoTitle : "کوچیتا | " . $city->name . " | " . $place->name;
?>
@section('head')
    <meta content="article" property="og:type"/>
    <meta property="og:title" content="{{$seoTitle}}"/>
    <meta property="title" content="{{$seoTitle}}"/>
    <meta name="twitter:title" content="{{$seoTitle}}"/>
    <meta name="twitter:card" content="{{$place->meta}}"/>
    <meta name="description" content="{{$place->meta}}"/>
    <meta name="twitter:description" content="{{$place->meta}}"/>
    <meta property="og:description" content="{{$place->meta}}"/>
    <meta property="article:section" content="{{$placeMode}}"/>
    <meta property="article:author " content="کوچیتا"/>
    <meta name="keywords" content="{{$place->keyword}}">
    <meta property="og:url" content="{{Request::url()}}"/>

    @if(count($photos) > 0)
        <meta property="og:image" content="{{$photos[0]}}"/>
        <meta property="og:image:secure_url" content="{{$photos[0]}}"/>
        <meta name="twitter:image" content="{{$photos[0]}}"/>
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
        var thisUrl = '{{Request::url()}}';
        var userCode = '{{$userCode}}';
        var yourRateForThisPlace = '{{$yourRate}}';
        var userPic = '{{$userPic}}';
        var userPhotos = {!! json_encode($userPhotos) !!};
        var userVideo = {!! json_encode($userVideo) !!};
        var placeMode = '{{$placeMode}}';
        var getQuestions = '{{route('getQuestions')}}';
        var likeLog = '{{route('likeLog')}}';
        var reviewUploadPic = '{{route('reviewUploadPic')}}';
        var doEditReviewPic = '{{route('doEditReviewPic')}}';
        var reviewUploadFileURLInPlaceDetails = '{{route('review.uploadFile')}}';
        var placeMode = '{{$placeMode}}';
        var sliderPics = {!! json_encode($sliderPics) !!};
        var photographerPics = {!! json_encode($photographerPics) !!};
        var sitePics = {!! json_encode($sitePics) !!};
        var hotelDetails;
        var hotelDetailsInAskQuestionMode;
        var hotelDetailsInAnsMode;
        var hotelDetailsInSaveToTripMode;
        var placeId = '{{$place->id}}';
        var kindPlaceId = '{{$kindPlaceId}}';
        var getCommentsCount = '{{route('getCommentsCount')}}';
        var totalPhotos = '{{count($sitePics) + count($userPhotos)}}';
        var sitePhotosCount = {{count($sitePics)}};
        var opOnComment = '{{route('opOnComment')}}';
        var askQuestionDir = '{{route('askQuestion')}}';
        var sendAnsDir = '{{route('sendAns')}}';
        var showAllAnsDir = '{{route('showAllAns')}}';
        var filterComments = '{{route('filterComments')}}';
        var getPhotoFilter = '{{route('getPhotoFilter')}}';
        var getPhotosDir = '{{route('getPhotos')}}';
        var showUserBriefDetail = '{{route('showUserBriefDetail')}}';
        var deleteReviewPicUrl = '{{route('deleteReviewPic')}}';
    </script>

{{--    <script defer src= {{URL::asset("js/calendar.js") }}></script>--}}
{{--    <script defer src= {{URL::asset("js/jalali.js") }}></script>--}}
{{--    <script defer src="{{URL::asset('js/adv.js')}}"></script>--}}
{{--    <script async src="{{URL::asset('js/swiper/swiper.min.js')}}"></script>--}}

    <script defer src="{{URL::asset('js/emoji/area/emojionearea.js')}}"></script>
    <script defer src="{{URL::asset('js/hotelDetails/hoteldetails_2.js')}}"></script>

    <style>

        .sogatSanieMobileFeatures{
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            background: white;
            padding-top: 15px;
            margin: 0px;
        }
        .featureBox{
            text-align: center;
            padding: 5px 15px;
            box-shadow: 2px 2px 4px 0px #333;
            margin: 6px 7px;
            border-radius: 8px;
        }
        .featureBox .title{
            font-weight: bold;
            color: var(--koochita-green);
        }
        .featureBox .value{
            display: flex;
            justify-content: center;
        }
        .featureBox .value .val{
            margin: 0px 10px;
            font-size: 11px;
            text-align: center;
        }

        .sogatFeature{
            margin: 10px 0px;
        }
        .sogatFeature .feat{
            display: flex;
            margin: 5px 0px;
        }
        .sogatFeature .feat .title{
            color: black;
            margin-left: 5px;
        }
        .sogatFeature .feat .value{
            font-weight: bold;
            color: green;
        }

        .seperatorSections{
            background: #f8f8f8;
            height: 15px;
            width: 100%;
            border-top: solid 1px #4dc7bc52;
            border-bottom: solid 1px #4dc7bc52;
            display: none;
        }

        @media (max-width: 767px) {
            .seperatorSections{
                display: block;
            }
        }

    </style>

@stop


@section('main')
    @include('general.schema')

    <div class="hideOnPhone">
        @include('general.secondHeader')
    </div>
    @include('component.mapMenu')

    @include('component.smallShowReview')

    <div id="comeDownHeader" class="topHeaderShowDown hideOnScreen">
        <div class="inOneRow">
            <div class="name">{{$place->name}}</div>
            <div class="buttonsH">
            <div class="circlePlaceDetailButtons" onclick="addPlaceToBookMark()">
                <div class="icon saveAsBookmarkIcon  {{auth()->check() && $bookMark ? "BookMarkIcon" : "BookMarkIconEmpty"}}"></div>
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
                    <a href="#" class="share whatsappLink">
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
            @else
                <div class="tabLinkMainWrap generalDescBtnTopBar" onclick="changeTabBarColor(this, 'generalDescLinkRel')">معرفی کلی</div>
                @if($placeMode != 'sogatSanaies')
                    <div class="tabLinkMainWrap mapBtnTopBar" onclick="changeTabBarColor(this, 'goToMapSection')">نقشه</div>
                @else
                    <div class="tabLinkMainWrap mapBtnTopBar" onclick="changeTabBarColor(this, 'goToMapSection')">ویژگی ها</div>
                @endif
            @endif
            <div class="tabLinkMainWrap postsBtnTopBar" onclick="changeTabBarColor(this, 'mainDivPlacePost')">نظرات</div>
            <div class="tabLinkMainWrap QAndAsBtnTopBar" onclick="changeTabBarColor(this,'QAndAMainDivId')">سوالات</div>
            @if($placeMode != 'mahaliFood' && $placeMode != 'sogatSanaies')
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
                                <div class="tvContentText">
                                    کوچیتا تی وی برای تماشای آنلاین و زنده محتواهای بصری و صوتی در تمامی حوزه های گردشگری و سفر
                                </div>
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
                            <div id="bookMarkIcon" class="saveAsBookmarkIcon {{auth()->check() && $bookMark ? "BookMarkIcon" : "BookMarkIconEmpty"}}"></div>
                            <div class="saveAsBookmarkLabel">
                                {{__('ذخیره این صفحه')}}
                            </div>
                        </span>
                    </div>

                    <div id="share_pic" class="wideScreen targets float-left col-xs-6 pd-0">
                        <span class="ui_button save-location-7306673 sharePageMainDiv">
                            <div class="shareIconDiv sharePageIcon first"></div>
                            <div class="sharePageLabel">
                                {{__('اشتراک‌گذاری صفحه')}}
                            </div>
                        </span>
                    </div>
                    @include('layouts.shareBox')

                </div>

                <div class="prw_rup prw_common_location_photos photos position-relative">
                    <div id="targetHelp_10" class="targets mainSliderPlaceDetails">
                        <div class="inner">
                            <div class="primaryWrap">
                                <div class="prw_rup prw_common_mercury_photo_carousel">
                                    <div class="carousel bignav">
                                        <div class="carousel_images carousel_images_header">
                                            <div id="photographerAlbum" {{count($sliderPics) > 0 ? "onclick=showPhotoAlbum('sliderPic')" : ''}}>
                                                <div id="mainSlider" class="swiper-container">
                                                    <div id="mainSliderWrapper" class="swiper-wrapper">
                                                        @foreach($sliderPics as $pics)
                                                            <div class="swiper-slide" style="overflow: hidden">
                                                                <img class="eachPicOfSlider resizeImgClass" src="{{$pics['s']}}" alt="{{$pics['alt']}}" onload="fitThisImg(this)">
                                                                <div class="see_all_count_wrap hideOnPhone">
                                                                    <span class="see_all_count">
                                                                        <div class="circleBase type2" id="photographerIdPic" style="background-color: var(--koochita-light-green);">
                                                                            <img src="{{$pics['userPic']}}" style="width: 100%; height: 100%; border-radius: 50%;">
                                                                        </div>
                                                                        <div class="display-inline-block mg-rt-10 mg-tp-2">
                                                                            <span class="display-block font-size-12">عکس از</span>
                                                                            <span class="display-block">{{$pics['name']}}</span>
                                                                        </div>
                                                                    </span>
                                                                </div>

                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div id="allPlacePicturesCount" class="hideOnScreen fullCameraIcon allPictureOnMainSlider"> {{count($sliderPics)}} </div>
                                            </div>
{{--                                            <a id="photographersLink" class="hideOnPhone" onclick="isPhotographer()"> عکاس هستید؟ کلیک کنید </a>--}}
                                        </div>
                                        <div class="left-nav left-nav-header swiper-button-next mainSliderNavBut"></div>
                                        <div class="right-nav right-nav-header swiper-button-prev mainSliderNavBut"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="secondaryWrap hideOnPhone">
                                <div class="tileWrap" onclick="showPhotoAlbum('sitePics')">
                                    <div class="prw_rup prw_hotels_flexible_album_thumb tile">
                                        <div class="albumThumbnail">
                                            <div class="prw_rup prw_common_centered_image">
                                                @if(count($sitePics) != 0)
                                                    <span class="imgWrap imgWrap1stTemp">
                                                        <img alt="{{$place->alt}}" src="{{$thumbnail}}" class="resizeImgClass centeredImg" width="100%" onload="fitThisImg(this)"/>
                                                    </span>
                                                @else
                                                    <span class="imgWrap imgWrap1stTemp">
                                                        <img src="{{URL::asset('images/mainPics/nopictext1.jpg')}}" class="resizeImgClass centeredImg" width="100%" onload="fitThisImg(this)"/>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="albumInfo" {{count($sitePics) != 0 ? 'data-toggle="modal" data-target="#showingSitePicsModal"' : ''}}>
                                                <span class="ui_icon camera">&nbsp;</span>
                                                عکس‌های سایت - {{count($sitePics)}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tileWrap" onclick=showPhotoAlbum("userPics")>
                                    <div class="prw_rup prw_hotels_flexible_album_thumb tile">
                                        <div class="albumThumbnail">
                                            <div class="prw_rup prw_common_centered_image">
                                        <span class="imgWrap imgWrap1stTemp">
                                            @if(count($userPhotos) != 0)
                                                <img src="{{$userPhotos[0]->pic}}" class="resizeImgClass centeredImg" width="100%" onload="fitThisImg(this)"/>
                                            @else
                                                <img src="{{URL::asset('images/mainPics/nopictext1.jpg')}}" class="resizeImgClass centeredImg" width="100%" onload="fitThisImg(this)"/>
                                            @endif
                                        </span>
                                            </div>
                                            <div {{(count($userPhotos) != 0) ? 'onclick=showPhotoAlbum("userPics")' : "" }}  class="albumInfo">
                                                <span class="ui_icon camera">&nbsp;</span>عکس‌های
                                                کاربران - {{count($userPhotos)}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tileWrap" onclick="showPhotoAlbum('userVideo')">
                                    <div class="prw_rup prw_hotels_flexible_album_thumb tile">
                                        <div class="albumThumbnail">
                                            <div class="prw_rup prw_common_centered_image">
                                            <span class="imgWrap imgWrap1stTemp">
                                                @if(count($userVideo) > 0)
                                                    <img src="{{$userVideo[0]->picName}}" class="resizeImgClass" onload="fitThisImg(this)">
                                                @else
                                                    <img src="{{URL::asset('images/mainPics/nopictext1.jpg')}}" class="centeredImg" width="100%"/>
                                                @endif
                                            </span>
                                            </div>
                                            <div class="albumInfo">
                                                <span class="ui_icon camera">&nbsp;</span>
                                                ویدیو و فیلم 360 - {{ count($userVideo) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hSectionInPlaceDetail hideOnScreen">
                    @if($placeMode == 'mahaliFood')
                        <div class="tabLinkMainWrap generalDescBtnTopBar tab" onclick="changeTabBarColor(this, 'generalDescLinkRel')">مواد لازم</div>
                        <div class="tabLinkMainWrap recipeDescBtnTopBar tab" onclick="changeTabBarColor(this, 'recepieForFood')">دستور پخت</div>
                    @else
                        <div class="tabLinkMainWrap generalDescBtnTopBar tab" onclick="changeTabBarColor(this, 'generalDescLinkRel')">معرفی کلی</div>
                        @if($placeMode != 'sogatSanaies')
                            <div class="tabLinkMainWrap mapBtnTopBar tab" onclick="changeTabBarColor(this, 'goToMapSection')">نقشه</div>
                        @else
                            <div class="tabLinkMainWrap mapBtnTopBar tab" onclick="changeTabBarColor(this, 'goToMapSection')">ویژگی ها</div>
                        @endif
                    @endif
                        <div class="tabLinkMainWrap postsBtnTopBar tab" onclick="changeTabBarColor(this, 'mainDivPlacePost')">نظرات</div>
                        <div class="tabLinkMainWrap QAndAsBtnTopBar tab" onclick="changeTabBarColor(this, 'QAndAMainDivId')">سوالات</div>
                    @if($placeMode != 'mahaliFood' && $placeMode != 'sogatSanaies')
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
                @if($placeMode == 'mahaliFood')
                    <nav id="sticky" class="tabLinkMainWrapMainDIV navbar navbar-inverse hideOnPhone"   >
                        <div class="container-fluid tabLinkMainWrapMainDiv tabLinkMainWrapMainDiv_Food">
                            <div class="collapse navbar-collapse" id="myNavbar">
                                <ul class="nav navbar-nav">
                                    <li>
                                        <a class="tabLinkMainWrap QAndAsBtnTopBar" href="#QAndAMainDivId" onclick="changeTabBarColor(this)"> سؤالات </a>
                                    </li>
                                    <li>
                                        <a id="pcPostButton" class="tabLinkMainWrap postsBtnTopBar" href="#mainDivPlacePost" onclick="changeTabBarColor(this)"> نظرات </a>
                                    </li>
                                    <li>
                                        <a class="tabLinkMainWrap generalDescBtnTopBar" href="#generalDescLinkRel" onclick="changeTabBarColor(this)"> دستور پخت </a>
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
                                        <a class="tabLinkMainWrap QAndAsBtnTopBar" href="#QAndAMainDivId" onclick="changeTabBarColor(this)">سؤالات</a>
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
                                        @if($placeMode == 'mahaliFood')
                                            <div class="tabLinkMainDiv hideOnPhone">
                                                <button class="tabLink" onclick="openCity('commentsAndAddressMobile', this, 'white', 'var(--koochita-light-green)')">
                                                    دستور پخت
                                                </button><!--
                                     -->
                                                <button class="tabLink"
                                                        onclick="openCity('detailsAndFeaturesMobile', this, 'white', 'var(--koochita-light-green)')">
                                                    کالری
                                                </button><!--
                                     -->
                                                <button class="tabLink"
                                                        onclick="openCity('generalDescriptionMobile', this, 'white', 'var(--koochita-light-green)')"
                                                        id="defaultOpen">
                                                    مواد لازم
                                                </button>
                                            </div>
                                        @else
                                            <div class="tabLinkMainDiv hideOnPhone">
                                                <button class="tabLink"
                                                        onclick="openCity('commentsAndAddressMobile', this, 'white', 'var(--koochita-light-green)')">
                                                    نظرات و آدرس
                                                </button><!--
                                     -->
                                                <button class="tabLink"
                                                        onclick="openCity('detailsAndFeaturesMobile', this, 'white', 'var(--koochita-light-green)')">
                                                    امکانات و ویژگی‌ها
                                                </button><!--
                                     -->
                                                <button class="tabLink" onclick="openCity('generalDescriptionMobile', this, 'white', 'var(--koochita-light-green)')" id="defaultOpen">
                                                    معرفی کلی
                                                </button>
                                            </div>
                                        @endif

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
                                            <div class="ui_columns is-multiline is-mobile reviewsAndDetails direction-rtlImp">

                                                <div id="generalDescriptionMobile" class="ui_column is-8 generalDescription tabContent">
                                                    <div class="block_header">
                                                        <div class="titlesPlaceDetail">
                                                            <h3 class="block_title">مواد لازم</h3>
                                                        </div>
                                                    </div>

                                                    <div class="row materSection">
                                                        @if(isset($place->material))
                                                            <div class="col-sm-6">
                                                                @foreach($place->material as $key => $item)
                                                                    @if($key%2 == 0)
                                                                        <div class="row font-size-20 materialRows">
                                                                            <div class="col-sm-6 col-xs-12 float-right materialName">{{$item->name}}</div>
                                                                            <div class="col-sm-6 col-xs-12 color-green materialVolume">{{$item->volume}}</div>
                                                                        </div>
                                                                        <hr>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                            <div class="col-sm-6" style="border-left: 1px solid #eee;">
                                                                @foreach($place->material as $key => $item)
                                                                    @if($key%2 != 0)
                                                                        <div class="row font-size-20 materialRows">
                                                                            <div class="col-sm-6 col-xs-12 float-right materialName">{{$item->name}}</div>
                                                                            <div class="col-sm-6 col-xs-12 color-green materialVolume">{{$item->volume}}</div>
                                                                        </div>
                                                                        <hr>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                        <div class="hideOnScreen" style="display: flex; justify-content: space-between; margin-top: 14px; text-align: center;">
                                                            <div class="foodKindMob" style="box-shadow: -2px 2px 4px 0px #333;">
                                                                <div class="title">نوع غذا</div>
                                                                <div class="val">{{$place->kindName}}</div>
                                                            </div>
                                                            <div class="foodKindMob">
                                                                <div class="title">نوع سرو</div>
                                                                <div class="val">{{$place->hotOrCold}}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="seperatorSections"></div>

                                                <div id="detailsAndFeaturesMobile" class="ui_column is-4 details tabContent mahaliFoodSeperator topAndBottomBorderAndMargin {{$mainInfoClass}} hideOnPhone">
                                                    <div class="direction-rtl featureOfPlaceMiddleContent row " style="margin: 0px">
                                                        @include('pages.placeDetails.tables.mahalifood-details-table')
                                                    </div>
                                                </div>

                                                <div id="recepieForFood" class="ui_column is-8 generalDescription tabContent">
                                                    <div class="block_header">
                                                        <div class="titlesPlaceDetail">
                                                            <h3 class="block_title">دستور پخت:</h3>
                                                        </div>
                                                    </div>
                                                    <div class="toggleDescription" style="position: relative">
                                                        <div class="unselectedText overviewContent descriptionOfPlaceMiddleContent"
                                                             id="introductionText">
                                                            {!! $place->recipes !!}
                                                        </div>
{{--                                                            <span class="showMoreDescriptionInDetails"></span>--}}
                                                    </div>
                                                </div>
                                                <div class="ui_column is-4 reviews tabContent hideOnPhone">
                                                    <div class="rateOfPlaceMiddleContent">
                                                        @include('pages.placeDetails.component.PlaceDetailRateSection')
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="ui_columns is-multiline is-mobile reviewsAndDetails direction-rtlImp">
                                                <div id="generalDescriptionMobile"
                                                     class="ui_column is-{{$showInfo}} generalDescription tabContent">
                                                    <div class="block_header">
                                                        <div class="titlesPlaceDetail">
{{--                                                            <div class="seperatorSections"></div>--}}

                                                            <h3 class="block_title">{{__('معرفی کلی')}} </h3>
                                                        </div>
                                                    </div>
                                                    <div class="toggleDescription" style="position: relative">
                                                        <div class="unselectedText overviewContent descriptionOfPlaceMiddleContent"
                                                             id="introductionText">
                                                            {!! $place->description !!}
{{--                                                            @if($kindPlaceId != 4)--}}
{{--                                                                <span class="introductionShowMore">--}}
{{--                                                                    بیشتر--}}
{{--                                                                </span>--}}
{{--                                                            @endif--}}
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
                                                <div id="commentsAndAddressMobile" class="ui_column is-{{$showReviewRate}} reviews tabContent hideOnPhone rateOfPlaceMiddle">
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

                    <div class="rateOfPlaceMiddleContent topAndBottomBorderAndMargin seperateRates hideOnScreen">
                        @include('pages.placeDetails.component.PlaceDetailRateSection')
                    </div>

                    <div class="seperatorSections"></div>

                    @if($placeMode != 'sogatSanaies' && $placeMode != 'mahaliFood')

                        <div class="topAndBottomBorderAndMargin" style="margin-top: 15px">
                            <div id='mediaad-Rvtf' class="importantFullyCenterContent marginBetweenMainPageMobileElements"></div>
                        </div>

                        <div class="seperatorSections"></div>

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
                            <div class="postMainDivHeader">
                                {{__('نظر شما')}}
                            </div>
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
{{--                        <div class="ad">--}}
{{--                            <img src="{{URL::asset('images/festival/cookFestival/gitcooking.webp')}}" >--}}
{{--                        </div>--}}
{{--                        <div class="ad">--}}
{{--                            <img src="{{URL::asset('images/festival/cookFestival/gitcooking.webp')}}" >--}}
{{--                        </div>--}}
{{--                        <div class="ad">--}}
{{--                            <img src="{{URL::asset('images/festival/cookFestival/gitcooking.webp')}}" >--}}
{{--                        </div>--}}
                    </div>

                    @include('pages.placeDetails.questionSection')
                </div>

                @if($placeMode != 'sogatSanaies' && $placeMode != 'mahaliFood')
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

    @if($placeMode != 'sogatSanaies' && $placeMode != 'mahaliFood')
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
                    autoplay: {
                        delay: 4000,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    // breakpoints: {
                    //     450: {
                    //         slidesPerView: 1,
                    //         spaceBetween: 15,
                    //     },
                    //     520: {
                    //         slidesPerView: 2,
                    //         spaceBetween: 15,
                    //     },
                    //     768: {
                    //         slidesPerView: 2,
                    //         spaceBetween: 30,
                    //     },
                    //     992: {
                    //         slidesPerView: 3,
                    //         spaceBetween: 30,
                    //     },
                    //     10000: {
                    //         slidesPerView: 4,
                    //         spaceBetween: 30,
                    //     }
                    // }
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
        var isOpenRateButton = false;
        var photographerPicsForAlbum = [];
        var sliderPicForAlbum = [];
        var sitePicsForAlbum = [];
        var userPhotosForAlbum = [];
        var userVideoForAlbum = [];
        var allPlacePics = [];

        photographerPics.map(item => {
            var arr = {
                'id': item['id'],
                'sidePic': item['l'],
                'mainPic': item['s'],
                'userPic': item['userPic'],
                'userName': item['name'],
                'picName': item['picName'],
                'like': item['like'],
                'dislike': item['dislike'],
                'alt': item['alt'],
                'description': item['description'],
                'uploadTime': item['fromUpload'],
                'showInfo': item['showInfo'],
                'userLike': item['userLike'],
            };
            photographerPicsForAlbum.push(arr);
        });
        sitePics.map(item => {
            var arr = {
                'id': item['id'],
                'sidePic': item['l'],
                'mainPic': item['s'],
                'userPic': item['userPic'],
                'userName': item['name'],
                'like': item['like'],
                'dislike': item['dislike'],
                'alt': item['alt'],
                'description': item['description'],
                'uploadTime': item['fromUpload'],
                'showInfo': item['showInfo'],
                'userLike': item['userLike'],
            };
            sitePicsForAlbum.push(arr);
        });
        sliderPics.map(item =>{
            var arr = {
                'id': item['id'],
                'sidePic': item['l'],
                'mainPic': item['s'],
                'userPic': item['userPic'],
                'userName': item['name'],
                'like': item['like'],
                'dislike': item['dislike'],
                'alt': item['alt'],
                'description': item['description'],
                'uploadTime': item['fromUpload'],
                'showInfo': item['showInfo'],
                'userLike': item['userLike'],
            };
            sliderPicForAlbum.push(arr);
            allPlacePics.push(arr);
        });
        userPhotos.map(item => {
            var arr = {
                'id': item['id'],
                'sidePic': item['pic'],
                'mainPic': item['pic'],
                'userPic': item['userPic'],
                'userName': item['username'],
                'uploadTime': item['time'],
                'showInfo': false,
            };
            userPhotosForAlbum.push(arr);
            allPlacePics.push(arr);
        });
        userVideo.map(item => {
            var arr = {
                id: item['id'],
                sidePic: item['picName'],
                mainPic: item['picName'],
                userPic: item['userPic'],
                userName: item['username'],
                video: item['video'],
                uploadTime: item['time'],
                showInfo: false,
            };
            userVideoForAlbum.push(arr);
            allPlacePics.push(arr);
        });

        if (sliderPics.length > 0) {
            var mainSlideSwiper = new Swiper('#mainSlider', {
                spaceBetween: 0,
                centeredSlides: true,
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                navigation: {
                    prevEl: '.swiper-button-next',
                    nextEl: '.swiper-button-prev',
                },
            });
        }
        else {
            $('.mainSliderNavBut').css('display', 'none');
            $('.see_all_count_wrap').css('display', 'none');
            text = `<div class="swiper-slide" style="overflow: hidden">
                        <img class="eachPicOfSlider resizeImgClass" src="{{URL::asset('images/mainPics/nopictext1.jpg')}}" style="width: 100%;">
                    </div>`;
            $('#mainSliderWrapper').append(text);
        }

        function getVideoFromTv(){
            $.ajax({
                type: 'get',
                url: `{{route('getVideosFromKoochitaTv')}}?id=${placeId}&kindPlaceId=${kindPlaceId}`,
                success: response => {
                    if(response.status == 'ok'){
                        var result = response.result;
                        var koochitaTvSectionElement = $('.koochitaTvSection');
                        koochitaTvSectionElement.find('.tvOverPic').removeClass('hidden');
                        koochitaTvSectionElement.find('.tvUserContentDiv').removeClass('hidden');
                        koochitaTvSectionElement.find('.tvVideoPic').removeClass('fullHeight');

                        koochitaTvSectionElement.find('.tvVideoPic').attr('href', result.url);
                        koochitaTvSectionElement.find('.tvUserName').text(result.username);
                        koochitaTvSectionElement.find('.tvUserTime').text(result.time);
                        $('.koochitaTvSeen').text(result.seen);
                        $('.koochitaTvDisLikeCount').text(result.disLike);
                        $('.koochitaTvLikeCount').text(result.like);
                        $('.koochitaTvImg').attr('src', result.pic);
                        $('.tvVideoName').attr('href', result.url).text(result.title);
                        $('.koochitaTvUserImg').attr('src', result.userPic);
                    }
                },
            })
        }
        getVideoFromTv();

        function openRateBoxForPlace(){
            if(!checkLogin())
                return;

            openMyModal('userRateToPlaceModal');
        }

        function ratingToPlace(_rate){
            for(var i = 1; i <= 5; i++){
                if(i <= _rate)
                    $(`.ratingStar${i}`).addClass('fullStarRating').removeClass('emptyStarRating').attr('data-selected', 1);
                else
                    $(`.ratingStar${i}`).addClass('emptyStarRating').removeClass('fullStarRating').attr('data-selected', 0);
            }
        }

        function submitRating(){
            var lastSelected = 0;
            for(var i = 5; i > 0; i--){
                if($(`.ratingStar${i}`).attr('data-selected') == 1){
                    lastSelected = $(`.ratingStar${i}`).attr('data-star');
                    break;
                }
            }

            if(lastSelected == 0)
                alert('برای ثبت امتیاز باید روی ستاره مورد نظر کلیک کنید');
            else{
                openLoading();
                $.ajax({
                    type: 'POST',
                    url: '{{route("places.setRateToPlaces")}}',
                    data:{
                        _token: '{{csrf_token()}}',
                        placeId: '{{$place->id}}',
                        kindPlaceId: '{{$kindPlaceId}}',
                        rate: lastSelected
                    },
                    complete: () => {
                        closeLoading()
                    },
                    success: response =>{
                        if(response.status == 'ok'){
                            updatePlaceRating(response.rates);
                            closeMyModal('userRateToPlaceModal');
                            showSuccessNotifi('امتیاز شما با موفقیت ثبت شد.', 'left', 'var(--koochita-blue)');
                        }
                        else if(response.status == 'error3')
                            alert('برای ثبت امتیاز باید روی ستاره مورد نظر کلیک کنید');
                        else
                            showSuccessNotifi('خطا در ثبت امتیاز', 'left', 'red');
                    },
                    error: err => showSuccessNotifi('خطا در ثبت امتیاز', 'left', 'red')
                })
            }
        }

        function updatePlaceRating(_rates){
            var totalRate = 0;
            var avg = Math.round(_rates.avg);
            var rates = _rates.rate;
            var elements = $('.placeRateStars');

            Object.keys(rates).forEach(key => totalRate += rates[key]);
            for(var i = 0; i < elements.length; i++){
                var lastAvg = $(elements[i]).attr('content');
                $(elements[i]).removeClass(`bubble_${lastAvg}0`).addClass(`bubble_${avg}0`);
                $(elements[i]).attr('content', avg);
            }

            Object.keys(rates).forEach(key => {
                var percent = (rates[key]*100/totalRate)+'%';
                $(`.ratePercent${key}`).text(percent);
                $(`.rateLine${key}`).css('width', percent);
            });
        }

        function changeTabBarColor(_elemnt, _section){
            if($(window).width() < 767){
                $('html, body').animate({
                    scrollTop: $(`#${_section}`).offset().top-100
                }, 300);
            }

            $('.tabLinkMainWrap').css('color', 'black');
            setTimeout(() => {
                $(_elemnt).css('color', 'var(--koochita-light-green)');
            }, 100)
        }

        function isPhotographer() {
            if (!checkLogin())
                return;

            //additionalData must be json format
            var additionalData = {
                'placeId': '{{$place->id}}',
                'kindPlaceId': '{{$kindPlaceId}}'
            };
            var _title = '{{$place->name}}' + ' در ' + '{{$city->name}}';
            additionalData = JSON.stringify(additionalData);
            openUploadPhotoModal(_title, '{{route('addPhotoToPlace')}}', '{{$place->id}}', '{{$kindPlaceId}}', additionalData);
        }

        function openCity(cityName, elmnt, color, fontColor) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabContent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tabLink");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].style.backgroundColor = "";
            }
            tablinks = document.getElementsByClassName("tabLink");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].style.color = "";
            }
            tablinks = document.getElementsByClassName("tabLink");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].style.borderColor = "";
            }
            document.getElementById(cityName).style.display = "block";
            elmnt.style.backgroundColor = color;
            elmnt.style.color = fontColor;
            elmnt.style.borderColor = fontColor;

        }

        function showAnswersActionBox(element) {
            $(element).next().toggle() ,
                $(element).toggleClass("bg-color-darkgrey")
        }

        function filterChoices(element) {
            $(element).toggleClass('bg-color-yellowImp')
        }

        function showPhotoAlbum(_kind) {
            console.log(_kind, sliderPics);
            if($(window).width() <= 767)
                createPhotoModal('آلبوم عکس', allPlacePics);// in general.photoAlbumModal.blade.php
            else {
                if (_kind == 'sliderPic' && sliderPicForAlbum.length > 0)
                    createPhotoModal('آلبوم عکس', sliderPicForAlbum);// in general.photoAlbumModal.blade.php
                if (_kind == 'photographer' && photographerPicsForAlbum.length > 0)
                    createPhotoModal('عکس های عکاسان', photographerPicsForAlbum);// in general.photoAlbumModal.blade.php
                else if (_kind == 'sitePics' && sitePicsForAlbum.length > 0)
                    createPhotoModal('عکس های سایت', sitePicsForAlbum);// in general.photoAlbumModal.blade.php
                else if (_kind == 'userPics' && userPhotosForAlbum.length > 0)
                    createPhotoModal('عکس های کاربران', userPhotosForAlbum);// in general.photoAlbumModal.blade.php
                else if (_kind == 'userVideo' && userVideoForAlbum.length > 0)
                    createPhotoModal('ویدیو های کاربران', userVideoForAlbum);// in general.photoAlbumModal.blade.php
            }
        }

        function addPlaceToBookMark() {

            if (!checkLogin())
                return;

            $.ajax({
                type: 'POST',
                url: '{{route("setBookMark")}}',
                data: {placeId, kindPlaceId},
                success: function (response) {
                    if (response == "ok-del"){
                        changeBookmarkIcon();
                        showSuccessNotifi('این صفحه از حالت ذخیره خارج شد', 'left', 'red');
                    }
                    else if(response == 'ok-add'){
                        changeBookmarkIcon();
                        showSuccessNotifi('این صفحه ذخیره شد', 'left', 'var(--koochita-blue)');
                    }
                }
            })
        }

        function addThisPlaceToTrip() {
            selectedPlaceId = placeId;
            selectedKindPlaceId = kindPlaceId;

            if(!checkLogin())
                return;

            saveToTripPopUp(placeId, kindPlaceId);
        }


        $(document).ready(() => {
            $('#allPlacePicturesCount').text(allPlacePics.length);
            autosize($(".inputBoxInputComment"));
            autosize($(".inputBoxInputAnswer"));

            if (window.matchMedia('(max-width: 373px)').matches)
                $('.eachCommentMainBox').removeClass('mg-rt-45');

            ratingToPlace(yourRateForThisPlace);
        });

        $(window).on('scroll', function(e){
            let topOfSticky = document.getElementById('BODYCON').getBoundingClientRect().top;
            if(topOfSticky < 20 && !$('#sticky').hasClass('stickyFixTop'))
                $('#sticky').addClass('stickyFixTop');
            else if(topOfSticky >= 25 && $('#sticky').hasClass('stickyFixTop'))
                $('#sticky').removeClass('stickyFixTop');

            $('.tabLinkMainWrap').css('color', 'black');

            var showWhatId = null;
            var sum = $(window).width() <= 767 ? 120 : 0;

            var topOfInfo = document.getElementById('generalDescLinkRel').getBoundingClientRect().top - sum;
            var topOfQA = document.getElementById('QAndAMainDivId').getBoundingClientRect().top - sum;
            var topOfPost = document.getElementById('mainDivPlacePost').getBoundingClientRect().top - sum;
            var topOfMap = document.getElementById('goToMapSection');
            var topOfSimilar = document.getElementById('topPlacesSection');
            var topOfRecipe = document.getElementById('recepieForFood');

            if(topOfSimilar){
                topOfSimilar = document.getElementById('topPlacesSection').getBoundingClientRect().top;
                if(topOfSimilar < 0)
                    showWhatId = 'similarLocationsBtnTopBar';
            }

            if(topOfQA < 0 && showWhatId == null)
                showWhatId = 'QAndAsBtnTopBar';

            if(topOfPost < 0 && showWhatId == null)
                showWhatId = 'postsBtnTopBar';

            if(topOfMap){
                topOfMap = document.getElementById('goToMapSection').getBoundingClientRect().top - sum;
                if(topOfMap < 0 && showWhatId == null)
                    showWhatId = 'mapBtnTopBar';
            }

            if(topOfRecipe){
                topOfRecipe = document.getElementById('recepieForFood').getBoundingClientRect().top - sum;
                if(topOfRecipe < 0 && showWhatId == null)
                    showWhatId = 'recipeDescBtnTopBar';
            }

            if(topOfInfo < 0 && showWhatId == null)
                showWhatId = 'generalDescBtnTopBar';

            if(showWhatId != null)
                $(`.${showWhatId}`).css('color', 'var(--koochita-light-green)');

            if($(window).width() <= 767){
                var indecTop = document.getElementById('indicForShowDown').getBoundingClientRect().top;
                indecTop += $('#indicForShowDown').height() - 110;
                if(indecTop < 0){
                    if(!isOpenRateButton && yourRateForThisPlace == 0){
                        isOpenRateButton = true;
                        $('.setScoreForThisPlaceComeUp').removeClass('hidden');
                        setTimeout(() => $('.setScoreForThisPlaceComeUp').addClass('open'), 100);
                    }
                    $('#comeDownHeader').addClass('show');
                }
                else
                    $('#comeDownHeader').removeClass('show');
            }
        });

    </script>
@stop

