@extends('layouts.bodyPlace')

@section('header')
    @parent

    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/photo_albums_stacked.css?v=1')}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/media_albums_extended.css?v=1')}}'/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/popUp.css?v=1')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/showAllPlaces.css?v=1')}}">

    <script>
        var getPlaceTrips = '{{route('placeTrips')}}';
        var filterComments = '{{route('filterComments')}}';
        var getCommentsCount = '{{route('getCommentsCount')}}';
        var hasLogin = '{{$hasLogin}}';
        var assignPlaceToTripDir = '{{route('assignPlaceToTrip')}}';
        var currentURL = '{{Request::url()}}';
        var bookMarkDir = '{{route('bookMark')}}';
        var photos = {!! json_encode($photos) !!};
        var sitePhotos = {!! json_encode($sitePhotos) !!};
        var getPhotosDir = '{{route('getPhotos')}}';
        var showUserBriefDetail = '{{route('showUserBriefDetail')}}';
        var placeIds = [];
        var kindPlaceIds = [];
        var placeModes = [];
        var getQuestions = '{{route('getQuestions')}}';
        var showAllAnsDir = '{{route('showAllAns')}}';
        var getPlaceStyles = '{{route('getPlaceStyles')}}';
        var getSrcCities = '{{route('getSrcCities')}}';
        var getTags = '{{route('getTags')}}';
        var getSimilarsHotel = '{{route('getSimilarsHotel')}}';
        var getSimilarsAmaken = '{{route('getSimilarsAmaken')}}';
        var getSimilarsRestaurant = '{{route('getSimilarsRestaurant')}}';
        var getSimilarsMajara = '{{route('getSimilarsMajara')}}';
        var getLogPhotos = '{{route('getLogPhotos')}}';
        var getNearby = '{{route('getNearby')}}';

        @for($i = 0; $i < count($places); $i++)
            placeIds['{{$i}}'] = '{{$places[$i]->id}}';
            kindPlaceIds['{{$i}}'] = '{{$kindPlaceIds[$i]}}';
            placeModes['{{$i}}'] = '{{$placeModes[$i]}}';
        @endfor
    </script>

    <style>

        .DivCol::-webkit-scrollbar-track
        {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
            border-radius: 10px;
            background-color: #F5F5F5;
        }

        .DivCol::-webkit-scrollbar
        {
            width: 12px;
            background-color: #F5F5F5;
        }

        .DivCol::-webkit-scrollbar-thumb
        {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
            background-color: #555;
        }

        .is-create-trip {

            color: #00AF87 !important;
            background-blend-mode: overlay;
            width: 150px;
            height: 150px;
            cursor: pointer;
            margin: 0 0 10px 0;
            border-radius: 2px;
            display: -webkit-box;
            display: flex;
            line-height: initial;
            transition: background-color .2s ease,corder-color .2s ease;
            border: 1px solid #f5f5f5;
            justify-content: space-around;
            background-color: #e5e5e5;
        }

        .ui_icon:before {
            display: inline-block;
            font-style: normal;
            font-weight: normal;
            font-variant: normal;
            font-size: inherit;
            line-height: 1;
            font-family: 'Shazde_Regular' !important;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            speak: none;
        }

        .is-create-trip .tile-content {
            align-self: center;
            margin: 10px;
            padding: 0;
            box-sizing: inherit;
            cursor: pointer;
        }

        footer {
            margin-top: 100vh;
        }

        .castle:before {
            color: #963019;
        }

        #PAGE {
            overflow: hidden;
        }
        .menu {
            background:#fff;
            color:#16174f;
            border: 2px solid #ccc;
            border-radius: 6px;
            height:40px;
            line-height:40px;
            letter-spacing:1px;
            width:100%;
        }
        .btn{
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 4px;

        }

        .btn-default {
            color: #333;
            background-color: #fff;
            border-color: #ccc;
        }

        .loader {
            background-image: url("{{URL::asset("images/loading.gif?v=".$fileVersions)}}");
            width: 100px;
            height: 100px;
        }
    </style>

    <style>
        td {
            max-width: 120px !important;
            width: auto !important;
        }
        .detailListItem {
            max-width: 120px !important;
            width: auto !important;
            padding: 0 !important;
        }
        .titleInTable {
            color: var(--koochita-light-green);
        }
    </style>

    <style>

        input[type="checkbox"], input[type="radio"] {
            display:none;
        }

        input[type="checkbox"] + label, input[type="radio"] + label{
            color:#666666;
        }

        input[type="checkbox"] + label span {
            display:inline-block;
            width:19px;
            height:19px;
            margin:-2px 10px 0 0;
            vertical-align:middle;
            background:url('{{URL::asset('images/check_radio_sheet.png')}}') left top no-repeat;
            cursor:pointer;
        }

        input[type="checkbox"]:checked + label span {
            background:url('{{URL::asset('images/check_radio_sheet.png')}}') -19px top no-repeat;
        }

        .red-heart-fill:before {
            color: #963019 !important;
        }

        .red-heart:hover:before {
            color: #963019 !important;
        }

        .labelForCheckBox:before{
            background-color: transparent !important;
            border: none !important;
            content: "" !important;
        }

        .atf_meta_and_photos_wrapper:before {
            height: 180px !important;
        }
        td {
            width: 100% !important;
            max-width: 120px !important;
            width: auto !important;
        }
        .detailListItem {
            max-width: 120px !important;
            width: auto !important;
            padding: 0 !important;
        }
    </style>

    <div id="afterCSS"></div>

@stop

<?php

    $counter = 0;
    for($j = 0; $j < 4; $j++) {
        if($validate[$j])
            $counter++;
    }
    $position = [];

    switch ($counter) {
        case 0:
        default:
            return Redirect::to('main');
        case 1:
            $position[0] = [5, 10, 5, 90];
            break;
        case 2:
            $position[0] = [5, 10, 45, 90];
            $position[1] = [50, 10, 45, 90];
            break;
        case 3:
            $position[0] = [5, 10, 45, 45];
            $position[1] = [50, 10, 45, 45];
            $position[2] = [5, 55, 45, 45];
            break;
        case 4:
            $position[0] = [5, 10, 45, 45];
            $position[1] = [50, 10, 45, 45];
            $position[2] = [5, 55, 45, 45];
            $position[3] = [50, 55, 45, 45];
            break;
    }
?>

@section('main')

    <div id="borderElements" style="position: absolute; left: 0; top: 10%; height: 100vh; width: 100%"></div>

    <?php $k = 0; ?>
    @for($j = 0; $j < 4; $j++)

        @if($validate[$j])

            <?php
                $total = $rates[$k][0][0] + $rates[$k][0][1] + $rates[$k][0][2] + $rates[$k][0][3] + $rates[$k][0][4];
                if($total == 0)
                    $total = 1;
            ?>

            <div data-val="{{$places[$k]->name}}" {{($k == 0) ? 'class="selectedPane DivCol"' : 'class="DivCol"'}}  onclick="changeSelectedPane('{{($k + 1)}}')" id="pane{{($k + 1)}}" style="background-color: #e5e5e5; position: absolute; padding: 5px; width: {{$position[$k][2]}}%; top: {{$position[$k][1]}}%; left: {{$position[$k][0]}}%; height: {{$position[$k][3]}}%; overflow: auto">

                <DIV class="ppr_rup ppr_priv_hr_atf_north_star_nostalgic">

                    <div class="atf_header_wrapper">
                        <div class="atf_header ui_container is-mobile full_width">
                            <DIV ID="taplc_location_detail_header_hotels_0" class="ppr_rup ppr_priv_location_detail_header">
                                <h1 id="HEADING" class="heading_title " property="name">{{$places[$k]->name}}</h1>
                                <span class="ui_button_overlay">
                                    @if($hasLogin)
                                        @if($kindPlaceIds[$k] != 8)
                                            @if($saves[$k])
                                                <span onclick="saveToTripWithIdx('{{$places[$k]->id}}', '{{$kindPlaceIds[$k]}}')" class="ui_button small saves secondary ui_icon red-heart-fill">ذخیره</span>
                                            @else
                                                <span onclick="saveToTripWithIdx('{{$places[$k]->id}}', '{{$kindPlaceIds[$k]}}')" class="ui_button small saves secondary ui_icon red-heart">ذخیره</span>
                                            @endif
                                        @endif

                                        @if($bookMarks[$k])
                                            <span onclick="bookMark('{{$places[$k]->id}}', '{{$kindPlaceIds[$k]}}')" class="ui_button small casino save-location-7306673 ui_icon castle">نشانه گذاری</span>
                                        @else
                                            <span onclick="bookMark('{{$places[$k]->id}}', '{{$kindPlaceIds[$k]}}')" class="ui_button small casino save-location-7306673 ui_icon red-heart">نشانه گذاری</span>
                                        @endif
                                    @endif


                                    @if($placeModes[$k] == "hotel")
                                        <span onclick="document.location.href = '{{route('show.place.details', ['kindPlaceName' => 'hotels', 'slug' => $places[$k]->slug])}}'" class="ui_button small secondary ui_icon">مشاهده به صورت تکی</span>
                                    @elseif($placeModes[$k] == "restaurant")
                                        <span onclick="document.location.href = '{{route('show.place.details', ['kindPlaceName' => 'restaurant', 'slug' => $places[$k]->slug])}}'" class="ui_button small secondary ui_icon">مشاهده به صورت تکی</span>
                                    @elseif($placeModes[$k] == "amaken")
                                        <span onclick="document.location.href = '{{route('show.place.details', ['kindPlaceName' => 'amaken', 'slug' => $places[$k]->slug])}}'" class="ui_button small secondary ui_icon">مشاهده به صورت تکی</span>
                                    @elseif($placeModes[$k] == "majara")
                                        <span onclick="document.location.href = '{{route('show.place.details', ['kindPlaceName' => 'majara', 'slug' => $places[$k]->slug])}}'" class="ui_button small secondary ui_icon">مشاهده به صورت تکی</span>
                                    @endif
                                    <span class="btnoverlay loading"><span class="bubbles small"><span></span><span></span><span></span></span></span>
                                 </span>

                                <div class="rating_and_popularity">
                                    <span class="header_rating">
                                       <div class="rs rating" rel="v:rating">
                                           <DIV class="prw_rup prw_common_bubble_rating overallBubbleRating">
                                                @if($avgRates[$k][1] == 5)
                                                   <span class="ui_bubble_rating bubble_50" style="font-size:16px;" property="ratingValue" content="5" alt='5 of 5 bubbles'></span>
                                               @elseif($avgRates[$k][1] == 4)
                                                   <span class="ui_bubble_rating bubble_40" style="font-size:16px;" property="ratingValue" content="4" alt='4 of 5 bubbles'></span>
                                               @elseif($avgRates[$k][1] == 3)
                                                   <span class="ui_bubble_rating bubble_30" style="font-size:16px;" property="ratingValue" content="3" alt='3 of 5 bubbles'></span>
                                               @elseif($avgRates[$k][1] == 2)
                                                   <span class="ui_bubble_rating bubble_20" style="font-size:16px;" property="ratingValue" content="2" alt='2 of 5 bubbles'></span>
                                               @elseif($avgRates[$k][1] == 1)
                                                   <span class="ui_bubble_rating bubble_10" style="font-size:16px;" property="ratingValue" content="1" alt='1 of 5 bubbles'></span>
                                               @endif
                                            </DIV>
                                           <a class="more taLnk" href="#REVIEWS">
                                               <span property="v:count" id="commentCount_{{$k}}"></span> نقد
                                           </a>
                                       </div>
                                    </span>
                                    <span class="header_popularity popIndexValidation">
                                    <b class="rank"></b>  <a> {{$total}} امتیاز</a> </span>
                                </div>
                            </DIV>
                        </div>
                    </div>

                    <div class="atf_meta_and_photos_wrapper" style="margin-top: -10px !important;">
                            <div class="atf_meta_and_photos ui_container is-mobile easyClear">
                                <DIV class="prw_rup prw_common_location_photos photos photoSliderDiv" id="photoSliderDiv_{{$k}}" style="width: 50% !important; height: 150px !important; margin-left: 0 !important; float: right">
                                    <div class="inner">
                                        <div class="primaryWrap" style="width:100%">
                                            <DIV class="prw_rup prw_common_mercury_photo_carousel">
                                                <div id="carousel_images_header_{{$k}}" class="carousel bignav">
                                                    <div onclick="photoRoundRobin(-1, '{{$k}}')" id="left-nav-header_{{$k}}" class="left-nav left-nav-header"></div>
                                                    <div onclick="photoRoundRobin(1, '{{$k}}')" id="right-nav-header_{{$k}}" class="right-nav right-nav-header"></div>
                                                </div>
                                            </DIV>
                                        </div>
                                    </div>
                                </DIV>
                                @if($kindPlaceIds[$k] != 8)

                                    <?php $place = $places[$k]; ?>

                                    @if($placeMode == "hotel")
                                        @include('hotel-details.tables.hotel-details-table')
                                    @elseif($placeMode == "amaken")
                                        @include('amaken-details-table')
                                    @elseif($placeMode == "amaken")
                                        @include('restaurant-details-table')
                                    @endif
                                @endif
                            </div>
                        </div>
                </DIV>

                @if($kindPlaceIds[$k] == 8)
                    <div class=" full_meta_photos_v3 full_meta_photos_v4 big_pic_mainwrap_tweaks horizontal_xsell ui_container is-mobile stickyMenuDiv hidden" id="stickyMenu_{{$k}}">
                        <div class="Hotel_Review prodp13n_jfy_overflow_visible">
                            <div class="col easyClear bodLHN poolB adjust_padding new_meta_chevron new_meta_chevron_v2">
                                <div class="hr_btf_wrap">

                                    <DIV id="introduction_{{$k}}" class="ppr_rup ppr_priv_location_detail_overview">
                                        <div class="block_wrap" data-tab="TABS_OVERVIEW">
                                            <div class="block_header" style="border: none !important;">
                                                <div class="block_title" style="margin-top: 50px;padding-top: 10px;">معرفی کلی </div>
                                            </div>
                                            <div style="padding: 10px;margin-top: -50px;">
                                                <div class="overviewContent" id="introductionText_{{$k}}" style="direction: rtl; line-height: 20px; font-size: 14px; max-height: 50px; overflow: hidden; padding: 10px">
                                                    {{$places[$k]->description}}
                                                </div>
                                                <div id="showMore_{{$k}}" onclick="showMore2('{{$k}}')" style="cursor: pointer;color:#16174f;" class="hidden">بیشتر</div>
                                            </div>
                                            <div class="overviewContent">
                                                <div class="ui_columns is-multiline is-mobile reviewsAndDetails" style="direction: ltr;">

                                                    <div class="ui_column is-8 details">
                                                        <div class="overviewContent" id="dastoor_{{$k}}" style="direction: rtl; line-height: 20px; font-size: 14px; max-height: 190px; overflow: hidden; padding: 10px">
                                                            {{$places[$k]->dastoor}}
                                                        </div>
                                                        <div id="showMoreDastoor_{{$k}}" onclick="showMore3('{{$k}}')" style="cursor: pointer;color:#16174f;" class="hidden">بیشتر</div>
                                                    </div>
                                                    <div class="ui_column  is-4 reviews" style="direction: ltr;border-width: 0 0px 0 1px;">
                                                        <div class="rating">
                                                            <span class="overallRating">{{$avgRates[$k][1]}} </span>
                                                            <DIV class="prw_rup prw_common_bubble_rating overallBubbleRating">
                                                                @if($avgRates[$k][1] == 5)
                                                                    <span class="ui_bubble_rating bubble_50" style="font-size:28px;" property="ratingValue" content="5" alt='5 of 5 bubbles'></span>
                                                                @elseif($avgRates[$k][1] == 4)
                                                                    <span class="ui_bubble_rating bubble_40" style="font-size:28px;" property="ratingValue" content="4" alt='4 of 5 bubbles'></span>
                                                                @elseif($avgRates[$k][1] == 3)
                                                                    <span class="ui_bubble_rating bubble_30" style="font-size:28px;" property="ratingValue" content="3" alt='3 of 5 bubbles'></span>
                                                                @elseif($avgRates[$k][1] == 2)
                                                                    <span class="ui_bubble_rating bubble_20" style="font-size:28px;" property="ratingValue" content="2" alt='2 of 5 bubbles'></span>
                                                                @elseif($avgRates[$k][1] == 1)
                                                                    <span class="ui_bubble_rating bubble_10" style="font-size:28px;" property="ratingValue" content="1" alt='1 of 5 bubbles'></span>
                                                                @endif
                                                            </DIV>
                                                            <a class="seeAllReviews autoResize" href="#REVIEWS"></a>
                                                        </div>
                                                        <DIV class="prw_rup prw_common_ratings_histogram_overview overviewHistogram">
                                                            <ul class="ratings_chart">
                                                                <li class="chart_row highlighted clickable">
                                                                    <span class="row_count row_cell">{{ceil($rates[$k][0][4] * 100 / $total)}} %</span>
                                                <span class="row_bar row_cell">
                                                    <span class="bar">
                                                        <span class="fill" style="width: {{ceil($rates[$k][0][4] * 100 / $total)}}%;"></span>
                                                    </span>
                                                </span>
                                                                    <span class="row_label row_cell">عالی</span>
                                                                </li>
                                                                <li class="chart_row clickable">
                                                                    <span class="row_count row_cell">{{ceil($rates[$k][0][3] * 100 / $total)}} %</span>
                                                <span class="row_bar row_cell">
                                                    <span class="bar">
                                                        <span class="fill" style="width:{{ceil($rates[$k][0][3] * 100 / $total)}}%;"></span>
                                                    </span>
                                                </span>
                                                                    <span class="row_label row_cell">خوب</span>
                                                                </li>
                                                                <li class="chart_row clickable">
                                                                    <span class="row_count row_cell">{{ceil($rates[$k][0][2] * 100 / $total)}} %</span>
                                                <span class="row_bar row_cell">
                                                    <span class="bar">
                                                        <span class="fill" style="width:{{ceil($rates[$k][0][2] * 100 / $total)}}%;"></span>
                                                    </span>
                                                </span>
                                                                    <span class="row_label row_cell">معمولی</span></li>
                                                                <li class="chart_row clickable">
                                                                    <span class="row_count row_cell">{{ceil($rates[$k][0][1] * 100 / $total)}} %</span>
                                                <span class="row_bar row_cell">
                                                    <span class="bar">
                                                        <span class="fill" style="width:{{ceil($rates[$k][0][1] * 100 / $total)}}%;"></span>
                                                    </span>
                                                </span>
                                                                    <span class="row_label row_cell">ضعیف</span></li>
                                                                <li class="chart_row">
                                                                    <span class="row_count row_cell">{{ceil($rates[$k][0][0] * 100 / $total)}} %</span>
                                                <span class="row_bar row_cell">
                                                    <span class="bar">
                                                        <span class="fill" style="width:{{ceil($rates[$k][0][0] * 100 / $total)}}%;"></span>
                                                    </span>
                                                </span>
                                                                    <span class="row_label row_cell">خیلی بد </span></li>
                                                            </ul>
                                                        </DIV>
                                                        <div class="address" style="float: right; font-size: 14px">
                                                            {{$places[$k]->address}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </DIV>

                                    <center>
                                        <div id="loader_{{$k}}" class="loader hidden"></div>
                                    </center>

                                    <div id="reminderItems_{{$k}}">
                                        <DIV id="reviewsDiv_{{$k}}" style="direction: rtl" class="ppr_rup ppr_priv_location_detail_two_column">
                                            <div class="column_wrap ui_columns is-mobile" style="direction: rtl">
                                                <div class="content_column ui_column is-12" style="margin-top: 20px">
                                                    <DIV class="ppr_rup ppr_priv_location_reviews_container">
                                                        <div id="REVIEWS_{{$k}}" class="ratings_and_types concepts_and_filters block_wrap">
                                                            <div class="header_group block_header">
                                                                <span class="tabs_header reviews_header block_title">نظرات</span> <span class="reviews_header_count block_title"></span>
                                                            </div>
                                                            <DIV class="ppr_rup ppr_priv_location_review_filter_controls">
                                                                <div id="filterControls" class="with_histogram">
                                                                    <div class="main ui_columns is-mobile">
                                                                        <div id="ratingFilter" class="ui_column is-5 rating">
                                                                            <div class="colTitle">امتیاز</div>
                                                                            <ul>

                                                                                <li class="filterItem">
                                                        <span class="toggle">
                                                            <div class='ui_input_checkbox'>
                                                                <input onclick="filter('{{$k}}')" id="excellent" type="checkbox" name="filterComment_{{$k}}[]" value="rate_5" class="filterInput">

                                                                <label class='labelForCheckBox' for='excellent'>
                                                                    <span></span>&nbsp;&nbsp;
                                                                </label>
                                                            </div>
                                                        </span>
                                                                                    <label class="filterLabel" style="margin-right: 34px">
                                                                                        <div class="row_label">عالی</div>
                                                                                        <span class="row_bar"><span class="row_fill" style="width:{{$rates[$k][0][4] * 100 / $total}}%;"></span></span><span>{{$rates[$k][0][4]}}</span>
                                                                                    </label>
                                                                                </li>

                                                                                <li class="filterItem">
                                                        <span class="toggle">
                                                            <div class='ui_input_checkbox'>
                                                                <input onclick="filter('{{$k}}')" type="checkbox" id="very_good" name="filterComment_{{$k}}[]" value="rate_4" class="filterInput">

                                                                <label class='labelForCheckBox' for='very_good'>
                                                                    <span></span>&nbsp;&nbsp;
                                                                </label>
                                                            </div>
                                                        </span>

                                                                                    <label class="filterLabel" style="margin-right: 34px">
                                                                                        <div class="row_label">خوب</div>
                                                                                        <span class="row_bar"><span class="row_fill" style="width:{{$rates[$k][0][3] * 100 / $total}}%;"></span></span><span>{{$rates[$k][0][3]}}</span>
                                                                                    </label>
                                                                                </li>


                                                                                <li class="filterItem">
                                                        <span class="toggle">
                                                            <div class='ui_input_checkbox'>
                                                               <input onclick="filter('{{$k}}')" type="checkbox" id="average" name="filterComment_{{$k}}[]" value="rate_3" class="filterInput">

                                                                <label class='labelForCheckBox' for='average'>
                                                                    <span></span>&nbsp;&nbsp;
                                                                </label>
                                                            </div>
                                                        </span>
                                                                                    <label class="filterLabel" style="margin-right: 34px">
                                                                                        <div class="row_label">معمولی</div>
                                                                                        <span class="row_bar"><span class="row_fill" style="width:{{$rates[$k][0][2] * 100 / $total}}%;"></span></span><span>{{$rates[$k][0][2]}}</span>
                                                                                    </label>
                                                                                </li>


                                                                                <li class="filterItem">
                                                        <span class="toggle">
                                                            <div class='ui_input_checkbox'>
                                                                <input onclick="filter('{{$k}}')" type="checkbox" name="filterComment_{{$k}}[]" value="rate_2" id="poor" class="filterInput">

                                                                <label class='labelForCheckBox' for='poor'>
                                                                    <span></span>&nbsp;&nbsp;
                                                                </label>
                                                            </div>
                                                        </span>
                                                                                    <label class="filterLabel" style="margin-right: 34px">
                                                                                        <div class="row_label">ضعیف</div>
                                                            <span class="row_bar">
                                                                <span class="row_fill" style="width:{{$rates[$k][0][1] * 100 / $total}}%;"></span>
                                                            </span>
                                                                                        <span>{{$rates[$k][0][1]}}</span>
                                                                                    </label>
                                                                                </li>

                                                                                <li class="filterItem">
                                                        <span class="toggle">
                                                            <div class='ui_input_checkbox'>
                                                                <input onclick="filter('{{$k}}')" type="checkbox" name="filterComment_{{$k}}[]" value="rate_1" id="very_poor" class="filterInput">

                                                                <label class='labelForCheckBox' for='very_poor'>
                                                                    <span></span>&nbsp;&nbsp;
                                                                </label>
                                                            </div>
                                                        </span>
                                                                                    <label class="filterLabel" style="margin-right: 34px">
                                                                                        <div class="row_label">خیلی بد</div>
                                                                                        <span class="row_bar"><span class="row_fill" style="width:{{$rates[$k][0][0] * 100 / $total}}%;"></span></span><span>{{$rates[$k][0][0]}}</span>
                                                                                    </label>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="ui_column is-2 segment">
                                                                            <div class="colTitle">نوع سفر</div>
                                                                            <ul id="placeStyles_{{$k}}">
                                                                            </ul>
                                                                        </div>
                                                                        <div class="ui_column is-2 season">
                                                                            <div class="colTitle">زمان سفر</div>
                                                                            <ul>
                                                                                <li class="filterItem">
                                                                                    <div class='ui_input_checkbox'>
                                                                                        <input onclick="filter('{{$k}}')" value="season_1" id="season_1" type="checkbox" name="filterComment_{{$k}}[]" class="filterInput">
                                                                                        <label class='labelForCheckBox' for='season_1'>
                                                                                            <span></span>&nbsp;&nbsp;بهار
                                                                                        </label>
                                                                                    </div>
                                                                                </li>
                                                                                <li class="filterItem">
                                                                                    <div class='ui_input_checkbox'>
                                                                                        <input onclick="filter('{{$k}}')" value="season_2" id="season_2" type="checkbox" name="filterComment_{{$k}}[]" class="filterInput">
                                                                                        <label class='labelForCheckBox' for='season_2'>
                                                                                            <span></span>&nbsp;&nbsp;تابستان
                                                                                        </label>
                                                                                    </div>
                                                                                </li>
                                                                                <li class="filterItem">
                                                                                    <div class='ui_input_checkbox'>
                                                                                        <input onclick="filter('{{$k}}')" value="season_3" id="season_3" type="checkbox" name="filterComment_{{$k}}[]" class="filterInput">
                                                                                        <label class='labelForCheckBox' for='season_3'>
                                                                                            <span></span>&nbsp;&nbsp;پاییز
                                                                                        </label>
                                                                                    </div>
                                                                                </li>
                                                                                <li class="filterItem">
                                                                                    <div class='ui_input_checkbox'>
                                                                                        <input onclick="filter('{{$k}}')" value="season_4" id="season_4" type="checkbox" name="filterComment_{{$k}}[]" class="filterInput">
                                                                                        <label class='labelForCheckBox' for='season_4'>
                                                                                            <span></span>&nbsp;&nbsp;زمستان
                                                                                        </label>
                                                                                    </div>
                                                                                </li>
                                                                            </ul>
                                                                            <input type="hidden" name="filterSeasons" value="">
                                                                        </div>
                                                                        <div class="ui_column is-3 language">
                                                                            <div class="colTitle">مبدا سفر</div>

                                                                            <ul id="srcCities_{{$k}}">
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div id="moreCities_{{$k}}" class="hidden">
                                                                    <div class="ppr_rup ppr_priv_location_review_filter_controls">
                                                                        <div style="font-size: 18px" class="title">شهر ها</div>
                                                                        <ul class="langs" id="moreCitiesItems_{{$k}}">
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </DIV>

                                                            <DIV class="ppr_rup ppr_priv_location_review_keyword_search">
                                                                <div id="taplc_location_review_keyword_search_hotels_0_search">
                                                                    <label class="title" for="taplc_location_review_keyword_search_hotels_0_q">نمایش جستجو در نقد ها </label>
                                                                    <div class="search_box_container">
                                                                        <div class="search">
                                                                            <div class="search-input ">
                                                                                <div class="search-submit" onclick="comments($('#comment_search_text_{{$k}}').val(), '{{$k}}')">
                                                                                    <div class="submit"><span class="ui_icon search search-icon"/></div>
                                                                                </div>
                                                                                <input type="text" autofocus autocomplete="off" id="comment_search_text_{{$k}}" placeholder='جستجو در نقد ها' class="text_input nocloud"/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="ui_tagcloud_group easyClear">
                                                                    <span id="taplc_location_review_keyword_search_hotels_0_all_reviews" class="ui_tagcloud selected fl all_reviews" data-val-idx="{{$k}}" data-content="-1">همه ی نظرات</span>
                                                                    <span id="tagsItems_{{$k}}"></span>
                                                                </div>

                                                            </DIV>

                                                            <DIV id="reviewsContainer_{{$k}}" class="ppr_rup ppr_priv_location_reviews_list">
                                                            </DIV>
                                                            <div class="unified pagination north_star">
                                                                <div class="pageNumbers" id="pageNumCommentContainer">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </DIV>
                                                </div>
                                                <div class="ad_column ui_column is-4">
                                                    <div class="adParent">
                                                        <div class="ad iab_medRecStrict single inactive">
                                                            <div id="gpt-ad-300x250-a" class="adInner gptAd"></div>
                                                        </div>
                                                    </div>
                                                    <div class="adParent">
                                                        <div class="ad iab_medRec dual inactive">
                                                            <div id="gpt-ad-300x250-300x600-a" class="adInner gptAd"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </DIV>

                                        <DIV id="shops_{{$k}}" class="ppr_rup ppr_priv_hr_btf_similar_hotels">
                                            <div class="outerShell block_wrap">
                                                <div class="ui_columns is-mobile recs">
                                                    <div class="nearbyContainer outerShell block_wrap" style="margin-right: 10px">
                                                        <DIV class="prw_rup prw_common_btf_nearby_poi_grid poiGrid hotel" style="border-color: #CCCCCC !important;">
                                                            <div class="sectionTitleWrap"><span class="sectionTitle">فروشگاه ها</span></div>
                                                            <div class="ui_columns is-multiline container">
                                                                @foreach($nearbies[$k] as $itr)
                                                                    <DIV class="prw_rup prw_common_btf_nearby_poi_entry ui_column is-6 poiTile" style="width: 30% !important;">
                                                                        <div class="ui_columns is-gapless is-mobile poiEntry shownOnMap">
                                                                            <DIV class="prw_rup prw_common_centered_image ui_column is-4 thumbnailWrap">
                                                                                <span class="imgWrap" style="max-width:94px;max-height:80px;">
                                                                                    <img src="{{URL::asset('images/shop-icon.jpg')}}" class="centeredImg" style=" min-width:80px; " width="100%"/>
                                                                                </span>
                                                                            </DIV>
                                                                            <div class="poiInfo ui_column is-8">
                                                                                <div class="poiName">{{$itr}}</div>
                                                                                <DIV class="prw_rup prw_meta_location_nearby_xsell_rec_price pricing nearby">
                                                                                    <div class="price"></div>
                                                                                    <div class="loadingPrices"><span class="ui_button nearbyMeta loading disabled">&nbsp;<span class="ui_loader"><span></span><span></span><span></span><span></span><span></span></span></span></div>
                                                                                </DIV>
                                                                            </div>
                                                                        </div>
                                                                    </DIV>
                                                                @endforeach
                                                                <div style="clear: both;"></div>
                                                            </div>
                                                        </DIV>
                                                    </div>
                                                </div>
                                            </div>
                                        </DIV>

                                        <DIV id="photosDiv_{{$k}}" class="ppr_rup ppr_priv_hr_btf_north_star_photos">
                                            <div class="block_wrap">
                                                <div class="block_header">
                                                    <div class="block_title">عکس ها </div>
                                                </div>
                                                <div class="block_body_top">
                                                    <div class="ui_columns is-mobile" style="direction: ltr;">
                                                        <div class="carousel_wrapper ui_column is-6">
                                                            <DIV class="prw_rup prw_common_mercury_photo_carousel carousel_outer">
                                                                <div class="carousel bignav" style="max-height: 424px;">
                                                                    <div id="carousel-images-footer_{{$k}}" class="carousel-images carousel-images-footer" style="height: 100%">
                                                                        <div class="see_all_count_wrap"><span class="see_all_count" id="see_all_count"></span></div>
                                                                    </div>
                                                                    <div onclick="photoRoundRobin2(-1, '{{$k}}')" id="left-nav-footer_{{$k}}" class="left-nav"></div>
                                                                    <div onclick="photoRoundRobin2(1, '{{$k}}')" id="right-nav-footer_{{$k}}" class="right-nav"></div>
                                                                </div>
                                                            </DIV>
                                                        </div>
                                                        <div class="thumb_wrapper ui_column ui_columns is-multiline is-mobile" id="logPhotosItems_{{$k}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="block_body_bottom">
                                                    <div class="inner ui_columns is-multiline is-mobile"></div>
                                                </div>
                                            </div>
                                        </DIV>

                                        <DIV id="ansAndQeustionDiv_{{$k}}" class="ppr_rup ppr_priv_location_qa">
                                        <div data-tab="TABS_ANSWERS" class="block_wrap">
                                            <div class="block_header" style="padding: 40px">
                                                <span style="font-size: 28px; font-weight: bold; line-height: 32px; float: right; color: #333;" class="block_title">سوال و جواب</span>
                                            </div>
                                            <div style="clear: both;"></div>

                                            <div class="block_body_top">
                                                <DIV class="prw_rup prw_common_location_topic">
                                                    <div class="question ui_column is-12 is-mobile" id="questionsContainer_{{$k}}" style="direction: rtl">
                                                    </div>
                                                </DIV>
                                                <DIV class="prw_rup prw_common_north_star_pagination" id="pageNumQuestionContainer">
                                                </DIV>
                                            </div>
                                        </div>
                                    </DIV>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <DIV class="prw_rup prw_common_atf_header_bl headerBL" style="direction: rtl; width: 100%">
                        <div class="blRow">
                            <div class="blEntry address  clickable colCnt3">
                                <span class="ui_icon map-pin"></span>
                                <span class="street-address">آدرس : </span>
                                <span>{{$places[$k]->address}}</span>
                            </div>
                            <div class="blEntry phone">
                                <span class="ui_icon phone"></span>
                                <span>{{$places[$k]->phone}}</span>
                            </div>
                            <div class="blEntry website">
                                <span class="ui_icon laptop"></span>
                                @if(!empty($places[$k]->site))
                                    <?php
                                    if(strpos($places[$k]->site, 'http') === false)
                                        $places[$k]->site = 'http://' . $places[$k]->site;
                                    ?>
                                    <a target="_blank" href="{{$places[$k]->site}}">
                                        <span>{{$places[$k]->site}}</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </DIV>

                    <div class="full_meta_photos_v3  full_meta_photos_v4  big_pic_mainwrap_tweaks horizontal_xsell ui_container is-mobile hidden stickyMenuDiv" id="stickyMenu_{{$k}}">
                        <div class="Hotel_Review prodp13n_jfy_overflow_visible">
                            <div class="col easyClear bodLHN poolB adjust_padding new_meta_chevron new_meta_chevron_v2">
                                <div class="hr_btf_wrap">

                                    <DIV id="introduction_{{$k}}" class="ppr_rup ppr_priv_location_detail_overview">
                                        <div class="block_wrap">
                                            <div class="block_header">
                                                <div class="block_title">معرفی کلی </div>
                                            </div>
                                            <div>
                                                <div class="overviewContent" id="introductionText_{{$k}}" style="direction: rtl; line-height: 20px; font-size: 14px; max-height: 50px; overflow: hidden; padding: 10px">
                                                    {{$places[$k]->description}}
                                                </div>
                                                <div id="showMore_{{$k}}" onclick="showMore2('{{$k}}')" style="cursor: pointer;color:#16174f;" class="hidden">بیشتر</div>
                                            </div>
                                            <div class="overviewContent">
                                                <DIV class="prw_rup prw_common_static_map_no_style staticMap"></DIV>
                                                <div class="ui_columns is-multiline is-mobile reviewsAndDetails" style="direction: ltr;">
                                                    <div class="ui_column is-6 details">
                                                        <div class="thumb_wrapper ui_column ui_columns is-multiline is-mobile" style="padding: 12px">
                                                            <div id="map_{{$k}}" data-val-x="{{$places[$k]->C}}" data-val-y="{{$places[$k]->D}}" class="ui_column is-12 mapTile prv_map clickable" style="float: right; height:224px; border: 1px solid #000;"></div>
                                                            <div style="clear: both;"></div>
                                                        </div>
                                                    </div>
                                                    <div class="ui_column  is-6 reviews" style="direction: ltr;">
                                                        <div class="rating">
                                                            <span class="overallRating">{{$avgRates[$k][1]}} </span>
                                                            <DIV class="prw_rup prw_common_bubble_rating overallBubbleRating">
                                                                @if($avgRates[$k][1] == 5)
                                                                    <span class="ui_bubble_rating bubble_50" style="font-size:28px;" property="ratingValue" content="5" alt='5 of 5 bubbles'></span>
                                                                @elseif($avgRates[$k][1] == 4)
                                                                    <span class="ui_bubble_rating bubble_40" style="font-size:28px;" property="ratingValue" content="4" alt='4 of 5 bubbles'></span>
                                                                @elseif($avgRates[$k][1] == 3)
                                                                    <span class="ui_bubble_rating bubble_30" style="font-size:28px;" property="ratingValue" content="3" alt='3 of 5 bubbles'></span>
                                                                @elseif($avgRates[$k][1] == 2)
                                                                    <span class="ui_bubble_rating bubble_20" style="font-size:28px;" property="ratingValue" content="2" alt='2 of 5 bubbles'></span>
                                                                @elseif($avgRates[$k][1] == 1)
                                                                    <span class="ui_bubble_rating bubble_10" style="font-size:28px;" property="ratingValue" content="1" alt='1 of 5 bubbles'></span>
                                                                @endif
                                                            </DIV>
                                                            <a class="seeAllReviews autoResize" href="#REVIEWS_{{$k}}"></a>
                                                        </div>
                                                        <DIV class="prw_rup prw_common_ratings_histogram_overview overviewHistogram">
                                                            <ul class="ratings_chart">
                                                                <li class="chart_row highlighted clickable">
                                                                    <span class="row_count row_cell">{{ceil($rates[$k][0][4] * 100 / $total)}} %</span>
                                                                    <span class="row_bar row_cell">
                                                                        <span class="bar">
                                                                            <span class="fill" style="width: {{ceil($rates[$k][0][4] * 100 / $total)}}%;"></span>
                                                                        </span>
                                                                    </span>
                                                                    <span class="row_label row_cell">عالی</span>
                                                                </li>
                                                                <li class="chart_row clickable">
                                                                    <span class="row_count row_cell">{{ceil($rates[$k][0][3] * 100 / $total)}} %</span>
                                                                    <span class="row_bar row_cell">
                                                                        <span class="bar">
                                                                            <span class="fill" style="width:{{ceil($rates[$k][0][3] * 100 / $total)}}%;"></span>
                                                                        </span>
                                                                    </span>
                                                                    <span class="row_label row_cell">خوب</span>
                                                                </li>
                                                                <li class="chart_row clickable">
                                                                    <span class="row_count row_cell">{{ceil($rates[$k][0][2] * 100 / $total)}} %</span>
                                                                    <span class="row_bar row_cell">
                                                                        <span class="bar">
                                                                            <span class="fill" style="width:{{ceil($rates[$k][0][2] * 100 / $total)}}%;"></span>
                                                                        </span>
                                                                    </span>
                                                                    <span class="row_label row_cell">معمولی</span>
                                                                </li>
                                                                <li class="chart_row clickable">
                                                                    <span class="row_count row_cell">{{ceil($rates[$k][0][1] * 100 / $total)}} %</span>
                                                                    <span class="row_bar row_cell">
                                                                        <span class="bar">
                                                                            <span class="fill" style="width:{{ceil($rates[$k][0][1] * 100 / $total)}}%;"></span>
                                                                        </span>
                                                                    </span>
                                                                    <span class="row_label row_cell">ضعیف</span>
                                                                </li>
                                                                <li class="chart_row">
                                                                    <span class="row_count row_cell">{{ceil($rates[$k][0][0] * 100 / $total)}} %</span>
                                                                    <span class="row_bar row_cell">
                                                                        <span class="bar">
                                                                            <span class="fill" style="width:{{ceil($rates[$k][0][0] * 100 / $total)}}%;"></span>
                                                                        </span>
                                                                    </span>
                                                                    <span class="row_label row_cell">خیلی بد </span>
                                                                </li>
                                                            </ul>
                                                        </DIV>
                                                    </div>
                                                </div>
                                            </DIV>
                                        </div>
                                    </div>

                                    <center>
                                        <div id="loader_{{$k}}" class="loader hidden"></div>
                                    </center>

                                    <div id="reminderItems_{{$k}}">
                                        <DIV id="reviewsDiv_{{$k}}" style="direction: rtl" class="ppr_rup ppr_priv_location_detail_two_column">
                                            <div class="column_wrap ui_columns is-mobile" style="direction: rtl">
                                                <div class="content_column ui_column is-12" style="margin-top: 20px">
                                                    <DIV class="ppr_rup ppr_priv_location_reviews_container">
                                                        <div id="REVIEWS_{{$k}}" class="ratings_and_types concepts_and_filters block_wrap">
                                                            <div class="header_group block_header">
                                                                <span class="tabs_header reviews_header block_title">نظرات</span> <span class="reviews_header_count block_title"></span>
                                                            </div>
                                                            <DIV class="ppr_rup ppr_priv_location_review_filter_controls">
                                                                <div id="filterControls" class="with_histogram">
                                                                    <div class="main ui_columns is-mobile">
                                                                        <div id="ratingFilter" class="ui_column is-5 rating">
                                                                            <div class="colTitle">امتیاز</div>
                                                                            <ul>

                                                                                <li class="filterItem">
                                                                                    <span class="toggle">
                                                                                        <div class='ui_input_checkbox'>
                                                                                            <input onclick="filter('{{$k}}')" id="excellent" type="checkbox" name="filterComment_{{$k}}[]" value="rate_5" class="filterInput">

                                                                                            <label class='labelForCheckBox' for='excellent'>
                                                                                                <span></span>&nbsp;&nbsp;
                                                                                            </label>
                                                                                        </div>
                                                                                    </span>
                                                                                    <label class="filterLabel" style="margin-right: 34px">
                                                                                        <div class="row_label">عالی</div>
                                                                                        <span class="row_bar"><span class="row_fill" style="width:{{$rates[$k][0][4] * 100 / $total}}%;"></span></span><span>{{$rates[$k][0][4]}}</span>
                                                                                    </label>
                                                                                </li>

                                                                                <li class="filterItem">
                                                                                    <span class="toggle">
                                                                                        <div class='ui_input_checkbox'>
                                                                                            <input onclick="filter('{{$k}}')" type="checkbox" id="very_good" name="filterComment_{{$k}}[]" value="rate_4" class="filterInput">

                                                                                            <label class='labelForCheckBox' for='very_good'>
                                                                                                <span></span>&nbsp;&nbsp;
                                                                                            </label>
                                                                                        </div>
                                                                                    </span>

                                                                                    <label class="filterLabel" style="margin-right: 34px">
                                                                                        <div class="row_label">خوب</div>
                                                                                        <span class="row_bar"><span class="row_fill" style="width:{{$rates[$k][0][3] * 100 / $total}}%;"></span></span><span>{{$rates[$k][0][3]}}</span>
                                                                                    </label>
                                                                                </li>

                                                                                <li class="filterItem">
                                                                                    <span class="toggle">
                                                                                        <div class='ui_input_checkbox'>
                                                                                           <input onclick="filter('{{$k}}')" type="checkbox" id="average" name="filterComment_{{$k}}[]" value="rate_3" class="filterInput">

                                                                                            <label class='labelForCheckBox' for='average'>
                                                                                                <span></span>&nbsp;&nbsp;
                                                                                            </label>
                                                                                        </div>
                                                                                    </span>
                                                                                    <label class="filterLabel" style="margin-right: 34px">
                                                                                        <div class="row_label">معمولی</div>
                                                                                        <span class="row_bar"><span class="row_fill" style="width:{{$rates[$k][0][2] * 100 / $total}}%;"></span></span><span>{{$rates[$k][0][2]}}</span>
                                                                                    </label>
                                                                                </li>

                                                                                <li class="filterItem">
                                                                                    <span class="toggle">
                                                                                        <div class='ui_input_checkbox'>
                                                                                            <input onclick="filter('{{$k}}')" type="checkbox" name="filterComment_{{$k}}[]" value="rate_2" id="poor" class="filterInput">

                                                                                            <label class='labelForCheckBox' for='poor'>
                                                                                                <span></span>&nbsp;&nbsp;
                                                                                            </label>
                                                                                        </div>
                                                                                    </span>
                                                                                    <label class="filterLabel" style="margin-right: 34px">
                                                                                        <div class="row_label">ضعیف</div>
                                                                                        <span class="row_bar">
                                                                                            <span class="row_fill" style="width:{{$rates[$k][0][1] * 100 / $total}}%;"></span>
                                                                                        </span>
                                                                                        <span>{{$rates[$k][0][1]}}</span>
                                                                                    </label>
                                                                                </li>

                                                                                <li class="filterItem">
                                                                                    <span class="toggle">
                                                                                        <div class='ui_input_checkbox'>
                                                                                            <input onclick="filter('{{$k}}')" type="checkbox" name="filterComment_{{$k}}[]" value="rate_1" id="very_poor" class="filterInput">

                                                                                            <label class='labelForCheckBox' for='very_poor'>
                                                                                                <span></span>&nbsp;&nbsp;
                                                                                            </label>
                                                                                        </div>
                                                                                    </span>
                                                                                    <label class="filterLabel" style="margin-right: 34px">
                                                                                        <div class="row_label">خیلی بد</div>
                                                                                        <span class="row_bar"><span class="row_fill" style="width:{{$rates[$k][0][0] * 100 / $total}}%;"></span></span><span>{{$rates[$k][0][0]}}</span>
                                                                                    </label>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="ui_column is-2 segment">
                                                                            <div class="colTitle">نوع سفر</div>
                                                                            <ul id="placeStyles_{{$k}}">
                                                                            </ul>
                                                                        </div>
                                                                        <div class="ui_column is-2 season">
                                                                            <div class="colTitle">زمان سفر</div>
                                                                            <ul>
                                                                                <li class="filterItem">
                                                                                    <div class='ui_input_checkbox'>
                                                                                        <input onclick="filter('{{$k}}')" value="season_1" id="season_1" type="checkbox" name="filterComment_{{$k}}[]" class="filterInput">
                                                                                        <label class='labelForCheckBox' for='season_1'>
                                                                                            <span></span>&nbsp;&nbsp;بهار
                                                                                        </label>
                                                                                    </div>
                                                                                </li>
                                                                                <li class="filterItem">
                                                                                    <div class='ui_input_checkbox'>
                                                                                        <input onclick="filter('{{$k}}')" value="season_2" id="season_2" type="checkbox" name="filterComment_{{$k}}[]" class="filterInput">
                                                                                        <label class='labelForCheckBox' for='season_2'>
                                                                                            <span></span>&nbsp;&nbsp;تابستان
                                                                                        </label>
                                                                                    </div>
                                                                                </li>
                                                                                <li class="filterItem">
                                                                                    <div class='ui_input_checkbox'>
                                                                                        <input onclick="filter('{{$k}}')" value="season_3" id="season_3" type="checkbox" name="filterComment_{{$k}}[]" class="filterInput">
                                                                                        <label class='labelForCheckBox' for='season_3'>
                                                                                            <span></span>&nbsp;&nbsp;پاییز
                                                                                        </label>
                                                                                    </div>
                                                                                </li>
                                                                                <li class="filterItem">
                                                                                    <div class='ui_input_checkbox'>
                                                                                        <input onclick="filter('{{$k}}')" value="season_4" id="season_4" type="checkbox" name="filterComment_{{$k}}[]" class="filterInput">
                                                                                        <label class='labelForCheckBox' for='season_4'>
                                                                                            <span></span>&nbsp;&nbsp;زمستان
                                                                                        </label>
                                                                                    </div>
                                                                                </li>
                                                                            </ul>
                                                                            <input type="hidden" name="filterSeasons" value="">
                                                                        </div>
                                                                        <div class="ui_column is-3 language">
                                                                            <div class="colTitle">مبدا سفر</div>

                                                                            <ul id="srcCities_{{$k}}">
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div id="moreCities_{{$k}}" class="hidden">
                                                                    <div class="ppr_rup ppr_priv_location_review_filter_controls">
                                                                        <div style="font-size: 18px" class="title">شهر ها</div>
                                                                        <ul class="langs" id="moreCitiesItems_{{$k}}">
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </DIV>

                                                            <DIV class="ppr_rup ppr_priv_location_review_keyword_search">
                                                                <div id="taplc_location_review_keyword_search_hotels_0_search">
                                                                    <label class="title" for="taplc_location_review_keyword_search_hotels_0_q">نمایش جستجو در نقد ها </label>
                                                                    <div class="search_box_container">
                                                                        <div class="search">
                                                                            <div class="search-input ">
                                                                                <div class="search-submit" onclick="comments($('#comment_search_text_{{$k}}').val(), '{{$k}}')">
                                                                                    <div class="submit"><span class="ui_icon search search-icon"></span></div>
                                                                                </div>
                                                                                <input type="text" autofocus autocomplete="off" id="comment_search_text_{{$k}}" placeholder='جستجو در نقد ها' class="text_input nocloud"/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="ui_tagcloud_group easyClear">
                                                                    <span id="taplc_location_review_keyword_search_hotels_0_all_reviews" class="ui_tagcloud selected fl all_reviews" data-val-idx="{{$k}}" data-content="-1">همه ی نظرات</span>
                                                                    <span id="tagsItems_{{$k}}"></span>
                                                                </div>
                                                            </DIV>

                                                            <DIV id="reviewsContainer_{{$k}}" class="ppr_rup ppr_priv_location_reviews_list"></DIV>
                                                            <div class="unified pagination north_star">
                                                                <div class="pageNumbers" id="pageNumCommentContainer">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </DIV>
                                                </div>
                                                <div class="ad_column ui_column is-4">
                                                    <div class="adParent">
                                                        <div class="ad iab_medRecStrict single inactive">
                                                            <div id="gpt-ad-300x250-a" class="adInner gptAd"></div>
                                                        </div>
                                                    </div>
                                                    <div class="adParent">
                                                        <div class="ad iab_medRec dual inactive">
                                                            <div id="gpt-ad-300x250-300x600-a" class="adInner gptAd"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </DIV>

                                        <DIV id="similars" class="ppr_rup ppr_priv_hr_btf_similar_hotels">
                                            <div class="outerShell block_wrap">
                                                <div class="block_header" style="border-bottom: 1px solid var(--koochita-light-green) !important;">
                                                    @if($placeModes[$k] == "hotel")
                                                        <div class="block_title">هتل های مشابه</div>
                                                    @elseif($placeModes[$k] == "amaken")
                                                        <div class="block_title">اماکن مشابه</div>
                                                    @else
                                                        <div class="block_title">رستوران های مشابه</div>
                                                    @endif
                                                </div>
                                                <div class="ui_columns is-mobile recs" id="similarsItems_{{$k}}">
                                                </div>
                                            </div>
                                        </DIV>

                                        <DIV id="photosDiv_{{$k}}" class="ppr_rup ppr_priv_hr_btf_north_star_photos">
                                            <div class="block_wrap">
                                                <div class="block_header">
                                                    <div class="block_title">عکس ها </div>
                                                </div>
                                                <div class="block_body_top">
                                                    <div class="ui_columns is-mobile" style="direction: ltr;">
                                                        <div class="carousel_wrapper ui_column is-6">
                                                            <DIV class="prw_rup prw_common_mercury_photo_carousel carousel_outer">
                                                                <div class="carousel bignav" style="max-height: 424px;">
                                                                    <div id="carousel-images-footer_{{$k}}" class="carousel-images carousel-images-footer" style="height: 100%">
                                                                        <div class="see_all_count_wrap"><span class="see_all_count" id="see_all_count"></span></div>
                                                                    </div>
                                                                    <div onclick="photoRoundRobin2(-1, '{{$k}}')" id="left-nav-footer_{{$k}}" class="left-nav"></div>
                                                                    <div onclick="photoRoundRobin2(1, '{{$k}}')" id="right-nav-footer_{{$k}}" class="right-nav"></div>
                                                                </div>
                                                            </DIV>
                                                        </div>
                                                        <div class="thumb_wrapper ui_column ui_columns is-multiline is-mobile" id="logPhotosItems_{{$k}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="block_body_bottom">
                                                    <div class="inner ui_columns is-multiline is-mobile"></div>
                                                </div>
                                            </div>
                                        </DIV>

                                        <DIV id="nearbyDiv_{{$k}}" class="ppr_rup ppr_priv_location_detail_two_column">
                                            <div class="column_wrap ui_columns is-mobile">
                                                <div class="content_column ui_column is-8">
                                                    <style>
                                                        .poiTile{
                                                            float: left;
                                                        }
                                                    </style>

                                                    <DIV class="ppr_rup ppr_priv_location_nearby">
                                                        <div class="nearbyContainer outerShell block_wrap">
                                                            <div class="block_header"><div style="font-size: 28px; font-weight: bold; line-height: 32px; color: #333;" class="block_title">مکان های نزدیک </div></div>

                                                            <DIV class="prw_rup prw_common_btf_nearby_poi_grid poiGrid hotel" data-prwidget-name="common_btf_nearby_poi_grid" data-prwidget-init="">
                                                                <div class="sectionTitleWrap"><span class="sectionTitle">هتل های نزدیک</span></div>
                                                                <div class="ui_columns is-multiline container" id="nearbyHotelsItems_{{$k}}">
                                                                </div>
                                                            </DIV>
                                                            <DIV class="prw_rup prw_common_btf_nearby_poi_grid poiGrid eatery" data-prwidget-name="common_btf_nearby_poi_grid" data-prwidget-init="">
                                                                <div class="sectionTitleWrap"><span class="sectionTitle">رستوران های نزدیک</span></div>
                                                                <div class="ui_columns is-multiline container" id="nearbyRestaurantsItems_{{$k}}">
                                                                </div>
                                                            </DIV>
                                                            <DIV class="prw_rup prw_common_btf_nearby_poi_grid poiGrid attraction" data-prwidget-name="common_btf_nearby_poi_grid" data-prwidget-init="">
                                                                <div class="sectionTitleWrap"><span class="sectionTitle">اماکن گردشگری نزدیک</span></div>
                                                                <div class="ui_columns is-multiline container" id="nearbyAmakensItems_{{$k}}">
                                                                </div>
                                                            </DIV>
                                                        </div>
                                                    </DIV>
                                                </div>
                                                <div class="ad_column ui_column is-4"></div>
                                            </div>
                                        </DIV>

                                        <DIV id="ansAndQeustionDiv_{{$k}}" class="ppr_rup ppr_priv_location_qa">
                                            <div data-tab="TABS_ANSWERS" class="block_wrap">
                                                <div class="block_header">
                                                    <span style="font-size: 28px; font-weight: bold; line-height: 32px; float: right; color: #333;" class="block_title">سوال و جواب</span>
                                                </div>
                                                <div style="clear: both;"></div>

                                                <div class="block_body_top">
                                                    <DIV class="prw_rup prw_common_location_topic">
                                                        <div class="question ui_column is-12 is-mobile" id="questionsContainer_{{$k}}" style="direction: rtl">
                                                        </div>
                                                    </DIV>
                                                    <DIV class="prw_rup prw_common_north_star_pagination" id="pageNumQuestionContainer">
                                                    </DIV>
                                                </div>
                                            </div>
                                        </DIV>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <?php $k++; ?>
        @endif
    @endfor

    <script src="{{URL::asset('js/resize.js')}}"></script>
    <script src="{{URL::asset('js/jsNeededForShowAllPlaces.js')}}"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdVEd4L2687AfirfAnUY1yXkx-7IsCER0&callback=init"></script>

    <span class='ui_overlay ui_popover arrow_right img_popUp hidden' style='z-index: 100000 !important; position: absolute; bottom: auto; direction: rtl; margin: -25px 20px 0 0'></span>

    <span id="addPlaceToTripPrompt" class="pop-up ui_overlay ui_modal find-location-modal-container fade_short fade_in hidden" style="position: fixed; width: 60%; left: 20%; right: auto; top: 20%; bottom: auto;">
        <div class="body_text">
            <div>
                <div class="find_location_modal">
                    <div style="direction: rtl" class="header_text">مدیریت مکان</div>
                    <div class="ui_typeahead" style="direction: rtl" id="tripsForPlace">
                    </div>
                </div>
            </div>
        </div>
        <div class="submitOptions" style="direction: rtl">
            <button onclick="assignPlaceToTrip()" style="color: #FFF;background-color: var(--koochita-light-green);border-color:var(--koochita-light-green);" class="btn btn-success">تایید</button>
            <input type="submit" onclick="hideElement('addPlaceToTripPrompt')" value="خیر" class="btn btn-default">
            <p style="margin-top: 10px" id="errorAssignPlace"></p>
        </div>
        <div class="ui_close_x" onclick="hideElement('addPlaceToTripPrompt')"></div>
    </span>
@stop