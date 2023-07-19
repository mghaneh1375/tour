
var clockOptions = {
    placement: 'left',
    donetext: 'تایید',
    autoclose: true,
};
var lastAjax = null;
var mealWhere = null;
let paths = [];
let events = [];
var eventsMarkerInSpecialMap = [];
var markerForSpecial = null;
var specialMap = null;
let moveMarker = null;
let mainMap = null;
var moveIconTime = 0;
var moveIconInterval = null;
var startMarker = null;
var endMarker = null;
let typesTitles = {'place' : 'بازدید ', 'meal' : 'وعده غذایی ', 'special' : 'برنامه ویژه '};



function searchForRestaurantForNewPlace(_value){
    let responseFunction = response => {
        if(response.status == 'ok') {
            let html = '';
            response.result.forEach(item => {
                html += `<div class="res" data-id="${item.id}" data-name="${item.name}" data-img="${item.pic}" data-kindPlaceId="${item.kindPlaceId}" onclick="chooseThisMealPlace(this)">
                                <span>${item.name}</span>
                                <span class="light"> (در شهر ${item.cityName})</span>
                            </div>`;
            });
            document.querySelector('#mealSearchResultSec .loader').classList.add('hidden');
            document.querySelector('#mealSearchResultSec .resContent').classList.remove('hidden');
            document.querySelector('#mealSearchResultSec .resContent').innerHTML = html;
        }
        else{
            console.error(response.status);
            document.querySelector('#mealSearchResultSec .loader').classList.add('hidden');
            document.querySelector('#mealSearchResultSec .resContent').classList.remove('hidden');
            document.querySelector('#mealSearchResultSec .resContent').innerHTML = '';
        }
    };


    if(_value.trim().length > 1){
        document.getElementById('mealSearchResultSec').classList.remove('hidden');
        document.querySelector('#mealSearchResultSec .loader').classList.remove('hidden');
        document.querySelector('#mealSearchResultSec .resContent').classList.add('hidden');

        if(mealWhere === 'amaken')
            ajaxSearchAmaken(_value, responseFunction);
        else
            ajaxSearchRestaurant(_value, responseFunction);
    }
    else{
        document.getElementById('mealSearchResultSec').classList.add('hidden');
        document.querySelector('#mealSearchResultSec .resContent').innerHTML = '';
    }
}
function chooseThisMealPlace(_element){
    let id   = _element.getAttribute('data-id');
    let name = _element.getAttribute('data-name');
    let pic  = _element.getAttribute('data-img');
    let kindPlaceId  = _element.getAttribute('data-kindPlaceId');

    let inputElement = document.getElementById('newRestaurantName');

    document.getElementById('mealSearchResultSec').classList.add('hidden');
    document.getElementById('newRestaurantName').value = name;

    inputElement.setAttribute('data-id', id);
    inputElement.setAttribute('data-name', name);
    inputElement.setAttribute('data-img', pic);
    inputElement.setAttribute('data-kindPlaceId', kindPlaceId);
}

function searchForAmakenForNewPlace(_value){
    if(_value.trim().length > 1){
        document.getElementById('amakenSearchResultSec').classList.remove('hidden');
        document.querySelector('#amakenSearchResultSec .loader').classList.remove('hidden');
        document.querySelector('#amakenSearchResultSec .resContent').classList.add('hidden');

        ajaxSearchAmaken(_value, response => {
            if(response.status == 'ok') {
                let html = '';
                response.result.forEach(item => {
                    html += `<div class="res" data-id="${item.id}" data-name="${item.name}" data-img="${item.pic}" data-kindPlaceId="${item.kindPlaceId}" onclick="chooseThisAmaken(this)">
                                                <span>${item.name}</span>
                                                <span class="light"> (در شهر ${item.cityName})</span>
                                            </div>`;
                });
                document.querySelector('#amakenSearchResultSec .loader').classList.add('hidden');
                document.querySelector('#amakenSearchResultSec .resContent').classList.remove('hidden');
                document.querySelector('#amakenSearchResultSec .resContent').innerHTML = html;
            }
            else{
                console.error(response.status);
                document.querySelector('#amakenSearchResultSec .loader').classList.add('hidden');
                document.querySelector('#amakenSearchResultSec .resContent').classList.remove('hidden');
                document.querySelector('#amakenSearchResultSec .resContent').innerHTML = '';
            }
        });
    }
    else{
        document.getElementById('amakenSearchResultSec').classList.add('hidden');
        document.querySelector('#amakenSearchResultSec .resContent').innerHTML = '';
    }
}
function chooseThisAmaken(_element){
    let id   = _element.getAttribute('data-id');
    let name = _element.getAttribute('data-name');
    let pic  = _element.getAttribute('data-img');
    let kindPlaceId  = _element.getAttribute('data-kindPlaceId');

    let inputElement = document.getElementById('newAmakenName');

    document.getElementById('amakenSearchResultSec').classList.add('hidden');
    document.getElementById('newAmakenName').value = name;
    document.getElementById('newAmakenNameTitle').innerText = name;

    inputElement.setAttribute('data-id', id);
    inputElement.setAttribute('data-name', name);
    inputElement.setAttribute('data-img', pic);
    inputElement.setAttribute('data-kindPlaceId', kindPlaceId);
}

function ajaxSearchAmaken(_value, _callBack){
    if(lastAjax != null)
        lastAjax.abort();

    lastAjax = $.ajax({
        type: 'POST',
        url: searchPlaceWithNameKinPlaceIdUrl,
        data:{
            _token: csrfTokenGlobal,
            value: _value,
            kindPlaceIds: [1, 6]
        },
        success: response => {
            if(response.status === 'ok')
                _callBack({
                    status: 'ok',
                    result: response.result
                });
            else
                _callBack({
                    status: response.status,
                });

        },
        error: err => {
            _callBack({
                status: err,
            });
        }
    })
}
function ajaxSearchRestaurant(_value, _callBack){
    if(lastAjax != null)
        lastAjax.abort();

    lastAjax = $.ajax({
        type: 'POST',
        url: searchPlaceWithNameKinPlaceIdUrl,
        data:{
            _token: csrfTokenGlobal,
            value: _value,
            kindPlaceIds: [3]
        },
        success: response => {
            if(response.status === 'ok')
                _callBack({
                    status: 'ok',
                    result: response.result
                });
            else
                _callBack({
                    status: response.status,
                });

        },
        error: err => {
            _callBack({
                status: err,
            });
        }
    })
}

function submitSchedule(){
    openLoading();

    let sendData = [];
    events.forEach(item => {
        sendData.push({
            id: item.id,
            type: item.type,
            title: item.title,
            description: item.description,
            lat: item.lat,
            lng: item.lng,
            sTime: item.sTime,
            eTime: item.eTime,
            placeId: item.placeId,
            kindPlaceId: item.kindPlaceId,
            number: item.number,
        });
    });

    $.ajax({
        type: 'POST',
        url: stageStoreUrl,
        data: {
            tourId: tour.id,
            events: sendData,
        },
        success: response =>{
            if(response.status == 'ok') {
                localStorage.removeItem(`planeDate_${tour.id}`);
                location.href = nextStageUrl;
            }
            else{
                closeLoading();
                showSuccessNotifiBP('ثبت در خواست با مشکل مواچه شد', 'left', 'red');
            }
        },
        error: err => {
            closeLoading();
            showSuccessNotifiBP('ثبت در خواست با مشکل مواچه شد', 'left', 'red');
        }
    })
}

function goToPrevStep(){
    openLoading(false, () => {
        location.href = prevStageUrl;
    })
}

function openNewEventModal(){
    document.getElementById('newEventModalTitle').innerText = 'ثبت برنامه جدید';
    document.getElementById('submitEventButton').innerText = 'ثبت برنامه';

    [...document.querySelectorAll('.eventInputSection')].map(item => item.classList.add('hidden'));
    [...document.querySelectorAll('input[name="eventType"]')].map(item => {
        item.parentElement.classList.remove('selected');
        item.parentElement.classList.remove('disabled');
        item.disabled = false;
        item.checked = false;
    });

    document.getElementById('newAmakenName').readOnly = false;
    document.getElementById('newRestaurantName').readOnly = false;


    let options = '<option value="-1">اولین برنامه</option>';
    events.forEach((item, index) => {
        options += `<option value="${index+1}">بعد از ${item.title}</option>`;
    });
    options += '<option value="-2" selected>اخرین برنامه</option>';

    document.getElementById('eventPosition').innerHTML = options;

    document.getElementById('eventId').value = 0;
    document.getElementById('eventCode').value = 0;

    openMyModalBP('addNewEventModal');
}

function changeEventType(_element){
    let type = _element.value;

    [...document.querySelectorAll(`input[name="eventType"]`)].map(item => item.parentElement.classList.remove('selected'));

    _element.parentElement.classList.add('selected');

    [...document.querySelectorAll('.eventInputSection')].map(item => item.classList.add('hidden'));

    document.getElementById(`${type}_eventInputs`).classList.remove('hidden');
}

function mealInRestaurant(_value){
    if(_value == 1)
        document.getElementById('mealInRestaurantSection').classList.remove('hidden');
    else
        document.getElementById('mealInRestaurantSection').classList.add('hidden');
}

function specialInMap(_value){
    if(_value == 1)
        document.getElementById('specialMapSection').classList.remove('hidden');
    else
        document.getElementById('specialMapSection').classList.add('hidden');
}

async function submitNewEvent(){
    openLoading();

    let index = null;
    let sTime = '';
    let eTime = '';
    let place = null;
    let placeId = 0;
    let kindPlaceId = 0;
    let title = '';
    let description = '';
    let lat = 0;
    let lng = 0;
    let picture = defaultPicture;

    if(document.querySelector('input[name="eventType"]:checked') === null){
        openErrorAlertBP('نوع برنامه را مشخص کنید.');
        closeLoading();
        return;
    }
    let type = document.querySelector('input[name="eventType"]:checked').value;
    let position = parseInt(document.getElementById('eventPosition').value);

    let id = document.getElementById('eventId').value;
    let code = document.getElementById('eventCode').value;

    if(code != 0){
        for(let i = 0; i < events.length; i++){
            if(events[i].code == code){
                index = i;
                break;
            }
        }
    }

    if(type === 'place'){
        let inputElement = document.getElementById('newAmakenName');
        sTime = document.getElementById('startTimeNewAmaken').value;
        eTime = document.getElementById('endTimeNewAmaken').value;

        kindPlaceId = inputElement.getAttribute('data-kindPlaceId');
        placeId = inputElement.getAttribute('data-id');

        let hasThisPlace = false;
        events.forEach(item => {
            if(item.type === 'place' && item.placeId == placeId && item.kindPlaceId == kindPlaceId && item.code != code)
                hasThisPlace = true;
        });

        if(hasThisPlace){
            openErrorAlertBP('این محل در برنامه شما ثبت شده است.');
            closeLoading();
            return;
        }

        if(code == 0) {
            let placeInformation = await getPlaceInfoForPlan(placeId, kindPlaceId);
            if (placeInformation.error) {
                closeLoading();
                showSuccessNotifiBP('خطا در دریافت اطلاعات', 'left', 'red');
                return;
            }
            place = placeInformation.place;
        }
        else
            place = events[index].place;

        lat = place.lat;
        lng = place.lng;
        picture = place.pics[0];
        title = place.name;
        description = place.description;
    }
    else if(type === 'meal'){
        title = 'وعده غذایی';

        let inRestaurant = document.querySelector('input[name="inRestaurant"]:checked').value;
        if(inRestaurant == 1) {
            let inputElement = document.getElementById('newRestaurantName');

            kindPlaceId = inputElement.getAttribute('data-kindPlaceId');
            placeId = inputElement.getAttribute('data-id');

            let placeInformation = await getPlaceInfoForPlan(placeId, kindPlaceId);
            if(placeInformation.error){
                closeLoading();
                showSuccessNotifiBP('خطا در دریافت اطلاعات', 'left', 'red');
                return;
            }
            place = placeInformation.place;
            lat = place.lat;
            lng = place.lng;
            picture = place.pics[0];
            title = place.name;
            description = place.description;
        }

        sTime = document.getElementById('startTimeNewMeal').value;
        eTime = document.getElementById('endTimeNewMeal').value;
    }
    else if(type === 'special'){
        title = document.getElementById('nameForSpecial').value;
        description = document.getElementById('descriptionForSpecial').value;
        sTime = document.getElementById('startTimeNewSpecial').value;
        eTime = document.getElementById('endTimeNewSpecial').value;

        if(title.trim().length === 0){
            alert('عنوان برنامه نمی تواند خالی باشد.');
            closeLoading();
            return;
        }

        let hasMap = document.querySelector('input[name="specialHasLocation"]:checked').value;

        if(hasMap == 1){
            lat = document.getElementById('latForSpecial').value;
            lng = document.getElementById('lngForSpecial').value;

            if(lat == 0 || lng == 0){
                alert('محل را روی نقشه مشخص کنید.');
                closeLoading();
                return;
            }
        }
    }

    let timeErrorText = '';
    if(sTime != '' && eTime != '') {
        if (sTime >= eTime)
            timeErrorText = 'ساعت پایان نمی تواند قبل از شروع باشد.';
        else if (sTime < tour.start.time)
            timeErrorText = 'ساعت شروع این برنامه نمی تواند قبل از شروع حرکت باشد.';
        else if (eTime > tour.end.time)
            timeErrorText = 'ساعت پایان این برنامه نمی تواند بعد از پایان تور باشد.';
        else {
            events.forEach((item, _index) => {
                if (_index != index) {
                    if (item.sTime != '' && item.eTime != '') {
                        if (!((item.sTime > sTime && item.sTime > eTime) || (item.eTime < sTime && item.eTime < eTime))) {
                            let title = `${typesTitles[item.type]} ${item.number}`;
                            timeErrorText = `ساعت شروع و پایان این برنامه با برنامه ${title} تداخل زمانی دارد.`;
                        }
                    }
                }
            });
        }

        if (timeErrorText !== '') {
            openErrorAlertBP(timeErrorText);
            closeLoading();
            return;
        }
    }


    if(index != null){
        events[index] = {
            ...events[index],
            id,
            title,
            description,
            lat,
            lng,
            sTime,
            eTime,
            place,
            placeId,
            kindPlaceId,
            number: 0,
        };

        if(index != position){
            let editedEvent = events[index];
            if(position == -1) {
                events.splice(index, 1);
                events.unshift(editedEvent);
            }
            else if(position == -2){
                events.splice(index, 1);
                events.push(editedEvent);
            }
            else{
                events[index] = null;
                events.splice(position, 0, editedEvent);
                for(let i = 0; i < events.length; i++){
                    if(events[i] === null){
                        events.splice(i, 1);
                        break;
                    }
                }
            }
        }
    }
    else{
        let event = {
            id,
            type,
            title,
            description,
            picture,
            lat,
            lng,
            sTime,
            eTime,
            place,
            placeId,
            kindPlaceId,
            number: 0,
            marker: null,
            code: code == 0 ? Math.floor(Math.random() * 100000000) : code,
        };

        let newEventsList = [];

        if(position == -1)
            newEventsList.push(event);
        events.forEach((item, index) => {
            newEventsList.push(item);
            if(index == position-1)
                newEventsList.push(event);
        });
        if(position == -2)
            newEventsList.push(event);

        events = newEventsList;
    }

    let numbers = { place: 0, meal: 0, special: 0 };
    events.forEach(item => {
        let showNumber;
        if(item.type === 'place'){
            numbers.place++;
            showNumber = numbers.place;
        }
        else if(item.type === 'meal'){
            numbers.meal++;
            showNumber = numbers.meal;
        }
        else if(item.type === 'special'){
            numbers.special++;
            showNumber = numbers.special;
        }

        item.number = showNumber;
    });

    cleanInputModal();
    createMarkers();
    createPlaceBox();
    closeMyModalBP('addNewEventModal');
    closeLoading();

    document.getElementById('addNewEventText').innerText = 'افزودن برنامه بعدی';
}

function createPlaceBox(){
    let html = '';
    events.forEach((item, index) => {
        let typeClass = item.type === 'place' ? 'seenPlaceTypeRow' : (item.type === 'meal' ? 'mealTypeRow' : 'specialTypeRow');
        let topTitle = typesTitles[item.type];

        html += `<div id="eventCard_${item.type}_${item.code}" class="placeCard">
                                <div class="imgSection">
                                    <img src="${item.picture}" class="resizeImgClass" onload="fitThisImg(this)">
                                </div>
                                <div class="infoSection">
                                    <div class="name lessShowText">
                                        <span style="margin-left: 10px;">${item.title}</span>
                                        <span class="${typeClass}"> ${topTitle} ${item.number}</span>
                                    </div>
                                    <div style="display: flex;">
                                        <div style="display: flex; flex-direction: column;">
                                            <div class="time">از ${item.sTime} تا ${item.eTime}</div>
                                            ${item.place != null ?
            `<div class="ratesAndReview">
                                                    <div class="rate ui_bubble_rating bubble_${item.place.rate}0"></div>
                                                    <div class="review">${item.place.reviewCount} نقد</div>
                                                </div>`
            : ''}
                                            <div class="description">${item.description}</div>
                                        </div>
                                        <div class="buttonsGroup">
                                            <button class="btn btn-primary" onclick="editThisEvent(${index})">ویرایش</button>
                                            <button class="btn btn-danger" onclick="deleteThisEvent(${index})">حذف</button>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
    });

    document.getElementById('eventBoxSection').innerHTML = html;
}

function editThisEvent(_index){
    cleanInputModal();

    document.getElementById('newEventModalTitle').innerText = 'ویرایش برنامه';
    document.getElementById('submitEventButton').innerText = 'ویرایش برنامه';
    let event = events[_index];

    [...document.querySelectorAll('input[name="eventType"]')].map(item => {
        item.parentElement.classList.remove('selected');
        item.parentElement.classList.add('disabled');
        item.disabled = true;
    });
    let eventTypeInputElement = document.querySelector(`input[name="eventType"][value="${event.type}"]`);
    eventTypeInputElement.parentElement.classList.add('selected');
    eventTypeInputElement.parentElement.classList.remove('disabled');
    eventTypeInputElement.checked = true;

    [...document.querySelectorAll('.eventInputSection')].map(item => item.classList.add('hidden'));
    document.getElementById(`${event.type}_eventInputs`).classList.remove('hidden');

    let position = _index == 0 ? -1 : (_index == events.length-1 ? -2 : _index);

    let options = `<option ${position === -1 ? 'selected' : ''} value="-1" >اولین برنامه</option>`;
    events.forEach((item, index) => {
        options += `<option ${position == index+1 ? 'selected' : ''} value="${index+1}" style="">بعد از ${item.title}</option>`;
    });
    options += `<option ${position === -2 ? 'selected' : ''} value="-2">اخرین برنامه</option>`;
    document.getElementById('eventPosition').innerHTML = options;

    document.getElementById('eventId').value = event.id;
    document.getElementById('eventCode').value = event.code;

    if(event.type === 'place'){
        let inputEl = document.getElementById('newAmakenName');

        inputEl.value = event.title;
        inputEl.readOnly = true;
        inputEl.setAttribute('data-name', event.title);
        inputEl.setAttribute('data-id', event.placeId);
        inputEl.setAttribute('data-kindPlaceId', event.kindPlaceId);

        document.getElementById('startTimeNewAmaken').value = event.sTime;
        document.getElementById('endTimeNewAmaken').value = event.eTime;
    }
    else if(event.type === 'meal'){
        document.getElementById('startTimeNewMeal').value = event.sTime;
        document.getElementById('endTimeNewMeal').value = event.eTime;

        let el;
        if(event.place === null){
            el = document.querySelector('input[name="inRestaurant"][value="0"]');
            document.getElementById('mealInRestaurantSection').classList.add('hidden');

            let inputEl = document.getElementById('newRestaurantName');
            inputEl.readOnly = false;
        }
        else{
            el = document.querySelector('input[name="inRestaurant"][value="1"]');
            document.getElementById('mealInRestaurantSection').classList.remove('hidden');

            let inputEl = document.getElementById('newRestaurantName');

            inputEl.readOnly = true;
            inputEl.value = event.title;
            inputEl.setAttribute('data-id', event.placeId);
            inputEl.setAttribute('data-name', event.title);
            inputEl.setAttribute('data-kindPlaceId', event.kindPlaceId);
        }

        el.checked = true;
        [...document.querySelectorAll('input[name="inRestaurant"]')].map(item => item.parentElement.classList.remove('active'));
        document.querySelector('input[name="inRestaurant"]:checked').parentElement.classList.add('active');
    }
    else if(event.type === 'special'){
        document.getElementById('nameForSpecial').value = event.title;
        document.getElementById('descriptionForSpecial').value = event.description;

        document.getElementById('latForSpecial').value = event.lat;
        document.getElementById('lngForSpecial').value = event.lng;

        document.getElementById('startTimeNewSpecial').value = event.sTime;
        document.getElementById('endTimeNewSpecial').value = event.eTime;

        if(event.lat != 0 && event.lng != 0) {
            document.querySelector('input[name="specialHasLocation"][value="1"]').checked = true;
            [...document.querySelectorAll('input[name="specialHasLocation"]')].map(item => item.parentElement.classList.remove('active'));
            document.querySelector('input[name="specialHasLocation"]:checked').parentElement.classList.add('active');
            specialInMap(1);

            let statusEl = document.getElementById('specialMapMarkerStatus');
            statusEl.classList.remove('false');
            statusEl.classList.add('true');
            statusEl.innerText = 'محل مشخص شده';
        }
        else{
            document.querySelector('input[name="specialHasLocation"][value="0"]').checked = true;
            [...document.querySelectorAll('input[name="specialHasLocation"]')].map(item => item.parentElement.classList.remove('active'));
            document.querySelector('input[name="specialHasLocation"]:checked').parentElement.classList.add('active');
            specialInMap(0);

            let statusEl = document.getElementById('specialMapMarkerStatus');
            statusEl.classList.remove('true');
            statusEl.classList.add('false');
            statusEl.innerText = 'محل نامشخص';
        }

    }

    openMyModalBP('addNewEventModal');
}

function deleteThisEvent(_index){
    openLoading();
    let event = events[_index];


    if(event.marker != null)
        mainMap.removeLayer(event.marker);

    document.getElementById(`eventCard_${event.type}_${event.code}`).remove();

    events.splice(_index, 1);
    events.forEach(item => {
        if(item.type === event.type && item.number > event.number)
            item.number--;
    });

    createPlaceBox();
    createMarkers();
    closeLoading();
}

function cleanInputModal(){
    let inputAmakenElement = document.getElementById('newAmakenName');
    inputAmakenElement.value = '';
    inputAmakenElement.setAttribute('data-id', '');
    inputAmakenElement.setAttribute('data-name', '');
    inputAmakenElement.setAttribute('data-img', '');
    inputAmakenElement.setAttribute('data-kindPlaceId', '');

    document.getElementById('startTimeNewAmaken').value = '';
    document.getElementById('endTimeNewAmaken').value = '';


    let inputRestaurantElement = document.getElementById('newRestaurantName');
    inputRestaurantElement.value = '';
    inputRestaurantElement.setAttribute('data-id', '');
    inputRestaurantElement.setAttribute('data-name', '');
    inputRestaurantElement.setAttribute('data-img', '');
    inputRestaurantElement.setAttribute('data-kindPlaceId', '');

    document.getElementById('startTimeNewMeal').value = '';
    document.getElementById('endTimeNewMeal').value = '';

    document.getElementById('nameForSpecial').value = '';
    document.getElementById('descriptionForSpecial').value = '';
    document.getElementById('latForSpecial').value = 0;
    document.getElementById('lngForSpecial').value = 0;

    document.querySelector('input[name="specialHasLocation"][value="0"]').checked = true;
    [...document.querySelectorAll('input[name="specialHasLocation"]')].map(item => item.parentElement.classList.remove('active'));
    document.querySelector('input[name="specialHasLocation"]:checked').parentElement.classList.add('active');
    specialInMap(0);

    let statusEl = document.getElementById('specialMapMarkerStatus');
    statusEl.classList.remove('true');
    statusEl.classList.add('false');
    statusEl.innerText = 'محل نامشخص';

    document.getElementById('startTimeNewSpecial').value = '';
    document.getElementById('endTimeNewSpecial').value = '';
}

async function getPlaceInfoForPlan(_id, _kindPlaceId, _callBack){
    let place = null;
    let error = false;

    await $.ajax({
        type: 'GET',
        url: `${getPlaceInfoForPlanUrl}?placeId=${_id}&kindPlaceId=${_kindPlaceId}`,
        success: response => {
            if(response.status === 'ok')
                place = response.result;
            else{
                console.error(response.result);
                closeLoading();
                error = true;
            }
        },
        error: err =>{
            console.error(err);
            closeLoading();
            error = true;
        }
    });

    return {place, error};
}

function submitNewLocationOnMap(){
    if(markerForSpecial === null){
        alert('محل را روی نقشه مشخص کنید.');
        return;
    }
    let latLng = markerForSpecial._latlng;

    document.getElementById('latForSpecial').value = latLng.lat;
    document.getElementById('lngForSpecial').value = latLng.lng;

    specialMap.removeLayer(markerForSpecial);
    markerForSpecial = null;

    let statusEl = document.getElementById('specialMapMarkerStatus');
    statusEl.classList.remove('false');
    statusEl.classList.add('true');
    statusEl.innerText = 'محل مشخص شده';

    closeMyModalBP('mapModal');
}

function openMapForSpecial(){
    openMyModalBP('mapModal');

    if(specialMap === null) {
        specialMap = L.map("mapForSpecialEvent", {
            minZoom: 1,
            maxZoom: 20,
            crs: L.CRS.EPSG3857,
            center: [35.72351645367768, 51.37030005455017],
            zoom: 6
        }).on('click', e => {
            setMarkerToMapForSpecial(e.latlng.lat, e.latlng.lng);
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
        ).addTo(specialMap);
    }

    eventsMarkerInSpecialMap.forEach(item => specialMap.removeLayer(item));
    eventsMarkerInSpecialMap = [];

    let setCenter = false;
    for(let i = events.length-1; i >= 0 ; i--){
        if(events[i].marker != null){
            if(!setCenter)
                specialMap.setView([events[i].lat, events[i].lng], 15);

            let marker = createMapMarker(events[i]);
            marker.addTo(specialMap);
            eventsMarkerInSpecialMap.push(marker);
        }
    }

    let lat = document.getElementById('latForSpecial').value;
    let lng = document.getElementById('lngForSpecial').value;

    if(lat != 0 && lng != 0){
        if(markerForSpecial != null)
            specialMap.removeLayer(markerForSpecial);

        specialMap.setView([lat, lng], 15);
        markerForSpecial = L.marker([lat, lng]).addTo(specialMap);
    }
}

function setMarkerToMapForSpecial(_lat, _lng){
    if(markerForSpecial != null)
        specialMap.removeLayer(markerForSpecial);

    markerForSpecial = L.marker([_lat, _lng]).addTo(specialMap);
}

function initialData(){
    openLoading(false, () => {
        let numbers = {};
        for(let x in typesTitles)
            numbers[x] = 0;

        backEvent.forEach(item => {
            numbers[item.type]++;
            events.push({
                ...item,
                number: numbers[item.type],
                marker: null,
                code: Math.floor(Math.random() * 100000000),
            });
        });

        createPlaceBox();
        createMarkers();

        closeLoading();
    });
}

function initMap()  {
    if(mainMap == null) {
        mainMap = L.map("mapDiv", {
            minZoom: 1,
            maxZoom: 20,
            crs: L.CRS.EPSG3857,
            center: [35.72351645367768, 51.37030005455017],
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

        setStartAndEnd();
    }
}

function setStartAndEnd(){
    let sLocation = JSON.parse(tour.start.location);
    let eLocation = JSON.parse(tour.end.location);

    sLocation = [parseFloat(sLocation[0]), parseFloat(sLocation[1])];
    eLocation = [parseFloat(eLocation[0]), parseFloat(eLocation[1])];


    startMarker = L.marker(sLocation, {
        title: 'محل شروع',
    }).addTo(mainMap);

    endMarker = L.marker(eLocation, {
        title: 'محل پایان',
    }).addTo(mainMap);

    mainMap.fitBounds([sLocation, eLocation]);
}

function createMarkers(){
    let places = [];
    events.forEach((item, index) => {
        if(item.place != null || (item.lat != 0 && item.lng != 0)) {
            if (item.marker != null)
                mainMap.removeLayer(item.marker);

            places.push({...item, eventIndex: index})
        }
    });

    places.forEach(item => {
        let marker = createMapMarker(item);

        events[item.eventIndex].marker = marker;

        marker.addTo(mainMap);
        mainMap.setView([marker._latlng.lat, marker._latlng.lng], 15);
    });

    createPathBetween();
}

function createMapMarker(_place){
    let typeName = typesTitles[_place.type];
    let typeClass = _place.type === 'place' ? 'seenPlaceType' : (_place.type === 'meal' ? 'mealType' : 'specialType');
    let pic = _place.type === 'special' ? defaultPicture : _place.picture;
    let name = _place.type === 'special' ? `برنامه ویژه ${_place.number}` : _place.title;

    let iconHtml = `<div class="topOnPic ${typeClass}">${typeName} ${_place.number}</div>
                                <div class="imgInIcon">
                                    <img src="${pic}">
                                </div>`;

    return L.marker([_place.lat, _place.lng], {
        title: name,
        icon: L.divIcon({
            className: 'myIconOnMap',
            html: iconHtml
        })
    });

}

function createPathBetween(){
    paths.forEach(item => mainMap.removeLayer(item));
    paths = [];

    let moveIconPolyLines = [];
    let places = [];
    events.forEach(item => {
        if(item.lat != 0 && item.lng != 0)
            places.push(item)
    });

    if(moveMarker != null)
        moveMarker.motionStop();

    places.unshift({
        lat: startMarker._latlng.lat,
        lng: startMarker._latlng.lng,
    });
    places.push({
        lat: endMarker._latlng.lat,
        lng: endMarker._latlng.lng,
    });

    for(let i = 0; i < places.length-1; i++){
        let line = [[places[i].lat, places[i].lng], [places[i+1].lat, places[i+1].lng]];
        let path = L.polyline(line, {
            weight: 2,
            color: 'blue',
            // dashArray: '10'
        });

        paths.push(path);
        path.addTo(mainMap);

        let nLine = [{
            lat: places[i].lat,
            lng: places[i].lng
        }, {
            lat: places[i+1].lat,
            lng: places[i+1].lng
        }];


        let rotateIcon = places[i].lng > places[i+1].lng ? '180' : '0';

        // var moveManIcon = `<div class="moveManIcon"><img src="${moveIconGif}" style="width: 100%; transform: rotateY(${rotateIcon}deg)"></div>`;
        var moveManIcon = `<div class="moveManIcon"></div>`;

        var motion = L.motion.polyline(nLine, {
            color: "transparent"
        }, null, {
            removeOnEnd: true,
            icon: L.divIcon({html: moveManIcon, iconSize: L.point(27.5, 24)})
        }).motionDuration(3000);

        moveIconPolyLines.push(motion);
    }

    if(moveIconPolyLines.length > 0) {
        moveIconTime = moveIconPolyLines.length * 3000;

        moveMarker = L.motion.seq(moveIconPolyLines).addTo(mainMap);

        if(moveIconInterval != null)
            clearTimeout(moveIconInterval);

        reloadMoveIcon();
    }
}

function reloadMoveIcon(){
    moveMarker.motionStop();
    moveMarker.motionStart();
    moveIconInterval = setTimeout(reloadMoveIcon, moveIconTime);
}

$(document).ready(() => {
    initMap();
    initialData();
    $('.clockP').clockpicker(clockOptions);
});
