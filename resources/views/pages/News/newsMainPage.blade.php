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
                    <a href="{{$item->url}}" class="picSec fullyCenterContent">
                        <img data-src="{{$item->pic}}" alt="{{$item->keyword}}" loading="lazy" class="lazyload resizeImgClass" onload="fitThisImg(this)">
                        <h3 class="title">{{$item->title}}</h3>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <div class="row inOneRows">
        <div class="title">اخرین ویدیوها</div>
        <div class="body">
            <div class="cardDownTitle">
                <a href="#" class="picSec fullyCenterContent playIcon">
                    <img src="https://www.irna.ir/sd/6b9bed202803f49cbcad1aec923c11bb5b14367bb822a44a2bfc591bbd772f476b34440488c6a66467a15e6bcb5dc8d3.jpg" alt="sdkj" class="resizeImgClass" onload="fitThisImg(this)">
                </a>
                <a href="#" class="content">
                    تروریسم داخلی؛ معضلی که گریبان آمریکا را گرفت
                </a>
            </div>
            <div class="cardDownTitle">
                <a href="#" class="picSec fullyCenterContent playIcon">
                    <img src="https://img9.irna.ir/d/r2/2021/01/11/2/157816837.jpg" alt="sdkj" class="resizeImgClass" onload="fitThisImg(this)">
                </a>
                <a href="#" class="content">
                    نشریه فرانسوی: پایان حیات سیاسی ترامپ نزدیک است
                </a>
            </div>
            <div class="cardDownTitle">
                <a href="#" class="picSec fullyCenterContent playIcon">
                    <img src="https://img9.irna.ir/d/r2/2021/01/24/2/157845643.jpg" alt="sdkj" class="resizeImgClass" onload="fitThisImg(this)">
                </a>
                <a href="#" class="content">
                    ارزیابی رسانه‌های غربی از گزینه احتمالی دولت بایدن در امور ایران
                </a>
            </div>
            <div class="cardDownTitle">
                <a href="#" class="picSec fullyCenterContent playIcon">
                    <img src="https://img9.irna.ir/d/r2/2021/01/24/2/157844513.jpg" alt="sdkj" class="resizeImgClass" onload="fitThisImg(this)">
                </a>
                <a href="#" class="content">
                    بایدن ۷۸ساله و آمریکایی که دیگر ابرقدرت نیست
                </a>
            </div>
        </div>
    </div>

    <?php
        $colors = ['green', 'yellow', 'lightGreen', 'red', 'blue']
    ?>

    @foreach($allCategories as $index => $category)
        @if(count($category->news) > 0)
            <div class="row oneBig4SmallRows {{$colors[($index%count($colors))]}}">
                <div class="col-md-12 title"> {{$category->name}} </div>

                <div class="col-md-4 oneBigSec" style="float: right">
                    <a href="{{$category->news[0]->url}}" class="colCard">
                        <div class="picSec fullyCenterContent">
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
                            <div class="picSec fullyCenterContent">
                                <img src="{{$category->news[$i]->pic}}" alt="{{$category->news[$i]->keyword}}" class="resizeImgClass" onload="fitThisImg(this)">
                            </div>
                            <h4 class="content">{{$category->news[$i]->title}}</h4>
                        </a>
                    @endfor
                </div>
            </div>

            @if($index%2 == 0)
                <div class="edBetween onED">
                    <a href="#" class="fullyCenterContent">
                        <img src="{{URL::asset('images/esitrevda/sistoda.jpeg')}}" alt="dfas" class="resizeImgClass" onload="fitThisImg(this)">
                    </a>
                </div>
            @else
                <div class="edBetween twoED">
                    <a href="#" class="fullyCenterContent">
                        <img src="{{URL::asset('images/esitrevda/sistoda.jpeg')}}" alt="dfas" class="resizeImgClass" onload="fitThisImg(this)">
                    </a>
                    <a href="#" class="fullyCenterContent">
                        <img src="{{URL::asset('images/esitrevda/sistoda.jpeg')}}" alt="dfas" class="resizeImgClass" onload="fitThisImg(this)">
                    </a>
                </div>
            @endif
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

    </script>

@endsection
