@extends('layouts.bodyPlace')

@section('title')

    <title>تور {{$tour->name}}</title>
@stop

@section('meta')

@stop

@section('header')
    @parent
    <link rel="stylesheet" href="{{URL::asset('css/theme2/tourDetails.css?v=1')}}">


    <style>
        body{
            background: white;
        }
        .changeWidth {
            @if(session('goDate'))
                   width: 14% !important;
            @endif
        }

        .poiTile {
            float: left;
        }
        .dayScheduleSec{
            display: flex;
            justify-content: flex-start;
            align-items: center;
            padding: 25px;
            background: white;
            overflow: auto;
        }
        .dayScheduleSec .circleSection{
            width: 150px;
            height: 60px;
            border-radius: 50%;
            border: dashed 2px black;
            position: relative;
        }
        .dayScheduleSec .circleSection:before{
            content: '';
            width: 107%;
            background: white;
            height: 60%;
            position: absolute;
            right: -4%;
        }
        .dayScheduleSec .circleSection.top{
            margin-top: 5px;
        }
        .dayScheduleSec .circleSection.bottom{
            margin-bottom: 5px;
        }
        .dayScheduleSec .circleSection.top:before{
            bottom: -5%;
        }
        .dayScheduleSec .circleSection.bottom:before{
            top: -5%;
        }
        .dayScheduleSec .circleSection .circle{
            position: absolute;
            width: 30px;
            height: 30px;
            background: red;
            border-radius: 50%;
            border: solid 1px;
            cursor: pointer;
            transition: .3s;
        }
        .dayScheduleSec .circleSection .circle:hover{
            opacity: .8;
        }
        .dayScheduleSec .circleSection .firstCircle{
            left: -18px;
            top: calc(50% - 15px);
        }
        .dayScheduleSec .circleSection .middleCircle{
            right: calc(50% - 15px);
        }
        .dayScheduleSec .circleSection.top .middleCircle{
            top: -15px;
        }
        .dayScheduleSec .circleSection.bottom .middleCircle{
            bottom: -15px;
        }
        .dayScheduleSec .circleSection .lastCircle{
            right: -15px;
            top: calc(50% - 15px);
        }

        .tourDailyScheduleGuideMainDiv{
            display: flex;
            direction: rtl;
            justify-content: flex-end;
            position: relative;
            margin-top: 20px;
        }
        .tourDailyScheduleGuideBoxes{
            border: 1px solid black;
            width: 35px;
            position: relative;
            height: 70px;
            display: flex;
            padding: 0;
            justify-content: center;
            margin: 10px 5px;
        }
        .tourDailyScheduleGuideBoxes .text{
            transform: rotate(90deg);
            font-size: 11px;
            position: absolute;
            width: 75px;
            bottom: 35px;
            font-weight: bold;
        }
        .tourScheduleGuideColor{
            position: absolute;
            top: -15px;
            right: 4px;
        }



        .sidePicMainContent{
            direction: rtl;
            margin-bottom: 25px;
        }
        .sidePicMainContent .title1{
            margin: 0;
            text-align: right;
            font-size: 28px;
            font-weight: bold;
        }
        .sidePicMainContent .dayCounts{
            font-size: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            margin-bottom: 5px;
        }
        .sidePicMainContent .dayCounts .ddccoou{
            margin-right: auto;
            font-size: 18px;
            font-weight: bold;
            color: #000000d1;
            margin-left: 13px;
        }

        .sidePicMainContent .srcDescSec{
            display: flex;
            align-items: center;
            margin: 10px 0px;
            font-size: 15px;
        }
        .sidePicMainContent .srcDescSec .src{

        }
        .sidePicMainContent .srcDescSec .leftArrowWithBody{
            padding-top: 5px;
            font-size: 50px;
            line-height: 10px;
            margin: 0px 15px;
            color: var(--koochita-red);
        }
        .boldFontMargSide10{
            font-weight: bold;
            margin: 0px 10px;
        }

        .tourDetailsBottomBox > div{
            padding: 0px;
        }
        .tourDetailsBottomBox .tourAgencyExp{
            display: flex;
            direction: rtl;
        }

        .tourStyle{
            display: flex;
            flex-wrap: wrap;
        }
        .tourStyle .styleItem{
            background: #0076a3c9;
            color: white;
            padding: 6px 10px;
            margin: 5px;
            border-radius: 5px;
            font-size: 12px;
            margin-right: 0;
        }

    </style>
@stop

@section('main')

    <div class="ppr_rup ppr_priv_hr_atf_north_star_nostalgic">

{{--        <div class="atf_header_wrapper">--}}
{{--            <div class="container" style="position: relative; direction: rtl;">--}}
{{--                <div class="ppr_rup ppr_priv_location_detail_header">--}}
{{--                    <h1 id="HEADING" class="heading_title " property="name">{{$tour->name}}</h1>--}}
{{--                    <div class="rating_and_popularity">--}}
{{--                        <span class="header_rating">--}}
{{--                           <div class="rs rating" rel="v:rating">--}}
{{--                               <div class="prw_rup prw_common_bubble_rating overallBubbleRating" style="float: right;">--}}
{{--                                   <span class="ui_bubble_rating bubble_50" style="font-size:16px;" property="ratingValue" content="5" alt='5 of 5 bubbles'></span>--}}
{{--                               </div>--}}
{{--                               <span class="more taLnk" href="#REVIEWS" style="margin-right: 15px;">--}}
{{--                                   <span property="v:count" id="commentCount">20</span> نقد--}}
{{--                               </span>--}}
{{--                           </div>--}}
{{--                        </span>--}}
{{--                        <span class="header_popularity popIndexValidation" style="margin-right: 0 !important">--}}
{{--                            <span>10 امتیاز</span>--}}
{{--                        </span>--}}
{{--                    </div>--}}
{{--                    <div style="position: relative">--}}
{{--                        <span class="ui_button_overlay" style="position: relative; float: left">--}}
{{--                            <div id="targetHelp_7" class="targets" style="float: right; position: relative">--}}
{{--                                <span class="ui_button saves ui_icon">لیست سفر</span>--}}
{{--                                <div id="helpSpan_7" class="helpSpans row hidden">--}}
{{--                                    <span class="introjs-arrow"></span>--}}
{{--                                    <p class="col-xs-12" style="font-size: 12px; line-height: 1.428 !important;">--}}
{{--                                        در هر مکانی که هستید با زدن این دکمه می توانید، آن مکان را به لیست سفرهای خود اضافه کنید. به سادگی همراه با دوستان تان سفر های خود را برنامه ریزی کنید. به سادگی همین دکمه...--}}
{{--                                    </p>--}}
{{--                                    <button data-val="7" class="btn btn-success nextBtnsHelp" id="nextBtnHelp_7">بعدی</button>--}}
{{--                                    <button data-val="7" class="btn btn-primary backBtnsHelp" id="backBtnHelp_7">قبلی</button>--}}
{{--                                    <button class="btn btn-danger exitBtnHelp">خروج</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <span class="btnoverlay loading">--}}
{{--                                <span class="bubbles small">--}}
{{--                                    <span></span>--}}
{{--                                    <span></span>--}}
{{--                                    <span></span>--}}
{{--                                </span>--}}
{{--                            </span>--}}
{{--                        </span>--}}
{{--                        <div class="prw_rup prw_common_atf_header_bl headerBL" style="width:50%">--}}
{{--                            <div class="tourHeaderDetailsRow full-width">--}}
{{--                                <div class="inline-block col-xs-3">--}}
{{--                                    <span >حرکت از:</span>--}}
{{--                                    <span>{{$tour->src->name ?? ''}}</span>--}}
{{--                                </div>--}}
{{--                                <div class="inline-block col-xs-3" onclick="showExtendedMap()">--}}
{{--                                    <span class="street-address">مقصد: </span>--}}
{{--                                    <span>{{$tour->dest->name ?? ''}}</span>--}}
{{--                                </div>--}}
{{--                                <div class="inline-block col-xs-3">--}}
{{--                                    <span>نوع تور:</span>--}}
{{--                                    <span>گردشگری</span>--}}
{{--                                </div>--}}
{{--                                <div class="inline-block col-xs-3">--}}
{{--                                    <span >درجه سختی:</span>--}}
{{--                                    <span>ساده</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="container secondRowSection">
            <div class="bestPriceRezerved col-xs-5">
                <div class="sidePicMainContent">
                    <div class="title1">{{$tour->name}}</div>
                    <div class="srcDescSec">
                        <div> از </div>
                        <div class="boldFontMargSide10">{{$tour->src->name}}</div>
                        <div> به </div>
                        <div class="boldFontMargSide10">{{$tour->dest->name}}</div>
                    </div>
                    <div class="dayCounts">
                        <div> از </div>
                        <div class="boldFontMargSide10">{{$tour->sDate}}</div>
                        <div> تا </div>
                        <div class="boldFontMargSide10">{{$tour->eDate}}</div>
                        <div class="ddccoou">{{$tour->day}} روزه</div>
                    </div>
                    <div class="isTourPrivSec">

                    </div>
                    <div class="tourStyle">
                        @foreach($tour->style as $item)
                            <div class="styleItem">{{$item}}</div>
                        @endforeach
                    </div>
                </div>

                <div class="offerBox tourDetailsBottomBox row">
                    <div class="tourPriceDescription col-xs-6">
                        <div class="fullyCenterContent" style="flex-direction: column;">
                            <div class="offerPrice">
                                شروع قیمت از
                                <span class="mainCost"></span>
                            </div>
                            <button class="btn viewOffersBtn" type="button">خرید</button>
                        </div>
                    </div>
                    <div class="tourDescription col-xs-6">
                        <div class="tourAgencyExp">
                            <div class="tourAgencyLogo circleBase type2"></div>
                            <div class="tourAgencyName">
                                <div class="full-width">آژانس ستاره طلایی</div>
                                <div class="prw_rup prw_common_bubble_rating overallBubbleRating full-width" style="float: right;">
                                    <span class="ui_bubble_rating bubble_50" style="font-size:16px;" property="ratingValue" content="5" alt='5 of 5 bubbles'></span>
                                </div>
                                <div>
                                    <div>0 نقد</div>
                                    <div>1 امتیاز</div>
                                </div>
                            </div>
                        </div>
{{--                        <div class="fullyCenterContent">--}}
{{--                            <hr class="tourExpDivider">--}}
{{--                        </div>--}}
{{--                        <div id="tourExpDiscountAlerts" class="tourExpDiscountAlerts fullyCenterContent discountAlerts"></div>--}}
                    </div>
                </div>
            </div>
            <div class="mainSliderSection col-xs-7">
                <div class="posRelWH100">
                    <div {{isset($tour->pics) && count($tour->pics) > 0 ? "onclick=showPhotoAlbum('allPic')" : ''}} style="width: 100%; height: 100%;">
                        <div id="mainSlider" class="swiper-container">
                            <div class="swiper-wrapper">
                                @foreach($tour->pics as $pic)
                                    <div class="swiper-slide" style="overflow: hidden">
                                        <img class="eachPicOfSlider resizeImgClass" src="{{$pic->pic}}" alt="{{$tour->name}}" onload="fitThisImg(this)">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="left-nav left-nav-header swiper-button-next mainSliderNavBut"></div>
                    <div class="right-nav right-nav-header swiper-button-prev mainSliderNavBut"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="display: flex; flex-direction: column;">
        <div class="menuTabsSticky">
            <a href="#ansAndQeustionDiv">سوال و جواب</a>
            <a href="#nearbyDiv">مکان های نزدیک</a>
            <a href="#photosDiv">عکس ها</a>
            <a href="#similars">هتل های مشابه</a>
            <a href="#reviewsDiv">نقدها</a>
            <a href="#introduction">معرفی کلی</a>
        </div>
        <div class="hr_btf_wrap" style="position: relative;">
            <div id="introduction" class="ppr_rup ppr_priv_location_detail_overview">
                <div class="block_wrap" data-tab="TABS_OVERVIEW">
                    <div style="margin: 15px 0 !important;">
                        <div id="showMore" onclick="showMore()" style="float: left; cursor: pointer;color:var(--koochita-light-green); font-size: 13px;" class="hidden">بیشتر</div>
                        <div class="overviewContent" id="introductionText" style="direction: rtl; font-size: 14px; max-height: 21px; overflow: hidden;"></div>
                    </div>
                    <div class="overviewContent">
                        <div class="ui_columns is-multiline is-mobile reviewsAndDetails" style="direction: ltr;">
                            <div class="ui_column is-8 details">
                                <div id="tourScheduleDetailsMainDiv" class="full-width inline-block">
                                    <div id="tourSchedulePeriodDetails" class="col-xs-6">
                                        <span>از</span>
                                        <span class="sDateTour"></span>
                                        <span onclick="changeTwoCalendar(2); nowCalendar()" class="ui_icon calendar calendarIcon"></span>
                                        <span>تا</span>
                                        <span class="eDateTour"></span>
                                        <div class="full-width inline-block">
                                            <span>این تور در تاریخ‌های متفاوتی ارائه می‌گردد</span>
                                        </div>
                                    </div>
                                    <div id="tourScheduleDayCounterDiv" class="col-xs-6">
                                        <span class="tourDay"></span>
                                        <span>روز و</span>
                                        <span class="tourNight"></span>
                                        <span>شب</span>
{{--                                        <div class="full-width inline-block">--}}
{{--                                            <span>چند روز آخر هفته و چند روز کاری و چند روز تعطیل</span>--}}
{{--                                        </div>--}}
                                    </div>
                                </div>
                                <div id="tourTransportationDetailsMainDiv" class="full-width inline-block">
                                    <div class="block_header" style="border: none; padding: 0 0 7px 0; margin: 0 ">
                                        <h4 class="block_title" style="padding-bottom: 10px; font-size: 18px">حمل و نقل اصلی</h4>
                                    </div>
                                    <table class="tourTransportationDetails full-width mainTransportDetails">
                                        <tr>
                                            <th></th>
                                            <th>نوع وسیله</th>
                                            <th>تاریخ حرکت</th>
                                            <th>محل حرکت</th>
                                            <th>توضیحات</th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td class="sTransportName"></td>
                                            <td class="sTransportDate"></td>
                                            <td class="sTransportAddress"></td>
                                            <td class="sTransportDescription"></td>
                                            <td><button>نقشه</button></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td class="eTransportName"></td>
                                            <td class="eTransportDate"></td>
                                            <td class="eTransportAddress"></td>
                                            <td class="eTransportDescription"></td>
                                            <td><button>نقشه</button></td>
                                        </tr>
                                    </table>
                                </div>
                                <div id="tourResidenceDetailsMainDiv" class="full-width inline-block">
                                    <div class="block_header" style="border: none; padding: 0 0 7px 0; margin: 0 ">
                                        <h4 class="block_title" style="padding-bottom: 10px; font-size: 18px">نوع اقامتگاه</h4>
                                    </div>
                                    <table class="tourResidenceDetails full-width">
                                        <tr>
                                            <td>
                                                <div class="full-width tourResidenceImg"></div>
                                            </td>
                                            <td>
                                                <b class="full-width inline-block">هتل آناهیتا</b>
                                                <span>درجه هتل:</span>
                                                <span>پنج ستاره</span>
                                            </td>
                                            <td>
                                                <div class="prw_rup prw_common_bubble_rating overallBubbleRating full-width" style="float: right;">
                                                    <span class="ui_bubble_rating bubble_50" property="ratingValue" content="5" alt='5 of 5 bubbles' style="font-size:16px;"></span>
                                                    <div style="margin-top: 5px;">
                                                        <div class="inline-block">0 نقد</div>
                                                        <div class="inline-block">1 امتیاز</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="blEntry address" style="white-space: normal;">
                                                    <span class="ui_icon map-pin"></span>
                                                    <span class="street-address"> </span>
                                                    <span style="font-size: 12px;"> شیراز، خیابان شیرازی</span>
                                                </div>
                                            </td>
                                            <td> +650000 </td>
                                            <td>
                                                <button>انتخاب</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="full-width tourResidenceImg"></div>
                                            </td>
                                            <td>
                                                <b class="full-width inline-block">هتل آناهیتا</b>
                                                <span>درجه هتل:</span>
                                                <span>پنج ستاره</span>
                                            </td>
                                            <td>
                                                <div class="prw_rup prw_common_bubble_rating overallBubbleRating full-width" style="float: right;">
                                                    <span class="ui_bubble_rating bubble_50" style="font-size:16px;" property="ratingValue" content="5" alt='5 of 5 bubbles'></span>
                                                    <div style="margin-top: 5px;">
                                                        <div class="inline-block">0 نقد</div>
                                                        <div class="inline-block">1 امتیاز</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="blEntry address" style="white-space: normal;">
                                                    <span class="ui_icon map-pin"></span>
                                                    <span class="street-address"> </span>
                                                    <span style="font-size: 12px;"> شیراز، خیابان شیرازی </span>
                                                </div>
                                            </td>
                                            <td> +650000 </td>
                                            <td>
                                                <button>انتخاب</button>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                                <div id="tourMoreOptionsMainDiv" class="full-width inline-block">
                                    <div class="block_header" style="border: none; padding: 0 0 7px 0; margin: 0 ">
                                        <h4 class="block_title" style="padding-bottom: 10px; font-size: 18px">امکانات اضافه</h4>
                                    </div>
                                    <table class="tourMoreOptionsDetails full-width additionalFeatures">
                                        <tr>
                                            <th></th>
                                            <th>نام مکان</th>
                                            <th>توضیحات</th>
                                            <th>افزایش قیمت</th>
                                        </tr>
                                    </table>

                                </div>
                                <div id="tourRestInfosMainDiv" class="full-width inline-block">
                                    <div id="tourStartEndPoint" class="col-xs-3">
                                        <span>مقصد: </span>
                                        <span class="destinationName"></span>
                                        <span>حرکت از: </span>
                                        <span class="srcName"></span>
                                    </div>
                                    <div id="tourStartEndTime" class="col-xs-4">
                                        <span>از: </span>
                                        <span class="sDateTour"></span>
                                        <span>تا: </span>
                                        <span class="eDateTour"></span>
                                    </div>
                                    <div id="tourPeriodTime" class="col-xs-2">
                                        <span class="tourDay"></span>
                                        <span>روز و </span>
                                        <span class="tourNight"></span>
                                        <span>شب</span>
                                    </div>
                                    <div id="tourRestCapacity" class="col-xs-3">
                                        <span>ظرفیت باقی‌مانده: </span>
                                        <span>20 نفر</span>
                                    </div>
                                </div>
                                <div id="tourPriceMainDiv" class="full-width inline-block">
                                    <div id="tourPriceOptions" class="col-xs-7">
                                        <div class="full-width inline-block">
                                            <b>قیمت پایه</b>
                                            <b class="mainCost"></b>
                                        </div>
                                        <div class="full-width inline-block">

                                            <span class="inline-block ">هزینه اقامتگاه</span>
                                            <span class="inline-block ">+650000</span>

                                            <div class="full-width inline-block">
                                                <span>هتل آناهیتا </span>
                                                <span style="float: initial; color: var(--koochita-light-green)">درجه هتل: </span>
                                                <span>پنج ستاره</span>
                                            </div>
                                        </div>
                                        <div class="full-width inline-block">
                                            <span class="inline-block">هزینه امکانات اضافه</span>
                                            <span class="inline-block">+650000</span>
                                            <div class="full-width inline-block">
                                                <div class="full-width inline-block">
                                                    <span>نهار عالی</span>
                                                    <span>+650000</span>
                                                </div>
                                                <div class="full-width inline-block">
                                                    <span>سرویس عالی</span>
                                                    <span>+650000</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="full-width inline-block">
                                            <div class="full-width inline-block">
                                                        <span>جمع کل
                                                            <span>(به ازای هر نفر)</span>
                                                        </span>
                                                <b>1.300.000</b>
                                            </div>
                                            <div class="full-width inline-block">
                                                <div>
                                                    <span class="full-width inline-block">با احتساب</span>
                                                    <span>ده درصد تخفیف ویژه نوروز</span>
                                                </div>

                                                <b >1.210.000</b>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tourPricePerMan" class="col-xs-5">
                                        <div class="full-width inline-block">
                                            <b>
                                                تعداد مسافرین را انتخاب کنید.
                                            </b>
                                            <center>
                                                <div class="roomBox">
                                                    <div id="roomDetail"
                                                         style="font-size: 0.9em; display: inline-block; cursor: pointer;margin-top: 8px"
                                                         onclick="togglePassengerNoSelectPane()">
                                                        <span id="room_number" style="float: right;" class="room"></span>&nbsp;
                                                        <span>اتاق</span>&nbsp;-&nbsp;
                                                        <span id="adult_number" class="adult"></span>
                                                        <span>بزرگسال</span>&nbsp;
                                                        {{---&nbsp;--}}
                                                        {{--<span class="children">--}}
                                                        {{--{{$children}}--}}
                                                        {{--</span>--}}
                                                        {{--<span>بچه</span>&nbsp;--}}
                                                    </div>
                                                    <div class="shTIcon passengerIcon"
                                                         style="font-size: 25px; display: inline-block; cursor: pointer;float: right"
                                                         onclick="togglePassengerNoSelectPane()"></div>
                                                    <div id="passengerArrowDown" onclick="togglePassengerNoSelectPane()"
                                                         class="shTIcon searchBottomArrowIcone arrowPassengerIcone"
                                                         style="display: inline-block;"></div>
                                                    <div id="passengerArrowUp" onclick="togglePassengerNoSelectPane()"
                                                         class="shTIcon searchTopArrowIcone arrowPassengerIcone hidden"
                                                         style="display: inline-block;"></div>


                                                    <div class="roomPassengerPopUp hidden " id="passengerNoSelectPane"
                                                         onmouseleave="addClassHidden('passengerNoSelectPane'); passengerNoSelect = false;">
                                                        <div class="rowOfPopUp">
                                                            <span style="float: right;">اتاق</span>
                                                            <div style="float: left; margin-right: 25px;">
                                                                <div onclick="changeRoomPassengersNum(-1, 3)"
                                                                     class="shTIcon minusPlusIcons minus"></div>
                                                                <span class='numBetweenMinusPlusBtn room' id="roomNumInSelect">
    {{--                                                        {{$room}}--}}
                                                        </span>
                                                                <div onclick="changeRoomPassengersNum(1, 3)"
                                                                     class="shTIcon minusPlusIcons plus"></div>
                                                            </div>
                                                        </div>
                                                        <div class="rowOfPopUp">
                                                            <span style="float: right;">بزرگسال</span>
                                                            <div style="float: left">
                                                                <div onclick="changeRoomPassengersNum(-1, 2)"
                                                                     class="shTIcon minusPlusIcons minus"></div>
                                                                <span class='numBetweenMinusPlusBtn adult'
                                                                      id="adultPassengerNumInSelect">
    {{--                                                        {{$adult}}--}}
                                                        </span>
                                                                <div onclick="changeRoomPassengersNum(1, 2)"
                                                                     class="shTIcon minusPlusIcons plus"></div>
                                                            </div>
                                                        </div>
                                                        {{--<div class="rowOfPopUp">--}}
                                                        {{--<span style="float: right;">بچه</span>--}}
                                                        {{--<div style="float: left">--}}
                                                        {{--<div onclick="changeRoomPassengersNum(-1, 1)"--}}
                                                        {{--class="shTIcon minusPlusIcons minus"></div>--}}
                                                        {{--<span class='numBetweenMinusPlusBtn children'--}}
                                                        {{--id="childrenPassengerNumInSelect">--}}
                                                        {{--{{$children}}--}}
                                                        {{--</span>--}}
                                                        {{--<div onclick="changeRoomPassengersNum(1, 1)"--}}
                                                        {{--class="shTIcon minusPlusIcons plus"></div>--}}
                                                        {{--</div>--}}
                                                        {{--</div>--}}
                                                        {{--<div class="childrenPopUpAlert">--}}
                                                        {{--سن بچه را در زمان ورود به هتل وارد کنید--}}
                                                        {{--</div>--}}
                                                        {{--<div class="childBox"></div>--}}
                                                    </div>
                                                </div>
                                            </center>
                                        </div>
                                        <div class="full-width inline-block">
                                            <span>بزرگسال</span>
                                            <span>1.210.000 X2</span>
                                        </div>
                                        <div class="full-width inline-block">
                                                    <span>کودک
                                                        <span>تخفیف ویژه کودکان</span>
                                                    </span>
                                            <span>1.210.000 X2</span>
                                        </div>
                                        <div class="full-width inline-block">
                                            <div class="full-width inline-block">
                                                <span>جمع کل</span>
                                                <b>1.300.000</b>
                                            </div>
                                            <div class="full-width inline-block">
                                                <div>
                                                    <span class="full-width inline-block">با احتساب</span>
                                                    <span>ده درصد تخفیف ویژه گروهی</span>
                                                </div>

                                                <b >1.210.000</b>
                                            </div>
                                            <center>
                                                <button class="tourListPurchaseBtn">خرید</button>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                                <div id="tourPriceMainDiv" class="full-width inline-block">
                                    <div id="fastReserveDiv" class="col-xs-7">
                                        <div class="inline-block col-xs-2">
                                            <button id="fastReserveTour4" class="fastReserveTour">رزرو آنی</button>
                                            <button id="reserveByPhoneBtn" class="fastReserveTour">تلفنی</button>
                                        </div>
                                        <div class="inline-block col-xs-10">
                                            بلیط شما به صورت آنلاین صادر می گردد.<br>
                                            برای شما کد پیگیری صادر شده و پس از تأیید برگزارکننده پرداخت و صدور بلیط انجام میگردد.
                                        </div>
                                    </div>
                                    <div id="businessApproachDiv" class="col-xs-5">
                                                <span class="full-width inline-block">
                                                    اگر شرکت هستید از راهکارهای تجاری ما استفاده کنید.
                                                </span>
                                        <b class="full-width inline-block">
                                            راهکار تجاری
                                        </b>
                                    </div>
                                </div>
                                <div id="whatToExpectDiv" class="full-width inline-block tourOrganizerBoxes">
                                    <div class="full-width inline-block">
                                        <b class="inline-block">چه انتظاری داشته باشیم</b>
                                        <span class="inline-block">این قسمت توسط برگزار کننده تکمیل شده است</span>
                                    </div>
                                    <span class="tourExeptionText"></span>
                                </div>
                                <div id="specificInfosDiv" class="full-width inline-block tourOrganizerBoxes">
                                    <div class="full-width inline-block">
                                        <b class="inline-block">اطلاعات اختصاصی</b>
                                        <span class="inline-block">این قسمت توسط برگزار کننده تکمیل شده است</span>
                                    </div>
                                    <span class="tourSpecialInformationText"></span>
                                </div>
                                <div id="betterTourSuggestionsDiv" class="full-width inline-block tourOrganizerBoxes">
                                    <div class="full-width inline-block">
                                        <b class="inline-block">پیشنهادات برای سفر بهتر</b>
                                        <span class="inline-block">این قسمت توسط برگزار کننده تکمیل شده است</span>
                                    </div>
                                    <span class="tourOpinionText"></span>
                                </div>
                                <div id="tourLimitationsDiv" class="full-width inline-block tourOrganizerBoxes">
                                    <div class="full-width inline-block">
                                        <b class="inline-block">محدودیت های سفر</b>
                                        <span class="inline-block">این قسمت توسط برگزار کننده تکمیل شده است</span>
                                    </div>
                                    <span class="tourLimitText"></span>
                                </div>
                            </div>
                            <div class="ui_column  is-4" style="border-left: 2px solid #e5e5e5;">
                                <div class="block_header" style="border: none; padding: 0 0 7px 0; margin: 0 ">
                                    <h3 class="block_title" style="padding-bottom: 10px;; font-size: 18px">معرفی کلی </h3>
                                </div>
                                <div class="tourAbstract">
                                    <div class="mainDescription"></div>
                                    <a class="seeAllReviews autoResize" href="#REVIEWS"></a>
                                </div>
                                <div class="tourExpDetails">
                                    <div class="tourDetailsTitles col-xs-6">
                                        <span>حرکت از : </span>
                                        <span class="srcName"></span>
                                    </div>
                                    <div class="tourDetailsTitles col-xs-6">
                                        <span>مقصد : </span>
                                        <span class="destinationName"></span>
                                    </div>

                                    <div class="tourDetailsTitles col-xs-6">
                                        <span>درجه سختی</span>
                                        <span>
                                            <span></span>
                                            ساده
                                        </span>
                                    </div>
                                    <div class="tourDetailsTitles col-xs-6">
                                        <span>نوع تور</span>
                                        <span>
                                            <span></span>
                                            شهرگردی
                                        </span>
                                    </div>
                                    <div class="tourDetailsTitles col-xs-12">
                                        <span>علایق تور</span>
                                        <span class="tourStyleOneRow"></span>
                                    </div>
                                    <div class="tourDetailsTitles col-xs-12">
                                        <span>تیپ تور</span>
                                        <span class="tourKindOneRow"></span>
                                    </div>
                                    <div class="tourDetailsTitles col-xs-6">
                                        <span>نوع تور</span>
                                        <span class="tourIsPrivate"></span>
                                    </div>
                                    <div class="tourDetailsTitles col-xs-6">
                                        <span>رفت و آمد محلی</span>
                                        <span class="tourSideTransportOneRow"></span>
                                    </div>
                                    <div class="tourDetailsTitles col-xs-6">
                                        <span>پذیرایی</span>
                                        <span>صبحانه - نهار</span>
                                    </div>
                                    <div class="tourDetailsTitles col-xs-6">
                                        <span>زبان تور</span>
                                        <span class="tourLanguageOneRow"></span>
                                    </div>
                                    <div class="tourDetailsTitles col-xs-6">
                                        <span>نوع بیمه</span>
                                        <span class="tourInsurance"></span>
                                    </div>
                                </div>
                                <div class="prw_rup prw_common_atf_header_bl tourAgencyDetailsMainDiv">
                                    <div class="tourAgencyExp inline-block full-width">
                                        <div class="tourAgencyLogo circleBase type2"></div>
                                        <div class="tourAgencyName">
                                            <div class="full-width">آژانس ستاره طلایی</div>
                                            {{--<div class="full-width">ستاره</div>--}}
                                            <div class="prw_rup prw_common_bubble_rating overallBubbleRating full-width" style="float: right;">
                                                        <span class="ui_bubble_rating bubble_50" style="font-size:16px;"
                                                              property="ratingValue" content="5" alt='5 of 5 bubbles'></span>
                                            </div>
                                            <div>
                                                <div>0 نقد</div>
                                                <div>امتیاز</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="blEntry address" style="white-space: normal;">
                                        <span class="ui_icon map-pin"></span>
                                        <span class="street-address"> </span>
                                        <span style="font-size: 12px;">
                                                    {{--{{$place->address}}--}}
                                                </span>
                                    </div>
                                    {{--@if(!empty($place->phone))--}}
                                    <div class="blEntry phone">
                                        <span class="ui_icon phone" ></span>
                                        <span style="font-size: 12px;">
                                                        {{--{{$place->phone}}--}}
                                                    </span>
                                    </div>
                                    {{--@endif--}}
                                    {{--@if(!empty($place->site))--}}
                                    <div class="blEntry website">
                                        <span class="ui_icon laptop"></span>
                                        <?php
                                        //if (strpos($place->site, 'http') === false)
                                        //  $place->site = 'http://' . $place->site;
                                        ?>
                                        <a target="_blank">
                                            {{--href="{{$place->site}}" {{($config->externalSiteNoFollow) ? 'rel="nofollow"' : ''}}>--}}
                                            <span style="font-size: 12px;">
                                                            {{--{{$place->site}}--}}
                                                        </span>
                                        </a>
                                    </div>
                                    {{--@endif--}}
                                </div>
                                <center class="prw_rup prw_common_atf_header_bl tourAgencyContactDetailsMainDiv">
                                    <b class="tourAgencyPhoneNum inline-block">+982188536124</b>
                                    <div id="tourAgencyContactLogo" class="circleBase type2"></div>
                                    <div class="phoneNumSub inline-block">شماره تماس پشتیبانی تور</div>
                                    <div id="tourAgencyIdCode">
                                        <span>شناسایی تور:</span>
                                        <span>100-001-1200-01</span>
                                    </div>
                                </center>
                                <div class="prw_rup prw_common_atf_header_bl tourGuiderDetailsMainDiv">
                                    <b class="tourGuiderDivTitle inline-block ">تور گردان شما</b>
                                    <div class="tourGuiderExp inline-block full-width">
                                        <div id="tourGuiderPic" class="circleBase type2"></div>
                                        <div id="tourGuiderName">
                                            <div class="full-width">محسن خلیل زاده</div>
                                            {{--<div class="full-width">ستاره</div>--}}
                                            <div class="prw_rup prw_common_bubble_rating overallBubbleRating full-width" style="float: right;">
                                                        <span class="ui_bubble_rating bubble_50" style="font-size:16px;"
                                                              property="ratingValue" content="5" alt='5 of 5 bubbles'></span>
                                            </div>
                                            <div>
                                                <div>0 نقد</div>
                                                <div>امتیاز</div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--@if(!empty($place->phone))--}}
                                    <div class="blEntry phone">
                                        <span class="ui_icon phone" ></span>
                                        <span style="font-size: 12px;">
                                                        {{--{{$place->phone}}--}}
                                                    </span>
                                    </div>
                                    {{--@endif--}}
                                    {{--@if(!empty($place->site))--}}
                                    <div class="blEntry website">
                                        <span class="ui_icon laptop"></span>
                                        <?php
                                        //if (strpos($place->site, 'http') === false)
                                        //  $place->site = 'http://' . $place->site;
                                        ?>
                                        <a target="_blank">
                                            {{--href="{{$place->site}}" {{($config->externalSiteNoFollow) ? 'rel="nofollow"' : ''}}>--}}
                                            <span style="font-size: 12px;">
                                                            {{--{{$place->site}}--}}
                                                        </span>
                                        </a>
                                    </div>
                                    <button class="tourGuiderPageAccess">مشاهده صفحه</button>
                                    <button class="tourGuiderSendMsg">ارسال پیام</button>
                                    {{--@endif--}}
                                </div>
                                <div class="prw_rup prw_common_atf_header_bl tourPlacesDetailsMainDiv">
                                    <b class="tourPlacesDivTitle inline-block ">شهرهایی که می‌بینید</b>
                                    <center class="tourPlacesDivs col-xs-6 inline-block">
                                        <center class="inline-block full-width">
                                            <div class="tourPlacesPic circleBase type2"></div>
                                        </center>
                                        <div class="tourPlacesName">
                                            <b class="full-width">قنات دو طبقه مون</b>
                                            {{--<div class="full-width">ستاره</div>--}}
                                            <div class="prw_rup prw_common_bubble_rating overallBubbleRating full-width" style="float: right;">
                                                        <span class="ui_bubble_rating bubble_50" style="font-size:16px;"
                                                              property="ratingValue" content="5" alt='5 of 5 bubbles'></span>
                                                <span>2 نقد</span>
                                            </div>
                                            <div class="inline-block">
                                                استان: اصفهان
                                            </div>
                                        </div>
                                    </center>
                                    <center class="tourPlacesDivs col-xs-6 inline-block">
                                        <center class="inline-block full-width">
                                            <div class="tourPlacesPic circleBase type2"></div>
                                        </center>
                                        <div class="tourPlacesName">
                                            <b class="full-width">قنات دو طبقه مون</b>
                                            {{--<div class="full-width">ستاره</div>--}}
                                            <div class="prw_rup prw_common_bubble_rating overallBubbleRating full-width" style="float: right;">
                                                        <span class="ui_bubble_rating bubble_50" style="font-size:16px;"
                                                              property="ratingValue" content="5" alt='5 of 5 bubbles'></span>
                                                <span>2 نقد</span>
                                            </div>
                                            <div class="inline-block">
                                                استان: اصفهان
                                            </div>
                                        </div>
                                    </center>
                                    <div class="moreInfoTourDetails">بیشتر</div>
                                </div>
                                <hr class="inline-block tourDetailsBoxDivider">
                                <div class="prw_rup prw_common_atf_header_bl tourPlacesDetailsMainDiv">
                                    <b class="tourPlacesDivTitle inline-block ">جاذبه‌هایی که می‌بینید</b>
                                    <center class="tourPlacesDivs col-xs-6 inline-block">
                                        <center class="inline-block full-width">
                                            <div class="tourPlacesPic circleBase type2"></div>
                                        </center>
                                        <div class="tourPlacesName">
                                            <b class="full-width">قنات دو طبقه مون</b>
                                            {{--<div class="full-width">ستاره</div>--}}
                                            <div class="prw_rup prw_common_bubble_rating overallBubbleRating full-width" style="float: right;">
                                                        <span class="ui_bubble_rating bubble_50" style="font-size:16px;"
                                                              property="ratingValue" content="5" alt='5 of 5 bubbles'></span>
                                                <span>2 نقد</span>
                                            </div>
                                            <div class="inline-block">
                                                استان: اصفهان
                                            </div>
                                        </div>
                                    </center>
                                    <center class="tourPlacesDivs col-xs-6 inline-block">
                                        <center class="inline-block full-width">
                                            <div class="tourPlacesPic circleBase type2"></div>
                                        </center>
                                        <div class="tourPlacesName">
                                            <b class="full-width">قنات دو طبقه مون</b>
                                            {{--<div class="full-width">ستاره</div>--}}
                                            <div class="prw_rup prw_common_bubble_rating overallBubbleRating full-width" style="float: right;">
                                                        <span class="ui_bubble_rating bubble_50" style="font-size:16px;"
                                                              property="ratingValue" content="5" alt='5 of 5 bubbles'></span>
                                                <span>2 نقد</span>
                                            </div>
                                            <div class="inline-block">
                                                استان: اصفهان
                                            </div>
                                        </div>
                                    </center>
                                    <div class="moreInfoTourDetails">بیشتر</div>
                                </div>
                            </div>
                            <div class="ui_column  is-12 tourDailySchedule" style="">
                                <div class="block_header tourBlockHeaders" style="border: none; padding: 0 0 7px 0; margin: 0 ">
                                    <h3 class="block_title inline-block full-width" style="padding-bottom: 5px; font-size: 18px">برنامه روزانه تور </h3>
                                    <span>برنامه روزانه تور طبق اعلام برگزارکننده ارائه گردیده است. توجه داشته باشید که ممکن است زمان‌ها و ترتیب رویدادها دستخوش تغییر شود.</span>
                                </div>
                                <div class="fastReserveTour" id="tourStartDateDiv">
                                    روز اول
                                    <span id="tourStartDate">1397/02/23</span>
                                </div>
                                <div class="tourDailyScheduleGuideMainDiv" style="position: relative">
                                    <div class="tourDailyScheduleGuideBoxes">
                                        <div class="text">اقامت</div>
                                        <div class="tourScheduleGuideColor circleBase type2" style="background: red"></div>
                                    </div>
                                    <div class="tourDailyScheduleGuideBoxes">
                                        <div class="text">رویداد</div>
                                        <div class="tourScheduleGuideColor circleBase type2" style="background: var(--koochita-light-green)"></div>
                                    </div>
                                    <div class="tourDailyScheduleGuideBoxes">
                                        <div class="text">غذا</div>
                                        <div class="tourScheduleGuideColor circleBase type2" style="background: var(--koochita-dark-green)"></div>
                                    </div>
                                    <div class="tourDailyScheduleGuideBoxes">
                                        <div class="text">جاذبه</div>
                                        <div class="tourScheduleGuideColor circleBase type2" style="background: var(--koochita-red)"></div>
                                    </div>
                                    <div class="tourDailyScheduleGuideBoxes">
                                        <div class="text">شهر</div>
                                        <div class="tourScheduleGuideColor circleBase type2" style="background: var(--koochita-blue)"></div>
                                    </div>
                                    <div class="tourDailyScheduleGuideBoxes">
                                        <div class="text">رفت و آمد</div>
                                        <div class="tourScheduleGuideColor circleBase type2" style="background: var(--koochita-green)"></div>
                                    </div>
                                </div>

                                <div class="dayScheduleSec">
                                    <div style="display: flex">
                                        <div class="circleSection top">
                                            <div class="circle firstCircle" style="background: red"></div>
                                            <div class="circle middleCircle" style="background: gray"></div>
                                        </div>
                                        <div class="circleSection bottom">
                                            <div class="circle firstCircle" style="background: blue"></div>
                                            <div class="circle middleCircle" style="background: yellow"></div>
                                        </div>
                                        <div class="circleSection top">
                                            <div class="circle firstCircle" style="background: peru"></div>
                                            <div class="circle middleCircle" style="background: red"></div>
                                        </div>
                                        <div class="circleSection bottom">
                                            <div class="circle firstCircle"></div>
                                            <div class="circle middleCircle"></div>
                                        </div>
                                        <div class="circleSection top">
                                            <div class="circle firstCircle"></div>
                                            <div class="circle middleCircle"></div>
                                        </div>
                                        <div class="circleSection bottom">
                                            <div class="circle firstCircle"></div>
                                            <div class="circle middleCircle"></div>
                                        </div>
                                        <div class="circleSection top">
                                            <div class="circle firstCircle"></div>
                                            <div class="circle middleCircle"></div>
                                        </div>
                                        <div class="circleSection bottom">
                                            <div class="circle firstCircle"></div>
                                            <div class="circle middleCircle"></div>
                                        </div>
                                        <div class="circleSection top">
                                            <div class="circle firstCircle"></div>
                                            <div class="circle middleCircle"></div>
                                        </div>
                                        <div class="circleSection bottom">
                                            <div class="circle firstCircle"></div>
                                            <div class="circle middleCircle"></div>
                                        </div>
                                        <div class="circleSection top">
                                            <div class="circle firstCircle"></div>
                                            <div class="circle middleCircle"></div>
                                        </div>
                                        <div class="circleSection bottom">
                                            <div class="circle firstCircle"></div>
                                            <div class="circle middleCircle"></div>
                                            <div class="circle lastCircle"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="ui_column  is-12" style="border-bottom: 2px solid #e5e5e5; margin-top: 20px">
                                <div class="block_header tourBlockHeaders" style="border: none; padding: 0 0 7px 0; margin: 0 ">
                                    <h3 class="block_title inline-block full-width" style="padding-bottom: 5px; font-size: 18px">لوازم ضروری </h3>
                                    <span>داشتن این لوازم برای حضور در تور ضروری است و به همراه نداشتن آن‌ها ممکن است در سفر شما اختلال ایجاد نماید.</span>
                                </div>
                                <div id="mustEquipments"></div>
                            </div>
                            <div class="ui_column  is-12" style="border-bottom: 2px solid #e5e5e5; margin-top: 20px">
                                <div class="block_header tourBlockHeaders" style="border: none; padding: 0 0 7px 0; margin: 0 ">
                                    <h3 class="block_title inline-block full-width" style="padding-bottom: 5px; font-size: 18px">لوازم پیشنهادی </h3>
                                    <span>به همراه داشتن این لوازم تجربه شما از تور را زیباتر و دلپذیرتر می‌کند.</span>
                                </div>
                                <div id="suggestEquipments"></div>
                                <div class="inline-block suggestedEquipments">فلاسک چای</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--@if(session('goDate') != null && $rooms != null)--}}
            <div id="roomChoice" class="ppr_rup ppr_priv_location_detail_two_column"
                 style="position: relative; display: block">

                {{--<div class="column_wrap ui_columns is-mobile"--}}
                {{--style="width: 100%; direction: rtl; position: relative;">--}}
                {{--<div class="content_column ui_column is-10 roomBox_IS_10">--}}
                {{--<div class="ppr_rup ppr_priv_location_reviews_container" style="position: relative">--}}
                {{--<div id="rooms" class="ratings_and_types concepts_and_filters block_wrap"--}}
                {{--style="position: relative">--}}
                {{--<div class="header_group block_header"--}}
                {{--style="position: relative; padding-bottom: 2%; border-bottom: solid lightgray 1.5px; display: flex; align-items: center">--}}
                {{--<h3 class="tabs_header reviews_header block_title"--}}
                {{--style="float: right; line-height: 45px"> انتخاب اتاق </h3>--}}
                {{--<div class="srchBox" style="display: inline-block; margin-right: 5%;">--}}
                {{--<button class="srchBtn" onclick="editSearch()">ویرایش جستجو</button>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--@for($i = 0; $i < count($rooms); $i++)--}}
                {{--<div class="eachRooms">--}}
                {{--<div class="roomPic">--}}
                {{--<img--}}
                {{--src="{{$rooms[$i]->pic}}"--}}
                {{--width="100%" height="100%"--}}
                {{--alt='{{$rooms[$i]->name}}'--}}
                {{-->--}}
                {{--</div>--}}
                {{--<div class="roomDetails">--}}
                {{--<div>--}}
                {{--<div class="roomRow"--}}
                {{--style="border-bottom: 1.5px solid #e5e5e5; width: 52%;">--}}
                {{--<div class="roomName">--}}
                {{--onclick="document.getElementById('room_info{{$i}}').style.display = 'flex'">--}}
                {{--{{$rooms[$i]->name}}--}}
                {{--</div>--}}
                {{--<div class="roomPerson">--}}
                {{--<div style="margin: -5px 0">--}}
                {{--@for($j = 0; $j < ceil($rooms[$i]->capacity->adultCount/2); $j++)--}}
                {{--<span class="shTIcon personIcon"></span>--}}
                {{--@endfor--}}
                {{--</div>--}}
                {{--<div style="margin: -10px 0">--}}
                {{--@for($j = 0; $j < floor($rooms[$i]->capacity->adultCount/2); $j++)--}}
                {{--<span class="shTIcon personIcon"></span>--}}
                {{--@endfor--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="roomRow" style="float: left">--}}
                {{--<div class="roomNumber">--}}
                {{--<div style="color: var(--koochita-light-green); display: inline-block; line-height: 24px">--}}
                {{--تعداد اتاق--}}
                {{--</div>--}}
                {{--<select name="room_Number" id="roomNumber--}}
                {{--{{$i}}--}}
                {{--"--}}
                {{--style="float: left; border: none;"--}}
                {{--onclick="changeNumRoom({{$i}}, this.value)"--}}
                {{-->--}}
                {{--@for($j = 0; $j < 11; $j++)--}}
                {{--<option value="{{$j}}">{{$j}}</option>--}}
                {{--@endfor--}}
                {{--</select>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div>--}}
                {{--<div class="roomRow">--}}
                {{--<div class="roomOptionTitle">امکانات اتاق</div>--}}
                {{--</div>--}}
                {{--<div class="roomRow"--}}
                {{--style="float: left; border-bottom: 1.5px solid #e5e5e5">--}}
                {{--<div class="check-box__item hint-system"--}}
                {{--@if(!($rooms[$i]->priceExtraGuest != null && $rooms[$i]->priceExtraGuest != ''))--}}
                {{--style="display: none;"--}}
                {{--@endif--}}
                {{-->--}}
                {{--<label class="labelEdit">استفاده از تخت--}}
                {{--اضافه</label>--}}
                {{--<input type="checkbox" id="additional_bed--}}
                {{--{{$i}}--}}
                {{--"--}}
                {{--name="additionalBed" value="1"--}}
                {{--style="display: inline-block; !important;">--}}
                {{--onclick="changeRoomPrice({{$i}}); changeNumRoom({{$i}}, this.value)">--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div style="margin-top: 5px">--}}

                {{--<div class="roomRow">--}}
                {{--<div class="roomOption">--}}
                {{--{{$rooms[$i]->roomFacility}}--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="roomRow" style="float: left; margin-top: 5px;">--}}

                {{--@if($rooms[$i]->priceExtraGuest != null && $rooms[$i]->priceExtraGuest != '')--}}
                {{--<div class="roomAdditionalOption">تخت اضافه</div>--}}
                {{--@endif--}}
                {{--<div class="roomAdditionalOption">--}}
                {{--{{$rooms[$i]->roomService}}--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="roomPrices">--}}
                {{--<div style="color: var(--koochita-light-green)">قیمت</div>--}}
                {{--<div style="text-align: center">--}}
                {{--<div style="font-size: 1.4em">--}}
                {{--{{floor($rooms[$i]->perDay[0]->price/1000)*1000}}--}}
                {{--@if($rooms[$i]->priceExtraGuest != null && $rooms[$i]->priceExtraGuest != '')--}}
                {{--<div id="extraBedPrice--}}
                {{--{{$i}}--}}
                {{--"--}}
                {{--style="display: none;">--}}
                {{--<div class="salePrice">--}}
                {{--{{floor($rooms[$i]->priceExtraGuest/1000)*1000 + floor($rooms[$i]->perDay[0]->price/1000)*1000}}--}}
                {{--</div>--}}
                {{--<div style="font-size: 0.6em; color: red;">--}}
                {{--<div>با احتساب--}}
                {{--{{floor($rooms[$i]->priceExtraGuest/1000)*1000}}--}}
                {{--</div>--}}
                {{--<div>با تخت اضافه</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--@endif--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div>--}}
                {{--<div style="display: inline-block">--}}
                {{--از {{$rooms[$i]->provider}}</div>--}}
                {{--<img style="float: left">--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div id="room_info--}}
                {{--{{$i}}--}}
                {{--"--}}
                {{--style="position: fixed; width: 100%; height: 100%; background-color: #00000094; top: 0; left: 0; z-index: 99; display: none; justify-content: center; align-items: center">--}}
                {{--<div class="container"--}}
                {{--style="background-color: white; padding: 10px;">--}}
                {{--<div class="row" style="direction :rtl;">--}}
                {{--<div class="col-md-8"--}}
                {{--style="display: flex; flex-direction: column; font-size: 20px;">--}}
                {{--<div class="roomRow "--}}
                {{--style="width: 100%; margin-bottom: 2%;">--}}
                {{--<div class="roomName">--}}
                {{--{{$rooms[$i]->name}}--}}
                {{--</div>--}}
                {{--<div class="shTIcon closeXicon" style="float: left;">--}}
                {{--onclick="document.getElementById('room_info{{$i}}').style.display = 'none'">--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="roomRow">--}}
                {{--<div class="roomOptionTitle">امکانات اتاق</div>--}}
                {{--</div>--}}
                {{--<div class="roomRow"--}}
                {{--style="width:85%; margin-bottom: 2%;">--}}
                {{--<div class="roomOption">--}}
                {{--{{$rooms[$i]->roomFacility}}--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="roomRow">--}}
                {{--<div class="roomOptionTitle">امکانات ویژه</div>--}}
                {{--</div>--}}
                {{--<div class="roomRow"--}}
                {{--style="float: left; margin-top: 5px; display: flex; flex-direction: column">--}}
                {{--@if($rooms[$i]->priceExtraGuest != null && $rooms[$i]->priceExtraGuest != '')--}}
                {{--<div class="roomAdditionalOption">تخت اضافه--}}
                {{--</div>--}}
                {{--@endif--}}
                {{--<div class="roomAdditionalOption">--}}
                {{--{{$rooms[$i]->roomService}}--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-md-4">--}}
                {{--<img--}}
                {{--src="{{$rooms[$i]->pic}}" width="100%"--}}
                {{--height="100%"--}}
                {{--alt='{{$rooms[$i]->name}}'--}}
                {{-->--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--@endfor--}}
                {{--</div>--}}

                {{--</div>--}}
                {{--</div>--}}

                {{--<div class="is-2 roomBox_IS_2" style="width: 100%;">--}}
                {{--<div class="priceRow_IS_2" style="margin-top: 0 !important;">--}}
                {{--<div>قیمت کل برای یک شب</div>--}}
                {{--<div id="totalPriceOneDay" style="text-align: left;">0</div>--}}
                {{--</div>--}}
                {{--<div class="priceRow_IS_2">--}}
                {{--<div><span class="lable_IS_2">قیمت کل </span> برای<span id="numDay"></span>شب--}}
                {{--</div>--}}
                {{--<div style="font-size: 1.2em; text-align: left" id="totalPrice">0</div>--}}
                {{--</div>--}}
                {{--<div class="priceRow_IS_2">--}}
                {{--<div>--}}
                {{--<div class="lable_IS_2">تعداد اتاق</div>--}}
                {{--<div style="float: left" id="totalNumRoom"></div>--}}
                {{--</div>--}}
                {{--<div style="text-align: center;" id="discriptionNumRoom">--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div style="margin: 7% 0; text-align: center">--}}
                {{--<button class="btn rezervedBtn" type="button" onclick="showReserve()">رزرو--}}
                {{--</button>--}}
                {{--</div>--}}
                {{--<div>--}}
                {{--<div>--}}
                {{--<div>حداکثر سن کودک</div>--}}
                {{--<div style="color: #92321b">یک سال بدون اخذ هزینه</div>--}}
                {{--</div>--}}
                {{--<div>--}}
                {{--<div>ساعت تحویل و تخلیه اتاق</div>--}}
                {{--<div style="color: #92321b">14:00</div>--}}
                {{--</div>--}}
                {{--<div>--}}
                {{--<div>قوانین کنسلی</div>--}}
                {{--<div style="color: #92321b">لورم ییی</div>--}}
                {{--</div>--}}
                {{--{{$place->policy}}--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}

                <div id="check_room"
                     style="position: fixed; width: 100%; height: 100%; background-color: #00000094; top: 0; left: 0; z-index: 99; display: none; justify-content: center; align-items: center">
                    <div class="container"
                         style="background-color: lightgray; padding: 10px; max-height: 85%; overflow-y: auto; overflow-x: hidden">
                        <div class="row" style="direction :rtl; text-align: center; padding: 10px;">
                                    <span style="font-size: 30px; font-weight: bold;">
                                        شهر
                                        {{--{{$city->name}}--}}
                                    </span>
                            <span style="font-size: 20px;">
                                        {{session('goDate')}}-{{session('backDate')}}
                                    </span>
                            <style>
                                .closeXicon:before {
                                    position: relative;
                                    top: 0px;
                                }
                            </style>
                            <span class="shTIcon closeXicon"
                                  {{--onclick="document.getElementById('check_room').style.display = 'none';"--}}
                                  style="float: left;">
                                    </span>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="font-size: 15px; position: fixed">
                                <div class="is-2 roomBox_IS_2"
                                     style="width: 100%; direction: rtl; margin: 0; background-color: white; border: none; position: relative; box-shadow: 0 0 20px 0px gray;">
                                    <div class="priceRow_IS_2">
                                        <div><span class="lable_IS_2">قیمت کل </span> برای<span
                                                id="check_num_day"></span>شب
                                        </div>
                                        <div style="font-size: 1.2em; text-align: left" id="check_total_price">
                                            0
                                        </div>
                                    </div>
                                    <div class="priceRow_IS_2">
                                        <div style="margin-bottom: 15px;">
                                            <div style="float: left"><span id="check_total_num_room"></span>اتاق
                                            </div>
                                            <div class="lable_IS_2">تعداد اتاق</div>
                                        </div>
                                        <div style="text-align: center; display: flex; flex-direction: column;"
                                             id="check_description">
                                        </div>
                                    </div>
                                    <div style="margin: 7% 0; text-align: center; position: absolute; bottom: 0; left: 0px; width: 100%; padding-right: 5%;">
                                                <span style="float: right;">
                                                    {{--{{$rooms[0]->provider}}--}}
                                                </span>
                                        <a href="{{url('buyHotel')}}">
                                            <button class="btn rezervedBtn" type="button" onclick="updateSession()"
                                                    style="float: left; margin-left: 5%; color: white;">
                                                تایید و ادامه
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9" style="float: right; width: 60%;">
                                <div class="row"
                                     style="padding: 10px; display: flex; flex-direction: column; direction: rtl">
                                    <div style="font-weight: bold; font-size: 15px; margin-bottom: 1%;">هتل
                                        انتخابی شما
                                    </div>
                                    <div style="width: 60%; background-color: white; display: flex; flex-direction: row; box-shadow: 0 0 20px 0px gray;">
                                        <div class="col-md-7" style="padding: 5px;">
                                            <span class="imgWrap" style="max-width:200px;max-height:113px;">
                                                        <img alt=""
                                                             {{--{{$place->alt1}}" src="{{$thumbnail}}--}}
                                                             class="centeredImg" style=" min-width:152px; "
                                                             width="100%"/>
                                                    </span>
                                        </div>
                                        <div class="col-md-5" style="display: flex; flex-direction: column;">
                                            <div style=" font-size: 20px; font-weight: bold; margin-bottom: 5%;">
                                                {{--{{$place->name}}--}}
                                            </div>
                                            <div class="rating_and_popularity"
                                                 style="display: flex; flex-direction: column; margin-bottom: 2%;">
                                                        <span class="header_rating">
                                                   <div class="rs rating" rel="v:rating">
                                                       <div class="prw_rup prw_common_bubble_rating overallBubbleRating"
                                                            style="float: right;">
                                                            {{--@if($avgRate == 5)--}}
                                                           <span class="ui_bubble_rating bubble_50"
                                                                 style="font-size:16px;"
                                                                 property="ratingValue" content="5"
                                                                 alt='5 of 5 bubbles'></span>
                                                           {{--@elseif($avgRate == 4)--}}
                                                           {{--<span class="ui_bubble_rating bubble_40"--}}
                                                           {{--style="font-size:16px;"--}}
                                                           {{--property="ratingValue" content="4"--}}
                                                           {{--alt='4 of 5 bubbles'></span>--}}
                                                           {{--@elseif($avgRate == 3)--}}
                                                           {{--<span class="ui_bubble_rating bubble_30"--}}
                                                           {{--style="font-size:16px;"--}}
                                                           {{--property="ratingValue" content="3"--}}
                                                           {{--alt='3 of 5 bubbles'></span>--}}
                                                           {{--@elseif($avgRate == 2)--}}
                                                           {{--<span class="ui_bubble_rating bubble_20"--}}
                                                           {{--style="font-size:16px;"--}}
                                                           {{--property="ratingValue" content="2"--}}
                                                           {{--alt='2 of 5 bubbles'></span>--}}
                                                           {{--@elseif($avgRate == 1)--}}
                                                           {{--<span class="ui_bubble_rating bubble_10"--}}
                                                           {{--style="font-size:16px;"--}}
                                                           {{--property="ratingValue" content="1"--}}
                                                           {{--alt='1 of 5 bubbles'></span>--}}
                                                           {{--@endif--}}
                                                       </div>
                                                   </div>
                                                </span>
                                                <span class="header_popularity popIndexValidation"
                                                      style="margin-right: 0 !important">
                                                    <a class="more taLnk" href="#REVIEWS">
                                                           <span property="v:count" id="commentCount"></span> نقد
                                                       </a>
                                                            <a>
                                                                {{--{{$total}} --}}
                                                                امتیاز</a>
                                                </span>
                                            </div>
                                            <div style="display: flex; flex-direction: row; margin-bottom: 5px;">
                                                <div class="titleInTable">درجه هتل</div>
                                                <div class="highlightedAmenity detailListItem">
                                                    {{--{{$place->rate}}--}}
                                                </div>
                                            </div>
                                            <div class="blEntry blEn address  clickable colCnt3"
                                                 onclick="showExtendedMap()">
                                                <span class="ui_icon map-pin"></span>
                                                <span class="street-address">آدرس : </span>
                                                <span>
                                                            {{--{{$place->address}}--}}
                                                        </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row"
                                     style="padding: 10px; display: flex; flex-direction: column; direction: rtl">
                                    <div style="font-weight: bold; font-size: 15px; margin-bottom: 1%;">اتاق های
                                        انتخابی شما
                                    </div>
                                    <div id="selected_rooms">
                                    </div>
                                    <div>
                                        <div class="row"
                                             style="background: white; margin: 1px; box-shadow: 0 0 20px 0px gray; margin-bottom: 10px; ">
                                            <div class="col-md-12" style="font-size: 15px; padding: 2%">
                                                {{--{{$place->policy}}--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                </div>

                <div class="content_column ui_column is-12">
                    <div class="ppr_rup ppr_priv_location_nearby">
                        <div class="nearbyContainer outerShell block_wrap">
                            <div class="block_header">
                                <h3 class="block_title">تورهای مشابه</h3>
                            </div>
                            <div class="ui_columns neighborhood inline-block full-width" style="padding-top: 22px;">
                                <div class="similarTourSuggestionsDiv inline-block col-xs-4">
                                    <div class="similarTourPic circleBase type2"></div>
                                    <div class="similarTourName">
                                        <b class="full-width">تور جهانگردی من</b>
                                        <div class="full-width">
                                            <span>مقصد:</span>
                                            <span>مقصد</span>
                                        </div>
                                        <div class="full-width">
                                            <span>حرکت از:</span>
                                            <span>مبدأ</span>
                                        </div>
                                        <div>
                                            <span>شروع قیمت از </span>
                                            <span>650.000</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="similarTourSuggestionsDiv inline-block col-xs-4">
                                    <div class="similarTourPic circleBase type2"></div>
                                    <div class="similarTourName">
                                        <b class="full-width">تور جهانگردی من</b>
                                        <div class="full-width">
                                            <span>مقصد:</span>
                                            <span>مقصد</span>
                                        </div>
                                        <div class="full-width">
                                            <span>حرکت از:</span>
                                            <span>مبدأ</span>
                                        </div>
                                        <div>
                                            <span>شروع قیمت از </span>
                                            <span>650.000</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="similarTourSuggestionsDiv inline-block col-xs-4">
                                    <div class="similarTourPic circleBase type2"></div>
                                    <div class="similarTourName">
                                        <b class="full-width">تور جهانگردی من</b>
                                        <div class="full-width">
                                            <span>مقصد:</span>
                                            <span>مقصد</span>
                                        </div>
                                        <div class="full-width">
                                            <span>حرکت از:</span>
                                            <span>مبدأ</span>
                                        </div>
                                        <div>
                                            <span>شروع قیمت از </span>
                                            <span>650.000</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content_column ui_column is-12">
                    <div class="ppr_rup ppr_priv_location_nearby">
                        <div class="nearbyContainer outerShell block_wrap">
                            <div class="block_header">
                                <h3 class="block_title">همین مقصد</h3>
                            </div>
                            <div class="ui_columns neighborhood inline-block full-width" style="padding-top: 22px;">
                                <div class="similarTourSuggestionsDiv inline-block col-xs-4">
                                    <div class="similarTourPic circleBase type2"></div>
                                    <div class="similarTourName sameDestinationTourName">
                                        <b class="full-width">تور جهانگردی من</b>
                                        <div>
                                            <span>شروع قیمت از </span>
                                            <span>650.000</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="similarTourSuggestionsDiv inline-block col-xs-4">
                                    <div class="similarTourPic circleBase type2"></div>
                                    <div class="similarTourName sameDestinationTourName">
                                        <b class="full-width">تور جهانگردی من</b>
                                        <div>
                                            <span>شروع قیمت از </span>
                                            <span>650.000</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="similarTourSuggestionsDiv inline-block col-xs-4">
                                    <div class="similarTourPic circleBase type2"></div>
                                    <div class="similarTourName sameDestinationTourName">
                                        <b class="full-width">تور جهانگردی من</b>
                                        <div>
                                            <span>شروع قیمت از </span>
                                            <span>650.000</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="ansAndQeustionDiv" class="ppr_rup ppr_priv_location_qa" style="position: relative;">
                    <div data-tab="TABS_ANSWERS" class="block_wrap" style="position: relative">
                        <div class="block_header" style="position: relative">
                            <div id="targetHelp_14" class="targets" style="float: left;">
                                        <span class="ui_button primary fr" onclick="showAskQuestion()"
                                              style="float: left;">سوال بپرس</span>
                                <div id="helpSpan_14" class="helpSpans hidden row">
                                    <span class="introjs-arrow"></span>
                                    <p>اگر سوالی دارید با فشردن این دکمه از دوستانتان بپرسید تا شما را یاری
                                        کنند.</p>
                                    <button data-val="14" class="btn btn-success nextBtnsHelp"
                                            id="nextBtnHelp_14">
                                        بعدی
                                    </button>
                                    <button data-val="14" class="btn btn-primary backBtnsHelp"
                                            id="backBtnHelp_14">
                                        قبلی
                                    </button>
                                    <button class="btn btn-danger exitBtnHelp">خروج</button>
                                </div>
                            </div>
                            <h3 class="block_title">سوال و جواب</h3>
                        </div>
                        <div style="max-width: 60%; float: right; direction: rtl;"
                             class="askQuestionForm hidden control">
                            <div class="askExplanation">سوال خودتو بپرس تا کسانی که می دونند کمکت کنند.</div>
                            <div class="overlayNote">سوال شما به صورت عمومی نمایش داده خواهد شد.</div>
                            <textarea style="width: 100%;" name="topicText" id="questionTextId"
                                      class="topicText ui_textarea"
                                      placeholder="سلام هرچی میخواهی بپرسید. بدون خجالت"></textarea>
                            <span onclick="$('#rules').removeClass('hidden')" class="postingGuidelines"
                                  style="float: right;">راهنما و قوانین</span>
                            <div class="underForm" style="float: left;margin-right: 10px;">
                                <span class="ui_button primary formSubmit" onclick="askQuestion()">ثبت</span>
                                <span class="ui_button secondary formCancel"
                                      onclick="hideAskQuestion()">انصراف</span>
                            </div>
                            <div style="clear: both;"></div>
                        </div>
                        <div style="clear: both;"></div>

                        <div class="block_body_top" style="position: relative">

                            <div class="prw_rup prw_common_location_topic" style="position: relative">
                                <div style="direction: rtl; position: relative"
                                     class="question is-mobile ui_column is-12" id="questionsContainer"></div>
                            </div>

                            <div class="prw_rup prw_common_north_star_pagination"
                                 id="pageNumQuestionContainer"></div>
                        </div>

                        <div class="shouldUpdateOnLoad"></div>
                    </div>
                </div>
                <div class="content_column ui_column is-12">
                    <div class="ppr_rup ppr_priv_location_nearby">
                        <div class="nearbyContainer outerShell block_wrap tourQualityFeedbackInstructions" >
                            <div class="block_header">
                                <h3 class="block_title">مرامنامه کیفی کوچیتا</h3>
                            </div>
                            <p>مسافر عزیز تمام مطالب این صفحه به جز تورهای مشابه، توسط برگزارکننده تهیه گردیده است. پس تمام آن‌ها حق شما برای بهره‌مندیدر تور پیش‌روست.همواره نسبت به شرایط، رویدادها و خدمات تور آگاه باشید و آن‌ها را مطالبه کنید.</p>
                            <p>همواره با استفاده از شماره‌های موجود اطلاعات خود را نسبت به شرایط تور بالا ببرید و سؤالی را نپرسیده نگذارید.</p>
                            <p>برگزارکننده‌ی تور متعهد است تمامی خدمات را همانگونه که ذکر کرده است در اختیار شما بگذارد و تحت هیچ شرایطی شخصیت، آرامش و امنیت شما یا خانواه‌ی شما را عمداً به خطر نیندازد.</p>
                            <p>همواره به صحبت‌های راهنمای خود گوش دهید تا تجربه‌ی رضایت‌بخشی بدست آورید.</p>
                            <p>هرگونه اغماض برگزارکننده را بی‌درنگ به مراجع ذی‌صلاح گزارش دهید.</p>
                            <p>راه‌های شکایت از برگزار‌کنندگان تور:</p>
                            <p>حتماً تجربه‌ی خود را با ما درمیان بگذارید تا در صورت رضایت، دیگران را تشویق و در صورت نارضایتی با برگزارکننده‌ در حد توان خود بخورد نماییم. گزارش منفی شما در مواردی می‌تواند منجر به قطع همکاری دائمی شازده با برگرار‌کننده‌، راهنما و سایر دست‌اندرکاران تور گردد.</p>
                            <p>شما برا ما مهمید. پس یا آگاهی از خدمات تور همواره آن‌هارا از برگزارکننده طلب نمایید و در صورت خطا حتماً تا جلب حقوق خود از راه‌های قانونی پیگیری کنید. ما هم در کنار شما هستیم.</p>
                            <p>نقد منفی و یا مثبت شما توسط شازده، دوستان شما و برگزارکنندگان خوانده می‌شود و برای ما بسیار مهم و تصمیم‌ساز ‌می‌باشد.</p>
                        </div>
                    </div>
                </div>
            </div>
            {{--@include('layouts.extendedMap')--}}
        </div>
    </div>


    <script>
        var tourCode = '{{$tour->code}}';
        var tourInformationUrl = '{{route("tour.getInformation")}}?code='+tourCode;

        var mainSlideSwiper = new Swiper('#mainSlider', {
            spaceBetween: 0,
            centeredSlides: true,
            loop: true,
            // autoplay: {
            //     delay: 5000,
            //     disableOnInteraction: false,
            // },
            navigation: {
                prevEl: '.swiper-button-next',
                nextEl: '.swiper-button-prev',
            },
        });
    </script>

    <script src="{{URL::asset('js/pages/tourShow.js')}}"></script>

@stop
