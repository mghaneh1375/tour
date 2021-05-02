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
            discount: '',
            minCount: 0,
            maxCount: 0,
            status: 1,
        }
    }

    var text = `<div id="groupDiscount_${disCountNumber}" data-index="${disCountNumber}" class="col-md-12 pd-0 discountRow" style="display: flex; align-items: center">
                    <div id="groupDiscountInputs_${disCountNumber}" class="inputBox discountLimitationWholesale float-right">
                        <input id="disCountGroupId_${disCountNumber}" type="hidden" value="0">
                        <div class="inputBoxText">
                            <div>از</div>
                        </div>
                        <input id="disCountFrom_${disCountNumber}"
                               class="inputBoxInput startDisCountNumber"
                               type="number"
                               placeholder="نفر"
                               onkeyup="checkDiscount(${disCountNumber}, this.value, 0)"
                               onchange="checkAllDiscount()" style="width: 100px;">
                        <div class="inputBoxText">
                            <div>الی</div>
                        </div>
                        <input id="disCountTo_${disCountNumber}"
                               class="inputBoxInput endDisCountNumber"
                               type="number"
                               placeholder="نفر"
                               onkeyup="checkDiscount(${disCountNumber}, this.value, 1)"
                               onchange="checkAllDiscount()" style="width: 100px;">
                        <div class="inputBoxText">
                            <div class="importantFieldLabel">درصد تخفیف</div>
                        </div>
                        <input id="disCountCap_${disCountNumber}"
                               class="inputBoxInput no-border-imp"
                               type="number"
                               placeholder="درصد تخفیف">
                    </div>
                    <div class="inline-block mg-rt-10">
                        <button type="button" class="submitBTNCircleIcon" onclick="this.remove()">
                                تایید
                        </button>
                        <button type="button" class="submitBTNCircleIcon" style="background: #94341e;" onclick="deleteDisCountCard(${disCountNumber})">
                            حذف
                        </button>
                    </div>
                </div>`;

    // var text = `<div id="groupDiscount_${disCountNumber}" data-index="${disCountNumber}" class="col-md-12 pd-0 discountRow" style="display: flex">
    //                 <div id="groupDiscountInputs_${disCountNumber}" class="inputBox discountLimitationWholesale float-right" style="opacity: ${_discount.status == 1 ? '1' : '.2'}">
    //                     <input id="disCountGroupId_${disCountNumber}" type="hidden" value="${_discount.id}">
    //                     <div class="inputBoxText">
    //                         <div class="importantFieldLabel">بازه‌ی تخفیف</div>
    //                     </div>
    //                     <input id="disCountFrom_${disCountNumber}"
    //                             class="inputBoxInput startDisCountNumber"
    //                             type="number"
    //                             value="${_discount.minCount}"
    //                             ${_discount.id == 0
    //                                 ?
    //                                     `placeholder="از"
    //                                     onkeyup="checkDiscount(${disCountNumber}, this.value, 0)"
    //                                     onchange="checkAllDiscount()"`
    //                                 :
    //                                     `readonly`
    //                             }>
    //
    //                     <div class="inputBoxText">
    //                         <div>الی</div>
    //                     </div>
    //                     <input id="disCountTo_${disCountNumber}"
    //                             class="inputBoxInput endDisCountNumber"
    //                             type="number"
    //                             value="${_discount.maxCount}"
    //                             ${_discount.id == 0
    //                                 ?
    //                                 `placeholder="تا"
    //                                 onkeyup="checkDiscount(${disCountNumber}, this.value, 1)"
    //                                 onchange="checkAllDiscount()"`
    //                                 :
    //                                 `readonly`
    //                             }>
    //                     <div class="inputBoxText">
    //                         <div class="importantFieldLabel">درصد تخفیف</div>
    //                     </div>
    //                     <input id="disCountCap_${disCountNumber}"
    //                             class="inputBoxInput no-border-imp"
    //                             type="number"
    //                             value="${_discount.discount}"
    //                             ${_discount.id == 0
    //                                 ?
    //                                 `placeholder="درصد تخفیف"`
    //                                 :
    //                                 `readonly`
    //                             }>
    //                 </div>
    //                 <div class="inline-block mg-tp-12 mg-rt-10">
    //                     ${_discount.id === 0
    //                     ?
    //                         `<button type="button" class="wholesaleDiscountLimitationBtn deleteBtnTourCreation deleteDisCountButton" onclick="deleteDisCountCard(${disCountNumber})">
    //                             حذف تخفیف گروهی
    //                         </button>`
    //                     :
    //                         `<button id="disableGroupDiscountButton_${disCountNumber}" data-status="${_discount.status}"
    //                                 type="button"
    //                                 class="wholesaleDiscountLimitationBtn deleteBtnTourCreation deleteDisCountButton"
    //                                 style="background: ${_discount.status === 1 ? 'var(--koochita-yellow)' : 'var(--koochita-green)'}"
    //                                 onclick="disableThisGroupDiscount(${disCountNumber})">
    //                             ${_discount.status === 1 ? 'غیر فعال' : 'فعال'} کردن تخفیف
    //                         </button>`
    //                     }
    //                 </div>
    //             </div>`;

    let className = _type === 'main' ? '#mainGroupDiscount' : '#groupDiscountDiv';
    $(className).append(text);
    disCountNumber++;

    disCounts.push(_discount);

    // if(disCountNumber > 1)
    //     checkAllDiscount();
}
function disableThisGroupDiscount(_index){
    let gdbElement = document.getElementById(`disableGroupDiscountButton_${_index}`);
    let status = gdbElement.getAttribute('data-status');

    disCounts[_index].status = status == 1 ? 0 : 1;
    gdbElement.setAttribute('data-status', disCounts[_index].status);
    gdbElement.style.background = disCounts[_index].status == 1 ? 'var(--koochita-yellow)' : 'var(--koochita-green)';
    gdbElement.innerText = disCounts[_index].status == 1 ? 'غیر فعال کردن تخفیف' : 'فعال کردن تخفیف';

    document.getElementById(`groupDiscountInputs_${_index}`).style.opacity = disCounts[_index].status == 1 ? '1' : '.2';
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
    console.log(tour);

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

    // for (var i = 0; i < tour.times.length - 1; i++)
    //     newCalendar();
    //
    // for (i = 0; i < tour.times.length; i++) {
    //     document.getElementById(`sDate_${i}`).value = tour.times[i].sDate;
    //     document.getElementById(`sDateCost_${i}`).value = numberWithCommas(tour.times[i].moreCost);
    // }
    //
    // if(tour.times.length > 1){
    //     $('input[name="anotherDay"]').parent().removeClass('active');
    //     $('input[name="anotherDay"][value="1"]').prop('checked', true).parent().addClass('active');
    //     document.getElementById('anotherDaysDate').classList.remove('hidden');
    // }
    //
    // if(tour.groupDiscount.length > 0)
    //     tour.groupDiscount.forEach(item => createGroupDisCountCard(item));
    //
    // if(tour.remainingDay.length > 0)
    //     tour.remainingDay.forEach(item => addLastDayDiscount(item));
}

$(window).ready(() => {
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
