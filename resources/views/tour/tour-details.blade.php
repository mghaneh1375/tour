@extends('layouts.bodyPlace')

<?php
//$total = $rates[0] + $rates[1] + $rates[2] + $rates[3] + $rates[4];
//if ($total == 0)
//    $total = 1;
?>
@section('title')
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <link rel="stylesheet" href="{{URL::asset('css/theme2/media_uploader.css?v=1')}}">
    <script async src="{{URL::asset("js/bootstrap-datepicker.js")}}"></script>
    <link rel="stylesheet" href="{{URL::asset('css/theme2/bootstrap-datepicker.css?v=1')}}">
    {{--<title>{{$place->name}} | {{$city->name}} | کوچیتا</title>--}}
@stop

@section('meta')
    {{--<meta name="keywords" content="{{$place->keyword}}">--}}
    {{--<meta property="og:description" content="{{$place->meta}}"/>--}}
    {{--<meta property="article:tag" content="{{$place->tag1}}"/>--}}
    {{--<meta property="article:tag" content="{{$place->tag2}}"/>--}}
    {{--<meta property="article:tag" content="{{$place->tag3}}"/>--}}
    {{--<meta property="article:tag" content="{{$place->tag4}}"/>--}}
    {{--<meta property="article:tag" content="{{$place->tag5}}"/>--}}
    {{--<meta property="article:tag" content="{{$place->tag6}}"/>--}}
    {{--<meta property="article:tag" content="{{$place->tag7}}"/>--}}
    {{--<meta property="article:tag" content="{{$place->tag8}}"/>--}}
    {{--<meta property="article:tag" content="{{$place->tag9}}"/>--}}
    {{--<meta property="article:tag" content="{{$place->tag10}}"/>--}}
    {{--<meta property="article:tag" content="{{$place->tag11}}"/>--}}
    {{--<meta property="article:tag" content="{{$place->tag12}}"/>--}}
    {{--<meta property="article:tag" content="{{$place->tag13}}"/>--}}
    {{--<meta property="article:tag" content="{{$place->tag14}}"/>--}}
    {{--<meta property="article:tag" content="{{$place->tag15}}"/>--}}
    {{--<meta name="twitter:card" content="summary_large_image"/>--}}
    {{--<meta name="twitter:description" content="{{$place->meta}}"/>--}}
    {{--<meta name="twitter:title" content="{{$place->name}} | {{$city->name}} | کوچیتا"/>--}}
    {{--<meta property="og:url" content="{{Request::url()}}"/>--}}
    {{--@if(count($photos) > 0)--}}
    {{--<meta property="og:image" content="{{$photos[0]}}"/>--}}
    {{--<meta property="og:image:secure_url" content="{{$photos[0]}}"/>--}}
    {{--<meta property="og:image:width" content="550"/>--}}
    {{--<meta property="og:image:height" content="367"/>--}}
    {{--<meta name="twitter:image" content="{{$photos[0]}}"/>--}}
    {{--@endif--}}
    {{--<meta content="article" property="og:type"/>--}}
    {{--<meta property="og:title" content="{{$place->name}} | {{$city->name}} | کوچیتا"/>--}}



@stop

@section('header')
    @parent
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/photo_albums_stacked.css?v=1')}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/media_albums_extended.css?v=1')}}'/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/popUp.css?v=1')}}">
    <link rel="stylesheet" href="{{URL::asset('css/theme2/help.css?v=1')}}">
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/photo_albums_stacked.css?v=1')}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/media_albums_extended.css?v=1')}}'/>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/popUp.css?v=1')}}">
    <link rel="stylesheet" href="{{URL::asset('css/theme2/help.css?v=1')}}">
    <link rel="stylesheet" href="{{URL::asset('css/theme2/cropper.css?v=1')}}">
    <link rel="stylesheet" href="{{URL::asset('css/theme2/tourDetails.css?v=1')}}">

@stop

@section('main')
    <script src= {{URL::asset("js/calendar.js") }}></script>
    <script src= {{URL::asset("js/jalali.js") }}></script>

    <style>
        .changeWidth {
            @if(session('goDate'))
                   width: 14% !important;
        @endif

        }
    </style>

    {{--alarm--}}
    <span class="ui_overlay ui_modal editTags getAlarm"style="padding: 10px 10px 1px !important; z-index: 201; display: none">
        <div class="shTIcon clsIcon" style="float: left; color: var(--koochita-light-green); font-size: 2em"></div>
        <div class="alarmHeaderText"> آیا می خواهید کمترین قیمت ها را به شما اطلاع دهیم </div>
        <div class="alarmSubHeaderText"> هنگامی که قیمت پرواز های </div>
        <div class="ui_column ui_picker alarmBoxCityName">
            <div class="shTIcon locationIcon" style="display: inline-block"></div>
            <input id="fromWarning" class="alarmInputCityName" placeholder="شهر مبدأ">
            <div id="resultSrc" class="data_holder"
                 style="max-height: 160px; overflow: auto;"></div>
        </div>
        <div class="alarmSubHeaderText"> به </div>
        <div class="ui_column ui_picker alarmBoxCityName">
            <div class="shTIcon locationIcon" style="display: inline-block"></div>
            <input id="toWarning" class="alarmInputCityName" placeholder="شهر مقصد">
            <div id="resultDest" class="data_holder"
                 style="max-height: 160px; overflow: auto;"></div>
        </div>
        <div class="alarmSubHeaderText"> کاهش یابد به شما اطلاع دهیم </div>
        <div class="check-box__item hint-system"
             style="text-align: right; width: 100%; font: 1em; color: #4A4A4A; padding-top: 0 !important;">
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
            <button class="btn alarmPopUpBotton" type="button"> دریافت هشدار </button>
        </div>
    </span>

    <div class="global-nav-no-refresh" id="global-nav-no-refresh-2">
        <div id="taplc_global_nav_onpage_assets_0" class="ppr_rup ppr_priv_global_nav_onpage_assets"
             data-placement-name="global_nav_onpage_assets">
            <div class="ui_container">
                <div class="ui_columns easyClear">
                    <div class="ui_column" style="direction: rtl;position: relative;">
{{--                        @include('layouts.shareBox')--}}
                        <div ID="taplc_trip_planner_breadcrumbs_0" class="ppr_rup ppr_priv_trip_planner_breadcrumbs">
                            <ul class="breadcrumbs">
                                {{--@if($placeMode == "hotel")--}}
                                <li class="breadcrumb" itemscope>
                                    <a class="link"
                                       {{--{{($config->backToHotelListNoFollow) ? 'rel="nofollow"' : ''}}--}}
                                       {{--href="{{route('hotelList', ['city' => $state->name, 'mode' => 'state'])}}"--}}
                                       itemprop="url">
                                            <span itemprop="title">
                                                {{--{{$state->name}}--}}
                                            </span>
                                    </a>&nbsp
                                    <span class="ui_icon single-chevron-left"></span>&nbsp;
                                </li>
                                <li class="breadcrumb" itemscope>
                                    <a class="link"
                                       {{--{{($config->backToHotelListNoFollow) ? 'rel="nofollow"' : ''}}--}}
                                       {{--href="{{route('hotelList', ['city' => $city->name, 'mode' => 'city'])}}"--}}
                                       itemprop="url">
                                            <span itemprop="title">
                                                {{--{{$city->name}}--}}
                                            </span>
                                    </a>&nbsp;
                                    <span class="ui_icon single-chevron-left"></span>&nbsp;
                                </li>
                                @if(Auth::check() && Auth::user()->level != 0)
                                    <li class="breadcrumb" itemscope>
                                        <a class="link" target="_blank"
                                           {{--{{($config->panelNoFollow) ? 'rel="nofollow"' : ''}}--}}
                                           {{--href="http://panel.baligh.ir/changeAlt/{{$place->id}}/4"--}}
                                           itemprop="url">
                                            <span itemprop="title">مدیریت alt ها و تصاویر</span>
                                        </a>&nbsp;
                                        <span class="ui_icon single-chevron-left"></span>&nbsp;
                                    </li>
                                    <li class="breadcrumb" itemscope>
                                        <a class="link" target="_blank"
                                           {{--{{($config->panelNoFollow) ? 'rel="nofollow"' : ''}}--}}
                                           {{--href="http://panel.baligh.ir/changeContent/{{$city->id}}/4/1/{{$place->name}}"--}}
                                           itemprop="url">
                                            <span itemprop="title">مدیریت محتوا</span>
                                        </a>&nbsp;
                                        <span class="ui_icon single-chevron-left"></span>&nbsp;
                                    </li>
                                    <li class="breadcrumb" itemscope>
                                        <a class="link" target="_blank"
                                           {{--{{($config->panelNoFollow) ? 'rel="nofollow"' : ''}}--}}
                                           {{--href="http://panel.baligh.ir/changeSeo/{{$city->id}}/1/{{$place->name}}/4"--}}
                                           itemprop="url">
                                            <span itemprop="title">مدیریت سئو</span>
                                        </a>&nbsp;
                                        <span class="ui_icon single-chevron-left"></span>&nbsp;
                                    </li>
                                @endif
                                {{--@elseif($placeMode == "amaken")--}}
                                <li class="breadcrumb" itemscope>
                                    <a class="link"
                                       {{--{{($config->backToHotelListNoFollow) ? 'rel="nofollow"' : ''}}--}}
                                       {{--href="{{route('amakenList', ['city' => $state->name, 'mode' => 'state'])}}"--}}
                                       itemprop="url">
                                            <span itemprop="title">
                                                {{--{{$state->name}}--}}
                                            </span>
                                    </a>&nbsp;
                                    <span class="ui_icon single-chevron-left"></span>&nbsp;
                                </li>
                                <li class="breadcrumb" itemscope>
                                    <a class="link"
                                       {{--{{($config->backToHotelListNoFollow) ? 'rel="nofollow"' : ''}}--}}
                                       {{--href="{{route('amakenList', ['city' => $city->name, 'mode' => 'city'])}}"--}}
                                       itemprop="url">
                                            <span itemprop="title">
                                                {{--{{$city->name}}--}}
                                            </span>
                                    </a>&nbsp;
                                    <span class="ui_icon single-chevron-left"></span>&nbsp;
                                </li>
                                @if(Auth::check() && Auth::user()->level != 0)

                                    <li class="breadcrumb" itemscope>
                                        <a class="link" target="_blank"
                                           {{--{{($config->panelNoFollow) ? 'rel="nofollow"' : ''}}--}}
                                           {{--href="http://panel.baligh.ir/changeAlt/{{$place->id}}/{{$kindPlaceId}}"--}}
                                           itemprop="url">
                                            <span itemprop="title">مدیریت alt ها و تصاویر</span>
                                        </a>&nbsp;
                                        <span class="ui_icon single-chevron-left"></span>&nbsp;
                                    </li>
                                    <li class="breadcrumb" itemscope>
                                        <a class="link" target="_blank"
                                           {{--{{($config->panelNoFollow) ? 'rel="nofollow"' : ''}}--}}
                                           {{--href="http://panel.baligh.ir/changeContent/{{$city->id}}/{{$kindPlaceId}}/1/{{$place->name}}"--}}
                                           itemprop="url">
                                            <span itemprop="title">مدیریت محتوا</span>
                                        </a>&nbsp;
                                        <span class="ui_icon single-chevron-left"></span>&nbsp;
                                    </li>
                                    <li class="breadcrumb" itemscope>
                                        <a class="link" target="_blank"
                                           {{--{{($config->panelNoFollow) ? 'rel="nofollow"' : ''}}--}}
                                           {{--href="http://panel.baligh.ir/changeSeo/{{$city->id}}/1/{{$place->name}}/{{$kindPlaceId}}"--}}
                                           itemprop="url">
                                            <span itemprop="title">مدیریت سئو</span>
                                        </a>&nbsp;
                                        <span class="ui_icon single-chevron-left"></span>&nbsp;
                                    </li>
                                @endif
                                {{--@else--}}
                                <li class="breadcrumb" itemscope>
                                    <a class="link"
                                       {{--{{($config->backToHotelListNoFollow) ? 'rel="nofollow"' : ''}}--}}
                                       {{--href="{{route('restaurantList', ['city' => $state->name, 'mode' => 'state'])}}"--}}
                                       itemprop="url">
                                            <span itemprop="title">
                                                {{--{{$state->name}}--}}
                                            </span>
                                    </a>&nbsp;
                                    <span class="ui_icon single-chevron-left"></span>&nbsp;
                                </li>
                                <li class="breadcrumb" itemscope>
                                    <a class="link"
                                       {{--{{($config->backToHotelListNoFollow) ? 'rel="nofollow"' : ''}}--}}
                                       {{--href="{{route('restaurantList', ['city' => $city->name, 'mode' => 'city'])}}"--}}
                                       itemprop="url">
                                            <span itemprop="title">
                                                {{--{{$city->name}}--}}
                                            </span>
                                    </a>&nbsp;
                                    <span class="ui_icon single-chevron-left"></span>&nbsp;
                                </li>

                                @if(Auth::check() && Auth::user()->level != 0)
                                    <li class="breadcrumb" itemscope>
                                        <a class="link" target="_blank"
                                           {{--{{($config->panelNoFollow) ? 'rel="nofollow"' : ''}}--}}
                                           {{--href="http://panel.baligh.ir/changeAlt/{{$place->id}}/3"--}}
                                           itemprop="url">
                                            <span itemprop="title">مدیریت alt ها و تصاویر</span>
                                        </a>&nbsp;
                                        <span class="ui_icon single-chevron-left"></span>&nbsp;
                                    </li>
                                    <li class="breadcrumb" itemscope>
                                        <a class="link" target="_blank"
                                           {{--{{($config->panelNoFollow) ? 'rel="nofollow"' : ''}}--}}
                                           {{--href="http://panel.baligh.ir/changeContent/{{$city->id}}/3/1/{{$place->name}}"--}}
                                           itemprop="url">
                                            <span itemprop="title">مدیریت محتوا</span>
                                        </a>&nbsp;
                                        <span class="ui_icon single-chevron-left"></span>&nbsp;
                                    </li>
                                    <li class="breadcrumb" itemscope>
                                        <a class="link" target="_blank"
                                           {{--{{($config->panelNoFollow) ? 'rel="nofollow"' : ''}}--}}
                                           {{--href="http://panel.baligh.ir/changeSeo/{{$city->id}}/1/{{$place->name}}/3"--}}
                                           itemprop="url">
                                            <span itemprop="title">مدیریت سئو</span>
                                        </a>&nbsp;
                                        <span class="ui_icon single-chevron-left"></span>&nbsp;
                                    </li>
                                @endif
                                {{--@endif--}}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ppr_rup ppr_priv_hr_atf_north_star_nostalgic" style="position: relative;">

        <div class="atf_header_wrapper" style="position: relative;">
            <div class="atf_header ui_container is-mobile full_width" style="position: relative;">

                <div class="ppr_rup ppr_priv_location_detail_header" style="position: relative;">
                    <h1 id="HEADING" class="heading_title " property="name">
                        تور جهانگردی
                        {{--{{$place->name}}--}}
                    </h1>

                    <div class="rating_and_popularity">
                        <span class="header_rating">
                           <div class="rs rating" rel="v:rating">
                               <div class="prw_rup prw_common_bubble_rating overallBubbleRating" style="float: right;">
                                    {{--@if($avgRate == 5)--}}
                                   <span class="ui_bubble_rating bubble_50" style="font-size:16px;"
                                         property="ratingValue" content="5" alt='5 of 5 bubbles'></span>
                                   {{--@elseif($avgRate == 4)--}}
                                   {{--<span class="ui_bubble_rating bubble_40" style="font-size:16px;"--}}
                                   {{--property="ratingValue" content="4" alt='4 of 5 bubbles'></span>--}}
                                   {{--@elseif($avgRate == 3)--}}
                                   {{--<span class="ui_bubble_rating bubble_30" style="font-size:16px;"--}}
                                   {{--property="ratingValue" content="3" alt='3 of 5 bubbles'></span>--}}
                                   {{--@elseif($avgRate == 2)--}}
                                   {{--<span class="ui_bubble_rating bubble_20" style="font-size:16px;"--}}
                                   {{--property="ratingValue" content="2" alt='2 of 5 bubbles'></span>--}}
                                   {{--@elseif($avgRate == 1)--}}
                                   {{--<span class="ui_bubble_rating bubble_10" style="font-size:16px;"--}}
                                   {{--property="ratingValue" content="1" alt='1 of 5 bubbles'></span>--}}
                                   {{--@endif--}}
                               </div>
                               <a class="more taLnk" href="#REVIEWS" style="margin-right: 15px;">
                                   <span property="v:count" id="commentCount"></span> نقد
                               </a>
                           </div>
                        </span>
                        <span class="header_popularity popIndexValidation" style="margin-right: 0 !important">
                        <a>
                            {{--{{$total}} --}}
                            امتیاز
                        </a>
                        </span>
                    </div>
                    <div style="position: relative">

                        {{--<div style="width: 110px;height: 29px;position: absolute;left: 100px;border: 1px solid black;cursor: pointer;" onclick="changeStatetoReserved()">--}}
                        {{--<span class="ui_button" style="padding: 0">تغییر به حالت رزرو</span>--}}
                        {{--</div>--}}
                        {{--<div style="width: 130px;height: 29px;position: absolute;left: 215px;border: 1px solid black;cursor: pointer;" onclick="changeStatetounReserved()">--}}
                        {{--<span class="ui_button" style="padding: 0">تغییر به حالت غیر رزرو</span>--}}
                        {{--</div>--}}

                        <span class="ui_button_overlay" style="position: relative; float: left">
                            <div id="targetHelp_7" class="targets" style="float: right; position: relative">
                                <span onclick="saveToTrip()"
                                      class="ui_button saves ui_icon
                                      {{--{{($save) ? "red-heart-fill" : "red-heart"}} --}}
                                              ">
                                    لیست سفر
                                </span>
                                <div id="helpSpan_7" class="helpSpans row hidden">
                                    <span class="introjs-arrow"></span>
                                    <p class="col-xs-12" style="font-size: 12px; line-height: 1.428 !important;">
                                        در هر مکانی که هستید با زدن این دکمه می توانید، آن مکان را به لیست سفرهای خود اضافه کنید. به سادگی همراه با دوستان تان سفر های خود را برنامه ریزی کنید. به سادگی همین دکمه...
                                    </p>
                                    <button data-val="7" class="btn btn-success nextBtnsHelp"
                                            id="nextBtnHelp_7">بعدی</button>
                                    <button data-val="7" class="btn btn-primary backBtnsHelp"
                                            id="backBtnHelp_7">قبلی</button>
                                    <button class="btn btn-danger exitBtnHelp">خروج</button>
                                </div>
                            </div>
                            {{--@if($hasLogin)--}}
                            {{--<div id="targetHelp_8" class="targets" style="float: left;">--}}
                                {{--<span onclick="bookMark()"--}}
                                      {{--class="ui_button casino save-location-7306673 ui_icon--}}
                                      {{--{{($bookMark) ? "castle" : "red-heart"}} --}}
                                              {{--">نشانه گذاری</span>--}}
                                {{--<div id="helpSpan_8" class="helpSpans hidden row">--}}
                                    {{--<span class="introjs-arrow"></span>--}}
                                    {{--<p style="font-size: 12px; line-height: 1.428 !important;">شاید بعدا بخواهید دوباره به همین مکان باز گردید. پس آن را نشان کنید تا از منوی بالا هر وقت که خواستید دوباره به آن باز گردید.</p>--}}
                                    {{--<button data-val="8" class="btn btn-success nextBtnsHelp" id="nextBtnHelp_8">بعدی</button>--}}
                                    {{--<button data-val="8" class="btn btn-primary backBtnsHelp" id="backBtnHelp_8">قبلی</button>--}}
                                    {{--<button class="btn btn-danger exitBtnHelp">خروج</button>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--@endif--}}
                            <span class="btnoverlay loading">
                                <span class="bubbles small">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </span>
                            </span>
                        </span>
                        <div class="prw_rup prw_common_atf_header_bl headerBL" style="width:50%">
                            <div class="tourHeaderDetailsRow full-width">
                                <div class="inline-block col-xs-3" onclick="showExtendedMap()">
                                    <span class="street-address">مقصد: </span>
                                    <span>مقصد</span>
                                </div>
                                {{--@if(!empty($place->phone))--}}
                                <div class="inline-block col-xs-3">
                                    <span >حرکت از:</span>
                                    <span>مبدأ</span>
                                </div>
                                {{--@endif--}}
                                {{--@if(!empty($place->site))--}}
                                <div class="inline-block col-xs-3">
                                    <span>نوع تور:</span>
                                    <span>گردشگری</span>
                                </div>
                                <div class="inline-block col-xs-3">
                                    <span >درجه سختی:</span>
                                    <span>ساده</span>
                                </div>
                                {{--@endif--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="atf_meta_and_photos_wrapper" style="position: relative;">
            <div class="atf_meta_and_photos ui_container is-mobile easyClear" style="position: relative;">
                {{--@if($placeMode == "hotel")--}}
                {{--<div id="bestPrice" class="meta"--}}
                {{--style="position: relative; @if(session('goDate') != null && session('backDate') != null) display: none @endif ">--}}
                {{--<div id="targetHelp_9" class="targets " style="float: left">--}}
                {{--@if($place->reserveId == null)--}}
                {{--<div style="width: 100%; height: 100%; position: absolute; z-index: 9; background-color: #000000cf; display: flex; justify-content: center; align-items: center;">--}}
                {{--<div style="color: white; font-size: 20px; font-weight: bold; text-align: center; padding: 0 20px; direction: rtl;">--}}
                {{--متاسفانه در حال حاضر امکان رزرو انلاین برای این مرکز موجود نمی باشد.--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--@endif--}}
                {{--<div class="meta_inner">--}}
                {{--<form id="form_hotel" method="post" action="{{route('makeSessionHotel')}}">--}}
                {{--{{csrf_field()}}--}}
                {{--<input type="hidden" name="adult" id="form_adult">--}}
                {{--<input type="hidden" name="room" id="form_room">--}}
                {{--<input type="hidden" name="children" id="form_children">--}}
                {{--<input type="hidden" name="goDate" id="form_goDate">--}}
                {{--<input type="hidden" name="backDate" id="form_backDate">--}}
                {{--<input type="hidden" name="ageOfChild" id="form_ageOfChild">--}}
                {{--<input type="hidden" name="city"--}}
                {{--value="{{$city->name}}"--}}
                {{-->--}}
                {{--<input type="hidden" name="name"--}}
                {{--value="{{$city->name}}"--}}
                {{-->--}}
                {{--<input type="hidden" name="mode" value="city">--}}
                {{--<input type="hidden" name="name"--}}
                {{--value="{{$place->name}}"--}}
                {{-->--}}
                {{--<input type="hidden" name="id"--}}
                {{--value="{{$place->id}}"--}}
                {{-->--}}
                {{--</form>--}}
                {{--<div class="ppr_rup ppr_priv_hr_atf_north_star_traveler_info_nostalgic">--}}
                {{--<div class="title" style="color: #a3513d;">بهترین قیمت اقامت</div>--}}
                {{--<div class="metaDatePicker easyClear">--}}
                {{--<div class="prw_rup prw_datepickers_hr_north_star_dates_nostalgic"--}}
                {{--style="border:2px solid #e5e5e5; border-radius: 10px; width: 80%; margin: 0 auto">--}}
                {{--<label class="lableCalender" style="margin-left: 0 !important;">--}}
                {{--<span onclick="changeTwoCalendar(2); nowCalendar()"--}}
                {{--class="ui_icon calendar calendarIcon"></span>--}}
                {{--<input name="GoDate" type="text" id="goDate" placeholder="تاریخ رفت"--}}
                {{--class="inputLableCalender" readonly value="{{session('goDate')}}">--}}
                {{--</label>--}}
                {{--<label class="lableCalender" style="margin-right: 0 !important;">--}}
                {{--<span class="ui_icon calendar"></span>--}}
                {{--<input value="{{session('backDate')}}" name="BackDate" type="text"--}}
                {{--id="backDate"--}}
                {{--placeholder="تاریخ برگشت" readonly class="inputLableCalender">--}}
                {{--</label>--}}

                {{--<style>--}}
                {{--td {--}}
                {{--width: 14% !important;--}}
                {{--}--}}
                {{--</style>--}}
                {{--<div style="width: 1100px; position: absolute; left: -40%; top: 90%;">--}}
                {{--@include('layouts.calendar')--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="roomBox">--}}
                {{--<div class="shTIcon passengerIcon"--}}
                {{--style="font-size: 25px; display: inline-block; cursor: pointer;"--}}
                {{--onclick="togglePassengerNoSelectPane()"></div>--}}
                {{--<div id="roomDetail"--}}
                {{--style="font-size: 1.1em; display: inline-block; cursor: pointer;"--}}
                {{--onclick="togglePassengerNoSelectPane()">--}}
                {{--<span class="room" id="num_room">--}}{{--{{$room}}--}}{{--</span>&nbsp;--}}
                {{--<span>اتاق</span>&nbsp;-&nbsp;--}}
                {{--<span class="adult" id="num_adult">--}}{{--{{$adult}}--}}{{--</span>--}}
                {{--<span>بزرگسال</span>&nbsp;--}}
                {{--<span class="children" id="num_child">--}}{{----}}{{--{{$children}}--}}{{----}}{{--</span>--}}
                {{--<span>بچه</span>&nbsp;--}}
                {{--</div>--}}
                {{--<div id="passengerArrowDown" onclick="togglePassengerNoSelectPane()"--}}
                {{--class="shTIcon searchBottomArrowIcone arrowPassengerIcone"--}}
                {{--style="display: inline-block;"></div>--}}
                {{--<div id="passengerArrowUp" onclick="togglePassengerNoSelectPane()"--}}
                {{--class="shTIcon searchTopArrowIcone arrowPassengerIcone hidden"--}}
                {{--style="display: inline-block;"></div>--}}

                {{--<div class="roomPassengerPopUp hidden" id="passengerNoSelectPane"--}}
                {{--onmouseleave="addClassHidden('passengerNoSelectPane'); passengerNoSelect = false;">--}}
                {{--<div class="rowOfPopUp">--}}
                {{--<span style="float: right;">اتاق</span>--}}
                {{--<div style="float: left; margin-right: 25px;">--}}
                {{--<div onclick="changeRoomPassengersNum(-1, 3)"--}}
                {{--class="shTIcon minusPlusIcons minus"></div>--}}
                {{--<span class='numBetweenMinusPlusBtn room'--}}
                {{--id="roomNumInSelect">--}}{{--{{$room}}--}}{{--</span>--}}
                {{--<div onclick="changeRoomPassengersNum(1, 3)"--}}
                {{--class="shTIcon minusPlusIcons plus"></div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rowOfPopUp">--}}
                {{--<span style="float: right;">بزرگسال</span>--}}
                {{--<div style="float: left">--}}
                {{--<div onclick="changeRoomPassengersNum(-1, 2)"--}}
                {{--class="shTIcon minusPlusIcons minus"></div>--}}
                {{--<span class='numBetweenMinusPlusBtn adult'--}}
                {{--id="adultPassengerNumInSelect">--}}{{--{{$adult}}--}}{{--</span>--}}
                {{--<div onclick="changeRoomPassengersNum(1, 2)"--}}
                {{--class="shTIcon minusPlusIcons plus"></div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="rowOfPopUp">--}}
                {{--<span style="float: right;">بچه</span>--}}
                {{--<div style="float: left">--}}
                {{--<div onclick="changeRoomPassengersNum(-1, 1)"--}}
                {{--class="shTIcon minusPlusIcons minus"></div>--}}
                {{--<span class='numBetweenMinusPlusBtn children'--}}
                {{--id="childrenPassengerNumInSelect">--}}{{----}}{{--{{$children}}--}}{{----}}{{--</span>--}}
                {{--<div onclick="changeRoomPassengersNum(1, 1)"--}}
                {{--class="shTIcon minusPlusIcons plus"></div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="childrenPopUpAlert">سن بچه را در زمان ورود به هتل وارد--}}
                {{--کنید--}}
                {{--</div>--}}
                {{--<div class="childBox"></div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div class="srchBox">--}}
                {{--<button class="srchBtn" onclick="inputSearch(0)">جستجو و رزرو</button>--}}
                {{--</div>--}}
                {{--<div class="explainSrch">--}}
                {{--با جستجو در بین سایر ارایه دهندگان خدمات، بهترین قیمت را از بین تمامی قیمت--}}
                {{--های موجود در بازار به شما پیشنهاد می دهیم.--}}
                {{--</div>--}}
                {{--<div class="explainRoom">--}}
                {{--** قیمت های ارایه شده بر اساس قیمت ارزان ترین اتاق و برای یک شب اقامت ارایه--}}
                {{--می گردد. ممکن است با توجه به نوع اتاق انتخابی و تعداد نفرات این قیمت متغیر--}}
                {{--باشد.--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<div id="helpSpan_9" class="helpSpans hidden">--}}
                {{--<span class="introjs-arrow"></span>--}}
                {{--<p>در این قسمت هتل خود را به سادگی چند دکمه رزرو کنید. البته این سیستم برای ما آنچنان--}}
                {{--ساده نیست. این سرویس هنوز آماده استفاده نمی باشد.</p>--}}
                {{--<button data-val="9" class="btn btn-success nextBtnsHelp" id="nextBtnHelp_9">بعدی</button>--}}
                {{--<button data-val="9" class="btn btn-primary backBtnsHelp" id="backBtnHelp_9">قبلی</button>--}}
                {{--<button class="btn btn-danger exitBtnHelp">خروج</button>--}}
                {{--</div>--}}
                {{--</div>--}}
                <div id="bestPriceRezerved" class="meta"
                     style="position: relative">
                    <div id="targetHelp_9" class="targets" style="float: left">
                        {{--@if($place->reserveId == null)--}}
                        {{--<div style="width: 100%; height: 100%; position: absolute; z-index: 9; display: flex; justify-content: center; align-items: center;">--}}
                        {{--<div style="color: white; font-size: 20px; font-weight: bold; text-align: center; padding: 0 20px; direction: rtl;">--}}
                        {{--متاسفانه در حال حاضر امکان رزرو انلاین برای این مرکز موجود نمی باشد.--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--@endif--}}
                        {{--@if(session('goDate') != null)--}}
                        <div class="meta_inner">
                            <div class="ppr_rup ppr_priv_hr_atf_north_star_traveler_info_nostalgic">
                                <div class="metaDatePicker easyClear">
                                    {{--<div style="border-bottom: 1.5px solid #e5e5e5">--}}
                                    {{--<style>--}}
                                    {{--.closeXicon2:before{--}}
                                    {{--position: absolute !important;--}}
                                    {{--top: 10px !important;--}}
                                    {{--}--}}
                                    {{--</style>--}}
                                    {{--<div class="shTIcon closeXicon closeXicon2"--}}
                                    {{--onclick="changeStatetounReserved()"></div>--}}
                                    {{--<div class="prw_rup prw_datepickers_hr_north_star_dates_nostalgic"--}}
                                    {{--style="width: 70%;">--}}
                                    {{--<label class="lableCalender"--}}
                                    {{--style="margin: 6px 0 6px 6px !important;">--}}
                                    {{--<span class="ui_icon calendar"></span>--}}
                                    {{--<input type="text" id="date_input"--}}
                                    {{--placeholder="{{session('goDate')}}"--}}
                                    {{--class="inputLableCalender">--}}
                                    {{--</label>--}}
                                    {{--<label class="lableCalender"--}}
                                    {{--style="margin: 6px 0 6px 6px !important;">--}}
                                    {{--<span class="ui_icon calendar"></span>--}}
                                    {{--<input type="text" id="date_input_end_inHotel"--}}
                                    {{--placeholder="{{session('backDate')}}"--}}
                                    {{--class="inputLableCalender">--}}
                                    {{--</label>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    <div class="offerBox">
                                        <b>نکات کلیدی تور</b>
                                        <p>
                                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از
                                            طراحان گرافیک است.
                                        </p>
                                        <p>
                                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از
                                            طراحان گرافیک است.
                                        </p>
                                        <p>
                                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از
                                            طراحان گرافیک است.
                                        </p>
                                        <p>
                                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از
                                            طراحان گرافیک است.
                                        </p>
                                        <p>
                                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از
                                            طراحان گرافیک است.
                                        </p>
                                    </div>

                                    <div class="offerBox" id="tourDetailsBottomBox">
                                        <div class="tourDescription col-xs-6">
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
                                                        <div>1 امتیاز</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <center>
                                                <hr id="tourExpDivider">
                                            </center>
                                            <center id="tourExpDiscountAlerts" class="discountAlerts">
                                                <span class="full-width">10 درصد تخفیف ثبت نام گروهی</span>
                                                <span class="full-width">تخفیف ویژه کودکان</span>
                                                <span class="full-width">10 درصد تخفیف ویژه نوروز</span>
                                            </center>
                                        </div>
                                        <div class="tourPriceDescription col-xs-5">
                                            <center>
                                                <b class="offerPrice">شروع قیمت از 650.000
                                                    <div class="salePrice">
                                                        550.000
                                                    </div>
                                                </b>
                                                <div class="offerDiscountExp" >
                                                    <div>ده درصد تخفیف ذخیره</div>
                                                </div>
                                                <div>
                                                    <button class="btn viewOffersBtn" type="button">خرید</button>
                                                </div>

                                            </center>
                                        </div>

                                    </div>

                                    {{--<div class="offerBox">--}}
                                        {{--<div>--}}
                                            {{--<div style="font-size: 1.4em; display: inline-block; line-height: 40px;">--}}
                                                {{--650.000--}}
                                            {{--</div>--}}
                                            {{--<div style="float: left">--}}
                                                {{--<div style="float:right; margin: 2px 10px;">--}}
                                                    {{--<div>از علی بابا</div>--}}
                                                    {{--<img src="" alt="">--}}
                                                {{--</div>--}}
                                                {{--<button class="btn viewOffersBtn" type="button">انتخاب</button>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                    <div class="hidden other10_Offer">به همراه
                                        {{--{{$place->otherRoom}}--}}
                                        پیشنهاد دیگر
                                    </div>

                                    {{--<div class="explainRoom">--}}
                                    {{--** قیمت های ارایه شده بر اساس قیمت ارزان ترین اتاق و برای یک شب اقامت--}}
                                    {{--ارایه--}}
                                    {{--می گردد. ممکن است با توجه به نوع اتاق انتخابی و تعداد نفرات این قیمت--}}
                                    {{--متغیر--}}
                                    {{--باشد.--}}
                                    {{--</div>--}}
                                </div>
                            </div>
                        </div>
                        {{--@endif--}}
                    </div>
                    <div id="fastReserveTour3" class="fastReserveTour">رزرو آنی</div>
                    <div id="helpSpan_9" class="helpSpans hidden">
                        <span class="introjs-arrow"></span>
                        <p>در این قسمت هتل خود را به سادگی چند دکمه رزرو کنید. البته این سیستم برای ما آنچنان
                            ساده نیست. این سرویس هنوز آماده استفاده نمی باشد.</p>
                        <button data-val="9" class="btn btn-success nextBtnsHelp" id="nextBtnHelp_9">بعدی</button>
                        <button data-val="9" class="btn btn-primary backBtnsHelp" id="backBtnHelp_9">قبلی</button>
                        <button class="btn btn-danger exitBtnHelp">خروج</button>
                    </div>
                </div>
                {{--@endif--}}
                <div class="prw_rup prw_common_location_photos photos" style="position: relative;">
                    <div id="targetHelp_10" class="targets" style="height: 400px;">
                        <div class="inner" style="max-width: 1000px; max-height: 338px;">
                            <div class="primaryWrap">
                                <div class="prw_rup prw_common_mercury_photo_carousel">
                                    <div class="carousel bignav" style="max-height: 338px;">
                                        <div class="carousel_images carousel_images_header">
                                            <div class="see_all_count_wrap" onclick="getPhotos(-1)">
                                                <span class="see_all_count"
                                                      {{--style="width:100px; height:100px; border: 1px solid black"--}}
                                                >
                                                    <span class="ui_icon camera"></span>
                                                    تمام عکس ها
                                                    {{--{{$userPhotos + $sitePhotos}} --}}
                                                </span>
                                            </div>
                                            <div class="entry_cta_wrap">
                                                <span class="entry_cta"><span class="ui_icon expand"></span>اندازه بزرگ عکس </span>
                                            </div>
                                        </div>
                                        <div onclick="photoRoundRobin(-1)" class="left-nav left-nav-header"></div>
                                        <div onclick="photoRoundRobin(1)" class="right-nav right-nav-header"></div>
                                    </div>
                                    <div id="mustSeeTour3" class="mustSeeTour">باید دید</div>
                                </div>

                            </div>
                            {{--<div class="secondaryWrap">--}}
                            {{--<div class="tileWrap" style="height:33.333332%;">--}}
                            {{--<div class="prw_rup prw_hotels_flexible_album_thumb tile">--}}
                            {{--<div class="albumThumbnail">--}}
                            {{--<div class="prw_rup prw_common_centered_image">--}}
                            {{--@if($sitePhotos != 0)--}}
                            {{--<span onclick="getPhotos(-1)" class="imgWrap"--}}
                            {{--style="max-width:200px;max-height:113px;">--}}
                            {{--<img--}}
                            {{--alt="{{$place->alt1}}" src="{{$thumbnail}}"--}}
                            {{--class="centeredImg" style=" min-width:152px; "--}}
                            {{--width="100%"/>--}}
                            {{--</span>--}}
                            {{--@else--}}
                            {{--<span class="imgWrap"--}}
                            {{--style="max-width:200px;max-height:113px;">--}}

                            {{--</span>--}}
                            {{--@endif--}}
                            {{--</div>--}}
                            {{--@if($sitePhotos != 0)--}}
                            {{--<div onclick="getPhotos(-2)" class="albumInfo">--}}
                            {{--<span class="ui_icon camera">&nbsp;</span>عکس های--}}
                            {{--سایت {{$sitePhotos}}--}}
                            {{--</div>--}}
                            {{--@else--}}
                            {{--<div class="albumInfo">--}}
                            {{--<span class="ui_icon camera">&nbsp;</span>عکس های--}}
                            {{--سایت {{$sitePhotos}}--}}
                            {{--</div>--}}
                            {{--@endif--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="tileWrap" style="height:33.333332%;">--}}
                            {{--<div class="prw_rup prw_hotels_flexible_album_thumb tile">--}}
                            {{--<div class="albumThumbnail">--}}
                            {{--<div class="prw_rup prw_common_centered_image">--}}
                            {{--<span class="imgWrap " style="max-width:200px;max-height:113px;">--}}
                            {{--@if($userPhotos != 0)--}}
                            {{--<img onclick="getPhotos(-3)"--}}
                            {{--src="{{$logPhoto['pic']}}"--}}
                            {{--class="centeredImg" style=" min-width:152px; "--}}
                            {{--width="100%"/>--}}
                            {{--@endif--}}
                            {{--</span>--}}
                            {{--</div>--}}
                            {{--<div class="albumInfo">--}}
                            {{--{{($userPhotos != 0) ? "onclick=getPhotos(-3)" : "" }}  --}}
                            {{--class="albumInfo">--}}
                            {{--<span class="ui_icon camera">&nbsp;</span>عکس های--}}
                            {{--کاربران {{$userPhotos}}--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="tileWrap" onclick="document.location.href = '{{route('video360')}}'"--}}
                            {{--style="height:33.333332%;">--}}
                            {{--<div class="prw_rup prw_hotels_flexible_album_thumb tile">--}}
                            {{--<div class="albumThumbnail">--}}
                            {{--<div class="prw_rup prw_common_centered_image"><span class="imgWrap "--}}
                            {{--style="max-width:200px;max-height:113px;"><img--}}
                            {{--src="https://static.tacdn.com/img2/x.gif"--}}
                            {{--class="centeredImg" style=" min-width:113px; "--}}
                            {{--width="100%"/></span></div>--}}
                            {{--<div class="albumInfo"><span class="ui_icon camera">&nbsp;</span>محتواهای--}}
                            {{--تعاملی--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                        </div>
                        <div id="helpSpan_10" class="helpSpans hidden row">
                            <span class="introjs-arrow"></span>
                            <p>عکس های دوستانتان را از دست ندهید. گاهی وقت ها یک عکس سخن های بسیاری دارد.</p>
                            <button data-val="10" class="btn btn-success nextBtnsHelp" id="nextBtnHelp_10">بعدی</button>
                            <button data-val="10" class="btn btn-primary backBtnsHelp" id="backBtnHelp_10">قبلی</button>
                            <button class="btn btn-danger exitBtnHelp">خروج</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="MAINWRAP"
         class=" full_meta_photos_v3  full_meta_photos_v4  big_pic_mainwrap_tweaks horizontal_xsell ui_container is-mobile"
         style="position: relative;">
        <div id="MAIN" class="Hotel_Review prodp13n_jfy_overflow_visible" style="position: relative;">
            <div id="BODYCON" ng-app="mainApp"
                 class="col easyClear bodLHN poolB adjust_padding new_meta_chevron new_meta_chevron_v2"
                 style="position: relative;">
                <div class="col-xs-12 menu"
                     style="padding: 15px 0; height: 70px !important; text-align: center;box-shadow: 0px 4px 5px #888888;">
                    <div class="col-xs-2 changeWidth"><a href="#ansAndQeustionDiv">سوال و جواب</a></div>
                    <div class="col-xs-2 changeWidth"><a href="#nearbyDiv">مکان های نزدیک</a></div>
                    <div class="col-xs-2 changeWidth"><a href="#photosDiv">عکس ها</a></div>
                    {{--@if($placeMode == "hotel")--}}
                    <div class="col-xs-2 changeWidth"><a href="#similars">هتل های مشابه</a></div>
                    {{--@elseif($placeMode == "restaurant")--}}
                    {{--<div class="col-xs-2 changeWidth"><a href="#similars">رستوران های مشابه</a></div>--}}
                    {{--@elseif($placeMode == "amaken")--}}
                    {{--<div class="col-xs-2 changeWidth"><a href="#similars">اماکن مشابه</a></div>--}}
                    {{--@endif--}}
                    <div class="col-xs-2 changeWidth"><a href="#reviewsDiv">نقدها</a></div>
                    {{--@if(session('goDate') != null)--}}
                    {{--<div class="col-xs-2 changeWidth"><a href="#roomChoice">انتخاب اتاق</a></div>--}}
                    {{--@endif--}}
                    <div class="col-xs-2  changeWidth"><a href="#introduction">معرفی کلی</a></div>
                </div>
                <div style="height: 90px;background-color: rgb(248,248,248);"></div>
                <div class="hr_btf_wrap" style="position: relative;">
                    <div id="introduction" class="ppr_rup ppr_priv_location_detail_overview">
                        <div class="block_wrap" data-tab="TABS_OVERVIEW">

                            <div style="margin: 15px 0 !important;">
                                <div id="showMore" onclick="showMore()"
                                     style="float: left; cursor: pointer;color:var(--koochita-light-green); font-size: 13px;"
                                     class="hidden">بیشتر
                                </div>
                                <div class="overviewContent" id="introductionText"
                                     style="direction: rtl; font-size: 14px; max-height: 21px; overflow: hidden;">
                                    {{--{{$place->description}}--}}
                                </div>
                            </div>
                            <div class="overviewContent">
                                <div class="ui_columns is-multiline is-mobile reviewsAndDetails" style="direction: ltr;">
                                    <div class="ui_column is-8 details">
                                        <div id="tourScheduleDetailsMainDiv" class="full-width inline-block">
                                            <div id="tourSchedulePeriodDetails" class="col-xs-6">
                                                <span>از</span>
                                                <span>تاریخ شروع</span>
                                                <span onclick="changeTwoCalendar(2); nowCalendar()" class="ui_icon calendar calendarIcon"></span>
                                                <span>تا</span>
                                                <span>تاریخ پایان</span>
                                                <div class="full-width inline-block">
                                                    <span>این تور در تاریخ‌های متفاوتی ارائه می‌گردد</span>
                                                </div>
                                            </div>
                                            <div id="tourScheduleDayCounterDiv" class="col-xs-6">
                                                <span>چند</span>
                                                <span>روز و</span>
                                                <span>چند</span>
                                                <span>شب</span>
                                                <div class="full-width inline-block">
                                                    <span>چند روز آخر هفته و چند روز کاری و چند روز تعطیل</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="tourTransportationDetailsMainDiv" class="full-width inline-block">
                                            <div class="block_header" style="border: none; padding: 0 0 7px 0; margin: 0 ">
                                                <h4 class="block_title" style="padding-bottom: 10px; font-size: 18px">حمل و نقل اصلی</h4>
                                            </div>
                                            <table class="tourTransportationDetails full-width">
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
                                                    <td>اتوبوس لوکس</td>
                                                    <td>21:45 - 23/11/97</td>
                                                    <td>میدان آرژانتین</td>
                                                    <td>اتوبوس لوکس با کولر و غیره</td>
                                                    <td><button>نقشه</button></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>اتوبوس لوکس</td>
                                                    <td>21:45 - 23/11/97</td>
                                                    <td>میدان آرژانتین</td>
                                                    <td>اتوبوس لوکس با کولر و غیره</td>
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
                                                            <span class="ui_bubble_rating bubble_50" style="font-size:16px;"
                                                                  property="ratingValue" content="5" alt='5 of 5 bubbles'>
                                                            </span>
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
                                                            <span style="font-size: 12px;">
                                                                شیراز، خیابان شیرازی
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        +650000
                                                    </td>
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
                                                            <span class="ui_bubble_rating bubble_50" style="font-size:16px;"
                                                                  property="ratingValue" content="5" alt='5 of 5 bubbles'>
                                                            </span>
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
                                                            <span style="font-size: 12px;">
                                                                شیراز، خیابان شیرازی
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        +650000
                                                    </td>
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
                                            <table class="tourMoreOptionsDetails full-width">
                                                <tr>
                                                    <th></th>
                                                    <th>نام مکان</th>
                                                    <th>توضیحات</th>
                                                    <th>افزایش قیمت</th>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class=" ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem ">
                                                            <input ng-model="sort" type="radio" id="ct1" value="rate" class="ng-pristine ng-untouched ng-valid ng-not-empty" name="6">
                                                            <label for="ct1"><span></span></label>
                                                        </div>
                                                    </td>
                                                    <td>بازدید از امکان لورم</td>
                                                    <td>بازدید از امکان لورم با استفاده از تور لیدر اختصاصی افزایش قیمت</td>
                                                    <td>+650.000</td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <div class=" ui_input_checkbox filterItem lhrFilter filter establishmentTypeFilters establishmentTypeFilters_10591 selected 0 index_0 alwaysShowItem ">
                                                            <input ng-model="sort" type="radio" id="ct2" value="rate" class="ng-pristine ng-untouched ng-valid ng-not-empty" name="6">
                                                            <label for="ct2"><span></span></label>
                                                        </div>
                                                    </td>
                                                    <td>بازدید از امکان لورم</td>
                                                    <td>بازدید از امکان لورم با استفاده از تور لیدر اختصاصی افزایش قیمت</td>
                                                    <td>+650.000</td>
                                                </tr>
                                            </table>

                                        </div>
                                        <div id="tourRestInfosMainDiv" class="full-width inline-block">
                                            <div id="tourStartEndPoint" class="col-xs-3">
                                                <span>مقصد: </span>
                                                <span>مقصد</span>
                                                <span>حرکت از: </span>
                                                <span>مبدأ</span>
                                            </div>
                                            <div id="tourStartEndTime" class="col-xs-4">
                                                <span>از: </span>
                                                <span>تاریخ شروع</span>
                                                <span>تا: </span>
                                                <span>تاریخ پایان</span>
                                            </div>
                                            <div id="tourPeriodTime" class="col-xs-2">
                                                <span>چند </span>
                                                <span>روز و </span>
                                                <span>چند </span>
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
                                                    <b>650000</b>
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
                                            <span>
                                                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطر آنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می‌باشد.
                                            </span>
                                        </div>
                                        <div id="specificInfosDiv" class="full-width inline-block tourOrganizerBoxes">
                                            <div class="full-width inline-block">
                                                <b class="inline-block">اطلاعات اختصاصی</b>
                                                <span class="inline-block">این قسمت توسط برگزار کننده تکمیل شده است</span>
                                            </div>
                                            <span>
                                                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطر آنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می‌باشد.
                                            </span>
                                        </div>
                                        <div id="betterTourSuggestionsDiv" class="full-width inline-block tourOrganizerBoxes">
                                            <div class="full-width inline-block">
                                                <b class="inline-block">پیشنهادات برای سفر بهتر</b>
                                                <span class="inline-block">این قسمت توسط برگزار کننده تکمیل شده است</span>
                                            </div>
                                            <span>
                                                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطر آنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می‌باشد.
                                            </span>
                                        </div>
                                        <div id="tourLimitationsDiv" class="full-width inline-block tourOrganizerBoxes">
                                            <div class="full-width inline-block">
                                                <b class="inline-block">محدودیت های سفر</b>
                                                <span class="inline-block">این قسمت توسط برگزار کننده تکمیل شده است</span>
                                            </div>
                                            <span>
                                                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطر آنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می‌باشد.
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ui_column  is-4" style="border-left: 2px solid #e5e5e5;">
                                        <div class="block_header" style="border: none; padding: 0 0 7px 0; margin: 0 ">
                                            <h3 class="block_title" style="padding-bottom: 10px;; font-size: 18px">معرفی کلی </h3>
                                        </div>
                                        <div class="tourAbstract">
                                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطر آنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای

                                            <a class="seeAllReviews autoResize" href="#REVIEWS"></a>
                                        </div>
                                        <div class="tourExpDetails">
                                            <div class="tourDetailsTitles col-xs-6">
                                                <span>حرکت از</span>
                                                <span>: مبداء</span>
                                            </div>
                                            <div class="tourDetailsTitles col-xs-6">
                                                <span>مقصد</span>
                                                <span>: مقصد</span>
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
                                                <span>طبیعت‌گردی، خانواده، عکاسی، طبیعت‌گردی</span>
                                            </div>
                                            <div class="tourDetailsTitles col-xs-12">
                                                <span>تیپ تور</span>
                                                <span>گروهی، بازی، دونفره، ماه عسل</span>
                                            </div>
                                            <div class="tourDetailsTitles col-xs-6">
                                                <span>فصل مناسب</span>
                                                <span>بهار</span>
                                            </div>
                                            <div class="tourDetailsTitles col-xs-6">
                                                <span>نوع تور</span>
                                                <span>خصوصی</span>
                                            </div>
                                            <div class="tourDetailsTitles col-xs-6">
                                                <span>رفت و آمد محلی</span>
                                                <span>اتوبوس - ماشین</span>
                                            </div>
                                            <div class="tourDetailsTitles col-xs-6">
                                                <span>پذیرایی</span>
                                                <span>صبحانه - نهار</span>
                                            </div>
                                            <div class="tourDetailsTitles col-xs-6">
                                                <span>زبان تور</span>
                                                <span>فارسی</span>
                                            </div>
                                            <div class="tourDetailsTitles col-xs-6">
                                                <span>نوع بیمه</span>
                                                <span>ندارد</span>
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
{{--                                        <hr class="inline-block tourDetailsBoxDivider">--}}
                                        {{--<div>--}}
                                            {{--<h3 style="direction: rtl; padding: 8px 0;">برچسب ها:</h3>--}}
                                            {{--<span class="tag">{{$place->tag1}}</span>--}}
                                            {{--<span class="tag">{{$place->tag2}}</span>--}}
                                            {{--<span class="tag">{{$place->tag3}}</span>--}}
                                            {{--<span class="tag">{{$place->tag4}}</span>--}}
                                            {{--<span class="tag">{{$place->tag5}}</span>--}}
                                            {{--<span class="tag">{{$place->tag6}}</span>--}}
                                            {{--<span class="tag">{{$place->tag7}}</span>--}}
                                            {{--<span class="tag">{{$place->tag8}}</span>--}}
                                            {{--<span class="tag">{{$place->tag9}}</span>--}}
                                            {{--<span class="tag">{{$place->tag10}}</span>--}}
                                            {{--<span class="tag">{{$place->tag11}}</span>--}}
                                            {{--<span class="tag">{{$place->tag12}}</span>--}}
                                            {{--<span class="tag">{{$place->tag13}}</span>--}}
                                            {{--<span class="tag">{{$place->tag14}}</span>--}}
                                            {{--<span class="tag">{{$place->tag15}}</span>--}}
                                        {{--</div>--}}
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
                                        <div class="circle-container">
                                            <div class="quarter top-left"></div>
                                            <div class="quarter top-right"></div>
                                            <div class="quarter bottom-left none-border"></div>
                                            <div class="quarter bottom-right none-border"></div>
                                            <div class="fill-circle"></div>
                                            <div class="dot pu-dot first-dot">
                                                <div class="tourDailyScheduleTitles">تهران</div>
                                                <div class="tourDailyScheduleTime">12:30</div>
                                            </div>
                                            <div class="dot o-dot top-dot">
                                                <div class="tourDailyScheduleTitles">اتوبوس</div>
                                                <div class="tourDailyScheduleTime"></div>
                                            </div>
                                        </div>
                                        <div class="circle-container">
                                            <div class="quarter top-left none-border"></div>
                                            <div class="quarter top-right none-border"></div>
                                            <div class="quarter bottom-left"></div>
                                            <div class="quarter bottom-right"></div>
                                            <div class="fill-circle"></div>
                                            <div class="dot pi-dot first-dot">
                                                <div class="tourDailyScheduleTitles">رستوران خوش غذا</div>
                                                <div class="tourDailyScheduleTime">14:30</div>
                                            </div>
                                            <div class="dot pu-dot bottom-dot">
                                                <div class="tourDailyScheduleTitles">سمنان</div>
                                                <div class="tourDailyScheduleTime">15:30</div>
                                            </div>
                                        </div>
                                        <div class="circle-container">
                                            <div class="quarter top-left"></div>
                                            <div class="quarter top-right"></div>
                                            <div class="quarter bottom-left none-border"></div>
                                            <div class="quarter bottom-right none-border"></div>
                                            <div class="fill-circle"></div>
                                            <div class="dot b-dot first-dot">
                                                <div class="tourDailyScheduleTitles">مسجد</div>
                                                <div class="tourDailyScheduleTime">16:00</div>
                                            </div>
                                            <div class="dot b-dot top-dot">
                                                <div class="tourDailyScheduleTitles">کویر</div>
                                                <div class="tourDailyScheduleTime">16:40</div>
                                            </div>
                                        </div>
                                        <div class="circle-container">
                                            <div class="quarter top-left none-border"></div>
                                            <div class="quarter top-right none-border"></div>
                                            <div class="quarter bottom-left"></div>
                                            <div class="quarter bottom-right"></div>
                                            <div class="fill-circle"></div>
                                            <div class="dot pu-dot first-dot">
                                                <div class="tourDailyScheduleTitles">شاهرود</div>
                                                <div class="tourDailyScheduleTime"></div>
                                            </div>
                                            <div class="dot b-dot bottom-dot">
                                                <div class="tourDailyScheduleTitles">آرامگاه</div>
                                                <div class="tourDailyScheduleTime"></div>
                                            </div>
                                        </div>
                                        <div class="circle-container">
                                            <div class="quarter top-left"></div>
                                            <div class="quarter top-right"></div>
                                            <div class="quarter bottom-left none-border"></div>
                                            <div class="quarter bottom-right none-border"></div>
                                            <div class="fill-circle"></div>
                                            <div class="dot pu-dot first-dot">
                                                <div class="tourDailyScheduleTitles">بسطام</div>
                                                <div class="tourDailyScheduleTime"></div>
                                            </div>
                                            <div class="dot g-dot top-dot">
                                                <div class="tourDailyScheduleTitles">جشنواره گل و گلاب</div>
                                                <div class="tourDailyScheduleTime"></div>
                                            </div>
                                        </div>
                                        <div class="circle-container">
                                            <div class="quarter top-left none-border"></div>
                                            <div class="quarter top-right none-border"></div>
                                            <div class="quarter bottom-left"></div>
                                            <div class="quarter bottom-right"></div>
                                            <div class="fill-circle"></div>
                                            <div class="dot pu-dot first-dot">
                                                <div class="tourDailyScheduleTitles">خرقان</div>
                                                <div class="tourDailyScheduleTime"></div>
                                            </div>
                                            <div class="dot o-dot bottom-dot">
                                                <div class="tourDailyScheduleTitles">آفرود</div>
                                                <div class="tourDailyScheduleTime"></div>
                                            </div>
                                            <div class="dot y-dot last-dot">
                                                <div class="tourDailyScheduleTitles">هتل تو و من</div>
                                                <div class="tourDailyScheduleTime"></div>
                                            </div>
                                        </div>
                                        <div class="tourDailyScheduleGuideMainDiv">
                                            <div class="tourDailyScheduleGuideBoxes">اقامت
                                                <div class="tourScheduleGuideColor circleBase type2"></div>
                                            </div>
                                            <div class="tourDailyScheduleGuideBoxes">رویداد
                                                <div class="tourScheduleGuideColor circleBase type2"></div>
                                            </div>
                                            <div class="tourDailyScheduleGuideBoxes">غذا
                                                <div class="tourScheduleGuideColor circleBase type2"></div>
                                            </div>
                                            <div class="tourDailyScheduleGuideBoxes">جاذبه
                                                <div class="tourScheduleGuideColor circleBase type2"></div>
                                            </div>
                                            <div class="tourDailyScheduleGuideBoxes">شهر
                                                <div class="tourScheduleGuideColor circleBase type2"></div>
                                            </div>
                                            <div class="tourDailyScheduleGuideBoxes">رفت و آمد
                                                <div class="tourScheduleGuideColor circleBase type2"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ui_column  is-12" style="border-bottom: 2px solid #e5e5e5; margin-top: 20px">
                                        <div class="block_header tourBlockHeaders" style="border: none; padding: 0 0 7px 0; margin: 0 ">
                                            <h3 class="block_title inline-block full-width" style="padding-bottom: 5px; font-size: 18px">لوازم ضروری </h3>
                                            <span>داشتن این لوازم برای حضور در تور ضروری است و به همراه نداشتن آن‌ها ممکن است در سفر شما اختلال ایجاد نماید.</span>
                                        </div>
                                        <div class="inline-block essentialEquipments">کارت ملی</div>
                                        <div class="inline-block essentialEquipments">بلیط</div>
                                        <div class="inline-block essentialEquipments">لباس گرم</div>
                                    </div>
                                    <div class="ui_column  is-12" style="border-bottom: 2px solid #e5e5e5; margin-top: 20px">
                                        <div class="block_header tourBlockHeaders" style="border: none; padding: 0 0 7px 0; margin: 0 ">
                                            <h3 class="block_title inline-block full-width" style="padding-bottom: 5px; font-size: 18px">لوازم پیشنهادی </h3>
                                            <span>به همراه داشتن این لوازم تجربه شما از تور را زیباتر و دلپذیرتر می‌کند.</span>
                                        </div>
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
                        {{--@endif--}}
                        <div id="reviewsDiv" class="ppr_rup ppr_priv_location_detail_two_column"
                             style="position: relative;">
                            <div class="column_wrap ui_columns is-mobile"
                                 style="width: 100%; direction: rtl; position: relative;">
                                <div class="content_column ui_column is-8"
                                     style="margin-top: 20px; position: relative;">
                                    <div class="ppr_rup ppr_priv_location_reviews_container" style="position: relative">
                                        <div id="REVIEWS" class="ratings_and_types concepts_and_filters block_wrap"
                                             style="position: relative">
                                            <div class="header_group block_header" style="position: relative">
                                                <div id="targetHelp_11" class="targets row"
                                                     style="max-width: 100px; float: left">
                                                <span style="color: #FFF !important;"
                                                      {{--onclick="showAddReviewPageHotel('{{route('review', ['placeId' => $place->id, 'kindPlaceId' => $kindPlaceId])}}')"--}}
                                                      class="button_war write_review ui_button primary col-xs-12">نوشتن نقد</span>
                                                    <div id="helpSpan_11" class="helpSpans hidden">
                                                        <span class="introjs-arrow"></span>
                                                        <p>اگر تجربه ای از این مکان دارید به ما بگویید تا دوستانتان هم
                                                            ببینند. در ضمن برای هر نقد امتیاز هیجان انگیزی می
                                                            گیرید. </p>
                                                        <button data-val="11" class="btn btn-success nextBtnsHelp"
                                                                id="nextBtnHelp_11">بعدی
                                                        </button>
                                                        <button data-val="11" class="btn btn-primary backBtnsHelp"
                                                                id="backBtnHelp_11">قبلی
                                                        </button>
                                                        <button class="btn btn-danger exitBtnHelp">خروج</button>
                                                    </div>
                                                </div>
                                                <h3 class="tabs_header reviews_header block_title"> نقدها <span
                                                            class="reviews_header_count block_title"></span></h3>
                                            </div>
                                            <div id="targetHelp_12" class="targets">
                                                <div ID="taplc_location_review_filter_controls_hotels_0"
                                                     class="ppr_rup ppr_priv_location_review_filter_controls">
                                                    <div id="filterControls" class="with_histogram">
                                                        <div class="main ui_columns is-mobile">
                                                            <div id="ratingFilter" class="ui_column is-5 rating">
                                                                <div class="colTitle">امتیاز</div>
                                                                <ul>
                                                                    <li class="filterItem">
                                                                    <span class="toggle">
                                                                        <div class='ui_input_checkbox'>
                                                                            <input onclick="filter()" id="excellent"
                                                                                   type="checkbox"
                                                                                   name="filterComment[]" value="rate_5"
                                                                                   class="filterInput">

                                                                            <label class='labelForCheckBox'
                                                                                   for='excellent'>
                                                                                <span></span>&nbsp;&nbsp;
                                                                            </label>
                                                                        </div>
                                                                    </span>
                                                                        <label class="filterLabel">
                                                                            <div class="row_label">عالی</div>
                                                                        <span class="row_bar">
                                                                            <span class="row_fill"
                                                                                    {{--style="width:{{$rates[4] * 100 / $total}}%;"--}}
                                                                            ></span>
                                                                        </span>
                                                                            <span>
                                                                                {{--{{$rates[4]}}--}}
                                                                            </span>
                                                                        </label>
                                                                    </li>

                                                                    <li class="filterItem">
                                                                    <span class="toggle">
                                                                        <div class='ui_input_checkbox'>
                                                                            <input onclick="filter()" type="checkbox"
                                                                                   id="very_good" name="filterComment[]"
                                                                                   value="rate_4" class="filterInput">

                                                                            <label class='labelForCheckBox'
                                                                                   for='very_good'>
                                                                                <span></span>&nbsp;&nbsp;
                                                                            </label>
                                                                        </div>
                                                                    </span>

                                                                        <label class="filterLabel">
                                                                            <div class="row_label">خوب</div>
                                                                        <span class="row_bar">
                                                                            <span class="row_fill"
                                                                                    {{--style="width:{{$rates[3] * 100 / $total}}%;"--}}
                                                                            ></span>
                                                                        </span>
                                                                            <span>
                                                                                {{--{{$rates[3]}}--}}
                                                                            </span>
                                                                        </label>
                                                                    </li>

                                                                    <li class="filterItem">
                                                                    <span class="toggle">
                                                                        <div class='ui_input_checkbox'>
                                                                           <input onclick="filter()" type="checkbox"
                                                                                  id="average" name="filterComment[]"
                                                                                  value="rate_3" class="filterInput">

                                                                            <label class='labelForCheckBox'
                                                                                   for='average'>
                                                                                <span></span>&nbsp;&nbsp;
                                                                            </label>
                                                                        </div>
                                                                    </span>
                                                                        <label class="filterLabel">
                                                                            <div class="row_label">معمولی</div>
                                                                        <span class="row_bar">
                                                                            <span class="row_fill"
                                                                                    {{--style="width:{{$rates[2] * 100 / $total}}%;"--}}
                                                                            ></span>
                                                                        </span>
                                                                            <span>
                                                                                {{--{{$rates[2]}}--}}
                                                                            </span>
                                                                        </label>
                                                                    </li>

                                                                    <li class="filterItem">
                                                                    <span class="toggle">
                                                                        <div class='ui_input_checkbox'>
                                                                            <input onclick="filter()" type="checkbox"
                                                                                   name="filterComment[]" value="rate_2"
                                                                                   id="poor" class="filterInput">

                                                                            <label class='labelForCheckBox' for='poor'>
                                                                                <span></span>&nbsp;&nbsp;
                                                                            </label>
                                                                        </div>
                                                                    </span>
                                                                        <label class="filterLabel">
                                                                            <div class="row_label">ضعیف</div>
                                                                        <span class="row_bar">
                                                                            <span class="row_fill"
                                                                                    {{--style="width:{{$rates[1] * 100 / $total}}%;"--}}
                                                                            ></span>
                                                                        </span>
                                                                            <span>
                                                                                {{--{{$rates[1]}}--}}
                                                                            </span>
                                                                        </label>
                                                                    </li>

                                                                    <li class="filterItem">
                                                                    <span class="toggle">
                                                                        <div class='ui_input_checkbox'>
                                                                            <input onclick="filter()" type="checkbox"
                                                                                   name="filterComment[]" value="rate_1"
                                                                                   id="very_poor" class="filterInput">

                                                                            <label class='labelForCheckBox'
                                                                                   for='very_poor'>
                                                                                <span></span>&nbsp;&nbsp;
                                                                            </label>
                                                                        </div>
                                                                    </span>
                                                                        <label class="filterLabel">
                                                                            <div class="row_label">خیلی بد</div>
                                                                        <span class="row_bar">
                                                                            <span class="row_fill"
                                                                                    {{--style="width:{{$rates[0] * 100 / $total}}%;"--}}
                                                                            ></span>
                                                                        </span>
                                                                            <span>
                                                                                {{--{{$rates[0]}}--}}
                                                                            </span>
                                                                        </label>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="ui_column is-2 segment">
                                                                <div class="colTitle">نوع سفر</div>
                                                                <ul>
                                                                    {{--@foreach($placeStyles as $placeStyle)--}}
                                                                    <li class="filterItem">
                                                                        <div class='ui_input_checkbox'>
                                                                            <input onclick="filter()" type="checkbox"
                                                                                   {{--id="placeStyle_{{$placeStyle->id}}"--}}
                                                                                   {{--value="placeStyle_{{$placeStyle->id}}"--}}
                                                                                   name="filterComment[]"
                                                                                   class="filterInput">
                                                                            <label class='labelForCheckBox'
                                                                                    {{--for='placeStyle_{{$placeStyle->id}}'--}}
                                                                            >
                                                                                <span></span>&nbsp;&nbsp;
                                                                                {{--{{$placeStyle->name}}--}}
                                                                            </label>
                                                                        </div>
                                                                    </li>
                                                                    {{--@endforeach--}}
                                                                </ul>
                                                            </div>
                                                            <div class="ui_column is-2 season">
                                                                <div class="colTitle">زمان سفر</div>
                                                                <ul>
                                                                    <li class="filterItem">
                                                                        <div class='ui_input_checkbox'>
                                                                            <input onclick="filter()" value="season_1"
                                                                                   id="season_1" type="checkbox"
                                                                                   name="filterComment[]"
                                                                                   class="filterInput">
                                                                            <label class='labelForCheckBox'
                                                                                   for='season_1'>
                                                                                <span></span>&nbsp;&nbsp;بهار
                                                                            </label>
                                                                        </div>
                                                                    </li>
                                                                    <li class="filterItem">
                                                                        <div class='ui_input_checkbox'>
                                                                            <input onclick="filter()" value="season_2"
                                                                                   id="season_2" type="checkbox"
                                                                                   name="filterComment[]"
                                                                                   class="filterInput">
                                                                            <label class='labelForCheckBox'
                                                                                   for='season_2'>
                                                                                <span></span>&nbsp;&nbsp;تابستان
                                                                            </label>
                                                                        </div>
                                                                    </li>
                                                                    <li class="filterItem">
                                                                        <div class='ui_input_checkbox'>
                                                                            <input onclick="filter()" value="season_3"
                                                                                   id="season_3" type="checkbox"
                                                                                   name="filterComment[]"
                                                                                   class="filterInput">
                                                                            <label class='labelForCheckBox'
                                                                                   for='season_3'>
                                                                                <span></span>&nbsp;&nbsp;پاییز
                                                                            </label>
                                                                        </div>
                                                                    </li>
                                                                    <li class="filterItem">
                                                                        <div class='ui_input_checkbox'>
                                                                            <input onclick="filter()" value="season_4"
                                                                                   id="season_4" type="checkbox"
                                                                                   name="filterComment[]"
                                                                                   class="filterInput">
                                                                            <label class='labelForCheckBox'
                                                                                   for='season_4'>
                                                                                <span></span>&nbsp;&nbsp;زمستان
                                                                            </label>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                                <input type="hidden" name="filterSeasons" value="">
                                                            </div>
                                                            <div class="ui_column is-3 language">
                                                                <div class="colTitle">مبدا سفر</div>
                                                                <?php
                                                                //                                                            $limit = (count($srcCities) > 4) ? 4 : count($srcCities)
                                                                ?>
                                                                <ul>
                                                                    {{--@for($i = 0; $i < $limit; $i++)--}}
                                                                    <li class="filterItem">
                                                                        <div class='ui_input_checkbox'>
                                                                            <input onclick="filter()"
                                                                                   {{--value="srcCity_{{$srcCities[$i]->src}}"--}}
                                                                                   {{--id="srcCity_{{$srcCities[$i]->src}}"--}}
                                                                                   type="checkbox"
                                                                                   name="filterComment[]"
                                                                                   class="filterInput">
                                                                            <label class='labelForCheckBox'>
                                                                                {{--for="srcCity_{{$srcCities[$i]->src}}">--}}
                                                                                <span></span>&nbsp;&nbsp;
                                                                                {{--{{$srcCities[$i]->src}}--}}
                                                                            </label>
                                                                        </div>
                                                                    </li>
                                                                    {{--@endfor--}}
                                                                    {{--@if(count($srcCities) > 4)--}}
                                                                    <li class="filterItem"><span
                                                                                class="toggle"></span><span
                                                                                onclick="toggleMoreCities()"
                                                                                id="moreLessSpan" class="taLnk more">شهرهای بیشتر</span>
                                                                    </li>
                                                                    {{--@endif--}}
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="moreCities" class="hidden">
                                                        <div class="ppr_rup ppr_priv_location_review_filter_controls">
                                                            <div style="font-size: 18px" class="title">شهر ها</div>
                                                            <ul class="langs">
                                                                {{--@for($i = 4; $i < count($srcCities); $i++)--}}
                                                                <li class="filterItem">
                                                                    <div class='ui_input_checkbox'>
                                                                        <input onclick="filter()"
                                                                               {{--value="srcCity_{{$srcCities[$i]->src}}"--}}
                                                                               {{--id="srcCity_{{$srcCities[$i]->src}}"--}}
                                                                               type="checkbox" name="filterComment[]"
                                                                               class="filterInput">
                                                                        <label class='labelForCheckBox'>
                                                                            {{--for="srcCity_{{$srcCities[$i]->src}}">--}}
                                                                            <span></span>&nbsp;&nbsp;
                                                                            {{--{{$srcCities[$i]->src}}--}}
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                                {{--@endfor--}}
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ppr_rup ppr_priv_location_review_keyword_search"
                                                     style="position: relative">
                                                    <div id="taplc_location_review_keyword_search_hotels_0_search">
                                                        <label class="title"
                                                               for="taplc_location_review_keyword_search_hotels_0_q">نمایش
                                                            جستجو در نقد ها </label>
                                                        <div id="taplc_location_review_keyword_search_hotels_0_search_box"
                                                             class="search_box_container">
                                                            <div class="search">
                                                                <div class="search-input ">
                                                                    <div class="search-submit"
                                                                         onclick="comments($('#comment_search_text').val())">
                                                                        <div class="submit">
                                                                            <span class="ui_icon search search-icon"/></span>
                                                                        </div>
                                                                    </div>
                                                                    <input type="text" autocomplete="off"
                                                                           id="comment_search_text"
                                                                           placeholder='جستجو در نقد ها'
                                                                           class="text_input nocloud"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="ui_tagcloud_group easyClear">
                                                    <span id="taplc_location_review_keyword_search_hotels_0_all_reviews"
                                                          class="ui_tagcloud selected fl all_reviews" data-content="-1">همه ی نقدها</span>

                                                        {{--@foreach($tags as $tag)--}}
                                                        <span class="ui_tagcloud fl"
                                                            {{--data-content="{{$tag->name}}"--}}
                                                        >
                                                            {{--{{$tag->name}}--}}
                                                        </span>
                                                        {{--@endforeach--}}
                                                    </div>
                                                </div>
                                                <div id="helpSpan_12" class="helpSpans hidden row">
                                                    <span class="introjs-arrow"></span>
                                                    <p>در سریع تر زمان نقدی که مناسب شما باشد را بیابید و با خواندن آن
                                                        بهتر
                                                        تصمیم بگیرید. اگر نقد ها کم است سعی کنید بعد از سفر نقد خود را
                                                        اضافه
                                                        کنید تا دوستان تان از آن استفاده کنند.</p>
                                                    <button data-val="12" class="btn btn-success nextBtnsHelp"
                                                            id="nextBtnHelp_12">بعدی
                                                    </button>
                                                    <button data-val="12" class="btn btn-primary backBtnsHelp"
                                                            id="backBtnHelp_12">قبلی
                                                    </button>
                                                    <button class="btn btn-danger exitBtnHelp">خروج</button>
                                                </div>
                                            </div>
                                            <div id="reviewsContainer"
                                                 class="ppr_rup ppr_priv_location_reviews_list"></div>
                                            <div class="unified pagination north_star">
                                                <div class="pageNumbers" id="pageNumCommentContainer"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ppr_rup ppr_priv_new_hotel_promo"></div>
                                </div>
                                <div class="ad_column ui_column is-4" style="margin-top: 45px !important;">
                                    <img width="100%" height="100%" id="ad_1">
                                </div>
                            </div>
                        </div>

                        <div id="similars" ng-controller="SimilarController as similar"
                             class="ppr_rup ppr_priv_hr_btf_similar_hotels">
                            <center>
                                <div class="loader hidden"></div>
                            </center>
                            <div id="test" infinite-scroll="myPagingFunction()" class="outerShell block_wrap"
                                 ng-show="show">
                                <div class="block_header" style="border-bottom: 1px solid var(--koochita-light-green) !important;">
                                    <h3 class="block_title">
{{--                                        [[similar.title]]--}}
                                    </h3>
                                </div>
                                <div class="ui_columns is-mobile recs">
                                    <div ng-repeat="place in places"
                                         ng-click="redirect(place.redirect)"
                                         style="cursor: pointer;" class="ui_column is-3 rec">
                                        <a href="#">
{{--                                        <a href="[[place.redirect]]">--}}
                                            <div class="recommendedCard">
                                                <div class="imageContainer">
                                                    <div class="prw_rup prw_common_centered_image">
                                                <span class="imgWrap" style="max-width:364px;max-height:166px;">
                                                    <img ng-src="[[place.pic]]" alt="[[place.alt1]]" class="centeredImg"
                                                         style=" min-width:209px; " width="100%"/>
                                                </span>
                                                    </div>
                                                </div>
                                                <div class="content">
                                                    <div class="hotelName" dir="auto" style="height: auto">
                                                        [[place.name]]
                                                    </div>
                                                    <div class="ratings">
                                            <span>
                                                <div class="prw_rup prw_common_bubble_rating bubbleRating">
                                                    <span class="[[place.ngClass]]" style="font-size:16px;"
                                                          property="ratingValue"
                                                          content="5"></span>
                                                </div>
                                            </span>
                                                        <a style="text-align: left;" class="reviewCount">[[place.reviews]]
                                                            نقد</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="photosDiv" class="ppr_rup ppr_priv_hr_btf_north_star_photos"
                             style="position: relative;">
                            <div class="block_wrap" style="position: relative;">
                                <div class="block_header" data-tab="TABS_PHOTOS" style="position: relative;">
                                    <div id="targetHelp_13" class="targets" style="float: left;">
                                        <a style="color: #FFF !important;" onclick="showAddPhotoPane()"
                                           class="ui_button primary button_war">افزودن عکس </a>
                                        <div id="helpSpan_13" class="helpSpans hidden row">
                                            <span class="introjs-arrow"></span>
                                            <p>اگر عکسی دارید حتما برای دوستان تان به اشتراک بگذارید. از این قسمت می
                                                توانید
                                                عکس های خود را بارگذاری کنید تا به نام شما و با امتیازی هیجان انگیز
                                                نمایش
                                                داده شود.</p>
                                            <button data-val="13" class="btn btn-success nextBtnsHelp"
                                                    id="nextBtnHelp_13">
                                                بعدی
                                            </button>
                                            <button data-val="13" class="btn btn-primary backBtnsHelp"
                                                    id="backBtnHelp_13">
                                                قبلی
                                            </button>
                                            <button class="btn btn-danger exitBtnHelp">خروج</button>
                                        </div>
                                    </div>
                                    <h3 class="block_title">عکس ها</h3>
                                </div>
                                <div class="block_body_top" ng-controller="LogPhotoController as logC">
                                    <div class="ui_columns is-mobile" style="direction: ltr;">
                                        <div class="carousel_wrapper ui_column is-6">
                                            <div class="prw_rup prw_common_mercury_photo_carousel carousel_outer">
                                                <div class="carousel bignav" style="max-height: 424px;">
                                                    <div class="carousel-images carousel_images_footer"
                                                         style="height: 100%">
                                                        <div ng-click="ngGetPhotos(-3)" class="see_all_count_wrap"><span
                                                                    class="see_all_count"><span
                                                                        class="ui_icon camera"></span>همه عکس ها
                                                                {{--{{$userPhotos}}--}}
                                                        </span>
                                                        </div>
                                                        <div class="entry_cta_wrap"><span class="entry_cta"><span
                                                                        class="ui_icon expand"></span>اندازه بزرگ عکس </span>
                                                        </div>
                                                    </div>
                                                    <div onclick="photoRoundRobin2(-1)"
                                                         class="left-nav left-nav-footer hidden"></div>
                                                    <div onclick="photoRoundRobin2(1)"
                                                         class="right-nav right-nav-footer hidden"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="thumb_wrapper ui_column ui_columns is-multiline is-mobile">
                                            <div ng-repeat="log in logs"
                                                 class="prw_rup prw_hotels_flexible_album_thumb albumThumbnailWrap ui_column is-6">
                                                <div class="albumThumbnail">
                                                    <div class="prw_rup prw_common_centered_image">
                                                    <span class="imgWrap" style="max-width:267px;max-height:200px;">
                                                        <img ng-click="ngGetPhotos(log.id)" ng-src="[[log.text]]"
                                                             class="centeredImg" style=" min-width:267px" width="100%"/>
                                                    </span>
                                                    </div>
                                                    <div ng-click="ngGetPhotos(log.id)" class="albumInfo">
                                                        <span class="ui_icon camera"></span> [[log.name]]
                                                        [[log.countNum]]
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="block_body_bottom">
                                    <div class="inner ui_columns is-multiline is-mobile"></div>
                                </div>
                            </div>
                        </div>


                        <div class="content_column ui_column is-12">

                            <style>
                                .poiTile {
                                    float: left;
                                }
                            </style>

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
        </div>

        @include('hotelDetailsPopUp')
        @include('editor')

        <script>
            var hotelMap = [];
            var amakenMap = [];
            var restMap = [];
            var majaraMap = [];
            var newHotelMap = [];
            var newRestMap = [];
            var newAmakenMap = [];
            var newMajaraMap = [];
            var isHotelOn = 1;
            var isRestaurantOn = [1, 1];
            var isAmakenOn = [1, 1, 1, 1, 1, 1];
            var map1;
            var markersHotel = [];
            var markersRest = [];
            var markersFast = [];
            var markersMus = [];
            var markersPla = [];
            var markersShc = [];
            var markersFun = [];
            var markersAdv = [];
            var markersNat = [];
            var iconBase = '{{URL::asset('images') . '/'}}';
            var icons = {
                hotel: iconBase + 'mhotel.png',
                pla: iconBase + 'matr_pla.png',
                mus: iconBase + 'matr_mus.png',
                shc: iconBase + 'matr_shc.png',
                nat: iconBase + 'matr_nat.png',
                fun: iconBase + 'matr_fun.png',
                adv: iconBase + 'matr_adv.png',
                vil: iconBase + 'matr_vil',
                fastfood: iconBase + 'mfast.png',
                rest: iconBase + 'mrest.png'
            };
            var kindIcon;
            var isMapAchieved = false;
            var newBounds = [];
            var newBound;
            var numOfNewHotel = 0;
            var numOfNewAmaken = 0;
            var numOfNewRest = 0;
            var numOfNewMajara = 0;
            var availableHotelIdMarker = [];
            var availableRestIdMarker = [];
            var availableAmakenlIdMarker = [];
            var availableMajaraIdMarker = [];
            var num = 0;
            var isItemClicked = false;

            function showExtendedMap() {
                if (!isMapAchieved) {
                    $('.dark').show();
                    showElement('mapState');//mapState
                    isMapAchieved = true;
                    init2();
                }
                else {
                    $("#mapState").removeClass('hidden');
                }
            }

            function init2() {
                var mapOptions = {
                    zoom: 18,
                    center: new google.maps.LatLng(x, y),
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
                    }
                    ]
                };
                var mapElementSmall = document.getElementById('mapState1');
                map1 = new google.maps.Map(mapElementSmall, mapOptions);
                google.maps.event.addListenerOnce(map1, 'idle', function () {
                    newBound = map1.getBounds();
                    newBounds[0] = newBound.getNorthEast().lat();
                    newBounds[1] = newBound.getNorthEast().lng();
                    newBounds[2] = newBound.getSouthWest().lat();
                    newBounds[3] = newBound.getSouthWest().lng();
                    addNewPlace(newBounds);
                    zoomChangeOrCenterChange();
                });
            }

            function toggleHotelsInExtendedMap(value) {
                if (isHotelOn == value) {
                    document.getElementById('hotelImg').src = "{{URL::asset('images') . '/'}}mhoteloff.png";
                    isHotelOn = 0;
                    mySetMap(isHotelOn, markersHotel);
                }
                else {
                    document.getElementById('hotelImg').src = "{{URL::asset('images') . '/'}}mhotel.png";
                    isHotelOn = 1;
                    mySetMap(isHotelOn, markersHotel);
                }
            }

            function toggleRestaurantsInExtendedMap(value) {
                if (isRestaurantOn[0] == value) {
                    document.getElementById('restImg').src = "{{URL::asset('images') . '/'}}mrestoff.png";
                    isRestaurantOn[0] = 0;
                    mySetMap(isRestaurantOn[0], markersRest);
                }
                else {
                    document.getElementById('restImg').src = "{{URL::asset('images') . '/'}}mrest.png";
                    isRestaurantOn[0] = 1;
                    mySetMap(isRestaurantOn[0], markersRest);
                }
            }

            function toggleFastFoodsInExtendedMap(value) {
                if (isRestaurantOn[1] == value) {
                    document.getElementById('fastImg').src = "{{URL::asset('images') . '/'}}mfastoff.png";
                    isRestaurantOn[1] = 0;
                    mySetMap(isRestaurantOn[1], markersFast);
                }
                else {
                    document.getElementById('fastImg').src = "{{URL::asset('images') . '/'}}mfast.png";
                    isRestaurantOn[1] = 1;
                    mySetMap(isRestaurantOn[1], markersFast);
                }
            }

            function toggleMuseumsInExtendedMap(value) {
                if (isAmakenOn[0] == value) {
                    document.getElementById('musImg').src = "{{URL::asset('images') . '/'}}matr_musoff.png";
                    isAmakenOn[0] = 0;
                    mySetMap(isAmakenOn[0], markersMus);
                }
                else {
                    document.getElementById('musImg').src = "{{URL::asset('images') . '/'}}matr_mus.png";
                    isAmakenOn[0] = 1;
                    mySetMap(isAmakenOn[0], markersMus);
                }
            }

            function toggleHistoricalInExtendedMap(value) {
                if (isAmakenOn[1] == value) {
                    document.getElementById('plaImg').src = "{{URL::asset('images') . '/'}}matr_plaoff.png";
                    isAmakenOn[1] = 0;
                    mySetMap(isAmakenOn[1], markersPla);
                }
                else {
                    document.getElementById('plaImg').src = "{{URL::asset('images') . '/'}}matr_pla.png";
                    isAmakenOn[1] = 1;
                    mySetMap(isAmakenOn[1], markersPla);
                }
            }

            function toggleShopCenterInExtendedMap(value) {
                if (isAmakenOn[2] == value) {
                    document.getElementById('shcImg').src = "{{URL::asset('images') . '/'}}matr_shcoff.png";
                    isAmakenOn[2] = 0;
                    mySetMap(isAmakenOn[2], markersShc);
                }
                else {
                    document.getElementById('shcImg').src = "{{URL::asset('images') . '/'}}matr_shc.png";
                    isAmakenOn[2] = 1;
                    mySetMap(isAmakenOn[2], markersShc);
                }
            }

            function toggleFunCenterInExtendedMap(value) {
                if (isAmakenOn[3] == value) {
                    document.getElementById('funImg').src = "{{URL::asset('images') . '/'}}matr_funoff.png";
                    isAmakenOn[3] = 0;
                    mySetMap(isAmakenOn[3], markersFun);
                }
                else {
                    document.getElementById('funImg').src = "{{URL::asset('images') . '/'}}matr_fun.png";
                    isAmakenOn[3] = 1;
                    mySetMap(isAmakenOn[3], markersFun);
                }
            }

            function toggleMajaraCenterInExtendedMap(value) {
                if (isAmakenOn[5] == value) {
                    document.getElementById('advImg').src = "{{URL::asset('images') . '/'}}matr_advoff.png";
                    isAmakenOn[5] = 0;
                    mySetMap(isAmakenOn[5], markersAdv);
                }
                else {
                    document.getElementById('advImg').src = "{{URL::asset('images') . '/'}}matr_adv.png";
                    isAmakenOn[5] = 1;
                    mySetMap(isAmakenOn[5], markersAdv);
                }
            }

            function toggleNaturalsInExtendedMap(value) {
                if (isAmakenOn[4] == value) {
                    document.getElementById('natImg').src = "{{URL::asset('images') . '/'}}matr_natoff.png";
                    isAmakenOn[4] = 0;
                    mySetMap(isAmakenOn[4], markersNat);
                }
                else {
                    document.getElementById('natImg').src = "{{URL::asset('images') . '/'}}matr_nat.png";
                    isAmakenOn[4] = 1;
                    mySetMap(isAmakenOn[4], markersNat);
                }
            }

            function addMarker() {
                var marker;
                for (i = numOfNewHotel; i < hotelMap.length; i++) {
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(hotelMap[i].C, hotelMap[i].D),
                        map: map1,
                        title: hotelMap[i].name,
                        icon: {
                            url: icons.hotel,
                            scaledSize: new google.maps.Size(35, 35)
                        }
                    });
                    var hotelDetail = {
                        url: '{{route('home') . '/hotel-details/'}}',
                        name: hotelMap[i].name
                    };
                    hotelDetail.url = hotelDetail.url + hotelMap[i].id + '/' + hotelMap[i].name;
                    markersHotel[i] = marker;
                    hotelMap[i].kind = 4;
                    hotelMap[i].url = hotelDetail.url;
                    hotelMap[i].first = true;
                    hotelMap[i].pic = "{{URL::asset("images/loading.gif?v=".$fileVersions)}}";
                    availableHotelIdMarker[i] = hotelMap[i].id;
                    numOfNewHotel = hotelMap.length;
                    clickable(markersHotel[i], hotelMap[i]);
                }
                for (i = numOfNewRest; i < restMap.length; i++) {
                    if (restMap[i].kind_id == 1)
                        kindIcon = icons.rest;
                    else
                        kindIcon = icons.fastfood;
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(restMap[i].C, restMap[i].D),
                        map: map1,
                        title: restMap[i].name,
                        icon: {
                            url: kindIcon,
                            scaledSize: new google.maps.Size(35, 35)
                        }
                    });
                    var restDetail = {
                        url: '{{route('home') . '/restaurant-details/'}}',
                        name: restMap[i].name
                    };
                    restDetail.url = restDetail.url + restMap[i].id + '/' + restMap[i].name;
                    restMap[i].kind = 3;
                    restMap[i].url = restDetail.url;
                    restMap[i].first = true;
                    restMap[i].pic = "{{URL::asset("images/loading.gif?v=".$fileVersions)}}";
                    numOfNewRest = restMap.length;
                    availableRestIdMarker[i] = restMap[i].id;
                    clickable(marker, restMap[i]);
                    if (restMap[i].kind_id == 1) {
                        markersRest[markersRest.length] = marker;
                    }
                    else {
                        markersFast[markersFast.length] = marker;
                    }
                }
                for (i = numOfNewAmaken; i < amakenMap.length; i++) {
                    if (amakenMap[i].mooze == 1)
                        kindIcon = icons.mus;
                    else if (amakenMap[i].tarikhi == 1)
                        kindIcon = icons.pla;
                    else if (amakenMap[i].tabiatgardi == 1)
                        kindIcon = icons.nat;
                    else if (amakenMap[i].tafrihi == 1)
                        kindIcon = icons.fun;
                    else if (amakenMap[i].markazkharid == 1)
                        kindIcon = icons.shc;
                    else
                        kindIcon = icons.pla;
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(amakenMap[i].C, amakenMap[i].D),
                        map: map1,
                        title: amakenMap[i].name,
                        icon: {
                            url: kindIcon,
                            scaledSize: new google.maps.Size(35, 35)
                        }
                    });
                    var amakenDetail = {
                        url: '{{route('home') . '/amaken-details/'}}',
                        name: amakenMap[i].name
                    };
                    amakenDetail.url = amakenDetail.url + amakenMap[i].id + '/' + amakenMap[i].name;
                    amakenMap[i].kind = 1;
                    amakenMap[i].url = amakenDetail.url;
                    amakenMap[i].first = true;
                    numOfNewAmaken = amakenMap.length;
                    availableAmakenlIdMarker[i] = amakenMap[i].id;
                    amakenMap[i].pic = "{{URL::asset("images/loading.gif?v=".$fileVersions)}}";
                    clickable(marker, amakenMap[i]);
                    if (amakenMap[i].mooze == 1)
                        markersMus[markersMus.length] = marker;
                    else if (amakenMap[i].tarikhi == 1)
                        markersPla[markersPla.length] = marker;
                    else if (amakenMap[i].tabiatgardi == 1)
                        markersNat[markersNat.length] = marker;
                    else if (amakenMap[i].tafrihi == 1)
                        markersFun[markersFun.length] = marker;
                    else if (amakenMap[i].markazkharid == 1)
                        markersShc[markersShc.length] = marker;
                    else
                        markersPla[markersPla.length] = marker;
                }
                for (i = numOfNewMajara; i < majaraMap.length; i++) {
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(majaraMap[i].C, majaraMap[i].D),
                        map: map1,
                        title: majaraMap[i].name,
                        icon: {
                            url: icons.adv,
                            scaledSize: new google.maps.Size(35, 35)
                        }
                    });
                    var majaraDetail = {
                        url: '{{route('home') . '/hotel-details/'}}',
                        name: majaraMap[i].name
                    };
                    majaraDetail.url = majaraDetail.url + majaraMap[i].id + '/' + majaraMap[i].name;
                    markersAdv[i] = marker;
                    majaraMap[i].kind = 6;
                    majaraMap[i].url = majaraDetail;
                    majaraMap[i].first = true;
                    majaraMap[i].pic = "{{URL::asset("images/loading.gif?v=".$fileVersions)}}";
                    majaraMap[i].address = majaraMap[i].dastresi;
                    numOfNewMajara = majaraMap.length;
                    availableMajaraIdMarker[i] = majaraMap[i].id;
                    clickable(markersAdv[i], majaraMap[i]);
                }
                mySetMap(isHotelOn, markersHotel);
                mySetMap(isRestaurantOn[0], markersRest);
                mySetMap(isRestaurantOn[1], markersFast);
                mySetMap(isAmakenOn[0], markersMus);
                mySetMap(isAmakenOn[1], markersPla);
                mySetMap(isAmakenOn[2], markersShc);
                mySetMap(isAmakenOn[3], markersFun);
                mySetMap(isAmakenOn[4], markersNat);
                mySetMap(isAmakenOn[5], majaraMap);
            }

            function mySetMap(isSet, marker) {
                if (isSet == 1) {
                    for (var i = 0; i < marker.length; i++) {
                        marker[i].setMap(map1);
                    }
                }
                else
                    for (var i = 0; i < marker.length; i++) {
                        marker[i].setMap(null);
                    }
            }

            // bounds
            function zoomChangeOrCenterChange() {
                google.maps.event.addListener(map1, 'bounds_changed', function () {
                    // map1.setOptions({draggable: false})
                    newBound = map1.getBounds();
                    newBounds[0] = newBound.getNorthEast().lat();
                    newBounds[1] = newBound.getNorthEast().lng();
                    newBounds[2] = newBound.getSouthWest().lat();
                    newBounds[3] = newBound.getSouthWest().lng();
                    addNewPlace(newBounds)
                });
            }

            function addNewPlace(newBounds) {
                var hotelId = JSON.stringify(availableHotelIdMarker);
                var restId = JSON.stringify(availableRestIdMarker);
                var amakenId = JSON.stringify(availableAmakenlIdMarker);
                var majaraId = JSON.stringify(availableMajaraIdMarker);
                $.ajax({
                    type: 'post',
                    url: '{{route('newPlaceForMap')}}',
                    data: {
                        'swLat': newBounds[2],
                        'swLng': newBounds[3],
                        'neLat': newBounds[0],
                        'neLng': newBounds[1],
                        'C': x,
                        'D': y,
                        'hotelId': hotelId,
                        'restId': restId,
                        'amakenId': amakenId,
                        'majaraId': majaraId
                    },
                    success: function (response) {
                        response = JSON.parse(response);
                        newHotelMap = response.hotel;
                        newRestMap = response.rest;
                        newAmakenMap = response.amaken;
                        newMajaraMap = response.majara;
                        afterSuccess();
                    }
                });
            }

            function afterSuccess() {
                for (i = 0; i < newHotelMap.length; i++) {
                    hotelMap[hotelMap.length] = newHotelMap[i];
                }
                for (i = 0; i < newMajaraMap.length; i++) {
                    majaraMap[majaraMap.length] = newMajaraMap[i];
                }
                for (i = 0; i < newRestMap.length; i++) {
                    restMap[restMap.length] = newRestMap[i];
                }
                for (i = 0; i < newAmakenMap.length; i++) {
                    amakenMap[amakenMap.length] = newAmakenMap[i];
                }
                addMarker();
            }

            function clickable(marker, name) {
                google.maps.event.addListener(marker, 'click', function () {
                    document.getElementById('placeInfoInExtendedMap').style.display = 'inline';
                    document.getElementById('url').innerHTML = name.name;
                    document.getElementById('url').href = name.url;
                    isItemClicked = true;
                    if (name.first)
                        getPic(name);
                    else {
                        $("#placeInfoPicInExtendedMap").attr('src', name.pic);
                    }
                    switch (name.rate) {
                        case 1:
                            document.getElementById('star').className = "ui_bubble_rating bubble_10";
                            document.getElementById('star').content = '1';
                            document.getElementById('rateNum').innerHTML = '1';
                            break;
                        case 2:
                            document.getElementById('star').className = "ui_bubble_rating bubble_20";
                            document.getElementById('star').content = '2';
                            document.getElementById('rateNum').innerHTML = '2';
                            break;
                        case 3:
                            document.getElementById('star').className = "ui_bubble_rating bubble_30";
                            document.getElementById('star').content = '3';
                            document.getElementById('rateNum').innerHTML = '3';
                            break;
                        case 4:
                            document.getElementById('star').className = "ui_bubble_rating bubble_40";
                            document.getElementById('star').content = '4';
                            document.getElementById('rateNum').innerHTML = '4';
                            break;
                        case 5:
                            document.getElementById('star').className = "ui_bubble_rating bubble_50";
                            document.getElementById('star').content = '5';
                            document.getElementById('rateNum').innerHTML = '5';
                            break;
                    }
                    switch (name.kind) {
                        case 4:
                            document.getElementById('nearTitle').innerHTML = 'سایر هتل ها';
                            break;
                        case 3:
                            document.getElementById('nearTitle').innerHTML = 'سایر رستوران ها';
                            break;
                        case 1:
                            document.getElementById('nearTitle').innerHTML = 'سایر اماکن ';
                            break;
                    }
                    document.getElementById('rev').innerHTML = name.reviews + "نقد";
                    document.getElementById('address').innerHTML = "آدرس : " + name.address;
                    var scope = angular.element(document.getElementById("nearbyInExtendedMap")).scope();
                    scope.$apply(function () {
                        scope.findNearPlaceForMap(name);
                    });
                });
                var classRatingHover;
                switch (name.rate) {
                    case 1:
                        // classRatingHover.className = 'ui_bubble_rating bubble_10';
                        classRatingHover = 'ui_bubble_rating bubble_10';
                        // classRatingHover.content = '1';
                        break;
                    case 2:
                        classRatingHover = 'ui_bubble_rating bubble_20';
                        // classRatingHover.content = '2';
                        break;
                    case 3:
                        classRatingHover = 'ui_bubble_rating bubble_30';
                        // classRatingHover.content = '3';
                        break;
                    case 4:
                        classRatingHover = 'ui_bubble_rating bubble_40';
                        // classRatingHover.content = '4';
                        break;
                    case 5:
                        classRatingHover = 'ui_bubble_rating bubble_50';
                        // classRatingHover.content = '5';
                        break;
                }
                var hoverContent = "<div id='myTotalPane' style='width:100%'><img id='itemPicInExtendedMap' style='height: 80px; width: 40%; display:inline-block;' src=" + '{{URL::asset("images/loading.gif?v=".$fileVersions)}}' + " >" +
                        "<a href='" + name.url + "' style='display: inline-block; margin-right: 5%; font-size: 110%;'>" + name.name + "</a>" +
                        "<div class='rating' style='display: block;margin-top: -18%; margin-right: 45%;'>" +
                        "<span id='rateNum1' class='overallRating'> </span>" +
                        "<div class='prw_rup prw_common_bubble_rating overallBubbleRating' style='display: inline;'>" +
                        "<span id='star1' class='" + classRatingHover + "' style='font-size:20px;' property='ratingValue' content='' ></span>" +
                        "</div>" +
                        "<span id='rev1' class='autoResize' style='margin-right: 10%;font-size: 115%;'>" + name.reviews + "نقد </span>" +
                        "</div>" +
                        "<h1 style='margin-right:42%; margin-top:2%'>فاصله :" + name.distance * 1000 + "متر</h1>" +
                        "<h1 id='address1' style='display: block; font-size: 130%; margin-top: 6%;'>" + name.address + "</h1>" +
                        "</div>";
                var infowindow = new google.maps.InfoWindow({
                    content: hoverContent,
                    maxWidth: 350
                });
                google.maps.event.addListener(marker, 'mouseover', function () {
                    if (name.first)
                        getPic(name);
                    else {
                        $("#itemPicInExtendedMap").attr('src', name.pic);
                    }
                    infowindow.open(map1, marker);
                });
                google.maps.event.addListener(marker, 'mouseout', function () {
                    infowindow.close(map1, marker);
                });
                google.maps.event.addListener(infowindow, 'domready', function () {
                    var iwOuter = $('.gm-style-iw');
                    var iwBackground = iwOuter.prev();
                    // Removes background shadow DIV
                    iwBackground.children(':nth-child(2)').css({'display': 'none'});
                    // Removes white background DIV
                    iwBackground.children(':nth-child(4)').css({'display': 'none'});
                    // Moves the infowindow 115px to the right.
                    iwOuter.parent().parent().css({left: '0px', 'overflow': 'none'});
                    // Moves the shadow of the arrow 76px to the left margin.
                    iwBackground.children(':nth-child(1)').attr('style', function (i, s) {
                        return s + 'left: 76px !important;'
                    });
                    // Moves the arrow 76px to the left margin.
                    iwBackground.children(':nth-child(3)').attr('style', function (i, s) {
                        return s + 'left: 0px !important;'
                    });
                    // Changes the desired tail shadow color.
                    iwBackground.children(':nth-child(3)').find('div').children().css({
                        'box-shadow': 'rgba(72, 181, 233, 0.6) 0px 1px 6px',
                        'z-index': '1'
                    });
                    // Reference to the div that groups the close button elements.
                    var iwCloseBtn = iwOuter.next();
                    // Apply the desired effect to the close button
                    iwCloseBtn.css({display: 'none'});
                    $("#myTotalPane").parent().attr('style', function (i, s) {
                        return s + 'min-height: 152px !important; max-height: 200px !important;'
                    })
                });
            }

            function getPic(name) {
                $.ajax({
                    type: 'post',
                    url: '{{route('getPlacePicture')}}',
                    data: {
                        'kindPlaceId': name.kind,
                        'placeId': name.id
                    },
                    success: function (response) {
                        $("#itemPicInExtendedMap").attr('src', response);
                        $("#placeInfoPicInExtendedMap").attr('src', name.pic);
                        name.first = false;
                        name.pic = response;
                    }
                });
            }

            function getJustPic(name) {
                $.ajax({
                    type: 'post',
                    url: '{{route('getPlacePicture')}}',
                    data: {
                        'kindPlaceId': name.kind,
                        'placeId': name.id
                    },
                    success: function (response) {
                        name.pic = response;
                        name.first = false;
                        $("#itemNearbyPic_" + name.id + "_" + name.kind).attr('src', response);
                    }
                });
            }
        </script>

        <script>
            var app = angular.module("mainApp", ['infinite-scroll'], function ($interpolateProvider) {
                $interpolateProvider.startSymbol('[[');
                $interpolateProvider.endSymbol(']]');
            });
                    {{--var placeMode = '{{$placeMode}}';--}}
            var data;
            var requestURL;
            const config = {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;',
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            };
            app.controller('LogPhotoController', function ($scope, $http) {
                $scope.places = [];
                {{--$scope.kindPlaceId = '{{$kindPlaceId}}';--}}
                        data = $.param({
                    {{--placeId: '{{$place->id}}',--}}
                    //                kindPlaceId: $scope.kindPlaceId
                });
                $scope.ngGetPhotos = function (val) {
                    getPhotos(val);
                };
                $scope.myPagingFunction = function () {
                    $http.post('{{route('getLogPhotos')}}', data, config).then(function (response) {
                        $scope.logs = response.data;
                    }).catch(function (err) {
                        console.log(err);
                    });
                };
                $scope.$on('myPagingFunctionAPI', function (event) {
                    $scope.myPagingFunction();
                });
            });
            app.controller('SimilarController', function ($scope, $http, $rootScope) {
                var title;
                $scope.show = false;
                $scope.places = [];
                if (placeMode == "hotel") {
                    this.title = "هتل های مشابه";
                    requestURL = '{{route('getSimilarsHotel')}}';
                }
                if (placeMode == "amaken") {
                    this.title = "اماکن مشابه";
                    requestURL = '{{route('getSimilarsAmaken')}}';
                }
                if (placeMode == "restaurant") {
                    this.title = "رستوران های مشابه";
                    requestURL = '{{route('getSimilarsRestaurant')}}';
                }
                if (placeMode == "majara") {
                    this.title = "ماجراجویی های مشابه";
                    requestURL = '{{route('getSimilarsMajara')}}';
                }
                data = $.param({
                    {{--placeId: '{{$place->id}}'--}}
                });
                $scope.redirect = function (url) {
                    document.location.href = url;
                };
                $scope.disable = false;
                $scope.myPagingFunction = function () {
                    var scroll = $(window).scrollTop();
                    if (scroll < 1200 || $scope.disable)
                        return;
                    $scope.disable = true;
                    $rootScope.$broadcast('myPagingFunctionAPI');
                    $rootScope.$broadcast('myPagingFunctionAPINearby');
                    $http.post(requestURL, data, config).then(function (response) {
                        if (response.data != null && response.data != null && response.data.length > 0)
                            $scope.show = true;
                        $scope.places = response.data;
                        var i;
                        for (i = 0; i < response.data.length; i++) {
                            if (placeMode == "hotel")
                                $scope.places[i].redirect = '{{ route('home') . '/hotel-details/' }}' + $scope.places[i].id + "/" + $scope.places[i].name;
                            else if (placeMode == "amken")
                                $scope.places[i].redirect = '{{ route('home') . '/amaken-details/' }}' + $scope.places[i].id + "/" + $scope.places[i].name;
                            else if (placeMode == "restaurant")
                                $scope.places[i].redirect = '{{ route('home') . '/restaurant-details/' }}' + $scope.places[i].id + "/" + $scope.places[i].name;
                            else if (placeMode == "majara")
                                $scope.places[i].redirect = '{{ route('home') . '/majara-details/' }}' + $scope.places[i].id + "/" + $scope.places[i].name;
                            switch ($scope.places[i].rate) {
                                case 5:
                                    $scope.places[i].ngClass = 'ui_bubble_rating bubble_50';
                                    break;
                                case 4:
                                    $scope.places[i].ngClass = 'ui_bubble_rating bubble_40';
                                    break;
                                case 3:
                                    $scope.places[i].ngClass = 'ui_bubble_rating bubble_30';
                                    break;
                                case 2:
                                    $scope.places[i].ngClass = 'ui_bubble_rating bubble_20';
                                    break;
                                default:
                                    $scope.places[i].ngClass = 'ui_bubble_rating bubble_10';
                            }
                        }
                    }).catch(function (err) {
                        console.log(err);
                    });
                };
            });
            var x1 = [];
            var y1 = [];
            var placeName = [];
            var lengthPlace = [];
            var kind;
            //این متفیر برای تعیین نوع رستوران برای ایکون نقشه است که 1 ایرانی و 0 فست فود است
            var kindRest = [];
            //این متغیر برای تعیین نوع مکان است
            var kindAmaken = [];
            app.controller('NearbyController', function ($scope, $http, $rootScope) {
                var kindPlaceId = (placeMode == "hotel") ? 4 : (placeMode == "amaken") ? 1 : 3;
                kind = kindPlaceId;
                data = $.param({
                    {{--placeId: '{{$place->id}}',--}}
                    kindPlaceId: kindPlaceId
                });
                $scope.redirect = function (url) {
                    document.location.href = url;
                };
                $scope.hotels = [];
                $scope.amakens = [];
                $scope.restaurants = [];
                $scope.myPagingFunction = function () {
                    $http.post('{{route('getNearby')}}', data, config).then(function (response) {
                        var i;
                        lengthPlace[0] = 0;
                        $scope.hotels = response.data[0];
                        for (i = 0; i < response.data[0].length; i++) {
                            $scope.hotels[i].redirect = '{{ route('home') . '/hotel-details/' }}' + $scope.hotels[i].id + "/" + $scope.hotels[i].name;
                            x1[i] = $scope.hotels[i].C;
                            y1[i] = $scope.hotels[i].D;
                            placeName[i] = $scope.hotels[i].name;
                            switch ($scope.hotels[i].rate) {
                                case 5:
                                    $scope.hotels[i].ngClass = 'ui_bubble_rating bubble_50';
                                    break;
                                case 4:
                                    $scope.hotels[i].ngClass = 'ui_bubble_rating bubble_40';
                                    break;
                                case 3:
                                    $scope.hotels[i].ngClass = 'ui_bubble_rating bubble_30';
                                    break;
                                case 2:
                                    $scope.hotels[i].ngClass = 'ui_bubble_rating bubble_20';
                                    break;
                                default:
                                    $scope.hotels[i].ngClass = 'ui_bubble_rating bubble_10';
                            }
                        }
                        lengthPlace[1] = x1.length;
                        $scope.amakens = response.data[2];
                        for (i = 0; i < response.data[2].length; i++) {
                            $scope.amakens[i].redirect = '{{ route('home') . '/amaken-details/' }}' + $scope.amakens[i].id + "/" + $scope.amakens[i].name;
                            x1[i + lengthPlace[1]] = $scope.amakens[i].C;
                            y1[i + lengthPlace[1]] = $scope.amakens[i].D;
                            placeName[i + lengthPlace[1]] = $scope.amakens[i].name;
                            if ($scope.amakens[i].mooze == 1)
                                kindAmaken[i] = 1;
                            else if ($scope.amakens[i].tarikhi == 1)
                                kindAmaken[i] = 2;
                            else if ($scope.amakens[i].tabiatgardi == 1)
                                kindAmaken[i] = 3;
                            else if ($scope.amakens[i].tafrihi == 1)
                                kindAmaken[i] = 4;
                            else if ($scope.amakens[i].markazkharid == 1)
                                kindAmaken[i] = 5;
                            else
                                kindAmaken[i] = 1;
                            switch ($scope.amakens[i].rate) {
                                case 5:
                                    $scope.amakens[i].ngClass = 'ui_bubble_rating bubble_50';
                                    break;
                                case 4:
                                    $scope.amakens[i].ngClass = 'ui_bubble_rating bubble_40';
                                    break;
                                case 3:
                                    $scope.amakens[i].ngClass = 'ui_bubble_rating bubble_30';
                                    break;
                                case 2:
                                    $scope.amakens[i].ngClass = 'ui_bubble_rating bubble_20';
                                    break;
                                default:
                                    $scope.amakens[i].ngClass = 'ui_bubble_rating bubble_10';
                            }
                        }
                        $scope.restaurants = response.data[1];
                        lengthPlace[2] = x1.length;
                        for (i = 0; i < response.data[1].length; i++) {
                            $scope.restaurants[i].redirect = '{{ route('home') . '/restaurant-details/' }}' + $scope.restaurants[i].id + "/" + $scope.restaurants[i].name;
                            x1[i + lengthPlace[2]] = $scope.restaurants[i].C;
                            y1[i + lengthPlace[2]] = $scope.restaurants[i].D;
                            placeName[i + lengthPlace[2]] = $scope.restaurants[i].name;
                            if ($scope.restaurants[i].kind_id == 1)
                                kindRest[i] = 1;
                            else
                                kindRest[i] = 0;
                            switch ($scope.restaurants[i].rate) {
                                case 5:
                                    $scope.restaurants[i].ngClass = 'ui_bubble_rating bubble_50';
                                    break;
                                case 4:
                                    $scope.restaurants[i].ngClass = 'ui_bubble_rating bubble_40';
                                    break;
                                case 3:
                                    $scope.restaurants[i].ngClass = 'ui_bubble_rating bubble_30';
                                    break;
                                case 2:
                                    $scope.restaurants[i].ngClass = 'ui_bubble_rating bubble_20';
                                    break;
                                default:
                                    $scope.restaurants[i].ngClass = 'ui_bubble_rating bubble_10';
                            }
                        }
                        lengthPlace[3] = x1.length;
                        initBigMap();
                    }).catch(function (err) {
                        console.log(err);
                    });
                };
                $scope.$on('myPagingFunctionAPINearby', function (event) {
                    $scope.myPagingFunction();
                });
            });
            var testhh2 = 1;
            var testshow = 1;

            function closeDiv(di) {
                if (di == 'nearbyInExtendedMap') {
                    if (testhh2 == 1) {
                        document.getElementById(di).style.display = 'block';
                        document.getElementById('closeNearbyPlaces').style.transform = 'rotate(-90deg)';
                        testhh2 = 0;
                    }
                    else {
                        document.getElementById(di).style.display = 'none';
                        document.getElementById('closeNearbyPlaces').style.transform = 'rotate(90deg)';
                        testhh2 = 1;
                    }
                }
                if (di == 'placeInfoInExtendedMap')
                    document.getElementById(di).style.display = 'none';
                if (di == 'show') {
                    if (testshow == 1) {
                        testshow = 0;
                        document.getElementById('closeShow').style.transform = 'scaleX(-1)';
                        document.getElementById(di).style.display = 'none';
                    }
                    else {
                        testshow = 1;
                        document.getElementById('closeShow').style.transform = 'scaleX(1)';
                        document.getElementById(di).style.display = 'inline-block';
                    }
                }
            }

            app.controller('nearPlaceRepeat', function ($scope) {
                $scope.findNearPlaceForMap = function (place) {
                    if (!isItemClicked)
                        return;
                    var C = place.C * 3.14 / 180;
                    var D = place.D * 3.14 / 180;
                    var counter = 0;
                    var i;
                    if (place.kind == 4) {
                        $scope.nearPlaces = [];
                        for (i = 0; i < hotelMap.length; i++) {
                            if (Math.acos(Math.sin(D) * Math.sin(hotelMap[i].D / 180 * 3.14) + Math.cos(D) * Math.cos(hotelMap[i].D / 180 * 3.14) * Math.cos(hotelMap[i].C / 180 * 3.14 - C)) * 6371 < 1) {
                                $scope.nearPlaces[counter] = hotelMap[i];
                                if ($scope.nearPlaces[counter].first)
                                    getJustPic($scope.nearPlaces[counter]);
                                $scope.nearPlaces[counter++].distance = Math.acos(Math.sin(D) * Math.sin(hotelMap[i].D / 180 * 3.14) + Math.cos(D) * Math.cos(hotelMap[i].D / 180 * 3.14) * Math.cos(hotelMap[i].C / 180 * 3.14 - C)) * 6371;
                            }
                        }
                    }
                    else if (place.kind == 3) {
                        $scope.nearPlaces = [];
                        for (i = 0; i < restMap.length; i++) {
                            if (Math.acos(Math.sin(D) * Math.sin(restMap[i].D / 180 * 3.14) + Math.cos(D) * Math.cos(restMap[i].D / 180 * 3.14) * Math.cos(restMap[i].C / 180 * 3.14 - C)) * 6371 < 1) {
                                $scope.nearPlaces[counter] = restMap[i];
                                if ($scope.nearPlaces[counter].first)
                                    getJustPic($scope.nearPlaces[counter]);
                                $scope.nearPlaces[counter++].distance = Math.acos(Math.sin(D) * Math.sin(restMap[i].D / 180 * 3.14) + Math.cos(D) * Math.cos(restMap[i].D / 180 * 3.14) * Math.cos(restMap[i].C / 180 * 3.14 - C)) * 6371;
                            }
                        }
                    }
                    else if (place.kind == 1) {
                        $scope.nearPlaces = [];
                        for (i = 0; i < amakenMap.length; i++) {
                            if (Math.acos(Math.sin(D) * Math.sin(amakenMap[i].D / 180 * 3.14) + Math.cos(D) * Math.cos(amakenMap[i].D / 180 * 3.14) * Math.cos(amakenMap[i].C / 180 * 3.14 - C)) * 6371 < 1) {
                                $scope.nearPlaces[counter] = amakenMap[i];
                                if ($scope.nearPlaces[counter].first)
                                    getJustPic($scope.nearPlaces[counter]);
                                $scope.nearPlaces[counter++].distance = Math.acos(Math.sin(D) * Math.sin(amakenMap[i].D / 180 * 3.14) + Math.cos(D) * Math.cos(amakenMap[i].D / 180 * 3.14) * Math.cos(amakenMap[i].C / 180 * 3.14 - C)) * 6371;
                            }
                        }
                    }
                    else {
                        $scope.nearPlaces = [];
                        for (i = 0; i < majaraMap.length; i++) {
                            if (Math.acos(Math.sin(D) * Math.sin(majaraMap[i].D / 180 * 3.14) + Math.cos(D) * Math.cos(majaraMap[i].D / 180 * 3.14) * Math.cos(majaraMap[i].C / 180 * 3.14 - C)) * 6371 < 1) {
                                $scope.nearPlaces[counter] = majaraMap[i];
                                if (majaraMap[i].first)
                                    getJustPic(majaraMap[i]);
                                $scope.nearPlaces[counter++].distance = Math.acos(Math.sin(D) * Math.sin(majaraMap[i].D / 180 * 3.14) + Math.cos(D) * Math.cos(majaraMap[i].D / 180 * 3.14) * Math.cos(majaraMap[i].C / 180 * 3.14 - C)) * 6371;
                            }
                        }
                    }
                    $scope.nearPlaces.sort(function (a, b) {
                        return a.distance - b.distance
                    });
                    for (i = 0; i < $scope.nearPlaces.length; i++) {
                        $scope.nearPlaces[i].distance = Math.round($scope.nearPlaces[i].distance * 1000);
                        switch ($scope.nearPlaces[i].rate) {
                            case 5:
                                $scope.nearPlaces[i].ngClass = 'ui_bubble_rating bubble_50';
                                break;
                            case 4:
                                $scope.nearPlaces[i].ngClass = 'ui_bubble_rating bubble_40';
                                break;
                            case 3:
                                $scope.nearPlaces[i].ngClass = 'ui_bubble_rating bubble_30';
                                break;
                            case 2:
                                $scope.nearPlaces[i].ngClass = 'ui_bubble_rating bubble_20';
                                break;
                            default:
                                $scope.nearPlaces[i].ngClass = 'ui_bubble_rating bubble_10';
                        }
                    }
                };
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
            {{--var x = '{{$place->C}}';--}}
            {{--var y = '{{$place->D}}';--}}

            function initBigMap() {
                var locations = [];
                var k;
                var iconBase = '{{URL::asset('images') . '/'}}';
                var icons = {
                    hotel: {
                        icon: iconBase + 'mhotel.png'
                    },
                    amaken1: {
                        icon: iconBase + 'matr_pla.png'
                    },
                    amaken2: {
                        icon: iconBase + 'matr_mus.png'
                    },
                    amaken3: {
                        icon: iconBase + 'matr_shc.png'
                    },
                    amaken4: {
                        icon: iconBase + 'matr_nat.png'
                    },
                    amaken5: {
                        icon: iconBase + 'matr_fun.png'
                    },
                    fastfood: {
                        icon: iconBase + 'mfast.png'
                    },
                    rest: {
                        icon: iconBase + 'mrest.png'
                    }
                };
                var mapOptions = {
                    zoom: 14,
                    center: new google.maps.LatLng(x, y),
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
                // Get the HTML DOM element that will contain your map
                // We are using a div with id="map" seen below in the <body>
//            var mapElement = document.getElementById('map');
                // Create the Google Map using our element and options defined above
//            var map = new google.maps.Map(mapElement, mapOptions);
                // Let's also add a marker while we're at it for big map
//            switch (kind) {
//                case 4:
//                    k = 'hotel';
//                    break;
//                case 1:
                {{--if ('{{ $place->mooze }}' == 1)--}}
                {{--k = 'amaken2';--}}
                {{--else if ('{{ $place->tarikhi }}' == 1)--}}
                {{--k = 'amaken1';--}}
                {{--else if ('{{ $place->tabiatgardi }}' == 1)--}}
                {{--k = 'amaken4';--}}
                {{--else if ('{{ $place->tafrihi }}' == 1)--}}
                {{--k = 'amaken5';--}}
                {{--else if ('{{ $place->markazkharid }}' == 1)--}}
                {{--k = 'amaken3';--}}
                {{--else--}}
                {{--k = 'amaken1';--}}
                {{--break;--}}
                {{--case 3:--}}
                {{--if ('{{$place->kind_id}}' == 1)--}}
                {{--k = 'rest';--}}
                {{--else--}}
                {{--k = 'fastfood';--}}
                {{--break;--}}
                //            }
                        {{--locations[0] = {positions: new google.maps.LatLng(x, y), name: '{{ $place->name }}', type: k};--}}
                for (j = 0; j < 3; j++) {
                    var number = 0;
                    for (i = lengthPlace[j]; i < lengthPlace[j + 1]; i++) {
                        if (j == 0)
                            k = 'hotel';
                        if (j == 2 && kindRest[number] == 1) {
                            k = 'rest';
                            number++;
                        }
                        else if (j == 2) {
                            k = 'fastfood';
                            number++;
                        }
                        if (j == 1) {
                            switch (kindAmaken[number]) {
                                case 1:
                                    k = 'amaken2';
                                    break;
                                case 2:
                                    k = 'amaken1';
                                    break;
                                case 3:
                                    k = 'amaken4';
                                    break;
                                case 4:
                                    k = 'amaken5';
                                    break;
                                case 5:
                                    k = 'amaken3';
                                    break;
                            }
                            number++;
                        }
                        locations[i + 1] = {
                            positions: new google.maps.LatLng(x1[i], y1[i]),
                            name: placeName[i],
                            type: k
                        };
                    }
                    locations.forEach(function (location) {
                        var marker = new google.maps.Marker({
                            position: location.positions,
                            icon: {
                                url: icons[location.type].icon,
                                scaledSize: new google.maps.Size(35, 35)
                            },
                            map: map,
                            title: location.name
                        });
                    });
                }
            }

            function init() {
                        {{--var x = '{{$place->C}}';--}}
                        {{--var y = '{{$place->D}}';--}}
                        {{--var place_name = '{{ $place->name }}';--}}
                var mapOptions = {
                            zoom: 14,
                            center: new google.maps.LatLng(x, y),
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
                // Get the HTML DOM element that will contain your map
                // We are using a div with id="map" seen below in the <body>
                var mapElementSmall = document.getElementById('map-small');
                // Create the Google Map using our element and options defined above
                var map2 = new google.maps.Map(mapElementSmall, mapOptions);
                // Let's also add a marker while we're at it smal map
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(x, y),
                    map: map2,
                    title: place_name
                });
            }
        </script>

        <script src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyCdVEd4L2687AfirfAnUY1yXkx-7IsCER0&callback=init"></script>
        <script async src="{{URL::asset('js/album.js')}}"></script>

        <script>
                    {{--var hasLogin = '{{$hasLogin}}';--}}
            var bookMarkDir = '{{route('bookMark')}}';
            var getPlaceTrips = '{{route('placeTrips')}}';
            var assignPlaceToTripDir = '{{route('assignPlaceToTrip')}}';
            var soon = '{{route('soon')}}';
                    {{--var placeMode = '{{$placeMode}}';--}}
            var hotelDetails;
            var hotelDetailsInBookMarkMode;
            var hotelDetailsInAskQuestionMode;
            var hotelDetailsInAnsMode;
            var hotelDetailsInSaveToTripMode;
            var getQuestions = '{{route('getQuestions')}}';
                    {{--var placeId = '{{$place->id}}';--}}
                    {{--var kindPlaceId = '{{$kindPlaceId}}';--}}
            var getCommentsCount = '{{route('getCommentsCount')}}';
                    {{--var totalPhotos = '{{$sitePhotos + $userPhotos}}';--}}
                    {{--var sitePhotosCount = '{{$sitePhotos}}';--}}
            var opOnComment = '{{route('opOnComment')}}';
            var askQuestionDir = '{{route('askQuestion')}}';
            var sendAnsDir = '{{route('sendAns')}}';
            var showAllAnsDir = '{{route('showAllAns')}}';
            var filterComments = '{{route('filterComments')}}';
            var getReportsDir = '{{route('getReports')}}';
            var sendReportDir = '{{route('sendReport2')}}';
            var getPhotoFilter = '{{route('getPhotoFilter')}}';
            var getPhotosDir = '{{route('getPhotos')}}';
            var showUserBriefDetail = '{{route('showUserBriefDetail')}}';
            var homePath = '{{route('home')}}';
            {{--var hotelDetailsInAddPhotoMode = '{{route('hotelDetails', ['placeId' => $place->id, 'placeName' => $place->name, 'mode' => 'addPhoto'])}}';--}}
        </script>

        <script>
            var selectedPlaceId = -1;
            var selectedKindPlaceId = -1;
            var currPage = 1;
            var currPageQuestions = 1;
            var selectedTag = "";
            var roundRobinPhoto;
            var roundRobinPhoto2;
            var selectedTrips;
            var currHelpNo;
            var noAns = false;
            var photos = [];
            var photos2 = [];

            function saveToTrip() {
                if (!hasLogin) {
                    showLoginPrompt(hotelDetailsInSaveToTripMode);
                    return;
                }
                selectedPlaceId = placeId;
                selectedKindPlaceId = kindPlaceId;
                $.ajax({
                    type: 'post',
                    url: getPlaceTrips,
                    data: {
                        'placeId': placeId,
                        'kindPlaceId': kindPlaceId
                    },
                    success: function (response) {
                        selectedTrips = [];
                        $('.dark').show();
                        response = JSON.parse(response);
                        var newElement = "<div class='row'>";
                        for (i = 0; i < response.length; i++) {
                            newElement += "<div class='col-xs-3' style='cursor: pointer' onclick='addToSelectedTrips(\"" + response[i].id + "\")'>";
                            if (response[i].select == "1") {
                                newElement += "<div id='trip_" + response[i].id + "' style='width: 150px; height: 150px; border: 2px solid var(--koochita-light-green);cursor: pointer;' onclick='' class='trip-images ui_columns is-gapless is-multiline is-mobile'>";
                                selectedTrips[selectedTrips.length] = response[i].id;
                            }
                            else
                                newElement += "<div id='trip_" + response[i].id + "' style='width: 150px; height: 150px; border: 2px solid #a0a0a0;cursor: pointer;' onclick='' class='trip-images ui_columns is-gapless is-multiline is-mobile'>";
                            if (response[i].placeCount > 0) {
                                tmp = "url('" + response[i].pic1 + "')";
                                newElement += "<div class='trip-image ui_column is-6' style='background: " + tmp + " repeat 0 0; background-size: 100% 100%'></div>";
                            }
                            else
                                newElement += "<div class='trip-image trip-image-empty ui_column is-6' style='background-color: #cfcfcf'></div>";
                            if (response[i].placeCount > 1) {
                                tmp = "url('" + response[i].pic2 + "')";
                                newElement += "<div class='trip-image ui_column is-6' style='background: " + tmp + " repeat 0 0; background-size: 100% 100%'></div>";
                            }
                            else
                                newElement += "<div class='trip-image trip-image-empty ui_column is-6' style='background-color: #cfcfcf'></div>";
                            if (response[i].placeCount > 1) {
                                tmp = "url('" + response[i].pic3 + "')";
                                newElement += "<div class='trip-image ui_column is-6' style='background: " + tmp + " repeat 0 0; background-size: 100% 100%'></div>";
                            }
                            else
                                newElement += "<div class='trip-image trip-image-empty ui_column is-6' style='background-color: #cfcfcf'></div>";
                            if (response[i].placeCount > 1) {
                                tmp = "url('" + response[i].pic4 + "')";
                                newElement += "<div class='trip-image ui_column is-6' style='background: " + tmp + " repeat 0 0; background-size: 100% 100%'></div>";
                            }
                            else
                                newElement += "<div class='trip-image trip-image-empty ui_column is-6' style='background-color: #cfcfcf'></div>";
                            newElement += "</div><div class='create-trip-text' style='font-size: 1.2em;'>" + response[i].name + "</div>";
                            newElement += "</div>";
                        }
                        newElement += "<div class='col-xs-3'>";
                        newElement += "<a onclick='showPopUp()' class='single-tile is-create-trip'>";
                        newElement += "<div class='tile-content' style='font-size: 20px !important; text-align: center'>";
                        newElement += "<span class='ui_icon plus'></span>";
                        newElement += "<div class='create-trip-text'>ایجاد سفر</div>";
                        newElement += "</div></a></div>";
                        newElement += "</div>";
                        $("#tripsForPlace").empty().append(newElement);
                        showElement('addPlaceToTripPrompt');
                    }
                });
            }

            function showElement(element) {
                $(".pop-up").addClass('hidden');
                $("#" + element).removeClass('hidden');
            }

            function hideElement(element) {
                $(".dark").hide();
                $("#" + element).addClass('hidden');
            }

            function bookMark() {
                if (!hasLogin) {
                    showLoginPrompt(hotelDetailsInBookMarkMode);
                    return;
                }
                $.ajax({
                    type: 'post',
                    url: bookMarkDir,
                    data: {
                        'placeId': placeId,
                        'kindPlaceId': kindPlaceId
                    },
                    success: function (response) {
                        if (response == "ok")
                            document.location.href = hotelDetails;
                    }
                })
            }

            function addToSelectedTrips(id) {
                allow = true;
                for (i = 0; i < selectedTrips.length; i++) {
                    if (selectedTrips[i] == id) {
                        allow = false;
                        $("#trip_" + id).css('border', '2px solid #a0a0a0');
                        selectedTrips.splice(i, 1);
                        break;
                    }
                }
                if (allow) {
                    $("#trip_" + id).css('border', '2px solid var(--koochita-light-green)');
                    selectedTrips[selectedTrips.length] = id;
                }
            }

            function assignPlaceToTrip() {
                if (selectedPlaceId != -1) {
                    var checkedValuesTrips = selectedTrips;
                    if (checkedValuesTrips == null || checkedValuesTrips.length == 0)
                        checkedValuesTrips = "empty";
                    $.ajax({
                        type: 'post',
                        url: assignPlaceToTripDir,
                        data: {
                            'checkedValuesTrips': checkedValuesTrips,
                            'placeId': selectedPlaceId,
                            'kindPlaceId': selectedKindPlaceId
                        },
                        success: function (response) {
                            if (response == "ok")
                                document.location.href = hotelDetails;
                            else {
                                err = "<p>به جز سفر های زیر که اجازه ی افزودن مکان به آنها را نداشتید بقیه به درستی اضافه شدند</p>";
                                response = JSON.parse(response);
                                for (i = 0; i < response.length; i++)
                                    err += "<p>" + response[i] + "</p>";
                                $("#errorAssignPlace").append(err);
                            }
                        }
                    });
                }
            }

            function showUpdateReserveResult() {
                $(".update_results_button").removeClass('hidden');
            }

            function showChildBox(val, childAge) {
                var newElement = "";
                for (i = 0; i < val; i++) {
                    newElement += "<span class='unified-picker age-picker'><select id='child_" + (i + 1) + "'>";
                    newElement += "<option value='none'>سن</option>";
                    for (j = 1; j <= childAge; j++) {
                        newElement += "<option value='" + j + "'>" + j + "</option>";
                    }
                    newElement += "</select></span>";
                }
                $("#ages-wrap").empty().append(newElement);
            }

            function changeCommentPage(element) {
                $('.pageNumComment').removeClass('current').addClass('taLnk');
                $(element).removeClass('taLnk');
                $(element).addClass('current');
                if ($(element).attr('data-page-number')) {
                    currPage = $(element).attr('data-page-number');
                    comments(selectedTag);
                    location.href = "#taplc_location_review_keyword_search_hotels_0_search";
                }
            }

            function changePageQuestion(element) {
                $('.pageNumComment').removeClass('current').addClass('taLnk');
                $(element).removeClass('taLnk');
                $(element).addClass('current');
                if ($(element).attr('data-page-number')) {
                    currPageQuestions = $(element).attr('data-page-number');
                    questions();
                    location.href = "#taplc_location_qa_hotels_0";
                }
            }

            function showAskQuestion() {
                if (!hasLogin) {
                    showLoginPrompt(hotelDetailsInAskQuestionMode);
                    return;
                }
                $(".askQuestionForm").removeClass('hidden');
                document.href = ".askQuestionForm";
            }

            function hideAskQuestion() {
                $(".askQuestionForm").addClass('hidden');
            }

            function askQuestion() {
                if (!hasLogin) {
                    showLoginPrompt(hotelDetailsInAskQuestionMode);
                    return;
                }
                if ($("#questionTextId").val() == "")
                    return;
                $.ajax({
                    type: 'post',
                    url: askQuestionDir,
                    data: {
                        'placeId': placeId,
                        'kindPlaceId': kindPlaceId,
                        'text': $("#questionTextId").val()
                    },
                    success: function (response) {
                        if (response == "ok") {
                            $(".dark").css('display', '');
                            $("#questionSubmitted").removeClass('hidden');
                        }
                    }
                });
            }


            function comments(tag) {
                selectedTag = tag;
                filter();
            }

            function questions() {
                $.ajax({
                    type: 'post',
                    url: getQuestions,
                    data: {
                        'placeId': placeId,
                        'kindPlaceId': kindPlaceId,
                        'page': currPageQuestions
                    },
                    success: function (response) {
                        showQuestions(JSON.parse(response));
                    }
                });
            }

            $(window).ready(function () {

                {{--@foreach($sections as $section)--}}
                {{--fillMyDivWithAdv('{{$section->sectionId}}', '{{$state->id}}');--}}
            {{--@endforeach--}}

            checkOverFlow();
                $('.menu').addClass('original').clone().insertAfter('.menu').addClass('cloned').css('position', 'fixed').css('top', '0').css('margin-top', '0').css('z-index', '500').removeClass('original').hide();
                scrollIntervalID = setInterval(stickIt, 10);
                $(".close_album").click(function () {
                    $("#photo_album_span").hide();
                });
                var i;
                {{--photos[0] = '{{$photos[0]}}';--}}
                //            for (i = 1; i < totalPhotos; i++)
                //                photos[i] = -1;
                //            for (i = 1; i < totalPhotos - sitePhotosCount; i++)
                //                photos2[i] = -1;
                currPage = 1;
                comments(-1);
                questions();
                roundRobinPhoto = -1;
                photoRoundRobin(1);
                if (totalPhotos - sitePhotosCount > 0) {
                    roundRobinPhoto2 = -1;
                    photoRoundRobin2(1);
                }
                $(".img_popUp").on({
                    mouseenter: function () {
                        $(".img_popUp").removeClass('hidden');
                    },
                    mouseleave: function () {
                        $(".img_popUp").addClass('hidden');
                    }
                });
                $('.ui_tagcloud').click(function () {
                    $(".ui_tagcloud").removeClass('selected');
                    $(this).addClass("selected");
                    if ($(this).attr("data-content")) {
                        var data_content = $(this).attr("data-content");
                        currPage = 1;
                        comments(data_content);
                    }
                });
            });

            function getSliderPhoto(mode, val, mode2) {
                var url = (mode2 == 2) ? '{{route('getSlider2Photo')}}' : '{{route('getSlider1Photo')}}';
                $.ajax({
                    type: 'post',
                    url: url,
                    data: {
                        {{--'placeId': '{{$place->id}}',--}}
                                {{--'kindPlaceId': '{{$kindPlaceId}}',--}}
                        'val': val
                    },
                    success: function (response) {
                        if (response != "nok") {
                            if (mode == 1) {
                                photos[roundRobinPhoto] = response;
                                $(".carousel_images_header").css('background', "url(" + photos[roundRobinPhoto] + ") no-repeat")
                                        .css('background-size', "cover");
                            }
                            else {
                                photos2[roundRobinPhoto2] = response;
                                $(".carousel_images_footer").css('background', "url(" + photos2[roundRobinPhoto2] + ") no-repeat")
                                        .css('background-size', "cover");
                            }
                        }
                    }
                });
            }

            function photoRoundRobin(val) {
                if (roundRobinPhoto + val < totalPhotos && roundRobinPhoto + val >= 0)
                    roundRobinPhoto += val;
                if (photos[roundRobinPhoto] != -1) {
                    $(".carousel_images_header").css('background', "url(" + photos[roundRobinPhoto] + ") no-repeat")
                            .css('background-size', "cover");
                }
                else {
                    if (roundRobinPhoto + 1 <= sitePhotosCount)
                        getSliderPhoto(1, roundRobinPhoto + 1, 1);
                    else
                        getSliderPhoto(1, roundRobinPhoto + 1 - sitePhotosCount, 2);
                }
                if (roundRobinPhoto + 1 >= totalPhotos)
                    $('.right-nav-header').addClass('hidden');
                else
                    $('.right-nav-header').removeClass('hidden');
                if (roundRobinPhoto - 1 < 0)
                    $('.left-nav-header').addClass('hidden');
                else
                    $('.left-nav-header').removeClass('hidden');
            }

            function photoRoundRobin2(val) {
                if (roundRobinPhoto2 + val < totalPhotos - sitePhotosCount && roundRobinPhoto2 + val >= 0)
                    roundRobinPhoto2 += val;
                if (photos2[roundRobinPhoto2] != -1) {
                    $(".carousel_images_footer").css('background', "url(" + photos2[roundRobinPhoto2] + ") no-repeat")
                            .css('background-size', "cover");
                }
                else {
                    getSliderPhoto(2, roundRobinPhoto2, 2);
                }
                if (roundRobinPhoto2 + 1 >= totalPhotos - sitePhotosCount)
                    $('.right-nav-footer').addClass('hidden');
                else
                    $('.right-nav-footer').removeClass('hidden');
                if (roundRobinPhoto2 - 1 < 0)
                    $('.left-nav-footer').addClass('hidden');
                else
                    $('.left-nav-footer').removeClass('hidden');
            }

            function showComments(arr) {
                $("#reviewsContainer").empty();
                var checkedValues = $("input:checkbox[name='filterComment[]']:checked").map(function () {
                    return this.value;
                }).get();
                if (checkedValues.length == 0)
                    checkedValues = -1;
                $.ajax({
                    type: 'post',
                    url: getCommentsCount,
                    data: {
                        'placeId': placeId,
                        'kindPlaceId': kindPlaceId,
                        'tag': selectedTag,
                        'filters': checkedValues
                    },
                    success: function (response) {
                        response = JSON.parse(response);
                        $(".seeAllReviews").empty().append(response[1] + " نقد");
                        $(".reviews_header_count").empty().append("(" + response[1] + " نقد)");
                        var newElement = "<p id='pagination-details' class='pagination-details' style='clear: both; padding: 12px 0 !important;'><b>" + response[0] + "</b> از <b>" + response[1] + "</b> نقد</p>";
                                {{--if (response[1] == 0) {--}}
                                {{--tmp = "<p style='font-size: 15px; color: #b7b7b7; float: right; margin: 8px 5px 8px 20px !important'>اولین نفری باشید که درباره ی این مکان نقد می نویسید</p>";--}}
                                {{--tmp += "<span style='color: #FFF !important; max-width: 100px; float: right;' onclick='document.location.href = showAddReviewPageHotel('{{route('review', ['placeId' => $place->id, 'kindPlaceId' => $kindPlaceId])}}')' class='button_war write_review ui_button primary col-xs-12'>نوشتن نقد</span>";--}}
                                {{--$("#reviewsContainer").empty().append(tmp);--}}
                                {{--}--}}
                        for (i = 0; i < arr.length; i++) {
                            newElement += "<div style='border-bottom: 1px solid #E3E3E3;' class='review'>";
                            newElement += "<div class='prw_rup prw_reviews_basic_review_hsx'>";
                            newElement += "<div class='reviewSelector'>";
                            newElement += "<div class='review hsx_review ui_columns is-multiline inlineReviewUpdate provider0'>";
                            newElement += "<div class='ui_column is-2' style='float: right;'>";
                            newElement += "<div class='prw_rup prw_reviews_member_info_hsx'>";
                            newElement += "<div class='member_info'>";
                            newElement += "<div class='avatar_wrap'>";
                            newElement += "<div class='prw_rup prw_common_centered_image qa_avatar' onmouseleave='$(\".img_popUp\").addClass(\"hidden\");' onmouseenter='showBriefPopUp(this, \"" + arr[i].visitorId + "\")'>";
                            newElement += "<span class='imgWrap fixedAspect' style='max-width:80px; padding-bottom:100.000%'>";
                            newElement += "<img src='" + arr[i].visitorPic + "' class='centeredImg' height='100%' style='border-radius: 100%;'/>";
                            newElement += "</span></div>";
                            newElement += "<div class='username' style='text-align: center;margin-top: 5px;'>" + arr[i].visitorId + "</div>";
                            newElement += "</div>";
                            newElement += "<div class='memberOverlayLink'>";
                            newElement += "<div class='memberBadgingNoText'><span class='ui_icon pencil-paper'></span><span class='badgetext'>" + arr[i].comments + "</span>&nbsp;&nbsp;";
                            newElement += "<span class='ui_icon thumbs-up-fill'></span><span id='commentLikes_" + arr[i].id + "' data-val='" + arr[i].likes + "' class='badgetext'>" + arr[i].likes + "</span>&nbsp;&nbsp;";
                            newElement += "<span class='ui_icon thumbs-down-fill'></span><span id='commentDislikes_" + arr[i].id + "' data-val='" + arr[i].dislikes + "' class='badgetext'>" + arr[i].dislikes + "</span>";
                            newElement += "</div>";
                            newElement += "</div></div></div></div>";
                            newElement += "<div class='ui_column is-9' style='float: right;'>";
                            newElement += "<div class='innerBubble'>";
                            newElement += "<div class='wrap'>";
                            newElement += "<div class='rating reviewItemInline'>";
                            switch (arr[i].rate) {
                                case 5:
                                    newElement += "<span class='ui_bubble_rating bubble_50'></span>";
                                    break;
                                case 4:
                                    newElement += "<span class='ui_bubble_rating bubble_40'></span>";
                                    break;
                                case 3:
                                    newElement += "<span class='ui_bubble_rating bubble_30'></span>";
                                    break;
                                case 2:
                                    newElement += "<span class='ui_bubble_rating bubble_20'></span>";
                                    break;
                                default:
                                    newElement += "<span class='ui_bubble_rating bubble_10'></span>";
                                    break;
                            }
                            newElement += "<span class='ratingDate relativeDate' style='float: right;'>نوشته شده در تاریخ " + arr[i].date + " </span></div>";
                            newElement += "<div class='quote isNew'><a href='" + homePath + "/showReview/" + arr[i].id + "'><h2 style='font-size: 1em;' class='noQuotes'>" + arr[i].subject + "</h2></a></div>";
                            newElement += "<div class='prw_rup prw_reviews_text_summary_hsx'>";
                            newElement += "<div class='entry'>";
                            newElement += "<p class='partial_entry' id='partial_entry_" + arr[i].id + "' style='line-height: 20px; max-height: 70px; overflow: hidden; padding: 10px; font-size: 12px'>" + arr[i].text;
                            newElement += "</p>";
                            newElement += "<div style='color: #16174f;cursor: pointer;text-align: left;' id='showMoreReview_" + arr[i].id + "' class='hidden' onclick='showMoreReview(" + arr[i].id + ")'>بیشتر</div></div></div>";
                            if (arr[i].pic != -1)
                                newElement += "<div><img id='reviewPic_" + arr[i].id + "' class='hidden' width='150px' height='150px' src='" + arr[i].pic + "'></div>";
                            newElement += "<div class='prw_rup prw_reviews_vote_line_hsx'>";
                            newElement += "<div class='tooltips wrap'><span style='cursor: pointer;font-size: 10px;color: #16174f' onclick='showReportPrompt(\"" + arr[i].id + "\")' class='taLnk no_cpu ui_icon '>گزارش تخلف</span></div>";
                            newElement += "<div class='helpful redesigned hsx_helpful'>";
                            newElement += "<span onclick='likeComment(\"" + arr[i].id + "\")' class='thankButton hsx_thank_button'>";
                            newElement += "<span class='helpful_text'><span class='ui_icon thumbs-up-fill emphasizeWithColor'></span><span class='numHelp emphasizeWithColor'></span><span class='thankUser'>" + arr[i].visitorId + " </span></span>";
                            newElement += "<div class='buttonShade hidden'><img src='https://static.tacdn.com/img2/generic/site/loading_anim_gry_sml.gif'/></div>";
                            newElement += "</span>";
                            newElement += "<span onclick='dislikeComment(\"" + arr[i].id + "\")' class='thankButton hsx_thank_button'>";
                            newElement += "<span class='helpful_text'><span class='ui_icon thumbs-down-fill emphasizeWithColor'></span><span class='numHelp emphasizeWithColor'></span><span class='thankUser'>" + arr[i].visitorId + " </span></span>";
                            newElement += "<div class='buttonShade hidden'><img src='https://static.tacdn.com/img2/generic/site/loading_anim_gry_sml.gif'/></div>";
                            newElement += "</span>";
                            newElement += "</div></div></div>";
                            newElement += "<div class='loadingShade hidden'>";
                            newElement += "<div class='ui_spinner'></div></div></div></div></div></div></div></div>";
                        }
                        $("#reviewsContainer").append(newElement);
                        for (i = 0; i < arr.length; i++) {
                            scrollHeight = $("#partial_entry_" + arr[i].id).prop('scrollHeight');
                            offsetHeight = $("#partial_entry_" + arr[i].id).prop('offsetHeight');
                            if (offsetHeight < scrollHeight) {
                                $('#showMoreReview_' + arr[i].id).removeClass('hidden');
                            }
                            else {
                                $('#showMoreReview_' + arr[i].id).addClass('hidden');
                            }
                        }
                        newElement = "";
                        limit = Math.ceil(response[0] / 6);
                        preCurr = passCurr = false;
                        for (k = 1; k <= limit; k++) {
                            if (Math.abs(currPage - k) < 4 || k == 1 || k == limit) {
                                if (k == currPage) {
                                    newElement += "<span data-page-number='" + k + "' class='pageNum current pageNumComment'>" + k + "</span>";
                                }
                                else {
                                    newElement += "<a onclick='changeCommentPage(this)' data-page-number='" + k + "' class='pageNum taLnk pageNumComment'>" + k + "</a>";
                                }
                            }
                            else if (k < currPage && !preCurr) {
                                preCurr = true;
                                newElement += "<span class='separator'>&hellip;</span>";
                            }
                            else if (k > currPage && !passCurr) {
                                passCurr = true;
                                newElement += "<span class='separator'>&hellip;</span>";
                            }
                        }
                        $("#pageNumCommentContainer").empty().append(newElement);
                        if ($("#commentCount").empty())
                            $("#commentCount").append(response[1]);
                    }
                });
            }

            function startHelp() {
                setGreenBackLimit(7);
                if (hasLogin) {
                    if (noAns)
                        initHelp2(16, [0, 4, 15], 'MAIN', 100, 400, [14, 15], [50, 100]);
                    else
                        initHelp2(16, [0, 4], 'MAIN', 100, 400, [15], [100]);
                }
                else {
                    if (noAns)
                        initHelp2(16, [0, 1, 2, 5, 8, 15], 'MAIN', 100, 400, [14, 15], [50, 100]);
                    else
                        initHelp2(16, [0, 1, 2, 5, 8], 'MAIN', 100, 400, [15], [100]);
                }
            }

            function showQuestions(arr) {
                $("#questionsContainer").empty();
                if (arr.length == 0) {
                    noAns = true;
                    $("#questionsContainer").append('<p class="no-question">با پرسیدن اولین سوال، از دوستان خود کمک بگیرید و به دیگران کمک کنید. سوال شما فقط به اندازه یک کلیک وقت می گیرد</p>');
                }

                var newElement;

                for (i = 0; i < arr.length; i++) {
                    newElement = "<div class='ui_column is-12' style='position: relative'><div class='ui_column is-2' style='float: right;'>";
                    newElement += "<div class='avatar_wrap'>";
                    newElement += "<div class='prw_rup prw_common_centered_image qa_avatar' onmouseleave='$(\".img_popUp\").addClass(\"hidden\");' onmouseenter='showBriefPopUp(this, \"" + arr[i].visitorId + "\")'>";
                    newElement += "<span class='imgWrap fixedAspect' style='max-width:80px; padding-bottom:100.000%'>";
                    newElement += "<img src='" + arr[i].visitorPic + "' class='centeredImg' height='100%'/>";
                    newElement += "</span></div>";
                    newElement += "<div class='username'>" + arr[i].visitorId + "</div>";
                    newElement += "</div></div>";
                    newElement += "<div class='ui_column is-8' style='position: relative'><a href='" + homePath + "/seeAllAns/" + arr[i].id + "'>" + arr[i].text + "</a>";
                    newElement += "<div class='question_date'>" + arr[i].date + "<span class='iapSep'>|</span><span style='cursor: pointer;font-size:10px;' onclick='showReportPrompt(\"" + arr[i].id + "\")' class='ui_icon'>گزارش تخلف</span></div>";
                    if (i == 0) {
                        newElement += "<div id='targetHelp_15' style='max-width: 100px; margin: 0 !important; float: right;' class='targets row'><span class='col-xs-12 ui_button primary small answerButton' onclick='showAnsPane(\"" + arr[i].id + "\")'>پاسخ ";
                        newElement += "</span>";
                        newElement += '<div id="helpSpan_15" class="helpSpans hidden">';
                        newElement += '<span class="introjs-arrow"></span>';
                        newElement += "<p>";
                        newElement += "می توانید با این دکمه به سوال ها پاسخ دهید تا دوستا ن تان هم به سوالات شما پاسخ دهند.";
                        newElement += "</p>";
                        newElement += '<button data-val="15" class="btn btn-success nextBtnsHelp" id="nextBtnHelp_15">بعدی</button>';
                        newElement += '<button onclick="show(14, -1)" data-val="15" class="btn btn-primary backBtnsHelp" id="backBtnHelp_15">قبلی</button>';
                        newElement += '<button onclick="myQuit();" class="btn btn-danger exitBtnHelp">خروج</button>';
                        newElement += '</div>';
                        newElement += "</div>";
                    }
                    else {
                        newElement += "<span class='ui_button primary small answerButton' style='float: right;' onclick='showAnsPane(\"" + arr[i].id + "\")'>پاسخ ";
                        newElement += "</span>";
                    }
                    newElement += "<span style='float: right; margin-top: 12px' class='ui_button secondary small' id='showAll_" + arr[i].id + "' onclick='showAllAns(\"" + arr[i].id + "\", -1)'>نمایش " + arr[i].ansNum + " جواب</span> ";
                    newElement += "<span class='ui_button secondary small hidden' id='hideAll_" + arr[i].id + "' onclick='showAllAns(\"" + arr[i].id + "\", 1)'>پنهان کردن جواب ها</span>";
                    newElement += "<div class='confirmDeleteExplanation hidden'>آیا می خواهی این سوال حذف شود ؟</div>";
                    newElement += "<span class='ui_button primary small delete hidden'>Delete</span>";
                    newElement += "<span class='ui_button primary small confirmDelete hidden'>Confirm</span>";
                    newElement += "<span class='ui_button secondary small cancelDelete hidden'>Cancel</span>";
                    newElement += "<div class='answerForm hidden' id='answerForm_" + arr[i].id + "'>";
                    newElement += "<div class='whatIsYourAnswer'>جواب شما چیست ؟</div>";
                    newElement += "<textarea class='answerText ui_textarea' id='answerText_" + arr[i].id + "' placeholder='سلام ، جواب خود را وارد کنید'></textarea>";
                    newElement += "<ul class='errors hidden'></ul>";
                    newElement += "<a target='_blank' href='" + soon + "' class='postingGuidelines' style='float: left;'>راهنما  و قوانین</a>";
                    newElement += "<div><span class='ui_button primary small formSubmit' onclick='sendAns(\"" + arr[i].id + "\")'>ارسال</span>";
                    newElement += "<span class='ui_button secondary small' onclick='hideAnsPane()'>لغو</span></div>";
                    newElement += "<div class='captcha_here'></div>";
                    newElement += "</div>";
                    newElement += "<div id='response_" + arr[i].id + "' class='answerList hidden' style='clear:both !important;'>";
                    newElement += "</div><p id='ans_err_" + arr[i].id + "'></p></div></div><div style='clear: both;'></div> ";
                    $("#questionsContainer").append(newElement);
                }
                $("#pageNumQuestionContainer").empty();
                // newElement = "";
                // limit = Math.ceil(response[0] / 6);
                // preCurr = passCurr = false;
                //
                // for(k = 1; k <= limit; k++) {
                //     if(Math.abs(currPageQuestions - k) < 4 || k == 1 || k == limit) {
                //         if (k == currPageQuestions) {
                //             newElement += "<span data-page-number='" + k + "' class='pageNum current pageNumQuestion'>" + k + "</span>";
                //         }
                //         else {
                //             newElement += "<a onclick='changePageQuestion(this)' data-page-number='" + k + "' class='pageNum taLnk pageNumQuestion'>" + k + "</a>";
                //         }
                //     }
                //     else if(k < currPage && !preCurr) {
                //         preCurr = true;
                //         newElement += "<span class='separator'>&hellip;</span>";
                //     }
                //     else if(k > currPage && !passCurr) {
                //         passCurr = true;
                //         newElement += "<span class='separator'>&hellip;</span>";
                //     }
                // }
                //
                // $("#pageNumQuestionContainer").append(newElement);
            }

            function toggleMoreCities() {
                if ($('#moreCities').hasClass('hidden')) {
                    $('#moreCities').removeClass('hidden');
                    $('#moreLessSpan').empty().append('شهر های کمتر');
                }
                else {
                    $('#moreCities').addClass('hidden');
                    $('#moreLessSpan').empty().append('شهر های بیشتر');
                }
            }

            function customReport() {
                if ($("#custom-checkBox").is(':checked')) {
                    var newElement = "<div class='col-xs-12'>";
                    newElement += "<textarea id='customDefinedReport' style='width: 375px; height:120px; padding: 5px !important; margin-top: 5px;' maxlength='1000' required placeholder='حداکثر 1000 کاراکتر'></textarea>";
                    newElement += "</label></div>";
                    $("#custom-define-report").empty().append(newElement).css("visibility", "visible");
                }
                else {
                    $("#custom-define-report").empty().css("visibility", "hidden");
                }
            }

            function getReports(logId) {
                $("#reports").empty();
                $.ajax({
                    type: 'post',
                    url: getReportsDir,
                    data: {
                        'logId': logId
                    },
                    success: function (response) {
                        if (response != "")
                            response = JSON.parse(response);
                        var newElement = "<div id='reportContainer' class='row'>";
                        if (response != "") {
                            for (i = 0; i < response.length; i++) {
                                newElement += "<div class='col-xs-12'>";
                                newElement += "<div class='ui_input_checkbox'>";
                                if (response[i].selected == true)
                                    newElement += "<input id='report_" + response[i].id + "' type='checkbox' name='reports' checked value='" + response[i].id + "'>";
                                else
                                    newElement += "<input id='report_" + response[i].id + "' type='checkbox' name='reports' value='" + response[i].id + "'>";
                                newElement += "<label class='labelForCheckBox' for='report_" + response[i].id + "'>";
                                newElement += "<span></span>&nbsp;&nbsp;";
                                newElement += response[i].description;
                                newElement += "</label>";
                                newElement += "</div></div>";
                            }
                        }
                        newElement += "<div class='col-xs-12'>";
                        newElement += "<div class='ui_input_checkbox'>";
                        newElement += "<input id='custom-checkBox' onchange='customReport()' type='checkbox' name='reports' value='-1'>";
                        newElement += "<label class='labelForCheckBox' for='custom-checkBox'>";
                        newElement += "<span></span>&nbsp;&nbsp;";
                        newElement += "سایر موارد</label>";
                        newElement += "</div></div>";
                        newElement += "<div id='custom-define-report' style='visibility: hidden'></div>";
                        newElement += "</div>";
                        $("#reports").append(newElement);
                        if (response != "" && response.length > 0 && response[0].text != "") {
                            customReport();
                            $("#customDefinedReport").val(response[0].text);
                        }
                    }
                });
            }

            function sendReport() {
                customMsg = "";
                if ($("#customDefinedReport").val() != null)
                    customMsg = $("#customDefinedReport").val();
                var checkedValuesReports = $("input:checkbox[name='reports']:checked").map(function () {
                    return this.value;
                }).get();
                if (checkedValuesReports.length <= 0)
                    return;
                if (!hasLogin) {
                    url = homePath + "/seeAllAns/" + questionId + "/report/" + selectedLogId;
                    showLoginPrompt(url);
                    return;
                }
                $.ajax({
                    type: 'post',
                    url: sendReportDir,
                    data: {
                        "logId": selectedLogId,
                        "reports": checkedValuesReports,
                        "customMsg": customMsg
                    },
                    success: function (response) {
                        if (response == "ok") {
                            closeReportPrompt();
                        }
                        else {
                            $("#errMsgReport").append('مشکلی در انجام عملیات مورد نقد رخ داده است');
                        }
                    }
                });
            }

            function closeReportPrompt() {
                $("#custom-checkBox").css("visibility", 'hidden');
                $("#custom-define-report").css("visibility", 'hidden');
                $("#reportPane").addClass('hidden');
                $('.dark').hide();
            }

            function showReportPrompt(logId) {
                if (!hasLogin) {
                    url = homePath + "/seeAllAns/" + questionId + "/report/" + logId;
                    showLoginPrompt(url);
                    return;
                }
                $('.dark').show();
                selectedLogId = logId;
                getReports(logId);
                showElement('reportPane');
            }

            function showAnsPane(logId) {
                $(".answerForm").addClass('hidden');
                $("#answerForm_" + logId).removeClass('hidden');
            }

            function hideAnsPane() {
                $(".answerForm").addClass('hidden');
            }

            function sendAns(logId) {
                if (!hasLogin) {
                    showLoginPrompt(hotelDetailsInAnsMode);
                    return;
                }
                if ($("#answerText_" + logId).val() == "")
                    return;
                $.ajax({
                    type: 'post',
                    url: sendAnsDir,
                    data: {
                        'placeId': placeId,
                        'kindPlaceId': kindPlaceId,
                        'text': $("#answerText_" + logId).val(),
                        'relatedTo': logId
                    },
                    success: function (response) {
                        if (response == "ok") {
                            $(".dark").css('display', '');
                            $('#ansSubmitted').removeClass('hidden');
                        }
                        else {
                            $("#ans_err_" + logId).empty().append('تنها یکبار می توانید به هر سوال پاسخ دهید');
                        }
                    }
                });
            }

            function showAllAns(logId, num) {
                $.ajax({
                    type: 'post',
                    url: showAllAnsDir,
                    data: {
                        'logId': logId,
                        'num': num
                    },
                    success: function (response) {
                        if (num == -1) {
                            $("#hideAll_" + logId).removeClass('hidden');
                            $("#showAll_" + logId).addClass('hidden');
                            $("#response_" + logId).removeClass('hidden');
                        }
                        else {
                            $("#hideAll_" + logId).addClass('hidden');
                            $("#showAll_" + logId).removeClass('hidden');
                            $("#response_" + logId).addClass('hidden');
                        }
                        response = JSON.parse(response);
                        newElement = "";
                        for (i = 0; i < response.length; i++) {
                            newElement += "<div class='prw_rup prw_common_location_posting'>";
                            newElement += "<div class='response'>";
                            newElement += "<div class='header' style='margin-right:22%;'><span>پاسخ از " + response[i].visitorId + "</span> | ";
                            newElement += "<span class='iapSep'>|</span>";
                            newElement += "<span style='cursor: pointer;font-size:10px;' onclick='showReportPrompt(\"" + response[i].id + "\")' class='ui_icon '>گزارش تخلف</span>";
                            newElement += "</div>";
                            newElement += "<div class='content'>";
                            newElement += "<div class='abbreviate'>" + response[i].text;
                            newElement += "</div></div>";
                            newElement += "<div class='confirmDeleteExplanation hidden'>آیا می خواهی این سوال حذف شود ؟</div>";
                            newElement += "<span class='ui_button primary small delete hidden'>حذف</span> <span class='ui_button primary small confirmDelete hidden'>ثبت</span> <span class='ui_button secondary small cancelDelete hidden'>لغو</span>";
                            newElement += "<div class='votingForm'>";
                            newElement += "<div class='voteIcon' onclick='likeAns(" + response[i].id + ")'>";
                            newElement += "<div class='ui_icon single-chevron-up-circle'></div>";
                            newElement += "<div class='ui_icon single-chevron-up-circle-fill'></div>";
                            newElement += "<div class='contents hidden'>پاسخ مفید</div>";
                            newElement += "</div>";
                            newElement += "<div class='voteCount'>";
                            newElement += "<div class='score' data-val='" + response[i].rate + "' id='score_" + response[i].id + "'>" + response[i].rate + "</div>";
                            newElement += "<div>نقد من</div>";
                            newElement += "</div>";
                            newElement += "<div class='voteIcon' onclick='dislikeAns(" + response[i].id + ")'>";
                            newElement += "<div class='ui_icon single-chevron-down-circle-fill'></div>";
                            newElement += "<div class='ui_icon single-chevron-down-circle'></div>";
                            newElement += "<div class='contents hidden'>پاسخ غیر مفید</div>";
                            newElement += "</div></div></div></div>";
                        }
                        $("#response_" + logId).empty().append(newElement);
                    }
                });
            }

            function likeComment(logId) {
                $.ajax({
                    type: 'post',
                    url: opOnComment,
                    data: {
                        'logId': logId,
                        'mode': 'like'
                    },
                    success: function (response) {
                        if (response == "1") {
                            $("#commentLikes_" + logId).empty()
                                    .attr('data-val', parseInt($("#commentLikes_" + logId).attr('data-val')) + 1)
                                    .append($("#commentLikes_" + logId).attr('data-val'));
                        }
                        else if (response == "2") {
                            $("#commentLikes_" + logId).empty()
                                    .attr('data-val', parseInt($("#commentLikes_" + logId).attr('data-val')) + 1)
                                    .append($("#commentLikes_" + logId).attr('data-val'));
                            $("#commentDislikes_" + logId).empty()
                                    .attr('data-val', parseInt($("#commentDislikes_" + logId).attr('data-val')) - 1)
                                    .append($("#commentDislikes_" + logId).attr('data-val'));
                        }
                    }
                });
            }

            function likeAns(logId) {
                $.ajax({
                    type: 'post',
                    url: opOnComment,
                    data: {
                        'logId': logId,
                        'mode': 'like'
                    },
                    success: function (response) {
                        if (response == "1") {
                            $("#score_" + logId).empty()
                                    .attr('data-val', parseInt($("#score_" + logId).attr('data-val')) + 1)
                                    .append($("#score_" + logId).attr('data-val'));
                        }
                        else if (response == "2") {
                            $("#score_" + logId).empty()
                                    .attr('data-val', parseInt($("#score_" + logId).attr('data-val')) + 2)
                                    .append($("#score_" + logId).attr('data-val'));
                        }
                    }
                });
            }

            function dislikeAns(logId) {
                $.ajax({
                    type: 'post',
                    url: opOnComment,
                    data: {
                        'logId': logId,
                        'mode': 'dislike'
                    },
                    success: function (response) {
                        if (response == "1") {
                            $("#score_" + logId).empty()
                                    .attr('data-val', parseInt($("#score_" + logId).attr('data-val')) - 1)
                                    .append($("#score_" + logId).attr('data-val'));
                        }
                        else if (response == "2") {
                            $("#score_" + logId).empty()
                                    .attr('data-val', parseInt($("#score_" + logId).attr('data-val')) - 2)
                                    .append($("#score_" + logId).attr('data-val'));
                        }
                    }
                });
            }

            function dislikeComment(logId) {
                $.ajax({
                    type: 'post',
                    url: opOnComment,
                    data: {
                        'logId': logId,
                        'mode': 'dislike'
                    },
                    success: function (response) {
                        if (response == "1") {
                            $("#commentDislikes_" + logId).empty()
                                    .attr('data-val', parseInt($("#commentDislikes_" + logId).attr('data-val')) + 1)
                                    .append($("#commentDislikes_" + logId).attr('data-val'));
                        }
                        else if (response == "2") {
                            $("#commentDislikes_" + logId).empty()
                                    .attr('data-val', parseInt($("#commentDislikes_" + logId).attr('data-val')) + 1)
                                    .append($("#commentDislikes_" + logId).attr('data-val'));
                            $("#commentLikes_" + logId).empty()
                                    .attr('data-val', parseInt($("#commentLikes_" + logId).attr('data-val')) - 1)
                                    .append($("#commentLikes_" + logId).attr('data-val'));
                        }
                    }
                });
            }

            function filter() {
                var checkedValues = $("input:checkbox[name='filterComment[]']:checked").map(function () {
                    return this.value;
                }).get();
                if (checkedValues.length == 0)
                    checkedValues = -1;
                $.ajax({
                    type: 'post',
                    url: filterComments,
                    data: {
                        'filters': checkedValues,
                        'placeId': placeId,
                        'kindPlaceId': kindPlaceId,
                        'tag': selectedTag,
                        'page': currPage
                    },
                    success: function (response) {
                        showComments(JSON.parse(response));
                    }
                });
            }

            function showAddPhotoPane() {
                if (!hasLogin) {
                    showLoginPrompt(hotelDetailsInAddPhotoMode);
                    return;
                }
                $('.dark').show();
                showElement('photoEditor');
                getPhotoFilters();
            }

            function checkSendPhotoBtnAbility() {
                var checkedValues = $("input:radio[name='filter']:checked").map(function () {
                    return this.value;
                }).get();
                if (checkedValues.length == 0) {
                    $("#sendPhotoBtn").attr('disabled', 'disabled');
                }
                else {
                    $("#sendPhotoBtn").removeAttr('disabled');
                }
            }

            function getPhotoFilters() {
                $.ajax({
                    type: 'post',
                    url: getPhotoFilter,
                    data: {
                        'kindPlaceId': kindPlaceId
                    },
                    success: function (response) {
                        response = JSON.parse(response);
                        newElement = "";
                        for (i = 0; i < response.length; i++) {
                            newElement += '<div class="ui_input_checkbox radioOption" style="float: right !important;">';
                            newElement += '<input type="radio" name="mask" value="' + response[i].id + '" id="cat_file_' + response[i].id + '">';
                            newElement += '<label class="labelForCheckBox" for="cat_file_' + response[i].id + '">';
                            newElement += '<span></span>&nbsp;&nbsp;';
                            newElement += response[i].name + '</label>'
                            newElement += '</div><div style="clear: both"></div>';
                        }
                        $("#photoTags").empty().append(newElement);
                    }
                });
            }

            function showDetails(username) {
                if (username == null)
                    return;
                $.ajax({
                    type: 'post',
                    url: showUserBriefDetail,
                    data: {
                        'username': username
                    },
                    success: function (response) {
                        if (response.length == 0)
                            return;
                        response = JSON.parse(response);
                        total = response.excellent + response.veryGood + response.average + response.bad + response.veryBad;
                        total /= 100;
                        var newElement = "<div class='arrow' style='margin: 0 30px 155px 0;'></div>";
                        newElement += "<div class='body_text'>";
                        newElement += "<div class='memberOverlay simple container moRedesign'>";
                        newElement += "<div class='innerContent'>";
                        newElement += "<div class='memberOverlayRedesign g10n'>";
                        newElement += "<a href='" + homePath + "/profile/index/" + username + "'>";
                        newElement += "<h3 class='username reviewsEnhancements'>" + username + "</h3>";
                        newElement += "</a>";
                        newElement += "<div class='memberreviewbadge'>";
                        newElement += "<div class='badgeinfo'>";
                        newElement += "سطح <span>" + response.level + "</span>";
                        newElement += "</div></div>";
                        newElement += "<ul class='memberdescriptionReviewEnhancements'>";
                        newElement += "<li>تاریخ عضویت در سایت " + response.created + "</li>";
                        newElement += "<li>از " + response.city + " در " + response.state + " </li>";
                        newElement += "</ul>";
                        newElement += "<ul class='countsReviewEnhancements'>";
                        newElement += "<li class='countsReviewEnhancementsItem'>";
                        newElement += "<span class='ui_icon pencil-paper iconReviewEnhancements'></span>";
                        newElement += "<span class='badgeTextReviewEnhancements'>" + response.rates + " نقد</span>";
                        newElement += "</li>";
                        newElement += "<li class='countsReviewEnhancementsItem'>";
                        newElement += "<span class='ui_icon globe-world iconReviewEnhancements'></span>";
                        newElement += "<span class='badgeTextReviewEnhancements'>" + response.seen + " مشاهده</span>";
                        newElement += "</li>";
                        newElement += "<li class='countsReviewEnhancementsItem'>";
                        newElement += "<span class='ui_icon thumbs-up-fill iconReviewEnhancements'></span>";
                        newElement += "<span class='badgeTextReviewEnhancements'>" + response.likes + " رای مثبت</span>";
                        newElement += "</li>";
                        newElement += "<li class='countsReviewEnhancementsItem'>";
                        newElement += "<span class='ui_icon thumbs-down-fill iconReviewEnhancements'></span>";
                        newElement += "<span class='badgeTextReviewEnhancements'>" + response.dislikes + " رای منفی</span>";
                        newElement += "</li>";
                        newElement += "</ul>";
                        newElement += "<div class='wrap'>";
                        newElement += "<ul class='memberTagsReviewEnhancements'>";
                        newElement += "</ul></div>";
                        newElement += "<div class='wrap'>";
                        newElement += "<div class='wrap container histogramReviewEnhancements'>";
                        newElement += "<div class='barlogoReviewEnhancements'>";
                        newElement += "<span>پراکندگی نقدها</span>";
                        newElement += "</div><ul>";
                        newElement += "<div class='chartRowReviewEnhancements'>";
                        newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>عالی</span>";
                        newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
                        newElement += "<span class='barReviewEnhancements'>";
                        newElement += "<span class='fillReviewEnhancements' style='width:" + response.excellent / total + "%;'></span>";
                        newElement += "</span></span>";
                        newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.excellent + "</span>";
                        newElement += "</div>";
                        newElement += "<div class='chartRowReviewEnhancements'>";
                        newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>خوب</span>";
                        newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
                        newElement += "<span class='barReviewEnhancements'>";
                        newElement += "<span class='fillReviewEnhancements' style='width:" + response.veryGood / total + "%;'></span>";
                        newElement += "</span></span>";
                        newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.veryGood + "</span>";
                        newElement += "</div>";
                        newElement += "<div class='chartRowReviewEnhancements'>";
                        newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>معمولی</span>";
                        newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
                        newElement += "<span class='barReviewEnhancements'>";
                        newElement += "<span class='fillReviewEnhancements' style='width:" + response.average / total + "%;'></span>";
                        newElement += "</span></span>";
                        newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.average + "</span>";
                        newElement += "</div>";
                        newElement += "<div class='chartRowReviewEnhancements'>";
                        newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>ضعیف</span>";
                        newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
                        newElement += "<span class='barReviewEnhancements'>";
                        newElement += "<span class='fillReviewEnhancements' style='width:" + response.bad / total + "%;'></span>";
                        newElement += "</span></span>";
                        newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.bad + "</span>";
                        newElement += "</div>";
                        newElement += "<div class='chartRowReviewEnhancements'>";
                        newElement += "<span class='rowLabelReviewEnhancements rowCellReviewEnhancements'>خیلی بد</span>";
                        newElement += "<span class='rowBarReviewEnhancements rowCellReviewEnhancements'>";
                        newElement += "<span class='barReviewEnhancements'>";
                        newElement += "<span class='fillReviewEnhancements' style='width:" + response.veryBad / total + "%;'></span>";
                        newElement += "</span></span>";
                        newElement += "<span class='rowCountReviewEnhancements rowCellReviewEnhancements'> " + response.veryBad + "</span>";
                        newElement += "</div></ul></div></div></div></div></div></div>";
                        $(".img_popUp").empty().append(newElement).removeClass('hidden');
                    }
                });
            }

            function showBriefPopUp(thisVar, owner) {
                var bodyRect = document.body.getBoundingClientRect(),
                        elemRect = thisVar.getBoundingClientRect(),
                        offset = elemRect.top - bodyRect.top,
                        offset2 = elemRect.left - bodyRect.left;
                if (offset < 0)
                    offset = Math.abs(offset);
                $(".img_popUp").css("top", offset).css("left", offset2 - 450);
                showDetails(owner);
            }

            function stickIt() {
                var orgElementPos = $('.original').offset();
                orgElementTop = orgElementPos.top;
                if ($(window).scrollTop() >= (orgElementTop)) {
                    // scrolled past the original position; now only show the cloned, sticky element.
                    // Cloned element should always have same left position and width as original element.
                    orgElement = $('.original');
                    coordsOrgElement = orgElement.offset();
                    leftOrgElement = coordsOrgElement.left;
                    widthOrgElement = orgElement.css('width');
                    $('.cloned').addClass('my_moblie_hidden')
                            .css('left', '0%').css('top', 0).css('font-size', '13px').css('right', '0%').css('width', 'auto').show()
                            .css('visibility', 'hidden');
                } else {
                    // not scrolled past the menu; only show the original menu.
                    $('.cloned').hide();
                    $('.original').css('visibility', 'visible');
                }
            }

            function checkOverFlow() {
                offsetHeight = $('#introductionText').prop('offsetHeight');
                scrollHeight = $('#introductionText').prop('scrollHeight');
                if (offsetHeight < scrollHeight)
                    $('#showMore').removeClass('hidden');
                else {
                    $('#showMore').addClass('hidden');
                }
            }

            function showMore() {
                scrollHeight = $('#introductionText').prop('scrollHeight');
                $('#introductionText').css('max-height', '');
                $('#showMore').empty().append('کمتر').attr('onclick', 'showLess()').css('padding-top', (scrollHeight - 12) + 'px');
            }

            function showLess() {
                $('#introductionText').css('max-height', '21px');
                $('#showMore').empty().append('بیشتر').attr('onclick', 'showMore()').css('padding-top', '');
            }

            function showMoreReview(idx) {
                $('#partial_entry_' + idx).css('max-height', '');
                $('#showMoreReview_' + idx).empty().append('کمتر').attr('onclick', 'showLessReview("' + idx + '")');
                $("#reviewPic_" + idx).removeClass('hidden');
            }

            function showLessReview(idx) {
                $('#partial_entry_' + idx).css('max-height', '70px');
                $('#showMoreReview_' + idx).empty().append('بیشتر').attr('onclick', 'showMoreReview(' + idx + ')');
                $("#reviewPic_" + idx).addClass('hidden');
            }

            function showAddReviewPageHotel(url) {
                if (!hasLogin) {
                    showLoginPrompt(url);
                }
                else {
                    document.location.href = url;
                }
            }
        </script>

        <script>
            var total;
            var filters = [];
            var hasFilter = false;
            var topContainer;
            var marginTop;
            var helpWidth;
            var greenBackLimit = 5;
            var pageHeightSize = window.innerHeight;
            var additional = [];
            var indexes = [];
            $(".nextBtnsHelp").click(function () {
                show(parseInt($(this).attr('data-val')) + 1, 1);
            });
            $(".backBtnsHelp").click(function () {
                show(parseInt($(this).attr('data-val')) - 1, -1);
            });
            $(".exitBtnHelp").click(function () {
                myQuit();
            });

            function myQuit() {
                clear();
                $(".dark").hide();
                enableScroll();
            }

            function setGreenBackLimit(val) {
                greenBackLimit = val;
            }

            function initHelp(t, sL, topC, mT, hW) {
                total = t;
                filters = sL;
                topContainer = topC;
                marginTop = mT;
                helpWidth = hW;
                if (sL.length > 0)
                    hasFilter = true;
                $(".dark").show();
                show(1, 1);
            }

            function initHelp2(t, sL, topC, mT, hW, i, a) {
                total = t;
                filters = sL;
                topContainer = topC;
                marginTop = mT;
                helpWidth = hW;
                additional = a;
                indexes = i;
                if (sL.length > 0)
                    hasFilter = true;
                $(".dark").show();
                show(1, 1);
            }

            function isInFilters(key) {
                key = parseInt(key);
                for (j = 0; j < filters.length; j++) {
                    if (filters[j] == key)
                        return true;
                }
                return false;
            }

            function getBack(curr) {
                for (i = curr - 1; i >= 0; i--) {
                    if (!isInFilters(i))
                        return i;
                }
                return -1;
            }

            function getFixedFromLeft(elem) {
                if (elem.prop('id') == topContainer || elem.prop('id') == 'PAGE') {
                    return parseInt(elem.css('margin-left').split('px')[0]);
                }
                return elem.position().left +
                        parseInt(elem.css('margin-left').split('px')[0]) +
                        getFixedFromLeft(elem.parent());
            }

            function getFixedFromTop(elem) {
                if (elem.prop('id') == topContainer) {
                    return marginTop;
                }
                if (elem.prop('id') == "PAGE") {
                    return 0;
                }
                return elem.position().top +
                        parseInt(elem.css('margin-top').split('px')[0]) +
                        getFixedFromTop(elem.parent());
            }

            function getNext(curr) {
                curr = parseInt(curr);
                for (i = curr + 1; i < total; i++) {
                    if (!isInFilters(i))
                        return i;
                }
                return total;
            }

            function bubbles(curr) {
                if (total <= 1)
                    return "";
                t = total - filters.length;
                newElement = "<div class='col-xs-12' style='position: relative'><div class='col-xs-12 bubbles' style='padding: 0; margin-right: 0; margin-left: " + ((400 - (t * 18)) / 2) + "px'>";
                for (i = 1; i < total; i++) {
                    if (!isInFilters(i)) {
                        if (i == curr)
                            newElement += "<div style='border: 1px solid #ccc; background-color: #ccc; border-radius: 50%; margin-right: 2px; width: 12px; height: 12px; float: left'></div>";
                        else
                            newElement += "<div onclick='show(\"" + i + "\", 1)' class='helpBubble' style='border: 1px solid #333; background-color: black; border-radius: 50%; margin-right: 2px; width: 12px; height: 12px; float: left'></div>";
                    }
                }
                newElement += "</div></div>";
                return newElement;
            }

            function clear() {
                $('.bubbles').remove();
                $(".targets").css({
                    'position': '',
                    'border': '',
                    'padding': '',
                    'background-color': '',
                    'z-index': '',
                    'cursor': '',
                    'pointer-events': 'auto'
                });
                $(".helpSpans").addClass('hidden');
                $(".backBtnsHelp").attr('disabled', 'disabled');
                $(".nextBtnsHelp").attr('disabled', 'disabled');
            }

            function show(curr, inc) {
                clear();
                if (hasFilter) {
                    while (isInFilters(curr)) {
                        curr += inc;
                    }
                }
                if (getBack(curr) <= 0) {
                    $("#backBtnHelp_" + curr).attr('disabled', 'disabled');
                }
                else {
                    $("#backBtnHelp_" + curr).removeAttr('disabled');
                }
                if (getNext(curr) > total - 1) {
                    $("#nextBtnHelp_" + curr).attr('disabled', 'disabled');
                }
                else {
                    $("#nextBtnHelp_" + curr).removeAttr('disabled');
                }
                if (curr < greenBackLimit) {
                    $("#targetHelp_" + curr).css({
                        'position': 'relative',
                        'border': '5px solid #333',
                        'padding': '10px',
                        'background-color': 'var(--koochita-light-green)',
                        'z-index': 1000001,
                        'cursor': 'auto'
                    });
                }
                else {
                    $("#targetHelp_" + curr).css({
                        'position': 'relative',
                        'border': '5px solid #333',
                        'padding': '10px',
                        'background-color': 'white',
                        'z-index': 100000001,
                        'cursor': 'auto'
                    });
                }
                var targetWidth = $("#targetHelp_" + curr).css('width').split('px')[0];
                var targetHeight = parseInt($("#targetHelp_" + curr).css('height').split('px')[0]);
                for (j = 0; j < indexes.length; j++) {
                    if (curr == indexes[j]) {
                        targetHeight += additional[j];
                        break;
                    }
                }
                if ($("#targetHelp_" + curr).offset().top > 200) {
                    $("html, body").scrollTop($("#targetHelp_" + curr).offset().top - 100);
                    $("#helpSpan_" + curr).css({
                        'left': $("#targetHelp_" + curr).offset().left + targetWidth / 2 - helpWidth / 2 + "px",
                        'top': targetHeight + 120 + "px"
                    }).removeClass('hidden').append(bubbles(curr));
                }
                else {
                    $("#helpSpan_" + curr).css({
                        'left': $("#targetHelp_" + curr).offset().left + targetWidth / 2 - helpWidth / 2 + "px",
                        'top': ($("#targetHelp_" + curr).offset().top + targetHeight + 20) % pageHeightSize + "px"
                    }).removeClass('hidden').append(bubbles(curr));
                }
                $(".helpBubble").on({
                    mouseenter: function () {
                        $(this).css('background-color', '#ccc');
                    },
                    mouseleave: function () {
                        $(this).css('background-color', '#333');
                    }
                });
                disableScroll();
            }

            // left: 37, up: 38, right: 39, down: 40,
            // spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36
            var keys = {37: 1, 38: 1, 39: 1, 40: 1};

            function preventDefault(e) {
                e = e || window.event;
                if (e.preventDefault)
                    e.preventDefault();
                e.returnValue = false;
            }

            function preventDefaultForScrollKeys(e) {
                if (keys[e.keyCode]) {
                    preventDefault(e);
                    return false;
                }
            }

            function disableScroll() {
                if (window.addEventListener) // older FF
                    window.addEventListener('DOMMouseScroll', preventDefault, false);
                window.onwheel = preventDefault; // modern standard
                window.onmousewheel = document.onmousewheel = preventDefault; // older browsers, IE
                window.ontouchmove = preventDefault; // mobile
                document.onkeydown = preventDefaultForScrollKeys;
            }

            function enableScroll() {
                if (window.removeEventListener)
                    window.removeEventListener('DOMMouseScroll', preventDefault, false);
                window.onmousewheel = document.onmousewheel = null;
                window.onwheel = null;
                window.ontouchmove = null;
                document.onkeydown = null;
            }
        </script>

        <script>
            var room = 0;
            var adult = 0;
            var children = 0;
            @if(session('room') != null)
                    room = parseInt('{{session('room')}}');
            adult = parseInt('{{session('adult')}}');
            children = parseInt('{{session('children')}}');
                    @endif
            var passengerNoSelect = false;
            $(".room").html(room);
            $(".adult").html(adult);
            $(".children").html(children);
            for (var i = 0; i < children; i++) {
                $(".childBox").append("" +
                        "<div class='childAge' data-id='" + i + "'>" +
                        "<div>سن بچه</div>" +
                        "<div><select class='selectAgeChild' name='ageOfChild' id='ageOfChild'>" +
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
                    $("#passengerNoSelectPane1").removeClass('hidden');
                    $("#passengerArrowUp").removeClass('hidden');
                    $("#passengerArrowDown").addClass('hidden');
                }
                else {
                    $("#passengerNoSelectPane").addClass('hidden');
                    $("#passengerNoSelectPane1").addClass('hidden');
                    $("#passengerArrowDown").removeClass('hidden');
                    $("#passengerArrowUp").addClass('hidden');
                    passengerNoSelect = false;
                }
            }

            function addClassHidden(element) {
                $("#" + element).addClass('hidden');
                if (element == 'passengerNoSelectPane' || element == 'passengerNoSelectPane1') {
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

                        if (room > 0 && adult == 0) {
                            adult = 1;
                            $("#adultPassengerNumInSelect").empty().append(adult);
                            $("#adultPassengerNumInSelect1").empty().append(adult);
                        }

                        $("#roomNumInSelect").empty().append(room);
                        $("#roomNumInSelect1").empty().append(room);
                        break;
                    case 2:
                        if (adult + inc >= 0)
                            adult += inc;
                        $("#adultPassengerNumInSelect").empty().append(adult);
                        $("#adultPassengerNumInSelect1").empty().append(adult);
                        break;
                    case 1:
                        if (children + inc >= 0)
                            children += inc;
                        if (inc >= 0) {
                            $(".childBox").append("<div class='childAge' data-id='" + (children - 1) + "'>" +
                                    "<div>سن بچه</div>" +
                                    "<div><select class='selectAgeChild' name='ageOfChild' id='ageOfChild'>" +
                                    "<option value='0'>1<</option>" +
                                    "<option value='1'>1</option>" +
                                    "<option value='2'>2</option>" +
                                    "<option value='3'>3</option>" +
                                    "<option value='4'>4</option>" +
                                    "<option value='5'>5</option>" +
                                    "</select></div>" +
                                    "</div>");
                            ;
                        } else {
                            $(".childAge[data-id='" + (children) + "']").remove();
                        }
                        $("#childrenPassengerNumInSelect").empty().append(children);
                        $("#childrenPassengerNumInSelect1").empty().append(children);
                        break;
                }
                var text = '<span style="float: right;">' + room + '</span>&nbsp;\n' +
                        '                                                <span>اتاق</span>&nbsp;-&nbsp;\n' +
                        '                                                <span id="childPassengerNo">' + adult + '</span>\n' +
                        '                                                <span>بزرگسال</span>&nbsp;-&nbsp;\n' +
                        '                                                <span id="infantPassengerNo">' + children + '</span>\n' +
                        '                                                <span>بچه</span>&nbsp;';
                // document.getElementById('roomDetailRoom').innerHTML = text;
                while ((4 * room) < adult) {
                    room++;
                    $("#roomNumInSelect").empty().append(room);
                }
                document.getElementById('num_room').innerText = room;
                document.getElementById('num_adult').innerText = adult;
            }
        </script>

        <script>
            function changeStatetounReserved() {
                document.getElementById('bestPriceRezerved').style.display = 'none';
                document.getElementById('bestPrice').style.display = 'block';
            }

            function changeRoomPrice(id) {
                var x = document.getElementById("extraBedPrice" + id);
                if (x.style.display === "none") {
                    x.style.display = "block";
                } else {
                    x.style.display = "none";
                }
            }

            function dotedNumber(number) {
                var i = 1;
                var num = 0;
                while (i < number) {
                    i *= 10;
                    num++;
                }
                var string_number = '';
                var mande = num % 3;
                string_number = Math.floor(number / (Math.pow(10, num - mande))) + '.';
                number = number % (Math.pow(10, num - mande));
                num = num - mande;
                var div = num;
                for (i = 0; i < div / 3; i++) {
                    if (number != 0) {
                        num -= 3;
                        string_number += Math.floor(number / (Math.pow(10, num))) + '.';
                        number = number % (Math.pow(10, num));
                    }
                    else if (i < (div / 3) - 1) {
                        string_number += '000.';
                    }
                    else {
                        string_number += '000';
                    }
                }
                return string_number;
            }

            function inputSearch() {
                var ageOfChild = [];
                var goDate;
                var backDate;
                var childSelect = document.getElementsByName('ageOfChild');
                for (var i = 0; i < children; i++) {
                    ageOfChild[i] = childSelect[i + 1].value;
                }
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

            function editSearch() {
                changeStatetounReserved();
                window.location.href = '#bestPrice';
            }

            @if(session('backDate') != null)
        document.getElementById('backDate').value = '{{session("backDate")}}';
            var rooms = '{!! $jsonRoom !!}';
            rooms = JSON.parse(rooms);
            var totalMoney = 0;
            var totalPerDayMoney = 0;
            var numDay = rooms[0].perDay.length;
            var room_code = [];
            var adult_count = [];
            var extra = [];
            var num_room_code = [];
            var room_name = [];
            document.getElementById('numDay').innerText = numDay;
            document.getElementById('check_num_day').innerText = numDay;

            function scrollToBed() {
                var elmnt = document.getElementById("rooms");
                elmnt.scrollIntoView();
            }

            function changeNumRoom(_index, value) {
                totalMoney = 0;
                totalPerDayMoney = 0;
                var totalNumRoom = 0;
                var text = '';
                var reserve_text = '';
                var reserve_money_text = '';
                room_code = [];
                adult_count = [];
                extra = [];
                num_room_code = [];
                room_name = [];
                for (i = 0; i < rooms.length; i++) {
                    numRoom = parseInt(document.getElementById('roomNumber' + i).value);
                    totalNumRoom += numRoom;
                    price = parseInt(rooms[i].perDay[0].price);
                    priceExtraBed = rooms[i].priceExtraGuest;
                    extraBed = document.getElementById('additional_bed' + i).checked;
                    totalPerDayMoney += numRoom * Math.floor(price / 1000) * 1000;
                    if (numRoom != 0) {
                        room_code.push(rooms[i].roomNumber);
                        adult_count.push(rooms[i].capacity['adultCount']);
                        num_room_code.push(numRoom);
                        room_name.push(rooms[i].name);
                        text += '<div><span>X' + numRoom + '</span>' + rooms[i].name;
                        reserve_money_text += '<div><span style="float: right">X' + numRoom + '</span><span style="float: right">' + rooms[i].name + '</span>';
                        reserve_text += '<div class="row" style="background: white; margin: 1px; box-shadow: 0 0 20px 0px gray; margin-bottom: 10px; ">\n' +
                                '<div class="col-md-9" style="font-size: 15px; padding-top: 2%;">\n' +
                                '<div class="row" style="display: flex; flex-direction: row;">\n' +
                                '<div style="width: 33%">\n' +
                                '<span style="color: #92321b">نام اتاق: </span>\n' +
                                '<span>' + rooms[i].name + '</span>\n' +
                                '</div>\n' +
                                '<div style="width: 33%">\n' +
                                '<span style="color: #92321b">تاریخ ورود: </span>\n' +
                                '<span>{{session("goDate")}}</span>\n' +
                                '</div>\n' +
                                '<div style="width: 33%">\n' +
                                '<span style="color: #92321b">تاریخ خروج: </span>\n' +
                                '<span>{{session("backDate")}}</span>\n' +
                                '</div>\n' +
                                '</div>\n' +
                                '<div class="row" style="display: flex; flex-direction: row; margin-bottom: 2%; margin-top: 2%;">\n' +
                                '<div style="width: 33%">\n' +
                                '<span style="color: #92321b">تعداد مسافر: </span>\n' +
                                '<span>' + rooms[i].capacity.adultCount + '</span>\n' +
                                '</div>\n' +
                                '<div style="width: 33%">\n' +
                                '<span style="color: #92321b">سرویس تخت اضافه: </span>\n';
                        if (extraBed) {
                            text += '<span style="font-size: 0.85em">با تخت اضافه</span>';
                            reserve_money_text += '<span style="font-size: 0.85em; float: right">با تخت اضافه</span><span style="float: left;">' + dotedNumber((Math.floor(priceExtraBed / 1000) * 1000) + (Math.floor(price / 1000) * 1000)) + '</span>';
                            totalPerDayMoney += numRoom * Math.floor(priceExtraBed / 1000) * 1000;
                            reserve_text += '<span>دارد</span>\n';
                            extra.push(true);
                        } else {
                            reserve_money_text += '<span style="float: left;">' + dotedNumber(Math.floor(price / 1000) * 1000) + '</span>';
                            reserve_text += '<span>ندارد</span>\n';
                            extra.push(false);
                        }
                        text += '</div>';
                        reserve_money_text += '</div>';
                        reserve_text += '</div>\n' +
                                '</div><div class="row" style="display: flex; flex-direction: row;">\n' +
                                '<div>\n' +
                                '<span style="color: #92321b"> صبحانه مجانی: </span>\n' +
                                '<span>دارد</span>\n' +
                                '</div>\n' +
                                '</div>\n' +
                                '</div>\n';
                        reserve_text += '<div class="col-md-3"><img src="' + rooms[i].pic + '" style="width: 100%;"></div></div>';
                    }
                }
                totalMoney += totalPerDayMoney * numDay;
                document.getElementById('totalPriceOneDay').innerText = dotedNumber(totalPerDayMoney);
                document.getElementById('totalPrice').innerText = dotedNumber(totalMoney);
                document.getElementById('check_total_price').innerText = dotedNumber(totalMoney);
                document.getElementById('totalNumRoom').innerText = totalNumRoom;
                document.getElementById('check_total_num_room').innerText = totalNumRoom;
                document.getElementById('discriptionNumRoom').innerHTML = text;
                document.getElementById('check_description').innerHTML = reserve_money_text;
                document.getElementById('selected_rooms').innerHTML = reserve_text;
            }

            function showReserve() {
                if (totalMoney > 0)
                    document.getElementById('check_room').style.display = 'flex';
            }
            function updateSession() {
                $.ajax({
                    url: '{{route("updateSession")}}',
                    type: 'post',
                    data: {
                        'room_code': room_code,
                        'adult_count': adult_count,
                        'extra': extra,
                        'num_room_code': num_room_code,
                        'room_name': room_name,
                        {{--'hotel_name': '{{$place->hotel_name}}',--}}
                                {{--'rph': '{{$place->rph}}',--}}
                        'backURL': window.location.href
                    },
                    success: function (response) {
                        window.location.href = '{{url('buyHotel')}}';
                    }
                })
            }
            @endif
        </script>

        <script src="{{URL::asset('js/adv.js')}}"></script>
@stop
