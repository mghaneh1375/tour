var selectedPlaceId = -1;
var selectedKindPlaceId = -1;
var selectedX;
var selectedY;
var selectedTripPlace;
var selectedUsername;
var currButtomInfoPlace;
var currButtomInfoKindPlace;
var oldButtonId = -1;

function showElement(element) {
    $(".pop-up").addClass('hidden');
    $(".item").addClass("hidden");
    $("#" + element).removeClass('hidden');
    $('.dark').show();
}

function hideElement() {
    $(".item").addClass('hidden');
    $('.dark').hide();
}

function searchPlace(element) {

    $.ajax({
        type: 'post',
        url: getStates,
        success: function (response) {

            $("#parameters").empty();

            response = JSON.parse(response);

            newElement = "<div class='row' style='direction: rtl'><div style='float: right;' class='col-xs-4'><select id='stateId' onchange='getCities(this.value)'>";

            newElement += "<option selected value='-1'>استان</option>";

            for(i = 0; i < response.length; i++) {
                newElement += "<option value = '" + response[i].id + "'>" + response[i].name + "</option>";
            }

            newElement += "</select></div>";

            newElement += "<div class='col-xs-4' style='float: right;'><select id='cityId'></select></div>";
            newElement += "<div class='col-xs-4'><select onchange='search()' id='placeKind'></select></div>";

            newElement += "<div class='col-xs-12' style='margin-top: 20px; border: 2px solid #CCC; border-radius: 7px;'>";
            newElement += "<input id='key' onkeyup='search()' style='border: none; margin-top: 10px;' type='text' maxlength='50' placeholder='هتل ، رستوران و اماکن'>";
            newElement += "<div id='result' class='data_holder' style='max-height: 160px; overflow: auto; margin-top: 10px;'></div>";
            newElement += "</div>";


            newElement += "</div>";

            if(response.length > 0)
                getCities(response[0].id);

            getPlaceKinds();

            $("#parameters").append(newElement);

            showElement(element);

        }
    });
}

function search() {

    key = $("#key").val();

    if(key == null || key.length < 3) {
        $("#result").empty();
        return;
    }

    cityId = $("#cityId").val();
    placeKind = $("#placeKind").val();

    if(placeKind == -1) {
        $("#result").empty().append("<p style='color: #963019'>لطفا مکان مورد نظر خود را مشخص کنید</p>");
        return;
    }

    $.ajax({
        type: 'post',
        url: searchPlaceDir,
        data: {
            "stateId": $("#stateId").val(),
            "cityId": cityId,
            "key": key,
            "placeKind": placeKind
        },
        success: function (response) {

            response = JSON.parse(response);
            $("#result").empty();
            newElement = "";

            if(response.length == 0) {
                $("#placeId").val("");
                newElement = 'موردی یافت نشد';
            }

            else {
                suggestions = response;
                currIdx = -1;

                for(i = 0; i < response.length; i++) {
                    newElement += "<div style='cursor: pointer; padding: 5px 20px; border-bottom: 1px solid #CCC' class='suggest' id='suggest_" + i + "'  onclick='addPlace(\"" + response[i].id + "\")'> " + response[i].name + "<span> - </span><span>در</span><span>&nbsp;</span>" + response[i].cityName + "<span>&nbsp;در</span>" + response[i].stateName + "<span>&nbsp;آدرس</span><span>&nbsp;</span>" + response[i].address + "</div>";
                }

                $("#result").append(newElement);
            }
        }
    });
}

function addPlace(val) {

    placeKind = $("#placeKind").val();

    $.ajax({
        type: 'post',
        url: addTripPlace,
        data: {
            "tripId": tripId,
            "placeId": val,
            "kindPlaceId": placeKind
        },
        success: function (response) {

            if(response == "ok")
                document.location.href = tripPlaces;
            else {
                $("#placePromptError").empty();
                $("#placePromptError").append('مکان مورد نظر در سفر شما موجود است');
            }
        }
    });
}

function getCities(stateId) {

    $.ajax({
        type: 'post',
        url: getCitiesDir,
        data: {
            stateId: stateId
        },
        success: function (response) {
            $("#cityId").empty();
            response = JSON.parse(response);

            newElement = "";

            if(response.length == 0)
                newElement = "نتیجه ای حاصل نشد";

            else
                newElement += "<option selected value = '-1'>شهر</option>";

            for(i = 0; i < response.length; i++) {
                newElement += "<option value='" + response[i].id + "'>" + response[i].name + "</option>";
            }

            search();
            $("#cityId").append(newElement);

        }
    });
}

function getPlaceKinds() {

    $.ajax({
        type: 'post',
        url: getPlaceKindsDir,
        success: function (response) {
            $("#placeKind").empty();
            response = JSON.parse(response);

            newElement = "";
            newElement += "<option selected value = '-1'>مکان مورد نظر</option>";
            for(i = 0; i < response.length; i++) {
                newElement += "<option value='" + response[i].id + "'>" + response[i].name + "</option>";
            }

            $("#placeKind").append(newElement);

        }
    });
}

function changeClearCheckBox(from, to) {

    val = $("#clearDateId").is(":checked");

    if(val == true) {
        $("#date_input_start_edit").val("");
        $("#date_input_end_edit").val("");
    }
    else {
        $("#date_input_start_edit").val(from);
        $("#date_input_end_edit").val(to);
    }

    val = $("#clearDateId_2").is(":checked");

    if(val == true) {
        $("#date_input_start_edit_2").val("");
        $("#date_input_end_edit_2").val("");
    }
    else {
        $("#date_input_start_edit_2").val(from);
        $("#date_input_end_edit_2").val(to);
    }
}

function checkBtnDisable() {

    if($("#tripNameEdit").val() == "")
        $("#editBtn").addClass("disabled");
    else
        $("#editBtn").removeClass("disabled");
}

function showEditTrip(from, to) {

    $("#date_input_start_edit").datepicker({
        numberOfMonths: 2,
        showButtonPanel: true,
        minDate: 0,
        dateFormat: "yy/mm/dd"
    });
    $("#date_input_end_edit").datepicker({
        numberOfMonths: 2,
        showButtonPanel: true,
        minDate: 0,
        dateFormat: "yy/mm/dd"
    });

    $("#date_input_start_edit").val(from);
    $("#date_input_end_edit").val(to);
    $("#error").empty();
    showElement('editTripPrompt');
}

function editTrip() {

    date_input_start = $("#date_input_start_edit").val();
    date_input_end = $("#date_input_end_edit").val();
    tripName = $("#tripNameEdit").val();

    if(tripName != "" && date_input_start != "" && date_input_start != "") {

        if(date_input_start > date_input_end) {
            $("#error").empty();
            newElement = "<p style='color: red'>تاریخ پایان از تاریخ شروع باید بزرگ تر باشد</p>";
            $("#error").append(newElement);
            return;
        }

        $.ajax({
            type: 'post',
            url: editTripDir,
            data: {
                'tripName': tripName,
                'dateInputStart' : date_input_start,
                'dateInputEnd' : date_input_end,
                'tripId' : tripId
            },
            success: function (response) {
                if(response == "ok") {
                    document.location.href = tripPlaces;
                }
                else if(response == "nok3") {
                    $("#error").empty();
                    newElement = "<p style='color: red'>تاریخ پایان از تاریخ شروع باید بزرگ تر باشد</p>";
                    $("#error").append(newElement);
                }
            }
        });
    }
    else
        editTripWithOutDate();

}

function editTripWithOutDate() {

    tripName = $("#tripNameEdit").val();

    if(tripName != "") {

        $.ajax({
            type: 'post',
            url: editTripDir,
            data: {
                'tripName': tripName,
                'tripId' : tripId
            },
            success: function (response) {
                if(response == "ok") {
                    document.location.href = tripPlaces;
                }
            }
        });
    }
}

function addToTrip(placeId, kindPlaceId) {

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

            $("#tripsForPlace").empty();

            response = JSON.parse(response);
            newElement = "<div class='row'>";

            for(i = 0; i < response.length; i++) {

                newElement += "<div class='col-xs-12'>";
                newElement += "<div class='ui_input_checkbox'>";

                if(response[i].select == "0")
                    newElement += "<input type='checkbox' name='selectedTrips[]' id='trip_" + response[i].id + "' value='" + response[i].id + "'>";
                else
                    newElement += "<input type='checkbox' name='selectedTrips[]' checked id='trip_" + response[i].id + "' value='" + response[i].id + "'>";

                newElement += "<label class='labelForCheckBox' for='trip_" + response[i].id + "'><span></span>&nbsp;&nbsp;" + response[i].name;
                newElement += "</label></div></div>";
            }

            newElement += "</div>";

            $("#tripsForPlace").append(newElement);
            showElement('addPlaceToTripPrompt');

        }
    });
}

function assignPlaceToTrip() {

    if(selectedPlaceId != -1) {
        var checkedValuesTrips = $("input:checkbox[name='selectedTrips[]']:checked").map(function () {
            return this.value;
        }).get();

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
                    document.location.href = tripPlaces;
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

function init() {
    // Basic options for a simple Google Map
    // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
    var mapOptions = {
        // How zoomed in you want the map to start at (always required)
        zoom: 14,

        // The latitude and longitude to center the map (always required)
        center: new google.maps.LatLng(selectedX, selectedY), // New York

        // How you would like to style the map.
        // This is where you would paste any style found on Snazzy Maps.
        styles: [{
            "featureType":"landscape",
            "stylers":[
                {"hue":"#FFA800"},
                {"saturation":0},
                {"lightness":0},
                {"gamma":1}
            ]}, {
            "featureType":"road.highway",
            "stylers":[
                {"hue":"#53FF00"},
                {"saturation":-73},
                {"lightness":40},
                {"gamma":1}
            ]},	{
            "featureType":"road.arterial",
            "stylers":[
                {"hue":"#FBFF00"},
                {"saturation":0},
                {"lightness":0},
                {"gamma":1}
            ]},	{
            "featureType":"road.local",
            "stylers":[
                {"hue":"#00FFFD"},
                {"saturation":0},
                {"lightness":30},
                {"gamma":1}
            ]},	{
            "featureType":"water",
            "stylers":[
                {"hue":"#00BFFF"},
                {"saturation":6},
                {"lightness":8},
                {"gamma":1}
            ]},	{
            "featureType":"poi",
            "stylers":[
                {"hue":"#679714"},
                {"saturation":33.4},
                {"lightness":-25.4},
                {"gamma":1}
            ]}
        ]
    };

    // Get the HTML DOM element that will contain your map
    // We are using a div with id="map" seen below in the <body>
    var mapElement = document.getElementById('map');

    // Create the Google Map using our element and options defined above
    var map = new google.maps.Map(mapElement, mapOptions);

    // Let's also add a marker while we're at it
    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(40.6700, -73.9400),
        map: map,
        title: 'Shazdemosafer!'
    });
}

function showPlaceInfo(id, placeId, kindPlaceId, x, y, tripPlaceId, rowId) {

    if(currButtomInfoKindPlace == kindPlaceId && currButtomInfoPlace == placeId) {
        if (!$("#row_" + rowId).hasClass('hidden')) {
            $("#row_" + rowId).empty();
            $("#row_" + rowId).addClass('hidden');
            oldButtonId = -1;
            $("#" + id).css('background', "url('../../images/down-arrow.png')").css('background-size', '100% 100%').css('background-repeat', 'no-repeat no-repeat');
            return;
        }
    }

    if(oldButtonId != -1)
        $("#" + oldButtonId).css('background', "url('../../images/down-arrow.png')").css('background-size', '100% 100%').css('background-repeat', 'no-repeat no-repeat');

    $("#" + id).css('background', "url('../../images/up-arrow.png')").css('background-size', '100% 100%').css('background-repeat', 'no-repeat no-repeat');
    oldButtonId = id;

    currButtomInfoPlace = placeId;
    currButtomInfoKindPlace = kindPlaceId;

    if(!tripPlaceId)
        tripPlaceId = -1;

    selectedX = x;
    selectedY = y;

    $.ajax({
        type: 'post',
        url: placeInfo,
        data: {
            'placeId': placeId,
            'kindPlaceId': kindPlaceId,
            'tripPlaceId': tripPlaceId
        },
        success: function (response) {

            response = JSON.parse(response);
            $("#row_" + rowId).empty();

            newElement = "<div class='col-xs-12' style='direction: rtl;'>";


            newElement += "<div class='col-xs-6'>";
            if(response["date"] != null)
                newElement += "<p style='float: left;padding: 5px 0;color: var(--koochita-light-green);'>تاریخ بازدید: " + response["date"] + "</p>";
            newElement += "</div>";
            newElement += "<div class='col-xs-6'>";
            newElement += "<p onclick='document.location.href = \""+ response['url'] +"\"' style='cursor: pointer; font-size: 1.5em; padding: 5px 0;'>" + response["name"] + "</p>";
            newElement += "</div>";
            newElement += "<div class='col-xs-4' id='map' style='border: 2px solid black; height: 200px'></div>";

            newElement += '<div class="col-xs-4"><DIV class="prw_rup prw_common_bubble_rating overallBubbleRating">';
            if(response["point"] == 5)
                newElement += '<span class="ui_bubble_rating bubble_50" style="font-size:16px;" property="ratingValue" content="5" alt="5 of 5 bubbles"></span>';
            else if(response["point"] == 4)
                newElement += '<span class="ui_bubble_rating bubble_40" style="font-size:16px;" property="ratingValue" content="5" alt="4 of 5 bubbles"></span>';
            else if(response["point"] == 3)
                newElement += '<span class="ui_bubble_rating bubble_30" style="font-size:16px;" property="ratingValue" content="5" alt="3 of 5 bubbles"></span>';
            else if(response["point"] == 2)
                newElement += '<span class="ui_bubble_rating bubble_20" style="font-size:16px;" property="ratingValue" content="5" alt="2 of 5 bubbles"></span>';
            else
                newElement += '<span class="ui_bubble_rating bubble_10" style="font-size:16px;" property="ratingValue" content="5" alt="1 of 5 bubbles"></span>';
            newElement += "</DIV>";

            newElement += "<p>" + response["city"] + "/" + response["state"] + "</p>";
            newElement += "<p>" + response["address"] + "</p>";
            newElement += "</div>";
            newElement += "<div class='col-xs-4'>";
            newElement += "<div><img onclick='document.location.href = \""+ response['url'] +"\"' width='200px' height='200px' style='cursor: pointer' src='" + response["pic"] +  "'></div>";
            newElement += "</div>";
            newElement += "</div>";

            if(tripPlaceId != -1) {

                comments = response["comments"];

                for(i = 0; i < comments.length; i++) {
                    newElement += "<div class='col-xs-12'>";
                    newElement += "<p>" + comments[i].uId + " میگه : " + comments[i].description + "</p>";

                    newElement += "</div>";
                }

                newElement += "<div class='col-xs-2' style='margin-top: 10px;'>";
                newElement += "<button class='btn btn-primary' onclick='addComment(\"" + tripPlaceId + "\")' data-toggle='tooltip' title='ارسال نظر' style='color: #FFF; background-color: var(--koochita-light-green); border-color:var(--koochita-light-green); border-radius: 5%; width: 100%; margin-top: 17px;'>ارسال</button>";
                newElement += "</div>";

                newElement += "<div class='col-xs-10' style='margin-top: 10px;'>";
                newElement += "<textarea id='newComment' placeholder='یادداشت خود را وارد نمایید (حداکثر 300 کارکتر)' maxlength='300' style='width: 100%; padding: 5px; float: right !important; border-radius: 5px; border: 1px solid #ccc'></textarea>";
                newElement += "</div>";
            }

            $("#row_" + rowId).append(newElement);
            $("#row_" + rowId).removeClass('hidden');

            init();
        }
    });
}

function addComment(tripPlaceId) {
    if($("#newComment").val() == "")
        return;
    $.ajax({
        type: 'post',
        url: addCommentDir,
        data: {
            'tripPlaceId': tripPlaceId,
            'comment': $("#newComment").val()
        },
        success: function (response) {

            if(response == "ok")
                document.location.href = tripPlaces;
        }
    });
}

function changeDate() {

    date_input_start = $("#date_input_start_edit_2").val();
    date_input_end = $("#date_input_end_edit_2").val();

    if(date_input_start != "" && date_input_start != "") {

        if(date_input_start > date_input_end) {
            $("#error2").empty();
            newElement = "<p style='color: red'>تاریخ پایان از تاریخ شروع باید بزرگ تر باشد</p>";
            $("#error2").append(newElement);
            return;
        }
    }

    $.ajax({
        type: 'post',
        url: changeDateTripDir,
        data: {
            'dateInputStart' : date_input_start,
            'dateInputEnd' : date_input_end,
            'tripId' : tripId
        },
        success: function (response) {
            if(response == "ok") {
                document.location.href = tripPlaces;
            }
            else if(response == "nok3") {
                $("#error2").empty();
                newElement = "<p style='color: red'>تاریخ پایان از تاریخ شروع باید بزرگ تر باشد</p>";
                $("#error2").append(newElement);
            }
        }
    });
}

function deleteTrip() {

    $(".dark").show();
    $("#deleteTrip").removeClass('hidden');
}

function doDeleteTrip() {

    $.ajax({
        type: 'post',
        url: deleteTripDir,
        data: {
            'tripId': tripId
        },
        success: function (response) {
            if(response == "ok")
                document.location.href = myTrips;
        }
    });
}

// XMaUcwm2WjjV9WpT

function doAddNote() {

    $.ajax({
        type: 'post',
        url: addNoteDir,
        data: {
            'tripId': tripId,
            'note': $("#tripNote").val()
        },
        success: function (response) {
            if(response == "ok") {
                hideElement('note');
                $("#tripNotePElement").empty();
                $("#tripNotePElement").append(($("#tripNote").val()));
            }
        }
    });

}

function editDateTrip(from, to) {

    $("#date_input_start_edit_2").datepicker({
        numberOfMonths: 2,
        showButtonPanel: true,
        minDate: 0,
        dateFormat: "yy/mm/dd"
    });
    $("#date_input_end_edit_2").datepicker({
        numberOfMonths: 2,
        showButtonPanel: true,
        minDate: 0,
        dateFormat: "yy/mm/dd"
    });

    $("#date_input_start_edit_2").val(from);
    $("#date_input_end_edit_2").val(to);
    $("#error2").empty();

    showElement('editDateTripPrompt');
}

function assignDateToPlace(tripPlaceId, from, to) {
    selectedPlaceId = tripPlaceId;
    $("#calendar-container-edit-placeDate").css("visibility", "visible");
    $("#date_input").datepicker({
        numberOfMonths: 2,
        showButtonPanel: true,
        minDate: from,
        maxDate: to,
        dateFormat: "yy/mm/dd"
    });
    showElement('addDateToPlace');
}

function doAssignDateToPlace() {

    if($("#date_input").val() != "") {
        $.ajax({
            type: 'post',
            url: assignDateToPlaceDir,
            data: {
                'tripPlaceId': selectedPlaceId,
                'date': $("#date_input").val()
            },
            success: function (response) {
                if(response == "ok")
                    document.location.href = tripPlaces;
                else if(response == "nok3") {
                    $("#errorText").empty();
                    $("#errorText").append("تاریخ مورد نظر در بازه ی سفر قرار ندارد");
                }
            }
        });
    }
}

function sortBaseOnPlaceDate(sortMode) {
    if(sortMode == "DESC")
        document.location.href = tripPlaces + "/ASC";
    else
        document.location.href = tripPlaces + "/DESC";
}

function inviteFriend() {

    if($("#nickName").val() == "" || $("#friendId").val() == "")
        return;

    $.ajax({
        type: 'post',
        url: inviteFriendDir,
        data: {
            'nickName' : $("#nickName").val(),
            'friendId' : $("#friendId").val(),
            'tripId' : tripId
        },
        success: function(response) {
            if(response == "ok") {
                $("#nickName").empty();
                $("#friendId").empty();
                $("#errorInvite").empty();
                hideElement('invitePane');
            }
            else if(response == "nok") {
                $("#errorInvite").empty();
                $("#errorInvite").append('نام کاربری وارد شده نامعتبر است');
            }
            else if(response == "err4") {
                $("#errorInvite").empty();
                $("#errorInvite").append('شما هم اکنون عضو این سفر هستید');
            }
        }
    });
}

function showMembers(owner) {

    $.ajax({
        type: 'post',
        url: getMembers,
        data: {
            'tripId': tripId
        },
        success: function (response) {

            response = JSON.parse(response);
            newElement = "";

            $("#members").empty();

            for(i = 0; i < response.length; i++) {
                newElement += "<div class='col-xs-12'>";
                newElement += "<span>" + response[i]['username'] + "</span>";
                if(response[i]["delete"] == 1) {
                    newElement += "<button style='margin-right: 10px;padding: 0px 9px;' class='ui_button secondary' onclick='deleteMember(\"" + response[i]['username'] + "\")' data-toggle='tooltip' title='حذف عضو'><span class='' style=''><img src='" + homeURL + "/images/deleteIcon.gif'/> </span></button>";
                    if (owner == 1) {
                        newElement += "<br><a onclick='memberDetails(\"" + response[i]['username'] + "\")' style='cursor: pointer; text-align: center;color: #16174f;'>جزئیات<img src='" + homeURL + "/images/blackNavArrowDown.gif' width='7' height='4' hspace='10' border='0' align='absmiddle'/></a>";
                        newElement += "<div class='hidden' id='details_" + response[i]['username'] + "'></div>"
                    }
                }
                newElement += "</div>";
            }

            $("#members").append(newElement);

            showElement('membersPane');
        }
    });
}

function deleteMember(username) {

    selectedUsername = username;
    $(".dark").show();
    $("#deleteMember").removeClass('hidden');
}

function doDeleteMember() {
    $.ajax({
        type: 'post',
        url: deleteMemberDir,
        data: {
            'username': selectedUsername,
            'tripId': tripId
        },
        success: function (response) {
            if(response == "ok")
                document.location.href = tripPlaces;
        }
    });
}

function memberDetails(username) {

    if(!$("#details_" + username).hasClass('hidden')) {
        $("#details_" + username).addClass('hidden');
        return;
    }


    $.ajax({
        type: 'post',
        url: getMemberAccessLevel,
        data: {
            'username': username,
            'tripId': tripId
        },
        success: function (response) {

            $("#details_" + username).empty();

            response = JSON.parse(response);

            newElement = "<div class='row'>";
            newElement += "<div class='col-xs-12' style='margin-top: 10px'>";
            newElement += "<div class='ui_input_checkbox'>";
            if(response.addPlace == 1)
                newElement += "<input id='addPlaceLevel' onclick='changeAddPlace(\"" + username + "\")' checked type='checkbox'>";
            else
                newElement += "<input id='addPlaceLevel' onclick='changeAddPlace(\"" + username + "\")' type='checkbox'>";

            newElement += "<label for='addPlaceLevel' class='labelForCheckBox'><span></span>&nbsp;&nbsp;افزودن مکان</label>";
            newElement += "</div></div>";

            newElement += "<div class='col-xs-12' style='margin-top: 10px'>";
            newElement += "<div class='ui_input_checkbox'>";
            if(response.addFriend == 1)
                newElement += "<input id='addFriendLevel' onclick='changeAddFriend(\"" + username + "\")' checked type='checkbox'>";
            else
                newElement += "<input id='addFriendLevel' onclick='changeAddFriend(\"" + username + "\")' type='checkbox'>";

            newElement += "<label class='labelForCheckBox' for='addFriendLevel'><span></span>&nbsp;&nbsp;دعوت دوستان</label></div></div>";

            newElement += "<div class='col-xs-12' style='margin-top: 10px'>";
            newElement += "<div class='ui_input_checkbox'>";
            if(response.changePlaceDate == 1)
                newElement += "<input id='changePlaceDateLevel' onclick='changePlaceDate(\"" + username + "\")' checked type='checkbox'>";
            else
                newElement += "<input id='changePlaceDateLevel' onclick='changePlaceDate(\"" + username + "\")' type='checkbox'>";
            newElement += "<label class='labelForCheckBox' for='changePlaceDateLevel'><span></span>&nbsp;&nbsp;تغییر زمان مکان های سفر</label></div></div>";

            newElement += "<div class='col-xs-12' style='margin-top: 10px'>";
            newElement += "<div class='ui_input_checkbox'>";
            if(response.changeTripDate == 1)
                newElement += "<input id='changeDate' onclick='changeTripDate(\"" + username + "\")' checked type='checkbox'>";
            else
                newElement += "<input id='changeDate' onclick='changeTripDate(\"" + username + "\")' type='checkbox'>";
            newElement += "<label class='labelForCheckBox' for='changeDate'><span></span>&nbsp;&nbsp;تغییر زمان سفر</label></div></div>";

            newElement += "</div>";
            $("#details_" + username).append(newElement);
            $("#details_" + username).removeClass('hidden');
        }
    });
}

function changeAddPlace(username) {

    $.ajax({
        type: 'post',
        url: changeAddPlaceDir,
        data: {
            'username': username,
            'tripId': tripId
        }
    });
}

function changeAddFriend(username) {

    $.ajax({
        type: 'post',
        url: changeAddFriendDir,
        data: {
            'username': username,
            'tripId': tripId
        }
    });
}

function changePlaceDate(username) {

    $.ajax({
        type: 'post',
        url: changePlaceDateDir,
        data: {
            'username': username,
            'tripId': tripId
        }
    });
}

function changeTripDate(username) {

    $.ajax({
        type: 'post',
        url: changeTripDateDir,
        data: {
            'username': username,
            'tripId': tripId
        }
    });
}

function deletePlace(tripPlaceId) {
    selectedTripPlace = tripPlaceId;
    $(".dark").show();
    $("#deleteTripPlace").removeClass('hidden');
}

function doDeleteTripPlace() {
    $.ajax({
        type: 'post',
        url: deletePlaceDir,
        data: {
            'tripPlaceId': selectedTripPlace
        },
        success: function (response) {
            if(response == "ok")
                document.location.href = tripPlaces;
        }
    });
}