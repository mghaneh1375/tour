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

</head>

<body id="BODY_BLOCK_JQUERY_REFLOW"
      class=" r_map_position_ul_fake ltr domn_en_US lang_en long_prices globalNav2011_reset rebrand_2017 css_commerce_buttons flat_buttons sitewide xo_pin_user_review_to_top track_back">

<div id="PAGE" class="filterSearch redesign_2015 non_hotels_like desktop scopedSearch">
    @include('layouts.placeHeader')
    <div class="ppr_rup ppr_priv_hr_atf_north_star_nostalgic">

        <div class="atf_header_wrapper">
            <div class="atf_header ui_container is-mobile full_width">

                <div class="ppr_rup ppr_priv_location_detail_header relative-position">
                    <h1 id="HEADING" property="name">
                        <b class="tourCreationMainTitle">شما در حال ایجاد یک تور جدید هستید</b>
                    </h1>
                    <div class="tourAgencyLogo circleBase type2"></div>
                    <b class="tourAgencyName">آژانس ستاره طلایی</b>
                </div>
            </div>
        </div>

        <div class="atf_meta_and_photos_wrapper">
            <div class="atf_meta_and_photos ui_container is-mobile easyClear">
                <div class="prw_rup darkGreyBox tourDetailsMainFormHeading">
                    <b class="formName">اطلاعات اختصاصی</b>
                    <div class="tourCreationStepInfo">
                        <span>
                            گام
                            <span>2</span>
                            از
                            <span>6</span>
                        </span>
                        <span>
                            آخرین ویرایش
                            <span>
                                {{$tour->lastUpdate}}
                            </span>
                            <span>
                                {{$tour->lastUpdateTime}}
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div id="tourDetailsMainForm2ndtStepMainDiv" class="Hotel_Review prodp13n_jfy_overflow_visible lightGreyBox">
        <form id="form" action="{{route('tour.create.stage.two.store')}}" method="post">
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
                                <input type="radio" name="isTransportTour" id="isTransportTour" value="0" onchange="transportTour(this.value)">خیر
                            </label>
                            <label class="btn btn-secondary active">
                                <input type="radio" name="isTransportTour" id="isTransportTour" value="1" onchange="transportTour(this.value)" checked>بلی
                            </label>

                        </div>
                    </div>

                    @if($tour->local)
                        <div id="sDiv" class="transportationDetailsMainBoxes">
                            <input type="hidden" name="eTransport" id="eTransport" value="-1">
                            <div class="transportationTitleBoxesLocal" id="toTheDestinationTitleBox">
                                <div>
                                    جابجایی تور
                                </div>
                            </div>

                            <div class="inputBox col-xs-4 transportationKindTourCreation" id="sTransportDiv">
                                <div class="inputBoxText">
                                    <div>
                                        نوع وسیله
                                        <span>*</span>
                                    </div>
                                </div>
                                <div class="select-side">
                                    <i class="glyphicon glyphicon-triangle-bottom"></i>
                                </div>
                                <select class="inputBoxInput styled-select" name="sTransport" id="sTransport" type="text" placeholder="انتخاب کنید">
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
                            <div class="inputBox col-xs-5" id="sAddressDiv">
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

                            <div class="inputBox col-xs-4 transportationStartTimeTourCreation" id="sTimeDiv">
                                <div class="inputBoxText">
                                    <div>
                                        ساعت حرکت
                                        <span>*</span>
                                    </div>
                                </div>

                                <input class="inputBoxInput" id="sHour" type="text" placeholder="ساعت" readonly>
                                <input class="inputBoxInput" id="sMinuts" type="text" placeholder="دقیقه" readonly>
                                <input type="hidden" id="sTime" name="sTime" class="form-control" required>

                                <script type="text/javascript">
                                    var sTime = $('#sHour').clockpicker({
                                        placement: 'left',
                                        donetext: 'تایید',
                                        autoclose: true,
                                        afterDone: function(){
                                            var sTime = document.getElementById('sHour').value ;
                                            document.getElementById('sTime').value = sTime;
                                            var sHour = sTime.split(':')[0];
                                            var sMinuts = sTime.split(':')[1];
                                            document.getElementById('sHour').value = sHour;
                                            document.getElementById('sMinuts').value = sMinuts;
                                        }
                                    });
                                    $('#sMinuts').click(function(e){
                                        e.stopPropagation();
                                        sTime.clockpicker('show');
                                    });
                                </script>

                            </div>
                            <div class="inputBox col-xs-7" id="">
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


                            <div class="inputBox col-xs-5" id="eAddressDiv">
                                <div class="inputBoxText">
                                    <div>
                                        محل اتمام
                                        <span>*</span>
                                    </div>
                                </div>
                                <input class="inputBoxInput" type="text" name="eAddress" id="eAddress" placeholder="فارسی">
                            </div>
                            <div class="inputBox col-xs-4 transportationStartTimeTourCreation" id="eTimeDiv">
                                <div class="inputBoxText">
                                    <div>
                                        ساعت اتمام
                                        <span>*</span>
                                    </div>
                                </div>

                                <input class="inputBoxInput" id="eHour" type="text" placeholder="ساعت" readonly>
                                <input class="inputBoxInput" id="eMinuts" type="text" placeholder="دقیقه" readonly>
                                <input type="hidden" id="eTime" name="eTime" class="form-control" required>

                                <script type="text/javascript">
                                    var eTime = $('#eHour').clockpicker({
                                        placement: 'left',
                                        donetext: 'تایید',
                                        autoclose: true,
                                        afterDone: function(){
                                            var eTime = document.getElementById('eHour').value ;
                                            document.getElementById('eTime').value = eTime;
                                            var eHour = eTime.split(':')[0];
                                            var eMinuts = eTime.split(':')[1];
                                            document.getElementById('eHour').value = eHour;
                                            document.getElementById('eMinuts').value = eMinuts;
                                        }
                                    });
                                    $('#eMinuts').click(function(e){
                                        e.stopPropagation();
                                        eTime.clockpicker('show');
                                    });
                                </script>

                            </div>
                            <button type="button" class="transportationMapPinningTourCreation col-xs-2" id="ePosition" data-toggle="modal" data-target="#modalMap" onclick="changeCenter('dest')">نشانه‌گذاری بر روی نقشه</button>
                            <input type="hidden" name="eLat" id="eLat" value="0">
                            <input type="hidden" name="eLng" id="eLng" value="0">

                            <div class="inputBox col-xs-7" id="">
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
                            <div class="transportationTitleBoxes" id="toTheDestinationTitleBox">
                                رفت
                            </div>
                            <div class="inputBox col-xs-4 transportationKindTourCreation" id="sTransportDiv">
                                <div class="inputBoxText">
                                    <div>
                                        نوع وسیله
                                        <span>*</span>
                                    </div>
                                </div>
                                <div class="select-side">
                                    <i class="glyphicon glyphicon-triangle-bottom"></i>
                                </div>
                                <select class="inputBoxInput styled-select" name="sTransport" id="sTransport" type="text" placeholder="انتخاب کنید">
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
                            <div class="inputBox col-xs-5" id="sAddressDiv">
                                <div class="inputBoxText">
                                    <div>
                                        محل حرکت
                                        <span>*</span>
                                    </div>
                                </div>
                                <input class="inputBoxInput" type="text" name="sAddress" id="sAddress" placeholder="فارسی">
                            </div>
                            <button type="button" class="transportationMapPinningTourCreation col-xs-2" id="sPosition" data-toggle="modal" data-target="#modalMap" onclick="changeCenter('src')">نشانه‌گذاری بر روی نقشه</button>
                            <input type="hidden" name="sLat" id="sLat" value="0">
                            <input type="hidden" name="sLng" id="sLng" value="0">

                            <div class="inputBox col-xs-4 transportationStartTimeTourCreation" id="sTimeDiv">
                                <div class="inputBoxText">
                                    <div>
                                        ساعت حرکت
                                        <span>*</span>
                                    </div>
                                </div>

                                <input class="inputBoxInput" id="sHour" type="text" placeholder="ساعت" readonly>
                                <input class="inputBoxInput" id="sMinuts" type="text" placeholder="دقیقه" readonly>
                                <input type="hidden" id="sTime" name="sTime" class="form-control" required>

                                <script type="text/javascript">
                                    var sTime = $('#sHour').clockpicker({
                                        placement: 'left',
                                        donetext: 'تایید',
                                        autoclose: true,
                                        afterDone: function(){
                                            var sTime = document.getElementById('sHour').value ;
                                            document.getElementById('sTime').value = sTime;
                                            var sHour = sTime.split(':')[0];
                                            var sMinuts = sTime.split(':')[1];
                                            document.getElementById('sHour').value = sHour;
                                            document.getElementById('sMinuts').value = sMinuts;
                                        }
                                    });
                                    $('#sMinuts').click(function(e){
                                        e.stopPropagation();
                                        sTime.clockpicker('show');
                                    });
                                </script>

                            </div>
                            <div class="inputBox col-xs-7" id="">
                                <div class="inputBoxText">
                                    <div>
                                        توضیحات تکمیلی
                                    </div>
                                </div>
                                <input class="inputBoxInput" name="sDescription" type="text" placeholder="حداکثر 100 کاراکتر" maxlength="100">
                            </div>
                            <div>
                                <span class="inboxHelpSubtitle">تاریخ رفت تاریخ شروع تور در نظر گرفته شود.</span>
                            </div>
                        </div>
                        <div id="eDiv" class="transportationDetailsMainBoxes">
                            <div class="transportationTitleBoxes" id="fromTheDestinationTitleBox">
                                برگشت
                            </div>
                            <div class="inputBox col-xs-4 transportationKindTourCreation" id="eTransportDiv">
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
                            <div class="inputBox col-xs-5" id="eAddressDiv">
                                <div class="inputBoxText">
                                    <div>
                                        محل حرکت
                                        <span>*</span>
                                    </div>
                                </div>
                                <input class="inputBoxInput" name="eAddress" id="eAddress" type="text" placeholder="فارسی">
                            </div>
                            <button type="button" class="transportationMapPinningTourCreation col-xs-2"  id="ePosition" data-toggle="modal" data-target="#modalMap" onclick="changeCenter('dest')">نشانه‌گذاری بر روی نقشه</button>
                            <input type="hidden" name="eLat" id="eLat" value="0">
                            <input type="hidden" name="eLng" id="eLng" value="0">

                            <div class="inputBox col-xs-4 transportationStartTimeTourCreation" id="eTimeDiv">
                                <div class="inputBoxText">
                                    <div>
                                        ساعت حرکت
                                        <span>*</span>
                                    </div>
                                </div>

                                <input class="inputBoxInput" id="eHour" type="text" placeholder="ساعت" readonly>
                                <input class="inputBoxInput" id="eMinuts" type="text" placeholder="دقیقه" readonly>
                                <input type="hidden" id="eTime" name="eTime" class="form-control" required>

                                <script type="text/javascript">
                                    var eTime = $('#eHour').clockpicker({
                                        placement: 'left',
                                        donetext: 'تایید',
                                        autoclose: true,
                                        afterDone: function(){
                                            var eTime = document.getElementById('eHour').value ;
                                            document.getElementById('eTime').value = eTime;
                                            var eHour = eTime.split(':')[0];
                                            var eMinuts = eTime.split(':')[1];
                                            document.getElementById('eHour').value = eHour;
                                            document.getElementById('eMinuts').value = eMinuts;
                                        }
                                    });
                                    $('#eMinuts').click(function(e){
                                        e.stopPropagation();
                                        eTime.clockpicker('show');
                                    });
                                </script>

                            </div>
                            <div class="inputBox col-xs-7" id="">
                                <div class="inputBoxText">
                                    <div>
                                        توضیحات تکمیلی
                                    </div>
                                </div>
                                <input class="inputBoxInput" type="text" name="eDescription" placeholder="حداکثر 100 کاراکتر"  maxlength="100">
                            </div>
                            <div>
                                <span class="inboxHelpSubtitle">تاریخ برگشت تاریخ پایان تور در نظر گرفته شود.</span>
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
                        <div class="inputBox col-xs-12 relative-position" id="mainClassificationOfTransportationInputDiv">
                            <div class="inputBoxText" id="mainClassificationOfTransportationLabel">
                                <div>
                                    دسته‌بندی اصلی
                                    <span>*</span>
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
                            <center class="addTourPlacesBtnDivTourCreation col-xs-4"  data-toggle="modal" data-target="#addResturantModal" onclick="cleanRestaurantSearch()" >
                                <div class="addTourPlacesBtnCreation circleBase type2">
                                    <img src="{{URL::asset("images/tourCreation/add.png")}}">
                                    <div>اضافه کنید</div>
                                </div>
                            </center>
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

                        <center class="addTourPlacesBtnDivTourCreation col-xs-4" data-toggle="modal" data-target="#addCityModal" onclick="cleanCitySearch()">
                            <div class="addTourPlacesBtnCreation circleBase type2">
                                <img src="{{URL::asset("images/tourCreation/add.png")}}">
                                <div>اضافه کنید</div>
                            </div>
                        </center>

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

                        <center class="addTourPlacesBtnDivTourCreation col-xs-4"  data-toggle="modal" data-target="#addAmakenModal" onclick="cleanAmakenSearch()">
                            <div class="addTourPlacesBtnCreation circleBase type2">
                                <img src="{{URL::asset("images/tourCreation/add.png")}}">
                                <div>اضافه کنید</div>
                            </div>
                        </center>
                    </div>
                </div>
            </div>
            <div class="ui_container">
                <button type="button" id="goToForthStep" class="btn nextStepBtnTourCreation"  onclick="checkInputs()">گام بعدی</button>
            </div>

            <div class="modal fade" id="addResturantModal">
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
                                <div class="row" style="display: flex; justify-content: space-between">
                                    <div class="inputBox col-xs-5 relative-position" id="mainClassificationOfPlaceInputDiv" style="float: right">
                                        <div class="inputBoxText">
                                            <div>
                                                استان
                                                <span>*</span>
                                            </div>
                                        </div>
                                        <div class="select-side">
                                            <i class="glyphicon glyphicon-triangle-bottom"></i>
                                        </div>
                                        <select class="inputBoxInput styled-select text-align-right" type="text" placeholder="انتخاب کنید" onchange="findCity(this.value, 'restaurant')">
                                            <option id="restaurantChooseOption">انتخاب کنید</option>
                                            @foreach($ostan as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="inputBox col-xs-5 relative-position" id="mainClassificationOfPlaceInputDiv" style="float: left">
                                        <div class="inputBoxText">
                                            <div>
                                                شهر
                                                <span>*</span>
                                            </div>
                                        </div>
                                        <div class="select-side">
                                            <i class="glyphicon glyphicon-triangle-bottom"></i>
                                        </div>
                                        <select id="restaurantCity" class="inputBoxInput styled-select text-align-right" onchange="findRestaurant(this.value)">
                                        </select>

                                    </div>
                                </div>
                            </div>

                            <div class="container-fluid">
                                <div class="row">
                                    <div class="inputBox col-xs-12 relative-position" id="placeNameAddingPlaceInputDiv">
                                        <div class="inputBoxText">
                                            <div>
                                                نام رستوران
                                                <span>*</span>
                                            </div>
                                        </div>
                                        <input id="inputSearchRestaurant" class="inputBoxInput text-align-right" type="text" placeholder="انتخاب کنید" onkeyup="showRestaurantList(this.value)">
                                        <div class="searchResult">
                                            <ul id="restaurantResult"></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="inboxHelpSubtitle">--}}
                                {{--اگر نام مورد نظر در داخل لیست موجود نبود، لطفاً آن را اضافه نمایید--}}
                            {{--</div>--}}

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
                                    <div class="inputBox col-xs-5 relative-position" id="mainClassificationOfPlaceInputDiv" style="float: right">
                                        <div class="inputBoxText">
                                            <div>
                                                استان
                                                <span>*</span>
                                            </div>
                                        </div>
                                        <div class="select-side">
                                            <i class="glyphicon glyphicon-triangle-bottom"></i>
                                        </div>
                                        <select class="inputBoxInput styled-select text-align-right" type="text" placeholder="انتخاب کنید" onchange="findCity(this.value, 'city')">
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
                                    <div class="inputBox col-xs-12 relative-position" id="placeNameAddingPlaceInputDiv">
                                        <div class="inputBoxText">
                                            <div>
                                                نام شهر
                                                <span>*</span>
                                            </div>
                                        </div>
                                        <input id="inputSearchCity" class="inputBoxInput text-align-right" type="text" placeholder="انتخاب کنید" onkeyup="showCityList(this.value)">
                                        <div class="searchResult">
                                            <ul id="cityResult"></ul>
                                        </div>
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
                                <div class="row" style="display: flex; justify-content: space-between">
                                    <div class="inputBox col-xs-5 relative-position" id="mainClassificationOfPlaceInputDiv" style="float: right">
                                        <div class="inputBoxText">
                                            <div>
                                                استان
                                                <span>*</span>
                                            </div>
                                        </div>
                                        <div class="select-side">
                                            <i class="glyphicon glyphicon-triangle-bottom"></i>
                                        </div>
                                        <select class="inputBoxInput styled-select text-align-right" type="text" placeholder="انتخاب کنید" onchange="findCity(this.value, 'amaken')">
                                            <option id="amakenChooseOption">انتخاب کنید</option>
                                            @foreach($ostan as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="inputBox col-xs-5 relative-position" id="mainClassificationOfPlaceInputDiv" style="float: left">
                                        <div class="inputBoxText">
                                            <div>
                                                شهر
                                                <span>*</span>
                                            </div>
                                        </div>
                                        <div class="select-side">
                                            <i class="glyphicon glyphicon-triangle-bottom"></i>
                                        </div>
                                        <select id="amakenCity" class="inputBoxInput styled-select text-align-right" onchange="findAmaken(this.value)"></select>
                                    </div>
                                </div>
                            </div>

                            <div class="container-fluid">
                                <div class="row">
                                    <div class="inputBox col-xs-12 relative-position" id="placeNameAddingPlaceInputDiv">
                                        <div class="inputBoxText">
                                            <div>
                                                نام اماکن
                                                <span>*</span>
                                            </div>
                                        </div>
                                        <input id="inputSearchAmaken" class="inputBoxInput text-align-right" type="text" placeholder="انتخاب کنید" onkeyup="showAmakenList(this.value)">
                                        <div class="searchResult">
                                            <ul id="amakenResult"></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="amakenChoose"></div>
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

    @include('layouts.footer.layoutFooter')
</div>

<script src={{URL::asset('js/tour/create/stageTwo.js')}}></script>

<script>

    var multiIsOpen = false;
    var transports = {!! $transport !!};
    var chooseSideTransport = [];
    var _token = '{{csrf_token()}}';
    var homeRoute = '{{route("home")}}';
    var searchRestaurantURL = '{{route("search.restauran.with.city")}}';
    var searchAmakenURL = '{{route("search.amaken.with.city")}}';
    var findCityURL = '{{route("findCityWithState")}}';
    var closePic  = '{{URL::asset("images/tourCreation/close.png")}}';
    var allState = {!! $ostan !!};
    var state;
    var city;
    var restaurantList;
    var restaurantInSearch = [];
    var restaurantChoose = [];
    var restaurantCity;
    var restaurantState;
    var cityInSearch = [];
    var cityChoose = [];
    var amakenCity;
    var amakenList;
    var amakenInSearch = [];
    var amakenChoose = [];
    var amakenState;

    function findCity(_value, _dest){
        var section;
        var s;

        for(i = 0; i < allState.length; i++){
            if(allState[i].id == _value){
                s = allState[i];
                state = s;
                break;
            }
        }

        if(_dest == 'restaurant') {
            document.getElementById('restaurantChooseOption').style.display = 'none';
            section = 'restaurantCity';
            restaurantState = s;
        }
        else if(_dest == 'city'){
            document.getElementById('cityResult').innerHTML = '';
            document.getElementById('cityChooseOption').style.display = 'none';
        }
        else if(_dest == 'amaken'){
            document.getElementById('amakenChooseOption').style.display = 'none';
            section = 'amakenCity';
            amakenState = s;
        }

        $.ajax({
            type: 'post',
            url: findCityURL,
            data: {
                '_token' : _token,
                'stateId': _value
            },
            success: function(response){
                city = JSON.parse(response);
                var text = '';
                for(i = 0; i < city.length; i++) {
                    if(_dest != 'city')
                        text += '<option value="' + city[i].id + '"> ' + city[i].name + ' </option>';

                }
                if(_dest != 'city')
                    document.getElementById(section).innerHTML = text;

            }
        })
    }

</script>

</body>
</html>