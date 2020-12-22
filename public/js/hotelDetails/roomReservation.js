
rooms = JSON.parse(rooms);
var totalMoney = 0;
var totalPerDayMoney = 0;
var numDay = rooms[0].perDay.length;
var room_code = [];
var adult_count = [];
var extra = [];
var num_room_code = [];
var room_name = [];
document.getElementById('numDay').innerText = numDay;
document.getElementById('check_num_day').innerText = numDay;

function scrollToBed() {
    var elmnt = document.getElementById("rooms");
    elmnt.scrollIntoView();
}

function changeNumRoom(_index, value) {
    totalMoney = 0;
    totalPerDayMoney = 0;
    var totalNumRoom = 0;
    var text = '';
    var reserve_text = '';
    var reserve_money_text = '';
    room_code = [];
    adult_count = [];
    extra = [];
    num_room_code = [];
    room_name = [];
    for (i = 0; i < rooms.length; i++) {
        numRoom = parseInt(document.getElementById('roomNumber' + i).value);
        totalNumRoom += numRoom;
        price = parseInt(rooms[i].perDay[0].price);
        priceExtraBed = rooms[i].priceExtraGuest;
        extraBed = document.getElementById('additional_bed' + i).checked;
        totalPerDayMoney += numRoom * Math.floor(price / 1000) * 1000;
        if (numRoom != 0) {
            room_code.push(rooms[i].roomNumber);
            adult_count.push(rooms[i].capacity['adultCount']);
            num_room_code.push(numRoom);
            room_name.push(rooms[i].name);
            text += '<div><span>X' + numRoom + '</span>' + rooms[i].name;
            reserve_money_text += '<div><span class="float-right">X' + numRoom + '</span><span class="float-right">' + rooms[i].name + '</span>';
            reserve_text += '<div id="changeNumRoomMainDiv" class="row">\n' +
                '<div class="col-md-9">\n' +
                '<div class="row display-flex flex-direction-row">\n' +
                '<div>\n' +
                '<span class="color-darkred">نام اتاق: </span>\n' +
                '<span>' + rooms[i].name + '</span>\n' +
                '</div>\n' +
                '<div class="width-33per">\n' +
                '<span class="color-darkred">تاریخ ورود: </span>\n' +
                '<span>{{session("goDate")}}</span>\n' +
                '</div>\n' +
                '<div class="width-33per">\n' +
                '<span class="color-darkred">تاریخ خروج: </span>\n' +
                '<span>{{session("backDate")}}</span>\n' +
                '</div>\n' +
                '</div>\n' +
                '<div class="row display-flex flex-direction-row mg-2per-0">\n' +
                '<div class="width-33per">\n' +
                '<span class="color-darkred">تعداد مسافر: </span>\n' +
                '<span>' + rooms[i].capacity.adultCount + '</span>\n' +
                '</div>\n' +
                '<div class="width-33per">\n' +
                '<span class="color-darkred">سرویس تخت اضافه: </span>\n';
            if (extraBed) {
                text += '<span class="font-size-085em">با تخت اضافه</span>';
                reserve_money_text += '<span class="font-size-0.85em float-right">با تخت اضافه</span><span class="float-left">' + dotedNumber((Math.floor(priceExtraBed / 1000) * 1000) + (Math.floor(price / 1000) * 1000)) + '</span>';
                totalPerDayMoney += numRoom * Math.floor(priceExtraBed / 1000) * 1000;
                reserve_text += '<span>دارد</span>\n';
                extra.push(true);
            } else {
                reserve_money_text += '<span class="float-left">' + dotedNumber(Math.floor(price / 1000) * 1000) + '</span>';
                reserve_text += '<span>ندارد</span>\n';
                extra.push(false);
            }
            text += '</div>';
            reserve_money_text += '</div>';
            reserve_text += '</div>\n' +
                '</div><div class="row display-flex flex-direction-row">\n' +
                '<div>\n' +
                '<span class="color-darkred"> صبحانه مجانی: </span>\n' +
                '<span>دارد</span>\n' +
                '</div>\n' +
                '</div>\n' +
                '</div>\n';
            reserve_text += '<div class="col-md-3"><img src="' + rooms[i].pic + '" class="full-width"></div></div>';
        }
    }
    totalMoney += totalPerDayMoney * numDay;
    document.getElementById('totalPriceOneDay').innerText = dotedNumber(totalPerDayMoney);
    document.getElementById('totalPrice').innerText = dotedNumber(totalMoney);
    document.getElementById('check_total_price').innerText = dotedNumber(totalMoney);
    document.getElementById('totalNumRoom').innerText = totalNumRoom;
    document.getElementById('check_total_num_room').innerText = totalNumRoom;
    document.getElementById('discriptionNumRoom').innerHTML = text;
    document.getElementById('check_description').innerHTML = reserve_money_text;
    document.getElementById('selected_rooms').innerHTML = reserve_text;
}

function showReserve() {
    if (totalMoney > 0)
        document.getElementById('check_room').style.display = 'flex';
}

function updateSession() {
    $.ajax({
        url: updateSession,
        type: 'post',
        data: {
            'room_code': room_code,
            'adult_count': adult_count,
            'extra': extra,
            'num_room_code': num_room_code,
            'room_name': room_name,
            'hotel_name': placeName,
            'rph': '{{$place->rph}}',
            'backURL': window.location.href
        },
        success: function (response) {
            window.location.href = '{{url('buyHotel')}}';
        }
    })
}



var passengerNoSelect = false;
$(".room").html(room);
$(".adult").html(adult);
$(".children").html(children);
for (var i = 0; i < children; i++) {
    $(".childBox").append("" +
        "<div class='childAge' data-id='" + i + "'>" +
        "<div>سن بچه</div>" +
        "<div><select class='selectAgeChild' name='ageOfChild' id='ageOfChild'>" +
        "<option value='0'>1<</option>" +
        "<option value='1'>1</option>" +
        "<option value='2'>2</option>" +
        "<option value='3'>3</option>" +
        "<option value='4'>4</option>" +
        "<option value='5'>5</option>" +
        "</select></div>" +
        "</div>");
}

function togglePassengerNoSelectPane() {
    if (!passengerNoSelect) {
        passengerNoSelect = true;
        $("#passengerNoSelectPane").removeClass('hidden');
        $("#passengerNoSelectPane1").removeClass('hidden');
        $("#passengerArrowUp").removeClass('hidden');
        $("#passengerArrowDown").addClass('hidden');
    }
    else {
        $("#passengerNoSelectPane").addClass('hidden');
        $("#passengerNoSelectPane1").addClass('hidden');
        $("#passengerArrowDown").removeClass('hidden');
        $("#passengerArrowUp").addClass('hidden');
        passengerNoSelect = false;
    }
}

function addClassHidden(element) {
    $("#" + element).addClass('hidden');
    if (element == 'passengerNoSelectPane' || element == 'passengerNoSelectPane1') {
        $("#passengerArrowDown").removeClass('hidden');
        $("#passengerArrowUp").addClass('hidden');
    }
}

function changeRoomPassengersNum(inc, mode) {
    switch (mode) {
        case 3:
        default:
            if (room + inc >= 0)
                room += inc;

            if (room > 0 && adult == 0) {
                adult = 1;
                $("#adultPassengerNumInSelect").empty().append(adult);
                $("#adultPassengerNumInSelect1").empty().append(adult);
            }

            $("#roomNumInSelect").empty().append(room);
            $("#roomNumInSelect1").empty().append(room);
            break;
        case 2:
            if (adult + inc >= 0)
                adult += inc;
            $("#adultPassengerNumInSelect").empty().append(adult);
            $("#adultPassengerNumInSelect1").empty().append(adult);
            break;
        case 1:
            if (children + inc >= 0)
                children += inc;
            if (inc >= 0) {
                $(".childBox").append("<div class='childAge' data-id='" + (children - 1) + "'>" +
                    "<div>سن بچه</div>" +
                    "<div><select class='selectAgeChild' name='ageOfChild' id='ageOfChild'>" +
                    "<option value='0'>1<</option>" +
                    "<option value='1'>1</option>" +
                    "<option value='2'>2</option>" +
                    "<option value='3'>3</option>" +
                    "<option value='4'>4</option>" +
                    "<option value='5'>5</option>" +
                    "</select></div>" +
                    "</div>");
                ;
            } else {
                $(".childAge[data-id='" + (children) + "']").remove();
            }
            $("#childrenPassengerNumInSelect").empty().append(children);
            $("#childrenPassengerNumInSelect1").empty().append(children);
            break;
    }
    var text = '<span class="float-right">' + room + '</span>&nbsp;\n' +
        '                                                <span>اتاق</span>&nbsp;-&nbsp;\n' +
        '                                                <span id="childPassengerNo">' + adult + '</span>\n' +
        '                                                <span>بزرگسال</span>&nbsp;-&nbsp;\n' +
        '                                                <span id="infantPassengerNo">' + children + '</span>\n' +
        '                                                <span>بچه</span>&nbsp;';
    // document.getElementById('roomDetailRoom').innerHTML = text;
    while ((4 * room) < adult) {
        room++;
        $("#roomNumInSelect").empty().append(room);
    }
    document.getElementById('num_room').innerText = room;
    document.getElementById('num_adult').innerText = adult;
}