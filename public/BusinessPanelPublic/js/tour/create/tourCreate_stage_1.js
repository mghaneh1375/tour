var ajaxVar = null;
var cityId;
var calendarIndex = 2;
var timeRowSample = $("#timeRowSample").html();
$("#timeRowSample").remove();

var datePickerOptions = {
    numberOfMonths: 1,
    showButtonPanel: true,
    language: "fa",
    dateFormat: "yy/mm/dd",
};

function newCalendar() {
    var text = timeRowSample.replace(
        new RegExp("##number##", "g"),
        calendarIndex
    );

    if (calendarIndex - 1 > 0) {
        document.getElementById(
            "deleteCalendar_" + (calendarIndex - 1)
        ).style.display = "block";
        document.getElementById(
            "newCalendar_" + (calendarIndex - 1)
        ).style.display = "none";
    }

    $("#notSameTimeCalendarDiv").append(text);

    $(`#eDate_${calendarIndex}`).datepicker(datePickerOptions);
    $(`#sDate_${calendarIndex}`).datepicker(datePickerOptions);
    calendarIndex++;
}

function deleteCalendar(_index) {
    $("#calendar_" + _index).remove();
}

function chooseSrcCityModal() {
    $("#addCityModal").modal("show");
    state();
}

function state() {
    stateList = "";

    $.ajax({
        type: "get",
        url: "https://boom.bogenstudio.com/api/v1/general/user/get-list-of-province",
        headers: {
            Accept: "application/json",
            // 'Content-Type': 'application/json',
            // Authorization: TOKEN,
        },
        success: function (myRes) {
            stateList += "";
            stateList +=
                '<select  class="inputBoxInput styled-select text-align-right"type="text" id="stateId" onChange="">';
            stateList += "<option>انتخاب کنید</option>";
            for (let i = 0; i < myRes.length; i++) {
                if (1 == 2) {
                    stateList +=
                        ' <option selected id="' +
                        myRes[i]._id +
                        '" value="' +
                        myRes[i].name +
                        '">' +
                        myRes[i].name +
                        "</option>";
                } else {
                    stateList +=
                        ' <option id="' +
                        myRes[i]._id +
                        '" value="' +
                        myRes[i].name +
                        '">' +
                        myRes[i].name +
                        "</option>";
                }
            }
            stateList += "</select>";
            $("#selectStateForSelectCity").empty().append(stateList);
        },
    });
}

function searchForCity(_element) {
    var stateId = $("#stateId").val();
    var value = $(_element).val().trim();
    var citySrcInput = $(_element);
    citySrcInput.next().empty();

    if (value.length > 1 && stateId != 0) {
        if (ajaxVar != null) ajaxVar.abort();

        ajaxVar = $.ajax({
            type: "GET",
            url:
                "https://koochita-server.bogenstudio.com/api/place/searchForCitiesOrStates?state=" +
                stateId +
                "&key=" +
                value,
            success: (myRes) => {
                let res = JSON.parse(myRes);

                if (res.status == "ok") {
                    var text = "";
                    for (let i = 0; i < res.data.cities.length; i++) {
                        cityId = res.data.cities[i].id;
                        text +=
                            '<div class="searchHover blue" onclick="selectThisCityForSrc(this,cityId )">';
                        text += "" + res.data.cities[i].target_name + "";
                        text += "</div>";
                    }

                    citySrcInput.next().html(text);
                }
            },
        });
    }
}

function selectThisCityForSrc(_element, _id) {
    $("#srcCity").val($(_element).text());
    $("#srcCityId").val(_id);
    $("#addCityModal").modal("hide");
    $(_element).parent().empty();

    if (document.getElementById("sameSrcDestInput").checked)
        $("#destPlaceId").val(_id);
}

function chooseDestModal() {
    $("#addDestinationModal").modal("show");
    stateForDest();
}
function stateForDest() {
    stateList = "";

    $.ajax({
        type: "get",
        url: "https://boom.bogenstudio.com/api/v1/general/user/get-list-of-province",
        headers: {
            Accept: "application/json",
            // 'Content-Type': 'application/json',
            // Authorization: TOKEN,
        },
        success: function (myRes) {
            stateList += "";
            stateList +=
                '<select  class="inputBoxInput styled-select text-align-right"type="text" id="stateDestId" onChange="">';
            stateList += "<option>انتخاب کنید</option>";
            for (let i = 0; i < myRes.length; i++) {
                if (1 == 2) {
                    stateList +=
                        ' <option selected id="' +
                        myRes[i]._id +
                        '" value="' +
                        myRes[i].name +
                        '">' +
                        myRes[i].name +
                        "</option>";
                } else {
                    stateList +=
                        ' <option id="' +
                        myRes[i]._id +
                        '" value="' +
                        myRes[i].name +
                        '">' +
                        myRes[i].name +
                        "</option>";
                }
            }
            stateList += "</select>";
            $("#selectStateForSelectCityDest").empty().append(stateList);
        },
    });
}
function searchForDestination(_element) {
    var stateId = $("#stateDestId").val();
    var value = $(_element).val().trim();
    var citySrcInput = $(_element);
    citySrcInput.next().empty();

    if (value.length > 1 && stateId != 0) {
        if (ajaxVar != null) ajaxVar.abort();

        ajaxVar = $.ajax({
            type: "GET",
            url:
                "https://koochita-server.bogenstudio.com/api/place/searchForCitiesOrStates?state=" +
                stateId +
                "&key=" +
                value,
            success: (myRes) => {
                let res = JSON.parse(myRes);
                if (res.status == "ok") {
                    var text = "";
                    for (let i = 0; i < res.data.cities.length; i++) {
                        cityId = res.data.cities[i].id;
                        text +=
                            '<div class="searchHover blue" onclick="selectThisForDest(this,cityId)">';
                        text += "" + res.data.cities[i].target_name + "";
                        text += "</div>";
                    }

                    citySrcInput.next().html(text);
                }
            },
        });
    }
}

function selectThisForDest(_element, _id) {
    var _kind = $("#selectDestinationKind").val();

    $("#destInput").val($(_element).text());
    $("#destPlaceId").val(_id);
    $("#destKind").val(_kind);
    $(_element).parent().empty();
    $("#addDestinationModal").modal("hide");
}

function srcDest() {
    var value = document.getElementById("sameSrcDestInput").checked;
    document.getElementById("destDiv").style.display = value
        ? "none"
        : "inline-block";
    document.getElementById("destPlaceId").value = value
        ? document.getElementById("srcCityId").value
        : 0;
    document.getElementById("destKind").value = value ? "city" : "tabiatgardy";
    $("#destInput").val("");
}

function fullDataInFields() {
    $("#tourId").val(tour.id);
    $("#tourName").val(tour.name);
    $("#srcCity").val(tour.src.name);
    $("#srcCityId").val(tour.src.id);

    $("#destInput").val(tour.dest.name);
    $("#destPlaceId").val(tour.dest.id);
    $("#destKind").val(tour.dest.kind);

    if (tour.isLocal) $("#sameSrcDestInput").click();

    $("#tourDay").val(tour.day);
    $("#tourNight").val(tour.night);

    $("#minCapacity").val(tour.minCapacity);
    $("#maxCapacity").val(tour.maxCapacity);
    if (tour.anyCapacity == 1) $("#anyCapacity").click();

    if (tour.private == 1) {
        $('input[name="private"]').parent().removeClass("active");
        $('input[name="private"][value="1"]')
            .prop("checked", true)
            .parent()
            .addClass("active");
    }

    for (var i = 0; i < tour.times.length - 1; i++) newCalendar();

    for (i = 0; i < tour.times.length; i++) {
        $(`#sDate_${i}`).val(tour.times[i].sDate);
        $(`#eDate_${i}`).val(tour.times[i].eDate);
    }

    $('input[name="isAllUserInfo"]').parent().removeClass("active");
    $(`input[name="isAllUserInfo"][value="${tour.allUserInfoNeed}"]`)
        .prop("checked", true)
        .parent()
        .addClass("active");

    $('input[name="userInfoNeed[]"]').prop("checked", false);
    tour.userInfoNeed.map((item) =>
        $(`#userInfoNeed_${item}`).prop("checked", true)
    );
}

function calculateDate() {
    var type = $("#calendarType").val();
    var count = $("#calendarCount").val();

    if (count > 0) {
        $("#calendarCount").val("");
        calendarIndex = 1;
        var sDate = $("#sDate_0").val().split("/");
        var eDate = $("#eDate_0").val().split("/");

        var sGregorian = jalaliToGregorian(sDate[0], sDate[1], sDate[2]).join(
            "/"
        );
        var eGregorian = jalaliToGregorian(eDate[0], eDate[1], eDate[2]).join(
            "/"
        );

        var sFirstDay = new Date(sGregorian);
        var eFirstDay = new Date(eGregorian);

        $(".calendarRow").remove();

        for (var i = 1; i <= count; i++) {
            newCalendar();
            var skip;
            var sJalali = [];
            var eJalali = [];

            if (type == "weekly" || type == "twoWeek") {
                skip = type == "weekly" ? 1 : 2;

                var sNext = new Date(
                    sFirstDay.getTime() + 7 * 24 * 60 * 60 * 1000 * i * skip
                );
                var eNext = new Date(
                    eFirstDay.getTime() + 7 * 24 * 60 * 60 * 1000 * i * skip
                );

                var sYear = sNext.getFullYear();
                var eYear = eNext.getFullYear();

                var sMonth = sNext.getMonth();
                var eMonth = eNext.getMonth();

                var sDay = sNext.getDate();
                var eDay = eNext.getDate();

                if (sMonth > 11) {
                    sMonth = 0;
                    sYear++;
                }
                if (eMonth > 11) {
                    eMonth = 0;
                    eYear++;
                }

                sJalali = gregorianToJalali(sYear, sMonth + 1, sDay);
                eJalali = gregorianToJalali(eYear, eMonth + 1, eDay);
            } else {
                skip = type == "monthly" ? 1 : 2;
                sJalali = sDate;
                eJalali = eDate;

                sJalali[1] = parseInt(sJalali[1]) + skip;
                eJalali[1] = parseInt(eJalali[1]) + skip;

                if (sJalali[1] > 12) {
                    sJalali[1] -= 12;
                    sJalali[0]++;
                }
                if (eJalali[1] > 12) {
                    eJalali[1] -= 12;
                    eJalali[0]++;
                }

                if (parseInt(sJalali[1]) < 10)
                    sJalali[1] = "0" + parseInt(sJalali[1]);
                if (parseInt(eJalali[1]) < 10)
                    eJalali[1] = "0" + parseInt(eJalali[1]);
            }

            $("#sDate_" + i).val(sJalali.join("/"));
            $("#eDate_" + i).val(eJalali.join("/"));
        }
    }
}

var dataToSend;
function checkInput() {
    dataToSend = {
        tourType,
        tourId: document.getElementById("tourId").value,
        businessId: document.getElementById("businessId").value,
        tourName: document.getElementById("tourName").value,
        srcCityId: $("#srcCityId").val(),
        destPlaceId: $("#destPlaceId").val(),
        kindDest: document.getElementById("destKind").value,
        sameSrcDestInput: document.getElementById("sameSrcDestInput").checked,
        tourDay: parseInt(p2e(document.getElementById("tourDay").value)),
        tourNight: parseInt(p2e(document.getElementById("tourNight").value)),
        minCapacity: parseInt(
            p2e(document.getElementById("minCapacity").value)
        ),
        maxCapacity: parseInt(
            p2e(document.getElementById("maxCapacity").value)
        ),
        private: document.querySelector('input[name="private"]:checked').value,
        anyCapacity: document.getElementById("anyCapacity").checked,
        isAllUserInfoNeed: $('input[name="isAllUserInfo"]:checked').val(),
        userInfoNeed: [
            ...document.querySelectorAll(
                'input[name="userInfoNeed[]"]:checked'
            ),
        ].map((item) => item.value),
        dates: [],
    };

    var errorText = "";
    if (dataToSend.tourName.trim().length < 2)
        errorText += "<li>نام تور خود را مشخص کنید.</li>";
    if (!(dataToSend.srcCityId.length >= 1))
        errorText += "<li>مبدا تور خود را مشخص کنید.</li>";
    if (!(dataToSend.destPlaceId.length >= 1))
        errorText += "<li>مقصد تور خود را مشخص کنید.</li>";
    if (!(Number.isInteger(dataToSend.tourDay) && dataToSend.tourDay >= 0))
        errorText += "<li>تعداد روزهای تور خود را مشخص کنید.</li>";
    if (!(Number.isInteger(dataToSend.tourNight) && dataToSend.tourNight >= 0))
        errorText += "<li>تعداد شب های تور خود را مشخص کنید.</li>";
    if (!dataToSend.anyCapacity) {
        if (
            !(
                Number.isInteger(dataToSend.minCapacity) &&
                dataToSend.minCapacity >= 0
            )
        )
            errorText += "<li>حداقل ظرفیت تور خود را مشخص کنید.</li>";
        if (
            !(
                Number.isInteger(dataToSend.maxCapacity) &&
                dataToSend.maxCapacity >= 0
            )
        )
            errorText += "<li>حداکثر ظرفیت تور خود را مشخص کنید.</li>";
    }

    if (dataToSend.userInfoNeed.length == 0)
        errorText += "<li>نمی توانید از مسافرین اطلاعاتی دریافت نکنید.</li>";

    var sDate = "";
    var eDate = "";
    var sRows = $('input[name="sDateNotSame[]"]');
    var eRows = $('input[name="eDateNotSame[]"]');
    for (var i = 0; i < sRows.length; i++) {
        if (
            $(sRows[i]).val().trim().length != 0 &&
            $(eRows[i]).val().trim().length != 0
        ) {
            eDate = $(eRows[i]).val().trim();
            sDate = $(sRows[i]).val().trim();
            dataToSend.dates.push({ sDate, eDate });
        }
    }

    if (sDate.trim().length == 0 || eDate.trim().length == 0)
        errorText += "<li>تاریخ تور را مشخص کنید.</li>";

    if (errorText != "") {
        errorText = `<ul class="errorList">${errorText}</ul>`;
        openErrorAlertBP(errorText);
    } else submitInputs();
}

function submitInputs() {
    openLoading(false, () => {
        $.ajax({
            type: "POST",
            url: stageOneStoreUrl,
            data: dataToSend,
            success: (response) => {
                if (response.status === "ok") {
                    location.href = `${stageTwoUrl}/${response.result}`;
                } else {
                    closeLoading();
                    showSuccessNotifiBP("در ثبت مشکلی پیش آمده", "left", "red");
                }
            },
            error: (err) => {
                closeLoading();
                showSuccessNotifiBP("در ثبت مشکلی پیش آمده", "left", "red");
            },
        });
    });
}

$(window).ready(() => {
    stateForDest();
    state();
    $(".observer-example").datepicker(datePickerOptions);
    $(".tourBasicKindsCheckbox")
        .mouseenter(() => $(this).addClass("green-border"))
        .mouseleave(() => $(this).removeClass("green-border"));
    if (tour != null) fullDataInFields();
});
