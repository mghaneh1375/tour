
var idxSlideBar;
var SliderFilter;
var defaultSlideBarPic = -1;
var alts;

$(".thumbNavLeft").css('background-position-y', '-40px');
$(".thumbNavRight").css('background-position-y', '0');

function nxtPhotoSlideBar() {

    idxSlideBar = parseInt(idxSlideBar);
    if (idxSlideBar + 1 < SliderFilter.length) {
        idxSlideBar++;
        setMainPic(idxSlideBar);
    }
}

function prvPhotoSlideBar() {
    idxSlideBar = parseInt(idxSlideBar);
    if (idxSlideBar - 1 >= 0) {
        idxSlideBar--;
        setMainPic(idxSlideBar);
    }
}

var logPhotosFetched = [];
var logPics = [[]];

function showPhotoLists(picItemId, idx) {

    var newElement = "";
    sliderPics = [];
    var sitesPhoto = 0;
    var i;

    if (idx != -1) {
        for (i = 0; i < logPics[idx].length; i++) {

            if (picItemId == -1) {
                sitesPhoto++;
                alts[alts.length] = logPics[idx][i].alt;
            }

            newElement += "<div class='tinyThumb filter_" + picItemId + "' id='tinyThumb_" + i + "' data-val='" + i + "' onclick='setMainPic($(this).attr(\"data-val\"))'><img style='cursor:pointer' src='" + logPics[idx][i].picT + "' width='50' height='50'></div>";
            sliderPics[i] = [picItemId, logPics[idx][i].pic, logPics[idx][i].owner, logPics[idx][i].ownerPic];
        }
    }

    SliderFilter = sliderPics;

    $(".inHeroList").empty().append(newElement);

    newElement = "<li class='ab101 ab_-1'>";
    newElement += "<span onclick='getPhotos(-1)' class='tabText'>همه (" + totalPhotos + ")</span>";
    newElement += "</li>";

    newElement += "<li class='ab101 ab_-2'>";
    newElement += "<span onclick='getPhotos(-2)' style='direction: rtl' class='tabText'>سایت (" + sitePhotosCount + ")</span>";
    newElement += "</li>";

    if (idx != -1) {
        newElement += "<li class='ab101 ab_-3'>";
        newElement += "<span onclick='getPhotos(-3)' style='direction: rtl' class='tabText'>عکس های کاربران (" + (totalPhotos - sitePhotosCount) + ")</span>";
        newElement += "</li>";
    }

    for (i = 0; i < filters.length; i++) {
        if (picItemId == 0 && i == 0)
            defaultSlideBarPic = filters[i].id;
        newElement += "<li class='ab101 ab_" + filters[i].id + "'>";
        newElement += "<span onclick='getPhotos(" + filters[i].id + ")' class='tabText' style='direction: rtl'>" + filters[i].name + "(" + filters[i].countNum + ")</span>";
        newElement += "</li>";
    }

    $(".tabCount3").empty().append(newElement);
    $("#photo_album_span").show();

    if (idx == -1)
        setMainPic(-1);

    filterSlideBar(picItemId);
}

function getPhotos(picItemId) {

    var i;

    for (i = 0; i < logPhotosFetched.length; i++) {
        if (logPhotosFetched[i] == picItemId) {
            showPhotoLists(picItemId, i);
            return;
        }
    }

    $.ajax({
        type: 'post',
        url: getPhotosDir,
        data: {
            'placeId': placeId,
            'kindPlaceId': kindPlaceId,
            'picItemId': picItemId
        },
        success: function (response) {

            logPhotosFetched[i] = picItemId;
            response = JSON.parse(response);
            filters = response["filters"];
            logPics[i] = response["pics"];
            alts = [];
            idxSlideBar = 0;

            showPhotoLists(picItemId, i);
        }
    });

    showPhotoLists(picItemId, -1);
}

function setMainPic(idx) {

    idxSlideBar = parseInt(idx);

    if (idxSlideBar <= 0) {
        $(".heroNavLeft").addClass('hidden');
    }
    else {
        $(".heroNavLeft").removeClass('hidden');
    }

    if (idxSlideBar == SliderFilter.length - 1) {
        $(".heroNavRight").addClass('hidden');
    }
    else {
        $(".heroNavRight").removeClass('hidden');
    }

    if (idxSlideBar > -1) {
        pic = SliderFilter[idxSlideBar][1];
        owner = SliderFilter[idxSlideBar][2];
        ownerPic = SliderFilter[idxSlideBar][3];
    }

    newElement = "<div class='member_info'>";
    newElement += "<div class='memberOverlayLink'>";

    if (idxSlideBar == -1) {
        newElement += "<div class='avatar' style='float: right !important; padding: 0 !important; border: none !important'>";
        $(".mainImg").empty().append("<div style='margin-top: 40vh; right: 45%; position: absolute' class='loader'></div>");
    }
    else if (SliderFilter[idxSlideBar][0] != -1) {
        newElement += "<div class='avatar' onmouseleave='$(\".img_popUp\").addClass(\"hidden\");' onmouseenter='showBriefPopUp(this, \"" + owner + "\")' style='float: right !important; padding: 0 !important; border: none !important'>";
        $(".mainImg").empty().append("<img src='" + pic + "' width='1000' height='1500'>");
    }
    else {
        newElement += "<div class='avatar' style='float: right !important; padding: 0 !important; border: none !important'>";
        $(".mainImg").empty().append("<img alt='" + alts[idxSlideBar] + "' src='" + pic + "' width='1000' height='1500'>");
    }

    if (idxSlideBar != -1) {
        newElement += "<img width='74' class='avatar' height='74' src='" + ownerPic + "'/>";
        newElement += "</div>";
        newElement += "<div class='username mo'></div></div>";
        newElement += "<div class='location'>" + owner + "</div>";
        newElement += "</div>";
    }
    $(".captionProvider").empty().append(newElement);

}

function filterSlideBar(id) {

    if (id == 0)
        id = defaultSlideBarPic;

    $(".ab101").removeClass('current');
    $(".ab_" + id).addClass('current');
    $(".tinyThumb").addClass('hidden');
    $(".filter_" + id).removeClass('hidden');

    SliderFilter = [];
    idxSlideBar = 0;

    for (i = 0; i < sliderPics.length; i++) {
        if (sliderPics[i][0] == id) {
            SliderFilter[SliderFilter.length] = sliderPics[i];
            $("#tinyThumb_" + i).attr('data-val', SliderFilter.length - 1);
        }
    }

    if (SliderFilter.length > 0)
        setMainPic(0);
}