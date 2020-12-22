var selectedPlaceId;
var selectedKindPlaceId;
var roundRobinPhoto = [];
var roundRobinPhoto2 = [];
var selectedTrips;
var currPage = 1;
var currPageQuestions = 1;

$(document).ready(function () {

    for(i = 0; i < photos.length; i++) {
        roundRobinPhoto[i] = 0;
        roundRobinPhoto2[i] = 0;
        photoRoundRobin(0, i);
        photoRoundRobin2(sitePhotos[i], i);
        comments(-1, i);
        questions(i);
    }

    $('.ui_tagcloud').click(function(){
        $(".ui_tagcloud").removeClass('selected');
        $(this).addClass("selected");
        if ($(this).attr("data-content")) {
            var data_content = $(this).attr("data-content");
            currPage = 1;
            comments(data_content, $(this).attr("data-val-idx"));
        }
    });
});

function toggleMoreCities(idx) {
    if($('#moreCities_' + idx).hasClass('hidden')) {
        $('#moreCities_' + idx).removeClass('hidden');
        $('#moreLessSpan_' + idx).empty().append('شهر های کمتر');
    }
    else {
        $('#moreCities_' + idx).addClass('hidden');
        $('#moreLessSpan_' + idx).empty().append('شهر های بیشتر');
    }
}

function questions(idx) {

    $.ajax({
        type: 'post',
        url: getQuestions,
        data: {
            'placeId': placeIds[idx],
            'kindPlaceId': kindPlaceIds[idx],
            'page': currPageQuestions
        },
        success: function (response) {
            showQuestions(JSON.parse(response), idx);
        }
    });
}

function showQuestions(arr, idx) {

    $("#questionsContainer_" + idx).empty();

    if(arr.length == 0) {
        $("#questionsContainer_" + idx).append('<p class="no-question">با پرسیدن اولین سوال، از دوستان خود کمک بگیرید و به دیگران کمک کنید. سوال شما فقط به اندازه یک کلیک وقت می گیرد</p>');
    }

    for(i = 0; i < arr.length; i++) {
        newElement = "<div class='ui_column is-12'><div class='ui_column is-2' style='float: right;'>";
        newElement += "<div class='avatar_wrap'>";
        newElement += "<DIV class='prw_rup prw_common_centered_image qa_avatar' onmouseleave='$(\".img_popUp\").addClass(\"hidden\");' onmouseenter='showBriefPopUp(this, \"" + arr[i].visitorId + "\")'>";
        newElement += "<span class='imgWrap fixedAspect' style='max-width:80px; padding-bottom:100.000%'>";
        newElement += "<img src='" + arr[i].visitorPic + "' class='centeredImg' height='100%'/>";
        newElement += "</span></DIV>";
        newElement += "<div class='username'>" + arr[i].visitorId + "</div>";
        newElement += "</div></div>";
        newElement += "<div class='ui_column is-8'><a href='" + homeURL + "/seeAllAns/" + arr[i].id + "'>" + arr[i].text + "</a>";
        newElement += "<div class='question_date'>" + arr[i].date + "</div>";
        newElement += "<span class='ui_button secondary small' id='showAll_" + arr[i].id + "' onclick='showAllAns(\"" + arr[i].id + "\", -1)'>نمایش " + arr[i].ansNum + " جواب</span> ";
        newElement += "<span class='ui_button secondary small hidden' id='hideAll_" + arr[i].id + "' onclick='showAllAns(\"" + arr[i].id + "\", 1)'>پنهان کردن جواب ها</span>";
        newElement += "<div id='response_" + arr[i].id + "' class='answerList'>";
        newElement += "</div></div></div><div style='clear: both;'></div> ";
        $("#questionsContainer_" + idx).append(newElement);

        showAllAns(arr[i].id, 1);
    }

    $("#pageNumQuestionContainer").empty();

    // newElement = "";
    // limit = Math.ceil(response[0] / 6);
    // preCurr = passCurr = false;
    //
    // for(k = 1; k <= limit; k++) {
    //     if(Math.abs(currPageQuestions - k) < 4 || k == 1 || k == limit) {
    //         if (k == currPageQuestions) {
    //             newElement += "<span data-page-number='" + k + "' class='pageNum current pageNumQuestion'>" + k + "</span>";
    //         }
    //         else {
    //             newElement += "<a onclick='changePageQuestion(this)' data-page-number='" + k + "' class='pageNum taLnk pageNumQuestion'>" + k + "</a>";
    //         }
    //     }
    //     else if(k < currPage && !preCurr) {
    //         preCurr = true;
    //         newElement += "<span class='separator'>&hellip;</span>";
    //     }
    //     else if(k > currPage && !passCurr) {
    //         passCurr = true;
    //         newElement += "<span class='separator'>&hellip;</span>";
    //     }
    // }
    //
    // $("#pageNumQuestionContainer").append(newElement);
}

function showAllAns(logId, num) {

    $.ajax({
        type: 'post',
        url: showAllAnsDir,
        data: {
            'logId': logId,
            'num': num
        },
        success: function (response) {

            if (num == -1) {
                $("#hideAll_" + logId).removeClass('hidden');
                $("#showAll_" + logId).addClass('hidden');
            }
            else {
                $("#hideAll_" + logId).addClass('hidden');
                $("#showAll_" + logId).removeClass('hidden');
            }

            response = JSON.parse(response);

            newElement = "";
            $("#response_" + logId).empty();


            for(i = 0; i < response.length; i++) {
                newElement += "<DIV class='prw_rup prw_common_location_posting'>";
                newElement += "<div class='response'>";
                newElement += "<div class='header'><span>پاسخ از " + response[i].visitorId +"</span>";
                newElement += "</div>";
                newElement += "<div class='content'>";
                newElement += "<div class='abbreviate'>" + response[i].text;
                newElement += "</div></div>";
                newElement += "</div></DIV>";
            }

            $("#response_" + logId).append(newElement);
        }
    });
}

function comments(tag, idx) {
    selectedTag = tag;
    filter(idx);
}

function changeCommentPage(element) {

    $('.pageNumComment').removeClass('current');
    $('.pageNumComment').addClass('taLnk');
    $(element).removeClass('taLnk');
    $(element).addClass('current');

    if($(element).attr('data-page-number')) {
        currPage = $(element).attr('data-page-number');
        comments(selectedTag);
        location.href = "#taplc_location_review_keyword_search_hotels_0_search";
    }
}

function filter(idx) {

    var checkedValues = $("input:checkbox[name='filterComment_" + idx + "[]']:checked").map(function() {
        return this.value;
    }).get();

    if(checkedValues.length == 0)
        checkedValues = -1;

    $.ajax({
        type: 'post',
        url: filterComments,
        data: {
            'filters': checkedValues,
            'placeId': placeIds[idx],
            'kindPlaceId': kindPlaceIds[idx],
            'tag': selectedTag,
            'page': currPage
        },
        success: function (response) {
            showComments(JSON.parse(response), idx);
        }
    });

}

function showElement(element) {
    $(".pop-up").addClass('hidden');
    $("#" + element).removeClass('hidden');
}

function hideElement(element) {
    $(".dark").hide();
    $("#" + element).addClass('hidden');
}

function addToSelectedTrips(id) {

    allow = true;

    for(i = 0; i < selectedTrips.length; i++) {
        if(selectedTrips[i] == id) {
            allow = false;
            $("#trip_" + id).css('border', '2px solid #a0a0a0');
            selectedTrips.splice(i, 1);
            break;
        }
    }

    if(allow) {
        $("#trip_" + id).css('border', '2px solid var(--koochita-light-green)');
        selectedTrips[selectedTrips.length] = id;
    }
}

function saveToTripWithIdx(placeId, kindPlaceId) {

    if(!hasLogin) {
        return;
    }
    
    selectedPlaceId = placeId;
    selectedKindPlaceId = kindPlaceId;

    $.ajax({
        type: 'post',
        url: getPlaceTrips,
        data: {
            'placeId': placeId,
            'kindPlaceId': kindPlaceId
        },
        success: function (response) {

            selectedTrips = [];
            $("#tripsForPlace").empty();
            $('.dark').show();

            response = JSON.parse(response);
            newElement = "<div class='row'>";

            for(i = 0; i < response.length; i++) {

                newElement += "<div class='col-xs-3' style='cursor: pointer' onclick='addToSelectedTrips(\"" + response[i].id + "\")'>";

                if(response[i].select == "1") {
                    newElement += "<div id='trip_" + response[i].id + "' style='width: 150px; height: 150px; border: 2px solid var(--koochita-light-green);cursor: pointer;' onclick='' class='trip-images ui_columns is-gapless is-multiline is-mobile'>";
                    selectedTrips[selectedTrips.length] = response[i].id;
                }
                else
                    newElement += "<div id='trip_" + response[i].id + "' style='width: 150px; height: 150px; border: 2px solid #a0a0a0;cursor: pointer;' onclick='' class='trip-images ui_columns is-gapless is-multiline is-mobile'>";

                if(response[i].placeCount > 0)
                    newElement += "<div class='trip-image ui_column is-6' style='background: url(\"" + response[i].pic1 + "\") repeat 0 0; background-size: 100% 100%'></div>";
                else
                    newElement += "<div class='trip-image trip-image-empty ui_column is-6' style='background-color: #cfcfcf'></div>";

                if(response[i].placeCount > 1)
                    newElement += "<div class='trip-image ui_column is-6' style='background: url(\"" + response[i].pic2 + "\") repeat 0 0; background-size: 100% 100%'></div>";
                else
                    newElement += "<div class='trip-image trip-image-empty ui_column is-6' style='background-color: #cfcfcf'></div>";

                if(response[i].placeCount > 1)
                    newElement += "<div class='trip-image ui_column is-6' style='background: url(\"" + response[i].pic3 + "\") repeat 0 0; background-size: 100% 100%'></div>";
                else
                    newElement += "<div class='trip-image trip-image-empty ui_column is-6' style='background-color: #cfcfcf'></div>";

                if(response[i].placeCount > 1)
                    newElement += "<div class='trip-image ui_column is-6' style='background: url(\"" + response[i].pic4 + "\") repeat 0 0; background-size: 100% 100%'></div>";
                else
                    newElement += "<div class='trip-image trip-image-empty ui_column is-6' style='background-color: #cfcfcf'></div>";

                newElement += "</div><div class='create-trip-text' style='font-size: 1.2em;'>" + response[i].name + "</div>";
                newElement += "</div>";
            }

            newElement += "<div class='col-xs-3'>";
            newElement += "<a onclick='showPopUp()' class='single-tile is-create-trip'>";
            newElement += "<div class='tile-content' style='font-size: 20px !important; text-align: center'>";
            newElement += "<span class='ui_icon plus' style='content: \"\e02f\";></span>";
            newElement += "<div class='create-trip-text'>ایجاد سفر</div>";
            newElement += "</div></a></div>";
            newElement += "</div>";

            $("#tripsForPlace").append(newElement);
            showElement('addPlaceToTripPrompt');

        }
    });
}

function bookMark(placeId, kindPlaceId) {

    if(!hasLogin)
        return;

    $.ajax({
        type: 'post',
        url: bookMarkDir,
        data: {
            'placeId': placeId,
            'kindPlaceId': kindPlaceId
        },
        success:function (response) {
            if(response == "ok")
                document.location.href = currentURL;
        }
    })
}

function assignPlaceToTrip() {

    if(selectedPlaceId != -1) {
        
        var checkedValuesTrips = selectedTrips;

        if(checkedValuesTrips == null || checkedValuesTrips.length == 0)
            checkedValuesTrips = "empty";

        $.ajax({
            type: 'post',
            url: assignPlaceToTripDir,
            data: {
                'checkedValuesTrips': checkedValuesTrips,
                'placeId': selectedPlaceId,
                'kindPlaceId': selectedKindPlaceId
            },
            success: function (response) {
                if (response == "ok")
                    document.location.href = currentURL;
                else {
                    err = "<p>به جز سفر های زیر که اجازه ی افزودن مکان به آنها را نداشتید بقیه به درستی اضافه شدند</p>";

                    response = JSON.parse(response);

                    for(i = 0; i < response.length; i++)
                        err += "<p>" + response[i] + "</p>";

                    $("#errorAssignPlace").append(err);

                }
            }

        });
    }
}

function photoRoundRobin(val, idx) {

    if(roundRobinPhoto[idx] + val < photos[idx].length && roundRobinPhoto[idx] + val >= 0)
        roundRobinPhoto[idx] += val;

    $("#carousel_images_header_" + idx).css('background', "url(" + photos[idx][roundRobinPhoto[idx]] + ") no-repeat")
        .css('background-size', "cover").css('background-position', 'center');

    if(roundRobinPhoto[idx] + 1 >= photos[idx].length)
        $('#right-nav-header_' + idx).addClass('hidden');
    else
        $('#right-nav-header_' + idx).removeClass('hidden');

    if(roundRobinPhoto[idx] - 1 < 0)
        $('#left-nav-header_' + idx).addClass('hidden');
    else
        $('#left-nav-header_' + idx).removeClass('hidden');
}

function photoRoundRobin2(val, idx) {

    if(roundRobinPhoto2[idx] + val < photos[idx].length && roundRobinPhoto2[idx] + val >= sitePhotos[idx])
        roundRobinPhoto2[idx] += val;

    $("#carousel-images-footer_" + idx).css('background', "url(" + photos[idx][roundRobinPhoto2[idx]] + ") no-repeat").css('background-size', "cover");

    if(roundRobinPhoto2[idx] + 1 >= photos[idx].length)
        $('#right-nav-footer_' + idx).addClass('hidden');
    else
        $('#right-nav-footer_' + idx).removeClass('hidden');

    if(roundRobinPhoto2[idx] - 1 < sitePhotos[idx])
        $('#left-nav-footer_' + idx).addClass('hidden');
    else
        $('#left-nav-footer_' + idx).removeClass('hidden');
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

function getPhotos(picItemId, placeId, kindPlaceId) {

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

            newElement = "";
            $(".inHeroList").empty();
            sliderPics = [];
            sitesPhoto = 0;

            for(i = 0; i < response.length; i++) {

                if(response[i].filter == -1)
                    sitesPhoto++;

                newElement += "<div class='tinyThumb filter_" + response[i].filter + "' id='tinyThumb_" + i + "' data-val='" + i + "' onclick='setMainPic($(this).attr(\"data-val\"))'><img style='cursor:pointer' src='" + response[i].pic + "' width='50' height='50'></div>";
                sliderPics[i] = [response[i].filter, response[i].pic, response[i].owner, response[i].ownerPic];
            }

            SliderFilter = sliderPics;

            $(".inHeroList").append(newElement);

            $(".tabCount3").empty();

            newElement = "<li class='ab101 ab_all'>";
            newElement += "<span onclick='removeFilterSlideBar()' class='tabText'>همه (" + response.length + ")</span>";
            newElement += "</li>";

            newElement += "<li class='ab101 ab_-1'>";
            newElement += "<span onclick='filterSlideBar(-1)' style='direction: rtl' class='tabText'>سایت (" + sitesPhoto + ")</span>";
            newElement += "</li>";

            for(i = 0; i < filters.length; i++) {
                if(picItemId == 0 && i == 0)
                    defaultSlideBarPic = filters[i].id;
                newElement += "<li class='ab101 ab_" + filters[i].id + "'>";
                newElement += "<span onclick='filterSlideBar(" + filters[i].id + ")' class='tabText' style='direction: rtl'>" + filters[i].name + "(" + filters[i].countNum + ")</span>";
                newElement += "</li>";
            }

            $(".tabCount3").append(newElement);
            $("#photo_album_span").show();
            filterSlideBar(picItemId);
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

    newElement = "<div class='member_info'>";
    newElement += "<div class='memberOverlayLink'>";

    if(SliderFilter[idxSlideBar][0] != -1)
        newElement += "<div class='avatar' onmouseleave='$(\".img_popUp\").addClass(\"hidden\");' onmouseenter='showBriefPopUp(this, \"" + owner + "\")' style='float: right !important; padding: 0 !important; border: none !important'>";
    else
        newElement += "<div class='avatar' style='float: right !important; padding: 0 !important; border: none !important'>";
    newElement += "<img width='74' class='avatar' height='74' src='" + ownerPic + "'/>";
    newElement += "</div>";
    newElement += "<div class='username mo'></div></div>";
    newElement += "<div class='location'>" + owner + "</div>";
    newElement += "</div>";
    $(".captionProvider").append(newElement);

}

function filterSlideBar(id) {

    if(id == 0)
        id = defaultSlideBarPic;

    $(".ab101").removeClass('current');
    $(".ab_" + id).addClass('current');
    $(".tinyThumb").addClass('hidden');
    $(".filter_" + id).removeClass('hidden');

    SliderFilter = [];
    idxSlideBar = 0;

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
    $(".ab101").removeClass('current');
    $(".ab_all").addClass('current');
    $(".tinyThumb").removeClass('hidden');

    idxSlideBar = 0;
    SliderFilter = sliderPics;

    for(i = 0; i < sliderPics.length; i++) {
        $("#tinyThumb_" + i).attr('data-val', i);
    }

    if(sliderPics.length > 0)
        setMainPic(0);
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
            newElement += "<h3 class='username reviewsEnhancements'>" + username + "</h3>";
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
            $(".img_popUp").removeClass('hidden');
        }
    });

}

function showBriefPopUp(thisVar, owner) {

    var bodyRect = document.body.getBoundingClientRect(),
        elemRect = thisVar.getBoundingClientRect(),
        offset   = elemRect.top - bodyRect.top,
        offset2 = elemRect.left - bodyRect.left;

    if(offset < 0)
        offset = Math.abs(offset);

    $(".img_popUp").css("top", offset);
    $(".img_popUp").css("left", offset2 - 450);
    showDetails(owner);
}

function showComments(arr, idx) {

    $("#reviewsContainer_" + idx).empty();

    var checkedValues = $("input:checkbox[name='filterComment_" + idx + "[]']:checked").map(function() {
        return this.value;
    }).get();

    if(checkedValues.length == 0)
        checkedValues = -1;

    $.ajax({
        type: 'post',
        url: getCommentsCount,
        data: {
            'placeId': placeIds[idx],
            'kindPlaceId': kindPlaceIds[idx],
            'tag': selectedTag,
            'filters': checkedValues

        },
        success: function (response) {

            response = JSON.parse(response);

            $(".seeAllReviews").empty();
            $(".seeAllReviews").append(response[1] + " نظر");
            $(".reviews_header_count").empty();
            $(".reviews_header_count").append("(" + response[1] + " نظر)");

            newElement = "<p id='pagination-details_" + idx + "' class='pagination-details'><b>" + response[0] + "</b> از <b>" + response[1] + "</b> نقد</p>";

            for(i = 0; i < arr.length; i++) {
                newElement += "<div style='border-bottom: 1px solid #E3E3E3; max-height: 200px; overflow: hidden' class='review'>";
                newElement += "<DIV class='prw_rup prw_reviews_basic_review_hsx'>";
                newElement += "<div class='reviewSelector'>";
                newElement += "<div class='review hsx_review ui_columns is-multiline inlineReviewUpdate provider0'>";

                newElement += "<div class='ui_column is-2' style='float: right;'>";
                newElement += "<DIV class='prw_rup prw_reviews_member_info_hsx'>";
                newElement += "<div class='member_info'>";

                newElement += "<div class='avatar_wrap'>";
                newElement += "<DIV class='prw_rup prw_common_centered_image qa_avatar' onmouseleave='$(\".img_popUp\").addClass(\"hidden\");' onmouseenter='showBriefPopUp(this, \"" + arr[i].visitorId + "\")'>";
                newElement += "<span class='imgWrap fixedAspect' style='max-width:80px; padding-bottom:100.000%'>";
                newElement += "<img src='" + arr[i].visitorPic + "' class='centeredImg' height='100%' style='border-radius: 100%;'/>";
                newElement += "</span></DIV>";
                newElement += "<div class='username' style='text-align: center;margin-top: 5px;'>" + arr[i].visitorId + "</div>";
                newElement += "</div>";

                newElement += "<div class='memberOverlayLink'>";
                newElement += "<div class='memberBadgingNoText'><span class='ui_icon pencil-paper'></span><span class='badgetext'>" + arr[i].comments + "</span>&nbsp;&nbsp;";
                newElement += "</div>";
                newElement += "</div></div></DIV></div>";
                newElement += "<div class='ui_column is-9' style='float: right;'>";
                newElement += "<div class='innerBubble'>";
                newElement += "<div class='wrap'>";
                newElement += "<div class='rating reviewItemInline'>";
                switch (arr[i].rate) {
                    case 5:
                        newElement += "<span class='ui_bubble_rating bubble_50'></span>";
                        break;
                    case 4:
                        newElement += "<span class='ui_bubble_rating bubble_40'></span>";
                        break;
                    case 3:
                        newElement += "<span class='ui_bubble_rating bubble_30'></span>";
                        break;
                    case 2:
                        newElement += "<span class='ui_bubble_rating bubble_20'></span>";
                        break;
                    default:
                        newElement += "<span class='ui_bubble_rating bubble_10'></span>";
                        break;
                }
                newElement += "<span class='ratingDate relativeDate' style='float: right;'>نوشته شده در تاریخ " + arr[i].date + " </span></div>";
                newElement += "<div class='quote isNew'><a href='" + homeURL + "/showReview/" + arr[i].id + "'><span class='noQuotes'>" + arr[i].subject + "</span></a></div>";
                newElement += "<DIV class='prw_rup prw_reviews_text_summary_hsx'>";
                newElement += "<div>";
                newElement += "<div><p>" + arr[i].text + "</p></div>";
                newElement += "</div></DIV>";
                newElement += "</div>";
                newElement += "</div></div></div></div></div></DIV></div>" ;
            }

            $("#reviewsContainer_" + idx).append(newElement);

            /*
            $("#pageNumCommentContainer_" + idx).empty();

            for(i = 0; i < arr.length; i++) {
                sc = $("#partial_entry_" + arr[i].id).prop('scrollHeight');
                sc = $("#partial_entry_" + arr[i].id).prop('offsetHeight');

                if(offsetHeight < scrollHeight) {
                    $('#showMoreReview_' + arr[i].id).removeClass('hidden');
                }
                else {
                    $('#showMoreReview_' + arr[i].id).addClass('hidden');
                }
            }

            newElement = "";
            limit = Math.ceil(response[0] / 6);
            preCurr = passCurr = false;

            for(k = 1; k <= limit; k++) {
                if(Math.abs(currPage - k) < 4 || k == 1 || k == limit) {
                    if (k == currPage) {
                        newElement += "<span data-page-number='" + k + "' class='pageNum current pageNumComment'>" + k + "</span>";
                    }
                    else {
                        newElement += "<a onclick='changeCommentPage(this)' data-page-number='" + k + "' class='pageNum taLnk pageNumComment'>" + k + "</a>";
                    }
                }
                else if(k < currPage && !preCurr) {
                    preCurr = true;
                    newElement += "<span class='separator'>&hellip;</span>";
                }
                else if(k > currPage && !passCurr) {
                    passCurr = true;
                    newElement += "<span class='separator'>&hellip;</span>";
                }
            }

            $("#pageNumCommentContainer").append(newElement);

            if($("#commentCount").empty())
                $("#commentCount").append(response[1]);
            */
        }
    });
}

function showMore2(idx) {
    $('#introductionText_' + idx).css('max-height', '');
    $('#showMore_' + idx).empty().append('کمتر').attr('onclick', 'showLess2("' + idx + '")');
}

function showLess2(idx) {
    $('#introductionText_' + idx).css('max-height', '50px');
    $('#showMore_' + idx).empty().append('بیشتر').attr('onclick', 'showMore2("' + idx + '")');
}

function showMore3(idx) {
    $('#dastoor_' + idx).css('max-height', '');
    $('#showMoreDastoor_' + idx).empty().append('کمتر').attr('onclick', 'showLess3("' + idx + '")');
}

function showLess3(idx) {
    $('#dastoor_' + idx).css('max-height', '190px');
    $('#showMoreDastoor_' + idx).empty().append('بیشتر').attr('onclick', 'showMore3("' + idx + '")');
}