var isOpenRateButton = false;

var sliderPicForAlbum = [];
var sitePicsForAlbum = [];
var userPhotosForAlbum = [];
var userVideoForAlbum = [];
var allPlacePics = [];

function getVideoFromTv(){
    $.ajax({
        type: 'GET',
        url: `${koochitaTvUrl}?id=${placeId}&kindPlaceId=${kindPlaceId}`,
        success: response => {
            if(response.status == 'ok'){
                var result = response.result;

                document.querySelector('.userInfoKoochitaTv').style.display = 'flex';

                [...document.querySelectorAll('.koochitaTvLinkUrl')].map(item => item.setAttribute('href', result.url));
                [...document.querySelectorAll('.koochitaTvTitle')].map(item => item.innerText = result.title);
                [...document.querySelectorAll('.koochitaTvUserPic')].map(item => item.src = result.userPic);
                [...document.querySelectorAll('.koochitaTvUserName')].map(item => item.innerText = result.username);
                [...document.querySelectorAll('.koochitaTvUserTime')].map(item => item.innerText = result.time);
                [...document.querySelectorAll('.koochitaTvPic')].map(item => item.src = result.pic);

                var koochitaTvSectionElement = $('.koochitaTvSection');
                koochitaTvSectionElement.find('.tvOverPic').removeClass('hidden');
                koochitaTvSectionElement.find('.tvUserContentDiv').removeClass('hidden');
                koochitaTvSectionElement.find('.tvVideoPic').removeClass('fullHeight');

                koochitaTvSectionElement.find('.koochitaTvSeen').text(result.seen);
                koochitaTvSectionElement.find('.koochitaTvDisLikeCount').text(result.disLike);
                koochitaTvSectionElement.find('.koochitaTvLikeCount').text(result.like);
            }
        },
    })
}

function openRateBoxForPlace(){
    if(!checkLogin())
        return;

    openMyModal('userRateToPlaceModal');
}

function ratingToPlace(_rate){
    for(var i = 1; i <= 5; i++){
        if(i <= _rate)
            $(`.ratingStar${i}`).addClass('fullStarRating').removeClass('emptyStarRating').attr('data-selected', 1);
        else
            $(`.ratingStar${i}`).addClass('emptyStarRating').removeClass('fullStarRating').attr('data-selected', 0);
    }
}

function submitRating(){
    var lastSelected = 0;
    for(var i = 5; i > 0; i--){
        if($(`.ratingStar${i}`).attr('data-selected') == 1){
            lastSelected = $(`.ratingStar${i}`).attr('data-star');
            break;
        }
    }

    if(lastSelected == 0)
        alert('برای ثبت امتیاز باید روی ستاره مورد نظر کلیک کنید');
    else{
        openLoading();
        $.ajax({
            type: 'POST',
            url: setRateToPlaceUrl,
            data:{
                _token: csrfTokenGlobal,
                placeId: placeId,
                kindPlaceId: kindPlaceId,
                rate: lastSelected
            },
            complete: closeLoading,
            success: response =>{
                if(response.status == 'ok'){
                    updatePlaceRating(response.rates);
                    closeMyModal('userRateToPlaceModal');
                    showSuccessNotifi('امتیاز شما با موفقیت ثبت شد.', 'left', 'var(--koochita-blue)');
                }
                else if(response.status == 'error3')
                    alert('برای ثبت امتیاز باید روی ستاره مورد نظر کلیک کنید');
                else
                    showSuccessNotifi('خطا در ثبت امتیاز', 'left', 'red');
            },
            error: err => showSuccessNotifi('خطا در ثبت امتیاز', 'left', 'red')
        })
    }
}

function updatePlaceRating(_rates){
    var totalRate = 0;
    var avg = Math.round(_rates.avg);
    var rates = _rates.rate;
    var elements = $('.placeRateStars');

    Object.keys(rates).forEach(key => totalRate += rates[key]);
    for(var i = 0; i < elements.length; i++){
        var lastAvg = $(elements[i]).attr('content');
        $(elements[i]).removeClass(`bubble_${lastAvg}0`).addClass(`bubble_${avg}0`).attr('content', avg);
    }

    Object.keys(rates).forEach(key => {
        var percent = (rates[key]*100/totalRate)+'%';
        $(`.ratePercent${key}`).text(percent);
        $(`.rateLine${key}`).css('width', percent);
    });
}

function changeTabBarColor(_elemnt, _section){
    if($(window).width() < 767){
        $('html, body').animate({
            scrollTop: $(`#${_section}`).offset().top-100
        }, 300);
    }

    $('.tabLinkMainWrap').css('color', 'black');
    setTimeout(() => {
        $(_elemnt).css('color', 'var(--koochita-light-green)');
    }, 100)
}

function isPhotographer() {
    if (!checkLogin())
        return;

    //additionalData must be json format
    var _title = `${placeNamePlaceDetail} در ${cityNamePlaceDetails}`;
    additionalData = JSON.stringify(additionalData);
    openUploadPhotoModal(_title, addPhotoToPlaceUrl, placeId, kindPlaceId);
}

function openCity(cityName, elmnt, color = 'white', fontColor = 'var(--koochita-light-green)') {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabContent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tabLink");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].style.backgroundColor = "";
        tablinks[i].style.color = "";
        tablinks[i].style.borderColor = "";
    }

    document.getElementById(cityName).style.display = "block";
    elmnt.style.backgroundColor = color;
    elmnt.style.color = fontColor;
    elmnt.style.borderColor = fontColor;
}

function showAnswersActionBox(element) {
    $(element).next().toggle();
    $(element).toggleClass("bg-color-darkgrey")
}

function filterChoices(element) {
    $(element).toggleClass('bg-color-yellowImp')
}

function showPhotoAlbum(_kind) {
    if($(window).width() <= 767)
        createPhotoModal('آلبوم عکس', allPlacePics);// in general.photoAlbumModal.blade.php
    else {
        if (_kind == 'sliderPic' && sliderPicForAlbum.length > 0)
            createPhotoModal('آلبوم عکس', sliderPicForAlbum);// in general.photoAlbumModal.blade.php
        // if (_kind == 'photographer' && photographerPicsForAlbum.length > 0)
        //     createPhotoModal('عکس های عکاسان', photographerPicsForAlbum);// in general.photoAlbumModal.blade.php
        else if (_kind == 'sitePics' && sitePicsForAlbum.length > 0)
            createPhotoModal('عکس های سایت', sitePicsForAlbum);// in general.photoAlbumModal.blade.php
        else if (_kind == 'userPics' && userPhotosForAlbum.length > 0)
            createPhotoModal('عکس های کاربران', userPhotosForAlbum);// in general.photoAlbumModal.blade.php
        else if (_kind == 'userVideo' && userVideoForAlbum.length > 0)
            createPhotoModal('ویدیو های کاربران', userVideoForAlbum);// in general.photoAlbumModal.blade.php
    }
}

function addPlaceToBookMark() {
    if (!checkLogin())
        return;

    storePlaceToBookMark(placeId, kindPlaceId, (_status, _response) => {
        if(_status === 'ok'){
            if (_response == "ok-del"){
                changeBookmarkIcon();
                showSuccessNotifi('این صفحه از حالت ذخیره خارج شد', 'left', 'red');
            }
            else if(_response == 'ok-add'){
                changeBookmarkIcon();
                showSuccessNotifi('این صفحه ذخیره شد', 'left', 'var(--koochita-blue)');
            }
        }
    });
}

function addThisPlaceToTrip() {
    selectedPlaceId = placeId;
    selectedKindPlaceId = kindPlaceId;

    if(!checkLogin())
        return;

    saveToTripPopUp(placeId, kindPlaceId);
}


function getPlacePics(){
    $.ajax({
        type: 'GET',
        url: `${getPlacePicsUrl}?kindPlaceId=${kindPlaceId}&placeId=${placeId}`,
        success: response => {
            if(response.status == 'ok')
                fillPlacePicSections(response.result);
        }
    })
}

function fillPlacePicSections(_result){
    var sideSecPicRowElement = $('.sideSecPicRow');
    var sitePicElement = $('#sideSliderSite');
    var userPicElement = $('#sideSliderUsers');
    var videoPicElement = $('#sideSliderVideos');

    $('#mainSliderPlaceHolderSectionPlaceDetail').remove();
    $('#mainSliderSectionPlaceDetail').removeClass('hidden');
    sideSecPicRowElement.find('.placeHolderAnime').remove();
    sideSecPicRowElement.find('.mainContent').removeClass('hidden');

    if(_result['sitePics'].length > 0){
        sitePicElement.find('img').attr('src', _result['sitePics'][0].sidePic);
        sitePicElement.find('.countOfPic').text(_result['sitePics'].length);
    }
    if(_result['userPhotos'].length > 0){
        userPicElement.find('img').attr('src', _result['userPhotos'][0].sidePic);
        userPicElement.find('.countOfPic').text(_result['userPhotos'].length);
    }
    if(_result['userVideo'].length > 0){
        videoPicElement.find('img').attr('src', _result['userVideo'][0].sidePic);
        videoPicElement.find('.countOfPic').text(_result['userVideo'].length);
    }


    _result['sitePics'].map(item => {
        sitePicsForAlbum.push(item);
        allPlacePics.push(item);
    });
    _result['userPhotos'].map(item => {
        userPhotosForAlbum.push(item);
        allPlacePics.push(item);
    });
    _result['userVideo'].map(item => {
        userVideoForAlbum.push(item);
        allPlacePics.push(item);
    });
    _result['sliderPics'].map(item => sliderPicForAlbum.push(item));


    $('#allPlacePicturesCount').text(allPlacePics.length);

    if (_result['sliderPics'].length > 0) {
        var html = '';
        _result['sliderPics'].map(item => {
            html += `<div class="swiper-slide" style="overflow: hidden">
                        <img class="eachPicOfSlider resizeImgClass" src="${item.mainPic}" alt="${item.alt}" onload="fitThisImg(this)">
                        <div class="see_all_count_wrap hideOnPhone">
                            <span class="see_all_count">
                                <div class="photographerIdPic circleBase type2" style="background-color: var(--koochita-light-green);">
                                    <img src="${item.userPic}" style="width: 100%; height: 100%; border-radius: 50%;">
                                </div>
                                <div class="display-inline-block mg-rt-10 mg-tp-2">
                                    <span class="display-block font-size-12">عکس از</span>
                                    <span class="display-block">${item.userName}</span>
                                </div>
                            </span>
                        </div>
                    </div>`;
        });
        $('#mainSliderWrapper').html(html);

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
    }
    else {
        $('.mainSliderNavBut').addClass('hidden');
        $('.see_all_count_wrap').addClass('hidden');
        text = `<div class="swiper-slide" style="overflow: hidden">
                    <img class="eachPicOfSlider resizeImgClass" src="${noPicUrl}" style="width: 100%;">
                </div>`;
        $('#mainSliderWrapper').append(text);
    }

}


$(document).ready(() => {
    getPlacePics();

    autosize($(".inputBoxInputComment"));
    autosize($(".inputBoxInputAnswer"));

    if (window.matchMedia('(max-width: 373px)').matches)
        $('.eachCommentMainBox').removeClass('mg-rt-45');

    ratingToPlace(yourRateForThisPlace);

    getVideoFromTv();
});

$(window).on('scroll', function(e){
    let topOfSticky = document.getElementById('BODYCON').getBoundingClientRect().top;
    if(topOfSticky < 20 && !$('#sticky').hasClass('stickyFixTop'))
        $('#sticky').addClass('stickyFixTop');
    else if(topOfSticky >= 25 && $('#sticky').hasClass('stickyFixTop'))
        $('#sticky').removeClass('stickyFixTop');

    $('.tabLinkMainWrap').css('color', 'black');

    var showWhatId = null;
    var sum = $(window).width() <= 767 ? 120 : 0;

    var topOfInfo = document.getElementById('generalDescLinkRel').getBoundingClientRect().top - sum;
    var topOfQA = document.getElementById('QAndAMainDivId').getBoundingClientRect().top - sum;
    var topOfPost = document.getElementById('mainDivPlacePost').getBoundingClientRect().top - sum;
    var topOfMap = document.getElementById('goToMapSection');
    var topOfSimilar = document.getElementById('topPlacesSection');
    var topOfRecipe = document.getElementById('recepieForFood');

    if(topOfSimilar){
        topOfSimilar = document.getElementById('topPlacesSection').getBoundingClientRect().top;
        if(topOfSimilar < 0)
            showWhatId = 'similarLocationsBtnTopBar';
    }

    if(topOfQA < 0 && showWhatId == null)
        showWhatId = 'QAndAsBtnTopBar';

    if(topOfPost < 0 && showWhatId == null)
        showWhatId = 'postsBtnTopBar';

    if(topOfMap){
        topOfMap = document.getElementById('goToMapSection').getBoundingClientRect().top - sum;
        if(topOfMap < 0 && showWhatId == null)
            showWhatId = 'mapBtnTopBar';
    }

    if(topOfRecipe){
        topOfRecipe = document.getElementById('recepieForFood').getBoundingClientRect().top - sum;
        if(topOfRecipe < 0 && showWhatId == null)
            showWhatId = 'recipeDescBtnTopBar';
    }

    if(topOfInfo < 0 && showWhatId == null)
        showWhatId = 'generalDescBtnTopBar';

    if(showWhatId != null)
        $(`.${showWhatId}`).css('color', 'var(--koochita-light-green)');

    if($(window).width() <= 767){
        var indecTop = document.getElementById('indicForShowDown').getBoundingClientRect().top;
        indecTop += $('#indicForShowDown').height() - 110;
        if(indecTop < 0){
            if(!isOpenRateButton && yourRateForThisPlace == 0){
                isOpenRateButton = true;
                $('.setScoreForThisPlaceComeUp').removeClass('hidden');
                setTimeout(() => $('.setScoreForThisPlaceComeUp').addClass('open'), 100);
            }
            $('#comeDownHeader').addClass('show');
        }
        else
            $('#comeDownHeader').removeClass('show');
    }
});
