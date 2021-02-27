<!doctype html>
<html lang="fa">
<head>
    @include('layouts.topHeader')
    <title>اطراف من</title>
    <link rel="stylesheet" href="{{URL::asset('css/pages/myLocation.css?v='.$fileVersions)}}">
    <link rel="stylesheet" href="{{URL::asset('packages/leaflet/leaflet.css')}}">

    {{--    <link rel="stylesheet" href="{{URL::asset('packages/map.ir/css/mapp.min.css')}}">--}}
    {{--    <link rel="stylesheet" href="{{URL::asset('packages/map.ir/css/fa/style.css')}}">--}}

    <style>
        footer .addNewReviewButtonMobileFooter{
            display: none;
        }
    </style>
</head>
<body>
    @include('general.forAllPages')

    @include('layouts.header1')

    <div class="bodySec">
        <div class="sideSection">
            <div class="searchSec">
                <div class="threeLineIcon" onclick="$('.bodySec').toggleClass('fullMap');"></div>
                <input id="searchPlaceInput" type="text" placeholder="محل مورد نظر را جستجو کنید..." onkeyup="searchPlace(this)" onfocus="showSearchResultSec(true)" onfocusout="showSearchResultSec(false)">
                <div id="resultMapSearch" class="placeSearchMapResults">
                    <div class="defaults">
                        <div class="res" onclick="getMyLocation()">
                            <div class="icon">
                                <img src="{{URL::asset('images/icons/myLocation.svg')}}" alt="myLocationIcon" style="width: 15px">
                            </div>
                            <div class="name">محل من</div>
                        </div>
                        <div class="res" onclick="chooseFromMap()">
                            <div class="icon locationIcon"></div>
                            <div class="name">انتخاب از روی نقشه</div>
                        </div>
                    </div>
                    <div class="resSec"></div>
                </div>
                <button class="searchButton">
                    <div class="searchIcon"></div>
                    <div class="lds-ring hidden"><div></div><div></div><div></div><div></div></div>
                </button>
            </div>
            <div class="filtersSec"></div>
        </div>

{{--        <div class="searchThisAreaButton">جستجوی این بخش</div>--}}

        <div class="listSection">
            <div class="leftArrowIcon" onclick="$('.bodySec').toggleClass('fullMap');"></div>
            <div class="content">
                <div class="fullyCenterContent placeListLoading hidden">
                    <img alt="loading" data-src="{{URL::asset('images/loading.gif?v'.$fileVersions)}}" class="lazyload" style="width: 100px;" />
                </div>
                <div class="placeList pcPlaceList"></div>
            </div>
        </div>
        <div id="mobileListSection" class="mobileListSection">
            <div class="topSecMobileList">
                <div class="fingerTopListSec topArrowFull"></div>
                <div class="nearName">اطراف من</div>
            </div>
            <div class="placeList mobileListContent">
                <div class="fullyCenterContent placeListLoading hidden">
                    <img alt="loading" data-src="{{URL::asset('images/loading.gif?v'.$fileVersions)}}" class="lazyload" style="width: 100px;" />
                </div>
                <div class="specialSelectedPlace selectedPlace"></div>
                <div id="mobileShowList" class="typesList"></div>
            </div>
        </div>
        <div class="mapSection">
            <div id="map" class="mapDiv"></div>
        </div>
    </div>

    <div id="localShopCategoriesModal" class="modalBlackBack fullCenter localShopCategoriesModal">
        <div class="modalBody">
            <div onclick="closeMyModal('localShopCategoriesModal')" class="iconClose closeModal"></div>
            <div class="mainFullBody">
                <div class="header">دسته بندی کسب و کارها</div>
                <div id="mapLocationShortcutDiv" class="swiper-container shortcutSec">
                    <div class="swiper-wrapper">
                        @foreach($localShopCategories as $category)
                            <div class="swiper-slide shortcutButton" onclick="goToMainCategorySection({{$category->id}})">
    {{--                            <div class="icon manSportIcon"></div>--}}
                                <div>{{$category->name}}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="rowButton">
                    <div class="butts showAll" onclick="showAllLocalShopCategories(-1, 0, this)">
                        <span class="text">تمامی دسته بندی ها</span>
                        <span class="icon">
                            <i class="far fa-eye"></i>
                            <i class="fas fa-slash slash"></i>
                        </span>
                    </div>
                </div>
                <div id="localShopCategoryFilterSection" class="filterSection">
                    @foreach($localShopCategories as $category)
                        <div id="localShopMainCategorySection_{{$category->id}}" class="rowFilter">
                            <div class="head">
                                <div>
{{--                                    <span class="icon manSportIcon"></span>--}}
                                    <span>{{$category->name}}</span>
                                </div>
                                <div class="showIcon showIconCategories" data-type="off" onclick="toggleLocalShopCategories({{$category->id}}, this)">
                                    <i class="far fa-eye"></i>
                                    <i class="fas fa-slash slash"></i>
                                </div>
                            </div>
                            <div class="body">
                                @foreach($category->sub as $sub)
                                    <div class="filter">
                                        <input id="localShopCategories_{{$sub->id}}" data-id="{{$sub->id}}" class="categoryFilterInput_0 categoryFilterInput_{{$category->id}}" type="checkbox" checked>
                                        <label for="localShopCategories_{{$sub->id}}" class="name checked">
{{--                                            <div class="icon manSportIcon"></div>--}}
                                            <div>{{$sub->name}}</div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="submitFilter" onclick="doLocalShopCategoryFilter()">اعمال فیلتر</div>
        </div>
    </div>

    @include('layouts.footer.layoutFooter')
    {{--    <script src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyCdVEd4L2687AfirfAnUY1yXkx-7IsCER0"></script>--}}

{{--    <script type="text/javascript" src="{{URL::asset('packages/map.ir/js/mapp.env.js')}}"></script>--}}
{{--    <script type="text/javascript" src="{{URL::asset('packages/map.ir/js/mapp.min.js')}}"></script>--}}


    <script>
        var localShopCategories = {!! $localShopCategories !!};
        var selectedPlaceFromBack = {!! json_encode($selectedPlaceName) !!};
        var searchPlaceUrl = "{{route('search.place')}}";
        var getPlacesLocationUrl = "{{route("getPlaces.location")}}";
        var noDataPicUrl = "{{URL::asset('images/mainPics/noData.png')}}";
        var filterButtons = {
            1: {
                id: 1,
                enName: 'amakenFilter',
                icon: 'touristAttractions',
                mapIcon: '{{URL::asset('images/mapIcon/att.png')}}',
                name: 'جاذبه',
                nameTitle: 'جاهای دیدنی نزدیک',
                onClick: '',
            },
            3: {
                id: 3,
                enName: 'restaurantFilter',
                icon: 'restaurantIcon',
                mapIcon: '{{URL::asset('images/mapIcon/res.png')}}',
                name: 'رستوران',
                nameTitle: 'رستوران های نزدیک',
                onClick: '',
            },
            4: {
                id: 4,
                enName: 'hotelFilter',
                icon: 'hotelIcon',
                mapIcon: '{{URL::asset('images/mapIcon/hotel.png')}}',
                name: 'اقامتگاه',
                nameTitle: 'اقامتگاه های نزدیک',
                onClick: '',
            },
            6: {
                id: 6,
                enName: 'advantureFilter',
                icon: 'adventureIcon',
                mapIcon: '{{URL::asset('images/mapIcon/adv.png')}}',
                name: 'طبیعت گردی',
                nameTitle: 'طبیعت گردی های نزدیک',
                onClick: '',
            },
            12: {
                id: 12,
                enName: 'boomgardyFilter',
                icon: 'boomIcon',
                mapIcon: '{{URL::asset('images/mapIcon/boom.png')}}',
                name: 'بوم گردی',
                nameTitle: 'بوم گردی های نزدیک',
                onClick: '',
            },
            13: {
                id: 13,
                enName: 'localShopFilter',
                icon: 'fullWalletIcon',
                mapIcon: '{{URL::asset('images/mapIcon/boom.png')}}',
                name: 'فروشگاه',
                nameTitle: 'فروشگاه های نزدیک',
                onClick: openLocalShopCategoriesFilter
            },
        };
        var localShopFilterCategory = [0];
        var totalLocalShopCategories = 0;

        localShopCategories.map(item => item.sub.map(sub => totalLocalShopCategories++));

        function openLocalShopCategoriesFilter(){
            openMyModal('localShopCategoriesModal');

            new Swiper('#mapLocationShortcutDiv', {
                slidesPerView: 'auto',
                spaceBetween: 10,
                freeMode: true,
            });
        }

        function showAllLocalShopCategories(_kind, _parent, _element = ''){
            if(_kind === 1)
                $('.categoryFilterInput_'+_parent).prop('checked', true);
            else if(_kind === 0)
                $('.categoryFilterInput_'+_parent).prop('checked', false);
            else if(_kind === -1){
                if($(_element).hasClass('showAll')) {
                    $(_element).removeClass('showAll');
                    $('.showIconCategories').attr('data-type', 'on').addClass('show');
                    showAllLocalShopCategories(0, 0);
                }
                else {
                    $(_element).addClass('showAll');
                    $('.showIconCategories').attr('data-type', 'off').removeClass('show');
                    showAllLocalShopCategories(1, 0);
                }
            }
        }

        function toggleLocalShopCategories(_id, _element){
            var type = $(_element).attr('data-type');
            if(type === 'on'){
                $(_element).attr('data-type', 'off').removeClass('show');
                showAllLocalShopCategories(1, _id);
            }
            else{
                $(_element).attr('data-type', 'on').addClass('show');
                showAllLocalShopCategories(0, _id);
            }
        }

        function doLocalShopCategoryFilter(){
            openLoading(false, () => {
                localShopFilterCategory = [];
                var elements = $('.categoryFilterInput_0');
                for(var i = 0; i < elements.length; i++){
                    if($(elements[i]).prop('checked'))
                        localShopFilterCategory.push($(elements[i]).attr('data-id'))
                }

                if(totalLocalShopCategories === localShopFilterCategory.length)
                    localShopFilterCategory = [0];

                if(localShopFilterCategory.length == 0){
                    $('.filterButtonMap_13').addClass('offFilter');
                    dontShowfilters.push(13);
                }
                else{
                    $('.filterButtonMap_13').removeClass('offFilter');
                    var index = dontShowfilters.indexOf(13);
                    if (index != -1)
                        dontShowfilters.splice(index, 1);
                }

                closeLoading();
                closeMyModal('localShopCategoriesModal');
                togglePlaces();
            })
        }

        var scrollNumber = -170;
        function goToMainCategorySection(_id){
            var element = $('#localShopCategoryFilterSection');
            element.animate({
                scrollTop: element.scrollTop() + $('#localShopMainCategorySection_'+_id).position().top + scrollNumber
            }, 1000).scrollTop();
        }
    </script>

    <script type="text/javascript" src="{{URL::asset('packages/leaflet/leaflet.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('packages/leaflet/leaflet-wms-header.js')}}"></script>

    <script src="{{URL::asset('js/pages/myLocation.js?v='.$fileVersions)}}"></script>
</body>
</html>
