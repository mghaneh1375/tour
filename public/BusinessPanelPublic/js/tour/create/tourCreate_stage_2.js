var openedDateEvent = 0;
var searchEventPlaceKind = null;
var planDate = [];
var searchResults = [];
var ajaxProcess = null;
var clockOptions = {
    placement: "left",
    donetext: "تایید",
    autoclose: true,
};
var placeCardSample = $("#choosePlaceSample").html();
$("#choosePlaceSample").remove();

if (tour.schedules.length != 0) {
    for (var i = 0; i < dateCount; i++) {
        planDate[i] = {
            hotelId: tour.schedules[i].hotelId,
            hotelKindPlaceId: tour.schedules[i].isBoomgardi == 1 ? 13 : 4,
            hotelInfo: {
                name: tour.schedules[i].hotel
                    ? tour.schedules[i].hotel.name
                    : "",
                pic: tour.schedules[i].hotel ? tour.schedules[i].hotel.pic : "",
                stateAndCity: tour.schedules[i].hotel
                    ? tour.schedules[i].hotel.cityAndState
                    : "",
            },
            description: tour.schedules[i].description,
            events: [],
        };
        tour.schedules[i].events.map((item) => {
            var eventIndex = null;
            eventType.map((ev, ind) => {
                if (ev.code == item.code) eventIndex = ind;
            });
            var events = {
                eventIndex: eventIndex,
                eventCode: eventType[eventIndex].code,
                sTime: item.sTime,
                eTime: item.eTime,
                moreData: item.text,
                description: item.description,
            };
            if (item.code == 3 || item.code == 7) events.moreData = item.places;

            planDate[i].events.push(events);
        });
    }
} else {
    for (var i = 0; i < dateCount; i++)
        planDate[i] = {
            hotelId: 0,
            hotelKindPlaceId: 0,
            hotelInfo: {
                name: "",
                pic: "",
                stateAndCity: "",
            },
            description: "",
            events: [],
        };
}

$(window).ready(() => {
    $(".clockP").clockpicker(clockOptions);

    var text = "";
    eventType.map(
        (item) =>
            (text += `<swiper-slide class="eventItem" onclick="chooseThisItem(this, ${item.code})">
                    <div class="text">${item.name}</div>
                    <div class="icon"></div>
                    </swiper-slide>`)
    );
    $("#eventTitles").html(text);

    doLastUpdate(false);
});

function goToPrevStep() {
    openLoading(false, () => {
        location.href = prevStageUrl;
    });
}

function openDatePlanRow(_element) {
    if ($(_element).next().hasClass("bodySec open")) {
        $(_element).find(".icon").removeClass("fa-angle-up");
        $(_element).find(".icon").addClass("fa-angle-down");
        $(_element).next().find(".bodySec").removeClass("open");
        $(_element).next().removeClass("open");
    } else {
        $(".whiteBox").find(".open").removeClass("open");
        $(".whiteBox").find(".icon").removeClass("fa-angle-up");
        $(".whiteBox").find(".icon").addClass("fa-angle-down");
        $(_element).find(".icon").removeClass("fa-angle-down");
        $(_element).find(".icon").addClass("fa-angle-up");
        $(_element).next().toggleClass("open");
    }
}

function addEventTo(_day) {
    $("#newEventTo").val(_day);

    $("#descriptionOfNewEvent").val("");
    $("#optBody").find("input").val("");

    $(".eventItem").removeClass("select");
    $(".optbodies").addClass("hidden");
    $(".choosedPlace").empty();
    $(".clockP").val("");

    openedDateEvent = _day;
    openMyModalBP("addNewEventModal");
}

function chooseThisItem(_element, _kind) {
    $(".eventItem").removeClass("select");
    $(_element).addClass("select");

    $(".optbodies").addClass("hidden");
    $("#optBod" + _kind).removeClass("hidden");

    eventType.map((ev, index) => {
        if (ev.code == _kind) searchEventPlaceKind = index;
    });
}

function searchForPlaces(_element, _kindPlaceId) {
    kindPlaceId = _kindPlaceId;
    _element = $(_element);
    var value = _element.val();
    _element.next().empty();
    if (value.trim().length > 1) {
        searchResults = [];
        if (ajaxProcess != null) ajaxProcess.abort();

        ajaxProcess = $.ajax({
            type: "GET",
            url: `https://koochita-server.bogenstudio.com/api/place/totalSearch?placeMode=${_kindPlaceId}&key=${value}`,
            success: (res) => {
                let data = JSON.parse(res);
                if (data.status == "ok") {
                    var text = "";
                    searchResults = data.data.places;
                    searchResults.map((item, index) => {
                        item.stateAndCity =
                            item.state_name && item.city_name
                                ? `استان ${item.state_name} شهر ${item.city_name}`
                                : "";
                        text += `<div class="res" data-index="${index}" onclick="chooseThisPlaceForDate(this,kindPlaceId)">${item.target_name}</div>`;
                    });
                    _element.next().html(text);
                }
            },
        });
    }
}
function chooseThisPlaceForDate(_element, _kin) {
    _element = $(_element);
    var index = _element.attr("data-index");
    createPlaceCardForSelect(
        searchResults[index],
        _element.parent().parent().parent().find(".choosedPlace")
    );

    _element.parent().empty().prev().val("");
}
function createPlaceCardForSelect(_place, _resultSec) {
    var text = placeCardSample;
    var fn = Object.keys(_place);
    for (var x of fn) {
        text = text.replace(new RegExp(`##${x}##`, "g"), _place[x]);
    }

    text = text.replace(new RegExp(`##dateIndex##`, "g"), openedDateEvent);

    _resultSec.append(text);
}
function deleteThisPlace(_element) {
    $(_element).parent().remove();
}

function doAddEvent() {
    var startTime = $("#startTimeEvent").val();
    var endTime = $("#endTimeEvent").val();
    var code = eventType[searchEventPlaceKind].code;
    var errorText = "";
    var error = false;
    if (startTime.trim().length != 5 || endTime.trim().length != 5) {
        alert("پر کردن زمان برنامه اجباری است");
        return;
    }

    if (startTime.trim() >= endTime.trim()) {
        alert("زمان شروع باید قبل از زمان پایان باشد.");
        return;
    }

    planDate[openedDateEvent].events.map((item) => {
        if (
            (item.sTime < endTime && item.eTime > endTime) ||
            (item.sTime < startTime && item.eTime > startTime) ||
            (item.sTime > startTime && item.eTime < endTime)
        ) {
            alert("زمان این برنامه با برنامه های دیگر روز مغایرت دارد...");
            error = true;
        }
    });

    if (error) return;

    var datas = {
        eventIndex: searchEventPlaceKind,
        eventCode: eventType[searchEventPlaceKind].code,
        sTime: startTime,
        eTime: endTime,
        moreData: "",
        description: $("#descriptionOfNewEvent").val(),
    };

    if (code == 1 || code == 4 || code == 5 || code == 6) {
        datas.moreData = $(`#opt${code}Name`).val();
    } else if (code == 3 || code == 7) {
        var ids = [];
        var placesSec = $("#optBod" + code).find(".placeCar");
        for (var i = 0; i < placesSec.length; i++) {
            var element = $($(placesSec[i])[0]);
            ids.push({
                id: element.attr("data-placeId"),
                kindPlaceId: element.attr("data-kindPlaceId"),
                pic: element.find("img").attr("src"),
                name: element.find(".name").text(),
                stateAndCity: element.find(".text").text(),
            });
        }
        datas.moreData = ids;
    }

    planDate[openedDateEvent].events.push(datas);

    searchEventPlaceKind = null;
    addNewEventToDayCalendar(openedDateEvent);
    closeMyModalBP("addNewEventModal");
}

function editThisDetail(_day, _index) {
    openedDateEvent = _day;
    var editData = planDate[_day].events[_index];
    var event = eventType[editData.eventIndex];

    $("#editDay").val(_day);
    $("#editIndex").val(_index);

    $("#editEventTitle").text(event.name);
    $("#startTimeEventEdit").val(editData.sTime);
    $("#endTimeEventEdit").val(editData.eTime);
    $("#editBody")
        .empty()
        .html($("#optBod" + event.code).html());

    $("#descriptionOfEditEvent").val(editData.description);
    if (
        event.code == 1 ||
        event.code == 4 ||
        event.code == 5 ||
        event.code == 6
    )
        $("#editBody").find("input").val(editData.moreData);
    else if (event.code == 3 || event.code == 7) {
        $("#editBody").find(".choosedPlace").empty();
        editData.moreData.map((item) =>
            createPlaceCardForSelect(item, $("#editBody").find(".choosedPlace"))
        );
    }
    openMyModalBP("editEventModal");
}
function doEditEvent() {
    var day = $("#editDay").val();
    var index = $("#editIndex").val();

    var startTime = $("#startTimeEventEdit").val();
    var endTime = $("#endTimeEventEdit").val();

    var event = planDate[day].events[index];
    var code = eventType[event.eventIndex].code;
    var error = false;

    if (startTime.trim().length != 5 || endTime.trim().length != 5) {
        alert("پر کردن زمان برنامه اجباری است");
        return;
    }

    if (startTime.trim() >= endTime.trim()) {
        alert("زمان شروع باید قبل از زمان پایان باشد.");
        return;
    }

    planDate[openedDateEvent].events.map((item, index) => {
        if (index != index) {
            if (
                (item.sTime < endTime && item.eTime > endTime) ||
                (item.sTime < startTime && item.eTime > startTime) ||
                (item.sTime > startTime && item.eTime < endTime)
            ) {
                alert("زمان این برنامه با برنامه های دیگر روز مغایرت دارد...");
                error = true;
            }
        }
    });

    if (error) return;

    event.description = $("#descriptionOfEditEvent").val();

    if (code == 1 || code == 4 || code == 5 || code == 6)
        event.moreData = $("#editBody").find("input").val();
    else if (code == 3 || code == 7) {
        var ids = [];
        var placesSec = $("#editBody").find(".placeCar");
        for (var i = 0; i < placesSec.length; i++) {
            var element = $($(placesSec[i])[0]);

            ids.push({
                id: element.attr("data-placeId"),
                kindPlaceId: element.attr("data-kindPlaceId"),
                pic: element.find("img").attr("src"),
                name: element.find(".name").text(),
                stateAndCity: element.find(".text").text(),
            });
        }
        event.moreData = ids;
    }

    event.sTime = startTime;
    event.eTime = endTime;
    planDate[day].events[index] = event;

    addNewEventToDayCalendar(openedDateEvent);
    closeMyModalBP("editEventModal");
}

function deleteThisEvent() {
    var day = $("#editDay").val();
    var index = $("#editIndex").val();
    $(`#detailPlan_${day}_${index}`).remove();
    planDate[day].events.splice(index, 1);
    closeMyModalBP("editEventModal");
}
function addNewEventToDayCalendar(_day) {
    var allDay = 24 * 60;
    var text = "";
    planDate[_day].events.map((item, index) => {
        var sTime = item.sTime.split(":");
        var eTime = item.eTime.split(":");

        var sMinutes = parseInt(sTime[0]) * 60 + parseInt(sTime[1]);
        var eMinutes = parseInt(eTime[0]) * 60 + parseInt(eTime[1]);

        var width = ((eMinutes - sMinutes) / allDay) * 100;
        var startPos = (sMinutes / allDay) * 100;
        var event = eventType[item.eventIndex];

        text += `<div id="detailPlan_${_day}_${index}" class="detail tooltipRow" style="width: ${width}%; right: ${startPos}%; background: ${event.color}" onclick="editThisDetail(${_day}, ${index})">${event.name}
        <span class="tooltipRowtext">${event.name}</span>
        </div>`;
    });
    $("#planRow_" + _day).html(text);

    openedDateEvent = 0;
}

function chooseHotel(_day) {
    $("#dayForHotelModal").val(_day);
    $("#inputSearchHotel").val("");
    $("#addHotelModal").modal("show");
}
function searchForHotel(_element) {
    var value = $(_element).val();
    if (ajaxProcess != null) ajaxProcess.abort();

    var kindPlaceId = $("#hotelKind").val();
    if (value.trim().length > 1) {
        ajaxProcess = $.ajax({
            type: "GET",
            url: `https://koochita-server.bogenstudio.com/api/place/totalSearch?placeMode=${kindPlaceId}&key=${value}`,
            success: (res) => {
                let data = JSON.parse(res);
                if (data.status == "ok") {
                    var text = "";
                    searchResults = data.data.places;
                    searchResults.map(
                        (item, key) =>
                            (text += `<div class="searchHover blue" data-index="${key}" data-kindPlaceId="${kindPlaceId}" onclick="chooseThisHotel(this)" > ${item.target_name} ,${item.city_name} در ${item.state_name} </div>`)
                    );
                    $(_element).next().html(text);
                }
            },
        });
    }
}
function chooseThisHotel(_element) {
    var index = $(_element).attr("data-index");
    var kindPlaceId = $(_element).attr("data-kindPlaceId");
    var day = $("#dayForHotelModal").val();
    $(_element).parent().empty();
    $("#inputSearchHotel").val("");

    planDate[day].hotelId = searchResults[index].id;
    planDate[day].hotelKindPlaceId = kindPlaceId;
    planDate[day].hotelInfo.name = searchResults[index].target_name;
    planDate[day].hotelInfo.pic = searchResults[index].pic;
    planDate[
        day
    ].hotelInfo.stateAndCity = `استان ${searchResults[index].state_name} شهر ${searchResults[index].city_name}`;
    $("#addHotelModal").modal("hide");
    console.log(day);
    console.log(planDate);
    showHotelInDay(day);
}
function showHotelInDay(_day) {
    $("#answerForSubmitLastHotel_" + _day).addClass("hidden");
    $("#hotelImgForDay_" + _day).attr("src", planDate[_day].hotelInfo.pic);
    $("#hotelNameForDay_" + _day).text(planDate[_day].hotelInfo.name);
    $("#hotelCityForDay_" + _day).text(planDate[_day].hotelInfo.stateAndCity);
    // $('#hotelAddressForDay_'+_day).text(searchResults[index].address);

    for (var i = parseInt(_day) + 1; i < dateCount; i++) {
        if ((planDate[i], planDate[i].hotelId == 0)) {
            $("#hotelImgForDay_" + i).attr("src", planDate[_day].hotelInfo.pic);
            $("#hotelNameForDay_" + i).text(planDate[_day].hotelInfo.name);
            $("#hotelCityForDay_" + i).text(
                planDate[_day].hotelInfo.stateAndCity
            );
            // $('#hotelAddressForDay_'+i).text(searchResults[index].address);

            $("#answerForSubmitLastHotel_" + i).removeClass("hidden");
            $("#lastHotelId_" + i).val(planDate[_day].hotelId);
            $("#lastHotelKindPlaceId" + i).val(planDate[_day].hotelKindPlaceId);
        } else break;
    }
}
function submitThisHotel(_day) {
    var hotelId = $("#lastHotelId_" + _day).val();
    var hotelKindPlaceId = $("#lastHotelKindPlaceId" + _day).val();
    $("#answerForSubmitLastHotel_" + _day).addClass("hidden");
    planDate[_day].hotelId = parseInt(hotelId);
    planDate[_day].hotelKindPlaceId = parseInt(hotelKindPlaceId);
}

function checkInput(mainStore = true) {
    planDate.map(
        (item, index) =>
            (item.description = $("#dateDescription_" + index).val())
    );

    if (mainStore) submitSchedule();
    else localStorage.setItem(`planeDate_${tour.id}`, JSON.stringify(planDate));
}

function submitSchedule() {
    openLoading();

    $.ajax({
        type: "POST",
        url: stageTwoStoreUrl,
        data: {
            tourId: tour.id,
            planDate: JSON.stringify(planDate),
        },
        success: (res) => {
            if (res.status == "ok") {
                localStorage.removeItem(`planeDate_${tour.id}`);
                location.href = nextStageUrl;
            } else {
                closeLoading();
                showSuccessNotifiBP(
                    "ثبت در خواست با مشکل مواچه شد",
                    "left",
                    "red"
                );
            }
        },
        error: (err) => {
            closeLoading();
            showSuccessNotifiBP("ثبت در خواست با مشکل مواچه شد", "left", "red");
        },
    });
}

function doLastUpdate(_lastData = true) {
    if (_lastData) planDate = JSON.parse(planD);

    planDate.map((day, index) => {
        showHotelInDay(index);
        addNewEventToDayCalendar(index);
        $(`#dateDescription_${index}`).val(day.description);
    });
}

var planD = localStorage.getItem(`planeDate_${tour.id}`);
if (!(planD == false || planD == null))
    openWarningBP(
        "بازگرداندن اطلاعات قبلی",
        doLastUpdate,
        "بله قبلی را ادامه می دهم"
    );

setInterval(() => checkInput(false), 5000);
