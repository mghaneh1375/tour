@extends('layouts.bodyPlace')

@section('head')
    <meta content="article" property="og:type"/>
    <meta property="og:title" content="{{$place->seoTitle}}"/>
    <meta property="title" content="{{$place->seoTitle}}"/>
    <meta name="twitter:title" content="{{$place->seoTitle}}"/>
    <meta name="twitter:card" content="{{$place->meta}}"/>
    <meta name="description" content="{{$place->meta}}"/>
    <meta name="twitter:description" content="{{$place->meta}}"/>
    <meta property="og:description" content="{{$place->meta}}"/>
    <meta property="article:author " content="کوچیتا"/>
    <meta name="keywords" content="{{$place->keyword}}">
    <meta property="og:url" content="{{Request::url()}}"/>

    <meta property="og:image" content="{{$place->pic}}"/>
    <meta property="og:image:secure_url" content="{{$place->pic}}"/>
    <meta name="twitter:image" content="{{$place->pic}}"/>
    <meta property="og:image:width" content="550"/>
    <meta property="og:image:height" content="367"/>

    <title>{{isset($place->seoTitle) ? $place->seoTitle : $place->name}} </title>

    <link rel="stylesheet" href="{{URL::asset('css/shazdeDesigns/hotelDetail.css?v='.$fileVersions)}}">
    <link rel="stylesheet" href="{{URL::asset('js/emoji/area/emojionearea.css?v='.$fileVersions)}}">

    <script defer src="{{URL::asset('js/emoji/area/emojionearea.js')}}"></script>
    <script defer src="{{URL::asset('js/hotelDetails/hoteldetails_2.js')}}"></script>

    <style>

        .sogatSanieMobileFeatures{
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            background: white;
            padding-top: 15px;
            margin: 0px;
        }
        .featureBox{
            text-align: center;
            padding: 5px 15px;
            box-shadow: 2px 2px 4px 0px #333;
            margin: 6px 7px;
            border-radius: 8px;
        }
        .featureBox .title{
            font-weight: bold;
            color: var(--koochita-green);
        }
        .featureBox .value{
            display: flex;
            justify-content: center;
        }
        .featureBox .value .val{
            margin: 0px 10px;
            font-size: 11px;
            text-align: center;
        }

        .sogatFeature{
            margin: 10px 0px;
        }
        .sogatFeature .feat{
            display: flex;
            margin: 5px 0px;
        }
        .sogatFeature .feat .title{
            color: black;
            margin-left: 5px;
        }
        .sogatFeature .feat .value{
            font-weight: bold;
            color: green;
        }

        .seperatorSections{
            background: #f8f8f8;
            height: 15px;
            width: 100%;
            border-top: solid 1px #4dc7bc52;
            border-bottom: solid 1px #4dc7bc52;
            display: none;
        }

        @media (max-width: 767px) {
            .seperatorSections{
                display: block;
            }
        }

    </style>

    <style>
        .mainReview{
            width: 100%;
            height: 400px;
        }
        .placeData{
            background: white;
            margin-top: 10px;
            direction: rtl;
            padding: 10px;
            display: flex;
            flex-wrap: wrap;
            border-radius: 10px;
        }
        .placeData .picSec{
            width: 100px;
            height: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            border-radius: 10px;
        }
        .placeData .info{
            width: calc(100% - 110px);
            margin-right: 10px;
        }
        .placeData .name{
            font-size: 18px;
        }
        .placeData .placeRateStars{
            font-size: 11px;
        }
    </style>
@stop


@section('main')
    @include('component.smallShowReview')

    <div class="container">
        <div class="col-md-4 placeData">
            <div class="picSec">
                <img src="{{$place->pic}}" class="resizeImgClass" onload="fitThisImg(this)">
            </div>
            <div class="info">
                <div class="name">{{$place->name}}</div>
                <div class="ui_bubble_rating bubble_{{$place->fullRate}}0 placeRateStars"></div>
            </div>

            <div></div>
        </div>
        <div class="col-md-8">
            <div id="mainReview" class="mainReview placeHolderAnime"></div>
        </div>
    </div>


    <script>
        $(window).ready(() => {
            getSingleFullDataReview( {{$reviewId}}, _review => showFullReviews({review: _review, kind: 'append', sectionId: 'mainReview'}) );
        });
    </script>
@stop
