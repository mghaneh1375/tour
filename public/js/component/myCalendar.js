var myCalendarHtml;
$.fn.myCalendar = function(_options) {
    var date = new Date();
    var jalaliDateHtml = '';
    var settings = $.extend({
        show: false,
        code: Math.floor(Math.random()*10000),
        jDateName: ['شنبه', 'یک شنبه', 'دوشنبه', 'سه شنبه', 'چهارشنبه', 'پنج شنبه', 'جمعه'],
        selectedSJDate: [date.getJalaliFullYear(), date.getJalaliMonth(), date.getJalaliDate()],
        selectedEJDate: [null, null, null],
        selectedSGDate: [date.getFullYear(), date.getMonth(), date.getDate()],
        selectedEGDate: [null, null, null],
    }, _options );

    settings.jDateName.map(item => jalaliDateHtml += `<td>${item}</td>`);

    $(this).html(myCalendarHtml);
    $(this).find('.myCalendarJalaliHeader').html(jalaliDateHtml);

    if(settings.show)
        $(this).show();
    else
        $(this).hide();

    return this;
};


var myCalendarDateName = ['شنبه', 'یک شنبه', 'دوشنبه', 'سه شنبه', 'چهارشنبه', 'پنج شنبه', 'جمعه'];
var calendarIsOpen = false;
var date = new Date();
var numClick = 2;
var checkOpen = true;

var numOfCalendar = 1;
var nowYear = date.getJalaliFullYear();
var nowMonth = date.getJalaliMonth();
var nowDate = date.getJalaliDate();
var backYear = nowYear;
var backMonth = parseInt(nowMonth) + 1;
var backDate = nowDate;
if (backMonth == 12) {
    backYear = parseInt(backYear) + 1;
    backMonth = 0;
}

var nowYearGre = date.getFullYear();
var nowMonthGre = date.getMonth();
var nowDateGre = date.getDate();

var backYearGre = nowYearGre;
var backMonthGre = parseInt(nowMonthGre) + 1;
var backDateGre = nowDateGre;
if (backMonthGre == 12) {
    backYearGre = parseInt(backYearGre) + 1;
    backMonthGre = 0;
}

var firstMonth;
var firstMonthBack;

var firstMonthGre ;
var firstMonthGreBack;


var selectDays = [[nowYear, nowMonth,nowDate], [null, null, null]];

changeTwoCalendar(1);

function changeTwoCalendar(num) {
    if (num == 1) {
        numClick = 0;
        numOfCalendar = 1;
        $('#calendarJalali2').hide();
        $('#calendarGregorian2').hide();
        $('#calendarJalali1').css('width', '100%');
        $('#calendarGregorian1').css('width', '100%');

        // document.getElementById('backDate').value = '';
        selectDays[1][1] = null;
        checkOpen = true;
    }
    else {
        numOfCalendar = 2;
        $('#calendarJalali2').css('display', 'inline-block');
        $('#calendarGregorian2').css('display', 'inline-block');
        $('#calendarJalali1').css('width', '49%');
        $('#calendarGregorian1').css('width', '49%');

        // document.getElementById('container1').style.width = '65%';
        checkOpen = true;

    }
}

function assignDate(from, id, btnId) {
    $("#" + id).css("visibility", "visible");

    if (btnId == "backDate" && $("#date_input1").val().length != 0)
        from = $("#date_input1").val();

    if (btnId == "backDate" && $("#date_input1_phone").val().length != 0)
        from = $("#date_input1_phone").val();

    $("#" + btnId).datepicker({
        numberOfMonths: 2,
        showButtonPanel: true,
        minDate: from,
        dateFormat: "yy/mm/dd"
    });
}

var cal0;
var cal1;
function initMyCalendar(_id, _dateName = myCalendarDateName){
    // $('#myCalendarJalaliDateNameRow').html(text);
    nowCalendar();

    // $(`#${_id}`).myCalendar({
    //     jDateName: _dateName,
    //     show: true,
    // });
}

// $(window).ready(() => {
//     myCalendarHtml = $('#myCalendarHtml').html();
//     $('#myCalendarHtml').remove();
// });

