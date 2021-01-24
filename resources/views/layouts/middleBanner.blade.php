<link rel='stylesheet' type='text/css' href='{{URL::asset('css/common/middleBanner.css?v='.$fileVersions)}}'/>

<div class="container fullWidthMainPageInMobile">
    <div class="ppr_rup ppr_priv_homepage_shelves">
        <div class="mainSuggestionMainDiv">
            <div class="hideOnScreen row">
                <div class="boxOFSquareDiv">
                    <div class="squareDiv" onclick="openMainSearch(11)">
                        <div class="phoneIcon ghazamahali"></div>
                        <div class="textIcon">{{__('غذای محلی')}}</div>
                    </div>
                    <div class="squareDiv" onclick="openMainSearch(3)">
                        <div class="phoneIcon restaurantIcon"></div>
                        <div class="textIcon">{{__('رستوران')}}</div>
                    </div>
                    <div class="squareDiv" onclick="openMainSearch(1)">
                        <div class="phoneIcon atraction"></div>
                        <div class="textIcon">{{__('جاذبه')}}</div>
                    </div>
                    <div class="squareDiv" onclick="openMainSearch(4)">
                        <div class="phoneIcon hotel"></div>
                        <div class="textIcon">{{__('اقامتگاه')}}</div>
                    </div>
                    <div class="squareDiv" onclick="openMainSearch(12)">
                        <div class="phoneIcon boomIcon"></div>
                        <div class="textIcon">{{__('بوم گردی')}}</div>
                    </div>


                    <div class="squareDiv" onclick="openMainSearch(6)" style="width: 39%">
                        <div class="phoneIcon adventureIcon"></div>
                        <div class="textIcon">{{__('طبیعت گردی')}}</div>
                    </div>
                    <div class="squareDiv" onclick="location.href = '{{route('safarnameh.index')}}'">
                        <div class="phoneIcon safarnameIcon"></div>
                        <div class="textIcon">{{__('سفرنامه')}}</div>
                    </div>
                    <div class="squareDiv" onclick="openMainSearch(10)" style="width: 39%">
                        <div class="phoneIcon restaurant"></div>
                        <div class="textIcon">{{__('سوغات و صنایع‌دستی')}}</div>
                    </div>
                </div>
            </div>

            <div class="threeSlider swiper-container marginBetweenMainPageMobileElements hideOnScreen hidden">
                <div class="cityMainPageSlider swiper-wrapper position-relative"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>

            <div class="topDAMainPage marginBetweenMainPageMobileElements">
                <a href="https://www.tourismbank.ir/" class="dddda" style="margin-top: 5px; width: 100%">
                    <img src="{{URL::asset('images/esitrevda/gardeshgary.jpg')}}">
                </a>
            </div>

            {{--banner_1--}}
            @if(isset($middleBan['1']) && count($middleBan['1']) > 0)
                <style>
                    .slide__text--1 {
                        left: 5%;
                    }
                    @for($i = 1; $i <= count($middleBan['1']); $i++)
                    .slide {
                        left: 100%;
                    }
                    .slide--{{$i}} {
                        z-index: {{$i}};
                    }
                    .slide--{{$i}} .slide__img-wrapper {
                        background: url({{$middleBan['1'][$i-1]['pic']}}) center center no-repeat;
                        background-size: 100% auto;
                    }
                    .active .slide--{{$i}} {
                        -webkit-transform: translate3d(-{{100 - ((100/count($middleBan['1'])) * ($i-1) )}}%, 0, 0);
                        transform: translate3d(-{{100 - ((100/count($middleBan['1'])) * ($i-1) )}}%, 0, 0);
                        -webkit-transition: -webkit-transform 950ms {{1235 * ($i-1)}}ms;
                        transition: -webkit-transform 950ms {{1235 * ($i-1)}}ms;
                        transition: transform 950ms {{1235 * ($i-1)}}ms;
                        transition: transform 950ms {{1235 * ($i-1)}}ms, -webkit-transform 950ms {{1235 * ($i-1)}}ms;
                    }
                    .active .slide--{{$i}} .slide__bg {
                        -webkit-transform: scale(0, 1);
                        transform: scale(0, 1);
                        -webkit-transition: 1900ms {{1235 * ($i-1)}}ms;
                        transition: 1900ms {{1235 * ($i-1)}}ms;
                    }
                    .active .slide-{{$i}} .slide__img-wrapper {
                        -webkit-transform: translate3d(-150px, 0, 0);
                        transform: translate3d(-150px, 0, 0);
                        -webkit-transition: 2000ms {{1235 * ($i-1)}}ms;
                        transition: 2000ms {{1235 * ($i-1)}}ms;
                    }
                    @endfor

                .slide__text:hover{
                        color: #fbe5c8 !important;
                    }
                </style>
                <div class="cont hideOnPhone">
                    @for($i = 1; $i <= count($middleBan['1']); $i++)
                        <div data-target='{{$i}}' class="slide slide--{{$i}}">
                            @if($middleBan['1'][$i-1]['link'] != '')
                                <a href="{{$middleBan['1'][$i-1]['link']}}" class="slide__text slide__text--{{$i}}" target="_blank">
                                    {{$middleBan['1'][$i-1]['text']}}
                                </a>
                            @else
                                <div class="slide__text slide__text--{{$i}}">
                                    {{$middleBan['1'][$i-1]['text']}}
                                </div>
                            @endif

                            <div class="slide__bg"></div>
                            <div class="slide__img">
                                <div class="slide__close"></div>
                                <div class="slide__img-wrapper"></div>
                            </div>
                            <div class="slide__bg-dark"></div>
                        </div>
                    @endfor
                </div>
                <script>
                    const $cont = $('.cont');
                    const $slide = $('.slide');
                    const $closeBtn = $('.slide__close')
                    const $text = $('.slide__text');
                    const $iconTwitter = $('.icon-link--twitter');
                    const numSlides = {{count($middleBan['1'])}};
                    const initialAnimDur = 7131;
                    const animDelay = 1000;
                    let initialAnim = true;
                    let clickAnim = false;

                    $(document).on('click', '.slide__bg-dark', function() {
                        if (initialAnim || clickAnim) return;
                        let _this = $(this).parent();
                        let target = +_this.attr('data-target');
                        clickAnim = true;

                        _this.css({
                            'transform': 'translate3d(-100%, 0, 0)',
                            'transition': '750ms',
                            'cursor': 'default'
                        })

                        _this.find('.slide__img-wrapper').css({
                            'transform': 'translate3d(0, 0, 0) scale(.95, .95)',
                            'transition': '2000ms'
                        })

                        for(let i = target, length = $slide.length; i < length; i++) {
                            $('.slide--' + (i + 1)).css({
                                'transform': 'translate3d(0, 0, 0)',
                                'transition': '750ms'
                            })
                        }

                        for(let i = target, length = $slide.length; i > 1; i--) {
                            $('.slide--' + (i - 1)).css({
                                'transform': 'translate3d(-150%, 0, 0)',
                                'transition': '750ms'
                            })
                        }

                        setTimeout(function() {
                            $slide.not(_this).find('.slide__bg-dark').css({
                                'opacity': '0'
                            })
                        }, 750)

                        $closeBtn.addClass('show-close');
                        $iconTwitter.addClass('icon-show');

                        _this.find('.slide__text').css({
                            'transform': 'translate3d(150px, -40%, 0)',
                            'opacity': '1',
                            'transition': '2000ms',
                            '-webkit-transition': '2000ms'
                        })
                    });

                    $(document).on('mousemove', '.slide', function() {
                        if(initialAnim || clickAnim) return;
                        let _this = $(this);
                        let target = +_this.attr('data-target');

                        _this.css({
                            'transform': 'translate3d(-' + (((100 / numSlides) * (numSlides - (target - 1))) + numSlides) + '%, 0, 0)',
                            'transition': '750ms'
                        })

                        _this.find('.slide__text').css({
                            'transform': 'translate3d(0, -40%, 0) rotate(0.01deg)',
                            '-moz-transform': 'translate3d(0, -40%, 0) rotate(0.01deg)',
                            'opacity': '1',
                            'transition': '750ms',
                            '-webkit-transition': '750ms'
                        })

                        for(let i = target, length = $slide.length; i < length; i++) {
                            $('.slide--' + (i + 1)).css({
                                'transform': 'translate3d(-' + (((100 / numSlides) * (numSlides - ((i + 1) - 1))) - numSlides) + '%, 0, 0)',
                                'transition': '750ms'
                            })
                        }

                        for(let i = target; i > 1; i--) {
                            $('.slide--' + (i - 1)).css({
                                'transform': 'translate3d(-' + (((100 / numSlides) * (numSlides - ((i - 1) - 1))) + numSlides) + '%, 0, 0)',
                                'transition': '750ms'
                            })
                        }

                        _this.find('.slide__img-wrapper').css({
                            'transform': 'translate3d(-200px, 0, 0) scale(.85, .85)',
                            'transition': '750ms'
                        })

                        $slide.not(_this).find('.slide__img-wrapper').css({
                            'transform': 'translate3d(-200px, 0, 0) scale(.90, .90)',
                            'transition': '1000ms'
                        })

                        $slide.not(_this).find('.slide__bg-dark').css({
                            'opacity': '.75'
                        })
                    });

                    $(document).on('mouseleave', '.slide', function() {
                        if(initialAnim || clickAnim) return;
                        let _this = $(this);
                        let target = +_this.attr('data-target');

                        for(let i = 1, length = $slide.length; i <= length; i++) {

                            $('.slide--' + i).css({
                                'transform': 'translate3d(-' + (100 / numSlides) * (numSlides - (i - 1)) + '%, 0, 0)',
                                'transition': '1000ms'
                            })
                        }

                        $slide.find('.slide__img-wrapper').css({
                            'transform': 'translate3d(-200px, 0, 0) scale(1, 1)',
                            'transition': '750ms'
                        })

                        $slide.find('.slide__bg-dark').css({
                            'opacity': '0'
                        })

                        $text.css({
                            'transform': 'translate3d(0, -50%, 0) rotate(0.01deg)',
                            'opacity': '0',
                            'transition': '200ms',
                            '-webkit-transition': '200ms'
                        })
                    });

                    $(document).on('click', '.slide__close', function() {

                        setTimeout(function() {
                            clickAnim = false;
                        }, 1000);

                        $closeBtn.removeClass('show-close');
                        $iconTwitter.removeClass('icon-show');

                        for(let i = 1, length = $slide.length; i <= length; i++) {
                            $('.slide--' + i).css({
                                'transform': 'translate3d(-' + (100 / numSlides) * (numSlides - (i - 1)) + '%, 0, 0)',
                                'transition': '1000ms',
                                'cursor': 'pointer'
                            })
                        }

                        $text.css({
                            'transform': 'translate3d(150px, -40%, 0)',
                            'opacity': '0',
                            'transition': '200ms',
                            '-webkit-transition': '200ms'
                        })

                        setTimeout(function() {
                            $text.css({
                                'transform': 'translate3d(0, -50%, 0)'
                            })
                        }, 200)
                    })

                    setTimeout(function() {
                        $cont.addClass('active');
                    }, animDelay);

                    setTimeout(function() {
                        initialAnim = false;
                    }, initialAnimDur + animDelay);

                </script>
            @endif

            <div id="loadSuggestionLine"></div>

            <div id="articleSuggestion" class="suggestRowsMainPage marginBetweenMainPageMobileElements first">
                <a class="shelf_title" href="{{route('safarnameh.index')}}" target="_blank">
                    <img class="hideOnPhone" src="{{URL::asset('images/icons/iconneg.svg')}}" alt="کوچیتا، سامانه جامع گردشگری ایران" loading="lazy" style="width: 50px;">
                    <img class="hideOnScreen" src="{{URL::asset('images/icons/iconnegBlack.svg')}}" alt="کوچیتا، سامانه جامع گردشگری ایران" loading="lazy" style="width: 50px;">
                    <div class="shelf_title_container h3">
                        <h3>{{__('جدیدترین سفرنامه‌ها')}}</h3>
                    </div>
                </a>
                <div class="shelf_item_container ui_columns is-mobile is-multiline">
                    <div class="mainSuggestion swiper-container">
                        <div class="topSafarnameh swiper-wrapper suggestionBody">
                            {{--fill with createMainPageSuggestion function--}}
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>

            <div class="topDAMainPage marginBetweenMainPageMobileElements">
                <a href="https://www.pasargadoil.com" class="dddda" style="margin-top: 5px;">
                    <img src="{{URL::asset('images/esitrevda/pasargardda.gif')}}">
                </a>
                <a href="https://www.iranol.ir" class="dddda" style="margin-top: 5px;">
                    <picture>
                        <source media="(max-width:767px)" srcset="{{URL::asset('images/esitrevda/iranolSmall.gif')}}">
                        <source media="(min-width:767px)" srcset="{{URL::asset('images/esitrevda/iranolBig.gif')}}">
                        <img src="{{URL::asset('images/esitrevda/iranolBig.gif')}}" alt="ایرانول" style="height:auto;">
                    </picture>
                </a>
            </div>

            <div class="mapBoxMainPage marginBetweenMainPageMobileElements">
                <div class="imgg">
                    <img src="{{URL::asset('images/mainPics/mapPicture.jpg')}}" class="resizeImgClass" onload="fitThisImg(this)">
                    <a href="{{route('myLocation')}}" class="clickMapBox">
                        <div>لوکیشن بده</div>
                        <div>جاهای جالب اطرافت رو ببین</div>
                    </a>
                </div>
            </div>

            <div id="newKoochita" class="suggestRowsMainPage hideOnPhone">
                <div class="shelf_title">
                    <img class="hideOnPhone" src="{{URL::asset('images/icons/iconneg.svg')}}" alt="کوچیتا، سامانه جامع گردشگری ایران" loading="lazy" style="width: 50px;">
                    <img class="hideOnScreen" src="{{URL::asset('images/icons/iconnegBlack.svg')}}" alt="کوچیتا، سامانه جامع گردشگری ایران" loading="lazy" style="width: 50px;">
                    <div class="shelf_title_container h3">
                        <h3>{{__('تازه‌های کوچیتا')}}</h3>
                    </div>
                </div>
                <div class="shelf_item_container ui_columns is-mobile is-multiline" style="width: 100%">
                    <div class="mainSuggestion swiper-container">
                        <div class="newInKoochita swiper-wrapper suggestionBody">
                            {{--fill with createMainPageSuggestion function--}}
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>


            @if(isset($middleBan['6']))
                <div class="middleBannerPhotoBanner middleBannerPB hideOnPhone">
                    @if($middleBan['6']['link'] != '')
                        <a href="{{$middleBan['6']['link']}}" target="_blank" >
                            <img data-src="{{$middleBan['6']['pic']}}" alt="کوچیتا، سامانه جامع گردشگری ایران" loading="lazy" class="lazyload" style="width: 100%;">
                        </a>
                    @else
                        <img data-src="{{$middleBan['6']['pic']}}" alt="کوچیتا، سامانه جامع گردشگری ایران" loading="lazy" class="lazyload" style="width: 100%;">
                    @endif
                </div>
            @endif

            @if(isset($articleBanner) && count($articleBanner) > 0 && false)
                <div class="siteArticlesMainDiv ">
                <div class="mainArticlaSwiperMainPage swiper-container">
                    <div class="swiper-wrapper position-relative">
                        @foreach($articleBanner as $item)
                            <div class="swiper-slide position-relative">
                                <div class="card transition">
                                    <h2 class="h2MidBanerArticle transition" onmouseenter="$(this).parent().next().removeClass('display-none')" onmouseleave="$(this).parent().next().addClass('display-none')" title="{{$item->title}}">{{$item->title}}</h2>
                                    <p class="pMidBanerArticle">
                                        {{$item->meta}}
                                    </p>
                                    <div class="cta-container transition" style="left: 0px">
                                        <a href="{{$item->url}}" class="cta">{{__('مشاهده مقاله')}}</a>
                                    </div>
                                    <div class="card_circle transition">
                                        <img data-src="{{$item->pic}}" alt="کوچیتا، سامانه جامع گردشگری ایران" loading="lazy" class="lazyload resizeImgClass" style="width: 100%;">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
            @endif

            <div id="foodSuggestion" class="suggestRowsMainPage marginBetweenMainPageMobileElements">
                <div>
                    <a class="shelf_title" href="{{route('place.list', ['kindPlaceId' => 11, 'mode' => 'country'])}}" target="_blank">
                        <img class="hideOnPhone" src="{{URL::asset('images/icons/iconneg.svg')}}" alt="کوچیتا، سامانه جامع گردشگری ایران" loading="lazy" style="width: 50px;">
                        <img class="hideOnScreen" src="{{URL::asset('images/icons/iconnegBlack.svg')}}" alt="کوچیتا، سامانه جامع گردشگری ایران" loading="lazy" style="width: 50px;">
                        <div class="shelf_title_container h3">
                            <h3>{{__('محبوب‌ترین غذا‌ها')}}</h3>
                        </div>
                    </a>
                    <div class="shelf_item_container ui_columns is-mobile is-multiline" style="width: 100%">
                        <div id="mainSuggestion" class="mainSuggestion swiper-container">
                            <div class="topFood swiper-wrapper suggestionBody">
                                {{-- fill with createMainPageSuggestion function--}}
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                </div>

                <div class="hideOnScreen">
                    <a class="shelf_title" href="{{route('place.list', ['kindPlaceId' => 1, 'mode' => 'country'])}}" target="_blank">
                        <img class="hideOnPhone" src="{{URL::asset('images/icons/iconneg.svg')}}" alt="کوچیتا، سامانه جامع گردشگری ایران" loading="lazy" style="width: 50px;">
                        <img class="hideOnScreen" src="{{URL::asset('images/icons/iconnegBlack.svg')}}" alt="کوچیتا، سامانه جامع گردشگری ایران" loading="lazy" style="width: 50px;">
                        <div class="shelf_title_container h3">
                            <h3>{{__('سفر تاریخی-فرهنگی')}}</h3>
                        </div>
                    </a>
                    <div class="shelf_item_container ui_columns is-mobile is-multiline" style="width: 100%">
                        <div class="mainSuggestion swiper-container">
                            <div class="swiper-wrapper topTarikhi suggestionBody">
                                {{--fill with createMainPageSuggestion function--}}
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div id='mediaad-Rvtf' class="importantFullyCenterContent marginBetweenMainPageMobileElements"></div>

            <div id="tabiatSuggestion" class="suggestRowsMainPage hideOnPhone">
                <a class="shelf_title" href="{{route('place.list', ['kindPlaceId' => 6, 'mode' => 'country'])}}" target="_blank">
                    <img class="hideOnPhone" src="{{URL::asset('images/icons/iconneg.svg')}}" alt="کوچیتا، سامانه جامع گردشگری ایران" loading="lazy" style="width: 50px;">
                    <img class="hideOnScreen" src="{{URL::asset('images/icons/iconnegBlack.svg')}}" alt="کوچیتا، سامانه جامع گردشگری ایران" loading="lazy" style="width: 50px;">
                    <div class="shelf_title_container h3">
                        <h3>{{__('سفر طبیعت‌گردی')}}</h3>
                    </div>
                </a>
                <div class="shelf_item_container ui_columns is-mobile is-multiline" style="width: 100%">
                    <div class="mainSuggestion swiper-container">
                        <div class="topTabiat swiper-wrapper suggestionBody">
                            {{--fill with createMainPageSuggestion function--}}
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>

            {{--banner_3--}}
            @if(isset($middleBan['4']) && count($middleBan['4']) > 0)
                <div class="circleSliderMainPage marginBetweenMainPageMobileElements">
                    <div class='parent'>
                        <a href="{{route('place.list', ['kindPlaceId' => 6, 'mode' => 'country'])}}" class="header hideOnScreen">
                            {{__('سفر طبیعت‌گردی')}}
                            <img class="hideOnScreen" src="{{URL::asset('images/icons/iconnegBlack.svg')}}" alt="کوچیتا، سامانه جامع گردشگری ایران" loading="lazy" style="width: 50px;">
                        </a>
                        <a href="{{route('place.list', ['kindPlaceId' => 6, 'mode' => 'country'])}}" class='slider' style="width: 100%;">
                            <button type="button" id='banner3_right' class='rightButton sliderButton' name="button">
                                <svg version="1.1" id="Capa_1" width='40px' height='40px ' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                     viewBox="0 0 477.175 477.175" style="enable-background:new 0 0 477.175 477.175;" xml:space="preserve">
                               <g>
                                   <path style='fill: #9d9d9d;' d="M360.731,229.075l-225.1-225.1c-5.3-5.3-13.8-5.3-19.1,0s-5.3,13.8,0,19.1l215.5,215.5l-215.5,215.5c-5.3,5.3-5.3,13.8,0,19.1c2.6,2.6,6.1,4,9.5,4c3.4,0,6.9-1.3,9.5-4l225.1-225.1C365.931,242.875,365.931,234.275,360.731,229.075z"/>
                               </g>
                            </svg>
                            </button>
                            <button type="button" id='banner3_left' class='leftButton sliderButton' name="button">
                                <svg version="1.1" id="Capa_2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                     viewBox="0 0 477.175 477.175" style="enable-background:new 0 0 477.175 477.175;" xml:space="preserve">
                               <g>
                                   <path style='fill: #9d9d9d;' d="M145.188,238.575l215.5-215.5c5.3-5.3,5.3-13.8,0-19.1s-13.8-5.3-19.1,0l-225.1,225.1c-5.3,5.3-5.3,13.8,0,19.1l225.1,225c2.6,2.6,6.1,4,9.5,4s6.9-1.3,9.5-4c5.3-5.3,5.3-13.8,0-19.1L145.188,238.575z"/>
                               </g>
                            </svg>
                            </button>

                            <svg id='svg2' class='up2 slidesvg' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <circle id='circle1' class='circle1 steap' cx="34px" cy="49%" r="20"  />
                                <circle id='circle2' class='circle2 steap' cx="34px" cy="49%" r="100"  />
                                <circle id='circle3' class='circle3 steap' cx="34px" cy="49%" r="180"  />
                                <circle id='circle4' class='circle4 steap' cx="34px" cy="49%" r="260"  />
                                <circle id='circle5' class='circle5 steap' cx="34px" cy="49%" r="340"  />
                                <circle id='circle6' class='circle6 steap' cx="34px" cy="49%" r="420"  />
                                <circle id='circle7' class='circle7 steap' cx="34px" cy="49%" r="500"  />
                                <circle id='circle8' class='circle8 steap' cx="34px" cy="49%" r="580"  />
                                <circle id='circle9' class='circle9 steap' cx="34px" cy="49%" r="660"  />
                            </svg>
                            <svg id='svg1' class='up2 slidesvg' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <circle id='circle10' class='circle10 steap' cx="648px" cy="49%" r="20"  />
                                <circle id='circle11' class='circle11 steap' cx="648px" cy="49%" r="100"  />
                                <circle id='circle12' class='circle12 steap' cx="648px" cy="49%" r="180"  />
                                <circle id='circle13' class='circle13 steap' cx="648px" cy="49%" r="260"  />
                                <circle id='circle14' class='circle14 steap' cx="648px" cy="49%" r="340"  />
                                <circle id='circle15' class='circle15 steap' cx="648px" cy="49%" r="420"  />
                                <circle id='circle16' class='circle16 steap' cx="648px" cy="49%" r="500"  />
                                <circle id='circle17' class='circle17 steap' cx="648px" cy="49%" r="580"  />
                                <circle id='circle18' class='circle18 steap' cx="648px" cy="49%" r="660"  />
                            </svg>
                            <div id="middleBan4Body"></div>
                        </a>
                    </div>
                </div>
                <script>
                    var totalPageSlide = {{isset($middleBan['4']) ? count($middleBan['4']) : 0}};
                    var Baner4isLoaded = false;
                    var curpage = 1;
                    var sliding = false;
                    var click = true;
                    var left = document.getElementById("banner3_left");
                    var right = document.getElementById("banner3_right");
                    var pagePrefixBanner4 = "slide";
                    var pageShift = 500;
                    var transitionPrefix = "circle";
                    var svg = true;

                    function leftSlide() {
                        if (click && Baner4isLoaded) {
                            if (curpage == 1) curpage = totalPageSlide+1;
                            sliding = true;
                            curpage--;
                            svg = true;
                            click = false;
                            for (k = 1; k <= totalPageSlide; k++) {
                                var a1 = document.getElementById(pagePrefixBanner4 + k);
                                a1.className += " tran";
                            }
                            setTimeout(() => move(), 200);
                            setTimeout(() => {
                                for (k = 1; k <= totalPageSlide; k++) {
                                    var a1 = document.getElementById(pagePrefixBanner4 + k);
                                    a1.classList.remove("tran");
                                }
                            }, 1400);
                        }
                    }

                    function rightSlide() {
                        if (click && Baner4isLoaded) {
                            if (curpage == totalPageSlide) curpage = 0;
                            sliding = true;
                            curpage++;
                            svg = false;
                            click = false;
                            for (k = 1; k <= totalPageSlide; k++) {
                                var a1 = document.getElementById(pagePrefixBanner4 + k);
                                a1.className += " tran";
                            }
                            setTimeout(() => move(), 200);
                            setTimeout(() => {
                                for (k = 1; k <= totalPageSlide; k++) {
                                    var a1 = document.getElementById(pagePrefixBanner4 + k);
                                    a1.classList.remove("tran");
                                }
                            }, 1400);
                        }
                    }

                    function move() {
                        if (sliding && Baner4isLoaded) {
                            sliding = false;
                            if (svg) {
                                for (j = 1; j <= 9; j++) {
                                    var c = document.getElementById(transitionPrefix + j);
                                    c.classList.remove("steap");
                                    c.setAttribute("class", transitionPrefix + j + " streak");
                                }
                            } else {
                                for (j = 10; j <= 18; j++) {
                                    var c = document.getElementById(transitionPrefix + j);
                                    c.classList.remove("steap");
                                    c.setAttribute("class", transitionPrefix + j + " streak");
                                }
                            }
                            setTimeout(() => {
                                for (i = 1; i <= totalPageSlide; i++) {
                                    if (i == curpage) {
                                        var a = document.getElementById(pagePrefixBanner4 + i);
                                        a.className += " up1";
                                    } else {
                                        var b = document.getElementById(pagePrefixBanner4 + i);
                                        b.classList.remove("up1");
                                    }
                                }
                                sliding = true;
                            }, 600);
                            setTimeout(() => {
                                click = true;
                            }, 1700);

                            setTimeout(() => {
                                if (svg) {
                                    for (j = 1; j <= 9; j++) {
                                        var c = document.getElementById(transitionPrefix + j);
                                        c.classList.remove("streak");
                                        c.setAttribute("class", transitionPrefix + j + " steap");
                                    }
                                } else {
                                    for (j = 10; j <= 18; j++) {
                                        var c = document.getElementById(transitionPrefix + j);
                                        c.classList.remove("streak");
                                        c.setAttribute("class", transitionPrefix + j + " steap");
                                    }
                                    sliding = true;
                                }
                            }, 850);
                            setTimeout(() => {
                                click = true;
                            }, 1700);
                        }
                    }
                    left.onmousedown = () => leftSlide();
                    right.onmousedown = () =>  rightSlide();
                    document.onkeydown = e => {
                        if (e.keyCode == 37)
                            leftSlide();
                        else if (e.keyCode == 39)
                            rightSlide();
                    };
                    setInterval(() => rightSlide(), 8000);
                </script>
            @endif

            <div id="restaurantSuggestion" class="suggestRowsMainPage marginBetweenMainPageMobileElements">
                <a class="shelf_title" href="{{route('place.list', ['kindPlaceId' => 3, 'mode' => 'country'])}}" target="_blank">
                    <img class="hideOnPhone" src="{{URL::asset('images/icons/iconneg.svg')}}" alt="کوچیتا، سامانه جامع گردشگری ایران" loading="lazy" style="width: 50px;">
                    <img class="hideOnScreen" src="{{URL::asset('images/icons/iconnegBlack.svg')}}" alt="کوچیتا، سامانه جامع گردشگری ایران" loading="lazy" style="width: 50px;">
                    <div class="shelf_title_container h3">
                        <h3>{{__('محبوب‌ترین رستوران‌ها')}}</h3>
                    </div>
                </a>
                <div class="shelf_item_container ui_columns is-mobile is-multiline" style="width: 100%">
                    <div class="mainSuggestion swiper-container">
                        <div class="topRestaurant swiper-wrapper suggestionBody">
                            {{--fill with createMainPageSuggestion function--}}
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>

            {{--banner_5--}}
            <div class="threeSlider swiper-container hideOnPhone hidden">
                <div id="cityMainPageSlider" class="cityMainPageSlider swiper-wrapper position-relative"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>

            <div id="tarikhiSuggestion" class="suggestRowsMainPage marginBetweenMainPageMobileElements hideOnPhone">
                <a class="shelf_title" href="{{route('place.list', ['kindPlaceId' => 1, 'mode' => 'country'])}}" target="_blank">
                    <img class="hideOnPhone" src="{{URL::asset('images/icons/iconneg.svg')}}" alt="کوچیتا، سامانه جامع گردشگری ایران" loading="lazy" style="width: 50px;">
                    <img class="hideOnScreen" src="{{URL::asset('images/icons/iconnegBlack.svg')}}" alt="کوچیتا، سامانه جامع گردشگری ایران" loading="lazy" style="width: 50px;">
                    <div class="shelf_title_container h3">
                        <h3>{{__('سفر تاریخی-فرهنگی')}}</h3>
                    </div>
                </a>
                <div class="shelf_item_container ui_columns is-mobile is-multiline" style="width: 100%">
                    <div class="mainSuggestion swiper-container">
                        <div class="swiper-wrapper topTarikhi suggestionBody">
                            {{--fill with createMainPageSuggestion function--}}
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>

            <div class="mainPageStatistics" style="display: none;">
                <div class="eachPartStatistic">
                    <div class="eachPartStatisticIcons articleStatisticIcon"></div>
                    <div class="eachPartStatisticNums">
                        <span>{{__('بیش از')}}</span>
                        <span class="safarnamehCountMiddleBanner"></span>
                    </div>
                    <div class="eachPartStatisticTitle">{{__('مقاله')}}</div>
                </div>
                <div class="eachPartStatistic">
                    <div class="eachPartStatisticIcons friendStatisticIcon"></div>
                    <div class="eachPartStatisticNums">
                        <span>{{__('بیش از')}}</span>
                        <span class="userCountMiddleBanner"></span>
                    </div>
                    <div class="eachPartStatisticTitle">{{__('دوست')}}</div>
                </div>
                <div class="eachPartStatistic">
                    <div class="eachPartStatisticIcons commentStatisticIcon"></div>
                    <div class="eachPartStatisticNums">
                        <span>{{__('بیش از')}}</span>
                        <span class="commentCountMiddleBanner"></span>
                    </div>
                    <div class="eachPartStatisticTitle">{{__('نظر')}}</div>
                </div>
                <div class="eachPartStatistic">
                    <div class="eachPartStatisticIcons traditionalFoodStatisticIcon"></div>
                    <div class="eachPartStatisticNums">
                        <span>{{__('بیش از')}}</span>
                        <span class="mahaliFoodCountMiddleBanner"></span>
                    </div>
                    <div class="eachPartStatisticTitle">{{__('غذای محلی')}}</div>
                </div>
                <div class="eachPartStatistic">
                    <div class="eachPartStatisticIcons souvenirStatisticIcon"></div>
                    <div class="eachPartStatisticNums">
                        <span>{{__('بیش از')}}</span>
                        <span class="sogatSanaieCountMiddleBanner"></span>
                    </div>
                    <div class="eachPartStatisticTitle">{{__('سوغات')}}</div>
                </div>
                <div class="eachPartStatistic">
                    <div class="eachPartStatisticIcons handcraftStatisticIcon"></div>
                    <div class="eachPartStatisticNums">
                        <span>{{__('بیش از')}}</span>
                        <span class="sogatSanaieCountMiddleBanner"></span>
                    </div>
                    <div class="eachPartStatisticTitle">{{__('صنایع‌دستی')}}</div>
                </div>
                <div class="eachPartStatistic">
                    <div class="eachPartStatisticIcons attractionStatisticIcon"></div>
                    <div class="eachPartStatisticNums">
                        <span>{{__('بیش از')}}</span>
                        <span class="amakenCountMiddleBanner"></span>
                    </div>
                    <div class="eachPartStatisticTitle">{{__('جاذبه')}}</div>
                </div>
                <div class="eachPartStatistic">
                    <div class="eachPartStatisticIcons restaurantStatisticIcon"></div>
                    <div class="eachPartStatisticNums">
                        <span>{{__('بیش از')}}</span>
                        <span class="restaurantCountMiddleBanner"></span>
                    </div>
                    <div class="eachPartStatisticTitle">{{__("رستوران")}}</div>
                </div>
                <div class="eachPartStatistic">
                    <div class="eachPartStatisticIcons residenceStatisticIcon"></div>
                    <div class="eachPartStatisticNums">
                        <span>{{__('بیش از')}}</span>
                        <span class="hotelCountMiddleBanner"></span>
                    </div>
                    <div class="eachPartStatisticTitle">{{__('اقامتگاه')}}</div>
                </div>
                <div class="eachPartStatistic">
                    <div class="eachPartStatisticIcons boom"></div>
                    <div class="eachPartStatisticNums">
                        <span>{{__('بیش از')}}</span>
                        <span class="boomgardyCountMiddleBanner"></span>
                    </div>
                    <div class="eachPartStatisticTitle">{{__('بوم گردی')}}</div>
                </div>
            </div>

            <div id="pos-article-text-16130"></div>

            <div id="kharidSuggestion" class="suggestRowsMainPage marginBetweenMainPageMobileElements hidden">
                <div class="shelf_title">
                    <img class="hideOnPhone" src="{{URL::asset('images/icons/iconneg.svg')}}" alt="کوچیتا، سامانه جامع گردشگری ایران" loading="lazy" style="width: 50px;">
                    <img class="hideOnScreen" src="{{URL::asset('images/icons/iconnegBlack.svg')}}" alt="کوچیتا، سامانه جامع گردشگری ایران" loading="lazy" style="width: 50px;">
                    <div class="shelf_title_container h3">
                        <h3>{{__('مراکز خرید')}}</h3>
                    </div>
                </div>
                <div class="shelf_item_container ui_columns is-mobile is-multiline" style="width: 100%">
                    <div class="mainSuggestion swiper-container">
                        <div class="topKharid swiper-wrapper suggestionBody">
                            {{--                            fill with createMainPageSuggestion function--}}
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>

{{--            @if(!isset($middleBan['2']) || $middleBan['2'] == null)--}}
{{--                <div class="middleBannerPhotoBanner">--}}
{{--                    <div class="dropping-texts">--}}
{{--                        <div>بشینیم</div>--}}
{{--                        <div>برنامه ریزی کنیم</div>--}}
{{--                        <div>سفر کنیم</div>--}}
{{--                        <div>بخندیم</div>--}}
{{--                    </div>--}}
{{--                    با هم--}}
{{--                </div>--}}
{{--            @else--}}
{{--                <div class="middleBannerPhotoBanner middleBannerPB">--}}
{{--                    @if($middleBan['2']['link'] != '')--}}
{{--                        <a href="{{$middleBan['2']['link']}}" target="_blank" >--}}
{{--                            <img data-src="{{$middleBan['2']['pic']}}" alt="کوچیتا، سامانه جامع گردشگری ایران" loading="lazy" class="lazyload" style="width: 100%;">--}}
{{--                        </a>--}}
{{--                    @else--}}
{{--                        <img data-src="{{$middleBan['2']['pic']}}" alt="کوچیتا، سامانه جامع گردشگری ایران" loading="lazy" class="lazyload" style="width: 100%;">--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--            @endif--}}
        </div>

        <div class="footerBarSpacer"></div>
    </div>
</div>

<script>
    var bannerIsLoaded = false;
    var middleBan5Color = ['red', 'green', 'navy'];
    var middleBan5 = {!! isset($middleBan['5']) ? $middleBan['5'] : json_encode([]) !!};
    var middleBan4 = {!! isset($middleBan['4']) ? $middleBan['4'] : json_encode([]) !!};
    var loadSuggestion = false;
    var lastPageForSuggestion = [];
    var divNames = ['newInKoochita', 'topFood', 'topTabiat', 'topRestaurant', 'topTarikhi', 'topSafarnameh']; /*'topKharid'*/
    var sugg4PlaceHolder = getSuggestionPackPlaceHolder();
    sugg4PlaceHolder += sugg4PlaceHolder+sugg4PlaceHolder+sugg4PlaceHolder;

    divNames.forEach(item => {
        $(`.${item}`).html(sugg4PlaceHolder);
        $(`.${item}`).find('.suggestionPackDiv').addClass('swiper-slide');
        $(`.${item}`).css('direction', 'ltr');
    });
    runMainSwiper('mainSuggestion');

    if (typeof(Storage) !== "undefined") {
        let lastPages;
        lastPages = localStorage.getItem('lastPages');
        if(lastPages != null)
            lastPageForSuggestion = JSON.parse(lastPages);
    } else
        console.log('your browser not support localStorage');

    function ajaxToFillMainPageSuggestion(){
        if(!bannerIsLoaded)
            loadMainPageSliders();

        var states = [];
        lastPageForSuggestion.map(item => states.push(item.state));

        $.ajax({
            type: 'GET',
            url: '{{route("getMainPageSuggestion")}}?lastPage='+JSON.stringify(states),
            success: response => {
                createMainPageSuggestion(response);
                // fillCountNumber(response.count);
            }
        })
    }

    function loadMainPageSliders(){
        bannerIsLoaded = true;
        var text = '';
        if(middleBan5.length > 0){
            $('.cityMainPageSlider').parent().removeClass('hidden');
            middleBan5.map((item, index) => {
                text += `<div class="swiper-slide position-relative citySliderMainPageItem">
                           <figure class="snip1091 ${middleBan5Color[index%3]}">
                               <img src="${item.pic}" alt="کوچیتا، سامانه جامع گردشگری ایران" loading="lazy" class="resizeImgClass" style="width: 100%"/>
                               <figcaption>
                                   <h2>${item.text}</h2>
                               </figcaption>
                               ${ item.link != '' ? `<a href="${item.link}"></a>` : '' }
                           </figure>
                        </div>`
            });
            $('.cityMainPageSlider').html(text);

            new Swiper('.threeSlider', {
                loop: true,
                breakpoints: {
                    768: {
                        slidesPerView: 'auto',
                        centeredSlides: true,
                        spaceBetween: 10,
                    },
                    10000: {
                        loopFillGroupWithBlank: true,
                        slidesPerView: 3,
                        spaceBetween: 20,
                    }
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                }
            });
        }
        else
            $('.cityMainPageSlider').parent().remove();


        if(middleBan4.length > 0){
            Baner4isLoaded = true;
            var Ban4Text = '';
            middleBan4.map((item, index) => Ban4Text += `<a href="{{route('place.list', ['kindPlaceId' => 6, 'mode' => 'country'])}}" id='slide${index+1}' class='mainBlubSlider ${index == 0 ? 'up1' : ''}' style="background-image: url('${item.pic}'); ">${item.text}</a>`)
            $('#middleBan4Body').html(Ban4Text);
        }
        else
            $('#middleBan4Body').parent().parent().remove();

    }

    function fillCountNumber(_counts){
        // CountMiddleBanner
        $('.safarnamehCountMiddleBanner').text(_counts.safarnameh);
        $('.userCountMiddleBanner').text(_counts.userCount);
        $('.commentCountMiddleBanner').text(_counts.comment);
        $('.mahaliFoodCountMiddleBanner').text(_counts.mahaliFood);
        $('.sogatSanaieCountMiddleBanner').text(_counts.sogatSanaie);
        $('.amakenCountMiddleBanner').text(_counts.amaken);
        $('.restaurantCountMiddleBanner').text(_counts.restaurant);
        $('.hotelCountMiddleBanner').text(_counts.hotel);
        $('.boomgardyCountMiddleBanner').text(_counts.boomgardy);
    }

    function createMainPageSuggestion(_result){
        let food = _result.topFood;
        let tarikhi = _result.amaken;
        let tabiat = _result.majara;
        let restaurant = _result.restaurant;
        let kharid = _result.bazar;
        let safarnameh = _result.safarnameh;

        // createSuggestionPack in suggestionPack.blade.php
        createSuggestionPack('newInKoochita', _result.result, function() {
            $('.newInKoochita').find('.suggestionPackDiv').addClass('swiper-slide');
            $('.newInKoochita').css('direction', 'ltr');
        }, true);

        createSuggestionPack('topFood', food, function() {
            $('.topFood').find('.suggestionPackDiv').addClass('swiper-slide');
            $('.topFood').css('direction', 'ltr');
        }, true);

        createSuggestionPack('topTabiat', tabiat, function() {
            $('.topTabiat').find('.suggestionPackDiv').addClass('swiper-slide');
            $('.topTabiat').css('direction', 'ltr');
        }, true);

        createSuggestionPack('topRestaurant', restaurant, function() {
            $('.topRestaurant').find('.suggestionPackDiv').addClass('swiper-slide');
            $('.topRestaurant').css('direction', 'ltr');
        }, true);

        createSuggestionPack('topTarikhi', tarikhi, function() {
            $('.topTarikhi').find('.suggestionPackDiv').addClass('swiper-slide');
            $('.topTarikhi').css('direction', 'ltr');
        }, true);

        // createSuggestionPack('topKharid', kharid, function() {
        //     $('.topKharid').find('.suggestionPackDiv').addClass('swiper-slide');
        //     $('.topKharid').css('direction', 'ltr');
        // });

        createSuggestionPack('topSafarnameh', safarnameh, function() {
            $('.topSafarnameh').find('.suggestionPackDiv').addClass('swiper-slide');
            $('.topSafarnameh').css('direction', 'ltr');
            runMainSwiper('mainSuggestion')
        }, true);
    }

    function runMainSwiper(_class){
        new Swiper('.' + _class, {

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
                // 520: {
                //     slidesPerView: 2,
                //     spaceBetween: 20,
                // },
                768: {
                    slidesPerView: 'auto',
                    spaceBetween: 10,
                    loop: false,
                    // slidesPerView: 2,
                    // spaceBetween: 20,
                },
                992: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                10000: {
                    slidesPerView: 4,
                    spaceBetween: 20,
                }
            }
        });
    }

    // this run function for mainArticlaSwiperMainPage
    // runMainSwiper('mainArticlaSwiperMainPage');

    if($(window).width() <= 767 && !bannerIsLoaded)
        loadMainPageSliders();

    $(window).ready(() => {
        let loadSuggestionLine = document.getElementById('loadSuggestionLine').getBoundingClientRect().top;
        if (loadSuggestionLine - $(window).height() <= 0) {
            loadSuggestion = true;
            ajaxToFillMainPageSuggestion();
        }

        $(window).on('scroll', function(e){
            if(!loadSuggestion) {
                let loadSuggestionLine = document.getElementById('loadSuggestionLine').getBoundingClientRect().top;
                if (loadSuggestionLine - $(window).height() <= 0) {
                    loadSuggestion = true;
                    ajaxToFillMainPageSuggestion();
                }
            }
        });
    })
</script>


