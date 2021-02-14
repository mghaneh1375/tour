var reviewsCount;
var imgCropNumber;
var fileUploadNum = 0;
var reviewPicNumber = 0;

var assignedUser = [];
var reviewMultiAns = [];
var reviewRateAnsId = [];
var rateQuestionAns = [];
var reviewMultiAnsId = [];
var reviewRateAnsQuestionId = [];
var reviewMultiAnsQuestionId = [];
var uploadedWriteReviewPicture = [];

var isUploadFileForReviewInPlaceDetails = false;
var fileToUploadInPlaceDetailReview = [];

$(window).ready(() => $("#postTextArea").emojioneArea());

for (i = 0; i < rateQuestion.length; i++)
    rateQuestionAns[i] = 0;

function newPostModal(kind = '') {
    if (!checkLogin())
        return;

    if($(window).width() > 767)
        $('html, body').animate({ scrollTop: $('#mainStoreReviewDiv').offset().top }, 800);

    $("#darkModal").show();
    $(".postModalMainDiv").removeClass('hidden');

    setTimeout(function () {
        if (kind == 'textarea')
            document.getElementById("postTextArea").focus();
        else if (kind == 'tag')
            $('#assignedSearch').focus();
    }, 500);
}

function uploadReviewPics(input){
    if (input.files && input.files[0]) {
        var lastNumber = reviewPicNumber;
        fileToUploadInPlaceDetailReview.push({ file: input.files[0], kind: 'image', upload: 0});

        var text = `<div id="reviewPic_${reviewPicNumber}" class="commentPhotosDiv commentPhotosAndVideos">
                        <div id="reviewPicLoader_${reviewPicNumber}" class="loaderReviewPiUpload">
                            <div id="reviewPicLoaderBackGround_${reviewPicNumber}" class="loaderReviewBackGround"></div>
                            <div id="reviewPicLoaderPercent_${reviewPicNumber}" class="loaderReviewPercent"></div>
                        </div>
                        <img id="showPic${reviewPicNumber}"  style="width: 100%; height: 100px;">
                        <input type="hidden" id="fileName_${reviewPicNumber}" >
                        <div class="deleteUploadPhotoComment" onclick="deleteUploadedReviewFile(${reviewPicNumber})"></div>
                        <div class="editUploadPhotoComment" onclick="openEditReviewPic(${reviewPicNumber})"></div>
                    </div>`;
        $('#reviewShowPics').append(text);

        var reader = new FileReader();
        reader.onload = e => {
            var mainPic = e.target.result;
            $('#showPic' + lastNumber).attr('src', mainPic);
            uploadedWriteReviewPicture[lastNumber] = mainPic;
        };
        reader.readAsDataURL(input.files[0]);

        uploadFileInPlaceDetailsReview(lastNumber);
        reviewPicNumber++;
    }
}
function uploadReviewVideo(input, _is360){
    var lastNumber = reviewPicNumber;
    fileToUploadInPlaceDetailReview.push({ file: input.files[0], kind: _is360 == 1 ? '360' : 'video', upload: 0, thumbnail: ''});

    var text = `<div id="reviewPic_${reviewPicNumber}" class="commentPhotosDiv commentPhotosAndVideos">
                    <div id="reviewPicLoader_${reviewPicNumber}" class="loaderReviewPiUpload">
                        <div id="reviewPicLoaderBackGround_${reviewPicNumber}" class="loaderReviewBackGround"></div>
                        <div id="reviewPicLoaderPercent_${reviewPicNumber}" class="loaderReviewPercent"></div>
                    </div>
                    <img id="showPic${reviewPicNumber}"  style="width: 100%; height: 100px;">
                    <input type="hidden" id="fileName_${reviewPicNumber}" >
                    <div class="deleteUploadPhotoComment" onclick="deleteUploadedReviewFile(${reviewPicNumber})"></div>
                    <div class="videoTimeDuration" id="videoDuration_${reviewPicNumber}"></div>
                </div>`;
    $('#reviewShowPics').append(text);

    window.URL = window.URL || window.webkitURL;

    var files = input.files;
    var video = document.createElement('video');
    video.preload = 'metadata';
    video.onloadedmetadata = () => {
        window.URL.revokeObjectURL(video.src);
        var duration = video.duration;
        sec = Math.floor(duration);
        min = Math.floor(sec/60);
        sec = sec - (min * 60);
        $(`#videoDuration_${lastNumber}`).text(min + ':' + sec);
    };
    video.src = URL.createObjectURL(files[0]);

    var file = input.files[0];
    var fileReader = new FileReader();
    fileReader.onload = function() {
        var blob = new Blob([fileReader.result], {type: file.type});
        var url = URL.createObjectURL(blob);
        var timeupdate = function() {
            if (snapImage()) {
                video.removeEventListener('timeupdate', timeupdate);
                video.pause();
            }
        };
        video.addEventListener('loadeddata', function() {
            if (snapImage())
                video.removeEventListener('timeupdate', timeupdate);
        });

        var snapImage = function() {
            var canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
            var image = canvas.toDataURL();
            var success = image.length > 100000;
            var lastNumber = reviewPicNumber;

            if (success) {
                var img = document.getElementById('showPic' + lastNumber);
                img.src = image;
                uploadedWriteReviewPicture[lastNumber] = image;
                URL.revokeObjectURL(url);
                fileToUploadInPlaceDetailReview[lastNumber].thumbnail = image;
                uploadFileInPlaceDetailsReview(lastNumber);
                reviewPicNumber++;
            }
            return success;
        };
        video.addEventListener('timeupdate', timeupdate);
        video.preload = 'metadata';
        video.src = url;
        video.muted = true;
        video.playsInline = true;
        video.play();
    };
    fileReader.readAsArrayBuffer(file);
}
function uploadFileInPlaceDetailsReview(_picNumber){

    if(_picNumber == -1){
        fileToUploadInPlaceDetailReview.map((item, index) => {
            if(item.upload == 0){
                uploadFileInPlaceDetailsReview(index);
                return;
            }
        })
    }

    if(!isUploadFileForReviewInPlaceDetails) {
        var uFile = fileToUploadInPlaceDetailReview[_picNumber];

        var isVideo = uFile.kind == 'image' ? 0 : 1;
        var is360 = (uFile.kind == '360') ? 1 : 0;
        var sendData = {
            code: $('#storeReviewCode').val(),
            is360,
            isVideo
        };

        isUploadFileForReviewInPlaceDetails = true;
        uploadLargeFile(reviewUploadFileURLInPlaceDetails, uFile.file, sendData, (_percent, _fileName = '', _result = '') => {
            if (_percent == 'done') {
                $(`#fileName_${_picNumber}`).val(_fileName);
                fileToUploadInPlaceDetailReview[_picNumber].saveFile = _fileName;
                fileUploadNum++;
                if(uFile.kind == 'image') {
                    fileToUploadInPlaceDetailReview[_picNumber].upload = 1;
                    $(`#reviewPicLoader_${_picNumber}`).remove();
                    isUploadFileForReviewInPlaceDetails = false;
                    uploadFileInPlaceDetailsReview(-1);
                }
                else
                    uploadThumbnailInReviewDetail(_picNumber);
                checkReviewToSend();
            }
            else if (_percent == 'error') {
                isUploadFileForReviewInPlaceDetails = false;
                showSuccessNotifi("آپلود فایل با مشگل مواجه شد", 'left', 'red');
                $('#reviewPic_' + _picNumber).remove();
                fileToUploadInPlaceDetailReview[_picNumber].upload = -2;
                uploadFileInPlaceDetailsReview(-1);
            }
            else if (_percent == 'cancelUpload') {
                isUploadFileForReviewInPlaceDetails = false;
                fileToUploadInPlaceDetailReview[_picNumber].upload = -1;
                $('#reviewPic_' + _picNumber).remove();
                uploadFileInPlaceDetailsReview(-1);
                checkReviewToSend();
            }
            else {
                var size = (160 - (_percent * 1.6)) + 'px';
                var leftBottom = ((_percent * 1.6)/2) + 'px';
                $(`#reviewPicLoaderPercent_${_picNumber}`).text(_percent+'%');
                $(`#reviewPicLoaderBackGround_${_picNumber}`).css({width: size, height: size, left: leftBottom, bottom: leftBottom});
            }
        });
    }
}
function uploadThumbnailInReviewDetail(_picNumber){

    var uFile = fileToUploadInPlaceDetailReview[_picNumber];

    var videoThumbnail = new FormData();
    videoThumbnail.append('code', $('#storeReviewCode').val());
    videoThumbnail.append('kind', 'thumbnail');
    videoThumbnail.append('file', uFile.thumbnail);
    videoThumbnail.append('fileName', uFile.saveFile);

    $.ajax({
        type: 'POST',
        url: uploadNewReviewPicUrl,
        data: videoThumbnail,
        processData: false,
        contentType: false,
        success: response => {
            if(response.status == 'ok'){
                fileToUploadInPlaceDetailReview[_picNumber].upload = 1;
                $(`#reviewPicLoader_${_picNumber}`).remove();
                isUploadFileForReviewInPlaceDetails = false;
                uploadFileInPlaceDetailsReview(-1);
            }
        },
        error: err => {
            $(`#reviewPicLoader_${_picNumber}`).remove();
            fileToUploadInPlaceDetailReview[_picNumber].upload = 1;
            isUploadFileForReviewInPlaceDetails = false;
            uploadFileInPlaceDetailsReview(-1);
        }
    })
}
function deleteUploadedReviewFile(_number){
    var fileName =  document.getElementById('fileName_' + _number).value;

    $.ajax({
        type: 'post',
        url: deleteReviewPicUrl,
        data: {
            'name': fileName,
            'code':  $('#storeReviewCode').val()
        },
        success: function(response){
            if(response.status == 'ok') {
                $('#reviewPic_' + _number).remove();
                fileUploadNum--;
                checkReviewToSend();
            }
            else{
                alert('problem')
            }
        }
    })
}


function radioChange(value, _questionId, _index, _ansId){
    if(reviewMultiAns[_index] != null)
        $(`#radioAnsStyle_${_questionId}_${reviewMultiAns[_index]}`).removeClass('filterChoose');

    $(`#radioAnsStyle_${_questionId}_${_ansId}`).addClass('filterChoose');

    if(reviewMultiAnsQuestionId.includes(_questionId)){
        var index = reviewMultiAnsQuestionId.indexOf(_questionId);
        reviewMultiAnsId[index] = _ansId;
    }
    else {
        reviewMultiAnsQuestionId[reviewMultiAnsQuestionId.length] = _questionId;
        reviewMultiAnsId[reviewMultiAnsId.length] = _ansId;
    }

    reviewMultiAns[_index] = _ansId;

    $('#multiQuestionInput').val(JSON.stringify(reviewMultiAnsQuestionId));
    $('#multiAnsInput').val(JSON.stringify(reviewMultiAnsId));

    checkReviewToSend();
}
function momentChangeRate(_index, _value, _kind){

    if(_kind == 'in') {
        for (i = 1; i < 6; i++) {
            if (_value < i) {
                document.getElementById('rate_' + i + '_' + _index).classList.remove('starRatingGreen');
                document.getElementById('rate_' + i + '_' + _index).classList.add('starRating');
            }
            else {
                document.getElementById('rate_' + i + '_' + _index).classList.remove('starRating');
                document.getElementById('rate_' + i + '_' + _index).classList.add('starRatingGreen');
            }
        }
        switch (_value) {
            case 1:
                text = 'اصلا راضی نبودم';
                break;
            case 2:
                text = 'بد نبود';
                break;
            case 3:
                text = 'معمولی بود';
                break;
            case 4:
                text = 'خوب بود';
                break;
            case 5:
                text = 'عالی بود';
                break;
        }

        document.getElementById('rateName_' + _index).innerText = text;
    }
    else{
        _value = rateQuestionAns[_index];
        for (i = 1; i < 6; i++) {
            if (_value < i) {
                document.getElementById('rate_' + i + '_' + _index).classList.remove('starRatingGreen');
                document.getElementById('rate_' + i + '_' + _index).classList.add('starRating');
            }
            else {
                document.getElementById('rate_' + i + '_' + _index).classList.remove('starRating');
                document.getElementById('rate_' + i + '_' + _index).classList.add('starRatingGreen');
            }
        }
        switch (_value) {
            case 0:
                text = '';
                break;
            case 1:
                text = 'اصلا راضی نبودم';
                break;
            case 2:
                text = 'بد نبود';
                break;
            case 3:
                text = 'معمولی بود';
                break;
            case 4:
                text = 'خوب بود';
                break;
            case 5:
                text = 'عالی بود';
                break;
        }

        document.getElementById('rateName_' + _index).innerText = text;
    }
}

function chooseQuestionRate(_index, _value, _id){
    rateQuestionAns[_index] = _value;

    if(reviewRateAnsQuestionId.includes(_id)){
        var index = reviewRateAnsQuestionId.indexOf(_id);
        reviewRateAnsId[index] = _value;
    }
    else {
        reviewRateAnsQuestionId[reviewRateAnsQuestionId.length] = _id;
        reviewRateAnsId[reviewRateAnsId.length] = _value;
    }

    document.getElementById('rateQuestionInput').value = JSON.stringify(reviewRateAnsQuestionId);
    document.getElementById('rateAnsInput').value = JSON.stringify(reviewRateAnsId);

    checkReviewToSend();
}
function openEditReviewPic(_number){

    $('#editReviewPictures').removeClass('hidden');

    $('#imgEditReviewPics').attr('src', uploadedWriteReviewPicture[_number]);
    imgCropNumber = _number;
    startReviewCropper(1, _number);
}
function startReviewCropper(ratio, _number) {

    if(first) {

        'use strict';
        Cropper = window.Cropper;
        URL = window.URL || window.webkitURL;

        // container = document.querySelector('.img-container');
        download = document.getElementById('download');
        actions = document.getElementById('actions');
        dataX = document.getElementById('dataX');
        dataY = document.getElementById('dataY');
        dataHeight = document.getElementById('dataHeight');
        dataWidth = document.getElementById('dataWidth');
        dataRotate = document.getElementById('dataRotate');
        dataScaleX = document.getElementById('dataScaleX');
        dataScaleY = document.getElementById('dataScaleY');
    }
    else {
        cropper.destroy();
        inputImage.value = null;
    }
    // image = container.getElementsByTagName('img').item(0);
    image = document.getElementById('imgEditReviewPics');

    options = {
        preview: '.img-preview',
        ready: function (e) {
            console.log(e.type);
        },
        cropstart: function (e) {
            console.log(e.type, e.detail.action);
        },
        cropmove: function (e) {
            console.log(e.type, e.detail.action);
        },
        cropend: function (e) {
            console.log(e.type, e.detail.action);
        }
    };

    cropper = new Cropper(image, options);

    if(first) {
        originalImageURL = image.src;
        uploadedImageType = 'image/jpeg';
        uploadedImageName = 'cropped.jpg';
    }

    if(first) {

        // Tooltip
        $('[data-toggle="tooltip"]').tooltip();

        // Buttons
        if (!document.createElement('canvas').getContext) {
            $('button[data-method="getCroppedCanvas"]').prop('disabled', true);
        }

        if (typeof document.createElement('cropper').style.transition === 'undefined') {
            $('button[data-method="rotate"]').prop('disabled', true);
            $('button[data-method="scale"]').prop('disabled', true);
        }

        // Download
        if (typeof download.download === 'undefined') {
            download.className += ' disabled';
        }

        // Methods
        actions.querySelector('.docs-buttons').onclick = function (event) {
            e = event || window.event;
            target = e.target || e.srcElement;

            if (!cropper) {
                return;
            }

            while (target !== this) {
                if (target.getAttribute('data-method')) {
                    break;
                }

                target = target.parentNode;
            }

            if (target === this || target.disabled || target.className.indexOf('disabled') > -1) {
                return;
            }

            data = {
                method: target.getAttribute('data-method'),
                target: target.getAttribute('data-target'),
                option: target.getAttribute('data-option') || undefined,
                secondOption: target.getAttribute('data-second-option') || undefined
            };

            cropped = cropper.cropped;

            if (data.method) {
                if (typeof data.target !== 'undefined') {
                    input = document.querySelector(data.target);

                    if (!target.hasAttribute('data-option') && data.target && input) {
                        try {
                            data.option = JSON.parse(input.value);
                        } catch (e) {
                            console.log(e.message);
                        }
                    }
                }

                switch (data.method) {
                    case 'rotate':
                        if (cropped && options.viewMode > 0) {
                            cropper.clear();
                        }

                        break;

                    case 'getCroppedCanvas':
                        try {
                            data.option = JSON.parse(data.option);
                        } catch (e) {
                            console.log(e.message);
                        }

                        if (uploadedImageType === 'image/jpeg') {
                            if (!data.option) {
                                data.option = {};
                            }

                            data.option.fillColor = '#fff';
                        }

                        break;
                }

                result = cropper[data.method](data.option, data.secondOption);

                switch (data.method) {
                    case 'rotate':
                        if (cropped && options.viewMode > 0) {
                            cropper.crop();
                        }

                        break;

                    case 'scaleX':
                    case 'scaleY':
                        target.setAttribute('data-option', -data.option);
                        break;

                    case 'getCroppedCanvas':
                        if (result) {

                            // $("#editPane").addClass('hidden');
                            // $("#photoEditor").removeClass('hidden');
                        }

                        break;
                }

                if (typeof result === 'object' && result !== cropper && input) {
                    try {
                        input.value = JSON.stringify(result);
                    } catch (e) {
                        console.log(e.message);
                    }
                }
            }
        };

        document.body.onkeydown = function (event) {
            var e = event || window.event;

            if (!cropper || this.scrollTop > 300) {
                return;
            }

            switch (e.keyCode) {
                case 37:
                    e.preventDefault();
                    cropper.move(-1, 0);
                    break;

                case 38:
                    e.preventDefault();
                    cropper.move(0, -1);
                    break;

                case 39:
                    e.preventDefault();
                    cropper.move(1, 0);
                    break;

                case 40:
                    e.preventDefault();
                    cropper.move(0, 1);
                    break;
            }
        };
        first = false;
    }
    // Import image
    inputImage = document.getElementById('showPic' + _number);

    if (URL) {
        inputImage.onchange = function () {
            var files = this.files;
            var file;

            if (cropper && files && files.length) {
                file = files[0];

                if (/^image\/\w+/.test(file.type)) {
                    uploadedImageType = file.type;
                    uploadedImageName = file.name;

                    if (uploadedImageURL) {
                        URL.revokeObjectURL(uploadedImageURL);
                    }

                    image.src = uploadedImageURL = URL.createObjectURL(file);
                    cropper.destroy();
                    cropper = new Cropper(image, options);
                    inputImage.value = null;
                } else {
                    window.alert('Please choose an image file.');
                }
            }
        };
    } else {
        inputImage.disabled = true;
        inputImage.parentNode.className += ' disabled';
    }
}
function cropReviewImg(){
    openLoading();

    var canvas1;
    var data = new FormData();
    var name = document.getElementById('fileName_' + imgCropNumber).value;

    data.append('code',  $('#storeReviewCode').val());
    data.append('name', name);

    canvas1 = cropper.getCroppedCanvas();

    $('#editReviewPictures').addClass('hidden');

    canvas1.toBlob(function (blob){
        data.append('pic', blob, name);

        $.ajax({
            type: 'post',
            url: doEditReviewPic,
            data: data,
            processData: false,
            contentType: false,
            success: function (response){
                if(response == 'ok')
                    $('#showPic' + imgCropNumber).attr('src', canvas1.toDataURL());
                else
                    $('#showPic' + imgCropNumber).attr('src', uploadedWriteReviewPicture[imgCropNumber]);
                closeLoading();
            },
            error: function(err){
                closeLoading();
                $('#showPic' + imgCropNumber).attr('src', uploadedWriteReviewPicture[imgCropNumber]);
            }
        })
    });
}


function sendWriteReview(){
    if(checkReviewToSend()) {
        var textId = [];
        var textAns = [];
        var assignedUsers = [];

        textQuestions.forEach(item => {
            textAns.push($('#textQuestionAns_'+item.id).val());
            textId.push(item.id);
        });

        var assignedUsersElements = $('#reviewMainDivDetails').find('.assignedUserForNewReview');
        for(var i = 0; i < assignedUsersElements.length; i++)
            assignedUsers.push($(assignedUsersElements[i]).text());

        $('#sendReviewButton').hide();
        $('#sendReviewLoader').css('display', 'flex');

        $.ajax({
            type: 'POST',
            url: storeReviewURLM,
            data: {
                _token: csrfTokenGlobal,
                kindPlaceId: $('#storeReviewKindPlaceId').val(),
                placeId: $('#storeReviewPlaceId').val(),
                code: $('#storeReviewCode').val(),
                assignedUser: assignedUsers,
                multiAns: $('#multiAnsInput').val(),
                multiQuestion: $('#multiQuestionInput').val(),
                rateAns: $('#rateAnsInput').val(),
                rateQuestion: $('#rateQuestionInput').val(),
                text: $('#postTextArea').val(),
                textId: textId,
                textAns: textAns,
            },
            success: function(response){
                try{
                    response = JSON.parse(response);
                    if(response.status == 'ok'){
                        $('#storeReviewCode').val(response.code);
                        showSuccessNotifi('دیدگاه شما با موفقیت ثبت شد.', 'left', 'var(--koochita-blue)');
                        reviewPage = 1;
                        assignedUser = [];
                        $('#participantDivMainDiv').html('');
                        loadReviews();
                        clearStoreReview();
                    }
                    else{
                        showSuccessNotifi("در ثبت دیدگاه مشکلی پیش آمده لطفا دوباره تلاش نمایید.", 'left', 'red');
                    }
                }
                catch (e) {
                    showSuccessNotifi("در ثبت دیدگاه مشکلی پیش آمده لطفا دوباره تلاش نمایید.", 'left', 'red');
                }

                $('#sendReviewButton').show();
                $('#sendReviewLoader').hide();
            },
            error: function(err){
                showSuccessNotifi("در ثبت دیدگاه مشکلی پیش آمده لطفا دوباره تلاش نمایید.", 'left', 'red');

                $('#sendReviewButton').show();
                $('#sendReviewLoader').hide();
            }
        })
    }
}
function checkReviewToSend(_kind = ''){
    var error = false;
    var text = $('#postTextArea').val();

    if(text.trim().length > 0)
        error = true;

    if(fileUploadNum > 0)
        error = true;

    if(reviewRateAnsId.length > 0)
        error = true;

    if(reviewMultiAnsId.length > 0)
        error = true;

    for(var i = 0; i < fileToUploadInPlaceDetailReview.length; i++){
        if(fileToUploadInPlaceDetailReview[i].upload == 0){
            error = true;
            break;
        }
    }


    if(error && !isUploadFileForReviewInPlaceDetails) {
        if(_kind == 'send')
            sendWriteReview();
        return true;
    }
    else
        return false;
}
function clearStoreReview(){
    $('#reviewShowPics').html('');
    $('#multiAnsInput').val('');
    $('#multiQuestionInput').val('');
    $('#rateAnsInput').val('');
    $('#rateQuestionInput').val('');
    $('#postTextArea').val('');

    fileUploadNum = 0;
    reviewRateAnsId = [];
    reviewMultiAnsId = [];
    assignedUser = [];
    reviewRateAnsQuestionId = [];
    reviewMultiAnsQuestionId = [];

    for(i = 0; i < rateQuestion.length; i++){
        rateQuestionAns[i] = 0;
        momentChangeRate(i, 0, 'out');
    }

    $($('#postTextArea').next().children()[0]).html('');

    textQuestions.forEach(item => $('#textQuestionAns_'+item.id).val('') );
    closeNewPostModal();
}
function closeNewPostModal() {
    $('#darkModal').hide();
    $(".postModalMainDiv").addClass('hidden');
    $('.showNewTextReviewArea').val($('#postTextArea').val())
}



