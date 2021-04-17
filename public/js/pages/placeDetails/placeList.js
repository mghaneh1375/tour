var specialFilters = [];
var categoryFilter = 0;
var categoryFilterCancelCallBack = 0;
var page = 1;
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
var searchNumber = 0;
var ADElements = [];
var ADElementsId = [];
var lastShowAd = 0;
var getingListItemAjax = null;
var isFinish = false;
var inTake = false;
var take = 24;
var mustBeTaken = false;
let url = window.location;
var localShopCategoryId = mainLocalShopCategoryId;

if(url.search.split('?filter=')[1] != undefined){
    var fil = url.search.split('?filter=')[1];
    if(fil == 'vegetarian')
        $('.vegetarian1').prop( "checked", true);
    else if(fil == 'vegan')
        $('.vegan1').prop( "checked", true);
    else if(fil == 'diabet')
        $('.diabet1').prop( "checked", true);

    specialFilters[0] = {
        kind : url.search.split('?filter=')[1],
        value : 1
    };
}

if(placeMode == 'hotels'){
    $(window).ready(() => doKindFilter('kind_id', 1))
}

function goToCampain(){
    if(checkLogin(addPlaceByUserInListUrl))
    location.href = addPlaceByUserInListUrl;
}

$('#compareButton').click(function(e) {
    $("#myCloseBtn").removeClass('hidden');
    $('#searchspan').animate({height: '100vh'});
});

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

$('#materialSearch').on('keyup', e => e.keyCode == 13 ? materialFilterFunc(e.target.value) : searchForMaterial(e.target.value));
function searchForMaterial(_value){
    if(_value.trim().length > 1){
        var materialSearchBoxElement = $("#materialSearchBox");
        materialSearchBoxElement.removeClass('hidden');
        materialSearchBoxElement.find('.loading').removeClass('hidden');
        materialSearchBoxElement.find('.res').addClass('hidden');
        searchNumber++;
        $.ajax({
            type: 'get',
            url : `${foodMaterialSearchUrl}?value=${_value.trim()}&searchNumber=${searchNumber}`,
            success: response => {
                if(response.searchNumber == searchNumber){
                    var html = '';
                    response.result.map(item => html += `<div class="result" onclick="chooseThisFoodMaterial(this)">${item}</div>`);
                    setResultToGlobalSearch(html); // forMobileSearch;
                    materialSearchBoxElement.find('.res').html(html);
                    materialSearchBoxElement.find('.loading').addClass('hidden');
                    materialSearchBoxElement.find('.res').removeClass('hidden');
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

function doKindFilter(_kind, _value, _name = '', _cancelCallBack = ''){
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

        specialFilters[findZero - 1] = {kind : _kind, value: _value, name: _name, cancelCallBack: _cancelCallBack};
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
        featureFilter.splice(featureFilter.indexOf(value), 1);
    else
        featureFilter.push(value);
    newSearch();
}
function cancelFeatureFilter(id, kind = 'refresh'){
    if(id == 0){
        featureFilter.map(item => $(`.featurePlaceListInput_${item}`).prop("checked", false));
        featureFilter = [];
    }
    else {
        if (featureFilter.includes(id)) {
            featureFilter.splice(featureFilter.indexOf(id), 1);
            $(`.featurePlaceListInput_${id}`).prop("checked", false);
        }
    }

    if(kind == 'refresh')
        newSearch();
}


function createFilter(){
    var filtersToShow = [];

    if(rateFilter != 0)
        filtersToShow.push({name: 'امتیاز کاربر', onClick: 'cancelRateFilter()'});

    if(categoryFilter != 0)
        filtersToShow.push({name: categoryFilter, onClick: 'cancelCategoryFilter()'});

    if(nameFilter.trim().length > 2)
        filtersToShow.push({name: 'نام', onClick: 'cancelNameFilter()'});

    for(var i = 0; i < featureFilter.length; i++){
        if(featureFilter[i] != 0) {
            var name = document.getElementById('feat' + featureFilter[i]).value;
            filtersToShow.push({name: name, onClick: `cancelFeatureFilter(${featureFilter[i]})`});
        }
    }

    for(i = 0; i < specialFilters.length; i++){

        if(specialFilters[i] != 0) {
            var name = '';
            if(specialFilters[i].name === '')
                name = document.getElementById(specialFilters[i]['kind'] + specialFilters[i]['value']).value;
            else
                name = specialFilters[i].name;

            // if(specialFilters[i]['kind'] === 'nowOpen'){
            //     var nowDate = new Date();
            //     var hours = nowDate.getHours();
            //     var minutes = nowDate.getMinutes();
            //     if(hours < 10)
            //         hours = '0'+hours;
            //
            //     if(minutes < 10)
            //         minutes = '0'+minutes;
            //
            //     var time = hours + ':' + minutes;
            //     specialFilters[i]['value'] = nowDate.getTime() + '_' + time;
            // }

            filtersToShow.push({name: name, onClick: `cancelKindFilter('${specialFilters[i]['kind']}', '${specialFilters[i]['value']}')`});
        }
    }

    if(materialFilter.length > 0)
        filtersToShow.push({name: 'مواد اولیه', onClick: `cancelKindFilter('foodMaterial', [])`});

    var text = '';
    filtersToShow.map(filter => {
        text +=  `<div class="filters" onclick="${filter.onClick}">
                            <div class="lessShowText name">${filter.name}</div>
                            <div class="iconClose"></div>
                          </div>`;
    });

    $('.filterShow').html(text);
    $('.filterBox').css('display', text != '' ? 'block' : 'none');
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
                if(typeof specialFilters[i].cancelCallBack === 'function')
                    specialFilters[i].cancelCallBack(_value);

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
    $(`.rateFilterList`).prop('checked', false);
    rateFilter = 0;
    if(kind == 'refresh')
        newSearch();
}

function cancelNameFilter(){
    $('.nameSearchInPlaceList').val('');
    nameFilterFunc('');
    // $('#nameSearch').val('');
    // $('#p_nameSearch').val('');
}

function closeFilters(){
    cancelCategoryFilter('noRef');
    cancelRateFilter('noRef');
    cancelFeatureFilter(0, 'noRef');
    cancelKindFilter(0, 0, 'noRef');
    cancelMaterialSearch();
    cancelNameFilter();
}

function openGlobalSearch(){
    createSearchInput(searchInPlaces, 'مکان مورد نظر را وارد کنید.');
}

function searchInPlaces(element){
    var value = element.value;
    if(value.trim().length > 1){
        $.ajax({
            type: 'POST',
            url: proSearchUrlInList,
            data: {
                key:  value,
                hotelFilter: 1,
                amakenFilter: 1,
                restaurantFilter: 1,
                majaraFilter: 1,
                sogatSanaieFilter: 1,
                mahaliFoodFilter: 1,
                boomgardyFilter: 1,
                selectedCities: cityId,
                mode: placeListModel
            },
            success: function (response) {
                $("#resultPlace").empty();

                if(response.length == 0)
                    return;

                response = JSON.parse(response);

                newElement = "";
                var searchIcon = {
                    'هتل': 'hotelIcon',
                    'رستوران': 'restaurantIcon',
                    'اماکن': 'touristAttractions',
                    'ماجرا': 'adventure',
                    'غذای محلی': 'traditionalFood',
                    'صنایع سوغات': 'souvenirIcon',
                    'بوم گردی': 'touristAttractions',
                };
                response.map(item =>{
                    newElement += `<div style="padding: 5px 20px; display: flex" onclick="selectSearchInPlace('${item['name']}', ${item["id"]}, ${item["kindPlaceId"]})">
                                        <div>
                                            <div class="icons ${searchIcon[item.kindPlace]} spIcons"></div>
                                            <p class="suggest cursor-pointer font-weight-700" style="margin: 0px; display: inline-block;">${item.name}</p>
                                            <p class="suggest cursor-pointer stateName">${item.cityName} در ${item.stateName}</p>
                                        </div>
                                    </div>`;
                });

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

function getPlaceListItems(){

    if(cityRel != 0 && placeListModel == 'city' && (kindPlaceId == 10 || kindPlaceId == 11 || kindPlaceId == 6)){
        if(isFinish){
            placeListModel = 'state';
            cityId = cityRel.stateId;
            cityRel = 0;
            isFinish = false;
            inTake = false;
            mustBeTaken = false;
            $('#listBodyToShowCards').append('<hr style="width: 100%;">');
        }
        else{
            mustBeTaken = true;
            placeListModel = 'city';
            cityId = cityRel.id;
        }
    }

    if(!isFinish && !inTake){
        inTake = true;
        openLoading();

        getingListItemAjax = $.ajax({
            type: "POST",
            url: getListElementUrl,
            data:{
                _token: csrfTokenGlobal,
                pageNum: page,
                take: take,
                sort: sort,
                specialFilters: specialFilters,
                rateFilter: rateFilter,
                nameFilter: nameFilter,
                materialFilter: materialFilter,
                featureFilter: featureFilter,
                nearPlaceIdFilter: nearPlaceIdFilter,
                nearKindPlaceIdFilter: nearKindPlaceIdFilter,
                city: cityId,
                mode: placeListModel,
                localShopCategoryId: localShopCategoryId,
                kindPlaceId: kindPlaceId
            },
            complete: e =>{
                getingListItemAjax = null;
                closeLoading();
                inTake = false;
            },
            success: response => createListItemCard(response),
            error: err => console.error(err)
        });
    }
}

function createListItemCard(_result){
    var nothingToShowElement = $('#notingToShowFilter');
    var listBodyToShowCardsElement = $('#listBodyToShowCards');
    var cards = '';
    var places = _result.places;

    if(places.length != take)
        isFinish = true;
    else
        page++;


    nothingToShowElement.addClass('hidden');
    if (_result.placeCount == 0 && _result.totalCount > 0)
        nothingToShowElement.removeClass('hidden');


    $('.totalPlaceCount').text(_result.totalCount);
    $('.filterShowCount').text(_result.placeCount);

    places.map(item => {
        var text = listElementSample;
        item.ngClass = `ui_bubble_rating bubble_${item.avgRate}0`;
        item.bookMark = item.bookMark == 1 ? 'BookMarkIcon' : 'BookMarkIconEmpty';
        for (var x of Object.keys(item))
            text = text.replace(new RegExp(`##${x}##`, "g"), item[x]);

        var stateKindText = item.isCountry == 1 ? 'کشور ' : 'استان ';
        text = text.replace(new RegExp('##stateKindText##', "g"), stateKindText);

        var showStateAndCity = (item.state && item.city) ? 'block' : 'none';
        text = text.replace(new RegExp('##hasState##', 'g'), showStateAndCity);

        cards += text;
    });

    listBodyToShowCardsElement.append(cards);

    if(lastShowAd == ADElements.length)
        lastShowAd = 0;

    listBodyToShowCardsElement.append(ADElements[lastShowAd]);
    lastShowAd++;

    if(places.length != take && mustBeTaken)
        getPlaceListItems();
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

    storePlaceToBookMark(placeId, kindPlaceId, (_status, _response) => {
        if(_status == 'ok') {
            if (_response == "ok-del") {
                $(_element).addClass('BookMarkIconEmpty').removeClass('BookMarkIcon');
                showSuccessNotifi('این صفحه از حالت ذخیره خارج شد', 'left', 'red');
            } else if (_response == 'ok-add') {
                $(_element).addClass('BookMarkIcon').removeClass('BookMarkIconEmpty');
                showSuccessNotifi('این صفحه ذخیره شد', 'left', 'var(--koochita-blue)');
            }
        }
    });
}

function showThisPlaceInMap(_element){
    var placeId = $(_element).attr('value');
    openLoading();
    location.href = `${myLocationPlaceListUrl}?place=${placeId}&kindPlace=${placeMode}`;
}

function clearFeatureSection(){
    $('.featureListSection').empty();
}


function cancelCategoryFilter(_type = 'refresh'){
    localShopCategoryFilter(localShopCategoryId);
}
function localShopCategoryFilter(_id){
    if(localShopCategoryId === _id){
        [...document.querySelectorAll(`.localShopCategoryId_${_id}`)].map(item => item.checked = false);
        localShopCategoryId = mainLocalShopCategoryId;
        categoryFilter = 0;
    }
    else {
        [...document.querySelectorAll(`.localShopCategoryId_${_id}`)].map(item => item.checked = true);
        localShopCategoryId = _id;
        categoryFilter = document.querySelector(`.localShopCategoryId_${_id}`).getAttribute('data-name');
    }

    newSearch();
}


$(window).ready(() => {
    getPlaceListItems();
    ADElementsId.map(item => ADElements.push($(`#${item}`).html()));
}).on('scroll', e => {
    var bottomOfList = document.getElementById('bottomMainList').getBoundingClientRect().top;
    var windowHeight = $(window).height();

    if(bottomOfList-windowHeight < 0 && !inTake && (!isFinish || mustBeTaken))
        getPlaceListItems();
});
