<?php
    $placeTitleName = isset($place->state) ? $place->listName : $place->name;
    $stateOrCountryText = isset($locationName['stateIsCountry']) && $locationName['stateIsCountry'] === 1 ? ' کشور' : ' استان ';
?>

<!DOCTYPE html>
<html lang="fa">

<head>
    @include('layouts.topHeader')

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
                "name": "{{$stateOrCountryText}} {{$place->state}}",
                                "alternateName": "{{$stateOrCountryText}} {{$place->state}}",
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
                    <span>{{$stateOrCountryText}} {{$place->state}}</span>
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
            <div class="row" style="font-size: 25px; margin: 5px 10px; border-bottom: solid 1px #f3f3f3;">{{__('تازه ترین پست ها')}}</div>
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
                                    <img src="{{$place->pic[$i]['pic']}}" class="resizeImgClass" alt="{{ $place->pic[$i]['alt'] }}" onload="fitThisImg(this)">
                                </div>
                            @endfor
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    @else
                    <div style="width: 100%">
                        <div class="cityPagePics fullyCenterContent">
                            <img class="cityPagePics cpPic resizeImgClass" src="{{$place->image}}" onload="fitThisImg(this)">
                        </div>
                    @endif
                        <div class="hideOnScreen cpShowOnSlider">
                            @if(isset($place->state))
                                <div class="cpStateName" onclick="openMainSearch(0)">
                                    <span class="cpNameLabel">شهر :</span>
                                    <span>{{$place->name}}</span>
                                </div>
                                <div class="cpCityName" onclick="openMainSearch(0)">
                                    <span class="cpNameLabel">{{$stateOrCountryText}} :</span>
                                    <span>{{$place->state}}</span>
                                </div>
                            @else
                                <div class="cpStateName" onclick="openMainSearch(0)">
                                    <span class="cpNameLabel">{{$stateOrCountryText}} :</span>
                                    <span>{{$place->name}}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 underSlider hideOnTablet ">
                        <div class="cpLittleMenu infoLittleMenu">
                            <img src="{{URL::asset('images/icons/info.png')}}">
                        </div>
                        <a class="col-xs-2 cpLittleMenu" href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=284">
                            <i class="cityPageIcon fa-solid fa-cart-shopping"></i>
                            <div class="textCityPageIcon">{{__('فروشگاه زنجیره ای')}}</div>
                        </a>
                        <a class="col-xs-2 cpLittleMenu" href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=190">
                            <i class="cityPageIcon fa-solid fa-police-box"></i>
                            <div class="textCityPageIcon">{{__('خدمات دولتی')}}</div>
                        </a>
                        <a class="col-xs-2 cpLittleMenu" href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=1">
                            <i class="cityPageIcon fa-solid fa-taxi-bus"></i>
                            <div class="textCityPageIcon">{{__('حمل و نقل')}}</div>
                        </a>
                        <a class="col-xs-2 cpLittleMenu" href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=281">
                            <i class="cityPageIcon fa-solid fa-car-wrench"></i>
                            <div class="textCityPageIcon">{{__('تعمیرگاه')}}</div>
                        </a>
                        <a class="col-xs-2 cpLittleMenu" href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=283">
                            <i class="cityPageIcon fa-solid fa-circle-dollar"></i>
                            <div class="textCityPageIcon">{{__('صرافی')}}</div>
                        </a>
                        <a class="col-xs-2 cpLittleMenu" href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=278">
                            <div class="cityPageIcon fas fa-gas-pump"></div>
                            <div class="textCityPageIcon">{{__('سوخت')}}</div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12 pd-0Imp hideOnPhone">
                    <div class="col-xs-12 zpr">
                        <a class="col-xs-4 cpLittleMenu" href="{{url('placeList/12/' . $kind . '/' . $place->listName)}}">
                            <div class="cityPageIcon boom"></div>
                            <div class="textCityPageIcon">{{__('بوم گردی')}}</div>
                            <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['boomgardy']}}</div>
                        </a>
                        <a class="col-xs-4 cpLittleMenu" href="{{url('placeList/1/' . $kind . '/' . $place->listName)}}">
                            <div class="cityPageIcon atraction"></div>
                            <div class="textCityPageIcon">{{__('جاذبه ها')}}</div>
                            <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['amaken']}}</div>
                        </a>
                        <a class="col-xs-4 cpLittleMenu" href="{{url('placeList/11/' . $kind . '/' . $place->listName)}}">
                            <div class="cityPageIcon fas fa-utensils"></div>
                            <div class="textCityPageIcon">{{__('غذای محلی')}}</div>
                            <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['mahaliFood']}}</div>
                        </a>
                    </div>
                    <div class="col-xs-12 zpr">
                        <a class="col-xs-4 cpLittleMenu" href="{{url("placeList/4/{$kind}/{$place->listName}")}}">
                            <div class="cityPageIcon hotel"></div>
                            <div class="textCityPageIcon">{{__('هتل')}}</div>
                            <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['hotel']}}</div>
                        </a>
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
                    </div>
                    <div class="col-xs-12 zpr">
                        <a class="col-xs-4 cpLittleMenu" href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=280">
                            <div class="cityPageIcon sanaye"></div>
                            <div class="textCityPageIcon">{{__('فروشگاه صنایع دستی')}}</div>
                            <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['localShops']}}</div>
                        </a>
                        <a class="col-xs-4 cpLittleMenu" href="{{url("placeList/6/{$kind}/{$place->listName}")}}">
                            <i class="cityPageIcon fa-solid fa-campground"></i>
                            <div class="textCityPageIcon">{{__('طبیعت گردی')}}</div>
                            <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['majara']}}</div>
                        </a>
                        <a href="{{route('safarnameh.list', ['type' => $kind, 'search' => $place->listName])}}" class="col-xs-4 cpLittleMenu">
                            <div class="cityPageIcon safarnameIcon"></div>
                            <div class="textCityPageIcon">{{__('سفر نامه')}}</div>
                            <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['safarnameh']}}</div>
                        </a>
                    </div>
                    <div class="col-xs-12 zpr">
                        <a class="col-xs-4 cpLittleMenu" href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=159">
                            <i class="cityPageIcon fa-solid fa-masks-theater"></i>
                            <div class="textCityPageIcon">{{__('هنر')}}</div>
                        </a>
                        <a class="col-xs-4 cpLittleMenu" href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=279">
                            <i class="cityPageIcon fa-solid fa-bowling-ball-pin"></i>
                            <div class="textCityPageIcon">{{__('سرگرمی')}}</div>
                        </a>
                        <a class="col-xs-4 cpLittleMenu" href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=226">
                            <i class="cityPageIcon fa-solid fa-truck-medical"></i>
                            <div class="textCityPageIcon">{{__('بهداشت و درمان')}}</div>
                        </a>
                    </div>
                    <div class="col-xs-12 zpr">
                        <a class="col-xs-4 cpLittleMenu" href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=282">
                            <i class="cityPageIcon fa-solid fa-coins"></i>
                            <div class="textCityPageIcon">{{__('بانک')}}</div>
                        </a>
                        <a class="col-xs-4 cpLittleMenu" href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=285">
                            <i class="cityPageIcon fa-solid fa-toilet"></i>
                            <div class="textCityPageIcon">{{__('سرویش بهداشتی')}}</div>
                        </a>
                        <a class="col-xs-4 cpLittleMenu" href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=90">
                            <i class="cityPageIcon fa-solid fa-shuttlecock"></i>
                            <div class="textCityPageIcon">{{__('ورزش و آرامش')}}</div>
                        </a>
                    </div>


                    <div class="col-xs-12 zpr showOnTablet">
                        <a class="col-xs-4 cpLittleMenu" href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=281">
                            <i class="cityPageIcon fa-solid fa-car-wrench"></i>
                            <div class="textCityPageIcon">{{__('تعمیرگاه')}}</div>
                        </a>
                        <a class="col-xs-4 cpLittleMenu" href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=283">
                            <i class="cityPageIcon fa-solid fa-circle-dollar"></i>
                            <div class="textCityPageIcon">{{__('صرافی')}}</div>
                        </a>
                        <a class="col-xs-4 cpLittleMenu"  href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=278">
                            <div class="cityPageIcon fas fa-gas-pump"></div>
                            <div class="textCityPageIcon">{{__('سوخت')}}</div>
                        </a>
                    </div>
                    <div class="col-xs-12 zpr showOnTablet">
                        <a class="col-xs-4 cpLittleMenu" href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=284">
                            <i class="cityPageIcon fa-solid fa-cart-shopping"></i>
                            <div class="textCityPageIcon">{{__('فروشگاه زنجیره ای')}}</div>
                        </a>
                        <a class="col-xs-4 cpLittleMenu"  href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=190">
                            <i class="cityPageIcon fa-solid fa-police-box"></i>
                            <div class="textCityPageIcon">{{__('خدمات دولتی')}}</div>
                        </a>
                        <a class="col-xs-4 cpLittleMenu" href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=1">
                            <i class="cityPageIcon fa-solid fa-taxi-bus"></i>
                            <div class="textCityPageIcon">{{__('حمل و نقل')}}</div>
                        </a>
                    </div>
                </div>

                <div class="hideOnScreen cpListsInPhone">
                    <a class="cpLittleMenu" href="{{url("placeList/12/{$kind}/{$place->listName}")}}">
                        <div class="cityPageIcon boom"></div>
                        <div class="textCityPageIcon">{{__('بوم گردی')}}</div>
                        <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['boomgardy']}}</div>
                    </a>
                    <a class="cpLittleMenu" href="{{url("placeList/1/{$kind}/{$place->listName}")}}">
                        <div class="cityPageIcon atraction"></div>
                        <div class="textCityPageIcon">{{__('جاذبه ها')}}</div>
                        <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['amaken']}}</div>
                    </a>
                    <a class="cpLittleMenu" href="{{url("placeList/11/{$kind}/{$place->listName}")}}">
                        <div class="cityPageIcon fas fa-utensils"></div>
                        <div class="textCityPageIcon">{{__('غذای محلی')}}</div>
                        <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['mahaliFood']}}</div>
                    </a>
                    <a class="cpLittleMenu" href="{{url("placeList/4/{$kind}/{$place->listName}")}}">
                        <div class="cityPageIcon hotel"></div>
                        <div class="textCityPageIcon">{{__('هتل')}}</div>
                        <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['hotel']}}</div>
                    </a>
                    <a class="cpLittleMenu" href="{{url("placeList/3/{$kind}/{$place->listName}")}}">
                        <div class="cityPageIcon restaurant"></div>
                        <div class="textCityPageIcon">{{__('رستوران')}}</div>
                        <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['restaurant']}}</div>
                    </a>
                    <a class="cpLittleMenu" href="{{url("placeList/10/{$kind}/{$place->listName}")}}">
                        <div class="cityPageIcon soghat"></div>
                        <div class="textCityPageIcon">{{__('سوغات')}}</div>
                        <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['sogatSanaie']}}</div>
                    </a>
                    <a class="cpLittleMenu" href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=280">
                        <div class="cityPageIcon sanaye"></div>
                        <div class="textCityPageIcon">{{__('فروشگاه صنایع دستی')}}</div>
                        <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['localShops']}}</div>
                    </a>
                    <a class="cpLittleMenu" href="{{url("placeList/6/{$kind}/{$place->listName}")}}">
                        <i class="cityPageIcon fa-solid fa-campground"></i>
                        <div class="textCityPageIcon">{{__('طبیعت گردی')}}</div>
                        <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['majara']}}</div>
                    </a>
                    <a class="cpLittleMenu" href="{{route('safarnameh.list', ['type' => $kind, 'search' => $place->listName])}}">
                        <div class="cityPageIcon safarnameIcon"></div>
                        <div class="textCityPageIcon">{{__('سفر نامه')}}</div>
                        <div class="textCityPageIcon" style="color: var(--koochita-blue)">{{$placeCounts['safarnameh']}}</div>
                    </a>
                    <a class="cpLittleMenu" href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=159">
                        <i class="cityPageIcon fa-solid fa-masks-theater"></i>
                        <div class="textCityPageIcon">{{__('هنر')}}</div>
                    </a>
                    <a class="cpLittleMenu" href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=279">
                        <i class="cityPageIcon fa-solid fa-bowling-ball-pin"></i>
                        <div class="textCityPageIcon">{{__('سرگرمی')}}</div>
                    </a>
                    <a class="cpLittleMenu" href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=226">
                        <i class="cityPageIcon fa-solid fa-truck-medical"></i>
                        <div class="textCityPageIcon">{{__('بهداشت و درمان')}}</div>
                    </a>
                    <a class="cpLittleMenu" href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=282">
                        <i class="cityPageIcon fa-solid fa-coins"></i>
                        <div class="textCityPageIcon">{{__('بانک')}}</div>
                    </a>
                    <a class="cpLittleMenu" href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=285">
                        <i class="cityPageIcon fa-solid fa-toilet"></i>
                        <div class="textCityPageIcon">{{__('سرویش بهداشتی')}}</div>
                    </a>
                    <a class="cpLittleMenu" href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=90">
                        <i class="cityPageIcon fa-solid fa-shuttlecock"></i>
                        <div class="textCityPageIcon">{{__('ورزش و آرامش')}}</div>
                    </a>
                    <a class="cpLittleMenu" href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=281">
                        <i class="cityPageIcon fa-solid fa-car-wrench"></i>
                        <div class="textCityPageIcon">{{__('تعمیرگاه')}}</div>
                    </a>
                    <a class="cpLittleMenu" href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=283">
                        <i class="cityPageIcon fa-solid fa-circle-dollar"></i>
                        <div class="textCityPageIcon">{{__('صرافی')}}</div>
                    </a>
                    <a class="cpLittleMenu"  href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=278">
                        <div class="cityPageIcon fas fa-gas-pump"></div>
                        <div class="textCityPageIcon">{{__('سوخت')}}</div>
                    </a>
                    <a class="cpLittleMenu" href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=284">
                        <i class="cityPageIcon fa-solid fa-cart-shopping"></i>
                        <div class="textCityPageIcon">{{__('فروشگاه زنجیره ای')}}</div>
                    </a>
                    <a class="cpLittleMenu" href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=190">
                        <i class="cityPageIcon fa-solid fa-police-box"></i>
                        <div class="textCityPageIcon">{{__('خدمات دولتی')}}</div>
                    </a>
                    <a class="cpLittleMenu" href="{{url("placeList/13/{$kind}/{$place->listName}")}}?category=1">
                        <i class="cityPageIcon fa-solid fa-taxi-bus"></i>
                        <div class="textCityPageIcon">{{__('حمل و نقل')}}</div>
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
    var cityPageKind = '{{$kind}}';
    var cityPageId = '{{$place->id}}';
    var getAllPlacesOfCityForMapUrl = '{{route("getCityAllPlaces")}}';
    var getReviewsForCityPageUrl = '{{route("review.getCityPageReview")}}?placeId={{$place->id}}&kind={{$kind}}';

    var reviews;
    var showCityPicNumber = 5;

    function runMainSwiper(){
        new Swiper('.mainSuggestion', {
            loop: true,
            // updateOnWindowResize: true,
            navigation: {
                prevEl: '.swiper-button-next',
                nextEl: '.swiper-button-prev',
            },
            breakpoints: {
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
            url : getReviewsForCityPageUrl,
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
        var kind = cityPageKind;
        var id = cityPageId;
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
                createSuggestionPack(`${x}Content`, _result[x], () => { // in suggestionPack.blade.php
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
            type: 'POST',
            url: getAllPlacesOfCityForMapUrl,
            data: {
                _token: csrfTokenGlobal,
                kind : cityPageKind,
                id: cityPageId
            },
            success: response => {
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

    $(window).ready(() => {
        setSmallReviewPlaceHolder('reviewPlaceHolderSection'); // in component.smallShowReview.blade.php
        setSmallReviewPlaceHolder('reviewPlaceHolderSection'); // in component.smallShowReview.blade.php

        initPlaceRowSection(topPlacesSections);

        getTopPlaces();

        if(cityPageKind === "city")
            getAllPlacesForMap();
        else
            $('#cpMap').addClass('hidden');

        if(window.innerWidth > 767 )
            getReviews();
    });

    @if(isset($place->pic) && count($place->pic) > 0)
        var cityPic = {!! json_encode($place->pic) !!};

        function showSliderPic(){
            var cityPicForAlbum = [];
            cityPic.map((pic, index) => {
                cityPicForAlbum[index] = {
                    'id' : pic['id'],
                    'alt' : pic['alt'],
                    'sidePic' : pic['pic'],
                    'mainPic' : pic['pic'],
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

        var changeSliderNum = 0;
        var picSwiper = new Swiper('.cityPagePics', {
            slidesPerGroup: 1,
            loop: true,
            autoplay: {
                delay: 10000,
                disableOnInteraction: false,
            },
            loopFillGroupWithBlank: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
        // .on('slideChange', function () {
        // if(showCityPicNumber < cityPic.length) {
        //     if (changeSliderNum == 5) {
        //         let nuum = 0;
        //         while (nuum < 10 && showCityPicNumber < cityPic.length) {
        //             slide = `<div class="swiper-slide position-relative cityImgSlider" onclick="showSliderPic()">
        //                         <img src="${cityPic[showCityPicNumber]['mainPic']}" class="resizeImgClass" style="width: 100%;" alt="${cityPic[showCityPicNumber]['alt']}" onload="fitThisImg(this)">
        //                     </div>`;
        //             picSwiper.addSlide(showCityPicNumber + 1, slide);
        //             showCityPicNumber++;
        //             nuum++;
        //         }
        //         resizeFitImg('resizeImgClass');
        //
        //         changeSliderNum = 0;
        //     } else
        //         changeSliderNum++;
        // }
        //
        // });

    @endif


</script>

</body>

</html>

