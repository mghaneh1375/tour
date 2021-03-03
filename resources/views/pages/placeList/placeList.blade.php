<!DOCTYPE html>
<html>
<head>
    @include('layouts.topHeader')
    <meta property="og:type" content="website" />
    <title> کوچیتا | {{$meta['title']}} </title>

    <meta name="title" content="{{$meta['title']}}" />
    <meta name="og:title" content="{{$meta['title']}}" />
    <meta name='description' content='{{$meta['description']}}' />
    <meta name='og:description' content='{{$meta['description']}}' />
    <meta name='keywords' content='{{$meta['keyword']}}' />
    <meta property="og:image" content="{{URL::asset('images/mainPics/noPicSite.jpg')}}"/>
    <meta property="og:image:secure_url" content="{{URL::asset('images/mainPics/noPicSite.jpg')}}"/>
    <meta property="og:image:width" content="550"/>
    <meta property="og:image:height" content="367"/>
    <meta name="twitter:image" content="{{URL::asset('images/mainPics/noPicSite.jpg')}}"/>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/hotelLists.css?v='.$fileVersions)}}"/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/mainPageStyles.css?v='.$fileVersions)}}'/>

    <style>
        .addNewReviewButtonMobileFooter{
            display: none !important;
        }
    </style>

</head>

<body id="BODY_BLOCK_JQUERY_REFLOW">

@include('general.forAllPages')

<div id="PAGE">

    @include('layouts.header1')

    <div class="hideOnPhone">
        @include('pages.secondHeader')

        <div style="background: white; width: 100%; padding: 15px 0px;">
            <a href="{{route('festival.cook')}}" class="topPageAd">
                <img src="{{URL::asset('images/esitrevda/bannerlong.webp')}}" >
            </a>
        </div>
    </div>

    <div class="hideOnScreen placeListMobileTopPic">
        <div class="topListImg">
            <img src="{{URL::asset('images/mainPics/placeList/'.$topPic)}}" alt="listPic" style="width: 100%">
        </div>
        <div class="listTitle">
            <div>{{$kindPlace->title}}</div>
            <div>{{$locationName['name']}}</div>
        </div>
        <div class="botGradient"></div>
    </div>

    <div class="container listContainer">

        <div class="placeListHeader hideOnPhone">
            <div class="placeListTitle">
                @if($locationName['kindState'] == 'country')
                    لیست {{$kindPlace->title}} ایران
                @else
                    {{$kindPlace->title}}
                    {{$locationName['name']}}
                @endif
            </div>

            <div class="shareSection">
                <div id="share_pic" class="btn sharePageMainDiv" onclick="toggleShareIcon(this)">
                    <div class="emptyShareIcon listShareIconPc"></div>
                    <div class="sharePageLabel">
                        {{__('اشتراک گذاری صفحه')}}
                    </div>
                    @include('layouts.shareBox', ['urlInThisShareBox' => Request::url()])
                </div>
            </div>
        </div>


        @if($kindPlace->id == 13)
            @include('pages.placeList.filters.localShopHeaderCategoryList')
        @endif

        <div id="BODYCON" class="row placeListBody">
            <div class="col-md-9 col-sm-8 rightLightBorder placeListBodyContentSection PlaceController">
                <div id="listBody" class="coverpage">
                    <div id="FilterTopController" class="placeListSortDiv bottomLightBorder hideOnPhone">
                        <div class="ordering sorting" style="font-weight: bold"> {{__('مرتب سازی بر اساس')}}:</div>
                        <div class="ordering">
                            <div class="orders" onclick="selectingOrder($(this),'review')" id="z1">{{__('بیشترین نظر')}} </div>
                        </div>
                        <div class="ordering">
                            <div class="orders" onclick="selectingOrder(this, 'rate')" id="z2"> {{__('بهترین بازخورد')}} </div>
                        </div>
                        <div class="ordering">
                            <div class="orders" onclick="selectingOrder(this, 'seen')" id="z3"> {{__('بیشترین بازدید')}} </div>
                        </div>
                        <div class="ordering">
                            <div class="orders" onclick="selectingOrder(this, 'alphabet')" id="z4" > {{__('حروف الفبا')}} </div>
                        </div>
                        @if($kindPlace->id != 10 && $kindPlace->id != 11)
                            <div class="ordering"  >
                                <div id="distanceNav" class="orders" style="width: 140% !important;" onclick="openGlobalSearch(); selectingOrder(this, 'distance')">{{__('کمترین فاصله تا')}}
                                    <span id="selectDistance">__ __ __</span>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="option">
                        <div class="row">
                            @if($notItemToShow)
                                <div id="notingToShowInPlace" class="notingToShowDiv">
                                    <div class="notingToShowImgDiv">
                                        <img src="{{URL::asset('images/mainPics/notElemList.png')}}" style="width: 100%;">
                                    </div>
                                    <div class="notingToShowTextDiv">
                                        <span style="font-weight: bold; font-size: 1.5em;"> {{$errorTxt[0]}} </span>
                                        @if(isset($errorTxt[1]))<span> {{$errorTxt[1]}} </span>@endif
                                        <span> {!! $errorTxt[2] !!} </span>
                                    </div>
                                </div>
                            @else
                                <div id="notingToShowFilter" class="notingToShowDiv hidden">
                                    <div class="notingToShowImgDiv">
                                        <img src="{{URL::asset('images/mainPics/notElemList.png')}}" style="width: 100%;">
                                    </div>
                                    <div class="notingToShowTextDiv">
                                        <span style="font-weight: bold; font-size: 1.5em;">{{__('با توجه به فیلتر های اعمال شده نتیجه ای برای نمایش موجود نمی باشد.')}}</span>
                                        <span class="hideOnScreen">{{__('لطفا از پنل اعمال فیلتر، فیلترها را برای رسیدن به نتیجه کاهش دهید')}}</span>
                                        <span class="hideOnPhone">{{__('لطفا از پنل سمت چپ، فیلترها را برای رسیدن به نتیجه کاهش دهید')}}</span>
                                    </div>
                                </div>
                            @endif

                            <div id="forCityContent"></div>
                            <div id="listBodyToShowCards"></div>
                        </div>
                    </div>
                </div>
                <div id="bottomMainList" style="width: 100%; height: 5px;"></div>
            </div>

            <div class="col-md-3 col-sm-4 placeListBodyFilterSection hideOnPhone" id="FilterController">

                <div id="EATERY_FILTERS_CONT" class="eatery_filters lhr">

                    <div class="filterGroupTitle bottomLightBorder">
                        <div id="pos-article-display-card-16129"></div>
                    </div>

                    <div class="bottomLightBorder headerFilter" >
                        <div class="filterBox" style="flex-direction: column; display: none;">
                            <div style="font-size: 15px; margin: 10px 0px;">
                                <span>{{__('فیلترهای اعمال شده')}}</span>
                                <span style="float: left">
                                    <span class="filterShowCount">----</span>
                                    <span style="margin: 0 5px">{{__('مورد از')}}</span>
                                    <span class="totalPlaceCount"></span>
                                </span>
                            </div>
                            <div style="cursor: pointer; font-size: 0.75em; color: #050c93; margin-bottom: 7px;" onclick="closeFilters()">{{__('پاک کردن فیلتر ها')}}</div>
                            <div class="filterShow" style="display: flex; flex-direction: row; flex-wrap: wrap;"></div>
                        </div>
                    </div>

                    <div class="bottomLightBorder headerFilter">
                        <div class="filterGroupTitle">{{__('جستجو‌ی نام')}}</div>
                        <input id="nameSearch" class="hl_inputBox nameSearchInPlaceList" placeholder="جستجو کنید" onchange="nameFilterFunc(this.value)">
                    </div>
                    @if($kindPlace->id == 11)
                        <div class="bottomLightBorder headerFilter" style="position: relative">
                            <div class="filterGroupTitle">{{__('جستجو براساس مواد اولیه')}}</div>
                            <input id="materialSearch" class="hl_inputBox materialSearchInput" placeholder="جستجو کنید" onchange="closeFoodMaterialSearch()">
                            <div id="materialSearchBox" class="searchBox hidden">
                                <div class="loading hidden">
                                    <img src="{{URL::asset('images/icons/gear.svg')}}" alt="" style="width: 30px">
                                </div>
                                <div class="res"></div>
                            </div>
                            <div class="youMaterialSearchResult materialSearchSelected"></div>
                        </div>
                    @endif

                    <div class="bottomLightBorder headerFilter">
                        <div class="filterGroupTitle">{{__('امتیاز کاربران')}}</div>
                        <div class="filterContent ui_label_group inline">
                            <div class="filterItem lhrFilter filter selected">
                                <input class="rateFilter_5 rateFilterList" onclick="rateFilterFunc(5, this)" type="radio" name="AVGrate" id="c5" value="5"/>
                                <label for="c5" style="display:inline-block;"><span></span></label>
                                <div class="rating-widget" style="font-size: 1.2em; display: inline-block">
                                    <div class="prw_rup prw_common_location_rating_simple">
                                        <span class="ui_bubble_rating bubble_50"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="filterItem lhrFilter filter selected">
                                <input class="rateFilter_4 rateFilterList"  onclick="rateFilterFunc(4, this)" type="radio" name="AVGrate" id="c4" value="4"/>
                                <label for="c4" style="display:inline-block;"><span></span></label>
                                <div class="rating-widget" style="font-size: 1.2em; display: inline-block">
                                    <div class="prw_rup prw_common_location_rating_simple">
                                        <span class="ui_bubble_rating bubble_40"></span>
                                    </div>
                                </div>
                                <span> {{__('به بالا')}}</span>
                            </div>
                            <div class="filterItem lhrFilter filter selected">
                                <input class="rateFilter_3 rateFilterList" onclick="rateFilterFunc(3, this)" type="radio" name="AVGrate" id="c3" value="3"/>
                                <label for="c3" style="display:inline-block;"><span></span></label>
                                <div class="rating-widget" style="font-size: 1.2em; display: inline-block">
                                    <div class="prw_rup prw_common_location_rating_simple">
                                        <span class="ui_bubble_rating bubble_30"></span>
                                    </div>
                                </div>
                                <span> {{__('به بالا')}}</span>
                            </div>
                            <div class="filterItem lhrFilter filter selected">
                                <input class="rateFilter_2 rateFilterList" onclick="rateFilterFunc(2, this)" type="radio" name="AVGrate" id="c2" value="2"/>
                                <label for="c2" style="display:inline-block;"><span></span></label>
                                <div class="rating-widget" style="font-size: 1.2em; display: inline-block">
                                    <div class="prw_rup prw_common_location_rating_simple">
                                        <span class="ui_bubble_rating bubble_20"></span>
                                    </div>
                                </div>
                                <span> {{__('به بالا')}}</span>
                            </div>
                            <div class="filterItem lhrFilter filter selected">
                                <input class="rateFilter_1 rateFilterList" onclick="rateFilterFunc(1, this)" type="radio" name="AVGrate" id="c1" value="1"/>
                                <label for="c1" style="display:inline-block;"><span></span></label>
                                <div class="rating-widget" style="font-size: 1.2em; display: inline-block">
                                    <div class="prw_rup prw_common_location_rating_simple">
                                        <span class="ui_bubble_rating bubble_10"></span>
                                    </div>
                                </div>
                                <span> {{__('به بالا')}}</span>
                            </div>
                        </div>
                    </div>

                    <div class="featureListSection">
                        @if($kindPlace->id == 4)
                            @include('pages.placeList.filters.hotelFilters')
                        @elseif($kindPlace->id == 10)
                            @include('pages.placeList.filters.sogatSanaieFilters')
                        @elseif($kindPlace->id == 11)
                            @include('pages.placeList.filters.mahaliFoodFilters')
                        @elseif($kindPlace->id == 13)
                            @include('pages.placeList.filters.localShopFilters')
                        @endif

                        @foreach($features as $feature)
                            <div class="bottomLightBorder headerFilter">
                                <div class="filterHeaderWithClose">
                                    <div class="filterGroupTitle">{{$feature->name}}</div>
                                    @if(count($feature->subFeat) > 5)
                                        <span onclick="showMoreItems({{$feature->id}})" class="moreItems{{$feature->id}} moreItems">
                                            <span>{{__('نمایش کامل فیلترها')}}</span>
                                            <span class="downArrowIcon"></span>
                                        </span>
                                        <span onclick="showLessItems({{$feature->id}})" class="lessItems hidden extraItem{{$feature->id}} moreItems">
                                            <span>{{__('پنهان سازی فیلتر‌ها')}}</span>
                                            <span class="upArrowIcon"></span>
                                        </span>
                                    @endif
                                </div>

                                <div class="filterContent ui_label_group inline">
                                    @foreach($feature->subFeat as $index => $sub)
                                        <div class="filterItem lhrFilter filter squerRadioInputSec {{$index > 4 ? "hidden extraItem{$feature->id}" : 'selected'}}">
                                            <input id="feat{{$sub->id}}" class="featurePlaceListInput_{{$sub->id}}" onclick="doFilterFeature({{$sub->id}})" type="checkbox" value="{{$sub->name}}"/>
                                            <label for="feat{{$sub->id}}" class="inputRadionSquer">
                                                <span class="labelBox"></span>
                                                <span class="name">{{$sub->name}}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div id="pos-article-display-sticky-16137"></div>

            </div>
        </div>

    </div>

    @include('layouts.footer.layoutFooter')
</div>


<script>
    <?php
        $isShowLocationIcon = ($kindPlaceId == 1 || $kindPlaceId == 3 || $kindPlaceId == 4 || $kindPlaceId == 6 || $kindPlaceId == 12 || $kindPlaceId == 13);
    ?>

    var listElementSample = `<div class="ui_column col-lg-3 col-md-4 col-xs-6 eachPlace">
                                <div class="poi listBoxesMainDivs">
                                    <div class="contentImgSection">
                                        <a href="##url##" class="thumbnail" style="margin-bottom: 5px !important; height: 100%">
                                            <div class="contentImg">
                                                <img src='##pic##' class='resizeImgClass' alt='##keyword##' onload="fitThisImg(this)" style="width: 100%">
                                            </div>
                                        </a>
                                        @if(auth()->check())
                                            <div class="bookMarkIconOnPic ##bookMark##" onclick="bookMarkThisPlace(this)" value="##id##"></div>
                                        @endif
                                        @if($isShowLocationIcon)
                                            <div class="locationIcon" onclick="showThisPlaceInMap(this)" value="##id##"></div>
                                        @endif
                                    </div>
                                    <div class="detail">
                                        <div class="contentDetailName lessShowText" title="##name##">
                                            <a class="poiTitle" target="_blank" href="##url##">##name##</a>
                                        </div>
                                        <div class="item rating-count">
                                            <div class="rating-widget">
                                                <div class="prw_rup prw_common_location_rating_simple">
                                                    <span class="##ngClass##"></span>
                                                </div>
                                            </div>
                                            <div target="_blank" class="review_count">
                                                ##reviews##
                                                <span>{{__('نقد')}}</span>
                                            </div>
                                        </div>
                                        <div class="item col-md-12 col-xs-6 itemState" style="margin-top: 5px">
                                            <span>##stateKindText##:</span>
                                            <span>##state##</span>
                                        </div>
                                        <div class="item col-md-12 col-xs-6 itemState" style="margin-top: 3px">
                                            <span>{{__('شهر')}}:</span>
                                            <span>##city##</span>
                                        </div>
                                        <div class="booking"></div>
                                    </div>
                                </div>
                            </div>`;

    var cityId = '{{ isset($city->id) ? $city->id : 0}}';
    var cityRel = {!! $cityRel !!};
    var placeListModel = '{{$mode}}';
    var kindPlaceId = '{{$kindPlace->id}}';
    var placeMode = '{{$placeMode}}';
    var myLocationPlaceListUrl = '{{route('myLocation')}}';

    var proSearchUrlInList = '{{route('proSearch')}}';
    var getListElementUrl = '{{route("place.list.getElems")}}';
    var setBookMarkInPlaceListUrl = '{{route("setBookMark")}}';
    var foodMaterialSearchUrl = '{{route("search.foodMaterial")}}';
    var addPlaceByUserInListUrl = '{{route('addPlaceByUser.index')}}';
    var getLocalShopFeatureListUrl = '{{route("localShop.getFeatureList")}}}';

    @if($kindPlaceId == 4 || $kindPlaceId == 1 || $kindPlaceId == 12 || $kindPlaceId == 3)
        var sort = "seen";
    @elseif($kindPlaceId == 6)
        var sort = "review";
    @elseif($kindPlaceId == 11)
        var sort = "lessSeen";
    @else
        var sort = "alphabet";
    @endif
</script>

<script src="{{URL::asset('js/pages/placeDetails/placeList.js?v='.$fileVersions)}}"></script>

</body>
</html>
