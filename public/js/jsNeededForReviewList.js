var selectedLogId;
var sliderPics = [];
var idxSlideBar;
var SliderFilter;

$(document).ready(function(){

    $(".img_btn").on({
        mouseenter: function(){

            var bodyRect = document.body.getBoundingClientRect(),
                elemRect = this.getBoundingClientRect(),
                offset2 = elemRect.left - bodyRect.left,
                offset = elemRect.top - bodyRect.top;

            if(offset < 0)
                offset = Math.abs(offset);

            $(".img_popUp").css("top", offset);
            $(".img_popUp").css("left", offset2 - 450);

            showDetails($(this).attr('data-val'));
        },
        mouseleave: function() {
            $(".img_popUp").addClass('hidden');
        }
    });

    $(".img_popUp").on({
        mouseenter: function(){
            $(".img_popUp").removeClass('hidden');
        },
        mouseleave: function(){
            $(".img_popUp").addClass('hidden');
        }
    });

});

function showElement(element) {
    $(".pop-up").addClass('hidden');
    $(".item").addClass('hidden');
    $("#" + element).removeClass('hidden');
}

function hideElement(element) {
    $("#" + element).addClass('hidden');
}

function showDetails(username) {

    if(username == null)
        return;

    $.ajax({
        type: 'post',
        url: showUserBriefDetail,
        data: {
            'username': username
        },
        success: function (response) {

            response = JSON.parse(response);

            total = response.excellent + response.veryGood + response.average + response.bad + response.veryBad;
            total /= 100;

            $(".img_popUp").empty();

            newElement = "<div class='arrow' style=' margin: 0 30px 155px 0;'></div>";
            newElement += "<div class='body_text'>";
            newElement += "<div class='memberOverlay simple container moRedesign'>";
            newElement += "<div class='innerContent'>";
            newElement += "<div class='memberOverlayRedesign g10n'>";
            newElement += "<a href='" + homeURL + "/profile/index/" + username + "'>";
            newElement += "<h3 class='username reviewsEnhancements'>" + username + "</h3>";
            newElement += "</a>";
            newElement += "<div class='memberreviewbadge'>";
            newElement += "<div class='badgeinfo'>";
            newElement += "Level <span>" + response.level + "</span>";
            newElement += "</div></div>";
            newElement += "<ul class='memberdescriptionReviewEnhancements'>";
            newElement += "<li>تاریخ عضویت در سایت " + response.created + "</li>";
            newElement += "<li>از " + response.city + " در " + response.state +  " </li>";
            newElement += "</ul>";
            newElement += "<ul class='countsReviewEnhancements'>";
            newElement += "<li class='countsReviewEnhancementsItem'>";
            newElement += "<span class='ui_icon pencil-paper iconReviewEnhancements'></span>";
            newElement += "<span class='badgeTextReviewEnhancements'>" + response.rates + " نظر</span>";
            newElement += "</li>";
            newElement += "<li class='countsReviewEnhancementsItem'>";
            newElement += "<span class='ui_icon globe-world iconReviewEnhancements'></span>";
            newElement += "<span class='badgeTextReviewEnhancements'>" + response.seen + " مشاهده</span>";
            newElement += "</li>";
            newElement += "<li class='countsReviewEnhancementsItem'>";
            newElement += "<span class='ui_icon thumbs-up-fill iconReviewEnhancements'></span>";
            newElement += "<span class='badgeTextReviewEnhancements'>" + response.likes + " رای مثبت</span>";
            newElement += "</li>";
            newElement += "<li class='countsReviewEnhancementsItem'>";
            newElement += "<span class='ui_icon thumbs-down-fill iconReviewEnhancements'></span>";
            newElement += "<span class='badgeTextReviewEnhancements'>" + response.dislikes + " رای منفی</span>";
            newElement += "</li>";
            newElement += "</ul>";
            newElement += "<div class='wrap'>";
            newElement += "<ul class='memberTagsReviewEnhancements'>";
            newElement += "</ul></div>";
            newElement += "<div class='wrap'>";
            newElement += "<div class='wrap container histogramReviewEnhancements'>";
            newElement += "<div class='barlogoReviewEnhancements'>";
            newElement += "<span>REVIEW DISTRIBUTION</span>";
            newElement += "</div><ul>";
            newElement += "<div class='chartRowReviewEnhancements'>";
            newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>Excellent</span>";
            newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
            newElement += "<span class='barReviewEnhancements'>";
            newElement += "<span class='fillReviewEnhancements' style='width:" + response.excellent / total + "%;'></span>";
            newElement += "</span></span>";
            newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.excellent + "</span>";
            newElement += "</div>";
            newElement += "<div class='chartRowReviewEnhancements'>";
            newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>Very good</span>";
            newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
            newElement += "<span class='barReviewEnhancements'>";
            newElement += "<span class='fillReviewEnhancements' style='width:" + response.veryGood / total + "%;'></span>";
            newElement += "</span></span>";
            newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.veryGood + "</span>";
            newElement += "</div>";
            newElement += "<div class='chartRowReviewEnhancements'>";
            newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>Average</span>";
            newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
            newElement += "<span class='barReviewEnhancements'>";
            newElement += "<span class='fillReviewEnhancements' style='width:" + response.average / total + "%;'></span>";
            newElement += "</span></span>";
            newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.average + "</span>";
            newElement += "</div>";
            newElement += "<div class='chartRowReviewEnhancements'>";
            newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>Poor</span>";
            newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
            newElement += "<span class='barReviewEnhancements'>";
            newElement += "<span class='fillReviewEnhancements' style='width:" + response.bad / total + "%;'></span>";
            newElement += "</span></span>";
            newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.bad + "</span>";
            newElement += "</div>";
            newElement += "<div class='chartRowReviewEnhancements'>";
            newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>Terrible</span>";
            newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
            newElement += "<span class='barReviewEnhancements'>";
            newElement += "<span class='fillReviewEnhancements' style='width:" + response.veryBad / total + "%;'></span>";
            newElement += "</span></span>";
            newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.veryBad + "</span>";
            newElement += "</div></ul></div></div></div></div></div></div>";

            $(".img_popUp").append(newElement);
            $(".img_popUp").removeClass('hidden');
        }
    });

}

function report(logId) {

    $.ajax({
        type: 'post',
        url: reportDir,
        data: {
            'logId': logId
        }
    });
}

function customReport() {

    if($("#custom-checkBox").is(':checked')) {
        $("#custom-define-report").empty();
        newElement = "<div class='col-xs-12'>";
        newElement += "<textarea id='customDefinedReport' style='width: 375px; height: 100px; padding: 5px !important; margin-top: 5px;' maxlength='1000' required placeholder='حداکثر 1000 کاراکتر'></textarea>";
        newElement += "</label></div>";
        $("#custom-define-report").append(newElement);
        $("#custom-define-report").css("visibility", "visible");
    }
    else {
        $("#custom-define-report").empty();
        $("#custom-define-report").css("visibility", "hidden");
    }
}

function getReports(logId) {

    $("#reports").empty();

    $.ajax({
        type: 'post',
        url: getReportsDir,
        data: {
            'logId': logId
        },
        success: function (response) {

            if(response != "")
                response = JSON.parse(response);

            newElement = "<div id='reportContainer' class='row'>";

            if(response != "") {
                for (i = 0; i < response.length; i++) {
                    newElement += "<div class='col-xs-12'>";
                    newElement += "<div class='ui_input_checkbox'>";
                    if(response[i].selected == true)
                        newElement += "<input id='report_" + response[i].id + "' type='checkbox' name='reports' checked value='" + response[i].id + "'>";
                    else
                        newElement += "<input id='report_" + response[i].id + "' type='checkbox' name='reports' value='" + response[i].id + "'>";
                    newElement += "<label class='labelForCheckBox' for='report_" + response[i].id + "'><span></span>&nbsp;&nbsp;";
                    newElement += response[i].description;
                    newElement += "</label>";
                    newElement += "</div></div>";
                }
            }

            newElement += "<div class='col-xs-12'>";

            newElement += "<div class='ui_input_checkbox'>";
            newElement += "<input id='custom-checkBox' onchange='customReport()' type='checkbox' name='reports' value='-1'>";
            newElement += "<label class='labelForCheckBox' for='custom-checkBox'><span></span>&nbsp;&nbsp;";
            newElement += "سایر موارد";
            newElement += "</label>";
            newElement += "</div></div>";

            newElement += "<div id='custom-define-report' style='visibility: hidden'></div>";

            newElement += "</div>";

            $("#reports").append(newElement);

            if(response != "" && response.length > 0 && response[0].text != "") {
                customReport();
                $("#customDefinedReport").val(response[0].text);
            }

        }
    });
}

function sendReport() {

    customMsg = "";

    if($("#customDefinedReport").val() != null)
        customMsg = $("#customDefinedReport").val();

    var checkedValuesReports = $("input:checkbox[name='reports']:checked").map(function() {
        return this.value;
    }).get();

    if(checkedValuesReports.length <= 0)
        return;

    if(!hasLogin) {
        url = homeURL + "/seeAllAns/" + questionId + "/report/" + selectedLogId;
        showLoginPrompt(url);
        return;
    }

    $.ajax({
        type: 'post',
        url: sendReportDir,
        data: {
            "logId": selectedLogId,
            "reports": checkedValuesReports,
            "customMsg" : customMsg
        },
        success: function (response) {
            if(response == "ok") {
                closeReportPrompt();
            }
            else {
                $("#errMsgReport").append('مشکلی در انجام عملیات مورد نظر رخ داده است');
            }
        }
    });
}

function closeReportPrompt() {
    $("#custom-checkBox").css("visibility", 'hidden');
    $("#custom-define-report").css("visibility", 'hidden');
    $("#reportPane").addClass('hidden');
    $(".dark").hide();
}

function showReportPrompt(logId) {

    if(!hasLogin) {
        url = homeURL + "/seeAllAns/" + questionId + "/report/" + logId;
        showLoginPrompt(url);
        return;
    }

    selectedLogId = logId;
    getReports(logId);
    showElement('reportPane');
    $(".dark").show();
}

function dislikeComment(logId) {

    $.ajax({
        type: 'post',
        url: opOnComment,
        data: {
            'logId': logId,
            'mode': 'dislike'
        },
        success: function (response) {
            if(response == "1") {
                $("#commentDislikes_" + logId).empty();
                $("#commentDislikes_" + logId).attr('data-val', parseInt($("#commentDislikes_" + logId).attr('data-val')) + 1);
                $("#commentDislikes_" + logId).append($("#commentDislikes_" + logId).attr('data-val'));
            }
            else if(response == "2") {
                $("#commentDislikes_" + logId).empty();
                $("#commentDislikes_" + logId).attr('data-val', parseInt($("#commentDislikes_" + logId).attr('data-val')) + 1);
                $("#commentDislikes_" + logId).append($("#commentDislikes_" + logId).attr('data-val'));

                $("#commentLikes_" + logId).empty();
                $("#commentLikes_" + logId).attr('data-val', parseInt($("#commentLikes_" + logId).attr('data-val')) - 1);
                $("#commentLikes_" + logId).append($("#commentLikes_" + logId).attr('data-val'));
            }
        }
    });
}

function likeComment(logId) {

    $.ajax({
        type: 'post',
        url: opOnComment,
        data: {
            'logId': logId,
            'mode': 'like'
        },
        success: function (response) {
            if(response == "1") {
                $("#commentLikes_" + logId).empty();
                $("#commentLikes_" + logId).attr('data-val', parseInt($("#commentLikes_" + logId).attr('data-val')) + 1);
                $("#commentLikes_" + logId).append($("#commentLikes_" + logId).attr('data-val'));
            }
            else if(response == "2") {
                $("#commentLikes_" + logId).empty();
                $("#commentLikes_" + logId).attr('data-val', parseInt($("#commentLikes_" + logId).attr('data-val')) + 1);
                $("#commentLikes_" + logId).append($("#commentLikes_" + logId).attr('data-val'));

                $("#commentDislikes_" + logId).empty();
                $("#commentDislikes_" + logId).attr('data-val', parseInt($("#commentDislikes_" + logId).attr('data-val')) - 1);
                $("#commentDislikes_" + logId).append($("#commentDislikes_" + logId).attr('data-val'));
            }
        }
    });
}

function nxtPhotoSlideBar() {
    idxSlideBar = parseInt(idxSlideBar);
    if(idxSlideBar + 1 < SliderFilter.length) {
        idxSlideBar++;
        setMainPic(idxSlideBar);
    }
}

function prvPhotoSlideBar() {
    idxSlideBar = parseInt(idxSlideBar);
    if(idxSlideBar - 1 >= 0) {
        idxSlideBar--;
        setMainPic(idxSlideBar);
    }
}

function getPhotos(placeId, kindPlaceId) {

    $.ajax({
        type: 'post',
        url: getPhotosDir,
        data: {
            'placeId': placeId,
            'kindPlaceId': kindPlaceId
        },
        success: function (response) {

            response = JSON.parse(response);
            filters = response["filters"];
            response = response["pics"];
            idxSlideBar = 0;

            var newElement = "";
            sitesPhoto = 0;
            $(".inHeroList").empty();
            sliderPics = [];

            for(i = 0; i < response.length; i++) {

                if(response[i].filter == -1)
                    sitesPhoto++;

                newElement += "<div class='tinyThumb filter_" + response[i].filter + "' id='tinyThumb_" + i + "' data-val='" + i + "'  onclick='setMainPic($(this).attr(\"data-val\"))'><img style='cursor:pointer' src='" + response[i].pic + "' width='50' height='50'></div>";
                sliderPics[i] = [response[i].filter, response[i].pic, response[i].owner, response[i].ownerPic];
            }

            SliderFilter = sliderPics;
            if(SliderFilter.length > 0)
                setMainPic(0);

            $(".inHeroList").append(newElement);

            $(".tabCount3").empty();
            newElement = "<li class='ab101 ab_all current'>";
            newElement += "<span onclick='removeFilterSlideBar()' class='tabText'>همه (" + response.length + ")</span>";
            newElement += "</li>";

            newElement += "<li class='ab101 ab_-1'>";
            newElement += "<span onclick='filterSlideBar(-1)' class='tabText' style='direction: rtl'>سایت (" + sitesPhoto + ")</span>";
            newElement += "</li>";

            for(i = 0; i < filters.length; i++) {
                newElement += "<li class='ab101 ab_" + filters[i].id + "'>";
                newElement += "<span onclick='filterSlideBar(" + filters[i].id + ")' class='tabText' style='direction: rtl'>" + filters[i].name + "(" + filters[i].countNum + ")</span>";
                newElement += "</li>";
            }
            $(".tabCount3").append(newElement);
            $("#photo_album_span").show();

        }
    });
}

function setMainPic(idx) {

    idxSlideBar = parseInt(idx);

    if(idxSlideBar == 0) {
        $(".heroNavLeft").addClass('hidden');
    }
    else {
        $(".heroNavLeft").removeClass('hidden');
    }

    if(idxSlideBar == SliderFilter.length - 1) {
        $(".heroNavRight").addClass('hidden');
    }
    else {
        $(".heroNavRight").removeClass('hidden');
    }

    pic = SliderFilter[idxSlideBar][1];
    owner = SliderFilter[idxSlideBar][2];
    ownerPic = SliderFilter[idxSlideBar][3];

    $(".mainImg").empty();
    $(".mainImg").append("<img src='" + pic + "' width='1000' height='1500'>");
    $(".captionProvider").empty();

    var newElement2 = "<div class='member_info'>";
    newElement2 += "<div class='memberOverlayLink'>";

    if(SliderFilter[idxSlideBar][0] != -1)
        newElement2 += "<div class='avatar' onmouseleave='$(\".img_popUp\").addClass(\"hidden\")' onmouseenter='showBriefPopUp(this, \"" + owner + "\")' style='float: right !important; padding: 0 !important; border: none !important'>";
    else
        newElement2 += "<div class='avatar' style='float: right !important; padding: 0 !important; border: none !important'>";

    newElement2 += "<img width='74' class='avatar' height='74' src='" + ownerPic + "'/>";
    newElement2 += "</div>";
    newElement2 += "<div class='username mo'></div></div>";
    newElement2 += "<div class='location'>" + owner + "</div>";
    newElement2 += "</div>";
    $(".captionProvider").append(newElement2);
}

function filterSlideBar(id) {

    SliderFilter = [];
    idxSlideBar = 0;

    $(".ab101").removeClass('current');
    $(".ab_" + id).addClass('current');
    $(".tinyThumb").addClass('hidden');
    $(".filter_" + id).removeClass('hidden');

    for(i = 0; i < sliderPics.length; i++) {
        if(sliderPics[i][0] == id) {
            SliderFilter[SliderFilter.length] = sliderPics[i];
            $("#tinyThumb_" + i).attr('data-val', SliderFilter.length - 1);
        }
    }

    if(SliderFilter.length > 0)
        setMainPic(0);
}

function removeFilterSlideBar() {

    idxSlideBar = 0;
    SliderFilter = sliderPics;

    $(".ab101").removeClass('current');
    $(".ab_all").addClass('current');
    $(".tinyThumb").removeClass('hidden');

    for(i = 0; i < sliderPics.length; i++) {
        $("#tinyThumb_" + i).attr('data-val', i);
    }

    if(sliderPics.length > 0)
        setMainPic(0);
}

function showBriefPopUp(thisVar, owner) {

    var bodyRect = document.body.getBoundingClientRect(),
        elemRect = thisVar.getBoundingClientRect(),
        offset2 = elemRect.left - bodyRect.left,
        offset   = elemRect.top - bodyRect.top;

    if(offset < 0)
        offset = Math.abs(offset);

    $(".img_popUp").css("left", offset2 - 450);
    $(".img_popUp").css("top", offset);
    showDetails(owner);
}