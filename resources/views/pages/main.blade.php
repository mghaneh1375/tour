<!DOCTYPE html>
<html lang="{{\App::getLocale()}}">

<head>
    @include('layouts.topHeader')

    <meta property="og:locale" content="fa_IR" />
    <meta property="og:type" content="website" />
    <title> کوچیتا، سامانه جامع گردشگری ایران </title>
    <meta name="title" content="کوچیتا | سامانه جامع گردشگری ایران و شبکه اجتماعی گردشگران" />
    <meta name='description' content='کوچیتا، سامانه جامع گردشگری ایران و شبکه اجتماعی گردشگران. اطلاعات اماکن و جاذبه ها، هتل ها، بوم گردی، ماجراجویی، آموزش سفر، فروشگاه صنایع‌دستی ، پادکست سفر' />
    <meta name='keywords' content='کوچیتا، هتل، تور ، سفر ارزان، سفر در ایران، بلیط، تریپ، نقد و بررسی، سفرنامه، کمپینگ، ایران گردی، آموزش سفر، مجله گردشگری، مسافرت، مسافرت داخلی, ارزانترین قیمت هتل ، مقایسه قیمت ، بهترین رستوران‌ها ، بلیط ارزان ، تقویم تعطیلات' />
    <meta property="og:image" content="{{URL::asset('images/mainPics/noPicSite.jpg')}}"/>
    <meta property="og:image:secure_url" content="{{URL::asset('images/mainPics/noPicSite.jpg')}}"/>
    <meta property="og:image:width" content="550"/>
    <meta property="og:image:height" content="367"/>
    <meta name="twitter:image" content="{{URL::asset('images/mainPics/noPicSite.jpg')}}"/>

    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/mainPageStyles.css?v='.$fileVersions)}}'/>

    @if(\App::getLocale() == 'en')
        <link rel="stylesheet" href="{{URL::asset('css/ltr/mainPage.css?v='.$fileVersions)}}">
    @endif

    <style>
        .backgroundColorForSlider{
            background-size: cover;
            background-position: right;
        }
        .mainH1{
            text-align: center;
            font-family: IRANSans;
            margin: 12px 0px;
        }

        .mobileMainBanner{
            overflow: hidden;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }
    </style>

    {{--urls--}}
    <script>
        var searchDir = '{{route('totalSearch')}}';
        var kindPlaceId = '{{$kindPlaceId}}';
        var recentlyUrl =  '{{route("recentlyViewed")}}';
        var getMainPageSuggestion =  '{{route("getMainPageSuggestion")}}';
        var imageBasePath = '{{URL::asset('images')}}';
        var getCitiesDir = "{{route('getCitiesDir')}}";
        var url;

        var config = {
            {{--headers: {--}}
            {{--    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;',--}}
            {{--    'X-CSRF-TOKEN': '{{csrf_token()}}'--}}
            {{--}--}}
        };

    </script>
</head>

<body style="background-color: #EAFBFF;">

    @include('general.forAllPages')

    @include('layouts.header1')

    <div id="mainDivContainerMainPage">
        <div class="mainBannerSlider">

            <div class="hideOnPhone" style="width: 100%; height: 100%;">
                <div id="mainSlider" class="swiper-container backgroundColorForSlider">
                    <div class="swiper-wrapper">
                        @foreach($sliderPic as $item)
                            <div class="swiper-slide mobileHeight imgOfSliderBox">
                                <img data-src="{{$item->pic}}" alt="کوچیتا، سامانه جامع گردشگری ایران" loading="lazy" class="lazyload imgOfSlider">
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
                <div class="mainDivSearchInputMainPage">
                    <div class="searchDivForScrollClass mainSearchDivPcSize">
                        <div onclick="openMainSearch(0) // in mainSearch.blade.php" style="text-align: center; font-size: 25px;">{{__('به کجا می‌روید؟')}}</div>
                    </div>
                    <div class="clear-both"></div>
                </div>
                <div class="sliderTextBox">
                    <div class="console-container">
                        <span id='text' class="sliderText"></span>
                    </div>
                </div>
            </div>
            <div class="hideOnScreen mobileMainBanner">
                <img src="{{URL::asset('images/mainPics/mobileMainPic.jpeg')}}" alt="mobileKoochita" class="resizeImgClass" onload="fitThisImg(this)">
                <div class="mainDivSearchInputMainPage">
                    <div class="searchDivForScrollClass mainSearchDivPcSize">
                        <div class="mainPageMainSearchText searchIcon" onclick="openMainSearch(0) // in mainSearch.blade.php">{{__('به کجا می‌روید؟')}}</div>
                    </div>
                </div>
                <div class="mainDivSearchInputMainPage nearMe">
                    <div class="searchDivForScrollClass mainSearchDivPcSize">
                        <a href="{{route("myLocation")}}" class="mainPageMainSearchText sendIconAfter locationIcon">اطراف من</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <h1 class="mainH1 hideOnPhone">کوچیتا، سامانه جامع گردشگری ایران</h1>

    @include('layouts.middleBanner')

    @include('layouts.footer.layoutFooter')

    <script>
    var mainSliderPics = {!! $sliderPic !!};

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
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    swiper.on('slideChange', function(){

        if(mainSliderPics[swiper.realIndex]['backgroundPic'] != null)
            $('.backgroundColorForSlider').css('background-image', 'url("' + mainSliderPics[swiper.realIndex]['backgroundPic'] + '")');
        else
            $('.backgroundColorForSlider').css('background-color', mainSliderPics[swiper.realIndex]['textBackground']);

        if(mainSliderPics[swiper.realIndex]['text'] != null)
            consoleText(mainSliderPics[swiper.realIndex]['text'], 'text', mainSliderPics[swiper.realIndex]['textColor']);
    });

    var setInterText = 0;
    if(mainSliderPics[0]['text'] != null)
        consoleText(mainSliderPics[0]['text'], 'text', mainSliderPics[0]['textColor']);

    if(mainSliderPics[0]['backgroundPic'] != null)
        $('.backgroundColorForSlider').css('background-image', 'url("' + mainSliderPics[0]['backgroundPic'] + '")');
    else
        $('.backgroundColorForSlider').css('background-color', mainSliderPics[0]['textBackground']);

    function consoleText(words, id, colors) {
        document.getElementById('text').innerHTML = '';

        if(setInterText != 0)
            clearInterval(setInterText);

        document.getElementById(id).innerHTML = '';
        if (colors === undefined) colors = ['#fff'];
        var visible = true;
        var con = document.getElementById('console');
        var letterCount = 1;
        var x = 1;
        var waiting = false;
        var target = document.getElementById(id);
        target.setAttribute('style', 'color:' + colors);

        setInterText = window.setInterval(function() {
            if (letterCount === 0 && waiting === false) {
                waiting = true;
                target.innerHTML = words.substring(0, letterCount);
                window.setTimeout(function() {
                    var usedColor = colors.shift();
                    colors.push(usedColor);
                    var usedWord = words.shift();
                    words.push(usedWord);
                    x = 1;
                    target.setAttribute('style', 'color:' + color);
                    letterCount += x;
                    waiting = false;
                }, 10)
            }
            else if (waiting === false) {
                target.innerHTML = words.substring(0, letterCount);
                letterCount += x;
            }
        }, 70);
    }

</script>

</body>
</html>

