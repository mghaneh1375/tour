@extends('pages.News.layout.newsLayout')


@section('head')
    <title>اخبار کوچیتا</title>

    <style>

    </style>
@endsection


@section('body')

    <div class="row topSectionMainPageNews">
        <div class="col-md-7">
            <div id="mainSlider" class="swiper-container mainPageSlider">
                <div class="swiper-wrapper">
                    @foreach($sliderNews as $item)
                        <div class="swiper-slide">
                            <img data-src="{{$item->pic}}" alt="{{$item->keyword}}" loading="lazy" class="lazyload resizeImgClass" onload="fitThisImg(this)">
                            <a href="{{$item->url}}" class="content">
                                <h3 class="title">{{$item->title}}</h3>
                                <p class="summery">{{$item->meta}}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>

        <div class="col-md-5 sideCardSec">
            @foreach($sideSliderNews as $item)
                <div class="sideNewsCard">
                    <a href="{{$item->url}}" class="picSec fullyCenterContent {{$item->video != null ? 'playIcon' : ''}}">
                        <img data-src="{{$item->pic}}" alt="{{$item->keyword}}" loading="lazy" class="lazyload resizeImgClass" onload="fitThisImg(this)">
                        <h3 class="title">{{$item->title}}</h3>
                    </a>
                </div>
            @endforeach
        </div>
    </div>


    @if(count($topNews) > 1)
        <div class="row inOneRows">
            <div class="title">اخبار برگزیده</div>
            <div class="body">
                <div id="horizSlider" class="swiper-container">
                    <div class="swiper-wrapper">
                        @foreach($topNews as $item)
                            <div class="swiper-slide cardDownTitle">
                                <a href="{{$item->url}}" class="picSec fullyCenterContent {{$item->video != null ? 'playIcon' : ''}}">
                                    <img src="{{$item->pic}}" alt="{{$item->keyword}}" class="resizeImgClass" onload="fitThisImg(this)">
                                </a>
                                <a href="{{$item->url}}" class="content">{{$item->title}}</a>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>

    @endif

    @if(count($lastVideos) > 0)
        <div class="row inOneRows">
            <div class="title">آخرین ویدیوها</div>
            <div class="body">
                @foreach($lastVideos as $item)
                    <div class="cardDownTitle">
                        <a href="{{$item->url}}" class="picSec fullyCenterContent playIcon">
                            <img src="{{$item->pic}}" alt="{{$item->keyword}}" class="resizeImgClass" onload="fitThisImg(this)">
                        </a>
                        <a href="{{$item->url}}" class="content">{{$item->title}}</a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <?php
        $colors = ['green', 'yellow', 'lightGreen', 'red', 'blue'];
        $takenColor = 0;
    ?>

    @foreach($allCategories as $category)
        @if(count($category->news) > 0)
            <div data-index="{{$takenColor}}" class="row oneBig4SmallRows {{$colors[($takenColor%count($colors))]}}">
                <a href="{{route('news.list', ['kind' => 'category', 'content' => $category->name])}}" class="col-md-12 title"> {{$category->name}} </a>

                <div class="col-md-4 oneBigSec" style="float: right">
                    <a href="{{$category->news[0]->url}}" class="colCard">
                        <div class="picSec fullyCenterContent {{$category->news[0]->video != null ? 'playIcon' : ''}}">
                            <img src="{{$category->news[0]->pic}}" alt="{{$category->news[0]->keyword}}" class="resizeImgClass" onload="fitThisImg(this)">
                        </div>
                        <div class="content">
                            <h3 class="title">{{$category->news[0]->title}}</h3>
                            <p class="summery">{{$category->news[0]->meta}}</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-8 sideDown">
                    @for($i = 1; $i < 7 && $i < count($category->news); $i++)
                        <a href="{{$category->news[$i]->url}}" class="rowCard">
                            <div class="picSec fullyCenterContent {{$category->news[$i]->video != null ? 'playIcon' : ''}}">
                                <img src="{{$category->news[$i]->pic}}" alt="{{$category->news[$i]->keyword}}" class="resizeImgClass" onload="fitThisImg(this)">
                            </div>
                            <h4 class="content">{{$category->news[$i]->title}}</h4>
                        </a>
                    @endfor
                </div>
            </div>

            @if($takenColor%2 == 0)
                <div data-kind="hor_1" class="edSections edBetween onED"></div>
            @else
                <div data-kind="hor_2" class="edSections edBetween twoED"></div>
            @endif
            <?php
                $takenColor++;
            ?>
        @endif
    @endforeach

@endsection


@section('script')

    <script>
        var swiper = new Swiper('#mainSlider', {
            spaceBetween: 30,
            centeredSlides: true,
            loop: true,
            autoplay: {
                delay: 50000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-prev',
                prevEl: '.swiper-button-next',
            },
        });

        var horizontalSwiper =  new Swiper('#horizSlider', {
            slidesPerView: 'auto',
            centeredSlides: true,
            spaceBetween: 10,
            loop: true,
            autoplay: {
                delay: 50000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.swiper-button-prev',
                prevEl: '.swiper-button-next',
            },
        })


    </script>

@endsection
