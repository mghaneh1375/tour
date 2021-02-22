var mainMap;
var cancelThisReviewFile = false;
var reviewFileInUpload = false;
var uploadReviewFileAjax = null;

function uploadFileForReview(_input, _kind){
    openWriteReview();
    if(_kind == 'image' && _input.files && _input.files[0]){
        var reader = new FileReader();
        reader.onload = e => {
            newReview.files.push({
                savedFile: '',
                uploaded: -1,
                image: e.target.result,
                kind: _kind,
                file: _input.files[0],
                code: Math.floor(Math.random()*1000)
            });
            createNewFileUploadCard(newReview.files.length - 1);
            reviewFileUploadQueue();
        };
        reader.readAsDataURL(_input.files[0]);
    }
    else if(_kind == 'video' || _kind == '360Video'){
        var ind = newReview.files.push({
            savedFile: '',
            thumbnailFile: '',
            uploaded: -1,
            image: '',
            kind: _kind,
            file: _input.files[0],
            code: Math.floor(Math.random()*1000)
        });
        convertVideoFileForConvert(ind-1);
    }
}

function createNewFileUploadCard(_index){
    var file = newReview.files[_index];
    var text = `<div id="uplaodedImg_${file.code}" class="uploadFileCard">
                    <div class="img">
                        <img src="${file.image}" class="resizeImgClass" onload="fitThisImg(this)">
                    </div>
                    <div class="absoluteBackground tickIcon"></div>
                    <div class="absoluteBackground warningIcon">اشکال در بارگذاری</div>
                    <div class="absoluteBackground process">
                        <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                        <div class="processCounter">0%</div>
                    </div>
                    <div class="hoverInfos">
                        <div onclick="deleteThisUploadedReviewFile(${file.code})" class="cancelButton closeIconWithCircle" >حذف عکس</div>
                    </div>
                </div>`;
    $('.uploadedFiles').append(text);
}

function convertVideoFileForConvert(_index){
    var uFile = newReview.files[_index];
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
                newReview.files[_index].image = image;
                URL.revokeObjectURL(url);
                createNewFileUploadCard(_index);
                reviewFileUploadQueue();
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
    fileReader.readAsArrayBuffer(uFile.file);
}

function reviewFileUploadQueue(){
    if(!reviewFileInUpload){
        var uploadFileIndex = null;
        newReview.files.map((item, index) =>{
            if(item.uploaded == -1 && uploadFileIndex == null)
                uploadFileIndex = index;
        });
        if(uploadFileIndex != null){
            reviewFileInUpload = true;
            newReview.files[uploadFileIndex].uploaded = 0;
            var uFile = newReview.files[uploadFileIndex];
            $('#uplaodedImg_' + uFile.code).addClass('process');

            var formData = new FormData();
            formData.append('code', newReview.code);
            formData.append('file', uFile.file);
            formData.append('kind', uFile.kind);

            uploadReviewFileAjax = $.ajax({
                type: 'POST',
                url: uploadReviewPicForLocalShop,
                data: formData,
                processData: false,
                contentType: false,
                xhr: function () {
                    var xhr = new XMLHttpRequest();
                    xhr.upload.onprogress = e => {
                        if (e.lengthComputable) {
                            var percent = Math.round((e.loaded / e.total) * 100);
                            $(`#uplaodedImg_${uFile.code}`).find('.processCounter').text(percent + '%');
                        }
                    };
                    return xhr;
                },
                success: response => {
                    reviewFileInUpload = false;
                    if (response.status == 'ok') {
                        if(cancelThisReviewFile) {
                            doDeleteReviewFile(uploadFileIndex);
                            cancelThisReviewFile = false;
                        }
                        if(uFile == 'image'){
                            $('#uplaodedImg_' + uFile.code).removeClass('process');
                            $('#uplaodedImg_' + uFile.code).addClass('done');
                            newReview.files[uploadFileIndex].uploaded = 1;
                            newReview.files[uploadFileIndex].savedFile = response.result;
                            reviewFileUploadQueue();
                        }
                        else{
                            newReview.files[uploadFileIndex].savedFile = response.result;
                            uploadReviewVideoThumbnail(uploadFileIndex);
                        }
                    }
                    else{
                        $('#uplaodedImg_' + uFile.code).removeClass('process');
                        $('#uplaodedImg_' + uFile.code).addClass('error');
                        newReview.files[uploadFileIndex].uploaded = -2;
                        reviewFileUploadQueue();
                    }
                },
                error: err => {
                    reviewFileInUpload = false;
                    $('#uplaodedImg_' + uFile.code).removeClass('process');
                    $('#uplaodedImg_' + uFile.code).addClass('error');
                    newReview.files[uploadFileIndex].uploaded = -2;
                    reviewFileUploadQueue();
                }
            })
        }
    }
}

function uploadReviewVideoThumbnail(_index){
    var uFile = newReview.files[_index];

    var videoThumbnail = new FormData();
    videoThumbnail.append('code', newReview.code);
    videoThumbnail.append('kind', 'videoPic');
    videoThumbnail.append('file', uFile.image);
    videoThumbnail.append('fileName', uFile.savedFile);

    $.ajax({
        type: 'POST',
        url: uploadReviewPicForLocalShop,
        data: videoThumbnail,
        processData: false,
        contentType: false,
        success: response => {
            if(response.status == 'ok'){
                $('#uplaodedImg_' + uFile.code).removeClass('process');
                $('#uplaodedImg_' + uFile.code).addClass('done');
                newReview.files[_index].uploaded = 1;
                newReview.files[_index].thumbnailFile = response.result;
                reviewFileUploadQueue();
            }
        },
        error: err => {
            $('#uplaodedImg_' + uFile.code).removeClass('process');
            $('#uplaodedImg_' + uFile.code).addClass('error');
            newReview.files[_index].uploaded = -2;
            reviewFileUploadQueue();
        }
    })
}

function deleteThisUploadedReviewFile(_code){
    var findedIndex = null;
    newReview.files.map((item, index) => {
        if(item.code == _code)
            findedIndex = index;
    });

    if(findedIndex != null)
        doDeleteReviewFile(findedIndex);
}

function doDeleteReviewFile(_index){
    var dFile = newReview.files[_index];
    if(dFile.uploaded == 1){
        $.ajax({
            type: 'delete',
            url: deleteReviewPicForLocalShop,
            data:{
                _token: csrfTokenGlobal,
                fileName: dFile.savedFile,
                code: newReview.code,
            },
            success: response => {
                if(response.status == 'ok'){
                    $(`#uplaodedImg_${dFile.code}`).remove();
                    newReview.files.splice(_index, 1);
                }
            },
        })
    }
    else if(dFile.uploaded == 0)
        cancelThisReviewFile = true;
    else{
        $(`#uplaodedImg_${dFile.code}`).remove();
        newReview.files.splice(_index, 1);
    }
}

function storeReview(_element){
    var canUpload = false;
    var text = $('#inputReviewText').val();

    if(text.trim().length > 0)
        canUpload = true;

    newReview.files.map(item =>{
        if(item.uploaded == 0){
            openWarning('یکی از فایل ها درحال آپلود می باشد. منتظر بمانید.');
            return;
        }
        if(item.uploaded == 1)
            canUpload = true;
    });

    $(_element).next().removeClass('hidden');
    $(_element).addClass('hidden');

    $.ajax({
        type: 'POST',
        url: reviewPicForLocalShop,
        data: {
            _token: csrfToken,
            kindPlaceId: 13,
            placeId: localShop.id,
            code: newReview.code,
            userAssigned: JSON.stringify(newReview.userAssigned),
            text: text,
        },
        success: response =>{
            $(_element).next().addClass('hidden');
            $(_element).removeClass('hidden');

            if(response.status == 'ok'){
                closeWriteReview();
                newReview.code = response.result;
                newReview.userAssigned = [];
                newReview.files = [];
                $('#inputReviewText').val('');
                $('#friendAddedSection').find('.acceptedUserFriend').remove();
                $('.uploadedFiles').find('.uploadFileCard').remove();
                showSuccessNotifi('دیدگاه شما با موفقیت ثبت شد.', 'left', 'var(--koochita-blue)');
            }
            else
                showSuccessNotifi('در ثبت دیدگاه مشکلی پیش امده.', 'left', 'red');
        },
        error: err => {
            console.log(err);
            showSuccessNotifi('در ثبت دیدگاه مشکلی پیش امده.', 'left', 'red');
            $(_element).next().addClass('hidden');
            $(_element).removeClass('hidden');
        }
    })

}

function openAlbum(_kind, selectId = 0){
    if(_kind == 'mainPics'){
        var showPics = [];
        var selectIndex = 0;
        localShop.pics.map((item, index) => {
            if(item.id == selectId)
                selectIndex = index;
            if(item.picCategory == "sitePicture") {
                showPics.push({
                    id: `main_${item.id}`,
                    sidePic: item.pic.l,
                    mainPic: item.pic.main,
                    userPic: item.ownerPic,
                    userName: item.ownerUsername,
                    alt: item.alt,
                    showInfo: false,
                });
            }
            else if(item.picCategory == "photographer"){
                showPics.push({
                    id: `photographer_${item.id}`,
                    sidePic: item.pic.l,
                    mainPic: item.pic.main,
                    alt: item.alt,
                    description: item.description,
                    userPic: item.ownerPic,
                    userName: item.ownerUsername,
                    showInfo: true,
                    like: item.like,
                    dislike: item.dislike,
                });
            }
        });
        createPhotoModal('آلبوم عکس', showPics, selectIndex) ; //in photoAlbumModal.blade.php
    }
}

function initMap(){

    mainMapInBlade = L.map("mapDiv", {
        minZoom: 1,
        maxZoom: 20,
        crs: L.CRS.EPSG3857,
        center: [localShop.lat, localShop.lng],
        zoom: 15
    });
    L.TileLayer.wmsHeader(
        "https://map.ir/shiveh",
        {
            layers: "Shiveh:Shiveh",
            format: "image/png",
            minZoom: 1,
            maxZoom: 20
        },
        [
            {
                header: "x-api-key",
                value: window.mappIrToken
            }
        ]
    ).addTo(mainMapInBlade);

    var marker = L.marker([localShop.lat, localShop.lng], {
        title: localShop.name,
        // icon: L.icon({
        //     iconUrl: mapIcon[x],
        //     iconSize: [30, 35],
        // })
    }).bindPopup(localShop.name);
    marker.addTo(mainMapInBlade);


    // var mapOptions = {
    //     center: new google.maps.LatLng(localShop.lat, localShop.lng),
    //     zoom: 15,
    //     styles: window.googleMapStyle
    // };
    // var mapElementSmall = document.getElementById('mapDiv');
    // mainMap = new google.maps.Map(mapElementSmall, mapOptions);
    //
    // new google.maps.Marker({
    //     position: new google.maps.LatLng(localShop.lat, localShop.lng)
    // }).setMap(mainMap);
}

function openWriteReview(){
    if(!checkLogin())
        return;

    $('#darkModal').show();
    $('#inputReviewSec').addClass('openReviewSec');
    autosize($('#inputReviewText'));
}

function closeWriteReview(){
    $('#darkModal').hide();
    $('#inputReviewSec').removeClass('openReviewSec');
    $('#inputReviewText').css('height', '80px');
}

function likeDisLikeShop(_element, _like){
    $(_element).parent().addClass('youRate');
    $(_element).parent().find('.selected').removeClass('selected');
    $(_element).addClass('selected');
}

function goToSection(_section){
    var topScroll = 0;
    var topInfoHeight = $('#topInfos').height();

    if(_section == 'description')
        topScroll = $('#stickyIndicator').offset().top - 10;
    else if(_section == 'map')
        topScroll = $('#mapDiv').offset().top - topInfoHeight+10;
    else if(_section == 'review')
        topScroll = $('#inputReviewSec').offset().top - topInfoHeight+10;
    else if(_section == 'question')
        topScroll = $('#questionSection').offset().top - topInfoHeight+10;

    $('html, body').animate({ scrollTop: topScroll }, 1000);
}

function searchUserFriend(_element){
    var value = $(_element).val();
    $('.searchResultUserFriend').empty().removeClass('open');

    if(value.trim().length > 1){
        searchForUserCommon(value)
            .then(response => {
                var text = '';
                var userName = response.userName;
                userName.map(item => text += `<div class="UserIcon result" onclick="addToSelectedUser(this)">${item.username}</div>`);
                $('.searchResultUserFriend').empty();
            })
            .catch(err => {
                $('.searchResultUserFriend').html(text).addClass('open');
                console.error(err);
            });
    }
    else
        $('.searchResultUserFriend').empty().removeClass('open');
}

function deleteAssigned(_element, _index){
    newReview.userAssigned.splice(_index, 1);
    $(_element).parent().remove();
}

function addToSelectedUser(_element){
    var username = $(_element).text();
    var text = '';
    if(newReview.userAssigned.indexOf(username) == -1) {
        var index = newReview.userAssigned.push(username);
        text = `<div class="acceptedUserFriend">
                            <div class="name">${username}</div>
                            <div class="iconClose" onclick="deleteAssigned(this, ${index-1})"></div>
                        </div>`;
    }

    $('#friendSearchInput').val('').before(text);
    $('.searchResultUserFriend').empty().removeClass('open');
}

function bookMarkThisLocalShop(){
    if(!checkLogin())
        return;

    openLoading();
    $.ajax({
        type: 'POST',
        url: setBookMarkInLocalShop,
        data: {
            _token: csrfTokenGlobal,
            placeId: localShop.id,
            kindPlaceId: 13
        },
        complete: closeLoading,
        success: response =>{
            if (response == "ok-del"){
                $('.BookMarkIconAfter.localShopPageBookMark').removeClass('BookMarkIconAfter').addClass('BookMarkIconEmptyAfter');
                showSuccessNotifi('این صفحه از حالت ذخیره خارج شد', 'left', 'red');
            }
            else if(response == 'ok-add'){
                $('.BookMarkIconEmptyAfter.localShopPageBookMark').removeClass('BookMarkIconEmptyAfter').addClass('BookMarkIconAfter');
                showSuccessNotifi('این صفحه ذخیره شد', 'left', 'var(--koochita-blue)');
            }
        }
    })
}

function addPictureToLocalShop() {
    if (!checkLogin())
        return;
    //additionalData must be json format
    openUploadPhotoModal(localShop.name, photographerUploadFileLocalShop, localShop.id, 13);
}

function getLocalShopReviews(){

    $.ajax({
        type: 'POST',
        url: getLocalShopReviewsUrl,
        data: {
            _token: csrfTokenGlobal,
            placeId: localShop.id,
            kindPlaceId: 13
        },
        success: response =>{
            response = JSON.parse(response);
            var reviews = response[0];
            var reviewsText = [[], []];
            reviews.map((item, index) => {
                var small = createSmallReviewHtml(item);
                reviewsText[index%2].push(small);
            });
            $('#showReviewsMain1').html(reviewsText[0]);
            $('#showReviewsMain2').html(reviewsText[1]);
        },
    });
}


$('.localShopPageBookMark').on('click', bookMarkThisLocalShop);

$(window).ready(() => {
    initMap();
    autosize($('.autoResizeTextArea'));
    getLocalShopReviews();

// console.log(localShop);
//     var reviewsText = [[], []];
//     localShop.review.map((item, index) => reviewsText[index%2].push(createSmallReviewHtml(item)) );
//     $('#showReviewsMain1').html(reviewsText[0]);
//     $('#showReviewsMain2').html(reviewsText[1]);

    new Swiper('#mainSlider', {
        spaceBetween: 0,
        centeredSlides: true,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        navigation: {
            prevEl: '.swiper-button-next',
            nextEl: '.swiper-button-prev',
        },
    });
}).on('scroll', e => {
    var tabShow = '';
    var topInfoHeight = $('#topInfos').height();
    let topOfSticky = document.getElementById('stickyIndicator').getBoundingClientRect().top;
    if(topOfSticky < 0 && !$('#topInfos').hasClass('open'))
        $('#topInfos').addClass('open');
    else if(topOfSticky >= 0 && $('#topInfos').hasClass('open'))
        $('#topInfos').removeClass('open');

    var mapTopScroll = document.getElementById('mapDiv').getBoundingClientRect().top - topInfoHeight;
    var inputReviewScroll = document.getElementById('inputReviewSec').getBoundingClientRect().top - topInfoHeight;
    var questionSectionScroll = document.getElementById('questionSection').getBoundingClientRect().top - topInfoHeight;

    if(questionSectionScroll < 0)
        tabShow = 'questionIcon';
    else if(inputReviewScroll <  0)
        tabShow = 'EmptyCommentIcon';
    else if(mapTopScroll <  0)
        tabShow = 'earthIcon';
    else
        tabShow = 'doubleQuet';

    $('.tabRow.fastAccess').find('.tab.selected').removeClass('selected');
    $('.tabRow.fastAccess').find(`.tab.${tabShow}`).addClass('selected');

});
