<style>
    .submitFiltersInMobile{
        display: none;
    }
    .fontAwesomIconMFooter{
        color: var(--koochita-green);
        margin-left: 8px !important;
        width: 20px !important;
        font-size: 20px !important;
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
            <div class="login-button" style="z-index: 99;" onclick="closeLoginHelperSection()">
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

@if(Auth::check())
    <div class="addNewReviewButtonMobileFooter plus2 hideOnScreen" onclick="openModalWriteNewReview()">ایجاد پست</div>
@endif

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

            <div class="overallMobileFooterModal newMyTripFooterButton plusIconAfter suitCaseIcon hidden" onclick="createTripFromMobileFooter()"> ایجاد سفر جدید </div>
            @if(auth()->check())
                <div class="overallMobileFooterModal seeAllBookMarkFooter BookMarkIconEmpty hidden" onclick="mobileFooterProfileButton('bookMark')"> تمام نشان کرده ها </div>
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
                        @if($kindPlace->id == 4)
                            @include('pages.placeList.filters.hotelFilters')
                        @elseif($kindPlace->id == 10)
                            @include('pages.placeList.filters.sogatSanaieFilters')
                        @elseif($kindPlace->id == 11)
                            <div class="prw_rup prw_restaurants_restaurant_filters">
                                <div id="jfy_filter_bar_establishmentTypeFilters" class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
                                    <div class="filterGroupTitle">{{__('جستجو براساس مواد اولیه')}}</div>
                                    <input id="p_foodMaterialSearch" class="hl_inputBox" placeholder="{{__('جستجو کنید')}}" onclick="openGlobalMaterialSearch()">
                                    <div class="youMaterialSearchResult materialSearchSelected"></div>
                                </div>
                            </div>
                            @include('pages.placeList.filters.mahaliFoodFilters')
                        @elseif($kindPlace->id == 13)
                            @include('pages.placeList.filters.localShopFilters')
                        @endif

                        @foreach($features as $feature)
                            <div class="prw_rup prw_restaurants_restaurant_filters">
                                <div class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
                                    <div class="filterHeaderWithClose">
                                        <div class="filterGroupTitle">{{$feature->name}}</div>
                                    </div>

                                    <div class="filterContent ui_label_group inline">
                                        @foreach($feature->subFeat as $sub)
                                            <div class="filterItem lhrFilter filter selected squerRadioInputSec">
                                                <input id="p_feat{{$sub->id}}" class="featurePlaceListInput_{{$sub->id}}" type="checkbox" value="{{$sub->name}}" onclick="doFilterFeature({{$sub->id}})"/>
                                                <label for="p_feat{{$sub->id}}" class="inputRadionSquer">
                                                    <span class="labelBox"></span>
                                                    <span class="name">{{$sub->name}}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="featureListSection"></div>

                    </div>

                </div>
            </div>
        </div>
    @endif

    <div id="specialMenuMobileFooter" class="modalBlackBack closeWithClick footerModals" style="z-index: 1050;">
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
                    <div class="specialFooterRow" onclick="goToCookFestival()">
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
{{--                    <div id="showMyCalTourism"></div>--}}
{{--                    <div id="showMyCalTourism1"></div>--}}
{{--                    @include('layouts.calendar')--}}
                </div>

                <div id="translateRowsPage" class="lp_others_content specPages hidden" style="position: relative;"></div>

                <div id="koochitaTvMFooterPage" class="lp_others_content specPages hidden" style="position: relative;"></div>
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
                <div class="lp_eachMenu specTabsFot" onclick="specialMobileFooter('koochitaTvMFooterPage', this)">
                    <div class="lp_icons tvIcon"></div>
                    <div>{{__('ببینیم')}}</div>
                </div>
            </div>
        </div>
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
                            <a href="{{route('place.list', ['kindPlaceId' => 14, 'mode' => 'country'])}}" class="pSC_cityDetails">
                                <i class="fas fa-wine-glass-alt fontAwesomIconMFooter"></i>
                                نوشیدنی ها
                            </a>
                            <a href="{{route('place.list', ['kindPlaceId' => 10, 'mode' => $locationName['kindState'], 'city' => $locationName['cityNameUrl']  ])}}"
                               class="pSC_cityDetails souvenirIcon">
                                صنایع دستی {{$locationName['cityNameUrl']}}
                            </a>
                            <a href="{{route('place.list', ['kindPlaceId' => 6, 'mode' => $locationName['kindState'], 'city' => $locationName['cityNameUrl']  ])}}"
                               class="pSC_cityDetails adventureIcon">
                                طبیعت گردی ‌های {{$locationName['cityNameUrl']}}
                            </a>
                            <a href="#" class="pSC_cityDetails">
                                <i class=" fas fa-mug-hot fontAwesomIconMFooter"></i>
                                کافه های {{$locationName['cityNameUrl']}}
                            </a>
                            <a href="{{route('place.list', ['kindPlaceId' => 13, 'mode' => $locationName['kindState'], 'city' => $locationName['cityNameUrl']  ])}}" class="pSC_cityDetails fullWalletIcon"> فروشگاه های {{$locationName['cityNameUrl']}}</a>

                            <a href="{{route('safarnameh.list', ['type' => $locationName['kindState'], 'search' => $locationName['cityNameUrl'] ])}}" class="pSC_cityDetails safarnameIcon">
                                سفرنامه های {{$locationName['cityNameUrl']}}
                            </a>
                            <a href="{{route('news.main')}}" class="pSC_cityDetails">
                                <i class="far fa-newspaper fontAwesomIconMFooter"></i>
                                اخبار
                            </a>

                            <a href="https://koochitatv.com" class="pSC_cityDetails">
                                <i class=" fas fa-tv fontAwesomIconMFooter"></i>
                                کوچیتا TV
                            </a>
                        </div>
                    @else
                        <div class="pSC_boxOfCityDetails" style="display: flex; flex-wrap: wrap;">
                            <a href="{{route('place.list', ['kindPlaceId' => 4, 'mode' => 'country'])}}" class="pSC_cityDetails hotelIcon">اقامتگاه‌های ایران</a>
                            <a href="{{route('place.list', ['kindPlaceId' => 12, 'mode' => 'country'])}}" class="pSC_cityDetails boomIcon">بوم گردی های ایران</a>
                            <a href="{{route('place.list', ['kindPlaceId' => 3, 'mode' => 'country'])}}" class="pSC_cityDetails restaurantIcon">رستوران‌های ایران</a>
                            <a href="{{route('place.list', ['kindPlaceId' => 1, 'mode' => 'country'])}}" class="pSC_cityDetails touristAttractions">جاذبه‌‌های ایران</a>
                            <a href="{{route('place.list', ['kindPlaceId' => 11, 'mode' => 'country'])}}" class="pSC_cityDetails traditionalFood"> غذاهای محلی ایران</a>
                            <a href="{{route('place.list', ['kindPlaceId' => 14, 'mode' => 'country'])}}" class="pSC_cityDetails">
                                <i class="fas fa-wine-glass-alt fontAwesomIconMFooter"></i>
                                نوشیدنی ها
                            </a>
                            <a href="{{route('place.list', ['kindPlaceId' => 10, 'mode' => 'country'])}}" class="pSC_cityDetails souvenirIcon"> صنایع دستی ایران</a>
                            <a href="{{route('place.list', ['kindPlaceId' => 6, 'mode' => 'country'])}}" class="pSC_cityDetails adventureIcon">طبیعت گردی های ایران</a>
                            <a href="#" class="pSC_cityDetails">
                                <i class=" fas fa-mug-hot fontAwesomIconMFooter"></i>
                                کافه های ایران
                            </a>
                            <a href="{{route('place.list', ['kindPlaceId' => 13, 'mode' => 'country'])}}" class="pSC_cityDetails fullWalletIcon"> فروشگاه های ایران</a>
                            <a href="{{route('safarnameh.index')}}" class="pSC_cityDetails safarnameIcon">سفرنامه</a>
                            <a href="{{route('news.main')}}" class="pSC_cityDetails">
                                <i class="far fa-newspaper fontAwesomIconMFooter"></i>
                                اخبار
                            </a>

                            <a href="https://koochitatv.com" class="pSC_cityDetails">
                                <i class=" fas fa-tv fontAwesomIconMFooter"></i>
                                کوچیتا TV
                            </a>
                        </div>
                    @endif
                </div>

                <div class="fullyCenterContent mobileFooterCategoryBottom">
                    <div class="headerSearchBar cityButtonsSec">
                        @if(isset($locationName['stateNameUrl']))
                            <a href="{{route('cityPage', ['kind' => 'state', 'city' => $locationName['stateNameUrl']])}}" class="headerSearchIcon footerSearchBar cityButton" style="margin-bottom: 6px;">
                                <div class="icc fullyCenterContent" style="word-spacing: -4px;  color: black;">
                                    <img src="{{URL::asset('images/icons/iranIcon.svg')}}" style="width: 20px">
                                    استان {{$locationName['stateNameUrl']}}
                                </div>
                            </a>

                            <script>
                                $('.pSC_boxOfDetails').css('height', 'calc(100% - 175px)');
                            </script>
                        @endif
                        @if(isset($locationName['cityNameUrl']) && $locationName['kindState'] == 'city')
                            <a href="{{route('cityPage', ['kind' => 'city', 'city' => $locationName['cityNameUrl']])}}" class="headerSearchIcon footerSearchBar cityButton">
                                <div class="icc locationIcon" style="word-spacing: -4px;  color: black;">شهر {{$locationName['cityNameUrl']}}</div>
                            </a>
                            <script>
                                $('.pSC_boxOfDetails').css('height', 'calc(100% - 235px)');
                            </script>
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

                <div id="profileSideMenu" class="profileSideMenu">
                    <div class="body">
                        <div class="iconClose" onclick="openSideMenuInProfileFooter()"></div>
                        <div class="tabs">
                            <a href="{{route('profile')}}" class="tab">
                                <div class="icon far fa-user"></div>
                                <div class="name">صفحه من</div>
                            </a>
                            <a href="{{route('profile.message.page')}}" class="tab">
                                <div class="icon far fa-envelope"></div>
                                <div class="name">پیام ها</div>
                            </a>
                            <div class="tab" onclick="goToAddPlacePageInFooter()">
                                <div class="icon">
                                    <img src="{{URL::asset('images/icons/koochit.svg')}}" class="pic" alt="koochitaSho">
                                </div>
                                <div class="name">افزودن مکان</div>
                            </div>
                            <div class="tab" onclick="openModalWriteNewReview()">
                                <div class="icon">
                                    <img src="{{URL::asset('images/icons/addPhotoIcon.svg')}}" class="pic" alt="addPicture">
                                </div>
                                <div class="name">ایجاد پست</div>
                            </div>
                            <div class="tab" onclick="writeNewSafaranmeh()">
                                <div class="icon">
                                    <img src="{{URL::asset('images/icons/addSafarnamehIcon.svg')}}" class="pic" alt="addSafarnameh">
                                </div>
                                <div class="name">نوشتن سفرنامه</div>
                            </div>
                            <a href="{{route('profile.accountInfo')}}" class="tab">
                                <div class="icon settingIcon"></div>
                                <div class="name">تنظیمات</div>
                            </a>
                            <a href="{{route("logout")}}" class="tab">
                                <div class="icon fas fa-sign-out-alt"></div>
                                <div class="name">خروج</div>
                            </a>
                        </div>
                    </div>
                </div>

                <div id="profileSearchReviewsMFooter" class="searchReviewMFooter">
                    <div class="searchBar">
                        <input id="searchInReviewMFooter" type="text" placeholder="جستجو" onkeyup="searchInReviewSearch(this.value)">
                        <div class="iconClose" onclick="openSearchModalReviewMFooter()"></div>
                    </div>
                    <div class="searchKindTab">
                        <div class="tab select" onclick="chooseThisSearchTypeReviewMFooter(this, 'user')">افراد</div>
                        <div class="tab" onclick="chooseThisSearchTypeReviewMFooter(this, 'tag')">هشتگ</div>
                        <div class="tab" onclick="chooseThisSearchTypeReviewMFooter(this, 'place')">مکان</div>
                    </div>
                    <div class="searchResultPlaceHolderSec hidden">
                        <div class="item placeHolder">
                            <div class="pic placeHolderAnime"></div>
                            <div class="content" style="width: 50%;">
                                <div class="rr placeHolderAnime"></div>
                                <div class="rr placeHolderAnime"></div>
                            </div>
                        </div>
                        <div class="item placeHolder">
                            <div class="pic placeHolderAnime"></div>
                            <div class="content" style="width: 50%;">
                                <div class="rr placeHolderAnime"></div>
                                <div class="rr placeHolderAnime"></div>
                            </div>
                        </div>
                    </div>
                    <div class="searchResultSec"></div>
                </div>

                <div class="userInfoMobileFooterBody">
                    <div class="row" style="width: 100%; margin: 0px; flex-direction: column; position: relative;">
                        <div class="threeDotIconVertical" onclick="openSideMenuInProfileFooter()"></div>

                        <div class="firsLine">
                            <a href="{{route('profile', ['username' => $authUserInfos->username])}}" class="pic">
                                <img src="{{isset($authUserInfos->pic) ? $authUserInfos->pic : ''}}" alt="userPic" class="resizeImgClass" onload="fitThisImg(this)"/>
                            </a>
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
                        <div>
                            <a href="{{route('profile', ['username' => $authUserInfos->username])}}" class="secondLine">{{auth()->user()->username}}</a>
                        </div>
                        <div class="buttonsLine">
                            <div class="mBLine bLine">
                                <div class="tabBut selected" onclick="changeMobileFooterReviewExplore(this, 'followers')">
                                    <div class="name">دوستان</div>
                                </div>
                                <div class="tabBut" onclick="changeMobileFooterReviewExplore(this, 'all')">
                                    <div class="name">همه</div>
                                </div>
                                <div id="searchReviewButton" class="tabBut" style="width: 100px;" onclick="openSearchModalReviewMFooter()">
                                    <div class="searchIcon" style="font-weight: bold;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="exploreReviewInFooterSection">
                            <div id="footerExploreReviewSection" class="reviewSec allReviewSec"></div>
                            <div id="indicatorForNewReview" class="indicatorForNewReview"></div>
                        </div>

{{--                        <div class="buttonsLine">--}}
{{--                            <div>--}}
{{--                                <div onclick="window.location.href='{{route("profile", ['username' => $authUserInfos->username])}}'">--}}
{{--                                    <div class="name" style="font-size: 16px; font-weight: bold; color: gray">صفحه من</div>--}}
{{--                                </div>--}}
{{--                                <div onclick="window.location.href='{{route("profile.message.page")}}'">--}}
{{--                                    <div class="name" style="font-size: 16px; font-weight: bold; color: {{$authUserInfos->newMsg > 0 ? 'var(--koochita-red)' : ''}};">صندوق پیام</div>--}}
{{--                                    @if($authUserInfos->newMsg > 0)--}}
{{--                                        <div class="footerMsgCountNumber">{{$authUserInfos->newMsg}}</div>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="mBLine bLine">--}}
{{--                                <div onclick="mobileFooterProfileButton('review')">--}}
{{--                                    <div class="icon EmptyCommentIcon"></div>--}}
{{--                                    <div class="name">پست ها</div>--}}
{{--                                </div>--}}
{{--                                <div onclick="mobileFooterProfileButton('photo')">--}}
{{--                                    <div class="icon emptyCameraIcon"></div>--}}
{{--                                    <div class="name">عکس و فیلم</div>--}}
{{--                                </div>--}}
{{--                                <div onclick="mobileFooterProfileButton('question')">--}}
{{--                                    <div class="icon questionIcon"></div>--}}
{{--                                    <div class="name">سوال و جواب</div>--}}
{{--                                </div>--}}
{{--                                <div onclick="mobileFooterProfileButton('safarnameh')">--}}
{{--                                    <div class="icon safarnameIcon"></div>--}}
{{--                                    <div class="name">سفرنامه ها</div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="mBLine bLine">--}}
{{--                                <div onclick="mobileFooterProfileButton('medal')">--}}
{{--                                    <div class="icon medalsIcon"></div>--}}
{{--                                    <div class="name">جایزه و امتیاز</div>--}}
{{--                                </div>--}}
{{--                                <div onclick="mobileFooterProfileButton('follower')">--}}
{{--                                    <div class="icon twoManIcon"></div>--}}
{{--                                    <div class="name" >دنبال کنندگان</div>--}}
{{--                                </div>--}}
{{--                                <div onclick="mobileFooterProfileButton('bookMark')">--}}
{{--                                    <div class="icon BookMarkIconEmpty" style="font-size: 26px;"></div>--}}
{{--                                    <div class="name">نشان کرده</div>--}}
{{--                                </div>--}}
{{--                                <div onclick="mobileFooterProfileButton('setting')">--}}
{{--                                    <div class="icon settingIcon"></div>--}}
{{--                                    <div class="name">تنظیمات</div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="mBLine bLine">--}}
{{--                                <div onclick="mobileFooterProfileButton('festival')">--}}
{{--                                    <div class="icon festivalIcon"></div>--}}
{{--                                    <div class="name">فستیوال</div>--}}
{{--                                </div>--}}
{{--                                <div onclick="window.location.href = '{{route("myTrips")}}'">--}}
{{--                                    <div class="icon MyTripsIcon"></div>--}}
{{--                                    <div class="name">سفرهای من</div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                    </div>

{{--                    <div class="profileScoreMainDiv">--}}
{{--                        <div class="memberPointInfo">--}}
{{--                            <div class="modules-membercenter-level-progress">--}}
{{--                                <div data-direction="left" id="targetHelp_9" class="targets progress_info tripcollectiveinfo">--}}
{{--                                    <div>--}}
{{--                                        <div class="labels">--}}
{{--                                            <div class="right label">{{__('مرحله فعلی')}}</div>--}}
{{--                                            <div class="float-leftImp label">{{__('مرحله بعدی')}}</div>--}}
{{--                                        </div>--}}
{{--                                        <div class="progress_indicator">--}}

{{--                                            <div class="next_badge myBadge">{{$authUserInfos->userLevel[0]->name}} </div>--}}
{{--                                            <div class="meter">--}}
{{--                                                <span id="progressIdPhone" class="progress"></span>--}}
{{--                                            </div>--}}
{{--                                            <div class="current_badge myBadge">{{$authUserInfos->userLevel[1]->name}} </div>--}}
{{--                                        </div>--}}

{{--                                        <div class="points_to_go" style="text-align: center; font-size: 10px;">--}}
{{--                                            <span style="color: var(--koochita-red); font-size: 14px"> {{$authUserInfos->nextLevel}} </span>--}}
{{--                                            امتیاز--}}
{{--                                            <span style="color: var(--koochita-red);">کم داری</span>--}}
{{--                                            تا مرحله--}}
{{--                                            <span style="color: var(--koochita-red);">بعد</span>--}}
{{--                                        </div>--}}
{{--                                        <div class="text-align-center">--}}
{{--                                            <a class="cursor-pointer color-black">{{__('مشاهده سیستم سطح بندی')}}</a>--}}
{{--                                        </div>--}}
{{--                                        <div class="clear fix"></div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="lp_phoneMenuBar">--}}
{{--                        <div class="lp_eachMenu" onclick="writeNewSafaranmeh()">--}}
{{--                            <img src="{{URL::asset('images/icons/addSafarnamehIcon.svg')}}" class="profileMobileFooterImg" alt="addSafarnameh">--}}
{{--                            <div>{{__('نوشتن سفرنامه')}}</div>--}}
{{--                        </div>--}}
{{--                        <div class="lp_eachMenu" onclick="openModalWriteNewReview()">--}}
{{--                            <img src="{{URL::asset('images/icons/addPhotoIcon.svg')}}" class="profileMobileFooterImg" alt="addPicture">--}}
{{--                            <div>{{__('پست گذاشتن')}}</div>--}}
{{--                        </div>--}}
{{--                        <div class="lp_eachMenu" onclick="goToAddPlacePageInFooter()">--}}
{{--                            <img src="{{URL::asset('images/icons/koochit.svg')}}" class="profileMobileFooterImg" alt="koochitaSho">--}}
{{--                            <div>{{__('کوچیت کن')}}</div>--}}
{{--                        </div>--}}
{{--                        <div class="lp_eachMenu" onclick="mobileFooterProfileButton('setting')">--}}
{{--                            <div class="settingIcon lp_icons"></div>--}}
{{--                            <div>{{__('تنظیمات')}}</div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>

            </div>
        </div>
    @endif
</div>

<script>
    var userProfileUrl = '{{route("profile")}}';
    var searchInForReviewUrl = '{{route("review.search.reviewContent")}}';
    var getKoochitaTvNewesUrlMFooter = '{{route("koochitatv.getNewestVideoFromKoochitaTv")}}';
</script>

<script src="{{URL::asset('js/pages/layout/mobileFooter.js?v='.$fileVersions)}}"></script>
