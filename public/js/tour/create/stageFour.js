var multiIsOpen = false;
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
var calendarIndex = 2;
var tourKind = 'oneTime';
var inKoochita = 0 ;
var findKoochitaAccount = 0;
var tourCalendarValue = [1];

function initLanguage(){
    var text = '';
    for(i = 0; i < language.length; i++)
        text += '<div class="optionMultiSelect" id="multiSelectTransport_' + i + '" onclick="chooseMultiSelect(' + i + ')">' + language[i] + '</div>';

    document.getElementById('multiselect').innerHTML = text;
}

function openMultiSelect(){
    if(multiIsOpen){
        $('#multiselect').hide();
        multiIsOpen = false;
    }
    else{
        $('#multiselect').show();
        multiIsOpen = true;
    }
}

function chooseMultiSelect(_index){

    if(!languageChoose.includes(language[_index])) {

        languageChoose[languageChoose.length] = language[_index];

        document.getElementById('multiSelectTransport_' + _index).style.display = 'none';

        text = '<div id="selectedMulti_' + _index + '" class="transportationKindChosenOnes col-xs-2">\n' + language[_index] +
            '<span class="glyphicon glyphicon-remove" onclick="removeMultiSelect(' + _index + ')"></span>\n' +
            '</div>';
        $('#multiSelected').append(text);

        document.getElementById('language').value = JSON.stringify(languageChoose);
    }
}

function removeMultiSelect(_index){
    $('#selectedMulti_' + _index).remove();
    document.getElementById('multiSelectTransport_' + _index).style.display = 'block';

    if(languageChoose.includes(language[_index])){
        index = languageChoose.indexOf(language[_index]);
        languageChoose.splice(index, 1);
    }

    document.getElementById('language').value = JSON.stringify(languageChoose);
}

function showTourGuid(_value){
    if(_value == 1)
        document.getElementById('isTourGuidDiv').style.display = 'block';
    else {
        document.getElementById('isTourGuidDiv').style.display = 'none';
    }
}

function tourGuidDefined(_value){
    if(_value == 1)
        document.getElementById('isTourGuidDefinedDiv').style.display = 'block';
    else
        document.getElementById('isTourGuidDefinedDiv').style.display = 'none';

}

function KoochitaAccount(_value){

    inKoochita = _value;

    if(_value == 1) {
        document.getElementById('haveKoochitaAccountDiv').style.display = 'block';
        document.getElementById('notKoochitaAccountDiv').style.display = 'none';
    }
    else {
        document.getElementById('haveKoochitaAccountDiv').style.display = 'none';
        document.getElementById('notKoochitaAccountDiv').style.display = 'block';
    }

}

function checkKoochitaAccount(_value){
    $.ajax({
        type: 'post',
        url: checkKoochitaAccountRoute,
        data: {
            '_token' : _token,
            'email' : _value,
        },
        success: function(response){
            if(response == 'nok'){
                document.getElementById('notFindAccount').style.display = 'block';
                document.getElementById('FindAccount').style.display = 'none';
                findKoochitaAccount = 0;
            }
            else{
                document.getElementById('notFindAccount').style.display = 'none';
                document.getElementById('FindAccount').style.display = 'block';
                findKoochitaAccount = 1;
            }

        }
    })
}

function isBackUpPhoneFunc(_value){
    if(_value == 1)
        document.getElementById('backUpPhoneDiv').style.display = 'block';
    else
        document.getElementById('backUpPhoneDiv').style.display = 'none';

}

function changeTime(_value){

    tourKind = _value;

    if(_value == 'oneTime'){
        $('#oneTime').show();
        $('#sameTime').hide();
        $('#notSameTime').hide();
    }
    else if(_value == 'sameTime'){
        $('#oneTime').hide();
        $('#sameTime').show();
        $('#notSameTime').hide();
    }
    else if(_value == 'notSameTime'){
        $('#oneTime').hide();
        $('#sameTime').hide();
        $('#notSameTime').show();
    }

}

function newCalendar(){
    var text = '<div id="calendar_' + calendarIndex + '"><div class="tourNthOccurrence">' + calendarIndex + '</div>\n' +
        '                        <div class="inputBox col-xs-3 relative-position float-right">\n' +
        '                            <div class="inputBoxText">\n' +
        '                                <div>\n' +
        '                                    تاریخ شروع\n' +
        '                                    <span>*</span>\n' +
        '                                </div>\n' +
        '                            </div>\n' +
        '                            <div class="select-side calendarIconTourCreation">\n' +
        '                                <i class="ui_icon calendar calendarIcon"></i>\n' +
        '                            </div>\n' +
        '                            <input name="sDateNotSame[]" id="sDate_' + calendarIndex + '" class="observer-example inputBoxInput" type="text">\n' +
        '                        </div>\n' +
        '                        <div class="inputBox col-xs-3 mg-rt-10 relative-position float-right">\n' +
        '                            <div class="inputBoxText">\n' +
        '                                <div>\n' +
        '                                    تاریخ پایان\n' +
        '                                    <span>*</span>\n' +
        '                                </div>\n' +
        '                            </div>\n' +
        '                            <div class="select-side calendarIconTourCreation">\n' +
        '                                <i class="ui_icon calendar calendarIcon"></i>\n' +
        '                            </div>\n' +
        '                            <input name="eDateNotSame[]" id="eDate_' + calendarIndex + '" class="observer-example inputBoxInput"/>\n' +
        '                        </div>\n' +
        '                        <div class="inline-block mg-tp-12 mg-rt-10">\n' +
        '                            <button type="button" id="newCalendar_' + calendarIndex + '" class="wholesaleDiscountLimitationBtn verifyBtnTourCreation" onclick="newCalendar()">\n' +
        '                                <img src="' + approvePic + '">\n' +
        '                            </button>\n' +
        '                            <button type="button" id="deleteCalendar_' + calendarIndex + '" class="wholesaleDiscountLimitationBtn deleteBtnTourCreation" onclick="deleteCalendar(' + calendarIndex + ')" style="display: none;">\n' +
        '                                <img src="' + deletePic + '">\n' +
        '                            </button>\n' +
        '                        </div></div>';

    document.getElementById('deleteCalendar_' + (calendarIndex-1)).style.display = 'block';
    document.getElementById('newCalendar_' + (calendarIndex-1)).style.display = 'none';
    tourCalendarValue[calendarIndex-1] = 1;

    $('#notSameTimeCalendarDiv').append(text);

    $('#eDate_' + calendarIndex).persianDatepicker({
        minDate: new Date().getTime(),
        format: 'YYYY/MM/DD',
        autoClose: true,
    });
    $('#sDate_' + calendarIndex).persianDatepicker({
        minDate: new Date().getTime(),
        format: 'YYYY/MM/DD',
        autoClose: true,
    });
    $('#sDate_' + calendarIndex).val('');
    $('#eDate_' + calendarIndex).val('');

    calendarIndex++;
}

function deleteCalendar(_index){
    tourCalendarValue[_index-1] = 0;
    $('#calendar_' + _index).remove();
}

function changeInputClass(_id){
    var value = document.getElementById(_id).value;
    if(value != '' && value != null){
        document.getElementById(_id).classList.remove('errorClass');
    }
}

function checkInputs(){
    var error = false;
    var error_text = '';

    if(tourKind == 'oneTime'){
        var sDate = document.getElementById('sDate').value;
        var eDate = document.getElementById('eDate').value;

        if(sDate == '' || sDate == null){
            error = true;
            error_text += '<li>لطفا تاریخ رفت تور را مشخص کنید.</li>';
            document.getElementById('sDate').classList.add('errorClass');
        }
        else
            document.getElementById('sDate').classList.remove('errorClass');

        if(eDate == '' || eDate == null){
            error = true;
            error_text += '<li>لطفا تاریخ برگشت تور را مشخص کنید.</li>';
            document.getElementById('eDate').classList.add('errorClass');
        }
        else
            document.getElementById('eDate').classList.remove('errorClass');
    }
    else if(tourKind == 'sameTime'){
        var sDate = document.getElementById('sDateSame').value;
        var eDate = document.getElementById('eDateSame').value;

        if(sDate == '' || sDate == null){
            error = true;
            error_text += '<li>لطفا تاریخ رفت تور را مشخص کنید.</li>';
            document.getElementById('sDateSame').classList.add('errorClass');
        }
        else
            document.getElementById('sDateSame').classList.remove('errorClass');

        if(eDate == '' || eDate == null){
            error = true;
            error_text += '<li>لطفا تاریخ برگشت تور را مشخص کنید.</li>';
            document.getElementById('eDateSame').classList.add('errorClass');
        }
        else
            document.getElementById('eDateSame').classList.remove('errorClass');

    }
    else if(tourKind == 'notSameTime'){
        var errorNotSame = false;
        for(i = 0; i < tourCalendarValue.length; i++){
            if(tourCalendarValue[i]){
                sDate = document.getElementById('sDate_' + (i+1)).value;
                eDate = document.getElementById('eDate_' + (i+1)).value;

                if((sDate == null || sDate == '') && (eDate != null && eDate != '')) {
                    error = true;
                    errorNotSame = true;
                    document.getElementById('sDate_' + (i + 1)).classList.add('errorClass');
                }
                else if((eDate == null || eDate == '') && (sDate != null && sDate != '')) {
                    error = true;
                    errorNotSame = true;
                    document.getElementById('eDate_' + (i + 1)).classList.add('errorClass');
                }
                else{
                    document.getElementById('sDate_' + (i+1)).classList.remove('errorClass');
                    document.getElementById('eDate_' + (i+1)).classList.remove('errorClass');
                }

            }
        }

        if(errorNotSame)
            error_text += '<li>لطفا تاریخ ها را کامل کنید.</li>';

    }

    if(inKoochita == 1){
        var email = document.getElementById('tourGuidKoochitaEmail').value;
        if(email == null || email == '' || findKoochitaAccount == 0){
            error = true;
            error_text += '<li>راهنمای تور را مشخص کنید.</li>';
            document.getElementById('tourGuidKoochitaEmail').classList.add('errorClass');
        }
        else
            document.getElementById('tourGuidKoochitaEmail').classList.remove('errorClass');
    }
    else{
        var firstName = document.getElementById('tourGuidFirstName').value;
        var lastName = document.getElementById('tourGuidLastName').value;

        if(firstName == null || firstName == ''){
            error = true;
            error_text += '<li>راهنمای تور را مشخص کنید.</li>';
            document.getElementById('tourGuidFirstName').classList.add('errorClass');
        }
        else
            document.getElementById('tourGuidFirstName').classList.remove('errorClass');

        if(lastName == null || lastName == ''){
            error = true;
            error_text += '<li>راهنمای تور را مشخص کنید.</li>';
            document.getElementById('tourGuidLastName').classList.add('errorClass');
        }
        else
            document.getElementById('tourGuidLastName').classList.remove('errorClass');
    }

    if(error){
        var text = '<div class="alert alert-danger alert-dismissible">\n' +
            '            <button type="button" class="close" data-dismiss="alert" style="float: left">&times;</button>\n' +
            '            <ul id="errorList">\n' + error_text +
            '            </ul>\n' +
            '        </div>';
        document.getElementById('errorDiv').style.display = 'block';
        document.getElementById('errorDiv').innerHTML = text;

        setTimeout(function(){
            document.getElementById('errorDiv').style.display = 'none';
        }, 5000);
    }
    else{
        document.getElementById('errorDiv').style.display = 'none';
        $('#form').submit();
    }

}

$(window).on('click', function (e) {
    var target = $(e.target);

    if( multiIsOpen && !target.is('#multiSelected' )&& !target.is('.optionMultiSelect'))
        openMultiSelect();

});

$(document).ready(function(){
    initLanguage();
});

