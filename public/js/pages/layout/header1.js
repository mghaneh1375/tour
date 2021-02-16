
function showCampingModal(){
    $('#campingHeader').css('display', 'flex');
    resizeFitImg('resizeImgClass');
}

function goToLanding(){
    if(!checkLogin(addPlaceByUserPageUrl))
        return;
    else {
        openLoading();
        location.href = addPlaceByUserPageUrl;
    }
}

function openUploadPost(){
    if(!checkLogin())
        return;
    else
        openUploadPhotoModal('کوچیتا', addPhotoToPlaceUrlHeader1, 0, 0, '');
}

function writeNewSafaranmeh(){
    if(checkLogin()) {
        $('#campingHeader').hide();
        openNewSafarnameh();
    }
}
function hideAllTopNavs(){
    openHeadersTab = false;

    $("#alert").hide();
    $("#bookmarkmenu").hide();
    $("#languageMenu").hide();
    $("#my-trips-not").hide();
    $("#profile-drop").hide();
}

$('#close_span_search').click(e => {
    hideAllTopNavs();
    $('#searchspan').animate({height: '0vh'});
    $("#myCloseBtn").addClass('hidden');
});

$('#openSearch').click(e => {
    hideAllTopNavs();
    $("#myCloseBtn").removeClass('hidden');
    $('#searchspan').animate({height: '100vh'});
});


function openHeaderTabsVariable(){
    setTimeout(() => openHeadersTab = true, 500);
}

$('#memberTop').click(e => {
    if( $("#profile-drop").is(":hidden")) {
        hideAllTopNavs();
        $("#profile-drop").show();
        openHeaderTabsVariable()
    }
    else {
        hideAllTopNavs();
    }
});

$('#bookmarkicon').click(e => {
    if( $("#bookmarkmenu").is(":hidden")){
        hideAllTopNavs();
        $("#bookmarkmenu").css('display', 'block');
        openHeaderTabsVariable()
    }
    else
        hideAllTopNavs();
});

$('#languageIcon').click(e => {
    if( $("#languageMenu").is(":hidden")){
        hideAllTopNavs();
        $("#languageMenu").css('display', 'block');
        openHeaderTabsVariable()
    }
    else
        hideAllTopNavs();
});

$('.notification-bell').click(e => {
    if( $("#alert").is(":hidden")) {
        hideAllTopNavs();
        $("#alert").css('display', 'block');
        setSeenAlert(0, '');
        getAlertItems();
        openHeaderTabsVariable();
    }
    else
        hideAllTopNavs();
});

$("#Settings").on({
    mouseenter: function () {
        $(".settingsDropDown").css('display', 'block')
    }, mouseleave: function () {
        $(".settingsDropDown").hide()
    }
});

function getRecentlyViews(containerId) {
    $("#" + containerId).empty();

    $.ajax({
        type: 'post',
        url: getRecentlyPath,
        success: function (response) {
            response = JSON.parse(response);
            for(i = 0; i < response.length; i++) {
                element = "<div>";
                element += "<a class='masthead-recent-card' style='text-align: right !important;' target='_self' href='" + response[i].placeRedirect + "'>";
                element += "<div class='media-left' style='padding: 0 12px !important; margin: 0 !important;'>";
                element += "<div class='thumbnail' style='background-image: url(" + response[i].placePic + ");'></div>";
                element += "</div>";
                element += "<div class='content-right'>";
                element += "<div class='poi-title'>" + response[i].placeName + "</div>";
                element += "<div class='rating'>";

                if (response[i].placeRate == 5)
                    element += "<div class='ui_bubble_rating bubble_50'></div>";
                else if (response[i].placeRate == 4)
                    element += "<div class='ui_bubble_rating bubble_40'></div>";
                else if (response[i].placeRate == 3)
                    element += "<div class='ui_bubble_rating bubble_30'></div>";
                else if (response[i].placeRate == 2)
                    element += "<div class='ui_bubble_rating bubble_20'></div>";
                else
                    element += "<div class='ui_bubble_rating bubble_10'></div>";

                element += "<br/>" + response[i].placeReviews + " {{__('نقد')}} ";
                element += "</div>";
                element += "<div class='geo'>" + response[i].placeCity + "/ " + response[i].placeState + "</div>";
                element += "</div>";
                element += "</a></div>";

                $("#" + containerId).append(element);
            }
        }
    });
}

function showRecentlyViews(element) {
    if( $("#my-trips-not").is(":hidden")){
        hideAllTopNavs();
        $("#my-trips-not").css('display', 'block');
        getRecentlyViews(element);
    }
    else
        hideAllTopNavs();
}
