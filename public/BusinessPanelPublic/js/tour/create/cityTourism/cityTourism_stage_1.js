var dataToSend;
var ajaxVar = null;
var calendarIndex = 2;
var lastDayDiscoutnIndex = 0;
var disCountNumber = 0;
var disCountIndex = 1;
var disCounts = [];
var discountError = false;
var selectedDate = [];
var lastDatePickerOpen = null;

var nowCitySearchResult = [];
var allDatesInformations = [];

// var timeRowSample = document.getElementById('timeRowSample').innerHTML;
// document.getElementById('timeRowSample').remove();


var datePickerOptions = {
    numberOfMonths: 1,
    showButtonPanel: true,
    language: 'fa',
    dateFormat: "yy/mm/dd",
    beforeShowDay: function(date){
        let thisId = this.getAttribute('id');

        if(lastDatePickerOpen != thisId) {
            selectedDate = [...document.querySelectorAll('input[name="sDateNotSame[]"]')].filter(item => item.getAttribute('id') != thisId).map(item => item.value);
            lastDatePickerOpen = thisId;
        }
        let nowDate = date.getDate();
        let nowMonth = date.getMonth()+1;
        let nowYear = date.getFullYear();

        nowMonth = nowMonth < 10 ? `0${nowMonth}` : nowMonth;
        nowDate = nowDate < 10 ? `0${nowDate}` : nowDate;

        let nowDay = `${nowYear}/${nowMonth}/${nowDate}`;

        if(selectedDate.indexOf(nowDay) != -1)
            return [false, 'youCantSelect'];
        else
            return [true];
    },
};

function searchInCity(_value){
    if (_value.trim().length > 1) {
        document.getElementById('citySearchResultSec').classList.remove('hidden');
        document.getElementById('citySearchLoader').classList.remove('hidden');
        document.getElementById('citySearchResult').classList.add('hidden');

        if (ajaxVar != null)
            ajaxVar.abort();

        ajaxVar = $.ajax({
            type: 'GET',
            url: `${findCityWithStateUrl}?&value=${_value.trim()}`,
            success: response => {
                if (response.status == 'ok') {
                    nowCitySearchResult = response.result;
                    document.getElementById('citySearchLoader').classList.add('hidden');
                    document.getElementById('citySearchResult').classList.remove('hidden');
                    let html = '';
                    response.result.filter(item => item.isVillage == 0).forEach(item => {
                        html += `<div class="res" data-id="${item.id}" data-name="${item.cityName}" onclick="chooseThisCity(this)">
                                            <span>${item.cityName}</span>
                                            <span class="light"> (${item.stateName})</span>
                                        </div>`
                    });

                    document.getElementById('citySearchResult').innerHTML = html;
                }
            }
        })
    }
    else{
        document.getElementById('citySearchResultSec').classList.add('hidden');
    }
}

function chooseThisCity(_element){
    let id = _element.getAttribute('data-id');
    let name = _element.getAttribute('data-name');

    document.getElementById('citySearchResultSec').classList.add('hidden');
    document.getElementById('citySearchResult').innerHTML = '';

    document.getElementById('srcCity').value = name;
    document.getElementById('srcCityId').value = id;
}

function changeCityName(_element){
    let name = _element.value;
    let find = false;
    nowCitySearchResult.forEach(item => {
        if(item.cityName == name){
            find = true;
            document.getElementById('srcCityId').value = item.id;

            document.getElementById('citySearchResultSec').classList.add('hidden');
            document.getElementById('citySearchResult').innerHTML = '';
        }
    });

    if(!find)
        openWarningBP('لطفا شهر مورد نظر را از لیست انتخاب کنید.');
}


function createGroupDisCountCard(_type, _discount = null){

    if(_discount == null){
        _discount = {
            id: 0,
            code: Math.floor(Math.random()*1000000),
            discount: '',
            minCount: '',
            maxCount: '',
            status: 1,
        }
    }

    var text = `<div id="groupDiscount_${disCountNumber}" data-index="${disCountNumber}" class="col-md-12 pd-0 discountRow ${_discount.status == 1 ? 'active' : 'notActive'}" style="display: flex; align-items: center">
                    <div id="groupDiscountInputs_${disCountNumber}" class="inputBox discountLimitationWholesale float-right">
                        <input id="disCountGroupId_${disCountNumber}" type="hidden" value="${_discount.id}">
                        <input id="disCountGroupStatus_${disCountNumber}" type="hidden" value="${_discount.status}">
                        <div class="inputBoxText">
                            <div>از</div>
                        </div>
                        <input id="disCountFrom_${disCountNumber}"
                               class="inputBoxInput startDisCountNumber"
                               type="number"
                               placeholder="نفر"
                               value="${_discount.minCount}"
                               ${_discount.id === 0 ?
                                    `onkeyup="checkDiscount(${disCountNumber}, this.value, 0)"
                                    onchange="checkAllDiscount()" style="width: 100px;"`
                                    :
                                    'readOnly'
                                }>
                        <div class="inputBoxText">
                            <div>الی</div>
                        </div>
                        <input id="disCountTo_${disCountNumber}"
                               class="inputBoxInput endDisCountNumber"
                               type="number"
                               placeholder="نفر"
                               value="${_discount.maxCount}"
                               ${_discount.id === 0 ?
                                    `onkeyup="checkDiscount(${disCountNumber}, this.value, 1)"
                                    onchange="checkAllDiscount()" style="width: 100px;"`
                                    :
                                    'readOnly'
                                }
                               >
                        <div class="inputBoxText">
                            <div class="importantFieldLabel">درصد تخفیف</div>
                        </div>
                        <input id="disCountCap_${disCountNumber}"
                               class="inputBoxInput no-border-imp"
                               type="number"
                               value="${_discount.discount}"${_discount.id === 0 ? `` : 'readOnly' }
                               placeholder="درصد تخفیف">
                    </div>
                    <div class="inline-block mg-rt-10">
                        ${
                            _discount.id == 0 ?
                                `<button type="button" class="submitBTNCircleIcon" onclick="this.remove()"> تایید </button>
                                <button type="button" class="submitBTNCircleIcon" onclick="deleteDisCountCard(${disCountNumber})" style="background: #94341e;"> حذف </button>`
                                :
                                `<button type="button" class="submitBTNCircleIcon disableButton" onclick="disableThisGroupDiscount(${disCountNumber})" style="font-size: 11px;"></button>`
                            }

                    </div>
                </div>`;

    let className = _type === 'main' ? '#mainGroupDiscount' : '#groupDiscountDiv';
    $(className).append(text);
    disCountNumber++;

    disCounts.push(_discount);
}
function disableThisGroupDiscount(_index){
    let nowStatus = document.getElementById(`disCountGroupStatus_${_index}`).value;
    let updateStatus = nowStatus == 1 ? 0 : 1;

    document.getElementById(`disCountGroupStatus_${_index}`).value = updateStatus;

    let element = document.getElementById(`groupDiscount_${_index}`);
    if(updateStatus === 1){
        element.classList.remove('notActive');
        element.classList.add('active');
    }
    else{
        element.classList.add('notActive');
        element.classList.remove('active');
    }

}
function deleteDisCountCard(_index){
    disCounts[_index] = null;
    $('#groupDiscount_'+_index).remove();
}

function checkDiscount(_index, _value, _kind){
    if(disCounts[_index] != null) {
        var errorIndex = false;
        if (_kind == 1)
            disCounts[_index].to = parseInt(_value);
        else
            disCounts[_index].from = parseInt(_value);


        for (let i = disCounts.length - 1; i >= 0; i--) {
            if (i != _index) {
                if (disCounts[i].to != 0 && disCounts[i].to != -1 && disCounts[i].from != 0 && disCounts[i].from != -1) {
                    if ((_value >= disCounts[i].from && _value <= disCounts[i].to)) {
                        errorIndex = true;
                        break;
                    }
                }
            }
        }

        var showId = (_kind == 1 ? 'disCountTo_' : 'disCountFrom_') + _index;
        if (errorIndex)
            $(`#${showId}`).addClass('errorClass');
        else
            $(`#${showId}`).removeClass('errorClass');
    }
}
function checkAllDiscount(){
    discountError = false;
    for(let i = disCounts.length-1; i >= 0 ; i--){
        if (disCounts[i] != null) {
            if (disCounts[i].from == 0 || disCounts[i].to == 0) {
                if (disCounts[i].to == 0)
                    document.getElementById('disCountTo_' + i).classList.add('errorClass');
                if (disCounts[i].from == 0)
                    document.getElementById('disCountFrom_' + i).classList.add('errorClass');
            }
            else if (disCounts[i].from > disCounts[i].to) {
                document.getElementById('disCountTo_' + i).classList.add('errorClass');
                document.getElementById('disCountFrom_' + i).classList.add('errorClass');
            }
            else {
                var checkErrorTo = false;
                var checkErrorFrom = false;

                for (var j = i - 1; j >= 0; j--) {
                    if (disCounts[j].to != 0 && disCounts[j].to != -1 && disCounts[j].from != 0 && disCounts[j].from != -1) {
                        if (!checkErrorFrom && disCounts[i].from >= disCounts[j].from && disCounts[i].from <= disCounts[j].to) {
                            document.getElementById('disCountFrom_' + i).classList.add('errorClass');
                            checkErrorFrom = true;
                            discountError = true;
                        }
                        if (!checkErrorTo && disCounts[i].to >= disCounts[j].from && disCounts[i].to <= disCounts[j].to) {
                            document.getElementById('disCountTo_' + i).classList.add('errorClass');
                            checkErrorTo = true;
                            discountError = true;
                        }
                    }
                }

                if(!checkErrorFrom)
                    document.getElementById('disCountFrom_' + i).classList.remove('errorClass');
                if(!checkErrorTo)
                    document.getElementById('disCountTo_' + i).classList.remove('errorClass');
            }
        }
    }
}

function addLastDayDiscount(_discount = null){
    if(_discount == null){
        _discount = {
            id: 0,
            discount: '',
            remainingDay: '',
            status: 1,
        }
    }

    var options = '';
    for(var i = 0; i < 16; i++)
        options += `<option value="${i}" ${_discount.remainingDay == i ? 'selected' : ''}>${i}</option>`;

    var html = `<div id="dayDiscountRow_${lastDayDiscoutnIndex}" data-index="${lastDayDiscoutnIndex}" class="col-md-12 pd-0 dayToDiscountRow" style="display: flex;">
                    <div id="dayDiscount_${lastDayDiscoutnIndex}" style="display: flex; align-items: center; opacity: ${_discount.status === 1 ? '1' : '.2'}">
                        <div class="inputBox discountLimitationWholesale float-right">
                            <input id="disCountRemainDayId_${lastDayDiscoutnIndex}" type="hidden" value="${_discount.id}">
                            <div class="inputBoxText">
                                <div class="importantFieldLabel">درصد تخفیف</div>
                            </div>
                            <input  id="dayDiscountInput_${lastDayDiscoutnIndex}"
                                    class="inputBoxInput no-border-imp"
                                    type="number"
                                    placeholder="درصد تخفیف"
                                    value="${_discount.discount}"
                                    ${_discount.id != 0 ? 'readonly' : ''}>
                        </div>
                        <div class="textSec">
                            <span>این تخفیف از</span>
                            ${_discount.id == 0
                                ?
                                `<select id="dayDiscountDay_${lastDayDiscoutnIndex}" class="inputBoxInput dayInput">${options}</select>`
                                :
                                `<input id="dayDiscountDay_${lastDayDiscoutnIndex}" class="inputBoxInput no-border-imp onlyInputBackGray" value="${_discount.remainingDay}" readonly>`
                            }
                            <span>روز مانده به برگزاری تور اعمال شود.</span>
                        </div>
                    </div>
                    <div class="inline-block mg-rt-10">
                    ${_discount.id === 0
                        ?
                        `<button type="button" class="wholesaleDiscountLimitationBtn deleteBtnTourCreation deleteDisCountButton" onclick="deleteDisCountDay(${lastDayDiscoutnIndex})">
                            حذف تخفیف
                        </button>`
                        :
                        `<button id="disableRemainingDayDiscountButton_${lastDayDiscoutnIndex}"
                                data-status="${_discount.status}"
                                type="button"
                                class="wholesaleDiscountLimitationBtn deleteBtnTourCreation deleteDisCountButton"
                                style="background: ${_discount.status === 1 ? 'var(--koochita-yellow)' : 'var(--koochita-green)'}"
                                onclick="disableThisRemainingDayDiscount(${lastDayDiscoutnIndex})">
                            ${_discount.status === 1 ? 'غیر فعال' : 'فعال'} کردن تخفیف
                        </button>`
                    }

                    </div>
                </div>`;

    lastDayDiscoutnIndex++;

    $('#lastDayesDiscounts').append(html);
}
function disableThisRemainingDayDiscount(_index){
    let gdbElement = document.getElementById(`disableRemainingDayDiscountButton_${_index}`);
    let status = gdbElement.getAttribute('data-status');

    let newStatus = status == 1 ? 0 : 1;

    gdbElement.setAttribute('data-status', newStatus);
    gdbElement.style.background = newStatus == 1 ? 'var(--koochita-yellow)' : 'var(--koochita-green)';
    gdbElement.innerText = newStatus == 1 ? 'غیر فعال کردن تخفیف' : 'فعال کردن تخفیف';

    document.getElementById(`dayDiscount_${_index}`).style.opacity = newStatus == 1 ? '1' : '.2';
}
function deleteDisCountDay(_index){
    $('#dayDiscountRow_'+_index).remove();
}

function changeCancelAble(_value){
    if(_value == 1)
        document.getElementById('cancelDiv').classList.remove('hidden');
    else
        document.getElementById('cancelDiv').classList.add('hidden');
}

function fullDataInFields() {

    $('#tourId').val(tour.id);
    $('#tourName').val(tour.name);
    $('#srcCity').val(tour.src.name);
    $('#srcCityId').val(tour.src.id);

    if (tour.private === 1) {
        $('input[name="private"]').parent().removeClass('active');
        $('input[name="private"][value="1"]').prop('checked', true).parent().addClass('active');
    }

    if (tour.cancelAble === 1) {
        $('input[name="isCancelAbel"]').parent().removeClass('active');
        $('input[name="isCancelAbel"][value="1"]').prop('checked', true).parent().addClass('active');
        document.getElementById('cancelDescription').value = tour.cancelDescription;
    }
    else{
        $('input[name="isCancelAbel"]').parent().removeClass('active');
        $('input[name="isCancelAbel"][value="0"]').prop('checked', true).parent().addClass('active');
        document.getElementById('cancelDiv').classList.add('hidden');
    }

    [...document.querySelectorAll('.onlyOnNew')].map(item => item.classList.add('hidden'));
    [...document.querySelectorAll('.onlyOnEdit')].map(item => item.classList.remove('hidden'));

    document.getElementById('otherDateSection').classList.remove('hidden');

    if(Array.isArray(tour.times)) {
        tour.times.forEach(item => {
            allDatesInformations.push({
                id: item.id,
                code: Math.floor(Math.random()*10000000),
                date: item.sDate,
                cost: item.cost,
                isInsurance: item.isInsurance,
                minCapacity: item.minCapacity,
                maxCapacity: item.maxCapacity,
                groupDiscount: item.groupDiscount,
                canEdit: item.canEdit
            });
        });
        createDateTableRows();
    }
}

function hasOtherDate(_value){
    if(allDatesInformations.length === 0 && _value == 1)
        openDateModal();
}

function openDateModal(_date = null){
    if(_date == null){
        _date = {
            id: 0,
            code: 0,
            date: '',
            minCapacity: '',
            maxCapacity: '',
            cost: '',
            isInsurance: 0,
            groupDiscount: [],
        }
    }

    document.getElementById('tourDateId').value = _date.id;
    document.getElementById('tourDateCode').value = _date.code;
    document.getElementById('dateInModal').value = _date.date;
    document.getElementById('dateInModalWithoutCalendar').value = _date.date;
    document.getElementById('minCapacityInModal').value = _date.minCapacity;
    document.getElementById('maxCapacityInModal').value = _date.maxCapacity;
    document.getElementById('costInModal').value = numberWithCommas(_date.cost);

    if(_date.date != '')
        changeModalDate(_date.date, 'modal');
    else
        changeModalDate('...', 'modal');

    if(_date.id == 0){
        document.getElementById('dateInModalWithoutCalendar').classList.add('hidden');
        document.getElementById('dateInModal').classList.remove('hidden');
    }
    else{
        document.getElementById('dateInModalWithoutCalendar').classList.remove('hidden');
        document.getElementById('dateInModal').classList.add('hidden');
    }

    $('input[name="isInsuranceInModal"]').parent().removeClass('active');
    $(`input[name="isInsuranceInModal"][value="${_date.isInsurance}"]`).prop('checked', true).parent().addClass('active');

    if(_date.groupDiscount.length == 0 && _date.id === 0){
        document.getElementById('groupDiscountDiv').innerHTML = '';
        createGroupDisCountCard('modal');
    }
    else
        _date.groupDiscount.forEach(item => {
            createGroupDisCountCard('modal', item);
        });

    openMyModalBP('dateModal');
}

function changeModalDate(_value, _type){
    let className = _type === 'main' ? '.mainDateShow' : '.dateClassInModal';
    [...document.querySelectorAll(className)].map(item => item.innerText = _value);
}

function submitDateModal(){
    let errorText = '';

    let id = document.getElementById('tourDateId').value;
    let code = document.getElementById('tourDateCode').value;
    if(code == 0)
        code = Math.floor(Math.random() * 100000);

    let index = null;
    for(let i = 0; i < allDatesInformations.length; i++) {
        if(code == allDatesInformations[i].code){
            index = i;
            break;
        }
    }

    let groupDiscount = [];
    let date = document.getElementById('dateInModal').value;
    let cost = parseFloat(document.getElementById('costInModal').value.replace(new RegExp(',', 'g'), ''));
    let isInsurance = document.querySelector('input[name="isInsuranceInModal"]:checked').value;
    let minCapacity = parseInt(document.getElementById('minCapacityInModal').value);
    let maxCapacity = parseInt(document.getElementById('maxCapacityInModal').value);

    let groupDiscountRow = 0;
    [...document.querySelectorAll('#groupDiscountDiv .discountRow')].map(item => {
        groupDiscountRow++;
        let hasError = false;
        let index = item.getAttribute('data-index');

        let disId = document.getElementById(`disCountGroupId_${index}`).value;
        let status = document.getElementById(`disCountGroupStatus_${index}`).value;
        let minCount = parseInt(document.getElementById(`disCountFrom_${index}`).value);
        let maxCount = parseInt(document.getElementById(`disCountTo_${index}`).value);
        let discount = parseFloat(document.getElementById(`disCountCap_${index}`).value);

        if(!(minCount > 0)){
            hasError = true;
            document.getElementById(`disCountFrom_${index}`).classList.add('errorClass');
        }
        if(!(maxCount > 0)){
            hasError = true;
            document.getElementById(`disCountTo_${index}`).classList.add('errorClass');
        }
        if(!(discount > 0)){
            hasError = true;
            document.getElementById(`disCountCap_${index}`).classList.add('errorClass');
        }

        if(!hasError)
            groupDiscount.push({ id: disId, minCount, maxCount, discount, status});
    });

    let mainDate = null;
    if(document.getElementById('tourId').value === '0')
        mainDate = document.getElementById('mainDate').value;


    if(date.trim().length === 0)
        errorText += `<li>تاریخ را مشخص کنید</li>`;

    if(date === mainDate)
        errorText += `<li>تاریخ تکراری می باشد.</li>`;
    else {
        for (let i = 0; i < allDatesInformations.length; i++) {
            if (allDatesInformations[i].code != code && allDatesInformations[i].delete != 1) {
                if (allDatesInformations[i].date === date) {
                    errorText += `<li>تاریخ تکراری می باشد.</li>`;
                    break;
                }
            }
        }
    }

    if(!(cost > 0))
        errorText += `<li>قیمت تور را  مشخص کنید.</li>`;
    if(!(minCapacity > 0))
        errorText += `<li>حداقل ظرفیت را مشخص کنید</li>`;
    if(!(maxCapacity > 0))
        errorText += `<li>حداکثر ظرفیت را مشخص کنید</li>`;
    if(groupDiscountRow != groupDiscount.length)
        errorText += `<li>بعضی از فیلد های تخفیف خالی است. آنها را پر کنید.</li>`;
    if(minCapacity > maxCapacity)
        errorText += `<li>حداکثر ظرفیت نمی تواند از حداقل کمتر باشد</li>`;


    if(errorText.trim().length > 0){
        errorText = `<ul class="errorList">${errorText}</ul>`;
        openErrorAlertBP(errorText);
    }
    else {
        let data = {id, code, date, cost, isInsurance, minCapacity, maxCapacity, groupDiscount, canEdit: true, delete: 0};
        if (index == null)
            allDatesInformations.push(data);
        else
            allDatesInformations[index] = data;

        for(let i = 0; i < allDatesInformations.length-1; i++){
            for(let j = i+1; j < allDatesInformations.length; j++){
                if(allDatesInformations[i].date > allDatesInformations[j].date){
                    let last = allDatesInformations[i];
                    allDatesInformations[i] = allDatesInformations[j];
                    allDatesInformations[j] = last;
                }
            }
        }

        createDateTableRows();
        closeMyModalBP('dateModal');
        cleanDateModalDate();
    }
}


function createDateTableRows(){
    let html = '';
    allDatesInformations.forEach(item => {
        if(item.delete != 1) {
            html += `<tr id="dateRow_${item.code}">
                    <td>${item.date}</td>
                    <td>${numberWithCommas(item.cost)} تومان</td>
                    <td>${item.minCapacity}-${item.maxCapacity} نفر</td>
                    <td>${item.groupDiscount.length} تا تخفیف گروهی</td>
                    <td>
                        ${
                item.canEdit ?
                    `<button class="btn btn-primary tableButton" onclick="editThisDate(${item.code})">ویرایش</button>\n
                                 <button class="btn btn-danger tableButton" onclick="deleteThisDate(${item.code})">حذف</button>`
                    :
                    ''
            }
                    </td>
                </tr>`;
        }
    });
    document.getElementById('otherDateTableBody').innerHTML = html;
    document.getElementById('otherDateSection').classList.remove('hidden');
}

function editThisDate(_code){
    for(let i = 0; i < allDatesInformations.length; i++) {
        if(allDatesInformations[i].code == _code){
            cleanDateModalDate();
            openDateModal(allDatesInformations[i]);
            break;
        }
    }
}

function cleanDateModalDate(){
    document.getElementById('dateInModal').value = '';
    document.getElementById('minCapacityInModal').value = '';
    document.getElementById('maxCapacityInModal').value = '';
    document.getElementById('costInModal').value = '';
    document.getElementById('groupDiscountDiv').innerHTML = '';
}

function deleteThisDate(_code){
    for(let i = 0; i < allDatesInformations.length; i++){
        if(allDatesInformations[i].code == _code){
            document.getElementById(`dateRow_${allDatesInformations[i].code}`).classList.add('hidden');
            allDatesInformations[i].delete = 1;
            break;
        }
    }

}

async function checkInput() {
    let allDates = [];
    dataToSend = {
        tourType,
        tourId: document.getElementById('tourId').value,
        businessId: document.getElementById('businessId').value,
        tourName: document.getElementById('tourName').value,
        srcCityId: document.getElementById('srcCityId').value,
        anyCapacity: 0,
        private: document.querySelector('input[name="private"]:checked').value,
        userInfoNeed: ['faName', 'sex', 'birthDay', 'meliCode'],
        cancelAble: document.querySelector('input[name="isCancelAbel"]:checked').value,
        cancelDescription: document.getElementById('cancelDescription').value,

        dates: []
    };

    let errorText = '';
    if (dataToSend.tourName.trim().length < 2)
        errorText += '<li>نام تور خود را مشخص کنید.</li>';

    if (!(dataToSend.srcCityId >= 1))
        errorText += '<li>شهر برگزاری تور خود را مشخص کنید.</li>';

    if(dataToSend.cancelAble == 1 && dataToSend.cancelDescription.trim().length === 0)
        errorText += '<li>در صورت داشتن شرایط کنسلی، شرایط آن را بنویسید.</li>';

    if(dataToSend.tourId == 0) {
        let mainGroupDiscount = [];
        let mainGroupDiscountRow = 0;
        let mainDate = document.getElementById('mainDate').value;
        let mainCost = parseFloat(document.getElementById('tourCost').value.replace(new RegExp(',', 'g'), ''));
        let mainMinCapacity = parseInt(document.getElementById('minCapacity').value);
        let mainMaxCapacity = parseInt(document.getElementById('maxCapacity').value);
        let mainIsInsurance = document.querySelector('input[name="isInsurance"]:checked').value;

        [...document.querySelectorAll('#mainGroupDiscount .discountRow')].map(item => {
            mainGroupDiscountRow++;
            let index = item.getAttribute('data-index');

            let min = parseInt(document.getElementById(`disCountFrom_${index}`).value);
            let max = parseInt(document.getElementById(`disCountTo_${index}`).value);
            let discount = parseFloat(document.getElementById(`disCountCap_${index}`).value);
            let hasError = false;

            if(!(min > 0)){
                hasError = true;
                document.getElementById(`disCountFrom_${index}`).classList.add('errorClass');
            }

            if(!(max > 0)){
                hasError = true;
                document.getElementById(`disCountTo_${index}`).classList.add('errorClass');
            }

            if(!(discount > 0)){
                hasError = true;
                document.getElementById(`disCountCap_${index}`).classList.add('errorClass');
            }

            if(!hasError)
                mainGroupDiscount.push({id: 0, min, max, discount});
        });

        if (mainDate.trim().length === 0)
            errorText += `<li>تاریخ اصلی تور را مشخص کنید.</li>`;
        if (!(mainCost > 0))
            errorText += `<li>قیمت تور در تاریخ ${mainDate} را مشخص کنید.</li>`;
        if (!(mainMinCapacity >= 0))
            errorText += `<li>حداقل ظرفیت تور در تاریخ ${mainDate} را مشخص کنید.</li>`;
        if (!(mainMaxCapacity >= 0))
            errorText += `<li>حداکثر ظرفیت تور در تاریخ ${mainDate} را مشخص کنید.</li>`;
        if (mainMaxCapacity < mainMinCapacity)
            errorText += `<li>حداکثر ظرفیت تور نمی تواند کوچکتر از حداقل باشد</li>`;
        if(mainGroupDiscount.length != mainGroupDiscountRow)
            errorText += `<li>بعضی از فیلدهای تخفیف گروهی برای تاریخ ${mainDate} خالی است. آنها را پر کنید و یا حذف کنید.</li>`;

        allDates.push({
            id: 0,
            date: mainDate,
            cost: mainCost,
            isInsurance: mainIsInsurance,
            minCapacity: mainMinCapacity,
            maxCapacity: mainMaxCapacity,
            groupDiscount: mainGroupDiscount
        });
    }

    allDatesInformations.forEach(item => allDates.push(item));

    dataToSend.dates = allDates;

    let errorInEmpty = false;
    if (errorInEmpty)
        errorText += '<li>بعضی از فیلدهای تخفیف خالی است. انها را کامل کنید.</li>';

    if (errorText != '') {
        errorText = `<ul class="errorList">${errorText}</ul>`;
        openErrorAlertBP(errorText);
    }
    else
        submitInputs();
}

function submitInputs(){
    openLoading(false, () => {
        $.ajax({
            type: 'POST',
            url: stageOneStoreUrl,
            data: dataToSend,
            success: response => {
                if(response.status === 'ok')
                    location.href = `${stageTwoUrl}/${response.result}`;
                else{
                    closeLoading();
                    let errorText = '';
                    errorText += `<li>خطا در ثبت اطلاعات</li>`;
                    response.result.forEach(err => {
                        if(err.status === 0)
                            errorText += `<li>تاریخ ${err.result.date} تکراری می باشد</li>`;
                        if(err.status === 3)
                            errorText += `<li>نام تور نباید خالی باشد</li>`;
                        if(err.status === 4)
                            errorText += `<li>شهر خود را از لیست انتهاب کنید.</li>`;
                        if(err.status === 5)
                            errorText += `<li>توضیح کنسلی نمی تواند خالی باشد</li>`;
                        if(err.status === 6) {
                            errorText += `<li>شما نمی توانید تاریخ ${err.result.date} را حذف کنید.</li>`;

                            for(let i = 0; i < allDatesInformations.length; i++){
                                if(allDatesInformations[i].date == err.result.date){
                                    document.getElementById(`dateRow_${allDatesInformations[i].code}`).classList.remove('hidden');
                                    allDatesInformations[i].delete = 0;
                                    break;
                                }
                            }
                        }
                    });
                    errorText = `<ul>${errorText}</ul>`;
                    openErrorAlertBP(errorText);
                }
            },
            error: err =>{
                closeLoading();
                showSuccessNotifiBP('در ثبت مشکلی پیش آمده', 'left', 'red')
            }
        })
    });
}

$(document).ready(() => {
    $('.observer-example').datepicker(datePickerOptions);
    $('.tourBasicKindsCheckbox').mouseenter(() => $(this).addClass('green-border')).mouseleave(() => $(this).removeClass('green-border'));
    if(tour != null)
        fullDataInFields();

    createGroupDisCountCard('main');
});


// NOT USE
function newCalendar() {
    let text = timeRowSample.replace(new RegExp('##number##', 'g'), calendarIndex);
    $('#otherDateSection').append(text);
    $(`#sDate_${calendarIndex}`).datepicker(datePickerOptions);
    calendarIndex++;
}
function deleteCalendar(_index) {
    $('#calendar_' + _index).remove();
}
function calculateDate() {
    var type = $('#calendarType').val();
    var count = $('#calendarCount').val();

    if (count > 0) {
        $('#calendarCount').val('');
        calendarIndex = 1;
        var sDate = $('#sDate_0').val().split('/');
        var eDate = $('#eDate_0').val().split('/');

        var sGregorian = jalaliToGregorian(sDate[0], sDate[1], sDate[2]).join('/');
        var eGregorian = jalaliToGregorian(eDate[0], eDate[1], eDate[2]).join('/');

        var sFirstDay = new Date(sGregorian);
        var eFirstDay = new Date(eGregorian);

        $('.calendarRow').remove();

        for (var i = 1; i <= count; i++) {
            newCalendar();
            var skip;
            var sJalali = [];
            var eJalali = [];

            if (type == 'weekly' || type == 'twoWeek') {
                skip = type == 'weekly' ? 1 : 2;

                var sNext = new Date(sFirstDay.getTime() + 7 * 24 * 60 * 60 * 1000 * i * skip);
                var eNext = new Date(eFirstDay.getTime() + 7 * 24 * 60 * 60 * 1000 * i * skip);

                var sYear = sNext.getFullYear();
                var eYear = eNext.getFullYear();

                var sMonth = sNext.getMonth();
                var eMonth = eNext.getMonth();

                var sDay = sNext.getDate();
                var eDay = eNext.getDate();

                if (sMonth > 11) {
                    sMonth = 0;
                    sYear++;
                }
                if (eMonth > 11) {
                    eMonth = 0;
                    eYear++;
                }

                sJalali = gregorianToJalali(sYear, sMonth + 1, sDay);
                eJalali = gregorianToJalali(eYear, eMonth + 1, eDay);
            } else {
                skip = (type == 'monthly') ? 1 : 2;
                sJalali = sDate;
                eJalali = eDate;

                sJalali[1] = parseInt(sJalali[1]) + (skip);
                eJalali[1] = parseInt(eJalali[1]) + (skip);

                if (sJalali[1] > 12) {
                    sJalali[1] -= 12;
                    sJalali[0]++;
                }
                if (eJalali[1] > 12) {
                    eJalali[1] -= 12;
                    eJalali[0]++;
                }

                if (parseInt(sJalali[1]) < 10)
                    sJalali[1] = '0' + parseInt(sJalali[1]);
                if (parseInt(eJalali[1]) < 10)
                    eJalali[1] = '0' + parseInt(eJalali[1]);
            }

            $('#sDate_' + i).val(sJalali.join('/'));
            $('#eDate_' + i).val(eJalali.join('/'));
        }
    }

}
