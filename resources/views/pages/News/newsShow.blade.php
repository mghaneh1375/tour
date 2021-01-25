@extends('pages.News.layout.newsLayout')


@section('head')

    <meta content="article" property="og:type"/>
    <meta property="og:title" content="{{$news->seoTitle}}"/>
    <meta property="title" content="{{$news->seoTitle}}"/>
    <meta name="twitter:title" content="{{$news->seoTitle}}"/>
    <meta name="twitter:card" content="{{$news->meta}}"/>
    <meta name="description" content="{{$news->meta}}"/>
    <meta name="twitter:description" content="{{$news->meta}}"/>
    <meta property="og:description" content="{{$news->meta}}"/>
    <meta property="article:section" content="{{$news->category->name}}"/>
    <meta property="article:author " content="{{$news->username}}"/>
    <meta name="keywords" content="{{$news->keyword}}">
    <meta property="og:url" content="{{Request::url()}}"/>

    <meta property="og:image" content="{{$news->pic}}"/>
    <meta property="og:image:secure_url" content="{{$news->pic}}"/>
    <meta name="twitter:image" content="{{$news->pic}}"/>
    <meta property="og:image:width" content="550"/>
    <meta property="og:image:height" content="367"/>

    @foreach($news->tags as $item)
        <meta property="article:tag" content="{{$item}}"/>
    @endforeach

    <title>{{isset($news->seoTitle) ? $news->seoTitle : $news->title}} </title>
@endsection


@section('body')

    <div class="row" style="margin-top: 20px">
        <div class="col-md-2">
            <div class="row sideSec">
                <div class="title">اخبار مشابه</div>
                <div class="otherNewsInShowSec">
                    <div id="otherNewsSlider" class="swiper-container otherNewsInShow">
                        <div class="swiper-wrapper">
                            @foreach($otherNews as $item)
                                <div class="swiper-slide">
                                    <div class="picSec">
                                        <img data-src="{{$item->pic}}" alt="{{$item->keyword}}" loading="lazy" class="lazyload resizeImgClass" onload="fitThisImg(this)">
                                    </div>
                                    <a href="{{$item->url}}" class="content">
                                        <h3 class="title">{{$item->title}}</h3>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>

            @foreach($sideAdv as $adv)
                <div class="row sideEdInShow">
                    <a href="#" class="edvPic">
                        <img src="{{$adv}}" alt="sisoo" >
                    </a>
                </div>
            @endforeach
        </div>

        <div class="col-md-8">
            <div class="mainPic">
                <img src="{{$news->pic}}" alt="{{$news->keyword}}" class="resizeImgClass" onload="fitThisImg(this)">
            </div>
            <div class="title">
                <h1>{{$news->title}}</h1>
            </div>

            <div class="body">
                <div class="descriptionText">
                    {!! $news->text !!}
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="row sideSec">
                <div> {{$news->showTime}}</div>
                <div>نویسنده: {{$news->author}}</div>
            </div>
            <div class="row sideSec">
                <div class="title">برچسب ها</div>
                <div class="tagSection">
                    @foreach($news->tags as $item)
                        <div class="tag">
                            <a href="#">{{$item}}</a>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="row sideSec">
                <div class="title">اشتراک گذاری</div>
                <div class="shareSec">
                    <div class="bu">
                        <a target="_blank" class="link mg-tp-5" href="https://www.facebook.com/sharer/sharer.php?u={{Request::url()}}">
                            <img src="{{URL::asset("images/shareBoxImg/facebook.png")}}" class="pic">
                            <div class="text"> فیسبوک</div>
                        </a>
                    </div>
                    <div class="bu">
                        <a target="_blank" class="link mg-tp-5" href="https://twitter.com/home?status={{Request::url()}}">
                            <img src="{{URL::asset("images/shareBoxImg/twitter.png")}}" class="pic">
                            <div class="text"> توییتر</div>
                        </a>
                    </div>
                    <div class="bu">
                        <a target="_blank" class="link mg-tp-5 whatsappLink" href="#">
                            <img src="{{URL::asset("images/shareBoxImg/whatsapp.png")}}" class="pic">
                            <div class="text"> واتس اپ</div>
                        </a>
                    </div>
                    <div class="bu">
                        <a target="_blank" class="link mg-tp-5" href="https://telegram.me/share/url?url={{Request::url()}}">
                            <img src="{{URL::asset("images/shareBoxImg/telegram.png")}}" class="pic">
                            <div class="text">تلگرام</div>
                        </a>
                    </div>
{{--                    <div class="bu">--}}
{{--                        <div class="position-relative inputBoxSharePage mg-tp-5">--}}
{{--                            <input id="shareLinkInput" class="full-width inputBoxInputSharePage" value="{{Request::url()}}" readonly onclick="copyLinkAddress()" style="cursor: pointer;">--}}
{{--                            <img src="{{URL::asset("images/shareBoxImg/copy.png")}}" id="copyImgInputShareLink">--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')

    <script>
        var swiper = new Swiper('#otherNewsSlider', {
            spaceBetween: 10,
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

        $(window).ready(() => {
            let encodeurlShareBox = encodeURIComponent('{{Request::url()}}');
            let textShareBox = 'whatsapp://send?text=';
            textShareBox += 'در کوچیتا ببینید:' + ' %0a ' + encodeurlShareBox;
            $('.whatsappLink').attr('href', textShareBox);
        });
    </script>

@endsection
