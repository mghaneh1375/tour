@extends('pages.tour.create.createTourLayout')

@section('head')
    <style>
        .transportInfoSec{
            display: flex !important;
            align-items: center;
            flex-wrap: wrap;
            direction: rtl;
            float: unset;
        }
        .transportInfoSec > div{
            width: 100%;
            display: flex;
            align-items: center;
        }
    </style>
@endsection


@section('body')

    <div class="ui_container">
        <div class="menu whiteBox">
            <div class="boxTitlesTourCreation">حمل و نقل اصلی</div>
            <div class="mainTransportationHelpTourCreation">حمل و نقل اصلی مرتبط با انتقال مسافران از مبدأ به مقصد و بالعکس می‌باشد</div>
            <div id="tourTransportationResponsibility">
                <span>آیا حمل و نقل اصلی برعهده‌ی تور است؟</span>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-secondary">
                        <input type="radio" name="isTransportTour" value="0" onchange="showSection('tourMainTransports', this.value)">
                        خیر
                    </label>
                    <label class="btn btn-secondary active">
                        <input type="radio" name="isTransportTour" value="1" onchange="showSection('tourMainTransports', this.value)" checked>
                        بلی
                    </label>

                </div>
            </div>

            <div id="tourMainTransports">
                @if(true)
                    <div id="sDiv" class="transportationDetailsMainBoxes">
                        <input type="hidden" name="eTransport" id="eTransport" value="-1">
                        <div class="transportationTitleBoxesLocal" id="toTheDestinationTitleBox">
                            <div>جابجایی تور</div>
                        </div>
                        <div class="inputBoxTour col-xs-4 transportationKindTourCreation" id="sTransportDiv">
                            <div class="inputBoxText">
                                <div>
                                    نوع وسیله
                                    <span>*</span>
                                </div>
                            </div>
                            <div class="select-side">
                                <i class="glyphicon glyphicon-triangle-bottom"></i>
                            </div>
                            <select id="sTransport" class="inputBoxInput styled-select">
                                <option value="0">انتخاب کنید</option>
                                @foreach($transport as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="inputBoxTour col-xs-4 transportationStartTimeTourCreation" id="sTimeDiv">
                            <div class="inputBoxText">
                                <div>
                                    ساعت حرکت
                                    <span>*</span>
                                </div>
                            </div>
                            <input id="sTime" type="text" class="inputBoxInput center clock" placeholder="00:00" required readonly>
                        </div>
                        <div class="inboxHelpSubtitle">تاریخ رفت تاریخ شروع تور در نظر گرفته شود.</div>

                        <div class="inputBoxTour col-xs-9" id="sAddressDiv" style="margin-left: 10px;">
                            <div class="inputBoxText">
                                <div>
                                    محل شروع
                                    <span>*</span>
                                </div>
                            </div>
                            <input id="sAddress" class="inputBoxInput" type="text" placeholder="آدرس سوار شدن مساقران">
                        </div>
                        <button type="button" class="transportationMapPinningTourCreation col-xs-2" data-toggle="modal" data-target="#modalMap" onclick="changeCenter('src')">نشانه‌گذاری بر روی نقشه</button>
                        <input type="hidden" id="sLat" value="0">
                        <input type="hidden" id="sLng" value="0">

                        <div class="inputBoxTour col-xs-12" >
                            <div class="inputBoxText" style="width: 120px">توضیحات تکمیلی</div>
                            <textarea id="sDescription" class="inputBoxInput" placeholder="حداکثر 100 کاراکتر" maxlength="100"></textarea>
                        </div>


                        <div class="seperatorInWhiteSec" style="width: 100%; direction: rtl; float: right; display: flex; flex-wrap: wrap;">
                            <div class="inputBoxTour col-xs-4 transportationStartTimeTourCreation" id="eTimeDiv" style="margin-left: 10px;">
                                <div class="inputBoxText">
                                    <div>
                                        ساعت اتمام
                                        <span>*</span>
                                    </div>
                                </div>
                                <input id="eTime" type="text" class="inputBoxInput clock" placeholder="00:00" readonly>
                            </div>
                            <div id="eAddressDiv" class="inputBoxTour col-xs-9" style="margin-left: 10px;">
                                <div class="inputBoxText">
                                    <div>
                                        محل اتمام
                                        <span>*</span>
                                    </div>
                                </div>
                                <input id="eAddress" class="inputBoxInput" type="text" placeholder="فارسی">
                            </div>
                            <button type="button" class="transportationMapPinningTourCreation col-xs-2" data-toggle="modal" data-target="#modalMap" onclick="changeCenter('dest')">نشانه‌گذاری بر روی نقشه</button>
                            <input id="eLat" type="hidden" value="0">
                            <input id="eLng" type="hidden" value="0">

                            <div class="inputBoxTour col-xs-12" >
                                <div class="inputBoxText" style="width: 120px">توضیحات تکمیلی</div>
                                <textarea id="eDescription" class="inputBoxInput" placeholder="حداکثر 100 کاراکتر" maxlength="100"></textarea>
                            </div>
                        </div>
                    </div>
                @else
                    <div id="sDiv" class="transportationDetailsMainBoxes">
                        <div class="transportationTitleBoxes" id="toTheDestinationTitleBox"> رفت </div>
                        <div class="transportInfoSec">
                            <div>
                                <div id="sTransportDiv" class="inputBoxTour col-xs-4 transportationKindTourCreation" style="margin-left: 15px;">
                                    <div class="inputBoxText">
                                        <div>
                                            نوع وسیله
                                            <span>*</span>
                                        </div>
                                    </div>
                                    <div class="select-side">
                                        <i class="glyphicon glyphicon-triangle-bottom"></i>
                                    </div>
                                    <select id="sTransport" class="inputBoxInput styled-select">
                                        <option value="0">انتخاب کنید</option>
                                        @foreach($transport as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="sTimeDiv" class="inputBoxTour transportationStartTimeTourCreation" style="margin-left: 15px;">
                                    <div class="inputBoxText">
                                        <div>
                                            ساعت حرکت
                                            <span>*</span>
                                        </div>
                                    </div>

                                    <input type="text" id="sTime" class="inputBoxInput center clock" placeholder="00:00" readonly>
                                </div>
                                <div class="inboxHelpSubtitle">تاریخ رفت تاریخ شروع تور در نظر گرفته شود.</div>
                            </div>

                            <div>
                                <div class="inputBoxTour col-xs-10" id="sAddressDiv"  style="margin-left: 10px;">
                                    <div class="inputBoxText">
                                        <div>
                                            محل حرکت
                                            <span>*</span>
                                        </div>
                                    </div>
                                    <input id="sAddress" class="inputBoxInput" type="text" placeholder="آدرس دقیق محل حرکت را وارد نمایید...">
                                </div>
                                <button type="button" class="transportationMapPinningTourCreation col-xs-2" data-toggle="modal" data-target="#modalMap" onclick="changeCenter('src')">نشانه‌گذاری بر روی نقشه</button>
                                <input type="hidden" id="sLat" value="0">
                                <input type="hidden" id="sLng" value="0">
                            </div>

                            <div>
                                <div class="inputBoxTour col-xs-12">
                                    <div class="inputBoxText" style="width: 120px">توضیحات تکمیلی</div>
                                    <textarea id="sDescription" class="inputBoxInput" type="text" placeholder="حداکثر 100 کاراکتر" maxlength="100"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="eDiv" class="transportationDetailsMainBoxes" style="border-top: solid 1px lightgray;">
                        <div class="transportationTitleBoxes" id="fromTheDestinationTitleBox">برگشت</div>
                        <div class="row transportInfoSec">
                            <div>
                                <div id="eTransportDiv" class="inputBoxTour col-xs-4 transportationKindTourCreation" style="margin-left: 15px;">
                                    <div class="inputBoxText">
                                        <div>
                                            نوع وسیله
                                            <span>*</span>
                                        </div>
                                    </div>
                                    <div class="select-side">
                                        <i class="glyphicon glyphicon-triangle-bottom"></i>
                                    </div>
                                    <select id="eTransport" class="inputBoxInput styled-select">
                                        <option value="0">انتخاب کنید</option>
                                        @foreach($transport as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="inputBoxTour transportationStartTimeTourCreation" id="eTimeDiv" style="margin-left: 15px;">
                                    <div class="inputBoxText">
                                        <div>
                                            ساعت حرکت
                                            <span>*</span>
                                        </div>
                                    </div>
                                    <input id="eTime" type="text" class="inputBoxInput center clock" placeholder="00:00" readonly>
                                </div>
                                <div class="inboxHelpSubtitle">تاریخ برگشت تاریخ پایان تور در نظر گرفته شود.</div>
                            </div>
                            <div>
                                <div class="inputBoxTour col-xs-10" id="eAddressDiv" style="margin-left: 10px;">
                                    <div class="inputBoxText" style="width: 120px;">
                                        <div>
                                            محل پیاده شدن
                                            <span>*</span>
                                        </div>
                                    </div>
                                    <input id="eAddress" class="inputBoxInput" type="text" placeholder="آدرس دقیق محل بازگشت را وارد نمایید...">
                                </div>
                                <button type="button" class="transportationMapPinningTourCreation col-xs-2" data-toggle="modal" data-target="#modalMap" onclick="changeCenter('dest')">نشانه‌گذاری بر روی نقشه</button>
                                <input type="hidden" name="eLat" id="eLat" value="0">
                                <input type="hidden" name="eLng" id="eLng" value="0">
                            </div>

                            <div>
                                <div class="inputBoxTour col-xs-12">
                                    <div class="inputBoxText" style="width: 120px">توضیحات تکمیلی</div>
                                    <textarea id="eDescription" class="inputBoxInput" type="text" placeholder="حداکثر 100 کاراکتر"  maxlength="100"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="whiteBox">
            <div class="boxTitlesTourCreation">حمل و نقل فرعی</div>
            <div class="inboxHelpSubtitle">
                حمل و نقل فرعی مرتبط با انتقال مسافران در داخل مقصد و در طول برگزاری تور می‌باشد.
            </div>

            <div class="row">
                <div class="inputBoxTour col-xs-12 relative-position" id="mainClassificationOfTransportationInputDiv">
                    <div class="inputBoxText" id="mainClassificationOfTransportationLabel">
                        <div>
                            دسته‌بندی اصلی
                            {{--                                    <span>*</span>--}}
                        </div>
                    </div>
                    <div class="select-side">
                        <i class="glyphicon glyphicon-triangle-bottom"></i>
                    </div>

                    <div id="multiSelected" class="transportationKindChosenMainDiv multiSelected" onclick="openMultiSelect(this)"></div>

                    <div id="multiselect" class="multiselect">
                        @foreach($transport as $item)
                            <div class="optionMultiSelect" id="multiSelectTransport_{{$item->id}}" onclick="chooseMultiSelectSideTransport({{$item->id}})">
                                {{$item->name}}
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
            <div class="inboxHelpSubtitle">در صورت وجود بیشتر از یک وسیله همه‌ی آن‌ها را انتخاب نمایید.</div>

            <div class="tourFoodOfferQuestions">
                <span>آیا حمل و نقل فرعی تور شامل هزینه اضافه است؟</span>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-secondary active">
                        <input type="radio" name="isCostForMainTransport" value="0" onchange="showSection('mainTransportCostDiv', this.value)" checked>خیر
                    </label>
                    <label class="btn btn-secondary">
                        <input type="radio" name="isCostForMainTransport" value="1" onchange="showSection('mainTransportCostDiv', this.value)">بلی
                    </label>
                </div>
            </div>

            <div id="mainTransportCostDiv" style="display: none;">
                <div class="inputBoxTour float-right col-xs-5">
                    <div class="inputBoxText">
                        <div>
                            هزینه اضافی
                            <span>*</span>
                        </div>
                    </div>
                    <input id="sideTransportCost" class="inputBoxInput" type="text" placeholder="ریال" onkeyup="$(this).val(numberWithCommas(this.value))">
                </div>
            </div>
        </div>

        <div class="whiteBox">
            <div class="boxTitlesTourCreation">وعده‌ی غذایی</div>
            <div class="seperatorInWhiteSec">
                <span>آیا در طول مدت تور وعده‌ی غذایی ارائه می‌شود؟</span>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-secondary active">
                        <input type="radio" name="isMeal" value="0" onchange="showSection('mealsDiv', this.value)" checked>خیر
                    </label>
                    <label class="btn btn-secondary">
                        <input type="radio" name="isMeal" value="1" onchange="showSection('mealsDiv', this.value)">بلی
                    </label>
                </div>
            </div>

            <div id="mealsDiv" style="display: none;">
                <div class="seperatorInWhiteSec">
                    <span>آیا وعده‌های غذایی تمام روزهای تور ارائه می‌شود و یا فقط در چند روز خاص قابل ارائه می‌باشد؟</span>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary">
                            <input type="radio" name="isMealsAllDay" value="0" onchange="changeKindOfMeal(this.value)" >چند روز خاص
                        </label>
                        <label class="btn btn-secondary active">
                            <input type="radio" name="isMealsAllDay" value="1" onchange="changeKindOfMeal(this.value)" checked>تمامی روزها
                        </label>
                    </div>


                    <div id="selectKindOfMealAllDay" style="display: inline-block;">
                        <div class="halfWidthDiv tourFoodMealTitleTourCreation">نوع وعده را انتخاب نمایید؟</div>
                        <div class="halfWidthDiv tourFoodMealChoseTourCreation">
                            <div class="col-xs-3">
                                <input name="meals[]" type="checkbox" id="c58" value="شام"/>
                                <label for="c58">
                                    <span></span>
                                    شام
                                </label>
                            </div>
                            <div class="col-xs-3">
                                <input name="meals[]" type="checkbox" id="c59" value="میان‌وعده"/>
                                <label for="c59">
                                    <span></span>
                                    میان‌وعده
                                </label>
                            </div>
                            <div class="col-xs-3">
                                <input name="meals[]" type="checkbox" id="c57" value="ناهار"/>
                                <label for="c57" >
                                    <span></span>
                                    ناهار
                                </label>
                            </div>
                            <div class="col-xs-3">
                                <input name="meals[]" type="checkbox" id="c56" value="صبحانه"/>
                                <label for="c56">
                                    <span></span>
                                    صبحانه
                                </label>
                            </div>
                        </div>
                    </div>

                    <div id="selectMealDays" style="display: none">
                        <div class="inboxHelpSubtitle">روز هایی که وعده غذایی ارائه می شود را انتخاب کنید</div>
                        <div>
                            @for($i = 1; $i <= $tour->day; $i++)
                                <div style="display: inline-block;">
                                    <div class="halfWidthDiv tourFoodMealTitleTourCreation">وعده ارائه شده برای روز {{$i}}</div>
                                    <div class="halfWidthDiv tourFoodMealChoseTourCreation">
                                        <div class="col-xs-3">
                                            <input id="meals3_day_{{$i}}" name="meals_day_{{$i}}" type="checkbox" value="شام"/>
                                            <label for="meals3_day_{{$i}}">
                                                <span></span>
                                                شام
                                            </label>
                                        </div>
                                        <div class="col-xs-3">
                                            <input id="meals4_day_{{$i}}" name="meals_day_{{$i}}" type="checkbox" value="میان‌وعده"/>
                                            <label for="meals4_day_{{$i}}">
                                                <span></span>
                                                میان‌وعده
                                            </label>
                                        </div>
                                        <div class="col-xs-3">
                                            <input id="meals2_day_{{$i}}" name="meals_day_{{$i}}" type="checkbox" value="ناهار"/>
                                            <label for="meals2_day_{{$i}}">
                                                <span></span>
                                                ناهار
                                            </label>
                                        </div>
                                        <div class="col-xs-3">
                                            <input id="meals1_day_{{$i}}" name="meals_day_{{$i}}" type="checkbox" value="صبحانه"/>
                                            <label for="meals1_day_{{$i}}">
                                                <span></span>
                                                صبحانه
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>

                </div>


                <div class="seperatorInWhiteSec">
                    <span>آیا وعده‌های غذایی نیازمند هزینه‌ی اضافی است؟</span>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary active">
                            <input type="radio" name="isMealCost" value="0" onchange="showSection('mealCostDiv', this.value)" checked>خیر
                        </label>
                        <label class="btn btn-secondary">
                            <input type="radio" name="isMealCost" value="1" onchange="showSection('mealCostDiv', this.value)">بلی
                        </label>
                    </div>

                    <div id="mealCostDiv" style="display: none;">
                        <div class="inputBoxTour float-right col-xs-3">
                            <div class="inputBoxText">
                                <div>
                                    هزینه اضافی
                                    <span>*</span>
                                </div>
                            </div>
                            <input id="mealCost" class="inputBoxInput" type="text" placeholder="ریال" onkeyup="$(this).val(numberWithCommas(this.value))">
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="whiteBox">
            <div class="boxTitlesTourCreation">زبان تور</div>
            <div class="inboxHelpSubtitle">آیا تور شما به غیر از زبان فارسی، از زبان دیگری پشتیبانی می‌کند.</div>
            <div class="inputBoxTour col-xs-12 relative-position">
                <div class="inputBoxText width-130"> زبان‌های دیگر</div>
                <div class="select-side">
                    <i class="glyphicon glyphicon-triangle-bottom"></i>
                </div>

                <div id="multiSelectedLanguage" class="transportationKindChosenMainDiv multiSelected" onclick="openMultiSelect(this)"></div>

                <div id="multiSelectLanguage" class="multiselect"></div>

            </div>
        </div>

        <div class="whiteBox">
            <div class="boxTitlesTourCreation">راهنمای تور</div>
            <div class="inboxHelpSubtitle"> نام راهنمای تور خود را وارد نمایید. این امر نقش مؤثری در اطمینان خاطر کاربران خواهد داشت.</div>
            <div class="tourGuiderQuestions mg-tp-15">
                <span>آیا تور شما راهنما دارد؟</span>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-secondary">
                        <input type="radio" name="isTourGuide" value="0" onchange="showSection('isTourGuidDiv', this.value)" >خیر
                    </label>
                    <label class="btn btn-secondary active">
                        <input type="radio" name="isTourGuide" value="1" onchange="showSection('isTourGuidDiv', this.value)"  checked>بلی
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
                <div class="inboxHelpSubtitle mg-tp-5" style="width: 100%">برخی از راهنمایان تور صرفاً گروه را هدایت می‌کنند اما برخی همراه با گردشگران در همه جا حضور می‌یابند و تجربه‌ی اختصاصی‌تری ایجاد می‌کنند.</div>
                <div class="tourGuiderQuestions mg-tp-15">
                    <span>آیا راهنمای تور شما هم اکنون مشخص است؟</span>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary">
                            <input type="radio" name="isTourGuidDefined" value="0" onchange="showSection('isTourGuidDefinedDiv', this.value)">خیر
                        </label>
                        <label class="btn btn-secondary active">
                            <input type="radio" name="isTourGuidDefined" value="1" onchange="showSection('isTourGuidDefinedDiv', this.value)" checked>بلی
                        </label>
                    </div>
                </div>

                <div id="isTourGuidDefinedDiv">
                    <div class="tourGuiderQuestions mg-tp-15">
                        <span>آیا راهنمای تور شما دارای حساب کاربری کوچیتا می‌باشد؟</span>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary active">
                                <input type="radio" name="isTourGuidInKoochita" value="0" onchange="hasKoochitaAccount(this.value)" checked>خیر
                            </label>
                            <label class="btn btn-secondary ">
                                <input type="radio" name="isTourGuidInKoochita" value="1" onchange="hasKoochitaAccount(this.value)">بلی
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
                            <select id="tourGuidSex" class="inputBoxInput width-50per styled-select">
                                <option value="1">مرد</option>
                                <option value="0">زن</option>
                            </select>
                        </div>
                        <div class="inputBoxTour float-right col-xs-5">
                            <div class="inputBoxText" style="width: 160px">
                                <div>
                                    نام و نام خانوادگی
                                    <span>*</span>
                                </div>
                            </div>
                            <input id="tourGuidName" class="inputBoxInput" type="text" placeholder="فارسی">
                        </div>
                    </div>

                    <div id="haveKoochitaAccountDiv" style="display: none;">
                        <div class="inboxHelpSubtitle mg-tp-5" style="width: 100%;">درخواست شما برای کاربر مورد نظر ارسال می‌شود و پس از تأیید او نام او به عنوان راهنمای تور معرفی می‌گردد.</div>
                        <div class="inputBoxTour float-right col-xs-3">
                            <div class="inputBoxText">
                                <div>
                                    نام کاربری
                                    <span>*</span>
                                </div>
                            </div>
                            <input id="tourGuidKoochitaUsername" class="inputBoxInput" type="text" onclick="openSearchKoochitaAccount()" readonly>
                            <input type="hidden" id="tourGuidUserId" value="0">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="whiteBox">
            <div class="boxTitlesTourCreation">تلفن پشتیبانی</div>
            <div class="tourGuiderQuestions mg-tp-15">
                <span>آیا از شماره‌ی موجود در پروفایل خود استفاده می‌کنید؟</span>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-secondary active">
                        <input type="radio" name="isBackUpPhone" value="1" onchange="showSection('backUpPhoneDiv', this.value)" checked>خیر
                    </label>
                    <label class="btn btn-secondary">
                        <input type="radio" name="isBackUpPhone" value="0" onchange="showSection('backUpPhoneDiv', this.value)">بلی
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
                    <input id="backUpPhone" class="inputBoxInput" type="text" placeholder="09XXXXXXXXX">
                </div>
                <div class="inboxHelpSubtitle" style="width: 100%;">
                    شماره را همانگونه که با موبایل خود تماس می‌گیرید وارد نمایید. در صورت وجود بیش از یک شماره با استفاده از - شماره‌ها را جدا نمایید.
                </div>
            </div>
        </div>


        <div class="row" style="padding: 15px;">
            <button class="btn nextStepBtnTourCreation" type="button" onclick="checkInput()">گام بعدی</button>
        </div>
    </div>

    <div class="modal fade" id="modalMap">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="map" style="width: 100%; height: 500px"></div>
                </div>
                <div class="modal-footer" style="text-align: center">
                    <button type="button" class="btn btn-success" data-dismiss="modal">تایید</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var tour = {!! $tour!!};
        var transports = {!! $transport !!};

        var inKoochita = 0 ;
        var isTransport = 1;
        var multiIsOpen = false;
        var chooseSideTransport = [];
        var language = [
            'فارسی',
            'انگلیسی',
            'عربی',
            'ترکی',
            'چینی',
            'کره ای',
            'ژاپنی',
            'اسپانیایی',
            'آلمانی',
            'فرانسوی',
            'پرتغالی',
        ];
        var languageChoose = [];
        var clockOptions = {
            placement: 'left',
            donetext: 'تایید',
            autoclose: true,
        };

        var showSection = (_id, _value) => $(`#${_id}`).css('display', _value == 1 ? 'block' : 'none');


        function initLanguage(){
            var text = '';
            language.map((item, index) => text += `<div class="optionMultiSelect" id="multiSelectLanguage_${index}" onclick="chooseLanguageMultiSelect(${index})">${item}</div>`);
            $("#multiSelectLanguage").html(text);
        }

        $(window).ready(() => {
            $('.clock').clockpicker(clockOptions);
            initLanguage();
        });
        $(window).on('click', e => {
            var target = $(e.target);
            if( multiIsOpen  && !target.is('.optionMultiSelect') && !target.is('.multiSelected'))
                $('.multiselect').hide();
        });

        function openMultiSelect(_element){
            if(multiIsOpen){
                $(_element).next().hide();
                multiIsOpen = false;
            }
            else{
                $(_element).next().show();
                multiIsOpen = true;
            }
        }

        function chooseMultiSelectSideTransport(_id){
            var choose = 0;
            var text = '';

            for(i = 0; i < transports.length; i++){
                if(transports[i].id == _id){
                    choose = transports[i];
                    break;
                }
            }

            if(choose != 0)
                document.getElementById('multiSelectTransport_' + choose.id).style.display = 'none';


            text = '<div id="selectedMulti_' + choose.id + '" class="transportationKindChosenOnes col-xs-2">\n' + choose.name +
                '<span class="glyphicon glyphicon-remove" onclick="removeMultiSelectSideTransport(' + choose.id + ')"></span>\n' +
                '</div>';
            $('#multiSelected').append(text);


            if(chooseSideTransport.includes(0)){
                index = chooseSideTransport.indexOf(0);
                chooseSideTransport[index] = choose.id;
            }
            else
                chooseSideTransport[chooseSideTransport.length] = choose.id;

        }
        function removeMultiSelectSideTransport(_id){
            $('#selectedMulti_' + _id).remove();
            document.getElementById('multiSelectTransport_' + _id).style.display = 'block';
            if(chooseSideTransport.includes(_id)){
                index = chooseSideTransport.indexOf(_id);
                chooseSideTransport[index] = 0;
            }
        }

        function chooseLanguageMultiSelect(_index){
            if(languageChoose.indexOf(language[_index]) == -1) {
                languageChoose[languageChoose.length] = language[_index];
                $(`#multiSelectLanguage_${_index}`).css('display', 'none');

                var text = `<div id="selectedMultiLanguage_${_index}" class="transportationKindChosenOnes col-xs-2">${language[_index]}
                        <span class="glyphicon glyphicon-remove" onclick="removeMultiSelectLanguage(${_index})"></span>
                    </div>`;
                $('#multiSelectedLanguage').append(text);
            }
        }
        function removeMultiSelectLanguage(_index){
            $('#selectedMultiLanguage_' + _index).remove();
            $(`#multiSelectLanguage_${_index}`).css('display', 'block');
            if(languageChoose.includes(language[_index])){
                var index = languageChoose.indexOf(language[_index]);
                languageChoose.splice(index, 1);
            }
        }

        function changeKindOfMeal(_value){
            $('#selectKindOfMealAllDay').css('display', _value == 1 ? 'inline-block' : 'none');
            $('#selectMealDays').css('display', _value == 1 ? 'none' : 'block');
        }

        function hasKoochitaAccount(_value){
            $('#notKoochitaAccountDiv').css('display', _value == 1 ? 'none' : 'block');
            $('#haveKoochitaAccountDiv').css('display', _value == 1 ? 'block' : 'none');
        }

        function openSearchKoochitaAccount() {
            openKoochitaUserSearchModal('راهنمای تور خود را مشخص کنید', (_id, _username) => {
                $('#tourGuidKoochitaUsername').val(_username);
                $('#tourGuidUserId').val(_id);
            })
        }

        function checkInput(){
            var errorText = '';

            var data = {
                isTransportTour : $('input[name="isTransportTour"]:checked').val(),
                sTransportKind : $('#sTransport').val(),
                eTransportKind : $('#eTransport').val(),
                sTime : $('#sTime').val(),
                eTime : $('#eTime').val(),
                sAddress : $('#sAddress').val(),
                eAddress : $('#eAddress').val(),
                sLat : $('#sLat').val(),
                eLat : $('#eLat').val(),
                sLng : $('#sLng').val(),
                eLng : $('#eLng').val(),
                sDescription : $('#sDescription').val(),
                eDescription : $('#eDescription').val(),

                sideTransport: chooseSideTransport,
                isSideTransportCost: $('input[name="isCostForMainTransport"]:checked').val(),
                sideTransportCost: $('#sideTransportCost').val().replace(new RegExp(',', 'g'), ''),

                isMeal: $('input[name="isMeal"]:checked').val(),
                isMealsAllDay: $('input[name="isMealsAllDay"]:checked').val(),
                isMealCost: $('input[name="isMealCost"]:checked').val(),
                mealMoreCost: $('#mealCost').val().replace(new RegExp(',', 'g'), ''),
                allDayMeals: [],
                sepecificDayMeals: [],

                otherLanguage: languageChoose,

                hasTourGuid: $('input[name="isTourGuide"]:checked').val(),
                isLocalTourGuide: $('input[name="isLocalTourGuide"]:checked').val(),
                isSpecialTourGuid: $('input[name="isSpecialTourGuid"]:checked').val(),
                isTourGuidDefined: $('input[name="isTourGuidDefined"]:checked').val(),
                isTourGuidInKoochita: $('input[name="isTourGuidInKoochita"]:checked').val(),
                koochitaUserId: $('#tourGuidUserId').val(),
                tourGuidName: $('#tourGuidName').val(),
                tourGuidSex: $('#tourGuidSex').val(),

                isBackUpPhone: $('input[name="isBackUpPhone"]:checked').val(),
                backUpPhone: $('#backUpPhone').val(),
            };

            if(data.isTransportTour == 1){
                if(data.sTransportKind.trim().length == 0)
                    errorText += '<li>نوع وسیله رفت را مشخص کنید</li>';

                if(data.sTime.trim().length == 0)
                    errorText += '<li>ساعت رفت را مشخص کنید</li>';

                if(data.sAddress.trim().length == 0)
                    errorText += '<li>محل رفت را مشخص کنید</li>';

                if(data.sLat == 0 || data.sLng == 0)
                    errorText += '<li>محل رفت را روی نقشه مشخص کنید</li>';


                if(data.eTransportKind.trim().length == 0)
                    errorText += '<li>نوع وسیله برگشت را مشخص کنید</li>';

                if(data.eTime.trim().length == 0)
                    errorText += '<li>ساعت برگشت را مشخص کنید</li>';

                if(data.eAddress.trim().length == 0)
                    errorText += '<li>محل برگشت را مشخص کنید</li>';

                if(data.eLat == 0 || data.eLng == 0)
                    errorText += '<li>محل برگشت را روی نقشه مشخص کنید</li>';
            }

            if(data.isSideTransportCost == 1 && data.sideTransportCost.trim().length == 0)
                errorText += '<li>هزینه ی اضافی حمل و نقل فرعی را مشخص کنید</li>';

            if(data.isMeal == 1){
                if(data.isMealsAllDay == 1){
                    var meals = $('input[name="meals[]"]:checked');
                    for(var i = 0; i < meals.length; i++)
                        data.allDayMeals.push($(meals[i]).val());
                }
                else{
                    for(var day = 1; day <= tour.day; day++){
                        data.sepecificDayMeals[day-1] = [];
                        var dayMeals = $(`input[name="meals_day_${day}"]:checked`);
                        for(var i = 0; i < dayMeals.length; i++)
                            data.sepecificDayMeals[day-1].push($(dayMeals[i]).val());
                    }
                }


                if(data.isMealCost == 1 && data.mealMoreCost.trim().length == 0)
                    errorText += '<li>هزینه ی اضافی غذا را مشخص کنید</li>';

            }

            if(data.hasTourGuid == 1){
                if(data.isTourGuidDefined == 1){
                    if(data.isTourGuidInKoochita == 1 && data.koochitaUserId == 0)
                        errorText += '<li>نام کاربری راهنمای تور را مشخص کنید</li>';
                    else if(data.isTourGuidInKoochita == 0 && data.tourGuidName.trim().length == 0)
                        errorText += '<li>نام راهنمای تور را وارد کنید</li>';
                }
            }

            if(errorText.trim().length == 0){
                openLoading();
                $.ajax({
                    type: 'POST',
                    url: '{{route("tour.create.stage.three.store")}}',
                    data: {
                        _token: '{{csrf_token()}}',
                        tourId: tour.id,
                        data: JSON.stringify(data)
                    },
                    success: response => {
                        if(response.status == 'ok')
                            location.href = '{{route("tour.create.stage.four", ['id' => $tour->id])}}'
                    }
                })
            }
            else
                openErrorAlert(errorText);
        }
    </script>

    <script>
        var map;
        var srcLatLng = tour.srcLatLng;
        var destLatLng = tour.destLatLng;
        var sMarker = 0;
        var eMarker = 0;
        var mapType;

        function init(){
            var mapOptions = {
                zoom: 5,
                center: new google.maps.LatLng(32.42056639964595, 54.00537109375),
                // How you would like to style the map.
                // This is where you would paste any style found on Snazzy Maps.
                styles: [{
                    "featureType": "landscape",
                    "stylers": [{"hue": "#FFA800"}, {"saturation": 0}, {"lightness": 0}, {"gamma": 1}]
                }, {
                    "featureType": "road.highway",
                    "stylers": [{"hue": "#53FF00"}, {"saturation": -73}, {"lightness": 40}, {"gamma": 1}]
                }, {
                    "featureType": "road.arterial",
                    "stylers": [{"hue": "#FBFF00"}, {"saturation": 0}, {"lightness": 0}, {"gamma": 1}]
                }, {
                    "featureType": "road.local",
                    "stylers": [{"hue": "#00FFFD"}, {"saturation": 0}, {"lightness": 30}, {"gamma": 1}]
                }, {
                    "featureType": "water",
                    "stylers": [{"hue": "#00BFFF"}, {"saturation": 6}, {"lightness": 8}, {"gamma": 1}]
                }, {
                    "featureType": "poi",
                    "stylers": [{"hue": "#679714"}, {"saturation": 33.4}, {"lightness": -25.4}, {"gamma": 1}]
                }]
            };
            var mapElementSmall = document.getElementById('map');
            map = new google.maps.Map(mapElementSmall, mapOptions);

            google.maps.event.addListener(map, 'click', function(event) {
                getLat(event.latLng);
            });
        }

        function getLat(location){
            if(mapType == 'src') {
                if (sMarker != 0) {
                    sMarker.setMap(null);
                }
                sMarker = new google.maps.Marker({
                    position: location,
                    map: map,
                    title: 'محل رفت'
                });

                document.getElementById('sLat').value = sMarker.getPosition().lat();
                document.getElementById('sLng').value = sMarker.getPosition().lng();

            }
            else{
                if (eMarker != 0) {
                    eMarker.setMap(null);
                }
                eMarker = new google.maps.Marker({
                    position: location,
                    map: map,
                    title: 'محل بازگشت'
                });
                document.getElementById('eLat').value = eMarker.getPosition().lat();
                document.getElementById('eLng').value = eMarker.getPosition().lng();
            }
        }

        function changeCenter(kind){
            map.setZoom(12);
            mapType = kind;

            if(kind == 'src')
                map.panTo({lat: srcLatLng[0], lng: srcLatLng[1]});
            else
                map.panTo({lat: destLatLng[0], lng: destLatLng[1]});

        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyCdVEd4L2687AfirfAnUY1yXkx-7IsCER0&callback=init"></script>
@endsection

