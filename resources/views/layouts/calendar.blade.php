<link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/calendar.css?v=1')}}'/>
<script src= {{URL::asset("js/calendar.js") }}></script>
{{--<script src= {{URL::asset("js/jalali.js") }}></script>--}}
<script src= {{URL::asset("js/component/myCalendar.js") }}></script>

<div id="myCalendarHtml">
    <div id="container1" class="calenderBase" style="width: 100%">
        <div id="calendarJalali">
            <div id="calendarJalali1">
                <div class="calendar">
                    <input type="hidden" id="goJalali">
                    <header>
                        <select id="select_month_go" onchange="getNewMonth(this.value, 'go')"></select>
                        <a class="ticketIcon leftArrowIcone leftInCalender" onclick="nextMonth('go')"></a>
                        <a class="ticketIcon rightArrowIcone rightInCalender" onclick="prevMonth('go')"></a>
                    </header>
                    <table>
                        <thead>
                            <tr class="myCalendarJalaliHeader"></tr>
                        </thead>
                        <tbody>
                        <tr id="row_go_0"></tr>
                        <tr id="row_go_1"></tr>
                        <tr id="row_go_2"></tr>
                        <tr id="row_go_3"></tr>
                        <tr id="row_go_4"></tr>
                        <tr id="row_go_5"></tr>
                        </tbody>
                    </table>
                </div> <!-- end calendar -->
            </div>
            <div id="calendarJalali2">
                <div class="calendar">
                    <header>
                        <input type="hidden" id="backJalali">
                        <select id="select_month_back" onchange="getNewMonth(this.value, 'back')"></select>
                        <a class="ticketIcon leftArrowIcone leftInCalender" onclick="nextMonth('back')"></a>
                        <a class="ticketIcon rightArrowIcone rightInCalender" onclick="prevMonth('back')"></a>
                    </header>
                    <table>
                        <thead>
                        <tr>
                            <td>شنبه</td>
                            <td>یک شنبه</td>
                            <td>دو شنبه</td>
                            <td>سه شنبه</td>
                            <td>چهار شنبه</td>
                            <td>پنج شنبه</td>
                            <td>جمعه</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr id="row_back_0"></tr>
                        <tr id="row_back_1"></tr>
                        <tr id="row_back_2"></tr>
                        <tr id="row_back_3"></tr>
                        <tr id="row_back_4"></tr>
                        <tr id="row_back_5"></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="calendarGregorian">
            <div id="calendarGregorian1">
                <div class="calendarGre">
                    <header>
                        <input type="hidden" id="goGre">
                        <select id="select_month_gre_go" onchange="getNewMonthGre(this.value, 'go')"></select>
                        <a class="ticketIcon leftArrowIcone leftInCalenderGre" onclick="prevMonthGre('go')"></a>
                        <a class="ticketIcon rightArrowIcone rightInCalenderGre" onclick="nextMonthGre('go')"></a>
                    </header>
                    <table>
                        <thead>
                        <tr>
                            <td>Mon</td>
                            <td>Tue</td>
                            <td>Wed</td>
                            <td>Thu</td>
                            <td>Fri</td>
                            <td>Sat</td>
                            <td>Sun</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr id="row_gre_go_0"></tr>
                        <tr id="row_gre_go_1"></tr>
                        <tr id="row_gre_go_2"></tr>
                        <tr id="row_gre_go_3"></tr>
                        <tr id="row_gre_go_4"></tr>
                        <tr id="row_gre_go_5"></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="calendarGregorian2">
                <div class="calendarGre">
                    <header>
                        <input type="hidden" id="backGre">
                        <select id="select_month_gre_back" onchange="getNewMonthGre(this.value, 'back')"></select>
                        <a class="ticketIcon leftArrowIcone leftInCalenderGre" onclick="prevMonthGre('back')"></a>
                        <a class="ticketIcon rightArrowIcone rightInCalenderGre" onclick="nextMonthGre('back')" ></a>
                    </header>
                    <table>
                        <thead>
                        <tr>
                            <td>Mon</td>
                            <td>Tue</td>
                            <td>Wed</td>
                            <td>Thu</td>
                            <td>Fri</td>
                            <td>Sat</td>
                            <td>Sun</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr id="row_gre_back_0"></tr>
                        <tr id="row_gre_back_1"></tr>
                        <tr id="row_gre_back_2"></tr>
                        <tr id="row_gre_back_3"></tr>
                        <tr id="row_gre_back_4"></tr>
                        <tr id="row_gre_back_5"></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="JalaliButton" class="bottomBtn">
            <button type="button" class="cancelBtn" onclick="closeCalender()">انصراف</button>
            <button type="button" class="differentCalendarBtn" onclick="changeDateKind(1)">Gregorian</button>
        </div>
        <div id="GregorianButton" class="bottomBtn">
            <button type="button" class="cancelBtn" onclick="closeCalender()">Cancel</button>
            <button type="button" class="differentCalendarBtn" onclick="changeDateKind(2)">شمسی</button>
        </div>
    </div>
</div>

<script>
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
</script>
