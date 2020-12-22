var selectedLogId;

$(document).ready(function(){

    $(".img_btn").on({
        mouseenter: function(){

            var bodyRect = document.body.getBoundingClientRect(),
                elemRect = this.getBoundingClientRect(),
                offset2 = elemRect.left - bodyRect.left,
                offset   = elemRect.top - bodyRect.top;

            if(offset < 0)
                offset = Math.abs(offset);

            $(".img_popUp").css("top", offset);
            $(".img_popUp").css("left", offset2 - 450);

            showDetails($(this).attr('data-val'));
        },
        mouseleave: function(){
            $(".img_popUp").hide();
        },
    });

    $(".img_popUp").on({
        mouseenter: function(){
            $(".img_popUp").show();
        },
        mouseleave: function(){
            $(".img_popUp").hide();
        },
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
            newElement += "<a href='#'>";
            newElement += "<h3 onclick='document.location.href = \"" + homeURL + "/profile/index/" + username + "\"' class='username reviewsEnhancements'>" + username + "</h3>";
            newElement += "</a>";
            newElement += "<div class='memberreviewbadge'>";
            newElement += "<div class='badgeinfo'>";
            newElement += "سطح <span>" + response.level + "</span>";
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
            newElement += "<span>پراکندگی نظرات</span>";
            newElement += "</div><ul>";
            newElement += "<div class='chartRowReviewEnhancements'>";
            newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>عالی</span>";
            newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
            newElement += "<span class='barReviewEnhancements'>";
            newElement += "<span class='fillReviewEnhancements' style='width:" + response.excellent / total + "%;'></span>";
            newElement += "</span></span>";
            newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.excellent + "</span>";
            newElement += "</div>";
            newElement += "<div class='chartRowReviewEnhancements'>";
            newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>خوب</span>";
            newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
            newElement += "<span class='barReviewEnhancements'>";
            newElement += "<span class='fillReviewEnhancements' style='width:" + response.veryGood / total + "%;'></span>";
            newElement += "</span></span>";
            newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.veryGood + "</span>";
            newElement += "</div>";
            newElement += "<div class='chartRowReviewEnhancements'>";
            newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>معمولی</span>";
            newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
            newElement += "<span class='barReviewEnhancements'>";
            newElement += "<span class='fillReviewEnhancements' style='width:" + response.average / total + "%;'></span>";
            newElement += "</span></span>";
            newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.average + "</span>";
            newElement += "</div>";
            newElement += "<div class='chartRowReviewEnhancements'>";
            newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>ضعیف</span>";
            newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
            newElement += "<span class='barReviewEnhancements'>";
            newElement += "<span class='fillReviewEnhancements' style='width:" + response.bad / total + "%;'></span>";
            newElement += "</span></span>";
            newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.bad + "</span>";
            newElement += "</div>";
            newElement += "<div class='chartRowReviewEnhancements'>";
            newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>خیلی بد</span>";
            newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
            newElement += "<span class='barReviewEnhancements'>";
            newElement += "<span class='fillReviewEnhancements' style='width:" + response.veryBad / total + "%;'></span>";
            newElement += "</span></span>";
            newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.veryBad + "</span>";
            newElement += "</div></ul></div></div></div></div></div></div>";

            $(".img_popUp").append(newElement);
            $(".img_popUp").show();
        }
    });

}

function likeAns(logId) {

    if(!hasLogin) {
        url = homeURL + "/seeAllAns/" + questionId + "/like/" + logId;
        showLoginPrompt(url);
        return;
    }

    $.ajax({
        type: 'post',
        url: opOnComment,
        data: {
            'logId': logId,
            'mode': 'like'
        },
        success: function (response) {
            if(response == "1") {
                $("#score_" + logId).empty();
                $("#score_" + logId).attr('data-val', parseInt($("#score_" + logId).attr('data-val')) + 1);
                $("#score_" + logId).append($("#score_" + logId).attr('data-val'));
            }
            else if(response == "2") {
                $("#score_" + logId).empty();
                $("#score_" + logId).attr('data-val', parseInt($("#score_" + logId).attr('data-val')) + 2);
                $("#score_" + logId).append($("#score_" + logId).attr('data-val'));
            }
        }
    });
}

function dislikeAns(logId) {

    if(!hasLogin) {
        url = homeURL + "/seeAllAns/" + questionId + "/dislike/" + logId;
        showLoginPrompt(url);
        return;
    }

    $.ajax({
        type: 'post',
        url: opOnComment,
        data: {
            'logId': logId,
            'mode': 'dislike'
        },
        success: function (response) {
            if(response == "1") {
                $("#score_" + logId).empty();
                $("#score_" + logId).attr('data-val', parseInt($("#score_" + logId).attr('data-val')) - 1);
                $("#score_" + logId).append($("#score_" + logId).attr('data-val'));
            }
            else if(response == "2") {
                $("#score_" + logId).empty();
                $("#score_" + logId).attr('data-val', parseInt($("#score_" + logId).attr('data-val')) - 2);
                $("#score_" + logId).append($("#score_" + logId).attr('data-val'));
            }
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

function sendAns(logId) {

    if($("#ansText").val() == "")
        return;

    if(!hasLogin) {
        url = homeURL + "/seeAllAns/" + questionId + "/sendAns/" + $("#ansText").val();
        showLoginPrompt(url);
        return;
    }

    $.ajax({
        type: 'post',
        url: sendAnsDir,
        data: {
            'text': $("#ansText").val(),
            'relatedTo': logId
        },
        success: function (response) {
            if(response == "ok")
                document.location.href = questionList;
            else if(response == "nok") {
                $("#errMsg").append('شما قبلا به این سوال پاسخ داده اید');
            }
        }
    });
}

function sendAns2(logId, ans) {

    if(ans == "")
        return;

    if(!hasLogin) {
        url = homeURL + "/seeAllAns/" + questionId + "/sendAns/" + ans;
        showLoginPrompt(url);
        return;
    }

    $.ajax({
        type: 'post',
        url: sendAnsDir,
        data: {
            'text': ans,
            'relatedTo': logId
        },
        success: function (response) {
            if(response == "ok")
                document.location.href = questionList;
            else if(response == "nok") {
                document.location.href = homeURL + "/seeAllAns/" + questionId + "/err";
            }
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
            newElement += " سایر موارد";
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
    $('.dark').hide();
}

function showReportPrompt(logId) {

    if(!hasLogin) {
        url = homeURL + "/seeAllAns/" + questionId + "/report/" + logId;
        showLoginPrompt(url);
        return;
    }

    selectedLogId = logId;
    getReports(logId);
    $('.dark').show();
    showElement('reportPane');
}