@if(!Request::is('main') && !Request::is('main/*') && !Request::is('/'))
    <style>
        .headerSecondSection{
            display: none;
        }
        .mainHeader{
            background: var(--koochita-light-green);
        }
        .headerIconCommon:before{
            color: white;
        }
        .nameOfIconHeaders{
            color: white;
        }
        .headerAuthButton:hover .headerIconCommon:before{
            color: white;
        }
        .headerAuthButton:hover .nameOfIconHeaders{
            color: white;
        }
    </style>
@endif

    {{--pc header--}}
<div class="mainHeader hideOnPhone">
    <div class="container headerContainer">
        <a href="{{route('main')}}" class="headerPcLogoDiv" >
{{--            <img src="{{URL::asset('images/camping/undp.svg')}}" alt="{{__('کوچیتا')}}" class="headerPcLogo"/>--}}
            <img src="{{URL::asset('images/icons/mainLogo.png')}}" alt="{{__('کوچیتا')}}" class="headerPcLogo"/>
        </a>
        @if(Request::is('main') || Request::is('main/*') || Request::is('profile') || Request::is('profile/*') || Request::is('/') || Request::is('article/*'))
            <div class="headerSearchBar">
                <span class="headerSearchIcon iconFamily searchIcon" onclick="openMainSearch(0) // in mainSearch.blade.php"></span>
            </div>
        @else
            @if(isset($locationName['cityNameUrl']))
                <div class="mainHeaderSearch arrowAfter" onclick="openMainSearch(0)">
                    <span class="iconFamily searchIcon mirorIcon" style="font-size: 17px"></span>
                    {{$locationName['cityNameUrl']}}
                </div>
            @endif
        @endif

        <div class="headerButtonsSection">

            @if(Auth::check())
                <div id="languageIcon" class="headerAuthButton" title="{{__('زبان')}}">
                    <span class="headerIconCommon iconFamily languageIcon"></span>
                    <div class="nameOfIconHeaders">
                        فارسی
                    </div>
                    <div id="languageMenu" class="arrowTopDiv headerSubMenu">
                        <div class="headerBookMarkBody" style="padding-top: 0;">
                            <div id="authLanguageMenu" class="headerBookMarkContentDiv authLanguageMenu">
                                <a href="{{url('language/fa')}}" class="authLang" style="color: var(--koochita-light-green);">
                                    فارسی
                                </a>
                                <a href="{{url('language/en')}}" class="authLang">
                                    English
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="headerAuthButton" onclick="showCampingModal()">
                    <span class="headerIconCommon iconFamily addPostIcon"></span>
                    <div class="nameOfIconHeaders">
                        {{__('کمپین')}}
                    </div>
                </div>

                <div id="bookmarkicon" class="headerAuthButton" title="{{__('نشانه گذاری شده ها')}}">
                    <span class="headerIconCommon iconFamily BookMarkIconEmpty"></span>
                    <div class="nameOfIconHeaders">
                        {{__('نشون‌کرده')}}
                    </div>

                    <div id="bookmarkmenu" class="arrowTopDiv headerSubMenu">
                        <div class="headerBookMarkBody">
                            <div class="headerBookMarkHeader">
                                <a class="headerBookMarkHeaderName" href="{{route('profile')}}#bookMark" target="_self"> {{__('نشون کرده ها')}} </a>
                            </div>
                            <div id="bookMarksDiv" class="headerBookMarkContentDiv headerFooterBookMarkTab"></div>
                        </div>
                    </div>
                </div>

                <a href="{{route('myTrips')}}" class="headerAuthButton" title="{{__('سفرهای من')}}">
                    <span class="headerIconCommon iconFamily MyTripsIcon"></span>
                    <div class="nameOfIconHeaders">
                        {{__('سفرهای من')}}
                    </div>
                </a>

                <div class="notification-bell headerAuthButton">
                    <span class="headerIconCommon iconFamily MsgIcon"></span>
                    <div class="nameOfIconHeaders">
                        {{__('پیام‌ها')}}
                    </div>
                    <div class="headerAlertNumber newAlertNumber hidden">0</div>

                    <div id="alert" class="arrowTopDiv headerSubMenu ">
                        <div class="headerBookMarkBody">
                            <div class="headerBookMarkHeader">
                                <a class="headerBookMarkHeaderName" href="#" target="_self"> {{__('تمامی پیام ها')}}</a>
                            </div>
                            <div id="headerMsgPlaceHolder" class="alertMsgResultDiv" style="width: 300px; overflow-y: auto">
                                <div class="headerBookMarkLink">
                                    <div class="headerBookMarContentImgDiv">
                                        <div class="headerBookMarkPlaceholder placeHolderAnime"></div>
                                    </div>
                                    <div class="bookMarkContent" style="width: 90px">
                                        <div class="bookMarkContentTitle placeHolderAnime resultLineAnim" style="width: 100%"></div>
                                        <div class="bookMarkContentRating placeHolderAnime resultLineAnim" style="width: 100%"></div>
                                        <div class="bookMarkContentCity placeHolderAnime resultLineAnim" style="width: 100%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="memberTop" class="headerAuthButton">
                    <span class="headerIconCommon iconFamily UserIcon"></span>
                    <div class="nameOfIconHeaders">
                        {{\auth()->user()->username}}
                    </div>
                    <div>
                        <div id="profile-drop" class="arrowTopDiv headerAuthMenu">
                            <ul class="global-nav-profile-menu">
                                <li class="subItemHeaderNavBar">
                                    <a href="{{route('profile')}}" class="subLink" data-tracking-label="UserProfile_viewProfile">{{__('صفحه کاربری')}}</a>
                                </li>
{{--                                <li class="subItemHeaderNavBar">--}}
{{--                                    <a href="{{route('profile')}}#medal" class="subLink" data-tracking-label="UserProfile_viewProfile">{{__('جوایز و مدال ها')}}</a>--}}
{{--                                </li>--}}
                                <li class="subItemHeaderNavBar rule">
                                    <a href="{{route('profile.message.page')}}" class="subLink global-nav-submenu-divided" data-tracking-label="UserProfile_messages">{{__('پیام‌ها')}}</a>
                                </li>
                                <li class="subItemHeaderNavBar">
                                    <a href="{{route('profile.accountInfo')}}" class="subLink" data-tracking-label="UserProfile_settings">{{__('اطلاعات کاربر')}}</a>
                                </li>
                                <li class="subItemHeaderNavBar">
                                    <a href="{{route('logout')}}" class="subLink" data-tracking-label="UserProfile_signout">{{__('auth.خروج')}}</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            @else
                <div class="headerAuthButton" onclick="showCampingModal()" style="margin-left: 15px">
                    <span class="headerIconCommon iconFamily addPostIcon" style="height: 26px;"></span>
                    <div class="nameOfIconHeaders" style="line-height: 12px">
                        {{__('کمپین')}}
                    </div>
                </div>

                <div class="mainLoginButton languageButton">
                    <a style="color: var(--koochita-dark-green);" href="{{url('language/fa')}}">
                        فارسی
                    </a>
                    <div class="languagePopUp">
                        <a class="languageSelect" style="margin: 10px 0px" href="{{url('language/en')}}">English</a>
                    </div>
                </div>

                <div class="headerLoginHelper loginHelperSection hidden" onclick="closeLoginHelperSection()">
                    <div class="pic">
                        <div class="login-button mainLoginButton" style="font-size: 30px;margin-bottom: 20px;"> {{__('auth.ورود / ثبت نام')}}</div>
                        <img  alt="کوچیتا، سامانه جامع گردشگری ایران" src="{{URL::asset('images/icons/firstTimeRegisterMsg.svg')}}" style="width: 500px;">
                    </div>
                </div>

                <div class="login-button mainLoginButton" title="{{__('auth.ورود / ثبت نام')}}"> {{__('auth.ورود / ثبت نام')}}</div>

            @endif
        </div>
    </div>

    <div class="headerSecondSection">
        <div class="container headerSecondContainer">
            <div class="headerSecondContentDiv">
                <div class="headerSecondTabs">
                    <span class="headerSecondLi" onclick="openMainSearch(12)  // in mainSearch.blade.php">{{__('بوم گردی')}}</span>
                    <span class="headerSecondLi" onclick="openMainSearch(4)  // in mainSearch.blade.php">{{__('هتل')}}</span>
                    <span class="headerSecondLi" onclick="openMainSearch(3)  // in mainSearch.blade.php">{{__('رستوران')}}</span>
                    <span class="headerSecondLi" onclick="openMainSearch(1)  // in mainSearch.blade.php">{{__('جاذبه')}}</span>
                    <span class="headerSecondLi" onclick="openMainSearch(10)  // in mainSearch.blade.php">{{__('سوغات و صنایع‌دستی')}}</span>
                    <span class="headerSecondLi" onclick="openMainSearch(11)  // in mainSearch.blade.php">{{__('غذای محلی')}}</span>
                    <a href="{{route('safarnameh.index')}}" class="headerSecondLi">{{__('سفرنامه‌ها')}}</a>
                    <a href="{{route('news.main')}}" class="headerSecondLi">{{__('اخبار')}}</a>
                </div>
            </div>
        </div>
    </div>
</div>


{{--mobile header--}}
<div class="hideOnScreen mobileHeader">
    <a href="{{route('main')}}" class="global-nav-logo" style="height: 100%; display: flex; align-items: center">
{{--        <img src="{{URL::asset('images/camping/undp.svg')}}" alt="{{__('کوچیتا')}}" style="height: 50px; width: auto;"/>--}}
        <img src="{{URL::asset('images/icons/mainLogo.png')}}" alt="{{__('کوچیتا')}}" style="height: 80%; width: auto;"/>
    </a>
</div>

<div id="campingHeader" class="modalBlackBack" style="z-index: 999;  display: none">
    <div class="headerCampaignModalBody">
        <span class="iconClose closeLanding" onclick="$('#campingHeader').hide();"></span>
        <div class="headerCampingTop" onclick="goToLanding()">
{{--            <img  alt="کوچیتا، سامانه جامع گردشگری ایران" src="{{URL::asset('images/camping/undp.svg')}}" style="position: absolute; width: 60px; top: 10px; right: 2%;">--}}
            <img alt="کوچیتا، سامانه جامع گردشگری ایران" src="{{URL::asset('images/camping/' . app()->getLocale() . '/landing.webp')}}" class="resizeImgClass" style="width: 100%;" onload="fitThisImg(this)">
        </div>
        <div class="headerCampingBottom">
            <div onclick="writeNewSafaranmeh()">
                <img alt="کوچیتا، سامانه جامع گردشگری ایران" src="{{URL::asset('images/camping/' . app()->getLocale() . '/nSafarnameh.webp')}}" class="resizeImgClass" onload="fitThisImg(this)">
            </div>
            <div onclick="$('#campingHeader').hide(); openUploadPost()">
                <img alt="کوچیتا، سامانه جامع گردشگری ایران" src="{{URL::asset('images/camping/' . app()->getLocale() . '/nAxasi.webp')}}" class="resizeImgClass" onload="fitThisImg(this)">
            </div>
        </div>
    </div>
</div>

<script>
    var bookMarksData = null;

    var locked = false;
    var superAccess = false;
    var getRecentlyPath = '{{route('recentlyViewed')}}';
    var addPlaceByUserPageUrl = '{{route("addPlaceByUser.index")}}';
    var addPhotoToPlaceUrlHeader1 = "{{route('upload.photographer.uploadFile')}}";
</script>

<script src="{{URL::asset('js/pages/layout/header1.js?v='.$fileVersions)}}"></script>
