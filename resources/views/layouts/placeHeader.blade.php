<link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/masthead-saves.css?v=1')}}' data-rup='long_lived_global_legacy'/>
<link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/placeHeader.css?v=1')}}' data-rup='long_lived_global_legacy'/>
<link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/abbreviations.css?v=1')}}' data-rup='long_lived_global_legacy'/>
<link rel="stylesheet" type='text/css' href="{{URL::asset('css/common/header.css?v=1')}}">

<?php

use App\models\Adab;
use App\models\places\Amaken;
use App\models\places\Hotel;
use App\models\places\Majara;
use App\models\places\Restaurant;
use App\models\Trip;
use App\models\TripMember;
use App\models\TripPlace;
$trips = [];
$user = Auth::user();

function convertStringToDate2($date) {
    if($date == "")
        return $date;
    return $date[0] . $date[1] . $date[2] . $date[3] . '/' . $date[4] . $date[5] . '/' . $date[6] . $date[7];
}

if(Auth::check()) {

    $uId = Auth::user()->id;
    $trips = Trip::where('uId',$uId)->get();

    $condition = ['uId' => $uId, 'status' => 1];
    $invitedTrips = TripMember::where($condition)->select('tripId')->get();

    foreach ($invitedTrips as $invitedTrip) {
        $trips[count($trips)] = Trip::find($invitedTrip->tripId);
    }

    if($trips != null && count($trips) != 0) {
        foreach ($trips as $trip) {
            $trip->placeCount = TripPlace::where('tripId',$trip->id)->count();
            $limit = ($trip->placeCount > 4) ? 4 : $trip->placeCount;
            $tripPlaces = TripPlace::where('tripId',$trip->id)->take($limit)->get();
            if($trip->placeCount > 0) {
                $kindPlaceId = $tripPlaces[0]->kindPlaceId;
                switch ($kindPlaceId) {
                    case 1:
                        $amaken = Amaken::whereId($tripPlaces[0]->placeId);
                        try{
                            if(file_get_contents(URL::asset('_images/amaken/' . $amaken->file . '/t-1.jpg')))
                                $trip->pic1 = URL::asset('_images/amaken/' . $amaken->file . '/t-1.jpg');
                        }
                        catch (Exception $x) {
                            $trip->pic1 = URL::asset('_images/nopic/blank.jpg');
                        }
                        break;
                    case 3:
                        $restaurant = Restaurant::whereId($tripPlaces[0]->placeId);
                        try {
                            if(file_get_contents(URL::asset('_images/restaurant/' . $restaurant->file . '/t-1.jpg')))
                                $trip->pic1 = URL::asset('_images/restaurant/' . $restaurant->file . '/t-1.jpg');
                        }
                        catch (Exception $x) {
                            $trip->pic1 = URL::asset('_images/nopic/blank.jpg');
                        }
                        break;
                    case 4:
                        $hotel = Hotel::whereId($tripPlaces[0]->placeId);
                        try {
                            if(file_get_contents(URL::asset('_images/hotels/' . $hotel->file . '/t-1.jpg')))
                                $trip->pic1 = URL::asset('_images/hotels/' . $hotel->file . '/' . $hotel->pic_1);
                        }
                        catch (Exception $x) {
                            $trip->pic1 = URL::asset('_images/nopic/blank.jpg');
                        }
                        break;
                    case 6:
                        $majara = Majara::whereId($tripPlaces[0]->placeId);
                        try {
                            if(file_get_contents(URL::asset('_images/majara/' . $majara->file . '/t-1.jpg')))
                                $trip->pic1 = URL::asset('_images/hotels/' . $majara->file . '/' . $majara->pic_1);
                        }
                        catch (Exception $x) {
                            $trip->pic1 = URL::asset('_images/nopic/blank.jpg');
                        }
                        break;
                    case 8:
                        $adab = Adab::whereId($tripPlaces[0]->placeId);
                        if($adab->category == 3) {
                            try {
                                if(file_get_contents(URL::asset('_images/adab/ghazamahali/' . $adab->file . '/t-1.jpg')))
                                    $trip->pic1 = URL::asset('_images/adab/ghazamahali/' . $adab->file . '/' . $adab->pic_1);
                            }
                            catch (Exception $x) {
                                $trip->pic1 = URL::asset('_images/nopic/blank.jpg');
                            }
                        }
                        else {
                            try{
                                if(file_get_contents(URL::asset('_images/adab/soghat/' . $adab->file . '/t-1.jpg')))
                                    $trip->pic1 = URL::asset('_images/adab/soghat/' . $adab->file . '/' . $adab->pic_1);
                            }
                            catch (Exception $x) {
                                $trip->pic1 = URL::asset('_images/nopic/blank.jpg');
                            }
                        }
                        break;
                }
            }
            if($trip->placeCount > 1) {
                $kindPlaceId = $tripPlaces[1]->kindPlaceId;
                switch ($kindPlaceId) {
                    case 1:
                        $amaken = Amaken::whereId($tripPlaces[0]->placeId);
                        try{
                            if(file_get_contents(URL::asset('_images/amaken/' . $amaken->file . '/t-1.jpg')))
                                $trip->pic2 = URL::asset('_images/amaken/' . $amaken->file . '/t-1.jpg');
                        }
                        catch (Exception $x) {
                            $trip->pic2 = URL::asset('_images/nopic/blank.jpg');
                        }
                        break;
                    case 3:
                        $restaurant = Restaurant::whereId($tripPlaces[0]->placeId);
                        try {
                            if(file_get_contents(URL::asset('_images/restaurant/' . $restaurant->file . '/t-1.jpg')))
                                $trip->pic2 = URL::asset('_images/restaurant/' . $restaurant->file . '/t-1.jpg');
                        }
                        catch (Exception $x) {
                            $trip->pic2 = URL::asset('_images/nopic/blank.jpg');
                        }
                        break;
                    case 4:
                        $hotel = Hotel::whereId($tripPlaces[0]->placeId);
                        try {
                            if(file_get_contents(URL::asset('_images/hotels/' . $hotel->file . '/t-1.jpg')))
                                $trip->pic2 = URL::asset('_images/hotels/' . $hotel->file . '/' . $hotel->pic_1);
                        }
                        catch (Exception $x) {
                            $trip->pic2 = URL::asset('_images/nopic/blank.jpg');
                        }
                        break;
                    case 6:
                        $majara = Majara::whereId($tripPlaces[0]->placeId);
                        try {
                            if(file_get_contents(URL::asset('_images/majara/' . $majara->file . '/t-1.jpg')))
                                $trip->pic2 = URL::asset('_images/hotels/' . $majara->file . '/' . $majara->pic_1);
                        }
                        catch (Exception $x) {
                            $trip->pic2 = URL::asset('_images/nopic/blank.jpg');
                        }
                        break;
                    case 8:
                        $adab = Adab::whereId($tripPlaces[0]->placeId);
                        if($adab->category == 3) {
                            try {
                                if(file_get_contents(URL::asset('_images/adab/ghazamahali/' . $adab->file . '/t-1.jpg')))
                                    $trip->pic2 = URL::asset('_images/adab/ghazamahali/' . $adab->file . '/' . $adab->pic_1);
                            }
                            catch (Exception $x) {
                                $trip->pic2 = URL::asset('_images/nopic/blank.jpg');
                            }
                        }
                        else {
                            try{
                                if(file_get_contents(URL::asset('_images/adab/soghat/' . $adab->file . '/t-1.jpg')))
                                    $trip->pic2 = URL::asset('_images/adab/soghat/' . $adab->file . '/' . $adab->pic_1);
                            }
                            catch (Exception $x) {
                                $trip->pic2 = URL::asset('_images/nopic/blank.jpg');
                            }
                        }
                        break;
                }
            }
            if($trip->placeCount > 2) {
                $kindPlaceId = $tripPlaces[2]->kindPlaceId;
                switch ($kindPlaceId) {
                    case 1:
                        $amaken = Amaken::whereId($tripPlaces[0]->placeId);
                        try{
                            if(file_get_contents(URL::asset('_images/amaken/' . $amaken->file . '/t-1.jpg')))
                                $trip->pic3 = URL::asset('_images/amaken/' . $amaken->file . '/t-1.jpg');
                        }
                        catch (Exception $x) {
                            $trip->pic3 = URL::asset('_images/nopic/blank.jpg');
                        }
                        break;
                    case 3:
                        $restaurant = Restaurant::whereId($tripPlaces[0]->placeId);
                        try {
                            if(file_get_contents(URL::asset('_images/restaurant/' . $restaurant->file . '/t-1.jpg')))
                                $trip->pic3 = URL::asset('_images/restaurant/' . $restaurant->file . '/t-1.jpg');
                        }
                        catch (Exception $x) {
                            $trip->pic3 = URL::asset('_images/nopic/blank.jpg');
                        }
                        break;
                    case 4:
                        $hotel = Hotel::whereId($tripPlaces[0]->placeId);
                        try {
                            if(file_get_contents(URL::asset('_images/hotels/' . $hotel->file . '/t-1.jpg')))
                                $trip->pic3 = URL::asset('_images/hotels/' . $hotel->file . '/' . $hotel->pic_1);
                        }
                        catch (Exception $x) {
                            $trip->pic3 = URL::asset('_images/nopic/blank.jpg');
                        }
                        break;
                    case 6:
                        $majara = Majara::whereId($tripPlaces[0]->placeId);
                        try {
                            if(file_get_contents(URL::asset('_images/majara/' . $majara->file . '/t-1.jpg')))
                                $trip->pic3 = URL::asset('_images/hotels/' . $majara->file . '/' . $majara->pic_1);
                        }
                        catch (Exception $x) {
                            $trip->pic3 = URL::asset('_images/nopic/blank.jpg');
                        }
                        break;
                    case 8:
                        $adab = Adab::whereId($tripPlaces[0]->placeId);
                        if($adab->category == 3) {
                            try {
                                if(file_get_contents(URL::asset('_images/adab/ghazamahali/' . $adab->file . '/t-1.jpg')))
                                    $trip->pic3 = URL::asset('_images/adab/ghazamahali/' . $adab->file . '/' . $adab->pic_1);
                            }
                            catch (Exception $x) {
                                $trip->pic3 = URL::asset('_images/nopic/blank.jpg');
                            }
                        }
                        else {
                            try{
                                if(file_get_contents(URL::asset('_images/adab/soghat/' . $adab->file . '/t-1.jpg')))
                                    $trip->pic3 = URL::asset('_images/adab/soghat/' . $adab->file . '/' . $adab->pic_1);
                            }
                            catch (Exception $x) {
                                $trip->pic3 = URL::asset('_images/nopic/blank.jpg');
                            }
                        }
                        break;
                }
            }
            if($trip->placeCount > 3) {
                $kindPlaceId = $tripPlaces[3]->kindPlaceId;
                switch ($kindPlaceId) {
                    case 1:
                        $amaken = Amaken::whereId($tripPlaces[0]->placeId);
                        try{
                            if(file_get_contents(URL::asset('_images/amaken/' . $amaken->file . '/t-1.jpg')))
                                $trip->pic4 = URL::asset('_images/amaken/' . $amaken->file . '/t-1.jpg');
                        }
                        catch (Exception $x) {
                            $trip->pic4 = URL::asset('_images/nopic/blank.jpg');
                        }
                        break;
                    case 3:
                        $restaurant = Restaurant::whereId($tripPlaces[0]->placeId);
                        try {
                            if(file_get_contents(URL::asset('_images/restaurant/' . $restaurant->file . '/t-1.jpg')))
                                $trip->pic4 = URL::asset('_images/restaurant/' . $restaurant->file . '/t-1.jpg');
                        }
                        catch (Exception $x) {
                            $trip->pic4 = URL::asset('_images/nopic/blank.jpg');
                        }
                        break;
                    case 4:
                        $hotel = Hotel::whereId($tripPlaces[0]->placeId);
                        try {
                            if(file_get_contents(URL::asset('_images/hotels/' . $hotel->file . '/t-1.jpg')))
                                $trip->pic4 = URL::asset('_images/hotels/' . $hotel->file . '/' . $hotel->pic_1);
                        }
                        catch (Exception $x) {
                            $trip->pic4 = URL::asset('_images/nopic/blank.jpg');
                        }
                        break;
                    case 6:
                        $majara = Majara::whereId($tripPlaces[0]->placeId);
                        try {
                            if(file_get_contents(URL::asset('_images/majara/' . $majara->file . '/t-1.jpg')))
                                $trip->pic4 = URL::asset('_images/hotels/' . $majara->file . '/' . $majara->pic_1);
                        }
                        catch (Exception $x) {
                            $trip->pic4 = URL::asset('_images/nopic/blank.jpg');
                        }
                        break;
                    case 8:
                        $adab = Adab::whereId($tripPlaces[0]->placeId);
                        if($adab->category == 3) {
                            try {
                                if(file_get_contents(URL::asset('_images/adab/ghazamahali/' . $adab->file . '/t-1.jpg')))
                                    $trip->pic4 = URL::asset('_images/adab/ghazamahali/' . $adab->file . '/' . $adab->pic_1);
                            }
                            catch (Exception $x) {
                                $trip->pic4 = URL::asset('_images/nopic/blank.jpg');
                            }
                        }
                        else {
                            try{
                                if(file_get_contents(URL::asset('_images/adab/soghat/' . $adab->file . '/t-1.jpg')))
                                    $trip->pic4 = URL::asset('_images/adab/soghat/' . $adab->file . '/' . $adab->pic_1);
                            }
                            catch (Exception $x) {
                                $trip->pic4 = URL::asset('_images/nopic/blank.jpg');
                            }
                        }
                        break;
                }
            }
        }
    }
}
?>

<div class="masthead position-relative">
    <div class="ppr_rup ppr_priv_global_nav position-relative">
        <div class="global-nav global-nav-single-line position-relative">
            <div class="global-nav-top position-relative">
                <div class="global-nav-bar global-nav-green" style="padding-top: 5px;">
                    <div class="ui_container global-nav-bar-container direction-rtl position-relative">
                        <div class="global-nav-hamburger is-hidden-tablet">
                            <span class="ui_icon menu-bars"></span>
                        </div>

                        <a href="{{route('main')}}" class="global-nav-logo" style="display: flex; align-items: center">
                            <img src="{{URL::asset('images/icons/mainLogo.png')}}" alt="کوچیتا" style="width: auto; height: 70%;"/>
                        </a>

                        <div class="global-nav-links ui_tabs inverted" style="display: flex; align-items: center">
                            <div id="taplc_global_nav_links_0" class="ppr_rup ppr_priv_global_nav_links" data-placement-name="global_nav_links">
                                <div class="global-nav-links-container">

                                    @if(isset($locationName['cityNameUrl']))
                                        <div class="mainHeaderSearch arrowAfter" onclick="openMainSearch(0)">
                                            {{$locationName['cityName']}}
                                        </div>
                                    @endif

                                    @if(Request::is('safarnameh/*'))
                                        <ul class="global-nav-links-menu">
                                            <li>
                                                <span class="unscoped global-nav-link ui_tab color-whiteImp" onclick="openMainSearch(4)// in mainSearch.blade.php">اقامتگاه</span>
                                            </li>
                                            <li>
                                                <span class="unscoped global-nav-link ui_tab color-whiteImp" onclick="openMainSearch(3)// in mainSearch.blade.php">رستوران‌ها</span>
                                            </li>
                                            <li>
                                                <span class="unscoped global-nav-link ui_tab color-whiteImp" onclick="openMainSearch(1)// in mainSearch.blade.php">جاذبه‌</span>
                                            </li>
                                            <li>
                                                <span class="unscoped global-nav-link ui_tab color-whiteImp" onclick="openMainSearch(10)// in mainSearch.blade.php">سوغات و صنایع‌دستی</span>
                                            </li>
                                            <li>
                                                <span class="unscoped global-nav-link ui_tab color-whiteImp" onclick="openMainSearch(11)// in mainSearch.blade.php">غذای محلی‌</span>
                                            </li>
                                            <li>
                                                <a href="{{route('safarnameh.index')}}" class="unscoped global-nav-link ui_tab color-whiteImp">سفرنامه ها‌</a>
                                            </li>
                                        </ul>
                                    @endif

                                </div>
                            </div>
                        </div>

                        <div class="global-nav-actions position-relative" >
                            @if(Auth::check())
                                <div class="ppr_rup ppr_priv_global_nav_action_trips" onclick="openUploadPost()">
                                    <div class="ppr_rup ppr_priv_global_nav_action_profile"  title="پست" style="font-size: 10px">
                                        <span class="ui_icon addPostIcon" style="justify-content: center"></span>
                                        <div class="nameOfIconHeaders" style="color: white;">
                                            پست
                                        </div>
                                    </div>
                                </div>

                                <div class="ppr_rup ppr_priv_global_nav_action_trips position-relative">
                                    <div id="targetHelp_1" class="targets">
                                        <div id="bookmarkicon" class="ppr_rup ppr_priv_global_nav_action_profile" title="نشانه گذاری شده ها" style="font-size: 10px">
                                            <span class="ui_icon casino" style="justify-content: center"></span>
                                            <div class="nameOfIconHeaders" style="color: white;">
                                                نشون کرده
                                            </div>
                                        </div>

                                        <div id="bookmarkmenu" class="ui_overlay ui_flyout global-nav-flyout global-nav-utility trips-flyout-container" style="direction: rtl;">
                                            <div>
                                                <div class="styleguide" id="masthead-saves-container">
                                                    <div id="masthead-recent" style="background-color: white">
                                                        <div class="recent-header-container">
                                                            <a class="recent-header" href="{{route('recentlyViewTotal')}}" target="_self"> نشانه گذاری شده ها </a>

                                                        </div>
                                                        <div class="masthead-recent-cards-container" id="bookMarksDiv"></div>
                                                        {{--<div class="see-all-button-container"><a href="{{route('recentlyViewTotal')}}" target="_self" class="see-all-button">مشاهده تمامی موارد </a></div>--}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="helpSpan_1" class="helpSpans hidden row">
                                            <span class="introjs-arrow"></span>
                                            <p class="col-xs-12">شاید بعدا بخواهید دوباره به همین مکان باز گردید. پس آن را نشان کنید تا از منوی بالا هر وقت که خواستید دوباره به آن باز گردید.</p>
                                            <div class="col-xs-12">
                                                <button data-val="1" class="btn btn-success nextBtnsHelp" id="nextBtnHelp_1">بعدی</button>
                                                <button data-val="1" class="btn btn-primary backBtnsHelp" id="backBtnHelp_1">قبلی</button>
                                                <button class="btn btn-danger exitBtnHelp">خروج</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="ppr_rup ppr_priv_global_nav_action_trips position-relative">
                                    <div id="targetHelp_2" class="targets">
                                        <div class="masthead-saves" title="سفرهای من">
                                            <a class="trips-icon"  href="{{route('myTrips')}}">
                                                <span class="ui_icon my-trips" style="justify-content: center"></span>
                                                <div class="nameOfIconHeaders" style="color: white; ">
                                                    سفرهای من
                                                </div>
                                            </a>
                                        </div>

                                        {{--<div id="my-trips-not" class="ui_overlay ui_flyout global-nav-flyout global-nav-utility trips-flyout-container" style="direction: rtl">--}}
                                            {{--<div>--}}
                                                {{--<div class="styleguide" id="masthead-saves-container">--}}
                                                    {{--<div id="masthead-recent" style="background-color: white">--}}
                                                        {{--<div class="recent-header-container">--}}
                                                            {{--<a class="recent-header" href="{{route('recentlyViewTotal')}}" target="_self">بازدیدهای اخیر </a>--}}
                                                        {{--</div>--}}
                                                        {{--<div class="masthead-recent-cards-container">--}}
                                                            {{--<div id="dropdown-test3-card">--}}
                                                                {{--<div class="ui_close_x"></div>--}}
                                                                {{--<div class="test-title">خوش آمدید</div>--}}
                                                                {{--<div class="test-content">شما می توانید بازدیدهای اخیرتان را در اینجا ببینید</div>>--}}
                                                            {{--</div>--}}
                                                            {{--<div id="masthead-recent-cards-region">--}}
                                                                {{--<div id="recentlyViewed"></div>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                        {{--<div class="see-all-button-container"><a href="{{route('recentlyViewTotal')}}" target="_self" class="see-all-button">مشاهده تمامی موارد </a></div>--}}
                                                    {{--</div>--}}
                                                    {{--<div id="masthead-trips">--}}
                                                        {{--<div class="trips-header-container"><a class="trips-header" target="_self" href="{{URL('myTrips')}}">سفر های من </a></div>--}}
                                                        {{--<div id="masthead-trips-tiles-region">--}}
                                                            {{--<div id="trips-tiles" class="column">--}}
                                                                {{--<div>--}}
                                                                    {{--<a onclick="showPopUp()" class="single-tile is-create-trip">--}}
                                                                        {{--<div class="tile-content">--}}
                                                                            {{--<span class="ui_icon plus"></span>--}}
                                                                            {{--<div class="create-trip-text">ایجاد سفر</div>--}}
                                                                        {{--</div>--}}
                                                                    {{--</a>--}}

                                                                    {{--@foreach($trips as $trip)--}}
                                                                        {{--<div onclick="document.location.href = '{{route('tripPlaces', ['tripId' => $trip->id])}}'" class="trip-images ui_columns is-gapless is-multiline is-mobile">--}}
                                                                            {{--@if($trip->placeCount > 0)--}}
                                                                                {{--<div class="trip-image ui_column is-6 placeCount0" style="background: url('{{$trip->pic1}}')" ></div>--}}
                                                                            {{--@else--}}
                                                                                {{--<div class="trip-image trip-image-empty ui_column is-6 placeCount0Else"></div>--}}
                                                                            {{--@endif--}}
                                                                            {{--@if($trip->placeCount > 1)--}}
                                                                                {{--<div class="trip-image ui_column is-6 placeCount0" style="background: url('{{$trip->pic1}}')" ></div>--}}
                                                                            {{--@else--}}
                                                                                {{--<div class="trip-image trip-image-empty ui_column is-6  placeCount0Else"></div>--}}
                                                                            {{--@endif--}}
                                                                            {{--@if($trip->placeCount > 2)--}}
                                                                                {{--<div class="trip-image ui_column is-6 placeCount0" style="background: url('{{$trip->pic1}}')" ></div>--}}
                                                                            {{--@else--}}
                                                                                {{--<div class="trip-image trip-image-empty ui_column is-6 placeCount0Else"></div>--}}
                                                                            {{--@endif--}}
                                                                            {{--@if($trip->placeCount > 3)--}}
                                                                                {{--<div class="trip-image ui_column is-6 placeCount0" style="background: url('{{$trip->pic1}}')" ></div>--}}
                                                                            {{--@else--}}
                                                                                {{--<div class="trip-image trip-image-empty ui_column is-6 placeCount0Else"></div>--}}
                                                                            {{--@endif--}}
                                                                        {{--</div>--}}
                                                                        {{--<div class="create-trip-text">{{$trip->name}} </div>--}}
                                                                        {{--@if($trip->to_ != "" && $trip->from_ != "")--}}
                                                                            {{--<div class="create-trip-text">--}}
                                                                                {{--{{convertStringToDate2($trip->to_)}}--}}
                                                                                {{--<p>الی</p>--}}
                                                                                {{--{{convertStringToDate2($trip->from_)}}--}}
                                                                            {{--</div>--}}
                                                                        {{--@else--}}
                                                                            {{--<div class="create-trip-text">بدون تاریخ</div>--}}
                                                                        {{--@endif--}}
                                                                    {{--@endforeach--}}
                                                                {{--</div>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                    </div>
                                </div>

                                <div id="taplc_global_nav_action_notif_0" class="ppr_rup ppr_priv_global_nav_action_notif position-relative">
                                    <div id="targetHelp_3" class="targets">
                                        <div class="masthead_notification" title="Alerts">
                                            <div class="masthead_notifctr_btn">
                                                <div class="masthead_notifctr_sprite ui_icon notification-bell" style="justify-content: center"></div>
                                                <div class="nameOfIconHeaders" style="color: white; ">
                                                    پیام ها
                                                </div>
                                                <div class="masthead_notifctr_jewel hidden">0</div>
                                            </div>
                                            <div id="alert" class="masthead_notifctr_dropdown">
                                                <div class="notifdd_title">پیام ها</div>
                                                <div class="notifdd_loading hidden">
                                                    <div class="ui_spinner"></div>
                                                </div>
                                                <div>
                                                    <div class="modules-engagement-notification-dropdown " data-backbone-name="modules.engagement.NotificationDropdown" data-backbone-context="Engagement_MemberNotifications">
                                                        <div class="notifdd_empty">هیچ پیامی موجود نیست </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="helpSpan_3" class="helpSpans hidden row">
                                            <span class="introjs-arrow"></span>
                                            <p class="col-xs-12">پیام های خود را به سادگی از اینجا دنبال کنید.</p>
                                            <div class="col-xs-12">
                                                <button data-val="3" class="btn btn-success nextBtnsHelp" id="nextBtnHelp_3">بعدی</button>
                                                <button data-val="3" class="btn btn-primary backBtnsHelp" id="backBtnHelp_3">قبلی</button>
                                                <button class="btn btn-danger exitBtnHelp">خروج</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div id="taplc_global_nav_action_profile_0" class="ppr_rup ppr_priv_global_nav_action_profile position-relative" style="margin: 0px;">
                                <div class="global-nav-profile global-nav-utility position-relative">
                                    @if(Auth::check())
                                        <div id="targetHelp_5" class="targets" title="Profile" class="position-relative">
                                            <div class="global-nav-utility-activator" title="Profile" style="flex-direction: column;">
                                                <span id="nameTop" class="ui_icon member" style="justify-content: center;"></span>
                                                <div class="nameOfIconHeaders" style="color: white; ">
                                                    {{$user->username}}
                                                </div>
                                            </div>
                                            <div id="helpSpan_5" class="helpSpans hidden row">
                                                <span class="introjs-arrow"></span>
                                                <p class="col-xs-12">پروفایل خود را چک کنید تا ببینید چه امتیاز های هیجان انگیزی می توانید کسب کنید. هر کمک شما به بی جواب نمی ماند.</p>
                                                <div class="col-xs-12">
                                                    <button data-val="5" class="btn btn-success nextBtnsHelp" id="nextBtnHelp_5">بعدی</button>
                                                    <button data-val="5" class="btn btn-primary backBtnsHelp" id="backBtnHelp_5">قبلی</button>
                                                    <button class="btn btn-danger exitBtnHelp">خروج</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="global-nav-overlays-container">
                                        <div id="profile-drop" class="ui_overlay ui_flyout global-nav-flyout global-nav-utility">
                                            <ul class="global-nav-profile-menu">
                                                <li class="subItemHeaderNavBar"><a href="{{route('profile')}}" class="subLink" data-tracking-label="UserProfile_viewProfile">صفحه کاربری</a></li>
                                                <li class="subItemHeaderNavBar rule"><a href="{{URL('messages')}}" class="subLink global-nav-submenu-divided" data-tracking-label="UserProfile_messages">پیام ها</a> </li>
                                                <li class="subItemHeaderNavBar"><a href="{{route('profile.accountInfo')}}" class="subLink" data-tracking-label="UserProfile_settings">اطلاعات کاربر </a></li>
                                                <li class="subItemHeaderNavBar"><a href="{{route('logout')}}" class="subLink" data-tracking-label="UserProfile_signout">خروج</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="taplc_masthead_search_0" class="ppr_rup ppr_priv_masthead_search position-relative" data-placement-name="masthead_search">
                                <div class="mag_glass_parent position-relative" title="Search">
                                    <div id="targetHelp_6" class="targets">
                                        <span class="ui_icon search" id="openSearch" style="transform: rotate(90deg); border: none;"></span>
                                        <div id="helpSpan_6" class="helpSpans hidden row">
                                            <span class="introjs-arrow"></span>
                                            <p class="col-xs-12">اگر دنبال پیدا کردن جای دیگری هستید حتما سیستم جستجوی پیشرفته ما را امتحان کنید.</p>
                                            <div class="col-xs-12">
                                                <button data-val="6" class="btn btn-success nextBtnsHelp" id="nextBtnHelp_6">بعدی</button>
                                                <button data-val="6" class="btn btn-primary backBtnsHelp" id="backBtnHelp_6">قبلی</button>
                                                <button class="btn btn-danger exitBtnHelp">خروج</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(!auth()->check())
                                <div class="ppr_rup ppr_priv_global_nav_action_trips position-relative">
                                        <div id="targetHelp_4" class="targets">
                                            <div id="entryBtnId" class="ppr_rup ppr_priv_global_nav_action_profile">
                                                <div class="global-nav-profile global-nav-utility">
                                                    <a class="ui_button secondary small login-button" title="Join">ورود / ثبت نام</a>
                                                </div>
                                            </div>
                                            <div id="helpSpan_4" class="helpSpans hidden row">
                                                <span class="introjs-arrow"></span>
                                                <p class="col-xs-12">پیام های خود را به سادگی از اینجا دنبال کنید.</p>
                                                <div class="col-xs-12">
                                                    <button data-val="4" class="btn btn-success nextBtnsHelp" id="nextBtnHelp_4">بعدی</button>
                                                    <button data-val="4" class="btn btn-primary backBtnsHelp" id="backBtnHelp_4">قبلی</button>
                                                    <button class="btn btn-danger exitBtnHelp">خروج</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            @endif
                        </div>

                        <div class="clear-both"></div>
                    </div>
                </div>

            </div>
            <div class="sidebar-nav-wrapper hidden">
                <div class="sidebar-nav-backdrop"></div>
                <div class="sidebar-nav-container">
                    <div class="ui_container">
                        <div class="sidebar-nav-header">
                            <div class="sidebar-nav-close">
                                <div class="ui_icon times"></div>
                            </div>
                            <a href="/" class="global-nav-logo">
                                <img src='{{URL::asset('images/icons/logo.png')}}' alt="کوچیتا" class="global-nav-img"/>
                            </a>
                        </div>
                        <div class="sidebar-nav-profile-container">
                            @if(Auth::check())
                                <div class="sidebar-nav-profile-linker position-relative">
                                    <a class="global-nav-profile-linker">
                                        <span onclick="document.location.href = '{{route('profile')}}'" class="ui_icon member"></span>
                                        <div class="profile-link">
                                            <div class="profile-name">{{$user->username}}</div>
                                            <div class="profile-link-text">صفحه کاربری</div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                            <p class="sidebar-nav-title">اکانت من</p>
                            <div class="sidebar-nav-profile">
                                <li class="subItem"><a href="{{route('soon')}}" class="subLink global-nav-submenu-divided">سفرهای من</a></li>
                                <li class="subItem"><a href="{{route('logout')}}" class="subLink" data-tracking-label="UserProfile_signout">خروج</a></li>
                            </div>
                        </div>
                        <div class="sidebar-nav-links-container">
                            <p class="sidebar-nav-title">Browse</p>
                            <div class="sidebar-nav-links"></div>
                            <div class="sidebar-nav-links-more"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear-both"></div>
        </div>
    </div>
</div>

<script>

    function hideAllTopNavs(){
        $("#alert").hide();
        $("#my-trips-not").hide();
        $("#profile-drop").hide();
        $("#bookmarkmenu").hide();
    }

    hideAllTopNavs();

    $(document).ready(function(){

        $(".menu-bars").click(function(){
            $("#menu_res").removeClass('off-canvas');
        });

        $("#close_menu_res").click(function(){

            $("#menu_res").addClass('off-canvas');
        });
    });

    function headerActionsToggle() {

        $('.collapseBtnActions').animate({transform: 'rotate(90deg)'})


        if($('.global-nav-actions').hasClass('display-flexImp')) {

            $('.global-nav-actions').animate({width: "0"},
                function () {
                    $('.global-nav-actions').toggleClass('display-flexImp');
                });
        }
        else {
            $('.global-nav-actions').animate({width: "270px"});
            $('.global-nav-actions').toggleClass('display-flexImp');
        }
    }

    $('#close_span_search').click(function(e) {
        hideAllTopNavs();
        $('#searchspan').animate({height: '0vh'});
        $("#myCloseBtn").addClass('hidden');
    });

    $('#openSearch').click(function(e) {
        hideAllTopNavs();
        $("#myCloseBtn").removeClass('hidden');
        $('#searchspan').animate({height: '100vh'});
    });

</script>

@if(Auth::check())
    <script>
        var locked = false;
        var superAccess = false;
        var getRecentlyPath = '{{route('recentlyViewed')}}';

        $('#nameTop').click(function(e) {

            if( $("#profile-drop").is(":hidden")) {
                hideAllTopNavs();
                $("#profile-drop").show();
            }
            else
                hideAllTopNavs();
        });

        $('#memberTop').click(function(e) {
            if( $("#profile-drop").is(":hidden")) {
                hideAllTopNavs();
                $("#profile-drop").show();
            }
            else
                hideAllTopNavs();
        });

        $('#bookmarkicon').click(function(e) {
            if( $("#bookmarkmenu").is(":hidden")){
                hideAllTopNavs();
                $("#bookmarkmenu").show();
                // showBookMarks('bookMarksDiv');
            }
            else
                hideAllTopNavs();
        });

        $('.notification-bell').click(function(e) {
            if( $("#alert").is(":hidden")) {
                hideAllTopNavs();
                $("#alert").show();
            }
            else
                hideAllTopNavs();
        });

        $("#Settings").on({
            mouseenter: function () {
                $(".settingsDropDown").show()
            }, mouseleave: function () {
                $(".settingsDropDown").hide()
            }
        });


        function openUploadPost(){
            openUploadPhotoModal('کوچیتا', '{{route('addPhotoToPlace')}}', 0, 0, '');
        }
    </script>
@endif
