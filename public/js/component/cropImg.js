var callBackAfterFinishCropImg = null;

function openCropImgModal(_ratio, _img, _callBack) {
    openLoading();
    openMyModal('editCropModal');
    $('#editUploadPhoto').attr('src', _img);
    startCropper(_ratio);
    callBackAfterFinishCropImg = _callBack;
}

function submitCropInModal(){
    openLoading();

    var canvas1;
    canvas1 = cropper.getCroppedCanvas();
    canvas1.toBlob(blob => {
        callBackAfterFinishCropImg(blob, canvas1.toDataURL());
        closeCropImgModal();
    });
}

function closeCropImgModal(){
    closeMyModal('editCropModal');
    closeLoading();
}
