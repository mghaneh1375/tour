var newReviewFileInUpload = false;
var searchInPlaceForNewReviewAjax = null;
var searchInTagNewReviewAjax = null;
var completeSendNewReviewCallBack = null;

// $(window).ready(() => {
//     autosize($('#inputNewReviewText'));
// });

function openModalWriteNewReview(_callBack = ''){
    openMyModal('newReviewSection');

    if(!newReviewDataForUpload.code){
        $.ajax({
            type: 'POST',
            url: getNewCodeForUploadNewReviewURl,
            data: {_token: csrfTokenGlobal},
            success: response => newReviewDataForUpload.code = response.code,
        })
    }

    if(typeof _callBack === 'function')
        completeSendNewReviewCallBack = _callBack;
    else
        completeSendNewReviewCallBack = null;
}

function uploadFileForNewReview(_input, _kind){
    openLoading();

    if(_kind == 'image' && _input.files && _input.files[0]){
        cleanImgMetaData(_input, (_imgDataURL, _files) => {
            resizeImgTo(_imgDataURL, {width: null, height: 1080} , resizeImageBeforeUploadInNewReview)
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
    $('#newReviewPictureInput').val('');
    $('#newReviewVideoInput').val('');
    $('#newReview360VideoInput').val('');

    var file = newReviewDataForUpload.files[_index];
    if($(`#uplaodedImgForNewReview_${file.code}`).length == 0){
        var text = `<div id="uplaodedImgForNewReview_${file.code}" data-code="${file.code}" class="uploadFileCard process" onclick="openAlbumForNewUploadedFiles(this)">
                        <div class="img">
                            <img src="${file.image}" class="resizeImgClass" onload="fitThisImg(this)">
                        </div>
                        <div class="absoluteBackground tickIcon"></div>
                        <div class="absoluteBackground warningIcon"> اشکال در بارگذاری</div>
                        <div class="absoluteBackground process">
                            <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                            <div class="processCounter">0%</div>
                        </div>
                    </div>`;
        $('.uploadedFiles').append(text);
    }
}
function openAlbumForNewUploadedFiles(_element){
    var albumPic = [];
    var fileCode = $(_element).attr('data-code');

    newReviewDataForUpload.files.map(item => {
        var data = {
            id : item.code,
            sidePic : item.image,
            mainPic : item.image,
            userPic : window.userPic,
            userName : window.user.username,
            showInfo :  false,
            where : '',
            whereUrl : '',
            deleteFunction: deleteThisUploadedReviewFile,
        };
        if(item.kind != 'image')
            data.video = item.videoShow;

        if(item.code == fileCode)
            albumPic.unshift(data);
        else
            albumPic.push(data);
    });

    createPhotoModal('فایل های در حال اپلود', albumPic);
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
                if(video.videoHeight > 1080){
                    scale = video.videoHeight / 1080;
                    canvas.height = 1080;
                    canvas.width = video.videoWidth / scale;
                }
                else if(video.videoWidth > 1080){
                    scale = video.videoWidth / 1080;
                    canvas.width = 1080;
                    canvas.height = video.videoHeight / scale;
                }
                else{
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                }

                canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                var image = canvas.toDataURL();
                var success = image.length > 100000;

                if (success) {
                    newReviewDataForUpload.files[_index].image = image;
                    newReviewDataForUpload.files[_index].videoShow = url;
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
    closePhotoAlbumModal();
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

function resizeImageBeforeUploadInNewReview(_image, _file){

    newReviewDataForUpload.files.push({
        savedFile: '',
        uploaded: -1,
        kind: 'image',
        image: _image,
        file: _file,
        code: Math.floor(Math.random()*1000)
    });
    createNewFileUploadCardForNewReview(newReviewDataForUpload.files.length - 1);
    reviewFileUploadQueueForNewReview();
}

function storeNewReview(_element){
    var canUpload = false;
    var fileUploding = false;
    var reviewText = $('#inputNewReviewText').html();
    var text = `<div>${reviewText}</div>`;

    if(reviewText.trim().length > 0)
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
        var assignedUsersElements = $('#newReviewSection').find('.assignedUserForNewReview');
        for(var i = 0; i < assignedUsersElements.length; i++)
            assignedUsers.push($(assignedUsersElements[i]).text());

        $(_element).next().removeClass('hidden');
        $(_element).addClass('hidden');

        openLoading();
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
            complete: closeLoading,
            success: response => {
                response = JSON.parse(response);
                $(_element).next().addClass('hidden');
                $(_element).removeClass('hidden');

                if (response.status == 'ok') {
                    closeMyModal('newReviewSection');

                    newReviewDataForUpload.code = response.code;
                    newReviewDataForUpload.files = [];

                    $('#inputNewReviewText').empty();
                    $('#friendAddedSection').empty();
                    $('.uploadedFiles').empty();

                    showSuccessNotifi('دیدگاه شما با موفقیت ثبت شد.', 'left', 'var(--koochita-blue)');

                    if(completeSendNewReviewCallBack != null)
                        completeSendNewReviewCallBack();
                }
                else
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
}

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
        var elements = $('#newReviewSection').find('.assignedUserForNewReview');
        var hasCheck = true;
        for(var i = 0; i < elements.length; i++){
            if($(elements).text() == _username){
                hasCheck = false;
                break;
            }
        }

        if(hasCheck)
            $('.friendAddedSection').append(`<div class="assignedUserForNewReview user iconClose" onclick="$(this).remove()">${_username}</div>`);
    });
}

async function findWhatNewKeyInput(){
    var inputElement = $('#inputNewReviewText');
    var findNewKey = new Promise((myResolve, myReject) => {
        var newText = inputElement.html().replace(/(<([^>]+)>)/gi, "").replace(/&nbsp;/gi, "_").replace(new RegExp(' ', 'g'), '_');
        if(lastTextInputed == null){
            lastTextInputed = newText;
            myResolve(0);
        }
        else {
            if (newText.length > lastTextInputed.length) {
                var youFind = false;
                for (var i = 0; i <= lastTextInputed.length; i++) {
                    if (newText[i] != lastTextInputed[i]) {
                        youFind = i;
                        break;
                    }
                }
                lastTextInputed = newText;
                myResolve(youFind === false ? newText.length-1 : youFind);
            }
            else {
                lastTextInputed = newText;
                myResolve("delete");
            }
        }
    })

    var newKeyIndex = await findNewKey;

    if(newKeyIndex != "delete") {
        var newTextText = inputElement.text();
        if(newTextText[newKeyIndex] == "@") openFindUserForNewCharacterInput();
        else if(newTextText[newKeyIndex] == "#") openFindTagsForNewCharacterInput();
    }
}

function openFindUserForNewCharacterInput(){
    var inputElement = $('#inputNewReviewText');
    var inputPosition = getSelectionCharacterOffsetWithin("inputNewReviewText", "html");
    openKoochitaUserSearchModal('جستجوی دوستان', (_id, _username) => {
        var nowHtml = inputElement.html();
        var firstSection = nowHtml.substr(0, inputPosition);
        var lastSection = nowHtml.substr(inputPosition + 1, nowHtml.length);
        var newHtml = `${firstSection} <a href="javascript:void(0)" class="linkInTextArea" data-username="${_username}" onclick="goToUserPageReview(this)">@${_username}</a> ${lastSection}`;
        inputElement.html(newHtml);
    });
}

function openFindTagsForNewCharacterInput(){

    var inputPosition = getSelectionCharacterOffsetWithin("inputNewReviewText", "html");

    createSearchInput(_element => {
        var value = $(_element).val();

        if (searchInTagNewReviewAjax != null){
            searchInTagNewReviewAjax.abort();
            clearGlobalResult();
        }

        if(value.trim().length > 1) {
            searchInTagNewReviewAjax = $.ajax({
                type: 'GET',
                url: `${searchInReviewTagsUrl}?value=${value}`,
                success: response => {
                    if (response.status == 'ok'){
                        var html = '';
                        if(response.hasInDB == 0) {
                            html += `<div class="globalSearchItem" data-tag="${value}" onclick="selectThisTagForNewReview(this, ${inputPosition})">
                                        <div class="globalSearchItemFirstLine">
                                            <span class="globalSearchItemName">#${value}</span>
                                        </div>
                                    </div>`;
                        }

                        response.result.map(item => {
                            html += `<div class="globalSearchItem" data-tag="${item.tag}" onclick="selectThisTagForNewReview(this, ${inputPosition})">
                                        <div class="globalSearchItemFirstLine" style="display: flex; align-items: center;">
                                            <span class="globalSearchItemName">#${item.tag}</span>
                                            <span class="globalSearchItemName" style="margin-right: auto; font-weight: normal; font-size: 12px; align-items: center;">${item.tagCount} تکرار</span>
                                        </div>
                                    </div>`;
                        });

                        setResultToGlobalSearch(html);
                    }
                },
            })
        }
    }, 'برچسپ مورد نظر را وارد کنید...');
}

function selectThisTagForNewReview(_element, _pos){
    var tag = $(_element).attr('data-tag');
    tag = tag.replace(new RegExp('#', 'g'), '').replace(new RegExp(' ', 'g'), '_');

    var inputElement = $('#inputNewReviewText');
    var nowHtml = inputElement.html();
    var firstSection = nowHtml.substr(0, _pos);
    var lastSection = nowHtml.substr(_pos + 1, nowHtml.length);

    var newHtml = `${firstSection} <a href="javascript:void(0)" class="linkInTextArea" onclick="goToTagsPageReview(this)" style="color: var(--koochita-blue)">#${tag}</a> ${lastSection}`;
    inputElement.html(newHtml);
    closeSearchInput();
}

function translatePositionToReal(_pos){
    var counter = 0;
    var isStartTag = false;
    var elementHtml = $('#inputNewReviewText').html();
    for(var i = 0; i < elementHtml.length; i++){
        if(elementHtml[i] == '&' && elementHtml[i+1] == 'n' && elementHtml[i+2] == 'b' && elementHtml[i+3] == 's' && elementHtml[i+4] == 'p' && elementHtml[i+5] == ';'){
            i += 4;
            continue
        }
        if(elementHtml[i] == '<') {
            isStartTag = true;
            continue;
        }
        else if(elementHtml[i] == '>') {
            isStartTag = false;
            continue;
        }

        if(!isStartTag)
            counter++;

        if(counter == _pos)
            break;
    }

    return i;
}

function getSelectionCharacterOffsetWithin(_id, _kind = 'text') {
    var element = document.getElementById(_id);
    var start = 0;
    var end = 0;
    var doc = element.ownerDocument || element.document;
    var win = doc.defaultView || doc.parentWindow;
    var sel;
    if (typeof win.getSelection != "undefined") {
        sel = win.getSelection();
        if (sel.rangeCount > 0) {
            var range = win.getSelection().getRangeAt(0);
            var preCaretRange = range.cloneRange();
            preCaretRange.selectNodeContents(element);
            preCaretRange.setEnd(range.startContainer, range.startOffset);
            start = preCaretRange.toString().length;
            preCaretRange.setEnd(range.endContainer, range.endOffset);
            end = preCaretRange.toString().length;
        }
    } else if ( (sel = doc.selection) && sel.type != "Control") {
        var textRange = sel.createRange();
        var preCaretTextRange = doc.body.createTextRange();
        preCaretTextRange.moveToElementText(element);
        preCaretTextRange.setEndPoint("EndToStart", textRange);
        start = preCaretTextRange.text.length;
        preCaretTextRange.setEndPoint("EndToEnd", textRange);
        end = preCaretTextRange.text.length;
    }
    if(_kind == 'text')
        return start;
    else
        return translatePositionToReal(start);
}


var lastTextInputed = null;
$('#inputNewReviewText').keyup(e => findWhatNewKeyInput());

