@extends('panelBusiness.layout.baseLayout')

@section('head')
    <title>مرحله سوم</title>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/shazdeDesigns/tourCreation.css?v='.$fileVersions)}}"/>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/clockpicker.css?v=1')}}"/>
    <script src= {{URL::asset("js/clockpicker.js") }}></script>

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

    <link rel="stylesheet" href="{{URL::asset('packages/leaflet/leaflet.css')}}">
@endsection


@section('body')

    <div class="mainBackWhiteBody">
        <div class="head">ایجاد تور: مرحله سوم</div>
        <div>
            <div class="menu whiteBox">
                <div class="boxTitlesTourCreation">حمل و نقل اصلی</div>
                <div class="mainTransportationHelpTourCreation">حمل و نقل اصلی مرتبط با انتقال مسافران از مبدأ به مقصد و بالعکس می‌باشد</div>
                <div id="tourTransportationResponsibility">
                    <span>آیا حمل و نقل اصلی برعهده‌ی تور است؟</span>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary active">
                            <input type="radio" name="isTransportTour" value="1" onchange="showSection('tourMainTransports', this)" checked>
                            بله
                        </label>
                        <label class="btn btn-secondary">
                            <input type="radio" name="isTransportTour" value="0" onchange="showSection('tourMainTransports', this)">
                            خیر
                        </label>
                    </div>
                </div>

                <div id="tourMainTransports">
                    @if($tour->isLocal)
                        <div id="sDiv" class="transportationDetailsMainBoxes">
                            <div class="transportationTitleBoxesLocal" id="toTheDestinationTitleBox">
                                <div>جابجایی تور</div>
                            </div>

                            <div class="row" style="display: flex; align-items: baseline;">
                                <div class="inputBoxTour col-md-4 transportationKindTourCreation" id="sTransportDiv">
                                    <div class="inputBoxText">
                                        <div class="importantFieldLabel">نوع وسیله</div>
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

                                    <select id="eTransport" style="display: none">
                                        <option value="0">انتخاب کنید</option>
                                        @foreach($transport as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class=" col-md-4">
                                    <div class="inputBoxTour transportationStartTimeTourCreation" id="sTimeDiv">
                                        <div class="inputBoxText">
                                            <div class="importantFieldLabel">ساعت حرکت</div>
                                        </div>
                                        <input id="sTime" type="text" class="inputBoxInput center clock" placeholder="00:00" required readonly>
                                    </div>
                                    <div class="inboxHelpSubtitle">تاریخ رفت تاریخ شروع تور در نظر گرفته شود.</div>
                                </div>
                            </div>

                            <div class="row" style="display: flex">
                                <div class="inputBoxTour col-md-9" id="sAddressDiv" style="margin-left: 10px;">
                                    <div class="inputBoxText">
                                        <div class="importantFieldLabel">محل شروع</div>
                                    </div>
                                    <input id="sAddress" class="inputBoxInput" type="text" placeholder="آدرس سوار شدن مسافران">
                                </div>
                                <button type="button" class="transportationMapPinningTourCreation col-md-2" onclick="changeCenter('src')">نشانه‌گذاری بر روی نقشه</button>
                                <input type="hidden" id="sLat" value="0">
                                <input type="hidden" id="sLng" value="0">
                            </div>

                            <div class="row" style="display: flex">
                                <div class="inputBoxTour col-md-12" >
                                    <div class="inputBoxText" style="width: 120px">توضیحات تکمیلی</div>
                                    <textarea id="sDescription" class="inputBoxInput" placeholder="حداکثر 100 کاراکتر" maxlength="100"></textarea>
                                </div>
                            </div>


                            <div class="seperatorInWhiteSec" style="width: 100%; direction: rtl; float: right; display: flex; flex-wrap: wrap;">
                                <div class="row" style="display: flex">
                                    <div class="inputBoxTour col-md-4 transportationStartTimeTourCreation" id="eTimeDiv" style="margin-left: 10px;">
                                        <div class="inputBoxText">
                                            <div class="importantFieldLabel">ساعت اتمام</div>
                                        </div>
                                        <input id="eTime" type="text" class="inputBoxInput clock" placeholder="00:00" readonly>
                                    </div>
                                </div>
                                <div class="row" style="display: flex">
                                    <div id="eAddressDiv" class="inputBoxTour col-md-9" style="margin-left: 10px;">
                                        <div class="inputBoxText">
                                            <div class="importantFieldLabel">محل اتمام</div>
                                        </div>
                                        <input id="eAddress" class="inputBoxInput" type="text" placeholder="فارسی">
                                    </div>
                                    <button type="button" class="transportationMapPinningTourCreation col-md-2" onclick="changeCenter('dest')">نشانه‌گذاری بر روی نقشه</button>
                                    <input id="eLat" type="hidden" value="0">
                                    <input id="eLng" type="hidden" value="0">
                                </div>

                                <div class="row" style="display: flex">
                                    <div class="inputBoxTour col-md-12" >
                                        <div class="inputBoxText" style="width: 120px">توضیحات تکمیلی</div>
                                        <textarea id="eDescription" class="inputBoxInput" placeholder="حداکثر 100 کاراکتر" maxlength="100"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div id="sDiv" class="transportationDetailsMainBoxes">
                            <div class="transportationTitleBoxes" id="toTheDestinationTitleBox"> رفت </div>
                            <div class="transportInfoSec">
                                <div>
                                    <div id="sTransportDiv" class="inputBoxTour col-md-4 transportationKindTourCreation" style="margin-left: 15px;">
                                        <div class="inputBoxText">
                                            <div class="importantFieldLabel">نوع وسیله</div>
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
                                            <div class="importantFieldLabel">ساعت حرکت</div>
                                        </div>

                                        <input type="text" id="sTime" class="inputBoxInput center clock" placeholder="00:00" readonly>
                                    </div>
                                    <div class="inboxHelpSubtitle">تاریخ رفت تاریخ شروع تور در نظر گرفته شود.</div>
                                </div>

                                <div>
                                    <div class="inputBoxTour col-md-10" id="sAddressDiv"  style="margin-left: 10px;">
                                        <div class="inputBoxText">
                                            <div class="importantFieldLabel">محل حرکت</div>
                                        </div>
                                        <input id="sAddress" class="inputBoxInput" type="text" placeholder="آدرس دقیق محل حرکت را وارد نمایید...">
                                    </div>
                                    <button type="button" class="transportationMapPinningTourCreation col-md-2" onclick="changeCenter('src')">نشانه‌گذاری بر روی نقشه</button>
                                    <input type="hidden" id="sLat" value="0">
                                    <input type="hidden" id="sLng" value="0">
                                </div>

                                <div>
                                    <div class="inputBoxTour col-md-12">
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
                                    <div id="eTransportDiv" class="inputBoxTour col-md-4 transportationKindTourCreation" style="margin-left: 15px;">
                                        <div class="inputBoxText">
                                            <div class="importantFieldLabel">نوع وسیله</div>
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
                                            <div class="importantFieldLabel">ساعت حرکت</div>
                                        </div>
                                        <input id="eTime" type="text" class="inputBoxInput center clock" placeholder="00:00" readonly>
                                    </div>
                                    <div class="inboxHelpSubtitle">تاریخ برگشت تاریخ پایان تور در نظر گرفته شود.</div>
                                </div>
                                <div>
                                    <div class="inputBoxTour col-md-10" id="eAddressDiv" style="margin-left: 10px;">
                                        <div class="inputBoxText" style="width: 120px;">
                                            <div class="importantFieldLabel">محل پیاده شدن</div>
                                        </div>
                                        <input id="eAddress" class="inputBoxInput" type="text" placeholder="آدرس دقیق محل بازگشت را وارد نمایید...">
                                    </div>
                                    <button type="button" class="transportationMapPinningTourCreation col-md-2" onclick="changeCenter('dest')">نشانه‌گذاری بر روی نقشه</button>
                                    <input type="hidden" name="eLat" id="eLat" value="0">
                                    <input type="hidden" name="eLng" id="eLng" value="0">
                                </div>

                                <div>
                                    <div class="inputBoxTour col-md-12">
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
                    <div class="inputBoxTour col-md-12 relative-position" id="mainClassificationOfTransportationInputDiv">
                        <div class="inputBoxText" id="mainClassificationOfTransportationLabel">
                            <div class="importantFieldLabel">دسته‌بندی اصلی</div>
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

                {{--            <div class="tourFoodOfferQuestions">--}}
                {{--                <span>آیا حمل و نقل فرعی تور شامل هزینه اضافه است؟</span>--}}
                {{--                <div class="btn-group btn-group-toggle" data-toggle="buttons">--}}
                {{--                    <label class="btn btn-secondary active">--}}
                {{--                        <input type="radio" name="isCostForMainTransport" value="0" onchange="showSection('mainTransportCostDiv', this)" checked>خیر--}}
                {{--                    </label>--}}
                {{--                    <label class="btn btn-secondary">--}}
                {{--                        <input type="radio" name="isCostForMainTransport" value="1" onchange="showSection('mainTransportCostDiv', this)">بلی--}}
                {{--                    </label>--}}
                {{--                </div>--}}
                {{--            </div>--}}

                {{--            <div id="mainTransportCostDiv" style="display: none;">--}}
                {{--                <div class="inputBoxTour float-right col-md-5">--}}
                {{--                    <div class="inputBoxText">--}}
                {{--                        <div>--}}
                {{--                            هزینه اضافی--}}
                {{--                            <span>*</span>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                    <input id="sideTransportCost" class="inputBoxInput" type="text" placeholder="ریال" onkeyup="$(this).val(numberWithCommas(this.value))">--}}
                {{--                </div>--}}
                {{--            </div>--}}
            </div>

            <div class="whiteBox">
                <div class="boxTitlesTourCreation">وعده‌ی غذایی</div>
                <div class="seperatorInWhiteSec">
                    <span>آیا در طول مدت تور وعده‌ی غذایی ارائه می‌شود؟</span>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-secondary">
                            <input type="radio" name="isMeal" value="1" onchange="showSection('mealsDiv', this)">بلی
                        </label>
                        <label class="btn btn-secondary active">
                            <input type="radio" name="isMeal" value="0" onchange="showSection('mealsDiv', this)" checked>خیر
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
                            <div class="halfWidthDiv tourFoodMealChoseTourCreation" style="display: flex">
                                <div class="col-md-3" style="margin-left: 20px;">
                                    <input name="meals[]" type="checkbox" id="c58" value="شام"/>
                                    <label for="c58">
                                        <span></span>
                                        شام
                                    </label>
                                </div>
                                <div class="col-md-3" style="margin-left: 20px;">
                                    <input name="meals[]" type="checkbox" id="c59" value="میان‌وعده"/>
                                    <label for="c59">
                                        <span></span>
                                        میان‌وعده
                                    </label>
                                </div>
                                <div class="col-md-3" style="margin-left: 20px;">
                                    <input name="meals[]" type="checkbox" id="c57" value="ناهار"/>
                                    <label for="c57" >
                                        <span></span>
                                        ناهار
                                    </label>
                                </div>
                                <div class="col-md-3" style="margin-left: 20px;">
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
                                        <div class="halfWidthDiv tourFoodMealChoseTourCreation" style="display: flex">
                                            <div class="col-md-3" style="margin-left: 20px;">
                                                <input id="meals3_day_{{$i}}" name="meals_day_{{$i}}" type="checkbox" value="شام"/>
                                                <label for="meals3_day_{{$i}}">
                                                    <span></span>
                                                    شام
                                                </label>
                                            </div>
                                            <div class="col-md-3" style="margin-left: 20px;">
                                                <input id="meals4_day_{{$i}}" name="meals_day_{{$i}}" type="checkbox" value="میان‌وعده"/>
                                                <label for="meals4_day_{{$i}}">
                                                    <span></span>
                                                    میان‌وعده
                                                </label>
                                            </div>
                                            <div class="col-md-3" style="margin-left: 20px;">
                                                <input id="meals2_day_{{$i}}" name="meals_day_{{$i}}" type="checkbox" value="ناهار"/>
                                                <label for="meals2_day_{{$i}}">
                                                    <span></span>
                                                    ناهار
                                                </label>
                                            </div>
                                            <div class="col-md-3" style="margin-left: 20px;">
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


                    {{--                <div class="seperatorInWhiteSec">--}}
                    {{--                    <span>آیا وعده‌های غذایی نیازمند هزینه‌ی اضافی است؟</span>--}}
                    {{--                    <div class="btn-group btn-group-toggle" data-toggle="buttons">--}}
                    {{--                        <label class="btn btn-secondary active">--}}
                    {{--                            <input type="radio" name="isMealCost" value="0" onchange="showSection('mealCostDiv', this)" checked>خیر--}}
                    {{--                        </label>--}}
                    {{--                        <label class="btn btn-secondary">--}}
                    {{--                            <input type="radio" name="isMealCost" value="1" onchange="showSection('mealCostDiv', this)">بلی--}}
                    {{--                        </label>--}}
                    {{--                    </div>--}}

                    {{--                    <div id="mealCostDiv" style="display: none;">--}}
                    {{--                        <div class="inputBoxTour float-right col-md-3">--}}
                    {{--                            <div class="inputBoxText">--}}
                    {{--                                <div>--}}
                    {{--                                    هزینه اضافی--}}
                    {{--                                    <span>*</span>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                            <input id="mealCost" class="inputBoxInput" type="text" placeholder="ریال" onkeyup="$(this).val(numberWithCommas(this.value))">--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    {{--                </div>--}}

                </div>
            </div>

            <div class="whiteBox">
                <div class="boxTitlesTourCreation">زبان تور</div>
                <div class="inboxHelpSubtitle">آیا تور شما به غیر از زبان فارسی، از زبان دیگری پشتیبانی می‌کند.</div>
                <div class="inputBoxTour col-md-12 relative-position">
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
                        <label class="btn btn-secondary active">
                            <input type="radio" name="isTourGuide" value="1" onchange="showSection('isTourGuidDiv', this)"  checked>بلی
                        </label>
                        <label class="btn btn-secondary">
                            <input type="radio" name="isTourGuide" value="0" onchange="showSection('isTourGuidDiv', this)" >خیر
                        </label>
                    </div>
                </div>
                <div id="isTourGuidDiv">
                    <div class="tourGuiderQuestions mg-tp-15">
                        <span>آیا راهنمای تور شما از افراد محلی منطقه می باشد؟</span>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary active">
                                <input type="radio" name="isLocalTourGuide" value="1" checked>بلی
                            </label>
                            <label class="btn btn-secondary">
                                <input type="radio" name="isLocalTourGuide" value="0">خیر
                            </label>
                        </div>
                    </div>
                    <div class="tourGuiderQuestions mg-tp-15">
                        <span>آیا راهنمای تور شما تجربه‌ی مخصوصی برای افراد فراهم می‌آورد؟</span>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary active">
                                <input type="radio" name="isSpecialTourGuid" value="1" checked>بلی
                            </label>
                            <label class="btn btn-secondary">
                                <input type="radio" name="isSpecialTourGuid" value="0">خیر
                            </label>
                        </div>
                    </div>
                    <div class="inboxHelpSubtitle mg-tp-5" style="width: 100%">برخی از راهنمایان تور صرفاً گروه را هدایت می‌کنند اما برخی همراه با گردشگران در همه جا حضور می‌یابند و تجربه‌ی اختصاصی‌تری ایجاد می‌کنند.</div>
                    <div class="tourGuiderQuestions mg-tp-15">
                        <span>آیا راهنمای تور شما هم اکنون مشخص است؟</span>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary active">
                                <input type="radio" name="isTourGuidDefined" value="1" onchange="showSection('isTourGuidDefinedDiv', this)" checked>بلی
                            </label>
                            <label class="btn btn-secondary">
                                <input type="radio" name="isTourGuidDefined" value="0" onchange="showSection('isTourGuidDefinedDiv', this)">خیر
                            </label>
                        </div>
                    </div>

                    <div id="isTourGuidDefinedDiv">
                        <div class="tourGuiderQuestions mg-tp-15">
                            <span>آیا راهنمای تور شما دارای حساب کاربری کوچیتا می‌باشد؟</span>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary ">
                                    <input type="radio" name="isTourGuidInKoochita" value="1" onchange="hasKoochitaAccount(this.value)">بلی
                                </label>
                                <label class="btn btn-secondary active">
                                    <input type="radio" name="isTourGuidInKoochita" value="0" onchange="hasKoochitaAccount(this.value)" checked>خیر
                                </label>
                            </div>
                        </div>

                        <div id="notKoochitaAccountDiv">
                            <div class="inboxHelpSubtitle mg-tp-5">
                                به راهنمای تور خدا توصیه کنید تا حساب خود را در کوچیتا ایجاد نماید و از مزایای آن بهره‌مند شود. برای ما راهنمایان تور دارای حساب کاربری از اهمیت بیشتری برخوردار هستند. پس از باز کردن حساب کاربری راهنمای تور شما می‌تواند با وارد کردن کد تور و پس از تأیید شما نام خود را به صفحه‌ی کاربریش اتصال دهد.
                            </div>
                            <div class="inputBoxTour float-right col-md-2 mg-rt-50">
                                <div class="inputBoxText width-45per">
                                    <div class="importantFieldLabel">جنسیت</div>
                                </div>
                                <div class="select-side">
                                    <i class="glyphicon glyphicon-triangle-bottom"></i>
                                </div>
                                <select id="tourGuidSex" class="inputBoxInput width-50per styled-select">
                                    <option value="1">مرد</option>
                                    <option value="0">زن</option>
                                </select>
                            </div>
                            <div class="inputBoxTour float-right col-md-5">
                                <div class="inputBoxText" style="width: 160px">
                                    <div class="importantFieldLabel">نام و نام خانوادگی</div>
                                </div>
                                <input id="tourGuidName" class="inputBoxInput" type="text" placeholder="فارسی">
                            </div>
                        </div>

                        <div id="haveKoochitaAccountDiv" style="display: none;">
                            <div class="inboxHelpSubtitle mg-tp-5" style="width: 100%;">درخواست شما برای کاربر مورد نظر ارسال می‌شود و پس از تأیید او نام او به عنوان راهنمای تور معرفی می‌گردد.</div>
                            <div class="inputBoxTour float-right col-md-3">
                                <div class="inputBoxText">
                                    <div class="importantFieldLabel">نام کاربری</div>
                                </div>
                                <input id="tourGuidKoochitaUsername" class="inputBoxInput" type="text" onclick="openSearchKoochitaAccount()" value="{{$tour->koochitaUserName ?? ''}}" readonly>
                                <input type="hidden" id="tourGuidUserId" value="{{$tour->tourGuidKoochitaId}}">
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
                        <label class="btn btn-secondary">
                            <input type="radio" name="isBackUpPhone" value="0" onchange="showSection('backUpPhoneDiv', this)">بلی
                        </label>
                        <label class="btn btn-secondary active">
                            <input type="radio" name="isBackUpPhone" value="1" onchange="showSection('backUpPhoneDiv', this)" checked>خیر
                        </label>
                    </div>
                </div>
                <div id="backUpPhoneDiv">
                    <div class="inputBoxTour float-right col-md-3">
                        <div class="inputBoxText">
                            <div class="importantFieldLabel">تلفن</div>
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
                <button class="btn nextStepBtnTourCreation goToPrevStep" type="button" onclick="goToPrevStep()">بازگشت به مرحله قبل</button>
            </div>
        </div>
    </div>
@endsection


@section('modals')
    @include('panelBusiness.component.userKoochitaSearchBP')

    <div class="modal fade" id="modalMap">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="mapDiv" style="width: 100%; height: 500px"></div>
                </div>
                <div class="modal-footer" style="text-align: center">
                    <button type="button" class="btn btn-success" data-dismiss="modal">تایید</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script defer type="text/javascript" src="{{URL::asset('packages/leaflet/leaflet-src.js')}}"></script>
    <script defer type="text/javascript" src="{{URL::asset('packages/leaflet/leaflet-wms-header.js')}}"></script>

    <script>
        var tour = {!! $tour!!};
        var transports = {!! $transport !!};
        var prevStageUrl = "{{route('businessManagement.tour.create.stage_2', ['business' => $businessIdForUrl ,'tourId' => $tour->id])}}";
        var nextStageUrl = "{{route('businessManagement.tour.create.stage_4', ['business' => $businessIdForUrl ,'tourId' => $tour->id])}}";
        var storeStageThreeURL = "{{route('businessManagement.tour.store.stage_3')}}";


        var sideMenuAdditional = {
            title: 'ویرایش تور',
            sub: [
                {
                    title: 'اطلاعات اولیه',
                    icon: '<i class="fa-duotone fa-info"></i>',
                    url: "{{route('businessManagement.tour.create.stage_1', ['business' => $businessIdForUrl ,'tourId' => $tour->id])}}",
                },
                {
                    title: 'برنامه سفر',
                    icon: '<i class="fa-duotone fa-calendar-pen"></i>',
                    url: "{{route('businessManagement.tour.create.stage_2', ['business' => $businessIdForUrl ,'tourId' => $tour->id])}}",
                },
                {
                    title: 'اطلاعات برگزاری',
                    icon: '<i class="fa-duotone fa-plane-tail"></i>',
                    url: "{{route('businessManagement.tour.create.stage_3', ['business' => $businessIdForUrl ,'tourId' => $tour->id])}}",
                    selected: 1
                },
                {
                    title: 'اطلاعات مالی',
                    icon: '<i class="fa-duotone fa-sack-dollar"></i>',
                    url: "{{route('businessManagement.tour.create.stage_4', ['business' => $businessIdForUrl ,'tourId' => $tour->id])}}",
                },
                {
                    title: 'اطلاعات اضافی',
                    icon: '<i class="fa-duotone fa-clipboard-list-check"></i>',
                    url: "{{route('businessManagement.tour.create.stage_5', ['business' => $businessIdForUrl ,'tourId' => $tour->id])}}",
                },
            ]
        };
        createNewMenuSideBar(sideMenuAdditional);
    </script>

    <script src="{{URL::asset('BusinessPanelPublic/js/tour/create/tourCreate_stage_3.js?v='.$fileVersions)}}"></script>
@endsection
