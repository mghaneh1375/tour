var mainSearchAjax = null;
var numOfMainSearchResult = 0;
var lastTimeMainSearch = 0;
var recentlyMainSearchSample = `<div class="prw_rup prw_shelves_rebrand_poi_shelf_item_widget spBoxOfSuggestion">
                                    <div class="mainSearchpoi">
                                        <div class="prw_rup prw_common_thumbnail_no_style_responsive prw_common_thumbnail_no_style_responsive22">
                                            <div class="prv_thumb has_image" style="height: 100%">
                                                <div class="image_wrapper spImageWrapper landscape landscapeWide mainSearchImgTop">
                                                    <img src="##mainPic##" alt="##name##" class="resizeImgClass" style="height: 100%" onload="fitThisImg(this)" onerror="setDefaultPic(this)">
                                                </div>
                                            </div>
                                        </div>
                                        <a href="##redirect##" class="textsOfRecently">
                                            <div class="detail direction-rtl" style="width: 100%;">
                                                <div class="textsOfRecently_text">##name##</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>`;


function openMainSearch(_kindPlaceId){
    var fpst;
    var pn;
    var countryIcon = '';

    showLastPages();

    switch (_kindPlaceId){
        case 0:
            fpst = 'به کجا';
            pn = 'دوست دارید سفر کنید؟';
            break;
        case 1:
            fpst = 'کدام جاذبه';
            pn = 'را می‌خواهید تجربه کنید؟';
            countryIcon = 'touristAttractions';
            break;
        case 3:
            fpst = 'در کدام رستوران';
            pn = 'دوست دارید غذا بخورید؟';
            countryIcon = 'restaurantIcon';
            break;
        case 4:
            fpst = 'در کدام هتل';
            pn = 'دوست دارید اقامت کنید؟';
            countryIcon = 'hotelIcon';
            break;
        case 6:
            fpst = ' کدام ماجرا';
            pn = 'دوست دارید تجربه کنید؟';
            countryIcon = 'adventureIcon';
            break;
        case 10:
            fpst = 'کدام صنایع‌دستی یا سوغات';
            pn = 'را دوست دارید بشناسید؟';
            countryIcon = 'souvenirIcon';
            break;
        case 11:
            fpst = 'کدام غذای محلی';
            pn = 'را می‌خواهید تجربه کنید؟';
            countryIcon = 'traditionalFood';
            break;
        case 12:
            fpst = 'کدام بوم گردی';
            pn = 'دوست دارید اقامت کنید؟';
            countryIcon = 'boomIcon';
            break;
    }

    var mainSearchInputElement = $('#mainSearchInput');

    $('#kindPlaceIdForMainSearch').val(_kindPlaceId);
    $('#firstPanSearchText').text(fpst);
    $('#searchPane').removeClass('hidden');

    mainSearchInputElement.attr('placeholder', pn);
    mainSearchInputElement.val('');
    mainSearchInputElement.focus();

    var showHtml = '';
    if(_kindPlaceId == 0) {
        showHtml = `<a href="${myLocationUrlMainSearch}" class="mainSearchResultRow">
                    <div class="icons location spIcons"></div>
                    <p class='suggest cursor-pointer' style='margin: 0px'>اطراف من</p>
                  </a>`;
    }
    else{
        showHtml = `<a href="${placeListUrlMainSearch}/${_kindPlaceId}/country" class="mainSearchResultRow">
                        <div class="icons ${countryIcon} spIcons"></div>
                        <p class='suggest cursor-pointer' style='margin: 0px'>همه جای ایران</p>
                      </a>`;
    }

    $('#result').removeClass('hidden');
    $("#mainSearchResult").show().html(showHtml);
};

function redirect() {
    var element = $('#placeId');
    "" != element.val() && (document.location.href = element.val())
}

function searchMain(e, val = '') {
    if (val == '')
        val = $("#mainSearchInput").val();

    var searchDivForScrollElement = $("#searchDivForScroll");
    var kindPlaceId = $('#kindPlaceIdForMainSearch').val();
    $(".suggest").css({
        "background-color" : "transparent",
        "padding" : "0",
        "border-radius" : "0",
    });

    if (null == val || "" == val || val.length < 2) {
        $('#result').addClass('hidden');
        $("#mainSearchResult").empty();
    }
    else {
        var scrollVal = searchDivForScrollElement.scrollTop();

        if (13 == e.keyCode && -1 != currIdx) {
            $("#placeId").val(suggestions[currIdx].url);
            return redirect();
        }

        if (13 == e.keyCode && -1 == currIdx && suggestions.length > 0) {
            $("#placeId").val(suggestions[0].url);
            return redirect();
        }

        if (40 == e.keyCode) {
            if (currIdx + 1 < suggestions.length) {
                currIdx++;
                searchDivForScrollElement.scrollTop(scrollVal + 25);
            }
            else {
                currIdx = 0;
                searchDivForScrollElement.scrollTop(0);
            }

            if (currIdx >= 0 && currIdx < suggestions.length) {
                $("#suggest_" + currIdx).css({
                    "background-color": "#dcdcdc",
                    "padding": "10px",
                    "border-radius": "5px",
                });
            }

            return;
        }
        if (38 == e.keyCode) {
            if (currIdx - 1 >= 0) {
                currIdx--;
                searchDivForScrollElement.scrollTop(scrollVal - 25);
            }
            else {
                currIdx = suggestions.length - 1;
                searchDivForScrollElement.scrollTop(25 * suggestions.length);
            }

            if (currIdx >= 0 && currIdx < suggestions.length){
                $("#suggest_" + currIdx).css({
                    "background-color": "#dcdcdc",
                    "padding": "10px",
                    "border-radius": "5px",
                });
            }
            return;
        }

        $('#result').removeClass('hidden');
        $('#placeHolderResult').show();
        $('#mainSearchResult').hide();

        if ("ا" == val[0]) {
            for (val2 = "آ", i = 1; i < val.length; i++) val2 += val[i];
            if(mainSearchAjax != null)
                mainSearchAjax.abort();

            numOfMainSearchResult++;
            mainSearchAjax = $.ajax({
                type: "post",
                url: searchDir,
                data: {
                    _token: csrfTokenGlobal,
                    kindPlaceId: kindPlaceId,
                    num: numOfMainSearchResult,
                    key: val,
                    key2: val2,
                },
                success: function (response) {
                    let check = JSON.parse(response);
                    if(check[2] == numOfMainSearchResult)
                        createSearchResponse(response);
                }
            })
        }
        else {
            numOfMainSearchResult++;
            if(mainSearchAjax != null)
                mainSearchAjax.abort();

            mainSearchAjax = $.ajax({
                type: "post",
                url: searchDir,
                data: {
                    _token: csrfTokenGlobal,
                    kindPlaceId: kindPlaceId,
                    num: numOfMainSearchResult,
                    key: val,
                },
                success: function (response) {
                    let check = JSON.parse(response);
                    if(check[2] == numOfMainSearchResult)
                        createSearchResponse(response);
                }
            });
        }
    }
}

function createSearchResponse(response){
    let newElement = "";
    let searchText = $('#mainSearchInput').val();
    var kindPlaceId = $('#kindPlaceIdForMainSearch').val();
    var resultElement = $('#result');

    if(searchText.trim().length < 3){
        resultElement.addClass('hidden');
        $('#placeHolderResult').hide();
        $('#mainSearchResult').hide();
        return;
    }

    if (response.length == 0) {
        $('#placeHolderResult').hide();
        $('#mainSearchResult').hide();
        newElement = 'موردی یافت نشد';
        $("#placeId").val("");
        return;
    }

    currIdx = -1;
    var resutl = JSON.parse(response);
    suggestions = resutl[1];

    response = resutl[1];
    if(lastTimeMainSearch == 0 || lastTimeMainSearch <= resutl[0]) {
        lastTimeMainSearch = resutl[0];

        response.map(item => {
            var url = '';
            var name1 = '';
            var name2 = '';

            if (item.mode == "state") {
                if(item.isCountry == 1) {
                    url = kindPlaceId == 0 ? item.url : `${placeListUrlMainSearch}/${kindPlaceId}/country/${item.targetName}`;
                    name1 = 'کشور ' + item.targetName;
                }
                else {
                    url = kindPlaceId == 0 ? item.url : `${placeListUrlMainSearch}/${kindPlaceId}/state/${item.targetName}`;
                    name1 = 'استان ' + item.targetName;
                }
            }
            else if (item.mode == "city") {
                url = kindPlaceId == 0 ? item.url : `${placeListUrlMainSearch}/${kindPlaceId}/city/${item.targetName}`;
                name1 = 'شهر '+item.targetName;
                name2 = item.stateName;
            }
            else {
                url = item.url;
                name1 = item.targetName;
                if(item.cityName && item.stateName)
                    name2 = item.cityName+' در '+item.stateName;
                else name2 = '';
            }
            // style="${window.mainIconsPlaces[item.mode].isAwesome ? 'font-size: 20px' : ''}"
            newElement += `<a href="${url}" class="mainSearchResultRow">
                                <div class="firstRow">
                                    <div class="icons ${window.mainIconsPlaces[item.mode].icon} spIcons"></div>
                                    <div class='suggest cursor-pointer text''>${name1}</div>
                                </div>
                                <div class='suggest cursor-pointer stateName'>${name2}</div>
                            </a>`;
        });

        response.length != 0 ? resultElement.removeClass('hidden') : resultElement.addClass('hidden');

        $("#mainSearchResult").empty().append(newElement);
        $('#placeHolderResult').hide();
        $('#mainSearchResult').show();
    }
}

