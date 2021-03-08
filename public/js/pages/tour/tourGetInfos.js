var timerInterval;
var isUsedTourCode = false;
var passengersSendInfos = [];
var lastPassengersInfos = [];
var lastPassengerIsOpen = false;
var priceDetIsOpen = false;
var submitedKoochitaScore = 0;
var passengerCount = 0;
var datePickerOptions = {
    format: 'YYYY/MM/DD',
    initialValue: false
};
var userInfoRowsSample = $('#getInfoUserSection').html();
$('#getInfoUserSection').empty();

function openPriceDetails(){
    $('#priceDetailsSection').toggleClass('open');
    priceDetIsOpen = !priceDetIsOpen;
}

function setTimer(){
    var percent = (1200 - remainingTime) / 12;

    var min = parseInt(remainingTime/60);
    var seconds = parseInt(remainingTime%60);

    if(min < 10)
        min = '0'+min;
    if(seconds < 10)
        seconds = '0'+seconds;
    $('#timer').text(`${min}:${seconds}`);
    remainingTime--;

    if(remainingTime <= 0){
        clearInterval(timerInterval);
        openErrorAlert('زمان شما برای پر کردن اطلاعات تمام شد. لطفا دوباره از صفحه ی تور اقدام کنید.', () => location.reload() );
    }
}

function searchCountryCode(_index) {
    var val = $("#countryCode_" + _index).val();
    $('#resultCountry_'+_index).empty();

    if(val.trim().length > 1) {
        $.ajax({
            type: 'GET',
            url: `${searchInCountryUrl}?value=${val}`,
            success: response => {
                if(response.status == 'ok'){
                    var html = '';
                    response.result.map(item => html += `<div class="result" data-id="${item.id}" data-index="${_index}" onclick="chooseThisCounty(this)">${item.name}</div>`);
                    $('#resultCountry_'+_index).html(html);
                }
            }
        })
    }
}

function chooseThisCounty(_element){
    var index = $(_element).attr('data-index');

    $('#resultCountry_'+index).empty();
    $('#countryCode_'+index).val($(_element).text());
    $('#countryCodeId_'+index).val($(_element).attr('data-id'));
}

function changeForeignRow(_index) {
    if ($("#foreign_" + _index).prop('checked')) {
        $("#foreignRow_" + _index).removeClass('hidden');
        $("#meliCodeSec_" + _index).addClass('hidden');
    }
    else {
        $("#meliCodeSec_" + _index).removeClass('hidden');
        $("#foreignRow_" + _index).addClass('hidden');
    }
}

function createGetUserInfoRow(_count){
    if(_count > passengerCount) {
        for (var i = passengerCount; i < _count; i++) {
            var text = userInfoRowsSample;
            text = text.replace(new RegExp("##index##", 'g'), passengerCount);
            text = text.replace(new RegExp("##passengerNum##", 'g'), passengerCount + 1);
            text = text.replace(new RegExp("##mainPassenger##", 'g'), (passengerCount == 0 ? mainPassengerSampleButton : ''));

            $('#getInfoUserSection').append(text);
            passengerCount++;

            $(".datePickerBox").pDatepicker(datePickerOptions);
            $(".datePickerEnBox").pDatepicker({
                ...datePickerOptions,
                calendarType: 'gregorian',
            });
        }
    }
    else{
        var less = passengerCount - _count;
        for(var i = 0; i < less; i++){
            passengerCount--;
            $(`#passenger_${passengerCount}`).remove();
        }
    }
}

function addPassenger(_index, _kind){
    var passengerCounts = $(`#passengerCountEdit_${_index}`).text();
    passengerCounts = parseInt(passengerCounts) + _kind;
    if(passengerCounts < 0)
        passengerCounts = 0;

    $(`#passengerCountEdit_${_index}`).text(passengerCounts);
}

function createInvoice(){
    var totalCost = 0;
    var totalFeatureCost = 0;
    var passCounts = 0;

    var inCapacityPassCount = 0;

    passengerInfos.map(item =>{
        var totalCostItem = item.payAbleCost * item.count;
        $(`#passengerCount_${item.id}`).text(`${item.count} نفر`);
        $(`#passengerTotalCost_${item.id}`).text(numberWithCommas(totalCostItem));

        passCounts += parseInt(item.count);
        totalCost += totalCostItem;

        if(item.inCapacity == 1)
            inCapacityPassCount += parseInt(item.count);
    });

    features.map(item => {
        var totalCostFeat = item.count * item.cost;
        $(`#featureCount_${item.id}`).text(`${item.count} عدد`);
        $(`#featureTotalCost_${item.id}`).text(numberWithCommas(totalCostFeat));

        totalFeatureCost += totalCostFeat;
    });

    if(tourAllNeeded == 1)
        createGetUserInfoRow(passCounts);

    var discountHtml = '';
    groupDiscount.map(item =>{
       if(item.minCount <= inCapacityPassCount && item.maxCount >= inCapacityPassCount){
           var discountCost = totalCost * item.discount / 100;
           totalCost = totalCost * (100 - item.discount) / 100;
           discountHtml += `<div class="bodyR discountRow">
                             <div>تخفیف خرید گروهی</div>
                             <div>${item.discount}%</div>
                             <div></div>
                             <div>${numberWithCommas(discountCost)}</div>
                           </div>`;
       }
    });

    totalCost += totalFeatureCost;
    $('.featTotCost').text(numberWithCommas(totalFeatureCost));
    $('.totalPayAbleCost').text(numberWithCommas(totalCost));

    $('.topPayAbleCost').removeClass('withDiscount');
    if(isUsedTourCode !== false){
        var discountCost = totalCost * isUsedTourCode / 100;
        totalCost = totalCost * (100 - isUsedTourCode) / 100;
        discountHtml += `<div class="bodyR discountRow">
                            <div>کد تخفیف</div>
                            <div>${isUsedTourCode}%</div>
                            <div></div>
                            <div>${numberWithCommas(discountCost)}</div>
                        </div>`;


        $('.costWithDiscount').text(totalCost);
        $('.topPayAbleCost').addClass('withDiscount');
    }
    $('#priceDiscountSec').html(discountHtml);

    fillLastPassengers();
}

function openEditPassengerCounts(){
    features.map(item => $(`#featureInput_${item.id}`).val(item.count));
    passengerInfos.map(item => $(`#passengerCountEdit_${item.id}`).text(item.count));
    openMyModal('editPassengerCountModal');
}

function doEditPassengerCount(){
    var feats = [];
    var pass = [];
    features.map(item => feats.push({
        id: item.id,
        count: $(`#featureInput_${item.id}`).val()
    }));
    passengerInfos.map(item => pass.push({
        id: item.id,
        count: parseInt($(`#passengerCountEdit_${item.id}`).text())
    }));

    openLoading();
    $.ajax({
        type: 'POST',
        url: updateReservationUrl,
        data: {
            _token: '{{csrf_token()}}',
            reservationCode: reservationCode,
            features: feats,
            passengers: pass
        },
        complete: closeLoading,
        success: response => {
            if(response.status == 'ok') {
                showSuccessNotifi('نفرات با موفقیت ویرایش شدند', 'left', 'var(--koochita-blue)');
                submitEditPassengers();
            }
            else if(response.status == 'maxCap')
                showSuccessNotifi('تعداد نفرات بیش از ظرفیت باقی مانده تور می باشد.', 'left', 'red');
            else
                showSuccessNotifi('خطا در ویرایش', 'left', 'red');

        },
        error: err => showSuccessNotifi('خطا در ویرایش', 'left', 'red')
    })
}

async function submitEditPassengers(){
    var updateCounts = () => {
        features.map(item => item.count = $(`#featureInput_${item.id}`).val());
        passengerInfos.map(item => item.count = $(`#passengerCountEdit_${item.id}`).text());
    };

    await updateCounts();
    createInvoice();
    closeMyModal('editPassengerCountModal');
}

function getMyInfo(){
    openLoading();
    $.ajax({
        type: 'GET',
        url: getMyInfoUrl,
        complete: closeLoading,
        success: response =>{
            if(response.status == 'ok'){
                result = response.result;

                var englishCharacters = /^[A-Za-z0-9]*$/;
                if(englishCharacters.test(result.first_name) && $('#nameEn_0').length > 0)
                    $('#nameEn_0').val(result.first_name);
                else
                    $('#nameFa_0').val(result.first_name);

                if(englishCharacters.test(result.last_name) && $('#familyEn_0').length > 0)
                    $('#familyEn_0').val(result.last_name);
                else
                    $('#familyFa_0').val(result.last_name);

                $('#sex_0').val(result.sex);
            }
        },
        error: err =>{

        }
    })
}

function openLastPassengersInfo(_index, _type = 'toggle'){
    setTimeout(() => {
        if(_type == 'toggle') $(`#oldPassengerPane_${_index}`).toggleClass('hidden');
        else if(_type == 'close') $(`#oldPassengerPane_${_index}`).addClass('hidden');
        else if(_type == 'open') $(`#oldPassengerPane_${_index}`).removeClass('hidden');

        lastPassengerIsOpen = $('.class_passengerOldPane.hidden').length != $('.class_passengerOldPane').length;
    }, 100);
}

function getLastPassengersInfos(){
    $.ajax({
        type: 'GET',
        url: getLastPassengers,
        success: response => {
            if(response.status == 'ok') {
                lastPassengersInfos = response.result;
                fillLastPassengers();
            }
        },
    })
}

function fillLastPassengers(){
    var html = '';
    lastPassengersInfos.map((item, _index) => html += `<div class="item" onclick="selectThisPassenger(this, ${_index})">${item.name}</div>`);
    $('.lastPassengersInfos').html(html)
}

function selectThisPassenger(_element, _index){
    var pas = lastPassengersInfos[_index];
    var rowIndex = $(_element).parent().attr('data-index');
    openLastPassengersInfo(rowIndex, 'close');

    if(pas.firstNameFa != null && $(`#nameFa_${rowIndex}`).length > 0)
        $(`#nameFa_${rowIndex}`).val(pas.firstNameFa);

    if(pas.lastNameFa != null && $(`#familyFa_${rowIndex}`).length > 0)
        $(`#familyFa_${rowIndex}`).val(pas.lastNameFa);

    if(pas.firstNameEn != null && $(`#nameEn_${rowIndex}`).length > 0)
        $(`#nameEn_${rowIndex}`).val(pas.firstNameEn);

    if(pas.lastNameEn != null && $(`#familyEn_${rowIndex}`).length > 0)
        $(`#familyEn_${rowIndex}`).val(pas.lastNameEn);

    if(pas.birthDay != null && $(`#birthDay${rowIndex}`).length > 0)
        $(`#birthDay${rowIndex}`).val(pas.birthDay);

    if(pas.meliCode != null && $(`#NID_${rowIndex}`).length > 0)
        $(`#NID_${rowIndex}`).val(pas.meliCode);

    if(pas.sex != null && $(`#sex_${rowIndex}`).length > 0)
        $(`#sex_${rowIndex}`).val(pas.sex);

    if(pas.passportExp != null && $(`#passportExpire${rowIndex}`).length > 0)
        $(`#passportExpire${rowIndex}`).val(pas.passportExp);

    if(pas.passportNum != null && $(`#passport_${rowIndex}`).length > 0)
        $(`#passport_${rowIndex}`).val(pas.passportNum);

    if($(`#foreign_${rowIndex}`).length > 0) {
        $(`#foreign_${rowIndex}`).prop('checked', pas.iForeign == 1);
        changeForeignRow(rowIndex);
    }

    $(`#saveInformation_${rowIndex}`).prop('checked', true);
}

function checkTourDiscountCode(){
    var discountCode = $('#discountCodeInput').val();
    if(discountCode.trim().length > 0) {
        openLoading();
        $.ajax({
            type: 'POST',
            url: checkDiscountCodeUrl,
            data: {
                _token: csrfTokenGlobal,
                userCode: reservationCode,
                code: discountCode
            },
            complete: closeLoading,
            success: response =>{
                if(response.status == 'ok'){
                    showSuccessNotifi('کد تخفیف با موفقیت اعمال شد', 'left', 'var(--koochita-blue)');
                    isUsedTourCode = response.result;
                    $('#codeDiscountSection').addClass('submited');
                    createInvoice();
                }
                else if(response.status == 'wrong')
                    showSuccessNotifi('کد تخفیف اشتباه می باشد', 'left', 'red');
                else
                    showSuccessNotifi('خطا', 'left', 'red');
            },
            error: err =>{
                showSuccessNotifi('خطا', 'left', 'red');
            }
        })
    }
}

function selectDiscountType(_element) {
    var dataType = $(_element).attr('data-type');
    $(_element).parent().find('.selected').removeClass('selected');
    $(_element).addClass('selected');

    $('.discountSec').addClass('hidden');
    $(`#${dataType}DiscountSection`).removeClass('hidden');
}

function checkInputs() {
    var mustBeFulls = $('.mustBeFull');
    var erroredField = 0;
    var errorText = '';

    for (var i = 0; i < mustBeFulls.length; i++) {
        var element = $(mustBeFulls[i]);
        if (element.is(':visible')) {
            var value = element.val();
            if (value.length == 0) {
                element.parent().addClass('errorField');
                erroredField++;
            } else
                element.parent().removeClass('errorField');
        }
    }

    var phone = $('#phoneNumForTicket').val();
    var email = $('#emailForTicket').val();
    var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;


    if (phone.trim().length != 11 || phone[0] != 0 || phone[1] != 9) {
        errorText += '<div>شماره تماس خود را به درستی وارد کنید</div>';
        $('#phoneNumForTicket').parent().addClass('errorField');
    }

    if (!email.match(validRegex)) {
        errorText += '<div>ایمیل خود را به درستی وارد کنید</div>';
        $('#emailForTicket').parent().addClass('errorField');
    }

    if (erroredField != 0)
        errorText += '<div>پرکردن اطلاعات تمامی مسافرین اجباری است</div>';

    if (errorText != '')
        openErrorAlert(errorText);
    else {
        checkInputAges();
    }
}

function submitDatas(){
    openLoading();
    passengersSendInfos = [];
    for(var i = 0; i < passengerCount; i++){
        passengersSendInfos.push({
            isMain: i == 0 ? 1 : 0,
            firstNameFa: $(`#nameFa_${i}`).length > 0 ? $(`#nameFa_${i}`).val() : '',
            lastNameFa: $(`#familyFa_${i}`).length > 0 ? $(`#familyFa_${i}`).val() : '',
            firstNameEn: $(`#nameEn_${i}`).length > 0 ? $(`#nameEn_${i}`).val() : '',
            lastNameEn: $(`#familyEn_${i}`).length > 0 ? $(`#familyEn_${i}`).val() : '',
            birthDay: $(`#birthDay${i}`).length > 0 ? $(`#birthDay${i}`).val() : '',
            codeMeli: $(`#NID_${i}`).length > 0 ? $(`#NID_${i}`).val() : '',
            sex: $(`#sex_${i}`).length > 0 ? $(`#sex_${i}`).val() : '',
            isForeign: $(`input[name="foreign_${i}"]:checked`).length > 0 ? 1 : 0,
            passport: $(`#passport_${i}`).length > 0 ? $(`#passport_${i}`).val() : '',
            passportExpire: $(`#passportExpire${i}`).length > 0 ? $(`#passportExpire${i}`).val() : '',
            countryCodeId: $(`#countryCodeId_${i}`).length > 0 ? $(`#countryCodeId_${i}`).val() : '',
            saveInformation: $(`input[id="saveInformation_${i}"]:checked`).length > 0 ? 1 : 0,
        });
    }

    var discount = 0;
    var discountType = $('.discountType.selected').attr('data-type');

    if(discountType == 'code') discount = $('#discountCodeInput').val();
    else if(discountType == 'koochitaScore') discount = submitedKoochitaScore;

    $.ajax({
        type: 'POST',
        url: submitPassengersInfoUrl,
        data: {
            _token: csrfTokenGlobal,
            passengers: passengersSendInfos,
            phone: $('#phoneNumForTicket').val(),
            email: $('#emailForTicket').val(),
            description: $('#userDescription').val(),
            importantInformation: $('input[id="importantInformation"]:checked').length > 0 ? 1 : 0,
            otherOffer: $('input[id="interestNews"]:checked').length > 0 ? 1 : 0,
            reservationCode,
            discountType,
            discount
        },
        success: response => {
            if(response.status == 'ok'){
                showSuccessNotifi('در حال انتقال به صفحه پرداخت', 'left', 'var(--koochita-blue)');
                location.href = response.result;
            }
            else if(response.status === 'sick'){
                closeLoading();
                var sickNid = response.result;
                var html = 'مسافرین با کد ملی زیر به علت داشتن سابقه ویروس کرونا ، نمی توانند در تور شرکت کنند.';
                html += '<ul>';
                sickNid.map(item => html += `<li>${item}</li>`);
                html += '</ul>';
                openErrorAlert(html);
            }
            else{
                showSuccessNotifi('خطا در ثبت اطلاعات', 'left', 'red');
                closeLoading();
            }
        },
        error: err => {
            console.log(err);
            showSuccessNotifi('خطا در ثبت اطلاعات', 'left', 'red');
            closeLoading();
        }
    });
}

function checkInputAges(){
    var allAges = [];
    var mainAges;
    passengerInfos.map(item => {
        var added = {
            id: item.id,
            count: item.count,
            ageFrom: item.ageFrom,
            ageTo: item.ageTo,
        };
        if(item.id == 0)
            mainAges = added;
        else
            allAges.push(added);
    });


    var birthDateElements = $('input[name="birthDay[]"]');
    var nowPersianDate = new persianDate();
    for(var i = 0; i < birthDateElements.length; i++){
        var birth = $(birthDateElements[i]).val();
        birth = convertNumberToEn(birth).split('/');
        if(birth.length == 3){
            var birthPersianDate = new persianDate([parseInt(birth[0]), parseInt(birth[1]), parseInt(birth[2])]);
            var diffYears = birthPersianDate.diff(nowPersianDate, 'years');
            var find = 0;
            allAges.map(item => {
                if(find == 0 && item.id != 0 && item.ageFrom <= diffYears && item.ageTo >= diffYears){
                    item.count--;
                    find = 1;
                }
            });
            if(find == 0)
                mainAges.count--;
        }
    }

    var allIsZero = true;
    if(mainAges.count != 0)
        allIsZero = false;
    allAges.map(item => allIsZero = item.count != 0 ? false : allIsZero);

    if(allIsZero)
        submitDatas();
    else
        openWarning('سن افراد وارد شده به عنوان اطلاعات با تعداد مسافران شما مغایرت دارد. توجه داشته باشید که قیمت بلیط از روی تاریخ تولد محاسبه می شود و قاعدتا هزینه بلیط شما متفاوت خواهد بود', submitDatas);
}

$('.mustBeFull').on('keyup', function(){
    if(this.value.trim().length == 0)
        $(this).parent().addClass('errorField');
    else
        $(this).parent().removeClass('errorField');
});

$(window).on('scroll', () => {
    if($(window).scrollTop() > 65)
        $('#stickyHeader').addClass('fixed');
    else
        $('#stickyHeader').removeClass('fixed');
});

$(window).on('click', e => {
    var element = $(e.target);

    if(element.is('.seeDetailBut.downArrowIconAfter'))
        openPriceDetails();
    else if(priceDetIsOpen){
        while(1){
            if(element.is('body')) {
                openPriceDetails();
                break;
            }
            else if(element.is('.detailsCostSec.open') || element.is('.seeDetailBut.downArrowIconAfter'))
                break;
            else
                element = element.parent();
        }
    }

    if(lastPassengerIsOpen){
        element = $(e.target);
        while(1){
            if(element.is('body')) {
                $('.class_passengerOldPane').addClass('hidden');
                lastPassengerIsOpen = false;
                break;
            }
            else if(element.is('.class_passengerOldPane'))
                break;
            element = element.parent();
        }
    }
});

$(window).ready(() => {
    if(tourAllNeeded == 0)
        createGetUserInfoRow(1);

    createInvoice();
    getLastPassengersInfos();
    timerInterval = setInterval(setTimer, 1000);
});
