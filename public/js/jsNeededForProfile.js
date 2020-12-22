function showElement(id) {
    $(".item").addClass('hidden');
    $("#" + id).removeClass('hidden');
}

function hideElement(id) {
    $("#" + id).addClass('hidden');
}

function showElement2(id) {
    $("#" + id).show();
}

function hideElement2(id) {
    $("#" + id).hide();
}

var tripStyles = [];

function toggleTripStyles(id) {
    for(i = 0; i < tripStyles.length; i++) {
        if(tripStyles[i] == id) {
            $("#tripStyle_" + id).removeClass('activeTripStyle');
            tripStyles.splice(i, 1);
            if(tripStyles.length < 3)
                $("#submitBtnTripStyle").attr("disabled", true);
            return;
        }
    }

    tripStyles[tripStyles.length] = id;
    $("#tripStyle_" + id).addClass('activeTripStyle');

    if(tripStyles.length >= 3)
        $("#submitBtnTripStyle").attr("disabled", false);
}

function closeTripStyles(element) {

    for(i = 0; i < tripStyles.length; i++) {
        $("#tripStylePic_" + tripStyles[i]).css("visibility", "hidden");
    }
    $('.dark').hide();
    hideElement(element);
}

function sendAjaxRequestToGiveActivity(activityId, uId, kindPlaceId, menuId, contentId, page, limit) {

    $(".headerActivity").css('color', '#16174f');
    $("#headerActivity_" + activityId).css('color', 'var(--koochita-light-green)');

    $("#" + menuId).empty();
    $("#" + contentId).empty();

    $.ajax({
        type: 'post',
        url: getActivitiesNumPath,
        data: {
            activityId: activityId,
            uId: uId
        },
        success: function (response2) {

            response2 = JSON.parse(response2);

            element = "<p>فیلترها :</p>";
            element += "<ul>";
            element += "<li class='subHeaderActivity' id='subHeaderActivity_-1' onclick='sendAjaxRequestToGiveActivity(" + activityId + "," + uId + ", -1, \"myActivities\", \"myActivitiesContent\", " + 1 + ", " + limit + ")'>همه</li>";

            for(i = 0; i < response2.length; i++) {
                element += "<li class='subHeaderActivity' id='subHeaderActivity_" + response2[i].placeId + "' onclick='sendAjaxRequestToGiveActivity(" + activityId + "," + uId + ", " + response2[i].placeId + ", \"myActivities\", \"myActivitiesContent\", " + 1 + ", " + limit + ")'>";
                element += "<span>" + response2[i].placeName  + "</span><span> ( </span>" + response2[i].nums + "<span> ) </span>";
                element += "</li>";
            }

            element += "</ul>";
            $("#" + menuId).append(element);
            $(".subHeaderActivity").css('color', '#16174f');

            $("#subHeaderActivity_" + kindPlaceId).css('color', 'var(--koochita-light-green)');

        }
    });

    $.ajax({
        type: 'post',
        url: getActivitiesPath,
        data: {
            activityId : activityId,
            uId : uId,
            kindPlaceId : kindPlaceId,
            page : page
        },
        success: function (response) {

            if(response == "empty") {
                return;
            }

            response = JSON.parse(response);

            for(i = 0; i < response.length; i++) {

                element2 = "<div class='cs-header-ratings'>";
                element2 += "<div class='cs-colheader-images'>عکس</div>";
                element2 += "<div class='cs-colheader-date'>تاریخ</div>";
                element2 += "<div class='cs-colheader-location'>نام</div>";
                element2 += "<div class='cs-colheader-points'>خلاصه</div>";
                element2 += "<div class='cs-colheader-rating'>امتیاز</div>";
                element2 += "</div><ul><li class='cs-rating'>";
                element2 += "<div class='cs-rating-thumb' style='z-index: 100'><a href='" + response[i].placeRedirect + "'><img src='" + response[i].placePic + "'></a></div>";
                element2 += "<center class='cs-rating-date'>" + response[i].date + "</center>";
                element2 += "<div class='cs-rating-geo'>" + response[i].visitorId + "</div>";

                element2 += "<center>";
                if(response[i].pic != "")
                    element2 += "<div class='cs-rating-location'><a><img style='width: 100%; vertical-align: middle' src='"  + response[i].pic + "'></a></div>";
                else
                    element2 += "<div class='cs-rating-location' style='text-align: center'><a>"  + response[i].text + "</a></div>";
                element2 += "</center>";

                if(response[i].point != -1) {
                    element2 += "<div class='cs-rating'>";
                    if(response[i].point == 5)
                        element2 += "<span class='ui_bubble_rating bubble_5'></span>";
                    else if(response[i].point == 4)
                        element2 += "<span class='ui_bubble_rating bubble_4'></span>";
                    else if(response[i].point == 3)
                        element2 += "<span class='ui_bubble_rating bubble_3'></span>";
                    else if(response[i].point == 2)
                        element2 += "<span class='ui_bubble_rating bubble_2'></span>";
                    else
                        element2 += "<span class='ui_bubble_rating bubble_1'></span>";

                    element2 += "</div>";
                }
                else
                    element2 += "<div class='cs-rating'></div>";

                element2 += "<div class='cs-rating-divider'></div>";
                element2 += "</li></ul>";
                $("#" + contentId).append(element2);
            }

            element2 = "<div class='cs-pagination-bar'>";
            if(page > 1)
                element2 += "<button onclick='sendAjaxRequestToGiveActivity(" + activityId + "," + uId + ", " + kindPlaceId + ", \"myActivities\", \"myActivitiesContent\", " + (page - 1) + ", " + limit + ")' id='cs-paginate-previous'>قبلی</button>";
            if(page < Math.ceil(limit / 5))
                element2 += "<button onclick='sendAjaxRequestToGiveActivity(" + activityId + "," + uId + ", " + kindPlaceId + ", \"myActivities\", \"myActivitiesContent\", " + (page + 1) + ", " + limit + ")' id='cs-paginate-next'>بعدی</button>";

            element2 += "<div class='cs-pagination-bar-inner' style='direction: ltr'>";

            for(i = 1; i <= Math.ceil(limit / 5); i++) {
                if(i == page)
                    element2 += "<button style='cursor: pointer; color: black' onclick='sendAjaxRequestToGiveActivity(" + activityId + "," + uId + ", " + kindPlaceId + ", \"myActivities\", \"myActivitiesContent\", " + i + ", " + limit + ")' class='cs-paginate-goto active'>" + i + "</button>";
                else
                    element2 += "<button style='cursor: pointer' onclick='sendAjaxRequestToGiveActivity(" + activityId + "," + uId + ", " + kindPlaceId + ", \"myActivities\", \"myActivitiesContent\", " + i + ", " + limit + ")' class='cs-paginate-goto active'>" + i + "</button>";
            }

            element2 += "</div></div>";
            $("#" + contentId).append(element2);
        }
    });

}

function sendAjaxRequestToGiveTripStyles(uId, containerId) {

    $('.dark').show();
    tripStyles = [];
    $("#" + containerId).empty();

    $.ajax({
        type: 'post',
        url: 'getTripStyles',
        data: {
            uId: uId
        },
        success: function (response) {

            response = JSON.parse(response);

            for (i = 0; i < response.length; i++) {

                element = "<div class='tagContainer'>";
                element += "<input class='tagSelection' name='memberTag' value='" + response[i].id + "' type='checkbox'>";
                if (response[i].selected) {
                    element += "<label id='tripStyle_" + response[i].id + "' class='tag tagBubble activeTripStyle' onclick='toggleTripStyles(" + response[i].id + ")'>";
                    element += "<div class='tagText'  style='padding-left: 12px; padding-right: 12px'>" + response[i].name + "</div>";
                    tripStyles[tripStyles.length] = response[i].id;
                }
                else {
                    element += "<label id='tripStyle_" + response[i].id + "' class='tag tagBubble' onclick='toggleTripStyles(" + response[i].id + ")'>";

                    element += "<div class='tagText' style='padding-left: 12px; padding-right: 12px'>" + response[i].name + "</div>";
                }
                element += "</label>";
                element += "</div>";

                $("#" + containerId).append(element);
            }


            if (tripStyles.length >= 3) {
                $("#submitBtnTripStyle").removeAttr("disabled");
            }

        }
    });
}

function updateMyTripStyle(uId, element) {

    $.ajax({
        type: 'post',
        url: 'updateTripStyles',
        data: {
            uId: uId,
            tripStyles : tripStyles
        },
        success: function (response) {
            response = JSON.parse(response);
            if(response['status'] == 'ok'){
                text = '';
                for(var i = 0; i < response['tripStyles'].length; i++) {
                    text += '<div class="tagContainer">\n' +
                        '<label id="tripStyle_12" class="tag tagBubble activeTripStyle">\n' +
                        '<div class="tagText tagTextBodyPlace" style="color: white">' + response["tripStyles"][i]["name"] + '</div>\n' +
                        '</label>\n' +
                        '</div>';
                }

                $('#myTripStyles').html(text);
            }
            closeTripStyles(element);
        }
    });
}

function sendCode() {

    if($("#phoneNum").val() == "")
        return;

    $.ajax({
        type: 'post',
        url: sendMyInvitationCode,
        data: {
            'phoneNum': $("#phoneNum").val()
        },
        success: function (response) {

            $("#msgContainer").removeClass('hidden');

            if(response == "ok")
                $("#sendMsg").empty().append("کد معرف شما به شماره مورد نظر ارسال شد");
            else
                $("#sendMsg").empty().append("از آخرین ارسال شما باید حداقل پنج دقیقه بگذرد");

            $("#sendMsg").removeClass('hidden');
        }
    });

}