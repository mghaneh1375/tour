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

    <style>
        .eddsSec{

        }
        .eddsSec.fixedL{
            position: fixed;
            bottom: 0px;
        }
        .newsVideo{

        }
    </style>
@endsection


@section('body')

    <div class="row" style="margin-top: 20px">
        <div id="pcSideAdSection" class="col-md-2 hideOnPhone">
            <div id="dsfjk" class="eddsSec">
                <div class="row sideSec">
                    <div class="title">اخبار مشابه</div>
                    <div class="otherNewsInShowSec">
                        <div id="otherNewsSlider" class="swiper-container otherNewsInShow">
                            <div class="swiper-wrapper">
                                @foreach($otherNews as $item)
                                    <div class="swiper-slide">
                                        <a href="{{$item->url}}" class="picSec">
                                            <img data-src="{{$item->pic}}" alt="{{$item->keyword}}" loading="lazy" class="lazyload resizeImgClass" onload="fitThisImg(this)">
                                        </a>
                                        <a href="{{$item->url}}" class="content">
                                            <h3 class="title">{{$item->title}}</h3>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                </div>

                <div data-kind="ver_b" class="edSections edBetween onED"></div>
                <div data-kind="ver_s" class="edSections edBetween onED"></div>
                <div data-kind="ver_s" class="edSections edBetween onED"></div>
            </div>
        </div>

        <div class="col-md-8">

            <div class="newsTitleShow hideOnScreen">
                <h1 style="font-weight: bold">{{$news->title}}</h1>
            </div>
            <div class="mainPic" style="max-width: 100%; width: 100%; max-height: 500px; overflow: hidden">
                @if($news->video == null)
                    <img src="{{$news->pic}}" alt="{{$news->keyword}}" class="resizeImgClass" onload="fitThisImg(this)">
                @else
                    <video src="{{$news->video}}" poster="{{$news->pic}}" class="newsVideo" controls style="width: 100%;"></video>
                @endif
            </div>
            <div class="title hideOnPhone">
                <h1 style="font-weight: bold">{{$news->title}}</h1>
            </div>

            <div class="body">
                <div class="descriptionText">
                    {!! $news->text !!}
                </div>
                <div id="bottomOfText"></div>
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
                            <a href="{{route('news.list', ['kind' => 'tag', 'content' => $item])}}">{{$item}}</a>
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

        <div class="col-md-2 hideOnScreen">
            <div class="row sideSec">
                <div class="title">اخبار مشابه</div>
                <div class="otherNewsInShowSec">
                    <div id="otherNewsSlider" class="swiper-container otherNewsInShow">
                        <div class="swiper-wrapper">
                            @foreach($otherNews as $item)
                                <div class="swiper-slide">
                                    <a href="{{$item->url}}" class="picSec">
                                        <img data-src="{{$item->pic}}" alt="{{$item->keyword}}" loading="lazy" class="lazyload resizeImgClass" onload="fitThisImg(this)">
                                    </a>
                                    <a href="{{$item->url}}" class="content">
                                        <h3 class="title">{{$item->title}}</h3>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>
            <div data-kind="ver_s" class="edSections edBetween onED"></div>
            <div data-kind="ver_s" class="edSections edBetween onED"></div>
        </div>
    </div>
@endsection


@section('script')

    <script>
        var swiper = new Swiper('.otherNewsInShow', {
            spaceBetween: 10,
            centeredSlides: true,
            loop: true,
            autoplay: {
                delay: 50000,
                disableOnInteraction: false,
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
            fitSideSizes()
        });

        var startFixing = false;
        var sideIsFixed = false;
        var lastScrollPosition = 0;
        var fixingId = 'dsfjk';

        function fitSideSizes(){
            var width = $(`#${fixingId}`).width();
            var leftOfAd = document.getElementById('dsfjk').getBoundingClientRect().left;

            if(!sideIsFixed) {
                $(`#${fixingId}`).css('left', leftOfAd);
                $(`#${fixingId}`).css('width', width);
            }

            startFixing = true;
        }
        $(window).on('resize', fitSideSizes);

        $(window).on('scroll', function() {

            if(!startFixing)
                 return;

            var scrollPosition = $(window).scrollTop();
            var positionOfFooter = document.getElementById('bottomOfText').getBoundingClientRect().top - $(window).height();
            var bottomOfAd = document.getElementById('dsfjk').getBoundingClientRect().top + $(`#${fixingId}`).height() - $(window).height();
            var scrollMovement = scrollPosition - lastScrollPosition > 0 ? 'down' : 'up';

            if(bottomOfAd <= 0 && !sideIsFixed){
                sideIsFixed = true;
                $(`#${fixingId}`).addClass('fixedL');
                $(`#${fixingId}`).css('bottom', 0)
            }

            if(sideIsFixed) {

                if (positionOfFooter <= 0)
                    $(`#${fixingId}`).css('bottom', Math.abs(positionOfFooter));
                else {
                    var absoluteTop = document.getElementById('dsfjk').getBoundingClientRect().top;

                    if (scrollMovement == 'up') {
                        if(absoluteTop < 10){
                            var bot = parseInt($(`#${fixingId}`).css('bottom'));
                            $(`#${fixingId}`).css('bottom', bot - Math.abs(scrollPosition - lastScrollPosition))
                        }

                        var topOfAdSection = document.getElementById('pcSideAdSection').getBoundingClientRect().top;
                        if (topOfAdSection >= 0) {
                            sideIsFixed = false;
                            $(`#${fixingId}`).removeClass('fixedL');
                        }
                    }
                    else {
                        if(bottomOfAd > 0){
                            var bot = parseInt($(`#${fixingId}`).css('bottom'));
                            $(`#${fixingId}`).css('bottom', bot + Math.abs(scrollPosition - lastScrollPosition))
                        }
                    }
                }
            }

            lastScrollPosition = scrollPosition;
        });
    </script>

@endsection
