<!DOCTYPE html>
<html>
<head>
    @include('layouts.topHeader')
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <link rel='stylesheet' type='text/css' media='screen, print'
          href='{{URL::asset('css/theme2/eatery_overview.css?v=2')}}'/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/long_lived_global_legacy_2.css?v=1')}}"/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/shazdeDesigns/tourList.css?v=1')}}"/>


    <title>
        {{--@if($placeMode == "hotel")--}}
            {{--هتل های--}}
        {{--@elseif($placeMode == "restaurant")--}}
            {{--رستوران های--}}
        {{--@else--}}
            {{--اماکن--}}
        {{--@endif--}}

        {{--@if($mode == "state")--}}
            {{--استان--}}
        {{--@else--}}
            {{--شهر--}}
        {{--@endif--}}
        {{--{{$city}}--}}
    </title>

    <script src= {{URL::asset("js/calendar.js") }}></script>
    <script src= {{URL::asset("js/jalali.js") }}></script>

</head>

<body id="BODY_BLOCK_JQUERY_REFLOW"
      class=" r_map_position_ul_fake ltr domn_en_US lang_en long_prices globalNav2011_reset rebrand_2017 css_commerce_buttons flat_buttons sitewide xo_pin_user_review_to_top track_back">

<div id="PAGE" class="filterSearch redesign_2015 non_hotels_like desktop scopedSearch">
    @include('layouts.placeHeader')
    <div id = "tourMainDiv" class=" hotels_lf_redesign ui_container is-mobile responsive_body tourMainDiv">
        <div class="restaurants_list">
            <div ID="taplc_hotels_redesign_header_0" class="ppr_rup ppr_priv_hotels_redesign_header">
                <div id="hotels_lf_header" class="restaurants_list">
                    <div id="p13n_tag_header_wrap" class="tag_header p13n_no_see_through ontop hotels_lf_header_wrap">
                        <div id="p13n_tag_header" class="restaurants_list no_bottom_padding">
                            <div id="p13n_welcome_message" class="easyClear tourMainDivHeading">
                                <h1 id="tourListHeading" class="p13n_geo_hotels " >
                                    شما در حال انتخاب تورهای
                                    <span>مبدأ</span>
                                    به
                                    <span>مقصد</span>
                                    هستید.
                                </h1>
                                {{--<div style="clear: both"></div>--}}
                                <div id="searchDiv">
                                    <div class="srchBox" id="tourSearchBox">
                                        <button class="srchBtn" onclick="inputSearch(0)">جستجو</button>
                                        <div class="calenderBox" id="tourSearchInitiatePointBox">
                                            <label id="calendar-container-edit-1placeDate" class="dateLabel">
                                                <input name="text" id="goDate" type="text" class="inputDateLabel" placeholder="نام مبدأ" >
                                            </label>
                                        </div>
                                        <div class="calenderBox" id="tourSearchDestinationPointBox">
                                            <label id="calendar-container-edit-2placeDate" class="dateLabel" style="margin-right: 14px !important;">
                                                <input name="text" id="backDate" type="text" class="returnDate inputDateLabel" placeholder="نام مقصد" >
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                {{--@include('layouts.calendar')--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="Restaurants prodp13n_jfy_overflow_visible">

            <div class="wrap"></div>

            <div id="BODYCON" class="col easyClear poolX adjust_padding new_meta_chevron_v2" ng-app="mainApp">

                <style>
                    .loader {
                        /*border: 16px solid #f3f3f3;*/
                        /*border-radius: 50%;*/
                        background-image: url("{{URL::asset("images/loading.gif?v=".$fileVersions)}}");
                        /*border-top: 16px solid blue;*/
                        /*border-right: 16px solid green;*/
                        /*border-bottom: 16px solid red;*/
                        width: 100px;
                        height: 100px;
                        /*-webkit-animation: spin 2s linear infinite;*/
                        /*animation: spin 2s linear infinite;*/
                    }

                    @-webkit-keyframes spin {
                        0% {
                            -webkit-transform: rotate(0deg);
                        }
                        100% {
                            -webkit-transform: rotate(360deg);
                        }
                    }

                    @keyframes spin {
                        0% {
                            transform: rotate(0deg);
                        }
                        100% {
                            transform: rotate(360deg);
                        }
                    }
                </style>

                <div class="eateryOverviewContent">
                    <div class="ui_columns is-partitioned is-mobile">

                        <div id="mainDivLeftOne" class="lhr ui_column is-3 hideCount reduced_height"
                             ng-controller="FilterController as filterCntl" style="direction: rtl;padding: 10px">

                            <div class="ppr_rup ppr_priv_restaurant_filters">
                                <div class="verticalFilters placements">
                                    <div id="EATERY_FILTERS_CONT" class="eatery_filters">
                                        <div class="prw_rup prw_restaurants_restaurant_filters rightFilterBarHeading">
                                            <b>نتایج را شخصی‌سازی کنید</b>
                                        </div>
                                        <div class="prw_rup prw_restaurants_restaurant_filters">
                                            <div id="jfy_filter_bar_establishmentTypeFilters"
                                                 class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
                                                <div class="filterGroupTitle rightFilterBarDivsHeading ">چه نوع  گردشگری هستم؟
                                                    <button class="showFilterChoices">
                                                        <span class="glyphicon glyphicon-triangle-bottom"></span>
                                                    </button>
                                                </div>
                                                <div class="lefFiltersCheckboxesHidden">
                                                    <div id="" class="leftFiltersCheckboxesMainDivs">
                                                        <center class="rightFiltersCheckboxesDivs tourKindDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22">
                                                                <p id="cityKindTour" class="tourKindIcons"></p>
                                                                <p id="cityKindTourName" class="tourKindNames">شهرگردی</p>
                                                            </label>
                                                        </center>
                                                        <center class="rightFiltersCheckboxesDivs tourKindDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22">
                                                                <p id="hikingKindTour" class="tourKindIcons"></p>
                                                                <p id="hikingKindTourName" class="tourKindNames">طبیعت‌گردی</p>
                                                            </label>
                                                        </center>
                                                        <center class="rightFiltersCheckboxesDivs tourKindDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22">
                                                                <p id="villageKindTour" class="tourKindIcons"></p>
                                                                <p id="villageKindTourName" class="tourKindNames">روستاگردی</p>
                                                            </label>
                                                        </center>
                                                        <div style="clear: both"></div>
                                                        <center class="rightFiltersCheckboxesDivs tourKindDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22">
                                                                <p id="adventureKindTour" class="tourKindIcons"></p>
                                                                <p id="adventureKindTourName" class="tourKindNames">ماجراجویی</p>
                                                            </label>
                                                        </center>
                                                        <center class="rightFiltersCheckboxesDivs tourKindDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22">
                                                                <p id="healthKindTour" class="tourKindIcons"></p>
                                                                <p id="healthKindTourName" class="tourKindNames">سلامت</p>
                                                            </label>
                                                        </center>
                                                        <center class="rightFiltersCheckboxesDivs tourKindDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22">
                                                                <p id="recreationalKindTour" class="tourKindIcons"></p>
                                                                <p id="recreationalKindTourName" class="tourKindNames">تفریحی</p>
                                                            </label>
                                                        </center>
                                                        <div style="clear: both"></div>
                                                        <center class="rightFiltersCheckboxesDivs tourKindDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22">
                                                                <p id="artisticKindTour" class="tourKindIcons"></p>
                                                                <p id="artisticKindTourName" class="tourKindNames">هنری</p>
                                                            </label>
                                                        </center>
                                                        <center class="rightFiltersCheckboxesDivs tourKindDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22">
                                                                <p id="sportsKindTour" class="tourKindIcons"></p>
                                                                <p id="sportsKindTourName" class="tourKindNames">ورزشی</p>
                                                            </label>
                                                        </center>
                                                        <center class="rightFiltersCheckboxesDivs tourKindDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22">
                                                                <p id="scientificKindTour" class="tourKindIcons"></p>
                                                                <p id="scientificKindTourName" class="tourKindNames">علمی</p>
                                                            </label>
                                                        </center>
                                                        <div style="clear: both"></div>
                                                        <center class="rightFiltersCheckboxesDivs tourKindDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22">
                                                                <p id="culturalKindTour" class="tourKindIcons"></p>
                                                                <p id="culturalKindTourName" class="tourKindNames">فرهنگی</p>
                                                            </label>
                                                        </center>
                                                        <center class="rightFiltersCheckboxesDivs tourKindDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22">
                                                                <p id="ProfessionalKindTour" class="tourKindIcons"></p>
                                                                <p id="ProfessionalKindTourName" class="tourKindNames">تخصصی</p>
                                                            </label>
                                                        </center>

                                                        <center class="rightFiltersCheckboxesDivs tourKindDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22">
                                                                <p id="" class="tourKindIcons"></p>
                                                                <p class="tourKindNames"></p>
                                                            </label>
                                                        </center>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <script>
                                            $(document).ready(function(){
                                                $(".tourKindIcons").mouseenter(function(){
                                                    $(this).css("background-color", "var(--koochita-light-green)");
                                                });
                                                $(".tourKindIcons").mouseleave(function(){
                                                    var $this = $(this);
                                                    if($this.data('clicked')) {
                                                        $(this).css("background-color", "var(--koochita-light-green)");
                                                    }
                                                    else {
                                                        $(this).css("background-color", "#e5e5e5");
                                                    }
                                                });
                                            });
                                        </script>
                                        <div class="prw_rup prw_restaurants_restaurant_filters">
                                            <div id="jfy_filter_bar_establishmentTypeFilters"
                                                 class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
                                                <div class="filterGroupTitle rightFilterBarDivsHeading ">علایق خود را مشخص کنید؟
                                                    <button class="showFilterChoices">
                                                        <span class="glyphicon glyphicon-triangle-bottom"></span>
                                                    </button>
                                                </div>
                                                <div class="lefFiltersCheckboxesHidden">
                                                    <div id="" class="leftFiltersCheckboxesMainDivs">
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;فرهنگی </label>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c23" value="review"/>
                                                            <label for="c23"><span></span>&nbsp;&nbsp; تاریخی </label>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c24" value="alphabet"/>
                                                            <label for="c24"><span></span>&nbsp;&nbsp; خرید </label>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;غذا </label>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c23" value="review"/>
                                                            <label for="c23"><span></span>&nbsp;&nbsp; پیاده‌روی </label>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c24" value="alphabet"/>
                                                            <label for="c24"><span></span>&nbsp;&nbsp; مردم‌شناسی </label>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;موزه </label>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c23" value="review"/>
                                                            <label for="c23"><span></span>&nbsp;&nbsp; شبانه </label>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c24" value="alphabet"/>
                                                            <label for="c24"><span></span>&nbsp;&nbsp; فیلم </label>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c24" value="alphabet"/>
                                                            <label for="c24"><span></span>&nbsp;&nbsp; جشنواره </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prw_rup prw_restaurants_restaurant_filters">
                                            <div id="jfy_filter_bar_establishmentTypeFilters"
                                                 class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
                                                <div class="filterGroupTitle rightFilterBarDivsHeading ">درجه سختی تور را مشخص کنید
                                                    <button class="showFilterChoices">
                                                        <span class="glyphicon glyphicon-triangle-bottom"></span>
                                                    </button>
                                                </div>
                                                <div class="lefFiltersCheckboxesHidden">
                                                    <div id="" class="leftFiltersCheckboxesMainDivs">
                                                        <center class="rightFiltersCheckboxesDivs tourLevelGradeDiv ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22">
                                                                <p id="easyLevelTour" class="tourLevelIcons"></p>
                                                                <sub>آسان</sub>
                                                            </label>
                                                        </center>
                                                        <center class="rightFiltersCheckboxesDivs tourLevelGradeDiv ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22">
                                                                <p id="lightLevelTour" class="tourLevelIcons"></p>
                                                                <sub>سبک</sub>
                                                            </label>
                                                        </center>
                                                        <center class="rightFiltersCheckboxesDivs tourLevelGradeDiv ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22">
                                                                <p id="activeLevelTour" class="tourLevelIcons"></p>
                                                                <sub>پرتحرک</sub>
                                                            </label>
                                                        </center>
                                                        <center class="rightFiltersCheckboxesDivs tourLevelGradeDiv ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22">
                                                                <p id="hardLevelTour" class="tourLevelIcons"></p>
                                                                <sub>سخت</sub>
                                                            </label>
                                                        </center>
                                                        <div style="clear:both"></div>
                                                        <center class="rightFiltersCheckboxesDivs tourLevelGradeDiv ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22">
                                                                <p id="professionalLevelTour" class="tourLevelIcons"></p>
                                                                <sub>تخصصی</sub>
                                                            </label>
                                                        </center>
                                                        <center class="rightFiltersCheckboxesDivs tourLevelGradeDiv ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22">
                                                                <p id="blindLevelTour" class="tourLevelIcons"></p>
                                                                <sub>نابینایان</sub>
                                                            </label>
                                                        </center>
                                                        <center class="rightFiltersCheckboxesDivs tourLevelGradeDiv ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22">
                                                                <p id="disabledLevelTour" class="tourLevelIcons"></p>
                                                                <sub>معلولان</sub>
                                                            </label>
                                                        </center>
                                                        <center class="rightFiltersCheckboxesDivs tourLevelGradeDiv ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22">
                                                                <p id="studentLevelTour" class="tourLevelIcons"></p>
                                                                <sub>دانش‌آموزان</sub>
                                                            </label>
                                                        </center>
                                                        <script>
                                                            $(document).ready(function(){
                                                                $(".tourLevelIcons").mouseenter(function(){
                                                                    $(this).css("background-color", "var(--koochita-light-green)"),
                                                                    $(this).css("color" , "white");
                                                                });
                                                                $(".tourLevelIcons").mouseleave(function(){
                                                                    $(this).css("background-color", "#e5e5e5"),
                                                                    $(this).css("color" , "black");
                                                                });
                                                            });
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prw_rup prw_restaurants_restaurant_filters">
                                            <div id="jfy_filter_bar_establishmentTypeFilters"
                                                 class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
                                                <div class="filterGroupTitle rightFilterBarDivsHeading ">اگر اولین بارتان هست
                                                    <button class="showFilterChoices">
                                                        <span class="glyphicon glyphicon-triangle-bottom"></span>
                                                    </button>
                                                </div>
                                                <div class="lefFiltersCheckboxesHidden">
                                                    <div id="" class="leftFiltersCheckboxesMainDivs">
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-12">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;نمایش تورهای متفاوت </label>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-12">
                                                            <input ng-model="sort" type="radio" id="c23" value="review"/>
                                                            <label for="c23"><span></span>&nbsp;&nbsp; تورهایی که نباید از دست داد </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prw_rup prw_restaurants_restaurant_filters">
                                            <div id="jfy_filter_bar_establishmentTypeFilters"
                                                 class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
                                                <div class="filterGroupTitle rightFilterBarDivsHeading ">تیپ خود را مشخص کنید
                                                    <button class="showFilterChoices">
                                                        <span class="glyphicon glyphicon-triangle-bottom"></span>
                                                    </button>
                                                </div>
                                                <div class="lefFiltersCheckboxesHidden">
                                                    <div id="" class="leftFiltersCheckboxesMainDivs">
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;جوانانه </label>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c23" value="review"/>
                                                            <label for="c23"><span></span>&nbsp;&nbsp; گروهی </label>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c24" value="alphabet"/>
                                                            <label for="c24"><span></span>&nbsp;&nbsp; دو نفره </label>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;بازی </label>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c23" value="review"/>
                                                            <label for="c23"><span></span>&nbsp;&nbsp; خانوادگی </label>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c24" value="alphabet"/>
                                                            <label for="c24"><span></span>&nbsp;&nbsp; با بچه </label>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;اقتصادی </label>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c23" value="review"/>
                                                            <label for="c23"><span></span>&nbsp;&nbsp; آب و هوای خاص </label>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c24" value="alphabet"/>
                                                            <label for="c24"><span></span>&nbsp;&nbsp; ماه عسل </label>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c24" value="alphabet"/>
                                                            <label for="c24"><span></span>&nbsp;&nbsp; ماجراجویی </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prw_rup prw_restaurants_restaurant_filters">
                                            <div id="jfy_filter_bar_establishmentTypeFilters"
                                                 class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
                                                <div class="filterGroupTitle rightFilterBarDivsHeading ">نوع راهنمای تور را مشخص کنید
                                                    <button class="showFilterChoices">
                                                        <span class="glyphicon glyphicon-triangle-bottom"></span>
                                                    </button>
                                                </div>
                                                <div class="lefFiltersCheckboxesHidden">
                                                    <div id="" class="leftFiltersCheckboxesMainDivs">
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;راهنمای کامل </label>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c23" value="review"/>
                                                            <label for="c23"><span></span>&nbsp;&nbsp; راهنمای محلی </label>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c24" value="alphabet"/>
                                                            <label for="c24"><span></span>&nbsp;&nbsp; راهنمای خصوصی </label>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c24" value="alphabet"/>
                                                            <label for="c24"><span></span>&nbsp;&nbsp; بدون راهنما </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prw_rup prw_restaurants_restaurant_filters">
                                            <div id="jfy_filter_bar_establishmentTypeFilters"
                                                 class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
                                                <div class="filterGroupTitle rightFilterBarDivsHeading ">نوع اقامتگاه تور را مشخص کنید
                                                    <button class="showFilterChoices">
                                                        <span class="glyphicon glyphicon-triangle-bottom"></span>
                                                    </button>
                                                </div>
                                                <div class="lefFiltersCheckboxesHidden">
                                                    <div id="" class="leftFiltersCheckboxesMainDivs">
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;هتل سه ستاره </label>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c24" value="alphabet"/>
                                                            <label for="c24"><span></span>&nbsp;&nbsp; بوم گردی </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="ad iab_medRec">
                                <div id="gpt-ad-300x250-300x600-bottom" class="adInner gptAd delayAd"></div>
                            </div>
                            <div class="ad iab_supSky">
                                <div id="gpt-ad-160x600" class="adInner gptAd delayAd"></div>
                            </div>
                            <script>
//                                $(document).ready (function (){
//                                    $('#showFilterChoices1').click(function() {
//                                        $('#rightFiltersCheckboxesMainDivs1').toggle();
//                                        $('#moreChoices1').toggle();
//                                    })
//                                })
                            </script>
                        </div>

                        <div id="mainDivMiddleOne" class="ui_column is-9" ng-controller="PlaceController as cntr" style="direction: rtl;padding: 10px">
                            <div id="mainDivMainBlock">

                                <div id="main1stDivMiddleClassifyBar" class="prw_rup prw_restaurants_restaurant_filters mainDivMiddleClassifyBars">
                                    <b>مرتب‌سازی بر اساس</b>
                                    <span style=" width: 20%">نزدیکترین زمان حرکت</span>
                                    <span style=" width: 9%">‌ارزان‌ترین</span>
                                    <span style=" width: 9%">جالب‌ترین</span>
                                    <span style=" width: 9%">کوتاه‌ترین</span>
                                    <span style=" width: 24%">نزدیک‌ترین تعطیلات رسمی</span>
                                    <span style=" width: 10%">آخر هفته</span>
                                </div>

                                <div id="main2ndDivMiddleClassifyBar" class="prw_rup prw_restaurants_restaurant_filters mainDivMiddleClassifyBars">
                                    <b style="width: 23%">شرایط کاری خود را در نظر بگیرید</b>
                                    <span style="width: 16%">فقط تعطیلات رسمی</span>
                                    <span style="width: 12%">فقط آخر هفته</span>
                                    <span style="width: 18%">شامل حداکثر
                                        <select>
                                            <option></option>
                                        </select>
                                        روز کاری</span>
                                    <span style="width: 15%">فقط روزهای کاری</span>
                                    <span style="width: 16%">تعریف روزکاری شما</span>
                                </div>

                                <div id="filterBarAlert">
                                    <span id="filterBarAlertText">شما با استفاده از فیلترها نتایج جستجو را محدود نمودید و ممکن است بعضی از نتایج را مشاهده نکنید. فیلترها براساس انتخاب‌های شما هوشمندانه تغییر می‌کنند.</span>
                                    <span id="removeFilterSpan">حذف فیلترها</span>
                                </div>
                                <div class="tourDetailsFullWidthBox">
                                    <div class="tourDetailsMainBox">
                                        <div id="tourDetailsMainBoxLogoBox" class="circleBase type2"></div>

                                        <div class="col-xs-5" id="tourDetailsRightBox">
                                            <div id="tourDetailsRightBoxImg">

                                            </div>
                                            <div id="tourDetailsRightBoxTexts">
                                                <b>تور جهانگردی من</b>
                                                <div>
                                                    <span class="greenFontColor">مقصد:</span>
                                                    <span>مقصد</span>
                                                </div>
                                                <div>
                                                    <span class="greenFontColor">حرکت از:</span>
                                                    <span>مبدأ</span>
                                                </div>
                                                <div>
                                                    <span class="greenFontColor">از</span>
                                                    <span>تاریخ شروع</span>
                                                </div>
                                                <div>
                                                    <span class="greenFontColor">تا</span>
                                                    <span>تاریخ پایان</span>
                                                </div>
                                                <div>
                                                    <span>چند</span>
                                                    <span class="greenFontColor">روز و</span>
                                                    <span>چند</span>
                                                    <span class="greenFontColor">شب</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-3" id="tourDetailsMiddleBox">
                                            <div>
                                                <span class="greenFontColor">نوع تور:</span>
                                                <span>شهرگردی</span>
                                            </div>
                                            <div>
                                                <span class="greenFontColor">درجه سختی:</span>
                                                <span>ساده</span>
                                            </div>
                                            <div>
                                                <span class="greenFontColor">حمل و نقل اصلی:</span>
                                                <span>اتوبوس</span>
                                            </div>
                                            <div>
                                                <span class="greenFontColor">حمل و نقل محلی:</span>
                                                <span>اتوبوس</span>
                                            </div>
                                            <div>
                                                <span class="greenFontColor">اقامتگاه:</span>
                                                <span>هتل</span>
                                            </div>
                                            <div>
                                                <span class="greenFontColor">وعده غذایی:</span>
                                                <span>صبحانه</span>
                                            </div>
                                        </div>
                                        <div class="col-xs-4 tourDetailsPriceBox" id="tourDetailsLeftBox">
                                            <div class="priceDiv">
                                                <span>شروع قیمت از:</span>
                                                <span>650.000</span>
                                                <hr>
                                                <span class="afterDiscountPrice">550.000</span>
                                            </div>
                                            <div class="full-width inline-block">
                                                <div class="discountAlerts">
                                                    <span>10 درصد تخفیف ویژه نوروز</span>
                                                    <span>10 درصد تخفیف ثبت نام گروهی</span>
                                                    <span>تخفیف ویژه کودکان</span>
                                                </div>
                                                <div class="moreOffersBtn moreOfferBtnFullBar">
                                                    <button class=" btn btn-warning">مشاهده پیشنهاد</button>
                                                </div>
                                            </div>
                                            <div>
                                                <span class="greenFontColor">برگزار کننده:</span>
                                                <span>آژانس ستاره طلایی</span>
                                            </div>
                                            <center>
                                                <div>0 نقد</div>
                                                <div>1 امتیاز</div>
                                                <div class="prw_rup prw_common_bubble_rating overallBubbleRating">
                                                        <span class="ui_bubble_rating bubble_50" style="font-size:12px;"
                                                              property="ratingValue" content="5" alt='5 of 5 bubbles'></span>
                                                </div>
                                            </center>
                                        </div>
                                        <div id="fastReserveTour1" class="fastReserveTour">رزرو آنی</div>
                                        <div id="mustSeeTour1" class="mustSeeTour">باید دید</div>
                                        <div id="groupDiscountTour1" class="groupDiscountTour">تخفیف گروهی</div>
                                        <div id="discountBoxTour1" class="discountBoxTour">
                                            <span>10%</span>
                                        </div>
                                    </div>
                                    <div class="tourDetailsMainBoxMoreInfo full-width">
                                        <div class="tourDetailsMoreInfoRightBox inline-block">
                                            <div>شرح کلی</div>
                                            <hr>
                                            <div>شهرها</div>
                                            <hr>
                                            <div>جاذبه‌ها</div>
                                            <hr>
                                            <div>تمرکز تور</div>
                                            <hr>
                                            <div>رفت و آمد</div>
                                        </div>
                                        <div class="tourDetailsMoreInfoLeftBox inline-block">
                                            <div class="col-xs-3 inline-block">
                                                <div>
                                                    <span class="greenFontColor">نوع تور:</span>
                                                    <span>شهرگردی</span>
                                                </div>
                                                <div>
                                                    <span class="greenFontColor">تمرکز تور:</span>
                                                    <span>تاریخی - فرهنگی</span>
                                                </div>
                                                <div>
                                                    <span class="greenFontColor">علایق:</span>
                                                    <span>خانواده</span>
                                                </div>
                                            </div>
                                            <div class="col-xs-3 inline-block">
                                                <div>
                                                    <span class="greenFontColor">درجه سختی:</span>
                                                    <span>آسان</span>
                                                </div>
                                            </div>
                                            <div class="col-xs-3 inline-block"></div>
                                            <div class="col-xs-3 inline-block"></div>
                                            <div style=" clear: both"></div>
                                            <div class="col-xs-12 inline-block redFontColor">اگر اولین بارتان هست این تور را از دست ندهید</div>

                                        </div>
                                    </div>
                                    <button id="toggleTourDetails1stBoxMoreInfo" class="toggleTourDetailsLessInfo">کمتر</button>
                                </div>
                            </div>
                            <div class="mainDivLittleBlock col-xs-4">
                                <div id="littleBoxLogoBox" class="circleBase type2"></div>
                                <center class="tourDetailsLittleBox inline-block full-width">
                                    <b class="inline-block full-width">تور جهانگردی من</b>
                                    <div id="tourDetailsLittleBoxImg">
                                    </div>
                                    <div class="inline-block tourDetailsLittleBox2ndDiv">
                                        <div class="inline-block full-width">
                                            <span class="greenFontColor">مقصد:</span>
                                            <span>مقصد</span>
                                        </div>
                                        <div class="inline-block full-width">
                                            <span class="greenFontColor">حرکت از:</span>
                                            <span>مبدأ</span>
                                        </div>
                                        <div class="inline-block full-width">
                                            <span class="greenFontColor">از</span>
                                            <span>تاریخ شروع</span>
                                        </div>
                                        <div class="inline-block full-width">
                                            <span class="greenFontColor">تا</span>
                                            <span>تاریخ پایان</span>
                                        </div>
                                        <div class="inline-block full-width">
                                            <span>چند</span>
                                            <span class="greenFontColor">روز و</span>
                                            <span>چند</span>
                                            <span class="greenFontColor">شب</span>
                                        </div>
                                    </div>
                                    <div class="tourDetailsPriceBox" >
                                        <div class="priceDiv">
                                            <span>شروع قیمت از:</span>
                                            <span>650.000</span>
                                            <hr>
                                            <span class="afterDiscountPrice">550.000</span>
                                        </div>
                                        <div class="full-width inline-block">
                                            <div class="discountAlerts">
                                                <span>10 درصد تخفیف ویژه نوروز</span>
                                                <span>10 درصد تخفیف ثبت نام گروهی</span>
                                                <span>تخفیف ویژه کودکان</span>
                                            </div>
                                            <div class="moreOffersBtn">
                                                <button class=" btn btn-warning">مشاهده پیشنهاد</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="fastReserveTour2" class="fastReserveTour">رزرو آنی</div>
                                    <div id="mustSeeTour2" class="mustSeeTour">باید دید</div>
                                    <div id="groupDiscountTour2" class="groupDiscountTour">تخفیف گروهی</div>
                                    <div id="discountBoxTour2" class="discountBoxTour">
                                        <span>10%</span>
                                    </div>
                                </center>
                                <button id="toggleTourDetailsLittleBoxMoreInfo" class="toggleTourDetailsMoreInfo">بیشتر</button>
                            </div>
                                <div class="verticalFilters placements"></div>
                                    <div id="EATERY_FILTERS_CONT" class="eatery_filters"></div>
                            {{--<div infinite-scroll="myPagingFunction()" class="coverpage">--}}
                                {{--<div class="ppr_ru
                                p ppr_priv_restaurants_coverpage_content">--}}
                                    {{--<div>--}}
                                        {{--<div class="prw_rup prw_restaurants_restaurants_coverpage_content">--}}
                                            {{--<div class="coverpage_widget">--}}
                                                {{--<div class="section">--}}

                                                    {{--<div class="single_filter_pois">--}}

                                                        {{--<div class="title ui_columns"><span--}}
                                                                    {{--class="titleWrap ui_column is-9"><a--}}
                                                                        {{--class="titleLink"></a></span><a--}}
                                                                    {{--class="view_all ui_column is-3"></a></div>--}}

                                                        {{--<div ng-repeat="packet in packets" class="option">--}}
                                                            {{--<div class="Price_3 ui_columns is-mobile">--}}

                                                                {{--<div ng-repeat="place in packet.places"--}}
                                                                     {{--class="ui_column is-3 is-mobile">--}}
                                                                    {{--<div class="poi">--}}

                                                                        {{--<a href="[[place.redirect]]" class="thumbnail">--}}
                                                                            {{--<div class="prw_rup prw_common_centered_thumbnail">--}}
                                                                                {{--<div class="sizing_wrapper"--}}
                                                                                     {{--style="width:200px;height:120px;">--}}
                                                                                    {{--<div class="centering_wrapper"--}}
                                                                                         {{--style="margin-top:-66px;">--}}
                                                                                        {{--<img ng-src='[[place.pic]]'--}}
                                                                                             {{--width="100%" height="100%"--}}
                                                                                             {{--class='photo_image'--}}
                                                                                             {{--alt='[[place.name]]'>--}}
                                                                                    {{--</div>--}}
                                                                                {{--</div>--}}
                                                                            {{--</div>--}}
                                                                        {{--</a>--}}
                                                                        {{--<div class="prw_rup prw_meta_saves_badge">--}}
                                                                            {{--<div class="savesButton">--}}
                                                                                {{--<span class="saves-widget-button saves secondary save-location-5247712 ui_icon heart saves-icon-locator"></span>--}}
                                                                            {{--</div>--}}
                                                                        {{--</div>--}}
                                                                        {{--<div class="detail">--}}

                                                                            {{--<div class="item name "--}}
                                                                                 {{--title="[[place.name]]"><a--}}
                                                                                        {{--class="poiTitle" target="_blank"--}}
                                                                                        {{--href="[[place.redirect]]">[[place.name]]</a>--}}
                                                                            {{--</div>--}}

                                                                            {{--<div class="item rating-count">--}}
                                                                                {{--<div class="rating-widget">--}}
                                                                                    {{--<div class="prw_rup prw_common_location_rating_simple">--}}
                                                                                        {{--<span class="[[place.ngClass]]"></span>--}}
                                                                                    {{--</div>--}}
                                                                                {{--</div>--}}
                                                                                {{--<a target="_blank" class="review_count"--}}
                                                                                   {{--href="">[[place.avgRate]] <span--}}
                                                                                            {{--style="color: #16174F;">نقد</span>--}}
                                                                                {{--</a>--}}
                                                                            {{--</div>--}}
                                                                            {{--<div class="item">استان: <span>[[place.state]]</span>--}}
                                                                            {{--</div>--}}
                                                                            {{--<div class="item">شهر:--}}
                                                                                {{--<span>[[place.city]]</span></div>--}}
                                                                            {{--<div class="booking"></div>--}}
                                                                        {{--</div>--}}
                                                                    {{--</div>--}}
                                                                {{--</div>--}}

                                                            {{--</div>--}}
                                                        {{--</div>--}}

                                                        {{--<center>--}}
                                                            {{--<div class="loader hidden"></div>--}}
                                                        {{--</center>--}}
                                                    {{--</div>--}}

                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="coverpage_tracking"></div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        </div>

                        <div id="mainDivRightOne" class="lhr ui_column is-3 hideCount reduced_height"
                             ng-controller="FilterController as filterCntl" style="direction: rtl;padding: 10px">

                            <div class="ppr_rup ppr_priv_restaurant_filters">
                                <div class="verticalFilters placements">
                                    <div id="EATERY_FILTERS_CONT" class="eatery_filters">
                                        <div class="prw_rup prw_restaurants_restaurant_filters rightFilterBarHeading">
                                            <b>جستجوی خود را محدودتر کنید</b>
                                        </div>
                                        <div class="prw_rup prw_restaurants_restaurant_filters">
                                            <div id="jfy_filter_bar_establishmentTypeFilters"
                                                 class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
                                                <div class="filterGroupTitle rightFilterBarDivsHeading ">به کجا می‌روید؟
                                                    <button class="showFilterChoices">
                                                        <span class="glyphicon glyphicon-triangle-bottom"></span>
                                                    </button>
                                                </div>
                                                <div class="filterGroupTitle rightFilterBarDivsHeading ">داخلی
                                                    <button class="showFilterChoices">
                                                        <span class="glyphicon glyphicon-triangle-bottom"></span>
                                                    </button>
                                                </div>
                                                <div class="destinationCityFiltersMainDiv">
                                                    <div class="destinationCityFiltersBox">
                                                        <b class="destinationCityFiltersHeadings">استان</b>
                                                        <span class="moreCities">بیشتر</span>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-lg-4 col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22"
                                                                   value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;تهران </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-lg-4 col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22"
                                                                   value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;اصفهان</label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-lg-4 col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22"
                                                                   value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;گیلان </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-lg-4 col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22"
                                                                   value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;سیستان</label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-lg-4 col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22"
                                                                   value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;خوزستان</label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-lg-4 col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22"
                                                                   value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;هرمزگان</label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                    </div>
                                                    <div class="destinationCityFiltersBox">
                                                        <b class="destinationCityFiltersHeadings">شهر</b>
                                                        <span class="moreCities">بیشتر</span>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-lg-4 col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22"
                                                                   value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;تهران </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-lg-4 col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22"
                                                                   value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;اصفهان</label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-lg-4 col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22"
                                                                   value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;گیلان </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-lg-4 col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22"
                                                                   value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;سیستان</label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-lg-4 col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22"
                                                                   value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;خوزستان</label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-sm-4 col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22"
                                                                   value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;هرمزگان
                                                            </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                    </div>
                                                    <center class="destinationCityFiltersBoxNotation">پس از انتخاب
                                                        استان‌ها می‌توانید با انتخاب شهرها دقیق‌تر بگردید.
                                                    </center>
                                                    <div class="filterGroupTitle rightFilterBarDivsHeading ">خارجی
                                                        <button class="showFilterChoices">
                                                            <span class="glyphicon glyphicon-triangle-bottom"></span>
                                                        </button>
                                                    </div>
                                                    <div class="destinationCityFiltersBox">
                                                        <b class="destinationCityFiltersHeadings">استان</b>
                                                        <span class="moreCities">بیشتر</span>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-sm-4 col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22"
                                                                   value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;تهران </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-sm-4 col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22"
                                                                   value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;اصفهان
                                                            </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-sm-4 col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22"
                                                                   value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;گیلان </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-sm-4 col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22"
                                                                   value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;سیستان
                                                            </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-sm-4 col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22"
                                                                   value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;خوزستان
                                                            </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-sm-4 col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22"
                                                                   value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;هرمزگان
                                                            </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                    </div>

                                                    <div class="destinationCityFiltersBox">
                                                        <b class="destinationCityFiltersHeadings">شهر</b>
                                                        <span class="moreCities">بیشتر</span>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-sm-4 col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;تهران </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-sm-4 col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;اصفهان </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-sm-4 col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;گیلان </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-sm-4 col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;سیستان </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-sm-4 col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;خوزستان </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-sm-4 col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;هرمزگان </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                    </div>
                                                    <center class="destinationCityFiltersBoxNotation">پس از انتخاب کشورها می‌توانید با انتخاب شهرها دقیق‌تر بگردید.</center>
                                                </div>
                                                <div class="rightFiltersCheckboxesHidden">
                                                    <div class="rightFiltersCheckboxesMainDivs">
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;امتیاز </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c23" value="review"/>
                                                            <label for="c23"><span></span>&nbsp;&nbsp; تعداد نقد </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c24" value="alphabet"/>
                                                            <label for="c24"><span></span>&nbsp;&nbsp; الفبا </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;امتیاز </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c23" value="review"/>
                                                            <label for="c23"><span></span>&nbsp;&nbsp; تعداد نقد </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c24" value="alphabet"/>
                                                            <label for="c24"><span></span>&nbsp;&nbsp; الفبا </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class= "moreChoices">
                                                    <button class= "moreChoicesBtn">بیشتر</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prw_rup prw_restaurants_restaurant_filters">
                                            <div id="jfy_filter_bar_establishmentTypeFilters"
                                                 class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible" style="margin-top: 10px; display: inline-block">
                                                <div class="rightFiltersCheckboxesMainDivs withoutHeadingFilter">
                                                    <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-12">
                                                        <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                        <label for="c22"><span></span>&nbsp;&nbsp;نمایش تورهایی که مستقیم به مقصد می‌روند </label>
                                                            <span class="numberOfSuggestion"></span>
                                                    </div>
                                                    <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-12">
                                                        <input ng-model="sort" type="radio" id="c23" value="review"/>
                                                        <label for="c23"><span></span>&nbsp;&nbsp; تورهایی که از مقصد می‌گذرند را هم ببینم </label>
                                                            <span class="numberOfSuggestion"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prw_rup prw_restaurants_restaurant_filters">
                                            <div id="jfy_filter_bar_establishmentTypeFilters"
                                                 class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
                                                <div class="filterGroupTitle rightFilterBarDivsHeading ">سایر شهرهایی که می‌بینید؟
                                                    <button class="showFilterChoices">
                                                        <span class="glyphicon glyphicon-triangle-bottom"></span>
                                                    </button>
                                                </div>
                                                <div class="rightFiltersCheckboxesHidden">
                                                    <div class="rightFiltersCheckboxesMainDivs">
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;امتیاز </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c23" value="review"/>
                                                            <label for="c23"><span></span>&nbsp;&nbsp; تعداد نقد </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c24" value="alphabet"/>
                                                            <label for="c24"><span></span>&nbsp;&nbsp; الفبا </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class= "moreChoices">
                                                    <button class= "moreChoicesBtn">بیشتر</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prw_rup prw_restaurants_restaurant_filters">
                                            <div id="jfy_filter_bar_establishmentTypeFilters"
                                                 class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
                                                <div class="filterGroupTitle rightFilterBarDivsHeading ">چگونه به مقصد می‌روید؟
                                                    <button class="showFilterChoices">
                                                        <span class="glyphicon glyphicon-triangle-bottom"></span>
                                                    </button>
                                                </div>
                                                <div class="rightFiltersCheckboxesHidden">
                                                    <div class="rightFiltersCheckboxesMainDivs">
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;امتیاز </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c23" value="review"/>
                                                            <label for="c23"><span></span>&nbsp;&nbsp; تعداد نقد </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c24" value="alphabet"/>
                                                            <label for="c24"><span></span>&nbsp;&nbsp; الفبا </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class= "moreChoices">
                                                    <button class= "moreChoicesBtn">بیشتر</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prw_rup prw_restaurants_restaurant_filters">
                                            <div id="jfy_filter_bar_establishmentTypeFilters"
                                                 class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
                                                <div class="filterGroupTitle rightFilterBarDivsHeading ">رفت و آمد محلی چگونه است؟
                                                    <button class="showFilterChoices">
                                                        <span class="glyphicon glyphicon-triangle-bottom"></span>
                                                    </button>
                                                </div>
                                                <div class="rightFiltersCheckboxesHidden">
                                                    <div class="rightFiltersCheckboxesMainDivs">
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;امتیاز </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c23" value="review"/>
                                                            <label for="c23"><span></span>&nbsp;&nbsp; تعداد نقد </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c24" value="alphabet"/>
                                                            <label for="c24"><span></span>&nbsp;&nbsp; الفبا </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class= "moreChoices">
                                                    <button class= "moreChoicesBtn">بیشتر</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prw_rup prw_restaurants_restaurant_filters">
                                            <div id="jfy_filter_bar_establishmentTypeFilters"
                                                 class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
                                                <div class="filterGroupTitle rightFilterBarDivsHeading ">چند روز وقت دارم؟
                                                    <button class="showFilterChoices">
                                                        <span class="glyphicon glyphicon-triangle-bottom"></span>
                                                    </button>
                                                </div>
                                                <div class="rightFiltersCheckboxesHidden">
                                                    <div class="rightFiltersCheckboxesMainDivs">
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;امتیاز </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c23" value="review"/>
                                                            <label for="c23"><span></span>&nbsp;&nbsp; تعداد نقد </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c24" value="alphabet"/>
                                                            <label for="c24"><span></span>&nbsp;&nbsp; الفبا </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class= "moreChoices">
                                                    <button class= "moreChoicesBtn">بیشتر</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prw_rup prw_restaurants_restaurant_filters">
                                            <div id="jfy_filter_bar_establishmentTypeFilters"
                                                 class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
                                                <div class="filterGroupTitle rightFilterBarDivsHeading ">چقدر می‌خواهید هزینه کنید؟
                                                    <button class="showFilterChoices">
                                                        <span class="glyphicon glyphicon-triangle-bottom"></span>
                                                    </button>
                                                </div>
                                                <div class="rightFiltersCheckboxesHidden">
                                                    <div class="rightFiltersCheckboxesMainDivs">
                                                        <div id="price-filter" class="panel-collapse collapse in"
                                                             style="height: auto;">
                                                            <div class="panel-content">
                                                                <!-- Slider -->
                                                                <div id="slider-price-range" class="pmd-range-slider"
                                                                     style="margin-top: 20px;"></div>
                                                                <!-- Values -->
                                                                <div class="row" style="margin: 15px -15px;">
                                                                    <div class="range-value col-sm-6">
                                                                        <span id="price-min" style="float: left;"></span>
                                                                    </div>
                                                                    <div class="range-value col-sm-6 text-right">
                                                                        <span id="price-max"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class= "moreChoices">
                                                    <button class= "moreChoicesBtn">بیشتر</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prw_rup prw_restaurants_restaurant_filters">
                                            <div id="jfy_filter_bar_establishmentTypeFilters"
                                                 class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
                                                <div class="filterGroupTitle rightFilterBarDivsHeading ">نوع تور را مشخص کنید؟
                                                    <button class="showFilterChoices">
                                                        <span class="glyphicon glyphicon-triangle-bottom"></span>
                                                    </button>
                                                </div>
                                                <div class="rightFiltersCheckboxesHidden">
                                                    <div class="rightFiltersCheckboxesMainDivs">
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;امتیاز </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c23" value="review"/>
                                                            <label for="c23"><span></span>&nbsp;&nbsp; تعداد نقد </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c24" value="alphabet"/>
                                                            <label for="c24"><span></span>&nbsp;&nbsp; الفبا </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class= "moreChoices">
                                                    <button class= "moreChoicesBtn">بیشتر</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prw_rup prw_restaurants_restaurant_filters">
                                            <div id="jfy_filter_bar_establishmentTypeFilters"
                                                 class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
                                                <div class="filterGroupTitle rightFilterBarDivsHeading ">نمایش تورهای مناسب
                                                    <button class="showFilterChoices">
                                                        <span class="glyphicon glyphicon-triangle-bottom"></span>
                                                    </button>
                                                </div>
                                                <div class="rightFiltersCheckboxesHidden">
                                                    <div class="rightFiltersCheckboxesMainDivs">
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;امتیاز </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c23" value="review"/>
                                                            <label for="c23"><span></span>&nbsp;&nbsp; تعداد نقد </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c24" value="alphabet"/>
                                                            <label for="c24"><span></span>&nbsp;&nbsp; الفبا </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class= "moreChoices">
                                                    <button class= "moreChoicesBtn">بیشتر</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prw_rup prw_restaurants_restaurant_filters">
                                            <div id="jfy_filter_bar_establishmentTypeFilters"
                                                 class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
                                                <div class="filterGroupTitle rightFilterBarDivsHeading ">چه وعده‌های غذایی برعهده‌ی تور است؟
                                                    <button class="showFilterChoices">
                                                        <span class="glyphicon glyphicon-triangle-bottom"></span>
                                                    </button>
                                                </div>
                                                <div class="rightFiltersCheckboxesHidden">
                                                    <div class="rightFiltersCheckboxesMainDivs">
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;امتیاز </label>
                                                            <span class="numberOfSuggestion"></span>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c23" value="review"/>
                                                            <label for="c23"><span></span>&nbsp;&nbsp; تعداد نقد </label>
                                                            <span class="numberOfSuggestion"></span>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c24" value="alphabet"/>
                                                            <label for="c24"><span></span>&nbsp;&nbsp; الفبا </label>
                                                            <span class="numberOfSuggestion"></span>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class= "moreChoices">
                                                    <button class= "moreChoicesBtn">بیشتر</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prw_rup prw_restaurants_restaurant_filters">
                                            <div id="jfy_filter_bar_establishmentTypeFilters"
                                                 class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible" style="display: inline-block">
                                                <div id="tourInsuranceDiv" class="rightFiltersCheckboxesMainDivs withoutHeadingFilter">
                                                    <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-12">
                                                        <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                        <label for="c22"><span></span>&nbsp;&nbsp;نمایش تورهای دارای بیمه </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prw_rup prw_restaurants_restaurant_filters">
                                            <div id="jfy_filter_bar_establishmentTypeFilters"
                                                 class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
                                                <div class="filterGroupTitle rightFilterBarDivsHeading ">تور به چه زبانی برگزار می‌شود؟
                                                    <button class="showFilterChoices">
                                                        <span class="glyphicon glyphicon-triangle-bottom"></span>
                                                    </button>
                                                </div>
                                                <div class="rightFiltersCheckboxesHidden">
                                                    <div class="rightFiltersCheckboxesMainDivs">
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;امتیاز</label>
                                                            <span class="numberOfSuggestion">20</span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c23" value="review"/>
                                                            <label for="c23"><span></span>&nbsp;&nbsp; تعداد نقد</label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c24" value="alphabet"/>
                                                            <label for="c24"><span></span>&nbsp;&nbsp; الفبا</label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class= "moreChoices">
                                                    <button class= "moreChoicesBtn">بیشتر</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prw_rup prw_restaurants_restaurant_filters">
                                            <div id="jfy_filter_bar_establishmentTypeFilters"
                                                 class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
                                                <div class="filterGroupTitle rightFilterBarDivsHeading ">نوع بلیط تور چگونه است؟
                                                    <button class="showFilterChoices">
                                                        <span class="glyphicon glyphicon-triangle-bottom"></span>
                                                    </button>
                                                </div>
                                                <div class="rightFiltersCheckboxesHidden">
                                                    <div class="rightFiltersCheckboxesMainDivs">
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp;امتیاز </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c23" value="review"/>
                                                            <label for="c23"><span></span>&nbsp;&nbsp; تعداد نقد </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                        <div class="rightFiltersCheckboxesDivs ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-6">
                                                            <input ng-model="sort" type="radio" id="c24" value="alphabet"/>
                                                            <label for="c24"><span></span>&nbsp;&nbsp; الفبا </label>
                                                            <span class="numberOfSuggestion"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class= "moreChoices">
                                                    <button class= "moreChoicesBtn">بیشتر</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="prw_rup prw_restaurants_restaurant_filters">
                                            <div id="jfy_filter_bar_establishmentTypeFilters"
                                                 class="lhrFilterBlock jfy_filter_bar_establishmentTypeFilters collapsible">
                                                <div class="filterGroupTitle rightFilterBarDivsHeading ">برگزار کننده‌ی تور را انتخاب کنید
                                                    <button class="showFilterChoices">
                                                        <span class="glyphicon glyphicon-triangle-bottom"></span>
                                                    </button>
                                                </div>
                                                <div class="rightFiltersCheckboxesHidden">
                                                    <div class="rightFiltersCheckboxesMainDivs">
                                                        <div class="rightFiltersCheckboxesDivs rightFiltersCheckboxesDivsFull ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem col-xs-12">
                                                            <input ng-model="sort" type="radio" id="c22" value="rate"/>
                                                            <label for="c22"><span></span>&nbsp;&nbsp; آژانس ستاره طلایی
                                                            </label>
                                                            <span class="tourDetailsCriticsBox ">0 نقد</span>
                                                            <span>1 امتیاز</span>
                                                            <div class="prw_rup prw_common_bubble_rating overallBubbleRating inline-block">
                                                                <span class="ui_bubble_rating bubble_50" style="font-size:12px;"
                                                                      property="ratingValue" content="5" alt='5 of 5 bubbles'></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class= "moreChoices">
                                                    <button class= "moreChoicesBtn">بیشتر</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>
                                $(document).ready (function (){
                                    $('.showFilterChoices').click(function() {
                                        $(this).parent().next().toggle();
                                        $(this).closest('.moreChoices').toggle();
                                    });
                                    $('.toggleTourDetailsLessInfo').click(function(){
                                        $(this).parent().hide();
                                        $('.mainDivLittleBlock').show();
                                    });
                                    $('.toggleTourDetailsMoreInfo').click(function(){
                                        $(this).parent().hide();
                                        $('.tourDetailsFullWidthBox').show();
                                    });
                                    $('.moreChoicesBtn').click(function() {
                                        $(this).parent().prev().children().toggleClass("autoHeight");
                                        $(this).text($(this).text() == 'بیشتر' ? 'کمتر' : 'بیشتر');
                                    })
                                })
                            </script>
                            <div class="ad iab_medRec">
                                <div id="gpt-ad-300x250-300x600-bottom" class="adInner gptAd delayAd"></div>
                            </div>
                            <div class="ad iab_supSky">
                                <div id="gpt-ad-160x600" class="adInner gptAd delayAd"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="clearFix"></div>

        </div>
    </div>
    <form id="form_hotel" method="post" action="{{route('makeSessionHotel')}}">
        {{csrf_field()}}
        <input type="hidden" name="adult" id="form_adult">
        <input type="hidden" name="room" id="form_room">
        <input type="hidden" name="children" id="form_children">
        <input type="hidden" name="goDate" id="form_goDate">
        <input type="hidden" name="backDate" id="form_backDate">
        <input type="hidden" name="ageOfChild" id="form_ageOfChild">
        <input type="hidden" name="city" value="">
        <input type="hidden" name="mode" value="">
    </form>

    @include('layouts.footer.layoutFooter')
</div>

@if(!Auth::check())
    @include('layouts.loginPopUp')
@endif


<script>

    var app = angular.module("mainApp", ['infinite-scroll'], function ($interpolateProvider) {
        $interpolateProvider.startSymbol('[[');
        $interpolateProvider.endSymbol(']]');
    });

    var filters = [-1];
    var page = 1;
    {{--var placeMode = '{{$placeMode}}';--}}
    var floor = 1;
    var sort = "rate";
    var colors = [];
    var data;
    var init = true;
    var lock = false;

    app.controller('FilterController', function ($scope, $rootScope) {

        $scope.showPic = false;
        {{--$scope.placeMode = '{{$placeMode}}';--}}

//        if ($scope.placeMode == "amaken")
//            $scope.showPic = true;

        $scope.sort = sort;

        $scope.$watch('sort', function (value) {

            if (value == null || sort == value || lock) {
                $scope.sort = sort;
                return;
            }

            sort = value;
            page = 1;
            floor = 1;
            init = true;
            $rootScope.$broadcast('myPagingFunctionAPI');
        });

        $scope.isDisable = function () {
            return lock;
        };

        $scope.doFilter = function (value) {

            var i;
            var duplicate = false;

            for (i = 0; i < filters.length; i++) {
                if (filters[i] == value) {
                    filters.splice(i);
                    duplicate = true;
                    break;
                }
            }

            if (!duplicate)
                filters[i] = value;

            page = 1;
            floor = 1;
            init = true;

            $rootScope.$broadcast('myPagingFunctionAPI');
        };

        $scope.doFilterColor = function (value) {

            var i;

            for (i = 0; i < colors.length; i++) {
                if (colors[i] == value) {
                    colors.splice(i);
                    break;
                }
            }

            if (i == colors.length)
                colors[i] = value;

            page = 1;
            floor = 1;
            init = true;

            $rootScope.$broadcast('myPagingFunctionAPI');
        };

    });

    app.controller('PlaceController', function ($scope, $http) {

        $scope.show = false;
        $scope.packets = [[]];
        $scope.oldScrollVal = 600;

        $scope.myPagingFunction = function () {

            if (page == 1) {
                $scope.packets = [[]];
            }

            var scroll = $(window).scrollTop();

            if (scroll - $scope.oldScrollVal < 100 && !init)
                return;

            if (init)
                init = false;
            else
                $scope.oldScrollVal += scroll;

            $(".loader").removeClass('hidden');

            data = $.param({
                pageNum: page,
                kind_id: filters,
                sort: sort,
                color: colors
            });

            {{--var requestURL = (placeMode == "hotel") ? '{{route('getHotelListElems', ['city' => $city, 'mode' => $mode])}}' :--}}
                            {{--(placeMode == "amaken") ? '{{route('getAmakenListElems', ['city' => $city, 'mode' => $mode])}}' :--}}
                                    {{--'{{route('getRestaurantListElems', ['city' => $city, 'mode' => $mode])}}'--}}
                    {{--;--}}

            const config = {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            };

            $http.post(requestURL, data, config).then(function (response) {

                if (response.data != null && response.data.places != null && response.data.places.length > 0)
                    $scope.show = true;

                $scope.packets[page - 1] = response.data;
                $scope.packets[page - 1].places = response.data.places;

//                for (j = 0; j < $scope.packets[page - 1].places.length; j++) {
//                    switch ($scope.packets[page - 1].places[j].avgRate) {
//                        case 5:
//                            $scope.packets[page - 1].places[j].ngClass = 'ui_bubble_rating bubble_50';
//                            break;
//                        case 4:
//                            $scope.packets[page - 1].places[j].ngClass = 'ui_bubble_rating bubble_40';
//                            break;
//                        case 3:
//                            $scope.packets[page - 1].places[j].ngClass = 'ui_bubble_rating bubble_30';
//                            break;
//                        case 2:
//                            $scope.packets[page - 1].places[j].ngClass = 'ui_bubble_rating bubble_20';
//                            break;
//                        default:
//                            $scope.packets[page - 1].places[j].ngClass = 'ui_bubble_rating bubble_10';
//                    }

                    {{--if (placeMode == "hotel") {--}}
                        {{--$scope.packets[page - 1].places[j].redirect = '{{route('home') . '/hotel-details/'}}' + $scope.packets[page - 1].places[j].id + '/' + $scope.packets[page - 1].places[j].name;--}}
                    {{--}--}}
                    {{--else if (placeMode == "amaken") {--}}
                        {{--$scope.packets[page - 1].places[j].redirect = '{{route('home') . '/amaken-details/'}}' + $scope.packets[page - 1].places[j].id + '/' + $scope.packets[page - 1].places[j].name;--}}
                    {{--}--}}
                    {{--else if (placeMode == "restaurant") {--}}
                        {{--$scope.packets[page - 1].places[j].redirect = '{{route('home') . '/restaurant-details/'}}' + $scope.packets[page - 1].places[j].id + '/' + $scope.packets[page - 1].places[j].name;--}}
                    {{--}--}}
//                }

                if (response.data.places.length != 4) {
                    $scope.$broadcast('finalizeReceive');
                    return;
                }

                data = $.param({
                    pageNum: ++page,
                    kind_id: filters,
                    sort: sort,
                    color: colors
                });

                $http.post(requestURL, data, config).then(function (response) {

                    if (response.data != null && response.data.places != null && response.data.places.length > 0)
                        $scope.show = true;

                    $scope.packets[page - 1] = response.data;
                    $scope.packets[page - 1].places = response.data.places;

                    {{--for (j = 0; j < $scope.packets[page - 1].places.length; j++) {--}}
                        {{--switch ($scope.packets[page - 1].places[j].avgRate) {--}}
                            {{--case 5:--}}
                                {{--$scope.packets[page - 1].places[j].ngClass = 'ui_bubble_rating bubble_50';--}}
                                {{--break;--}}
                            {{--case 4:--}}
                                {{--$scope.packets[page - 1].places[j].ngClass = 'ui_bubble_rating bubble_40';--}}
                                {{--break;--}}
                            {{--case 3:--}}
                                {{--$scope.packets[page - 1].places[j].ngClass = 'ui_bubble_rating bubble_30';--}}
                                {{--break;--}}
                            {{--case 2:--}}
                                {{--$scope.packets[page - 1].places[j].ngClass = 'ui_bubble_rating bubble_20';--}}
                                {{--break;--}}
                            {{--default:--}}
                                {{--$scope.packets[page - 1].places[j].ngClass = 'ui_bubble_rating bubble_10';--}}
                        {{--}--}}

                        {{--if (placeMode == "hotel") {--}}
                            {{--$scope.packets[page - 1].places[j].redirect = '{{route('home') . '/hotel-details/'}}' + $scope.packets[page - 1].places[j].id + '/' + $scope.packets[page - 1].places[j].name;--}}
                        {{--}--}}
                        {{--else if (placeMode == "amaken") {--}}
                            {{--$scope.packets[page - 1].places[j].redirect = '{{route('home') . '/amaken-details/'}}' + $scope.packets[page - 1].places[j].id + '/' + $scope.packets[page - 1].places[j].name;--}}
                        {{--}--}}
                        {{--else if (placeMode == "restaurant") {--}}
                            {{--$scope.packets[page - 1].places[j].redirect = '{{route('home') . '/restaurant-details/'}}' + $scope.packets[page - 1].places[j].id + '/' + $scope.packets[page - 1].places[j].name;--}}
                        {{--}--}}
                    {{--}--}}
                    if (response.data.places.length != 4) {
                        $scope.$broadcast('finalizeReceive');
                        return;
                    }

                    data = $.param({
                        pageNum: ++page,
                        kind_id: filters,
                        sort: sort,
                        color: colors
                    });

                    $http.post(requestURL, data, config).then(function (response) {

                        if (response.data != null && response.data.places != null && response.data.places.length > 0)
                            $scope.show = true;

                        $scope.packets[page - 1] = response.data;
                        $scope.packets[page - 1].places = response.data.places;
                        {{--for (j = 0; j < $scope.packets[page - 1].places.length; j++) {--}}
                            {{--switch ($scope.packets[page - 1].places[j].avgRate) {--}}
                                {{--case 5:--}}
                                    {{--$scope.packets[page - 1].places[j].ngClass = 'ui_bubble_rating bubble_50';--}}
                                    {{--break;--}}
                                {{--case 4:--}}
                                    {{--$scope.packets[page - 1].places[j].ngClass = 'ui_bubble_rating bubble_40';--}}
                                    {{--break;--}}
                                {{--case 3:--}}
                                    {{--$scope.packets[page - 1].places[j].ngClass = 'ui_bubble_rating bubble_30';--}}
                                    {{--break;--}}
                                {{--case 2:--}}
                                    {{--$scope.packets[page - 1].places[j].ngClass = 'ui_bubble_rating bubble_20';--}}
                                    {{--break;--}}
                                {{--default:--}}
                                    {{--$scope.packets[page - 1].places[j].ngClass = 'ui_bubble_rating bubble_10';--}}
                            {{--}--}}

                            {{--if (placeMode == "hotel") {--}}
                                {{--$scope.packets[page - 1].places[j].redirect = '{{route('home') . '/hotel-details/'}}' + $scope.packets[page - 1].places[j].id + '/' + $scope.packets[page - 1].places[j].name;--}}
                            {{--}--}}
                            {{--else if (placeMode == "amaken") {--}}
                                {{--$scope.packets[page - 1].places[j].redirect = '{{route('home') . '/amaken-details/'}}' + $scope.packets[page - 1].places[j].id + '/' + $scope.packets[page - 1].places[j].name;--}}
                            {{--}--}}
                            {{--else if (placeMode == "restaurant") {--}}
                                {{--$scope.packets[page - 1].places[j].redirect = '{{route('home') . '/restaurant-details/'}}' + $scope.packets[page - 1].places[j].id + '/' + $scope.packets[page - 1].places[j].name;--}}
                            {{--}--}}
                        {{--}--}}

                        $scope.$broadcast('finalizeReceive');

                    }).catch(function (err) {
                        console.log(err);
                    });

                }).catch(function (err) {
                    console.log(err);
                });
            }).catch(function (err) {
                console.log(err);
            });
        };

        $scope.$on('finalizeReceive', function (event) {

            page++;
            $(".loader").addClass('hidden');
            floor = page;

        });

        $scope.$on('myPagingFunctionAPI', function (event) {
            $scope.myPagingFunction();
        });
    });
</script>

<script async>
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

<script>

    {{--$('.login-button').click(function () {--}}

        {{--var url;--}}
        {{--@if($placeMode == "hotel")--}}
                {{--url = '{{route('hotelList', ['city' => $city, 'mode' => $mode])}}';--}}
        {{--@elseif($placeMode == "amaken")--}}
                {{--url = '{{route('amakenList', ['city' => $city, 'mode' => $mode])}}';--}}
        {{--@else--}}
                {{--url = '{{route('restaurantList', ['city' => $city, 'mode' => $mode])}}';--}}
        {{--@endif--}}

        {{--$(".dark").show();--}}
        {{--showLoginPrompt(url);--}}
    {{--});--}}

    {{--$(document).ready(function () {--}}

        {{--@foreach($sections as $section)--}}
            {{--fillMyDivWithAdv('{{$section->sectionId}}', '{{$state->id}}');--}}
        {{--@endforeach--}}

{{--$("#global-nav-hotels").attr('href', '{{route('hotelList', ['city' => $city, 'mode' => $mode])}}');--}}
        {{--$("#global-nav-restaurants").attr('href', '{{route('restaurantList', ['city' => $city, 'mode' => $mode])}}');--}}
        {{--$("#global-nav-amaken").attr('href', '{{route('amakenList', ['city' => $city, 'mode' => $mode])}}');--}}
    {{--});--}}

    function hideElement(val) {
        $("#" + val).addClass('hidden');
        $(".dark").hide();
    }

    function showElement(val) {
        $(".dark").show();
        $("#" + val).removeClass('hidden');
    }

    function showMoreItems() {
        $(".extraItem").removeClass('hidden').addClass('selected');
        $(".moreItems").addClass('hidden');
    }

    function showLessItems() {
        $(".extraItem").addClass('hidden').removeClass('selected');
        $(".moreItems").removeClass('hidden');
    }

    function showMoreItems2() {
        $(".extraItem2").removeClass('hidden').addClass('selected');
        $(".moreItems2").addClass('hidden');
    }

    function showLessItems2() {
        $(".extraItem2").addClass('hidden').removeClass('selected');
        $(".moreItems2").removeClass('hidden');
    }
</script>

<script>
    var room = parseInt('0');
    var adult = parseInt('0');
    var children = parseInt('0');
    var passengerNoSelect = false;

    $(".room").html(room);
    $(".adult").html(adult);
    $(".children").html(children);

    for (var i = 0; i < children; i++) {
        $(".childBox").append("" +
                "<div class='childAge' data-id='" + i + "'>" +
                "<div>سن بچه</div>" +
                "<div><select class='selectAgeChild' name='ageOfChild' id=''>" +
                "<option value='0'>1<</option>" +
                "<option value='1'>1</option>" +
                "<option value='2'>2</option>" +
                "<option value='3'>3</option>" +
                "<option value='4'>4</option>" +
                "<option value='5'>5</option>" +
                "</select></div>" +
                "</div>");
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

    function addClassHidden(element) {
        $("#" + element).addClass('hidden');
        if (element == 'passengerNoSelectPane'){
            $("#passengerArrowDown").removeClass('hidden');
            $("#passengerArrowUp").addClass('hidden');
        }
    }

    function changeRoomPassengersNum(inc, mode) {
        switch (mode) {
            case 3:
            default:
                if (room + inc >= 0)
                    room += inc;
                $("#roomNumInSelect").empty().append(room);
                break;
            case 2:
                if (adult + inc >= 0)
                    adult += inc;
                $("#adultPassengerNumInSelect").empty().append(adult);
                break;
            case 1:
                if (children + inc >= 0)
                    children += inc;
                if (inc >= 0) {
                    $(".childBox").append("<div class='childAge' data-id='" + (children - 1) + "'>" +
                            "<div>سن بچه</div>" +
                            "<div><select class='selectAgeChild' name='ageOfChild' id=''>" +
                            "<option value='0'>1<</option>" +
                            "<option value='1'>1</option>" +
                            "<option value='2'>2</option>" +
                            "<option value='3'>3</option>" +
                            "<option value='4'>4</option>" +
                            "<option value='5'>5</option>" +
                            "</select></div>" +
                            "</div>");
                } else {
                    $(".childAge[data-id='" + (children) + "']").remove();
                }
                $("#childrenPassengerNumInSelect").empty().append(children);


                break;
        }
        while((4*room) < adult){
            room++;
            $("#roomNumInSelect").empty().append(room);
        }
        document.getElementById('adult_number').innerText = adult;
        document.getElementById('room_number').innerText = room;
        // document.getElementById('roomDetail').innerHTML = '<span style="float: right;">' + room + '</span>&nbsp;\n' +
        //     '                                                <span>اتاق</span>&nbsp;-&nbsp;\n' +
        //     '                                                <span id="childPassengerNo">' + adult + '</span>\n' +
        //     '                                                <span>بزرگسال</span>&nbsp;-&nbsp;\n';
        // '                                                <span id="infantPassengerNo">' + children + '</span>\n' +
        // '                                                <span>بچه</span>&nbsp;';
    }

    function inputSearch() {
        var ageOfChild = [];
        var goDate;
        var backDate;
        var childSelect = document.getElementsByName('ageOfChild');

        for(var i = 0; i < children; i++)
            ageOfChild[i] = childSelect[i].value;

        goDate = document.getElementById('goDate').value;
        backDate = document.getElementById('backDate').value;

        document.getElementById('form_room').value = room;
        document.getElementById('form_adult').value = adult;
        document.getElementById('form_children').value = children;
        document.getElementById('form_goDate').value = goDate;
        document.getElementById('form_backDate').value = backDate;
        document.getElementById('form_ageOfChild').value = ageOfChild;

        document.getElementById('form_hotel').submit();
    }

</script>

<script>
    // multiple handled with value
    var pmdSliderPriceRange = document.getElementById('slider-price-range');


    noUiSlider.create(pmdSliderPriceRange, {
        start: [1500, 3000], // Handle start position
        connect: true, // Display a colored bar between the handles
        tooltips: [wNumb({decimals: 0}), wNumb({decimals: 0})],
        step: 50,
        format: wNumb({
            decimals: 0,
            thousand: '',
            postfix: '',
        }),
        range: {
            'min': 500,
            'max': 10000
        }
    });

    var priceMax = document.getElementById('price-max'),
        priceMin = document.getElementById('price-min');
    var firstTime = 0;

    pmdSliderPriceRange.noUiSlider.on('update', function (values, handle) {
        if (handle) {
            if(values[handle] >= 1000){
                t = values[handle] / 1000;
                priceMax.innerHTML = t.toFixed(3) + ".000";
            }else {
                priceMax.innerHTML = values[handle] + ".000";
            }
            maxMoney = values[handle]*1000;
        } else {
            if(values[handle] >= 1000){
                t = values[handle] / 1000;
                priceMin.innerHTML = t.toFixed(3) + ".000";
            }else {
                priceMin.innerHTML = values[handle] + ".000";
            }
            minMoney = values[handle]*1000;
        }
        checkMoneyFilter = true;

        doMoneyFilter();
    });

    cancelMoneyFilter();

</script>

<script src="{{URL::asset('js/adv.js')}}"></script>
<div class="ui_backdrop dark" style="display: none; z-index: 10000000"></div>
</body>
</html>