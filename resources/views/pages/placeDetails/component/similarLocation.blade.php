<style>
    .articleImageSuggest{
        width: 100%;
        height: 170px;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
    }
</style>

<div id="similarLocationsMainDiv" class="tabContentMainWrap">

    <div class="topBarContainerSimilarLocations display-none"></div>

    <div class="mainSuggestion swiper-container">
        <div class="shelf_header">
            <div class="shelf_title">
                <div class="shelf_title_container h3">
                    <a href="{{route('safarnameh.index')}}">
                        <h3>مقالات برتر</h3>
                    </a>
                </div>
            </div>
        </div>
        <div id="articleSwiperContent" class="swiper-wrapper"></div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <div class="mainSuggestion swiper-container tabContentMainWrap similarLocationsMainDiv">
        <div class="shelf_header">
            <div class="shelf_title">
                <div class="shelf_title_container h3">
                    <h3>جاذبه های نزدیک</h3>
                </div>
            </div>
        </div>
        <div id="amakenSwiperContent" class="swiper-wrapper"></div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <div class="mainSuggestion swiper-container">
        <div class="shelf_header">
            <div class="shelf_title">
                <div class="shelf_title_container h3">
                    <h3>رستوران‌های نزدیک</h3>
                </div>
            </div>
        </div>
        <div id="restaurantSwiperContent" class="swiper-wrapper"></div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <div class="mainSuggestion swiper-container">
        <div class="shelf_header">
            <div class="shelf_title">
                <div class="shelf_title_container h3">
                    <h3>هتل‌های نزدیک</h3>
                </div>
            </div>
        </div>

        <div id="hotelSwiperContent" class="swiper-wrapper"></div>

        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <div class="mainSuggestion swiper-container">
        <div class="shelf_header">
            <div class="shelf_title">
                <div class="shelf_title_container h3">
                    <h3>طبیعت گردی های نزدیک</h3>
                </div>
            </div>
        </div>

        <div id="majaraSwiperContent" class="swiper-wrapper"></div>

        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <div class="mainSuggestion swiper-container">
        <div class="shelf_header">
            <div class="shelf_title">
                <div class="shelf_title_container h3">
                    <h3>بوم گردی های نزدیگ</h3>
                </div>
            </div>
        </div>

        <div id="boomgardySwiperContent" class="swiper-wrapper"></div>

        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>

<div class="footerOptimizer display-none"></div>

<script>

    function createSwiperContent(_places, _kind){
        var text = '';
        if(_kind == 'article') {
            for(var i = 0; i < _places.length; i++){
                text += '<div class="swiper-slide">\n' +
                    '                <div class="prw_rup prw_shelves_rebrand_poi_shelf_item_widget ui_column ng-scope" style="width: 250px">\n' +
                    '                    <div class="poi">\n' +
                    '                        <a href="' + _places[i]["url"] + '"\n' +
                    '                           class="thumbnail">\n' +
                    '                            <div class="prw_rup prw_common_thumbnail_no_style_responsive">\n' +
                    '                                <div class="prv_thumb has_image">\n' +
                    '                                    <div class="image_wrapper landscape landscapeWide articleImageSuggest">\n' +
                    '                                        <img src="' + _places[i]["pic"] + '" alt="' + _places[i]["keyword"] + '" class="image resizeImgClass" style="width: 100%;" onload="fitThisImg(this)">\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                            </div>\n' +
                    '                        </a>\n' +
                    '                        <div class="detail rtl">\n' +
                    '                            <a href="' + _places[i]["url"] + '"\n' +
                    '                               class="item poi_name ui_link ng-binding" style="width: 200px;">' + _places[i]["title"] + '</a>\n' +
                    '                            <div class="item rating-widget">\n' +
                    '                                <span class="reviewCount ng-binding">' + _places[i]["msgs"] + '</span>\n' +
                    '                                <span>نقد </span>\n' +
                    '                            </div>\n' +
                    '                        </div>\n' +
                    '                    </div>\n' +
                    '                </div>\n' +
                    '            </div>\n';
            }
            document.getElementById('articleSwiperContent').innerHTML = text;
        }
        else {
            for (var i = 0; i < _places.length; i++) {
                text += '<div class="swiper-slide">\n' +
                    '                <div class="prw_rup prw_shelves_rebrand_poi_shelf_item_widget ui_column ng-scope" style="width: 250px;">\n' +
                    '                    <div class="poi">\n' +
                    '                        <a href="' + _places[i]["url"] + '"\n' +
                    '                           class="thumbnail">\n' +
                    '                            <div class="prw_rup prw_common_thumbnail_no_style_responsive">\n' +
                    '                                <div class="prv_thumb has_image">\n' +
                    '                                    <div class="image_wrapper landscape landscapeWide articleImageSuggest">\n' +
                    '                                        <img src="' + _places[i]["pic"] + '" alt="' + _places[i]["alt1"] + '" class="image resizeImgClass" onload="fitThisImg(this)">\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                            </div>\n' +
                    '                        </a>\n' +
                    '                        <div class="detail rtl">\n' +
                    '                            <a href="' + _places[i]["url"] + '"\n' +
                    '                               class="item poi_name ui_link ng-binding">' + _places[i]["name"] + '</a>\n' +
                    '                            <div class="item rating-widget">\n' +
                    '                                <div class="prw_rup prw_common_location_rating_simple">\n' +
                    '                                    <span class="ui_bubble_rating bubble_' + _places[i]["rate"] + '0"></span>\n' +
                    '                                </div>\n' +
                    '                                <span class="reviewCount ng-binding">' + _places[i]["review"] + '</span>\n' +
                    '                                <span>نقد </span>\n' +
                    '                            </div>\n' +
                    '                            <div class="item tags ng-binding">' + _places[i]["cityName"] + '\n' +
                    '                                <span>در </span>\n' +
                    '                                <span class="ng-binding">' + _places[i]["stateName"] + '</span>\n' +
                    '                            </div>\n' +
                    '                        </div>\n' +
                    '                    </div>\n' +
                    '                </div>\n' +
                    '            </div>\n';
            }

            if (_kind == 'hotel')
                document.getElementById('hotelSwiperContent').innerHTML = text;
            else if (_kind == 'restuarant')
                document.getElementById('restaurantSwiperContent').innerHTML = text;
            else if (_kind == 'amaken')
                document.getElementById('amakenSwiperContent').innerHTML = text;
            else if (_kind == 'majara')
                document.getElementById('majaraSwiperContent').innerHTML = text;
            else if (_kind == 'boomgardy')
                document.getElementById('boomgardySwiperContent').innerHTML = text;
        }
    }
</script>