var clockOptions = {
    placement: 'left',
    donetext: 'تایید',
    autoclose: true,
};

var amakenAdded = [];
var mealsAdded = [];
var sEventAdded = [];
var lastAjax = null;
var lastType = 'amaken';

var mealWhere = null;
var mealKind = null;
function createNewMealEvent(){
    openMyModalBP('addMealEventModal');
}
function changeMealWhere(_type){
    document.getElementById('restaurantNameSection').classList.remove('hidden');

    document.getElementById('forMealInAmaken').classList.add('hidden');
    document.getElementById('forMealInRestaurant').classList.add('hidden');

    if(_type === 'amaken')
        document.getElementById('forMealInAmaken').classList.remove('hidden');
    else
        document.getElementById('forMealInRestaurant').classList.remove('hidden');

    mealWhere = _type;
}
function changeMealKind(_kind){
    mealKind = _kind;
}
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
function submitNewMeal(){
    if(mealKind != null) {
        document.getElementById('restaurantNameSection').classList.add('hidden');
        document.getElementById('forMealInAmaken').classList.add('hidden');
        document.getElementById('forMealInRestaurant').classList.add('hidden');

        [...document.querySelectorAll('div[data-name="mealWhere"]')].map(item => item.classList.remove('selected'));
        [...document.querySelectorAll('div[data-name="mealKind"]')].map(item => item.classList.remove('selected'));

        openLoading();
        closeMyModalBP('addMealEventModal');
        let inputElement = document.getElementById('newRestaurantName');

        let place_id = inputElement.getAttribute('data-id');
        let place_name = inputElement.getAttribute('data-name');
        let place_img = inputElement.getAttribute('data-img');
        let place_kindPlaceId = inputElement.getAttribute('data-kindPlaceId');
        let time = document.getElementById('mealTime').value;

        if(place_name.trim().length === 0) {
            place_id = 0;
            place_kindPlaceId = 0;
            place_name = '';
            place_img = defaultPicture;
        }

        let newValue = {
            code: Math.floor(Math.random() * 100000),
            kind: mealKind,
            where: mealWhere,
            id: place_id,
            kindPlaceId: place_kindPlaceId,
            name: place_name,
            img: place_img,
            sTime: time,
            eTime: '',
        };

        mealsAdded.push(newValue);

        createNewEventBox(newValue, 'meal');

        inputElement.setAttribute('data-id', '');
        inputElement.setAttribute('data-name', '');
        inputElement.setAttribute('data-img', '');
        inputElement.setAttribute('data-kindPlaceId', '');
        document.getElementById('mealTime').value = '';
        inputElement.value = '';
        mealWhere = null;
        mealKind = null;

        closeLoading();
    }
    else
        openErrorAlertBP('نوع وعده غذایی را مشخص کنید.');
}
function editNewMeal(){
    let code = document.getElementById('editMealCode').value;
    let time = document.getElementById('mealTimeEdit').value;

    for(let i = 0; i < mealsAdded.length; i++){
        if(mealsAdded[i].code == code){
            mealsAdded[i].sTime = time;
            document.querySelector(`#eventBox_${code} .time`).innerText = time;
            break;
        }
    }

    closeMyModalBP('editMealEventModal');
}

function createNewAmakenEvent(){
    openMyModalBP('addAmakenEventModal');
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
function submitNewAmaken(){
    openLoading();
    closeMyModalBP('addAmakenEventModal');
    let inputElement = document.getElementById('newAmakenName');

    let place_id = inputElement.getAttribute('data-id');
    let place_name = inputElement.getAttribute('data-name');
    let place_img = inputElement.getAttribute('data-img');
    let place_kindPlaceId = inputElement.getAttribute('data-kindPlaceId');

    let sTime = document.getElementById('startTimeNewAmaken').value;
    let eTime = document.getElementById('endTimeNewAmaken').value;
    let description = document.getElementById('descriptionForAmaken').value;

    let newValue = {
        code: Math.floor(Math.random()*100000),
        id: place_id,
        kindPlaceId: place_kindPlaceId,
        name: place_name,
        img: place_img,
        sTime,
        eTime,
        description
    };

    amakenAdded.push(newValue);

    createNewEventBox(newValue, 'amaken');

    document.getElementById('startTimeNewAmaken').value = '';
    document.getElementById('endTimeNewAmaken').value = '';
    document.getElementById('descriptionForAmaken').value = '';
    inputElement.value = '';

    document.getElementById('newAmakenButtonText').innerText = 'محل بعدی بازدید را مشخص کنید';
    closeLoading();
}
function submitEditAmaken(){
    let code = document.getElementById('editAmakenCode').value;
    let sTime = document.getElementById('startTimeEditAmaken').value;
    let eTime = document.getElementById('endTimeEditAmaken').value;
    let description = document.getElementById('descriptionForEditAmaken').value;

    for(let i = 0; i < amakenAdded.length; i++){
        if(amakenAdded[i].code == code){
            amakenAdded[i].sTime = sTime;
            amakenAdded[i].eTime = eTime;
            amakenAdded[i].description = description;
            document.querySelector(`#eventBox_${code} .time`).innerText = `${eTime} - ${sTime}`;
            break;
        }
    }

    closeMyModalBP('editAmakenEventModal');
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

function createNewEventBox(_value, _type){
    let html = `<div id="eventBox_${_value.code}" class="eventAdded">
                            <div class="picSec">
                                <img src="${_value.img}" class="resizeImgClass" onload="fitThisImg(this)">
                                ${
        _type === 'meal' ? `<div class="mealType">${_value.kind === 'main' ? 'وعده اصلی' : 'میان وعده'}</div>`: ''
    }
                            </div>
                            <div class="infoSec">
                                <div class="name">${_value.name}</div>
                                <div class="time">${_value.eTime} - ${_value.sTime}</div>
                                <div class="buttons">
                                    <button onclick="deleteThisEvent(${_value.code}, '${_type}')" class="btn btn-danger">حدف</button>
                                    <button onclick="editThisEvent(${_value.code}, '${_type}')" class="btn btn-primary">ویرایش</button>
                                </div>
                            </div>
                        </div>`;

    if(_type === 'amaken')
        document.getElementById('amakenEvents').innerHTML += html;
    else if(_type === 'meal')
        document.getElementById('mealsEvents').innerHTML += html;
    else if(_type === 'sEvent')
        document.getElementById('SEvents').innerHTML += html;
}

// function deleteThisEvent(_code, _type){
//     let index = null;
//     let searchVar = [];
//     document.getElementById(`eventBox_${_code}`).remove();
//
//     if(_type === 'amaken')
//         searchVar = amakenAdded;
//     else if(_type === "meal")
//         searchVar = mealsAdded;
//     else if(_type === "sEvent")
//         searchVar = sEventAdded;
//
//     searchVar.forEach((_item, _index) => {
//         if(_item.code === _code)
//             index = _index;
//     });
//
//     if(index !== null) {
//         if(_type === 'amaken')
//             amakenAdded.splice(index, 1);
//         else if(_type === "meal")
//             mealsAdded.splice(index, 1);
//         else if(_type === "sEvent")
//             sEventAdded.splice(index, 1);
//     }
// }
//
// function editThisEvent(_code, _type){
//     let event = null;
//     if(_type === 'amaken'){
//         amakenAdded.forEach(item => {
//             if(item.code === _code)
//                 event = item;
//         });
//         document.getElementById('editAmakenNameTitle').innerText = event.name;
//
//         document.getElementById('editAmakenCode').value = event.code;
//         document.getElementById('editAmakenName').value = event.name;
//         document.getElementById('startTimeEditAmaken').value = event.sTime;
//         document.getElementById('endTimeEditAmaken').value = event.eTime;
//         document.getElementById('descriptionForEditAmaken').value = event.description;
//
//         openMyModalBP('editAmakenEventModal');
//     }
//     else if(_type === 'meal'){
//         mealsAdded.forEach(item => {
//             if(item.code === _code)
//                 event = item;
//         });
//         document.getElementById('snackMealKindEdit').classList.remove('selected');
//         document.getElementById('mainMealKindEdit').classList.remove('selected');
//
//         document.getElementById('restaurantMealWhere').classList.remove('selected');
//         document.getElementById('amakenMealWhere').classList.remove('selected');
//
//         let eventKindId = event.kind === 'main' ? 'mainMealKindEdit' : 'snackMealKindEdit';
//         document.getElementById(eventKindId).classList.add('selected');
//
//
//         let eventWhereId = event.where === 'amaken' ? 'amakenMealWhere' : 'restaurantMealWhere';
//         document.getElementById(eventWhereId).classList.add('selected');
//
//
//         document.getElementById('mealPlaceName').value = event.name;
//         document.getElementById('mealTimeEdit').value = event.sTime;
//         document.getElementById('editMealCode').value = event.code;
//
//         openMyModalBP('editMealEventModal');
//     }
//     else if(_type === 'sEvent'){
//         sEventAdded.forEach(item => {
//             if(item.code === _code)
//                 event = item;
//         });
//
//         document.getElementById('editSpecialEventName').value = event.name;
//         document.getElementById('descriptionForSEventEdit').value = event.description;
//         document.getElementById('sTimeSEventEdit').value = event.sTime;
//         document.getElementById('eTimeSEventEdit').value = event.eTime;
//
//         if(event.sTime != ''){
//             document.querySelector('input[name="sEditEventHasTime"][value="0"]').checked = false;
//             document.querySelector('input[name="sEditEventHasTime"][value="0"]').parentElement.classList.remove('active');
//
//             document.querySelector('input[name="sEditEventHasTime"][value="1"]').checked = true;
//             document.querySelector('input[name="sEditEventHasTime"][value="1"]').parentElement.classList.add('active');
//
//             document.getElementById('sEventTimeSectionEdit').classList.remove('hidden');
//         }
//         else{
//             document.querySelector('input[name="sEditEventHasTime"][value="1"]').checked = false;
//             document.querySelector('input[name="sEditEventHasTime"][value="1"]').parentElement.classList.remove('active');
//
//             document.querySelector('input[name="sEditEventHasTime"][value="0"]').checked = true;
//             document.querySelector('input[name="sEditEventHasTime"][value="0"]').parentElement.classList.add('active');
//
//             document.getElementById('sEventTimeSectionEdit').classList.add('hidden');
//         }
//         document.getElementById('sEventCode').value = event.code;
//
//         openMyModalBP('editSpecialEventModal');
//     }
// }

function specialEventHasTime(_value, _type = 'New'){
    if(_value == 1)
        document.getElementById(`sEventTimeSection${_type}`).classList.remove('hidden');
    else
        document.getElementById(`sEventTimeSection${_type}`).classList.add('hidden');
}
function createNewSEvent(){
    openMyModalBP('specialEventModal');
}
function submitNewSEvent(){
    let sTime = '';
    let eTime = '';
    let name = document.getElementById('specialEventName').value;
    let description = document.getElementById('descriptionForSEvent').value;

    if(name.trim().length === 0){
        openErrorAlertBP('عنوان برنامه را مشخص کنید.');
        return;
    }

    let hasTime = document.querySelector('input[name="sEventHasTime"]:checked').value;
    if(hasTime == 1){
        sTime = document.getElementById('sTimeSEvent').value;
        eTime = document.getElementById('eTimeSEvent').value;

        if(sTime.trim().length === 0 || eTime.trim().length === 0){
            openErrorAlertBP('زمان برنامه را مشخص کنید');
            return;
        }
    }

    let newValue = {
        code: Math.floor(Math.random()*100000),
        id: 0,
        kindPlaceId: 0,
        name: name,
        img: defaultPicture,
        sTime,
        eTime,
        description
    };
    sEventAdded.push(newValue);

    createNewEventBox(newValue, 'sEvent');

    document.getElementById('specialEventName').value = '';
    document.getElementById('descriptionForSEvent').value = '';
    document.getElementById('sTimeSEvent').value = '';
    document.getElementById('eTimeSEvent').value = '';

    closeMyModalBP('specialEventModal');
}
function editSEvent(){
    let sTime = '';
    let eTime = '';
    let code = document.getElementById('sEventCode').value;
    let name = document.getElementById('editSpecialEventName').value;
    let description = document.getElementById('descriptionForSEventEdit').value;

    let hasTime = document.querySelector('input[name="sEditEventHasTime"]:checked').value;
    if(hasTime == 1){
        sTime = document.getElementById('sTimeSEventEdit').value;
        eTime = document.getElementById('eTimeSEventEdit').value;

        if(sTime.trim().length === 0 || eTime.trim().length === 0){
            openErrorAlertBP('زمان برنامه را مشخص کنید');
            return;
        }
    }

    for(let i = 0; i < sEventAdded.length; i++){
        if(sEventAdded[i].code == code){
            sEventAdded[i].name = name;
            sEventAdded[i].description = description;
            sEventAdded[i].sTime = sTime;
            sEventAdded[i].eTime = eTime;

            document.querySelector(`#eventBox_${code} .name`).innerText = `${name}`;
            document.querySelector(`#eventBox_${code} .time`).innerText = `${eTime} - ${sTime}`;
        }
    }

    closeMyModalBP('editSpecialEventModal');
}

function submitSchedule(){
    openLoading();

    $.ajax({
        type: 'POST',
        url: stageTwoStoreUrl,
        data: {
            tourId: tour.id,
            amaken: amakenAdded,
            meals: mealsAdded,
            special: sEventAdded,
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

$(window).ready(() => $('.clockP').clockpicker(clockOptions));
