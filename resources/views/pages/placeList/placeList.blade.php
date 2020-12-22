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
    <meta property="og:image" content="{{URL::asset('_images/nopic/blank.jpg')}}"/>
    <meta property="og:image:secure_url" content="{{URL::asset('_images/nopic/blank.jpg')}}"/>
    <meta property="og:image:width" content="550"/>
    <meta property="og:image:height" content="367"/>
    <meta name="twitter:image" content="{{URL::asset('_images/nopic/blank.jpg')}}"/>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/hotelLists.css?v='.$fileVersions)}}"/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/mainPageStyles.css?v='.$fileVersions)}}'/>

</head>

<body id="BODY_BLOCK_JQUERY_REFLOW">

@include('general.forAllPages')

<div id="PAGE">

    @include('layouts.header1')

    <div class="hideOnPhone">
        @include('general.secondHeader')
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
            <div>
                @if($mode != 'country')
                    @if($mode == 'state')
                        {{__('استان')}}
                    @endif
                    {{$city->name}}
                @else
                    {{__('ایران من')}}
                @endif
            </div>
        </div>
        <div class="botGradient"></div>
    </div>

    <div class="container listContainer">

        <div class="placeListHeader hideOnPhone">
            <div class="placeListTitle">
                {{$kindPlace->title}}
                @if($mode != 'country')
                    @if($mode == 'state')
                        {{__('استان')}}
                    @endif
                    {{$city->name}}
                @else
                    {{__('ایران من')}}
                @endif
            </div>
            <div class="shareSection">
                <div id="share_pic" class="btn sharePageMainDiv" onclick="toggleShareIcon(this)">
                    <div class="emptyShareIcon listShareIconPc"></div>
                    <div class="sharePageLabel">
                        {{__('اشتراک&zwnj;گذاری صفحه')}}
                    </div>
                    @include('layouts.shareBox')
                </div>
            </div>
        </div>

        <div id="BODYCON" class="row placeListBody">
            <div class="col-md-9 col-sm-8 rightLightBorder placeListBodyContentSection PlaceController">
                <div id="listBody" class="coverpage">
                    <div id="FilterTopController" class="placeListSortDiv bottomLightBorder hideOnPhone">
                        <div class="ordering sorting" style="font-weight: bold">
                            {{__('مرتب سازی بر اساس')}}:
                        </div>
                        <div class="ordering">
                            <div class="orders" onclick="selectingOrder($(this),'review')" id="z1">
                                {{__('بیشترین نظر')}}
                            </div>
                        </div>
                        <div class="ordering">
                            <div class="orders" onclick="selectingOrder(this, 'rate')" id="z2">
                                {{__('بهترین بازخورد')}}
                            </div>
                        </div>
                        <div class="ordering">
                            <div class="orders" onclick="selectingOrder(this, 'seen')" id="z3">
                                {{__('بیشترین بازدید')}}
                            </div>
                        </div>
                        <div class="ordering">
                            <div class="orders" onclick="selectingOrder(this, 'alphabet')" id="z4" >
                                {{__('حروف الفبا')}}
                            </div>
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
                            @if($contentCount == 0)
                                <div id="notingToShowInPlace" class="notingToShowDiv">
                                    <div class="notingToShowImgDiv">
                                        <img src="{{URL::asset('images/mainPics/notElemList.png')}}" style="width: 100%;">
                                    </div>
                                    <div class="notingToShowTextDiv">
                                        <span style="font-weight: bold; font-size: 1.5em;">
                                            {{$errorTxt[0]}}
                                        </span>
                                        <span>
                                            {{$errorTxt[1]}}
                                        </span>
                                        <span>
                                            {!! $errorTxt[2] !!}
                                        </span>
                                    </div>
                                    {{--                                <div class="notingToShowClose iconClose"></div>--}}
                                </div>
                            @else
                                <div id="listBodyToShowCards"></div>
                                <div id="notingToShowFilter" class="notingToShowDiv hidden">
                                    <div class="notingToShowImgDiv">
                                        <img src="{{URL::asset('images/mainPics/notElemList.png')}}" style="width: 100%;">
                                    </div>
                                    <div class="notingToShowTextDiv">
                                    <span style="font-weight: bold; font-size: 1.5em;">
                                        {{__('با توجه به فیلتر های اعمال شده نتیجه ای برای نمایش موجود نمی باشد.')}}
                                    </span>
                                        <span class="hideOnScreen">
                                        {{__('لطفا از پنل اعمال فیلتر، فیلترها را برای رسیدن به نتیجه کاهش دهید')}}
                                    </span>
                                        <span class="hideOnPhone">
                                        {{__('لطفا از پنل سمت چپ، فیلترها را برای رسیدن به نتیجه کاهش دهید')}}
                                    </span>
                                    </div>
                                    {{--                                <div class="notingToShowClose iconClose"></div>--}}
                                </div>
                            @endif

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
                            <div style="cursor: pointer; font-size: 0.75em; color: #050c93; margin-bottom: 7px;" onclick="closeFilters()">
                                {{__('پاک کردن فیلتر ها')}}
                            </div>
                            <div class="filterShow" style="display: flex; flex-direction: row; flex-wrap: wrap;"></div>
                        </div>
                    </div>

                    <div class="bottomLightBorder headerFilter">
                        <div class="filterGroupTitle">{{__('جستجو‌ی نام')}}</div>
                        <input id="nameSearch" class="hl_inputBox" placeholder="جستجو کنید" onchange="nameFilterFunc(this.value)">
                    </div>
                    @if($kindPlace->id == 11)
                        <div class="bottomLightBorder headerFilter" style="position: relative">
                            <div class="filterGroupTitle">{{__('جستجو براساس مواد اولیه')}}</div>
                            <input id="materialSearch" class="hl_inputBox materialSearchInput" placeholder="جستجو کنید" onchange="closeFoodMaterialSearch()">
                            <div id="materialSearchBox" class="searchBox hidden">
                                <div class="loading hidden">
                                    <img src="{{URL::asset('images/icons/gear.svg')}}" alt="" style="width: 30px">
<!--                                    --><?php //echo file_get_contents(URL::asset('images/icons/gear.svg'), false, stream_context_create(['ssl' => ["verify_peer"=>false, "verify_peer_name"=>false]])) ?>
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
                                <input onclick="rateFilterFunc(5, this)" type="radio" name="AVGrate" id="c5" value="5"/>
                                <label for="c5" style="display:inline-block;"><span></span></label>
                                <div class="rating-widget" style="font-size: 1.2em; display: inline-block">
                                    <div class="prw_rup prw_common_location_rating_simple">
                                        <span class="ui_bubble_rating bubble_50"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="filterItem lhrFilter filter selected">
                                <input  onclick="rateFilterFunc(4, this)" type="radio" name="AVGrate" id="c4" value="4"/>
                                <label for="c4" style="display:inline-block;"><span></span></label>
                                <div class="rating-widget" style="font-size: 1.2em; display: inline-block">
                                    <div class="prw_rup prw_common_location_rating_simple">
                                        <span class="ui_bubble_rating bubble_40"></span>
                                    </div>
                                </div>
                                <span> {{__('به بالا')}}</span>
                            </div>
                            <div class="filterItem lhrFilter filter selected">
                                <input onclick="rateFilterFunc(3, this)" type="radio" name="AVGrate" id="c3" value="3"/>
                                <label for="c3" style="display:inline-block;"><span></span></label>
                                <div class="rating-widget" style="font-size: 1.2em; display: inline-block">
                                    <div class="prw_rup prw_common_location_rating_simple">
                                        <span class="ui_bubble_rating bubble_30"></span>
                                    </div>
                                </div>
                                <span> {{__('به بالا')}}</span>
                            </div>
                            <div class="filterItem lhrFilter filter selected">
                                <input onclick="rateFilterFunc(2, this)" type="radio" name="AVGrate" id="c2" value="2"/>
                                <label for="c2" style="display:inline-block;"><span></span></label>
                                <div class="rating-widget" style="font-size: 1.2em; display: inline-block">
                                    <div class="prw_rup prw_common_location_rating_simple">
                                        <span class="ui_bubble_rating bubble_20"></span>
                                    </div>
                                </div>
                                <span> {{__('به بالا')}}</span>
                            </div>
                            <div class="filterItem lhrFilter filter selected">
                                <input onclick="rateFilterFunc(1, this)" type="radio" name="AVGrate" id="c1" value="1"/>
                                <label for="c1"
                                       style="display:inline-block;"><span></span></label>
                                <div class="rating-widget"
                                     style="font-size: 1.2em; display: inline-block">
                                    <div class="prw_rup prw_common_location_rating_simple">
                                        <span class="ui_bubble_rating bubble_10"></span>
                                    </div>
                                </div>
                                <span> {{__('به بالا')}}</span>
                            </div>
                        </div>
                    </div>

                    @if($kindPlace->id == 4)
                        @include('pages.placeList.filters.hotelFilters')
                    @elseif($kindPlace->id == 10)
                        @include('pages.placeList.filters.sogatSanaieFilters')
                    @elseif($kindPlace->id == 11)
                        @include('pages.placeList.filters.mahaliFoodFilters')
                    @endif

                    @foreach($features as $feature)
                        <div class="bottomLightBorder headerFilter">
                            <div class="filterHeaderWithClose">
                                <div class="filterGroupTitle">{{$feature->name}}</div>
                                @if(count($feature->subFeat) > 5)
                                    <span onclick="showMoreItems({{$feature->id}})" class="moreItems{{$feature->id}} moreItems">
                                        {{__('نمایش کامل فیلترها')}}
                                        <span class="downArrowIcon"></span>
                                    </span>
                                    <span onclick="showLessItems({{$feature->id}})" class="lessItems hidden extraItem{{$feature->id}} moreItems">
                                        {{__('پنهان سازی فیلتر‌ها')}}
                                        <span class="upArrowIcon"></span>
                                    </span>
                                @endif
                            </div>

                            <div class="filterContent ui_label_group inline">
                                @for($i = 0; $i < 5 && $i < count($feature->subFeat); $i++)
                                    <div class="filterItem lhrFilter filter squerRadioInputSec selected">
                                        <input onclick="doFilterFeature({{$feature->subFeat[$i]->id}})" type="checkbox" id="feat{{$feature->subFeat[$i]->id}}" value="{{$feature->subFeat[$i]->name}}"/>
                                        <label for="feat{{$feature->subFeat[$i]->id}}" class="inputRadionSquer">
                                            <span class="labelBox"></span>
                                            <span class="name">{{$feature->subFeat[$i]->name}}</span>
                                        </label>
                                    </div>
                                @endfor

                                @if(count($feature->subFeat) > 5)
                                    @for($i = 5; $i < count($feature->subFeat); $i++)
                                        <div class="filterItem lhrFilter filter extraItem{{$feature->id}} squerRadioInputSec hidden">
                                            <input onclick="doFilterFeature({{$feature->subFeat[$i]->id}})" type="checkbox" id="feat{{$feature->subFeat[$i]->id}}" value="{{$feature->subFeat[$i]->name}}"/>
                                            <label for="feat{{$feature->subFeat[$i]->id}}" class="inputRadionSquer">
                                                <span class="labelBox"></span>
                                                <span class="name">{{$feature->subFeat[$i]->name}}</span>
                                            </label>
                                        </div>
                                    @endfor
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div id="pos-article-display-sticky-16137"></div>

            </div>
        </div>

    </div>

    @include('layouts.footer.layoutFooter')
</div>


<script>
    var listElementSample = `
                                            <div class="ui_column col-lg-3 col-md-4 col-xs-6 eachPlace">
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
                    {{__('استان')}}:
                    <span>##state##</span>
                </div>
                <div class="item col-md-12 col-xs-6 itemState" style="margin-top: 3px">
                    {{__('شهر')}}:
                    <span>##city##</span>
                </div>
                <div class="booking"></div>
            </div>
        </div>
    </div>

    `;


</script>

<script>
    function goToCampain(){
        if(checkLogin('{{route('addPlaceByUser.index')}}'))
            location.href = '{{route('addPlaceByUser.index')}}';
    }

    $('#compareButton').click(function(e) {
        $("#myCloseBtn").removeClass('hidden');
        $('#searchspan').animate({height: '100vh'});
    });

    var specialFilters = [];
    var page = 1;
    var placeMode = '{{$placeMode}}';
    var floor = 1;
    var rateFilter = 0;
    var featureFilter = [];
    var nameFilter = '';
    var materialFilter = [];
    var data;
    var init = true;
    var lock = false;
    var nearPlaceIdFilter = 0;
    var nearKindPlaceIdFilter = 0;
    var kindPlaceId = '{{$kindPlace->id}}';

    @if(isset($city->id))
        var cityId = '{{$city->id}}';
    @else
        var cityId = 0;
    @endif

    @if($kindPlaceId == 4 || $kindPlaceId == 1 || $kindPlaceId == 12 || $kindPlaceId == 3)
        var sort = "seen";
    @elseif($kindPlaceId == 6)
        var sort = "review";
    @elseif($kindPlaceId == 11)
        var sort = "lessSeen";
    @else
        var sort = "alphabet";
    @endif

    let url = window.location;
    if(url.search.split('?filter=')[1] != undefined){
        var fil = url.search.split('?filter=')[1];
        if(fil == 'vegetarian')
            $('.vegetarian1').prop( "checked", true);
        else if(fil == 'vegan')
            $('.vegan1').prop( "checked", true);
        else if(fil == 'diabet')
            $('.diabet1').prop( "checked", true);

        specialFilters[0] = {
            'kind' : url.search.split('?filter=')[1],
            'value' : 1
        };
    }

    if(placeMode == 'hotel'){
        specialFilters = [{
            'kind' : 'kind_id',
            'value' : 1
        }];
    }

    function selectingOrder(elem, type) {
        $(".orders").removeClass('selectOrder');
        $("#selectDistance").text('__ __ __');
        $("#selectDistanceMobile").text('__ __ __');
        $(elem).addClass('selectOrder');
        sort = type;

        if(type != 'distance')
            newSearch();
    }

    function nameFilterFunc(value){
        nameFilter = value.trim().length > 2 ? value : '';
        newSearch();
    }

    var searchNumber = 0;
    $('#materialSearch').on('keyup', e => e.keyCode == 13 ? materialFilterFunc(e.target.value) : searchForMaterial(e.target.value));
    function searchForMaterial(_value){
        if(_value.trim().length > 1){
            $("#materialSearchBox").removeClass('hidden');
            $("#materialSearchBox").find('.loading').removeClass('hidden');
            $("#materialSearchBox").find('.res').addClass('hidden');
            searchNumber++;
            $.ajax({
                type: 'get',
                url : `{{route("search.foodMaterial")}}?value=${_value.trim()}&searchNumber=${searchNumber}`,
                success: response => {
                    if(response.searchNumber == searchNumber){
                        var html = '';
                        response.result.map(item => html += `<div class="result" onclick="chooseThisFoodMaterial(this)">${item}</div>`);
                        setResultToGlobalSearch(html); // forMobileSearch;
                        $("#materialSearchBox").find('.res').html(html);
                        $("#materialSearchBox").find('.loading').addClass('hidden');
                        $("#materialSearchBox").find('.res').removeClass('hidden');
                    }
                },
                error: err => console.log(err)
            })
        }
    }

    function closeFoodMaterialSearch(){
        setTimeout(() => $("#materialSearchBox").addClass('hidden'), 100);
    }

    function createChoosenMaterialBox(_ref = 'refresh'){
        var searchResult = '';
        materialFilter.map(item =>  searchResult += `<div class="matSel iconCloseAfter" onclick="deleteMaterialSearch(this)">${item}</div>` );
        $('.youMaterialSearchResult').html(searchResult);
        $('.materialSearchInput').val('');
        if(_ref == 'refresh')
            newSearch();
    }

    function deleteMaterialSearch(_element){
        var index = materialFilter.indexOf($(_element).text());
        if(index > -1) {
            materialFilter.splice(index, 1);
            createChoosenMaterialBox();
        }
    }

    function chooseThisFoodMaterial(_element){
        var material = $(_element).text();
        $('#materialSearch').val(material);
        materialFilterFunc(material);
        closeSearchInput(); // for mobile search
    }

    function materialFilterFunc(_value){
        _value = _value.trim();
        if(_value.length > 2 &&materialFilter.indexOf(_value) == -1) {
            materialFilter.push(_value);
            createChoosenMaterialBox();
        }
        closeFoodMaterialSearch();
    }

    function cancelMaterialSearch(){
        materialFilter = [];
        createChoosenMaterialBox('dontRefresh');
    }

    function doKindFilter(_kind, _value){
        var is = false;
        for(var i = 0; i < specialFilters.length; i++){
            //this if for radioboxes
            if((_kind == 'eatable' && specialFilters[i]['kind'] == 'eatable') ||
                (_kind == 'fragile' && specialFilters[i]['kind'] == 'fragile') ||
                (_kind == 'hotOrCold' && specialFilters[i]['kind'] == 'hotOrCold')){
                specialFilters[i] = 0;
                break;
            }
            else if(specialFilters[i]['kind'] == _kind && specialFilters[i]['value'] == _value){
                specialFilters[i] = 0;
                is = true;
                break;
            }
        }

        if(!is){
            var findZero = false;
            for(i = 0; i < specialFilters.length; i++){
                if(specialFilters[i] == 0){
                    findZero = i+1;
                    break;
                }
            }

            if(!findZero)
                findZero = specialFilters.length + 1;

            specialFilters[findZero - 1] = {
                'kind' : _kind,
                'value' : _value
            };
        }

        if(placeMode == 'sogatSanaies')
            onlyForSogatSanaie(); // in sogatSanaieFilters
        else
            newSearch();
    }

    function rateFilterFunc(value, _element = ''){
        if(_element != '' && $(_element).val() == rateFilter)
            cancelRateFilter();
        else {
            rateFilter = value;
            newSearch();
        }
    }

    function doFilterFeature(value){
        if(featureFilter.includes(value))
            featureFilter[featureFilter.indexOf(value)] = 0;
        else{
            if(featureFilter.includes(0))
                featureFilter[featureFilter.indexOf(0)] = value;
            else
                featureFilter[featureFilter.length] = value;
        }

        newSearch();
    }

    function createFilter(){
        var text = '';
        var hasFilter = false;

        $('.filterShow').html('');
        if(rateFilter != 0) {
            text +=  `<div class="filters" onclick="cancelRateFilter()">
                        <div class="lessShowText name">امتیاز کاربر</div>
                        <div class="iconClose"></div>
                      </div>`;
            hasFilter = true;
        }

        if(nameFilter.trim().length > 2) {
            text +=  `<div class="filters" onclick="cancelNameFilter()">
                        <div class="lessShowText name">نام</div>
                        <div class="iconClose"></div>
                      </div>`;
            hasFilter = true;
        }

        for(i = 0; i < featureFilter.length; i++){
            if(featureFilter[i] != 0) {
                var name = document.getElementById('feat' + featureFilter[i]).value;
                text +=  `<div class="filters" onclick="cancelFeatureFilter(${featureFilter[i]})">
                            <div class="lessShowText name">${name}</div>
                            <div class="iconClose"></div>
                          </div>`;
                hasFilter = true;
            }
        }

        for(i = 0; i < specialFilters.length; i++){
            if(specialFilters[i] != 0) {
                var name = document.getElementById(specialFilters[i]['kind'] + specialFilters[i]['value']).value;
                text +=  `<div class="filters" onclick="cancelKindFilter('${specialFilters[i]['kind']}', '${specialFilters[i]['value']}')">
                            <div class="lessShowText name">${name}</div>
                            <div class="iconClose"></div>
                          </div>`;
                hasFilter = true;
            }
        }

        if(materialFilter.length > 0){
            text +=  `<div class="filters" onclick="cancelKindFilter('foodMaterial', [])">
                            <div class="lessShowText name">مواد اولیه</div>
                            <div class="iconClose"></div>
                          </div>`;
            hasFilter = true;
        }

        $('.filterShow').html(text);
        $('.filterBox').css('display', hasFilter ? 'block' : 'none');
    }

    function cancelKindFilter(_kind, _value, _ref = 'refresh'){
        if(_kind == 0 && _value == 0){
            for(i = 0; i< specialFilters.length; i++){
                if(specialFilters[i] != 0)
                    $('.' + specialFilters[i]['kind'] + specialFilters[i]['value']).prop("checked", false);
            }
            specialFilters = [];
        }
        else if(_kind == 'foodMaterial')
            cancelMaterialSearch();
        else {
            for(var i = 0; i < specialFilters.length; i++){
                if(specialFilters[i]['kind'] == _kind && specialFilters[i]['value'] == _value) {
                    $('.' + specialFilters[i]['kind'] + specialFilters[i]['value']).prop("checked", false);
                    specialFilters[i] = 0;
                    break;
                }
            }
        }

        if(placeMode == 'sogatSanaies' && _kind == 'eatable')
            specialCancelSogataSanaiesFilters();
        else if(_ref == 'refresh')
            newSearch();
    }

    function cancelRateFilter(kind = 'refresh'){
        for(i = 1; i < 6; i++) {
            document.getElementById('c' + i).checked = false;
            document.getElementById('p_c' + i).checked = false;
        }

        rateFilter = 0;
        if(kind == 'refresh')
            newSearch();
    }

    function cancelFeatureFilter(id, kind = 'refresh'){
        if(id == 0){
            for(i = 0; i< featureFilter.length; i++){
                if(featureFilter[i] != 0) {
                    $('#feat' + featureFilter[i]).prop("checked", false);
                    $('#p_feat' + featureFilter[i]).prop("checked", false);
                }
            }
            featureFilter = [];
        }
        else {
            if (featureFilter.includes(id)) {
                featureFilter[featureFilter.indexOf(id)] = 0;
                $('#feat' + id).prop("checked", false);
                $('#p_feat' + id).prop("checked", false);
            }
        }

        if(kind == 'refresh')
            newSearch();
    }

    function cancelNameFilter(){
        $('#nameSearch').val('');
        $('#p_nameSearch').val('');
        nameFilterFunc('');
    }

    function closeFilters(){
        // cancelRateFilter('noRef');
        cancelFeatureFilter(0, 'noRef');
        cancelKindFilter(0, 0, 'noRef');
        cancelMaterialSearch();
        cancelNameFilter();
    }

    function openGlobalSearch(){
        createSearchInput('searchInPlaces', 'مکان مورد نظر را وارد کنید.');
    }

    function searchInPlaces(element){
        var value = element.value;
        if(value.trim().length > 1){
            $.ajax({
                type: 'post',
                url: "{{route('proSearch')}}",
                data: {
                    'key':  value,
                    'hotelFilter': 1,
                    'amakenFilter': 1,
                    'restaurantFilter': 1,
                    'majaraFilter': 1,
                    'sogatSanaieFilter': 1,
                    'mahaliFoodFilter': 1,
                    'boomgardyFilter': 1,
                    'selectedCities': cityId,
                    'mode': '{{$mode}}'
                },
                success: function (response) {
                    $("#resultPlace").empty();

                    if(response.length == 0)
                        return;

                    response = JSON.parse(response);

                    newElement = "";
                    for(i = 0; i < response.length; i++) {

                        var searchIcon = {
                            'هتل': 'hotelIcon',
                            'رستوران': 'restaurantIcon',
                            'اماکن': 'touristAttractions',
                            'ماجرا': 'adventure',
                            'غذای محلی': 'traditionalFood',
                            'صنایع سوغات': 'souvenirIcon',
                            'بوم گردی': 'touristAttractions',
                        };

                        newElement += '<div style="padding: 5px 20px; display: flex" onclick="selectSearchInPlace(\'' + response[i]['name'] + '\', ' + response[i]["id"] + ', ' + response[i]["kindPlaceId"] + ')">' +
                                    '       <div>' +
                                    `          <div class="icons ${searchIcon[response[i].kindPlace]} spIcons"></div>` +
                                    '           <p class="suggest cursor-pointer font-weight-700" id="suggest_1" style="margin: 0px; display: inline-block;">' + response[i].name + '</p>' +
                                    '           <p class="suggest cursor-pointer stateName" id="suggest_1">' + response[i].cityName + ' در ' + response[i].stateName + '</p>' +
                                    '       </div>\n' +
                                    '</div>';
                    }

                    setResultToGlobalSearch(newElement);
                }
            });
        }
    }

    function selectSearchInPlace(name, id, kindPlaceId){
        nearPlaceIdFilter = id;
        nearKindPlaceIdFilter = kindPlaceId;
        $('#selectDistance').text(name);
        $('#selectDistanceMobile').text(name);

        closeSearchInput();

        sort = 'distance';
        newSearch();
    }

    function showMoreItems(_id) {
        $(".extraItem" + _id).removeClass('hidden').addClass('selected');
        $(".moreItems" + _id).addClass('hidden');
    }

    function showLessItems(_id) {
        $(".extraItem" + _id).addClass('hidden').removeClass('selected');
        $(".moreItems" + _id).removeClass('hidden');
    }

</script>

<script>
    var ADElements = [];
    var ADElementsId = [];
    var lastShowAd = 0;
    var getingListItemAjax = null;
    var isFinish = false;
    var inTake = false;
    var take = 24;

    function getPlaceListItems(){
        if(!isFinish && !inTake){
            inTake = true;
            openLoading();
            getingListItemAjax = $.ajax({
                type: "POST",
                url: `{{route("place.list.getElems")}}`,
                data:{
                    _token: '{{csrf_token()}}',
                    pageNum: page,
                    take: take,
                    specialFilters: specialFilters,
                    rateFilter: rateFilter,
                    nameFilter: nameFilter,
                    materialFilter: materialFilter,
                    sort: sort,
                    featureFilter: featureFilter,
                    nearPlaceIdFilter: nearPlaceIdFilter,
                    nearKindPlaceIdFilter: nearKindPlaceIdFilter,
                    city: cityId,
                    mode: '{{$mode}}',
                    kindPlaceId: '{{$kindPlace->id}}'
                },
                complete: e =>{
                    inTake = false;
                    getingListItemAjax = null;
                    closeLoading();
                },
                success: response => createListItemCard(response),
                error: err => console.error(err)
            });
        }
    }

    function createListItemCard(_result){
        var cards = '';
        var places = _result.places;

        if(places.length != take)
            isFinish = true;
        else
            page++;


        $('#notingToShowFilter').addClass('hidden');
        if (_result.placeCount == 0 && _result.totalCount > 0)
            $('#notingToShowFilter').removeClass('hidden');


        $('.totalPlaceCount').text(_result.totalCount);
        $('.filterShowCount').text(_result.placeCount);

        places.map(item => {
            var text = listElementSample;
            item.ngClass = `ui_bubble_rating bubble_${item.avgRate}0`;
            item.bookMark = item.bookMark == 1 ? 'BookMarkIcon' : 'BookMarkIconEmpty';
            for (var x of Object.keys(item))
                text = text.replace(new RegExp(`##${x}##`, "g"), item[x]);

            cards += text;
        });

        $('#listBodyToShowCards').append(cards);

        if(lastShowAd == ADElements.length)
            lastShowAd = 0;

        $('#listBodyToShowCards').append(ADElements[lastShowAd]);
        lastShowAd++;
    }

    function newSearch(){
        page = 1;
        isFinish = false;
        inTake = false;
        $('#listBodyToShowCards').html('');
        if(getingListItemAjax != null)
            getingListItemAjax.abort();
        createFilter();
        getPlaceListItems();
    }

    function bookMarkThisPlace(_element){
        if(!checkLogin())
            return;

        var placeId = $(_element).attr('value');
        $.ajax({
            type: 'post',
            url: '{{route("setBookMark")}}',
            data: {
                placeId,
                kindPlaceId
            },
            success: function (response) {
                if (response == "ok-del"){
                    $(_element).addClass('BookMarkIconEmpty').removeClass('BookMarkIcon');
                    showSuccessNotifi('این صفحه از حالت ذخیره خارج شد', 'left', 'red');
                }
                else if(response == 'ok-add'){
                    $(_element).addClass('BookMarkIcon').removeClass('BookMarkIconEmpty');
                    showSuccessNotifi('این صفحه ذخیره شد', 'left', 'var(--koochita-blue)');
                }
            }
        })
    }

    $(window).on('scroll', e => {
        var bottomOfList = document.getElementById('bottomMainList').getBoundingClientRect().top;
        var windowHeight = $(window).height();

        if(bottomOfList-windowHeight < 0 && !inTake && !isFinish)
            getPlaceListItems();
    });

    $(window).ready(() => {
        getPlaceListItems();
        ADElementsId.map(item => ADElements.push($(`#${item}`).html()));
    });
</script>

</body>
</html>