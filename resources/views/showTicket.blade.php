<?php $placeMode = "ticket";
$state = "تهران"; ?>
<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include('layouts.topHeader')
    <link rel='stylesheet' type='text/css' media='screen, print'
          href='{{URL::asset('css/theme2/eatery_overview.css?v=2')}}'/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/long_lived_global_legacy_2.css?v=1')}}"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/icons.css?v=1')}}'/>


    <script src= {{URL::asset("js/calendar.js") }}></script>
    <script src= {{URL::asset("js/jalali.js") }}></script>



    <style>
        /*a {*/
        /*text-decoration: none;*/
        /*}*/
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

        table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            margin-bottom: 3%;
        }

        /* ---------- CALENDAR ---------- */
        .calendarJ {
            text-align: center;
            direction: rtl;
        }

        .calendarJ header {
            position: relative;
            margin-bottom: 3%;
        }

        .calendarJ h2 {
            text-transform: uppercase;
        }

        .calendarJ thead {
            font-weight: 600;
            text-transform: uppercase;
        }

        .calendarJ tbody {
            color: #7c8a95;
        }

        .calendarJ td {
            display: inline-block;
            height: 4em;
            line-height: 4em;
            font-size: 80%;
            color: black;
            width: 13%;
        }

        .calendarJ td:nth-child(5) {
            border-left: 1px solid #aeaeae;
        }

        .calendarJ .prev-month,
        .calendarJ .next-month {
            color: #ebebeb;
            border: 2px solid transparent;
            text-align: center;
            width: 100%;
            height: 100%;
            border-radius: 50% !important;
        }

        /******for gregorian calendar***********************/
        .calendarGre {
            text-align: center;
            direction: ltr;
        }

        .calendarGre header {
            margin-bottom: 3%;
            position: relative;
        }

        .calendarGre h2 {
            text-transform: uppercase;
        }

        .calendarGre thead {
            font-weight: 600;
            text-transform: uppercase;
        }

        .calendarGre tbody {
            color: #7c8a95;
        }

        .calendarGre td {
            display: inline-block;
            height: 4em;
            line-height: 4em;
            font-size: 80%;
            color: black;
            width: 13%;
        }

        .calendarGre td:nth-child(6) {
            border-left: 1px solid #aeaeae;
        }

        .calendarGre .prev-month,
        .calendarGre .next-month {
            color: #ebebeb;
            border: 2px solid transparent;
            text-align: center;
            width: 100%;
            height: 100%;
            border-radius: 50% !important;
        }

        .tableDiv {
            border: 2px solid transparent;
            text-align: center;
            width: 100%;
            height: 100%;
            border-radius: 50% !important;
        }

        .tableDiv:hover {
            border: 2px solid var(--koochita-light-green);
        }

        .current-day {
            background: var(--koochita-light-green);
            color: white !important;
        }

        .event {
            cursor: pointer;
            position: relative;
        }

        .event:after {
            background: #00addf;
            border-radius: 50%;
            bottom: .5em;
            display: block;
            content: '';
            height: .5em;
            left: 50%;
            margin: -.25em 0 0 -.25em;
            position: absolute;
            width: .5em;
        }

        .event.current-day:after {
            background: #f9f9f9;
        }

        .btn-prev,
        .btn-next {
            border: 2px solid #cbd1d2;
            border-radius: 50%;
            color: #cbd1d2;
            height: 2em;
            font-size: .75em;
            line-height: 2em;
            margin: -1em;
            position: absolute;
            top: 50%;
            width: 2em;
        }

        .btn-prev:hover,
        .btn-next:hover {
            background: #cbd1d2;
            color: #f9f9f9;
        }

        .btn-prev {
            left: 6em;
        }

        .btn-next {
            right: 6em;
        }

        .between {
            color: var(--koochita-light-green);
        }
    </style>

    <style>
        /* ---------- GENERAL ---------- */
        body {
            color: #0e171c;
            font: 300 100%/1.5em 'Lato', sans-serif;
            margin: 0;
        }

        a {
            text-decoration: none;
        }

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

        table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            margin-bottom: 3%;
        }

        .container {
            height: auto;
            padding: 2%;
            border: solid #cccccc;
            left: 20%;
            margin: -255px 0 0 -245px;
            position: absolute;
            top: 35%;
            width: 75%;
        }

        /* ---------- CALENDAR ---------- */
        .calendar {
            text-align: center;
        }

        .calendar header {
            position: relative;
            margin-bottom: 3%;
        }

        .calendar h2 {
            text-transform: uppercase;
        }

        .calendar thead {
            font-weight: 600;
            text-transform: uppercase;
        }

        .calendar tbody {
            color: #7c8a95;
        }

        .calendar td {
            display: inline-block;
            height: 4em;
            line-height: 4em;
            font-size: 100%;
            color: black;
            width: 13%;
        }

        .calendar td:nth-child(5) {
            border-left: 1px solid #aeaeae;
        }

        .calendar .prev-month,
        .calendar .next-month {
            color: #ebebeb;
            border: 2px solid transparent;
            text-align: center;
            width: 100%;
            height: 100%;
            border-radius: 50% !important;
        }

        /******for gregorian calendar***********************/
        .calendarGre {
            text-align: center;
            direction: ltr;
        }

        .calendarGre header {
            margin-bottom: 3%;
            position: relative;
        }

        .calendarGre h2 {
            text-transform: uppercase;
        }

        .calendarGre thead {
            font-weight: 600;
            text-transform: uppercase;
        }

        .calendarGre tbody {
            color: #7c8a95;
        }

        .calendarGre td {
            display: inline-block;
            height: 4em;
            line-height: 4em;
            font-size: 100%;
            color: black;
            width: 13%;
        }

        .calendarGre td:nth-child(6) {
            border-left: 1px solid #aeaeae;
        }

        .calendarGre .prev-month,
        .calendarGre .next-month {
            color: #ebebeb;
            border: 2px solid transparent;
            text-align: center;
            width: 100%;
            height: 100%;
            border-radius: 50% !important;
        }

        .tableDiv {
            border: 2px solid transparent;
            text-align: center;
            width: 100%;
            height: 100%;
            border-radius: 50% !important;
        }

        .tableDiv:hover {
            border: 2px solid var(--koochita-light-green);
        }

        .current-day {
            background: var(--koochita-light-green);
            color: white !important;
        }

        .event {
            cursor: pointer;
            position: relative;
        }

        .event:after {
            background: #00addf;
            border-radius: 50%;
            bottom: .5em;
            display: block;
            content: '';
            height: .5em;
            left: 50%;
            margin: -.25em 0 0 -.25em;
            position: absolute;
            width: .5em;
        }

        .event.current-day:after {
            background: #f9f9f9;
        }

        .btn-prev,
        .btn-next {
            border: 2px solid #cbd1d2;
            border-radius: 50%;
            color: #cbd1d2;
            height: 2em;
            font-size: .75em;
            line-height: 2em;
            margin: -1em;
            position: absolute;
            top: 50%;
            width: 2em;
        }

        .btn-prev:hover,
        .btn-next:hover {
            background: #cbd1d2;
            color: #f9f9f9;
        }

        .btn-prev {
            left: 6em;
        }

        .btn-next {
            right: 6em;
        }

        .between {
            color: var(--koochita-light-green);
        }
    </style>

    <style>
        input[type="checkbox"], input[type="radio"] {
            display: none;
        }

        input[type="checkbox"] + label, input[type="radio"] + label {
            color: #666666;
        }

        input[type="checkbox"] + label span, input[type="radio"] + label span {
            display: inline-block;
            width: 19px;
            height: 19px;
            margin: -2px 10px 0 0;
            vertical-align: middle;
            background: url('{{URL::asset('images/check_radio_sheet.png')}}') left top no-repeat;
            cursor: pointer;
        }

        input[type="checkbox"]:checked + label span, input[type="radio"]:checked + label span {
            background: url('{{URL::asset('images/check_radio_sheet.png')}}') -19px top no-repeat;
        }

        .moreItems {
            display: block;
            text-align: center;
            margin-top: 5px;
            cursor: pointer;
            text-align: -webkit-right;
        }

        .lessItems {
            display: block;
            text-align: center;
            margin-top: 5px;
            cursor: pointer;
            text-align: -webkit-right;
        }

        .moreItems2 {
            display: block;
            text-align: center;
            margin-top: 5px;
            cursor: pointer;
            text-align: -webkit-right;
        }

        .lessItems2 {
            display: block;
            text-align: center;
            margin-top: 5px;
            cursor: pointer;
            text-align: -webkit-right;
        }

        ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
            color: black;
            opacity: 1; /* Firefox */
        }
    </style>

    <style>
        /* Range Slider css */
        @import "https://propeller.in/components/range-slider/css/nouislider.min.css";
        /*Propeller Range Slider css*/
        @import "https://propeller.in/components/range-slider/css/range-slider.css";

        .main-container {
            width: 100vw;
            min-height: 90vh;
        }

        .set-center {
            display: flex;
            justify-content: center;
        }

        .search-fild-detail {
            text-align: center;
            direction: rtl;
        }

        .search-fields-box {
            width: 32%;
            padding: 0 10px;
            display: inline-block;
            text-align: center;
            font-size: 1.03em;
        }

        .search-fields-date-icon {
            margin-left: 5px;
            margin-right: 5px;
            color: var(--koochita-light-green) !important;
            font-size: 15px;
        }

        .search-fields-but {
            margin-right: 40px;
            background-color: var(--koochita-light-green);
            border: none;
            color: white;
            height: 25px;
            border-radius: 3px;
        }

        .selected-filter:hover {
            color: var(--koochita-light-green);
            cursor: pointer;
        }

        .selected-filter:selection {
            color: var(--koochita-light-green);
            font-size: 13px;
            cursor: pointer;
        }

        .select-sort {
            color: var(--koochita-light-green);
        }

        .filter-selected-byclick {
            color: var(--koochita-light-green);
            cursor: pointer;
        }

        .filter-underline {
            display: none;
        }

        .selected-filter:hover .filter-underline {
            display: block;
            width: 50%;
            position: absolute;
            top: 136%;
            margin: auto;
            background-color: var(--koochita-light-green);
            height: 3px;
            border-radius: 2px;
        }

        .underline_select {
            display: block;
            width: 50%;
            position: absolute;
            top: 136%;
            margin: auto;
            background-color: var(--koochita-light-green);
            height: 3px;
            border-radius: 2px;
        }

        .filter-underline-selected {
            display: block !important;
            width: 50%;
            position: absolute;
            top: 136%;
            margin: auto;
            background-color: var(--koochita-light-green);
            height: 3px;
            border-radius: 2px;
        }

        .boxTicket {
            background-color: #ebebeb;
            width: 100%;
            height: 165px;
            box-shadow: 0px 0px 3px 3px #f9f9f9;
            margin-bottom: 10px;
        }

        .choiceFlight {
            width: 100%;
            height: 30px;
            line-height: 30px;
            margin: 15px;
            padding: 0 10px;
            color: #92321b;
            font-size: 1.5em;
            font-weight: 700;
            text-align: right;
            box-shadow: 0px 0px 3px 3px #E5E5E5;
        }

        .boxSale {
            background-color: white;
            width: 100%;
            height: 30px;
            box-shadow: 0px 0px 3px 3px #E5E5E5;
            margin-bottom: 15px;
        }

        .boxOffer {
            background-color: white;
            width: 100%;
            height: 65px;
            box-shadow: 0px 0px 3px 3px #E5E5E5;
            margin-bottom: 30px;
            text-align: right;
            padding: 10px 15px;
        }

        .ticket-type {
            width: 120px;
            float: right;
            background-color: var(--koochita-light-green);
            margin: 5px 10px;
            font-size: 15px;
            color: white;
            text-align: center;
        }
    </style>

    <style>
        .check-box__item {
            padding-top: 5px;
            padding-bottom: 5px;
            position: relative;
        }

        *, :after, :before {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }
        .left_bar_background {
            background-color: #ebebeb;
            width: 70%;
            margin: 0 auto;
            height: 610px;
            border-radius: 5px;
            box-shadow: 1px 2px 2px 2px #f9f9f9;
        }
        .left_bar {
            padding-left: 10px;
            height: 85px;
            padding-right: 10px;
            padding-top: 10px;
        }

        .left_content_bar {
            background-color: white;
            height: 100%;
            border-radius: 18px;
            margin-bottom: 8%;
            cursor: pointer;
        }

        .left_content_bar:hover {
            background-color: red;
        }

        .left_content_bar:hover .date-money {
            color: white;
        }

        .left_content_bar_now {
            background-color: red;
            height: 100%;
            border-radius: 18px;
            color: white;
            margin-bottom: 8%;
            cursor: pointer;
        }

        .not_day {
            background-color: white;
            height: 100%;
            border-radius: 18px;
            margin-bottom: 8%;
        }

        /************************/
        .modal-content {
            display: none;
            background-color: whitesmoke;
            padding: 20px;
            margin-top: 10px;
            border: 1px solid #888;
            width: 100%;
        }

        .pmd-range-slider.noUi-background {
            transition: all 0.2s ease-in-out;
        }

        .pmd-range-slider.noUi-background {
            box-shadow: none;
            background: #dedede;
        }

        .pmd-range-slider.noUi-target {
            box-shadow: none;
            border: none;
            height: 4px;
            margin: 40px 0 6px;
        }

        .pmd-range-slider .noUi-base {
            z-index: 100;
        }

        .noUi-target * {
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -ms-touch-action: none;
            touch-action: none;
            -ms-user-select: none;
            -moz-user-select: none;
            user-select: none;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .pmd-range-slider .noUi-handle {
            border: none;
            box-shadow: none;
            border-radius: 50%;
            background: var(--koochita-light-green);
            width: 14px;
            height: 14px;
            left: -7px;
            top: -6px;
            cursor: pointer;
        }

        .noUi-horizontal .noUi-handle {
            width: 20px;
            height: 20px;
            left: -10px;
            top: -9px;
        }

        .noUi-horizontal .noUi-handle-lower .noUi-tooltip {
            display: none;
        }

        .noUi-horizontal .noUi-handle-upper .noUi-tooltip {
            display: none;
        }

        .pmd-range-slider .noUi-handle:before {
            display: block;
            width: 100%;
            height: 100%;
            background: var(--koochita-light-green);
            position: absolute;
            left: 0;
            top: 0;
            border-radius: 50%;
        }

        .pmd-range-slider .noUi-connect {
            background: var(--koochita-light-green);
        }
    </style>

    <style>
        .ui_column .thumbnail {
            height: 250px !important;
        }

        .dateLabel {
            position: relative;
            width: 150px;
            height: 30px;
            /*border: 1px solid #e5e5e5;*/
            border-radius: 3px;
            /*box-shadow: 0 7px 12px -7px #e5e5e5 inset;*/
            margin: 0 !important;
            cursor: pointer;
            float: right;
            max-width: 40%;
        }

        .dateLabel_phone {
            height: 30px;
        }

        .inputDateLabel {
            background: transparent;
            width: 100px;
            border: none;
            /*font-size: 75%;*/
            position: absolute;
            top: 5px;
            right: 35px;
            cursor: pointer;
            text-align: center;
        }

        .inputDateLabel_phone {
            width: 85%;
            border: none;
            font-size: 30px;
            line-height: 40px;
            position: absolute;
            top: 7px;
            right: 65px;
        }

        .ui_icon.travelers-choice-badge {
            display: inherit;
        }
    </style>

    {{--showTicketIcon--}}
    <style>
        .shTIcon {
            font-family: shazde_regular2 !important;
            font-size: 20px;
        }

        .calendarIcon:before {
            content: '\E015';
            color: var(--koochita-light-green);
            display: inline-block;
        }

        .passengerIcon:before {
            content: '\E0DF';
            color: var(--koochita-light-green);
        }

        .clsIcon:before {
            content: '\E02C';
            cursor: pointer;
        }

        .bottomArrowIcon:before {
            content: '\E04A';
            color: #92321b;
            position: absolute;
            top: -7px;
            left: -20px;
        }

        #morning:before {
            content: '\E061';
        }

        #noon:before {
            content: '\E062';
        }

        #afternoon:before {
            content: '\E063';
        }

        #night:before {
            content: '\E075';
        }

        #changeTime:before {
            left: 12%;
            top: -2px;
            color: #050c93 !important;
        }
        .fillArrowBottomIcone {
            text-align: center;
        }
        .fillArrowUpIcone {
            text-align: center;
        }

        .fillArrowBottomIcon:before {
            content: '\E040';
            color: var(--koochita-light-green);
            font-size: 1.7em;
            height: 50px;
            line-height: 50px;
            cursor: pointer;
        }

        .fillArrowUpIcon:before {
            content: '\E03A';
            color: var(--koochita-light-green);
            font-size: 1.7em;
            cursor: pointer;
            height: 50px;
            text-align: center;
            line-height: 50px;
        }

        .fillArrowUpIcon2:before {
            content: '\E03A';
            color: grey;
            font-size: 1.7em;
            cursor: pointer;
        }

        .locationIcon:before {
            content: '\E019';
            color: var(--koochita-light-green);
        }

        .leftArrowIcon:before {
            content: '\E04D';
            color: gray;
            position: absolute;
            top: 20px;
            left: -12px;
        }
    </style>

    <style>
        .blitTabligh {
            background-image: url("{{URL::asset('images/Capture.PNG')}}");
            background-size: 100% 100%;
            margin-top: 25px;
            width: 100%;
            height: 25vh;
        }

        .filterBox {
            background-color: var(--koochita-light-green);
            border-radius: 3px;
            color: white;
            padding: 2px 5px;
            display: inline-block;
            float: right;
            margin: 5px;
        }

        .shTIcon {
            font-family: shazde_regular2 !important;
            font-size: 20px;
        }

        .clsIcon:before {
            content: '\E02C';
            cursor: pointer;
        }

        .bottomArrowIcon:before {
            content: '\E04A';
            color: #92321b;
            position: absolute;
            top: -7px;
            left: -20px;
        }

        .dayNight {
            width: 24%;
            display: inline-block;
            text-align: center;
            cursor: pointer;
        }

        .dayNightText {
            font-size: 1.3em;
            margin-top: 15px;
        }

        #morning:before {
            content: '\E061';
        }

        #noon:before {
            content: '\E062';
        }

        #afternoon:before {
            content: '\E063';
        }

        #night:before {
            content: '\E075';
        }

        /*#timeFlight:before {*/
        /*right: 55px;*/
        /*}*/
        /*#stopFlight:before {*/
        /*right: 30px;*/
        /*}*/
        /*#kindFlight:before {*/
        /*right: 50px;*/
        /*}*/
        /*#companyFlight:before {*/
        /*right: 95px;*/
        /*}*/
        /*#classFlight:before {*/
        /*right: 60px;*/
        /*}*/
        /*#periodFlight:before {*/
        /*right: 55px;*/
        /*}*/
        .labelEdit {
            position: absolute;
            right: 20px;
            top: 7px;
            width: 20%;
            font-weight: 100;
            font-size: 0.8em;
        }

        .salelabelEdit {
            color: black;
            position: absolute;
            right: 50px;
            width: 25%;
            font-weight: 700;
            top: 8px;
        }

        .picturelabelEdit {
            background-image: url("{{URL::asset('images/phoneBanner.jpg')}}");
            background-size: 100% 100%;
            width: 10%;
            height: 5vh;
            display: inline-block;
            position: absolute;
            left: 0;
        }
        .fillArrowBottomIcon {
            text-align: center;
        }
        .fillArrowUpIcon {
            text-align: center;
        }

        .fillArrowBottomIcon:before {
            content: '\E040';
            color: var(--koochita-light-green);
            font-size: 1.7em;
            height: 50px;
            line-height: 50px;
        }

        .fillArrowUpIcon:before {
            content: '\E03A';
            font-size: 1.7em;
            cursor: pointer;
            height: 50px;
            text-align: center;
            line-height: 50px;
        }

        .fillArrowUpIcon3:before {
            color: var(--koochita-light-green);
        }

        .class_changeTime {
            text-align: center !important;
            position: absolute;
            background-color: white !important;
            padding: 10px;
            top: 25px;
            left: 0px;
            border-radius: 5px;
            z-index: 10000000;
            box-shadow: 0 15px 20px -5px #e5e5e5 inset;
            border: 2px solid #ebebeb;
        }

        .changeTypeTime {
            cursor: pointer;
        }

        .changeTypeTime:hover {
            border-bottom: 1px solid var(--koochita-light-green);
        }
    </style>

    <style>
        .airlinesImage {
            float: right;
            width: 60px;
            height: 60px;
            line-height: 60px;
            margin-right: 20%;
        }

        .airlinesText {
            display: inline-block;
            line-height: 60px;
            font-size: 1.7em;
        }

        .viewOffersBtn {
            background: orange;
            border-color: orange;
            line-height: 30px;
            width: 150px;
            border-radius: 7px;
            text-align: center;
            font-size: 1.5em;
            font-weight: bold;
        }

        .alarm {
            background: var(--koochita-light-green);
            border-color: var(--koochita-light-green);
            color: #fff;
            line-height: 32px;
            font-size: 1.5em;
            width: 120px;
            border-radius: 7px;
        }

        .btn:hover, .btn:active {
            color: #fff;
            opacity: .8;
        }

        .dropbtn {
            background-color: #4CAF50;
            color: white;
            padding: 16px;
            font-size: 16px;
            border: none;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown:hover .dropbtn {
            background-color: #3e8e41;
        }
    </style>

    <style>
        .searchAgain {
            border: 1.5px solid #b7b7b7;
            background-color: white;
            width: 93%;
            height: 35px;
            float: right;
            border-radius: 7px;
        }

        .origin {
            width: 19%;
            border-left: 1.5px solid #b7b7b7;
        }

        .destination {
            width: 19%;
            border-left: 1.5px solid #b7b7b7;
        }

        .dates {
            width: 19%;
            border-left: 1.5px solid #b7b7b7;
        }

        .passenger {
            width: 19%;
            border-left: 1.5px solid #b7b7b7;
        }

        .classFlight {
            width: 19%;
        }
    </style>

    <style>
        .explainFlight {
            width: 80%;
            height: 60px;
            position: absolute;
            right: 10%;
            display: inline-block;
        }

        .explainPurpose {
            width: 12%;
            text-align: center;
            display: inline-block;
            position: absolute;
        }

        .explainStop {
            width: 30%;
            color: #92321b;
            text-align: center;
            position: absolute;
            top: 50%;
            right: 50%;
            transform: translate(50%, -50%);
            z-index: 1000;
        }

        .leftArrowIcon:before {
            content: '\E04D';
            color: gray;
            position: absolute;
            top: 20px;
            left: -12px;
        }
    </style>

    {{--get alarm style:--}}
    <style>
        .getAlarm {
            position: fixed;
            left: 30%;
            right: 30%;
            top: 19%;
            bottom: auto;
            overflow: auto;
            max-height: 500px;
            z-index: 10000001;
            direction: rtl;
            text-align: right;
        }

        .alarmHeaderText {
            font-size: 1.3em;
            font-weight: 700;
            color: #4a4a4a;
        }

        .alarmSubHeaderText {
            margin: 7px 0 1px;
            color: #888686;
        }

        .alarmBoxCityName {
            border: 2px solid #E5E5E5;
            border-radius: 10px;
            width: 33%;
            padding: 7px;
            font-size: 0.8em;
        }

        .alarmInputCityName {
            width: 90%;
            border: none !important;
        }

        .alarmInputCityName:focus {
            border: none !important;
            color: var(--koochita-light-green);
        }

        .alarmPopUpBotton {
            background: var(--koochita-light-green);
            border-color: var(--koochita-light-green);
            color: #fff;
            line-height: 24px;
            font-size: 1em;
            width: 100px;
            border-radius: 7px;
        }
    </style>

    {{--visitOffers style :--}}
    <style>
        .visitOffers {
            position: fixed;
            left: 10%;
            right: 10%;
            top: 15%;
            bottom: auto;
            z-index: 10000001;
            direction: rtl;
            text-align: right;
        }

        .ui_overlay:before {
            border: none !important;
        }

        .boxRightVaLetf {
            width: 49.5%;
            display: inline-block;
        }

        .rightBoxFlight {
            width: 100%;
            background-color: #ffffff;
            padding: 5px 10px;
            margin-bottom: 8px;
            box-shadow: 3px 3px 1px #dbdbdb;
        }
    </style>

    <style>
        .editSearchButtton {
            margin-right: 40px;
            background-color: var(--koochita-light-green);
            border: none;
            color: white;
            height: 49px;
            width: 100%;
            font-size: 2.5em;
            border-radius: 10px;
        }
        .editSearchBox {
            width: 84%;
            height: 50px;
            border: 2px solid #E5E5E5;
            border-radius: 10px;
            float: right;
            position: relative;
        }
        .editSearchDestBox {
            width: 20%;
            padding: 11px 7px;
            border-left: 2px solid #E5E5E5;
            display: inline-block;
            position: absolute;
        }
        .editSearchCalenderBox {
            width: 24%;
            padding: 8px;
            border-left: 2px solid #E5E5E5;
            display: inline-block;
            position: absolute;
            right: 40%;
        }
        .editSearchCalenderIcon {
            position: absolute;
            top: 5px;
            right: 5px;
            display: inline-block;
            font-size: 21px;
        }
        .editSearchPassengerBox {
            width: 24%;
            padding: 11px 7px;
            border-left: 2px solid #E5E5E5;
            display: inline-block;
            position: absolute;
            right: 64%;
            text-align: right;
            font-weight: 700;
        }
        .editSearchClassBox {
            width: 12%;
            padding: 13px 10px;
            display: inline-block;
            position: absolute;
            right: 88%;
            text-align: right;
            font-weight: 700;
        }
        .cityName:hover {
            background-color: var(--koochita-light-green) !important;
            color: white !important;
        }
        .inputCityName {
            width: 85%;
            border: none !important;
            display: inline-block;
            text-align: right;
            color: black;
            margin-left: 2px;
            padding: 2px 5px;
            font-size: 1.15em;
            font-weight: 700;
        }
        .inputCityName:focus {
            border: none !important;
            color: var(--koochita-light-green);
        }
        .searchBottomArrowIcone:before {
            content: '\E04A';
            position: absolute;
            top: 15px;
            cursor: pointer;
        }
        .searchTopArrowIcone:before {
            content: '\E044';
            position: absolute;
            top: 15px;
            cursor: pointer;
        }
        .bottomArrowClassIcone:before {
            left: 10%;
        }
        .bottomArrowPassengerIcone:before {
            left: 10%;
        }

        .class_passengerPane {
            text-align: center !important;
            position: absolute;
            background-color: white;
            padding: 10px;
            top: 55px;
            right: 20%;
            border-radius: 5px;
            z-index: 999;
            border: 2px solid #e5e5e5;
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

        .calenderBase {
            width: 75%;
            height: auto;
            direction: rtl;
            background: white;
            z-index: 999999999;
            display: none;
            padding: 1%;
            /*margin: -255px 0 0 -245px;*/
            border: solid #ebebeb;
            position: absolute;
            right: 30%;
            top: 170px !important;
        }

        .calendar {
            text-align: center;
            direction: rtl;
        }

        .calendar header {
            position: relative;
            margin-bottom: 3%;
        }

        .calendar h2 {
            text-transform: uppercase;
        }

        .calendar thead {
            font-weight: 600;
            text-transform: uppercase;
        }

        .calendar tbody {
            color: #7c8a95;
        }

        .numBetweenMinusPlusBtn {
            float: right;
            margin-top: -2px;
            margin-left: 5px;
            margin-right: 5px;
        }

        .calendar td {
            display: inline-block;
            height: 2em;
            line-height: 2em;
            font-size: 79%;
            color: black;
            width: 14%;
        }

        .calendar td:nth-child(5) {
            border-left: 1px solid #aeaeae;
        }

        .calendar .prev-month,
        .calendar .next-month {
            color: #ebebeb;
            border: 2px solid transparent;
            text-align: center;
            width: 100%;
            height: 100%;
            border-radius: 50% !important;
        }

        /******for gregorian calendar******/
        .calendarGre {
            text-align: center;
            direction: ltr;
        }

        .calendarGre header {
            margin-bottom: 3%;
            position: relative;
        }

        .calendarGre h2 {
            text-transform: uppercase;
        }

        .calendarGre thead {
            font-weight: 600;
            text-transform: uppercase;
        }

        .calendarGre tbody {
            color: #7c8a95;
        }

        .calendarGre td {
            display: inline-block;
            height: 2em;
            line-height: 2em;
            font-size: 79%;
            color: black;
            width: 13%;
        }

        .calendarGre td:nth-child(6) {
            border-left: 1px solid #aeaeae;
        }

        .calendarGre .prev-month,
        .calendarGre .next-month {
            color: #ebebeb;
            border: 2px solid transparent;
            text-align: center;
            width: 100%;
            height: 100%;
            border-radius: 50% !important;
        }

        .tableDiv {
            border: 2fpx solid transparent;
            width: 45%;
            height: 102%;
            margin: 0 auto;
            border-radius: 50% !important;
            cursor: pointer;
        }

        .tableDiv:hover {
            border: 2px solid var(--koochita-light-green);
        }

        .current-day {
            background: var(--koochita-light-green);
            color: white !important;
        }

        .event {
            cursor: pointer;
            position: relative;
        }

        .event:after {
            background: #00addf;
            border-radius: 50%;
            bottom: .5em;
            display: block;
            content: '';
            height: .5em;
            left: 50%;
            margin: -.25em 0 0 -.25em;
            position: absolute;
            width: .5em;
        }

        .event.current-day:after {
            background: #f9f9f9;
        }

        .btn-prev,
        .btn-next {
            border: 2px solid #cbd1d2;
            border-radius: 50%;
            color: #cbd1d2;
            height: 2em;
            font-size: .75em;
            line-height: 2em;
            margin: -1em;
            position: absolute;
            top: 50%;
            width: 2em;
        }

        .btn-prev:hover,
        .btn-next:hover {
            background: #cbd1d2;
            color: #f9f9f9;
        }

        .btn-prev {
            left: 6em;
        }

        .btn-next {
            right: 6em;
        }
        .between {
            color: var(--koochita-light-green);
        }

        /*bottom button*/
        .bottomBtn {
            width: 100%;
            border-top: 2px solid #aeaeae;
            padding-top: 2%;
            margin-top: 1%;
        }
        .diffrentCalenBtn {
            float: left;
            margin-left: 5%;
            color: var(--koochita-light-green);
            background-color: white; border: none; font-size: 140%;
            border: none;
            font-size: 120%;
        }
        .cancleBtn {
            float: right;
            margin-right: 5%;
            color: #92321b;
            background-color: white;
            border: none;
            font-size: 120%;
        }

        .ticketIcon {
            font-family: shazde_regular2 !important;
            display: inline-block;
        }
        .rightArrowIcone:before {
            content: '\E047';
            color: var(--koochita-light-green);
            font-size: 2.5em;
            position: absolute;
            top: 4px;
        }
        .leftArrowIcone:before {
            content: '\E04D ';
            color: var(--koochita-light-green);
            font-size: 2.5em;
            position: absolute;
            top: 4px;
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

        .classTypePane {
            cursor: pointer;
        }

        .classTypePane:hover {
            border-bottom: 1px solid var(--koochita-light-green);
        }
    </style>



</head>

<body id="BODY_BLOCK_JQUERY_REFLOW"
      class=" r_map_position_ul_fake ltr domn_en_US lang_en long_prices globalNav2011_reset rebrand_2017 css_commerce_buttons flat_buttons sitewide xo_pin_user_review_to_top track_back">

<div id="PAGE" class="filtersearch redesign_2015 non_hotels_like desktop scopedSearch">
    @include('layouts.placeHeader')

    <div class="main-container">
        <div class="container-fluid">
            <div class="row set-center">
                <div class="col-md-6 set-center">
                    <h2 style="font-size: 3em; font-weight: 900;">{{$src[0]}} به {{$dest[0]}}</h2>
                </div>
            </div>

            {{--edit search--}}
            <div id="search" class="row" style="margin-top: 10px;">
                <div style="width: 92%; margin: 0 auto">
                    <div style="width: 14%; display: inline-block;">
                        <button class="editSearchButtton" onclick="editTicketGo(0)">جستجو</button>
                    </div>
                    <div class="editSearchBox">
                        <div class="editSearchClassBox">
                            <div id="flightClass" style="float: right; cursor: pointer;" onclick="toggleClassNoSelectPane()"> {{$additional}} </div>
                            <div id="classArrowDown" onclick="toggleClassNoSelectPane()" class="shTIcon searchBottomArrowIcone bottomArrowClassIcone" style="display: inline-block;"></div>
                            <div id="classArrowUp" onclick="toggleClassNoSelectPane()" class="shTIcon searchTopArrowIcone bottomArrowClassIcone hidden" style="display: inline-block;"></div>

                            <div class="class_passengerPane item hidden" id="classNoSelectPane" onmouseleave="addClassHidden('classNoSelectPane'); classNoSelect = false;">
                                <div class="classTypePane" onclick="changeClass(1)" style="height: 25px"> اکونومی </div>
                                <div class="classTypePane" onclick="changeClass(2)" style="height: 25px"> فرست کلاس </div>
                                <div class="classTypePane" onclick="changeClass(3)" style="height: 25px"> بیزینس </div>
                            </div>
                        </div>

                        <div class="editSearchPassengerBox">
                            <div id="searchAge" style="font-size: 1.1em; display: inline-block; cursor: pointer;" onclick="togglePassengerNoSelectPane()">
                                <span style="float: right;">{{$adult}}</span>&nbsp;
                                <span>بزرگسال</span>&nbsp;-&nbsp;
                                <span>{{$child}}</span>
                                <span>کودک</span>&nbsp;-&nbsp;
                                <span>{{$infant}}</span>
                                <span>نوزاد</span>&nbsp;
                            </div>
                            <div class="shTIcon passengerIcon" style="font-size: 25px; display: inline-block; cursor: pointer;" onclick="togglePassengerNoSelectPane()"></div>
                            <div id="passengerArrowDown" onclick="togglePassengerNoSelectPane()" class="shTIcon searchBottomArrowIcone bottomArrowPassengerIcone" style="display: inline-block;"></div>
                            <div id="passengerArrowUp" onclick="togglePassengerNoSelectPane()" class="shTIcon searchTopArrowIcone bottomArrowPassengerIcone hidden" style="display: inline-block;"></div>


                            <div class="class_passengerPane item hidden " id="passengerNoSelectPane" onmouseleave="addClassHidden('passengerNoSelectPane'); passengerNoSelect = false;">
                                <div style="height: 25px">
                                    <span style="float: right;">بزرگسال
                                        {{--<span style="margin: 10px; font-size: 60%;color: #00AF87" id="adultNoSpan"></span>--}}
                                    </span>
                                    <div style="float: left; margin-right: 25px;">
                                        <div onclick="changePassengersNo(-1, 3, 'flight')" class="minusPlusBtn" style="background-position: -18px -6px;"></div>
                                        <span class='numBetweenMinusPlusBtn' id="adultPassengerNoInSelect">{{$adult}}</span>
                                        <div onclick="changePassengersNo(1, 3, 'flight')" class="minusPlusBtn" style="background-position: -1px -6px;"></div>
                                    </div>
                                </div>
                                <div style="height: 25px">
                                    <span style="float: right;">کودک
                                        {{--<span style="margin: 10px; font-size: 60%;color: #00AF87" id="childNoSpan"></span>--}}
                                    </span>
                                    <div style="float: left">
                                        <div onclick="changePassengersNo(-1, 2, 'flight')" class="minusPlusBtn" style="background-position: -18px -6px;"></div>
                                        <span class='numBetweenMinusPlusBtn' id="childPassengerNoInSelect">{{$child}}</span>
                                        <div onclick="changePassengersNo(1, 2, 'flight')" class="minusPlusBtn" style="background-position: -1px -6px;"></div>
                                    </div>
                                </div>
                                <div style="height: 25px">
                                    <span style="float: right;">نوزاد
                                        {{--<span style="margin: 10px; font-size: 60%;color: #00AF87" id="infantNoSpan"></span>--}}
                                    </span>
                                    <div style="float: left">
                                        <div onclick="changePassengersNo(-1, 1, 'flight')" class="minusPlusBtn" style="background-position: -18px -6px;"></div>
                                        <span class='numBetweenMinusPlusBtn' id="infantPassengerNoInSelect">{{$infant}}</span>
                                        <div onclick="changePassengersNo(1, 1, 'flight')" class="minusPlusBtn" style="background-position: -1px -6px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="editSearchCalenderBox">
                            <label id="calendar-container-edit-1placeDate" class="dateLabel">
                                <span class="ui_icon calendar" style="color: #30b4a6 !important; font-size: 22px; line-height: 32px; right: -75%; top: -4px;"></span>
                                <input name="date" id="goDate" type="text" class="inputDateLabel" placeholder="تاریخ رفت"  onclick="nowCalendar()" required readonly>
                            </label>
                            @if($eDate[0] != '')
                            <label id="calendar-container-edit-2placeDate" class="dateLabel" style="margin-right: 14px !important;">
                                <div class="shTIcon calendarIcone editSearchCalenderIcon"></div>
                                <input name="date" id="backDate" type="text"  class="inputDateLabel" placeholder="تاریخ برگشت" required readonly>
                            </label>
                                @endif
                        </div>

                        <div class="editSearchDestBox" style="right: 20%;">
                            <div class="shTIcon locationIcon" style="float: right; font-size: 25px;"></div>
                            <input class="inputCityName" id="destCitySearch" onkeyup="searchForCity(event, 'destCitySearch', 'resultDestSearch')" placeholder="شهر مقصد">
                            <div id="resultDestSearch" class="data_holder" style="z-index: 10000; position: relative; background-color: #aeaeae; max-height: 160px; overflow: auto;"></div>
                        </div>

                        <div class="editSearchDestBox" style="right: 0%;">
                            <div class="shTIcon locationIcon" style="float: right; font-size: 25px;"></div>
                            <input class="inputCityName" id="srcCitySearch" onkeyup="searchForCity(event, 'srcCitySearch', 'resultSrcSearch')" placeholder="شهر مبدا">
                            <div id="resultSrcSearch" class="data_holder" style="z-index: 10000; position: relative; background-color: #aeaeae; max-height: 160px; overflow: auto; text-align: right"></div>
                        </div>
                    </div>
                </div>
            </div>
            {{--search--}}
            {{--<div id="showInformTicket" class="row">--}}
                {{--<div style="width: 45%; margin: 10px auto 0">--}}
                    {{--<div class="search-fields-box">--}}
                        {{--<button class="search-fields-but" onclick="openEditTicket()">ویرایش جست‌جو</button>--}}
                        {{--<div style="display: inline-block">{{$additional}}</div>--}}
                    {{--</div>--}}
                    {{--<div class="search-fields-box" style="border-left:1px solid gray; border-right:1px solid gray;">--}}
                        {{--<div style="display: inline-block"> بزرگسال {{$adult}} - کودک {{$child}} - نوزاد {{$infant}}</div>--}}
                        {{--<div class="shTIcon passengerIcon" style="display: inline-block"></div>--}}
                    {{--</div>--}}
                    {{--<div class="search-fields-box" style="direction: rtl;">--}}
                        {{--<div class="shTIcon calendarIcone" style="display: inline-block"></div>--}}
                        {{--<div id="goDate1" style="display: inline-block;"> </div>--}}
                        {{--<div id="backDate1" style="display: inline-block;">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="row set-center">
                <div class="col-md-11" style="border-top: solid 2px #aeaeae; margin-top: 15px;"></div>
            </div>

            <div class="row set-center " style="margin-top: 10px;">
                <div class="col-md-12">
                    <div class="col-md-2" style="border-right: solid 2px #aeaeae;">
                        <h6 style="color: #9f3322; margin-left: 26%; margin-top: 10px; font-weight: 900;">نمایش قیمت در هفته</h6>
                        <div style=" width:85%; float: right; border-top: solid 2px #aeaeae; margin-top: 10px;"></div>
                        {{--<img src="{{URL::asset('images').'/bad.svg'}}"--}}
                        {{--style="margin-left: 88px; width: 50px; height: 50px; margin-bottom: 10px; margin-top: 10px;">--}}
                        <div id="fill" style="display: none; height: 60px;"></div>
                        <div id="prevDay" class="shTIcon" onclick="prevDay()"></div>
                        <div class="left_bar_background">
                            <div id="dayBar" class="left_bar">

                            </div>
                        </div>
                        <div id="nextDay" class="shTIcon fillArrowBottomIcon" onclick="nextDay()"></div>
                        {{--<img src="{{URL::asset('images').'/bad.svg'}}"--}}
                        {{--style="margin-left: 88px; width: 50px; height: 50px; margin-bottom: 10px; margin-top: 10px; transform: rotate(180deg)">--}}


                    </div>
                    <div class="col-md-7 ">
                        <div class="row" style="padding: 10px; padding-top: 0px;">
                            <div class="col-md-12">
                                <div class="col-md-9" style="padding-top: 10px;">
                                    <div class="col-md-6 set-center dropdown" style="color: #050c93; direction: rtl;">
                                        <h6> زمان : </h6>
                                        <h6 id="sortTime" style="margin-right: 5px;"></h6>
                                        <div class="class_changeTime dropdown-content">
                                            <div class="changeTypeTime" onclick="sortTicket(2, 0)"> نزدیک ترین زمان خروج </div>
                                            <div class="changeTypeTime" style="margin: 5px 0" onclick="sortTicket(3, 0)"> نزدیک ترین زمان ورود </div>
                                            {{--<div class="changeTypeTime" onclick="sortTicket(3)"> کمترین زمان توقف </div>--}}
                                        </div>
                                        <div class="shTIcon bottomArrowIcon" id="changeTime"></div>
                                    </div>

                                    {{--@if($mode != "internalFlight")--}}
                                        {{--<div id="shortestTime" class="col-md-3 set-center selected-filter "--}}
                                             {{--onclick="addSelected('shortestTime')">--}}
                                            {{--<h6>کوتاه‌ترین مدت</h6>--}}
                                            {{--<div class="filter-underline"></div>--}}
                                        {{--</div>--}}
                                    {{--@else--}}
                                        {{--<div class="col-md-3 set-center selected-filter "></div>--}}
                                    {{--@endif--}}

                                    <div id="lessMoney" class="col-md-6 set-center selected-filter"
                                         onclick="sortTicket(1, 0)">
                                        <h6>ارزانترین قیمت</h6>
                                        <div id="lessMoneyUnderLine" class="filter-underline"></div>
                                    </div>

                                    {{--@if($mode != "internalFlight")--}}
                                        {{--<div class="col-md-3 set-center selected-filter">--}}
                                            {{--<h6>بهترین قیمت</h6>--}}
                                            {{--<div class="filter-underline"></div>--}}
                                        {{--</div>--}}
                                    {{--@else--}}
                                        {{--<div class="col-md-3 set-center selected-filter "></div>--}}
                                    {{--@endif--}}
                                </div>
                                <div class="col-md-3" style="text-align: right; padding-top: 10px">
                                    <h5 style="font-weight: 900;">مرتب سازی بر اساس </h5>
                                </div>
                            </div>
                            <div style=" width:100%; border-top: solid 2px #aeaeae; margin-top: 5px; margin-bottom: 25px;"></div>
                            @if($back == 1 && $ticketGo != '')
                                <div id="middle" class="col-md-12">
                                    <div class="boxTicket" style="background-color: white !important;">
                                        <div class="row" style="height: 165px;">
                                            <div class="col-md-3 "
                                                 style="margin-top: 10px; border-right: solid 2px #aeaeae; padding-left: 25px; margin-bottom: 10px; max-width: 25%; !important; text-align: center">
                                                <img style="background-color: #2d3e52" src="{{URL::asset('images/blitbin.png')}}" alt="لوگو علی بابا" class="offerImg">
                                                <div style="color: #92321b">
                                                    <h6 id="totalNumber" style="display: inline-block"></h6>
                                                    <h5 id="totalMoneyGo" style="display: inline-block">مجموع 1.950.000</h5>
                                                </div>
                                                <div onclick="changeGOTicket(1)">
                                                    <h6 style="color: #92321b; margin-top: 10px; text-align: left; position: absolute; bottom: 0;">ویرایش</h6>
                                                </div>
                                            </div>
                                            <div class="col-md-6 set-center" style="max-width: 50%; !important;">
                                                <div style="width: 98%; height: 35%; margin: 5px; position: absolute; right: 0%; top: 30%;">
                                                    <div class="explainPurpose" style="left: 0%">
                                                        <div> مقصد</div>
                                                        <div style="width: 15px;height: 15px;border-radius: 50%;background-color: gray; margin: 0 auto"></div>
                                                        <div id="arrTicketGo"></div>
                                                    </div>
                                                    <div class="explainFlight">
                                                        <div id="timeFlightGo"
                                                             style="position: absolute; right: 45%; top: 20%;"></div>
                                                        <div style="width: 100%;border: 0.8px solid gray; position: absolute; top: 49%;"></div>
                                                        <div class="shTIcon leftArrowIcon"></div>
                                                    </div>
                                                    <div class="explainPurpose" style="right: 0">
                                                        <div> مبدأ</div>
                                                        <div style="width: 15px;height: 15px;border-radius: 50%;background-color: gray; margin: 0 auto"></div>
                                                        <div id="goTicketGo"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 set-center"
                                                 style="text-align:center;height: auto; border-left: solid 2px #aeaeae; margin-bottom: 10px;margin-top: 10px; ">
                                                <div style="color: #92321b; position: absolute; top: 0; right: 15%; font-size: 140%;"> پرواز رفت </div>

                                                <div style="width: 100%; height: 40%; position: absolute; top: 30%;">
                                                    <div class="airlinesImage"><img src="{{$ticketGo->lineLogo}}" style="width: 100%"></div>
                                                    <div class="airlinesText">{{$ticketGo->line}}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="myModal" class="modal-content">
                                            <div class="col-md-12"
                                                 style="width: 100%; border-bottom: solid 0.8px gray;">
                                                <div class="col-md-3 set-center selected-filter"
                                                     style="float: right; padding-right: 0; width: 15%;">
                                                    <h6>جزییات پرواز</h6>
                                                </div>
                                                <div class="col-md-3 set-center selected-filter"
                                                     style="width: 10%; padding-right: 0; float: right;">
                                                    <h6>قیمت</h6>
                                                </div>
                                                <div id="shortestTime" class="col-md-3 set-center selected-filter "
                                                     onclick="addSelected('shortestTime')"
                                                     style="float: right; width: 20%; padding-right: 0;">
                                                    <h6>نقدها و نظرات</h6>
                                                </div>
                                                <div id="modal" style="width: 30px; display: inline-block;">close</div>
                                            </div>
                                            <div style="margin-top: 30px;">
                                                <div style="width: 40%; display: inline-block; float: right; border-left: solid 0.8px gray; padding: 10px;">
                                                    right
                                                </div>
                                                <div style="width: 60%; display: inline-block; padding: 10px;">
                                                    left
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($eDate[0] != '' && $back == 1)
                                <div class="choiceFlight"> لطفا پرواز برگشت را انتخاب کنید</div>
                            @else
                                <div class="choiceFlight"> لطفا پرواز رفت را انتخاب کنید</div>
                            @endif
                            <div id="ticketPlace" style="width: 100%;">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3" style="padding-right: 3%; border-left: solid 2px #aeaeae;">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12" style="text-align: right; height: 28px;">
                                    <h6 style="color: #9f3322; line-height: 40px; font-weight: 900">جستجو خود را محدود‌تر کنید</h6>
                                </div>

                                <div style=" width:100%; border-top: solid 2px #aeaeae; margin-top: 15px;"></div>

                                <div style=" width:100%; margin-top: 15px;">
                                    <div class="blitTabligh"></div>
                                </div>

                                <div id="filters_tab" style="width: 100%;">
                                    <div style="width: 100%; height: 25px; margin-top: 10px;">
                                        <div style="font-size: 1.4em; float: right; color: var(--koochita-light-green);"> فیلتر اعمال شده
                                        </div>
                                        <div style="font-size: 1.4em; float: left; direction: rtl;"><span id="filterTicket"> 0</span> <span>مورد از </span> <span id="totalTicket">  </span>
                                        </div>
                                    </div>
                                    <div style="font-size: 0.9em; float: right; color: #050c93; cursor: pointer;" onclick="closeAll()"> پاک کردن همه فیلتر ها</div>
                                    <div style="clear:both;"></div>
                                    <div>
                                        <div id="flightTime" class="filterBox" style="display: none;">
                                            <div style="float: right"> زمان پرواز</div>
                                            <div class="shTIcon clsIcon" style="float: left; color: white; margin-right: 15px;" onclick="closeFilter(1)"></div>
                                        </div>
                                        <div id="dayTime" class="filterBox" style="display: none;">
                                            <div style="float: right"> پرواز در طول شب یا روز</div>
                                            <div class="shTIcon clsIcon" style="float: left; color: white; margin-right: 15px;" onclick="closeFilter(2)"></div>
                                        </div>
                                        <div id="flightKind" class="filterBox" style="display: none;">
                                            <div style="float: right"> نوع پرواز</div>
                                            <div class="shTIcon clsIcon" style="float: left; color: white; margin-right: 15px;" onclick="closeFilter(3)"></div>
                                        </div>
                                        <div id="flightCompany" class="filterBox" style="display: none;">
                                            <div style="float: right"> شرکت هواپیمایی</div>
                                            <div class="shTIcon clsIcon" style="float: left; color: white; margin-right: 15px;" onclick="closeFilter(4)"></div>
                                        </div>

                                    </div>
                                </div>

                                <div style=" width:100%; border-top: solid 2px #aeaeae; margin-top: 15px;"></div>

                                <div style="width: 100%">
                                    <div style="text-align: right; cursor: pointer; padding-right: 15px"
                                         onclick="closeFilterTab(0)">
                                        <h6 style="position: relative; color: #9f3322; display: inline-block; margin-top: 10px">
                                            زمان پرواز
                                            <div class="shTIcon bottomArrowIcon"></div>
                                        </h6>
                                    </div>
                                    <div id="timeFilterTab1">
                                        <div class="col-md-12" style="margin-top: 15px;">
                                            <h6 style="text-align: right; margin-top: 0px;"><span
                                                        style="font-size: 0.9em; color: #92321b">(</span>ساعت خروج <span
                                                        style="font-size: 0.9em; color: #92321b">(</span><span
                                                        style="font-size: 0.9em; color: #92321b">رفت</span></h6>
                                            <!-- Ranger Slider with value -->

                                            <!-- Slider -->
                                            <div id="pmd-slider-value-range" class="pmd-range-slider"
                                                 style="margin-top: 20px;"></div>

                                            <!-- Values -->
                                            <div class="row" style="margin-top: 15px;">
                                                <div class="range-value col-sm-6">
                                                    <span id="value-min"></span>
                                                </div>
                                                <div class="range-value col-sm-6 text-right">
                                                    <span id="value-max"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <h6 style="text-align: right; margin-top: 15px; margin-bottom: 0px;"><span
                                                        style="font-size: 0.9em; color: #92321b">(</span>ساعت ورود <span
                                                        style="font-size: 0.9em; color: #92321b">(</span><span
                                                        style="font-size: 0.9em; color: #92321b">رفت</span></h6>
                                            <!-- Ranger Slider with value -->

                                            <!-- Slider -->
                                            <div id="pmd-slider-value-range2" class="pmd-range-slider"
                                                 style="margin-top: 20px;"></div>

                                            <!-- Values -->
                                            <div class="row">
                                                <div class="range-value col-sm-6">
                                                    <span id="value-min-2"></span>
                                                </div>
                                                <div class="range-value col-sm-6 text-right">
                                                    <span id="value-max-2"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--فیلتر زمان برگشت--}}
                                {{--<div style=" width:100%; border-top: solid 2px #aeaeae; margin-top: 15px;"></div>--}}
                                {{--<div class="col-md-12" style="margin-top: 15px;">--}}
                                {{--<h6 style="text-align: right;"><span--}}
                                {{--style="font-size: 0.9em; color: #92321b">(</span>ساعت خروج <span--}}
                                {{--style="font-size: 0.9em; color: #92321b">(</span><span--}}
                                {{--style="font-size: 0.9em; color: #92321b">برگشت</span></h6>--}}
                                {{--<!-- Ranger Slider with value -->--}}

                                {{--<!-- Slider -->--}}
                                {{--<div id="pmd-slider-value-range3" class="pmd-range-slider"--}}
                                {{--style="margin-top: 20px;"></div>--}}

                                {{--<!-- Values -->--}}
                                {{--<div class="row" style="margin-top: 15px;">--}}
                                {{--<div class="range-value col-sm-6">--}}
                                {{--<span id="value-min-3"></span>--}}
                                {{--</div>--}}
                                {{--<div class="range-value col-sm-6 text-right">--}}
                                {{--<span id="value-max-3"></span>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-12">--}}
                                {{--<h6 style="text-align: right; margin-top: 15px; margin-bottom: 0px;"><span--}}
                                {{--style="font-size: 0.9em; color: #92321b">(</span>ساعت ورود <span--}}
                                {{--style="font-size: 0.9em; color: #92321b">(</span><span--}}
                                {{--style="font-size: 0.9em; color: #92321b">برگشت</span></h6>--}}
                                {{--<!-- Ranger Slider with value -->--}}

                                {{--<!-- Slider -->--}}
                                {{--<div id="pmd-slider-value-range4" class="pmd-range-slider"--}}
                                {{--style="margin-top: 20px;"></div>--}}

                                {{--<!-- Values -->--}}
                                {{--<div class="row">--}}
                                {{--<div class="range-value col-sm-6">--}}
                                {{--<span id="value-min-4"></span>--}}
                                {{--</div>--}}
                                {{--<div class="range-value col-sm-6 text-right">--}}
                                {{--<span id="value-max-4"></span>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                <div id="timeFilterTab2" style="width: 100%;">
                                    <div style=" width:100%; border-top: solid 2px #aeaeae; margin-top: 15px;"></div>

                                    <div style="width: 100%; margin-top: 20px">
                                        <div id="nightBase" class="dayNight" style="color:#555555 ;"
                                             onclick="dayTimeFilter(1)">
                                            <div class="shTIcon" id="night"
                                                 style="font-size: 30px; margin-bottom: 10px;"></div>
                                            <div class="dayNightText"> شب</div>
                                        </div>
                                        <div id="afternoonBase" class="dayNight" style="color:#555555 ;"
                                             onclick="dayTimeFilter(2)">
                                            <div class="shTIcon" id="afternoon" style="font-size: 40px"></div>
                                            <div class="dayNightText"> عصر</div>
                                        </div>
                                        <div id="noonBase" class="dayNight" style="color:#555555 ;"
                                             onclick="dayTimeFilter(3)">
                                            <div class="shTIcon" id="noon" style="font-size: 40px"></div>
                                            <div class="dayNightText"> ظهر</div>
                                        </div>
                                        <div id="morningBase" class="dayNight" style="color:#555555 ;"
                                             onclick="dayTimeFilter(4)">
                                            <div class="shTIcon" id="morning" style="font-size: 40px"></div>
                                            <div class="dayNightText"> صبح</div>
                                        </div>
                                    </div>
                                    <div class="check-box__item hint-system"
                                         style="text-align: right; width: 100%; margin: 10px 15px 0 0;">
                                        <label class="labelEdit" style="width: 30% !important;">پرواز در طول شب</label>
                                        <input type="checkbox" id="nightFlight" name="fltNight" value="پرواز در طول شب"
                                               style="display: inline-block; !important;"
                                               onclick="dayTimeFilter(5)">
                                    </div>
                                </div>

                                <div style="width:100%; border-top: solid 2px #aeaeae; margin-top: 15px;"></div>

                                {{--<div class="col-md-12">--}}
                                {{--<h6 style="color: #9f3322; text-align: right; margin-top: 10px;">قیمت</h6>--}}
                                {{--<!-- Ranger Slider with value -->--}}

                                {{--<!-- Slider -->--}}
                                {{--<div id="pmd-slider-value-range5" class="pmd-range-slider"--}}
                                {{--style="color: var(--koochita-light-green)!important;"></div>--}}

                                {{--<!-- Values -->--}}
                                {{--<div class="row">--}}
                                {{--<div class="range-value col-sm-6">--}}
                                {{--<span id="value-min-5"></span>--}}
                                {{--</div>--}}
                                {{--<div class="range-value col-sm-6 text-right">--}}
                                {{--<span id="value-max-5"></span>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--<div style="width:100%; border-top: solid 2px #aeaeae; margin-top: 15px;"></div>--}}

                                {{--//توقف--}}
                                {{--<div class="col-md-12">--}}
                                {{--<div style="position: relative">--}}
                                {{--<h6 style="color: #9f3322; text-align: right; margin-top: 10px;">توقف</h6>--}}
                                {{--<div class="shTIcon bottomArrowIcon" id="stopFlight"></div>--}}
                                {{--</div>--}}
                                {{--<div class="check-box__item hint-system" style="text-align: right;">--}}
                                {{--<label class="labelEdit">بدون توقف</label>--}}
                                {{--<input type="checkbox" id="non_stop" name="nonStop" value="بدون توقف"--}}
                                {{--style="display: inline-block; !important;">--}}
                                {{--</div>--}}
                                {{--<div class="check-box__item hint-system" style="text-align: right;">--}}
                                {{--<label class="labelEdit">یک توقف</label>--}}
                                {{--<input type="checkbox" id="one_stop" name="oneStop" value="یک توقف"--}}
                                {{--style="display: inline-block; !important;">--}}
                                {{--</div>--}}
                                {{--</div>--}}

                                {{--<div style=" width:100%; border-top: solid 2px #aeaeae; margin-top: 15px;"></div>--}}

                                <div class="col-md-12">
                                    <div style="text-align: right; cursor: pointer" onclick="closeFilterTab(1)">
                                        <h6 style="position: relative; color: #9f3322;  display: inline-block; margin-top: 10px;">
                                            نوع پرواز
                                            <div class="shTIcon bottomArrowIcon"></div>
                                        </h6>
                                    </div>
                                    <div id="kindFlightTab">
                                        <div class="check-box__item hint-system" style="text-align: right;">
                                            <label class="labelEdit">سیستمی</label>
                                            <input type="checkbox" id="systemi" name="system" value="سیستمی" style="display: inline-block; !important;" onclick="systemFilterFunc(1)">
                                        </div>
                                        <div class="check-box__item hint-system" style="text-align: right;">
                                            <label class="labelEdit">چارتر</label>
                                            <input type="checkbox" id="charteri" name="charter" value="چارتر" style="display: inline-block; !important;" onclick="systemFilterFunc(2)">
                                        </div>
                                    </div>
                                </div>

                                <div style=" width:100%; border-top: solid 2px #aeaeae; margin-top: 15px;"></div>

                                <div class="col-md-12">
                                    <div style="text-align: right; cursor: pointer" onclick="closeFilterTab(2)">
                                        <h6 style="position: relative; color: #9f3322;  display: inline-block; margin-top: 10px;">
                                            شرکت هواپیمایی
                                            <div class="shTIcon bottomArrowIcon"></div>
                                        </h6>
                                    </div>
                                    <div class="shTIcon" id="companyFlight" style="font-size: 10px;"></div>
                                </div>

                                <div style=" width:100%; border-top: solid 2px #aeaeae; margin-top: 15px;"></div>

                                {{--کلاس پرواز--}}
                                {{--<div class="col-md-12">--}}
                                {{--<div style="position: relative">--}}
                                {{--<h6 style="color: #9f3322; text-align: right; margin-top: 10px;">کلاس پرواز</h6>--}}
                                {{--<div class="shTIcon bottomArrowIcon" id="classFlight"></div>--}}
                                {{--</div>--}}
                                {{--<div class="check-box__item hint-system" style="text-align: right;">--}}
                                {{--<label class="labelEdit">فرست کلاس</label>--}}
                                {{--<input type="checkbox" id="fClass" name="fClass" value="فرست کلاس"--}}
                                {{--style="display: inline-block; !important;">--}}
                                {{--</div>--}}
                                {{--<div class="check-box__item hint-system" style="text-align: right;">--}}
                                {{--<label class="labelEdit">بیزینس</label>--}}
                                {{--<input type="checkbox" id="business" name="business" value="بیزینس"--}}
                                {{--style="display: inline-block; !important;">--}}
                                {{--</div>--}}
                                {{--<div class="check-box__item hint-system" style="text-align: right;">--}}
                                {{--<label class="labelEdit">اکونومی</label>--}}
                                {{--<input type="checkbox" id="economy" name="economy" value="اکونومی"--}}
                                {{--style="display: inline-block; !important;">--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--<div style=" width:100%; border-top: solid 2px #aeaeae; margin-top: 15px;"></div>--}}


                                {{--مدت پرواز--}}
                                {{--<div class="col-md-12">--}}
                                {{--<div style="position: relative">--}}
                                {{--<h6 style="color: #9f3322; text-align: right; margin-top: 10px;">مدت پرواز</h6>--}}
                                {{--<div class="shTIcon bottomArrowIcon" id="periodFlight"></div>--}}
                                {{--</div>--}}
                                {{--<!-- Ranger Slider with value -->--}}

                                {{--<!-- Slider -->--}}
                                {{--<div id="pmd-slider-value-range6" class="pmd-range-slider"--}}
                                {{--style="margin-top: 25px !important; color: var(--koochita-light-green)!important;"></div>--}}

                                {{--<!-- Values -->--}}
                                {{--<div class="row">--}}
                                {{--<div class="range-value col-sm-6">--}}
                                {{--<span id="value-min-6"></span>--}}
                                {{--</div>--}}
                                {{--<div class="range-value col-sm-6 text-right">--}}
                                {{--<span id="value-max-6"></span>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}

                                <div style="height: 200px;"></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Slider js -->
    <script src="https://propeller.in/components/range-slider/js/wNumb.js"></script>
    <script src="https://propeller.in/components/range-slider/js/nouislider.js"></script>

    <script>
        // multiple handled with value
        var pmdSliderValueRange = document.getElementById('pmd-slider-value-range');
        noUiSlider.create(pmdSliderValueRange, {
            start: [20, 80], // Handle start position
            connect: true, // Display a colored bar between the handles
            tooltips: [wNumb({decimals: 0}), wNumb({decimals: 0})],
            format: wNumb({
                decimals: 0,
                thousand: '',
                postfix: '',
            }),
            range: {
                'min': 0,
                'max': 144// 144 تا 10 دقیقه برای 24 ساعت
            }
        });
        var firstTime = 0;
        var valueMax = document.getElementById('value-max'),
            valueMin = document.getElementById('value-min');
        var min, hour;
        // When the slider value changes, update the input and span
        pmdSliderValueRange.noUiSlider.on('update', function (values, handle) {
            hour = values[handle] / 6;
            hour = Math.floor(hour);
            min = values[handle] % 6;
            min = Math.floor(min) * 10;
            if (handle) {
                valueMax.innerHTML = hour + ":" + min;
                if (firstTime == 1) {
                    TimeFilter = true;
                    getFilter();
                }
            } else {
                valueMin.innerHTML = hour + ":" + min;
                if (firstTime == 1) {
                    TimeFilter = true;
                    getFilter();
                }
            }
        });
    </script>

    <script>
        // multiple handled with value
        var pmdSliderValueRange = document.getElementById('pmd-slider-value-range2');
        noUiSlider.create(pmdSliderValueRange, {
            start: [20, 80], // Handle start position
            connect: true, // Display a colored bar between the handles
            tooltips: [wNumb({decimals: 0}), wNumb({decimals: 0})],
            format: wNumb({
                decimals: 0,
                thousand: '',
                postfix: '',
            }),
            range: {
                'min': 0,
                'max': 144// 144 تا 10 دقیقه برای 24 ساعت
            }
        });
        var valueMax2 = document.getElementById('value-max-2'),
            valueMin2 = document.getElementById('value-min-2');
        var min2, hour2;
        // When the slider value changes, update the input and span
        pmdSliderValueRange.noUiSlider.on('update', function (values, handle) {
            hour2 = values[handle] / 6;
            hour2 = Math.floor(hour2);
            min2 = values[handle] % 6;
            min2 = Math.floor(min2) * 10;
            if (handle) {
                valueMax2.innerHTML = hour2 + ":" + min2;
                if (firstTime == 1) {
                    TimeFilter = true;
                    getFilter();
                }
            } else {
                valueMin2.innerHTML = hour2 + ":" + min2;
                if (firstTime == 1) {
                    TimeFilter = true;
                    getFilter();
                }
            }
        });
        // $('#pmd-slider-value-range').ready(function () {
        //     $('#pmd-slider-value-range').css('color','#ffff');
        // });
    </script>

    <script>
        // multiple handled with value
        var pmdSliderValueRange = document.getElementById('pmd-slider-value-range3');
        noUiSlider.create(pmdSliderValueRange, {
            start: [20, 80], // Handle start position
            connect: true, // Display a colored bar between the handles
            tooltips: [wNumb({decimals: 0}), wNumb({decimals: 0})],
            format: wNumb({
                decimals: 0,
                thousand: '',
                postfix: '',
            }),
            range: {
                'min': 0,
                'max': 144// 144 تا 10 دقیقه برای 24 ساعت
            }
        });
        var valueMax3 = document.getElementById('value-max-3'),
            valueMin3 = document.getElementById('value-min-3');
        var min3, hour3;
        // When the slider value changes, update the input and span
        pmdSliderValueRange.noUiSlider.on('update', function (values, handle) {
            hour3 = values[handle] / 6;
            hour3 = Math.floor(hour3);
            min3 = values[handle] % 6;
            min3 = Math.floor(min3) * 10;
            if (handle) {
                valueMax3.innerHTML = hour3 + ":" + min3;
            } else {
                valueMin3.innerHTML = hour3 + ":" + min3;
            }
        });
    </script>

    <script>
        // multiple handled with value
        var pmdSliderValueRange = document.getElementById('pmd-slider-value-range4');
        noUiSlider.create(pmdSliderValueRange, {
            start: [20, 80], // Handle start position
            connect: true, // Display a colored bar between the handles
            tooltips: [wNumb({decimals: 0}), wNumb({decimals: 0})],
            format: wNumb({
                decimals: 0,
                thousand: '',
                postfix: '',
            }),
            range: {
                'min': 0,
                'max': 144// 144 تا 10 دقیقه برای 24 ساعت
            }
        });
        var valueMax4 = document.getElementById('value-max-4'),
            valueMin4 = document.getElementById('value-min-4');
        var min4, hour4;
        // When the slider value changes, update the input and span
        pmdSliderValueRange.noUiSlider.on('update', function (values, handle) {
            hour4 = values[handle] / 6;
            hour4 = Math.floor(hour4);
            min4 = values[handle] % 6;
            min4 = Math.floor(min4) * 10;
            if (handle) {
                valueMax4.innerHTML = hour4 + ":" + min4;
            } else {
                valueMin4.innerHTML = hour4 + ":" + min4;
            }
        });
        // $('#pmd-slider-value-range').ready(function () {
        //     $('#pmd-slider-value-range').css('color','#ffff');
        // });
    </script>

    <script>
        // multiple handled with value
        var pmdSliderValueRange = document.getElementById('pmd-slider-value-range5');
        noUiSlider.create(pmdSliderValueRange, {
            start: [20, 80], // Handle start position
            connect: true, // Display a colored bar between the handles
            tooltips: [wNumb({decimals: 0}), wNumb({decimals: 0})],
            format: wNumb({
                decimals: 0,
                thousand: '',
                postfix: '',
            }),
            range: { // Slider can select '0' to '100'
                'min': 0,
                'max': 100
            }
        });
        var valueMax5 = document.getElementById('value-max-5'),
            valueMin5 = document.getElementById('value-min-5');
        // When the slider value changes, update the input and span
        pmdSliderValueRange.noUiSlider.on('update', function (values, handle) {
            if (handle) {
                valueMax5.innerHTML = values[handle];
            } else {
                valueMin5.innerHTML = values[handle];
            }
        });
        // $('#pmd-slider-value-range').ready(function () {
        //     $('#pmd-slider-value-range').css('color','#ffff');
        // });
    </script>

    <script>
        // multiple handled with value
        var pmdSliderValueRange = document.getElementById('pmd-slider-value-range6');
        noUiSlider.create(pmdSliderValueRange, {
            start: [20, 80], // Handle start position
            connect: true, // Display a colored bar between the handles
            tooltips: [wNumb({decimals: 0}), wNumb({decimals: 0})],
            format: wNumb({
                decimals: 0,
                thousand: '',
                postfix: '',
            }),
            range: {
                'min': 0,
                'max': 144//144 تا 5 دقیقه برای 12 ساعت
            }
        });
        var valueMax6 = document.getElementById('value-max-6'),
            valueMin6 = document.getElementById('value-min-6');
        var min6, hour6;
        // When the slider value changes, update the input and span
        pmdSliderValueRange.noUiSlider.on('update', function (values, handle) {
            hour6 = values[handle] / 12;
            hour6 = Math.floor(hour6);
            min6 = values[handle] % 12;
            min6 = Math.floor(min6) * 5;
            if (handle) {
                valueMax6.innerHTML = hour6 + ":" + min6;
            } else {
                valueMin6.innerHTML = hour6 + ":" + min6;
            }
        });
        // $('#pmd-slider-value-range').ready(function () {
        //     $('#pmd-slider-value-range').css('color','#ffff');
        // });
    </script>

    <script>
        function addSelected(s) {
            var cusid_ele = document.getElementsByClassName('selected-filter');
            for (var i = 0; i < cusid_ele.length; ++i) {
                var item = cusid_ele[i];
                item.removeClass('filter-selected-byclick');
            }
            $("." + s).addClass('filter-selected-byclick');
        }
    </script>


    @include('layouts.footer.layoutFooter')
</div>

@if(!Auth::check())
    @include('layouts.loginPopUp')
@endif

<div class="ui_backdrop dark" style="display: none; z-index: 10000000"></div>

<div id="container1" class="calenderBase">
    <div id="calendarJalali">
        <div id="calendarJalali1" style="display: inline-block; width: 49%;">
            <div class="calendar" style="width: auto; height: auto;">
                <input type="hidden" id="goJalali">
                <header>
                    <select id="select_month_go" onchange="getNewMonth(this.value, 'go')" style="width: 30%; font-size: 95%;"></select>
                    <a class="ticketIcon leftArrowIcone leftInCalender" onclick="nextMonth('go')" href="#"></a>
                    <a class="ticketIcon rightArrowIcone rightInCalender" onclick="prevMonth('go')" href="#"></a>
                </header>
                <table>
                    <thead>
                    <tr style="border-bottom: 1px solid #aeaeae;">
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
        <div id="calendarJalali2" style="display: inline-block; width: 49%; margin-right: 3px; padding-right: 7px; border-right: 1px solid #aeaeae">
            <div class="calendar" style="width: auto; height: auto;">
                <input type="hidden" id="backJalali">
                <header>
                    <select id="select_month_back" onchange="getNewMonth(this.value, 'back')" style="width: 30%; font-size: 95%;"></select>
                    <a class="ticketIcon leftArrowIcone leftInCalender" onclick="nextMonth('back')" href="#"></a>
                    <a class="ticketIcon rightArrowIcone rightInCalender" onclick="prevMonth('back')" href="#"></a>
                </header>
                <table>
                    <thead>
                    <tr style="border-bottom: 1px solid #aeaeae">
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

    <div id="calendarGregorian" style="display: none; direction: ltr;">
        <div id="calendarGregorian1" style="display: inline-block; width: 49%;">
            <div class="calendarGre">
                <header>
                    <input type="hidden" id="goGre">
                    <select id="select_month_gre_go" onchange="getNewMonthGre(this.value, 'go')" style="width: 45%; font-size: 95%;"></select>
                    <a class="ticketIcon leftArrowIcone leftInCalenderGre" onclick="prevMonthGre('go')" href="#"></a>
                    <a class="ticketIcon rightArrowIcone rightInCalenderGre" onclick="nextMonthGre('go')" href="#"></a>
                </header>
                <table>
                    <thead>
                    <tr style="border-bottom: 1px solid #aeaeae">
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
        <div id="calendarGregorian2" style="display: inline-block; width: 49%; margin-left: 3px; padding-left: 7px; border-left: 1px solid #aeaeae">
            <div class="calendarGre">
                <header>
                    <input type="hidden" id="backGre">
                    <select id="select_month_gre_back" onchange="getNewMonthGre(this.value, 'back')" style="width: 45%; font-size: 95%;"></select>
                    <a class="ticketIcon leftArrowIcone leftInCalenderGre" onclick="prevMonthGre('back')" href="#"></a>
                    <a class="ticketIcon rightArrowIcone rightInCalenderGre" onclick="nextMonthGre('back')" href="#"></a>
                </header>
                <table>
                    <thead>
                    <tr style="border-bottom: 1px solid #aeaeae">
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
        <button type="button" class="cancleBtn" onclick="closeCalender()">انصراف</button>
        <button type="button" class="diffrentCalenBtn" onclick="changeDateKind(1)">Gregorian</button>
    </div>
    <div id="GregorianButton" class="bottomBtn" style="display: none">
        <button type="button" class="cancleBtn" onclick="closeCalender()">Cancel</button>
        <button type="button" class="diffrentCalenBtn" onclick="changeDateKind(2)">شمسی</button>
    </div>
</div>

{{--getAlarm--}}
<div id="idGetAlarm" class="hidden"
     style="position: fixed; width: 100%; height: 100%; left: 0; top: 0; background-color: rgba(0,0,0,0.6); z-index: 200;">
<span class="ui_overlay ui_modal editTags getAlarm" style="padding: 10px 10px 1px !important; z-index: 201;">
    <div class="shTIcon clsIcon" style="float: left; color: var(--koochita-light-green); font-size: 2em" onclick="getAlarm(0)"></div>
    <div class="alarmHeaderText"> آیا می خواهید کمترین قیمت ها را به شما اطلاع دهیم </div>
    <div class="alarmSubHeaderText"> هنگامی که قیمت پرواز های </div>
    <div class="ui_column ui_picker alarmBoxCityName">
        <div class="shTIcon locationIcon" style="display: inline-block"></div>
        <input id="fromWarning" class="alarmInputCityName" placeholder="شهر مبدأ"
               onkeyup="searchForCity(event, 'fromWarning', 'resultSrc')" value="{{$src[0]}}-{{$src[1]}}">
        <div id="resultSrc" class="data_holder"
             style="max-height: 160px; overflow: auto;"></div>
    </div>
    <div class="alarmSubHeaderText"> به </div>
    <div class="ui_column ui_picker alarmBoxCityName">
        <div class="shTIcon locationIcon" style="display: inline-block"></div>
        <input id="toWarning" class="alarmInputCityName" placeholder="شهر مقصد"
               onkeyup="searchForCity(event, 'toWarning', 'resultDest')" value="{{$dest[0]}}-{{$dest[1]}}">
        <div id="resultDest" class="data_holder"
             style="max-height: 160px; overflow: auto;"></div>
    </div>
    <div class="alarmSubHeaderText"> کاهش یابد به شما اطلاع دهیم </div>
    <div class="check-box__item hint-system" style="text-align: right; width: 100%; font: 1em; color: #4A4A4A; padding-top: 0 !important;">
        <label class="labelEdit" style="width: 50% !important; font-weight: 100; top: 0 !important; color: #888686"> سایر پیشنهادات را نیز به من اطلاع دهید </label>
        <input type="checkbox" id="otherOffers" name="otherOffer" value="سایر پیشنهادات"
               style="display: inline-block; !important;">
    </div>
    @if(!Auth::check())
        <div class="ui_column ui_picker alarmBoxCityName" style="width: 60% !important; display: inline-block">
        <input id="emailWarning" class="alarmInputCityName" placeholder="آدرس ایمیل خود را وارد کنید">
    </div>
    @endif
    <div style="float: left">
        <button class="btn alarmPopUpBotton" type="button" onclick="getTicketWarning()"> دریافت هشدار </button>
    </div>
    {{--<div onclick="$('#statePane').addClass('hidden'); $('.dark').hide()" class="ui_close_x"></div>--}}
</span>
</div>

{{--visitOffers--}}
<div id="visitOffers" class="hidden"
     style="position: fixed; width: 100%; height: 100%; left: 0; top: 0; background-color: rgba(0,0,0,0.6); z-index: 200;">
<span class="ui_overlay ui_modal editTags visitOffers"
      style="background-color: #ebebeb; padding: 10px 10px 1px !important;">
    <div class="shTIcon clsIcon" style="float: left; color: var(--koochita-light-green); font-size: 2em"
         onclick="document.getElementById('visitOffers').classList.add('hidden')"></div>
    <div class="row set-center" style="margin: 0 5%">
        <div class="col-md-6 set-center">
            <h2 style="font-size: 2.2em; font-weight: 700;">{{$src[0]}} به {{$dest[0]}}</h2>
        </div>
    </div>
    <div class="row">
        <div style="width: 60%; margin: 1% auto 2%">
            <div class="search-fields-box" style="direction: rtl; text-align: left">
                <div class="shTIcon calendarIcon" style="display: inline-block"></div>
                <div id="goDate2" style="display: inline-block;"> {{$sDate[0]}}/{{$sDate[1]}}/{{$sDate[2]}} </div>
                <div id="backDate" style="display: inline-block;">
                    @if($eDate[0] != '')تا
                    {{$eDate[0]}} /{{$eDate[1]}}/{{$eDate[2]}}
                    @endif
                </div>
            </div>
            <div class="search-fields-box" style="border-left:1px solid #aeaeae; border-right:1px solid #aeaeae;">
                <div class="shTIcon passengerIcon" style="display: inline-block"></div>
                <div style="display: inline-block">
                    <span style="float: right;">{{$adult}}</span>&nbsp;
                                <span>بزرگسال</span>&nbsp;-&nbsp;
                                <span>{{$child}}</span>
                                <span>کودک</span>&nbsp;-&nbsp;
                                <span>{{$infant}}</span>
                                <span>نوزاد</span>&nbsp;
                </div>
            </div>
            <div class="search-fields-box" style="text-align: right">
                <div style="display: inline-block">{{$additional}}</div>
                {{--<button class="search-fields-but">ویرایش جست‌جو</button>--}}
            </div>
        </div>
    </div>
    <div style="width: 98%; margin: 0 1% 1%; text-align: justify"> شما ارزان ترین پیشنهادات را انتخاب کرده اید. با توجه به اینکه برای انتخاب ارزان ترین پیشنهاد می بایست پرواز رفت و برگشت را جداگانه خرید کنید حتما ابتدا اطلاعات خود را در دو صفحه وارد کنید و پس از اطمینان از موجود بودن بلیط ، ابتدا پرواز رفت و سپس پرواز برگشت را پرداخت نمایید </div>
    <div style="width: 98%; margin: 0 1%">
        <div class="boxRightVaLetf">
            <div style="margin: 0px 5px 0 0; font-size: 0.8em"> پرواز رفت ( ساعت ها همگی به وقت محلی است. )</div>
            <div id="informVisit" class="rightBoxFlight"> </div>
            <div class="rightBoxFlight">
                <div style="width: 100%; position: relative; height: 30px; padding: 5px 0;">
                    <div style="width: 25%; position: absolute; right: 0">
                        <div style="float: right; color: #92321b;"> هواپیما </div>
                        <div id="informCompany" style="float: left">  </div>
                    </div>
                    <div style="width: 25%; position: absolute; right: 50%; transform: translate(+50%);">
                        <div style="float: right; color: #92321b;"> تاریخ پرواز </div>
                        <div id="informDate" style="float: left"> </div>
                    </div>
                    <div id="informDiffBase" style="width: 25%; position: absolute; left: 0">
                        <div style="float: right;  color: #92321b;"> مدت پرواز </div>
                        <div id="informDiff" style="float: left">  </div>
                    </div>
                </div>
                <div style="width: 100%; display: block; height: 30px; padding: 5px 0;">
                    <div style="width: 25%; float: right;">
                        <div style="float: right; color: #92321b;"> شماره پرواز </div>
                        <div id="informNoTicket" style="float: left"> </div>
                    </div>
                    <div style="width: 62%; float:left; position: relative; margin-left: 2px;">
                        <div style="position: absolute; right: 0; color: #92321b;"> خروج </div>
                        <div id="informSrc" style="position: absolute; right: 12%;">  </div>
                        <div id="informSrcTime"
                             style="position: absolute; right: 50%; transform: translate(+50%)"> </div>
                        <div id="informSrcPort" style="position: absolute; left: 0;">  </div>
                    </div>
                </div>
                <div style="width: 100%; display: block; height: 30px; padding: 5px 0;">
                    <div style="width: 25%; float: right; visibility: hidden;">
                        <div style="float: right; color: #92321b;"> نوع هاپیما </div>
                        <div style="float: left"> Airbus 737 </div>
                    </div>
                    <div style="width: 62%; float:left; position: relative; margin-left: 2px;">
                        <div style="position: absolute; right: 0; color: #92321b;"> ورود </div>
                        <div id="informDest" style="position: absolute; right: 12%;">  </div>
                        <div id="informDestTime"
                             style="position: absolute; right: 50%; transform: translate(+50%)">  </div>
                        <div id="informDestPort" style="position: absolute; left: 0;">  </div>
                    </div>
                </div>
            </div>

            {{--<div class="rightBoxFlight">--}}
            {{--<div style="display: inline-block; color: #92321b"> توقف در شهر مقصد در روز ... در تاریخ </div>--}}
            {{--<div style="float: left;"> مدت توقف 2h00m </div>--}}
            {{--</div>--}}
            {{--<div class="rightBoxFlight"> شهر توقف به شهر مقصد در روز ... در تاریخ </div>--}}
            {{--<div class="rightBoxFlight">--}}
            {{--<div style="width: 100%; position: relative; height: 30px; padding: 5px 0;">--}}
            {{--<div style="width: 25%; position: absolute; right: 0">--}}
            {{--<div style="float: right; color: #92321b;"> هواپیما </div>--}}
            {{--<div style="float: left"> کاسپین </div>--}}
            {{--</div>--}}
            {{--<div style="width: 25%; position: absolute; right: 50%; transform: translate(+50%);">--}}
            {{--<div style="float: right; color: #92321b;"> تاریخ پرواز </div>--}}
            {{--<div style="float: left"> 96/11/25 </div>--}}
            {{--</div>--}}
            {{--<div style="width: 25%; position: absolute; left: 0">--}}
            {{--<div style="float: right;  color: #92321b;"> مدت پرواز </div>--}}
            {{--<div style="float: left"> 2h00m </div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div style="width: 100%; display: block; height: 30px; padding: 5px 0;">--}}
            {{--<div style="width: 25%; float: right;">--}}
            {{--<div style="float: right; color: #92321b;"> شماره پرواز </div>--}}
            {{--<div style="float: left"> wqt34 </div>--}}
            {{--</div>--}}
            {{--<div style="width: 62%; float:left; position: relative; margin-left: 2px;">--}}
            {{--<div style="position: absolute; right: 0; color: #92321b;"> خروج </div>--}}
            {{--<div style="position: absolute; right: 12%;"> از توقف </div>--}}
            {{--<div style="position: absolute; right: 50%; transform: translate(+50%)"> ساعت 8:35 </div>--}}
            {{--<div style="position: absolute; left: 0;"> فرودگاه نوقف </div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div style="width: 100%; display: block; height: 30px; padding: 5px 0;">--}}
            {{--<div style="width: 25%; float: right;">--}}
            {{--<div style="float: right; color: #92321b;"> نوع هاپیما </div>--}}
            {{--<div style="float: left"> Airbus 737 </div>--}}
            {{--</div>--}}
            {{--<div style="width: 62%; float:left; position: relative; margin-left: 2px;">--}}
            {{--<div style="position: absolute; right: 0; color: #92321b;"> ورود </div>--}}
            {{--<div style="position: absolute; right: 12%;"> به مقصد </div>--}}
            {{--<div style="position: absolute; right: 50%; transform: translate(+50%)"> ساعت 10:35 </div>--}}
            {{--<div style="position: absolute; left: 0;"> فرودگاه مقصد </div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div style="margin: 35px 5px 0 0; font-size: 0.8em"> پرواز برگشت ( ساعت ها همگی به وقت محلی است. )</div>--}}
            {{--<div class="rightBoxFlight"> شهر مبدأ به شهر مقصد در روز ... در تاریخ </div>--}}
            {{--<div class="rightBoxFlight">--}}
            {{--<div style="width: 100%; position: relative; height: 30px; padding: 5px 0;">--}}
            {{--<div style="width: 25%; position: absolute; right: 0">--}}
            {{--<div style="float: right; color: #92321b;"> هواپیما </div>--}}
            {{--<div style="float: left"> کاسپین </div>--}}
            {{--</div>--}}
            {{--<div style="width: 25%; position: absolute; right: 50%; transform: translate(+50%);">--}}
            {{--<div style="float: right; color: #92321b;"> تاریخ پرواز </div>--}}
            {{--<div style="float: left"> 96/11/25 </div>--}}
            {{--</div>--}}
            {{--<div style="width: 25%; position: absolute; left: 0">--}}
            {{--<div style="float: right;  color: #92321b;"> مدت پرواز </div>--}}
            {{--<div style="float: left"> 2h00m </div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div style="width: 100%; display: block; height: 30px; padding: 5px 0;">--}}
            {{--<div style="width: 25%; float: right;">--}}
            {{--<div style="float: right; color: #92321b;"> شماره پرواز </div>--}}
            {{--<div style="float: left"> wqt34 </div>--}}
            {{--</div>--}}
            {{--<div style="width: 62%; float:left; position: relative; margin-left: 2px;">--}}
            {{--<div style="position: absolute; right: 0; color: #92321b;"> خروج </div>--}}
            {{--<div style="position: absolute; right: 12%;"> از مبدأ </div>--}}
            {{--<div style="position: absolute; right: 50%; transform: translate(+50%)"> ساعت 8:35 </div>--}}
            {{--<div style="position: absolute; left: 0;"> فرودگاه مبدأ </div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div style="width: 100%; display: block; height: 30px; padding: 5px 0;">--}}
            {{--<div style="width: 25%; float: right;">--}}
            {{--<div style="float: right; color: #92321b;"> نوع هاپیما </div>--}}
            {{--<div style="float: left"> Airbus 737 </div>--}}
            {{--</div>--}}
            {{--<div style="width: 62%; float:left; position: relative; margin-left: 2px;">--}}
            {{--<div style="position: absolute; right: 0; color: #92321b;"> ورود </div>--}}
            {{--<div style="position: absolute; right: 12%;"> به مقصد </div>--}}
            {{--<div style="position: absolute; right: 50%; transform: translate(+50%)"> ساعت 10:35 </div>--}}
            {{--<div style="position: absolute; left: 0;"> فرودگاه مقصد </div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="rightBoxFlight">--}}
            {{--<div style="display: inline-block; color: #92321b"> توقف در شهر مقصد در روز ... در تاریخ </div>--}}
            {{--<div style="float: left;"> مدت توقف 2h00m </div>--}}
            {{--</div>--}}
            {{--<div class="rightBoxFlight"> شهر توقف به شهر مقصد در روز ... در تاریخ </div>--}}
            {{--<div class="rightBoxFlight">--}}
            {{--<div style="width: 100%; position: relative; height: 30px; padding: 5px 0;">--}}
            {{--<div style="width: 25%; position: absolute; right: 0">--}}
            {{--<div style="float: right; color: #92321b;"> هواپیما </div>--}}
            {{--<div style="float: left"> کاسپین </div>--}}
            {{--</div>--}}
            {{--<div style="width: 25%; position: absolute; right: 50%; transform: translate(+50%);">--}}
            {{--<div style="float: right; color: #92321b;"> تاریخ پرواز </div>--}}
            {{--<div style="float: left"> 96/11/25 </div>--}}
            {{--</div>--}}
            {{--<div style="width: 25%; position: absolute; left: 0">--}}
            {{--<div style="float: right;  color: #92321b;"> مدت پرواز </div>--}}
            {{--<div style="float: left"> 2h00m </div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div style="width: 100%; display: block; height: 30px; padding: 5px 0;">--}}
            {{--<div style="width: 25%; float: right;">--}}
            {{--<div style="float: right; color: #92321b;"> شماره پرواز </div>--}}
            {{--<div style="float: left"> wqt34 </div>--}}
            {{--</div>--}}
            {{--<div style="width: 62%; float:left; position: relative; margin-left: 2px;">--}}
            {{--<div style="position: absolute; right: 0; color: #92321b;"> خروج </div>--}}
            {{--<div style="position: absolute; right: 12%;"> از توقف </div>--}}
            {{--<div style="position: absolute; right: 50%; transform: translate(+50%)"> ساعت 8:35 </div>--}}
            {{--<div style="position: absolute; left: 0;"> فرودگاه نوقف </div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div style="width: 100%; display: block; height: 30px; padding: 5px 0;">--}}
            {{--<div style="width: 25%; float: right;">--}}
            {{--<div style="float: right; color: #92321b;"> نوع هاپیما </div>--}}
            {{--<div style="float: left"> Airbus 737 </div>--}}
            {{--</div>--}}
            {{--<div style="width: 62%; float:left; position: relative; margin-left: 2px;">--}}
            {{--<div style="position: absolute; right: 0; color: #92321b;"> ورود </div>--}}
            {{--<div style="position: absolute; right: 12%;"> به مقصد </div>--}}
            {{--<div style="position: absolute; right: 50%; transform: translate(+50%)"> ساعت 10:35 </div>--}}
            {{--<div style="position: absolute; left: 0;"> فرودگاه مقصد </div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
        </div>
        <div class="boxRightVaLetf" style="float: left;">
            <div style="margin: 0px 5px 0 0; font-size: 0.8em"> پیشنهاد های برتر </div>
            <div class="rightBoxFlight">
                <div style="font-size: 1em"> قوانین بلیط، کنسلی و مقررات حمل بار حتما پیش از خرید در سایت موردنطر مطالعه فرمایید </div>
                <div style="font-size: 0.8em;"> با انتخاب هر پیشنهاد از ستون شازده به سایت موردنظر هدایت می شوید </div>
                <div id="informProvider">

                </div>
            </div>
        </div>
    </div>
</span>
</div>

@if($eDate[0] != '')
    <div id="editing"
         style="position: fixed; width: 100%; height: 100%; left: 0; top: 0; background-color: rgba(0,0,0,0.6); z-index: 200; display: none;">

    <span class="ui_overlay ui_modal editTags getAlarm" style="padding: 10px 10px 1px !important; z-index: 201;">
    <div></div>
    <div style="float: left">
        <button class="btn alarmPopUpBotton" type="button" onclick="editTicketGo(1)"> بله </button>
        <button class="btn alarmPopUpBotton" type="button" onclick="changeGOTicket(0)"> خیر </button>
    </div>
        {{--<div onclick="$('#statePane').addClass('hidden'); $('.dark').hide()" class="ui_close_x"></div>--}}
</span>

    </div>
@endif

</body>

<script>

    @if($back == 1 && $ticketGo != '')
        var modal = document.getElementById('myModal');
        var close = document.getElementById('modal');

        close.onclick = function () {
            modal.style.display = "none";
        }
    @endif
</script>

{{--<script>--}}
    {{--function assignDate(from, id, btnId) {--}}
        {{--$("#" + id).css("visibility", "visible");--}}
        {{--if (btnId == "date_input2" && $("#date_input1").val().length != 0)--}}
            {{--from = $("#date_input1").val();--}}
        {{--if (btnId == "date_input2_phone" && $("#date_input1_phone").val().length != 0)--}}
            {{--from = $("#date_input1_phone").val();--}}
        {{--$("#" + btnId).datepicker({--}}
            {{--numberOfMonths: 2,--}}
            {{--showButtonPanel: true,--}}
            {{--minDate: from,--}}
            {{--dateFormat: "yy/mm/dd"--}}
        {{--});--}}
    {{--}--}}
{{--</script>--}}


{{--<script>--}}

    {{--var date = new Date();--}}
    {{--var numClick = 2;--}}
    {{--var checkOpen = true;--}}

    {{--var numOfCalendar = 1;--}}
    {{--var nowYear = date.getJalaliFullYear();--}}
    {{--var nowMonth = date.getJalaliMonth();--}}

    {{--var nowDate = date.getJalaliDate();--}}
    {{--var backYear = nowYear;--}}
    {{--var backMonth = parseInt(nowMonth) + 1;--}}
    {{--var backDate = nowDate;--}}
    {{--if (backMonth == 12) {--}}
        {{--backYear = parseInt(backYear) + 1;--}}
        {{--backMonth = 0;--}}
    {{--}--}}

    {{--var nowYearGre = date.getFullYear();--}}
    {{--var nowMonthGre = date.getMonth();--}}
    {{--var nowDateGre = date.getDate()--}}

    {{--var backYearGre = nowYearGre;--}}
    {{--var backMonthGre = parseInt(nowMonthGre) + 1;--}}
    {{--var backDateGre = nowDateGre;--}}
    {{--if (backMonthGre == 12) {--}}
        {{--backYearGre = parseInt(backYearGre) + 1;--}}
        {{--backMonthGre = 0;--}}
    {{--}--}}

    {{--var firstMonth;--}}
    {{--var firstMonthBack;--}}

    {{--var firstMonthGre ;--}}
    {{--var firstMonthGreBack;--}}


    {{--var selectDays = [[nowYear, nowMonth,nowDate], [null, null, null]];--}}
    {{--changeTwoCalendar(1);--}}
    {{--function changeTwoCalendar(num) {--}}
        {{--if (num == 1) {--}}
            {{--numClick = 0;--}}
            {{--numOfCalendar = 1;--}}
            {{--document.getElementById('calendarJalali2').style.display = 'none';--}}
            {{--document.getElementById('calendarGregorian2').style.display = 'none';--}}

            {{--document.getElementById('calendarJalali1').style.width = '100%';--}}
            {{--document.getElementById('calendarGregorian1').style.width = '100%';--}}
            {{--document.getElementById('container1').style.width = '35%';--}}

            {{--document.getElementById('backDate').value = '';--}}
            {{--selectDays[1][1] = null;--}}
            {{--checkOpen = true;--}}
        {{--}--}}
        {{--else {--}}
            {{--numOfCalendar = 2;--}}
            {{--document.getElementById('calendarJalali2').style.display = 'inline-block';--}}
            {{--document.getElementById('calendarGregorian2').style.display = 'inline-block';--}}

            {{--document.getElementById('calendarJalali1').style.width = '49%';--}}
            {{--document.getElementById('calendarGregorian1').style.width = '49%';--}}
            {{--document.getElementById('container1').style.width = '65%';--}}
            {{--checkOpen = true;--}}

        {{--}--}}
    {{--}--}}

{{--</script>--}}


<script>
    var date = new Date();
    var numClick = 0;
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
    var firstMonthGre;
    var firstMonthGreBack;

    var eDate = '';

    @if($eDate[0] != '')
            eDate = 1;
            @endif

    var selectDays;
    if (eDate != '') {
        selectDays = [[{{$sDate[0]}}, {{$sDate[1]}}-1, {{$sDate[2]}}], [{{$eDate[0]}}, {{$eDate[1]}}-1, {{$eDate[2]}}]];
        changeTwoCalendar(2);
    }
    else {
        selectDays = [[{{$sDate[0]}}, {{$sDate[1]}}-1, {{$sDate[2]}}], [null, null, null]];
        changeTwoCalendar(1);
    }

    function changeTwoCalendar(num) {
        if (num == 1) {
            numClick = 0;
            numOfCalendar = 1;
            document.getElementById('calendarJalali2').style.display = 'none';
            document.getElementById('calendarGregorian2').style.display = 'none';

            document.getElementById('calendarJalali1').style.width = '100%';
            document.getElementById('calendarGregorian1').style.width = '100%';
            document.getElementById('container1').style.width = '28%';

            document.getElementById('backDate').value = '';
            selectDays[1][1] = null;
            checkOpen = true;
        }
        else {
            numOfCalendar = 2;
            document.getElementById('calendarJalali2').style.display = 'inline-block';
            document.getElementById('calendarGregorian2').style.display = 'inline-block';

            document.getElementById('calendarJalali1').style.width = '49%';
            document.getElementById('calendarGregorian1').style.width = '49%';
            document.getElementById('container1').style.width = '55%';
            checkOpen = true;

        }
    }

    document.getElementById('goDate').value = selectDays[0][0] +'/'+ selectDays[0][1] +'/'+ selectDays[0][2];
//    document.getElementById('goDate1').innerText = selectDays[0][0] +'/'+ selectDays[0][1] +'/'+ selectDays[0][2];

    @if($eDate[0] != '')
        document.getElementById('backDate').value = selectDays[1][0] +'/'+ selectDays[1][1] +'/'+ selectDays[1][2];
//        document.getElementById('backDate1').innerText = selectDays[1][0] +'/'+ selectDays[1][1] +'/'+ selectDays[1][2];
    @endif

</script>

<script>

    @if($ticketGo != '')
        var ticketGo = {!! $ticketGo !!};
    @endif

    var thisPage = [{{$sDate[0]}}, {{$sDate[1]}}-1, {{$sDate[2]}}];
    var date = new Date();
    var nowDay = date.getFirstDayMonth(thisPage[0], thisPage[1], thisPage[2]);
    var lastMonth;
    if ((thisPage[1] - 1) < 0)
        lastMonth = date.getLocalMonthDays('jalali', 11);
    else
        lastMonth = date.getLocalMonthDays('jalali', thisPage[1] - 1);
    var nowMonth1 = date.getLocalMonthDays('jalali', thisPage[1]);
    var days = [];
    var counter = 0;
    var nowDayI;
    var newMonth = 1;
    for (var i = 0; i < nowDay; i++) {
        if ((thisPage[2] - nowDay + i) <= 0) {
            if ((thisPage[1] - 1) < 0) {
                days[i] = (thisPage[0] - 1) + "/12/" + (parseInt(lastMonth) + thisPage[2] - nowDay + i);
                counter++;
            }
            else {
                days[i] = thisPage[0] + "/" + (parseInt(thisPage[1])) + "/" + (parseInt(lastMonth) + thisPage[2] - nowDay + i);
                counter++;
            }
        }
        else {
            days[i] = thisPage[0] + "/" + (thisPage[1] + 1) + "/" + (thisPage[2] - nowDay + i);
            counter++;
        }
    }
    days[counter] = thisPage[0] + "/" + (thisPage[1] + 1) + "/" + thisPage[2];
    nowDayI = counter;
    counter++;
    for (var i = 1, cc = counter; i <= 7 - cc; i++) {
        if ((thisPage[2] + i) > nowMonth1) {
            if ((thisPage[1] + 1 > 11)) {
                days[counter] = (thisPage[0] + 1) + "/1/" + newMonth;
                newMonth++;
                counter++;
            }
            else {
                days[counter] = thisPage[0] + "/" + (thisPage[1] + 2) + "/" + newMonth;
                newMonth++;
                counter++;
            }
        }
        else {
            days[counter] = thisPage[0] + "/" + (thisPage[1] + 1) + "/" + (thisPage[2] + i);
            counter++;
        }
    }
    var day = ["شنبه", "یکشنبه", "دوشنبه", "سه شنبه", "چهارشنبه", "پنج شنبه", "جمعه"];
    var check = 0;
</script>

<script>
    var tickets = [];
    var provider = [];
    var updateId;
    var filterTab = [1, 1, 1];
    var TimeFilter = false;
    var dayFilter = false;
    var nightFlight = false;
    var CompanyFilter = false;
    var systemFilter = false;
    var dayFilterNumber = [];
    var flightCompanys = [];
    var flightCompanysPic = [];
    var flightCompanysCheck = [];
    var flightCompanysPay = [];
//    var last = 0;
    var booleanFirstRequestForGetTicket = true;
    var booleanFirstRequestForGetTicketNextWeek = false;
    var lastShow = [0, 0, 0, 0, 0, 0, 0];
    var numberFilter = 0;
    var kindSystemFlight;
    var countCompany = 1;

    var adult = parseInt('{{$adult}}');
    var child = parseInt('{{$child}}');
    var infant = parseInt('{{$infant}}');
    var passengerNoSelect = false;
    var classNoSelect = false;
    var additional;
    if('{{$additional}}' == 'اکونومی')
        additional = 1;
    else if('{{$additional}}' == 'فرست کلاس')
        additional = 2;
    else if('{{$additional}}' == 'بیزینس')
        additional = 3;
    else
        additional = -1;

    document.getElementById('destCitySearch').value = '{{$dest[0]}}-{{$dest[1]}}';
    document.getElementById('srcCitySearch').value = '{{$src[0]}}-{{$src[1]}}';

    var error = 0;
            @if($back == 1)
    var minGo = (parseInt(ticketGo.time) / 100) % 100;
    var hGo = Math.floor((parseInt(ticketGo.time) / 10000) % 10000);
    ticketGo.time = hGo + ':' + minGo;
    var diffGo = '';
    if (parseInt(ticketGo.arrivalTime) != 0) {
        var minArr = (parseInt(ticketGo.arrivalTime) / 100) % 100;
        var hArr = Math.floor((parseInt(ticketGo.arrivalTime) / 10000) % 10000);
        if (hArr < hGo)
            ticketGo.tomorrow = 1;
        ticketGo.arrivalTime = hArr + ':' + minArr;

        var hArrGo = ticketGo.arrivalTime.split(':')[0];
        var hGoGo = ticketGo.time.split(':')[0];
        var StartGo = '01/01/2007 ' + ticketGo.time + ':00';
        var EndGo = '01/01/2007 ' + ticketGo.arrivalTime + ':00';
        if (hArrGo < hGoGo)
            EndGo = '01/02/2007 ' + ticketGo.arrivalTime + ':00';
        var timeStartGo = new Date(StartGo).getTime();
        var timeEndGo = new Date(EndGo).getTime();
        diffGo = timeEndGo - timeStartGo;
        diffGo /= 1000;
        diffGo = Math.floor(diffGo / 3600) + 'h:' + (diffGo - (3600 * Math.floor(diffGo / 3600))) / 60 + 'm';
    }
    else {
        ticketGo.arrivalTime = '';
    }
    if (parseInt('{{$adult}}') + parseInt('{{$child}}') + parseInt('{{$infant}}') != 1)
        ticketGo.totalMoney = (ticketGo.price * parseInt('{{$adult}}')) + (ticketGo.childPrice * parseInt('{{$child}}')) + (ticketGo.infantPrice * parseInt('{{$infant}}'));
    else
        ticketGo.totalMoney = ticketGo.price;
    document.getElementById('timeFlightGo').innerText = diffGo;
    document.getElementById('totalMoneyGo').innerText = 'مجموع ' + ticketGo.totalMoney;
    document.getElementById('totalNumber').innerText = 'برای ' + (parseInt('{{$adult}}') + parseInt('{{$child}}') + parseInt('{{$infant}}')) + 'نفر';
    document.getElementById('arrTicketGo').innerText = ticketGo.arrivalTime;
    document.getElementById('goTicketGo').innerText = ticketGo.time;

    @endif

    function getTicket(kind) {

        if (error == 0)
            error = 1;

        if ('{{$mode}}' == 'internalFlight')
            var url = '{{route('getInnerFlightTicket')}}';

        var separateDay = days[nowDayI].split('/');
        var sdate = jalaliToGregorian(separateDay[0], (parseInt(separateDay[1])), separateDay[2]);

        if (sdate[1] < 10)
            sdate[1] = '0' + sdate[1];
        if (sdate[2] < 10)
            sdate[2] = '0' + sdate[2];

        var sda = sdate[0] + '/' + sdate[1] + '/' + sdate[2];

        if (kind == 1) {
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    'date': sda,
                    'src': '{{$src[1]}}',
                    'dest': '{{$dest[1]}}',
//                    'last': last,
                    'additional': additional
                },
                success: function (response) {

                    response = JSON.parse(response);
//                    var itr = -1;

                    if (tickets[nowDayI] == null || tickets[nowDayI].length == 0) {
                        tickets[nowDayI] = response.tickets;
//                        itr = response.tickets.length - 1;
                    }
                    else {
                        for (itr = 0; itr < response.tickets.length; itr++)
                            tickets[nowDayI][tickets[nowDayI].length] = response.tickets[itr];
                    }

//                    if(itr > 0)
//                        last = response.tickets[itr - 1].id;

                    if (tickets[nowDayI].length != 0) {
                        if (flightCompanys[0] == null) {
                            flightCompanys[0] = tickets[nowDayI][0].line;
                            flightCompanysPay[0] = tickets[nowDayI][0].price;
                            flightCompanysPic[0] = tickets[nowDayI][0].lineLogoSmall;
                        }
                        for (var i = lastShow[nowDayI]; i < tickets[nowDayI].length; i++) {
                            var minGo = (parseInt(tickets[nowDayI][i].time) / 100) % 100;
                            var hGo = Math.floor((parseInt(tickets[nowDayI][i].time) / 10000) % 10000);
                            tickets[nowDayI][i].time = hGo + ':' + minGo;
                            if (parseInt(tickets[nowDayI][i].arrivalTime) != 0) {
                                var minArr = (parseInt(tickets[nowDayI][i].arrivalTime) / 100) % 100;
                                var hArr = Math.floor((parseInt(tickets[nowDayI][i].arrivalTime) / 10000) % 10000);
                                if (hArr < hGo)
                                    tickets[nowDayI][i].tomorrow = 1;
                                tickets[nowDayI][i].arrivalTime = hArr + ':' + minArr;
                            }
                            else {
                                tickets[nowDayI][i].arrivalTime = '';
                            }

                            var chec = 0;
                            for (j = 0; j < flightCompanys.length; j++) {
                                if (flightCompanys[j] == tickets[nowDayI][i].line) {
                                    chec = 1;
                                    if (flightCompanysPay[j] < tickets[nowDayI][i].price)
                                        flightCompanysPay[j] = tickets[nowDayI][i].price;
                                    break;
                                }
                            }
                            if (chec == 0) {
                                flightCompanys[countCompany] = tickets[nowDayI][i].line;
                                flightCompanysPay[countCompany] = tickets[nowDayI][i].price;
                                flightCompanysPic[countCompany] = tickets[nowDayI][i].lineLogoSmall;
                                countCompany++;
                            }
                        }
                        var text = '';
                        for (var i = 0; i < countCompany; i++) {
                            text += '<div class="check-box__item hint-system" style="text-align: right; margin-top: 5%;">\n' +
                                    '                                        <label class="labelEdit"> ' + flightCompanys[i] + ' </label>\n' +
                                    '                                        <span class="salelabelEdit">(' + FormatNumberBy3(flightCompanysPay[i]) + '  از  )</span>\n' +
                                    // '                                        <div class="picturelabelEdit"></div>\n' +
                                    '                                        <input type="checkbox" id="Company' + i + '" onclick="CompanyFilterFunc(' + i + ')" \n' +
                                    '                                         style="display: inline-block; !important;">\n' +
                                    ' <img src="' + flightCompanysPic[i] + '" alt="' + flightCompanys[i] + '" style="max-height: 43px; float:left; position: absolute; left: 0; top: -10%">\n' +
                                    '                                    </div>';
                        }
                        document.getElementById('companyFlight').innerHTML = text;
                        sortTicket(2, 0);
                    }
                    else
                        sortTicket(2, 0);
                }
            });
        }

        else {
            if (tickets[nowDayI] == null) {
                document.getElementById('ticketPlace').innerHTML = '';
                getTicket(1);
            }
            else
                showTicket(0);
        }
    }

    setTimeout(function(){
        alert("لطفا صفحه را دوباره بارگذاری کنید...");
        location.reload();
    }, 300000);

    function getJavaTicket() {

        $.ajax({
            type: "post",
            url: '{{route('sendJavaRequest')}}',
            data: {
                'sDate': days[0],
                'eDate': days[6],
                'src': '{{$src[1]}}',
                'dest': '{{$dest[1]}}'
            }
        });
    }

    function getMinPrice() {

        $.ajax({
            type: 'post',
            url: '{{route('getMinPrice')}}',
            data: {
                'minDay': days[0],
                'maxDay': days[6],
                'src': '{{$src[1]}}',
                'dest': '{{$dest[1]}}'
            },
            success: function (response) {
                response = JSON.parse(response);
                for (var i = 0; i < response.length; i++) {
                    var date = response[i].date.split('/');
                    if (parseInt(date[1]) < 10)
                        date[1] = parseInt(date[1]);
                    if (parseInt(date[2]) < 10)
                        date[2] = parseInt(date[2]);
                    document.getElementById('money/' + date[0] + '/' + date[1] + '/' + date[2]).innerText = FormatNumberBy3(response[i].price);
                }
                getTicket(1);
            }
        });
    }

    changeDay(nowDayI, 1);

    function changeDay(nowDayII, kind) {

        document.getElementById('dayBar').style.display = 'none';
        document.getElementById('nextDay').style.display = 'none';
        document.getElementById('prevDay').classList.remove('fillArrowUpIcon');
        document.getElementById('fill').style.display = 'block';
        nowDayI = nowDayII;
        var text = '';
        var separateDay, ifCheck;

        if (kind == 1) {
            for (var i = 0; i < 7; i++) {
                separateDay = days[i].split('/');
                if (eDate != '')
                    ifCheck = ((separateDay[0] == nowYear && separateDay[1] - 1 == nowMonth && separateDay[2] < nowDate) || (separateDay[0] == nowYear && separateDay[1] - 1 < nowMonth) || (separateDay[0] == '{{$eDate[0]}}' && separateDay[1] == '{{$eDate[1]}}' && parseInt(separateDay[2]) < parseInt('{{$eDate[2]}}') && '{{$back}}' == 1) || (separateDay[0] == '{{$eDate[0]}}' && parseInt(separateDay[1]) < parseInt('{{$eDate[1]}}') && '{{$back}}' == 1));
                else
                    ifCheck = ((separateDay[0] == nowYear && separateDay[1] - 1 == nowMonth && separateDay[2] < nowDate) || (separateDay[0] == nowYear && separateDay[1] - 1 < nowMonth));

                if (ifCheck) {
                    text += '<div id="' + i + '" class="not_day">\n' +
                            '        <center>\n' +
                            '        <h6 id="day" class="date-money" style="padding-top: 0.5em">' + day[i] + '</h6>\n' +
                            '        <h6 id="date" class="date-money"> ' + days[i] + '</h6>\n' +
                            '        <h6 id="money/' + days[i] + '" class="date-money"></h6>\n' +
                            '    </center>\n' +
                            '    </div>';
                }
                else if (i == nowDayII) {
                    text += '<div id="' + i + '" class="left_content_bar_now" onclick="changeDay(' + i + ',0)">\n' +
                            '        <center>\n' +
                            '        <h6 id="day" class="date-money" style="padding-top: 0.5em">' + day[i] + '</h6>\n' +
                            '        <h6 id="date" class="date-money" > ' + days[i] + '</h6>\n' +
                            '        <h6 id="money/' + days[i] + '" class="date-money"></h6>\n' +
                            '    </center>\n' +
                            '    </div>';
                }
                else {
                    text += '<div id="' + i + '" class="left_content_bar" onclick="changeDay(' + i + ',0)"> \n' +
                            '        <center>\n' +
                            '        <h6 id="day" class="date-money" style="padding-top: 0.5em">' + day[i] + '</h6>\n' +
                            '        <h6 id="date" class="date-money" > ' + days[i] + '</h6>\n' +
                            '        <h6 id="money/' + days[i] + '" class="date-money"></h6>\n' +
                            '    </center>\n' +
                            '    </div>';
                }
            }
            document.getElementById('dayBar').innerHTML = text;
        }
        else {
            for (var i = 0; i < 7; i++) {
                if (document.getElementById(i).classList.contains('left_content_bar_now')) {
                    document.getElementById(i).classList.remove('left_content_bar_now');
                    document.getElementById(i).classList.add('left_content_bar');
                }
            }
            document.getElementById(nowDayII).classList.remove('left_content_bar');
            document.getElementById(nowDayII).classList.add('left_content_bar_now');
        }

        separateDay = days[nowDayII].split('/');

        if (eDate != '')
            ifCheck = ((separateDay[0] == nowYear && separateDay[1] - 1 == nowMonth && separateDay[2] == nowDate || (separateDay[0] == '{{$eDate[0]}}' && separateDay[1] == '{{$eDate[1]}}' && separateDay[2] == '{{$eDate[2]}}' && '{{$back}}' == 1)));
        else
            ifCheck = (separateDay[0] == nowYear && separateDay[1] - 1 == nowMonth && separateDay[2] == nowDate);


        if (ifCheck) {
            document.getElementById('prevDay').classList.remove('fillArrowUpIcon3');
            document.getElementById('prevDay').classList.add('fillArrowUpIcon2');
        }
        else {
            document.getElementById('prevDay').classList.remove('fillArrowUpIcon2');
            document.getElementById('prevDay').classList.add('fillArrowUpIcon3');
        }

        if (booleanFirstRequestForGetTicket && '{{$allow}}' == 1) {
            getJavaTicket();
            document.getElementById('fill').style.display = 'none';
            getMinPrice();
            booleanFirstRequestForGetTicket = false;
        }
        else if(booleanFirstRequestForGetTicketNextWeek) {
            getJavaTicket();
            document.getElementById('fill').style.display = 'none';
            getMinPrice();
            booleanFirstRequestForGetTicketNextWeek = false;
        }
        else {
            if (kind == 1)
                getMinPrice();
            else {

                if (check != 1)
                    check = 1;

                getTicket(0);
            }
        }

    }
    function nextDay() {

        if (nowDayI != 6) {
            nowDayI++;
            changeDay(nowDayI, 0);
        }
        else {
            var separate = days[6].split('/');
            var separate2 = days[0].split('/');
            thisPage[2] = parseInt(separate[2]) + 1;
            newMonth = 1;
            if ((parseInt(separate2[2]) > parseInt(separate[2]))) {
                thisPage[1] = parseInt(separate2[1]) - 1;
                thisPage[1] = thisPage[1] + 1;
                if (thisPage[1] == 12) {
                    thisPage[1] = 0;
                    thisPage[0] += 1;
                }
                if ((thisPage[1] - 1) < 0)
                    lastMonth = date.getLocalMonthDays('jalali', 11);
                else
                    lastMonth = date.getLocalMonthDays('jalali', thisPage[1] - 1);

                nowMonth1 = date.getLocalMonthDays('jalali', thisPage[1]);
            }
            else if (thisPage[2] > nowMonth1) {
                thisPage[1] = parseInt(separate2[1]) - 1;
                thisPage[1] = thisPage[1] + 1;
                if (thisPage[1] == 12) {
                    thisPage[1] = 0;
                    thisPage[0] += 1;
                }
                if ((thisPage[1] - 1) < 0)
                    lastMonth = date.getLocalMonthDays('jalali', 11);
                else
                    lastMonth = date.getLocalMonthDays('jalali', thisPage[1] - 1);

                nowMonth1 = date.getLocalMonthDays('jalali', thisPage[1]);
                thisPage[2] = 1;
            }

            var counter = 0;
            for (var i = 0; i <= 7; i++) {
                if ((thisPage[2] + i) > nowMonth1) {
                    if ((thisPage[1] + 1 > 11)) {
                        days[counter] = (thisPage[0] + 1) + "/1/" + newMonth;
                        newMonth++;
                        counter++;
                    }
                    else {
                        days[counter] = thisPage[0] + "/" + (thisPage[1] + 2) + "/" + newMonth;
                        newMonth++;
                        counter++;
                    }
                }
                else {
                    days[counter] = thisPage[0] + "/" + (thisPage[1] + 1) + "/" + (thisPage[2] + i);
                    counter++;
                }
            }
            nowDayI = 0;
            for(k = 0; k < 7; k++)
                tickets[k] = null;
            booleanFirstRequestForGetTicketNextWeek = true;
            changeDay(0, 1);
        }
    }
    function prevDay() {
        var separateDay = days[nowDayI].split('/');

        var ifCheck;

        if (eDate != '')
            ifCheck = (!(separateDay[0] == nowYear && separateDay[1] - 1 == nowMonth && separateDay[2] == nowDate || (separateDay[0] == '{{$eDate[0]}}' && separateDay[1] == '{{$eDate[1]}}' && separateDay[2] == '{{$eDate[2]}}' && '{{$back}}' == 1)));
        else
            ifCheck = (!(separateDay[0] == nowYear && separateDay[1] - 1 == nowMonth && separateDay[2] == nowDate));



        if (ifCheck) {
            if (nowDayI != 0) {
                nowDayI--;
                changeDay(nowDayI, 0);
            }
            else {
                var separate = days[0].split('/');
                var separate2 = days[6].split('/');

                thisPage[2] = parseInt(separate[2]) - 1;
                if (thisPage[2] == 0) {
                    thisPage[2] = lastMonth;
                    thisPage[1] -= 1;
                }
                else if (parseInt(separate2[2]) < parseInt(separate[2])) {
                    thisPage[1] -= 1;
                    if (thisPage[1] == -1) {
                        thisPage[0] -= 1;
                        thisPage[1] = 11;
                    }
                }


                var nowD = date.getFirstDayMonth(thisPage[0], thisPage[1], thisPage[2]);
                var counter = 0;

                for (var i = 0; i < nowD; i++) {
                    if ((thisPage[2] - nowD + i) <= 0) {
                        if ((thisPage[1] - 1) < 0) {
                            days[i] = (thisPage[0] - 1) + "/12/" + (parseInt(lastMonth) + thisPage[2] - nowD + i);
                            counter++;
                        }
                        else {
                            days[i] = thisPage[0] + "/" + (parseInt(thisPage[1])) + "/" + (parseInt(lastMonth) + thisPage[2] - nowD + i);
                            counter++;
                        }
                    }
                    else {
                        days[i] = thisPage[0] + "/" + (thisPage[1] + 1) + "/" + (thisPage[2] - nowD + i);
                        counter++;
                    }
                }
                days[counter] = thisPage[0] + "/" + (thisPage[1] + 1) + "/" + thisPage[2];
                counter++;
                for (var i = 1, cc = counter; i <= 7 - cc; i++) {
                    if ((thisPage[2] + i) > nowMonth1) {
                        if ((thisPage[1] + 1 > 11)) {
                            days[counter] = (thisPage[0] + 1) + "/1/" + newMonth;
                            newMonth++;
                            counter++;
                        }
                        else {
                            days[counter] = thisPage[0] + "/" + (thisPage[1] + 2) + "/" + newMonth;
                            newMonth++;
                            counter++;
                        }
                    }
                    else {
                        days[counter] = thisPage[0] + "/" + (thisPage[1] + 1) + "/" + (thisPage[2] + i);
                        counter++;
                    }
                }

                for(k = 0; k < 7; k++)
                    tickets[k] = null;
                nowDayI = 6;
                booleanFirstRequestForGetTicketNextWeek = true;
                changeDay(6, 1);
            }
        }
    }
    function showTicket(kind) {
        var text = '';
        document.getElementById('totalTicket').innerText = tickets[nowDayI].length;
        var firstTicket = 0;
        if (kind == 0)
            document.getElementById('ticketPlace').innerHTML = '';
        else {
            firstTicket = lastShow[nowDayI];
            lastShow[nowDayI] = tickets[nowDayI].length;
        }

        var price2, itr, price1;

        for (itr = firstTicket; itr < tickets[nowDayI].length; itr++) {
            var diff = '';
            if (tickets[nowDayI][itr].arrivalTime != '') {
                var hArr = tickets[nowDayI][itr].arrivalTime.split(':')[0];
                var hGo = tickets[nowDayI][itr].time.split(':')[0];
                var Start = '01/01/2007 ' + tickets[nowDayI][itr].time + ':00';
                var End = '01/01/2007 ' + tickets[nowDayI][itr].arrivalTime + ':00';
                if (parseInt(hArr) < parseInt(hGo))
                    End = '01/02/2007 ' + tickets[nowDayI][itr].arrivalTime + ':00';
                var timeStart = new Date(Start).getTime();
                var timeEnd = new Date(End).getTime();
                diff = timeEnd - timeStart;
                diff /= 1000;
                diff = Math.floor(diff / 3600) + 'h:' + (diff - (3600 * Math.floor(diff / 3600))) / 60 + 'm';
            }
            if (parseInt('{{$adult}}') + parseInt('{{$child}}') + parseInt('{{$infant}}') != 1)
                tickets[nowDayI][itr].totalMoney = (tickets[nowDayI][itr].price * parseInt('{{$adult}}')) + (tickets[nowDayI][itr].childPrice * parseInt('{{$child}}')) + (tickets[nowDayI][itr].infantPrice * parseInt('{{$infant}}'));
            else
                tickets[nowDayI][itr].totalMoney = tickets[nowDayI][itr].price;

            price1 = FormatNumberBy3(tickets[nowDayI][itr].price);
            if (parseInt('{{$adult}}') + parseInt('{{$child}}') + parseInt('{{$infant}}') != 1)
                price2 = FormatNumberBy3(tickets[nowDayI][itr].totalMoney);

            text += "<div id='ticket" + itr + "' class='col-md-12'>\n" +
                    '            <div class="boxTicket">\n';
            text += "            <div class='row' style='height: 165px;'>\n";
            text +=    '            <div class="col-md-3 "\n' +
                    '        style="margin-top: 10px; border-right: solid 2px #aeaeae; padding-left: 25px; margin-bottom: 10px; max-width: 25%; !important; text-align: center">\n' +
                    '            <h6 style="color: #9f3322;">بهترین قیمت از</h6>\n' +
                    '        <h5 style="font-weight: 900;"> ' + price1 + '</h5>\n';
            if (parseInt('{{$adult}}') + parseInt('{{$child}}') + parseInt('{{$infant}}') != 1)
                text += '        <h6>' + price2 + ' مجموع </h6>\n';
            text += '        <div style="">\n' +
                    '            <button class="btn viewOffersBtn" type="button" onclick="goTicket(' + itr + ') "> مشاهده پیشنهاد ها\n' +
                    '        </button>\n' +
                    '        </div>\n' +
                    '        <h6 style="color: dodgerblue; margin-top: 10px;">به همراه ' + tickets[nowDayI][itr].num + ' پیشنهاد\n' +
                    '        دیگر</h6>\n' +
                    '        </div>\n' +
                    '        <div class="col-md-6 set-center" style="max-width: 50%; !important;">\n' +
                    '        <div style="width: 98%; height: 35%; margin: 5px; position: absolute; top: 30%; right: 0%">\n' +
                    '        <div class="explainPurpose" style="left: 0%">\n' +
                    '            <div> مقصد </div>\n' +
                    '            <div style="width: 15px;height: 15px;border-radius: 50%;background-color: gray; margin: 0 auto"></div>\n';
            if (tickets[nowDayI][itr].tomorrow == 1)
                text += '<div>+1 ' + tickets[nowDayI][itr].arrivalTime + '</div>\n';
            else
                text += '<div>' + tickets[nowDayI][itr].arrivalTime + '</div>\n';
            text += '        </div>\n' +
                '        <div class="explainFlight">\n' +
                '        <div style="position: absolute; right: 45%; top: 20%;">' + diff + '</div>\n' +
                '        <div style="width: 100%;border: 0.8px solid gray; position: absolute; top: 49%;"></div>\n' +
                '            <div class="shTIcon leftArrowIcon"></div>\n' +
                '            </div>\n' +
                '            <div class="explainPurpose" style="right: 0">\n' +
                '            <div> مبدأ </div>\n' +
                '            <div style="width: 15px;height: 15px;border-radius: 50%;background-color: gray; margin: 0 auto"></div>\n' +
                '            <div>' + tickets[nowDayI][itr].time + '</div>\n' +
                '        </div>\n' +
                '        </div>\n' +
                '        </div>\n' +
                '        <div class="col-md-3 set-center"\n' +
                '        style="text-align:center;height: auto; border-left: solid 2px #aeaeae; margin-bottom: 10px;margin-top: 10px;">\n' +
                '            <div style="width: 100%; height: 40%;  position: absolute; top: 30%;">\n' +
                '            <div class="airlinesImage"><img src="' + tickets[nowDayI][itr].lineLogo + '" style="width: 100%;"></div>\n' +
                '            <div class="airlinesText">' + tickets[nowDayI][itr].line + '</div>\n' +
                '            </div>\n' +
                '            </div>\n' +
                '            </div>\n' +
                '            <div id="myModal" class="modal-content">\n' +
                '            <div class="col-md-12" style="width: 100%; border-bottom: solid 0.8px gray;">\n' +
                '            <div class="col-md-3 set-center selected-filter"\n' +
                '        style="float: right; padding-right: 0; width: 15%;">\n' +
                '            <h6>جزییات پرواز</h6>\n' +
                '        </div>\n' +
                '        <div class="col-md-3 set-center selected-filter"\n' +
                '        style="width: 10%; padding-right: 0; float: right;">\n' +
                '            <h6>قیمت</h6>\n' +
                '            </div>\n' +
                '            <div id="shortestTime" class="col-md-3 set-center selected-filter "\n' +
                '        onclick="addSelected(\'shortestTime\')"\n' +
                '        style="float: right; width: 20%; padding-right: 0;">\n' +
                '            <h6>نقدها و نظرات</h6>\n' +
                '        </div>\n' +
                '        <div id="modal" style="width: 30px; display: inline-block;">close</div>\n' +
                '            </div>\n' +
                '            <div style="margin-top: 30px;">\n' +
                '            <div style="width: 40%; display: inline-block; float: right; border-left: solid 0.8px gray; padding: 10px;">\n' +
                '            right\n' +
                '            </div>\n' +
                '            <div style="width: 60%; display: inline-block; padding: 10px;">\n' +
                '            left\n' +
                '            </div>\n' +
                '            </div>\n' +
                '            </div>\n' +
                '            </div>\n';
            if (tickets[nowDayI][itr].isCharter == 1) {
                text += '<div id="middle" class="col-md-12" style="padding: 0 !important;">\n' +
                    '                                <div class="boxSale">\n' +
                    '                                <div class="ticket-type"> چارتر</div>\n' +
                    '                                <div class="ticket-type" style="background: #92321b;"> ظرفیت ' + tickets[nowDayI][itr].free + 'نفر</div>\n' +
                    // '                                <div style="float: left; color: #92321b; margin: 3px 10px; font-size: 1.3em; line-height: 24px;">\n' +
                    // '                                ده درصد تخفیف\n' +
                    // '                                </div>\n' +
                    '                                </div>\n' +
                    '                                </div>\n' +
                    '                                </div>';
            }
            else {
                text += '<div id="middle" class="col-md-12" style="padding: 0 !important;">\n' +
                    '                                <div class="boxSale">\n' +
                    '                                <div class="ticket-type"> سیستمی</div>\n' +
                    '                                <div class="ticket-type" style="background: #92321b;"> ظرفیت ' + tickets[nowDayI][itr].free + 'نفر</div>\n' +
                    '                                </div>\n' +
                    '                                </div>\n' +
                    '                                </div>';
            }
            if (itr == 0) {
                text += '<div id="middle" class="col-md-12">\n' +
                    '                                <div class="boxOffer">\n' +
                    '                                <div style="display: inline-block">\n' +
                    '                                <div style="font-size: 1.6em"> آیا می خواهید کمترین قیمت ها را به شما اطلاع\n' +
                    '                                دهیم\n' +
                    '                                </div>\n' +
                    '                                <div style="font-size: 1.3em"> هنگامی که قیمت های مبدا به مقصد کاهش یابد به شما\n' +
                    '                                اطلاع می دهیم\n' +
                    '                                </div>\n' +
                    '                                </div>\n' +
                    '                                <div style="float: left">\n' +
                    '                                <button class="btn alarm" type="button" onclick="getAlarm(1)"> دریافت هشدار</button>\n' +
                    '                                </div>\n' +
                    '                                </div>\n' +
                    '                                </div> ';
            }
        }
        document.getElementById('dayBar').style.display = '';
        document.getElementById('nextDay').style.display = '';
        document.getElementById('prevDay').classList.add('fillArrowUpIcon');
        document.getElementById('fill').style.display = 'none';
        $('#ticketPlace').append(text);
        if (kind == 1)
            closeAll();
        else
            getFilter();
    }
    function getFilter() {
        firstTime = 1;
        var minTimeStart = valueMin.innerHTML.split(':');
        var maxTimeStart = valueMax.innerHTML.split(':');
        var minTimeEnd = valueMin2.innerHTML.split(':');
        var maxTimeEnd = valueMax2.innerHTML.split(':');
        for (var i = 0; i < tickets[nowDayI].length; i++) {
            var number = 0;
            var sepStart = tickets[nowDayI][i].time.split(':');
            if(tickets[nowDayI][i].arrivalTime != '') {
                var sepEnd = tickets[nowDayI][i].arrivalTime.split(':');
                sepEnd[0] = parseInt(sepEnd[0]);
                sepEnd[1] = parseInt(sepEnd[1]);
            }
            sepStart[0] = parseInt(sepStart[0]);
            sepStart[1] = parseInt(sepStart[1]);

            if (TimeFilter) {
                if ((minTimeStart[0] < sepStart[0]) || (minTimeStart[0] == sepStart[0] && minTimeStart[1] <= sepStart[1])) {
                    number++;
                }
                if ((maxTimeStart[0] > sepStart[0]) || (maxTimeStart[0] == sepStart[0] && maxTimeStart[1] >= sepStart[1])) {
                    number++;
                }
                if(tickets[nowDayI][i].arrivalTime != '') {
                    if ((minTimeEnd[0] < sepEnd[0]) || (minTimeEnd[0] == sepEnd[0] && minTimeEnd[1] <= sepEnd[1])) {
                        number++;
                    }
                    if ((maxTimeEnd[0] > sepEnd[0]) || (maxTimeEnd[0] == sepEnd[0] && maxTimeEnd[1] >= sepEnd[1])) {
                        number++;
                    }
                }
                else{
                    number += 2;
                }
                Filter(1);
            }
            else {
                number += 4;
            }
            if (dayFilter) {
                if (nightFlight) {
                    if (((sepStart[0] >= dayFilterNumber[0] && sepStart[0] <= 24) || (sepStart[0] >= 0 && sepStart[0] <= dayFilterNumber[1])) && ((sepEnd[0] >= dayFilterNumber[0] && sepEnd[0] <= 24) || (sepEnd[0] >= 0 && sepEnd[0] <= dayFilterNumber[1]))) {
                        number++;
                    }
                } else if (dayFilterNumber[0] == 21 && dayFilterNumber[1] == 3) {
                    if (sepStart[0] >= dayFilterNumber[0] || sepStart[0] < dayFilterNumber[1])
                        number++;
                }
                else if (sepStart[0] >= dayFilterNumber[0] && (sepStart[0] < dayFilterNumber[1] || (sepStart[0] == dayFilterNumber[1] && sepStart[1] == 0))) {
                    number++;
                }
                Filter(2);
            }
            else {
                number += 1;
            }
            if (CompanyFilter) {
                for (j = 0; j < flightCompanysCheck.length; j++) {
                    if (flightCompanysCheck[j] != null && flightCompanysCheck[j] == tickets[nowDayI][i].line) {
                        number++;
                        break;
                    }
                }
                Filter(4);
            }
            else {
                number++;
            }
            if (systemFilter) {
                if (kindSystemFlight == tickets[nowDayI][i].isCharter)
                    number++;
                Filter(3);
            }
            else {
                number++;
            }
            if (number == 7) {
                if ($('#ticket' + i).css("display") == 'none') {
                    numberFilter--;
                    $('#ticket' + i).css("display", "block");
                }
            }
            else {
                if ($('#ticket' + i).css("display") != 'none') {
                    $('#ticket' + i).css("display", "none");
                    numberFilter++;
                }
            }
        }
        Filter(0);
    }
    function Filter(kind) {
        switch (kind) {
            case 1:
                document.getElementById('flightTime').style.display = '';
                document.getElementById('filters_tab').style.display = '';
                break;
            case 2:
                document.getElementById('dayTime').style.display = '';
                document.getElementById('filters_tab').style.display = '';
                break;
            case 3:
                document.getElementById('flightKind').style.display = '';
                document.getElementById('filters_tab').style.display = '';
                break;
            case 4:
                document.getElementById('flightCompany').style.display = '';
                document.getElementById('filters_tab').style.display = '';
                break;
        }
        if (document.getElementById('flightTime').style.display == 'none' && document.getElementById('dayTime').style.display == 'none' && document.getElementById('flightKind').style.display == 'none' && document.getElementById('flightCompany').style.display == 'none') {
            document.getElementById('filters_tab').style.display = 'none';
        }
        document.getElementById('filterTicket').innerText =tickets[nowDayI].length - numberFilter;
    }
    function closeFilter(kind) {
        switch (kind) {
            case 1:
                document.getElementById('flightTime').style.display = 'none';
                TimeFilter = false;
                break;
            case 2:
                document.getElementById('dayTime').style.display = 'none';
                dayFilter = false;
                document.getElementById('nightBase').style.color = '#555555';
                document.getElementById('afternoonBase').style.color = '#555555';
                document.getElementById('noonBase').style.color = '#555555';
                document.getElementById('morningBase').style.color = '#555555';
                document.getElementById('nightFlight').checked = false;
                break;
            case 3:
                document.getElementById('flightKind').style.display = 'none';
                document.getElementById('charteri').checked = false;
                document.getElementById('systemi').checked = false;
                systemFilter = false;
                break;
            case 4:
                document.getElementById('flightCompany').style.display = 'none';
                for (var i = 0; i < flightCompanys.length; i++) {
                    document.getElementById('Company' + i).checked = false;
                    flightCompanysCheck[i] = null;
                }
                CompanyFilter = false;
                break;
        }
        getFilter();
    }
    function dayTimeFilter(kind) {
        document.getElementById('nightBase').style.color = '#555555';
        document.getElementById('afternoonBase').style.color = '#555555';
        document.getElementById('noonBase').style.color = '#555555';
        document.getElementById('morningBase').style.color = '#555555';
        switch (kind) {
            case 1:
                document.getElementById('nightBase').style.color = 'var(--koochita-light-green)';
                dayFilterNumber = [21, 3];
                break;
            case 2:
                document.getElementById('afternoonBase').style.color = 'var(--koochita-light-green)';
                dayFilterNumber = [15, 21];
                break;
            case 3:
                document.getElementById('noonBase').style.color = 'var(--koochita-light-green)';
                dayFilterNumber = [10, 15];
                break;
            case 4:
                document.getElementById('morningBase').style.color = 'var(--koochita-light-green)';
                dayFilterNumber = [3, 9];
                break;
            case 5:
                if (nightFlight) {
                    nightFlight = false;
                    closeFilter(2);
                }
                else {
                    dayFilterNumber = [21, 3];
                    nightFlight = true;
                }
        }
        dayFilter = true;
        getFilter();
    }
    function CompanyFilterFunc(number) {
        if (document.getElementById('Company' + number).checked == true) {
            flightCompanysCheck[number] = flightCompanys[number];
        }
        else {
            flightCompanysCheck[number] = null;
        }
        var count = 0;
        for (var i = 0; i < flightCompanysCheck.length; i++) {
            if (flightCompanysCheck[i] == null)
                count++;
        }
        if (count == flightCompanysCheck.length) {
            CompanyFilter = false;
            closeFilter(4);
        }
        else {
            CompanyFilter = true;
        }
        getFilter();
    }
    function systemFilterFunc(kind) {
        if (kind == 1) {
            if (document.getElementById('systemi').checked == true) {
                document.getElementById('charteri').checked = false;
                systemFilter = true;
                kindSystemFlight = 0;
            }
            else {
                systemFilter = false;
            }
        }
        else {
            if (document.getElementById('charteri').checked == true) {
                document.getElementById('systemi').checked = false;
                systemFilter = true;
                kindSystemFlight = 1;
            }
            else {
                systemFilter = false;
            }
        }
        getFilter();
    }
    function closeAll() {
        document.getElementById('filters_tab').style.display = 'none';
        closeFilter(1);
        closeFilter(2);
        closeFilter(3);
        closeFilter(4);
        document.getElementById('filterTicket').innerText = 0;
        numberFilter = 0;
    }
    function sortTicket(kind, mode) {
        switch (kind) {
            case 0:
                break;
            case 1:
                if ($("#lessMoney").hasClass("select-sort")) {
                    document.getElementById('lessMoneyUnderLine').classList.remove("underline_select");
                    document.getElementById('lessMoney').classList.remove("select-sort");
                }
                else {
                    document.getElementById('lessMoneyUnderLine').classList.add("underline_select");
                    document.getElementById('lessMoney').classList.add("select-sort");
                    document.getElementById('sortTime').innerText = '';

                    for (var i = 0; i < tickets[nowDayI].length - 1; i++) {
                        for (var j = i + 1; j < tickets[nowDayI].length; j++) {
                            if (tickets[nowDayI][j].price < tickets[nowDayI][i].price) {
                                t = tickets[nowDayI][i];
                                tickets[nowDayI][i] = tickets[nowDayI][j];
                                tickets[nowDayI][j] = t;
                            }
                        }
                    }
                    showTicket(mode);
                }
                break;
            case 2:
                document.getElementById('sortTime').innerText = ' نزدیک ترین زمان خروج';
                for (var i = 0; i < tickets[nowDayI].length - 1; i++) {
                    var separate = tickets[nowDayI][i].time.split(":");
                    for (j = i + 1; j < tickets[nowDayI].length; j++) {
                        var separate2 = tickets[nowDayI][j].time.split(":");
                        if ((parseInt(separate2[0]) < parseInt(separate[0])) || (parseInt(separate2[0]) == parseInt(separate[0]) && parseInt(separate2[1]) < parseInt(separate2[1]))) {
                            var t = tickets[nowDayI][i];
                            tickets[nowDayI][i] = tickets[nowDayI][j];
                            tickets[nowDayI][j] = t;
                            separate = separate2;
                        }
                    }
                }
                if ($("#lessMoney").hasClass("select-sort")) {
                    document.getElementById('lessMoneyUnderLine').classList.remove("underline_select");
                    document.getElementById('lessMoney').classList.remove("select-sort");
                }
                showTicket(mode);
                break;
            case 3:
                document.getElementById('sortTime').innerText = ' نزدیک ترین زمان ورود';
                for (var i = 0; i < tickets[nowDayI].length - 1; i++) {
                    separate = tickets[nowDayI][i].arrivalTime.split(":");
                    var separate1 = tickets[nowDayI][i].time.split(":");
                    if (parseInt(separate[0]) < parseInt(separate1[0])) {
                        separate[0] = parseInt(separate[0]) + 24;
                    }
                    for (j = i + 1; j < tickets[nowDayI].length; j++) {
                        separate2 = tickets[nowDayI][j].arrivalTime.split(":");
                        var separate3 = tickets[nowDayI][j].time.split(":");
                        if (parseInt(separate[0]) < parseInt(separate3[0])) {
                            separate2[0] = parseInt(separate2[0]) + 24;
                        }
                        if ((parseInt(separate2[0]) < parseInt(separate[0])) || (parseInt(separate2[0]) == parseInt(separate[0]) && parseInt(separate2[1]) < parseInt(separate2[1]))) {
                            t = tickets[nowDayI][i];
                            tickets[nowDayI][i] = tickets[nowDayI][j];
                            tickets[nowDayI][j] = t;
                            separate = separate2;
                        }
                    }
                }
                if ($("#lessMoney").hasClass("select-sort")) {
                    document.getElementById('lessMoneyUnderLine').classList.remove("underline_select");
                    document.getElementById('lessMoney').classList.remove("select-sort");
                }
                showTicket(mode);
                break;
        }
    }
    function getAlarm(kind) {
        if (kind == 1) {
            document.getElementById('idGetAlarm').classList.remove('hidden');
        }
        else {
            document.getElementById('idGetAlarm').classList.add('hidden');
        }
    }
    function changeGOTicket(kind) {
        if (kind == 1)
            document.getElementById('editing').style.display = 'block';
        else
            document.getElementById('editing').style.display = 'none';
    }
    function editTicketGo(kind) {
        if(kind == 1) {
            @if($eDate[0] != '')
                @if($additional == 'اکونومی')
            var addi = 1;
                    @elseif($additional == 'فرست کلاس')
            var addi = 2;
                    @else
            var addi = 3;
                    @endif
            var edate = {{$eDate[0]}} +',' + {{$eDate[1]}} +',' + {{$eDate[2]}};
            var separateDay = days[nowDayI].split('/');
            var sdate = separateDay[0] + ',' + separateDay[1] + ',' + separateDay[2];
            document.location.href = '{{route('home')}}' + "/getTickets/{{$mode}}/{{$destination}}/{{$source}}/{{$adult}}/{{$child}}/{{$infant}}/" + addi + "/" + edate + "/" + sdate + "/0";
            @endif
        }
        else if( kind == 0){
            var src = document.getElementById('srcCitySearch').value;
            var dest = document.getElementById('destCitySearch').value;
            var sdate = selectDays[0][0] + ',' + (parseInt(selectDays[0][1])+1) + ',' + selectDays[0][2];

            @if($eDate[0] != '')
                var edate = selectDays[1][0] + ',' + (parseInt(selectDays[1][1])+1) + ',' + selectDays[1][2];
                document.location.href = '{{route('home')}}' + "/getTickets/{{$mode}}/" + src + "/" + dest + "/" + adult + "/" + child + "/" + infant + "/" + additional + "/" + sdate + "/" + edate + "/0";
            @else
                document.location.href = '{{route('home')}}' + "/getTickets/{{$mode}}/" + src + "/" + dest + "/" + adult + "/" + child + "/" + infant + "/" + additional + "/" + sdate ;
            @endif
        }
    }
    function goTicket(num) {
        $.ajax({
            type: 'post',
            url: '{{route('getProvidersOfSpecificFlight')}}',
            data: {
                'flightId': tickets[nowDayI][num].flightId
            },
            success: function (response) {
                provider = JSON.parse(response);
                var date;
                switch (nowDayI) {
                    case 0:
                    default:
                        date = 'شنبه';
                        break;
                    case 1:
                        date = 'یکشنبه';
                        break;
                    case 2:
                        date = 'دوشنبه';
                        break;
                    case 3:
                        date = 'سه شنبه';
                        break;
                    case 4:
                        date = 'چهارشنبه';
                        break;
                    case 5:
                        date = 'پنج شنبه';
                        break;
                    case 6:
                        date = 'جمعه';
                        break;
                }
                var checkArrivalTime = false;
                if (parseInt(tickets[nowDayI][num].arrivalTime) == 0) {
                    var hArr = tickets[nowDayI][num].arrivalTime.split(':');
                    var hGo = tickets[nowDayI][num].time.split(':')[0];
                    var Start = '01/01/2007 ' + tickets[nowDayI][num].time + ':00';
                    var End = '01/01/2007 ' + tickets[nowDayI][num].arrivalTime + ':00';
                    if (parseInt(hArr[0]) < parseInt(hGo))
                        End = '01/02/2007 ' + tickets[nowDayI][num].arrivalTime + ':00';
                    var timeStart = new Date(Start).getTime();
                    var timeEnd = new Date(End).getTime();
                    var diff = timeEnd - timeStart;
                    diff /= 1000;
                    diff = Math.floor(diff / 3600) + 'h:' + (diff - (3600 * Math.floor(diff / 3600))) / 60 + 'm';
                    checkArrivalTime = true;
                }


                document.getElementById('informVisit').innerText = 'شهر {{$src[0]}} به شهر{{$dest[0]}}  در روز ' + date + ' در تاریخ ' + days[nowDayI] + '';
                document.getElementById('informCompany').innerText = tickets[nowDayI][num].line;
                document.getElementById('informDate').innerText = days[nowDayI];
                document.getElementById('informNoTicket').innerText = tickets[nowDayI][num].noTicket;
                document.getElementById('informSrc').innerText = 'از{{$src[0]}}';
                document.getElementById('informSrcTime').innerText = 'ساعت ' + tickets[nowDayI][num].time;
                document.getElementById('informSrcPort').innerText = 'فرودگاه {{$src[1]}}';

                document.getElementById('informDest').innerText = 'از{{$dest[0]}}';
                document.getElementById('informDestTime').innerText = 'ساعت ' + tickets[nowDayI][num].arrivalTime;
                document.getElementById('informDestPort').innerText = 'فرودگاه {{$dest[1]}}';

                var text = '';
                for (var i = 0; i < provider.length; i++) {

                    if (parseInt('{{$adult}}') + parseInt('{{$child}}') + parseInt('{{$infant}}') != 1) {
                        provider[i].totalMoney = (provider[i].price * parseInt('{{$adult}}')) + (provider[i].childPrice * parseInt('{{$child}}')) + (provider[i].infantPrice * parseInt('{{$infant}}'));
                        provider[i].num = parseInt('{{$adult}}') + parseInt('{{$child}}') + parseInt('{{$infant}}');
                    }
                    else {
                        provider[i].totalMoney = provider[i].price;
                        provider[i].num = 1;
                    }

                    @if($back == '')
                        var kindBack = 0;
                    @elseif($back == 0)
                        var kindBack = 1;
                    @else
                        var kindBack = 2;
                     @endif

                    text += '<div style="cursor: pointer; height: 130px; margin: 10px 5px 0; padding: 10px 0; border-top: 1.5px solid #aeaeae;" onclick="submitTicket(' + kindBack + ',' + provider[i].id + ')">\n' +
                            '                    <div style="float: right">\n' +
                            '                        <div style="background-color: #2d3e52">\n' +
                            '                            <img src="{{URL::asset('images/blitbin.png')}}" alt="لگو ' + provider[i].provider + '" class="offerImg">\n' +
                            '                        </div>\n' +
                            '                        <div>\n' +
                            '                            <div style="display: inline-block; font-weight: bold"> ' + provider[i].price + ' </div>\n' +
                            '                            <div style="display:inline-block; font-size: 0.9em;"> برای یک نفر </div>\n' +
                            '                        </div>\n' +
                            // '                        <div style="font-size: 0.8em; color: #ff0000"> ده درصد ذخیره </div>\n' +
                            '                    </div>\n' +
                            '                    <div style="float: left">\n' +
                            '                        <button class="btn viewOffersBtn" type="button" style="font-size: 1.3em !important;" > مشاهده پیشنهاد </button>\n' +
                            '                        <div style="font-size: 0.9em; margin-top: 5px">\n' +
                            '                            <div> قیمت بزرگسال :' + provider[i].price + ' </div>\n' +
                            '                            <div> قیمت کودک : ' + provider[i].childPrice + ' </div>\n' +
                            '                            <div> قیمت خردسال :  ' + provider[i].infantPrice + ' </div>\n' +
                            '                        </div>\n' +
                            '                    </div>\n' +
                            '                    <div style="display: inline-block; float: left; margin: 5px 10px; color: #92321b; line-height: 30px;"> ' + provider[i].totalMoney + ' برای ' + provider[i].num + ' نفر </div>\n' +
                            '                    </div>';
                }
                document.getElementById('informProvider').innerHTML = text;
                document.getElementById('informDiffBase').style.visibility = 'hidden';
                if (checkArrivalTime) {
                    document.getElementById('informDiff').innerText = diff;
                    document.getElementById('informDiffBase').style.visibility = '';
                }
                document.getElementById('visitOffers').classList.remove('hidden');
            }
        });

    }
    function closeFilterTab(kind) {
        switch (kind) {
            case 0:
                if (filterTab[kind] == 1) {
                    filterTab[kind] = 0;
                    document.getElementById('timeFilterTab1').style.display = 'none';
                    document.getElementById('timeFilterTab2').style.display = 'none';
                }
                else {
                    filterTab[kind] = 1;
                    document.getElementById('timeFilterTab1').style.display = '';
                    document.getElementById('timeFilterTab2').style.display = '';
                }
                break;
            case 1:
                if (filterTab[kind] == 1) {
                    filterTab[kind] = 0;
                    document.getElementById('kindFlightTab').style.display = 'none';
                }
                else {
                    filterTab[kind] = 1;
                    document.getElementById('kindFlightTab').style.display = '';
                }
                break;
            case 2:
                if (filterTab[kind] == 1) {
                    filterTab[kind] = 0;
                    document.getElementById('companyFlight').style.display = 'none';
                }
                else {
                    filterTab[kind] = 1;
                    document.getElementById('companyFlight').style.display = '';
                }
                break;
        }
    }
    function getTicketWarning() {
        var fromCity = $("#fromWarning").val();
        var toCity = $("#toWarning").val();
        var otherOffers;
        var email = 0;
        if ($('#otherOffers').prop("checked"))
            otherOffers = 1;
        else
            otherOffers = 0;
        @if(! Auth::check())
            email = $("#emailWarning").val();
        @endif
        $.ajax({
            type: 'post',
            url: '{{route('getTicketWarning')}}',
            data: {
                'from': fromCity,
                'to': toCity,
                'otherOffer': otherOffers,
                'email': email,
                'date': days[nowDayI]
            },
            success: function (response) {
                if (response == 1)
                    alert('ثبت شد!!');
                else
                    alert('no');
            }
        });
    }
    function searchForCity(e, targetDiv, resultDiv) {
        var selectedMode = "internalFlight";
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
                        for (var i = 0; i < response.length; i++) {
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
    function submitTicket(kind, id) {
        if(kind == 1) {
            @if($eDate[0] != '')
            if ('{{$back}}' == 0) {
                        @if($additional == 'اکونومی')
                var addi = 1;
                        @elseif($additional == 'فرست کلاس')
                var addi = 2;
                        @else
                var addi = 3;
                        @endif
                var edate = {{$eDate[0]}} +',' + {{$eDate[1]}} +',' + {{$eDate[2]}};
                var separateBackDay = edate.split(',');
                var separateDay = days[nowDayI].split('/');
                var sdate = separateDay[0] + ',' + separateDay[1] + ',' + separateDay[2];
                if ((separateDay[1] == separateBackDay[1] && separateDay[0] == separateBackDay[0] && separateDay[2] > separateBackDay[2]) || (separateDay[1] > separateBackDay[1] && separateDay[0] == separateBackDay[0]) || (separateDay[0] > separateBackDay[0])) {
                    edate = sdate;
                }
                document.location.href = '{{route('home')}}' + "/getTickets/{{$mode}}/{{$destination}}/{{$source}}/{{$adult}}/{{$child}}/{{$infant}}/" + addi + "/" + edate + "/" + sdate + "/1/" + id;
            }
            @endif
        }
        else if(kind == 0)
            document.location.href = '{{route('home')}}' + '/preBuyInnerFlight/' + id + '/' + adult + '/' + child + '/' + infant;

        else if( kind == 2) {
            @if($ticketGo != '')
            document.location.href = '{{route('home')}}' + '/preBuyInnerFlight/{{$ticketGo->id}}/' + adult + '/' + child + '/' + infant + '/' + id;
            @endif
        }
    }
    // function openEditTicket(){
    //     document.getElementById('showInformTicket').classList.add('hidden');
    //     document.getElementById('search').classList.remove('hidden');
    // }
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
    function addClassHidden(element) {
        $("#" + element).addClass('hidden');
        if (element == 'classNoSelectPane') {
            $("#classArrowDown").removeClass('hidden');
            $("#classArrowUp").addClass('hidden');
        }
        if (element == 'typeNoSelectPane')
            $("#typeArrow").css('background-position', '-10px -123px');
        if (element == 'passengerNoSelectPane'){
            $("#passengerArrowDown").removeClass('hidden');
            $("#passengerArrowUp").addClass('hidden');
        }
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

        document.getElementById('searchAge').innerHTML = '<span style="float: right;"   >' + adult + '</span>&nbsp;\n' +
            '                                                <span>بزرگسال</span>&nbsp;-&nbsp;\n' +
            '                                                <span id="childPassengerNo">' + child + '</span>\n' +
            '                                                <span>کودک</span>&nbsp;-&nbsp;\n' +
            '                                                <span id="infantPassengerNo">' + infant + '</span>\n' +
            '                                                <span>نوزاد</span>&nbsp;';
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


    function FormatNumberBy3(num) {
        // check for missing parameters and use defaults if so

        var sep = ",";
        var decpoint = ".";
        // need a string for operations
        num = num.toString();
        // separate the whole number and the fraction if possible
        a = num.split(decpoint);
        x = a[0]; // decimal
        y = a[1]; // fraction
        z = "";


        if (typeof(x) != "undefined") {
            // reverse the digits. regexp works from left to right.
            for (var i=x.length-1;i>=0;i--)
                z += x.charAt(i);
            // add seperators. but undo the trailing one, if there
            z = z.replace(/(\d{3})/g, "$1" + sep);
            if (z.slice(-sep.length) == sep)
                z = z.slice(0, -sep.length);
            x = "";
            // reverse again to get back the number
            for (var i=z.length-1;i>=0;i--)
                x += z.charAt(i);
            // add the fraction back in, if it was there
            if (typeof(y) != "undefined" && y.length > 0)
                x += decpoint + y;
        }
        return x;
    }




</script>

{{--//برای سفر های خارجی--}}
{{--text += '<div id="" class="col-md-12">\n' +--}}
{{--'            <div class="boxTicket">\n' +--}}
{{--'            <div class="row" style="height: 165px;">\n' +--}}
{{--'            <div class="col-md-3 "\n' +--}}
{{--'        style="margin-top: 10px; border-right: solid 2px #aeaeae; padding-left: 25px; margin-bottom: 10px; max-width: 25%; !important; text-align: center">\n' +--}}
{{--'            <h6 style="color: #9f3322;">بهترین قیمت از</h6>\n' +--}}
{{--'        <h5> 650.000</h5>\n' +--}}
{{--'        <h6>مجموع 1.950.000</h6>\n' +--}}
{{--'        <div style="">\n' +--}}
{{--'            <button class="btn viewOffersBtn" type="button"> مشاهده پیشنهاد ها\n' +--}}
{{--'        </button>\n' +--}}
{{--'        </div>\n' +--}}
{{--'        <h6 style="color: dodgerblue; margin-top: 10px;">به همراه 10 پیشنهاد\n' +--}}
{{--'        دیگر</h6>\n' +--}}
{{--'        </div>\n' +--}}
{{--'        <div class="col-md-6 set-center" style="max-width: 50%; !important;">\n' +--}}
{{--// '            <div style="width: 98%; height: 35%; margin: 5px; position: absolute; right: 0%">\n' +--}}
{{--// '            <div style="width: 10%; display: inline-block; position: absolute; top: 15%; left: 2%;">\n' +--}}
{{--// '            <div> 5h00m </div>\n' +--}}
{{--// '        <div style="color: #92321b"> 1h15m </div>\n' +--}}
{{--// '        </div>\n' +--}}
{{--// '        <div class="explainPurpose" style="left: 13%">\n' +--}}
{{--// '            <div> مقصد </div>\n' +--}}
{{--// '            <div style="width: 15px;height: 15px;border-radius: 50%;background-color: gray; margin: 0 auto"></div>\n' +--}}
{{--// '            <div> 12:35 </div>\n' +--}}
{{--// '        </div>\n' +--}}
{{--// '        <div class="explainFlight">\n' +--}}
{{--// '            <div style="position: absolute; left: 15%; top: 20%;"> 1h45m </div>\n' +--}}
{{--// '        <div style="position: absolute; right: 15%; top: 20%;"> 2h00m </div>\n' +--}}
{{--// '        <div class="explainStop">\n' +--}}
{{--// '            <div> توقف </div>\n' +--}}
{{--// '            <div style="width: 10px;height: 10px;border-radius: 50%;background-color: #92321b; margin: 0 auto"></div>\n' +--}}
{{--// '            <div style="display: inline-block; margin-right: 5px;"> 11:30 </div>\n' +--}}
{{--// '        <div style="display: inline-block; margin-left: 5px;"> 10:35 </div>\n' +--}}
{{--// '        </div>\n' +--}}
{{--// '        <div style="width: 100%;border: 0.8px solid gray; position: absolute; top: 49%;"></div>\n' +--}}
{{--// '            <div class="shTIcon leftArrowIcon"></div>\n' +--}}
{{--// '            </div>\n' +--}}
{{--// '            <div class="explainPurpose" style="right: 0">\n' +--}}
{{--// '            <div> مبدأ </div>\n' +--}}
{{--// '            <div style="width: 15px;height: 15px;border-radius: 50%;background-color: gray; margin: 0 auto"></div>\n' +--}}
{{--// '            <div> 8:35 </div>\n' +--}}
{{--// '        </div>\n' +--}}
{{--// '        </div>\n' +--}}
{{--'        <div style="width: 98%; height: 35%; margin: 5px; position: absolute; top: 30%; right: 0%">\n' +--}}
{{--'            <div style="width: 10%; display: inline-block; position: absolute; top: 15%; left: 2%;">\n' +--}}
{{--'            <div> 5h00m </div>\n' +--}}
{{--'        <div style="color: #92321b"> 1h15m </div>\n' +--}}
{{--'        </div>\n' +--}}
{{--'        <div class="explainPurpose" style="left: 13%">\n' +--}}
{{--'            <div> مقصد </div>\n' +--}}
{{--'            <div style="width: 15px;height: 15px;border-radius: 50%;background-color: gray; margin: 0 auto"></div>\n' +--}}
{{--'            <div> 12:35 </div>\n' +--}}
{{--'        </div>\n' +--}}
{{--'        <div class="explainFlight">\n' +--}}
{{--'            <div style="position: absolute; left: 15%; top: 20%;"> 1h45m </div>\n' +--}}
{{--'        <div style="position: absolute; right: 15%; top: 20%;"> 2h00m </div>\n' +--}}
{{--'        <div class="explainStop">\n' +--}}
{{--'            <div> توقف </div>\n' +--}}
{{--'            <div style="width: 10px;height: 10px;border-radius: 50%;background-color: #92321b; margin: 0 auto"></div>\n' +--}}
{{--'            <div style="display: inline-block; margin-right: 5px;"> 11:30 </div>\n' +--}}
{{--'        <div style="display: inline-block; margin-left: 5px;"> 10:35 </div>\n' +--}}
{{--'        </div>\n' +--}}
{{--'        <div style="width: 100%;border: 0.8px solid gray; position: absolute; top: 49%;"></div>\n' +--}}
{{--'            <div class="shTIcon leftArrowIcon"></div>\n' +--}}
{{--'            </div>\n' +--}}
{{--'            <div class="explainPurpose" style="right: 0">\n' +--}}
{{--'            <div> مبدأ </div>\n' +--}}
{{--'            <div style="width: 15px;height: 15px;border-radius: 50%;background-color: gray; margin: 0 auto"></div>\n' +--}}
{{--'            <div> 8:35 </div>\n' +--}}
{{--'        </div>\n' +--}}
{{--'        </div>\n' +--}}
{{--'        </div>\n' +--}}
{{--'        <div class="col-md-3 set-center"\n' +--}}
{{--'        style="text-align:center;height: auto; border-left: solid 2px #aeaeae; margin-bottom: 10px;margin-top: 10px;">\n' +--}}
{{--'            <div style="width: 100%; height: 40%; position: absolute;">\n' +--}}
{{--'            <div class="airlinesImage"></div>\n' +--}}
{{--'            <div class="airlinesText">کاسپین</div>\n' +--}}
{{--'            </div>\n' +--}}
{{--'\n' +--}}
{{--'            <div style="width: 100%; height: 40%;  position: absolute; top: 50%;">\n' +--}}
{{--'            <div class="airlinesImage"></div>\n' +--}}
{{--'            <div class="airlinesText">کاسپین</div>\n' +--}}
{{--'            </div>\n' +--}}
{{--'            </div>\n' +--}}
{{--'            </div>\n' +--}}
{{--'            <div id="myModal" class="modal-content">\n' +--}}
{{--'            <div class="col-md-12" style="width: 100%; border-bottom: solid 0.8px gray;">\n' +--}}
{{--'            <div class="col-md-3 set-center selected-filter"\n' +--}}
{{--'        style="float: right; padding-right: 0; width: 15%;">\n' +--}}
{{--'            <h6>جزییات پرواز</h6>\n' +--}}
{{--'        </div>\n' +--}}
{{--'        <div class="col-md-3 set-center selected-filter"\n' +--}}
{{--'        style="width: 10%; padding-right: 0; float: right;">\n' +--}}
{{--'            <h6>قیمت</h6>\n' +--}}
{{--'            </div>\n' +--}}
{{--'            <div id="shortestTime" class="col-md-3 set-center selected-filter "\n' +--}}
{{--'        onclick="addSelected(\'shortestTime\')"\n' +--}}
{{--'        style="float: right; width: 20%; padding-right: 0;">\n' +--}}
{{--'            <h6>نقدها و نظرات</h6>\n' +--}}
{{--'        </div>\n' +--}}
{{--'        <div id="modal" style="width: 30px; display: inline-block;">close</div>\n' +--}}
{{--'            </div>\n' +--}}
{{--'            <div style="margin-top: 30px;">\n' +--}}
{{--'            <div style="width: 40%; display: inline-block; float: right; border-left: solid 0.8px gray; padding: 10px;">\n' +--}}
{{--'            right\n' +--}}
{{--'            </div>\n' +--}}
{{--'            <div style="width: 60%; display: inline-block; padding: 10px;">\n' +--}}
{{--'            left\n' +--}}
{{--'            </div>\n' +--}}
{{--'            </div>\n' +--}}
{{--'            </div>\n' +--}}
{{--'            </div>\n' +--}}
{{--'            </div>';--}}



{{--<div style="width: 100%; height: 40%;  position: absolute; top: 50%;">--}}
{{--<div class="airlinesImage"></div>--}}
{{--<div class="airlinesText">کاسپین</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div id="myModal" class="modal-content">--}}
{{--<div class="col-md-12" style="width: 100%; border-bottom: solid 0.8px gray;">--}}
{{--<div class="col-md-3 set-center selected-filter"--}}
{{--style="float: right; padding-right: 0; width: 15%;">--}}
{{--<h6>جزییات پرواز</h6>--}}
{{--</div>--}}
{{--<div class="col-md-3 set-center selected-filter"--}}
{{--style="width: 10%; padding-right: 0; float: right;">--}}
{{--<h6>قیمت</h6>--}}
{{--</div>--}}
{{--<div id="shortestTime" class="col-md-3 set-center selected-filter "--}}
{{--onclick="addSelected('shortestTime')"--}}
{{--style="float: right; width: 20%; padding-right: 0;">--}}
{{--<h6>نقدها و نظرات</h6>--}}
{{--</div>--}}
{{--<div id="modal" style="width: 30px; display: inline-block;">close</div>--}}
{{--</div>--}}
{{--<div style="margin-top: 30px;">--}}
{{--<div style="width: 40%; display: inline-block; float: right; border-left: solid 0.8px gray; padding: 10px;">--}}
{{--right--}}
{{--</div>--}}
{{--<div style="width: 60%; display: inline-block; padding: 10px;">--}}
{{--left--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div id="middle" class="col-md-12">--}}
{{--<div class="boxSale">--}}
{{--<div class="ticket-type"> سیستمی</div>--}}
{{--<div style="float: left; color: #92321b; margin: 3px 10px; font-size: 1.3em; line-height: 24px;">--}}
{{--ده درصد تخفیف--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div id="middle" class="col-md-12">--}}
{{--<div class="boxOffer"--}}
{{--style="background-color: #ebebeb; box-shadow: 0px 0px 3px 3px #F9F9F9;">--}}
{{--<div style="display: inline-block">--}}
{{--<div style="font-size: 1.6em"> بهترین قیمت این پرواز را از علی بابا بخواهید--}}
{{--</div>--}}
{{--<div style="font-size: 1.3em"> قیمت های مبدا به مقصد را در تاریخ --- در علی بابا--}}
{{--ببینید--}}
{{--</div>--}}
{{--</div>--}}

{{--<div style="float: left">--}}
{{--<button class="btn viewOffersBtn" type="button"--}}
{{--style="width: 125px; line-height: 20px; border-radius: 1px;"> مشاهده--}}
{{--پیشنهاد--}}
{{--</button>--}}
{{--<div style="text-align: center; cursor: pointer; margin-top: 3px;"> لینک--}}
{{--تبلیغاتی--}}
{{--</div>--}}
{{--</div>--}}

{{--<div style="display: inline-block; float: left; margin-left: 5px;">--}}
{{--<img src="https://cdn.alibaba.ir/img/logo.5f19c7a.svg" alt="لوگو علی بابا"--}}
{{--class="offerImg">--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}



{{--<div id="middle" class="col-md-12">--}}
    {{--<div class="boxTicket">--}}
        {{--<div class="row" style="height: 165px;">--}}
            {{--<div class="col-md-3" style="margin-top: 10px; border-right: solid 2px #aeaeae; padding-left: 25px; margin-bottom: 10px; max-width: 25%; !important; text-align: center; position: relative">--}}
                {{--<img src="https://cdn.alibaba.ir/img/logo.5f19c7a.svg" alt="لوگو علی بابا" class="offerImg">--}}
                {{--<div style="color: #92321b">--}}
                    {{--<h6 style="display: inline-block">برای سه نفر</h6>--}}
                    {{--<h5 style="display: inline-block">مجموع 1.950.000</h5>--}}
                {{--</div>--}}
                {{--<h6 style="color: #92321b; margin-top: 10px; text-align: left; position: absolute; bottom: 0;">ویرایش</h6>--}}
            {{--</div>--}}
            {{--<div class="col-md-6 set-center" style="max-width: 50%; !important;">--}}
                {{--<div style="width: 98%; height: 35%; margin: 5px; position: absolute; right: 0%">--}}
                    {{--<div style="width: 10%; display: inline-block; position: absolute; top: 15%; left: 2%;">--}}
                        {{--<div> 5h00m </div>--}}
                        {{--<div style="color: #92321b"> 1h15m </div>--}}
                    {{--</div>--}}
                    {{--<div class="explainPurpose" style="left: 13%">--}}
                        {{--<div> مقصد </div>--}}
                        {{--<div style="width: 15px;height: 15px;border-radius: 50%;background-color: gray; margin: 0 auto"></div>--}}
                        {{--<div> 12:35 </div>--}}
                    {{--</div>--}}
                    {{--<div class="explainFlight">--}}
                        {{--<div style="position: absolute; left: 15%; top: 20%;"> 1h45m </div>--}}
                        {{--<div style="position: absolute; right: 15%; top: 20%;"> 2h00m </div>--}}
                        {{--<div class="explainStop">--}}
                            {{--<div> توقف </div>--}}
                            {{--<div style="width: 10px;height: 10px;border-radius: 50%;background-color: #92321b; margin: 0 auto"></div>--}}
                            {{--<div style="display: inline-block; margin-right: 5px;"> 11:30 </div>--}}
                            {{--<div style="display: inline-block; margin-left: 5px;"> 10:35 </div>--}}
                        {{--</div>--}}
                        {{--<div style="width: 100%;border: 0.8px solid gray; position: absolute; top: 49%;"></div>--}}
                        {{--<div class="shTIcon leftArrowIcon"></div>--}}
                    {{--</div>--}}
                    {{--<div class="explainPurpose" style="right: 0">--}}
                        {{--<div> مبدأ </div>--}}
                        {{--<div style="width: 15px;height: 15px;border-radius: 50%;background-color: gray; margin: 0 auto"></div>--}}
                        {{--<div> 8:35 </div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div style="width: 98%; height: 35%; margin: 5px; position: absolute; top: 50%; right: 0%">--}}
                    {{--<div style="width: 10%; display: inline-block; position: absolute; top: 15%; left: 2%;">--}}
                        {{--<div> 5h00m </div>--}}
                        {{--<div style="color: #92321b"> 1h15m </div>--}}
                    {{--</div>--}}
                    {{--<div class="explainPurpose" style="left: 13%">--}}
                        {{--<div> مقصد </div>--}}
                        {{--<div style="width: 15px;height: 15px;border-radius: 50%;background-color: gray; margin: 0 auto"></div>--}}
                        {{--<div> 12:35 </div>--}}
                    {{--</div>--}}
                    {{--<div class="explainFlight">--}}
                        {{--<div style="position: absolute; left: 15%; top: 20%;"> 1h45m </div>--}}
                        {{--<div style="position: absolute; right: 15%; top: 20%;"> 2h00m </div>--}}
                        {{--<div class="explainStop">--}}
                            {{--<div> توقف </div>--}}
                            {{--<div style="width: 10px;height: 10px;border-radius: 50%;background-color: #92321b; margin: 0 auto"></div>--}}
                            {{--<div style="display: inline-block; margin-right: 5px;"> 11:30 </div>--}}
                            {{--<div style="display: inline-block; margin-left: 5px;"> 10:35 </div>--}}
                        {{--</div>--}}
                        {{--<div style="width: 100%;border: 0.8px solid gray; position: absolute; top: 49%;"></div>--}}
                        {{--<div class="shTIcon leftArrowIcon"></div>--}}
                    {{--</div>--}}
                    {{--<div class="explainPurpose" style="right: 0">--}}
                        {{--<div> مبدأ </div>--}}
                        {{--<div style="width: 15px;height: 15px;border-radius: 50%;background-color: gray; margin: 0 auto"></div>--}}
                        {{--<div> 8:35 </div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="col-md-3 set-center"--}}
                 {{--style="text-align:center;height: auto; border-left: solid 2px #aeaeae; margin-bottom: 10px;margin-top: 10px;">--}}
                {{--<div style="width: 100%; height: 40%; position: relative;">--}}
                    {{--<div style="color: #92321b; position: absolute; top: 0; right: 3%;"> پرواز رفت </div>--}}
                    {{--<div class="airlinesImage"></div>--}}
                    {{--<div class="airlinesText">کاسپین</div>--}}
                {{--</div>--}}


</html>