<link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/calendar.css?v=1')}}'/>
<script src= {{URL::asset("js/calendar.js") }}></script>
{{--<script src= {{URL::asset("js/jalali.js") }}></script>--}}
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

<script src= {{URL::asset("js/component/myCalendar.js") }}></script>
