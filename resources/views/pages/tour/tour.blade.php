<!DOCTYPE html>
<html>
<head>
    @include('layouts.topHeader')
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/home_rebranded.css?v=4')}}"/>
    <title>صفحه اصلی</title>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/long_lived_global_legacy_2.css?v=2')}}"/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/masthead-saves.css?v=2')}}'/>
    <link rel='stylesheet' type='text/css' media='screen, print' href='{{URL::asset('css/theme2/hr_north_star.css?v=2')}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/icons.css?v=1')}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/home_rebranded.css?v=1')}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/hr_north_star.css?v=1')}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/tourMainPage.css?v=1')}}'/>

    <script>
        var homePath = '{{route('home')}}';
        var searchDir = '{{route('totalSearch')}}';
        var getStates = '{{route('getStates')}}';
        var getGoyesh = '{{route('getGoyesh')}}';
        var url;
    </script>

</head>

<body class="rebrand_2017 desktop HomeRebranded  js_logging">
    {{--<div class="header hideOnPhone">--}}
        {{--@include('layouts.header1')--}}
    {{--</div>--}}

    {{--<div class="hideOnScreen">--}}
        {{--@include('layouts.header1Phone')--}}
    {{--</div>--}}

    <div class="page" ng-app="mainApp">
        <div class="ppr_rup ppr_priv_homepage_hero">
            <div class="homeHero default_home" style="padding: 0 !important;/*background-image: url('`s://static.tacdn.com/img2/branding/homepage/home-tab1-hero-1367x520-beach-prog.jpg');*/width: 100%; background-position:50% bottom">
                <div class="ui_container container" style="width: 100%; max-width: 100%; padding: 0px;">
                    <div class="placement_wrap">
                        <div class="placement_wrap_row">
                            <div class="placement_wrap_cell">
                                <div id="sliderBarDIV" class="ppr_rup ppr_priv_trip_search hideOnPhone" style="max-width: 100%; overflow: hidden">
                                    {{--@if($placeMode == "hotel")--}}
                                        <div class="ui_columns datepicker_box trip_search metaDatePicker rounded_lockup usePickerTypeIcons preDates noDates with_children hideOnPhone" style="position: absolute;right: 6%;top: 20%;width: 68%;z-index: 10000000;">
                                            <div class="tourInputsMainDiv">
                                                <span>من در </span>
                                                <div id="searchDivForScroll" class="tourInputsDivs prw_rup prw_search_typeahead ui_column is-4 search_typeahead wctx-tripsearch searchDivForScroll">
                                                    <div class="ui_picker">
                                                        <span class="typeahead_align ui_typeahead">
                                                            <input onkeyup="search(event)" type="text" id="placeName" class="typeahead_input tour_inputs" placeholder="مبدأ"/>
                                                            <input type="hidden" id="placeId">
                                                            {{--<span class="ui_icon map-pin-fill pickerType typeahead_icon"></span>--}}
                                                        </span>
                                                        <div id="result" class="data_holder"></div>
                                                    </div>
                                                </div>
                                                <span>هستم و به</span>
                                                <div id="searchDivForScroll" class="tourInputsDivs prw_rup prw_search_typeahead ui_column is-4 search_typeahead wctx-tripsearch searchDivForScroll">
                                                    <div class="ui_picker">
                                                        <span class="typeahead_align ui_typeahead">
                                                            <input onkeyup="search(event)" type="text" id="placeName" class="typeahead_input tour_inputs" placeholder="مقصد"/>
                                                            <input type="hidden" id="placeId">
                                                            {{--<span class="ui_icon map-pin-fill pickerType typeahead_icon"></span>--}}
                                                        </span>
                                                        <div id="result" class="data_holder"></div>
                                                    </div>
                                                </div>
                                                <span>می روم</span>
                                                <div class="is-2 prw_rup prw_common_form_submit ui_column submit_wrap searchDivForScroll-button">
                                                    <button onclick="redirect()" class="autoResize form_submit tourInputsBtn">
                                                        <span class="ui_icon search submit_icon"></span>
                                                        <span onclick="window.location = '{{route('main', ['mode' => 'hotel'])}}'" class="submit_text">جستجو</span>
                                                    </button>
                                                    <span class="ui_loader dark fill"></span>
                                                </div>
                                            </div>


                                            <div style="clear: both"></div>
                                            <div class="tourInputsMainDiv">
                                                <span>من از </span>
                                                <div id="searchDivForScroll" class="tourInputsDivs prw_rup prw_search_typeahead ui_column is-4 search_typeahead wctx-tripsearch searchDivForScroll">
                                                    <div class="ui_picker">
                                                        <span class="typeahead_align ui_typeahead">
                                                            <input onkeyup="search(event)" type="text" id="placeName" class="typeahead_input tour_inputs" placeholder="مبدأ"/>
                                                            <input type="hidden" id="placeId">
                                                            {{--<span class="ui_icon map-pin-fill pickerType typeahead_icon"></span>--}}
                                                        </span>
                                                        <div id="result" class="data_holder"></div>
                                                    </div>
                                                </div>
                                                <span>به هر کجا که جالب باشد می روم</span>
                                                <div class="is-2 prw_rup prw_common_form_submit ui_column submit_wrap searchDivForScroll-button">
                                                    <button onclick="redirect()" class="autoResize form_submit tourInputsBtn">
                                                        <span class="ui_icon search submit_icon"></span>
                                                        <span onclick="window.location = '{{route('main', ['mode' => 'hotel'])}}'" class="submit_text">جستجو</span>
                                                    </button>
                                                    <span class="ui_loader dark fill"></span>
                                                </div>
                                            </div>


                                            <div style="clear: both"></div>
                                            <div class="tourInputsMainDiv">
                                                <span>من می خواهم در </span>
                                                <div id="searchDivForScroll" class="tourInputsDivs prw_rup prw_search_typeahead ui_column is-4 search_typeahead wctx-tripsearch searchDivForScroll">
                                                    <div class="ui_picker">
                                                        <span class="typeahead_align ui_typeahead">
                                                            <input onkeyup="search(event)" type="text" id="placeName" class="typeahead_input tour_inputs" placeholder="مقصد"/>
                                                            <input type="hidden" id="placeId">
                                                            {{--<span class="ui_icon map-pin-fill pickerType typeahead_icon"></span>--}}
                                                        </span>
                                                        <div id="result" class="data_holder"></div>
                                                    </div>
                                                </div>
                                                <span>گردش کنم</span>
                                                <div class="is-2 prw_rup prw_common_form_submit ui_column submit_wrap searchDivForScroll-button">
                                                    <button onclick="redirect()" class="autoResize form_submit tourInputsBtn">
                                                        <span class="ui_icon search submit_icon"></span>
                                                        <span onclick="window.location = '{{route('main', ['mode' => 'hotel'])}}'" class="submit_text">جستجو</span>
                                                    </button>
                                                    <span class="ui_loader dark fill"></span>
                                                </div>
                                            </div>


                                            <div style="clear: both"></div>
                                                {{--<div class="ui_column" style="width: 35%;padding: 10px !important;float: right;border-radius:  0px 10px 10px 0px;">--}}
                                                {{--<div class="ui_picker" style="color: #b7b7b7 !important;">--}}
                                                {{--<label id="calendar-container-edit-1placeDate" class="dateLabel">--}}
                                                {{--<span class="ui_icon calendar" style="color: #30b4a6 !important; font-size: 20px; line-height: 32px; position: absolute; right: 7px;"></span>--}}
                                                {{--<input name="date" id="date_input1" type="text" onclick="assignDate('{{convertStringToDate(getToday()["date"])}}', 'calendar-container-edit-1placeDate', 'date_input1')" class="inputDateLabel" placeholder="تاریخ رفت" required readonly>--}}
                                                {{--</label>--}}
                                                {{--<label id="calendar-container-edit-2placeDate" class="dateLabel" style="margin-right: 14px !important;">--}}
                                                {{--<span class="ui_icon calendar" style="color: #30b4a6 !important; font-size: 20px; line-height: 32px; position: absolute; right: 7px;"></span>--}}
                                                {{--<input name="date" id="date_input2" type="text" onclick="assignDate('{{convertStringToDate(getToday()["date"])}}', 'calendar-container-edit-2placeDate', 'date_input2')" class="inputDateLabel" placeholder="تاریخ برگشت" required readonly>--}}
                                                {{--</label>--}}
                                                {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<div class="ui_column" style="min-width: 15%; max-width: 40%; float: right;border-radius:  10px 0px 0px 10px;">--}}
                                                {{--<div class="ui_picker" style="padding: 4px 0 0 0;">--}}
                                                {{--<span class="ui_icon friends pickerType" style="margin: 0 !important;float: right"></span>--}}
                                                {{--<div style="float: right;">--}}
                                                {{--<span style="float:right; margin-right: 5px">نفر</span>--}}
                                                {{--<div style="float: left; margin-right: 35px">--}}
                                                {{--<div onclick="changePassengersNo(1)" class="minusPlusBtn" style="background-position: -1px -6px;"></div>--}}
                                                {{--<span id="passengerNoSelect"></span>--}}
                                                {{--<div onclick="changePassengersNo(-1)" class="minusPlusBtn" style="background-position: -18px -6px;"></div>--}}
                                                {{--</div>--}}
                                                {{--</div>--}}
                                                {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<div style="clear: both"></div>--}}
                                            </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="tourSearchPops">
            <b class="tourSearchPopsTexts">سلام...</b>
            <button id="tourSearchPopsCloseBtn"></button>
            <br>
            <span id="tourSearchPopsHeaderText" class="tourSearchPopsTexts">یک گام پیش از نمایش نتایج</span>

            <hr>
            <b class="tourSearchPopsTexts">لطفاً انتخاب کنید:</b>
            <br>
            <label>تنها مایل به مشاهده‌ی تورهای داخلی هستم</label>
            <input type="radio" id="">
            <br>
            <label>تنها مایل به مشاهده‌ی تور خارجی هستم</label>
            <input type="radio" id="">
            <br>
            <label>تفاوتی ندارد</label>
            <input type="radio" id="">
            <br>
            <hr>
            <span id= "tourSearchPopProvinceFilterText" class="tourSearchPopsTexts">اگر تمایل ندارید تورهای مرتبط با استان یا استان‌های خاصی برای شما نمایش داده شود به ما بگویید تا سریع‌تر به نتیجه برسید :)</span>
            <input type="text" id="provinceFilterInput" placeholder="لطفاً نام اسان را وارد کنید">
            <div style="clear: both"></div>
            <div class="provinceFilterDiv">
                <span>استان اصفهان</span>
                <button></button>
            </div>
            <span id="tourSearchPopsErrorTexts">حداقل یکی از گزینه‌های قرمز را انتخاب کنید</span>
            <div style="clear: both"></div>
            <button id="tourSearchPopSubmit">تأیید</button>
        </div>
        <div id="tourSearchPopsError">
            <b class="tourSearchPopsTexts">سلام...</b>
            <button id="tourErrorPopsCloseBtn"></button>
            <br>
            <span id="tourErrorPopsHeaderText" class="tourErrorPopsTexts">متأسفانه برای از مبدأ به مقصد نتیجه موجود نیست.</span>

            <hr>
            <b class="tourErrorPopsTexts">آیا تمایل دارید، ما تورهای مشابه در نزدیکترین شهر را پیدا کنیم؟</b>
            <br>
            <label>نزدیکترین شهر حتماً در استان مبدأ باشد</label>
            <input type="radio" id="">
            <br>
            <label>نزدیکترین شهر حتماً در استان مبدأ یا استان‌های همجوار باشد</label>
            <input type="radio" id="">
            <br>
            <span id="tourPopsResearchDesc" class="tourErrorPopsTexts">ما تمامی شهر ها را برای یافتن نزدیکترین مورد مشابه، جستجو می‌کنیم.</span>
            <br>
            <hr>
            <b class="tourErrorPopsTexts">نگران نباشید، شازده شما را به مقصد جدید می‌رساند.</b>
            <label>پس از خرید تور تمامی پیشنهادهای مناسب من را ارائه دهید</label>
            <input type="radio" id="">
            <div style="clear: both"></div>
            <button id="tourResearchPopSubmit">جستجوی جدید</button>
        </div>
        <script>
            $(document).ready (function (){
                $('#tourErrorPopsCloseBtn').click(function () {
                    $('#tourSearchPopsError').hide();
                });
                $('#tourSearchPopsCloseBtn').click(function () {
                    $('#tourSearchPops').hide();
                });
            })
        </script>
        <script async>
            var currIdx, newElement, thisVal, imgPath = ["1.jpg", "2.jpg", "3.jpg", "4.jpg"],
                    titles = ["گیلان", "بندر ترکمن", "قشم", "گردنه حیران"],
                    photoGraphers = [" ", "عکس از علی مهدی حقدوست", "عکس از منصور وحدانی", "عکس از مصطفی قوینامین"], options = {
                        slider_Wrap: "#pbSlider0",
                        slider_Threshold: 10,
                        slider_Speed: 600,
                        slider_Ease: "ease-out",
                        slider_Drag: !0,
                        slider_Arrows: {enabled: !0},
                        slider_Dots: {class: ".o-slider-pagination", enabled: !0, preview: !0},
                        slider_Breakpoints: {
                            default: {height: 500},
                            tablet: {height: 350, media: 1024},
                            smartphone: {height: 250, media: 768}
                        }
                    }, slider_Opts = $.extend({
                        slider_Wrap: "pbSlider0",
                        slider_Item: ".o-slider--item",
                        slider_Drag: !0,
                        slider_Dots: {class: ".o-slider-pagination", enabled: !0, preview: !0},
                        slider_Arrows: {class: ".o-slider-arrows", enabled: !0},
                        slider_Threshold: 25,
                        slider_Speed: 1e3,
                        slider_Ease: "cubic-bezier(0.5, 0, 0.5, 1)",
                        slider_Breakpoints: {
                            default: {height: 500},
                            tablet: {height: 400, media: 1024},
                            smartphone: {height: 300, media: 768}
                        }
                    }, options), pbSlider = {};

            function changeSlider(e) {
                $(".o-slider--item").removeClass("isActive"), $("#sliderItem_" + e).addClass("isActive")
            }

            pbSlider.slider_Wrap = slider_Opts.slider_Wrap, pbSlider.slider_Item = slider_Opts.slider_Item, pbSlider.slider_Dots = slider_Opts.slider_Dots, pbSlider.slider_Threshold = slider_Opts.slider_Threshold, pbSlider.slider_Active = 0, pbSlider.slider_Count = 0, pbSlider.slider_NavWrap = '<div class="o-slider-controls"></div>', pbSlider.slider_NavPagination = '<ul class="o-slider-pagination"></ul>', pbSlider.slider_NavArrows = '<ul class="o-slider-arrows"><li class="o-slider-prev"><span class="icon-left-open-big"></span></li><li class="o-slider-next"><span class="icon-right-open-big"></span></li></ul>';
            var loaderHtml = '<div class="loaderWrap"><div class="ball-scale-multiple"><div></div><div></div><div></div><div></div></div></div>';

            function pbTouchSlider() {
                for (newElement = "<div class='o-sliderContainer' id='pbSliderWrap0' style='margin-top: 0'>", newElement += "<div class='o-slider' style='display: block !important;' id='pbSlider0'></div></div", $("#sliderBarDIV").append(newElement), pbSlider.pbInit = function (e) {
                    pbSlider.slider_Draggable = e, pbSlider.slider_Count = $(pbSlider.slider_Wrap).find(pbSlider.slider_Item).length, $("#pbSliderWrap0").css("width", 100 * pbSlider.slider_Count + "%");
                    for (var i = 0; i < pbSlider.slider_Count; i++) $("#sliderItem_" + i).css({width: 100 / pbSlider.slider_Count + "%"});
                    var r = 0;
                    if ($(pbSlider.slider_Wrap).find(pbSlider.slider_Item).each(function () {
                                $(this).attr("data-id", "slide-" + r++)
                            }), !0 !== slider_Opts.slider_Arrows.enabled && !0 !== slider_Opts.slider_Dots.enabled || $(pbSlider.slider_Wrap).append(pbSlider.slider_NavWrap), !0 === slider_Opts.slider_Arrows.enabled && $(pbSlider.slider_Wrap).append(pbSlider.slider_NavArrows), !0 === slider_Opts.slider_Dots.enabled) {
                        var l = 0;
                        for ($(pbSlider.slider_Wrap).append(pbSlider.slider_NavPagination); l < pbSlider.slider_Count; l++) {
                            var d = l === pbSlider.slider_Active ? ' class="isActive"' : "", s = 'data-increase="' + [l] + '"',
                                    a = $(pbSlider.slider_Wrap).find("[data-id='slide-" + l + "']").attr("data-image");
                            !0 === slider_Opts.slider_Dots.preview ? $(pbSlider.slider_Wrap).find(pbSlider.slider_Dots.class).append("<li " + d + " " + s + '><span class="o-slider--preview" style="background-image:url(' + a + ')"></span></li>') : $(pbSlider.slider_Wrap).find(pbSlider.slider_Dots.class).append("<li " + d + " " + s + "></li>")
                        }
                    }
                    setTimeout(function () {
                        $(pbSlider.slider_Item + "[data-id=slide-" + pbSlider.slider_Active + "]").addClass("isActive")
                    }, 400), $(pbSlider.slider_Wrap + " .o-slider-pagination li").on("click", function () {
                        var e = $(this).attr("data-increase");
                        $(this).hasClass("isActive") || pbSlider.pbGoslide(e)
                    }), $(pbSlider.slider_Wrap + " .o-slider-prev").addClass("isDisabled"), $(pbSlider.slider_Wrap + " .o-slider-arrows li").on("click", function () {
                        $(this).hasClass("o-slider-next") ? pbSlider.pbGoslide(pbSlider.slider_Active + 1) : pbSlider.pbGoslide(pbSlider.slider_Active - 1)
                    })
                }, pbSlider.pbGoslide = function (e) {
                    if ($(pbSlider.slider_Wrap + " .o-slider-arrows li").removeClass("isDisabled"), e < 0 ? pbSlider.slider_Active = 0 : e > pbSlider.slider_Count - 1 ? pbSlider.slider_Active = pbSlider.slider_Count - 1 : pbSlider.slider_Active = e, pbSlider.slider_Active >= pbSlider.slider_Count - 1) {
                        $(pbSlider.slider_Wrap).find(pbSlider.slider_Item).first();
                        $(pbSlider.slider_Wrap + " .o-slider-next").addClass("isDisabled")
                    } else pbSlider.slider_Active <= 0 ? $(pbSlider.slider_Wrap + " .o-slider-prev").addClass("isDisabled") : $(pbSlider.slider_Wrap + " .o-slider-arrows li").removeClass("isDisabled");
                    pbSlider.slider_Active != pbSlider.slider_Count - 1 && 0 != pbSlider.slider_Active && $(pbSlider.slider_Wrap).find(pbSlider.slider_Item).addClass("isMoving"), $(pbSlider.slider_Item).css("transform", ""), pbSlider.slider_Draggable = "#sliderItem_" + e, $(pbSlider.slider_Draggable).addClass("isAnimate");
                    var i = -100 * pbSlider.slider_Active;
                    if ($(pbSlider.slider_Draggable).css({
                                perspective: "1000px",
                                "backface-visibility": "hidden",
                                transform: "translateX( " + i + "% )"
                            }), clearTimeout(pbSlider.timer), pbSlider.timer = setTimeout(function () {
                                $(pbSlider.slider_Wrap).find(pbSlider.slider_Draggable).removeClass("isAnimate"), $(pbSlider.slider_Wrap).find(pbSlider.slider_Item).removeClass("isActive").removeClass("isMoving"), $(pbSlider.slider_Wrap).find(pbSlider.slider_Item + "[data-id=slide-" + pbSlider.slider_Active + "]").addClass("isActive"), $(pbSlider.slider_Wrap + " .o-slider--item img").css("transform", "translateX(0px )")
                            }, slider_Opts.slider_Speed), !0 === slider_Opts.slider_Dots.enabled) {
                        for (var r = $(pbSlider.slider_Wrap).find(pbSlider.slider_Dots.class + " > *"), l = 0; l < r.length; l++) {
                            var d = l == pbSlider.slider_Active ? "isActive" : "";
                            $(pbSlider.slider_Wrap).find(r[l]).removeClass("isActive").addClass(d), $(pbSlider.slider_Wrap).find(r[l]).children().removeClass("isActive").addClass(d)
                        }
                        setTimeout(function () {
                            $(pbSlider.slider_Wrap).find(r).children().removeClass("isActive")
                        }, 500)
                    }
                    pbSlider.slider_Active = Number(pbSlider.slider_Active)
                }, pbSlider.auto = function () {
                    pbSlider.autoTimer = setInterval(function () {
                        pbSlider.slider_Active >= pbSlider.slider_Count - 1 ? pbSlider.pbGoslide(0) : $(pbSlider.slider_Wrap + " .o-slider-next").trigger("click")
                    }, 3e3)
                }, currIdx = 0; currIdx < 4; currIdx++) {
                    thisVal = "#sliderItem_" + currIdx, newElement = "<div class='o-slider--item' id='sliderItem_" + currIdx + "' data-image='{{URL::asset('images') . '/'}}" + imgPath[currIdx] + "' style='background-image: url(\"{{URL::asset('images') . '/'}}" + imgPath[currIdx] + "\");'>", newElement += "<div class='o-slider-textWrap'>", newElement += "<span class='a-divider'></span>", newElement += "<h2 class='o-slider-subTitle'>" + titles[currIdx] + "</h2>", newElement += "<span class='a-divider'></span>", newElement += "<p class='o-slider-paragraph'>" + photoGraphers[currIdx] + "</p>", newElement += "</div></div>", $("#pbSlider0").append(newElement), 0 == currIdx && $("head").append("<style>" + pbSlider.slider_Wrap + " .o-slider.isAnimate{-webkit-transition: all " + slider_Opts.slider_Speed + "ms " + slider_Opts.slider_Ease + ";transition: all " + slider_Opts.slider_Speed + "ms " + slider_Opts.slider_Ease + ";</style>"), setTimeout(function () {
                        var e = $(slider_Opts.slider_Wrap + " .loaderWrap");
                        $(e).hide()
                    }, 200), $(pbSlider.slider_Wrap + " .o-slider-controls").addClass("isVisible"), $(pbSlider.slider_Draggable).addClass("isVisible");
                    var e = document.documentElement.clientWidth;
                    e >= slider_Opts.slider_Breakpoints.tablet.media ? $(pbSlider.slider_Wrap + ".o-sliderContainer," + pbSlider.slider_Wrap + " " + pbSlider.slider_Item).css({height: slider_Opts.slider_Breakpoints.default.height}) : e >= slider_Opts.slider_Breakpoints.smartphone.media ? $(pbSlider.slider_Wrap + ".o-sliderContainer," + pbSlider.slider_Wrap + " " + pbSlider.slider_Item).css({height: slider_Opts.slider_Breakpoints.tablet.height}) : $(pbSlider.slider_Wrap + ".o-sliderContainer," + pbSlider.slider_Wrap + " " + pbSlider.slider_Item).css({height: slider_Opts.slider_Breakpoints.smartphone.height}), 3 == currIdx && pbSlider.pbInit(thisVal)
                }
            }

            $(slider_Opts.slider_Wrap).each(function () {
                $("#pbSlider0").append(loaderHtml)
            }), pbTouchSlider();
            var mod;
            mod = angular.module("infinite-scroll", []), mod.directive("infiniteScroll", ["$rootScope", "$window", "$timeout", function (i, n, e) {
                return {
                    link: function (t, l, o) {
                        var r, c, f, a;
                        return n = angular.element(n), f = 0, null != o.infiniteScrollDistance && t.$watch(o.infiniteScrollDistance, function (i) {
                            return f = parseInt(i, 10)
                        }), a = !0, r = !1, null != o.infiniteScrollDisabled && t.$watch(o.infiniteScrollDisabled, function (i) {
                            return a = !i, a && r ? (r = !1, c()) : void 0
                        }), c = function () {
                            var e, c, u, d;
                            return d = n.height() + n.scrollTop(), e = l.offset().top + l.height(), c = e - d, u = n.height() * f >= c, u && a ? i.$$phase ? t.$eval(o.infiniteScroll) : t.$apply(o.infiniteScroll) : u ? r = !0 : void 0
                        }, n.on("scroll", c), t.$on("$destroy", function () {
                            return n.off("scroll", c)
                        }), e(function () {
                            return o.infiniteScrollImmediateCheck ? t.$eval(o.infiniteScrollImmediateCheck) ? c() : void 0 : c()
                        }, 0)
                    }
                }
            }])
        </script>
</div>


</body>
</html>
