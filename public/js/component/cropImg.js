var callBackAfterFinishCropImg = null;

function openCropImgModal(_ratio, _img, _callBack) {
    openMyModal('editCropModal');
    openLoading(false, () => {
        $('#editUploadPhoto').attr('src', _img);
        try {
            startCropper(_ratio);
        }
        catch (e) {
            closeCropImgModal();
        }
        callBackAfterFinishCropImg = _callBack;
    });
}

function submitCropInModal(){
    openLoading(false, () => {
        var canvas1;
        canvas1 = cropper.getCroppedCanvas();
        canvas1.toBlob(blob => {
            callBackAfterFinishCropImg(blob, canvas1.toDataURL());
            closeCropImgModal();
        });
    });
}

function closeCropImgModal(){
    closeMyModal('editCropModal');
    closeLoading();
}
