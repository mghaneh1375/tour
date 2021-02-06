var alertWarningCallBack = false;
var errorAlertCallBack;

function resizeFitImg(_class) {
    let imgs = $('.' + _class);
    for(let i = 0; i < imgs.length; i++)
        fitThisImg(imgs[i]);
}

function fitThisImg(_element){
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

function isNeedSideProgressBar(_kind){
    if(_kind)
        $('#mainSideBar').addClass("hasSideProgressBar");
    else
        $('#mainSideBar').removeClass("hasSideProgressBar");
}

function updateSideProgressBar(_percent){
    $('#sideProgressBarNumber').text(_percent+'%');
    $('#sideProgressBarFull').css('width', _percent+'%');
}

function openLoading(_process = false, _callBack = ''){
    $('#fullPageLoader').removeClass('hidden');

    $('#fullPageLoader').find('.percentBar').text(`0%`);
    $('#fullPageLoader').find('.bar').css('width', `0%`);

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
    $('#fullPageLoader').find('.percentBar').text(`${_percent}%`);
    $('#fullPageLoader').find('.bar').css('width', `${_percent}%`);
}


function showSuccessNotifiBP(_msg, _side = 'right', _color = '#0076ac'){
    var element = $('#successNotifiAlertBP');
    element.text(_msg).addClass('topAlertBP').css('background', _color).addClass(_side == 'right' ? 'rightAlertBP' : 'leftAlertBP');
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


$(document, window).ready(() => {
    resizeFitImg('resizeImgClass');


    $('.sideNavRow').on('click', function(){
        $('.sideNavRow').removeClass('open');
        $(this).toggleClass('open')
    });

    $('.topHeaderDropDown').on('click', function(){
        $('.topHeaderDropDown').toggleClass('open')
    })
});


