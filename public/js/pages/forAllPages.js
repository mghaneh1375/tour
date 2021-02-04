
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


let alertWarningCallBack = false;
var errorAlertCallBack;

function showSuccessNotifi(_msg, _side = 'right', _color = '#0076ac'){
    $('#successNotifiAlert').text(_msg);
    $('#successNotifiAlert').addClass('topAlert');

    $('#successNotifiAlert').css('background', _color);
    $('#successNotifiAlert').addClass(_side == 'right' ? 'rightAlert' : 'leftAlert');

    setTimeout(function(){
        $('#successNotifiAlert').removeClass('topAlert');
        setTimeout(function () {
            $('#successNotifiAlert').removeClass('leftAlert');
            $('#successNotifiAlert').removeClass('rightAlert');
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



function getLoginPages(_callBack){
    openLoading(false, () => {
        $.ajax({
            type: 'GET',
            url: window.getLoginPageUrl,
            success: response => {
                closeLoading();
                $('body').append(response);
                window.getPages.push('login');
                if(typeof _callBack === 'function')
                    _callBack();
            },
            error: err => {
                closeLoading();
                console.error(err);
            }
        });
    });
}

function checkLogin(redirect = window.InUrl, _callBackAfterLogin = ''){
    if (!hasLogin) {
        if(window.getPages.indexOf('login') == -1)
            getLoginPages(() => showLoginPrompt(redirect, _callBackAfterLogin));
        else
            showLoginPrompt(redirect, _callBackAfterLogin);
        return false;
    }
    else
        return true;
}

function setSeenAlert(_id = 0, _element = ''){
    let kind = _id == 0 ? 'seen' : 'click';

    if(kind == 'seen' && seenToZero)
        return;

    $.ajax({
        type: 'post',
        url: window.alertSeenUrl,
        data: {
            _token: csrfTokenGlobal,
            id: _id,
            kind: kind
        },
        success: function(response){
            if(response.status == 'ok'){
                if(kind == 'seen') {
                    $('.newAlertNumber').addClass('hidden');
                    seenToZero = true;
                }
                else
                    $(_element).css('background', 'white');
            }
        }
    })
}

function deleteBookMarkState(_id, _element){
    $.ajax({
        type: 'post',
        url: window.deleteBookMarkUrl,
        data: {
            _token: csrfTokenGlobal,
            id: _id
        },
        success: response =>{
            if(response.status == 'ok')
                $(_element).parent().remove();
            else
                showSuccessNotifi('مشکلی در حذف نشان کرده پیش امده', 'left', 'red');
        },
        error: err => showSuccessNotifi('مشکلی در حذف نشان کرده پیش امده', 'left', 'red')
    })
}

function getAlertItems() {
    $.ajax({
        type: 'get',
        url: window.getAlertUrl,
        success: function (response) {
            var newElement = "";
            var newMsg = 0;

            if (response.result.length > 0) {
                response.result.map(item => {
                    if (item.click != 0)
                        item.color = 'white';

                    if(item.seen == 0)
                        newMsg++;

                    newElement += '<div class="alertMsgHeaderContent" style="background: ' + item.color + '" onclick="setSeenAlert(' + item.id + ', this)">\n' +
                        '<div class="alertMsgHeaderContentImgDiv">\n' +
                        '<img src="' + item.pic + '"  alt="کوچیتا، سامانه جامع گردشگری ایران" class="resizeImgClass" onload="fitThisImg(this)" style="width: 100%">\n' +
                        '</div>\n' +
                        '<div class="alertMsgHeaderContentTextDiv">\n' +
                        '<div class="alertMsgHeaderContentText">' + item.msg + '</div>\n' +
                        '<div class="alertMsgHeaderContentTime">' + item.time + '</div>\n' +
                        '</div>\n' +
                        '</div>';
                });
                $('.alertMsgResultDiv').html(newElement);

                if(newMsg != 0)
                    $('.newAlertNumber').removeClass('hidden').html(newMsg);
            }
            else{
                newElement += '<div><div class="modules-engagement-notification-dropdown"><div class="notifdd_empty">هیچ پیامی موجود نیست </div></div></div>';
                $('#headerMsgPlaceHolder').html(newElement);
            }

        }
    });
}

function goToLanguage(_lang){
    if(_lang != 0)
        location.href = window.languageUrl + _lang;
}

function convertNumberToEn(str) {
    let persianNumbers = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g];
    let arabicNumbers = [/٠/g, /١/g, /٢/g, /٣/g, /٤/g, /٥/g, /٦/g, /٧/g, /٨/g, /٩/g];
    if (typeof str === 'string') {
        for (var i = 0; i < 10; i++)
            str = str.replace(persianNumbers[i], i).replace(arabicNumbers[i], i);
    }
    return str;
}

function cleanImgMetaData(_input, _callBack){
    openLoading(false, function(){
        options = { canvas: true };
        loadImage.parseMetaData(_input.files[0], function(data) {
            if (data.exif)
                options.orientation = data.exif.get('Orientation');

            loadImage(
                _input.files[0],
                function(canvas) {
                    closeLoading();
                    var imgDataURL = canvas.toDataURL();
                    if(typeof _callBack === 'function') {
                        blob = dataURItoBlob(imgDataURL);
                        _callBack(imgDataURL, blob);
                    }
                },
                options
            );
        });
    });
}

function dataURItoBlob(dataURI) {
    var byteString = atob(dataURI.split(',')[1]);
    var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
    var ab = new ArrayBuffer(byteString.length);
    var ia = new Uint8Array(ab);
    for (var i = 0; i < byteString.length; i++)
        ia[i] = byteString.charCodeAt(i);

    var blob = new Blob([ab], {type: mimeString});
    return blob;
}

function openMyModal(_id){
    $('#'+_id).addClass('showModal');
}

function closeMyModal(_id){
    $('#'+_id).removeClass('showModal');
}

function closeMyModalClass(_class){
    $('.'+_class).removeClass('showModal');
}

function showLastPages(){
    let lastPages = localStorage.getItem('lastPages');
    lastPages = JSON.parse(lastPages);

    $('#recentlyRowMainSearch').html('');

    if(lastPages != null){
        var showRecentlyText = '';
        for(i = 0; i < lastPages.length; i++){
            var text = recentlyMainSearchSample;
            var fk = Object.keys(lastPages[i]);

            var name = lastPages[i]['name'];
            t = '##name##';
            re = new RegExp(t, "g");

            if(lastPages[i]['kind'] == 'city')
                name +=' در ' + lastPages[i]['state'];
            else if(lastPages[i]['kind'] == 'place')
                name +=' در ' + lastPages[i]['city'];
            else if(lastPages[i]['kind'] == 'article')
                name = 'مقاله ' + lastPages[i]['name'];
            text = text.replace(re, name);

            for (var x of fk) {
                var t = '##' + x + '##';
                var re = new RegExp(t, "g");

                if(x == 'city' && lastPages[i]['state'] != '')
                    text = text.replace(re, lastPages[i][x] + ' در ');
                else
                    text = text.replace(re, lastPages[i][x]);
            }

            showRecentlyText += text;
        }
        $('.recentlyRowMainSearch').html(showRecentlyText);
    }
}

function getBookMarkForHeaderAndFooter(){
    if(checkLogin()){
        getMyBookMarkPromiseFunc().then(response => {
            var text = '';
            response.map(item =>{
                var add = false;
                var name = '';
                var pic = '';
                var state = '';
                var kind = '';
                var kindIcon = '';
                if(item.kind == 'place'){
                    name = item.name;
                    pic = item.pic;
                    state = item.city + ' در ' + item.state;
                    kindIcon = window.mainIconsPlaces[item.kindPlaceName].icon;
                    kind = window.mainIconsPlaces[item.kindPlaceName].nameFa;
                    add = true;
                }
                else if(item.kind == 'safarnameh'){
                    name = item.title;
                    pic = item.pic;
                    kind = 'سفرنامه';
                    kindIcon = window.mainIconsPlaces['safarnameh'].icon;
                    add = true;
                }
                if(add) {
                    text += `<div class="bookMarkSSec">
                                    <div class="BookMarkIcon BookMarkIconEmptyAfter" onclick="deleteBookMarkState(${item.bmId}, this)"></div>
                                    <div class="imgSec" onclick="goToBookMarkSelected('${item.url}')">
                                        <img src="${pic}" class="resizeImgClass" alt="${name}" onload="fitThisImg(this)">
                                    </div>
                                    <div class="infoSec" onclick="goToBookMarkSelected('${item.url}')">
                                        <div class="type ${kindIcon}">${kind}</div>
                                        <div class="name">${name}</div>
                                        <div class="state">${state}</div>
                                    </div>
                                </div>`;
                }
            });

            if(text != '')
                $('.headerFooterBookMarkTab').html(text);
            else{
                $('.headerFooterBookMarkTab').find('.bookMarkSSec').remove();
                $('.headerFooterBookMarkTab').find('.notInfoFooterModalImg').removeClass('hidden');
            }
        })
    }
}

function goToBookMarkSelected(_url){
    window.location.href = _url;
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

function sendSeenPageLog(){
    $.ajax({
        type: 'post',
        url: window.storeSeenLogUrl,
        data: {
            _token: csrfTokenGlobal,
            relatedId: window.seenRelatedId,
            seenPageLogId: window.seenPageLogId,
            scrollData: window.userScrollPageLog,
            isMobile: window.isMobile,
            windowsSize: {width: $(window).width(), height: $(window).height()},
            url: document.location.pathname
        },
        success: response => {
            if(response.status == 'ok') {
                sessionStorage.setItem("lastPageLogId", response.seenPageLogId);
                window.seenPageLogId = response.seenPageLogId;
            }
            // setTimeout(sendSeenPageLog, 5000);
        },
        // error: err => setTimeout(sendSeenPageLog, 5000)
    })
}

var searchInUserAjax;
async function searchForUserCommon(_value){
    var findUserPromise = new Promise((myResolve, myReject) => {
        if(searchInUserAjax != null)
            searchInUserAjax.abort();

        searchInUserAjax = $.ajax({
            type: 'GET',
            url: window.searchInUserUrl+'?username='+_value.trim(),
            success: response => {
                if(response.status == 'ok')
                    myResolve(response.result);
                else
                    myReject(response.status);
            },
        })
    });

    return await findUserPromise;
}


var koochitaUserSearchResults = [];
function openKoochitaUserSearchModal(_title = '', _selectUserCallBack = '', _htmlButtons = ''){
    _title = _title == '' ? 'دوستان خود را پیدا کنید' : _title;
    koochitaUserModalButtons = _htmlButtons;
    koochitaUserModalSelectUser = _selectUserCallBack;

    $('#koochitaUserSearchModalTitle').text(_title);

    openMyModal('koochitaUserSearchModal');

    $('#koochitaUserSearchModalInput').val('');
    setTimeout(() => $('#koochitaUserSearchModalInput').focus(), 400);
}

function openKoochitaUserSearchInput(_value){
    var searchBody = $('#koochitaUserSearchModalBody');
    searchBody.addClass('openSearch');
    searchBody.children().addClass('hidden');
    searchBody.find('searchResultUserKoochitaModal').removeClass('hidden');

    $('#userKoochiatModalSearchButton').children().addClass('hidden');
    $('#userKoochiatModalSearchButton').find('.iconClose').removeClass('hidden');
}

function closeKoochitaUserSearchInput(_value){
    if(_value == 0)
        $('#koochitaUserSearchModalInput').val('');

    if(_value == 0 || _value.length == 0) {
        $('#koochitaUserSearchModalBody').removeClass('openSearch');
        $('#userKoochiatModalSearchButton').children().addClass('hidden');
        $('#userKoochiatModalSearchButton').find('.searchIcon').removeClass('hidden');
        $('#searchResultKoochitaUserInput').addClass('hidden');
    }
}

function searchForKoochitaUser(_value){
    $("#searchResultKoochitaUserInput").empty();
    if(_value.trim().length > 1) {
        var userSearchPlaceHolder = `<div class="peopleRow placeHolder">
                                                   <div class="pic placeHolderAnime"></div>
                                                   <div class="name placeHolderAnime resultLineAnim"></div>
                                                   <div class="buttonP placeHolderAnime resultLineAnim"></div>
                                                </div>`;

        $("#searchResultKoochitaUserInput").html(userSearchPlaceHolder+userSearchPlaceHolder).removeClass('hidden');

        searchForUserCommon(_value)
            .then(response => createUserKoochitaSearchResult(response.userName))
            .catch(err => console.error(err));
    }
}

function createUserKoochitaSearchResult(_result){
    koochitaUserSearchResults = _result;
    let text = '';
    if(koochitaUserSearchResults.length == 0) {
        text =  `<div class="emptyPeople">
                       <img alt="noData" src="{{URL::asset('images/mainPics/noData.png')}}" >
                       <span class="text">هیچ کاربری ثبت نشده است</span>
                     </div>`;
    }
    else {
        koochitaUserSearchResults.map((item, index) => {
            text += `<div class="peopleRow hoverChangeBack" onclick="chooseThisKoochitaUser(${index})" style="cursor: pointer;">
                            <div class="pic">
                                <img alt="کوچیتا، سامانه جامع گردشگری ایران" src="${item.pic}" class="resizeImgClass" style="width: 100%" onload="fitThisImg(this)">
                            </div>
                            <div class="name">${item.username}</div>
                            <div class="buttonP">${koochitaUserModalButtons}</div>
                         </div>`;
        });
    }
    $(`#searchResultKoochitaUserInput`).html(text);
}

function chooseThisKoochitaUser(_index){
    var user = koochitaUserSearchResults[_index];
    closeKoochitaUserSearchInput(0);
    closeMyModal('koochitaUserSearchModal');
    if(typeof koochitaUserModalSelectUser === 'function')
        koochitaUserModalSelectUser(user.id, user.username, user.pic);
}


function createPhotoModal(_title, _pics, _choosenIndex = 0){
    // _pics = [
    //     {
    //         'id' : , must be kind_idNum like => review_124 or photographer_1134
    //         'sidePic' : ,
    //         'mainPic' : ,
    //         'userPic' : ,
    //         'userName' : ,
    //         'showInfo' : show like or not (true , false) ,
    //         'where' : ,   (optional)
    //         'whereUrl' : ,   (optional)
    //         'like' : ,   (optional)
    //         'dislike' : ,    (optional)
    //         'alt' : ,    (optional)
    //         'uploadTime' : , (optional)
    //         'video': if video, (optional)
    //         'description' : ,    (optional)
    //         'userLike' : if user like this img?,     (optional)
    //     }
    // ]

    sidePics = _pics;
    $('#photoAlbumTitle').text(_title);
    $('#sidePhotoModal').empty();

    for(var i = 0; i < sidePics.length; i++){
        var re;
        var text = srcSidePic;
        var fk = Object.keys(sidePics[i]);
        for (var x of fk) {
            re = new RegExp(`##${x}##`, "g");
            text = text.replace(re, sidePics[i][x]);
        }

        re = new RegExp('##picIndex##', "g");
        text = text.replace(re, 'chooseAlbumMainPhoto(' + i + ')');

        re = new RegExp('##index##', "g");
        text = text.replace(re, i);

        $('#sidePhotoModal').append(text);
    }
    $('#photoAlbumModal').modal({backdrop: 'static', keyboard: false});
    chooseAlbumMainPhoto(_choosenIndex);
}

function chooseAlbumMainPhoto(_index){
    choosenIndex = _index;
    $('.chooseSidePhotoAlbum').removeClass('chooseSidePhotoAlbum');
    $('#photoAlbumDescription').text('');
    $('#photoAlbumNamePic').text('');

    if(sidePics[_index]['picName'] != undefined)
        $('#photoAlbumNamePic').text(' - ' + sidePics[_index]['picName']);

    $('.photoAlbumUploadTime').text(sidePics[_index]['uploadTime']);
    $('.photoAlbumUserName').text(sidePics[_index]['userName']);
    $('.userProfileLinks').attr('href', "{{url('profile/index')}}/" + sidePics[_index]['userName']);
    $('.photoAlbumWhere').text(sidePics[_index]['where'] ? sidePics[_index]['where'] : '').attr('href', sidePics[_index]['whereUrl']);
    $('.photoAlbumUserPic').attr('src', sidePics[_index]['userPic']);

    $('#sideAlbumPic' + _index).addClass('chooseSidePhotoAlbum');

    if(sidePics[_index]['video'] != undefined) {
        $('#mainPhotoAlbum').css('display', 'none');
        $('#mainVideoPhotoAlbum').css('display', 'block').attr('src', sidePics[_index]['video']);
    }
    else{
        $('#mainPhotoAlbum').css('display', 'block').attr('src', sidePics[_index]['mainPic']).attr('alt', sidePics[_index]['alt']);
        $('#mainVideoPhotoAlbum').css('display', 'none').attr('src', '');
    }

    if(sidePics[_index]['showInfo']) {
        $('#photoAlbumLikeSection').css('display', 'block');
        $('.photoAlbumDisLikeCount').text(sidePics[_index]['dislike']);
        $('.photoAlbumLikeCount').text(sidePics[_index]['like']);

        $('.photoAlbumTopLike').removeClass('fullLikePhotoAlbum').attr('picId', sidePics[_index]['id']);
        $('.photoAlbumTopDisLike').removeClass('fullDisLikePhotoAlbum').attr('picId', sidePics[_index]['id']);

        if(sidePics[_index]['userLike'] == 1)
            likePhotoAlbum(1);
        else if(sidePics[_index]['userLike'] == -1)
            likePhotoAlbum(-1);
    }
    else
        $('#photoAlbumLikeSection').css('display', 'none');

    $('#photoAlbumDescription').text(sidePics[_index]['description']);
    if(userInPhoto !== false && userInPhoto == sidePics[_index].userName)
        $('#deletePicIconsPhotoAlbum').css('display', 'flex').attr('dataValue', sidePics[_index].id);
    else
        $('#deletePicIconsPhotoAlbum').css('display', 'none').attr('dataValue', 0);

}

function likePhotoAlbum(_like){
    $('.photoAlbumTopLike').removeClass('fullLikePhotoAlbum');
    $('.photoAlbumTopDisLike').removeClass('fullDisLikePhotoAlbum');
    sidePics[choosenIndex]['userLike'] = _like;

    if(_like == 1)
        $('.photoAlbumTopLike').addClass('fullLikePhotoAlbum');
    else if(_like == -1)
        $('.photoAlbumTopDisLike').addClass('fullDisLikePhotoAlbum');
}

function setLikeNumberInPhotoAlbum(_count, _kind){
    if(_kind == 'like') {
        $('.photoAlbumLikeCount').text(_count);
        sidePics[choosenIndex]['like'] = _count;
    }
    else if(_kind == 'dislike'){
        $('.photoAlbumDisLikeCount').text(_count);
        sidePics[choosenIndex]['dislike'] = _count;
    }
}

function closePhotoAlbumModal(){
    $('#mainVideoPhotoAlbum').attr('src', '');
    $('#photoAlbumModal').modal('hide');
}

var deletedPhotoInAlbum = false;
function openDeletePhotoModal(){
    deletedPhotoInAlbum = $('#deletePicIconsPhotoAlbum').attr('dataValue');
    var text = 'آیا از حذف عکس خود اطمینان دارید؟ در صورت حذف محتوای مورد نظر قابل بازیابی نمی باشد.';
    openWarning(text, doPhotoDeleteInAlbum); // in general.alert.blade.php
}

function doPhotoDeleteInAlbum(){
    openLoading();
    $.ajax({
        type: 'POST',
        url: deletePicInAlbumUrl,
        data: {
            _token: csrfTokenGlobal,
            id: deletedPhotoInAlbum
        },
        success: function(response){
            if(response.status == 'ok')
                location.reload();
            else {
                closeLoading();
                showSuccessNotifi('در حذف عکس مشکلی پیش آمده لطفا دوباره تلاش نمایید.', 'left', 'red'); // in general.alert.blade.php
            }
        },
        error: () => {
            closeLoading();
            showSuccessNotifi('در حذف عکس مشکلی پیش آمده لطفا دوباره تلاش نمایید.', 'left', 'red'); // in general.alert.blade.php
        }
    })
}

function likeAlbumPic(_element, _like){
    if(!checkLogin())
        return;

    var id = $('.photoAlbumTopLike').attr('picId');

    $.ajax({
        type: 'POST',
        url: likePhotographerUrl,
        data: {
            _token: csrfTokenGlobal,
            id : id,
            like : _like
        },
        success: function(response){
            response = JSON.parse(response);
            if(response.status == 'ok'){
                setLikeNumberInPhotoAlbum(response.like, 'like');
                setLikeNumberInPhotoAlbum(response.disLike, 'dislike');
                likePhotoAlbum(_like);
            }
        }
    });
}

// $(window).on('scroll', () => {
//     var time = seenLogStartTime;
//     seenLogStartTime = new Date().getTime();
//     if(new Date().getTime() - time > 1000){
//         window.userScrollPageLog.push({
//             scroll: (lastSeenLogScroll/($(document).height() - $(window).height())) * 100,
//             time: new Date().getTime() - time
//         })
//     }
//     else if(window.userScrollPageLog[window.userScrollPageLog.length-1] != 'scrolling')
//         window.userScrollPageLog.push('scrolling');
//
//     if(userWindowInScrolling != null)
//         clearTimeout(userWindowInScrolling);
//
//     setTimeout(() => {
//         seenLogStartTime = new Date().getTime();
//         lastSeenLogScroll = window.pageYOffset
//     }, 1000);
// });


$(window).on('click', e => {
    if($('.modalBlackBack.closeWithClick.showModal:not(.notCloseOnClick)').length > 0){
        if($(e.target).is('.modalBlackBack, .showModal, .closeWithClick')) {
            closeMyModal($(e.target).attr('id'));
            opnedMobileFooterId = null; // for placeFooter.js
        }
    }
    if($('.modalBlackBack.fullCenter.showModal:not(.notCloseOnClick)').length > 0){
        if($(e.target).is('.modalBlackBack, .showModal, .fullCenter'))
            closeMyModal($(e.target).attr('id'));
    }

    $('.closeWithOneClick').addClass('hidden');
    $('.moreOptionFullReview').removeClass('bg-color-darkgrey');

    if(openHeadersTab)
        hideAllTopNavs();
});

$(window).on('resize', e => {
    resizeFitImg('resizeImgClass');
});
window.mobileAndTabletCheck = function() {
    let check = false;
    (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
    return check;
};



