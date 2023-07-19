let alertWarningCallBack = false;
var errorAlertCallBack;

function showSuccessNotifi(_msg, _side = 'right', _color = '#0076ac'){
    var successNotifiAlertElement = $('#successNotifiAlert');

    successNotifiAlertElement.text(_msg).css('background', _color).addClass('topAlert').addClass(_side == 'right' ? 'rightAlert' : 'leftAlert');

    setTimeout(function(){
        successNotifiAlertElement.removeClass('topAlert');
        setTimeout(function () {
            successNotifiAlertElement.removeClass('leftAlert').removeClass('rightAlert');
        }, 1000);
    }, 5000);

}

function openWarning(_text, _callBack = false, _okText = 'بسیار خب'){
    alertWarningCallBack = _callBack;
    $('#warningOkText').text(_okText);

    if(typeof _callBack === 'function')
        $('#warningModalCallBackShow').show();
    else
        $('#warningModalCallBackShow').hide();

    $('#warningBody').html(_text);
    $('#warningBoxDiv').css('display', 'flex');
}

function cancelWarning(){
    $('#warningBoxDiv').css('display', 'none');
}

function closeWarning(){
    if(alertWarningCallBack !== false && typeof alertWarningCallBack === 'function')
        alertWarningCallBack();
    cancelWarning()
}

function openErrorAlert(_text, _callBack= ''){
    $('#alertBodyDiv').html(_text);
    $('#alertBoxDiv').css('display', 'flex');
    errorAlertCallBack = _callBack;
}

function closeErrorAlert(){
    $('#alertBoxDiv').css('display', 'none');
    if(typeof errorAlertCallBack === 'function')
        errorAlertCallBack();
}
