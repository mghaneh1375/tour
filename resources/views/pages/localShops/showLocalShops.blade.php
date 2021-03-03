@extends('pages.localShops.localShopLayout')


@section('head')
    <title>کوچیتا | مغازه داران | {{isset($localShop->seoTitle) ? $localShop->seoTitle : $localShop->name}} </title>

    <meta content="article" property="og:type"/>
    <meta property="og:title" content="{{$localShop->seoTitle}}"/>
    <meta property="title" content="{{$localShop->seoTitle}}"/>
    <meta name="twitter:title" content="{{$localShop->seoTitle}}"/>
    <meta name="twitter:card" content="{{$localShop->meta}}"/>
    <meta name="description" content="{{$localShop->meta}}"/>
    <meta name="twitter:description" content="{{$localShop->meta}}"/>
    <meta name="keywords" content="{{$localShop->keyword}}">
    <meta property="og:description" content="{{$localShop->meta}}"/>
    <meta property="og:url" content="{{Request::url()}}"/>

    @if(isset($localShop->mainPic))
        <meta property="og:image" content="{{$localShop->mainPic}}"/>
        <meta property="og:image:secure_url" content="{{$localShop->mainPic}}"/>
        <meta name="twitter:image" content="{{$localShop->mainPic}}"/>
        <meta property="og:image:width" content="550"/>
        <meta property="og:image:height" content="367"/>
    @endif

    @if(isset($localShop->lat) && isset($localShop->lng))
        <meta NAME="geo.position" CONTENT="{{$localShop->lat}}; {{$localShop->lng}}">
    @endif

    @if(isset($localShop->tags ))
        @foreach($localShop->tags as $item)
            <meta property="article:tag" content="{{$item}}"/>
        @endforeach
    @endif


    <link rel="stylesheet" href="{{URL::asset('packages/leaflet/leaflet.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/pages/localShops/showLocalShops.css?v='.$fileVersions)}}">

@endsection

@section('body')
    <div id="topInfos" class="topInfoFixed">
        <div class="infosSec">
            <div class="info">
                <h1 style="font-weight: bold;">{{$localShop->name}}</h1>
                <div class="address"> {{$localShop->address}} </div>
            </div>
            <div class="fullyCenterContent pic" onclick="openAlbum('mainPics')" style="cursor: pointer">
                <img src="{{isset($localShop->mainPic->pic['f']) ? $localShop->mainPic->pic['f'] : $localShop->mainPic}}" class="resizeImgClass" onload="fitThisImg(this)">
            </div>
        </div>
        <div class="tabRow fastAccess">
            <div class="tab doubleQuet selected" onclick="goToSection('description')">
                <div class="text">توضیحات</div>
            </div>
            <div class="tab earthIcon" onclick="goToSection('map')">
                <div class="text">نقشه</div>
            </div>
            <div class="tab EmptyCommentIcon" onclick="goToSection('review')">
                <div class="text">دیدگاه شما</div>
            </div>
            <div class="tab questionIcon" onclick="goToSection('question')">
                <div class="text">سوال و جواب ها</div>
            </div>
        </div>

        <div class="mainHeaderButts" style="position: relative">
            <div class="fullyCenterContent emptyCameraIconAfter" onclick="addPictureToLocalShop()">
                <div class="text">گذاشتن عکس</div>
            </div>
            <div class="fullyCenterContent localShopPageBookMark  {{$localShop->bookMark == 1 ? 'BookMarkIconAfter' : 'BookMarkIconEmptyAfter'}}">
                <div class="text">نشان کردن</div>
            </div>
            <div id="topShareIcon" class="fullyCenterContent emptyShareIconAfter">
                <div class="text">اشتراک گذاری</div>
            </div>
            @include('layouts.shareBox', ['urlInThisShareBox' => Request::url(), 'idToClick' => 'topShareIcon'])

        </div>
    </div>


    <div class="showHeader">
        <div class="container">
            <div class="inff">
                <h1 style="font-weight: bold;">{{$localShop->name}}</h1>
                <div class="address">{{$localShop->address}}</div>
            </div>
            <div class="mainHeaderButts" style="position: relative;">
                <div class="phone telephoneIcon">
                    @foreach($localShop->telephone as $telephone)
                        <a href="tel:{{$telephone}}">{{$telephone}}</a>
                    @endforeach
                </div>

                <div class="fullyCenterContent emptyCameraIconAfter" onclick="addPictureToLocalShop()">
                    <div class="text">گذاشتن عکس</div>
                </div>
                <div class="fullyCenterContent localShopPageBookMark {{$localShop->bookMark == 1 ? 'BookMarkIconAfter' : 'BookMarkIconEmptyAfter'}}">
                    <div class="text">نشان کردن</div>
                </div>
                <div id="share_pic" class="fullyCenterContent emptyShareIconAfter">
                    <div class="text">اشتراک گذاری</div>
                </div>
                @include('layouts.shareBox', ['urlInThisShareBox' => Request::url(), 'idToClick' => 'share_pic'])
            </div>
        </div>
    </div>


    <div class="grayBackGround showBody">
        <div class="container">
            <div class="row">
                <div class="col-md-7 plPc-0">
                    <div id="mainSlider" class="mainSliderOfLocalShop fullyCenterContent bodySec imgSliderSec swiper-container">
                        <div class="swiper-wrapper">
                            @foreach($localShop->pics as $pic)
                                <div class="swiper-slide" style="overflow: hidden">
                                    <img src="{{$pic->pic['s']}}" alt="{{$localShop->name}}" class="resizeImgClass" onload="fitThisImg(this)" onclick="openAlbum('mainPics', {{$pic->id}})">
                                </div>
                            @endforeach
                        </div>
                        <div class="left-nav left-nav-header swiper-button-next mainSliderNavBut"></div>
                        <div class="right-nav right-nav-header swiper-button-prev mainSliderNavBut"></div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="bodySec infoSec">
                        <div class="iWasHere flagIcon {{$localShop->iAmHere == 1 ? 'selected' : ''}}" onclick="imAmHereFunc(this)">من اینجا بودم</div>
                        <div class="boldText">{{$localShop->name}}</div>
                        <div class="normText">{{$localShop->address}}</div>
                        <div class="phone telephoneIconAfter">
                            @foreach($localShop->telephone as $telephone)
                                <a href="tel:{{$telephone}}">{{$telephone}}</a>
                            @endforeach
                        </div>
                        <div class="groupSec">
                            <div class="boldText mr4bef clockIcon">ساعات کاری</div>
                            <div class="weekTime">
                                @if($localShop->isBoarding == 0)
                                    <div>
                                        <span>روزهای هفته:</span>
                                        <span>
                                            {{$localShop->inWeekOpenTime == null ? '' : $localShop->inWeekOpenTime}}
                                            تا
                                            {{$localShop->inWeekCloseTime == null ? '' : $localShop->inWeekCloseTime}}
                                        </span>
                                    </div>
                                    <div>
                                        <span>قبل تعطیلی:</span>
                                        @if($localShop->afterClosedDayIsOpen == 1)
                                        <span>
                                            {{$localShop->afterClosedDayOpenTime == null ? '' : $localShop->afterClosedDayOpenTime}}
                                            تا
                                            {{$localShop->afterClosedDayCloseTime == null ? '' : $localShop->afterClosedDayCloseTime}}
                                        </span>
                                        @else
                                            <span class="closse">تعطیل</span>
                                        @endif
                                    </div>
                                @else
                                    <div>
                                        <span style="color: green;">شبانه روزی</span>
                                    </div>
                                @endif
                                <div>
                                    <span>روزهای تعطیل:</span>
                                    @if($localShop->closedDayIsOpen == 1)
                                        <span>
                                            {{$localShop->closedDayOpenTime == null ? '' : $localShop->closedDayOpenTime}}
                                            تا
                                            {{$localShop->closedDayCloseTime == null ? '' : $localShop->closedDayCloseTime}}
                                        </span>
                                    @else
                                        <span class="closse">تعطیل</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{--the best localShop section--}}

{{--                        <div class="groupSec">--}}
{{--                            <div class="boldText mr4bef fullStarRating">انتخاب بهترین مغازه دار</div>--}}
{{--                            <div class="normText" style="padding: 0px 20px;">--}}
{{--                                آیا شما از مغازه و مغازه دار راضی بودید؟--}}
{{--                            </div>--}}
{{--                            <div class="ratingButtons">--}}
{{--                                <div class="likeSec" onclick="likeDisLikeShop(this, 1)">--}}
{{--                                    <div class="fullyCenterContent icon LikeIconEmpty">--}}
{{--                                        <span class="count">102</span>--}}
{{--                                    </div>--}}
{{--                                    <div class="fullyCenterContent result">--}}
{{--                                        <div>--}}
{{--                                            <span class="name">محلی : </span>--}}
{{--                                            <span class="num">100</span>--}}
{{--                                        </div>--}}
{{--                                        <div>--}}
{{--                                            <span class="name">غیر محلی : </span>--}}
{{--                                            <span class="num">32</span>--}}
{{--                                        </div>--}}
{{--                                        <div>--}}
{{--                                            <span class="name">نامشخص : </span>--}}
{{--                                            <span class="num">32</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="disLikeSec" onclick="likeDisLikeShop(this, -1)">--}}
{{--                                    <div class="fullyCenterContent icon DisLikeIconEmpty">--}}
{{--                                        <span class="count">243</span>--}}
{{--                                    </div>--}}
{{--                                    <div class="fullyCenterContent result">--}}
{{--                                        <div>--}}
{{--                                            <span class="name">محلی : </span>--}}
{{--                                            <span class="num">100</span>--}}
{{--                                        </div>--}}
{{--                                        <div>--}}
{{--                                            <span class="name">غیر محلی : </span>--}}
{{--                                            <span class="num">32</span>--}}
{{--                                        </div>--}}
{{--                                        <div>--}}
{{--                                            <span class="name">نامشخص : </span>--}}
{{--                                            <span class="num">32</span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                    </div>
                </div>
            </div>

{{--            <div class="row">--}}
{{--                <div class="col-md-12">--}}
{{--                    <div class="fullyCenterContent bodySec adver fullRow">تبلیغ</div>--}}
{{--                </div>--}}
{{--            </div>--}}

            <div id="stickyIndicator" class="row">
                <div class="col-md-12">
                    <div class="bodySec fastAccess">
                        <div class="tab doubleQuet selected" onclick="goToSection('description')">
                            <div class="text">توضیحات</div>
                        </div>
                        <div class="tab earthIcon" onclick="goToSection('map')">
                            <div class="text">نقشه</div>
                        </div>
                        <div class="tab EmptyCommentIcon" onclick="goToSection('review')">
                            <div class="text">دیدگاه شما</div>
                        </div>
                        <div class="tab questionIcon" onclick="goToSection('question')">
                            <div class="text">سوال و جواب ها</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="bodySec pad-15">
                        <h2 class="headerSec doubleQuet">توضیحات</h2>
                        <div class="descriptionBody" style="color: #636363;">{{$localShop->description}}</div>
                        <hr>
                        <div class="row">
                            <div class="col-md-8 featuresSection">
                                @foreach($localShop->features as $features)
                                    @if(count($features->subs) > 0)
                                        <div class="topFeatRow">
                                            <div class="featName">{{$features->name}}</div>
                                            <div class="subFeatSec">
                                                @foreach($features->subs as $sub)
                                                    <div class="subFeatName">{{$sub->name}}</div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <div class="col-md-4 ratingSection">
                                <h2 class="title">امتیاز کاربران</h2>
                                <div class="ratingStarsSection" onclick="openRateBoxForPlace()">
                                    <div class="emptyStarRating star"></div>
                                    <div class="emptyStarRating star"></div>
                                    <div class="emptyStarRating star"></div>
                                    <div class="emptyStarRating star"></div>
                                    <div class="emptyStarRating star"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
{{--                <div class="col-md-3">--}}
{{--                    <div class="fullyCenterContent bodySec adver sideMap">تبلیغ</div>--}}
{{--                    <div class="fullyCenterContent bodySec adver sideMap">تبلیغ</div>--}}
{{--                </div>--}}
{{--                <div class="col-md-9 prPc-0">--}}
{{--                    <div id="mapDiv" class="bodySec map"></div>--}}
{{--                </div>--}}
                <div class="col-md-12">
                    <div id="mapDiv" class="bodySec map"></div>
                </div>
            </div>

            <div class="row">
                <div id="inputReviewSec" class="col-md-12">
                    <div class="inputReviewBodies">
                        <div class="bodySec">
                            <h2 class="yourReviewHeader EmptyCommentIcon">
                                دیدگاه شما
                                <span class="iconClose" onclick="closeWriteReview()"></span>
                            </h2>
                            <div class="inputReviewSec">
                                <div class="firsRow">
                                    <div class="fullyCenterContent uPic50">
                                        <img src="{{$userPic}}" class="resizeImgClass" onload="fitThisImg(this)" style="width: 100%" >
                                    </div>
                                    <textarea class="autoResizeTextArea Inp" placeholder="کاربر چه فکر یا احساسی داری..." onclick="openWriteReview()" readonly></textarea>
                                </div>
                                <div class="searchYouFriendDiv" onclick="$('#friendSearchInput').focus()">
                                    <input type="text"
                                           placeholder="با چه کسانی بودید؟ نام کاربری را وارد نمایید"
                                           onclick="openWriteReview()"
                                           onkeyup="searchUserFriend(this)" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="bodySec">
                            <div class="reviewButs">
                                <label for="reviewPictureInput" class="but addPhotoIcon"  onclick="openWriteReview()"> عکس اضافه کنید.</label>
                                <label for="reviewVideoInput" class="but addVideoIcon"  onclick="openWriteReview()">ویدیو اضافه کنید.</label>
                                <label for="review360VideoInput" class="but addVideo360Icon"  onclick="openWriteReview()">ویدیو 360 اضافه کنید.</label>
                                <div class="but addFriendIcon" onclick="openWriteReview();">دوستنتان را TAG کنید.</div>

{{--                                <input type="file" id="reviewPictureInput" accept="image/png,image/jpeg,image/jpg,image/webp" style="display: none;">--}}
{{--                                <input type="file" id="reviewVideoInput" accept="video/*" style="display: none;" onclick="openWriteReview()">--}}
{{--                                <input type="file" id="review360VideoInput" accept="video/*" style="display: none;" onclick="openWriteReview()">--}}
                            </div>
                            <div class="reviewQues showWhenNeed" style="display: none;"></div>
                            <div class="reviewSubmit showWhenNeed" onclick="storeReview(this)">ارسال دیدگاه</div>
                            <div class="reviewSubmit showWhenNeed hidden" style="cursor: not-allowed">
                                <img src="{{URL::asset('images/icons/mGear.svg')}}" style="width: 30px; height: 30px;">
                                درحال ارسال دیدگاه
                            </div>
                        </div>
                    </div>

                    <div class="reviewShowSection">
                        <div id="showReviewsMain1"></div>
                        <div id="showReviewsMain2"></div>
                    </div>
                </div>
                <div class="col-md-4 hidden">
                    <div class="fullyCenterContent bodySec adver sideMap">تبلیغ</div>
                    <div class="fullyCenterContent bodySec adver sideMap">تبلیغ</div>
                </div>
{{--                <div class="col-md-8 reviewShowSection">--}}
{{--                    <div id="showReviewsMain1"></div>--}}
{{--                    <div id="showReviewsMain2"></div>--}}
{{--                </div>--}}
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="bodySec pad-15">
                        <h2 class="headerSec questionIcon">سوال و جواب</h2>
                        <div id="questionSection" class="questionBodies">
                            <div class="questionInfoText">
                                <div style="font-weight: bold; font-size: 1em;">سؤلات خود را بپرسید تا با کمک دوستانتان آگاهانه‌تر سفر کنید. همچنین می‌توانید با پاسخ یه سؤالات دوستانتان علاوه بر دریافت امتیاز، اطلاعات خود را به اشتراک بگذارید.</div>
                                <div style="margin-top: 12px; font-size: .85em;">
                                    <span>در حال حاضر</span>
                                    <span id="questionCount"></span>
                                    <span>سؤال</span>
                                    <span id="answerCount"></span>
                                    <span>پاسخ موجود می‌باشد.</span>
                                </div>
                            </div>
                            <div class="inputQuestionSec">
                                <div class="fullyCenterContent uPic50">
                                    <img src="{{$userPic}}" class="resizeImgClass" onload="fitThisImg(this)" style="width: 100%" >
                                </div>
                                <div class="inpQ">
                                    <textarea id="questionInput" class="autoResizeTextArea" placeholder="شما چه سوالی دارید؟"></textarea>
                                    <button onclick="sendQuestion(this)">ارسال</button>
                                    <div class="sendingQuestionLoading" style="display: none;" disabled>
                                        <img src="{{URL::asset('images/icons/mGear.svg')}}" style="width: 30px; height: 30px;">
                                        {{__('در حال ثبت سوال')}}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" style="direction: ltr;">
                    <div id="questionSectionDiv"></div>
                </div>
            </div>

        </div>
    </div>

    <div id="userRateToPlaceModal" class="userRateToPlaceModal modalBlackBack fullCenter">
        <div class="modalBody">
            <div class="topIcon">
                <img src="{{URL::asset('images/icons/koochitaPlaceRate.svg?v=1')}}" style="width: 88px">
            </div>
            <div class="header">امتیاز شما به {{$localShop->name}} چیست؟</div>
            <div class="body">
                <div class="starIcons emptyStarRating ratingStar1" data-star="1" data-selected="0" onclick="ratingToPlace(1)"></div>
                <div class="starIcons emptyStarRating ratingStar2" data-star="2" data-selected="0" onclick="ratingToPlace(2)"></div>
                <div class="starIcons emptyStarRating ratingStar3" data-star="3" data-selected="0" onclick="ratingToPlace(3)"></div>
                <div class="starIcons emptyStarRating ratingStar4" data-star="4" data-selected="0" onclick="ratingToPlace(4)"></div>
                <div class="starIcons emptyStarRating ratingStar5" data-star="5" data-selected="0" onclick="ratingToPlace(5)"></div>
            </div>
            <div class="footer">
                <button onclick="submitRating()">ثبت امتیاز</button>
            </div>
        </div>
    </div>


@endsection

@section('script')
{{--    <script async src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyCdVEd4L2687AfirfAnUY1yXkx-7IsCER0"></script>--}}

    <script defer type="text/javascript" src="{{URL::asset('packages/leaflet/leaflet.js')}}"></script>
    <script defer type="text/javascript" src="{{URL::asset('packages/leaflet/leaflet-wms-header.js')}}"></script>

    <script>

        var photographerUploadFileLocalShop = '{{route('photographer.uploadFile')}}';
        var getLocalShopReviewsUrl = '{{route("getReviews")}}';
        var setBookMarkInLocalShop = '{{route("setBookMark")}}';
        var askQuestionUrl = '{{route("askQuestion")}}';
        var getQuestionsUrl = '{{route("getQuestions")}}';
        var setRateToPlaceUrl = '{{route("places.setRateToPlaces")}}';
        var iAmHereLocalShopUrl = '{{route("localShop.addIAmHere")}}';

        var localShop = {!! $localShop !!};
        var newReview = {
            code: "{{$codeForReview}}",
            userAssigned: [],
            files: [],
        };

        var kindPlaceId = 13;
        var placeId = localShop.id;
        var questionPerPageNum = [-1];
    </script>

    <script defer src="{{URL::asset('js/pages/localShops/showLocalShop.js?v='.$fileVersions)}}"></script>
    <script defer src="{{URL::asset('js/component/getAndAskQuestionForPlaces.js?v='.$fileVersions)}}"></script>

@endsection
