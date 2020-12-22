var total;
var filters = [];
var hasFilter = false;
var topContainer;
var marginTop;
var helpWidth;
var greenBackLimit = 5;
var pageHeightSize = window.innerHeight;
var additional = [];
var indexes = [];
var selectedPlaceId = -1;
var selectedKindPlaceId = -1;
var currPage = 1;
var currPageQuestions = 1;
var selectedTag = "";
var roundRobinPhoto;
var roundRobinPhoto2;
var selectedTrips;
var currHelpNo;
var noAns = false;
var photos = [];
var photos2 = [];
// left: 37, up: 38, right: 39, down: 40,
// spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36
var keys = {37: 1, 38: 1, 39: 1, 40: 1};


// $(".nextBtnsHelp").click(function () {
//     show(parseInt($(this).attr('data-val')) + 1, 1);
// });
// $(".backBtnsHelp").click(function () {
//     show(parseInt($(this).attr('data-val')) - 1, -1);
// });
// $(".exitBtnHelp").click(function () {
//     myQuit();
// });

$(window).ready(function () {
    // checkOverFlow();
    // $('.menu').addClass('original').clone().insertAfter('.menu').addClass('cloned').css('position', 'fixed').css('top', '0').css('margin-top', '0').css('z-index', '500').removeClass('original').hide();
    // // scrollIntervalID = setInterval(stickIt, 10);
    // $(".close_album").click(function () {
    //     $("#photo_album_span").hide();
    // });
    // var i;
    // // photos[0] = '{{$photos[0]}}';
    // for (i = 1; i < totalPhotos; i++)
    //     photos[i] = -1;
    // for (i = 1; i < totalPhotos - sitePhotosCount; i++)
    //     photos2[i] = -1;
    // currPage = 1;
    // comments(-1);
    // // questions();
    // roundRobinPhoto = -1;
    // photoRoundRobin(1);
    // if (totalPhotos - sitePhotosCount > 0) {
    //     roundRobinPhoto2 = -1;
    //     photoRoundRobin2(1);
    // }
    // $(".img_popUp").on({
    //     mouseenter: function () {
    //         $(".img_popUp").removeClass('hidden');
    //     },
    //     mouseleave: function () {
    //         $(".img_popUp").addClass('hidden');
    //     }
    // });
    // $('.ui_tagcloud').click(function () {
    //     $(".ui_tagcloud").removeClass('selected');
    //     $(this).addClass("selected");
    //     if ($(this).attr("data-content")) {
    //         var data_content = $(this).attr("data-content");
    //         currPage = 1;
    //         comments(data_content);
    //     }
    // });
});

function changeStatetounReserved() {
    document.getElementById('bestPriceRezerved').style.display = 'none';
    document.getElementById('bestPrice').style.display = 'block';
}

function changeRoomPrice(id) {
    var x = document.getElementById("extraBedPrice" + id);
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

function dotedNumber(number) {
    var i = 1;
    var num = 0;
    while (i < number) {
        i *= 10;
        num++;
    }
    var string_number = '';
    var mande = num % 3;
    string_number = Math.floor(number / (Math.pow(10, num - mande))) + '.';
    number = number % (Math.pow(10, num - mande));
    num = num - mande;
    var div = num;
    for (i = 0; i < div / 3; i++) {
        if (number != 0) {
            num -= 3;
            string_number += Math.floor(number / (Math.pow(10, num))) + '.';
            number = number % (Math.pow(10, num));
        }
        else if (i < (div / 3) - 1) {
            string_number += '000.';
        }
        else {
            string_number += '000';
        }
    }
    return string_number;
}

function inputSearch() {
    var ageOfChild = [];
    var goDate;
    var backDate;
    var childSelect = document.getElementsByName('ageOfChild');
    for (var i = 0; i < children; i++) {
        ageOfChild[i] = childSelect[i + 1].value;
    }
    goDate = document.getElementById('goDate').value;
    backDate = document.getElementById('backDate').value;
    document.getElementById('form_room').value = room;
    document.getElementById('form_adult').value = adult;
    document.getElementById('form_children').value = children;
    document.getElementById('form_goDate').value = goDate;
    document.getElementById('form_backDate').value = backDate;
    document.getElementById('form_ageOfChild').value = ageOfChild;
    document.getElementById('form_hotel').submit();
}

function editSearch() {
    changeStatetounReserved();
    window.location.href = '#bestPrice';
}

function myQuit() {
    clear();
    $(".dark").hide();
    enableScroll();
}

function setGreenBackLimit(val) {
    greenBackLimit = val;
}

function initHelp(t, sL, topC, mT, hW) {
    total = t;
    filters = sL;
    topContainer = topC;
    marginTop = mT;
    helpWidth = hW;
    if (sL.length > 0)
        hasFilter = true;
    $(".dark").show();
    show(1, 1);
}

function initHelp2(t, sL, topC, mT, hW, i, a) {
    total = t;
    filters = sL;
    topContainer = topC;
    marginTop = mT;
    helpWidth = hW;
    additional = a;
    indexes = i;
    if (sL.length > 0)
        hasFilter = true;
    $(".dark").show();
    show(1, 1);
}

function isInFilters(key) {
    key = parseInt(key);
    for (j = 0; j < filters.length; j++) {
        if (filters[j] == key)
            return true;
    }
    return false;
}

function getBack(curr) {
    for (i = curr - 1; i >= 0; i--) {
        if (!isInFilters(i))
            return i;
    }
    return -1;
}

function getFixedFromLeft(elem) {
    if (elem.prop('id') == topContainer || elem.prop('id') == 'PAGE') {
        return parseInt(elem.css('margin-left').split('px')[0]);
    }
    return elem.position().left +
        parseInt(elem.css('margin-left').split('px')[0]) +
        getFixedFromLeft(elem.parent());
}

function getFixedFromTop(elem) {
    if (elem.prop('id') == topContainer) {
        return marginTop;
    }
    if (elem.prop('id') == "PAGE") {
        return 0;
    }
    return elem.position().top +
        parseInt(elem.css('margin-top').split('px')[0]) +
        getFixedFromTop(elem.parent());
}

function getNext(curr) {
    curr = parseInt(curr);
    for (i = curr + 1; i < total; i++) {
        if (!isInFilters(i))
            return i;
    }
    return total;
}

function bubbles(curr) {
    if (total <= 1)
        return "";
    t = total - filters.length;
    newElement = "<div class='col-xs-12 position-relative'><div class='col-xs-12 bubbles pd-0 mg-rt-0' style='margin-left: " + ((400 - (t * 18)) / 2) + "px'>";
    for (i = 1; i < total; i++) {
        if (!isInFilters(i)) {
            if (i == curr)
                newElement += "<div id='notInFiltersDiv'></div>";
            else
                newElement += "<div id='isInFilterDiv' onclick='show(\"" + i + "\", 1)' class='helpBubble'></div>";
        }
    }
    newElement += "</div></div>";
    return newElement;
}

function clear() {
    $('.bubbles').remove();
    $(".targets").css({
        'position': '',
        'border': '',
        'padding': '',
        'background-color': '',
        'z-index': '',
        'cursor': '',
        'pointer-events': 'auto'
    });
    $(".helpSpans").addClass('hidden');
    $(".backBtnsHelp").attr('disabled', 'disabled');
    $(".nextBtnsHelp").attr('disabled', 'disabled');
}

function show(curr, inc) {
    clear();
    if (hasFilter) {
        while (isInFilters(curr)) {
            curr += inc;
        }
    }
    if (getBack(curr) <= 0) {
        $("#backBtnHelp_" + curr).attr('disabled', 'disabled');
    }
    else {
        $("#backBtnHelp_" + curr).removeAttr('disabled');
    }
    if (getNext(curr) > total - 1) {
        $("#nextBtnHelp_" + curr).attr('disabled', 'disabled');
    }
    else {
        $("#nextBtnHelp_" + curr).removeAttr('disabled');
    }
    if (curr < greenBackLimit) {
        $("#targetHelp_" + curr).css({
            'position': 'relative',
            'border': '5px solid #333',
            'padding': '10px',
            'background-color': 'var(--koochita-light-green)',
            'z-index': 1000001,
            'cursor': 'auto'
        });
    }
    else {
        $("#targetHelp_" + curr).css({
            'position': 'relative',
            'border': '5px solid #333',
            'padding': '10px',
            'background-color': 'white',
            'z-index': 100000001,
            'cursor': 'auto'
        });
    }
    var targetWidth = $("#targetHelp_" + curr).css('width').split('px')[0];
    var targetHeight = parseInt($("#targetHelp_" + curr).css('height').split('px')[0]);
    for (j = 0; j < indexes.length; j++) {
        if (curr == indexes[j]) {
            targetHeight += additional[j];
            break;
        }
    }
    if ($("#targetHelp_" + curr).offset().top > 200) {
        $("html, body").scrollTop($("#targetHelp_" + curr).offset().top - 100);
        $("#helpSpan_" + curr).css({
            'left': $("#targetHelp_" + curr).offset().left + targetWidth / 2 - helpWidth / 2 + "px",
            'top': targetHeight + 120 + "px"
        }).removeClass('hidden').append(bubbles(curr));
    }
    else {
        $("#helpSpan_" + curr).css({
            'left': $("#targetHelp_" + curr).offset().left + targetWidth / 2 - helpWidth / 2 + "px",
            'top': ($("#targetHelp_" + curr).offset().top + targetHeight + 20) % pageHeightSize + "px"
        }).removeClass('hidden').append(bubbles(curr));
    }
    $(".helpBubble").on({
        mouseenter: function () {
            $(this).css('background-color', '#ccc');
        },
        mouseleave: function () {
            $(this).css('background-color', '#333');
        }
    });
    disableScroll();
}

function preventDefault(e) {
    e = e || window.event;
    if (e.preventDefault)
        e.preventDefault();
    e.returnValue = false;
}

function preventDefaultForScrollKeys(e) {
    if (keys[e.keyCode]) {
        preventDefault(e);
        return false;
    }
}

function disableScroll() {
    if (window.addEventListener) // older FF
        window.addEventListener('DOMMouseScroll', preventDefault, false);
    window.onwheel = preventDefault; // modern standard
    window.onmousewheel = document.onmousewheel = preventDefault; // older browsers, IE
    window.ontouchmove = preventDefault; // mobile
    document.onkeydown = preventDefaultForScrollKeys;
}

function enableScroll() {
    if (window.removeEventListener)
        window.removeEventListener('DOMMouseScroll', preventDefault, false);
    window.onmousewheel = document.onmousewheel = null;
    window.onwheel = null;
    window.ontouchmove = null;
    document.onkeydown = null;
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
    for (i = 0; i < selectedTrips.length; i++) {
        if (selectedTrips[i] == id) {
            allow = false;
            $("#trip_" + id).css('border', '2px solid #a0a0a0');
            selectedTrips.splice(i, 1);
            break;
        }
    }
    if (allow) {
        $("#trip_" + id).css('border', '2px solid var(--koochita-light-green)');
        selectedTrips[selectedTrips.length] = id;
    }
}

function showUpdateReserveResult() {
    $(".update_results_button").removeClass('hidden');
}

function showChildBox(val, childAge) {
    var newElement = "";
    for (i = 0; i < val; i++) {
        newElement += "<span class='unified-picker age-picker'><select id='child_" + (i + 1) + "'>";
        newElement += "<option value='none'>سن</option>";
        for (j = 1; j <= childAge; j++) {
            newElement += "<option value='" + j + "'>" + j + "</option>";
        }
        newElement += "</select></span>";
    }
    $("#ages-wrap").empty().append(newElement);
}

// function changeCommentPage(element) {
//     $('.pageNumComment').removeClass('current').addClass('taLnk');
//     $(element).removeClass('taLnk');
//     $(element).addClass('current');
//     if ($(element).attr('data-page-number')) {
//         currPage = $(element).attr('data-page-number');
//         comments(selectedTag);
//         location.href = "#taplc_location_review_keyword_search_hotels_0_search";
//     }
// }

// function changePageQuestion(element) {
//     $('.pageNumComment').removeClass('current').addClass('taLnk');
//     $(element).removeClass('taLnk');
//     $(element).addClass('current');
//     if ($(element).attr('data-page-number')) {
//         currPageQuestions = $(element).attr('data-page-number');
//         // questions();
//         location.href = "#taplc_location_qa_hotels_0";
//     }
// }

function showAskQuestion() {
    if (!checkLogin())
        return;

    $(".askQuestionForm").removeClass('hidden');
    document.href = ".askQuestionForm";
}

function hideAskQuestion() {
    $(".askQuestionForm").addClass('hidden');
}

function askQuestion() {
    if (!checkLogin())
        return;
    if ($("#questionTextId").val() == "")
        return;
    $.ajax({
        type: 'post',
        url: askQuestionDir,
        data: {
            'placeId': placeId,
            'kindPlaceId': kindPlaceId,
            'text': $("#questionTextId").val()
        },
        success: function (response) {
            if (response == "ok") {
                $(".dark").css('display', '');
                $("#questionSubmitted").removeClass('hidden');
            }
        }
    });
}

function comments(tag) {
    selectedTag = tag;
    filter();
}

// function questions() {
//     $.ajax({
//         type: 'post',
//         url: getQuestions,
//         data: {
//             'placeId': placeId,
//             'kindPlaceId': kindPlaceId,
//             'page': currPageQuestions
//         },
//         success: function (response) {
//             try{
//                 showQuestions(JSON.parse(response));
//             }
//             catch{
//
//             }
//         }
//     });
// }


// function photoRoundRobin(val) {
//     if (roundRobinPhoto + val < totalPhotos && roundRobinPhoto + val >= 0)
//         roundRobinPhoto += val;
//     if (photos[roundRobinPhoto] != -1) {
//         $(".carousel_images_header").css('background', "url(" + photos[roundRobinPhoto] + ") no-repeat")
//             .css('background-size', "cover");
//     }
//     else {
//         if (roundRobinPhoto + 1 <= sitePhotosCount)
//             getSliderPhoto(1, roundRobinPhoto + 1, 1);
//         else
//             getSliderPhoto(1, roundRobinPhoto + 1 - sitePhotosCount, 2);
//     }
//     if (roundRobinPhoto + 1 >= totalPhotos)
//         $('.right-nav-header').addClass('hidden');
//     else
//         $('.right-nav-header').removeClass('hidden');
//     if (roundRobinPhoto - 1 < 0)
//         $('.left-nav-header').addClass('hidden');
//     else
//         $('.left-nav-header').removeClass('hidden');
// }

function photoRoundRobin2(val) {
    if (roundRobinPhoto2 + val < totalPhotos - sitePhotosCount && roundRobinPhoto2 + val >= 0)
        roundRobinPhoto2 += val;
    if (photos2[roundRobinPhoto2] != -1) {
        $(".carousel_images_footer").css('background', "url(" + photos2[roundRobinPhoto2] + ") no-repeat")
            .css('background-size', "cover");
    }
    else {
        getSliderPhoto(2, roundRobinPhoto2, 2);
    }
    if (roundRobinPhoto2 + 1 >= totalPhotos - sitePhotosCount)
        $('.right-nav-footer').addClass('hidden');
    else
        $('.right-nav-footer').removeClass('hidden');
    if (roundRobinPhoto2 - 1 < 0)
        $('.left-nav-footer').addClass('hidden');
    else
        $('.left-nav-footer').removeClass('hidden');
}

function startHelp() {
    setGreenBackLimit(7);
    if (checkLogin()) {
        if (noAns)
            initHelp2(16, [0, 4, 15], 'MAIN', 100, 400, [14, 15], [50, 100]);
        else
            initHelp2(16, [0, 4], 'MAIN', 100, 400, [15], [100]);
    }
    else {
        if (noAns)
            initHelp2(16, [0, 1, 2, 5, 8, 15], 'MAIN', 100, 400, [14, 15], [50, 100]);
        else
            initHelp2(16, [0, 1, 2, 5, 8], 'MAIN', 100, 400, [15], [100]);
    }
}

function showQuestions(arr) {
    $("#questionsContainer").empty();
    if (arr.length == 0) {
        noAns = true;
        $("#questionsContainer").append('<p class="no-question">با پرسیدن اولین سوال، از دوستان خود کمک بگیرید و به دیگران کمک کنید. سوال شما فقط به اندازه یک کلیک وقت می گیرد</p>');
    }

    var newElement;

    for (i = 0; i < arr.length; i++) {
        newElement = "<div class='ui_column is-12 position-relative float-right'><div class='ui_column is-2'>";
        newElement += "<div class='avatar_wrap'>";
        newElement += "<div class='prw_rup prw_common_centered_image qa_avatar' onmouseleave='$(\".img_popUp\").addClass(\"hidden\");' onmouseenter='showBriefPopUp(this, \"" + arr[i].visitorId + "\")'>";
        newElement += "<span class='imgWrap fixedAspect'>";
        newElement += "<img src='" + arr[i].visitorPic + "' class='centeredImg' height='100%'/>";
        newElement += "</span></div>";
        newElement += "<div class='username'>" + arr[i].visitorId + "</div>";
        newElement += "</div></div>";
        newElement += "<div class='ui_column is-8 position-relative'><a href='" + homeURL + "/seeAllAns/" + arr[i].id + "'>" + arr[i].text + "</a>";
        newElement += "<div class='question_date'>" + arr[i].date + "<span class='iapSep'>|</span><span id='showReportReviews2' onclick='showReportPrompt(\"" + arr[i].id + "\")' class='ui_icon'>گزارش تخلف</span></div>";
        if (i == 0) {
            newElement += "<div id='targetHelp_15' class='targets row'><span class='col-xs-12 ui_button primary small answerButton' onclick='showAnsPane(\"" + arr[i].id + "\")'>پاسخ ";
            newElement += "</span>";
            newElement += '<div id="helpSpan_15" class="helpSpans hidden">';
            newElement += '<span class="introjs-arrow"></span>';
            newElement += "<p>";
            newElement += "می توانید با این دکمه به سوال ها پاسخ دهید تا دوستا ن تان هم به سوالات شما پاسخ دهند.";
            newElement += "</p>";
            newElement += '<button data-val="15" class="btn btn-success nextBtnsHelp" id="nextBtnHelp_15">بعدی</button>';
            newElement += '<button onclick="show(14, -1)" data-val="15" class="btn btn-primary backBtnsHelp" id="backBtnHelp_15">قبلی</button>';
            newElement += '<button onclick="myQuit();" class="btn btn-danger exitBtnHelp">خروج</button>';
            newElement += '</div>';
            newElement += "</div>";
        }
        else {
            newElement += "<span class='ui_button primary small answerButton float-right' onclick='showAnsPane(\"" + arr[i].id + "\")'>پاسخ ";
            newElement += "</span>";
        }
        newElement += "<span class='showAllComments ui_button secondary small' id='showAll_" + arr[i].id + "' onclick='showAllAns(\"" + arr[i].id + "\", -1)'>نمایش " + arr[i].ansNum + " جواب</span> ";
        newElement += "<span class='ui_button secondary small hidden' id='hideAll_" + arr[i].id + "' onclick='showAllAns(\"" + arr[i].id + "\", 1)'>پنهان کردن جواب ها</span>";
        newElement += "<div class='confirmDeleteExplanation hidden'>آیا می خواهی این سوال حذف شود ؟</div>";
        newElement += "<span class='ui_button primary small delete hidden'>Delete</span>";
        newElement += "<span class='ui_button primary small confirmDelete hidden'>Confirm</span>";
        newElement += "<span class='ui_button secondary small cancelDelete hidden'>Cancel</span>";
        newElement += "<div class='answerForm hidden' id='answerForm_" + arr[i].id + "'>";
        newElement += "<div class='whatIsYourAnswer'>جواب شما چیست ؟</div>";
        newElement += "<textarea class='answerText ui_textarea' id='answerText_" + arr[i].id + "' placeholder='سلام ، جواب خود را وارد کنید'></textarea>";
        newElement += "<ul class='errors hidden'></ul>";
        newElement += "<a target='_blank' href='" + soon + "' class='postingGuidelines float-left'>راهنما  و قوانین</a>";
        newElement += "<div><span class='ui_button primary small formSubmit' onclick='sendAns(\"" + arr[i].id + "\")'>ارسال</span>";
        newElement += "<span class='ui_button secondary small' onclick='hideAnsPane()'>لغو</span></div>";
        newElement += "<div class='captcha_here'></div>";
        newElement += "</div>";
        newElement += "<div id='response_" + arr[i].id + "' class='answerList hidden clear-both'>";
        newElement += "</div><p id='ans_err_" + arr[i].id + "'></p></div></div><div class='clear-both'></div> ";
        $("#questionsContainer").append(newElement);
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

function toggleMoreCities() {
    if ($('#moreCities').hasClass('hidden')) {
        $('#moreCities').removeClass('hidden');
        $('#moreLessSpan').empty().append('شهر های کمتر');
    }
    else {
        $('#moreCities').addClass('hidden');
        $('#moreLessSpan').empty().append('شهر های بیشتر');
    }
}

function customReport() {
    if ($("#custom-checkBox").is(':checked')) {
        var newElement = "<div class='col-xs-12'>";
        newElement += "<textarea id='customDefinedReport' maxlength='1000' required placeholder='حداکثر 1000 کاراکتر'></textarea>";
        newElement += "</label></div>";
        $("#custom-define-report").empty().append(newElement).css("visibility", "visible");
    }
    else {
        $("#custom-define-report").empty().css("visibility", "hidden");
    }
}


function showAnsPane(logId) {
    $(".answerForm").addClass('hidden');
    $("#answerForm_" + logId).removeClass('hidden');
}

function hideAnsPane() {
    $(".answerForm").addClass('hidden');
}

function sendAns(logId) {
    if (!checkLogin())
        return;

    if ($("#answerText_" + logId).val() == "")
        return;
    $.ajax({
        type: 'post',
        url: sendAnsDir,
        data: {
            'placeId': placeId,
            'kindPlaceId': kindPlaceId,
            'text': $("#answerText_" + logId).val(),
            'relatedTo': logId
        },
        success: function (response) {
            if (response == "ok") {
                $(".dark").css('display', '');
                $('#ansSubmitted').removeClass('hidden');
            }
            else {
                $("#ans_err_" + logId).empty().append('تنها یکبار می توانید به هر سوال پاسخ دهید');
            }
        }
    });
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
                $("#response_" + logId).removeClass('hidden');
            }
            else {
                $("#hideAll_" + logId).addClass('hidden');
                $("#showAll_" + logId).removeClass('hidden');
                $("#response_" + logId).addClass('hidden');
            }
            response = JSON.parse(response);
            newElement = "";
            for (i = 0; i < response.length; i++) {
                newElement += "<div class='prw_rup prw_common_location_posting'>";
                newElement += "<div class='response'>";
                newElement += "<div class='header mg-rt-22percent'><span>پاسخ از " + response[i].visitorId + "</span> | ";
                newElement += "<span class='iapSep'>|</span>";
                newElement += "<span onclick='showReportPrompt(\"" + response[i].id + "\")' class='ui_icon cursor-pointer font-size-10'>گزارش تخلف</span>";
                newElement += "</div>";
                newElement += "<div class='content'>";
                newElement += "<div class='abbreviate'>" + response[i].text;
                newElement += "</div></div>";
                newElement += "<div class='confirmDeleteExplanation hidden'>آیا می خواهی این سوال حذف شود ؟</div>";
                newElement += "<span class='ui_button primary small delete hidden'>حذف</span> <span class='ui_button primary small confirmDelete hidden'>ثبت</span> <span class='ui_button secondary small cancelDelete hidden'>لغو</span>";
                newElement += "<div class='votingForm'>";
                newElement += "<div class='voteIcon' onclick='likeAns(" + response[i].id + ")'>";
                newElement += "<div class='ui_icon single-chevron-up-circle'></div>";
                newElement += "<div class='ui_icon single-chevron-up-circle-fill'></div>";
                newElement += "<div class='contents hidden'>پاسخ مفید</div>";
                newElement += "</div>";
                newElement += "<div class='voteCount'>";
                newElement += "<div class='score' data-val='" + response[i].rate + "' id='score_" + response[i].id + "'>" + response[i].rate + "</div>";
                newElement += "<div>نقد من</div>";
                newElement += "</div>";
                newElement += "<div class='voteIcon' onclick='dislikeAns(" + response[i].id + ")'>";
                newElement += "<div class='ui_icon single-chevron-down-circle-fill'></div>";
                newElement += "<div class='ui_icon single-chevron-down-circle'></div>";
                newElement += "<div class='contents hidden'>پاسخ غیر مفید</div>";
                newElement += "</div></div></div></div>";
            }
            $("#response_" + logId).empty().append(newElement);
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
            if (response == "1") {
                $("#commentLikes_" + logId).empty()
                    .attr('data-val', parseInt($("#commentLikes_" + logId).attr('data-val')) + 1)
                    .append($("#commentLikes_" + logId).attr('data-val'));
            }
            else if (response == "2") {
                $("#commentLikes_" + logId).empty()
                    .attr('data-val', parseInt($("#commentLikes_" + logId).attr('data-val')) + 1)
                    .append($("#commentLikes_" + logId).attr('data-val'));
                $("#commentDislikes_" + logId).empty()
                    .attr('data-val', parseInt($("#commentDislikes_" + logId).attr('data-val')) - 1)
                    .append($("#commentDislikes_" + logId).attr('data-val'));
            }
        }
    });
}

function likeAns(logId) {
    $.ajax({
        type: 'post',
        url: opOnComment,
        data: {
            'logId': logId,
            'mode': 'like'
        },
        success: function (response) {
            if (response == "1") {
                $("#score_" + logId).empty()
                    .attr('data-val', parseInt($("#score_" + logId).attr('data-val')) + 1)
                    .append($("#score_" + logId).attr('data-val'));
            }
            else if (response == "2") {
                $("#score_" + logId).empty()
                    .attr('data-val', parseInt($("#score_" + logId).attr('data-val')) + 2)
                    .append($("#score_" + logId).attr('data-val'));
            }
        }
    });
}

function dislikeAns(logId) {
    $.ajax({
        type: 'post',
        url: opOnComment,
        data: {
            'logId': logId,
            'mode': 'dislike'
        },
        success: function (response) {
            if (response == "1") {
                $("#score_" + logId).empty()
                    .attr('data-val', parseInt($("#score_" + logId).attr('data-val')) - 1)
                    .append($("#score_" + logId).attr('data-val'));
            }
            else if (response == "2") {
                $("#score_" + logId).empty()
                    .attr('data-val', parseInt($("#score_" + logId).attr('data-val')) - 2)
                    .append($("#score_" + logId).attr('data-val'));
            }
        }
    });
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
            if (response == "1") {
                $("#commentDislikes_" + logId).empty()
                    .attr('data-val', parseInt($("#commentDislikes_" + logId).attr('data-val')) + 1)
                    .append($("#commentDislikes_" + logId).attr('data-val'));
            }
            else if (response == "2") {
                $("#commentDislikes_" + logId).empty()
                    .attr('data-val', parseInt($("#commentDislikes_" + logId).attr('data-val')) + 1)
                    .append($("#commentDislikes_" + logId).attr('data-val'));
                $("#commentLikes_" + logId).empty()
                    .attr('data-val', parseInt($("#commentLikes_" + logId).attr('data-val')) - 1)
                    .append($("#commentLikes_" + logId).attr('data-val'));
            }
        }
    });
}

function filter() {
    var checkedValues = $("input:checkbox[name='filterComment[]']:checked").map(function () {
        return this.value;
    }).get();
    if (checkedValues.length == 0)
        checkedValues = -1;
    $.ajax({
        type: 'post',
        url: filterComments,
        data: {
            'filters': checkedValues,
            'placeId': placeId,
            'kindPlaceId': kindPlaceId,
            'tag': selectedTag,
            'page': currPage
        },
        success: function (response) {
            try {
                showComments(JSON.parse(response));
            }
            catch{

            }
        }
    });
}

function showAddPhotoPane() {
    if (!checkLogin())
        return;
    // $('.dark').show();
    showElement('photoEditor');
    getPhotoFilters();
}

function checkSendPhotoBtnAbility() {
    var checkedValues = $("input:radio[name='filter']:checked").map(function () {
        return this.value;
    }).get();
    if (checkedValues.length == 0) {
        $("#sendPhotoBtn").attr('disabled', 'disabled');
    }
    else {
        $("#sendPhotoBtn").removeAttr('disabled');
    }
}

function getPhotoFilters() {
    $.ajax({
        type: 'post',
        url: getPhotoFilter,
        data: {
            'kindPlaceId': kindPlaceId
        },
        success: function (response) {
            response = JSON.parse(response);
            newElement = "";
            for (i = 0; i < response.length; i++) {
                newElement += '<div class="ui_input_checkbox radioOption float-rightImp">';
                newElement += '<input type="radio" name="mask" value="' + response[i].id + '" id="cat_file_' + response[i].id + '">';
                newElement += '<label class="labelForCheckBox" for="cat_file_' + response[i].id + '">';
                newElement += '<span></span>&nbsp;&nbsp;';
                newElement += response[i].name + '</label>'
                newElement += '</div><div class="clear-both"></div>';
            }
            $("#photoTags").empty().append(newElement);
        }
    });
}

function showDetails(username) {
    if (username == null)
        return;
    $.ajax({
        type: 'post',
        url: showUserBriefDetail,
        data: {
            'username': username
        },
        success: function (response) {
            if (response.length == 0)
                return;
            response = JSON.parse(response);
            total = response.excellent + response.veryGood + response.average + response.bad + response.veryBad;
            total /= 100;
            var newElement = "<div class='arrow' id='arrowHotelDetails'></div>";
            newElement += "<div class='body_text'>";
            newElement += "<div class='memberOverlay simple container moRedesign'>";
            newElement += "<div class='innerContent'>";
            newElement += "<div class='memberOverlayRedesign g10n'>";
            newElement += "<a href='" + homeURL + "/profile/index/" + username + "'>";
            newElement += "<h3 class='username reviewsEnhancements'>" + username + "</h3>";
            newElement += "</a>";
            newElement += "<div class='memberreviewbadge'>";
            newElement += "<div class='badgeinfo'>";
            newElement += "سطح <span>" + response.level + "</span>";
            newElement += "</div></div>";
            newElement += "<ul class='memberdescriptionReviewEnhancements'>";
            newElement += "<li>تاریخ عضویت در سایت " + response.created + "</li>";
            newElement += "<li>از " + response.city + " در " + response.state + " </li>";
            newElement += "</ul>";
            newElement += "<ul class='countsReviewEnhancements'>";
            newElement += "<li class='countsReviewEnhancementsItem'>";
            newElement += "<span class='ui_icon pencil-paper iconReviewEnhancements'></span>";
            newElement += "<span class='badgeTextReviewEnhancements'>" + response.rates + " نقد</span>";
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
            newElement += "<span>پراکندگی نقدها</span>";
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
            $(".img_popUp").empty().append(newElement).removeClass('hidden');
        }
    });
}

function showBriefPopUp(thisVar, owner) {
    var bodyRect = document.body.getBoundingClientRect(),
        elemRect = thisVar.getBoundingClientRect(),
        offset = elemRect.top - bodyRect.top,
        offset2 = elemRect.left - bodyRect.left;
    if (offset < 0)
        offset = Math.abs(offset);
    $(".img_popUp").css("top", offset).css("left", offset2 - 450);
    showDetails(owner);
}

// function stickIt() {
//     var orgElementPos = $('.original').offset();
//     orgElementTop = orgElementPos.top;
//     if ($(window).scrollTop() >= (orgElementTop)) {
//         // scrolled past the original position; now only show the cloned, sticky element.
//         // Cloned element should always have same left position and width as original element.
//         orgElement = $('.original');
//         coordsOrgElement = orgElement.offset();
//         leftOrgElement = coordsOrgElement.left;
//         widthOrgElement = orgElement.css('width');
//         $('.cloned').addClass('my_moblie_hidden')
//             .css('left', '0%').css('top', 0).css('font-size', '13px').css('right', '0%').css('width', 'auto').show()
//             .css('visibility', 'hidden');
//     } else {
//         // not scrolled past the menu; only show the original menu.
//         $('.cloned').hide();
//         $('.original').css('visibility', 'visible');
//     }
// }

function checkOverFlow() {
    offsetHeight = $('#introductionText').prop('offsetHeight');
    scrollHeight = $('#introductionText').prop('scrollHeight');
    if (offsetHeight < scrollHeight)
        $('#showMore').removeClass('hidden');
    else {
        $('#showMore').addClass('hidden');
    }
}

function showMore() {
    scrollHeight = $('#introductionText').prop('scrollHeight');
    $('#introductionText').css('max-height', '');
    $('#showMore').empty().append('کمتر').attr('onclick', 'showLess()').css('padding-top', (scrollHeight - 12) + 'px');
}

function showLess() {
    $('#introductionText').css('max-height', '21px');
    $('#showMore').empty().append('بیشتر').attr('onclick', 'showMore()').css('padding-top', '');
}

function showMoreReview(idx) {
    $('#partial_entry_' + idx).css('max-height', '');
    $('#showMoreReview_' + idx).empty().append('کمتر').attr('onclick', 'showLessReview("' + idx + '")');
    $("#reviewPic_" + idx).removeClass('hidden');
}

function showLessReview(idx) {
    $('#partial_entry_' + idx).css('max-height', '70px');
    $('#showMoreReview_' + idx).empty().append('بیشتر').attr('onclick', 'showMoreReview(' + idx + ')');
    $("#reviewPic_" + idx).addClass('hidden');
}

function showAddReviewPageHotel(url) {
    if (!checkLogin())
        return;
    else {
        document.location.href = url;
    }
}

