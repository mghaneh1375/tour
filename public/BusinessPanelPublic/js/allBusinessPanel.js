var alertWarningCallBack = false;
var errorAlertCallBack;

var inputDate = "";

function validateDate(evt, inputId) {

    var theEvent = evt || window.event;

    if(inputDate.length == 8 && theEvent.keyCode != 8) {
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
        return;
    }

    var key = theEvent.keyCode || theEvent.which;

    if(key != 8) {
        key = String.fromCharCode(key);
        var regex = /[0-9]|\./;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault) theEvent.preventDefault();
            return;
        }

        inputDate += key;
    }
    else
        inputDate = inputDate.substring(0, inputDate.length - 1);

    var output = "";

    switch(inputDate.length) {
        case 1:
            output = inputDate + "___ / __ / __";
            break;
        case 2:
            output = inputDate + "__ / __ / __";
            break;
        case 3:
            output = inputDate + "_ / __ / __";
            break;
        case 4:
            output = inputDate + " / __ / __";
            break;
        case 5:
            output = inputDate.substring(0, 4) + " / " + inputDate[4] + "_ / __";
            break;
        case 6:
            output = inputDate.substring(0, 4) + " / " + inputDate.substring(4) + " / __";
            break;
        case 7:
            output = inputDate.substring(0, 4) + " / " + inputDate.substring(4, 6) + " / " + inputDate[6] +"_";
            break;
        case 8:
            output = inputDate.substring(0, 4) + " / " + inputDate.substring(4, 6) + " / " + inputDate.substring(6);
            break;
    }

    $("#" + inputId).val(output);

    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
}

function resizeFitImg(_class) {
    let imgs = $('.' + _class);
    for(let i = 0; i < imgs.length; i++)
        fitThisImg(imgs[i]);
}

function fitThisImg(_element) {
    var img = $(_element);
    var imgW = img.width();
    var imgH = img.height();

    var secW = img.parent().width();
    var secH = img.parent().height();

    if(imgH < secH){
        img.css('height', '100%');
        img.css('width', 'auto');
    }
    else if(imgW < secW){
        img.css('width', '100%');
        img.css('height', 'auto');
    }
}

function errorAjax(reject) {

    closeLoading();

    if (reject.status === 422) {

        var errors = JSON.parse(reject.responseText).errors;

        var errMsg = "";
        $.each(errors, function (key, val) {
            errMsg += val + "<br/>";
        });

        showSuccessNotifiBP(errMsg, 'right', '#ac0020');
    }

}

function justNum(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode( key );
    var regex = /[0-9]|\./;
    if( !regex.test(key) ) {
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
    }
}

function isNeedSideProgressBar(_kind) {
    if(_kind)
        $('#mainSideBar').addClass("hasSideProgressBar");
    else
        $('#mainSideBar').removeClass("hasSideProgressBar");
}

function updateSideProgressBar(_percent){
    $('#sideProgressBarNumber').text(_percent+'%');
    $('#sideProgressBarFull').css('width', _percent+'%');
}

function openLoading(_process = false, _callBack = '') {
    $('#fullPageLoader').removeClass('hidden')
        .find('.percentBar').text(`0%`)
        .find('.bar').css('width', `0%`);

    if(_process)
        $('#fullPageLoader').find('.processBar').removeClass('hidden');

    setTimeout(function(){
        if(typeof _callBack === 'function')
            _callBack();
        else if(typeof _process === 'function')
            _process();
    }, 200);
}

function closeLoading(){
    $('#fullPageLoader').addClass('hidden');
}

function updatePercentLoadingBar(_percent){
    $('#fullPageLoader').find('.percentBar').text(`${_percent}%`)
        .find('.bar').css('width', `${_percent}%`);
}


function showSuccessNotifiBP(_msg, _side = 'right', _color = '#0076ac') {

    var element = $('#successNotifiAlertBP');
    element.empty().append("<p>" + _msg + "</p>").addClass('topAlertBP').css('background', _color).addClass(_side == 'right' ? 'rightAlertBP' : 'leftAlertBP');
    setTimeout(function(){
        element.removeClass('topAlertBP');
        setTimeout(() => element.removeClass('leftAlertBP').removeClass('rightAlertBP'), 1000);
    }, 5000);

}

function openWarningBP(_text, _callBack = false, _okText = 'بسیار خب'){

    alertWarningCallBack = _callBack;
    $('#warningOkTextBP').text(_okText);

    if(typeof _callBack === 'function')
        $('#warningModalCallBackShowBP').show();
    else
        $('#warningModalCallBackShowBP').hide();

    $('#warningBodyBP').html(_text);
    $('#warningBoxDivBP').css('display', 'flex');
}

function cancelWarningBP(){
    $('#warningBoxDivBP').css('display', 'none');
}

function closeWarningBP(){
    if(alertWarningCallBack !== false && typeof alertWarningCallBack === 'function')
        alertWarningCallBack();
    cancelWarningBP()
}

function openErrorAlertBP(_text, _callBack= ''){
    $('#alertBodyDivBP').html(_text);
    $('#alertBoxDivBP').css('display', 'flex');
    errorAlertCallBack = _callBack;
}

function closeErrorAlertBP(){
    $('#alertBoxDivBP').css('display', 'none');

    if(typeof errorAlertCallBack === 'function')
        errorAlertCallBack();
}



function openMyModalBP(_id){
    $('#'+_id).addClass('showModal');
}

function closeMyModalBP(_id){
    $('#'+_id).removeClass('showModal');
}

function closeMyModalClassBP(_class){
    $('.'+_class).removeClass('showModal');
}

function numberWithCommas(_x) {
    if(_x != undefined && _x != null) {
        _x = _x.toString().replace(new RegExp(',', 'g'), '');
        var parts = _x.toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return parts.join(".");
    }
    else
        return '';
}


$(document, window).ready(() => {
    resizeFitImg('resizeImgClass');


    $('.sideNavRow').on('click', function() {
        $(this).toggleClass('open')
    });

    $('.topHeaderDropDown').on('click', function(){
        $('.topHeaderDropDown').toggleClass('open')
    })
});


