<?php
$kindPlaceId = 1;
$placeMode = 'state';
$state = 'تهران';
?>
        <!DOCTYPE html>
<html>
<head>
    @include('layouts.topHeader')
    @include('layouts.phonePopUp')
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/home_rebranded.css?v=4')}}"/>
    <title>مرحله پنجم ثبت تور</title>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/long_lived_global_legacy_2.css?v=2')}}"/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/masthead-saves.css?v=2')}}'/>
    <link rel='stylesheet' type='text/css' media='screen, print' href='{{URL::asset('css/theme2/hr_north_star.css?v=2')}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/icons.css?v=1')}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/passStyle.css?v=1')}}'/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/shazdeDesigns/tourCreation.css?v=1')}}"/>

    {{--<script src= {{URL::asset("js/jalali.js") }}></script>--}}

{{--    <link rel="stylesheet" href="{{URL::asset('css/calendar2/persian-datepicker.css?v=1')}}"/>--}}
{{--    <script src="{{URL::asset('js/calendar2/persian-date.min.js')}}"></script>--}}
{{--    <script src="{{URL::asset('js/calendar2/persian-datepicker.min.js')}}"></script>--}}

    <script src="{{URL::asset('js/tour/create/stageFour.js')}}"></script>


    <style>
        .inputBoxTour .inputBoxText{
            min-width: 100px;
            width: auto;
        }
    </style>
</head>

<body>

<div>
    @include('general.forAllPages')
    @include('layouts.placeHeader')

    @include('pages.tour.create.tourCreateHeader', ['createTourStep' => 4, 'createTourHeader' => 'اطلاعات زمانی و زبانی'])

    <div id="tourDetailsMainForm3rdtStepMainDiv" class="Hotel_Review prodp13n_jfy_overflow_visible lightGreyBox">
        <form id="form" method="post" action="{{route('tour.create.stage.four.store')}}" autocomplete="off">
            {!! csrf_field() !!}
            <input type="hidden" name="language" id="language">
            <input type="hidden" name="tourId" value="{{$tour->id}}">

            <div class="ui_container">
                <div class="menu ui_container whiteBox">
                    <div class="boxTitlesTourCreation">نوع برگزاری</div>
                    <div class="inboxHelpSubtitle">کدام یک از موارد زیر در مورد تور شما صادق است؟</div>

                    <input ng-model="sort" type="radio" id="c53" name="tourKind" value="notSameTime" onchange="changeTime(this.value)"/>
                    <label for="c53" class="tourBasicKindsCheckbox">
                        <p>
                            تور ما با برنامه‌ی زمانی نامنظم بیش از یک‌بار برگزار می‌گردد.
                        </p>
                        <span class="tourBasicKindsCheckboxSpan mg-tp-5imp" ></span>
                    </label>

                    <input ng-model="sort" type="radio" id="c52" name="tourKind" value="sameTime" onchange="changeTime(this.value)"/>
                    <label for="c52" class="tourBasicKindsCheckbox">
                        <p>
                            تور ما با برنامه زمانی یکسان و منظم بیش از یکبار برگزار می‌گردد.
                        </p>
                        <span class="tourBasicKindsCheckboxSpan mg-tp-5imp" ></span>
                    </label>

                    <input ng-model="sort" type="radio" id="c51" name="tourKind" value="oneTime" onchange="changeTime(this.value)" checked/>
                    <label for="c51" class="tourBasicKindsCheckbox pd-40-30">
                        <p>
                            تور ما فقط برای یکبار برگزار می‌گردد.
                        </p>
                        <span class="tourBasicKindsCheckboxSpan"></span>
                    </label>

                    <div class="inboxHelpSubtitleBlue mg-tp-20">
                        نیاز به راهنمایی دارید؟
                    </div>
                </div>
                <script>
                    $(document).ready(function () {
                        $('.tourBasicKindsCheckbox').mouseenter(function () {
                            $(this).addClass('green-border')
                        });
                        $('.tourBasicKindsCheckbox').mouseleave(function () {
                            $(this).removeClass('green-border')
                        });
                    })
                </script>
            </div>

            {{--one time--}}
            <div id="oneTime" class="ui_container">
                <div class="menu ui_container whiteBox">
                    <div class="boxTitlesTourCreation">
                        زمان برگزاری
                    </div>
                    <div class="inboxHelpSubtitle">
                        تاریخ شروع و پایان تور خود را وارد نمایید. توجه کنید که ما این امکان را برای شما فراهم آوردیم تا با تعریف یکباره‌ی تور بتوانید بارهم از آن کپی گرفته و سریعتر تور خود را تعریف نمایید.
                    </div>
                    <div class="inputBoxTour col-xs-3 mg-rt-10 relative-position float-right">
                        <div class="inputBoxText">
                            <div>
                                تاریخ پایان
                                <span>*</span>
                            </div>
                        </div>
                        <div class="select-side calendarIconTourCreation">
                            <i class="ui_icon calendar calendarIcon"></i>
                        </div>
                        <input name="eDate" id="eDate" class="observer-example inputBoxInput" readonly/>
                    </div>

                    <div class="inputBoxTour col-xs-3 relative-position float-right">
                        <div class="inputBoxText">
                            <div>
                                تاریخ شروع
                                <span>*</span>
                            </div>
                        </div>
                        <div class="select-side calendarIconTourCreation">
                            <i class="ui_icon calendar calendarIcon"></i>
                        </div>
                        <input name="sDate" id="sDate" class="observer-example inputBoxInput" type="text" onchange="changeInputClass('sDate')">
                    </div>

                </div>
            </div>

            {{--same time--}}
            <div id="sameTime" class="ui_container" style="display: none;">
                <div class="menu ui_container whiteBox">
                    <div class="boxTitlesTourCreation">
                        زمان برگزاری
                    </div>
                    <div class="inboxHelpSubtitle">
                        تاریخ شروع و پایان تور خود را وارد نمایید. توجه کنید که ما این امکان را برای شما فراهم آوردیم تا با تعریف یکباره‌ی تور بتوانید بارهم از آن کپی گرفته و سریعتر تور خود را تعریف نمایید.
                    </div>

                    <div class="inputBoxTour col-xs-3 mg-rt-10 relative-position float-right">
                        <div class="inputBoxText">
                            <div>
                                تاریخ پایان
                                <span>*</span>
                            </div>
                        </div>
                        <div class="select-side calendarIconTourCreation">
                            <i class="ui_icon calendar calendarIcon"></i>
                        </div>
                        <input name="eDateSame" id="eDateSame" class="observer-example inputBoxInput" onchange="changeInputClass('eDateSame')"/>
                    </div>

                    <div class="inputBoxTour col-xs-3 relative-position float-right">
                        <div class="inputBoxText">
                            <div>
                                تاریخ شروع
                                <span>*</span>
                            </div>
                        </div>
                        <div class="select-side calendarIconTourCreation">
                            <i class="ui_icon calendar calendarIcon"></i>
                        </div>
                        <input name="sDateSame" id="sDateSame" class="observer-example inputBoxInput" type="text" onchange="changeInputClass('sDateSame')">
                    </div>

                    <div class="inboxHelpSubtitle">
                        روز شروع تور در هفته و مدت آن ثابت فرض می‌گردد و شما تنها می‌بایست دوره‌ی تکرار را برای تور مشخص کنید.
                    </div>
                    <div class="inputBoxTour float-right col-xs-3">
                        <div class="inputBoxText">
                            <div>
                                دوره‌ی تکرار
                                <span>*</span>
                            </div>
                        </div>
                        <div class="select-side">
                            <i class="glyphicon glyphicon-triangle-bottom"></i>
                        </div>
                        <select class="inputBoxInput styled-select" name="priod" id="priod">
                            <option value="0">هفتگی</option>
                            <option value="1">هر دو هفته</option>
                            <option value="2">ماهیانه</option>
                            <option value="3">هر دو ماه یکبار</option>
                            <option value="4">هر فصل</option>
                        </select>
                    </div>
                </div>
            </div>

            {{--not same time--}}
            <div id="notSameTime" class="ui_container" style="display: none;">
                <div class="menu ui_container whiteBox tourCapacityNGOTours">
                    <div class="boxTitlesTourCreation">
                        زمان برگزاری
                    </div>
                    <div class="inboxHelpSubtitle">
                        تاریخ شروع و پایان تور خود را وارد نمایید. توجه کنید که ما این امکان را برای شما فراهم آوردیم تا با تعریف یکباره‌ی تور بتوانید بارهم از آن کپی گرفته و سریعتر تور خود را تعریف نمایید.
                    </div>

                    <div id="notSameTimeCalendarDiv" style="display: flex; flex-direction: column">
                        <div id="calendar_1">
                            <div class="tourNthOccurrence">1</div>

                            <div class="inputBoxTour col-xs-3 relative-position float-right">
                                <div class="inputBoxText">
                                    <div>
                                        تاریخ شروع
                                        <span>*</span>
                                    </div>
                                </div>
                                <div class="select-side calendarIconTourCreation">
                                    <i class="ui_icon calendar calendarIcon"></i>
                                </div>
                                <input name="sDateNotSame[]" id="sDate_1" class="observer-example inputBoxInput" type="text">
                            </div>
                            <div class="inputBoxTour col-xs-3 mg-rt-10 relative-position float-right">
                                <div class="inputBoxText">
                                    <div>
                                        تاریخ پایان
                                        <span>*</span>
                                    </div>
                                </div>
                                <div class="select-side calendarIconTourCreation">
                                    <i class="ui_icon calendar calendarIcon"></i>
                                </div>
                                <input name="eDateNotSame[]" id="eDate_1" class="observer-example inputBoxInput"/>
                            </div>

                            <div class="inline-block mg-tp-12 mg-rt-10">
                                <button type="button" id="newCalendar_1" class="wholesaleDiscountLimitationBtn verifyBtnTourCreation" onclick="newCalendar()">
                                    <img src="{{URL::asset('images/tourCreation/approve.png')}}">
                                </button>
                                <button type="button" id="deleteCalendar_1" class="wholesaleDiscountLimitationBtn deleteBtnTourCreation" onclick="deleteCalendar(1)" style="display: none;">
                                    <img src="{{URL::asset('images/tourCreation/delete.png')}}">
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="ui_container">
                <div class="menu ui_container whiteBox">
                    <div class="boxTitlesTourCreation">زبان تور</div>
                    <div class="inboxHelpSubtitle">آیا تور شما به غیر از زبان فارسی، از زبان دیگری پشتیبانی می‌کند.</div>
                    <div class="inputBoxTour col-xs-12 relative-position">
                        <div class="inputBoxText width-130">
                            <div>
                                زبان‌های دیگر
                                <span>*</span>
                            </div>
                        </div>
                        <div class="select-side">
                            <i class="glyphicon glyphicon-triangle-bottom"></i>
                        </div>

                        <div id="multiSelected" class="transportationKindChosenMainDiv" onclick="openMultiSelect()"></div>

                        <div id="multiselect" class="multiselect"></div>

                    </div>
                </div>
            </div>

            <div class="ui_container">
                <div class="menu ui_container whiteBox">
                    <div class="boxTitlesTourCreation">راهنمای تور</div>
                    <div class="inboxHelpSubtitle"> نام راهنمای تور خود را وارد نمایید. این امر نقش مؤثری در اطمینان خاطر کاربران خواهد داشت.</div>
                    <div class="tourGuiderQuestions mg-tp-15">
                        <span>آیا تور شما راهنما دارد؟</span>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary">
                                <input type="radio" name="isTourGuide" value="0" onchange="showTourGuid(this.value)" >خیر
                            </label>
                            <label class="btn btn-secondary active">
                                <input type="radio" name="isTourGuide" value="1" onchange="showTourGuid(this.value)"  checked>بلی
                            </label>
                        </div>
                    </div>

                    <div id="isTourGuidDiv">
                        <div class="tourGuiderQuestions mg-tp-15">
                            <span>آیا راهنمای تور شما از افراد محلی منطقه می باشد؟</span>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary">
                                    <input type="radio" name="isLocalTourGuide" value="0">خیر
                                </label>
                                <label class="btn btn-secondary active">
                                    <input type="radio" name="isLocalTourGuide" value="1" checked>بلی
                                </label>
                            </div>
                        </div>
                        <div class="tourGuiderQuestions mg-tp-15">
                            <span>آیا راهنمای تور شما تجربه‌ی مخصوصی برای افراد فراهم می‌آورد؟</span>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary">
                                    <input type="radio" name="isSpecialTourGuid" value="0">خیر
                                </label>
                                <label class="btn btn-secondary active">
                                    <input type="radio" name="isSpecialTourGuid" value="1" checked>بلی
                                </label>
                            </div>
                        </div>
                        <div class="inboxHelpSubtitle mg-tp-5">
                            برخی از راهنمایان تور صرفاً گروه را هدایت می‌کنند اما برخی همراه با گردشگران در همه جا حضور می‌یابند و تجربه‌ی اختصاصی‌تری ایجاد می‌کنند.
                        </div>
                        <div class="tourGuiderQuestions mg-tp-15">
                            <span>آیا راهنمای تور شما هم اکنون مشخص است؟</span>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary">
                                    <input type="radio" name="isTourGuidDefined" value="0" onchange="tourGuidDefined(this.value)">خیر
                                </label>
                                <label class="btn btn-secondary active">
                                    <input type="radio" name="isTourGuidDefined" value="1" onchange="tourGuidDefined(this.value)" checked>بلی
                                </label>
                            </div>
                        </div>

                        <div id="isTourGuidDefinedDiv">
                            <div class="tourGuiderQuestions mg-tp-15">
                                <span>آیا راهنمای تور شما دارای حساب کاربری کوچیتا می‌باشد؟</span>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-secondary active">
                                        <input type="radio" name="isTourGuideInKoochita" value="0" onchange="KoochitaAccount(this.value)" checked>خیر
                                    </label>
                                    <label class="btn btn-secondary ">
                                        <input type="radio" name="isTourGuideInKoochita" value="1" onchange="KoochitaAccount(this.value)">بلی
                                    </label>
                                </div>
                            </div>

                            <div id="notKoochitaAccountDiv">
                                <div class="inboxHelpSubtitle mg-tp-5">
                                    به راهنمای تور خدا توصیه کنید تا حساب خود را در کوچیتا ایجاد نماید و از مزایای آن بهره‌مند شود. برای ما راهنمایان تور دارای حساب کاربری از اهمیت بیشتری برخوردار هستند. پس از باز کردن حساب کاربری راهنمای تور شما می‌تواند با وارد کردن کد تور و پس از تأیید شما نام خود را به صفحه‌ی کاربریش اتصال دهد.
                                </div>
                                <div class="inputBoxTour float-right col-xs-2 mg-rt-50">
                                    <div class="inputBoxText width-45per">
                                        <div>
                                            جنسیت
                                            <span>*</span>
                                        </div>
                                    </div>
                                    <div class="select-side">
                                        <i class="glyphicon glyphicon-triangle-bottom"></i>
                                    </div>
                                    <select class="inputBoxInput width-50per styled-select" name="tourGuidSex">
                                        <option value="1">مرد</option>
                                        <option value="0">زن</option>
                                    </select>
                                </div>
                                <div class="inputBoxTour float-right col-xs-4 mg-rt-50">
                                    <div class="inputBoxText">
                                        <div>
                                            نام
                                            <span>*</span>
                                        </div>
                                    </div>
                                    <input class="inputBoxInput" name="tourGuidFirstName" id="tourGuidFirstName" type="text" placeholder="فارسی">
                                </div>
                                <div class="inputBoxTour float-right col-xs-3">
                                    <div class="inputBoxText">
                                        <div>
                                            نام خانوادگی
                                            <span>*</span>
                                        </div>
                                    </div>
                                    <input class="inputBoxInput" name="tourGuidLastName" id="tourGuidLastName" type="text" placeholder="فارسی">
                                </div>
                            </div>

                            <div id="haveKoochitaAccountDiv" style="display: none;">
                                <div class="inboxHelpSubtitle mg-tp-5">
                                    درخواست شما برای کاربر مورد نظر ارسال می‌شود و پس از تأیید او نام او به عنوان راهنمای تور معرفی می‌گردد.
                                </div>
                                <div class="inputBoxTour float-right col-xs-3">
                                    <div class="inputBoxText">
                                        <div>
                                            ایمیل
                                            <span>*</span>
                                        </div>
                                    </div>
                                    <input class="inputBoxInput" type="text" name="tourGuidKoochitaEmail" id="tourGuidKoochitaEmail" onchange="checkKoochitaAccount(this.value)">
                                    <div id="notFindAccount" style="display: none; color: red;">
                                        کاربری با این ایمیل موجود نیست
                                    </div>
                                    <div id="FindAccount" style="display: none; color: green;">
                                        کاربر مورد نظر یافت شد
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="ui_container">
                <div class="menu ui_container whiteBox">
                    <div class="boxTitlesTourCreation">تلفن پشتیبانی</div>
                    <div class="tourGuiderQuestions mg-tp-15">
                        <span>آیا از شماره‌ی موجود در پروفایل خود استفاده می‌کنید؟</span>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary">
                                <input type="radio" name="isBackUpPhone" value="0" onchange="isBackUpPhoneFunc(this.value)" >خیر
                            </label>
                            <label class="btn btn-secondary active">
                                <input type="radio" name="isBackUpPhone" value="1" onchange="isBackUpPhoneFunc(this.value)" checked>بلی
                            </label>
                        </div>
                    </div>
                    <div id="backUpPhoneDiv">
                        <div class="inputBoxTour float-right col-xs-3">
                            <div class="inputBoxText">
                                <div>
                                    تلفن
                                    <span>*</span>
                                </div>
                            </div>
                            <input class="inputBoxInput" name="backUpPhone" type="text" placeholder="09XXXXXXXXX">
                        </div>
                        <div class="inboxHelpSubtitle">
                        شماره را همانگونه که با موبایل خود تماس می‌گیرید وارد نمایید. در صورت وجود بیش از یک شماره با استفاده از، شماره‌ها را جدا نمایید.
                    </div>
                    </div>
                </div>
            </div>

            <div class="ui_container">
                <button type="button" id="goToSixthStep" class="btn nextStepBtnTourCreation" onclick="checkInputs()">گام بعدی</button>
            </div>

        </form>
    </div>

    <div class="errorDiv" id="errorDiv"></div>

    @include('layouts.footer.layoutFooter')
</div>

<script>
    var checkKoochitaAccountRoute = '{{route("findKoochitaAccount")}}';
    var _token = '{!! csrf_token() !!}';
    var approvePic = "{{URL::asset('images/tourCreation/approve.png')}}";
    var deletePic = "{{URL::asset('images/tourCreation/delete.png')}}";
    var datePickerOptions = {
        numberOfMonths: 1,
        showButtonPanel: true,
        dateFormat: "yy/mm/dd"
    };
    $('.observer-example').datepicker(datePickerOptions);
</script>


</body>
</html>
