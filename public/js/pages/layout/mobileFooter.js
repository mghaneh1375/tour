var opnedMobileFooterId = null;
var profileSideMenuElement = $('#profileSideMenu');


var openSideMenuInProfileFooter = () => profileSideMenuElement.toggleClass('open');

var closeMobileFooterPopUps = _id => $(`#${_id}`).modal('hide');

var createReviewExploreMinPlaceHolder = () => '<div class="reviewExploreSquare smallReviewPlaceHolder placeHolderAnime"></div>';

var createTripFromMobileFooter = () => createNewTrip(() => getMyTripsPromiseFunc().then(response => createTripCardFooter(response)));

function specialMobileFooter(_id, _element){
    resizeFitImg('resizeImgClass');
    $('.specPages').addClass('hidden');
    $(`#${_id}`).removeClass('hidden');

    $('.specTabsFot').removeClass('lp_selectedMenu');
    $(_element).addClass('lp_selectedMenu');
}

function openMobileFooterPopUps(_id, _type = "toggle"){
    console.log(opnedMobileFooterId);
    closeMyModalClass('footerModals');
    if(opnedMobileFooterId != _id || _type === "open") {
        opnedMobileFooterId = _id;

        if(_id === "profileFooterModal")
            addReviewPlaceHolderToFooter();
        else if(_id === "mainMenuFooter")
            showLastPages();

        openMyModal(_id);
    }
    else
        opnedMobileFooterId = null;

    resizeFitImg('resizeImgClass');
}

function mobileFooterProfileButton(_kind){
    let windowUrl = window.location;
    let url = windowUrl.origin + windowUrl.pathname;

    if(_kind == 'setting')
        window.location.href = userSettingPageUrl;
    else if(_kind == 'follower')
        openFollowerModal('resultFollowers', window.user.id); // in general.followerPopUp.blade.php
    else if(url == profileUrl || url == profileUrl+'/'+window.user.username) {
        closeMyModalClass('footerModals');
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
    }
    else
        window.location.href = profileUrl+'/'+window.user.username+'#'+_kind;
}


// START mobile_footer_explore
var mobileFooterExploreTryNum = 3;
var mobileFooterExplorePage = 1;
var mobileFooterExploreKind = 'followers';
var mobileFooterExploreSearchValue = '';
var mobileFooterExploreTake = 5;
var mobileFooterExploreIsEnd = false;
var mobileFooterExploreInTake = false;
var getReviewForExploreAjax = null;

function addReviewPlaceHolderToFooter(){
    if(!mobileFooterExploreIsEnd && !mobileFooterExploreInTake) {
        var footerExploreReviewSectionElement = $('#footerExploreReviewSection');
        var reviewPlaceHolder = '';
        mobileFooterExploreInTake = true;

        if(mobileFooterExploreKind === "followers" || mobileFooterExploreKind === "search_place"){
            reviewPlaceHolder = getReviewPlaceHolder();
            reviewPlaceHolder += reviewPlaceHolder;
            mobileFooterExploreTake = 5;

            footerExploreReviewSectionElement.removeClass('allReviewSec')
        }
        else{
            var reviewPlaceHolder1 = createReviewExploreMinPlaceHolder();
            for(var i = 0; i < 9; i++)
                reviewPlaceHolder += reviewPlaceHolder1;

            mobileFooterExploreTake = 25;
            footerExploreReviewSectionElement.addClass('allReviewSec');
        }

        footerExploreReviewSectionElement.append(reviewPlaceHolder);

        getReviewForExploreAjax = $.ajax({
            type: 'GET',
            url: `${getReviewExploreUrl}?take=${mobileFooterExploreTake}&page=${mobileFooterExplorePage}&kind=${mobileFooterExploreKind}&value=${mobileFooterExploreSearchValue}`,
            complete: () => {
                footerExploreReviewSectionElement.find('.smallReviewPlaceHolder').remove();
            },
            success: response => {
                if(response.status == 'ok')
                    createReviewUIForExplore(response.result);
            },
            error: err =>{
                mobileFooterExploreInTake = false;
            }
        });
    }
}

function createReviewUIForExplore(_result){
    if(_result.length != mobileFooterExploreTake)
        mobileFooterExploreIsEnd = true;

    mobileFooterExplorePage++;

    var html = '';
    _result.map(item => {
        html += (mobileFooterExploreKind == 'followers' || mobileFooterExploreKind === "search_place") ? createSmallReviewHtml(item) : createReviewExploreMin(item);
        setIntoGlobalReviewInput(item);
    });

    $('#footerExploreReviewSection').append(html);

    mobileFooterExploreInTake = false;
}

function createReviewExploreMin(review){
    var picSec = '';
    var normalText = review.text.replace(/(<([^>]+)>)/gi, "");
    if(review.mainPic != undefined)
        picSec = `<img src="${review.mainPic}" alt="mainPic" class="resizeImgClass" onload="fitThisImg(this)">`;
    else
        picSec = `<div class="text">${normalText}</div>`;

    return `<div class="reviewExploreSquare" onclick="getSingleFullReview(${review.id})">
                    <div class="picSec ${review.mainPic == undefined ? 'isText' : ''} ${review['mainPicIsVideo'] == 1 ? 'playIconOnPicSection' : ''}">
                        ${picSec}
                    </div>
                </div>`;
}

function changeMobileFooterReviewExplore(_element, _kind, _value=''){
    mobileFooterExplorePage = 1;
    mobileFooterExploreIsEnd = false;
    mobileFooterExploreInTake = false;
    mobileFooterExploreKind = _kind;
    mobileFooterExploreSearchValue = _value;

    $(_element).parent().find('.selected').removeClass('selected');
    $(_element).addClass('selected');

    $('#footerExploreReviewSection').empty();

    if(getReviewForExploreAjax != null)
        getReviewForExploreAjax.abort();

    addReviewPlaceHolderToFooter();
}

// END mobile_footer_explore




// START review_search
var searchForReviewContentAjax = null;
var reviewSearchMFooterType = 'user';
var searchInReviewElement = $('#profileSearchReviewsMFooter');
var searchInReviewMFooterElement = $('#searchInReviewMFooter');
var searchInReviewPlaceHolderElement = searchInReviewElement.find('.searchResultPlaceHolderSec');
var searchInReviewResultElement = searchInReviewElement.find('.searchResultSec');

var openSearchModalReviewMFooter = () => searchInReviewElement.toggleClass('open');

function closeAndClearReviewSearchModal() {
    searchInReviewElement.removeClass('open');
    searchInReviewPlaceHolderElement.addClass('hidden');
    searchInReviewResultElement.removeClass('hidden').empty();

    searchInReviewMFooterElement.val('');
}

function chooseThisSearchTypeReviewMFooter(_element, _type){
    _element = $(_element);
    _element.parent().find('.select').removeClass('select');
    _element.addClass('select');

    searchInReviewPlaceHolderElement.addClass('hidden');
    searchInReviewResultElement.removeClass('hidden').empty();

    if(searchForReviewContentAjax != null)
        searchForReviewContentAjax.abort();

    reviewSearchMFooterType = _type;

    searchInReviewSearch(searchInReviewMFooterElement.val());
}

function searchInReviewSearch(_value){
    if(searchForReviewContentAjax != null)
        searchForReviewContentAjax.abort();

    if(_value.trim().length > 1){
        searchInReviewPlaceHolderElement.removeClass('hidden');
        searchInReviewResultElement.empty().addClass('hidden');

        searchForReviewContentAjax = $.ajax({
            type: 'GET',
            url: `${searchInForReviewUrl}?kind=${reviewSearchMFooterType}&value=${_value}`,
            success: response => {
                if(response.status == 'ok')
                    createSearchResultForReviewSearchMFooter(response.result);
            }
        })
    }
    else{
        searchInReviewPlaceHolderElement.addClass('hidden');
        searchInReviewResultElement.empty().removeClass('hidden');
    }
}

function createSearchResultForReviewSearchMFooter(_result){
    var html = '';
    _result.map(item => {
        var secRowText = '';
        var picSec = '';
        var id = -1;

        if(reviewSearchMFooterType === "place") {
            id = `${item.kindPlace}_${item.id}`;
            secRowText = `${item.city} در ${item.state}`;
            picSec = `<img src="${item.pic}" alt="mainPic" class="resizeImgClass" onload="fitThisImg(this)">`;
        }
        else if(reviewSearchMFooterType === "user"){
            id = item.id;
            picSec = `<img src="${item.pic}" alt="mainPic" class="resizeImgClass" onload="fitThisImg(this)">`;
        }
        else if(reviewSearchMFooterType === "tag"){
            id = item.name;
            picSec = '<div class="fullyCenterContent" style="margin: 4px 2px 0 0;">#</div>';
        }


        html += `<div class="item" data-kind="${reviewSearchMFooterType}" data-id="${id}" onclick="clickOnReviewSearchResult(this)">
                        <div class="pic" style="${reviewSearchMFooterType === 'tag' ? 'border: solid 1px #333;' : ''}"> ${picSec} </div>
                        <div class="content">
                            <div class="firstRow">${item.name}</div>
                            <div class="secRow">${secRowText}</div>
                        </div>
                    </div>`;
    });

    searchInReviewPlaceHolderElement.addClass('hidden');
    searchInReviewResultElement.removeClass('hidden').html(html);

    searchForReviewContentAjax = null;
}

function clickOnReviewSearchResult(_element){
    var kind = $(_element).attr('data-kind');
    var id = $(_element).attr('data-id');
    var element;
    if(kind === "user")
        openLoading(false, () => location.href = `${userProfileUrl}/${id}`);
    else if(kind === "tag"){
        openReviewTagSearchFromReview(id);
    }
    else if(kind === "place"){
        element = document.getElementById("searchReviewButton");
        changeMobileFooterReviewExplore(element, "search_place", id);
        closeAndClearReviewSearchModal();
    }
}

function openReviewTagSearchFromReview(_tag){
    openMobileFooterPopUps("profileFooterModal", "open");
    var element = document.getElementById("searchReviewButton");
    changeMobileFooterReviewExplore(element, "search_tag", _tag);
    closeAndClearReviewSearchModal();
}

// END review_search



profileSideMenuElement.on('click', e => {
    if($(e.target).hasClass('profileSideMenu'))
        openSideMenuInProfileFooter();
});

$('.userInfoMobileFooterBody').on('scroll', () => {
    var bottomOfList = document.getElementById('indicatorForNewReview').getBoundingClientRect().top;
    var windowHeight = $('.userInfoMobileFooterBody').height();
    if(bottomOfList-windowHeight < 100 && !mobileFooterExploreIsEnd && !mobileFooterExploreInTake)
        addReviewPlaceHolderToFooter();
});

$('.footerModals').on('touchstart', e => {
    var touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
    touchRigthForFooterMobile = touch.pageX;
}).on('touchend', e => {
    var windowWidth = $(window).width();
    var touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
    if((touch.pageX - touchRigthForFooterMobile) > (windowWidth/3) ) {
        closeMyModalClass('footerModals');
        opnedMobileFooterId = null;
    }
});

$('.gombadi').on('click', e => {
    if($(e.target).hasClass('gombadi')) {
        closeMyModal($(e.target).parent().attr('id'));
    }
});
