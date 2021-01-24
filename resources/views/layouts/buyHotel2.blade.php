<?php
$ticket = \App\models\InnerFlightTicket::first();
$adult = session('adult');
$infant = 0;
$child = session('children');
$rooms = json_decode(session('reserve_room'));
$num_room = 0;
?>

<link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/buyHotel2.css?v=1')}}'/>

<div class="full-width">
    <div class="float-right"> شما در حال انتقال به سایت فروشنده بلیط هستید</div>
    <div class="text-align-left">
        <a href="{{session('backURL')}}" class="color-5-12-147Imp"> بازگشت به صفحه اطلاعات هتل >> </a>
    </div>
</div>

<div class="inlineBorder"></div>
<form id="reserve_form" method="post" action="{{route('sendReserveRequest')}}">
    {{csrf_field()}}
    <div class="full-width mg-bt-3per">
        <div> اطلاعاتی که در این صفحه وارد می کنید به سایت پذیرنده منتقل می شود تا خرید شما آسان تر از قبل گردد</div>
        <div class="textTitle"> اطلاعات تماس</div>
        <div class="font-size-08em"> این اطلاعات به عنوان اطلاعات تماس شما در شازده ثبت می شود</div>
        <div class="width-60per height-120">
            <div id="phone_error_text">پر کردن این بخش اجباری است</div>
            <div class="inputBox width-30per float-right">
                <div class="inputBoxText">
                    <div class="display-inline-block position-relative">
                        <div class="afterBuyIcon redStar"></div>
                        تلفن همراه
                    </div>
                </div>
                <input class="inputBoxInput" id="phoneNumForTicket" type="tel" onkeypress="return isNumber(event)" placeholder="0912xxxxxxx" name="phone" onchange="clearError(0, 0)"
                       @if(auth()->check() && auth()->user()->phone != '' && auth()->user()->phone != null ) value="{{auth()->user()->phone}}" @endif>
            </div>
            <div class="width-40per float-left">
                <div id="email_error_text">پر کردن این بخش اجباری است</div>
                <div class="inputBox width-85per">
                    <div class="inputBoxText">
                        <div class="display-inline-block position-relative">
                            <div class="afterBuyIcon redStar"></div>
                            ایمیل
                        </div>
                    </div>
                    <input class="inputBoxInput" id="emailForTicket" type="email" placeholder="example@domain.com" name="email" onchange="clearError(0, 1)"
                           @if(auth()->check() && auth()->user()->email != '' && auth()->user()->email != null ) value="{{auth()->user()->email}}" @endif>
                </div>
                <div class="check-box__item mg-tp-5">
                    <label class="labelEdit"> اطلاعات مهم را با این آدرس به من اطلاع دهید </label>
                    <input type="checkbox" id="importantInformation" name="otherOffer" value="اطلاعات مهم" class="display-inline-blockImp">
                </div>
                <div class="check-box__item">
                    <label class="labelEdit"> اخبار مربوط به علایق من را با این آدرس برای من بفرستید </label>
                    <input type="checkbox" id="interestNews" name="otherOffer" value="اخبار مورد علاقه" class="display-inline-blockImp">
                </div>
            </div>
        </div>
    </div>

    <div class="inlineBorder"></div>

    <div>
        <div class="textTitle"> اطلاعات مسافرین</div>
        <div>
            <div class="height-50 mg-bt-25">
                <div class="roomBox">
                    <div id="roomDetail">
                        <span class="float-right room">{{$num_room}}</span>&nbsp;
                        <span>اتاق</span>&nbsp;-&nbsp;
                        <span class="adult">{{session('adult')}}</span>
                        <span>بزرگسال</span>&nbsp;
                    </div>
                    <div class="shTIcon passengerIcon font-size-25 display-inline-block"></div>
                </div>
                <div class="calenderBox">
                    <label id="calendar-container-edit-1placeDate" class="dateLabel">
                        <span class="ui_icon calendar calendarIcon" ></span>
                        <input type="text" class="inputDateLabel border-none width-80" value="{{session('goDate')}}" readonly="">
                    </label>
                    <span class="calendarBoxTillStyles">تا</span>
                    <label id="calendar-container-edit-2placeDate" class="dateLabel">
                        <input type="text" class="inputDateLabel border-none width-80" value="{{session('backDate')}}" readonly="">
                    </label>
                </div>
            </div>

    </div>

    <div class="inlineBorder"></div>

    @for($step = 0, $k = 0; $step < 3; $step++)
        @for($j = 0; $j < 3; $j++, $k++)
            <div id="passenger_{{$k}}">
                <div>
                    <div>
                        <div class="display-inline-block">
                            @if($k == 0 && Auth::check())
                                <div class="textTitle">
                                    <span id="passengerInfo_{{$k}}"></span>
                                    <span>111}</span>
                                </div>
                                <div class="mainPassengerDiv">مسافر اصلی</div>
                                <button onclick="getMyInfo()" class="btn afterBuyBtn bg-color-green" type="button"> من هستم</button>
                                <div class="autoFillInputs">
                                    اطلاعات موجود از پروفایل شما پر می گردد
                                </div>

                            @else
                                <div class="textTitle" id="passengerInfo_{{$k}}">222</div>
                            @endif
                        </div>
                        <div class="float-left position-relative">
                            <button onclick="deletePassenger('{{$k}}')" class="btn afterBuyBtn color-146-50-27" type="button">
                                حذف مسافر
                            </button>

                            @if(Auth::check())
                                <button onclick="toggleOldPassenger('{{$k}}')" class="btn afterBuyBtn bg-color-green" type="button">
                                    مسافرین سابق
                                </button>
                                <div class="class_passengerOldPane item hidden" id="oldPassengerPane_{{$k}}"
                                     onmouseleave="addClassHidden('oldPassengerPane_{{$k}}'); passengerNoSelect = false;">
                                    <div>
                                        <p>مسافرین سابق</p>
                                        <div class="lastPassengersDivider"></div>
                                        <div id="passengerList_{{$k}}"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="check-box__item mg-tp-5">
                        <label class="labelEdit"> تبعه خارجی هستم </label>
                        <input onclick="changeForeignRow('{{$k}}')" id="foreign_{{$k}}" name="foreign[]" value="خارجی"
                               type="checkbox" class="display-inline-blockImp">
                    </div>

                        <div class="full-width">
                        <div>
                            <div id="nameFa_error_text_{{$k}}" class="essentialInfos">پر کردن این بخش اجباری است</div>
                            <div class="inputBox width-21per">
                                <div class="inputBoxText">
                                    <div class="display-inline-block position-relative">
                                        <div class="afterBuyIcon redStar"></div>
                                        نام
                                    </div>
                                </div>
                                <input class="inputBoxInput" id="nameFa_{{$k}}" name="nameFa[]" type="text"
                                       placeholder="فارسی" onchange="clearError(1,{{$k}})">
                            </div>
                            <div id="familyFa_error_text_{{$k}}" class="essentialInfos">پر کردن این بخش اجباری است</div>
                            <div class="inputBox width-25per mg-rt-10per">
                                <div class="inputBoxText">
                                    <div class="display-inline-block position-relative">
                                        <div class="afterBuyIcon redStar"></div>
                                        نام خانوادگی
                                    </div>
                                </div>
                                <input class="inputBoxInput" type="text" name="familyFa[]" id="familyFa_{{$k}}"
                                       placeholder="فارسی" onchange="clearError(2,{{$k}})">
                            </div>
                        </div>
                        <div>
                            <div id="nameEn_error_text_{{$k}}" class="essentialInfos">پر کردن این بخش اجباری است</div>
                            <div class="inputBox width-21per">
                            <div class="inputBoxText">
                                <div class="display-inline-block position-relative">
                                    <div class="afterBuyIcon redStar"></div>
                                    نام
                                </div>
                            </div>
                            <input class="inputBoxInput" name="nameEn[]" id="nameEn_{{$k}}" type="text"
                                   placeholder="لاتین" onchange="clearError(3,{{$k}})">
                        </div>
                            <div id="familyEn_error_text_{{$k}}" class="essentialInfos">پر کردن این بخش اجباری است</div>
                            <div class="inputBox width-25per mg-rt-10per">
                                <div class="inputBoxText">
                                    <div class="display-inline-block position-relative">
                                        <div class="afterBuyIcon redStar"></div>
                                        نام خانوادگی
                                    </div>
                                </div>
                                <input class="inputBoxInput" type="text" placeholder="لاتین" name="familyEn[]"
                                       id="familyEn_{{$k}}" onchange="clearError(4,{{$k}})">
                            </div>
                        </div>
                        <div>
                            <div id="birthDay_error_text_{{$k}}" class="essentialInfos">پر کردن این بخش اجباری است</div>
                            <div class="inputBox width-21per">
                                <div class="inputBoxText">
                                    <div class="display-inline-block position-relative">
                                        <div class="afterBuyIcon redStar"></div>
                                        تاریخ تولد
                                    </div>
                                </div>
                                <select name="birthDayD[]" id="birthDayD_{{$k}}" class="inputBoxSelect" onchange="clearError(5,{{$k}})" required>
                                    <option value="0"> روز</option>
                                    @for($i = 1; $i < 32; $i++)
                                        <option value="{{$i}}"> {{$i}} </option>
                                    @endfor
                                </select>
                                <select name="birthDayM[]" id="birthDayM_{{$k}}" class="inputBoxSelect" onchange="clearError(5,{{$k}})" required>
                                    <option value="0"> ماه</option>
                                    <option value="1"> فروردین</option>
                                    <option value="2"> اردیبهشت</option>
                                    <option value="3"> خرداد</option>
                                    <option value="4"> تیر</option>
                                    <option value="5"> مرداد</option>
                                    <option value="6"> شهریور</option>
                                    <option value="7"> مهر</option>
                                    <option value="8"> آبان</option>
                                    <option value="9"> آذر</option>
                                    <option value="10"> دی</option>
                                    <option value="11"> بهمن</option>
                                    <option value="12"> اسفند</option>
                                </select>
                                <select name="birthDayY[]" id="birthDayY_{{$k}}" class="inputBoxSelect" onchange="clearError(5,{{$k}})" required>
                                    <option value="0"> سال</option>
                                    @for($i = 1330; $i < 1398; $i++)
                                        <option value="{{$i}}"> {{$i}} </option>
                                    @endfor
                                </select>
                            </div>
                            <div id="NID_error_text_{{$k}}" class="essentialInfos">پر کردن این بخش اجباری است</div>
                            <div class="inputBox width-25per mg-rt-10per">
                                <div class="inputBoxText width-50per">
                                    <div class="display-inline-block position-relative">
                                        <div class="afterBuyIcon redStar"></div>
                                        <span id="nidOrPassport_{{$k}}">کد ملی</span></div>
                                </div>
                                <input onkeypress="return isNumber(event)" name="NID[]" id="NID_{{$k}}" class="inputBoxInput width-50per" type="text"
                                       placeholder="000000000" onchange="clearError(6,{{$k}})">
                            </div>
                            <div class="inputBox width-13per mg-rt-10per">
                                <div class="inputBoxText width-50per">
                                    <div class="display-inline-block position-relative">
                                        <div class="afterBuyIcon redStar"></div>
                                        جنسیت
                                    </div>
                                </div>
                                <select name="sex[]" id="sex_{{$k}}" class="inputBoxSelect width-30per mg-0-9" required>
                                    <option value="female"> زن</option>
                                    <option value="male"> مرد</option>
                                </select>
                            </div>
                        </div>
                        <div id="foreignRow_{{$k}}" class="hidden">
                            <div id="expire_error_text_{{$k}}" class="essentialInfos">پر کردن این بخش اجباری است</div>
                            <div class="inputBox width-21per">
                                <div class="inputBoxText">
                                    <div class="display-inline-block position-relative"> تاریخ انقضا</div>
                                </div>
                                <select name="expireD[]" id="expireD_{{$k}}" class="inputBoxSelect" required>
                                    <option value=""> روز</option>
                                    @for($i = 1; $i < 32; $i++)
                                        <option value="{{$i}}"> {{$i}} </option>
                                    @endfor
                                </select>
                                <select name="expireM[]" id="expireM_{{$k}}" class="inputBoxSelect" required>
                                    <option value=""> ماه</option>
                                    <option value="1"> فروردین</option>
                                    <option value="2"> اردیبهشت</option>
                                    <option value="3"> خرداد</option>
                                    <option value="4"> تیر</option>
                                    <option value="5"> مرداد</option>
                                    <option value="6"> شهریور</option>
                                    <option value="7"> مهر</option>
                                    <option value="8"> آبان</option>
                                    <option value="9"> آذر</option>
                                    <option value="10"> دی</option>
                                    <option value="11"> بهمن</option>
                                    <option value="12"> اسفند</option>
                                </select>
                                <select name="expireY[]" id="expireY_{{$k}}" class="inputBoxSelect" required>
                                    <option value=""> سال</option>
                                    @for($i = 1330; $i < 1398; $i++)
                                        <option value="{{$i}}"> {{$i}} </option>
                                    @endfor
                                </select>
                            </div>
                            <div id="countryCode_error_text_{{$k}}" class="essentialInfos">پر کردن این بخش اجباری است</div>
                            <div id="searchDivForScroll_{{$k}}" class="inputBox searchDivForScroll width-25per mg-rt-10per">
                                <div class="inputBoxText">
                                    <div class="display-inline-block position-relative"> محل صدور</div>
                                </div>
                                <input onkeyup="searchCountryCode(event, '{{$k}}')" name="countryCode[]"
                                       id="countryCode_{{$k}}" class="inputBoxInput" type="text" placeholder="Iran">
                                <div id="result_{{$k}}" class="data_holder"></div>
                            </div>
                        </div>
                        <div class="questions_div">
                            <div class="questions">
                                <div class="question">
                                    ایا مسافری با تابعیت خارجی در این تاق اقامت خواهد داشت؟
                                </div>
                                <div class="answer" onclick="changeAnswer({{$k}}, 1)">
                                    <div class="common_answer common_answer_right" id="yes_1_{{$k}}">
                                        بلی
                                    </div>
                                    <div class="common_answer choose_answer common_answer_left" id="no_1_{{$k}}">
                                        خیر
                                    </div>
                                </div>
                            </div>

                            <div class="questions">
                                <div class="question">
                                    ایا شما به مسافرت کاری می روید؟
                                </div>
                                <div class="answer" onclick="changeAnswer({{$k}}, 2)">
                                    <div class="common_answer common_answer_right" id="yes_2_{{$k}}">
                                        بلی
                                    </div>
                                    <div class="common_answer choose_answer common_answer_left" id="no_2_{{$k}}">
                                        خیر
                                    </div>
                                </div>
                            </div>

                            <div class="questions">
                                <div class="question">
                                    ایا درخواست ترانسفر فرودگاهی دارید؟
                                </div>
                                <div class="answer" onclick="changeAnswer({{$k}}, 3)">
                                    <div class="common_answer common_answer_right" id="yes_3_{{$k}}">
                                        بلی
                                    </div>
                                    <div class="common_answer choose_answer common_answer_left" id="no_3_{{$k}}">
                                        خیر
                                    </div>
                                </div>
                            </div>

                            <div class="questions">
                                <div class="question">
                                    ایا کودکان همراه شما در این اتاق اقامت دارند؟
                                </div>
                                <div class="answer" onclick="changeAnswer({{$k}}, 4)">
                                    <div class="common_answer common_answer_right" id="yes_4_{{$k}}">
                                        بلی
                                    </div>
                                    <div class="common_answer choose_answer common_answer_left" id="no_4_{{$k}}">
                                        خیر
                                    </div>
                                </div>
                            </div>

                            <div class="questions helpUsText">
                                <div>
                                    اگر درخواست یا ملاحظه ی دیگری دارید حتما بنویسید تا ما با میزبان شما درمیان بگذاریم
                                </div>
                                <div class="mg-tp-5">
                                    <textarea class="requestArea" id="textArea{{$k}}" onchange="roomRequest({{$k}})" rows="4" placeholder="درخواست خود را وارد کنید"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                        @if($mode == 2 || Auth::check())
                        <div id="saveInformation_div_{{$k}}" class="check-box__item mg-tp-5">
                            <label class="labelEdit"> این اطلاعات در قسمت مسافر ها ذخیره شود. در صورت ذخیره اطلاعات در هنگام
                                خرید بلیط دیگر نیاز به وارد کردن اطلاعات این مسافر نمی باشد و تنها با وارد کردن نام می توان
                                اطلاعات را به طور کامل وارد نمود </label>
                            <input type="checkbox" id="saveInformation_{{$k}}" name="saveInformation[]"
                                   value="ذخیره اطلاعات" class="display-inline-blockImp">
                        </div>
                    @endif
                </div>
                <div class="inlineBorder"></div>
            </div>
        @endfor
    @endfor

</form>

<script>
    var passengerNoSelect = false;
    var passengers = [];
    var getMyPassengersBool = false;
    var ageArr = [];
    var nums = ['اول', 'دوم', 'سوم', 'چهارم', 'پنجم', 'ششم', 'هفتم', 'هشتم', 'نهم'];
    var currIdx = 0, suggestions = [];
    var nameFa = [];
    var familyFa = [];
    var nameEn = [];
    var familyEn = [];
    var NID = [];
    var birthDay = [];
    var birthDayD = [];
    var birthDayM = [];
    var birthDayY = [];
    var foreign = [];
    var expire = [];
    var expireD = [];
    var expireM = [];
    var expireY = [];
    var countryCode = [];
    var sex = [];
    var savedInformation = [];
    var ageType = [];
    var allow = [];
    var phoneNum;
    var email ;
    var informMe = [];
    var newsMe = [];
    var username = [];
    var pass = [];
    var rPass = [];
    var room_code = [];
    var hasRegister = false;
    var order_id = '{{session('orderId')}}';
    var reserve_request_id = '{{session('reserveRequestId')}}';
    var answers = [];
    var request = [];
    var check_time = true;
    var check_reserve = 10;
    var user_id = 0 ;

    var k = 0;
{{--    @for($step = 0, $k = 0; $step < count($rooms->num_room_code); $step++)--}}
{{--        @for($j = 0; $j < $rooms->num_room_code[$step]; $j++, $k++)--}}
{{--            answers[k] = ['false', 'false', 'false', 'false'];--}}
{{--            request[k] = '';--}}
{{--            k++;--}}
{{--        @endfor--}}
{{--    @endfor--}}

    function changeForeignRow(idx) {
        if ($("#foreign_" + idx).prop('checked')) {
            $("#foreignRow_" + idx).removeClass('hidden');
            $("#nidOrPassport_" + idx).empty().append('شماره پاسپورت');
        }
        else {
            $("#nidOrPassport_" + idx).empty().append('کد ملی');
            $("#foreignRow_" + idx).addClass('hidden');
        }
    }
    function searchCountryCode(e, idx) {
        val = $("#countryCode_" + idx).val();
        $(".suggest").css("background-color", "transparent").css("padding", "0").css("border-radius", "0");
        if (null == val || "" == val || val.length < 2)
            $("#result_" + idx).empty();
        else {
            var scrollVal = $("#searchDivForScroll").scrollTop();
            if (13 == e.keyCode && -1 != currIdx) {
                $("#countryCode_" + idx).val(suggestions[currIdx].code);
                $("#result_" + idx).empty();
                return;
            }
            if (13 == e.keyCode && -1 == currIdx && suggestions.length > 0) {
                $("#countryCode_" + idx).val(suggestions[0].code);
                $("#result_" + idx).empty();
                return;
            }
            if (40 == e.keyCode) {
                if (currIdx + 1 < suggestions.length) {
                    currIdx++;
                    $("#searchDivForScroll").scrollTop(scrollVal + 25);
                }
                else {
                    currIdx = 0;
                    $("#searchDivForScroll").scrollTop(0);
                }
                if (currIdx >= 0 && currIdx < suggestions.length) {
                    $("#suggest_" + currIdx).css("background-color", "#dcdcdc").css("padding", "10px").css("border-radius", "5px");
                }
                return;
            }
            if (38 == e.keyCode) {
                if (currIdx - 1 >= 0) {
                    currIdx--;
                    $("#searchDivForScroll").scrollTop(scrollVal - 25);
                }
                else {
                    currIdx = suggestions.length - 1;
                    $("#searchDivForScroll").scrollTop(25 * suggestions.length);
                }
                if (currIdx >= 0 && currIdx < suggestions.length)
                    $("#suggest_" + currIdx).css("background-color", "#dcdcdc").css("padding", "10px").css("border-radius", "5px");
                return;
            }
            if ("ا" == val[0]) {
                val2 = "آ";
                for (i = 1; i < val.length; i++)
                    val2 += val[i];
                $.ajax({
                    type: "post",
                    url: '{{route('ajax.searchInCounty')}}',
                    data: {
                        key: val,
                        key2: val2
                    },
                    success: function (response) {
                        newElement = "";
                        if (response.length == 0) {
                            newElement = "موردی یافت نشد";
                            $("#countryCode_" + idx).val("");
                            return;
                        }
                        response = JSON.parse(response);
                        currIdx = -1;
                        suggestions = response;
                        for (i = 0; i < response.length; i++)
                            newElement += "<p class='suggest cursor-pointer' id='suggest_" + i + "' onclick='setInput(\"" + response[i].code + "\", \"" + idx + "\")'>" + response[i].name + " - " + response[i].nameEn + "</p>";
                        $("#result_" + idx).empty().append(newElement)
                    }
                })
            }
            else $.ajax({
                type: "post",
                url: '{{route('ajax.searchInCounty')}}',
                data: {
                    key: val
                },
                success: function (response) {
                    newElement = "";
                    if (response.length == 0) {
                        newElement = "موردی یافت نشد";
                        $("#countryCode_" + idx).val("");
                        return;
                    }
                    response = JSON.parse(response);
                    currIdx = -1;
                    suggestions = response;
                    for (i = 0; i < response.length; i++)
                        newElement += "<p class='suggest cursor-pointer' id='suggest_" + i + "' onclick='setInput(\"" + response[i].code + "\", \"" + idx + "\")'>" + response[i].name + " - " + response[i].nameEn + "</p>";
                    $("#result_" + idx).empty().append(newElement)
                }
            })
        }
    }
    function setInput(e, idx) {
        $("#countryCode_" + idx).val(e);
        $("#result_" + idx).empty();
    }
    function toggleOldPassenger(idx) {
        var elem = $("#oldPassengerPane_" + idx);
        if (elem.hasClass('hidden')) {
            elem.removeClass('hidden');
            getMyPassengers(idx);
        }
        else
            elem.addClass('hidden');
    }
    function fillPassengerInfo(idxPassenger, idxRow) {
        if (idxPassenger < 0 || idxPassenger >= passengers.length)
            return;
        $("#nameFa_" + idxRow).val(passengers[idxPassenger].nameFa);
        $("#nameEn_" + idxRow).val(passengers[idxPassenger].nameEn);
        $("#familyFa_" + idxRow).val(passengers[idxPassenger].familyFa);
        $("#familyEn_" + idxRow).val(passengers[idxPassenger].familyEn);
        $("#NID_" + idxRow).val(passengers[idxPassenger].NID);
        $("#birthDayY_" + idxRow).val(passengers[idxPassenger].birthDay.substr(0, 4));
        m = passengers[idxPassenger].birthDay.substr(4, 2);

        if (m[0] == "0")
            m = m[1];

        $("#birthDayM_" + idxRow).val(m);

        d = passengers[idxPassenger].birthDay.substr(6, 2);
        if (d[0] == "0")
            d = d[1];
        $("#birthDayD_" + idxRow).val(d);
        if (passengers[idxPassenger].expire != null && passengers[idxPassenger].expire.length > 0) {
            $("#expireY_" + idxRow).val(passengers[idxPassenger].expire.substr(0, 4));
            m = passengers[idxPassenger].expire.substr(4, 2);
            if (m[0] == "0")
                m = m[1];
            $("#expireM_" + idxRow).val(m);
            d = passengers[idxPassenger].expire.substr(6, 2);
            if (d[0] == "0")
                d = d[1];
            $("#expireD_" + idxRow).val(d);
        }
        s = passengers[idxPassenger].sex;
        if (s == 0 || s == "0")
            s = "female";
        else
            s = "male";
        $("#sex_" + idxRow).val(s);
        if (passengers[idxPassenger].NIDType == 1 || passengers[idxPassenger].NIDType == "1")
            $("#foreign_" + idxRow).prop('checked', true);
        else
            $("#foreign_" + idxRow).prop('checked', false);
        $("#countryCode_" + idxRow).val(passengers[idxPassenger].countryCodeId);
        changeForeignRow(idxRow);
    }

    function getMyPassengerInfo() {
        $.ajax({
            type: 'post',
            url: '{{route('getMyTicketInfo')}}',
            success: function (response) {
                tmp = JSON.parse(response);
                if (tmp != null && tmp.length > 0) {
                    newIdx = passengers.length;
                    passengers[newIdx] = tmp;
                    fillPassengerInfo(newIdx, 0);
                }
                else
                    $("#msgErr").empty().append('شما سابقه خریدی ندارید و باید یکبار تراکنش انجام داده باشید');
            }
        });
    }

    function getMyPassengers(idx) {
        if (!getMyPassengersBool) {
            $.ajax({
                type: 'post',
                url: '{{route('getHotelPassengerInfo')}}',
                success: function (response) {
                    passengers = JSON.parse(response);
                    getMyPassengersBool = true;
                    newElement = "";
                    if (passengers.length == 0)
                        newElement += "<p class='pd-10'>مسافری موجود نیست</p>";
                    for (i = 0; i < passengers.length; i++) {
                        newElement += "<p class='cursor-pointer pd-10' onclick='fillPassengerInfo(" + i + ", " + idx + ")'>" + passengers[i].nameFa + " " + passengers[i].familyFa + "</p>";
                    }
                    $("#passengerList_" + idx).empty().append(newElement);
                }
            });
        }
        else {
            newElement = "";
            if (passengers.length == 0)
                newElement += "<p class='pd-10'>مسافری موجود نیست</p>";
            for (i = 0; i < passengers.length; i++)
                newElement += "<p class='cursor-pointer pd-10' onclick='fillPassengerInfo(" + i + ", " + idx + ")'>" + passengers[i].nameFa + " " + passengers[i].familyFa + "</p>";
            $("#passengerList_" + idx).empty().append(newElement);
        }
    }

    function addClassHidden(e) {
        if (e == "passengerNoSelectPane") {
            $("#searchAgain").addClass('hidden');
            $("#hurryUpErr").addClass('hidden');
            $("#passengerArrow").css('background-position', '-10px -123px');
            checkCapacity();
        }
        $("#" + e).addClass('hidden');
    }

    function togglePassengerNoSelectPane() {
        if (!passengerNoSelect) {
            passengerNoSelect = true;
            $("#passengerNoSelectPane").removeClass('hidden');
            $("#passengerArrow").css('background-position', '-10px -159px');
            $("#adultPassengerNoInSelect").empty().append(adult);
            $("#childPassengerNoInSelect").empty().append(child);
            $("#infantPassengerNoInSelect").empty().append(infant);
        }
        else {
            $("#passengerNoSelectPane").addClass('hidden');
            $("#passengerArrow").css('background-position', '-10px -123px');
            passengerNoSelect = false;
        }
    }
    function changePassengersNo(inc, mode) {
        switch (mode) {
            case 3:
            case "3":
            default:
                if (adult + inc >= 0)
                    adult += inc;
                $("#adultPassengerNoInSelect").empty().append(adult);
                break;
            case 2:
            case "2":
                if (child + inc >= 0)
                    child += inc;
                $("#childPassengerNoInSelect").empty().append(child);
                break;
            case 1:
            case "1":
                if (infant + inc >= 0)
                    infant += inc;
                $("#infantPassengerNoInSelect").empty().append(infant);
                break;
        }
    }

    function register() {
        var allowRegister = true;
        username = $("#usernameForRegistration").val();
        if (username.length == 0) {
            $("#usernameForRegistration").parent().addClass('error_input');
            $("#msgErr").empty().append("لطفا نام کاربری ای برای خود انتخاب نمایید");
            allowRegister = false;
        }
        pass = $("#passwordForRegistration").val();
        if (pass.length == 0) {
            $("#passwordForRegistration").parent().addClass('error_input');
            $("#msgErr").empty().append("لطفا رمز عبوری برای خود انتخاب نمایید");
            allowRegister = false;
        }
        rPass = $("#rPasswordForRegistration").val();
        if (rPass.length == 0) {
            $("#rPasswordForRegistration").parent().addClass('error_input');
            $("#msgErr").empty().append("لطفا تکرار رمز عبور خود را وارد نمایید");
            allowRegister = false;
        }
        phoneNum = $("#phoneNumForTicket").val();
        if (phoneNum.length == 0) {
            $("#phoneNumForTicket").parent().addClass('error_input');
            $("#msgErr").empty().append('لطفا شماره همراه خود را وارد نمایید');
            allowRegister = false;
        }
        email = $("#emailForTicket").val();
        if (email.length == 0) {
            $("#emailForTicket").parent().addClass('error_input');
            $("#msgErr").empty().append('لطفا ایمیل خود را وارد نمایید');
            allowRegister = false;
        }
        if(allowRegister) {
            $.ajax({
                type: 'post',
                url: '{{route('checkUserNameAndPassHotelReserve')}}',
                data: {
                    'username': username,
                    'pass': pass,
                    'rPass': rPass,
                    'phone': phoneNum,
                    'email': email
                },
                success: function (response) {
                    if (response != "nok") {
                        user_id = JSON.parse(response);
                        hasRegister = true;
                        if (validation(2))
                            sendInfo(2);
                    }
                    else if (response == "nok1")
                        $("#msgErr").empty().append('نام کاربری وارد شده در سامانه موجود است');
                    else if (response == "nok2")
                        $("#msgErr").empty().append('رمز عبور و تکرار آن یکسان نمی باشد');
                }
            });
        }
    }

    function validation(mode) {
        allow = true;
        var counter = 0;
        phoneNum = $("#phoneNumForTicket").val();
        if (phoneNum.length == 0) {
            $("#phoneNumForTicket").parent().addClass('error_input');
            // document.getElementById('phone_error_text').style.display = '';
            $("#msgErr").empty().append('لطفا شماره همراه خود را وارد نمایید');
            allow = false;
        }

        email = $("#emailForTicket").val();
        if (email.length == 0) {
            $("#emailForTicket").parent().addClass('error_input');
            // document.getElementById('email_error_text').style.display = '';
            $("#msgErr").empty().append('لطفا ایمیل خود را وارد نمایید');
            allow = false;
        }

        counter = 0;
        $("input[name='nameFa[]']").each(function () {
            tmp = $(this).val();
            if (tmp.length == 0) {
                $(this).parent().addClass('error_input');
                // document.getElementById('nameFa_error_text_'+counter).style.display = '';
                $("#msgErr").empty().append("لطفا نام فارسی برای تمامی اتاق ها را وارد نمایید");
                allow = false;
            }
            nameFa[counter++] = tmp;
        });

        counter = 0;
        $("input[name='room_code[]']").each(function () {
            tmp = $(this).val();
            room_code[counter++] = tmp;
        });

        counter = 0;
        $("input[name='nameEn[]']").each(function () {
            tmp = $(this).val();
            if (tmp.length == 0) {
                $(this).parent().addClass('error_input');
                // document.getElementById('nameEn_error_text_'+counter).style.display = '';
                $("#msgErr").empty().append("لطفا نام انگلیسی برای تمامی اتاق ها را وارد نمایید");
                allow = false;
            }
            nameEn[counter++] = tmp;
        });

        counter = 0;
        $("input[name='familyFa[]']").each(function () {
            tmp = $(this).val();
            if (tmp.length == 0) {
                $(this).parent().addClass('error_input');
                $("#msgErr").empty().append("لطفا نام خانوادگی فارسی برای تمامی اتاق ها را وارد نمایید");
                allow = false;
            }
            familyFa[counter++] = tmp;
        });

        counter = 0;
        $("input[name='familyEn[]']").each(function () {
            tmp = $(this).val();
            if (tmp.length == 0) {
                $(this).parent().addClass('error_input');
                // document.getElementById('familyEn_error_text_'+counter).style.display = '';
                $("#msgErr").empty().append("لطفا نام خانوادگی انگلیسی برای تمامی اتاق ها را وارد نمایید");
                allow = false;
            }
            familyEn[counter++] = tmp;
        });

        counter = 0;
        $("select[name='birthDayY[]']").each(function () {
            tmp = $(this).val();
            if (tmp == 0) {
                $(this).parent().addClass('error_input');
                // document.getElementById('birthDay_error_text_'+counter).style.display = '';
                $("#msgErr").empty().append("لطفا تاریخ تولد برای تمامی اتاق ها را وارد نمایید");
                allow = false;
            }
            birthDayY[counter] = tmp;
            birthDay[counter++] = tmp;
        });

        counter = 0;
        $("select[name='birthDayM[]']").each(function () {
            tmp = $(this).val();
            if (tmp == 0) {
                $(this).parent().addClass('error_input');
                // document.getElementById('birthDay_error_text_'+counter).style.display = '';
                $("#msgErr").empty().append("لطفا تاریخ تولد برای تمامی اتاق ها را وارد نمایید");
                allow = false;
            }
            birthDay[counter] = birthDay[counter] + "/" + tmp;
            birthDayM[counter] = tmp;
            counter++;
        });

        counter = 0;
        $("select[name='birthDayD[]']").each(function () {
            tmp = $(this).val();
            if (tmp == 0) {
                $(this).parent().addClass('error_input');
                $("#msgErr").empty().append("لطفا تاریخ تولد برای تمامی اتاق ها را وارد نمایید");
                allow = false;
            }
            birthDay[counter] = birthDay[counter] + "/" + tmp;
            birthDayD[counter] = tmp;
            counter++;
        });

        counter = 0;
        $("input[name='NID[]']").each(function () {
            tmp = $(this).val();
            if (tmp.length == 0) {
                $(this).parent().addClass('error_input');
                // document.getElementById('birthDay_error_text_'+counter).style.display = '';
                $("#msgErr").empty().append("لطفا کد ملی / شماره پاسپورت برای تمامی اتاق ها را وارد نمایید");
                allow = false;
            }
            NID[counter++] = tmp;
        });

        counter = 0;
        $("input[name='foreign[]']").each(function () {
            tmp = $(this).prop('checked');
            if (tmp || tmp == "true")
                foreign[counter++] = "ok";
            else
                foreign[counter++] = "nok";
        });

        counter = 0;
        $("select[name='expireY[]']").each(function () {
            tmp = $(this).val();
            if (tmp == 0 && foreign[counter] == "ok") {
                // document.getElementById('expire_error_text_'+counter).style.display = '';
                $("#msgErr").empty().append("لطفا تاریخ انقضا پاسپورت مسافران تبعه خارجی خود را مشخص نمایید");
                allow = false;
            }
            expireY[counter] = tmp;
            expire[counter++] = tmp;
        });

        counter = 0;
        $("select[name='expireM[]']").each(function () {
            tmp = $(this).val();
            if (tmp == 0 && foreign[counter] == "ok") {
                $(this).parent().addClass('error_input');
                // document.getElementById('expire_error_text_'+counter).style.display = '';
                $("#msgErr").empty().append("لطفا تاریخ انقضا پاسپورت مسافران تبعه خارجی خود را مشخص نمایید");
                allow = false;
            }
            expire[counter] = expire[counter] + "/" + tmp;
            expireM[counter] = tmp;
            counter++;
        });

        counter = 0;
        $("select[name='expireD[]']").each(function () {
            tmp = $(this).val();
            if (tmp == 0 && foreign[counter] == "ok") {
                $(this).parent().addClass('error_input');
                // document.getElementById('expire_error_text_'+counter).style.display = '';
                $("#msgErr").empty().append("لطفا تاریخ انقضا پاسپورت مسافران تبعه خارجی خود را مشخص نمایید");
                allow = false;
            }
            expire[counter] = expire[counter] + "/" + tmp;
            expireD[counter] = tmp;
            counter++;
        });

        counter = 0;
        $("input[name='countryCode[]']").each(function () {
            tmp = $(this).val();
            if (tmp.length == 0 && foreign[counter] == "ok") {
                $(this).parent().addClass('error_input');
                // document.getElementById('countryCode_error_text_'+counter).style.display = '';
                $("#msgErr").empty().append("لطفا محل صدور پاسپورت مسافران تبعه خارجی خود را مشخص نمایید");
                allow = false;
            }
            countryCode[counter++] = tmp;
        });

        counter = 0;
        $("select[name='sex[]']").each(function () {
            tmp = $(this).val();
            if (tmp.length == 0) {
                $(this).parent().addClass('error_input');
                $("#msgErr").empty().append("لطفا جنسیت مسافران خود را مشخص نمایید");
                allow = false;
            }
            sex[counter++] = tmp;
        });
        @if(Auth::check() || $mode == 2)
            counter = 0;
            $("input[name='saveInformation[]']").each(function () {
                tmp = $(this).prop('checked');
                if (tmp || tmp == "true")
                    savedInformation[counter++] = "ok";
                else
                    savedInformation[counter++] = "nok";
            });
        @endif
        // if (mode == 1) {
        //     alert('mode 1')
        //     if (nameFa.length != nameEn.length || nameFa.length != familyFa.length ||
        //         nameFa.length != familyEn.length || nameFa.length != NID.length ||
        //         nameFa.length != birthDay.length || nameFa.length != foreign.length ||
        //         nameFa.length != expire.length || nameFa.length != countryCode.length ||
        //         nameFa.length != sex.length || nameFa.length != savedInformation.length ||
        //         nameFa.length != ageType.length
        //     ) {
        //         $("#msgErr").empty().append("اشکالی در انجام عملیات مورد نظر رخ داده است");
        //         allow = false;
        //         return;
        //     }
        // }
        // else {
        //     alert('else')
        //     if (nameFa.length != nameEn.length || nameFa.length != familyFa.length ||
        //         nameFa.length != familyEn.length || nameFa.length != NID.length ||
        //         nameFa.length != birthDay.length || nameFa.length != foreign.length ||
        //         nameFa.length != expire.length || nameFa.length != countryCode.length ||
        //         nameFa.length != sex.length || nameFa.length != ageType.length
        //     ) {
        //         $("#msgErr").empty().append("اشکالی در انجام عملیات مورد نظر رخ داده است");
        //         allow = false;
        //         return;
        //     }
        // }

        informMe = $("#importantInformation").prop("checked");
        if (informMe || informMe == "true")
            informMe = "ok";
        else
            informMe = "nok";
        newsMe = $("#interestNews").prop("checked");
        if (newsMe || newsMe == "true")
            newsMe = "ok";
        else
            newsMe = "nok";
        if(allow)
            return true;
        else
            return false;
    }

    function clearError(index, num){
        switch(index){
            case 0 :
                if(num == 0) {
                    $("#phoneNumForTicket").parent().removeClass('error_input');
                    document.getElementById('phone_error_text').style.display = 'none';
                }
                else {
                    $("#emailForTicket").parent().removeClass('error_input');
                    document.getElementById('email_error_text').style.display = 'none';
                }
                break;
            case 1:
                $("#nameFa_" + num).parent().removeClass('error_input');
                document.getElementById('nameFa_error_text_'+num).style.display = 'none';
                break;
            case 2:
                $("#familyFa_" + num).parent().removeClass('error_input');
                document.getElementById('familyFa_error_text_'+num).style.display = 'none';
                break;
            case 3:
                $("#nameEn_" + num).parent().removeClass('error_input');
                document.getElementById('nameEn_error_text_'+num).style.display = 'none';
                break;
            case 4:
                $("#familyEn_" + num).parent().removeClass('error_input');
                document.getElementById('familyEn_error_text_'+num).style.display = 'none';
                break;
            case 5:
                d = $("#birthDayD_" + num).val();
                m = $("#birthDayM_" + num).val();
                y = $("#birthDayY_" + num).val();
                if(d != 0 && m != 0 && y != 0) {
                    $("#birthDayY_" + num).parent().removeClass('error_input');
                    document.getElementById('birthDay_error_text_'+num).style.display = 'none';
                }
                break;
            case 6:
                $("#NID_" + num).parent().removeClass('error_input');
                document.getElementById('NID_error_text_'+num).style.display = 'none';
                break;
        }
    }

    function deletePassenger(idx) {

        document.getElementById('nameFa_'+idx).value = null;
        document.getElementById('familyFa_'+idx).value = null;
        document.getElementById('nameEn_'+idx).value = null;
        document.getElementById('familyEn_'+idx).value = null;
        document.getElementById('birthDayD_'+idx).value = 0;
        document.getElementById('birthDayM_'+idx).value = 0;
        document.getElementById('birthDayY_'+idx).value = 0;
        document.getElementById('nidOrPassport_'+idx).value = null;
        document.getElementById('NID_'+idx).value = null;

    }

    function doPayment(mode) {
        if (mode == 2 && !hasRegister) {
            return register();
        }
        else if(validation(mode))
            sendInfo(mode);
    }

    function sendInfo(mode){
        // $('#reserve_form').submit();
        console.log(savedInformation);
        $.ajax({
            type: 'post',
            url: '{{route('sendReserveRequest')}}',
            data: {
                'nameFa': nameFa,
                'familyFa': familyFa,
                'nameEn': nameEn,
                'familyEn': familyEn,
                'NID': NID,
                'birthDay': birthDay,
                'birthDayD': birthDayD,
                'birthDayM': birthDayM,
                'birthDayY': birthDayY,
                'foreign': foreign,
                'expire': expire,
                'expireD': expireD,
                'expireM': expireM,
                'expireY': expireY,
                'countryCode': countryCode,
                'sex': sex,
                'savedInformation': savedInformation,
                'ageType': ageType,
                'phoneNum': phoneNum,
                'email': email,
                'informMe': informMe,
                'newsMe': newsMe,
                'room_code': room_code,
                'answers': answers,
                'request': request,
                'mode': mode,
                'user_id': user_id
            },
            success: function (response) {
                if(response == 'paymentPage') {
                    PaymentPage();
                }
                else if(response == 'nok'){
                    $("#msgErr").empty().append("مشکلی در ارتباط با سرور پیش امده لطفا دوباره تلاش کنید.");
                }
                else{
                    response = JSON.parse(response);
                    console.log(response);
                    order_id = response['data']['orderId'];
                    reserve_request_id = response['data']['reserveRequestId'];
                    reverseTime(response['data']['expiryDateTime']);
                }
            }
        });

    }

    function reverseTime(time) {
        if(check_reserve == 10){
            check_reserve = 0;
            GetReserveStatus();
        }
        if(check_time) {
            document.getElementById('stay_time').style.display = 'flex';
            check_time = false;
        }

        var minutes = Math.floor(time/60);
        var seconds = Math.floor(time%60);

        document.getElementById("demo").innerHTML = minutes + ":" + seconds;

        if(time <= 0)
            window.location.reload();

        setTimeout(function () {
            check_reserve++;
            reverseTime(time-1);
        },1000);
    }

    function GetReserveStatus() {
        $.ajax({
            url: '{{route('GetReserveStatus')}}',
            type: 'post',
            data:{
                'order_id': order_id
            },
            success: function(response){
                if(response == 'voucher' || response == 'payment' || response == 'fake') {
                    if(response == 'voucher')
                        window.location.href = '{{route('voucherHotel')}}';
                    else if(response == 'payment')
                        PaymentPage();
                    else if(response == 'fake') {
                        alert('خطایی پیش امده لطفا دوباره تلاش کنید.');
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000);
                    }
                }
                else if(response == 'timeOut'){
                    alert('زمان رزور به پایان رسید لطفا دوباره تلاش کنید.');
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                }
                else if(response == 'nok'){
                    console.error('error');
                }
                else{
                    response = JSON.parse(response);
                    console.log(response);
                }
            }
        })
    }

    function PaymentPage() {
        window.location.href = '{{route('paymentPage')}}';
    }

    function changeAnswer(index, num){
        if(answers[index][num-1]) {
            document.getElementById('no_' + num + '_' + index).classList.add('choose_answer');
            document.getElementById('yes_' + num + '_' + index).classList.remove('choose_answer');
            answers[index][num - 1] = false;
        }
        else
        {
            document.getElementById('yes_' + num + '_' + index).classList.add('choose_answer');
            document.getElementById('no_' + num + '_' + index).classList.remove('choose_answer');
            answers[index][num - 1] = true;
        }
    }

    function roomRequest(index) {
        request[index] = document.getElementById('textArea'+index).value;
    }

    @if(session('remain') != null)
        reverseTime({{session('remain')}});
    @endif

    @if(auth()->check())
        function getMyInfo(){
        var first_name = '{{auth()->user()->first_name}}';
        var last_name = '{{auth()->user()->last_name}}';
        var nid = '{{auth()->user()->nid}}';
        var firsChar_firstName = first_name.charCodeAt(0);
        if(first_name.charCodeAt(0) <= 122 && first_name.charCodeAt(0) >= 65 ){
            document.getElementById('nameEn_0').value = first_name;
            document.getElementById('familyEn_0').value = last_name;
        }
        else{
            document.getElementById('nameFa_0').value = first_name;
            document.getElementById('familyFa_0').value = last_name;
        }
        document.getElementById('NID_0').value = nid;
        document.getElementById('saveInformation_div_0').style.display = 'none';
    }
    @endif
</script>
