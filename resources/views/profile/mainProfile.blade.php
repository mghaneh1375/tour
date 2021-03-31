@extends('layouts.bodyPlace')

@section('title')
    <title> صفحه کاربری {{$user->username}}</title>

    @if(isset($sideInfos['userPicture']))
        <meta property="og:image" content="{{$sideInfos['userPicture']}}"/>
        <meta property="og:image:secure_url" content="{{$sideInfos['userPicture']}}"/>
        <meta name="twitter:image" content="{{$sideInfos['userPicture']}}"/>
        <meta property="og:image:width" content="550"/>
        <meta property="og:image:height" content="367"/>
    @endif
    <style>
        .myPageButtonsTop{
            display: flex;
            font-size: 12px;
        }
        .myPageButtonsTop a, .myPageButtonsTop button{
            width: 100px;
            text-align: center;
        }
        .mobileTabs .moreTabMenu{
            position: absolute;
            left: 13px;
            top: 55px;
            z-index: 9;
            background: #f2f2f2;
            text-align: center;
            font-size: 16px;
            padding: 2px 9px;
            border: solid 2px #f2f2f2;
            border-radius: 10px;
        }
        .mobileTabs .moreTabMenu .tabMenu{
            margin: 10px 0px;
            cursor: pointer;
        }

        .msgHeaderButton.searchButton.mobile{
            margin: 10px 1%;
            width: 98%;
            border: solid 1px gray;
            font-weight: bold;
            background: #d3d3d35c;
        }
    </style>
@stop

@section('meta')

@stop

@section('header')
    @parent

    <link rel="stylesheet" href="{{URL::asset('css/pages/profile.css?v1='.$fileVersions)}}">
@stop

@section('main')

    @include('component.safarnamehRow')

    <div class="userPostsPage">
        <div class="userProfilePageCoverImg" style="background-image: url('{{$user->banner}}'); background-size: cover; background-position: center">
            @if(isset($myPage) && $myPage)
                <div class="addPicForUser" style=" top: 10px; left: 15px;" onclick="openBannerModal()">
                    <span class="emptyCameraIcon addPicByUser"></span>
                </div>
            @endif
        </div>
        <div class="mainBodyUserProfile userPosts">
            <div class="mainDivContainerProfilePage">

                <div class="userPageBodyTopBar">
                    <div class="userPagePicSection">
                        <div class="circleBase profilePicUserProfile">
                            <img src="{{$sideInfos['userPicture']}}" class="resizeImgClass" style="width: 100%" onload="fitThisImg(this)">
                        </div>
                        <div class="followerHeaderSection hideOnScreen" onclick="openFollowerModal('resultFollowers', {{$user->id}}) // in general.followerPopUp.blade.php">
                            <span class="followerNumber" style="font-weight: bold">{{$followersUserCount}}</span>
                            <span style="font-size: 9px;">Followers</span>
                        </div>
                        @if(isset($myPage) && $myPage)
                            <div class="addPicForUser" style="top: 10px; right: 15px;" onclick="openEditPhotoModal()">
                                <span class="emptyCameraIcon addPicByUser"></span>
                            </div>
                        @endif
                    </div>

                    <div class="userProfileInfo">
                        <div>{{$user->username}}</div>
                        @if(isset($myPage) && $myPage)
                            <div class="myPageButtonsTop width50">
                                <a href="{{route('profile.accountInfo')}}" class="settingHeaderButton">
                                    <span>ویرایش</span>
                                    <span class="settingIcon"></span>
                                </a>
                                <a href="{{route("profile.message.page")}}" class="msgHeaderButton">
                                    صندوق پیام
                                    @if(isset($authUserInfos->newMsg) && $authUserInfos->newMsg > 0)
                                        <span class="newMsgCount">{{$authUserInfos->newMsg}}</span>
                                    @endif
                                </a>
                            </div>
                        @else
                            <div class="myPageButtonsTop">
                                <button class="msgHeaderButton followButton hideOnPhone {{$youFollowed != 0 ? 'followed' : ''}}" onclick="followUser(this, {{$user->id}})">
                                        <span class="addMemberIcon"></span>
                                        <span class="text"></span>
                                    </button>
                                @if(auth()->check())
                                    <a href="{{route("profile.message.page")}}?user={{$user->username}}" class="msgHeaderButton">ارسال پیام</a>
                                @else
                                    <div class="msgHeaderButton" onclick="checkLogin('{{route("profile.message.page")}}?user={{$user->username}}')">ارسال پیام</div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="postsMainFiltrationBar hideOnPhone">
                        <div class="" style="display: flex; justify-content: space-around; align-items: center; padding: 0px 5px 0px 0px; ">
                            <a id="reviewTab" href="#review" class="profileHeaderLinksTab" onclick="changePages('review')">
                                <span class="icon EmptyCommentIcon"></span>
                                <span class="text">پست‌ها</span>
                            </a>
                            <a id="photoTab" href="#photo" class="profileHeaderLinksTab" onclick="changePages('photo')">
                                <span class="icon emptyCameraIcon"></span>
                                <span class="text">عکس و فیلم</span>
                            </a>
                            <a id="questionTab" href="#question" class="profileHeaderLinksTab" onclick="changePages('question')">
                                <span class="icon questionIcon"></span>
                                <span class="text">سؤال‌ و جواب</span>
                            </a>
                            <a id="safarnamehTab" href="#safarnameh" class="profileHeaderLinksTab" onclick="changePages('safarnameh')">
                                <span class="icon safarnameIcon"></span>
                                <span class="text">سفرنامه ها</span>
                            </a>
                            <a id="medalsTab" href="#medal" class="profileHeaderLinksTab" onclick="changePages('medal')">
                                <span class="icon medalsIcon"></span>
                                <span class="text">جایزه و امتیاز</span>
                            </a>
                            <a id="followerTab" href="#" class="profileHeaderLinksTab" onclick="openFollowerModal('resultFollowers', {{$user->id}}) // in general.followerPopUp.blade.php">
                                <span class="icon twoManIcon"></span>
                                <span class="text">Followers</span>
                            </a>
                            @if(isset($myPage) && $myPage)
                                <a id="bookMarkTab" href="#bookMark" class="profileHeaderLinksTab" onclick="changePages('bookMark')" style="margin-left: 20px;">
                                    <span class="icon BookMarkIconEmpty"></span>
                                    <span class="text">نشان کرده</span>
                                </a>
                                <a id="festivalTab" href="#festival" class="profileHeaderLinksTab" onclick="changePages('festival')" style="margin-left: 20px;">
                                    <span class="icon festivalIcon"></span>
                                    <span class="text">فستیوال ها</span>
                                </a>
                            @endif
                        </div>
{{--                        <a href="#" class="profileHeaderLinksTab threeDotIcon"></a>--}}
                    </div>
                </div>

                <div class="profileMobileSection">
                    <div style="display: flex">
                        @if(!$myPage)
                            <button class="msgHeaderButton followButton helfInOtherUser mobile hideOnScreen {{$youFollowed != 0 ? 'followed' : ''}}" onclick="followUser(this, {{$user->id}})">
                                <span class="text"></span>
                            </button>
                        @endif
                        <button class="msgHeaderButton searchButton helfInOtherUser mobile searchIcon hideOnScreen" onclick="searchUserInMainProfile()">جستجوی دوستان</button>
                    </div>

                    <div class="bioSec">
                        <div class="mainDivHeaderText" onclick="showFullUserInfoInMobile(this)">
                            <h3>{{$user->username}}</h3>
                            <div class="downArrowIcon"></div>
                        </div>
                        <div class="bioContent">
                            <div class="bioText">
                                @if(isset($sideInfos['introduction']))
                                    {{$sideInfos['introduction']}}
                                @endif
                            </div>
                        </div>
                </div>
                    <div id="stickyProfileHeader" class="profileMobileStickHeader">
                        <div class="mobileTabs">
                            @if(isset($myPage) && $myPage)
                                <div id="moreMobileProfileTab" class="tab" onclick="openMoreTabProfileMobile()">
                                    <div class="icon threeDotIconVertical"></div>
                                    <div class="name"></div>
                                    <div class="bottomLine"></div>
                                </div>

                                <div id="myMenuMoreTab" class="moreTabMenu hidden">
                                    <div id="myMenuMoreTabQuestion" class="tabMenu" onclick="chooseFromMobileMenuTab('question', this)">سوال و جواب</div>
                                    <div id="myMenuMoreTabBookMark" class="tabMenu" onclick="chooseFromMobileMenuTab('bookMark', this)">نشان کرده</div>
                                    <div id="myMenuMoreFestivalMark" class="tabMenu" onclick="chooseFromMobileMenuTab('festival', this)">فستیوال</div>
                                </div>
                            @endif
                            <div id="safarnamehProfileMoblieTab" class="tab" onclick="mobileChangeProfileTab(this, 'safarnameh')">
                                <div class="icon safarnameIcon"></div>
                                <div class="name">سفرنامه</div>
                                <div class="bottomLine"></div>
                            </div>
                            <div id="medalProfileMoblieTab" class="tab" onclick="mobileChangeProfileTab(this, 'medal')">
                                <div class="icon medalsIcon"></div>
                                <div class="name">جوایز و مدال ها</div>
                                <div class="bottomLine"></div>
                            </div>
                            <div id="photoProfileMoblieTab" class="tab" onclick="mobileChangeProfileTab(this, 'photo')">
                                <div class="icon emptyCameraIcon"></div>
                                <div class="name">عکس و فیلم</div>
                                <div class="bottomLine"></div>
                            </div>
                            <div id="reviewProfileMoblieTab" class="tab selected" onclick="mobileChangeProfileTab(this, 'review')">
                                <div class="icon EmptyCommentIcon"></div>
                                <div class="name">پست</div>
                                <div class="bottomLine"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="userProfileSideInfos" class="userProfileDetailsMainDiv col-sm-4 col-xs-12 float-right hideOnPhone">
                    @if($sideInfos['introduction'] != null || count($sideInfos['tripStyle']) > 0 || $myPage)
                        <div class="userProfileLevelMainDiv rightColBoxes">
                            <div class="mainDivHeaderText">
                                <h3>بیو</h3>
                                @if(isset($myPage) && $myPage)
                                    <div onclick="sendAjaxRequestToGiveTripStyles()">ویرایش</div>
                                @endif
                            </div>
                            <div id="myIntroduction" class="userProfileBio">
                                @if($sideInfos['introduction'] != null)
                                    {{$sideInfos['introduction']}}
                                @elseif(isset($myPage) && $myPage)
                                    <div style="font-size: 14px; color: var(--koochita-blue); text-align: center; cursor: pointer" onclick="sendAjaxRequestToGiveTripStyles()">خودتان را به دیگران معرفی کنید.</div>
                                @endif
                            </div>
{{--                            <div id="myTripStyles" class="userProfileTagsSection">--}}
{{--                                @if(count($sideInfos['tripStyle']) == 0 && $sideInfos['introduction'] != null && isset($myPage) && $myPage)--}}
{{--                                    <div style="font-size: 14px; color: var(--koochita-blue); text-align: center; cursor: pointer" onclick="sendAjaxRequestToGiveTripStyles()">علایقتان را با ما در میان بگذارید و امتیاز بگیرید</div>--}}
{{--                                @else--}}
{{--                                    @foreach($sideInfos['tripStyle'] as $item)--}}
{{--                                        <div class="userProfileTags">{{$item->name}}</div>--}}
{{--                                    @endforeach--}}
{{--                                @endif--}}
{{--                            </div>--}}
                        </div>
                    @endif
                    <div class="userProfileLevelMainDiv rightColBoxes">
                        <div class="mainDivHeaderText">
                            <h3>سطح کاربر</h3>
                        </div>
                        <div class="userProfileLevelDetails">
                            <div class="levelIconDiv currentLevel">
                                <div class="upperBox">{{$sideInfos['nearLvl'][0]->name}}</div>
                                <div class="outer">
                                    <div class="inner"></div>
                                </div>
                            </div>
                            <div class="levelDetailsMainDiv" style="height: 45px;">
                                <div>سطح بعدی</div>
                                <div>سطح فعلی</div>
                            </div>
                            <div class="levelIconDiv nextLevel">
                                <div class="upperBox">{{$sideInfos['nearLvl'][1]->name}}</div>
                                <div class="outer">
                                    <div class="inner"></div>
                                </div>
                            </div>
                            <div class="w3-black">
                                <div class="w3-blue" style="width: {{$sideInfos['nearLvl'][1]['percent']}}%"></div>
                            </div>
                            <div style="text-align: center; font-size: 12px; margin-top: 30px;">
                                مشاهده سیستم سطح بندی
                            </div>
                        </div>
                    </div>
                    <div class="userProfileLevelMainDiv rightColBoxes" style="padding: 0px">
                        <div class="mainDivHeaderText">
                            <h3>امتیاز کاربر</h3>
                            <div>سیستم امتیاز دهی</div>
                        </div>
                        <div class="userProfileLevelDetails userProfileScoreSection">
                            <div  style="width: 49%; border-left: solid 1px gray;">
                                <div style="font-size: 17px; color: #656565; font-weight: bold"> {{__('امتیاز کل کاربر')}} </div>
                                <div class="points" style="color: #963019; font-size: 23px;">{{$sideInfos['userScore']}}</div>
                            </div>
                            <a href="#" style="width: 49%">
                                چگونه کسب درآمد کنیم؟
                            </a>
                        </div>
                    </div>
                    <div class="userProfileMedalsMainDiv rightColBoxes">
                        <div class="mainDivHeaderText">
                            <h3>مدال‌های افتخار</h3>
                            <div href="#medal" onclick="changePages('medal')">مشاهده همه</div>
                        </div>
                        <div class="medalsMainBox" style="direction: rtl; display: {{count($userMedals) == 0 ? 'none' : 'flex'}}">
                            @foreach($userMedals as $key => $medal)
                                @if($key < 3)
                                    <div class="medalsDiv">
                                        <img src='{{$medal->onPic}}' class="resizeImgClass" style="width: 100%" onload="fitThisImg(this)">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="userProfileActivitiesMainDiv rightColBoxes">
                        <div class="mainDivHeaderText">
                            <h3>شرح فعالیت‌ها</h3>
                            <div class="hideOnScreen" onclick="showUserActivity(this)">مشاهده</div>
                        </div>
                        <div class="activitiesMainDiv hideOnPhone">
                            <div class="activitiesLinesDiv">
                                <div class="activityTitle">گذاشتن پست</div>
                                <div class="activityNumbers">
                                    {{$sideInfos['userActivityCount']['postCount']}}
                                    پست
                                </div>
                            </div>
                            <div class="activitiesLinesDiv">
                                <div class="activityTitle">آپلود عکس</div>
                                <div class="activityNumbers">
                                    {{$sideInfos['userActivityCount']['picCount']}}
                                    عکس
                                </div>
                            </div>
                            <div class="activitiesLinesDiv">
                                <div class="activityTitle">آپلود فیلم</div>
                                <div class="activityNumbers">
                                    {{$sideInfos['userActivityCount']['videoCount']}}
                                    فیلم
                                </div>
                            </div>
                            <div class="activitiesLinesDiv">
                                <div class="activityTitle">آپلود فیلم 360</div>
                                <div class="activityNumbers">
                                    {{$sideInfos['userActivityCount']['video360Count']}}
                                    فیلم
                                </div>
                            </div>
                            <div class="activitiesLinesDiv">
                                <div class="activityTitle">پرسیدن سؤال</div>
                                <div class="activityNumbers">
                                    {{$sideInfos['userActivityCount']['questionCount']}}
                                    سؤال
                                </div>
                            </div>
                            <div class="activitiesLinesDiv">
                                <div class="activityTitle">پاسخ به سؤال دیگران</div>
                                <div class="activityNumbers">
                                    {{$sideInfos['userActivityCount']['ansCount']}}
                                    پاسخ سؤال
                                </div>
                            </div>
                            <div class="activitiesLinesDiv">
                                <div class="activityTitle">امتیازدهی</div>
                                <div class="activityNumbers">
                                    {{$sideInfos['userActivityCount']['scoreCount']}}
                                    مکان
                                </div>
                            </div>
                            <div class="activitiesLinesDiv">
                                <div class="activityTitle">پاسخ به سؤالات اختیاری</div>
                                <div class="activityNumbers">
                                    -
                                    پاسخ
                                </div>
                            </div>
                            <div class="activitiesLinesDiv">
                                <div class="activityTitle">ویرایش مکان</div>
                                <div class="activityNumbers">
                                    -
                                    مکان
                                </div>
                            </div>
                            <div class="activitiesLinesDiv">
                                <div class="activityTitle">پیشنهاد مکان جدید</div>
                                <div class="activityNumbers">
                                    {{$sideInfos['userActivityCount']['addPlace']}}
                                    مکان
                                </div>
                            </div>
                            <div class="activitiesLinesDiv">
                                <div class="activityTitle">نوشتن مقاله</div>
                                <div class="activityNumbers">
                                    -
                                    مقاله
                                </div>
                            </div>
                            <div class="activitiesLinesDiv">
                                <div class="activityTitle">معرفی دوستان</div>
                                <div class="activityNumbers">
                                    -
                                    معرفی
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="userProfilePicturesMainDiv rightColBoxes">
                        <div class="mainDivHeaderText">
                            <h3>عکس و تصاویر</h3>
                            <div href="#picture" onclick="changePages('photo'); window.showAllPic = 1; ">مشاهده همه</div>
                        </div>
                        <div class="picturesMainBox height-auto">
                            @foreach($sideInfos['allUserPics'] as $pic)
                                <div class="picturesDiv" data-toggle="modal">
                                    <img src="{{$pic['sidePic']}}" class="resizeImgClass" style="width: 100%" onload="fitThisImg(this)" onclick="showAllPicUser()">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div id="userProfileMainContentSection" class="userProfileActivitiesDetailsMainDiv userActivitiesArticles col-sm-8 col-xs-12">
                    <div id="reviewMainBody" class="prodileSections hidden">
                        @include('profile.innerParts.userPostsInner')
                    </div>

                    <div id="picMainBody" class="prodileSections hidden">
                        @include('profile.innerParts.userPhotosAndVideosInner')
                    </div>

                    <div id="questionMainBody" class="prodileSections hidden">
                        @include('profile.innerParts.userQuestionsInner')
                    </div>

                    <div id="safarnamehBody" class="prodileSections hidden">
                        @include('profile.innerParts.userSafarnameh')
                    </div>

                    <div id="medalBody" class="prodileSections hidden">
                        @include('profile.innerParts.userMedals')
                    </div>

                    <div id="bookMarkBody" class="prodileSections hidden">
                        @include('profile.innerParts.UserBookMarks')
                    </div>

                    <div id="festivalBody" class="prodileSections hidden">
                        @include('profile.innerParts.userFestivalInner')
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(isset($myPage) && $myPage)
        <div id="userTripStyle" class="modalBlackBack">
            <div class="userTripMainBody">
                <div class="closeFullReview iconClose" onclick="closeMyModal('userTripStyle');"></div>
                <div>
                    <div class="myTripHeaders">منو بشناس</div>
                    <div class="tripModalBody">
                        <textarea name="myBio" id="myBioInput" cols="30" rows="3" class="myBioInput" placeholder="خودتو تو 100 کلمه به بقیه معرفی کن...">{{$sideInfos['introduction']}}</textarea>
                    </div>
                </div>
                <div style="border-top: solid 1px #cccccc; margin-top: 10px; padding-top: 10px;">
                    <div class="myTripHeaders">من چه گردشگری هستم ؟</div>
                    <div>
                        <div id="myTripStyleSelectDiv" class="tripModalBody"></div>

                        <div class="bioClassSection">
                            <button class="saveBioButton" onclick="updateMyTripStyle()" >ذخیره تغییرات</button>
                            <button class="cancelBioButton" onclick="closeMyModal('userTripStyle');">لغو</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="userImages" class="modalBlackBack">
            <div class="userTripMainBody">
                <div class="closeFullReview iconClose" onclick="closeMyModal('userImages')"></div>
                <div>
                    <div class="myTripHeaders">تغییر عکس کاربری</div>
                    <div class="nowImg">
                        <input id="newImage" name="newPic" type="file" accept="image/*" style="display: none" onchange="changeUploadPic(this)">
                        <input type="text" id="uploadImgMode" name="id" style="display: none">

                        <div class="circleBase profilePicUserProfile">
                            <img id="changePic" src="{{$sideInfos['userPicture']}}" class="resizeImgClass" style="width: 100%" onload="fitThisImg(this)">
                        </div>
                        <button id="cropButton" class="cropProfileImg" onclick="openCropProfile()">برش عکس</button>
                    </div>

                    <div class="uploadSection">
                        <label for="newImage" class="newImageButton"> آپلود عکس </label>
                        <div class="oldBrowser">
                            عکس شما می‌بایست در فرمت‌های jpg یا png یا gif بوده و از 3MB بیشتر نباشید. حتما دقت کنید اندازه عکس 80*80 پیکسل باشد تا زیبا به نظر برسد. در غیر اینصورت ممکن است نتیجه نهایی باب میل شما نباشد.
                        </div>
                    </div>
                    <div class="orSec">
                        <span>یا</span>
                    </div>

                    <div id="ourPic" class="ourPic"></div>

                    <div class="bioClassSection">
                        <button class="saveBioButton" onclick="updateUserPic(true)" >ذخیره تغییرات</button>
                        <button class="cancelBioButton" onclick=" closeMyModal('userImages')">لغو</button>
                    </div>

                </div>
            </div>
        </div>

        <div id="userBannerModal" class="modalBlackBack">
            <div class="userTripMainBody">
                <div class="closeFullReview iconClose" onclick="closeMyModal('userBannerModal')"></div>
                <div>
                    <div class="myTripHeaders">تغییر عکس بنر</div>
                    <div class="nowImg">
                        <input id="newBannerImage" type="file" accept="image/*" style="display: none" onchange="changeUploadBannerPic(this)">

                        <div class="showBannerPic">
                            <img id="changeBannerPic" src="{{$user->banner}}" style="width: 100%">
                        </div>
                        <button id="cropBannerButton" class="cropProfileImg" onclick="openCropBanner()">برش عکس</button>
                    </div>

                    <div class="uploadSection">
                        <label for="newBannerImage" class="newImageButton"> آپلود عکس</label>
                    </div>
                    <div class="orSec">
                        <span>یا</span>
                    </div>

                    <div id="bannerPics" class="ourPic"></div>

                    <div class="bioClassSection">
                        <button class="saveBioButton" onclick="doUpdateBannerPic()" >ذخیره تغییرات</button>
                        <button class="cancelBioButton" onclick="closeMyModal('userBannerModal')">لغو</button>
                    </div>

                </div>
            </div>
        </div>

    @endif


    <script>
        var allUserPics = {!! json_encode($sideInfos['allUserPics']) !!};
        var selectedTrip = [];
        var userPageId = {{$user->id}};
        var userPageUsername = '{{$user->username}}';
        var openMobileMoreMenu = false;
        var defaultPics = null;
        var choosenPic = 0;
        var uploadedPic = null;
        var mainUploadedPic = null;

        let bannerPics = null;
        let bannerPicsHtml = '';
        let chosenBannerPic = null;
        let mainUploadedBanner = false;
        let uploadedBanner = false;
        let cropKind = null;
    </script>

    <script>
        $(window).on('scroll', () =>{
            let top = document.getElementById('stickyProfileHeader').getBoundingClientRect().top;
            let elem = $('.mobileTabs')[0];
            if(top > 0 && $(elem).hasClass('stickToTop'))
                $(elem).removeClass('stickToTop');
            else if(top <= 0 && !$(elem).hasClass('stickToTop'))
                $(elem).addClass('stickToTop');
        });

        $(window).on('click', () => {
            if(openMobileMoreMenu && !$('#myMenuMoreTab').hasClass('hidden'))
                $('#myMenuMoreTab').addClass('hidden');
        });

        $(window).on('ready', () => {
            autosize(document.getElementsByClassName("inputBoxInputSearch"));
            autosize(document.getElementsByClassName("inputBoxInputAnswer"));
            autosize(document.getElementsByClassName("inputBoxInputComment"));
        });

        searchUserInMainProfile = () => openKoochitaUserSearchModal('جستجوی دوستان', goToUserProfilePage, '');
        function goToUserProfilePage(_id, _username){
            openLoading();
            location.href = '{{url("profile/index")}}/'+_username
        }

        function showFullUserInfoInMobile(_elems) {
            $(_elems).parent().toggleClass('show');
        }

        function showAllPicUser(){
            createPhotoModal('عکس های شما', allUserPics);// in general.photoAlbumModal.blade.php
        }

        function showUserActivity(_element){
            $(_element).parent().next().toggleClass('hideOnPhone');
            if($(_element).text() == 'مشاهده')
                $(_element).text('بستن');
            else
                $(_element).text('مشاهده');
        }

        function sendAjaxRequestToGiveTripStyles() {
            openMyModal('userTripStyle');
            $.ajax({
                type: 'post',
                url: '{{route("getTripStyles")}}',
                data: {
                    uId: 0
                },
                success: function (response) {
                    var element = '';
                    selectedTrip = [];
                    response = JSON.parse(response);

                    for (i = 0; i < response.length; i++) {
                        element += `<div id="tripStyle_${response[i].id}" idValue="${response[i].id}" class="tripButton ${response[i].selected ? 'active' : ''}" onclick="selectThisTrip(this)">${response[i].name}</div>`;
                        if(response[i].selected)
                            selectedTrip.push(response[i].id+'')
                    }
                    $("#myTripStyleSelectDiv").html(element);
                }
            });
        }

        function selectThisTrip(_element){
            let id = $(_element).attr('idValue');
            $(_element).toggleClass('active');

            if(selectedTrip.indexOf(id) > -1)
                selectedTrip[selectedTrip.indexOf(id)] = 0;
            else
                selectedTrip.push(id);
        }

        function updateMyTripStyle() {
            let myBio = $('#myBioInput').val();

            $.ajax({
                type: 'post',
                url: '{{route("profile.updateMyBio")}}',
                data: {
                    tripStyles : selectedTrip,
                    myBio : myBio,
                },
                success: function (response) {
                    var text = '';
                    response = JSON.parse(response);
                    response.tripStyles.forEach(item => {
                        text += `<div class="userProfileTags">${item.name}</div>`;
                    })

                    $('#myIntroduction').text(response.introduction);
                    $('#myTripStyles').html(text);

                    closeMyModal('userTripStyle');
                }
            });
        }

        function changePages(_kind){
            $('.postsMainFiltrationBar').find('.active').removeClass('active');
            $('.prodileSections').addClass('hidden');

            if(_kind === 'review'){
                $('#reviewTab').addClass('active');
                $('#reviewMainBody').removeClass('hidden');
                mobileChangeProfileTab($('#reviewProfileMoblieTab'), 'review');
                getReviewsUserReview(); // in profile.innerParts.userPostsInner
            }
            else if(_kind === 'photo') {
                $('#photoTab').addClass('active');
                $('#picMainBody').removeClass('hidden');
                mobileChangeProfileTab($('#photoProfileMoblieTab'), 'photo');
                getAllUserPicsAndVideo();// in profile.innerParts.userPhotosAndVideosInner
            }
            else if(_kind === 'question') {
                $('#questionTab').addClass('active');
                $('#questionMainBody').removeClass('hidden');
                chooseFromMobileMenuTab('question', $('#myMenuMoreTabQuestion'));
                getAllUserQuestions();// in profile.innerParts.userQuestionsInner
            }
            else if(_kind === 'safarnameh') {
                $('#safarnamehTab').addClass('active');
                $('#safarnamehBody').removeClass('hidden');
                mobileChangeProfileTab($('#safarnamehProfileMoblieTab'), 'safarnameh');
                getSafarnamehs(); // in profile.innerParts.userSafarnameh
            }
            else if(_kind === 'medal') {
                $('#medalsTab').addClass('active');
                $('#medalBody').removeClass('hidden');
                mobileChangeProfileTab($('#medalProfileMoblieTab'), 'medal');
                getMedals(); // in profile.innerParts.userMedals
            }
            else if(_kind === 'bookMark') {
                $('#bookMarkTab').addClass('active');
                $('#bookMarkBody').removeClass('hidden');
                chooseFromMobileMenuTab('bookMark', $('#myMenuMoreTabBookMark'));
                getProfileBookMarks(); // in profile.innerParts.UserBookMarks
            }
            else if(_kind.search('festival') > -1) {
                $('#festivalTab').addClass('active');
                $('#festivalBody').removeClass('hidden');
                chooseFromMobileMenuTab('festival', $('#myMenuMoreFestivalMark'));
                getMainFestival(); // in profile.innerParts.userFestivalInner.blade.php

                var showFestival = _kind.split('id=');
                if(showFestival[1])
                    getFestivalMyWorks(showFestival[1]);
            }
        }

        function openMoreTabProfileMobile(){
            if($('#myMenuMoreTab').hasClass('hidden'))
                setTimeout(() => $('#myMenuMoreTab').removeClass('hidden'), 100);

            openMobileMoreMenu = true;
        }

        function chooseFromMobileMenuTab(_kind, _elem){
            $('#moreMobileProfileTab').find('.name').text($(_elem).text());
            mobileChangeProfileTab($('#moreMobileProfileTab'), _kind);
        }

        function mobileChangeProfileTab(_element, _kind){
            $(_element).parent().find('.selected').removeClass('selected');
            $(_element).addClass('selected');
            window.location.hash = '#'+_kind;

            if(_kind != 'question' && _kind != 'bookMark' && _kind != 'festival')
                $('#moreMobileProfileTab').find('.name').text('');

            $('.prodileSections').addClass('hidden');
            if(_kind == 'review'){
                $('#reviewMainBody').removeClass('hidden');
                getReviewsUserReview(); // in profile.innerParts.userPostsInner
            }
            else if(_kind == 'photo'){
                $('#picMainBody').removeClass('hidden');
                getAllUserPicsAndVideo();// in profile.innerParts.userPhotosAndVideosInner
            }
            else if(_kind == 'safarnameh'){
                $('#safarnamehBody').removeClass('hidden');
                getSafarnamehs(); // in profile.innerParts.userSafarnameh
            }
            else if(_kind == 'medal'){
                $('#medalBody').removeClass('hidden');
                getMedals(); // in profile.innerParts.userMedals
            }
            else if(_kind == 'question'){
                $('#questionMainBody').removeClass('hidden');
                getAllUserQuestions();// in profile.innerParts.userQuestionsInner
            }
            else if(_kind == 'bookMark'){
                $('#bookMarkBody').removeClass('hidden');
                getProfileBookMarks(); // in profile.innerParts.UserBookMarks
            }
            else if(_kind == 'festival'){
                $('#festivalBody').removeClass('hidden');
                getMainFestival(); // in profile.innerParts.userFestivalInner.blade.php
            }
        }

        function openEditPhotoModal(){
            if(defaultPics == null)
                getOurPic();
            openMyModal('userImages');
        }

        function getOurPic(){
            $.ajax({
                type: 'post',
                url: '{{route("getDefaultPics")}}',
                data: {
                    _token: '{{csrf_token()}}'
                },
                success: function(response){
                    response = JSON.parse(response);
                    defaultPics = response;
                    defaultPics.map((pic, index) => {
                        text =  '<div id="ourPic_' + index + '" class="oPs" onclick="chooseThisImg(' + index + ', this)"> \n' +
                                '   <img src="' + pic.name + '">\n' +
                                '</div>';
                        $('#ourPic').append(text);
                    })
                }
            })
        }

        function changeUploadPic(_input){
            if(_input.files && _input.files[0]){
                cleanImgMetaData(_input, function(imgDataURL, _files){ // in forAllPages.blade.php
                    $('#changePic').attr('src', imgDataURL);
                    mainUploadedPic = imgDataURL;
                    uploadedPic = _files;

                    choosenPic = 'uploaded';
                    $('#uploadImgMode').val(0);
                    $('#cropButton').show();
                });
            }
        }

        function chooseThisImg(_index, _element){
            $(_element).parent().find('.active').removeClass('active');
            $(_element).addClass('active');

            $('#changePic').attr('src', defaultPics[_index].name);
            choosenPic = defaultPics[_index].id;
            $("#uploadImgMode").val(defaultPics[_index].id);
            $('#newImage').val('');
            uploadedPic = null;
            mainUploadedPic = null;
            $('#cropButton').hide();
        }

        function updateUserPic(_resizeImg = false){
            openLoading(true, () => {

                let formDa = new FormData();
                formDa.append('_token', '{{csrf_token()}}');
                formDa.append('id', $('#uploadImgMode').val());

                if(choosenPic == 'uploaded') {
                    if(_resizeImg) {
                        resizeProfilePicUpload();
                        return;
                    }
                    formDa.append('pic', uploadedPic);
                }

                $.ajax({
                    type: 'POST',
                    url: '{{route("upload.profile.updateUserPhoto")}}',
                    data: formDa,
                    processData: false,
                    contentType: false,
                    xhr: function () {
                        let xhr = new XMLHttpRequest();
                        xhr.upload.onprogress = function (e) {
                            if (e.lengthComputable) {
                                percent = Math.round((e.loaded / e.total) * 100);
                                updatePercentLoadingBar(percent);
                            }
                        };
                        return xhr;
                    },
                    success: function(response){
                        if(response == 'ok')
                            location.reload();
                        else{
                            closeLoading();
                        }
                    },
                    error: function(err){
                        closeLoading();
                    }

                })
            });
        }

        function resizeProfilePicUpload() {
            var file = uploadedPic;

            if(file.type.match(/image.*/)) {
                var reader = new FileReader();
                reader.onload = function (readerEvent) {
                    console.log('img loaded');
                    var image = new Image();
                    image.onload = function (imageEvent) {
                        var canvas = document.createElement('canvas'),
                            max_size = 1080,// TODO : pull max size from a site config
                            width = image.width,
                            height = image.height;

                        if (width > height) {
                            if (width > max_size) {
                                height *= max_size / width;
                                width = max_size;
                            }
                        } else {
                            if (height > max_size) {
                                width *= max_size / height;
                                height = max_size;
                            }
                        }
                        canvas.width = width;
                        canvas.height = height;
                        canvas.getContext('2d').drawImage(image, 0, 0, width, height);
                        var dataUrl = canvas.toDataURL('image/jpeg');
                        uploadedPic = dataURLToBlob(dataUrl);
                        console.log('process complate');
                        updateUserPic(false);
                    };
                    image.src = readerEvent.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        function dataURLToBlob(dataURL) {
            var BASE64_MARKER = ';base64,';
            if (dataURL.indexOf(BASE64_MARKER) == -1) {
                var parts = dataURL.split(',');
                var contentType = parts[0].split(':')[1];
                var raw = parts[1];

                return new Blob([raw], {type: contentType});
            }

            var parts = dataURL.split(BASE64_MARKER);
            var contentType = parts[0].split(':')[1];
            var raw = window.atob(parts[1]);
            var rawLength = raw.length;

            var uInt8Array = new Uint8Array(rawLength);

            for (var i = 0; i < rawLength; ++i) {
                uInt8Array[i] = raw.charCodeAt(i);
            }

            return new Blob([uInt8Array], {type: contentType});
        }


        function openCropProfile(){
            openLoading();
            startProfileCropper('circle', 1, 'userPic');
        }

        function openBannerModal() {
            if(bannerPicsHtml == '')
                getBannerPic();
            openMyModal('userBannerModal');
        }

        function getBannerPic(){
            if(bannerPics == null) {
                $.ajax({
                    type: 'post',
                    url: '{{route("getBannerPics")}}',
                    data: {
                        _token: '{{csrf_token()}}'
                    },
                    success: function (response) {
                        $('#bannerPics').empty();
                        bannerPics = JSON.parse(response);
                        bannerPics.map((item, index) => {
                            bannerPicsHtml += '<div onclick="choseBannerPic(\'' + index + '\', this)" class="bannerPicItem"><img src="' + item.url + '"></div>';
                        });
                        $('#bannerPics').append(bannerPicsHtml);
                    },
                    error: function (err) {
                    }
                });
            }
        }

        function changeUploadBannerPic(_input){
            if(_input.files && _input.files[0]){
                cleanImgMetaData(_input, function(imgDataURL, _file){
                    $('#cropBannerButton').show();
                    uploadedBanner = true;
                    $('#changeBannerPic').attr('src', imgDataURL);
                    mainUploadedBanner = imgDataURL;
                    chosenBannerPic = _file;
                })
            }
        }

        function choseBannerPic(_index, _element){
            $(_element).parent().find('.active').removeClass('active');
            $(_element).addClass('active');

            chosenBannerPic = bannerPics[_index].name;
            uploadedBanner = false;

            $('#changeBannerPic').attr('src', bannerPics[_index].url);
        }

        function openCropBanner(){
            openLoading();
            startProfileCropper('req', 6, 'bannerPic');
        }

        function doUpdateBannerPic(){
            openLoading();

            let formDa = new FormData();
            formDa.append('_token', '{{csrf_token()}}');
            formDa.append('uploaded', uploadedBanner);
            formDa.append('pic', chosenBannerPic);

            $.ajax({
                type: 'post',
                url: '{{route('upload.profile.updateBannerPic')}}',
                data: formDa,
                processData: false,
                contentType: false,
                success: function(response){
                    closeLoading();
                    if(response.status == 'ok') {
                        closeMyModal('userBannerModal');
                        $('.userProfilePageCoverImg').css('background-image', `url(${response.url})`);
                    }
                },
                error: function(err){
                    closeLoading();
                }
            })
        }

        function startProfileCropper(_kind, _ratio, _sec){
            var im = _sec === 'userPic' ? mainUploadedPic : mainUploadedBanner;
            openCropImgModal(_ratio, im, (_blob, _file) => {
                if(_sec == 'userPic') {
                    $('#changePic').attr('src', _file);
                    $('#uploadImgMode').val(0);
                    uploadedPic = _blob;
                    choosenPic = 'uploaded';
                }
                else{
                    $('#changeBannerPic').attr('src', _file);
                    chosenBannerPic = _blob;
                    uploadedBanner = true;
                }
            }); // in cropImg.js
        }

        $(document).ready(() => {
            var url = new URL(location.href);
            if(url.hash === '')
                changePages('review');
            else if(url.hash != '')
                changePages(url.hash.replace("#", ""));
        })
    </script>
@stop
