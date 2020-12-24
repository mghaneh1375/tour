var opnedMobileFooterId = null;

function showSafarnamehFooterSearch(_element, _kind){
    $(_element).parent().find('.selected').removeClass('selected');
    $(_element).addClass('selected');
    if(_kind == 'place'){
        $('#safarnamehPlaceSearchFooter').show();
        $('#safarnamehContentSearchFooter').hide();
    }
    else{
        $('#safarnamehPlaceSearchFooter').hide();
        $('#safarnamehContentSearchFooter').show();
    }
}

function showSafarnamehSubCategory(_id){
    $('.mainSafarnamehCategory').hide();
    $('.subSafarnamehCategory').show();
    $(`#subSafarnamehCategory_${_id}`).show();
    setTimeout(() => $(`#subSafarnamehCategory_${_id}`).addClass('show'), 10);
}

function backToSafarnamehCategoryFooter(_element){
    $(_element).parent().removeClass('show');
    setTimeout(() => {
        $(_element).parent().hide();
        $('.mainSafarnamehCategory').show();
        $('.subSafarnamehCategory').hide();
    }, 300);
}

function lp_selectArticleFilter(id , element) {
    $('.lp_ar_eachFilters').removeClass('lp_ar_selectedMenu');
    $(element).addClass('lp_ar_selectedMenu');
    $('.lp_ar_contentOfFilters').addClass('hidden');
    $('#' + id).removeClass('hidden');
}

function showMorefooter() {
    $('.footMoreLessBtnText').toggleClass('hidden');
    $('#aboutShazde').toggleClass('aboutShazdeMoreLess');
}

function openLoginHelperSection(){
    $('.loginHelperSection').removeClass('hidden');
    $('html, body').css('overflow', 'hidden');
}

function closeLoginHelperSection() {
    $('.loginHelperSection').addClass('hidden');
    $('html, body').css('overflow-y', 'auto');
}

function openMobileFooterPopUps(_id){
    showLastPages();
    closeMyModalClass('footerModals');
    if(opnedMobileFooterId != _id) {
        opnedMobileFooterId = _id;
        openMyModal(_id);
    }
    else
        opnedMobileFooterId = null;

    resizeFitImg('resizeImgClass');
}

function mobileFooterProfileButton(_kind){
    let windowUrl = window.location;
    let url = windowUrl.origin + windowUrl.pathname;

    if(url == profileUrl || url == profileUrl+'/'+window.user.username) {
        if (_kind == 'review')
            mobileChangeProfileTab($('#reviewProfileMoblieTab'), 'review'); // in mainProfile.blade.php
        else if (_kind == 'photo')
            mobileChangeProfileTab($('#photoProfileMoblieTab'), 'photo'); // in mainProfile.blade.php
        else if (_kind == 'safarnameh')
            mobileChangeProfileTab($('#safarnamehProfileMoblieTab'), 'safarnameh'); // in mainProfile.blade.php
        else if (_kind == 'medal')
            mobileChangeProfileTab($('#medalProfileMoblieTab'), 'medal'); // in mainProfile.blade.php
        else if (_kind == 'question')
            chooseFromMobileMenuTab('question', $('#myMenuMoreTabQuestion')); // in mainProfile.blade.php
        else if (_kind == 'bookMark')
            chooseFromMobileMenuTab('bookMark', $('#myMenuMoreTabBookMark')); // in mainProfile.blade.php
        else if (_kind == 'festival')
            chooseFromMobileMenuTab('festival', $('#myMenuMoreTabFestivalMark')); // in mainProfile.blade.php
        closeMyModalClass('footerModals');
    }
    else if(_kind == 'setting')
        window.location.href = userSettingPageUrl;
    else if(_kind == 'follower')
        openFollowerModal('resultFollowers', window.user.id); // in general.followerPopUp.blade.php
    else
        window.location.href = profileUrl+'#'+_kind;
}

function lp_selectMenu(id , element) {
    $('.lp_eachMenu').removeClass('lp_selectedMenu');
    $(element).addClass('lp_selectedMenu');
    $('.lp_others_content').addClass('hidden');
    $('#' + id).removeClass('hidden');

    if(id == 'lp_others_myTravel'){
        $('.newMyTripFooterButton').removeClass('hidden');
        $('.seeAllBookMarkFooter').addClass('hidden');
        getMyTripsPromiseFunc().then(response => createTripCardFooter(response));
    }
    else if(id == 'lp_others_mark'){
        getBookMarkForHeaderAndFooter();
        $('.newMyTripFooterButton').addClass('hidden');
        $('.seeAllBookMarkFooter').removeClass('hidden');
    }
    else{
        $('.newMyTripFooterButton').addClass('hidden');
        $('.seeAllBookMarkFooter').addClass('hidden');
    }
}

function closeMobileFooterPopUps(_id){
    $(`#${_id}`).modal('hide');
}

function createTripFromMobileFooter(){
    createNewTrip(() => getMyTripsPromiseFunc().then(response => createTripCardFooter(response)));
}

function goToAddPlacePageInFooter(){
    if(!checkLogin())
        return;

    window.location.href = addPlaceByUserUrl;
}

function createTripCardFooter(_response){
    var card = '';
    if(_response.length == 0){
        $('#emptyTripMobileFooter').removeClass('hidden');
        $('#myTripsFooter').addClass('hidden');
    }
    else {
        _response.map(item => {
            var placePicHtml = '';
            var placePicCount = item.placePic.length;
            item.placePic.map(item => {
                placePicHtml += `<div class="pic">
                                        <img src="${item}" class="resizeImgClass" onload="fitThisImg(this)" >
                                    </div>`;
            });

            if (placePicHtml == '') {
                placePicHtml = `<div class="cardPics cardPics-1" style="height: 200px; background: gainsboro;">
                                    <img src="${window.notTrip}" class="resizeImgClass" onload="fitThisImg(this)">
                                </div>`;
                placePicCount = 1;
            }
            card += `<a href="${item.url}" class="myTripCard">
                        <div class="name">${item.name}</div>
                        <div class="date">
                            <div class="from">${item.from_}</div>
                            <div>تا</div>
                            <div class="from">${item.to_}</div>
                        </div>
                        <div class="picsSec pic_${placePicCount}">${placePicHtml}</div>
                        <div class="placeCount">
                            تعداد اماکن: ${item.placeCount}
                        </div>
                    </a>`;
        });
        $('#myTripsFooter').html(card);
    }
}




