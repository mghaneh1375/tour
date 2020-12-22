
<link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/buyHotel.css?v=1')}}'/>

<div class="full-width">
    <div class="float-right"> شما در حال انتقال به سایت فروشنده بلیط هستید </div>
    <div class="text-align-left">
        {{--<a href="{{$backURL}}" style=" color: #0c0593 !important;"> بازگشت به صفحه جستجو بلیط >> </a>--}}
    </div>
</div>

<div class="inlineBorder"></div>

<div class="full-width">
    <div> اطلاعاتی که در این صفحه وارد می کنید به سایت پذیرنده منتقل می شود تا خرید شما آسان تر از قبل گردد </div>
    <div class="textTitle"> اطلاعات تماس </div>
    <div class="font-size-08em"> این اطلاعات  به عنوان اطلاعات تماس شما در شازده ثبت می شود </div>
    <div class="width-60per height-120">
        <div class="inputBox width-30per float-right">
            <div class="inputBoxText">
                <div class="display-inline-block position-relative">
                    <div class="afterBuyIcon redStar"></div>
                    تلفن همراه
                </div>
            </div>
            <input onkeypress="return isNumber(event)" class="inputBoxInput" id="phoneNumForTicket" type="tel" placeholder="0912xxxxxxx">
        </div>
        <div class="width-40per float-left">
            <div class="inputBox width-85per">
                <div class="inputBoxText">
                    <div class="display-inline-block position-relative"><div class="afterBuyIcon redStar"></div> ایمیل </div>
                </div>
                <input class="inputBoxInput" id="emailForTicket" type="email" placeholder="example@domain.com">
            </div>
            <div class="check-box__item mg-tp-5">
                <label class="labelEdit"> اطلاعات مهم را با این آدرس به من اطلاع دهید </label>
                <input type="checkbox" id="importantInformation" name="otherOffer" value="اطلاعات مهم">
            </div>
            <div class="check-box__item">
                <label class="labelEdit"> اخبار مربوط به علایق من را با این آدرس برای من بفرستید </label>
                <input type="checkbox" id="interestNews" name="otherOffer" value="اخبار مورد علاقه">
            </div>
        </div>
    </div>
</div>

<div class="inlineBorder"></div>

<div>
    <div class="textTitle"> اطلاعات مسافرین </div>
    <div>
        <div class="passengersInfosMainDiv">
            <div  class="display-inline-block">
                <span id="finalAdultNo"></span> بزرگسال -
                <span id="finalChildNo"></span> کودک -
                <span id="finalInfantNo"></span> نوزاد
            </div>

            <div class="cursor-pointer" class="afterBuyIcon bottomArrowIcon" onclick="togglePassengerNoSelectPane()"></div>

            <div class="class_passengerPane item hidden" id="passengerNoSelectPane"
                 onmouseleave="addClassHidden('passengerNoSelectPane'); passengerNoSelect = false;">
                <div class="height-25">
                    <span class="float-right">بزرگسال</span>
                    <div class="float-left mg-rt-50">
                        <div onclick="changePassengersNo(1, 3)" class="minusPlusBtn bg-position--1--6"></div>
                        <span id="adultPassengerNoInSelect"></span>
                        <div onclick="changePassengersNo(-1, 3)" class="minusPlusBtn bg-position--18--6" ></div>
                    </div>
                </div>
                <div class="height-25">
                    <span class="float-right">کودک
                        <span id="childNoSpan"></span>
                    </span>
                    <div class="float-left">
                        <div onclick="changePassengersNo(1, 2)" class="minusPlusBtn bg-position--1--6"></div>
                        <span id="childPassengerNoInSelect"></span>
                        <div onclick="changePassengersNo(-1, 2)" class="minusPlusBtn bg-position--18--6"></div>
                    </div>
                </div>
                <div class="height-25">
                    <span class="float-right">نوزاد
                        <span id="infantNoSpan"></span>
                    </span>
                    <div class="float-left">
                        <div onclick="changePassengersNo(1, 1)" class="minusPlusBtn bg-position--1--6"></div>
                        <span id="infantPassengerNoInSelect"></span>
                        <div onclick="changePassengersNo(-1, 1)" class="minusPlusBtn bg-position--18--6"></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="revisionOfCapacityChanges"> تغییر در تعداد مسافرین نیاز بررسی دوباره ظرفیت می باشد </div>
        {{--<button onclick="document.location.href = '{{route('home')}}' + '/buyInnerFlight/3/' + '{{$ticket->id}}/' + $('#finalAdultNo').html() + '/' + $('#finalChildNo').html() + '/' + $('#finalInfantNo').html()" class="btn afterBuyBtn" type="button" style="background-color: var(--koochita-light-green)"> بررسی مجدد </button>--}}
    </div>
    <div id="hurryUpErr" class="hidden">
        <span> عجله کنید </span>
        متأسفانه ظرفیت موجود به تعداد مسافران نمی باشد. تنها
        <span id="reminderCapacity"></span>
        ظرفیت باقی مانده است
    </div>
    {{--<div id="searchAgain" class="hidden">
            <span class="flightCapacityNotification"> متأسفیم </span> ظرفیت پرواز فوق به پایان رسیده است.
            <a href="{{$backURL}}" class="color-5-12-147"> دوباره جست و جو کنید </a> تا پرواز دیگری برای شما پیدا کنیم
        </div>--}}
</div>

<div class="inlineBorder"></div>

{{--<?php--}}
{{--$counter = 0;--}}
{{--$modes = [];--}}

{{--for($i = 0; $i < $adult; $i++)--}}
    {{--$modes[$counter++] = 3;--}}

{{--for($i = 0; $i < $child; $i++)--}}
    {{--$modes[$counter++] = 2;--}}

{{--for($i = 0; $i < $infant; $i++)--}}
    {{--$modes[$counter++] = 1;--}}

{{--?>--}}

{{--@for($step = 0; $step < ($adult + $child + $infant); $step++)--}}

    {{--<div id="passenger_{{$step}}">--}}
        {{--<div>--}}
            {{--<div>--}}
                {{--<div class="display-inline-block">--}}
                    {{--@if($step == 0 && Auth::check())--}}
                        {{--<div style="font-size: 1.1em; font-weight: 300; color: #050c93; display: inline-block"> <span id="passengerInfo_{{$step}}"></span><span>&nbsp;</span><span>اول</span> </div>--}}
                        {{--<button onclick="getMyTicketInfo()" class="btn afterBuyBtn" type="button" style="background-color: var(--koochita-light-green)"> من هستم </button>--}}
                        {{--<div style="font-size: 0.9em; display: inline-block"> اطلاعات موجود از پروفایل شما پر می گردد </div>--}}
                    {{--@else--}}
                        {{--<div style="font-size: 1.1em; font-weight: 300; color: #050c93; display: inline-block" id="passengerInfo_{{$step}}"></div>--}}
                    {{--@endif--}}
                {{--</div>--}}
                {{--<div style="float: left; position: relative">--}}
                    {{--<button onclick="deletePassenger('{{$step}}', '{{$modes[$step]}}')" class="btn afterBuyBtn" type="button" style="background-color: #92321b"> حذف مسافر </button>--}}

                    {{--@if(Auth::check())--}}
                        {{--<button onclick="toggleOldPassenger('{{$step}}')" class="btn afterBuyBtn" type="button" style="background-color: var(--koochita-light-green)"> مسافرین سابق </button>--}}

                        {{--<div class="class_passengerOldPane item hidden" id="oldPassengerPane_{{$step}}" onmouseleave="addClassHidden('oldPassengerPane_{{$step}}'); passengerNoSelect = false;">--}}
                            {{--<div>--}}
                                {{--<p>مسافرین سابق</p>--}}
                                {{--<div style="height: 3px; background-color: black; width: 100%"></div>--}}
                                {{--<div id="passengerList_{{$step}}"></div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--@endif--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="check-box__item" style="margin-top: 5px">--}}
                {{--<label class="labelEdit"> تبعه خارجی هستم </label>--}}
                {{--<input onclick="changeForeignRow('{{$step}}')" id="foreign_{{$step}}" name="foreign[]" value="خارجی" type="checkbox" style="display: inline-block; !important;">--}}
            {{--</div>--}}
            {{--<div class="full-width">--}}
                {{--<div>--}}
                    {{--<div class="inputBox" style="width: 20%;">--}}
                        {{--<div class="inputBoxText">--}}
                            {{--<div class="display-inline-block position-relative"><div class="afterBuyIcon redStar"></div> نام </div>--}}
                        {{--</div>--}}
                        {{--<input class="inputBoxInput" id="nameFa_{{$step}}" name="nameFa[]" type="text" placeholder="فارسی">--}}
                    {{--</div>--}}
                    {{--<div class="inputBox" style="width: 25%; margin-right: 10%;">--}}
                        {{--<div class="inputBoxText">--}}
                            {{--<div class="display-inline-block position-relative"><div class="afterBuyIcon redStar"></div> نام خانوادگی </div>--}}
                        {{--</div>--}}
                        {{--<input class="inputBoxInput" type="text" name="familyFa[]" id="familyFa_{{$step}}" placeholder="فارسی">--}}
                        {{--<input type="hidden" name="ageType[]" value="{{$modes[$step]}}">--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div>--}}
                    {{--<div class="inputBox" style="width: 20%;">--}}
                        {{--<div class="inputBoxText">--}}
                            {{--<div class="display-inline-block position-relative"><div class="afterBuyIcon redStar"></div> نام </div>--}}
                        {{--</div>--}}
                        {{--<input class="inputBoxInput" name="nameEn[]" id="nameEn_{{$step}}" type="text" placeholder="لاتین">--}}
                    {{--</div>--}}
                    {{--<div class="inputBox" style="width: 25%; margin-right: 10%;">--}}
                        {{--<div class="inputBoxText">--}}
                            {{--<div class="display-inline-block position-relative"><div class="afterBuyIcon redStar"></div> نام خانوادگی </div>--}}
                        {{--</div>--}}
                        {{--<input class="inputBoxInput" type="text" placeholder="لاتین" name="familyEn[]" id="familyEn_{{$step}}">--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div>--}}
                    {{--<div class="inputBox" style="width: 20%;">--}}
                        {{--<div class="inputBoxText">--}}
                            {{--<div class="display-inline-block position-relative"><div class="afterBuyIcon redStar"></div> تاریخ تولد </div>--}}
                        {{--</div>--}}
                        {{--<select name="birthDayD[]" id="birthDayD_{{$step}}" class="inputBoxSelect" required>--}}
                            {{--<option value="" > روز </option>--}}
                            {{--@for($i = 1; $i < 32; $i++)--}}
                                {{--<option value="{{$i}}"> {{$i}} </option>--}}
                            {{--@endfor--}}
                        {{--</select>--}}
                        {{--<select name="birthDayM[]" id="birthDayM_{{$step}}" class="inputBoxSelect" required>--}}
                            {{--<option value="" > ماه </option>--}}
                            {{--<option value="1"> فروردین </option>--}}
                            {{--<option value="2"> اردیبهشت </option>--}}
                            {{--<option value="3"> خرداد </option>--}}
                            {{--<option value="4"> تیر </option>--}}
                            {{--<option value="5"> مرداد </option>--}}
                            {{--<option value="6"> شهریور </option>--}}
                            {{--<option value="7"> مهر </option>--}}
                            {{--<option value="8"> آبان </option>--}}
                            {{--<option value="9"> آذر </option>--}}
                            {{--<option value="10"> دی </option>--}}
                            {{--<option value="11"> بهمن </option>--}}
                            {{--<option value="12"> اسفند </option>--}}
                        {{--</select>--}}
                        {{--<select name="birthDayY[]" id="birthDayY_{{$step}}" class="inputBoxSelect" required>--}}
                            {{--<option value="" > سال </option>--}}
                            {{--@for($i = 1330; $i < 1398; $i++)--}}
                                {{--<option value="{{$i}}"> {{$i}} </option>--}}
                            {{--@endfor--}}
                        {{--</select>--}}
                    {{--</div>--}}
                    {{--<div class="inputBox" style="width: 25%; margin-right: 10%;">--}}
                        {{--<div style="width: 50%" class="inputBoxText">--}}
                            {{--<div style="display: inline-block; position: relative;"><div class="afterBuyIcon redStar"></div> <span id="nidOrPassport_{{$step}}">کد ملی</span> </div>--}}
                        {{--</div>--}}
                        {{--<input style="width: 50%" name="NID[]" id="NID_{{$step}}" class="inputBoxInput" type="text" placeholder="000000000">--}}
                    {{--</div>--}}
                    {{--<div class="inputBox" style="width: 10%; margin-right: 10%;">--}}
                        {{--<div class="inputBoxText" style="width: 50%">--}}
                            {{--<div class="display-inline-block position-relative"><div class="afterBuyIcon redStar"></div> جنسیت </div>--}}
                        {{--</div>--}}
                        {{--<select name="sex[]" id="sex_{{$step}}" class="inputBoxSelect" style="width: 30%; margin: 0 9px" required>--}}
                            {{--<option value="female"> زن </option>--}}
                            {{--<option value="male"> مرد </option>--}}
                        {{--</select>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div id="foreignRow_{{$step}}" class="hidden">--}}
                    {{--<div class="inputBox" style="width: 20%;">--}}
                        {{--<div class="inputBoxText">--}}
                            {{--<div class="display-inline-block position-relative"> تاریخ انقضا </div>--}}
                        {{--</div>--}}
                        {{--<select name="expireD[]" id="expireD_{{$step}}" class="inputBoxSelect" required>--}}
                            {{--<option value="" > روز </option>--}}
                            {{--@for($i = 1; $i < 32; $i++)--}}
                                {{--<option value="{{$i}}"> {{$i}} </option>--}}
                            {{--@endfor--}}
                        {{--</select>--}}
                        {{--<select name="expireM[]" id="expireM_{{$step}}" class="inputBoxSelect" required>--}}
                            {{--<option value="" > ماه </option>--}}
                            {{--<option value="1"> فروردین </option>--}}
                            {{--<option value="2"> اردیبهشت </option>--}}
                            {{--<option value="3"> خرداد </option>--}}
                            {{--<option value="4"> تیر </option>--}}
                            {{--<option value="5"> مرداد </option>--}}
                            {{--<option value="6"> شهریور </option>--}}
                            {{--<option value="7"> مهر </option>--}}
                            {{--<option value="8"> آبان </option>--}}
                            {{--<option value="9"> آذر </option>--}}
                            {{--<option value="10"> دی </option>--}}
                            {{--<option value="11"> بهمن </option>--}}
                            {{--<option value="12"> اسفند </option>--}}
                        {{--</select>--}}
                        {{--<select name="expireY[]" id="expireY_{{$step}}" class="inputBoxSelect" required>--}}
                            {{--<option value="" > سال </option>--}}
                            {{--@for($i = 1330; $i < 1398; $i++)--}}
                                {{--<option value="{{$i}}"> {{$i}} </option>--}}
                            {{--@endfor--}}
                        {{--</select>--}}
                    {{--</div>--}}
                    {{--<div id="searchDivForScroll_{{$step}}" class="inputBox searchDivForScroll" style="width: 25%; margin-right: 10%;">--}}
                        {{--<div class="inputBoxText">--}}
                            {{--<div class="display-inline-block position-relative"> محل صدور </div>--}}
                        {{--</div>--}}
                        {{--<input onkeyup="searchCountryCode(event, '{{$step}}')"  name="countryCode[]" id="countryCode_{{$step}}" class="inputBoxInput" type="text" placeholder="Iran">--}}
                        {{--<div id="result_{{$step}}" class="data_holder"></div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--@if(Auth::check())--}}
                {{--<div class="check-box__item" style="margin-top: 5px">--}}
                    {{--<label class="labelEdit"> این اطلاعات در قسمت مسافر ها ذخیره شود. در صورت ذخیره اطلاعات در هنگام خرید بلیط دیگر نیاز به وارد کردن اطلاعات این مسافر نمی باشد و تنها با وارد کردن نام می توان اطلاعات را به طور کامل وارد نمود </label>--}}
                    {{--<input type="checkbox" id="saveInformation_{{$step}}" name="saveInformation[]" value="ذخیره اطلاعات" style="display: inline-block; !important;">--}}
                {{--</div>--}}
            {{--@endif--}}
        {{--</div>--}}

        {{--<div class="inlineBorder"></div>--}}

    {{--</div>--}}

{{--@endfor--}}

<script>

    var passengerNoSelect = false;
    var adult = parseInt('{{$adult}}');
    var child = parseInt('{{$child}}');
    var infant = parseInt('{{$infant}}');
    var passengers = [];
    var getMyPassengersBool = false;
    var ageArr = [];
    var nums = ['اول', 'دوم', 'سوم', 'چهارم', 'پنجم', 'ششم', 'هفتم', 'هشتم', 'نهم'];

    function renderAges() {

        var counter = 0;

        for(i = 0; i < adult; i++) {
            ageArr[counter++] = 'مسافر بزرگسال ' + nums[i];
        }
        for(i = 0; i < child; i++) {
            ageArr[counter++] = 'مسافر کودک ' + nums[i];
        }
        for(i = 0; i < infant; i++) {
            ageArr[counter++] = 'مسافر خردسال ' + nums[i];
        }

        var j = 0, i;

        for(i = 0; i < counter; i++) {

            while(!$("#passengerInfo_" + j).length)
                j++;

            $("#passengerInfo_" + j++).empty().append(ageArr[i]);
        }

    }

    function changeToAdult(idx) {
        ageType[idx] = 3;
        sendRequest();
    }
    function changeToChild(idx) {
        ageType[idx] = 2;
        sendRequest();
    }
    function changeToInfant(idx) {
        ageType[idx] = 1;
        sendRequest();
    }

    function deletePassenger(idx, mode) {
        $("#passenger_" + idx).remove();
        changePassengersNo(-1, mode);

        $("#finalAdultNo").empty().append(adult);
        $("#finalChildNo").empty().append(child);
        $("#finalInfantNo").empty().append(infant);
        renderAges();

    }

    var currIdx = 0, suggestions = [];

    function changeForeignRow(idx) {

        if($("#foreign_" + idx).prop('checked')) {
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
                $("#countryCode_"+ idx).val(suggestions[currIdx].code);
                $("#result_" + idx).empty();
                return;
            }

            if (13 == e.keyCode && -1 == currIdx && suggestions.length > 0) {
                $("#countryCode_"+ idx).val(suggestions[0].code);
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
                    url: '{{route('searchCountryCode')}}',
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
                            newElement += "<p style='cursor: pointer' class='suggest' id='suggest_" + i + "' onclick='setInput(\"" + response[i].code + "\", \"" + idx + "\")'>" + response[i].name + " - " + response[i].nameEn + "</p>";

                        $("#result_" + idx).empty().append(newElement)
                    }
                })
            }
            else $.ajax({
                type: "post",
                url: '{{route('searchCountryCode')}}',
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
                        newElement += "<p style='cursor: pointer' class='suggest' id='suggest_" + i + "' onclick='setInput(\"" + response[i].code + "\", \"" + idx + "\")'>" + response[i].name + " - " + response[i].nameEn + "</p>";

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
        if(elem.hasClass('hidden')) {
            elem.removeClass('hidden');
            getMyPassengers(idx);
        }
        else
            elem.addClass('hidden');
    }

    function fillPassengerInfo(idxPassenger, idxRow) {

        if(idxPassenger < 0 || idxPassenger >= passengers.length)
            return;

        $("#nameFa_" + idxRow).val(passengers[idxPassenger].nameFa);
        $("#nameEn_" + idxRow).val(passengers[idxPassenger].nameEn);
        $("#familyFa_" + idxRow).val(passengers[idxPassenger].familyFa);
        $("#familyEn_" + idxRow).val(passengers[idxPassenger].familyEn);
        $("#NID_" + idxRow).val(passengers[idxPassenger].NID);
        $("#birthDayY_" + idxRow).val(passengers[idxPassenger].birthDay.substr(0, 4));
        m = passengers[idxPassenger].birthDay.substr(4, 2);
        if(m[0] == "0")
            m = m[1];
        $("#birthDayM_" + idxRow).val(m);
        d = passengers[idxPassenger].birthDay.substr(6, 2);
        if(d[0] == "0")
            d = d[1];
        $("#birthDayD_" + idxRow).val(d);

        if(passengers[idxPassenger].expire != null && passengers[idxPassenger].expire.length > 0) {
            $("#expireY_" + idxRow).val(passengers[idxPassenger].expire.substr(0, 4));
            m = passengers[idxPassenger].expire.substr(4, 2);
            if(m[0] == "0")
                m = m[1];
            $("#expireM_" + idxRow).val(m);
            d = passengers[idxPassenger].expire.substr(6, 2);
            if(d[0] == "0")
                d = d[1];
            $("#expireD_" + idxRow).val(d);
        }

        s = passengers[idxPassenger].sex;
        if(s == 0 || s == "0")
            s = "female";
        else
            s = "male";
        $("#sex_" + idxRow).val(s);

        if(passengers[idxPassenger].NIDType == 1 || passengers[idxPassenger].NIDType == "1")
            $("#foreign_" + idxRow).prop('checked', true);
        else
            $("#foreign_" + idxRow).prop('checked', false);

        $("#countryCode_" + idxRow).val(passengers[idxPassenger].countryCodeId);
        changeForeignRow(idxRow);
    }

    function getMyTicketInfo() {
        $.ajax({
            type: 'post',
            url: '{{route('getMyTicketInfo')}}',
            success: function(response) {
                tmp = JSON.parse(response);
                if(tmp != null && tmp.length > 0) {
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
        if(!getMyPassengersBool) {
            $.ajax({
                type: 'post',
                url: '{{route('getMyPassengers')}}',
                success: function(response) {
                    passengers = JSON.parse(response);
                    getMyPassengersBool = true;
                    newElement = "";
                    if(passengers.length == 0)
                        newElement += "<p style='padding: 10px'>مسافری موجود نیست</p>";

                    for (i = 0; i < passengers.length; i++) {
                        newElement += "<p style='cursor: pointer; padding: 10px' onclick='fillPassengerInfo(" + i + ", " + idx + ")' style='cursor: pointer'>" + passengers[i].nameFa + " " + passengers[i].familyFa + "</p>";
                    }
                    $("#passengerList_" + idx).empty().append(newElement);
                }
            });
        }
        else {

            newElement = "";

            if(passengers.length == 0)
                newElement += "<p style='padding: 10px'>مسافری موجود نیست</p>";

            for (i = 0; i < passengers.length; i++)
                newElement += "<p style='cursor: pointer; padding: 10px' onclick='fillPassengerInfo(" + i + ", " + idx + ")' style='cursor: pointer'>" + passengers[i].nameFa + " " + passengers[i].familyFa + "</p>";

            $("#passengerList_" + idx).empty().append(newElement);
        }
    }

    function checkCapacity() {

        $.ajax({
            type: 'post',
            url: '{{route('checkInnerFlightCapacity')}}',
            data: {
                'requested': adult + child + infant,
                'ticketId': '{{$ticket->id}}'
            },
            success: function(response) {

                response = JSON.parse(response);

                if(response.status == "ok") {
                    $("#finalAdultNo").empty().append(adult);
                    $("#finalChildNo").empty().append(child);
                    $("#finalInfantNo").empty().append(infant);
                }
                else if(response.status == "nok1") {
                    $("#reminderCapacity").empty().append(response.reminder);
                    $("#hurryUpErr").removeClass('hidden');
                }
                else
                    $("#searchAgain").removeClass('hidden');
            }
        });
    }

    $(document).ready(function() {
        checkCapacity();
        renderAges();
    });

    function addClassHidden(e) {

        if(e == "passengerNoSelectPane") {
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

    var nameFa;
    var familyFa;
    var nameEn;
    var familyEn;
    var NID;
    var birthDay;
    var foreign;
    var expire;
    var countryCode;
    var sex;
    var savedInformation;
    var ageType;
    var allow;
    var phoneNum;
    var email;
    var informMe;
    var newsMe;
    var username;
    var pass;
    var rPass;
    var hasRegister = false;

    function register() {

        username = $("#usernameForRegistration").val();

        if(username.length == 0) {
            $("#msgErr").empty().append("لطفا نام کاربری ای برای خود انتخاب نمایید");
            return;
        }

        pass = $("#passwordForRegistration").val();

        if(pass.length == 0) {
            $("#msgErr").empty().append("لطفا رمز عبوری برای خود انتخاب نمایید");
            return;
        }

        rPass = $("#rPasswordForRegistration").val();

        if(rPass.length == 0) {
            $("#msgErr").empty().append("لطفا تکرار رمز عبور خود را وارد نمایید");
            return;
        }

        $.ajax({
            type: 'post',
            url: '{{route('checkUserNameAndPass')}}',
            data: {
                'username': username,
                'pass': pass,
                'rPass': rPass
            },
            success: function(response) {
                if(response == "ok") {
                    hasRegister = true;
                    validation(2);
                }
                else if(response == "nok1")
                    $("#msgErr").empty().append('نام کاربری وارد شده در سامانه موجود است');
                else if(response == "nok2")
                    $("#msgErr").empty().append('رمز عبور و تکرار آن یکسان نمی باشد');
            }
        });
    }

    function validation(mode) {
        nameFa = [];
        familyFa = [];
        nameEn = [];
        familyEn = [];
        NID = [];
        birthDay = [];
        foreign = [];
        expire = [];
        countryCode = [];
        sex = [];
        savedInformation = [];
        ageType = [];
        allow = true;

        var counter = 0;

        phoneNum = $("#phoneNumForTicket").val();
        if(phoneNum.length == 0) {
            $("#msgErr").empty().append('لطفا شماره همراه خود را وارد نمایید');
            return;
        }

        email = $("#emailForTicket").val();
        if(email.length == 0) {
            $("#msgErr").empty().append('لطفا ایمیل خود را وارد نمایید');
            return;
        }

        $("input[name='ageType[]']").each(function() {
            ageType[counter++] = $(this).val();
        });

        counter = 0;

        $("input[name='nameFa[]']").each(function() {
            tmp = $(this).val();
            if(tmp.length == 0) {
                $("#msgErr").empty().append("لطفا نام فارسی تمام مسافران را وارد نمایید");
                allow = false;
                return;
            }

            nameFa[counter++] = tmp;
        });

        if(!allow)
            return;

        counter = 0;
        $("input[name='nameEn[]']").each(function() {
            tmp = $(this).val();
            if(tmp.length == 0) {
                $("#msgErr").empty().append("لطفا نام انگلیسی تمام مسافران را وارد نمایید");
                allow = false;
                return;
            }

            nameEn[counter++] = tmp;
        });

        if(!allow)
            return;

        counter = 0;
        $("input[name='familyFa[]']").each(function() {
            tmp = $(this).val();
            if(tmp.length == 0) {
                $("#msgErr").empty().append("لطفا نام خانوادگی فارسی تمام مسافران را وارد نمایید");
                allow = false;
                return;
            }

            familyFa[counter++] = tmp;
        });

        if(!allow)
            return;

        counter = 0;
        $("input[name='familyEn[]']").each(function() {
            tmp = $(this).val();
            if(tmp.length == 0) {
                $("#msgErr").empty().append("لطفا نام خانوادگی انگلیسی تمام مسافران را وارد نمایید");
                allow = false;
                return;
            }

            familyEn[counter++] = tmp;
        });

        if(!allow)
            return;

        counter = 0;
        $("select[name='birthDayY[]']").each(function() {
            tmp = $(this).val();
            if(tmp.length == 0) {
                $("#msgErr").empty().append("لطفا تاریخ تولد تمام مسافران را وارد نمایید");
                allow = false;
                return;
            }

            birthDay[counter++] = tmp;
        });

        if(!allow)
            return;

        counter = 0;
        $("select[name='birthDayM[]']").each(function() {
            tmp = $(this).val();
            if(tmp.length == 0) {
                $("#msgErr").empty().append("لطفا تاریخ تولد تمام مسافران را وارد نمایید");
                allow = false;
                return;
            }

            birthDay[counter] = birthDay[counter] + "/" + tmp;
            counter++;
        });

        if(!allow)
            return;

        counter = 0;
        $("select[name='birthDayD[]']").each(function() {
            tmp = $(this).val();
            if(tmp.length == 0) {
                $("#msgErr").empty().append("لطفا تاریخ تولد تمام مسافران را وارد نمایید");
                allow = false;
                return;
            }

            birthDay[counter] = birthDay[counter] + "/" + tmp;
            counter++;
        });

        if(!allow)
            return;

        counter = 0;
        $("input[name='NID[]']").each(function() {
            tmp = $(this).val();
            if(tmp.length == 0) {
                $("#msgErr").empty().append("لطفا کد ملی / شماره پاسپورت تمام مسافران را وارد نمایید");
                allow = false;
                return;
            }

            NID[counter++] = tmp;
        });

        if(!allow)
            return;

        counter = 0;
        $("input[name='foreign[]']").each(function() {
            tmp = $(this).prop('checked');
            if(tmp || tmp == "true")
                foreign[counter++] = "ok";
            else
                foreign[counter++] = "nok";
        });

        counter = 0;
        $("select[name='expireY[]']").each(function() {
            tmp = $(this).val();
            if(tmp.length == 0 && foreign[counter] == "ok") {
                $("#msgErr").empty().append("لطفا تاریخ انقضا پاسپورت مسافران تبعه خارجی خود را مشخص نمایید");
                allow = false;
                return;
            }

            expire[counter++] = tmp;
        });

        if(!allow)
            return;

        counter = 0;
        $("select[name='expireM[]']").each(function() {
            tmp = $(this).val();
            if(tmp.length == 0 && foreign[counter] == "ok") {
                $("#msgErr").empty().append("لطفا تاریخ انقضا پاسپورت مسافران تبعه خارجی خود را مشخص نمایید");
                allow = false;
                return;
            }

            expire[counter] = expire[counter] + "/" + tmp;
            counter++;
        });

        if(!allow)
            return;

        counter = 0;
        $("select[name='expireD[]']").each(function() {
            tmp = $(this).val();
            if(tmp.length == 0 && foreign[counter] == "ok") {
                $("#msgErr").empty().append("لطفا تاریخ انقضا پاسپورت مسافران تبعه خارجی خود را مشخص نمایید");
                allow = false;
                return;
            }

            expire[counter] = expire[counter] + "/" + tmp;
            counter++;
        });

        if(!allow)
            return;

        counter = 0;
        $("input[name='countryCode[]']").each(function() {
            tmp = $(this).val();
            if(tmp.length == 0 && foreign[counter] == "ok") {
                $("#msgErr").empty().append("لطفا محل صدور پاسپورت مسافران تبعه خارجی خود را مشخص نمایید");
                allow = false;
                return;
            }

            countryCode[counter++] = tmp;
        });

        if(!allow)
            return;

        counter = 0;
        $("select[name='sex[]']").each(function() {
            tmp = $(this).val();
            if(tmp.length == 0) {
                $("#msgErr").empty().append("لطفا جنسیت مسافران خود را مشخص نمایید");
                allow = false;
                return;
            }

            sex[counter++] = tmp;
        });

        if(!allow)
            return;

        if(mode == 1) {
            counter = 0;
            $("input[name='saveInformation[]']").each(function () {
                tmp = $(this).prop('checked');
                if (tmp || tmp == "true")
                    savedInformation[counter++] = "ok";
                else
                    savedInformation[counter++] = "nok";
            });
        }

        if(mode == 1) {
            if (nameFa.length != nameEn.length || nameFa.length != familyFa.length ||
                nameFa.length != familyEn.length || nameFa.length != NID.length ||
                nameFa.length != birthDay.length || nameFa.length != foreign.length ||
                nameFa.length != expire.length || nameFa.length != countryCode.length ||
                nameFa.length != sex.length || nameFa.length != savedInformation.length ||
                nameFa.length != ageType.length
            ) {
                $("#msgErr").empty().append("اشکالی در انجام عملیات مورد نظر رخ داده است");
                allow = false;
                return;
            }
        }
        else {
            if (nameFa.length != nameEn.length || nameFa.length != familyFa.length ||
                nameFa.length != familyEn.length || nameFa.length != NID.length ||
                nameFa.length != birthDay.length || nameFa.length != foreign.length ||
                nameFa.length != expire.length || nameFa.length != countryCode.length ||
                nameFa.length != sex.length || nameFa.length != ageType.length
            ) {
                $("#msgErr").empty().append("اشکالی در انجام عملیات مورد نظر رخ داده است");
                allow = false;
                return;
            }
        }

        if(!allow)
            return;

        informMe = $("#importantInformation").prop("checked");
        if(informMe || informMe == "true")
            informMe = "ok";
        else
            informMe = "nok";


        newsMe = $("#interestNews").prop("checked");
        if(newsMe || newsMe == "true")
            newsMe = "ok";
        else
            newsMe = "nok";

        sendRequest();

    }

    function sendRequest() {

        $.ajax({
            type: 'post',
            url: '{{route('sendPassengersInfo', ['ticketId' => $ticket->id])}}',
            data: {
                'nameFa': nameFa,
                'familyFa': familyFa,
                'nameEn': nameEn,
                'familyEn': familyEn,
                'NID': NID,
                'birthDay': birthDay,
                'foreign': foreign,
                'expire': expire,
                'countryCode': countryCode,
                'sex': sex,
                'savedInformation': savedInformation,
                'ageType': ageType,
                'phoneNum': phoneNum,
                'email': email,
                'informMe': informMe,
                'newsMe': newsMe
            },
            success: function (response) {

                response = JSON.parse(response);

                if(response.status == "nok") {
                    $("#msgErr").empty().append('عملیات مورد نظر با خطا رو به رو شده است لطفا مجددا امتحان فرمایید');
                    return;
                }
                else if(response.status == "nok5") {
                    $("#msgErr").empty().append(nameFa[response.idx] + " " + familyFa[response.idx] + " در محدوده سنی کودک قرار نمی گیرد" + "<span>&nbsp;&nbsp;&nbsp;</span><span onclick='changeToAdult(" + [response.idx] + ")' style='color: #0c0593; cursor: pointer'>بزرگسال محاسبه شود</span><span>&nbsp;&nbsp;&nbsp;</span><span onclick='changeToInfant(" + [response.idx] + ")' style='color: #0c0593; cursor: pointer'>خردسال محاسبه شود<span>");
                    return;
                }
                else if(response.status == "nok6") {
                    $("#msgErr").empty().append(nameFa[response.idx] + " " + familyFa[response.idx] + " در محدوده سنی خردسال قرار نمی گیرد" + "<span>&nbsp;&nbsp;&nbsp;</span><span onclick='changeToAdult(" + [response.idx] + ")' style='color: #0c0593; cursor: pointer'>بزرگسال محاسبه شود</span><span>&nbsp;&nbsp;&nbsp;</span><span onclick='changeToChild(" + [response.idx] + ")' style='cursor: pointer; color: #0c0593'>کودک محاسبه شود<span>");
                    return;
                }

                document.location.href = response.result;
            }
        });
    }

    function doPayment(mode) {

        if(mode == 2 && !hasRegister)
            return register();

        validation(mode);
    }

</script>