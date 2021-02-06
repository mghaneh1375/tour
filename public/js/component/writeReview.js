var newReviewFileInUpload = false;

$(window).ready(() => {
    autosize($('#inputNewReviewText'));
});

function openModalWriteNewReview(){
    openMyModal('newReviewSection');

    if(!newReviewDataForUpload.code){
        $.ajax({
            type: 'POST',
            url: getNewCodeForUploadNewReviewURl,
            data: {_token: csrfTokenGlobal},
            success: response => newReviewDataForUpload.code = response.code,
        })
    }
}

function uploadFileForNewReview(_input, _kind){
    openLoading();

    if(_kind == 'image' && _input.files && _input.files[0]){

        cleanImgMetaData(_input, function(_imgDataURL, _files){ // in forAllPages.blade.php
            newReviewDataForUpload.files.push({
                savedFile: '',
                uploaded: -1,
                kind: 'image',
                image: _imgDataURL,
                file: _files,
                code: Math.floor(Math.random()*1000)
            });
            createNewFileUploadCardForNewReview(newReviewDataForUpload.files.length - 1);
            reviewFileUploadQueueForNewReview();
        });
    }
    else if(_kind == 'video' || _kind == '360Video'){
        var ind = newReviewDataForUpload.files.push({
            savedFile: '',
            thumbnailFile: '',
            uploaded: -1,
            image: '',
            kind: _kind,
            file: _input.files[0],
            code: Math.floor(Math.random()*1000)
        });
        convertVideoFileForConvertForNewReview(ind-1);
    }
    else
        closeLoading();
}

function createNewFileUploadCardForNewReview(_index){
    closeLoading();
    var file = newReviewDataForUpload.files[_index];
    if($(`#uplaodedImgForNewReview_${file.code}`).length == 0){
        var text = `<div id="uplaodedImgForNewReview_${file.code}" class="uploadFileCard">
                    <div class="img">
                        <img src="${file.image}" class="resizeImgClass" onload="fitThisImg(this)">
                    </div>
                    <div class="absoluteBackground tickIcon"></div>
                    <div class="absoluteBackground warningIcon"> اشکال در بارگذاری</div>
                    <div class="absoluteBackground process">
                        <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                        <div class="processCounter">0%</div>
                    </div>
                    <div class="hoverInfos">
                        <div onclick="deleteThisUploadedReviewFile(${file.code})" class="cancelButton closeIconWithCircle"> حذف عکس </div>
                    </div>
                </div>`;
        $('.uploadedFiles').append(text);
    }
}

function convertVideoFileForConvertForNewReview(_index){
    try{
        var uFile = newReviewDataForUpload.files[_index];
        window.URL = window.URL || window.webkitURL;

        var video = document.createElement('video');
        video.preload = 'metadata';
        video.src = URL.createObjectURL(uFile.file);

        var fileReader = new FileReader();
        fileReader.onload = function() {
            var blob = new Blob([fileReader.result], {type: uFile.file.type});
            var url = URL.createObjectURL(blob);
            var timeupdate = function() {
                if (snapImage()) {
                    video.removeEventListener('timeupdate', timeupdate);
                    video.pause();
                }
            };
            video.addEventListener('loadeddata', function() {
                if (snapImage()) {
                    video.removeEventListener('timeupdate', timeupdate);
                }
            });

            var snapImage = function() {
                var canvas = document.createElement('canvas');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                var image = canvas.toDataURL();
                var success = image.length > 100000;

                if (success) {
                    newReviewDataForUpload.files[_index].image = image;
                    URL.revokeObjectURL(url);
                    createNewFileUploadCardForNewReview(_index);
                    reviewFileUploadQueueForNewReview();
                }
                return success;
            };
            video.addEventListener('timeupdate', timeupdate);
            video.preload = 'metadata';
            video.src = url;
            video.muted = true;
            video.playsInline = true;
            video.currentTime = 2;
            video.play();
        };
        fileReader.readAsArrayBuffer(uFile.file);
    }
    catch (e) {
        closeLoading();
    }
}

function reviewFileUploadQueueForNewReview(){
    if(!newReviewFileInUpload){
        var uploadFileIndex = null;
        newReviewDataForUpload.files.map((item, index) =>{
            if(item.uploaded == -1 && uploadFileIndex == null)
                uploadFileIndex = index;
        });
        if(uploadFileIndex != null){
            var uFile = newReviewDataForUpload.files[uploadFileIndex];

            newReviewFileInUpload = true;
            newReviewDataForUpload.files[uploadFileIndex].uploaded = 0;
            $('#uplaodedImgForNewReview_' + uFile.code).addClass('process');

            var isVideo = 0;
            var is360 = 0;
            if(uFile.kind == 'video'){
                isVideo = 1;
                if(uFile.kind != 'video')
                    is360 = 1;
            }

            $('.uploadedFiles').scrollLeft($(`#uplaodedImgForNewReview_${uFile.code}`).position().left - 100);
            uploadLargeFile(reviewUploadFileUrl, uFile.file, {code: newReviewDataForUpload.code, is360, isVideo}, (_percent, _fileName = '', _result = '') => {
                if(_percent == 'done') {
                    newReviewFileInUpload = false;
                    newReviewDataForUpload.files[uploadFileIndex].savedFile = _fileName;
                    if(uFile.kind == 'image'){
                        $('#uplaodedImgForNewReview_' + uFile.code).removeClass('process').addClass('done');
                        newReviewDataForUpload.files[uploadFileIndex].uploaded = 1;
                        reviewFileUploadQueueForNewReview();
                    }
                    else
                        uploadReviewVideoThumbnail(uploadFileIndex);
                }
                else if(_percent == 'error') {
                    newReviewFileInUpload = false;
                    $('#uplaodedImgForNewReview_' + uFile.code).removeClass('process').addClass('error');
                    newReviewDataForUpload.files[uploadFileIndex].uploaded = -2;
                    reviewFileUploadQueueForNewReview();
                }
                else if(_percent == 'cancelUpload'){
                    newReviewFileInUpload = false;
                    newReviewDataForUpload.files[uploadFileIndex].uploaded = -1;
                    doDeleteNewReviewFile(uploadFileIndex);
                }
                else {
                    newReviewDataForUpload.code = _result;
                    $('#uplaodedImgForNewReview_' + uFile.code).find('.processCounter').text(_percent + '%');
                }
            });
        }
    }
}

function uploadReviewVideoThumbnail(_index){
    var uFile = newReviewDataForUpload.files[_index];

    var videoThumbnail = new FormData();
    videoThumbnail.append('code', newReviewDataForUpload.code);
    videoThumbnail.append('kind', 'thumbnail');
    videoThumbnail.append('file', uFile.image);
    videoThumbnail.append('fileName', uFile.savedFile);

    $.ajax({
        type: 'POST',
        url: uploadNewReviewPicUrl,
        data: videoThumbnail,
        processData: false,
        contentType: false,
        success: response => {
            if(response.status == 'ok'){
                $('#uplaodedImgForNewReview_' + uFile.code).removeClass('process').addClass('done');
                $('#uplaodedImgForNewReview_' + uFile.code);
                newReviewDataForUpload.files[_index].uploaded = 1;
                newReviewDataForUpload.files[_index].thumbnailFile = response.result;
                reviewFileUploadQueueForNewReview();
            }
        },
        error: err => {
            $('#uplaodedImgForNewReview_' + uFile.code).removeClass('process').addClass('error');
            newReviewDataForUpload.files[_index].uploaded = -2;
            reviewFileUploadQueueForNewReview();
        }
    })
}

function deleteThisUploadedReviewFile(_code){
    var findedIndex = null;
    newReviewDataForUpload.files.map((item, index) => {
        if(item.code == _code)
            findedIndex = index;
    });

    if(findedIndex != null)
        doDeleteNewReviewFile(findedIndex);
}

function doDeleteNewReviewFile(_index){
    var dFile = newReviewDataForUpload.files[_index];
    if(dFile.uploaded == 1){
        $.ajax({
            type: 'POST',
            url: deleteNewReviewPicUrl,
            data:{
                _token: csrfTokenGlobal,
                name: dFile.savedFile,
                code: newReviewDataForUpload.code,
            },
            success: response => {
                if(response.status == 'ok'){
                    $(`#uplaodedImgForNewReview_${dFile.code}`).remove();
                    newReviewDataForUpload.files.splice(_index, 1);
                }
            },
        });
    }
    else if(dFile.uploaded == 0)
        cancelLargeUploadedFile();
    else{
        $(`#uplaodedImgForNewReview_${dFile.code}`).remove();
        newReviewDataForUpload.files.splice(_index, 1);
    }

    reviewFileUploadQueueForNewReview();
}

function storeNewReview(_element){
    var canUpload = false;
    var fileUploding = false;
    var text = $('#inputNewReviewText').val();

    if(text.trim().length > 0)
        canUpload = true;

    newReviewDataForUpload.files.map(item =>{
        if(item.uploaded == 0){
            openWarning('یکی از فایل ها درحال آپلود می باشد. منتظر بمانید.');
            fileUploding = true;
            return;
        }
        if(item.uploaded == 1)
            canUpload = true;
    });

    if(canUpload && !fileUploding) {
        var assignedUsers = [];
        var assignedUsersElements = $('.assignedUserForNewReview');
        for(var i = 0; i < assignedUsersElements.length; i++)
            assignedUsers.push($(assignedUsersElements[i]).text());


        $(_element).next().removeClass('hidden');
        $(_element).addClass('hidden');

        $.ajax({
            type: 'POST',
            url: storeNewReviewUrl,
            data: {
                _token: csrfTokenGlobal,
                kindPlaceId: $('#kindPlaceIdNewReview').val(),
                placeId: $('#placeIdNewReview').val(),
                code: newReviewDataForUpload.code,
                assignedUser: JSON.stringify(assignedUsers),
                text: text,
            },
            success: response => {
                response = JSON.parse(response);
                $(_element).next().addClass('hidden');
                $(_element).removeClass('hidden');

                if (response.status == 'ok') {
                    closeMyModal('newReviewSection');

                    newReviewDataForUpload.code = response.code;
                    newReviewDataForUpload.files = [];

                    $('#inputReviewText').val('');
                    $('#friendAddedSection').empty();
                    $('.uploadedFiles').empty();

                    showSuccessNotifi('دیدگاه شما با موفقیت ثبت شد.', 'left', 'var(--koochita-blue)');
                } else
                    showSuccessNotifi('در ثبت دیدگاه مشکلی پیش امده.', 'left', 'red');
            },
            error: err => {
                showSuccessNotifi('در ثبت دیدگاه مشکلی پیش امده.', 'left', 'red');
                $(_element).next().addClass('hidden');
                $(_element).removeClass('hidden');
            }
        })
    }

}

var searchInPlaceForNewReviewAjax = null;
function addPlaceToNewReview(){
    createSearchInput(_element => {
        var value = $(_element).val();

        if (searchInPlaceForNewReviewAjax != null){
            searchInPlaceForNewReviewAjax.abort();
            clearGlobalResult();
        }

        if(value.trim().length > 1) {
            searchInPlaceForNewReviewAjax = $.ajax({
                type: 'GET',
                url: `${searchPlaceForNewReviewUrl}?value=${value}&kindPlaceId=all`,
                success: response => {
                    if (response.status == 'ok')
                        setResultToGlobalSearchDefaultForPlaces(response.result, selectPlaceForNewReview);
                },
            })
        }
    }, 'محل مورد نظر را جستجو کنید...');
};

function selectPlaceForNewReview(_kindPlaceId, _placeId, _placeName){
    $('#kindPlaceIdNewReview').val(_kindPlaceId);
    $('#placeIdNewReview').val(_placeId);

    $('#addPlaceButtonNewReview').removeClass('atractionIcon').addClass('newReviewButWithPlace').text(_placeName);

    $('.newReviewButWithPlace').on('click', () => {
        $('#kindPlaceIdNewReview').val(0);
        $('#placeIdNewReview').val(0);
        $('#addPlaceButtonNewReview').removeClass('newReviewButWithPlace').addClass('atractionIcon').text('محل عکس را مشخص کنید');
    })
}

function openUserSearchForNewReview(){
    openKoochitaUserSearchModal('جستجوی دوستان', (_id, _username) => {
        $('#friendAddedSection').append(`<div class="assignedUserForNewReview user iconClose" onclick="deleteThisAssignedUserToReview(this)">${_username}</div>`);
    });
}

function deleteThisAssignedUserToReview(_element){
    $(_element).remove();
}
