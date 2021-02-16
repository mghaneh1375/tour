
var openGlobalMaterialSearch = () => createSearchInput(getGlobalInputMaterialSearchKeyUp, 'ماده اولبه مورد نظر خود را وارد کنید.');

var getGlobalInputMaterialSearchKeyUp = _element => searchForMaterial($(_element).val());

var goToCookFestival = () => openLoading(false, () => location.href = cookFestivalUrl);


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


function openListSort(_element){
    $('.sortListMobileFooter').toggleClass('open');
    $(_element).toggleClass('selected');
}


$(window).ready(() => {
    // initMyCalendar('showMyCalTourism', [
    //     'ش',
    //     'ی',
    //     'د',
    //     'س',
    //     'چ',
    //     'پ',
    //     'ج',
    // ]);
});

// var serviceWorkerUrl = '{{URL::asset("ServiceWorker.js")}}';
// serviceWorkerUrl = serviceWorkerUrl.replace('http://', 'https://');
//
// if ('serviceWorker' in navigator) {
//     window.addEventListener('load', function(){
//         navigator.serviceWorker.register(serviceWorkerUrl).then(
//             registration => {
//                 console.log('Service Worker is registered', registration);
//             }).catch(
//             err => {
//                 console.error('Registration failed:', err);
//             });
//     })
// }
