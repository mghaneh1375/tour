<style>
    .submitFiltersInMobile{
        display: none;
    }

    @media (max-width: 767px) {
        .submitFiltersInMobile{
            display: block;
            position: absolute;
            bottom: 0px;
            background: var(--koochita-blue);
            color: white;
            width: 100%;
            right: 0px;
            text-align: center;
            padding: 5px 0px;
        }
    }
</style>
<div class="gapForMobileFooter hideOnScreen"></div>

<div class="footerPhoneMenuBar hideOnScreen">
    <div onclick="openMobileFooterPopUps('otherPossibilities');">
        <span class="footerMenuBarLinks">{{__('منو')}}</span>
        <span class="threeLineIcon"></span>
    </div>
    <div onclick="openMobileFooterPopUps('mainMenuFooter')" style="position: relative;">
        <span class="footerMenuBarLinks" style="direction: rtl;"> {{__('دیگه چه خبر...')}} </span>
        <span class="ui_icon questionIcon" style="font-size: 20px; font-weight: normal;"></span>
        <span class="newMsgMainFooterCount newAlertNumber hidden" style="left: 0; top: 5px;">0</span>
    </div>
    <div onclick="openMobileFooterPopUps('specialMenuMobileFooter');">
        <span class="footerMenuBarLinks">
           {{__('برنامه های ویژه')}}
        </span>
        <span class="iconFamily addPostIcon" style="font-size: 20px;"></span>
    </div>
    @if(Auth::check())
        <div class="profileBtn" style="flex-direction: column; position: relative" onclick="openMobileFooterPopUps('profileFooterModal')">
            <div class="profileBtnText">
                <span>صفحه من</span>
            </div>
            <div class="fullyCenterContent profilePicFooter circleBase type2">
                <img src="{{isset($authUserInfos->pic) ? $authUserInfos->pic : ''}}" class="resizeImgClass" onload="fitThisImg(this)" alt="user_picture">
            </div>
            @if($authUserInfos->newMsg > 0)
                <span class="newMsgMainFooterCount">{{$authUserInfos->newMsg}}</span>
            @endif
        </div>
    @else
        <div class="loginHelperSection footerLoginHelperSection hidden" onclick="closeLoginHelperSection()">
            <div class="login-button">
                <span class="footerMenuBarLinks" style="display: flex; align-items: center">
                    {{__('ورود')}}
                    <span class="iconFamily UserIcon" style="font-size: 20px; margin-left: 2px"></span>
                </span>
            </div>
            <div class="pic">
                <img alt="کوچیتا، سامانه جامع گردشگری ایران" src="{{URL::asset('images/icons/firstTimeRegisterMsg.svg')}}" style="width: 100%;">
            </div>
        </div>

        <div class="login-button">
                <span class="footerMenuBarLinks" style="display: flex; align-items: center">
                    {{__('ورود')}}
                    <span class="iconFamily UserIcon" style="font-size: 20px; margin-left: 2px"></span>
                </span>
        </div>
    @endif
</div>

<div class="container">

    <div id="mainMenuFooter" class="modalBlackBack closeWithClick footerModals" style="z-index: 1050;">
        <div class="mainPopUp rightPopUp recentViewLeftBar" style="overflow: hidden; transition: .3s;">
            {{--                <div class="closeFooterPopupIcon iconFamily iconClose" onclick="closeMobileFooterPopUps('mainMenuFooter')"></div>--}}
            {{--                <div class="footerLanguageDivPhone">--}}
            {{--                    <div class="footerLanguageTextPhone">زبان</div>--}}
            {{--                    <div class="footerLanguageInputPhone">--}}
            {{--                        <select class="chooseLanguagePhone" onchange="goToLanguage(this.value)">--}}
            {{--                            <option value="fa" selected>فارسی</option>--}}
            {{--                            <option value="en">English</option>--}}
            {{--                        </select>--}}
            {{--                    </div>--}}
            {{--                </div>--}}

            <div class="headerSearchBar">
                <span class="headerSearchIcon iconFamily footerSearchBar" style="background: var(--koochita-green); margin-left: 6px;" onclick="openMainSearch(0) // in mainSearch.blade.php">
                    <span class="icc searchIcon" style="word-spacing: -4px;">به کجا می روید؟</span>
                </span>
                <span class="headerSearchIcon footerSearchBar" style="background: var(--koochita-red);">
                    <a href="{{route('myLocation')}}" class="icc addressBarIcon" style="word-spacing: -4px;">اطراف من</a>
                </span>
            </div>

            <div style="height: calc(100% - 170px); overflow-y: auto">
                <div class="lp_others_content" id="lp_others_recentlyViews">
                    <div id="phoneRecentlyView" class="mainContainerBookmarked recentlyRowMainSearch" style="display: flex; flex-wrap: wrap;">
                        <div class="notInfoFooterModalImg" style="height: 95%;">
                            <div class="text">تازه کاری.....</div>
                            <img src="{{URL::asset('images/icons/notRecentlyKoochita.svg')}}" alt="cryKoochita" style="width: 100%;opacity: .3;">
                            <div class="text">بازدیدهای اخیرت رو اینجا ببین ...</div>
                        </div>
                    </div>
                </div>

                <div class="lp_others_content alertMsgResultDiv hidden" id="lp_others_messages">
                    <div class="notInfoFooterModalImg" style="height: 95%;">
                        <div class="text">ناراحتم.....</div>
                        <img src="{{URL::asset('images/icons/crykoochita.svg')}}" alt="cryKoochita" style="width: 70%;opacity: .3;">
                        <div class="text">فعالیتت کمه ، لایکی ، پیامی ...</div>
                    </div>
                </div>

                <div class="lp_others_content hidden" id="lp_others_mark">
                    <div class="mainContainerBookmarked headerFooterBookMarkTab" style="height: 100%; display: flex; flex-wrap: wrap; justify-content: space-between;">
                        <div class="notInfoFooterModalImg {{auth()->check() ? 'hidden' : ''}}">
                            <div class="text">جایی رو نشون نکردی...!!</div>
                            <img src="{{URL::asset('images/icons/notBookMark.svg')}}" alt="koochitaNotBookMark" style="width: 100%; opacity: .3; margin-right: 14px;">
                            <div class="text">بگرد ، نشون کن ، به کارت میاد...</div>
                        </div>

                        @if(auth()->check())
                            @for($i = 0; $i < 6; $i++)
                                <div class="bookMarkSSec">
                                    <div class="imgSec placeHolderAnime"></div>
                                    <div class="infoSec">
                                        <div class="type placeHolderAnime resultLineAnim" style="height: 20px"></div>
                                        <div class="name placeHolderAnime resultLineAnim"></div>
                                        <div class="state placeHolderAnime resultLineAnim"></div>
                                    </div>
                                </div>
                            @endfor
                        @endif
                    </div>
                </div>

                <div class="lp_others_content hidden" id="lp_others_myTravel" style="position: relative;">
                    <div id="emptyTripMobileFooter" class="notInfoFooterModalImg hidden">
                        <div class="text">برنامه سفرت چیه ؟</div>
                        <img src="{{URL::asset('images/icons/mytrip0.svg')}}" alt="سفر ندارید" style="width: 100%;opacity: .3;">
                        <div class="text">بیا برای یه سفر خوب برنامه ریزی کنیم.</div>
                    </div>
                    <div id="myTripsFooter" class="myTripFooter"></div>
                </div>
            </div>

            <div class="overallMobileFooterModal newMyTripFooterButton plusIconAfter suitCaseIcon hidden" onclick="createTripFromMobileFooter()">
                ایجاد سفر جدید
            </div>
            @if(auth()->check())
                <div class="overallMobileFooterModal seeAllBookMarkFooter BookMarkIconEmpty hidden" onclick="mobileFooterProfileButton('bookMark')">
                    تمام نشان کرده ها
                </div>
            @endif

            <div class="lp_phoneMenuBar">
                <div class="lp_eachMenu" onclick="lp_selectMenu('lp_others_myTravel', this)">
                    <div class="iconFamily MyTripsIcon lp_icons"></div>
                    <div>{{__('سفرهای من')}}</div>
                </div>
                <div class="lp_eachMenu" onclick="lp_selectMenu('lp_others_mark', this);">
                    <div class="lp_icons BookMarkIconEmpty"></div>
                    <div>{{__('نشون‌کرده')}}</div>
                </div>
                <div class="lp_eachMenu" onclick="lp_selectMenu('lp_others_messages', this);setSeenAlert(0, '')/**in forAllPages**/;">
                    <div class="lp_icons iconFamily MsgIcon"></div>
                    <div>{{__('چه خبر ...!')}}</div>
                    <span class="newMsgMainFooterCount newAlertNumber hidden" style="left: 0; top: 5px;">0</span>
                </div>
                <div class="lp_eachMenu lp_selectedMenu" onclick="lp_selectMenu('lp_others_recentlyViews', this)">
                    <div class="lp_icons iconFamily searchIcon"></div>
                    <div>{{__('بازدید اخیر')}}</div>
                </div>
            </div>
        </div>
    </div>

    @if(Request::is('placeList/*'))
        <div class="mobileFiltersButtonTabs hideOnScreen">
            <div class="minGombad sortListMobileFooter">
                <div class="gomb orders" onclick="selectingOrder(this, 'rate')">
                    <div class="topGomb fullStarRating"></div>
                    <div class="text">بهترین ها</div>
                </div>
                <div class="gomb orders" onclick="selectingOrder(this, 'review')">
                    <div class="topGomb CommentIcon" style="font-size: 30px;"></div>
                    <div class="text">بیشترین نظر</div>
                </div>
                <div class="gomb orders" onclick="selectingOrder(this, 'seen')">
                    <div class="topGomb">
                        <img class="offEye" src="{{URL::asset('images/icons/eye.svg')}}" style="width: 58%">
                        <img class="onEye" src="{{URL::asset('images/icons/eyeYellow.svg')}}" style="width: 58%">
                    </div>
                    <div class="text">پربازدیدها</div>
                </div>
            </div>
            <div class="tabs">
                <div class="tab filterIcon" onclick="openMyModal('placeListMobileFilter')">اعمال فیلتر</div>
                <div class="tab twoHouseIcon" onclick="openListSort(this)">مرتب سازی</div>
            </div>
        </div>
        <div id="placeListMobileFilter" class="modalBlackBack fullCenter" style="transition: .7s">
            <div class="gombadi">
                <div class="mobileFooterFilterPic" style="position: relative">
                    <img src="{{URL::asset('images/mainPics/amakenMobileFooter.jpg')}}" style="width: 100%">
                    <div class="gradientWhite">
                        <div class="closeThisModal iconClose" onclick="closeMyModal('placeListMobileFilter')"></div>
                    </div>
                </div>
                <div id="lp_ar_rightFilters" class="lp_ar_contentOfFilters fil">
                    <div class="filterBoxMobile filterBox">
                        <div class="filterBoxShadow">
                            <div class="clearAll" onclick="closeFilters(); closeMyModal('placeListMobileFilter');"> پاک کردن تمام فیلترها </div>
                            <div class="filtersRows">
                                <div class="filterShow"></div>
                            </div>
                            <div class="submitFiltersInMobile" onclick="closeMyModal('placeListMobileFilter')">اعمال فیلتر</div>
                        </div>
                    </div>
                    <div id="EATERY_FILTERS_CONT" class="eatery_filters">
                        {{--<div class="prw_rup prw_restaurants_restaurant_filters">--}}
                        {{--<div id="jfy_filter_bar_establishmentTypeFilters" class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">--}}
                        {{--<div class="filterGroupTitle">{{__('جستجو‌ی نام')}}</div>--}}
                        {{--<input id="p_nameSearch" class="hl_inputBox" placeholder="{{__('جستجو کنید')}}" onchange="nameFilterFunc(this.value)">--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        @if($kindPlace->id == 11)
                            <div class="prw_rup prw_restaurants_restaurant_filters">
                                <div id="jfy_filter_bar_establishmentTypeFilters" class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
                                    <div class="filterGroupTitle">{{__('جستجو براساس مواد اولیه')}}</div>
                                    <input id="p_foodMaterialSearch" class="hl_inputBox" placeholder="{{__('جستجو کنید')}}" onclick="openGlobalMaterialSearch()">
                                    <div class="youMaterialSearchResult materialSearchSelected"></div>
                                </div>
                            </div>
                            <script>
                                function openGlobalMaterialSearch(){
                                    createSearchInput('getGlobalInputMaterialSearchKeyUp', 'ماده اولبه مورد نظر خود را وارد کنید.');
                                }

                                function getGlobalInputMaterialSearchKeyUp(_element){
                                    searchForMaterial($(_element).val())
                                }
                            </script>
                        @endif

{{--                        <div class="prw_rup prw_restaurants_restaurant_filters">--}}
{{--                            <div id="jfy_filter_bar_establishmentTypeFilters"--}}
{{--                                 class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">--}}
{{--                                <div class="filterGroupTitle">{{__('امتیاز کاربران')}}</div>--}}
{{--                                <div class="filterContent ui_label_group inline" style="font-size: 12px;">--}}
{{--                                    <div class="filterItem lhrFilter filter selected squerRadioInputSec">--}}
{{--                                        <input onclick="rateFilterFunc(5, this)" type="radio" name="AVGrate" id="p_c5" value="5"/>--}}
{{--                                        <label for="p_c5" class="inputRadionSquer"></label>--}}
{{--                                        <div class="rating-widget" style="font-size: 1.2em; display: inline-block">--}}
{{--                                            <div class="prw_rup prw_common_location_rating_simple">--}}
{{--                                                <span class="ui_bubble_rating bubble_50"></span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="filterItem lhrFilter filter selected squerRadioInputSec">--}}
{{--                                        <input onclick="rateFilterFunc(4, this)" type="radio" name="AVGrate" id="p_c4" value="4"/>--}}
{{--                                        <label for="p_c4" class="inputRadionSquer"></label>--}}
{{--                                        <div class="rating-widget"--}}
{{--                                             style="font-size: 1.2em; display: inline-block">--}}
{{--                                            <div class="prw_rup prw_common_location_rating_simple">--}}
{{--                                                <span class="ui_bubble_rating bubble_40"></span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <span> {{__('به بالا')}}</span>--}}
{{--                                    </div>--}}
{{--                                    <div class="filterItem lhrFilter filter selected squerRadioInputSec">--}}
{{--                                        <input onclick="rateFilterFunc(3, this)" type="radio" name="AVGrate" id="p_c3" value="3"/>--}}
{{--                                        <label for="p_c3" class="inputRadionSquer"></label>--}}
{{--                                        <div class="rating-widget"--}}
{{--                                             style="font-size: 1.2em; display: inline-block">--}}
{{--                                            <div class="prw_rup prw_common_location_rating_simple">--}}
{{--                                                <span class="ui_bubble_rating bubble_30"></span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <span> {{__('به بالا')}}</span>--}}
{{--                                    </div>--}}
{{--                                    <div class="filterItem lhrFilter filter selected squerRadioInputSec">--}}
{{--                                        <input onclick="rateFilterFunc(2, this)" type="radio" name="AVGrate" id="p_c2" value="2"/>--}}
{{--                                        <label for="p_c2" class="inputRadionSquer"></label>--}}
{{--                                        <div class="rating-widget"--}}
{{--                                             style="font-size: 1.2em; display: inline-block">--}}
{{--                                            <div class="prw_rup prw_common_location_rating_simple">--}}
{{--                                                <span class="ui_bubble_rating bubble_20"></span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <span> {{__('به بالا')}}</span>--}}
{{--                                    </div>--}}
{{--                                    <div class="filterItem lhrFilter filter selected squerRadioInputSec">--}}
{{--                                        <input onclick="rateFilterFunc(1, this)" type="radio" name="AVGrate" id="p_c1" value="1"/>--}}
{{--                                        <label for="p_c1" class="inputRadionSquer"></label>--}}
{{--                                        <div class="rating-widget"--}}
{{--                                             style="font-size: 1.2em; display: inline-block">--}}
{{--                                            <div class="prw_rup prw_common_location_rating_simple">--}}
{{--                                                <span class="ui_bubble_rating bubble_10"></span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <span> {{__('به بالا')}}</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        @if($kindPlace->id == 4)
                            @include('pages.placeList.filters.hotelFilters')
                        @elseif($kindPlace->id == 10)
                            @include('pages.placeList.filters.sogatSanaieFilters')
                        @elseif($kindPlace->id == 11)
                            @include('pages.placeList.filters.mahaliFoodFilters')
                        @endif

                        @foreach($features as $feature)
                            <div class="prw_rup prw_restaurants_restaurant_filters">
                                <div class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
                                    <div class="filterHeaderWithClose">
                                        <div class="filterGroupTitle">{{$feature->name}}</div>
{{--                                        @if(count($feature->subFeat) > 5)--}}
{{--                                            <span onclick="showMoreItems({{$feature->id}})" class="moreItems{{$feature->id}} moreItems">{{__('نمایش کامل فیلترها')}}</span>--}}
{{--                                            <span onclick="showLessItems({{$feature->id}})" class="lessItems hidden extraItem{{$feature->id}} moreItems">{{__('پنهان سازی فیلتر‌ها')}}</span>--}}
{{--                                        @endif--}}
                                    </div>

                                    <div class="filterContent ui_label_group inline">
                                        @for($i = 0; $i < count($feature->subFeat); $i++)
                                            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                                                <input onclick="doFilterFeature({{$feature->subFeat[$i]->id}})" type="checkbox" id="p_feat{{$feature->subFeat[$i]->id}}" value="{{$feature->subFeat[$i]->name}}"/>
                                                <label for="p_feat{{$feature->subFeat[$i]->id}}" class="inputRadionSquer">
                                                    <span class="labelBox"></span>
                                                    <span class="name">{{$feature->subFeat[$i]->name}}</span>
                                                </label>
                                            </div>
                                        @endfor

{{--                                        @if(count($feature->subFeat) > 5)--}}
{{--                                            @for($i = 5; $i < count($feature->subFeat); $i++)--}}
{{--                                                <div class="filterItem lhrFilter filter hidden extraItem{{$feature->id}} squerRadioInputSec">--}}
{{--                                                    <input onclick="doFilterFeature({{$feature->subFeat[$i]->id}})" type="checkbox" id="p_feat{{$feature->subFeat[$i]->id}}" value="{{$feature->subFeat[$i]->name}}"/>--}}
{{--                                                    <label for="p_feat{{$feature->subFeat[$i]->id}}" class="inputRadionSquer">--}}
{{--                                                        <span class="labelBox"></span>--}}
{{--                                                        <span class="name">{{$feature->subFeat[$i]->name}}</span>--}}
{{--                                                    </label>--}}
{{--                                                </div>--}}
{{--                                            @endfor--}}
{{--                                        @endif--}}
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    @endif

    <div id="specialMenuMobileFooter" class="modalBlackBack closeWithClick footerModals" style="z-index: 1050;">
{{--        @if(Request::is('safarnameh/*') || Request::is('safarnameh'))--}}
{{--            <div class="mainPopUp rightPopUp" style="padding: 7px">--}}
{{--                <div class="lp_ar_searchTitle">{{__('جستجو خود را محدودتر کنید')}}</div>--}}

{{--                <div class="lp_ar_filters">--}}
{{--                    @if(Request::is('safarnameh/list/*'))--}}
{{--                        <div class="lp_ar_eachFilters lp_ar_rightFilters lp_ar_selectedMenu" onclick="lp_selectArticleFilter('lp_ar_rightFilters' ,this)" style="width: 100%; border-left: none">{{__('دسته‌بندی مطالب')}}</div>--}}
{{--                    @else--}}
{{--                        <div class="lp_ar_eachFilters lp_ar_rightFilters lp_ar_selectedMenu" onclick="lp_selectArticleFilter('lp_ar_rightFilters' ,this)">{{__('دسته‌بندی مطالب')}}</div>--}}
{{--                        <div class="lp_ar_eachFilters" onclick="lp_selectArticleFilter('lp_ar_leftFilters' ,this)">{{__('مطالب مشابه')}}</div>--}}
{{--                    @endif--}}
{{--                </div>--}}

{{--                <div id="lp_ar_rightFilters" class="lp_ar_contentOfFilters">--}}
{{--                    <div class="gnContentsCategory footerSafarnmaehCategoryRow">--}}
{{--                        <div class="mainSafarnamehCategory">--}}
{{--                            @foreach($category as $cat)--}}
{{--                                @if(count($cat->subCategory) > 0)--}}
{{--                                    <div class="safarnamehRow" onclick="showSafarnamehSubCategory({{$cat->id}})">--}}
{{--                                        <div class="next leftArrowIcon"></div>--}}
{{--                                        <div class="name">{{$cat->name}}</div>--}}
{{--                                    </div>--}}
{{--                                @else--}}
{{--                                    <a href="{{route('safarnameh.list', ['type' => 'category', 'search' => $cat->name])}}" class="safarnamehRow">--}}
{{--                                        <div class="name">{{$cat->name}}</div>--}}
{{--                                    </a>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                        <div class="subSafarnamehCategory">--}}
{{--                            @foreach($category as $cat)--}}
{{--                                <div id="subSafarnamehCategory_{{$cat->id}}" class="subSec">--}}
{{--                                    <div class="safarnamehRow back" onclick="backToSafarnamehCategoryFooter(this)">--}}
{{--                                        <div class="name" style="font-weight: bold">بازگشت</div>--}}
{{--                                        <div class="leftArrowIcon" style="color: white; font-size: 30px; line-height: 10px; width: 20px"></div>--}}
{{--                                    </div>--}}
{{--                                    @foreach($cat->subCategory as $item)--}}
{{--                                        <a href="{{route('safarnameh.list', ['type' => 'category', 'search' => $item->name])}}" class="safarnamehRow">--}}
{{--                                            <div class="name">{{$item->name}}</div>--}}
{{--                                        </a>--}}
{{--                                    @endforeach--}}
{{--                                </div>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="safarnamehSearchRowFooter">--}}
{{--                        <div class="header">--}}
{{--                            <div class="title">جستجو بر اساس</div>--}}
{{--                            <div class="tab selected" onclick="showSafarnamehFooterSearch(this, 'place')">مکان</div>--}}
{{--                            <div class="tab" onclick="showSafarnamehFooterSearch(this, 'text')">عبارت</div>--}}
{{--                        </div>--}}
{{--                        <div class="inputs">--}}
{{--                            <input type="text"--}}
{{--                                   id="safarnamehPlaceSearchFooter"--}}
{{--                                   class="safarnamehInput searchCityInArticleInput"--}}
{{--                                   placeholder="نام محل را وارد نمایید"--}}
{{--                                   readonly> --}}{{--open in safarnamehLayout.blade.php--}}
{{--                            <div id="safarnamehContentSearchFooter" style="display: none; background-color: #f2f2f2; position: relative; margin-top: 10px;">--}}
{{--                                <input type="text"--}}
{{--                                       id="safarnamehContentSF"--}}
{{--                                       class="safarnamehInput searchInputElemsText"--}}
{{--                                       placeholder="عبارت مورد نظر را وارد نمایید"--}}
{{--                                       style="margin: 0;">--}}
{{--                                <button class="iconFamily searchIcon" onclick="searchInArticle('safarnamehContentSF')// open in safarnamehLayout.blade.php"></button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                --}}{{--left menu--}}
{{--                <div id="lp_ar_leftFilters" class="lp_ar_contentOfFilters hidden">--}}
{{--                    @if(isset($similarSafarnameh))--}}
{{--                        @foreach($similarSafarnameh as $item)--}}
{{--                            <div class="content-2col">--}}
{{--                                <div class="im-entry-thumb" style="background-image: url('{{$item->pic}}'); background-size: 100% 100%;">--}}
{{--                                    <div class="im-entry-header">--}}
{{--                                        <div class="im-entry-category">--}}
{{--                                            <div class="iranomag-meta clearfix">--}}
{{--                                                <div class="cat-links im-meta-item">--}}
{{--                                                    <a class="im-catlink-color-2079" href="{{route('safarnameh.list', ['type' => 'category', 'search' => $item->category])}}">{{$item->category}}</a>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <a href="{{$item->url}}" rel="bookmark">--}}
{{--                                            <h1 class="im-entry-title" style="color: white;">--}}
{{--                                                {{$item->title}}--}}
{{--                                            </h1>--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="im-entry">--}}
{{--                                    <div class="im-entry-footer">--}}
{{--                                        <div class="iranomag-meta clearfix">--}}
{{--                                            <div class="posted-on im-meta-item">--}}
{{--                                                <span class="entry-date published updated">{{$item->date}}</span>--}}
{{--                                            </div>--}}
{{--                                            <div class="comments-link im-meta-item">--}}
{{--                                                <i class="fa fa-comment-o"></i>{{$item->msgs}}--}}
{{--                                            </div>--}}
{{--                                            <div class="author vcard im-meta-item">--}}
{{--                                                <i class="fa fa-user"></i>--}}
{{--                                                {{$item->username}}--}}
{{--                                            </div>--}}
{{--                                            <div class="post-views im-meta-item">--}}
{{--                                                <i class="fa fa-eye"></i>{{$item->seen}}--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endforeach--}}
{{--                    @elseif(isset($mostSeenPost))--}}
{{--                        <div class="widget widget_impv_display_widget ">--}}
{{--                            <div class="widget-head"><strong class="widget-title">--}}
{{--                                    {{__('پربازدیدترین ها')}}--}}
{{--                                </strong>--}}
{{--                                <div class="widget-head-bar"></div>--}}
{{--                                <div class="widget-head-line"></div>--}}
{{--                            </div>--}}
{{--                            <div id="impv_display_widget-4-tab2" class="widget_pop_body">--}}
{{--                                <ul class="popular_by_views_list">--}}
{{--                                    @foreach($mostSeenPost as $post)--}}
{{--                                        <li class="im-widget clearfix">--}}
{{--                                            <figure class="im-widget-thumb im-widget-thumb_rightSide">--}}
{{--                                                <a  href="{{route('safarnameh.show', ['id' => $post->id])}}" title="{{$post->title}}">--}}
{{--                                                    <img  alt="کوچیتا، سامانه جامع گردشگری ایران" src="{{$post->pic}}" alt="{{$post->keyword}}"/>--}}
{{--                                                </a>--}}
{{--                                            </figure>--}}
{{--                                            <div class="im-widget-entry im-widget-entry_rightSide">--}}
{{--                                                <header class="im-widget-entry-header">--}}
{{--                                                    <h4 class='im-widget-entry-title'>--}}
{{--                                                        <a  href="{{route('article.show', ['slug' => $post->slug])}}" title="{{$post->title}}">--}}
{{--                                                            {{$post->title}}--}}
{{--                                                        </a>--}}
{{--                                                    </h4>--}}
{{--                                                </header>--}}
{{--                                                <p class="im-widget-entry-footer">--}}
{{--                                                <div class="iranomag-meta clearfix">--}}
{{--                                                    <div class="posted-on im-meta-item">--}}
{{--                                                                <span class="entry-date published updated">--}}
{{--                                                                    {{$post->date}}--}}
{{--                                                                </span>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="post-views im-meta-item">--}}
{{--                                                        <i class="fa fa-eye"></i>--}}
{{--                                                        {{$post->seen}}--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                </p>--}}
{{--                                            </div>--}}
{{--                                        </li>--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @else--}}
            <div class="mainPopUp rightPopUp recentViewLeftBar" style="overflow: hidden; transition: .3s;">
                <div class="headerSearchBar">
                    <span class="headerSearchIcon iconFamily footerSearchBar" style="background: var(--koochita-green); margin-left: 6px;" onclick="openMainSearch(0) // in mainSearch.blade.php">
                        <span class="icc searchIcon" style="word-spacing: -4px;">به کجا می روید؟</span>
                    </span>
                    <span class="headerSearchIcon footerSearchBar" style="background: var(--koochita-red);">
                        <a href="{{route('myLocation')}}" class="icc addressBarIcon" style="word-spacing: -4px;">اطراف من</a>
                    </span>
                </div>
                <div style="height: calc(100% - 170px); overflow-y: auto">
                    <div id="specRowsPage" class="lp_others_content specPages" style="position: relative;">
                        <div class="specialFooterRow"  onclick="goToLanding()">
                            <img  alt="کوچیتا، سامانه جامع گردشگری ایران" src="{{URL::asset('images/camping/undp.svg')}}" style="position: absolute; width: 23px; top: 18px; right: 14px;">
                            <img alt="کوچیتا، سامانه جامع گردشگری ایران" src="{{URL::asset('images/camping/' . app()->getLocale() . '/landing.webp')}}" class="resizeImgClass" style="width: 100%;">
                        </div>
                        <div class="specialFooterRow" onclick="writeNewSafaranmeh()">
                            <img alt="koochitaCook" src="{{URL::asset('images/festival/cookFestival/gitcooking.webp')}}" class="resizeImgClass">
                        </div>
                        <div class="specialFooterRow" onclick="writeNewSafaranmeh()">
                            <img alt="کوچیتا، سامانه جامع گردشگری ایران" src="{{URL::asset('images/camping/' . app()->getLocale() . '/nSafarnameh.webp')}}" class="resizeImgClass">
                        </div>
                        <div class="specialFooterRow" onclick="$('#campingHeader').hide(); openUploadPost()">
                            <img alt="کوچیتا، سامانه جامع گردشگری ایران" src="{{URL::asset('images/camping/' . app()->getLocale() . '/nAxasi.webp')}}" class="resizeImgClass">
                        </div>
                    </div>

                    <div id="calendarRowPage" class="lp_others_content specPages hidden" style="position: relative;">
                        <div id="showMyCalTourism"></div>
                        <div id="showMyCalTourism1"></div>
                        @include('layouts.calendar')
                    </div>

                    <div id="translateRowsPage" class="lp_others_content specPages hidden" style="position: relative;"></div>
                </div>

                <div class="lp_phoneMenuBar">
                    <div class="lp_eachMenu specTabsFot" style="flex-direction: column;" onclick="specialMobileFooter('calendarRowPage', this)">
                        <div class="lp_icons calendarIconA"></div>
                        <div>{{__('تقویم گردشگری')}}</div>
                    </div>
                    <div class="lp_eachMenu specTabsFot lp_selectedMenu" onclick="specialMobileFooter('specRowsPage', this)">
                        <div class="lp_icons medalsIcon"></div>
                        <div>{{__('مسابقات')}}</div>
                    </div>
                    <div class="lp_eachMenu specTabsFot" onclick="specialMobileFooter('translateRowsPage', this)">
                        <div class="lp_icons earthIcon"></div>
                        <div>{{__('ترجمه')}}</div>
                        <span class="newMsgMainFooterCount newAlertNumber hidden" style="left: 0; top: 5px;">0</span>
                    </div>
                    <div class="lp_eachMenu specTabsFot" onclick="specialMobileFooter('translateRowsPage', this)">
                        <div class="lp_icons tvIcon"></div>
                        <div>{{__('ببینیم')}}</div>
                    </div>
                </div>
            </div>
{{--        @endif--}}
    </div>

    <div id="otherPossibilities" class="modalBlackBack closeWithClick footerModals" style="z-index: 1050;">
        <div class="mainPopUp rightPopUp" style="overflow-y: auto">
            <div class="headerSearchBar">
                <span class="headerSearchIcon iconFamily footerSearchBar" style="background: var(--koochita-green); margin-left: 6px;" onclick="openMainSearch(0) // in mainSearch.blade.php">
                    <span class="icc searchIcon" style="word-spacing: -4px;">به کجا می روید؟</span>
                </span>
                <span class="headerSearchIcon footerSearchBar" style="background: var(--koochita-red);">
                    <a href="{{route('myLocation')}}" class="icc addressBarIcon" style="word-spacing: -4px;">اطراف من</a>
                </span>
            </div>
            <div class="pSC_boxOfDetails" style="    height: calc(100% - 80px);">
                <div class="pSC_choiseDetailsText">
                        <span class="pSC_cityTilte" >
                            {{isset($locationName['cityNameUrl']) ? $locationName['cityNameUrl'] : 'ایران'}}
                        </span>
                    را بهتر بشناسید
                </div>
                <div>
                    @if(isset($locationName))
                        <div class="pSC_boxOfCityDetails" style="display: flex; flex-wrap: wrap;">
                            <a href="{{route('place.list', ['kindPlaceId' => 4, 'mode' => $locationName['kindState'], 'city' => $locationName['cityNameUrl'] ])}}"
                               class="pSC_cityDetails hotelIcon">
                                اقامتگاه های {{$locationName['cityNameUrl']}}
                            </a>
                            <a href="{{route('place.list', ['kindPlaceId' => 12, 'mode' => $locationName['kindState'], 'city' => $locationName['cityNameUrl']  ])}}"
                               class="pSC_cityDetails boomIcon">
                                بوم گردی های {{$locationName['cityNameUrl']}}
                            </a>
                            <a href="{{route('place.list', ['kindPlaceId' => 3, 'mode' => $locationName['kindState'], 'city' => $locationName['cityNameUrl']  ])}}"
                               class="pSC_cityDetails restaurantIcon">
                                رستوران های {{$locationName['cityNameUrl']}}
                            </a>
                            <a href="{{route('place.list', ['kindPlaceId' => 1, 'mode' => $locationName['kindState'], 'city' => $locationName['cityNameUrl']  ])}}"
                               class="pSC_cityDetails touristAttractions">
                                جاذبه های {{$locationName['cityNameUrl']}}
                            </a>
                            <a href="{{route('place.list', ['kindPlaceId' => 11, 'mode' => $locationName['kindState'], 'city' => $locationName['cityNameUrl']  ])}}"
                               class="pSC_cityDetails traditionalFood">
                                غذاهای محلی {{$locationName['cityNameUrl']}}
                            </a>
                            <a href="{{route('place.list', ['kindPlaceId' => 10, 'mode' => $locationName['kindState'], 'city' => $locationName['cityNameUrl']  ])}}"
                               class="pSC_cityDetails souvenirIcon">
                                صنایع دستی {{$locationName['cityNameUrl']}}
                            </a>
                            <a href="{{route('place.list', ['kindPlaceId' => 6, 'mode' => $locationName['kindState'], 'city' => $locationName['cityNameUrl']  ])}}"
                               class="pSC_cityDetails adventureIcon">
                                طبیعت گردی ‌های {{$locationName['cityNameUrl']}}
                            </a>
                            <a href="{{route('safarnameh.list', ['type' => $locationName['kindState'], 'search' => $locationName['cityNameUrl'] ])}}"
                               class="pSC_cityDetails safarnameIcon">
                                سفرنامه های {{$locationName['cityNameUrl']}}
                            </a>
                        </div>
                    @else
                        <div class="pSC_boxOfCityDetails" style="display: flex; flex-wrap: wrap;">
                            <a href="{{route('place.list', ['kindPlaceId' => 4, 'mode' => 'country'])}}" class="pSC_cityDetails hotelIcon">
                                اقامتگاه‌های ایران
                            </a>
                            <a href="{{route('place.list', ['kindPlaceId' => 12, 'mode' => 'country'])}}" class="pSC_cityDetails boomIcon">
                                بوم گردی های ایران
                            </a>
                            <a href="{{route('place.list', ['kindPlaceId' => 3, 'mode' => 'country'])}}" class="pSC_cityDetails restaurantIcon">
                                رستوران‌های ایران
                            </a>
                            <a href="{{route('place.list', ['kindPlaceId' => 1, 'mode' => 'country'])}}" class="pSC_cityDetails touristAttractions">
                                جاذبه‌‌های ایران
                            </a>
                            <a href="{{route('place.list', ['kindPlaceId' => 11, 'mode' => 'country'])}}" class="pSC_cityDetails traditionalFood">
                                غذاهای محلی ایران
                            </a>
                            <a href="{{route('place.list', ['kindPlaceId' => 10, 'mode' => 'country'])}}" class="pSC_cityDetails souvenirIcon">
                                صنایع دستی ایران
                            </a>
                            <a href="{{route('place.list', ['kindPlaceId' => 6, 'mode' => 'country'])}}" class="pSC_cityDetails adventureIcon">
                                طبیعت گردی های ایران
                            </a>
                            <a href="{{route('safarnameh.index')}}" class="pSC_cityDetails safarnameIcon">
                                سفرنامه
                            </a>
                        </div>
                    @endif
                </div>

                <div class="fullyCenterContent mobileFooterCategoryBottom">
                    <div class="headerSearchBar cityButtonsSec">
                        @if(isset($locationName['stateNameUrl']))
                            <a href="{{route('cityPage', ['kine' => 'state', 'city' => $locationName['stateNameUrl']])}}" class="headerSearchIcon footerSearchBar cityButton" style="margin-bottom: 6px;">
                                <div class="icc fullyCenterContent" style="word-spacing: -4px;  color: black;">
                                    <img src="{{URL::asset('images/icons/iranIcon.svg')}}" style="width: 20px">
                                    استان {{$locationName['stateNameUrl']}}
                                </div>
                            </a>
                        @endif
                        @if(isset($locationName['cityNameUrl']) && $locationName['kindState'] == 'city')
                            <a href="{{route('cityPage', ['kine' => 'city', 'city' => $locationName['cityNameUrl']])}}" class="headerSearchIcon footerSearchBar cityButton">
                                <div class="icc locationIcon" style="word-spacing: -4px;  color: black;">شهر {{$locationName['cityNameUrl']}}</div>
                            </a>
                        @endif
                    </div>
{{--                    <a href="https://koochitatv.com" class="pSC_cityDetails koochitaTvRowPhoneFooter" style="width: 49%;">--}}
{{--                        {{__('تلویزیون گردشگری')}}--}}
{{--                        <img src="{{URL::asset('images/mainPics/vodLoboMobile.webp')}}" alt="koochitatv" style="height: 25px; margin-bottom: 5px">--}}
{{--                    </a>--}}
                </div>
            </div>
        </div>
    </div>

    @if(auth()->check())
        <div id="profileFooterModal" class="modalBlackBack closeWithClick footerModals" style="z-index: 1050;">
            <div class="welcomeMsgModalFooter hidden" onclick="$(this).remove()">
                <a href="{{route("profile.message.page")}}" class="showMsgButton">
                    <div class="name">صندوق پیام</div>
                    <div class="num">0</div>
                </a>
                <img src="{{URL::asset('images/icons/thankyou0.svg')}}" alt="thankYou">
            </div>

            <div class="mainPopUp rightPopUp profileFooterPopUp">
                <div class="userInfoMobileFooterBody">
                    <div class="row" style="width: 100%; margin: 0px; flex-direction: column;">
                        <div class="firsLine">
                            <div class="pic">
                                <img src="{{isset($authUserInfos->pic) ? $authUserInfos->pic : ''}}" alt="userPic" class="resizeImgClass" onload="fitThisImg(this)"/>
                            </div>
                            <div class="infos">
                                <div class="inf">
                                    <div class="number">1</div>
                                    <div class="name">سطح کاربر</div>
                                </div>
                                <div class="inf">
                                    <div class="number">0</div>
                                    <div class="name">امتیاز</div>
                                </div>
                                <div class="inf" onclick="mobileFooterProfileButton('follower')">
                                    <div class="number">{{$authUserInfos->followerCount}}</div>
                                    <div class="name">دنبال کننده</div>
                                </div>
                            </div>
                        </div>
                        <div class="secondLine">{{auth()->user()->username}}</div>
                        <div class="buttonsLine">
                            <div class="mBLine bLine">
                                <div onclick="window.location.href='{{route("profile")}}'">
                                    <div class="name" style="font-size: 16px; font-weight: bold; color: gray">صفحه من</div>
                                </div>
                                <div onclick="window.location.href='{{route("profile.message.page")}}'">
                                    <div class="name" style="font-size: 16px; font-weight: bold; color: {{$authUserInfos->newMsg > 0 ? 'var(--koochita-red)' : ''}};">صندوق پیام</div>
                                    @if($authUserInfos->newMsg > 0)
                                        <div class="footerMsgCountNumber">{{$authUserInfos->newMsg}}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="mBLine bLine">
                                <div onclick="mobileFooterProfileButton('review')">
                                    <div class="icon EmptyCommentIcon"></div>
                                    <div class="name">پست ها</div>
                                </div>
                                <div onclick="mobileFooterProfileButton('photo')">
                                    <div class="icon emptyCameraIcon"></div>
                                    <div class="name">عکس و فیلم</div>
                                </div>
                                <div onclick="mobileFooterProfileButton('question')">
                                    <div class="icon questionIcon"></div>
                                    <div class="name">سوال و جواب</div>
                                </div>
                                <div onclick="mobileFooterProfileButton('safarnameh')">
                                    <div class="icon safarnameIcon"></div>
                                    <div class="name">سفرنامه ها</div>
                                </div>
                            </div>
                            <div class="mBLine bLine">
                                <div onclick="mobileFooterProfileButton('medal')">
                                    <div class="icon medalsIcon"></div>
                                    <div class="name">جایزه و امتیاز</div>
                                </div>
                                <div onclick="mobileFooterProfileButton('follower')">
                                    <div class="icon twoManIcon"></div>
                                    <div class="name" >دنبال کنندگان</div>
                                </div>
                                <div onclick="mobileFooterProfileButton('bookMark')">
                                    <div class="icon BookMarkIconEmpty" style="font-size: 26px;"></div>
                                    <div class="name">نشان کرده</div>
                                </div>
                                <div onclick="mobileFooterProfileButton('setting')">
                                    <div class="icon settingIcon"></div>
                                    <div class="name">تنظیمات</div>
                                </div>
                            </div>
                            <div class="mBLine bLine">
                                <div onclick="mobileFooterProfileButton('festival')">
                                    <div class="icon festivalIcon"></div>
                                    <div class="name">فستیوال</div>
                                </div>
                                <div onclick="window.location.href = '{{route("myTrips")}}'">
                                    <div class="icon MyTripsIcon"></div>
                                    <div class="name">سفرهای من</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profileScoreMainDiv">
                        <div class="memberPointInfo">
                            <div class="modules-membercenter-level-progress">
                                <div data-direction="left" id="targetHelp_9" class="targets progress_info tripcollectiveinfo">
                                    <div>
                                        <div class="labels">
                                            <div class="right label">{{__('مرحله فعلی')}}</div>
                                            <div class="float-leftImp label">{{__('مرحله بعدی')}}</div>
                                        </div>
                                        <div class="progress_indicator">

                                            <div class="next_badge myBadge">{{$authUserInfos->userLevel[0]->name}} </div>
                                            <div class="meter">
                                                <span id="progressIdPhone" class="progress"></span>
                                            </div>
                                            <div class="current_badge myBadge">{{$authUserInfos->userLevel[1]->name}} </div>
                                        </div>

                                        <div class="points_to_go" style="text-align: center; font-size: 10px;">
                                            <span style="color: var(--koochita-red); font-size: 14px"> {{$authUserInfos->nextLevel}} </span>
                                            امتیاز
                                            <span style="color: var(--koochita-red);">کم داری</span>
                                            تا مرحله
                                            <span style="color: var(--koochita-red);">بعد</span>
                                        </div>
{{--                                        <div class="text-align-center">--}}
{{--                                            <a class="cursor-pointer color-black">{{__('مشاهده سیستم سطح بندی')}}</a>--}}
{{--                                        </div>--}}
                                        <div class="clear fix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lp_phoneMenuBar">
                        <div class="lp_eachMenu" onclick="writeNewSafaranmeh()">
                            <img src="{{URL::asset('images/icons/addSafarnamehIcon.svg')}}" class="profileMobileFooterImg" alt="addSafarnameh">
                            <div>{{__('نوشتن سفرنامه')}}</div>
                        </div>
                        <div class="lp_eachMenu" onclick="openUploadPost()">
                            <img src="{{URL::asset('images/icons/addPhotoIcon.svg')}}" class="profileMobileFooterImg" alt="addPicture">
                            <div>{{__('افزودن عکس')}}</div>
                        </div>
                        <div class="lp_eachMenu" onclick="goToAddPlacePageInFooter()">
                            <img src="{{URL::asset('images/icons/koochit.svg')}}" class="profileMobileFooterImg" alt="koochitaSho">
                            <div>{{__('کوچیت کن')}}</div>
                        </div>
                        <div class="lp_eachMenu" onclick="mobileFooterProfileButton('setting')">
                            <div class="settingIcon lp_icons"></div>
                            <div>{{__('تنظیمات')}}</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endif
</div>

<script>
    var userSettingPageUrl = "{{route('profile.accountInfo')}}";
    var addPlaceByUserUrl = "{{route('addPlaceByUser.index')}}";
    var touchRigthForFooterMobile = 0;

    $('.footerModals').on('touchstart', e => {
        var touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
        touchRigthForFooterMobile = touch.pageX;
    });
    $('.footerModals').on('touchend', e => {
        var windowWidth = $(window).width();
        var touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
        if((touch.pageX - touchRigthForFooterMobile) > (windowWidth/3) ) {
            closeMyModalClass('footerModals');
            opnedMobileFooterId = null;
        }
    });

    $('.gombadi').on('click', e => {
        if($(e.target).hasClass('gombadi')) {
            closeMyModal($(e.target).parent().attr('id'));
        }
    });

    function openListSort(_element){
        $('.sortListMobileFooter').toggleClass('open');
        $(_element).toggleClass('selected');
    }

    function specialMobileFooter(_id, _element){
        resizeFitImg('resizeImgClass');
        $('.specPages').addClass('hidden');
        $(`#${_id}`).removeClass('hidden');

        $('.specTabsFot').removeClass('lp_selectedMenu');
        $(_element).addClass('lp_selectedMenu');
    }

    $(window).ready(() => {
        initMyCalendar('showMyCalTourism', [
            'ش',
            'ی',
            'د',
            'س',
            'چ',
            'پ',
            'ج',
        ]);
    })

</script>