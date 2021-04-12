var mainMap;
var cancelThisReviewFile = false;
var reviewFileInUpload = false;
var uploadReviewFileAjax = null;


function openWriteReview(){
    if(!checkLogin())
        return;

    selectPlaceForNewReview(kindPlaceId, placeId, localShop.name);
    openModalWriteNewReview(getLocalShopReviews);
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
        var element = $(`.ratingStar${i}`);
        if(element.attr('data-selected') == 1){
            lastSelected = element.attr('data-star');
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
                    updatePlaceRating(response.rates.avg, response.rates.rate);
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

function updatePlaceRating(_avg, _separate = []){
    var elements = $('.ratingStarsSection').find('.star');
    var elementsModal = $('.userRateToPlaceModal').find('.starIcons');
    for(var i = 0; i < elements.length; i++){
        if(i < _avg){
            $(elements[i]).removeClass('emptyStarRating').addClass('fullStarRating');
            $(elementsModal[i]).removeClass('emptyStarRating').addClass('fullStarRating');
        }
        else{
            $(elements[i]).addClass('emptyStarRating').removeClass('fullStarRating');
            $(elementsModal[i]).addClass('emptyStarRating').removeClass('fullStarRating');
        }
    }
}

function imAmHereFunc(_element){
    openLoading();

    $.ajax({
        type: 'POST',
        url: iAmHereLocalShopUrl,
        data:{
            _token: csrfTokenGlobal,
            localShopId: placeId
        },
        complete: closeLoading,
        success: response => {
            if(response.status == 'ok'){
                if(response.result == 1)
                    $(_element).addClass('selected');
                else
                    $(_element).removeClass('selected');
            }
            else
                showSuccessNotifi('ثبت نظر با مشکل مواجه شد', 'left', 'red');
        },
        error: err =>{
            showSuccessNotifi('ثبت نظر با مشکل مواجه شد', 'left', 'red');
        }
    })
}

function getVideoFromKoochitaTv(){
    var setDefaultData = () =>{
        document.querySelector('.koochitaTvTitle').innerText = 'کوچیتا تی وی ، پلتفرم ویدیو ';
        [...document.querySelectorAll('.koochitaTvPic')].map(item => 'https://koochitatv.com');
    };

    $.ajax({
        type: 'GET',
        url: `${koochitaTvUrl}?id=${placeId}&kindPlaceId=13`,
        success: response => {
            if(response.status == 'ok'){
                var result = response.result;
                document.querySelector('.userInfoKoochitaTv').style.display = 'flex';

                document.querySelector('.koochitaTvPic').src = result.pic;
                document.querySelector('.koochitaTvTitle').innerText = result.title;
                document.querySelector('.koochitaTvUserTime').innerText = result.time;
                document.querySelector('.koochitaTvUserName').innerText = result.username;
                document.querySelector('.koochitaTvUserPic').src = result.userPic;
                [...document.querySelectorAll('.koochitaTvPic')].map(item => item.setAttribute('href', result.url));
            }
            else
                setDefaultData()
        },
        error: setDefaultData
    })
}


$('.localShopPageBookMark').on('click', bookMarkThisLocalShop);

$(window).ready(() => {
    getVideoFromKoochitaTv();
    initMap();
    autosize($('.autoResizeTextArea'));
    getLocalShopReviews();

    updatePlaceRating(localShop.fullRate);

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
