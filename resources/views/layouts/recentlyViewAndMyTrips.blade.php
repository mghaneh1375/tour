<?php

use App\models\Adab;
use App\models\places\Amaken;
use App\models\places\Hotel;
use App\models\places\Majara;
use App\models\places\Restaurant;
use App\models\Trip;
use App\models\TripMember;
use App\models\TripPlace;
function convertStringToDate2($date) {
    if($date == "")
        return $date;
    return $date[0] . $date[1] . $date[2] . $date[3] . '/' . $date[4] . $date[5] . '/' . $date[6] . $date[7];
}

$trips = [];
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
                            $trip->pic1 = URL::asset('images/mainPics/noPicSite.jpg');
                        }
                        break;
                    case 3:
                        $restaurant = Restaurant::whereId($tripPlaces[0]->placeId);
                        try {
                            if(file_get_contents(URL::asset('_images/restaurant/' . $restaurant->file . '/t-1.jpg')))
                                $trip->pic1 = URL::asset('_images/restaurant/' . $restaurant->file . '/t-1.jpg');
                        }
                        catch (Exception $x) {
                            $trip->pic1 = URL::asset('images/mainPics/noPicSite.jpg');
                        }
                        break;
                    case 4:
                        $hotel = Hotel::whereId($tripPlaces[0]->placeId);
                        try {
                            if(file_get_contents(URL::asset('_images/hotels/' . $hotel->file . '/t-1.jpg')))
                                $trip->pic1 = URL::asset('_images/hotels/' . $hotel->file . '/t-1.jpg');
                        }
                        catch (Exception $x) {
                            $trip->pic1 = URL::asset('images/mainPics/noPicSite.jpg');
                        }
                        break;
                    case 6:
                        $majara = Majara::whereId($tripPlaces[0]->placeId);
                        try {
                            if(file_get_contents(URL::asset('_images/majara/' . $majara->file . '/t-1.jpg')))
                                $trip->pic1 = URL::asset('_images/hotels/' . $majara->file . '/t-1.jpg');
                        }
                        catch (Exception $x) {
                            $trip->pic1 = URL::asset('images/mainPics/noPicSite.jpg');
                        }
                        break;
                    case 8:
                        $adab = Adab::whereId($tripPlaces[0]->placeId);
                        if($adab->category == 3) {
                            try {
                                if(file_get_contents(URL::asset('_images/adab/ghazamahali/' . $adab->file . '/t-1.jpg')))
                                    $trip->pic1 = URL::asset('_images/adab/ghazamahali/' . $adab->file . '/t-1.jpg');
                            }
                            catch (Exception $x) {
                                $trip->pic1 = URL::asset('images/mainPics/noPicSite.jpg');
                            }
                        }
                        else {
                            try{
                                if(file_get_contents(URL::asset('_images/adab/soghat/' . $adab->file . '/t-1.jpg')))
                                    $trip->pic1 = URL::asset('_images/adab/soghat/' . $adab->file . '/t-1.jpg');
                            }
                            catch (Exception $x) {
                                $trip->pic1 = URL::asset('images/mainPics/noPicSite.jpg');
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
                            $trip->pic2 = URL::asset('images/mainPics/noPicSite.jpg');
                        }
                        break;
                    case 3:
                        $restaurant = Restaurant::whereId($tripPlaces[0]->placeId);
                        try {
                            if(file_get_contents(URL::asset('_images/restaurant/' . $restaurant->file . '/t-1.jpg')))
                                $trip->pic2 = URL::asset('_images/restaurant/' . $restaurant->file . '/t-1.jpg');
                        }
                        catch (Exception $x) {
                            $trip->pic2 = URL::asset('images/mainPics/noPicSite.jpg');
                        }
                        break;
                    case 4:
                        $hotel = Hotel::whereId($tripPlaces[0]->placeId);
                        try {
                            if(file_get_contents(URL::asset('_images/hotels/' . $hotel->file . '/t-1.jpg')))
                                $trip->pic2 = URL::asset('_images/hotels/' . $hotel->file . '/' . $hotel->pic_1);
                        }
                        catch (Exception $x) {
                            $trip->pic2 = URL::asset('images/mainPics/noPicSite.jpg');
                        }
                        break;
                    case 6:
                        $majara = Majara::whereId($tripPlaces[0]->placeId);
                        try {
                            if(file_get_contents(URL::asset('_images/majara/' . $majara->file . '/t-1.jpg')))
                                $trip->pic2 = URL::asset('_images/hotels/' . $majara->file . '/' . $majara->pic_1);
                        }
                        catch (Exception $x) {
                            $trip->pic2 = URL::asset('images/mainPics/noPicSite.jpg');
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
                                $trip->pic2 = URL::asset('images/mainPics/noPicSite.jpg');
                            }
                        }
                        else {
                            try{
                                if(file_get_contents(URL::asset('_images/adab/soghat/' . $adab->file . '/t-1.jpg')))
                                    $trip->pic2 = URL::asset('_images/adab/soghat/' . $adab->file . '/' . $adab->pic_1);
                            }
                            catch (Exception $x) {
                                $trip->pic2 = URL::asset('images/mainPics/noPicSite.jpg');
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
                            $trip->pic3 = URL::asset('images/mainPics/noPicSite.jpg');
                        }
                        break;
                    case 3:
                        $restaurant = Restaurant::whereId($tripPlaces[0]->placeId);
                        try {
                            if(file_get_contents(URL::asset('_images/restaurant/' . $restaurant->file . '/t-1.jpg')))
                                $trip->pic3 = URL::asset('_images/restaurant/' . $restaurant->file . '/t-1.jpg');
                        }
                        catch (Exception $x) {
                            $trip->pic3 = URL::asset('images/mainPics/noPicSite.jpg');
                        }
                        break;
                    case 4:
                        $hotel = Hotel::whereId($tripPlaces[0]->placeId);
                        try {
                            if(file_get_contents(URL::asset('_images/hotels/' . $hotel->file . '/t-1.jpg')))
                                $trip->pic3 = URL::asset('_images/hotels/' . $hotel->file . '/' . $hotel->pic_1);
                        }
                        catch (Exception $x) {
                            $trip->pic3 = URL::asset('images/mainPics/noPicSite.jpg');
                        }
                        break;
                    case 6:
                        $majara = Majara::whereId($tripPlaces[0]->placeId);
                        try {
                            if(file_get_contents(URL::asset('_images/majara/' . $majara->file . '/t-1.jpg')))
                                $trip->pic3 = URL::asset('_images/hotels/' . $majara->file . '/' . $majara->pic_1);
                        }
                        catch (Exception $x) {
                            $trip->pic3 = URL::asset('images/mainPics/noPicSite.jpg');
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
                                $trip->pic3 = URL::asset('images/mainPics/noPicSite.jpg');
                            }
                        }
                        else {
                            try{
                                if(file_get_contents(URL::asset('_images/adab/soghat/' . $adab->file . '/t-1.jpg')))
                                    $trip->pic3 = URL::asset('_images/adab/soghat/' . $adab->file . '/' . $adab->pic_1);
                            }
                            catch (Exception $x) {
                                $trip->pic3 = URL::asset('images/mainPics/noPicSite.jpg');
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
                            $trip->pic4 = URL::asset('images/mainPics/noPicSite.jpg');
                        }
                        break;
                    case 3:
                        $restaurant = Restaurant::whereId($tripPlaces[0]->placeId);
                        try {
                            if(file_get_contents(URL::asset('_images/restaurant/' . $restaurant->file . '/t-1.jpg')))
                                $trip->pic4 = URL::asset('_images/restaurant/' . $restaurant->file . '/t-1.jpg');
                        }
                        catch (Exception $x) {
                            $trip->pic4 = URL::asset('images/mainPics/noPicSite.jpg');
                        }
                        break;
                    case 4:
                        $hotel = Hotel::whereId($tripPlaces[0]->placeId);
                        try {
                            if(file_get_contents(URL::asset('_images/hotels/' . $hotel->file . '/t-1.jpg')))
                                $trip->pic4 = URL::asset('_images/hotels/' . $hotel->file . '/' . $hotel->pic_1);
                        }
                        catch (Exception $x) {
                            $trip->pic4 = URL::asset('images/mainPics/noPicSite.jpg');
                        }
                        break;
                    case 6:
                        $majara = Majara::whereId($tripPlaces[0]->placeId);
                        try {
                            if(file_get_contents(URL::asset('_images/majara/' . $majara->file . '/t-1.jpg')))
                                $trip->pic4 = URL::asset('_images/hotels/' . $majara->file . '/' . $majara->pic_1);
                        }
                        catch (Exception $x) {
                            $trip->pic4 = URL::asset('images/mainPics/noPicSite.jpg');
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
                                $trip->pic4 = URL::asset('images/mainPics/noPicSite.jpg');
                            }
                        }
                        else {
                            try{
                                if(file_get_contents(URL::asset('_images/adab/soghat/' . $adab->file . '/t-1.jpg')))
                                    $trip->pic4 = URL::asset('_images/adab/soghat/' . $adab->file . '/' . $adab->pic_1);
                            }
                            catch (Exception $x) {
                                $trip->pic4 = URL::asset('images/mainPics/noPicSite.jpg');
                            }
                        }
                        break;
                }
            }
        }
    }
}
?>

<link rel="stylesheet" href="{{URL::asset('css/theme2/recentlyViewAndMyTrips.css?v=1')}}">

<script>

    var getRecentlyPath = '{{route('recentlyViewed')}}';

    function recentlyViews(uId, containerId) {

        $("#" + containerId).empty();

        $.ajax({
            type: 'post',
            url: getRecentlyPath,
            data: {
                uId: uId
            },
            success: function (response) {

                response = JSON.parse(response);

                for(i = 0; i < response.length; i++) {
                    element = "<div>";
                    element += "<a class='masthead-recent-card' style='text-align: right !important;' target='_self' href='" + response[i].placeRedirect + "'>";
                    element += "<div class='media-left' style='padding: 0 12px !important; margin: 0 !important;'>";
                    element += "<div class='thumbnail' style='background-image: url(" + response[i].placePic + ");'></div>";
                    element += "</div>";
                    element += "<div class='content-right'>";
                    element += "<div class='poi-title'>" + response[i].placeName + "</div>";
                    element += "<div class='rating'>";

                    if(response[i].placeRate == 5)
                        element += "<div class='ui_bubble_rating bubble_50'></div>";
                    else if(response[i].placeRate == 4)
                        element += "<div class='ui_bubble_rating bubble_40'></div>";
                    else if(response[i].placeRate == 3)
                        element += "<div class='ui_bubble_rating bubble_30'></div>";
                    else if(response[i].placeRate == 2)
                        element += "<div class='ui_bubble_rating bubble_20'></div>";
                    else
                        element += "<div class='ui_bubble_rating bubble_10'></div>";

                    element += "<br/>" + response[i].placeReviews + " نقد ";
                    element += "</div>";
                    element += "<div class='geo'>" + response[i].placeCity + "/ " + response[i].placeState + "</div>";
                    element += "</div>";
                    element += "</a></div>";

                    $("#" + containerId).append(element);
                }

            }
        });
    }
</script>

<div id="my-trips-not" class="ui_overlay ui_flyout global-nav-flyout global-nav-utility trips-flyout-container">
    <div>
        <div class="styleguide" id="masthead-saves-container">
            <div id="masthead-recent" class="masthead-recent">
                <div class="recent-header-container">
                    <a class="recent-header" href="{{route('recentlyViewTotal')}}" target="_self">بازدیدهای اخیر </a>
                </div>
                <div class="masthead-recent-cards-container">
                    <div id="dropdown-test3-card">
                        <div class="ui_close_x"></div>
                        <div class="test-title">خوش آمدید</div>
                        <div class="test-content">شما می توانید بازدیدهای اخیرتان را در اینجا ببینید</div>>
                    </div>
                    <div id="masthead-recent-cards-region">
                        <div id="recentlyViewed"></div>
                    </div>
                </div>
                <div class="see-all-button-container"><a href="{{route('recentlyViewTotal')}}" target="_self" class="see-all-button">مشاهده تمامی موارد </a></div>
            </div>
            <div id="masthead-trips">
                <div class="trips-header-container"><a class="trips-header" target="_self" href="{{URL('myTrips')}}">سفر های من </a></div>
                <div id="masthead-trips-tiles-region">
                    <div id="trips-tiles" class="column">
                        <div>
                            <a onclick="showPopUp()" class="single-tile is-create-trip">
                                <div class="tile-content">
                                    <span class="ui_icon plus"></span>
                                    <div class="create-trip-text">ایجاد سفر</div>
                                </div>
                            </a>

                            @foreach($trips as $trip)
                                <div id="mainDivTripImageRecentViewBodyProfile" onclick="document.location.href = '{{route('tripPlaces', ['tripId' => $trip->id])}}'" class="trip-images ui_columns is-gapless is-multiline is-mobile">
                                    @if($trip->placeCount > 0)
                                        <div class="trip-image ui_column is-6" style="background: url('{{$trip->pic1}}') repeat 0 0; background-size: 100% 100%"></div>
                                    @else
                                        <div class="bg-color-recentlyViewBodyProfile trip-image trip-image-empty ui_column is-6"></div>
                                    @endif
                                    @if($trip->placeCount > 1)
                                        <div class="trip-image ui_column is-6" style="background: url('{{$trip->pic2}}')  repeat 0 0; background-size: 100% 100%"></div>
                                    @else
                                        <div class="bg-color-recentlyViewBodyProfile trip-image trip-image-empty ui_column is-6"></div>
                                    @endif
                                    @if($trip->placeCount > 2)
                                        <div class="trip-image ui_column is-6" style="background: url('{{$trip->pic3}}') repeat 0 0; background-size: 100% 100%"></div>
                                    @else
                                        <div class="bg-color-recentlyViewBodyProfile trip-image trip-image-empty ui_column is-6"></div>
                                    @endif
                                    @if($trip->placeCount > 3)
                                        <div class="trip-image ui_column is-6" style="background: url('{{$trip->pic4}}') repeat 0 0; background-size: 100% 100%"></div>
                                    @else
                                        <div class="bg-color-recentlyViewBodyProfile trip-image trip-image-empty ui_column is-6"></div>
                                    @endif
                                </div>
                                <div class="create-trip-text font-size-12em">{{$trip->name}} </div>
                                @if($trip->to_ != "" && $trip->from_ != "")
                                    <div class="create-trip-text" id="createTripTextRecentlyViewBodyProfile">
                                        {{convertStringToDate2($trip->to_)}}
                                        <p style="">الی</p>
                                        {{convertStringToDate2($trip->from_)}}
                                    </div>
                                @else
                                    <div class="create-trip-text" id="createTripTextRecentlyViewBodyProfileElse">بدون تاریخ</div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="bookmarkmenu" class="ui_overlay ui_flyout global-nav-flyout global-nav-utility trips-flyout-container">
    <div>
        <div class="styleguide" id="masthead-saves-container">
            <div id="masthead-recent" class="masthead-recent-class">
                <div class="recent-header-container">
                    <a class="recent-header" href="{{route('recentlyViewTotal')}}" target="_self"> نشانه‌گذاری شده‌ها </a>
                </div>
                <div class="masthead-recent-cards-container" id="bookMarksDiv">

                </div>
                {{--<div class="see-all-button-container"><a href="{{route('recentlyViewTotal')}}" target="_self" class="see-all-button">مشاهده تمامی موارد </a></div>--}}
            </div>

        </div>
    </div>
</div>
