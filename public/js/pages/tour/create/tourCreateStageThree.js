var inKoochita = 0 ;
var isTransport = 1;
var multiIsOpen = false;
var chooseSideTransport = [];
var language = [
    'فارسی',
    'انگلیسی',
    'عربی',
    'ترکی',
    'چینی',
    'کره ای',
    'ژاپنی',
    'اسپانیایی',
    'آلمانی',
    'فرانسوی',
    'پرتغالی',
];
var languageChoose = [];
var clockOptions = {
    placement: 'left',
    donetext: 'تایید',
    autoclose: true,
};

var storeData = {
    isTransportTour : tour.isTransport,
    sTransportKind : tour.hasTransport ? tour.transports.sTransportId : 0,
    eTransportKind : tour.hasTransport ? tour.transports.eTransportId : 0,
    sTime : tour.hasTransport ? tour.transports.sTime : '',
    eTime : tour.hasTransport ? tour.transports.eTime : '',
    sAddress : tour.hasTransport ? tour.transports.sAddress : '',
    eAddress : tour.hasTransport ? tour.transports.eAddress : '',
    sLat :  tour.hasTransport ? tour.transports.sLatLng[0] : 0,
    eLat : tour.hasTransport ? tour.transports.eLatLng[0] : 0,
    sLng : tour.hasTransport ? tour.transports.sLatLng[1] : 0,
    eLng : tour.hasTransport ? tour.transports.eLatLng[1] : 0,
    sDescription : tour.hasTransport ? tour.transports.sDescription : '',
    eDescription : tour.hasTransport ? tour.transports.eDescription : '',

    sideTransport: tour.sideTransport != null ? tour.sideTransport : [] ,
    // isSideTransportCost: tour.sideTransportCost == null ? 0 : 1,
    // sideTransportCost: tour.sideTransportCost != null ? tour.sideTransportCost : '',

    isMeal: tour.isMeal,
    isMealsAllDay: tour.isMealAllDay,
    // isMealCost: tour.isMealCost,
    // mealMoreCost: tour.mealMoreCost,
    allDayMeals: tour.isMealAllDay ? tour.meals : [],
    sepecificDayMeals: tour.isMealAllDay ? [] : tour.meals,

    otherLanguage: tour.language,

    hasTourGuid: tour.isTourGuide,
    isLocalTourGuide: tour.isLocalTourGuide,
    isSpecialTourGuid: tour.isSpecialTourGuid,
    isTourGuidDefined: tour.isTourGuidDefined,
    isTourGuidInKoochita: tour.isTourGuideInKoochita,
    koochitaUserId: tour.tourGuidKoochitaId,
    tourGuidName: tour.tourGuidName,
    tourGuidSex: tour.tourGuidSex,

    isBackUpPhone: tour.backupPhone == null ? 0 : 1,
    backUpPhone: tour.backupPhone,
};

function goToPrevStep(){
    openLoading(false, () => {
        location.href = prevStageUrl;
    })
}

var showSection = (_id = '', _element) => {
    _element = $(_element);
    var _value = _element.val();
    var name = _element.attr('name');

    _element.prop('checked', true);
    $(`input[name="${name}"]`).parent().removeClass('active');
    $(`input[name="${name}"]:checked`).parent().addClass('active');

    if(_id != '')
        $(`#${_id}`).css('display', _value == 1 ? 'block' : 'none');
};

function fillInputs(){
    showSection('tourMainTransports', $(`input[name="isTransportTour"][value="${storeData.isTransportTour}"]`));

    $('#sTransport').val(storeData.sTransportKind);
    $('#sTime').val(storeData.sTime);
    $('#sAddress').val(storeData.sAddress);
    $('#sDescription').val(storeData.sDescription);
    $('#sLat').val(storeData.sLat);
    $('#sLng').val(storeData.sLng);

    $('#eTransport').val(storeData.eTransportKind);
    $('#eTime').val(storeData.eTime);
    $('#eAddress').val(storeData.eAddress);
    $('#eDescription').val(storeData.eDescription);
    $('#eLat').val(storeData.eLat);
    $('#eLng').val(storeData.eLng);

    storeData.sideTransport.map(item => chooseMultiSelectSideTransport(item));
    // $('#sideTransportCost').val(numberWithCommas(storeData.sideTransportCost));
    // showSection('mainTransportCostDiv', $(`input[name="isCostForMainTransport"][value="${storeData.isSideTransportCost}"]`));

    showSection('mealsDiv', $(`input[name="isMeal"][value="${storeData.isMeal}"]`));

    // $('#mealCost').val(numberWithCommas(storeData.mealMoreCost));
    // showSection('mealCostDiv', $(`input[name="isMealCost"][value="${storeData.isMealCost}"]`));

    showSection('', $(`input[name="isMealsAllDay"][value="${storeData.isMealsAllDay}"]`));
    changeKindOfMeal(storeData.isMealsAllDay);
    if(storeData.isMealsAllDay == 1)
        storeData.allDayMeals.map(item => $(`input[name="meals[]"][value="${item}"]`).prop('checked', true));
    else{
        for(var day = 1; day <= tour.day; day++) {
            if(storeData.sepecificDayMeals[day - 1])
                storeData.sepecificDayMeals[day - 1].map(item => $(`input[name="meals_day_${day}"][value="${item}"]`).prop('checked', true));
        }
    }

    storeData.otherLanguage.map(item => chooseLanguageMultiSelect(language.indexOf(item)));

    showSection('isTourGuidDiv', $(`input[name="isTourGuide"][value="${storeData.hasTourGuid}"]`));
    showSection('', $(`input[name="isLocalTourGuide"][value="${storeData.isLocalTourGuide}"]`));
    showSection('', $(`input[name="isSpecialTourGuid"][value="${storeData.isSpecialTourGuid}"]`));
    showSection('isTourGuidDefinedDiv', $(`input[name="isTourGuidDefined"][value="${storeData.isTourGuidDefined}"]`));
    showSection('', $(`input[name="isTourGuidInKoochita"][value="${storeData.isTourGuidInKoochita}"]`));

    hasKoochitaAccount(storeData.isTourGuidInKoochita);
    $('#tourGuidName').val(storeData.tourGuidName);
    $('#tourGuidSex').val(storeData.tourGuidSex);
    $('#tourGuidUserId').val(storeData.koochitaUserId);
    $('#tourGuidKoochitaUsername').val(storeData.koochitaUserUsername);

    showSection('backUpPhoneDiv', $(`input[name="isBackUpPhone"][value="${storeData.isBackUpPhone}"]`));
    $('#backUpPhone').val(storeData.backUpPhone);
}

function initLanguage(){
    var text = '';
    language.map((item, index) => text += `<div class="optionMultiSelect" id="multiSelectLanguage_${index}" onclick="chooseLanguageMultiSelect(${index})">${item}</div>`);
    $("#multiSelectLanguage").html(text);
}

function openMultiSelect(_element){
    if(multiIsOpen){
        $(_element).next().hide();
        multiIsOpen = false;
    }
    else{
        $(_element).next().show();
        multiIsOpen = true;
    }
}

function chooseMultiSelectSideTransport(_id){
    var choose = 0;
    var text = '';

    for(i = 0; i < transports.length; i++){
        if(transports[i].id == _id){
            choose = transports[i];
            break;
        }
    }

    if(choose != 0)
        document.getElementById('multiSelectTransport_' + choose.id).style.display = 'none';


    text = `<div id="selectedMulti_${choose.id}" class="transportationKindChosenOnes col-xs-2">
                ${choose.name}
                <span class="glyphicon glyphicon-remove" onclick="removeMultiSelectSideTransport(${choose.id})"></span>
            </div>`;
    $('#multiSelected').append(text);


    if(chooseSideTransport.includes(0)){
        index = chooseSideTransport.indexOf(0);
        chooseSideTransport[index] = choose.id;
    }
    else
        chooseSideTransport[chooseSideTransport.length] = choose.id;

}
function removeMultiSelectSideTransport(_id){
    $('#selectedMulti_' + _id).remove();
    document.getElementById('multiSelectTransport_' + _id).style.display = 'block';
    if(chooseSideTransport.includes(_id)){
        index = chooseSideTransport.indexOf(_id);
        chooseSideTransport[index] = 0;
    }
}

function chooseLanguageMultiSelect(_index){
    if(languageChoose.indexOf(language[_index]) == -1) {
        languageChoose[languageChoose.length] = language[_index];
        $(`#multiSelectLanguage_${_index}`).css('display', 'none');

        var text = `<div id="selectedMultiLanguage_${_index}" class="transportationKindChosenOnes col-xs-2">${language[_index]}
                        <span class="glyphicon glyphicon-remove" onclick="removeMultiSelectLanguage(${_index})"></span>
                    </div>`;
        $('#multiSelectedLanguage').append(text);
    }
}
function removeMultiSelectLanguage(_index){
    $('#selectedMultiLanguage_' + _index).remove();
    $(`#multiSelectLanguage_${_index}`).css('display', 'block');
    if(languageChoose.includes(language[_index])){
        var index = languageChoose.indexOf(language[_index]);
        languageChoose.splice(index, 1);
    }
}

function changeKindOfMeal(_value){
    $('#selectKindOfMealAllDay').css('display', _value == 1 ? 'inline-block' : 'none');
    $('#selectMealDays').css('display', _value == 1 ? 'none' : 'block');
}

function hasKoochitaAccount(_value){
    $('#notKoochitaAccountDiv').css('display', _value == 1 ? 'none' : 'block');
    $('#haveKoochitaAccountDiv').css('display', _value == 1 ? 'block' : 'none');
}

function openSearchKoochitaAccount() {
    openKoochitaUserSearchModal('راهنمای تور خود را مشخص کنید', (_id, _username) => {
        $('#tourGuidKoochitaUsername').val(_username);
        $('#tourGuidUserId').val(_id);
    })
}

function checkInput(_isMainStore = true){
    var errorText = '';

    storeData = {
        isTransportTour : $('input[name="isTransportTour"]:checked').val(),
        sTransportKind : $('#sTransport').val(),
        eTransportKind : $('#eTransport').val(),
        sTime : $('#sTime').val(),
        eTime : $('#eTime').val(),
        sAddress : $('#sAddress').val(),
        eAddress : $('#eAddress').val(),
        sLat : $('#sLat').val(),
        eLat : $('#eLat').val(),
        sLng : $('#sLng').val(),
        eLng : $('#eLng').val(),
        sDescription : $('#sDescription').val(),
        eDescription : $('#eDescription').val(),

        sideTransport: chooseSideTransport,
        // isSideTransportCost: $('input[name="isCostForMainTransport"]:checked').val(),
        // sideTransportCost: $('#sideTransportCost').val().replace(new RegExp(',', 'g'), ''),

        isMeal: $('input[name="isMeal"]:checked').val(),
        isMealsAllDay: $('input[name="isMealsAllDay"]:checked').val(),
        // isMealCost: $('input[name="isMealCost"]:checked').val(),
        // mealMoreCost: $('#mealCost').val().replace(new RegExp(',', 'g'), ''),
        allDayMeals: [],
        sepecificDayMeals: [],

        otherLanguage: languageChoose,

        hasTourGuid: $('input[name="isTourGuide"]:checked').val(),
        isLocalTourGuide: $('input[name="isLocalTourGuide"]:checked').val(),
        isSpecialTourGuid: $('input[name="isSpecialTourGuid"]:checked').val(),
        isTourGuidDefined: $('input[name="isTourGuidDefined"]:checked').val(),
        isTourGuidInKoochita: $('input[name="isTourGuidInKoochita"]:checked').val(),
        koochitaUserId: $('#tourGuidUserId').val(),
        koochitaUserUsername: $('#tourGuidKoochitaUsername').val(),
        tourGuidName: $('#tourGuidName').val(),
        tourGuidSex: $('#tourGuidSex').val(),

        isBackUpPhone: $('input[name="isBackUpPhone"]:checked').val(),
        backUpPhone: $('#backUpPhone').val(),
    };

    if(storeData.isTransportTour == 1){
        if(storeData.sTransportKind.trim().length == 0)
            errorText += '<li>نوع وسیله رفت را مشخص کنید</li>';

        if(storeData.sTime.trim().length == 0)
            errorText += '<li>ساعت رفت را مشخص کنید</li>';

        if(storeData.sAddress.trim().length == 0)
            errorText += '<li>محل رفت را مشخص کنید</li>';

        if(storeData.sLat == 0 || storeData.sLng == 0)
            errorText += '<li>محل رفت را روی نقشه مشخص کنید</li>';

        if(storeData.eTransportKind.trim().length == 0)
            errorText += '<li>نوع وسیله برگشت را مشخص کنید</li>';

        if(storeData.eTime.trim().length == 0)
            errorText += '<li>ساعت برگشت را مشخص کنید</li>';

        if(storeData.eAddress.trim().length == 0)
            errorText += '<li>محل برگشت را مشخص کنید</li>';

        if(storeData.eLat == 0 || storeData.eLng == 0)
            errorText += '<li>محل برگشت را روی نقشه مشخص کنید</li>';
    }

    if(storeData.isSideTransportCost == 1 && storeData.sideTransportCost.trim().length == 0)
        errorText += '<li>هزینه ی اضافی حمل و نقل فرعی را مشخص کنید</li>';

    if(storeData.isMeal == 1){
        if(storeData.isMealsAllDay == 1){
            var meals = $('input[name="meals[]"]:checked');
            for(var i = 0; i < meals.length; i++)
                storeData.allDayMeals.push($(meals[i]).val());
        }
        else{
            for(var day = 1; day <= tour.day; day++){
                storeData.sepecificDayMeals[day-1] = [];
                var dayMeals = $(`input[name="meals_day_${day}"]:checked`);
                for(var i = 0; i < dayMeals.length; i++)
                    storeData.sepecificDayMeals[day-1].push($(dayMeals[i]).val());
            }
        }
        // if(storeData.isMealCost == 1 && storeData.mealMoreCost.trim().length == 0)
        //     errorText += '<li>هزینه ی اضافی غذا را مشخص کنید</li>';

    }

    if(storeData.hasTourGuid == 1){
        if(storeData.isTourGuidDefined == 1){
            if(storeData.isTourGuidInKoochita == 1 && storeData.koochitaUserId == 0)
                errorText += '<li>نام کاربری راهنمای تور را مشخص کنید</li>';
            else if(storeData.isTourGuidInKoochita == 0 && storeData.tourGuidName.trim().length == 0)
                errorText += '<li>نام راهنمای تور را وارد کنید</li>';
        }
    }


    if(_isMainStore) {
        if (errorText.trim().length == 0) {
            openLoading();
            $.ajax({
                type: 'POST',
                url: storeStageThreeURL,
                data: {
                    _token: csrfTokenGlobal,
                    tourId: tour.id,
                    data: JSON.stringify(storeData)
                },
                success: response => {
                    if (response.status == 'ok') {
                        localStorage.removeItem(`stageThreeTourCreation_${tour.id}`);
                        location.href = nextStageUrl;
                    }
                }
            })
        }
        else
            openErrorAlert(errorText);
    }
    else
        localStorage.setItem(`stageThreeTourCreation_${tour.id}`, JSON.stringify(storeData));
}

function doLastUpdate(){
    storeData = JSON.parse(lastData);
    fillInputs();
}

var lastData = localStorage.getItem(`stageThreeTourCreation_${tour.id}`);
if(!(lastData == false || lastData == null))
    openWarning('بازگرداندن اطلاعات قبلی', doLastUpdate, 'بله قبلی را ادامه می دهم');
setInterval(() => checkInput(false), 5000);


$(window).ready(() => {
    $('.clock').clockpicker(clockOptions);
    initLanguage();
    fillInputs();
}).on('click', e => {
    var target = $(e.target);
    if( multiIsOpen  && !target.is('.optionMultiSelect') && !target.is('.multiSelected'))
        $('.multiselect').hide();
});



var map;
var srcLatLng = tour.srcLatLng;
var destLatLng = tour.destLatLng;
var sMarker = 0;
var eMarker = 0;
var mapType;
var mapIsOpen = false;

var mainMap = null;

function initMapIr(){
    if(mainMap == null) {
        mainMap = L.map("mapDiv", {
            minZoom: 1,
            maxZoom: 20,
            crs: L.CRS.EPSG3857,
            center: [32.42056639964595, 54.00537109375],
            zoom: 6
        }).on('click', e => {
            setMarkerToMap(e.latlng.lat, e.latlng.lng);
        });
        L.TileLayer.wmsHeader(
            "https://map.ir/shiveh",
            {
                layers: "Shiveh:Shiveh",
                format: "image/png",
                minZoom: 1,
                maxZoom: 20
            },
            [
                {
                    header: "x-api-key",
                    value: window.mappIrToken
                }
            ]
        ).addTo(mainMap);

        if(storeData.sLat != 0 && storeData.sLng != 0)
            setMarkerToMap(storeData.sLat, storeData.sLng, 'src');
        if(storeData.eLat != 0 && storeData.eLng != 0)
            setMarkerToMap(storeData.eLat, storeData.eLng, 'dest');

    }
}

function changeCenter(_kind){
    mapIsOpen = _kind;
    setTimeout(() => {
        initMapIr();

        var lat = 32.42056639964595;
        var lng = 54.00537109375;
        var zoom = 6;

        if(_kind === 'src'){
            if(sMarker === 0 && tour.srcCityLocation.lat && tour.srcCityLocation.lng){
                lat = parseFloat(tour.srcCityLocation.lat);
                lng = parseFloat(tour.srcCityLocation.lng);
                zoom = 10;
            }
            else if(sMarker != 0){
                lat = parseFloat(document.getElementById('sLat').value);
                lng = parseFloat(document.getElementById('sLng').value);
                zoom = 16;
            }
        }
        else{
            if(eMarker === 0 && tour.destCityLocation.lat && tour.destCityLocation.lng){
                lat = parseFloat(tour.destCityLocation.lat);
                lng = parseFloat(tour.destCityLocation.lng);
                zoom = 10;
            }
            else if(eMarker != 0){
                lat = parseFloat(document.getElementById('eLat').value);
                lng = parseFloat(document.getElementById('eLng').value);
                zoom = 16;
            }
        }
        mainMap.setView([lat, lng], zoom);
    }, 500);
}

function setMarkerToMap(_lat, _lng, _type = mapIsOpen){
    if(_type == 'src'){
        if(sMarker != 0)
            mainMap.removeLayer(sMarker);
        sMarker = L.marker([_lat, _lng]).addTo(mainMap);
        document.getElementById('sLat').value = parseFloat(_lat);
        document.getElementById('sLng').value = parseFloat(_lng);
    }
    else{
        if(eMarker != 0)
            mainMap.removeLayer(eMarker);
        eMarker = L.marker([_lat, _lng]).addTo(mainMap);

        document.getElementById('eLat').value = parseFloat(_lat);
        document.getElementById('eLng').value = parseFloat(_lng);
    }
}

// function init(){
//     var mapOptions = {
//         zoom: 5,
//         center: new google.maps.LatLng(32.42056639964595, 54.00537109375),
//         // How you would like to style the map.
//         // This is where you would paste any style found on Snazzy Maps.
//         styles: [{
//             "featureType": "landscape",
//             "stylers": [{"hue": "#FFA800"}, {"saturation": 0}, {"lightness": 0}, {"gamma": 1}]
//         }, {
//             "featureType": "road.highway",
//             "stylers": [{"hue": "#53FF00"}, {"saturation": -73}, {"lightness": 40}, {"gamma": 1}]
//         }, {
//             "featureType": "road.arterial",
//             "stylers": [{"hue": "#FBFF00"}, {"saturation": 0}, {"lightness": 0}, {"gamma": 1}]
//         }, {
//             "featureType": "road.local",
//             "stylers": [{"hue": "#00FFFD"}, {"saturation": 0}, {"lightness": 30}, {"gamma": 1}]
//         }, {
//             "featureType": "water",
//             "stylers": [{"hue": "#00BFFF"}, {"saturation": 6}, {"lightness": 8}, {"gamma": 1}]
//         }, {
//             "featureType": "poi",
//             "stylers": [{"hue": "#679714"}, {"saturation": 33.4}, {"lightness": -25.4}, {"gamma": 1}]
//         }]
//     };
//     var mapElementSmall = document.getElementById('map');
//     map = new google.maps.Map(mapElementSmall, mapOptions);
//
//     google.maps.event.addListener(map, 'click', function(event) {
//         getLat(event.latLng);
//     });
// }
//
// function getLat(location){
//     if(mapType == 'src') {
//         if (sMarker != 0) {
//             sMarker.setMap(null);
//         }
//         sMarker = new google.maps.Marker({
//             position: location,
//             map: map,
//             title: 'محل رفت'
//         });
//
//         document.getElementById('sLat').value = sMarker.getPosition().lat();
//         document.getElementById('sLng').value = sMarker.getPosition().lng();
//
//     }
//     else{
//         if (eMarker != 0) {
//             eMarker.setMap(null);
//         }
//         eMarker = new google.maps.Marker({
//             position: location,
//             map: map,
//             title: 'محل بازگشت'
//         });
//         document.getElementById('eLat').value = eMarker.getPosition().lat();
//         document.getElementById('eLng').value = eMarker.getPosition().lng();
//     }
// }
//
// function changeCenter(kind){
//     map.setZoom(12);
//     mapType = kind;
//
//     if(kind == 'src')
//         map.panTo({lat: srcLatLng[0], lng: srcLatLng[1]});
//     else
//         map.panTo({lat: destLatLng[0], lng: destLatLng[1]});
//
// }
