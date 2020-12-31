<?php
$kindPlaceId = 1;
$placeMode = 'state';
$state = 'تهران';
?>
        <!DOCTYPE html>
<html>
<head>
    @include('layouts.topHeader')
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/home_rebranded.css?v=4')}}"/>
    <title>ایجاد تور</title>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/long_lived_global_legacy_2.css?v=2')}}"/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/masthead-saves.css?v=2')}}'/>
    <link rel='stylesheet' type='text/css' media='screen, print' href='{{URL::asset('css/theme2/hr_north_star.css?v=2')}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/icons.css?v=1')}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/passStyle.css?v=1')}}'/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/shazdeDesigns/tourCreation.css?v=1')}}"/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/shazdeDesigns/abbreviations.css?v=1')}}"/>

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

        .placeCard{
            width: 100%;
            display: flex;
            margin-top: 10px;
            border-bottom: solid 1px lightgray;
            padding-bottom: 10px;
            position: relative;
        }
        .placeCard .picSec{
            width: 100px;
            height: 100px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 3px;
            border-radius: 50%;
            border: solid 1px black;
        }
        .placeCard .picSec > div{
            width: 100%;
            height: 100%;
            overflow: hidden;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .placeCard .infoSec{
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin-right: 10px;
            font-size: 12px;
        }
        .placeCard .infoSec .name{
            font-size: 1.3em;
            font-weight: bold;
        }
        .placeCard .infoSec .loc{
            margin-bottom: 10px;
        }
        .placeCard .infoSec .address{

        }
        .placeCard .dataSec{

        }
        .placeCard .iconClose{
            position: absolute;
            left: 0px;
            top: 35%;
            font-size: 25px;
            cursor: pointer;
            color: red;
        }
    </style>

</head>

<body>

    <div>
        @include('general.forAllPages')
        @include('layouts.placeHeader')

        @include('pages.tour.create.tourCreateHeader', ['createTourStep' => 2, 'createTourHeader' => 'اطلاعات اختصاصی'])


        <div id="tourDetailsMainForm2ndtStepMainDiv" class="Hotel_Review prodp13n_jfy_overflow_visible lightGreyBox">
            <form id="form" method="post" action="{{route('tour.create.stage.two.store')}}">
                {!! csrf_field() !!}
                <input type="hidden" name="tourId" value="{{$tour->id}}">
                <input type="hidden" name="sideTransport" id="sideTransport">
                <input type="hidden" name="restaurantList" id="restaurantList">
                <input type="hidden" name="amakenList" id="amakenList">
                <input type="hidden" name="cityList" id="cityList">

                <div class="ui_container">
                    <div class="menu ui_container whiteBox whiteBoxSpecificInfo">
                        <div>
                            <span id="mainTransportationTitleTourCreation">حمل و نقل اصلی</span></div>
                        <div>
                            <span id="mainTransportationHelpTourCreation">حمل و نقل اصلی مرتبط با انتقال مسافران از مبدأ به مقصد و بالعکس می‌باشد</span>
                        </div>
                        <div id="tourTransportationResponsibility">
                            <span>آیا حمل و نقل اصلی برعهده‌ی تور است؟</span>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary">
                                    <input type="radio" name="isTransportTour" id="isTransportTour" value="0" onchange="transportTour(this.value)">
                                    خیر
                                </label>
                                <label class="btn btn-secondary active">
                                    <input type="radio" name="isTransportTour" id="isTransportTour" value="1" onchange="transportTour(this.value)" checked>
                                    بلی
                                </label>

                            </div>
                        </div>

                        @if($tour->local)
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
                                    <select class="inputBoxInput styled-select" name="sTransport" id="sTransport">
                                        <option value="0">انتخاب کنید</option>
                                        @foreach($transport as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="inputBoxTour col-xs-5" id="sAddressDiv">
                                    <div class="inputBoxText">
                                        <div>
                                            محل شروع
                                            <span>*</span>
                                        </div>
                                    </div>
                                    <input class="inputBoxInput" type="text" name="sAddress" id="sAddress" placeholder="فارسی">
                                </div>
                                <button type="button" class="transportationMapPinningTourCreation col-xs-2" id="sPosition" data-toggle="modal" data-target="#modalMap" onclick="changeCenter('src')">نشانه‌گذاری بر روی نقشه</button>
                                <input type="hidden" name="sLat" id="sLat" value="0">
                                <input type="hidden" name="sLng" id="sLng" value="0">

                                <div class="inputBoxTour col-xs-4 transportationStartTimeTourCreation" id="sTimeDiv">
                                    <div class="inputBoxText">
                                        <div>
                                            ساعت حرکت
                                            <span>*</span>
                                        </div>
                                    </div>

                                    <input type="text" class="inputBoxInput" id="sTime" name="sTime" required readonly>
                                </div>
                                <div class="inputBoxTour col-xs-7" >
                                    <div class="inputBoxText">
                                        <div>
                                            توضیحات تکمیلی
                                        </div>
                                    </div>
                                    <input class="inputBoxInput" name="sDescription" type="text" placeholder="حداکثر 100 کاراکتر" maxlength="100">
                                </div>
                                <div style="width: 100%;">
                                    <span class="inboxHelpSubtitle">تاریخ رفت تاریخ شروع تور در نظر گرفته شود.</span>
                                </div>


                                <div class="inputBoxTour col-xs-5" id="eAddressDiv">
                                    <div class="inputBoxText">
                                        <div>
                                            محل اتمام
                                            <span>*</span>
                                        </div>
                                    </div>
                                    <input class="inputBoxInput" type="text" name="eAddress" id="eAddress" placeholder="فارسی">
                                </div>
                                <div class="inputBoxTour col-xs-4 transportationStartTimeTourCreation" id="eTimeDiv">
                                    <div class="inputBoxText">
                                        <div>
                                            ساعت اتمام
                                            <span>*</span>
                                        </div>
                                    </div>
                                    <input type="text" class="inputBoxInput"  id="eTime" name="eTime" required readonly>
                                </div>
                                <button type="button" class="transportationMapPinningTourCreation col-xs-2" id="ePosition" data-toggle="modal" data-target="#modalMap" onclick="changeCenter('dest')">نشانه‌گذاری بر روی نقشه</button>
                                <input type="hidden" name="eLat" id="eLat" value="0">
                                <input type="hidden" name="eLng" id="eLng" value="0">

                                <div class="inputBoxTour col-xs-7" >
                                    <div class="inputBoxText">
                                        <div>
                                            توضیحات تکمیلی
                                        </div>
                                    </div>
                                    <input class="inputBoxInput" name="eDescription" type="text" placeholder="حداکثر 100 کاراکتر" maxlength="100">
                                </div>
                            </div>
                        @else
                            <div id="sDiv" class="transportationDetailsMainBoxes">
                                <div class="transportationTitleBoxes" id="toTheDestinationTitleBox"> رفت </div>
                                <div class="transportInfoSec">
                                    <div>
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
                                            <select class="inputBoxInput styled-select" name="sTransport" id="sTransport">
                                                <option value="0">
                                                    انتخاب کنید
                                                </option>
                                                @foreach($transport as $item)
                                                    <option value="{{$item->id}}">
                                                        {{$item->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="inputBoxTour transportationStartTimeTourCreation" id="sTimeDiv">
                                            <div class="inputBoxText">
                                                <div>
                                                    ساعت حرکت
                                                    <span>*</span>
                                                </div>
                                            </div>

                                            <input type="text" id="sTime" name="sTime" class="inputBoxInput center" placeholder="00:00" readonly>
                                        </div>
                                        <div>
                                            <span class="inboxHelpSubtitle">تاریخ رفت تاریخ شروع تور در نظر گرفته شود.</span>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="inputBoxTour col-xs-10" id="sAddressDiv">
                                            <div class="inputBoxText">
                                                <div>
                                                    محل حرکت
                                                    <span>*</span>
                                                </div>
                                            </div>
                                            <input class="inputBoxInput" type="text" name="sAddress" id="sAddress" placeholder="آدرس دقیق محل حرکت را وارد نمایید...">
                                        </div>
                                        <button type="button" class="transportationMapPinningTourCreation col-xs-2" id="sPosition" data-toggle="modal" data-target="#modalMap" onclick="changeCenter('src')">نشانه‌گذاری بر روی نقشه</button>
                                        <input type="hidden" name="sLat" id="sLat" value="0">
                                        <input type="hidden" name="sLng" id="sLng" value="0">
                                    </div>

                                    <div>
                                        <div class="inputBoxTour col-xs-12">
                                            <div class="inputBoxText">
                                                <div>
                                                    توضیحات تکمیلی
                                                </div>
                                            </div>
                                            <textarea class="inputBoxInput" name="sDescription" type="text" placeholder="حداکثر 100 کاراکتر" maxlength="100"></textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div id="eDiv" class="transportationDetailsMainBoxes" style="border-top: solid 1px lightgray;">
                                <div class="transportationTitleBoxes" id="fromTheDestinationTitleBox">
                                    برگشت
                                </div>
                                <div class="row transportInfoSec">
                                    <div>
                                        <div class="inputBoxTour col-xs-4 transportationKindTourCreation" id="eTransportDiv">
                                            <div class="inputBoxText">
                                                <div>
                                                    نوع وسیله
                                                    <span>*</span>
                                                </div>
                                            </div>
                                            <div class="select-side">
                                                <i class="glyphicon glyphicon-triangle-bottom"></i>
                                            </div>
                                            <select class="inputBoxInput styled-select" name="eTransport" id="eTransport">
                                                <option value="0">
                                                    انتخاب کنید
                                                </option>
                                                @foreach($transport as $item)
                                                    <option value="{{$item->id}}">
                                                        {{$item->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="inputBoxTour transportationStartTimeTourCreation" id="eTimeDiv">
                                            <div class="inputBoxText">
                                                <div>
                                                    ساعت حرکت
                                                    <span>*</span>
                                                </div>
                                            </div>
                                            <input type="text" id="eTime" name="eTime" class="inputBoxInput center" placeholder="00:00" required readonly>
                                        </div>
                                        <div>
                                            <span class="inboxHelpSubtitle">تاریخ برگشت تاریخ پایان تور در نظر گرفته شود.</span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="inputBoxTour col-xs-10" id="eAddressDiv">
                                            <div class="inputBoxText">
                                                <div>
                                                    محل حرکت
                                                    <span>*</span>
                                                </div>
                                            </div>
                                            <input class="inputBoxInput" name="eAddress" id="eAddress" type="text" placeholder="آدرس دقیق محل بازگشت را وارد نمایید...">
                                        </div>
                                        <button type="button" class="transportationMapPinningTourCreation col-xs-2"  id="ePosition" data-toggle="modal" data-target="#modalMap" onclick="changeCenter('dest')">نشانه‌گذاری بر روی نقشه</button>
                                        <input type="hidden" name="eLat" id="eLat" value="0">
                                        <input type="hidden" name="eLng" id="eLng" value="0">
                                    </div>

                                    <div>
                                        <div class="inputBoxTour col-xs-12">
                                            <div class="inputBoxText">
                                                <div>توضیحات تکمیلی</div>
                                            </div>
                                            <textarea class="inputBoxInput" type="text" name="eDescription" placeholder="حداکثر 100 کاراکتر"  maxlength="100"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="ui_container">
                    <div class="menu ui_container whiteBox whiteBoxSpecificInfo">
                        <div class="boxTitlesTourCreation">
                            حمل و نقل فرعی
                        </div>
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

                                <div id="multiSelected" class="transportationKindChosenMainDiv" onclick="openMultiSelect()"></div>

                                <div id="multiselect" class="multiselect">
                                    @foreach($transport as $item)
                                        <div class="optionMultiSelect" id="multiSelectTransport_{{$item->id}}" onclick="chooseMultiSelect({{$item->id}})">
                                            {{$item->name}}
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                       <div class="inboxHelpSubtitle">
                            در صورت وجود بیشتر از یک وسیله همه‌ی آن‌ها را انتخاب نمایید.
                        </div>
                    </div>
                </div>

                <div class="ui_container">
                    <div class="menu ui_container whiteBox whiteBoxSpecificInfo">
                        <div class="boxTitlesTourCreation">
                            <span>وعده‌ی غذایی</span>
                        </div>
                        <div class="tourFoodOfferQuestions">
                            <span>آیا در طول مدت تور وعده‌ی غذایی ارائه می‌شود؟</span>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary">
                                    <input type="radio" name="isMeal" id="option1" value="0" onchange="isMealsChange(this.value)">خیر
                                </label>
                                <label class="btn btn-secondary active">
                                    <input type="radio" name="isMeal" id="option2" value="1" onchange="isMealsChange(this.value)" checked>بلی
                                </label>
                            </div>
                        </div>

                        <div id="mealsDiv">

                            <div class="fullwidthDiv">
                                <div id="tourFoodMealTitleTourCreation" class="halfWidthDiv">
                                    نوع وعده را انتخاب نمایید؟
                                </div>
                                <div id="tourFoodMealChoseTourCreation" class="halfWidthDiv">
                                    <div class="col-xs-3">
                                        <input ng-model="sort" name="meals[]" type="checkbox" id="c56" value="صبحانه"/>
                                        <label for="c56">
                                            <span></span>
                                        </label>
                                        <span class="tourTypeChoseTourCreation">
                                        صبحانه
                                    </span>
                                    </div>
                                    <div class="col-xs-3">
                                        <input ng-model="sort" name="meals[]" type="checkbox" id="c57" value="ناهار"/>
                                        <label for="c57">
                                            <span></span>
                                        </label>
                                        <span class="tourTypeChoseTourCreation">
                                        ناهار
                                    </span>
                                    </div>
                                    <div class="col-xs-3">
                                        <input ng-model="sort" name="meals[]" type="checkbox" id="c58" value="شام"/>
                                        <label for="c58">
                                            <span></span>
                                        </label>
                                        <span class="tourTypeChoseTourCreation">
                                        شام
                                    </span>
                                    </div>
                                    <div class="col-xs-3">
                                        <input ng-model="sort" name="meals[]" type="checkbox" id="c59" value="میان‌وعده"/>
                                        <label for="c59">
                                            <span></span>
                                        </label>
                                        <span class="tourTypeChoseTourCreation">
                                        میان‌وعده
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="tourFoodOfferQuestions">
                                <span>آیا وعده‌های غذایی تمام روزهای تور ارائه می‌شود و یا فقط در چند روز خاص قابل ارائه می‌باشد؟</span>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-secondary active">
                                        <input type="radio" name="isMealsAllDay" id="option1" value="0" checked>خیر
                                    </label>
                                    <label class="btn btn-secondary">
                                        <input type="radio" name="isMealsAllDay" id="option2" value="1" >بلی
                                    </label>
                                </div>
                            </div>

                            <div class="tourFoodOfferQuestions">
                                <span>آیا وعده‌های غذایی نیازمند هزینه‌ی اضافی است؟</span>
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-secondary active">
                                        <input type="radio" name="isMealCost" value="0" checked>خیر
                                    </label>
                                    <label class="btn btn-secondary">
                                        <input type="radio" name="isMealCost" value="1">بلی
                                    </label>
                                </div>
                            </div>
                            <div class="mg-tp-15">
                                اگر محل ارائه‌ی وعده‌ها مشخص است حتماً آن را وارد نمایید.
                            </div>
                            <div class="inboxHelpSubtitle">
                                ما مجموعه‌ی وسیعی از مزاکز ارائه‌ی غذا را در ردیتابیس خود داریم. با انتخاب گزینه‌ی به علاوه می‌توانید با جستجو در داخل آن‌ها مکان مورد نظر خود را انتخاب و به کاربران اطلاع دهید. تکمیل نمودن اطلاعات تأثیر به سزایی در توجه بیشتر کاربران دارد.
                            </div>
                            <div>
                                <div class="row" id="restaurantChooseMain" style="display: flex; flex-wrap: wrap"></div>

                                <div class="addTourPlacesBtnDivTourCreation col-xs-4"  onclick="cleanRestaurantSearch()">
                                    <div class="addTourPlacesBtnCreation circleBase type2">
                                        <img src="{{URL::asset("images/tourCreation/add.png")}}">
                                        <div>اضافه کنید</div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="ui_container">
                    <div class="menu ui_container whiteBox whiteBoxSpecificInfo">
                        <div class="boxTitlesTourCreation">
                            <span>شهرهایی که می‌بینیم</span>
                        </div>
                        <div class="inboxHelpSubtitle">
                            شهرهایی که در طول تور در آن‌ها برنامه‌ای برای کاربران دارید انتخاب نمایید. توجه نمایید حداقل در این شهر می‌بایست یک برنامه مانند رویداد و یا بازدید داشته باشید. شهر مبدأ و مقصد را وارد نمایید.
                        </div>
                        <div>
                            <div class="row"  id="cityChooseMain" style="display: flex; flex-wrap: wrap"></div>

                            <div class="addTourPlacesBtnDivTourCreation col-xs-4" onclick="cleanCitySearch()">
                                <div class="addTourPlacesBtnCreation circleBase type2">
                                    <img src="{{URL::asset("images/tourCreation/add.png")}}">
                                    <div>اضافه کنید</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="ui_container">
                    <div class="menu ui_container whiteBox whiteBoxSpecificInfo">
                        <div class="boxTitlesTourCreation">
                            <span>جاذبه‌هایی که می‌بینیم</span>
                        </div>
                        <div class="inboxHelpSubtitle">
                            جاذبه‌هایی که در طول تور می‌بینیم را وارد نمایید تا کاربران با تور شما بیشتر آشنا شوند. برای بسیاری از کاربران جاذبه‌های مورد بازدید بسیار مهم است.
                        </div>
                        <div>
                            <div class="row" id="amakenChooseMain" style="display: flex; flex-wrap: wrap"></div>

                            <div class="addTourPlacesBtnDivTourCreation col-xs-4" onclick="cleanAmakenSearch()">
                                <div class="addTourPlacesBtnCreation circleBase type2">
                                    <img src="{{URL::asset("images/tourCreation/add.png")}}">
                                    <div>اضافه کنید</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ui_container">
                    <button type="button" id="goToForthStep" class="btn nextStepBtnTourCreation"  onclick="checkInputs()">گام بعدی</button>
                </div>


                <div class="modal fade" id="addRestaurantModal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <div class="modal-body" style="direction: rtl">
                                <div class="fullwidthDiv">
                                    <div class="addPlaceGeneralInfoTitleTourCreation">
                                        رستوران مورد نظر خود را اضافه کنید
                                    </div>
                                    <button type="button" class="closee" data-dismiss="modal" style="border: none; background: none; float: left">&times;</button>
                                </div>

                                <div class="container-fluid">
                                    <div class="row" style="display: flex; flex-wrap: wrap">
                                        <div class="inputBoxTour col-xs-6 relative-position" id="placeNameAddingPlaceInputDiv">
                                            <div class="inputBoxText">
                                                <div>
                                                    نام رستوران
                                                    <span>*</span>
                                                </div>
                                            </div>
                                            <input id="inputSearchRestaurant" type="text" class="inputBoxInput text-align-right" placeholder="نام رستوران را وارد نمایید..." onkeyup="searchInRestaurant(this)">
                                            <div class="searchResult"></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="restaurantChoose"></div>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer" style="text-align: center">
                                <button id="goToForthStep" class="btn nextStepBtnTourCreation" data-dismiss="modal">تأیید</button>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal fade" id="addCityModal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-body" style="direction: rtl">
                                <div class="fullwidthDiv">
                                    <div class="addPlaceGeneralInfoTitleTourCreation">
                                        شهر مورد نظر خود را اضافه کنید
                                    </div>
                                    <button type="button" class="closee" data-dismiss="modal" style="border: none; background: none; float: left">&times;</button>
                                </div>

                                <div class="container-fluid">
                                    <div class="row" style="display: flex; justify-content: space-between">
                                        <div class="inputBoxTour col-xs-5 relative-position" id="mainClassificationOfPlaceInputDiv" style="float: right">
                                            <div class="inputBoxText">
                                                <div>
                                                    استان
                                                    <span>*</span>
                                                </div>
                                            </div>
                                            <div class="select-side">
                                                <i class="glyphicon glyphicon-triangle-bottom"></i>
                                            </div>
                                            <select id="selectStateForSelectCity" class="inputBoxInput styled-select text-align-right" type="text">
                                                <option id="cityChooseOption">انتخاب کنید</option>
                                                @foreach($ostan as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                </div>

                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="inputBoxTour col-xs-12 relative-position" id="placeNameAddingPlaceInputDiv">
                                            <div class="inputBoxText">
                                                <div>
                                                    نام شهر
                                                    <span>*</span>
                                                </div>
                                            </div>
                                            <input id="inputSearchCity" class="inputBoxInput text-align-right" type="text" placeholder="انتخاب کنید" onkeyup="searchForCity(this)">
                                            <div class="searchResult"></div>
                                        </div>
                                    </div>
                                </div>
                                {{--<div class="inboxHelpSubtitle">--}}
                                    {{--اگر نام مورد نظر در داخل لیست موجود نبود، لطفاً آن را اضافه نمایید--}}
                                {{--</div>--}}

                                <div id="cityChoose"></div>

                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer" style="text-align: center">
                                <button id="goToForthStep" class="btn nextStepBtnTourCreation" data-dismiss="modal">تأیید</button>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal fade" id="addAmakenModal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <div class="modal-body" style="direction: rtl">
                                <div class="fullwidthDiv">
                                    <div class="addPlaceGeneralInfoTitleTourCreation">
                                        اماکن مورد نظر خود را اضافه کنید
                                    </div>
                                    <button type="button" class="closee" data-dismiss="modal" style="border: none; background: none; float: left">&times;</button>
                                </div>

                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="inputBoxTour col-xs-12 relative-position" id="placeNameAddingPlaceInputDiv">
                                            <div class="inputBoxText">
                                                <div>نام اماکن</div>
                                            </div>
                                            <input id="inputSearchAmaken" class="inputBoxInput text-align-right" type="text" onkeyup="searchInAmaken(this)">
                                            <div class="searchResult"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer" style="text-align: center">
                                <button id="goToForthStep" class="btn nextStepBtnTourCreation" data-dismiss="modal">تأیید</button>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalMap">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <div id="map" style="width: 100%; height: 500px"></div>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer" style="text-align: center">
                                <button type="button" class="btn btn-success" data-dismiss="modal">تایید</button>
                            </div>

                        </div>
                    </div>
                </div>
                <script>
                    var map;
                    var tour = {!! $tour!!};
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
                        if(kind == 'src') {
                            mapType = 'src';
                            map.panTo({lat: srcLatLng[0], lng: srcLatLng[1]});
                        }
                        else {
                            mapType = 'dest';
                            map.panTo({lat: destLatLng[0], lng: destLatLng[1]});
                        }

                    }
                </script>
                <script src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyCdVEd4L2687AfirfAnUY1yXkx-7IsCER0&callback=init"></script>

            </form>
        </div>

        <div class="errorDiv" id="errorDiv"></div>

        <div id="placeSampleCard" style="display: none">
            <div data-id="##placeId##" data-type="##type##" class="placeCard">
                <div class="picSec">
                    <div>
                        <img class="resizeImgClass" ##picimg## onload="fitThisImg(this)">
                    </div>
                </div>
                <div class="infoSec">
                    <div class="name">##name##</div>
                    <div class="loc">##stateAndCity##</div>
                    <div class="address">##address##</div>
                </div>
                <div class="dataSec"></div>

                <div class="iconClose" onclick="deleteThisPlace(this)"></div>
            </div>
        </div>


        @include('layouts.footer.layoutFooter')
    </div>

    <script src={{URL::asset('js/tour/create/stageTwo.js')}}></script>

    <script>
        var isTransport = 1;
        var multiIsOpen = false;
        var transports = {!! $transport !!};
        var chooseSideTransport = [];
        var _token = '{{csrf_token()}}';
        var homeRoute = '{{route("home")}}';
        var closePic  = '{{URL::asset("images/tourCreation/close.png")}}';
        var allState = {!! $ostan !!};
        var searchInAjax;
        var restaurant;
        var cities;
        var amakens;
        var chooseRestaurant = [];
        var chooseRestaurantIds = [];
        var chooseAmaken = [];
        var chooseAmakenIds = [];
        var chooseCity = [];
        var chooseCityIds = [];
        var placeSampleCard = $('#placeSampleCard').html();
        $('#placeSampleCard').remove();

        $(window).ready(() => {
            var clockOptions = {
                placement: 'left',
                donetext: 'تایید',
                autoclose: true,
            };

            var sTime = $('#sTime').clockpicker(clockOptions);
            var eTime = $('#eTime').clockpicker(clockOptions);
        });

        function searchInRestaurant(_element){
            var value = $(_element).val();
            if(searchInAjax != null)
                searchInAjax.abort();

            if(value.trim().length > 1){
                searchInAjax = $.ajax({
                    type: 'GET',
                    url: '{{route("search.place.with.name.kindPlaceId")}}?value='+value+'&kindPlaceId=3',
                    success: response => {
                        if(response.status == 'ok') {
                            var text = '';
                            restaurant = response.result;
                            restaurant.map((item, key) => text += `<div class="searchHover blue" data-index="${key}" onclick="chooseThisRestaurant(this)" >${item.name} در ${item.state.name} , ${item.city.name}</div>`);
                            $(_element).next().html(text);
                        }
                    }
                });
            }
        }
        function chooseThisRestaurant(_element){
            var index = $(_element).attr('data-index');
            $(_element).parent().empty();
            $('#inputSearchRestaurant').val('');
            if(chooseRestaurantIds.indexOf(restaurant[index].id) == -1) {
                chooseRestaurant.push(restaurant[index]);
                chooseRestaurantIds.push(restaurant[index].id);
            }
            createPlaceSelected('restaurant');
        }

        function searchInAmaken(_element){
            var value = $(_element).val();
            if(searchInAjax != null)
                searchInAjax.abort();

            if(value.trim().length > 1){
                searchInAjax = $.ajax({
                    type: 'GET',
                    url: '{{route("search.place.with.name.kindPlaceId")}}?value='+value+'&kindPlaceId=1',
                    success: response => {
                        if(response.status == 'ok') {
                            var text = '';
                            amakens = response.result;
                            amakens.map((item, key) => text += `<div class="searchHover blue" data-index="${key}" onclick="chooseThisAmaken(this)" >${item.name} در ${item.state.name} , ${item.city.name}</div>`);
                            $(_element).next().html(text);
                        }
                    }
                });
            }
        }
        function chooseThisAmaken(_element){
            var index = $(_element).attr('data-index');
            $(_element).parent().empty();
            $('#inputSearchAmaken').val('');
            if(chooseAmakenIds.indexOf(amakens[index].id) == -1) {
                chooseAmaken.push(amakens[index]);
                chooseAmakenIds.push(amakens[index].id);
            }
            createPlaceSelected('amaken');
        }

        function searchForCity(_element){
            var value = $(_element).val();
            if(searchInAjax != null)
                searchInAjax.abort();

            var stateId = $('#selectStateForSelectCity').val();
            if(stateId == 0){
                alert('ابتدا استان را مشخص نمایید');
                return;
            }

            if(value.trim().length > 1){
                searchInAjax = $.ajax({
                    type: 'GET',
                    url: '{{route("findCityWithState")}}?value='+value+'&stateId='+stateId,
                    success: response => {
                        if(response.status == 'ok') {
                            var text = '';
                            cities = response.result;
                            cities.map((item, key) => text += `<div class="searchHover blue" data-index="${key}" onclick="chooseThisCity(this)" >${item.name} در ${item.state.name}</div>`);
                            $(_element).next().html(text);
                        }
                    }
                });
            }
        }
        function chooseThisCity(_element){
            var index = $(_element).attr('data-index');
            $(_element).parent().empty();
            $('#inputSearchCity').val('');
            if(chooseCityIds.indexOf(cities[index].id) == -1) {
                chooseCity.push(cities[index]);
                chooseCityIds.push(cities[index].id);
            }
            createPlaceSelected('cities');
        }

        function createPlaceSelected(_kind){
            if(_kind == 'restaurant'){
                $('#restaurantChooseMain').empty();
                chooseRestaurant.forEach(item => {
                    var text = placeSampleCard;
                    var fk = Object.keys(item);
                    for (var x of fk)
                        text = text.replace(new RegExp(`##${x}##`, "g"), item[x]);

                    text = text.replace(new RegExp("##picimg##", "g"), `src="${item.pic}"`);
                    text = text.replace(new RegExp("##stateAndCity##", "g"), `استان ${item.state.name} شهر ${item.city.name}`);
                    text = text.replace(new RegExp("##placeId##", "g"), item.id);
                    text = text.replace(new RegExp("##type##", "g"), "restaurant");

                    $('#restaurantChooseMain').append(text);
                });
            }
            else if(_kind == 'amaken'){
                $('#amakenChooseMain').empty();
                chooseAmaken.forEach(item => {
                    var text = placeSampleCard;
                    var fk = Object.keys(item);
                    for (var x of fk)
                        text = text.replace(new RegExp(`##${x}##`, "g"), item[x]);

                    text = text.replace(new RegExp("##picimg##", "g"), `src="${item.pic}"`);
                    text = text.replace(new RegExp("##stateAndCity##", "g"), `استان ${item.state.name} شهر ${item.city.name}`);
                    text = text.replace(new RegExp("##placeId##", "g"), item.id);
                    text = text.replace(new RegExp("##type##", "g"), "restaurant");

                    $('#amakenChooseMain').append(text);
                });
            }
            else if(_kind == 'cities'){
                $('#cityChooseMain').empty();
                chooseCity.forEach(item => {
                    var text = placeSampleCard;
                    var fk = Object.keys(item);
                    for (var x of fk)
                        text = text.replace(new RegExp(`##${x}##`, "g"), item[x]);

                    text = text.replace(new RegExp("##picimg##", "g"), `src="${item.pic}"`);
                    text = text.replace(new RegExp("##stateAndCity##", "g"), `استان ${item.state.name}`);
                    text = text.replace(new RegExp("##placeId##", "g"), item.id);
                    text = text.replace(new RegExp("##type##", "g"), "cities");
                    text = text.replace(new RegExp("##address##", "g"), '');

                    $('#cityChooseMain').append(text);
                });
            }
        }

        function deleteThisPlace(_element){
            var index;
            var id = $(_element).parent().attr('data-id');
            var type = $(_element).parent().attr('data-type');
            $(_element).parent().remove();

            if(type == 'restaurant') {
                index = chooseRestaurantIds.indexOf(parseInt(id));
                if (index != -1) {
                    chooseRestaurantIds.splice(index, 1);
                    chooseRestaurant.splice(index, 1);
                }
            }
            else if(type == 'cities'){
                index = chooseCity.indexOf(parseInt(id));
                if (index != -1) {
                    chooseCityIds.splice(index, 1);
                    chooseCity.splice(index, 1);
                }
            }
        }

        function cleanRestaurantSearch(){
            $('#addRestaurantModal').modal('show');
            $('#inputSearchRestaurant').val('').next().empty();
        }

        function cleanCitySearch(){
            $('#addCityModal').modal('show');
            $('#inputSearchCity').val('').next().empty();
        }

        function cleanAmakenSearch(){
            $('#addAmakenModal').modal('show');
            $('#inputSearchAmaken').val('').next().empty();
        }

        function checkInputs(){

            var error = false;
            var error_text = '';

            if(isTransport){
                var sTransport = document.getElementById('sTransport').value;
                var eTransport = document.getElementById('eTransport').value;
                var sTime = document.getElementById('sTime').value;
                var eTime = document.getElementById('eTime').value;
                var sAddress = document.getElementById('sAddress').value;
                var eAddress = document.getElementById('eAddress').value;
                var sLat = document.getElementById('sLat').value;
                var eLat = document.getElementById('eLat').value;
                var sLng = document.getElementById('sLng').value;
                var eLng = document.getElementById('eLng').value;

                if(sTransport == 0 ){
                    error = true;
                    error_text += '<li>لطفا وسیله نقلیه ی رفت را مشخص کنید.</li>';
                    document.getElementById('sTransportDiv').classList.add('errorClass');
                }
                else
                    document.getElementById('sTransportDiv').classList.remove('errorClass');

                if(eTransport != -1) {
                    if (eTransport == 0) {
                        error = true;
                        error_text += '<li>لطفا وسیله نقلیه ی برگشت را مشخص کنید.</li>';
                        document.getElementById('eTransportDiv').classList.add('errorClass');
                    }
                    else
                        document.getElementById('eTransportDiv').classList.remove('errorClass');
                }

                if(sTime == null || sTime == ''){
                    error = true;
                    error_text += '<li>لطفا ساعت حرکت رفت را مشخص کنید.</li>';
                    document.getElementById('sTimeDiv').classList.add('errorClass');
                }
                else
                    document.getElementById('sTimeDiv').classList.remove('errorClass');

                if(eTime == null || eTime == ''){
                    error = true;
                    error_text += '<li>لطفا ساعت حرکت برگشت را مشخص کنید.</li>';
                    document.getElementById('eTimeDiv').classList.add('errorClass');
                }
                else
                    document.getElementById('eTimeDiv').classList.remove('errorClass');

                if(sAddress == null || sAddress == ''){
                    error = true;
                    error_text += '<li>لطفا محل حرکت رفت را مشخص کنید.</li>';
                    document.getElementById('sAddressDiv').classList.add('errorClass');
                }
                else
                    document.getElementById('sAddressDiv').classList.remove('errorClass');

                if(eAddress == null || eAddress == ''){
                    error = true;
                    error_text += '<li>لطفا محل حرکت برگشت را مشخص کنید.</li>';
                    document.getElementById('eAddressDiv').classList.add('errorClass');
                }
                else
                    document.getElementById('eAddressDiv').classList.remove('errorClass');

                if(sLat == 0 || sLng == 0){
                    error = true;
                    error_text += '<li>لطفا محل حرکت را روی نقشه مشخص کنید.</li>';
                    document.getElementById('sPosition').classList.add('errorClass');
                }
                else
                    document.getElementById('sPosition').classList.remove('errorClass');

                if(eLng == 0 || eLat == 0){
                    error = true;
                    error_text += '<li>لطفا محل برگشت را روی نقشه مشخص کنید.</li>';
                    document.getElementById('ePosition').classList.add('errorClass');
                }
                else
                    document.getElementById('ePosition').classList.remove('errorClass');

            }

            if(chooseSideTransport.length == 0){
                error = true;
                error_text += '<li>لطفا وسیله نقلیه ی فرعی را مشخص کنید.</li>';
                document.getElementById('mainClassificationOfTransportationInputDiv').classList.add('errorClass');
            }
            else{
                e = 0;
                for(i = 0; i < chooseSideTransport.length; i++){
                    if(chooseSideTransport[i] != 0){
                        e = 1;
                        break;
                    }
                }
                if(e == 0){
                    error = true;
                    error_text += '<li>لطفا وسیله نقلیه ی فرعی را مشخص کنید.</li>';
                    document.getElementById('mainClassificationOfTransportationInputDiv').classList.add('errorClass');
                }
                else
                    document.getElementById('mainClassificationOfTransportationInputDiv').classList.remove('errorClass');
            }

            if(isMeal == 1){
                if(!document.getElementById('c56').checked && !document.getElementById('c57').checked && !document.getElementById('c58').checked && !document.getElementById('c59').checked){
                    error = true;
                    error_text += '<li>لطفا نوع وعده غذایی را مشخص کنید.</li>';
                }
            }

            if(error){
                var text = '<div class="alert alert-danger alert-dismissible">\n' +
                    '            <button type="button" class="close" data-dismiss="alert" style="float: left">&times;</button>\n' +
                    '            <ul id="errorList">\n' + error_text +
                    '            </ul>\n' +
                    '        </div>';
                document.getElementById('errorDiv').style.display = 'block';
                document.getElementById('errorDiv').innerHTML = text;

                setTimeout(function(){
                    document.getElementById('errorDiv').style.display = 'none';
                }, 5000);
            }
            else{
                document.getElementById('errorDiv').style.display = 'none';
                $('#restaurantList').val(JSON.stringify(chooseRestaurantIds));
                $('#amakenList').val(JSON.stringify(chooseAmakenIds));
                $('#cityList').val(JSON.stringify(chooseCityIds));
                $('#sideTransport').val(JSON.stringify(chooseSideTransport));

                $('#form').submit();
            }

        }

    </script>

</body>
</html>
