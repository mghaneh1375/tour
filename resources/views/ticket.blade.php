<?php $placeMode = "ticket";
$kindPlaceId = 10; ?>
<!DOCTYPE html>
<html lang="en">

<head>

    @include('layouts.topHeader')
    @include('layouts.phonePopUp')

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ngInfiniteScroll/1.3.0/ng-infinite-scroll.js"></script>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/home_rebranded.css?v=4')}}"/>
    <title>صفحه اصلی</title>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/long_lived_global_legacy_2.css?v=2')}}"/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/masthead-saves.css?v=2')}}'/>
    <link rel='stylesheet' type='text/css' media='screen, print'
          href='{{URL::asset('css/theme2/hr_north_star.css?v=2')}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/icons.css?v=1')}}'/>

    <script>
        var getStates = '{{route('getStates')}}';
        var getGoyesh = '{{route('getGoyesh')}}';
        var imageBasePath = '{{URL::asset('images')}}';
        var getCitiesDir = "{{route('getCitiesDir')}}";
        var checkOpen = false;

        var config = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;',
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
        };
    </script>

    <script src= {{URL::asset("js/calendar.js") }}></script>
    <script src= {{URL::asset("js/jalali.js") }}></script>

    <style>
        h2 {
        font-size: 2em;
        line-height: 1.25em;
        margin: .25em 0;
        }

        h3 {
        font-size: 1.5em;
        line-height: 1em;
        margin: .33em 0;
        }

        .numBetweenMinusPlusBtn {
            float: right;
            margin-top: -2px;
            margin-left: 5px;
            margin-right: 5px;
        }

    </style>

    <style>
        .icon-mainpage {
            width: 50px;
            height: 50px;
            background: #FFF;
            position: absolute;
            bottom: -14%;
            right: 43%;
            border-radius: 100%;
            border: 1px solid #CCC;
        }

        .icon-mainpage span {
            color: var(--koochita-light-green);
            font-size: 26px;
            line-height: 50px;
        }

        #middle-box:hover {
            background: #ededed !important;
        }

        .o-slider-next {
            left: 24%;
            right: auto;
        }

        .o-slider-prev span {
            top: 250px !important;
        }

        .o-slider-next span {
            top: 250px !important;
        }

        .o-slider-pagination {
            width: 25% !important;
            top: 450px;
        }
    </style>

    <style>
        div.ppr_rup.ppr_priv_trip_search .trip_search.rounded_lockup .ui_column:first-child {
            border-style: solid !important;
            border-color: #e5e5e5 !important;
            border-radius: 0 10px 10px 0;
        }

        .blitButton {
            width: 44px;
            height: 38px;
            background-size: 45px;
            border-radius: 15%;
            display: inline-block;
            cursor: pointer;
        }

        @media screen and (max-width: 600px) {
            .blitButton {
                width: 72px;
                height: 60px;
                background-size: 72px;
                border-radius: 11px;
            }
        }

        .class_passengerPane {
            text-align: center !important;
            position: absolute;
            background-color: white;
            padding: 10px;
            top: 115px;
            border-radius: 5px;
        }

        .class_passengerPane_phone {
            text-align: center !important;
            position: absolute;
            background-color: white;
            padding: 30px;
            border-radius: 25px;
            font-size: 3em;
            width: max-content;
            left: 50%;
            top: 50%;
            transform: translate(20%, -50%);
            z-index: 1000000000000000;
        }

        .classTypePane {
            cursor: pointer;
        }

        .classTypePane:hover {
            border-bottom: 1px solid var(--koochita-light-green);
        }

        .classTypePane_phone {
            height: 90px;
            line-height: 90px;
            border-bottom: 1px solid var(--koochita-light-green);
        }

        .arrowPane {
            background-image: url('{{URL::asset('images/profile.png')}}');
            cursor: pointer;
            display: inline-block;
            background-size: 35px;
            width: 16px;
            height: 8px;
        }

        @media screen and (max-width: 600px) {
            .arrowPane {
                width: 32px;
                height: 16px;
                background-size: 80px;
            }
        }

        .minusPlusBtn {
            width: 17px;
            height: 17px;
            cursor: pointer;
            float: right;
            display: inline-block;
            background-image: url('{{URL::asset('images') . '/icons.jpg'}}');
            background-size: 72px;
        }

        @media screen and (max-width: 600px) {
            .minusPlusBtn {
                width: 44px;
                height: 44px;
                background-size: 185px;
            }
        }

        #directional {
            width: 28%;
            height: 36%;
            position: absolute;
            right: 7%;
            top: 100%;
        }

        .directional {
            width: 30%;
            margin: 7px;
            border-radius: 7px;
            position: absolute;
            text-align: center;
            line-height: 38px;
            display: inline-block;
            cursor: pointer;
            font-size: 0.9em;
        }

        @media screen and (max-width: 600px) {
            .directional {
                font-size: 25px;
                line-height: 50px;
                margin: 15px 10px;
            }
        }

        .dateLabel {
            position: relative;
            width: 45%;
            height: 30px;
            /*border: 1px solid #e5e5e5;*/
            border-radius: 3px;
            /*box-shadow: 0 7px 12px -7px #e5e5e5 inset;*/
            margin: 0 !important;
            cursor: pointer;
            float: right;
            max-width: 40%;
        }

        .inputDateLabel {
            background: transparent;
            width: 90%;
            border: none;
            position: absolute;
            top: 5px;
            right: 35px;
            cursor: pointer;
            color: black;
        }

        .cityName {
            cursor: pointer;
            border-radius: 2px;
            padding: 2px 5px;
            margin: 0;
        }

        .cityName:hover {
            background-color: var(--koochita-light-green) !important;
            color: white !important;
        }

        .inputCityName {
            width: 85%;
            border: none !important;
            margin: 6px 0 2px;
            padding: 2px 5px;
            font-weight: 600;
        }

        .inputCityName:focus {
            border: none !important;
            color: var(--koochita-light-green);
        }

        .locationIcon {
            background-image: url('{{URL::asset('images') . '/icons.jpg'}}');
            background-position: -53px -60px;
            background-size: 70px;
            width: 16px;
            height: 25px;
            display: inline-block;
            float: right;
            margin: 2px 0 0 3px;
        }

        @media screen and (max-width: 600px) {
            .locationIcon {
                background-position: -107px -3px;
                background-size: 140px;
                width: 32px;
                height: 50px;
            }
        }

        .loader {
            background-image: url("{{URL::asset("images/loading.gif?v=".$fileVersions)}}");
            width: 100px;
            height: 100px;
        }

    </style>

    <style>
        ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
            color: black;
            opacity: 1; /* Firefox */
        }

        .shTIcon {
            font-family: shazde_regular2 !important;
            font-size: 20px;
        }
        .searchBottomArrowIcone:before {
            content: '\E04A';
            position: absolute;
            cursor: pointer;
        }
        .searchTopArrowIcone:before {
            content: '\E044';
            position: absolute;
            cursor: pointer;
        }
        .bottomArrowTypeIcone:before {
            top: 1px;
            left: 10%;
        }
        .bottomArrowClassIcone:before {
            top: 1px;
            left: 10%;
        }
        .bottomArrowPassengerIcone:before {
            top: 1px;
            left: 0%;
        }
    </style>

    <style>
        {{--calender in phone--}}
        @media screen and (max-width: 600px) {
            #ui-datepicker-div {
                width: 17em !important;
            }

            .ui-datepicker-multi-2 .ui-datepicker-group {
                width: 100% !important;
            }
        }
    </style>

    <style>
        .phoneBanner {
            background-image: url("{{URL::asset('images/phoneBanner.jpg')}}");
            background-size: 100% 100%;
            height: 90vh;
        }

        @media screen and (max-width: 600px) {
            /*DIV.ppr_rup.ppr_priv_homepage_hero .placement_wrap .placement_wrap_cell {*/
            /*display: grid !important;*/
            /*}*/
            /*.o-sliderContainer {*/
            /*height: 250px;*/
            /*}*/
            .nearby_cuisines .ui_columns.is-multiline .ui_column, .recently_viewed .ui_columns.is-multiline .ui_column, .recommended_poi_list .ui_columns.is-multiline .ui_column, .poi_by_tag .ui_columns.is-multiline .ui_column, .flights_airline_reviews .ui_columns.is-multiline .ui_column, .attraction_products_by_group .ui_columns.is-multiline .ui_column, .poi_by_taxonomy .ui_columns.is-multiline .ui_column {
                width: 386px !important;
            }

            .image_wrapper.landscape.landscapeWide .image {
                width: -webkit-fill-available !important;
            }

            .ui_column .thumbnail {
                height: 250px !important;
            }

            .image_wrapper {
                height: -webkit-fill-available;
            }

            DIV.prw_rup.prw_shelves_rebrand_poi_shelf_item_widget .detail .item.poi_name {
                font-size: 30px;
                line-height: 30px;
            }

            DIV.prw_rup.prw_shelves_shelf_widget .shelf_container.rebrand .shelf_header .ui_icon.travelers-choice-badge {
                display: inherit;
            }

            h3 {
                font-size: 200%;
            }

            DIV.prw_rup.prw_shelves_rebrand_poi_shelf_item_widget .detail .item.poi_name {
                font-size: 32px;
                line-height: 40px;
            }

            DIV.prw_rup.prw_shelves_rebrand_poi_shelf_item_widget .detail .item.tags {
                padding-top: 4px;
                font-size: 24px;
                line-height: 32px;
            }

            DIV.prw_rup.prw_shelves_rebrand_poi_shelf_item_widget .detail .item.rating-widget .reviewCount {
                font-size: 24px;
                line-height: 32px;
                margin: 0 10px;
            }

            body {
                font-size: x-large;
            }
        }
    </style>

    <style>
        .ticketIcon {
            font-family: shazde_regular2 !important;
            display: inline-block;
        }
        .rightArrowIcone:before {
            content: '\E047';
            color: var(--koochita-light-green);
            font-size: 2.5em;
            position: absolute;
            top:-10px;
        }
        .leftArrowIcone:before {
            content: '\E04D ';
            color: var(--koochita-light-green);
            font-size: 2.5em;
            position: absolute;
            top:-10px;
        }
        .rightInCalender:before {
            right: 25%;
        }
        .leftInCalender:before {
            left: 27%;
        }
        .rightInCalenderGre:before {
            right: 20%;
        }
        .leftInCalenderGre:before {
            left: 17%;
        }
    </style>

    <style>
        .squareDiv {
            height: 35vh;
            color: #30b4a6 !important;
            background-color: white;
            border: 1px solid lightgray;
            display: inline-block;
            text-align: center;
            cursor: pointer;
        }
        .squareDiv:hover {
            border:2px solid #30b4a6;
        }
    </style>

</head>

<body class="rebrand_2017 desktop HomeRebranded  js_logging">

    <div class="header hideOnPhone">
        @include('layouts.header1')
    </div>

    <div class="hideOnScreen">
        @include('layouts.header1Phone')
    </div>

    <div class="page" ng-app="mainApp">

        <div class="ppr_rup ppr_priv_homepage_hero">
            <div class="homeHero default_home" style="padding: 0 !important; width: 100%; background-position:50% bottom">
                <div class="ui_container container" style="width: 100%; max-width: 100%; padding: 0">
                    <div class="placement_wrap">
                        <div class="placement_wrap_row">
                            <div class="placement_wrap_cell">
                                <div id="sliderBarDIV" class="ppr_rup ppr_priv_trip_search hideOnPhone"
                                     style="max-width: 100%; overflow: hidden">

                                    <div class="ui_columns datepicker_box trip_search metaDatePicker rounded_lockup usePickerTypeIcons preDates noDates with_children" style="position: absolute; top: 20%; right: 5%; left: 5%; z-index: 10000000;">
                                        <div data-val="flightMode" data-val2="flightMode2" id="internalFlight"
                                             onclick="blitButtonClicked('internalFlight, internalFlight_phone')"
                                             class='blitButton' style="margin-left: 13%; background-position: 0 0"></div>
                                        <div data-val="flightMode" data-val2="flightMode2" id="externalFlight"
                                             onclick="blitButtonClicked('externalFlight, externalFlight_phone')"
                                             class='blitButton' style="background-position: 0 -36px"></div>
                                        <div data-val="trainMode" data-val2="trainMode2" data-val3="coupeExclusive"
                                             id="train" onclick="blitButtonClicked('train, train_phone')" class='blitButton'
                                             style="background-position: -1px -76px"></div>
                                        <div data-val="busMode" data-toggle="tooltip" data-placement="top"
                                             title="این بخش بزودی فعال می شود" id="bus" class="blitButton"
                                             style="background-position: -1px -112px;"></div>
{{--                                        when busMode is active: onclick="blitButtonClicked('bus, bus_phone')"--}}

                                        <div style="clear:both;"></div>
                                        <div class="ui_column ui_picker" style="float: right;border-radius: 0 10px 10px 0; width: 12%; padding: 8px !important;">
                                            <div class="locationIcon" style="margin-right: 10px"></div>
                                            <input class="inputCityName" id="srcCity" onkeyup="searchForCity(event, 'srcCity', 'resultSrc')" placeholder="شهر مبدا">
                                            <div id="resultSrc" class="data_holder" style="max-height: 160px; overflow: auto;"></div>
                                        </div>
                                        <div class="ui_column ui_picker" style="float: right; width: 12%; padding: 8px !important;">
                                            <div class="locationIcon" style="margin-right: 10px"></div>
                                            <input class="inputCityName" id="destCity" onkeyup="searchForCity(event, 'destCity', 'resultDest')" placeholder="شهر مقصد">
                                            <div id="resultDest" class="data_holder" style="max-height: 160px; overflow: auto;"></div>
                                        </div>
                                        <div class="ui_column" style="float: right; width: 30%; padding: 8px !important;">
                                            <div class="ui_picker" style="color: #b7b7b7 !important;">
                                                <label id="calendar-container-edit-1placeDate" class="dateLabel"  onclick="nowCalendar()">
                                                    <span class="ui_icon calendar" style="color: #30b4a6 !important; font-size: 20px; line-height: 32px; position: absolute; right: 7px;"></span>
                                                    <input name="date" id="goDate" type="text" class="inputDateLabel" placeholder="تاریخ رفت" required readonly>
                                                </label>
                                                <label id="calendar-container-edit-2placeDate" class="dateLabel hidden" style="margin-right: 14px !important;"  onclick="nowCalendar()">
                                                    <span style="color: #30b4a6 !important; font-size: 20px; line-height: 32px; position: absolute; right: 7px;">تا</span>
                                                    <input name="date" id="backDate" type="text" onclick="assignDate('{{convertStringToDate(getToday()["date"])}}', 'calendar-container-edit-2placeDate', 'backDate')" style="right: 52%" class="inputDateLabel" placeholder="تاریخ برگشت" required readonly>
                                                </label>
                                            </div>
                                        </div>
{{--                                        Passenger in flightMode--}}
                                        <div class="ui_column tripPassenger" id="flightMode" style="float: right; width: 24%; padding: 8px !important;">
                                            <div onclick="togglePassengerNoSelectPane()" style="background-image: url('{{URL::asset('images') . '/icons.jpg'}}');width: 19px;height: 31px;background-size: 72px;background-position: -36px -61px;display: inline-block; float: right; cursor: pointer; margin-right: 10px"></div>
                                            <div onclick="togglePassengerNoSelectPane()" style="width: 85%; display: inline-block; position: relative; float: right; margin: 6px 0 4px; font-weight: 700; cursor: pointer;" class="ui_picker">
                                                <div style="float: right">
                                                    <span id="adultPassengerNo"></span>&nbsp;
                                                    <span>بزرگسال</span>&nbsp;-&nbsp;
                                                    <span id="childPassengerNo"></span>
                                                    <span>کودک</span>&nbsp;-&nbsp;
                                                    <span id="infantPassengerNo"></span>
                                                    <span>نوزاد</span>&nbsp;
                                                </div>
                                                <div id="passengerArrowDown" class="shTIcon searchBottomArrowIcone bottomArrowPassengerIcone" style="display: inline-block;"></div>
                                                <div id="passengerArrowUp" class="shTIcon searchTopArrowIcone bottomArrowPassengerIcone hidden" style="display: inline-block;"></div>
                                            </div>
                                            <div class="class_passengerPane item hidden" id="passengerNoSelectPane" onmouseleave="addClassHidden('passengerNoSelectPane'); passengerNoSelect = false;" style="text-align: right !important;">
                                                <div style="height: 25px">
                                                    <span style="float: right;">بزرگسال<span style="margin: 10px; font-size: 60%;color: #00AF87" id="adultNoSpan"></span></span>
                                                    <div style="float: left; margin-right: 50px">
                                                        <div onclick="changePassengersNo(1, 3, 'flight')" class="minusPlusBtn" style="background-position: -1px -6px;"></div>
                                                        <span class='numBetweenMinusPlusBtn' id="adultPassengerNoInSelect"></span>
                                                        <div onclick="changePassengersNo(-1, 3, 'flight')" class="minusPlusBtn" style="background-position: -18px -6px;"></div>
                                                    </div>
                                                </div>
                                                <div style="height: 25px">
                                                    <span style="float: right;">کودک<span style="margin: 10px; font-size: 60%;color: #00AF87" id="childNoSpan"></span></span>
                                                    <div style="float: left">
                                                        <div onclick="changePassengersNo(1, 2, 'flight')" class="minusPlusBtn" style="background-position: -1px -6px;"></div>
                                                        <span class='numBetweenMinusPlusBtn' id="childPassengerNoInSelect"></span>
                                                        <div onclick="changePassengersNo(-1, 2, 'flight')" class="minusPlusBtn" style="background-position: -18px -6px;"></div>
                                                    </div>
                                                </div>
                                                <div style="height: 25px">
                                                    <span style="float: right;">نوزاد<span style="margin: 10px; font-size: 60%;color: #00AF87" id="infantNoSpan"></span></span>
                                                    <div style="float: left">
                                                        <div onclick="changePassengersNo(1, 1, 'flight')" class="minusPlusBtn" style="background-position: -1px -6px;"></div>
                                                        <span class='numBetweenMinusPlusBtn' id="infantPassengerNoInSelect"></span>
                                                        <div onclick="changePassengersNo(-1, 1, 'flight')" class="minusPlusBtn" style="background-position: -18px -6px;"></div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
{{--                                        Passenger in trainMode--}}
                                        <div class="ui_column tripPassenger item hidden" id="trainMode" style="float: right; width: 24%; padding: 8px !important;">
                                            <div style="background-image: url('{{URL::asset('images') . '/icons.jpg'}}');width: 19px;height: 31px;background-size: 72px;background-position: -36px -61px;display: inline-block; float: right; margin-right: 10px;"></div>
                                            <div style="display: inline-block; position: inherit !important; float: right; margin-top: 6px; font-weight: 700;" class="ui_picker">
                                                <span style="float:right;">مسافر</span>
                                                <div style="float: left; margin-right: 60px">
                                                    <div onclick="changePassengersNo(1, 1, 'train')" class="minusPlusBtn" style="background-position: -1px -6px;"></div>
                                                    <span id="passengerNoSelect"></span>
                                                    <div onclick="changePassengersNo(-1, 1, 'train')" class="minusPlusBtn" style="background-position: -18px -6px;"></div>
                                                </div>
                                            </div>
                                        </div>
{{--                                        typeTrip in flightMode--}}
                                        <div class="ui_column tripClass" id="flightMode2" style="float: right; width: 11%; border-radius:  10px 0px 0px 10px; padding: 8px !important;">
                                            <div style="position: relative; margin: 6px 0 4px; font-weight: 700; margin-right: 3px" class="ui_picker">
                                                <div id="flightClass" style="display: inline-block; cursor: pointer;" onclick="toggleClassNoSelectPane()"></div>
                                                <div id="classArrowDown" onclick="toggleClassNoSelectPane()" class="shTIcon searchBottomArrowIcone bottomArrowClassIcone" style="display: inline-block;"></div>
                                                <div id="classArrowUp" onclick="toggleClassNoSelectPane()" class="shTIcon searchTopArrowIcone bottomArrowClassIcone hidden" style="display: inline-block;"></div>
                                            </div>
                                            <div class="hidden class_passengerPane item" id="classNoSelectPane" onmouseleave="addClassHidden('classNoSelectPane'); classNoSelect = false;">
                                                <div class="classTypePane" onclick="changeClass(1)">اکونومی</div>
                                                <div class="classTypePane" onclick="changeClass(2)">فرست کلاس</div>
                                                <div class="classTypePane" onclick="changeClass(3)">بیزینس</div>
                                            </div>
                                        </div>
{{--                                        typeTrip in trainMode--}}
                                        <div class="ui_column tripClass hidden" id="trainMode2" style="float: right; width: 11%; border-radius:  10px 0px 0px 10px; padding: 8px !important;">
                                            <div style="position: relative; margin: 6px 0 4px; font-weight: 700;" class="ui_picker">
                                                <div id="passengerType" style="display: inline-block; cursor: pointer;" onclick="toggleTypeNoSelectPane()"></div>
                                                <div id="typeArrowDown" onclick="toggleTypeNoSelectPane()" class="shTIcon searchBottomArrowIcone bottomArrowTypeIcone" style="display: inline-block;"></div>
                                                <div id="typeArrowUp" onclick="toggleTypeNoSelectPane()" class="shTIcon searchTopArrowIcone bottomArrowTypeIcone hidden" style="display: inline-block;"></div>
                                            </div>
                                            <div class="class_passengerPane hidden" id="typeNoSelectPane"
                                                 onmouseleave="addClassHidden('typeNoSelectPane'); typeNoSelect = false;">
                                                <div class="classTypePane" onclick="changePassengerType(1)">مسافران
                                                    عادی
                                                </div>
                                                <div class="classTypePane" onclick="changePassengerType(2)">ویژه
                                                    خواهران
                                                </div>
                                                <div class="classTypePane" onclick="changePassengerType(3)">ویژه
                                                    برادران
                                                </div>
                                                <div class="classTypePane" onclick="changePassengerType(4)">حمل خودرو
                                                </div>
                                            </div>

                                        </div>
                                        <div class="prw_rup prw_common_form_submit ui_column submit_wrap" style="float: right; width: 10%; border-radius:  10px; border: 0px solid var(--koochita-light-green); margin-right: 9px;">
                                            <button onclick="redirect()" class="autoResize form_submit" style="padding: 13px !important;">
                                                <span class="ui_icon search submit_icon"></span>
                                                <span class="submit_text">جستجو</span>
                                            </button>
                                            <span class="ui_loader dark fill"></span>
                                        </div>

                                        <div style="clear:both;"></div>

                                        <div id="directional">
                                            <div id="unidirectional" class="directional"
                                                 onclick="directionalClicked('unidirectional'); changeTwoCalendar(1)" style="right: 0%">یک طرفه
                                            </div>
                                            <div id="bidirectional" class="directional"
                                                 onclick="directionalClicked('bidirectional'); changeTwoCalendar(2)" style="right: 33%">رفت و
                                                برگشت
                                            </div>
                                            <div id="coupeExclusive" data-status="OFF" class="directional hidden"
                                                 onclick="coupeExclusiveClicked('coupeExclusive')" style="right: 66%">کوپه
                                                دربست
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ppr_rup ppr_priv_trip_search phoneBanner hideOnScreen">

                                    <div class="ui_columns datepicker_box trip_search metaDatePicker rounded_lockup usePickerTypeIcons preDates noDates with_children"
                                         style="width: 50%; position: absolute; top: 45%; left: 50%; transform: translate(-50%, -50%); z-index: 10000000;">
                                        <div data-val="flightMode_phone" data-val2="flightMode2_phone"
                                             id="internalFlight_phone"
                                             onclick="blitButtonClicked('internalFlight, internalFlight_phone')"
                                             class='blitButton' style="background-position: 0 0"></div>
                                        <div data-val="flightMode_phone" data-val2="flightMode2_phone"
                                             id="externalFlight_phone"
                                             onclick="blitButtonClicked('externalFlight_phone, externalFlight')"
                                             class='blitButton' style="background-position: 0 -59px"></div>
                                        <div data-val="trainMode_phone" data-val2="trainMode2_phone"
                                             data-val3="coupeExclusive_phone" id="train_phone"
                                             onclick="blitButtonClicked('train_phone, train')" class='blitButton'
                                             style="background-position: 0px -120px"></div>
                                        <div data-val="busMode_phone" data-toggle="tooltip" data-placement="top"
                                             title="این بخش بزودی فعال می شود" id="bus_phone" class="blitButton"
                                             style="background-position: 0px -178px;"></div> when busMode is active: onclick="blitButtonClicked('bus_phone, bus')"

                                        <div style="clear:both;"></div>

                                        <div class="ui_column ui_picker" style="border-radius: 10px 10px 0 0">
                                            <div class="locationIcon" style="margin-right: 10px"></div>
                                            <input class="inputCityName" id="srcCity_phone" style="font-size: 2em" onclick="$('#phoneSearchPopUp').removeClass('hidden')" onkeyup="searchForCity(event, 'srcCity_phone', 'resultSrc_phone')" placeholder="شهر مبدا">
                                            <div class="inputCityName" id="srcCity_phone" style="font-size: 2em" onclick="$('#phoneSearchPopUp').removeClass('hidden')">شهر مبدا</div>
                                            <div id="resultSrc_phone" class="data_holder" style="max-height: 160px; overflow: auto;"></div>
                                        </div>

                                        <div style="clear:both;"></div>

                                        <div class="ui_column ui_picker">
                                            <div class="locationIcon" style="margin-right: 10px"></div>
                                            <input class="inputCityName" id="destCity_phone" style="font-size: 2em" onclick="$('#phoneSearchPopUp').removeClass('hidden')" onkeyup="searchForCity(event, 'destCity_phone', 'resultDest_phone')" placeholder="شهر مقصد">
                                            <div id="resultDest_phone" class="data_holder" style="max-height: 160px; overflow: auto;"></div>
                                        </div>

                                        <div style="clear:both;"></div>

                                        <div class="ui_column">
                                            <div class="ui_picker" style="color: #b7b7b7 !important;">
                                                <label id="calendar-container-edit-1placeDate_phone" class="dateLabel">
                                                    <span class="ui_icon calendar"
                                                          style="color: #30b4a6 !important; font-size: 35px; line-height: 40px; position: absolute; right: -10px;"></span>
                                                    <input name="date" id="date_input1_phone" style="font-size: 20px"
                                                           type="text"
                                                           onclick="assignDate('{{convertStringToDate(getToday()["date"])}}', 'calendar-container-edit-1placeDate_phone', 'date_input1_phone')"
                                                           class="inputDateLabel" placeholder="تاریخ رفت" required readonly>
                                                </label>
                                                <label id="calendar-container-edit-2placeDate_phone"
                                                       class="dateLabel hidden" style="margin-right: 14px !important;">
                                                    <span class="ui_icon calendar"
                                                          style="color: #30b4a6 !important; font-size: 35px; line-height: 40px; position: absolute; right: -10px;"></span>
                                                    <input name="date" id="backDate_phone" style="font-size: 20px"
                                                           type="text"
                                                           onclick="assignDate('{{convertStringToDate(getToday()["date"])}}', 'calendar-container-edit-2placeDate_phone', 'backDate_phone')"
                                                           class="inputDateLabel" placeholder="تاریخ برگشت" required
                                                           readonly>
                                                </label>
                                            </div>
                                        </div>
{{--                                        Passenger in flightMode_phone--}}
                                        <div class="ui_column tripPassenger" id="flightMode_phone"
                                             style="width: 70%; float: right">
                                            <div style="background-image: url('{{URL::asset('images') . '/icons.jpg'}}');width: 38px;height: 62px;background-size: 144px;background-position: -71px 0px;display: inline-block; float: right;"></div>
                                            <div style="display: inline-block; position: inherit !important; float: right; margin-top: 10px; font-size: 20px; line-height: 40px"
                                                 class="ui_picker">
                                                <div style="float: right">
                                                    <span id="adultPassengerNo_phone"></span>&nbsp;
                                                    <span>بزرگسال</span>&nbsp;-&nbsp;
                                                    <span id="childPassengerNo_phone"></span>
                                                    <span>کودک</span>&nbsp;-&nbsp;
                                                    <span id="infantPassengerNo_phone"></span>
                                                    <span>نوزاد</span>&nbsp;
                                                </div>
                                                <div id="passengerArrow_phone" class="arrowPane" onclick="togglePassengerNoSelectPane_phone()" style="background-position: -25px -278px;"></div>
                                            </div>
                                        </div>
{{--                                        Passenger in trainMode_phone--}}
                                        <div class="ui_column tripPassenger item hidden" id="trainMode_phone" style="width: 65%; float: right; padding-bottom: 2px !important;">
                                            <div style="background-image: url('{{URL::asset('images') . '/icons.jpg'}}');width: 38px;height: 62px;background-size: 144px;background-position: -71px 0px;display: inline-block; float: right;"></div>
                                            <div style="display: inline-block; position: inherit !important; float: right; margin-top: 8px; font-size: 22px; line-height: 40px" class="ui_picker">
                                                <span style="float:right;">مسافر</span>
                                                <div style="float: left; margin-right: 115px">
                                                    <div onclick="changePassengersNo(1, 1, 'train')" class="minusPlusBtn" style="background-position: -1px -13px; width: 35px; height: 35px; background-size: 150px;"></div>
                                                    <span id="passengerNoSelect_phone"></span>
                                                    <div onclick="changePassengersNo(-1, 1, 'train')" class="minusPlusBtn" style="background-position: -39px -13px; width: 35px; height: 35px; background-size: 150px;"></div>
                                                </div>
                                            </div>
                                        </div>
{{--                                        typeTrip in flightMode_phone--}}
                                        <div class="ui_column tripClass" id="flightMode2_phone" style="width: 30%">
                                            <div style="position: inherit !important; margin-top: 4px; font-size: 20px; line-height: 50px"
                                                 class="ui_picker">
                                                <div id="flightClass_phone" style="display: inline-block"></div>
                                                <div id="classArrow_phone" class="arrowPane" onclick="toggleClassNoSelectPane_phone()" style="background-position: -25px -278px;"></div>
                                                <div class="hidden class_passengerPane_phone item" id="classNoSelectPane_phone" style="width: auto !important;">
                                                <div class="ui_close_x" onclick="$('#classNoSelectPane_phone').addClass('hidden')" style="right: 78% !important;top: 1% !important;"></div>
                                                <div class="classTypePane_phone" onclick="changeClass(1)" style="margin-top: 30px">اکونومی</div>
                                                <div class="classTypePane_phone" onclick="changeClass(2)">فرست کلاس</div>
                                                <div class="classTypePane_phone" onclick="changeClass(3)">بیزینس</div>
                                                </div>
                                            </div>
                                        </div>
{{--                                        typeTrip in trainMode_phone--}}
                                        <div class="ui_column tripClass hidden" id="trainMode2_phone" style="width: 35%">
                                            <div style="position: inherit !important; margin-top: 8px; font-size: 22px; line-height: 44px"
                                                 class="ui_picker">
                                                <div id="passengerType_phone" style="display: inline-block"></div>
                                                <div id="typeArrow_phone" class="arrowPane"
                                                     onclick="toggleTypeNoSelectPane_phone()"
                                                     style="background-position: -25px -278px;"></div>
                                                <div class="hidden class_passengerPane_phone" id="typeNoSelectPane_phone" style="width: auto !important;">
                                                <div class="ui_close_x" onclick="$('#typeNoSelectPane_phone').addClass('hidden')" style="right: 78% !important;top: 1% !important;"></div>
                                                <div class="classTypePane_phone" onclick="changePassengerType(1)" style="margin-top: 40px">مسافران عادی</div>
                                                <div class="classTypePane_phone" onclick="changePassengerType(2)">ویژه خواهران</div>
                                                <div class="classTypePane_phone" onclick="changePassengerType(3)">ویژه برادران</div>
                                                <div class="classTypePane_phone" onclick="changePassengerType(4)">حمل خودرو</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div style="clear:both;"></div>

                                        <div class="prw_rup prw_common_form_submit ui_column submit_wrap"
                                             style="border: 0px solid var(--koochita-light-green); border-radius: 0 0 10px 10px; margin: 0 !important;">
                                            <button onclick="redirect()" class="autoResize form_submit"
                                                    style="padding: 17px !important; font-size: 30px; line-height: 30px">
                                                <span class="ui_icon search submit_icon"></span>
                                                <span class="submit_text">جستجو</span>
                                            </button>
                                            <span class="ui_loader dark fill"></span>
                                        </div>

                                        <div style="clear:both;"></div>

                                        <div>
                                            <div id="unidirectional_phone" class="directional"
                                                 onclick="directionalClicked('unidirectional_phone')"
                                                 style="right: 0; margin-right: 0">یک طرفه
                                            </div>
                                            <div id="bidirectional_phone" class="directional"
                                                 onclick="directionalClicked('bidirectional_phone')" style="right: 33%">رفت
                                                و برگشت
                                            </div>
                                            <div id="coupeExclusive_phone" data-status="OFF" class="directional hidden"
                                                 onclick="coupeExclusiveClicked('coupeExclusive_phone')"
                                                 style="margin-left: 0">کوپه دربست
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .homepage_shelves_widget {
                min-height: 100px;
            }
        </style>

        <div class="hideOnScreen row">
            <div class="col-xs-12">
                <a class="col-xs-4 squareDiv" href="{{route('mainMode', ['mode' => 'amaken'])}}"
                   style="color: #30b4a6 !important;">
                    <div class="phoneIcon atraction"></div>
                    <div class="textIcon">جاذبه ها</div>
                </a>
                <a class="col-xs-4 squareDiv" href="{{route('tickets')}}" style="color: #30b4a6 !important;">
                    <div class="phoneIcon ticket"></div>
                    <div class="textIcon">بلیط</div>
                </a>
                <a class="col-xs-4 squareDiv" href="{{route('main')}}" style="color: #30b4a6 !important;">
                    <div class="phoneIcon hotel"></div>
                    <div class="textIcon">هتل</div>
                </a>
            </div>
            <div style="clear: both"></div>
            <div class="col-xs-12">
                <div class="col-xs-4 squareDiv" onclick="$('#phoneSearchPopUp').removeClass('hidden')">
                    <div class="phoneIcon ghazamahali"></div>
                    <div class="textIcon">غذای محلی</div>
                </div>
                <div class="col-xs-4 squareDiv" onclick="$('#phoneSearchPopUp').removeClass('hidden')">
                    <div class="phoneIcon soghat"></div>
                    <div class="textIcon">سوغات</div>
                </div>
                <a class="col-xs-4 squareDiv" href="{{route('mainMode', ['mode' => 'restaurant'])}}"
                   style="color: #30b4a6 !important;">
                    <div class="phoneIcon restaurant"></div>
                    <div class="textIcon">رستوران</div>
                </a>
            </div>
            <div style="clear: both"></div>
            <div class="col-xs-4"></div>
            <div class="col-xs-4" onclick="$('#phoneMenuBarPopUp').removeClass('hidden')"
                 style="margin-top: -2px; text-align: center;">
                <span style="font-size: 30px; font-weight: bold"><span
                            class="phoneIcon downArrow"></span>گزینه های بیشتر</span>
            </div>
            <div class="col-xs-4"></div>
        </div>

        @include('layouts.middleBanner')
    </div>

    @include('layouts.footer.layoutFooter')

    @if(!Auth::check())
        @include('layouts.loginPopUp')
    @endif

    <script defer>
        var suggestions = [];
        var currIdx;
        var infant = 0, child = 0, adult = 0;
        var additional = 0;
        var trainPassenger = 0;
        var passengerNoSelect = false;
        var passengerNoSelect_phone = false;
        var classNoSelect = false;
        var classNoSelect_phone = false;
        var typeNoSelect = false;
        var typeNoSelect_phone = false;
        var selectedMode = "internalFlight";
        var directionMode;
        var adultInner = '{{$adultInner}}';
        var childInner = '{{$childInner}}';
        var infantInner = '{{$infantInner}}';
        var adultExternal = '{{$adultExternal}}';
        var childExternal = '{{$childExternal}}';
        var infantExternal = '{{$infantExternal}}';

        var url = '{{route('tickets')}}';
        $(document).ready(function () {

            $("#date_input1").val("");
            $("#backDate").val("");

            $('[data-toggle="tooltip"]').tooltip();
            $("#passengerNoSelect").empty().append(trainPassenger);
            $("#passengerNoSelect_phone").empty().append(trainPassenger);
            blitButtonClicked('internalFlight', 'internalFlight_phone');
            directionalClicked('unidirectional');
            changePassengersNo(0, 3, 'flight');
            changePassengersNo(0, 2, 'flight');
            changePassengersNo(0, 1, 'flight');
            changeClass(0);
            changePassengerType(0);
        });

        function redirect() {

            var src = $("#srcCity").val();

            if(src.length == 0) {
                alert("لطفا ابتدا مبدا سفر خود را انتخاب نمایید");
                return;
            }

            var dest = $("#destCity").val();
            if(dest.length == 0) {
                alert("لطفا ابتدا مقصد سفر خود را انتخاب نمایید");
                return;
            }

            var sDate = $("#goDate").val();
            if(sDate.length == 0) {
                alert("لطفا ابتدا تاریخ رفت سفر خود را انتخاب نمایید");
                return;
            }

            sDate = sDate.split('/');

            var eDate = "";

            if(directionMode === "bidirectional_phone" || directionMode === "bidirectional") {
                eDate = $("#backDate").val();
                if(eDate.length == 0) {
                    alert("لطفا ابتدا تاریخ برگشت سفر خود را انتخاب نمایید");
                    return;
                }

                eDate = eDate.split('/');
            }

            var mode;

            var tmp = selectedMode.split(",")[0];
            if(tmp === "internalFlight" || tmp === "internalFlight_phone") {
                mode = "internalFlight";
                if(adult + child + infant == 0) {
                    alert("لطفا تعداد مسافرین سفر خود را انتخاب نمایید");
                    return;
                }

            }

            else if(tmp === "train" || tmp === "train_phone") {
                mode = "train";
                if(trainPassenger == 0) {
                    alert("لطفا تعداد مسافرین سفر خود را انتخاب نمایید");
                    return;
                }

                adult = trainPassenger;
                child = infant = 0;
            }

            if(eDate.length > 0)
                document.location.href = '{{route('home')}}' + "/getTickets/" + mode + "/" + src + "/" + dest + "/" + adult + "/"
                    + child + "/" + infant + "/" + additional + "/" + sDate + "/" + eDate + "/0";
            else
                document.location.href = '{{route('home')}}' + "/getTickets/" + mode + "/" + src + "/" + dest + "/" + adult + "/"
                        + child + "/" + infant + "/" + additional + "/" + sDate;

        }

        function addClassHidden(element) {
            $("#" + element).addClass('hidden');
            if (element === 'classNoSelectPane') {
                $("#classArrowDown").removeClass('hidden');
                $("#classArrowUp").addClass('hidden');
            }
            if (element === 'typeNoSelectPane'){
                $("#typeArrowDown").removeClass('hidden');
                $("#typeArrowUp").addClass('hidden');
            }
            if (element === 'passengerNoSelectPane'){
                $("#passengerArrowDown").removeClass('hidden');
                $("#passengerArrowUp").addClass('hidden');
            }

            //in phone
            if (element === 'classNoSelectPane_phone')
                $("#classArrow_phone").css('background-position', '-25px -278px');
            if (element === 'typeNoSelectPane_phone')
                $("#typeArrow_phone").css('background-position', '-25px -278px');
            if (element === 'passengerNoSelectPane_phone')
                $("#passengerArrow_phone").css('background-position', '-25px -278px');
        }

        function togglePassengerNoSelectPane() {
            if (!passengerNoSelect) {
                passengerNoSelect = true;
                $("#passengerNoSelectPane").removeClass('hidden');
                $("#passengerArrowUp").removeClass('hidden');
                $("#passengerArrowDown").addClass('hidden');
            }
            else {
                $("#passengerNoSelectPane").addClass('hidden');
                $("#passengerArrowDown").removeClass('hidden');
                $("#passengerArrowUp").addClass('hidden');
                passengerNoSelect = false;
            }
        }

        function togglePassengerNoSelectPane_phone() {
            if (!passengerNoSelect_phone) {
                passengerNoSelect_phone = true;
                $('.dark').show();
                $("#passengerNoSelectPane_phone").removeClass('hidden');
                $("#passengerArrow_phone").css('background-position', '-25px -360px');
            }
            else {
                $("#passengerNoSelectPane_phone").addClass('hidden');
                $("#passengerArrow_phone").css('background-position', '-25px -278px');
                $('.dark').hide();
                passengerNoSelect_phone = false;
            }
        }

        function toggleClassNoSelectPane() {
            if (!classNoSelect) {
                classNoSelect = true;
                $("#classNoSelectPane").removeClass('hidden');
                $("#classArrowUp").removeClass('hidden');
                $("#classArrowDown").addClass('hidden');
            }
            else {
                $("#classNoSelectPane").addClass('hidden');
                $("#classArrowDown").removeClass('hidden');
                $("#classArrowUp").addClass('hidden');
                classNoSelect = false;
            }
        }

        function toggleClassNoSelectPane_phone() {
            if (!classNoSelect_phone) {
                classNoSelect_phone = true;
                $('.dark').show();
                $("#classNoSelectPane_phone").removeClass('hidden');
                $("#classArrow_phone").css('background-position', '-25px -360px');
            }
            else {
                $("#classNoSelectPane_phone").addClass('hidden');
                $("#classArrow_phone").css('background-position', '-25px -278px');
                $('.dark').hide();
                classNoSelect_phone = false;
            }
        }

        function toggleTypeNoSelectPane() {
            if (!typeNoSelect) {
                typeNoSelect = true;
                $("#typeNoSelectPane").removeClass('hidden');
                $("#typeArrowUp").removeClass('hidden');
                $("#typeArrowDown").addClass('hidden');
            }
            else {
                $("#typeNoSelectPane").addClass('hidden');
                $("#typeArrowDown").removeClass('hidden');
                $("#typeArrowUp").addClass('hidden');
                typeNoSelect = false;
            }
        }

        function toggleTypeNoSelectPane_phone() {
            if (!typeNoSelect_phone) {
                typeNoSelect_phone = true;
                $('.dark').show();
                $("#typeNoSelectPane_phone").removeClass('hidden');
                $("#typeArrow_phone").css('background-position', '-25px -360px');
            }
            else {
                $("#typeNoSelectPane_phone").addClass('hidden');
                $("#typeArrow_phone").css('background-position', '-25px -278px');
                $('.dark').hide();
                typeNoSelect_phone = false;
            }
        }

        function blitButtonClicked(elem, elemPhone) {

            var modeTmp = elem.split(',')[0];

            if(modeTmp === "internalFlight") {
                $("#adultNoSpan").empty().append(adultInner);
                $("#childNoSpan").empty().append(childInner);
                $("#infantNoSpan").empty().append(infantInner);

                $("#adultNoSpanMobile").empty().append(adultInner);
                $("#childNoSpanMobile").empty().append(childInner);
                $("#infantNoSpanMobile").empty().append(infantInner);
            }
            else if(modeTmp === "externalFlight") {

                $("#adultNoSpan").empty().append(adultExternal);
                $("#childNoSpan").empty().append(childExternal);
                $("#infantNoSpan").empty().append(infantExternal);

                $("#adultNoSpanMobile").empty().append(adultExternal);
                $("#childNoSpanMobile").empty().append(childExternal);
                $("#infantNoSpanMobile").empty().append(infantExternal);
            }

            selectedMode = elem;

            elem = $("#" + elem);
            elemPhone = $("#" + elemPhone);

            $(".blitButton").css('background-color', 'white')
                .css('background-image', 'url("' + '{{URL::asset('images') . '/tbuttonoff.png'}}' + '")');
            elem.css('background-color', 'var(--koochita-light-green)')
                .css('background-image', 'url("' + '{{URL::asset('images') . '/tbuttonon.png'}}' + '")');
            elemPhone.css('background-color', 'var(--koochita-light-green)')
                .css('background-image', 'url("' + '{{URL::asset('images') . '/tbuttonon.png'}}' + '")');

            $(".tripClass").addClass('hidden');
            $(".tripPassenger").addClass('hidden');
            $("#coupeExclusive").addClass('hidden');
            $("#coupeExclusive_phone").addClass('hidden');

            $("#" + elem.attr('data-val')).removeClass('hidden');
            $("#" + elem.attr('data-val2')).removeClass('hidden');
            $("#" + elem.attr('data-val3')).removeClass('hidden');

            $("#" + elemPhone.attr('data-val')).removeClass('hidden');
            $("#" + elemPhone.attr('data-val2')).removeClass('hidden');
            $("#" + elemPhone.attr('data-val3')).removeClass('hidden');
        }

        function changePassengersNo(inc, mode, type) {
            switch (type) {
                case 'flight':
                    switch (mode) {
                        case 3:
                        default:
                            if (adult + inc >= 0)
                                adult += inc;
                            $("#adultPassengerNo").empty().append(adult);
                            $("#adultPassengerNoInSelect").empty().append(adult);

                            $("#adultPassengerNo_phone").empty().append(adult);
                            $("#adultPassengerNoInSelect_phone").empty().append(adult);
                            break;
                        case 2:
                            if (child + inc >= 0)
                                child += inc;
                            $("#childPassengerNo").empty().append(child);
                            $("#childPassengerNoInSelect").empty().append(child);

                            $("#childPassengerNo_phone").empty().append(child);
                            $("#childPassengerNoInSelect_phone").empty().append(child);
                            break;
                        case 1:
                            if (infant + inc >= 0)
                                infant += inc;
                            $("#infantPassengerNo").empty().append(infant);
                            $("#infantPassengerNoInSelect").empty().append(infant);

                            $("#infantPassengerNo_phone").empty().append(infant);
                            $("#infantPassengerNoInSelect_phone").empty().append(infant);
                            break;
                    }
                    break;
                case 'train':
                    if (trainPassenger + inc >= 0)
                        trainPassenger += inc;
                    $("#passengerNoSelect").empty().append(trainPassenger);
                    $("#passengerNoSelect_phone").empty().append(trainPassenger);
                    break;
            }
        }

        function changeClass(mode) {
            additional = mode;
            switch (mode) {
                case 1:
                    $("#flightClass").empty().append('اکونومی');
                    $("#flightClass_phone").empty().append('اکونومی');
                    break;
                case 2:
                    $("#flightClass").empty().append('فرست کلاس');
                    $("#flightClass_phone").empty().append('فرست کلاس');
                    break;
                case 3:
                    $("#flightClass").empty().append('بیزینس');
                    $("#flightClass_phone").empty().append('بیزینس');
                    break;
                default:
                    $("#flightClass").empty().append('کلاس');
                    $("#flightClass_phone").empty().append('کلاس');
                    break;
            }
            $('dark').hide();
        }

        function changePassengerType(mode) {
            additional = mode;
            switch (mode) {
                case 1:
                    $("#passengerType").empty().append('مسافران عادی');
                    $("#passengerType_phone").empty().append('مسافران عادی');
                    break;
                case 2:
                    $("#passengerType").empty().append('ویژه خواهران');
                    $("#passengerType_phone").empty().append('ویژه خواهران');
                    break;
                case 3:
                    $("#passengerType").empty().append('ویژه برادران');
                    $("#passengerType_phone").empty().append('ویژه برادران');
                    break;
                case 4:
                    $("#passengerType").empty().append('حمل خودرو');
                    $("#passengerType_phone").empty().append('حمل خودرو');
                    $('dark').hide();
                    break;
                default:
                    $("#passengerType").empty().append('نوع مسافر');
                    $("#passengerType_phone").empty().append('نوع مسافر');
                    break;
            }
            $('dark').hide();
        }

        function directionalClicked(element) {

            directionMode = element;

            $(".directional").css('background-color', 'white').css('color', 'black');
            $("#" + element).css('background-color', 'var(--koochita-light-green)').css('color', 'white');
            $("#unidirectional_phone").css('background-color', 'var(--koochita-light-green)').css('color', 'white');

            if(element === 'bidirectional')
                $("#calendar-container-edit-2placeDate").removeClass('hidden');
            else
                $("#calendar-container-edit-2placeDate").addClass('hidden');

            if (element === 'bidirectional_phone')
                $("#calendar-container-edit-2placeDate_phone").removeClass('hidden');
            else
                $("#calendar-container-edit-2placeDate_phone").addClass('hidden');
        }

        function coupeExclusiveClicked(element) {
            if ($("#" + element).attr('data-status') == 'OFF') {
                $("#" + element).css('background-color', 'var(--koochita-light-green)').css('color', 'white')
                    .attr('data-status', 'ON');
            } else {
                $("#" + element).css('background-color', 'white').css('color', 'black')
                    .attr('data-status', 'OFF');
            }
        }

        function hideElement(val) {
            $("#" + val).addClass('hidden');
        }

        function showElement(val) {
            $("#" + val).removeClass('hidden');
        }

        function searchForCity(e, targetDiv, resultDiv) {
            $("#directional").css("right", "25%").css("top", "75%");
            $("#" + resultDiv).css('margin-top', '15px');
            if ($("#" + targetDiv).val().length < 2) {
                $("#" + resultDiv).css('margin-top', '0px').empty();
                $("#directional").css("right", "7%").css("top", "100%");
                return;
            }

            $(".cityName").css("background-color", "transparent").css("color", "black");

            if (13 == e.keyCode && -1 != currIdx) {
                setCityName(targetDiv, resultDiv, suggestions[currIdx].name);
                return;
            }

            if (13 == e.keyCode && -1 == currIdx && suggestions.length > 0) {
                setCityName(targetDiv, resultDiv, suggestions[0].name);
                return;
            }

            if (40 == e.keyCode) {
                if (currIdx + 1 < suggestions.length)
                    currIdx++;
                else
                    currIdx = 0;

                if (currIdx >= 0 && currIdx < suggestions.length)
                    $("#suggest_" + currIdx).css("background-color", "var(--koochita-light-green)").css("color", "white");
                return;
            }
            if (38 == e.keyCode) {
                if (currIdx - 1 >= 0)
                    currIdx--;
                else
                    currIdx = suggestions.length - 1;

                if (currIdx >= 0 && currIdx < suggestions.length)
                    $("#suggest_" + currIdx).css("background-color", "var(--koochita-light-green)").css("color", "white");
                return;
            }

            $.ajax({
                type: 'post',
                url: '{{route('searchForLine')}}',
                data: {
                    'key': $("#" + targetDiv).val(),
                    'mode': selectedMode
                },
                success: function (response) {

                    currIdx = -1;
                    $("#" + resultDiv).empty();

                    if (response.length != 0) {
                        response = JSON.parse(response);
                        suggestions = response;
                        newElement = "";
                        if (response.length > 0) {
                            if (response[0].mode == "near")
                                newElement += "<p style='color: #963019;'>نتیجه ای یافت نشد.</p><p style='color: #963019;'> " + response[0].place + " های نزدیک</p>";
                            for (i = 0; i < response.length; i++) {
                                newElement += "<p class='cityName' id='suggest_" + i + "' onclick='setCityName(\"" + targetDiv + "\", \"" + resultDiv + "\", \"" + response[i].name + "\")'>" + response[i].name + "</p>";
                            }
                        }
                        else
                            newElement += "<p>نتیجه ای یافت نشد</p>";
                        $("#" + resultDiv).append(newElement);
                    }
                }
            });
        }

        function setCityName(targetDiv, resultDiv, cityName) {
            if (cityName != "") {
                $("#" + targetDiv).val(cityName);
                $("#" + resultDiv).empty();
            }
            $("#" + resultDiv).css('margin-top', '0px').empty();
            $("#directional").css("right", "7%").css("top", "100%");
        }
    </script>

    <script defer src="{{URL::asset('js/mainPageSuggestions.js')}}"></script>

    <script async src="{{URL::asset('js/middleBanner.js')}}"></script>

    <script async src="{{URL::asset('js/slideBar.js')}}"></script>

    <span id="statePane" class="ui_overlay ui_modal editTags hidden"
          style="position: fixed; left: 30%; right: 30%; top:19%; bottom: auto;overflow: auto;max-height: 500px;z-index: 10000001;">

        <div class="header_text">استان مورد نظر</div>
        <div class="subheader_text">استان مورد نظر خود را از بین استان های موجود انتخاب کنید</div>
        <div class="body_text">

            <select style="margin-top: 25px;" id="states"></select>

            <div style="margin-top: 25px;" class="submitOptions">
                <button onclick="document.location.href = $('#states').val()"
                        style="color: #FFF;background-color: var(--koochita-light-green);border-color:var(--koochita-light-green);"
                        class="btn btn-success">تایید</button>
                <input type="submit" onclick="$('.dark').hide(); $('#statePane').addClass('hidden')" value="خیر"
                       class="btn btn-default">
            </div>
        </div>
        <div onclick="$('#statePane').addClass('hidden'); $('.dark').hide()" class="ui_close_x"></div>
    </span>

    <span id="goyeshPane" class="ui_overlay ui_modal editTags hidden"
          style="position: fixed; left: 30%; right: 30%; top:19%; bottom: auto;overflow: auto;max-height: 500px;z-index: 10000001;">

        <div class="header_text">گویش مورد نظر</div>
        <div class="subheader_text">گویش مورد نظر خود را از بین گویش های موجود انتخاب کنید</div>
        <div class="body_text">

            <select style="margin-top: 25px;" id="goyesh"></select>

            <div style="margin-top: 25px;" class="submitOptions">
                <button onclick="document.location.href = $('#goyesh').val()"
                        style="color: #FFF;background-color: var(--koochita-light-green);border-color:var(--koochita-light-green);"
                        class="btn btn-success">تایید</button>
                <input type="submit" onclick="$('.dark').hide(); $('#goyeshPane').addClass('hidden')" value="خیر"
                       class="btn btn-default">
            </div>
        </div>
        <div onclick="$('#goyeshPane').addClass('hidden'); $('.dark').hide()" class="ui_close_x"></div>
    </span>

{{--    Number of passenger | popUp--}}
    <div class="class_passengerPane_phone item hidden" id="passengerNoSelectPane_phone">
        <div class="ui_close_x"
             onclick="$('#passengerNoSelectPane_phone').addClass('hidden'); $('.dark').hide(); $('#passengerArrow_phone').css('background-position', '-25px -278px'); passengerNoSelect_phone = false;"
             style="right: 86% !important;top: 1% !important;"></div>
        <div style="height: 90px; margin-top: 72px">
            <span style="float: right;">بزرگسال<span style="margin: 10px; font-size: 60%;color: #00AF87" id="adultNoSpanMobile"></span></span>
            <div style="float: left; margin-right: 50px">
                <div onclick="changePassengersNo(1, 3, 'flight')" class="minusPlusBtn"
                     style="background-position: -1px -15px;"></div>
                <span id="adultPassengerNoInSelect_phone"></span>
                <div onclick="changePassengersNo(-1, 3, 'flight')" class="minusPlusBtn"
                     style="background-position: -48px -15px;"></div>
            </div>
        </div>
        <div style="height: 90px">
            <span style="float: right;">کودک<span style="margin: 10px; font-size: 60%;color: #00AF87" id="childNoSpanMobile"></span></span>
            <div style="float: left">
                <div onclick="changePassengersNo(1, 2, 'flight')" class="minusPlusBtn"
                     style="background-position: -1px -15px;"></div>
                <span id="childPassengerNoInSelect_phone"></span>
                <div onclick="changePassengersNo(-1, 2, 'flight')" class="minusPlusBtn"
                     style="background-position: -48px -15px;"></div>
            </div>
        </div>
        <div style="height: 25px">
            <span style="float: right;">نوزاد<span style="margin: 10px; font-size: 60%;color: #00AF87" id="infantNoSpanMobile"></span></span>
            <div style="float: left">
                <div onclick="changePassengersNo(1, 1, 'flight')" class="minusPlusBtn"
                     style="background-position: -1px -15px;"></div>
                <span id="infantPassengerNoInSelect_phone"></span>
                <div onclick="changePassengersNo(-1, 1, 'flight')" class="minusPlusBtn"
                     style="background-position: -48px -15px;"></div>
            </div>
        </div>
    </div>
{{--    class of flight mode | popUp--}}
    <div class="class_passengerPane_phone item hidden" id="classNoSelectPane_phone" style="transform: translate(60% , -50%) !important;">
        <div class="ui_close_x" onclick="$('#classNoSelectPane_phone').addClass('hidden'); $('.dark').hide(); $('#classArrow_phone').css('background-position', '-25px -278px'); classNoSelect_phone = false;" style="right: 78% !important;top: 1% !important;"></div>
        <div class="classTypePane_phone" onclick="changeClass(1)" style="margin-top: 30px">اکونومی</div>
        <div class="classTypePane_phone" onclick="changeClass(2)">فرست کلاس</div>
        <div class="classTypePane_phone" onclick="changeClass(3)">بیزینس</div>
    </div>
{{--    class of train mode | popUp--}}
    <div class="class_passengerPane_phone hidden" id="typeNoSelectPane_phone" style="transform: translate(60% , -50%) !important;">
        <div class="ui_close_x" onclick="$('#typeNoSelectPane_phone').addClass('hidden'); $('.dark').hide(); $('#typeArrow_phone').css('background-position', '-25px -278px'); typeNoSelect_phone = false;" style="right: 78% !important;top: 1% !important;"></div>
        <div class="classTypePane_phone" onclick="changePassengerType(1)" style="margin-top: 40px">مسافران عادی</div>
        <div class="classTypePane_phone" onclick="changePassengerType(2)">ویژه خواهران</div>
        <div class="classTypePane_phone" onclick="changePassengerType(3)">ویژه برادران</div>
        <div class="classTypePane_phone" onclick="changePassengerType(4)">حمل خودرو</div>
    </div>

    <div id="darkPane" class="ui_backdrop dark" style="display: none; z-index: 10000000;"></div>

</body>


</html>