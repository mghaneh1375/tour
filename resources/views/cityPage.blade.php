<!DOCTYPE html>
<html lang="fa">

<head>
    @include('layouts.topHeader')
    <?php
        $placeTitleName = isset($place->state) ? $place->listName : $place->name;
    ?>
    <title>کوچیتا |معرفی اقامتگاه ها و جاهای دیدنی {{$placeTitleName}} </title>

    <meta content="article" property="og:type"/>
    <meta name="title" content="{{$placeTitleName}} | اطلاعات گردشگری {{$placeTitleName}} – جاهای دیدنی {{$placeTitleName}} – هتل های {{$placeTitleName}} – رستوران های {{$placeTitleName}}- صنایع‌دستی و سوغات  {{$placeTitleName}} | کوچیتا" />
    <meta name="og:title" content="{{$placeTitleName}} | اطلاعات گردشگری {{$placeTitleName}} – جاهای دیدنی {{$placeTitleName}} – هتل های {{$placeTitleName}} – رستوران های {{$placeTitleName}}- صنایع‌دستی و سوغات  {{$placeTitleName}} | کوچیتا" />
    <meta name="twitter:title" content="{{$placeTitleName}} | اطلاعات گردشگری {{$placeTitleName}} – جاهای دیدنی {{$placeTitleName}} – هتل های {{$placeTitleName}} – رستوران های {{$placeTitleName}}- صنایع‌دستی و سوغات  {{$placeTitleName}} | کوچیتا" />
    <meta name='description' content='. هر چه یک گردشگر باید درباره ی {{$placeTitleName}}  و هتل های {{$placeTitleName}} و جاهای دیدنی {{$placeTitleName}} و غذاهای محلی {{$placeTitleName}} و رستوران های {{$placeTitleName}} و سوغات {{$placeTitleName}} و صنایع دستی {{$placeTitleName}} و روستاهای {{$placeTitleName}} و بوم گردی های {{$placeTitleName}} و اطلاعات جامع {{$placeTitleName}} در این صفحه می توانید ببینید  ' />
    <meta name='og:description' content='. هر چه یک گردشگر باید درباره ی {{$placeTitleName}}  و هتل های {{$placeTitleName}} و جاهای دیدنی {{$placeTitleName}} و غذاهای محلی {{$placeTitleName}} و رستوران های {{$placeTitleName}} و سوغات {{$placeTitleName}} و صنایع دستی {{$placeTitleName}} و روستاهای {{$placeTitleName}} و بوم گردی های {{$placeTitleName}} و اطلاعات جامع {{$placeTitleName}} در این صفحه می توانید ببینید  ' />
    <meta name='twitter:description' content='. هر چه یک گردشگر باید درباره ی {{$placeTitleName}}  و هتل های {{$placeTitleName}} و جاهای دیدنی {{$placeTitleName}} و غذاهای محلی {{$placeTitleName}} و رستوران های {{$placeTitleName}} و سوغات {{$placeTitleName}} و صنایع دستی {{$placeTitleName}} و روستاهای {{$placeTitleName}} و بوم گردی های {{$placeTitleName}} و اطلاعات جامع {{$placeTitleName}} در این صفحه می توانید ببینید  ' />
    <meta name='keywords' content='جاذبه های  {{$placeTitleName}} – اطلاعات گردشگری {{$placeTitleName}} – نقد و بررسی {{$placeTitleName}} ' />

    @if(isset($place->image))
        <meta property="og:image" content="{{URL::asset($place->image)}}"/>
        <meta property="og:image:secure_url" content="{{URL::asset($place->image)}}"/>
        <meta property="og:image:width" content="550"/>
        <meta property="og:image:height" content="367"/>
        <meta name="twitter:image" content="{{URL::asset($place->image)}}"/>
    @endif

    <meta property="article:tag" content="{{$placeTitleName}}"/>
    <meta property="article:tag" content="جاهای دیدنی {{$placeTitleName}}"/>
    <meta property="article:tag" content="بوم گردی های {{$placeTitleName}}"/>
    <meta property="article:tag" content="{{$placeTitleName}} را بشناسیم"/>
    <meta property="article:tag" content="اطلاعات {{$placeTitleName}}"/>
    <meta property="article:tag" content="غذاهای محلی {{$placeTitleName}}"/>
    <meta property="article:tag" content="هتل های {{$placeTitleName}}"/>
    <meta property="article:tag" content="رستوران های {{$placeTitleName}}"/>
    <meta property="article:tag" content="سوغات {{$placeTitleName}}"/>
    <meta property="article:tag" content="صنایع دستی {{$placeTitleName}}"/>
    <meta property="article:tag" content="روستاهای {{$placeTitleName}}"/>

    <link rel="stylesheet" type='text/css' href="{{URL::asset('css/shazdeDesigns/usersActivities.css?v='.$fileVersions)}}">
    <link rel="stylesheet" type='text/css' href="{{URL::asset('css/theme2/article.min.css?v='.$fileVersions)}}"/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/cityPage.css?v='.$fileVersions)}}'/>
</head>

<body>

@include('general.forAllPages')

@include('layouts.header1')

@include('component.smallShowReview')

<script type="application/ld+json">
                {
                    "@context": "https://schema.org",
                    "@type": "BreadcrumbList",
                    "itemListElement":
                    [
                        @if(isset($place->state))
        {
            "@type": "ListItem",
            "item":  {
                "@type": "Thing",
                "name": "استان {{$place->state}}",
                                "alternateName": "استان {{$place->state}}",
                                "url": "{{url('cityPage/state/'.$place->state)}}",
                                "id":"state"
                            },
                            "position": "2"
                        },
                        @endif
    {
        "@type": "ListItem",
        "item":  {
            "@type": "Thing",
            "name": "{{$place->name}}",
                                "alternateName": "{{$place->name}}",
                                "url": "{{Request::url()}}",
                                "id":"city"
                            },
                            "position": "3"
                        },
                        {
                            "@type": "ListItem",
                            "item":  {
                                "@type": "Thing",
                                "name": "خانه",
                                "alternateName": "کوچیتا | سامانه جامع گردشگری",
                                "url": "{{url('/')}}",
                                "id":"home"
                            },
                            "position": "1"
                        }
                    ]
                }
            </script>

<div class="container cpBody">
    <div class="cpBorderBottom cpHeader hideOnPhone">

        <div class="cpHeaderRouteOfCityName">

            <a href="{{url('/')}}" class="navigatorLinks">
                <span>{{__('صفحه اصلی')}}</span>
            </a>
            <span style="color: var(--koochita-yellow)"> > </span>
            @if(isset($place->state))
                <a href="{{url('cityPage/state/'.$place->state)}}" class="navigatorLinks">
                    <span>استان {{$place->state}}</span>
                </a>
                <span style="color: var(--koochita-yellow)"> > </span>
                <span class="navigatorLinks" style="font-size: 13px">{{$place->name}}</span>
            @else
                <span class="navigatorLinks" style="font-size: 13px">{{$place->name}}</span>
            @endif
        </div>

        <div class="cpHeaderCityName">{{$place->name}}</div>
    </div>

    <div class="row">
        <div id="commentSection" class="col-md-3 text-align-right mainReviewSection hideOnTablet">
            <div class="row" style="font-size: 25px; margin: 5px 10px; border-bottom: solid 1px #f3f3f3;">
                {{__('تازه ترین پست ها')}}
            </div>
            <div id="reviewSection" class="postsMainDivInSpecificMode cpCommentBox cpBorderBottom" style="display: none; width: 100%"></div>
            <div id="reviewPlaceHolderSection" class="postsMainDivInSpecificMode cpCommentBox cpBorderBottom" style="width: 100%"></div>
        </div>

        <div id="cpBorderLeft" class="col-md-9 cpMainContent">
            <div class="row cpMainBox">
                <div class="col-md-8 col-xs-12 pd-0Imp cpSliderSec">
                    @if(isset($place->pic) && count($place->pic) > 0)
                        <div class="cityPagePics swiper-container">
                            <div class="swiper-wrapper position-relative"  style="height: 100%">
                                @for($i = 0; $i < count($place->pic) && $i < 5; $i++)
                                    <div class="swiper-slide position-relative cityImgSlider" onclick="showSliderPic()">
                                        <img src="{{$place->pic[$i]['mainPic']}}" class="resizeImgClass" style="width: 100%;" alt="{{ $place->pic[$i]['alt'] }}" onload="fitThisImg(this)">
                                    </div>
                                @endfor
                            </div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>

                            <div class="hideOnScreen cpShowOnSlider">
                                @if(isset($place->state))
                                    <div class="cpStateName">
                                        <span class="cpNameLabel">استان :</span>
                                        {{$place->state}}
                                    </div>
                                    <div class="cpCityName">
                                        <span class="cpNameLabel">شهر :</span>
                                        {{$place->name}}
                                    </div>
                                @else
                                    <div class="cpStateName">
                                        <span class="cpNameLabel">استان :</span>
                                        {{$place->name}}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <img class="cityPagePics cpPic" src="{{$place->image}}">
                    @endif
                    <div class="col-xs-12 underSlider hideOnTablet ">
                        <div class="cpLittleMenu infoLittleMenu">
                            <img src="{{URL::asset('images/icons/info.png')}}">
                        </div>
                        <a class="col-xs-2 cpLittleMenu" href="#">
{{--                            <img class="cpLittleMenuImg" src="{{URL::asset('images/icons/cinema.png')}}" alt="{{__('سینما')}}">--}}
                            <div class="cityPageIcon fas fa-video"></div>
                            <div class="textCityPageIcon">{{__('سینما')}}</div>
                            {{--<div class="textCityPageIcon" style="color: var(--koochita-blue)">1000</div>--}}
                        </a>
                        <a class="col-xs-2 cpLittleMenu" href="#">
                            <img class="cpLittleMenuImg" src="{{URL::asset('images/icons/bakery.png')}}" alt="{{__('قنادی')}}">
                            <div class="textCityPageIcon">{{__('قنادی')}}</div>
                            {{--<div class="textCityPageIcon" style="color: var(--koochita-blue)">1000</div>--}}
                        </a>
                        <a class="col-xs-2 cpLittleMenu" href="#">
                            <img class="cpLittleMenuImg" src="{{URL::asset('images/icons/mortarboard(1).png')}}" alt="{{__('آموزش')}}">
                            <div class="textCityPageIcon">{{__('آموزش')}}</div>
                            {{--<div class="textCityPageIcon" style="color: var(--koochita-blue)">1000</div>--}}
                        </a>
                        <a class="col-xs-2 cpLittleMenu" href="#">
                            <img class="cpLittleMenuImg" src="{{URL::asset('images/icons/culture.png')}}" alt="{{__('فرهنگ')}}">
                            <div class="textCityPageIcon">{{__('فرهنگ')}}</div>
                            {{--<div class="textCityPageIcon" style="color: var(--koochita-blue)">1000</div>--}}
                        </a>
                        <a class="col-xs-2 cpLittleMenu" href="#">
                            <img class="cpLittleMenuImg" src="{{URL::asset('images/icons/barbershop.png')}}" alt="{{__('آرایشگاه')}}">
                            <div class="textCityPageIcon">{{__('آرایشگاه')}}</div>
                            {{--<div class="textCityPageIcon" style="color: var(--koochita-blue)">1000</div>--}}
                        </a>
                        <a class="col-xs-2 cpLittleMenu" href="#">
{{--                            <img class="cpLittleMenuImg" src="{{URL::asset('images/icons/fuel.png')}}" alt="{{__('سوخت')}}">--}}
                            <div class="cityPageIcon fas fa-gas-pump"></div>
                            <div class="textCityPageIcon">{{__('سوخت')}}</div>
                            {{--<div class="textCityPageIcon" style="color: var(--koochita-blue)">1000</div>--}}
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12 pd-0Imp hideOnPhone">
                    <div class="col-xs-12 zpr">
                        <a class="col-xs-4 cpLittleMenu" href="{{url('placeList/4/' . $kind . '/' . $place->listName)}}">
                            <div class="cityPageIcon hotel"></div>
                            <div class="textCityPageIcon">{{__('هتل')}}</div>
                            <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['hotel']}}</div>
                        </a>
                        <a class="col-xs-4 cpLittleMenu" href="#">
                            <div class="cityPageIcon ticket"></div>
                            <div class="textCityPageIcon">{{__('بلیط')}}</div>
                        </a>
                        <a class="col-xs-4 cpLittleMenu" href="{{url('placeList/1/' . $kind . '/' . $place->listName)}}">
                            <div class="cityPageIcon atraction"></div>
                            <div class="textCityPageIcon">{{__('جاذبه ها')}}</div>
                            <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['amaken']}}</div>
                        </a>
                    </div>
                    <div class="col-xs-12 zpr">
                        <a class="col-xs-4 cpLittleMenu" href="{{url('placeList/3/' . $kind. '/' . $place->listName )}}">
                            <div class="cityPageIcon restaurant"></div>
                            <div class="textCityPageIcon">{{__('رستوران')}}</div>
                            <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['restaurant']}}</div>
                        </a>
                        <a class="col-xs-4 cpLittleMenu" href="{{url('placeList/10/' . $kind . '/' . $place->listName)}}">
                            <div class="cityPageIcon soghat"></div>
                            <div class="textCityPageIcon">{{__('سوغات')}}</div>
                            <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['sogatSanaie']}}</div>
                        </a>
                        <a class="col-xs-4 cpLittleMenu" href="{{url('placeList/11/' . $kind . '/' . $place->listName)}}">
{{--                            <div class="cityPageIcon foodIcon"></div>--}}
                            <div class="cityPageIcon fas fa-utensils"></div>
                            <div class="textCityPageIcon">{{__('غذای محلی')}}</div>
                            <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['mahaliFood']}}</div>
                        </a>
                    </div>
                    <div class="col-xs-12 zpr">
                        <a class="col-xs-4 cpLittleMenu" href="{{url('placeList/6/' . $kind . '/' . $place->listName)}}">
                            <div class="cityPageIcon majara"></div>
                            <div class="textCityPageIcon">{{__('طبیعت گردی')}}</div>
                            <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['majara']}}</div>
                        </a>
                        <a class="col-xs-4 cpLittleMenu" href="{{url('placeList/10/' . $kind . '/' . $place->listName)}}">
                            <div class="cityPageIcon sanaye"></div>
                            <div class="textCityPageIcon">{{__('صنایع‌دستی')}}</div>
                            <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['sogatSanaie']}}</div>
                        </a>
                        <a class="col-xs-4 cpLittleMenu" href="{{route('place.list', ['kindPlaceId' => 13, 'mode' => $kind, 'city' => $place->listName])}}">
                            <div class="cityPageIcon fullWalletIcon"></div>
                            <div class="textCityPageIcon">{{__('فروشگاه')}}</div>
                            {{--<img class="cpLittleMenuImg" src="{{URL::asset('images/icons/tag.png')}}" alt="{{__('فروشگاه')}}">--}}
                            <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['localShops']}}</div>
                        </a>
                    </div>
                    <div class="col-xs-12 zpr">
                        <a class="col-xs-4 cpLittleMenu" href="{{url('placeList/12/' . $kind . '/' . $place->listName)}}">
                            <div class="cityPageIcon boom"></div>
                            <div class="textCityPageIcon">{{__('بوم گردی')}}</div>
                            <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['boomgardy']}}</div>
                        </a>
                        <div class="col-xs-4 cpLittleMenu">
                            <div class="cityPageIcon estelah"></div>
                            <div class="textCityPageIcon">{{__('اصطلاحات محلی')}}</div>
                        </div>
                        <a href="{{route('safarnameh.list', ['type' => $kind, 'search' => $place->listName])}}" class="col-xs-4 cpLittleMenu">
                            <div class="cityPageIcon safarnameIcon"></div>
                            <div class="textCityPageIcon">{{__('سفر نامه')}}</div>
                            <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['safarnameh']}}</div>
                        </a>
                    </div>
                    <div class="col-xs-12 zpr">
                        <a class="col-xs-4 cpLittleMenu" href="#">
                            <div class="cityPageIcon manSportIcon"></div>
                            <div class="textCityPageIcon">{{__('ورزشی')}}</div>
                            {{--<img class="cpLittleMenuImg" src="{{URL::asset('images/icons/gym.png')}}" alt="{{__('ورزشی')}}">--}}
                            {{--<div class="textCityPageIcon" style="color: var(--koochita-blue)">1000</div>--}}
                        </a>
                        <div class="col-xs-4 cpLittleMenu">
                            <div class="cityPageIcon lebas"></div>
                            <div class="textCityPageIcon">{{__('لباس محلی')}}</div>
                        </div>
                        <a class="col-xs-4 cpLittleMenu" href="#">
{{--                            <img class="cpLittleMenuImg" src="{{URL::asset('images/icons/hospital(1).png')}}" alt="{{__('پزشکی')}}">--}}
                            <div class="cityPageIcon fas fa-syringe"></div>
                            <div class="textCityPageIcon">{{__('پزشکی')}}</div>
                            {{--<div class="textCityPageIcon" style="color: var(--koochita-blue)">1000</div>--}}
                        </a>
                    </div>
                    <div class="col-xs-12 zpr showOnTablet">
                        <a class="col-xs-4 cpLittleMenu" href="#">
{{--                            <img class="cpLittleMenuImg" src="{{URL::asset('images/icons/cinema.png')}}" alt="{{__('سینما')}}">--}}
                            <div class="cityPageIcon fas fa-video"></div>
                            <div class="textCityPageIcon">{{__('سینما')}}</div>
                            {{--<div class="textCityPageIcon" style="color: var(--koochita-blue)">1000</div>--}}
                        </a>
                        <a class="col-xs-4 cpLittleMenu" href="#">
{{--                            <img class="cpLittleMenuImg" src="{{URL::asset('images/icons/bakery.png')}}" alt="{{__('قنادی')}}">--}}
                            <div class="cityPageIcon fas fa-birthday-cake"></div>
                            <div class="textCityPageIcon">{{__('قنادی')}}</div>
                            {{--<div class="textCityPageIcon" style="color: var(--koochita-blue)">1000</div>--}}
                        </a>
                        <a class="col-xs-4 cpLittleMenu" href="#">
{{--                            <img class="cpLittleMenuImg" src="{{URL::asset('images/icons/mortarboard(1).png')}}" alt="{{__('آموزش')}}">--}}
                            <div class="cityPageIcon fas fa-user-graduate"></div>
                            <div class="textCityPageIcon">{{__('آموزش')}}</div>
                            {{--<div class="textCityPageIcon" style="color: var(--koochita-blue)">1000</div>--}}
                        </a>
                    </div>
                    <div class="col-xs-12 zpr showOnTablet">
                        <a class="col-xs-4 cpLittleMenu" href="#">
{{--                            <img class="cpLittleMenuImg" src="{{URL::asset('images/icons/culture.png')}}" alt="{{__('فرهنگ')}}">--}}
                            <div class="cityPageIcon fas fa-theater-masks"></div>
                            <div class="textCityPageIcon">{{__('فرهنگ')}}</div>
                            {{--<div class="textCityPageIcon" style="color: var(--koochita-blue)">1000</div>--}}
                        </a>
                        <a class="col-xs-4 cpLittleMenu" href="#">
                            <img class="cpLittleMenuImg" src="{{URL::asset('images/icons/barbershop.png')}}" alt="{{__('آرایشگاه')}}">
                            <div class="textCityPageIcon">{{__('آرایشگاه')}}</div>
                            {{--<div class="textCityPageIcon" style="color: var(--koochita-blue)">1000</div>--}}
                        </a>
                        <a class="col-xs-4 cpLittleMenu" href="#">
{{--                            <img class="cpLittleMenuImg" src="{{URL::asset('images/icons/fuel.png')}}" alt="{{__('سوخت')}}">--}}
                            <div class="cityPageIcon fas fa-gas-pump"></div>
                            <div class="textCityPageIcon">{{__('سوخت')}}</div>
                            {{--<div class="textCityPageIcon" style="color: var(--koochita-blue)">1000</div>--}}
                        </a>
                    </div>
                </div>

                <div class="hideOnScreen cpListsInPhone">
                    <a class="cpLittleMenu" href="{{url('placeList/4/' . $kind . '/' . $place->listName)}}">
                        <div class="cityPageIcon hotel"></div>
                        <div class="textCityPageIcon">{{__('هتل')}}</div>
                        <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['hotel']}}</div>
                    </a>

                    <a class="cpLittleMenu" href="{{url('placeList/12/' . $kind . '/' . $place->listName)}}">
                        <div class="cityPageIcon boom"></div>
                        <div class="textCityPageIcon">{{__('بوم گردی')}}</div>
                        <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['boomgardy']}}</div>
                    </a>
                    <a class="cpLittleMenu" href="{{url('placeList/1/' . $kind . '/' . $place->listName)}}">
                        <div class="cityPageIcon atraction"></div>
                        <div class="textCityPageIcon">{{__('جاذبه ها')}}</div>
                        <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['amaken']}}</div>
                    </a>
                    <a class="cpLittleMenu" href="{{url('placeList/3/' . $kind. '/' . $place->listName )}}">
                        <div class="cityPageIcon restaurant"></div>
                        <div class="textCityPageIcon">{{__('رستوران')}}</div>
                        <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['restaurant']}}</div>
                    </a>
                    <a class="cpLittleMenu" href="{{url('placeList/10/' . $kind . '/' . $place->listName)}}">
                        <div class="cityPageIcon soghat"></div>
                        <div class="textCityPageIcon">{{__('سوغات')}}</div>
                        <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['sogatSanaie']}}</div>
                    </a>
                    <a class="cpLittleMenu" href="{{url('placeList/11/' . $kind . '/' . $place->listName)}}">
{{--                        <div class="cityPageIcon foodIcon"></div>--}}
{{--                        <div class="cityPageIcon fas fa-utensils"></div>--}}
                        <img class="cpLittleMenuImg" src="{{URL::asset('images/icons/pan.svg')}}" alt="{{__('غذای محلی')}}" style="width: 44px; margin-bottom: 2px;">
                        <div class="textCityPageIcon">{{__('غذای محلی')}}</div>
                        <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['mahaliFood']}}</div>
                    </a>
                    <a class="cpLittleMenu" href="{{url('placeList/6/' . $kind . '/' . $place->listName)}}">
                        <div class="cityPageIcon majara"></div>
                        <div class="textCityPageIcon">{{__('طبیعت گردی')}}</div>
                        <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['majara']}}</div>
                    </a>
                    <a class="cpLittleMenu" href="{{url('placeList/10/' . $kind . '/' . $place->listName)}}">
                        <div class="cityPageIcon sanaye"></div>
                        <div class="textCityPageIcon">{{__('صنایع‌دستی')}}</div>
                        <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['sogatSanaie']}}</div>
                    </a>
                    <a class="cpLittleMenu" href="{{route('place.list', ['kindPlaceId' => 13, 'mode' => $kind, 'city' => $place->listName])}}">
                        <div class="cityPageIcon fullWalletIcon"></div>
                        <div class="textCityPageIcon">{{__('فروشگاه')}}</div>
                        <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['localShops']}}</div>
                        {{--                        <img class="cpLittleMenuImg" src="{{URL::asset('images/icons/tag.png')}}" alt="{{__('فروشگاه')}}">--}}
                    </a>
                    <a href="{{route('safarnameh.list', ['type' => $kind, 'search' => $place->listName])}}" class="cpLittleMenu">
{{--                        <div class="cityPageIcon safarnameIcon"></div>--}}
                        <img class="cpLittleMenuImg" src="{{URL::asset('images/icons/magazine.svg')}}" alt="{{__('سفر نامه')}}" style="width: 34px; margin-bottom: 9px; margin-top: 10px;">
                        <div class="textCityPageIcon">{{__('سفر نامه')}}</div>
                        <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['safarnameh']}}</div>
                    </a>
                    <a class="cpLittleMenu" href="#">
                        <div class="cityPageIcon ticket"></div>
                        <div class="textCityPageIcon">{{__('بلیط')}}</div>
                    </a>
                    <div class="cpLittleMenu">
                        <div class="cityPageIcon lebas"></div>
                        <div class="textCityPageIcon">{{__('لباس محلی')}}</div>
                    </div>
                    <a class="cpLittleMenu" href="#">
                        {{--                        <img class="cpLittleMenuImg" src="{{URL::asset('images/icons/gym.png')}}" alt="{{__('ورزشی')}}">--}}
                        <div class="cityPageIcon manSportIcon"></div>
                        <div class="textCityPageIcon">{{__('ورزشی')}}</div>
                        {{--<div class="textCityPageIcon" style="color: var(--koochita-blue)">1000</div>--}}
                    </a>
                    <a class="cpLittleMenu" href="#">
{{--                        <img class="cpLittleMenuImg" src="{{URL::asset('images/icons/hospital(1).png')}}" alt="{{__('پزشکی')}}">--}}
                        <div class="cityPageIcon fas fa-syringe"></div>
                        <div class="textCityPageIcon">{{__('پزشکی')}}</div>
                        {{--<div class="textCityPageIcon" style="color: var(--koochita-blue)">1000</div>--}}
                    </a>
                    <a class="cpLittleMenu" href="#">
{{--                        <img class="cpLittleMenuImg" src="{{URL::asset('images/icons/cinema.png')}}" alt="{{__('سینما')}}">--}}
                        <div class="cityPageIcon fas fa-video"></div>
                        <div class="textCityPageIcon">{{__('سینما')}}</div>
                        {{--<div class="textCityPageIcon" style="color: var(--koochita-blue)">1000</div>--}}
                    </a>
                    <a class="cpLittleMenu" href="#">
{{--                        <img class="cpLittleMenuImg" src="{{URL::asset('images/icons/bakery.png')}}" alt="{{__('قنادی')}}">--}}
                        <div class="cityPageIcon fas fa-birthday-cake"></div>
                        <div class="textCityPageIcon">{{__('قنادی')}}</div>
                        {{--<div class="textCityPageIcon" style="color: var(--koochita-blue)">1000</div>--}}
                    </a>
                    <a class="cpLittleMenu" href="#">
{{--                        <img class="cpLittleMenuImg" src="{{URL::asset('images/icons/mortarboard(1).png')}}" alt="{{__('آموزش')}}">--}}
                        <div class="cityPageIcon fas fa-user-graduate"></div>
                        <div class="textCityPageIcon">{{__('آموزش')}}</div>
                        {{--<div class="textCityPageIcon" style="color: var(--koochita-blue)">1000</div>--}}
                    </a>
                    <a class="cpLittleMenu" href="#">
                        <div class="cityPageIcon fas fa-theater-masks"></div>
                        <div class="textCityPageIcon">{{__('فرهنگ')}}</div>
{{--                        <img class="cpLittleMenuImg" src="{{URL::asset('images/icons/culture.png')}}" alt="{{__('فرهنگ')}}">--}}
                        {{--<div class="textCityPageIcon" style="color: var(--koochita-blue)">1000</div>--}}
                    </a>
                    <a class="cpLittleMenu" href="#">
                        <img class="cpLittleMenuImg" src="{{URL::asset('images/icons/hairCut.svg')}}" alt="{{__('آرایشگاه')}}" style="width: 44px; margin-bottom: 2px;">
                        <div class="textCityPageIcon">{{__('آرایشگاه')}}</div>
                        {{--<div class="textCityPageIcon" style="color: var(--koochita-blue)">1000</div>--}}
                    </a>
                    <a class="cpLittleMenu" href="#">
{{--                        <img class="cpLittleMenuImg" src="{{URL::asset('images/icons/fuel.png')}}" alt="{{__('سوخت')}}">--}}
                        <div class="cityPageIcon fas fa-gas-pump"></div>
                        <div class="textCityPageIcon">{{__('سوخت')}}</div>
                        {{--<div class="textCityPageIcon" style="color: var(--koochita-blue)">1000</div>--}}
                    </a>
                </div>
            </div>

            <div class="row cpMainBody">
                @if(strlen($place->description) > 10)
                    <div class="cpDescription cpBorderBottom" style="white-space: pre-line;">
                        <h1 style="margin: 0; line-height: 10px; text-align: center;">
                            معرفی و تاریخچه  {{$place->name}}
                        </h1>
                        {{$place->description}}
                    </div>
                @endif

                <div style="direction: ltr;">
                    @include('component.rowSuggestion')
                </div>
            </div>

            <div class="col-xs-12 articleDiv">
                <div class="row topPlacesDivInCity" style="background: white">
                    <article class="im-article content-2col col-md-6 col-sm-12">
                        <div class="im-entry-thumb">
                            <a class="im-entry-thumb-link" href="{{$safarnameh[0]->url}}" title="{{$safarnameh[0]->slug}}" style="height: 275px;">
                                <img class="lazy-img resizeImgClass" src="{{$safarnameh[0]->pic}}" alt="{{$safarnameh[0]->keyword}}" style="opacity: 1;" onload="fitThisImg(this)">
                            </a>
                            <header class="im-entry-header">
                                <div class="im-entry-category">
                                    <div class="iranomag-meta clearfix">
                                        <div class="cat-links im-meta-item">
                                            <a style="background-color: #666; color: #fff !important;" href="{{$safarnameh[0]->catURL}}"title="{{$safarnameh[0]->category}}">{{$safarnameh[0]->category}}</a>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="im-entry-title">
                                    <a href="{{$safarnameh[0]->url}}" style="font-size: 20px">{{$safarnameh[0]->title}}</a>
                                </h3>
                            </header>
                        </div>
                        <div class="im-entry mainArticleDiv">
                            <div class="iranomag-meta clearfix">
                                <div class="posted-on im-meta-item">
                                    <span class="entry-date published updated withColor">{{$safarnameh[0]->date}}</span>
                                </div>

                                <div class="comments-link im-meta-item withColor">
                                    <i class="fa fa-comment-o"></i>{{$safarnameh[0]->msgs}}
                                </div>

                                <div class="author vcard im-meta-item withColor">
                                    <i class="fa fa-user"></i>{{$safarnameh[0]->username}}
                                </div>

{{--                                <div class="post-views im-meta-item withColor">--}}
{{--                                    <i class="fa fa-eye"></i>{{$safarnameh[0]->seen}}--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </article>
                    <div class="col-md-6 col-sm-12">
                        <div class="widget">
                            <ul>
                                @for($i = 1; $i <= 4 && $i < count($safarnameh); $i++)
                                    <li class="widget-10104im-widgetclearfix">
                                        <figure class="im-widget-thumb">
                                            <a href="{{$safarnameh[$i]->url}}" title="{{$safarnameh[$i]->title}}" style="height: 100%;">
                                                <img src="{{$safarnameh[$i]->pic}}" alt="{{$safarnameh[$i]->keyword}}" class="resizeImgClass" style="width: 100%" onload="fitThisImg(this)">
                                            </a>
                                        </figure>
                                        <div class="im-widget-entry">
                                            <header class="im-widget-entry-header">
                                                <a class="im-widget-entry-title lessShowText" href="{{$safarnameh[$i]->url}}" title="{{$safarnameh[$i]->title}}">
                                                    {{$safarnameh[$i]->title}}
                                                </a>
                                            </header>
                                            <div class="iranomag-meta clearfix marg5">
                                                <div class="posted-on im-meta-item">
                                                    <span class="entry-date published updated">{{$safarnameh[$i]->date}}</span>
                                                </div>
                                                <div class="comments-link im-meta-item">
                                                    <i class="fa fa-comment-o"></i>{{$safarnameh[$i]->msgs}}
                                                </div>
                                                <div class="author vcard im-meta-item">
                                                    <i class="fa fa-user"></i>{{$safarnameh[$i]->username}}
                                                </div>
{{--                                                <div class="post-views im-meta-item">--}}
{{--                                                    <i class="fa fa-eye"></i>{{$safarnameh[$i]->seen}}--}}
{{--                                                </div>--}}
                                            </div>
                                        </div>
                                    </li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 topPlacesDivInCity cpBorderBottom cpMapSec">
                <div id="cpMap" class="cpMap placeHolderAnime" style="height: 500px"></div>
            </div>

        </div>
    </div>
</div>

@include('layouts.footer.layoutFooter')

@include('component.mapMenu')

<script>

    setSmallReviewPlaceHolder('reviewPlaceHolderSection'); // in component.smallShowReview.blade.php
    setSmallReviewPlaceHolder('reviewPlaceHolderSection'); // in component.smallShowReview.blade.php

    @if(isset($place->pic) && count($place->pic) > 0)
        var cityPic = {!! json_encode($place->pic) !!};

        function showSliderPic(){
            var cityPicForAlbum = [];
            cityPic.map((pic, index) => {
                cityPicForAlbum[index] = {
                    'id' : pic['id'],
                    'alt' : pic['alt'],
                    'sidePic' : pic['smallPic'],
                    'mainPic' : pic['mainPic'],
                    'userPic' : '{{getUserPic(0)}}',
                    'userName' : 'کوچیتا',
                    'where' : pic['name'],
                    'whereUrl' : pic['url'],
                    'uploadTime' : '',
                    'showInfo' : false,
                }
            });

            createPhotoModal('عکس های شهر '+ cityName1, cityPicForAlbum); // in general.photoAlbumModal.blade.php
        };

        var picSwiper = new Swiper('.cityPagePics', {
            slidesPerGroup: 1,
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            loopFillGroupWithBlank: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });

        var changeSliderNum = 0;
        picSwiper.on('slideChange', function () {

            if(showCityPicNumber < cityPic.length) {
                if (changeSliderNum == 3) {
                    let nuum = 0;
                    while (nuum < 5 && showCityPicNumber < cityPic.length) {
                        slide = `<div class="swiper-slide position-relative cityImgSlider" onclick="showSliderPic()">
                                    <img src="${cityPic[showCityPicNumber]['mainPic']}" class="resizeImgClass" style="width: 100%;" alt="${cityPic[showCityPicNumber]['alt']}" onload="fitThisImg(this)">
                                </div>`;
                        picSwiper.addSlide(showCityPicNumber + 1, slide);
                        nuum++;
                        showCityPicNumber++;
                    }
                    resizeFitImg('resizeImgClass');

                    changeSliderNum = 0;
                } else
                    changeSliderNum++;
            }

        });

    @endif

    var reviews;
    var showCityPicNumber = 5;
    var cityName1 = '{{ $place->name }}';
    var topPlacesSections = [
            {
                name: '{{__('محبوب‌ترین بوم گردی ها')}}',
                id: 'topBoomgardyCityPage',
                url: '{{route('place.list', ['kindPlaceId' => 12, 'mode' => $kind, 'city' => $locationName['cityNameUrl']])}}'
            },
            {
                name: '{{__('محبوبترین جاذبه ها')}}',
                id: 'topAmakenCityPage',
                url: '{{route('place.list', ['kindPlaceId' => 1, 'mode' => $kind, 'city' => $locationName['cityNameUrl'] ])}}'
            },
            {
                name: '{{__('محبوب‌ترین رستوران‌ها')}}',
                id: 'topRestaurantInCity',
                url: '{{route('place.list', ['kindPlaceId' => 3, 'mode' => $kind, 'city' => $locationName['cityNameUrl']])}}'
            },
            {
                name: '{{__('محبوب‌ترین اقامتگاه ها')}}',
                id: 'topHotelCityPage',
                url: '{{route('place.list', ['kindPlaceId' => 4, 'mode' => $kind, 'city' => $locationName['cityNameUrl']])}}'
            },
            {
                name: '{{__('محبوب‌ترین طبیعت گردی ها')}}',
                id: 'topMajaraCityPage',
                url: '{{route('place.list', ['kindPlaceId' => 6, 'mode' => $kind, 'city' => $locationName['cityNameUrl']])}}'
            },
            {
                name: '{{__('محبوب‌ترین صنابع دستی و سوغات')}}',
                id: 'topSogatCityPage',
                url: '{{route('place.list', ['kindPlaceId' => 10, 'mode' => $kind, 'city' => $locationName['cityNameUrl']])}}'
            },
            {
                name: '{{__('محبوب‌ترین غذاهای محلی')}}',
                id: 'topFoodCityPage',
                url: '{{route('place.list', ['kindPlaceId' => 11, 'mode' => $kind, 'city' => $locationName['cityNameUrl']])}}'
            },
        ];

    initPlaceRowSection(topPlacesSections);

    function runMainSwiper(){
        new Swiper('.mainSuggestion', {
            loop: true,
            updateOnWindowResize: true,
            navigation: {
                prevEl: '.swiper-button-next',
                nextEl: '.swiper-button-prev',
            },
            on: {
                init: function(){
                    this.update();
                },
                resize: function () {
                    resizeFitImg('resizeImgClass');
                    this.update()
                },
            },
            breakpoints: {
                // 450: {
                //     slidesPerView: 1,
                //     spaceBetween: 20,
                // },
                // 550: {
                //     slidesPerView: 2,
                //     spaceBetween: 10,
                // },
                // 768: {
                //     slidesPerView: 2,
                //     spaceBetween: 20,
                // },

                768: {
                    slidesPerView: 'auto',
                    spaceBetween: 10,
                    loop: false,
                },
                991: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                10000: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                }
            }
        });
    }

    function getReviews(){
        $.ajax({
            type: 'get',
            url : '{{route("review.getCityPageReview")}}?placeId={{$place->id}}&kind={{$kind}}',
            success: response => {
                reviews = response.result;
                createReviewSections();
            }
        })
    }

    function createReviewSections(){

        reviews.forEach(item => {
            text = createSmallReviewHtml(item); // in component.smallShowReview.blade.php;
            $('#reviewSection').append(text);
        });

        $('#reviewSection').css('display', 'block');
        $('#reviewPlaceHolderSection').remove();

        resizeFitImg('resizeImgClass');
    }

    function getTopPlaces(){
        var kind = '{{$kind}}';
        var id = '{{$place->id}}';
        $.ajax({
            type: 'GET',
            url : `{{route("cityPage.topPlaces")}}?id=${id}&kind=${kind}&city={{$locationName['cityNameUrl']}}`,
            success: response => createTopPlacesDiv(response.topPlaces)
        })
    }
    function createTopPlacesDiv(_result){
        let fk = Object.keys(_result);
        for (let x of fk) {
            if(_result[x].length > 4){
                createSuggestionPack(`${x}Content`, _result[x], function() { // in suggestionPack.blade.php
                    $(`#${x}Content`).find('.suggestionPackDiv').addClass('swiper-slide');
                });
            }
            else
                $(`#${x}`).hide();
        }

        runMainSwiper();
        var height = $('#cpBorderLeft').height();
        $('#commentSection').css('height', height);
    }

    function getAllPlacesForMap(){
        $.ajax({
            type: 'post',
            url: '{{route("getCityAllPlaces")}}',
            data: {
                _token: '{{csrf_token()}}',
                kind : '{{$kind}}',
                id: '{{$place->id}}'
            },
            success: function(response){
                let map = response.map;
                let allPlaces = response.allPlaces;

                let center = {
                    x: map.C,
                    y: map.D
                };

                createMapInBlade('cpMap', center, allPlaces);
            }
        })
    }

    $(window).ready(function(){
        getReviews();
        getTopPlaces();
        getAllPlacesForMap();
    })

</script>


</body>

</html>

