<?php $mode = "profile"; $user = Auth::user(); ?>
@extends('layouts.bodyProfile')

@section('header')
    @parent

    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/myTripsInner.css?v=2')}}'/>
    <link rel="stylesheet" href="{{URL::asset('css/shazdeDesigns/abbreviations.css?v=1')}}">

    <style>
        .no-saves-content.content{
            flex-direction: column;
            text-align: center;
            font-size: 32px;
            height: 23vh;
            display: flex;
            align-items: center;
            justify-content: center;

        }
        .no-saves-content.content .BookMarkIconEmpty{
            color: var(--koochita-yellow);
            font-size: 50px;
        }
        .headerTitle{
            text-align: center;
            color: black;
            border: none !important;
            margin-bottom: 15px;
        }
        .colPlaceCard{
            padding: 15px;
            border-radius: 10px 10px 0px 0px;
            float: right;
        }
        .colPlaceCard.fullShow{
            background: var(--koochita-blue);
            padding-bottom: 17px;
        }
        .placeCard{
            width: 100% !important;
            background: white;
            border: 1px solid #e5e5e5;
            display: flex;
            flex-direction: column;
            border-radius: 10px;
            padding: 0;
        }
        .placeCard:hover{
            /*box-shadow: 0px 0px 3px 1px #dedede;*/
        }
        .placeCard .header{
            padding: 10px;
            display: flex;
            justify-content: space-between;
            width: 100%;
            position: relative;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .placeCard .header .name{
            font-weight: bold;
            font-size: 15px;
            color: black;
        }
        .placeCard .header .removeBtnTargetHelp_16{
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
        .placeCard .pic{
            width: 97%;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            overflow: hidden;
            margin: 0 auto;
        }
        .placeCard .pic > img{
            width: 100%;
        }
        .placeCard .footer{
            display: flex;
            justify-content: center;
            padding: 10px 0px;
        }

        .placeDetailsToggleBar .leftSec{
            padding: 0px;
        }
        .placeDetailsToggleBar > div{
            height: 250px !important;
        }
        .morePlaceInfo{
            font-size: 9px;
            color: white;
            border: none;
            background: var(--koochita-green);
            border-radius: 20px;
            padding: 4px 8px;
        }
        .morePlaceInfo:focus{
            color: white;
            border: none;
            background: var(--koochita-green);
        }
        .morePlaceInfo:hover{
            color: white;
            border: none;
            background: var(--koochita-green);
        }
        @media (max-width: 767px) {
            .colPlaceCard{
                width: 50%
            }

            .placeDetailsToggleBar > div{
                height: auto !important;
            }
        }
        @media (max-width: 500px) {
            .colPlaceCard{
                width: 100%
            }
        }
    </style>
@stop

@section('main')

    <div id="MAIN" class="Saves prodp13n_jfy_overflow_visible" style="border: none;">
        <div id="BODYCON" ng-app="mainApp" class="col easyClear poolB adjust_padding new_meta_chevron_v2">
            <div class="wrpHeader"></div>
            <div id="saves-body" class="styleguide">
                <div id="saves-root-view">
                    <div id="saves-all-trips">
                        <div class="ui_column helpBtnIcon" style="padding: 0px;">
                            <a class="link float-left cursor-pointer" onclick="initHelp(12, [1, 2, 3, 4, 5], 'MAIN', 100, 400)">
                                <div id="initHelpDiv" style="background-image: url('{{URL::asset('images') . '/help_share.png'}}')"></div>
                            </a>
                        </div>

                        @if($placesCount == 0)
                            <div id="saves-itinerary-container">
                                <div id="trip-dates-region"></div>
                                <div id="trip-side-by-side">
                                    <div class="ui_columns">
                                        <div id="trip-items-region" class="ui_column " data-column-name="items">
                                            <div id="trip-item-collection-container" data-bucket-id="unscheduled" class="drag_container">
                                                <div class="no-saves-container">
                                                    <div class="no-saves-content content">
                                                        <div class="ui_icon BookMarkIconEmpty"></div>
                                                        <div class="cta-header">
                                                            هنوز چیزی ذخیره نشده است
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="container">
                                <div class="row">
                                    <h1 class="headerTitle">
                                        نشون کرده ها
                                    </h1>
                                </div>
                                <div id="tableSection" class="row">
                                    @foreach($places as $key => $place)
                                        <div id="place_{{$place->logId}}" class="col-sm-6 col-md-4 col-lg-3 colPlaceCard">
                                            <div class="placeCard">
                                                <div class="header">
                                                    <a href="{{$place->url}}" class="name">{{$place->name}}</a>
                                                    <div class="removeBtnTargetHelp_16" onclick="deleteBookMark({{$place->id}}, {{$place->kindPlaceId}}, {{$place->logId}})"></div>
                                                </div>
                                                <div class="pic">
                                                    <img src="{{$place->pic}}" alt="">
                                                </div>
                                                <div class="footer">
                                                    <button data-toggle="tooltip" title="نمایش جزئیات" class="btn btn-default morePlaceInfo" onclick="showPlaceInfo({{$place->logId}}, {{$key}})">
                                                        اطلاعات بیشتر
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="placeFullInfo" style="display: none;">
        <div class="trip-tile-container ui_column is-12 placeDetailsToggleBar showPlaceInfo">
            <div class="tabSection hideOnPhone">
                <div class="active" onclick="choosePlaceInfoTab('info', this)">اطلاعات محل</div>
                <div onclick="choosePlaceInfoTab('map', this)">نقشه</div>
            </div>
            <div class="rightSec show">
                <div class="placeInfo">
                    <div class="img">
                        <img  class="moreInfoPic" style="width: 100%">
                    </div>
                    <div class="info">
                        <div class="name">
                            <a href="#" target="_blank" class="placeName lessShowText"></a>
                            <span class="city"></span>
                        </div>
                        <div class="rating">
                            <span class="ui_bubble_rating bubble_00"></span>
                            <span class="reviewCount"></span>
                        </div>
                        <div class="address"></div>
                    </div>
                </div>
            </div>
            <div class="leftSec">
                <div id="map_" class="mapSec"></div>
            </div>
        </div>
    </div>

    <script>
        let map;
        let openId = 0;
        let places = {!! json_encode($places) !!};
        let fullPlaceInfoHtml = $('#placeFullInfo').html();
        $('#placeFullInfo').remove('');

        function showPlaceInfo(_id, _index) {
            let selectedPlace = null;
            places.forEach(item => {
                if(item.logId == _id)
                    selectedPlace = item;
            });

            $(".addCommentInput").val('');
            $(".placeSelectedId").val(0);
            $('.placeDetailsToggleBar').remove();
            $('.fullShow').removeClass('fullShow');

            if(selectedPlace != null && openId != _id){
                openId = _id;
                let width = $('#tableSection').width();
                let elemWidth = $('#place_' + _id).width() + (2 * parseFloat($('#place_' + _id).css('padding').split('px')[0]));
                let countInRow = Math.floor(width/elemWidth);

                let nextCount = (countInRow - 1) - (_index % countInRow);
                let showAfter = $("#place_" + _id);
                for(let i = 0; i < nextCount; i++) {
                    nextElemes = showAfter.next();
                    if(nextElemes.length == 0)
                        break;
                    showAfter = nextElemes
                }

                $(fullPlaceInfoHtml).insertAfter(showAfter[0]);

                $(".placeSelectedId").val(_id);

                $("#place_" + _id).addClass('fullShow');

                if(selectedPlace.C && selectedPlace.D) {
                    initMap(selectedPlace.C, selectedPlace.D);
                    setTimeout(function(){
                        mapMarker = new google.maps.Marker({
                            position: new google.maps.LatLng(selectedPlace.C, selectedPlace.D),
                            map: map,
                            title: selectedPlace.name
                        });
                    }, 200);
                }
                else
                    $('#map_').hide();

                $('.placeName').text(selectedPlace.name);
                $('.placeName').attr('href', selectedPlace.url);
                $('.moreInfoPic').attr('src', selectedPlace.pic);

                if(selectedPlace.address)
                    $('.address').text(selectedPlace.address);

                $('.reviewCount').text(selectedPlace.review + ' نقد ');
                $('.rating').find('.ui_bubble_rating').addClass('bubble_' + selectedPlace.rate + '0');

                $('.rightSec').find('.city').text(selectedPlace.city + ' در ' + selectedPlace.state);
            }
            else
                openId = 0;
        }

        function initMap(x = '0', y = '0') {
            var mapOptions = {
                zoom: 14,
                center: new google.maps.LatLng(x, y), // New York
                styles: [
                    {
                        "featureType":"landscape",
                        "stylers":[
                            {"hue":"#FFA800"},
                            {"saturation":0},
                            {"lightness":0},
                            {"gamma":1}
                        ]}, {
                        "featureType":"road.highway",
                        "stylers":[
                            {"hue":"#53FF00"},
                            {"saturation":-73},
                            {"lightness":40},
                            {"gamma":1}
                        ]},	{
                        "featureType":"road.arterial",
                        "stylers":[
                            {"hue":"#FBFF00"},
                            {"saturation":0},
                            {"lightness":0},
                            {"gamma":1}
                        ]},	{
                        "featureType":"road.local",
                        "stylers":[
                            {"hue":"#00FFFD"},
                            {"saturation":0},
                            {"lightness":30},
                            {"gamma":1}
                        ]},	{
                        "featureType":"water",
                        "stylers":[
                            {"hue":"#00BFFF"},
                            {"saturation":6},
                            {"lightness":8},
                            {"gamma":1}
                        ]},	{
                        "featureType":"poi",
                        "stylers":[
                            {"hue":"#679714"},
                            {"saturation":33.4},
                            {"lightness":-25.4},
                            {"gamma":1}
                        ]}
                ]
            };
            var mapElement = document.getElementById('map_');
            map = new google.maps.Map(mapElement, mapOptions);
        }

        function choosePlaceInfoTab(_kind, _element){
            $('.tabSection').find('.active').removeClass('active');
            $(_element).addClass('active');
            $('.placeDetailsToggleBar').find('.rightSec').removeClass('show');
            $('.placeDetailsToggleBar').find('.leftSec').removeClass('show');

            if(_kind == 'info')
                $('.placeDetailsToggleBar').find('.rightSec').addClass('show');
            else
                $('.placeDetailsToggleBar').find('.leftSec').addClass('show');
        }

        function deleteBookMark(_placeId, _kindPlaceId, _logId){
            $.ajax({
                type: 'post',
                url: '{{route("setBookMark")}}',
                data: {
                    'placeId': _placeId,
                    'kindPlaceId': _kindPlaceId
                },
                success: function (response) {
                    if (response == "ok-del"){
                        $('#place_' + _logId).remove();
                        showSuccessNotifi('این صفحه از حالت ذخیره خارج شد', 'left', 'var(--koochita-blue)');
                    }
                },
                error:function(err){
                    showSuccessNotifi('مشکلی در ارتباط با سرور به وجود امده', 'left', 'red');
                }
            })

        }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdVEd4L2687AfirfAnUY1yXkx-7IsCER0&callback=initMap"></script>

@stop
