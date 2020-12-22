@extends('layouts.bodyProfile')

@section('header')
    @parent

    <title>کوچیتا | سفرهای من</title>

    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/myTrips.css?v='.$fileVersions)}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/abbreviations.css?v='.$fileVersions)}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/saves-rest-client.css?v='.$fileVersions)}}' data-rup='saves-rest-client'/>

    <style>
        #saves-all-trips .trip-tile-container .trip-tile.new-trip{
            padding: 120px 0;
        }
        .ui_column{
            float: right;
        }
        .cardFooter{
            display: flex;
            flex-direction: column;
        }
        .cardFooter > div{
            padding: 5px !important;
        }
        .cardPics{
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            border: solid white 1px;
        }
        .cardPics > img{
            width: 100%;
            max-width: none !important;
        }
        .trip-name{
            display: flex;
            justify-content: space-between;
        }
        .trip-name .iconSec{
            display: flex;
            font-weight: 100;
        }
        .trip-header{
            padding: 5px 10px !important;
        }
        .trip-header .icons{
            display: flex;
            position: relative;
            top: auto;
            right: auto;
            justify-content: center;
            align-items: center;
            border: solid 1px;
            width: 25px;
            margin-right: 3px;
            transition: .3s;
        }
        .trip-header .delete{
            color: red;
        }
        .trip-header .settingIcon{
            color: gray;
        }
        .trip-header .delete:hover{
            color: white;
            background: red;
            border-color: red;
        }
        .trip-header .edit{
            color: var(--koochita-blue);
        }
        .trip-header .edit:hover{
            color: white;
            background: var(--koochita-blue);
            border-color:  var(--koochita-blue);
        }
        .tripDate{
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
            direction: rtl;
            width: 100%;
            text-align: right;
            position: relative;
            font-size: 12px;
        }

        .tripDate .date{
            direction: ltr;
            color: black;
            font-style: normal;
        }
        .tripDate .date > span{
            display: inline-flex;
        }
        .cardPics-1{
            width: 100%;
        }
        .cardPics-2{
            width: 50%;
        }
        .picSec.row{
            display: flex !important;
            flex-wrap: wrap !important;
            width: 100% !important;
            margin: 0 !important;
        }

        .emptyTripDiv{
            display: flex;
            flex-direction: column;
        }
        .emptyTripDiv .emptyTripPic{
            opacity: .3;
            text-align: center;
            filter: grayscale(1);
        }
        .emptyTripDiv .emptyTripPic .text{
            font-size: 25px;
            margin: 10px 0px;
        }
        .emptyTripDiv .emptyTripPic img{
            max-width: 400px;
            width: 100%;
        }
        @media (max-width: 768px) {
            .ui_column{
                float: none;
            }

        }
    </style>
@stop


@section('main')

    @include('general.addToTripModal')

    <div id="MAIN" class="Saves prodp13n_jfy_overflow_visible position-relative">
        <div id="BODYCON" class="col easyClear poolB adjust_padding new_meta_chevron_v2 position-relative">
            <div class="wrpHeader"></div>
            <div id="saves-body" class="styleguide position-relative">
                <div id="saves-root-view"  class="position-relative">
                    <div id="saves-all-trips"  class="position-relative">
                        <div class="saves-title title position-relative">
                            <span>
                                سفرهای من
                            </span>
                            <div onclick="createNewTrip(getMyTripsInPage)" class="header-create-trip ui_button primary" style="margin: 0px auto;">+ ایجاد سفر </div>
                        </div>

                        <div id="emptyTrip" class="emptyTripDiv">
                            <div class="emptyTripPic">
                                <div class="text">برنامه سفرت چیه ؟</div>
                                <img src="{{URL::asset('images/icons/mytrip0.svg')}}" alt="سفر ندارید">
                                <div class="text">بیا برای یه سفر خوب برنامه ریزی کنیم.</div>
                            </div>
                        </div>
                        <div id="hasTrip" class="trips-container ui_container hidden">
                            <div class="container">
                                <div id="tripCardSection" class="row"></div>
                            </div>
                        </div>
                    </div>
                    <div class="notification-container"></div>
                </div>
            </div>
            <div class="ui_backdrop dark display-none" ></div>
        </div>
    </div>

    <script>
        var getMyTripsInPage = () => getMyTripsPromiseFunc().then(response => createTripCard(response));

        getMyTripsInPage();

        function createTripCard(_trips){
            var cards = '';

            if(_trips.length > 0){

                _trips.map(item => {
                    var tripPicHtml = '';
                    var tripPlacePicCount = item.placePic.length;
                    if(tripPlacePicCount == 0){
                        tripPicHtml = `<div class="cardPics cardPics-1" style="height: 200px; background: gainsboro;">
                                           <img src="{{URL::asset('images/icons/KOFAV0.svg')}}">
                                       </div>`;
                    }
                    else if(tripPlacePicCount == 1){
                        tripPicHtml = `<div class="cardPics cardPics-1" style="height: 200px;">
                                            <img src="${item.placePic[0]}" class="resizeImgClass">
                                       </div>`
                    }
                    else if(tripPlacePicCount == 2){
                        tripPicHtml = ` <div class="cardPics-1 cardPics" style="height: 100px;">
                                            <img src="${item.placePic[0]}" class="resizeImgClass">
                                        </div>
                                        <div class="cardPics-1 cardPics" style="height: 100px;">
                                            <img src="${item.placePic[1]}" class="resizeImgClass">
                                        </div>`;
                    }
                    else if(tripPlacePicCount == 3){
                        tripPicHtml = ` <div class=" cardPics-2 cardPics" style="height: 100px;">
                                            <img src="${item.placePic[0]}}" class="resizeImgClass">
                                        </div>
                                        <div class="cardPics-2 cardPics" style="height: 100px;">
                                            <img src="${item.placePic[1]}" class="resizeImgClass">
                                        </div>
                                        <div class="cardPics-1 cardPics" style="height: 100px;">
                                            <img src="${item.placePic[2]}" class="resizeImgClass">
                                        </div>`
                    }
                    else if(tripPlacePicCount == 4){
                        item.placePic.map(pic => {
                            tripPicHtml += `<div class="cardPics-2 cardPics" style="height: 100px;">
                                                <img src="${pic}" class="resizeImgClass">
                                            </div>`;
                        });
                    }

                   cards += `<div class="trip-tile-container ui_column col-lg-3 col-md-4 col-sm-6">
                                <a href="${item.url}" class="trip-tile ui_card is-fullwidth">
                                    <div class="trip-header">
                                        <div class="trip-name">
                                            <div>${item.name}</div>
                                            <div class="iconSec"></div>
                                       </div>
                                       <div class="tripDate">
                                           <div class="date calendarIconA">
                                               <span>${item.to_}</span>
                                               <span>تا</span>
                                               <span>${item.from_}</span>
                                            </div>
                                           <div class="userIconA user">${item.member}</div>
                                        </div>
                                    </div>
                                   <div class="row picSec">${tripPicHtml}</div>
                                   <div class="trip-details ui_columns is-mobile is-fullwidth cardFooter">
                                        <div class="trip-itemcount ui_column">تعداد اماکن موجود : ${item.placeCount}</div>
                                        <div class="trip-last-modified ui_column">
                                            آخرین بازید :
                                            <span>${item.lastSeen}</span>
                                        </div>
                                   </div>
                                </a>
                             </div>`;
                });

                $('#emptyTrip').addClass('hidden');
                $('#hasTrip').removeClass('hidden');
            }

            $('#tripCardSection').html(cards);
        }
    </script>

@stop