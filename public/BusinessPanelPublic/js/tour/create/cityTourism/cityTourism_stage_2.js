var inKoochita = 0 ;
var multiIsOpen = false;
var language = [
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
var map;
var srcLatLng = tour.srcLatLng;
var destLatLng = tour.destLatLng;
var sMarker = 0;
var eMarker = 0;
var mapType;
var mapIsOpen = false;
var mainMap = null;

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

    otherLanguage: tour.language,

    hasTourGuid: tour.isTourGuide,
    isLocalTourGuide: tour.isLocalTourGuide,
    isSpecialTourGuid: tour.isSpecialTourGuid,
    isTourGuidDefined: tour.isTourGuidDefined,
    isTourGuidInKoochita: tour.isTourGuideInKoochita,
    koochitaUserId: tour.tourGuidKoochitaId,
    koochitaUserUsername: tour.koochitaUserUsername,
    tourGuidName: tour.tourGuidName,
    tourGuidSex: tour.tourGuidSex,
    tourGuidPhone: tour.tourGuidPhone,

    backUpPhone: tour.backupPhone,
};

function fillInputs(){
    $('#sTransport').val(storeData.sTransportKind);
    $('#sTime').val(storeData.sTime);
    $('#sAddress').val(storeData.sAddress);
    $('#sDescription').val(storeData.sDescription);
    $('#sLat').val(storeData.sLat);
    $('#sLng').val(storeData.sLng);

    $('#eTime').val(storeData.eTime);
    $('#eAddress').val(storeData.eAddress);
    $('#eDescription').val(storeData.eDescription);
    $('#eLat').val(storeData.eLat);
    $('#eLng').val(storeData.eLng);

    if(storeData.otherLanguage) {
        storeData.otherLanguage.map(item => chooseLanguageMultiSelect(language.indexOf(item)));
        $('input[name="hasOtherLanguage"]').parent().removeClass('active');
        $('input[name="hasOtherLanguage"][value="1"]').prop('checked', true).parent().addClass('active');
        changeOtherLanguage(1);
    }

    showSection('isTourGuidDiv', $(`input[name="isTourGuide"][value="${storeData.hasTourGuid}"]`)[0], true);
    showSection('', $(`input[name="isLocalTourGuide"][value="${storeData.isLocalTourGuide}"]`)[0]), true;
    showSection('', $(`input[name="isSpecialTourGuid"][value="${storeData.isSpecialTourGuid}"]`)[0], true);
    showSection('isTourGuidDefinedDiv', $(`input[name="isTourGuidDefined"][value="${storeData.isTourGuidDefined}"]`)[0], true);
    showSection('', $(`input[name="isTourGuidInKoochita"][value="${storeData.isTourGuidInKoochita}"]`)[0], true);

    hasKoochitaAccount(storeData.isTourGuidInKoochita);
    $('#tourGuidName').val(storeData.tourGuidName);
    $('#tourGuidSex').val(storeData.tourGuidSex);
    $('#tourGuidPhone').val(storeData.tourGuidPhone);
    $('#tourGuidUserId').val(storeData.koochitaUserId);
    $('#tourGuidKoochitaUsername').val(storeData.koochitaUserUsername);

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

function chooseLanguageMultiSelect(_index){
    if(languageChoose.indexOf(language[_index]) == -1) {
        languageChoose[languageChoose.length] = language[_index];
        $(`#multiSelectLanguage_${_index}`).css('display', 'none');

        var text = `<div id="selectedMultiLanguage_${_index}" class="transportationKindChosenOnes col-md-2">${language[_index]}
                        <i class="fa-regular fa-xmark" onclick="removeMultiSelectLanguage(${_index})" style="color: red;"></i>
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

function goToPrevStep(){
    openLoading(false, () => location.href = prevStageUrl);
}

function showSection(_id = '', _element, _fromJs = false){
    var _value = _element.value;
    var name = _element.getAttribute('name');

    _element.checked = true;

    if(_fromJs) {
        [...document.querySelectorAll(`input[name="${name}"]`)].map(item => item.parentElement.classList.remove('active'));
        document.querySelector(`input[name="${name}"]:checked`).parentElement.classList.add('active');
    }

    if(_id != '')
        $(`#${_id}`).css('display', _value == 1 ? 'block' : 'none');
}

function changeOtherLanguage(_value){
    if(_value == 1)
        document.getElementById('otherLanguageSection').classList.remove('hidden');
    else
        document.getElementById('otherLanguageSection').classList.add('hidden');
}

function checkInput(_isMainStore = true){
    var errorText = '';

    storeData = {
        isTransportTour : 1,
        sTransportKind : $('#sTransport').val(),
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
        tourGuidPhone: $('#tourGuidPhone').val(),

        backUpPhone: $('#backUpPhone').val(),
    };

    if(storeData.sTransportKind == 0)
        errorText += '<li>نوع وسیله رفت و آمد را مشخص کنید</li>';

    if(storeData.sTime.trim().length == 0)
        errorText += '<li>ساعت حرکت را مشخص کنید</li>';

    if(storeData.sAddress.trim().length == 0)
        errorText += '<li>آدرس دقیق محل حرکت را مشخص کنید</li>';

    if(storeData.sLat == 0 || storeData.sLng == 0)
        errorText += '<li>محل حرکت را روی نقشه مشخص کنید</li>';

    if(storeData.eTime.trim().length == 0)
        errorText += '<li>ساعت پیاده شدن را مشخص کنید</li>';

    if(storeData.eAddress.trim().length == 0)
        errorText += '<li>آدرس دقیق محل پیاده شدن را مشخص کنید</li>';

    if(storeData.eLat == 0 || storeData.eLng == 0)
        errorText += '<li>محل پیاده شدن را روی نقشه مشخص کنید</li>';

    if(storeData.hasTourGuid == 1 && storeData.isTourGuidDefined == 1){
        if(storeData.isTourGuidInKoochita == 1 && storeData.koochitaUserId == 0)
            errorText += '<li>نام کاربری راهنمای تور را مشخص کنید</li>';
        else if(storeData.isTourGuidInKoochita == 0){
            if(storeData.tourGuidName.trim().length == 0)
                errorText += '<li>نام راهنمای تور را وارد کنید</li>';

            if(storeData.tourGuidPhone.trim().length == 0)
                errorText += '<li>شماره تماس راهنمای تور را وارد کنید</li>';
            else if(storeData.tourGuidPhone[0] != 0 || storeData.tourGuidPhone[1] != 9)
                errorText += '<li>شماره همراه راهنمای تور را به درستی وارد کنید</li>';
        }
    }

    if(storeData.backUpPhone.trim().length === 0)
        errorText += '<li>وارد کردن تلفن پشتیبانی برای این تور اجباری است.</li>';


    if(_isMainStore) {
        if (errorText.trim().length == 0) {
            openLoading();
            $.ajax({
                type: 'POST',
                url: storeStageURL,
                data: {
                    _token: csrfTokenGlobal,
                    tourId: tour.id,
                    data: storeData
                },
                success: response => {
                    if (response.status == 'ok') {
                        localStorage.removeItem(`stageThreeTourCreation_${tour.id}`);
                        location.href = nextStageUrl;
                    }
                    else{
                        openErrorAlertBP('در ثبت مشکلی پیش امده لطفا دوباره تلاش کنید');
                        closeLoading();
                    }
                },
                error: err => {
                    console.error(err);
                    openErrorAlertBP('در ثبت مشکلی پیش امده لطفا دوباره تلاش کنید');
                    closeLoading();
                }
            })
        }
        else
            openErrorAlertBP(errorText);
    }
    else
        localStorage.setItem(`stageThreeTourCreation_${tour.id}`, JSON.stringify(storeData));
}

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
                    value: mappIrToken
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
    $('#modalMap').modal('show');
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

$(window).ready(() => {
    $('.clock').clockpicker(clockOptions);
    initLanguage();
    fillInputs();
}).on('click', e => {
    var target = $(e.target);
    if( multiIsOpen  && !target.is('.optionMultiSelect') && !target.is('.multiSelected'))
        $('.multiselect').hide();
});
