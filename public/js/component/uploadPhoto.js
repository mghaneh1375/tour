
var file;
var uploadPhotoUrl;
var mainPicUploadPhoto;
var dropzone = $('#dropArea');
var userId = window.user.id;
var additionalData;
var mainFileName = null;
var mainFilesUploaded = [];
var repeatTime = 3;
var squerImg = {
    file: null,
    blob: null
};
var reqImg = {
    file: null,
    blob: null
};

//drag and drop file
dropzone.on('dragover', () => {
    dropzone.addClass('hover');
    return false;
});
dropzone.on('dragleave', () => {
    dropzone.removeClass('hover');
    return false;
});
dropzone.on('drop', e => {
    e.stopPropagation();
    e.preventDefault();
    dropzone.removeClass('hover');
    var files = e.originalEvent.dataTransfer;
    submitPhoto(files);
    return false;
});

function openUploadPhotoModal(_title, _uploadUrl, _placeId = 0, _kindPlaceId = 0, _additionalData){

    $('#placeIdUploadPhoto').val(_placeId);
    $('#kindPlaceIdUploadPhoto').val(_kindPlaceId);
    $('#placeNameUploadPhoto').val(_title);

    $('.titleOfUploadPhoto').text(_title);
    uploadPhotoUrl = _uploadUrl;
    additionalData = _additionalData;

    if(!checkLogin())
        return;

    $("#addPhotographerModal").removeClass('hidden');
}

function submitPhoto(input) {
    $('#uploadPhotoPicName').val('');
    $('#uploadPhotoPicAlt').val('');
    $('#uploadPhotoDescription').val('');
    $(".successScreen").addClass('hidden');

    cleanImgMetaData(input, (_imgDataURL, _files) => {
        $('#rectanglePicUploadPhoto').attr('src', _imgDataURL);
        $('#squarePicUploadPhoto').attr('src', _imgDataURL);
        $('#mainPicUploadPhotoImg').attr('src', _imgDataURL);
        mainPicUploadPhoto = _imgDataURL;
        closeLoading();
    });

    $(".itemRow").css('display', 'block');
    $(".startScreen").addClass('hidden');
    $(".action").css('display', 'block');
    $(".footer").removeClass('hidden');
}

function doEdit(ratio, result) {
    openCropImgModal(ratio, mainPicUploadPhoto, (_blob, _file) => {
        $(`#${result}`).attr('src', _file);
        if(result === 'rectanglePicUploadPhoto')
            reqImg = { file: _file, blob: _blob };
        else
            squerImg = { file: _file, blob: _blob };
    });
}

function closePhotoModal(){
    $(".successScreen").addClass('hidden');
    newUploadPic();
    $('#addPhotographerModal').addClass('hidden');
}

function submitUpload(type){
    var im = null;
    var otherSize = [];
    var nextSend = false;

    if(type === 'mainFile') {
        im = mainPicUploadPhoto;
        if(squerImg.blob == null)
            otherSize.push('squ');
        else
            nextSend = 'squ';

        if(reqImg.blob == null)
            otherSize.push('req');
        else if(nextSend === false)
            nextSend = 'req';

        if(otherSize.length == 0){
            submitUpload('squ');
            return;
        }
    }
    else if(type === 'squ' && squerImg.blob != null) {
        im = squerImg.file;
        if(reqImg.blob != null)
            nextSend = 'req';
    }
    else if(type === 'req' && reqImg.blob != null)
        im = reqImg.file;

    resizeImgTo(im, {width: null, height: 1080}, (_src, _file) => {

        var uploadPhotoFormData = new FormData();
        uploadPhotoFormData.append('name', $('#uploadPhotoPicName').val());
        uploadPhotoFormData.append('alt', $('#uploadPhotoPicAlt').val());
        uploadPhotoFormData.append('description', $('#uploadPhotoDescription').val());
        uploadPhotoFormData.append('additionalData', additionalData);
        uploadPhotoFormData.set('pic', _file);
        uploadPhotoFormData.set('fileName', mainFileName);
        uploadPhotoFormData.set('otherSize', otherSize);
        uploadPhotoFormData.set('fileKind', type);
        uploadPhotoFormData.set('placeId', $('#placeIdUploadPhoto').val());
        uploadPhotoFormData.set('kindPlaceId', $('#kindPlaceIdUploadPhoto').val());

        $.ajax({
            type : 'post',
            url : uploadPhotoUrl,
            data: uploadPhotoFormData,
            processData: false,
            contentType: false,
            xhr: function () {
                var xhr = new XMLHttpRequest();
                xhr.upload.onprogress = e => {
                    var percent = '0';
                    if (e.lengthComputable) {
                        percent = Math.round((e.loaded / e.total) * 100);
                        percent = percent/2 + (type === 'req' ? 50 : 0);
                        updatePercentLoadingBar(percent);
                    }
                };
                return xhr;
            },
            success: response => {
                if(response.status == 'ok'){
                    console.log(nextSend);
                    mainFileName = response.result[0];
                    if(nextSend !== false)
                        submitUpload(nextSend);
                    else{
                        mainFilesUploaded[mainFilesUploaded.length] = response.result[1];
                        mainFileName = null;
                        goToPage3();
                    }
                }
                else if(response.status == 'nok1'){
                    if(repeatTime != 0){
                        closeLoading();
                        showSuccessNotifi("در بارگذاری عکس مشکلی پیش امده لطفا دوباره تلاش کنید.", 'left', 'red');
                    }
                    else{
                        repeatTime--;
                        resizeImg();
                    }
                }
                else if(response.status == 'nok2'){
                    closeLoading();
                    showSuccessNotifi("فرمت عکس باید jpg و یا webp و یا jpeg و یا png باشد", 'left', 'red');
                }
                else if(response.status == 'sizeError'){
                    closeLoading();
                    showSuccessNotifi("حجم عکس باید از 2 مگابایت کمتر باشد.", 'left', 'red');
                }
            },
            error: function(err){
                closeLoading();
                showSuccessNotifi("در بارگذاری عکس مشکلی پیش امده لطفا دوباره تلاش کنید.", 'left', 'red');
            }
        })
    });
}


function resizeImg(){
    var errorElement = $('.photographerErrors');
    var name = document.getElementById('uploadPhotoPicName').value;
    var alt = document.getElementById('uploadPhotoPicAlt').value;
    var description = document.getElementById('uploadPhotoDescription').value;

    placeIdUploadPhoto = $('#placeIdUploadPhoto').val();
    kindPlaceIdUploadPhoto = $('#kindPlaceIdUploadPhoto').val();

    errorElement.text('');

    if($('#uploadPhotoRole').is(":checked") && name.trim().length > 0 &&
        description.trim().length <= 100 && kindPlaceIdUploadPhoto != 0 &&
        placeIdUploadPhoto != 0) {

        openLoading(true);
        submitUpload('mainFile');
    }
    else {
        var text = '';
        if(name == null || name == '') {
            $('#uploadPhotoPicNameDiv').addClass('inputUploadPhotosError');
            text = 'فیلد های بالا را پر کنید.';
        }
        if(description.trim().length > 100){
            $('#uploadPhotoPicAltDiv').addClass('inputUploadPhotosError');
            text += 'توضیح باید کمتر از 100 کاراکتر باشد.';
        }

        if(placeIdUploadPhoto == 0 || placeIdUploadPhoto == 0){
            $('#uploadPhotoPicAltDiv').addClass('inputUploadPhotosError');
            text += 'لطفا مشخص کنید که عکس برای چه مکانی است.';
        }

        if(!$('#photographerRole').is(":checked")) {
            text += 'تایید مقررات اجباری است';
            $('#uploadCheckBoxPolici').addClass('tickInputUploadPhotosError');
            $('.secondStepPolicyText').css('color', 'red');
        }

        errorElement.text(text);
    }
}


function newUploadPic(){
    $('#uploadPhotoInputPic').val('');
    $('#uploadPhotoPicName').val('');
    $('#uploadPhotoPicAlt').val('');
    $('#uploadPhotoDescription').val('');

    $(".itemRow").css('display', 'none');
    $(".startScreen").removeClass('hidden');
    $(".action").css('display', 'none');
    $(".footer").addClass('hidden');

    squerImg = { file: null, blob: null};
    reqImg = {file: null, blob: null};
}

function goToPage3() {
    newUploadPic();
    closeLoading();
    $('.mainPicUploadPercentDiv').hide();

    var text = '';
    var picWidth = Math.floor(100/mainFilesUploaded.length);
    for (var i = 0; i < mainFilesUploaded.length; i++){
        text += `<div class="uploadedImgShowDiv" style=" width: ${picWidth}%">
                    <img alt="کوچیتا، سامانه جامع گردشگری ایران" src="${mainFilesUploaded[i]}" class="uploadedImgPic" style="height: 100%; width: auto; ">
                </div>`;
    }

    $('#uploadedImgDiv').html(text);
    $(".itemRow").css('display', 'none');
    $(".successScreen").removeClass('hidden');
}

function searchPlaceForUploadPhoto(){
    createSearchInput(searchInPlacesUploadPhoto, 'نام مکان مورد نظر را وارد کنید.');
}

function searchInPlacesUploadPhoto(_element) {
    var value = _element.value;

    if(value.trim().length > 1){
        cities = -1;

        hotelFilter = 1;
        amakenFilter = 1;
        restuarantFilter = 1;
        majaraFilter = 1;
        sogatSanaieFilter = 1;
        mahaliFoodFilter = 1;
        boomgardyFilter = 1;


        $.ajax({
            type: 'POST',
            url: proSearchUrl,
            data: {
                key:  value,
                hotelFilter: hotelFilter,
                amakenFilter: amakenFilter,
                restaurantFilter: restuarantFilter,
                majaraFilter: majaraFilter,
                sogatSanaieFilter: sogatSanaieFilter,
                mahaliFoodFilter: mahaliFoodFilter,
                boomgardyFilter: boomgardyFilter,
                selectedCities: cities,
                mode: 'city'
            },
            success: function (response) {
                $("#resultPlace").empty();

                if(response.length == 0)
                    return;

                response = JSON.parse(response);

                newElement = "";
                for(i = 0; i < response.length; i++) {

                    if(response[i].kindPlace == 'هتل')
                        icon = '<div class="icons hotelIcon spIcons"></div>';
                    else if(response[i].kindPlace == 'رستوران')
                        icon = '<div class="icons restaurantIcon spIcons"></div>';
                    else if(response[i].kindPlace == 'اماکن')
                        icon = '<div class="icons touristAttractions spIcons"></div>';
                    else if(response[i].kindPlace == 'ماجرا')
                        icon = '<div class="icons adventure spIcons"></div>';
                    else if(response[i].kindPlace == 'غذای محلی')
                        icon = '<div class="icons traditionalFood spIcons"></div>';
                    else if(response[i].kindPlace == 'صنایع سوغات')
                        icon = '<div class="icons souvenirIcon spIcons"></div>';
                    else if(response[i].kindPlace == 'بوم گردی')
                        icon = '<div class="icons boomIcon spIcons"></div>';
                    else
                        icon = '<div class="icons touristAttractions spIcons"></div>';

                    newElement += `<div style="padding: 5px 20px; display: flex">
                                        <div style="width: 80%; color: black;" onclick="choosePlaceForUploadPhoto(${response[i].id}, ${response[i].kindPlaceId}, '${response[i].cityName}', '${response[i].name}')">
                                            <div>
                                                ${icon}
                                                <p class="suggest cursor-pointer font-weight-700" style="margin: 0px; display: inline-block;">${response[i].name}</p>
                                                <p class="suggest cursor-pointer stateName">${response[i].stateName} در ${response[i].cityName}</p>
                                            </div>
                                        </div>
                                    </div>`;
                }

                setResultToGlobalSearch(newElement);
            }
        });
    }
    else
        clearGlobalResult();
}

function choosePlaceForUploadPhoto(_placeId, _kindPlaceId, _city, _placeName){
    var name = _placeName + ' در ' + _city;

    $('#placeIdUploadPhoto').val(_placeId);
    $('#kindPlaceIdUploadPhoto').val(_kindPlaceId);
    $('#placeNameUploadPhoto').val(name);
    closeSearchInput();
}

function clickUploadRoleButton(){
    $('#uploadCheckBoxPolici').removeClass('tickInputUploadPhotosError');
    $('.secondStepPolicyText').css('color', '#4a4a4a');
}
