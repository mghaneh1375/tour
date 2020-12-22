<?php $placeMode = "ticket";
$state = "تهران";
$kindPlaceId = 10; ?>

        <!DOCTYPE html>
<html>
<head>
    @include('layouts.topHeader')
    @include('layouts.phonePopUp')

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/home_rebranded.css?v=4')}}"/>
    <title>صفحه اصلی</title>

    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/theme2/long_lived_global_legacy_2.css?v=2')}}"/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/theme2/masthead-saves.css?v=2')}}'/>
    <link rel='stylesheet' type='text/css' media='screen, print'
          href='{{URL::asset('css/theme2/hr_north_star.css?v=2')}}'/>
    <link rel='stylesheet' type='text/css' href='{{URL::asset('css/shazdeDesigns/icons.css?v=1')}}'/>

    <script src= {{URL::asset("js/calendar.js") }}></script>
    <script src= {{URL::asset("js/jalali.js") }}></script>

    <style>
        .mainBox {
            width: 85%;
            margin: 5% auto 0;
            padding: 10px;
            border-radius: 10px;
            background-color: #e1e1e1;
            text-align: right;
        }
        .fourBox {
            cursor: pointer;
            width: 18%;
            margin: 0 18px;
            display: inline-block;
            height: 200px;
            border: 1px solid var(--koochita-light-green);
            text-align: center;
            position: relative;
            font-weight: 700;
        }
        .textFourBox {
            position: absolute;
            bottom: 0;
            padding: 15px 5px;
        }
    </style>
    <style>
        .underMainBox {
            width: 85%;
            margin: 1% auto 5%;
            padding: 10px;
            border-radius: 10px;
            background-color: #e1e1e1;
            text-align: right;
        }
        .threeHiddenBox {
            width: 33%;
            text-align: center;
            display: inline-block;
        }
        .loginRegister {
            color: white;
            line-height: 15px;
            width: 150px;
            border-radius: 7px;
            text-align: center;
            margin: 5px 0;
            font-size: 1.1em;
        }
    </style>

</head>

<body id="BODY_BLOCK_JQUERY_REFLOW"
      class=" r_map_position_ul_fake ltr domn_en_US lang_en long_prices globalNav2011_reset rebrand_2017 css_commerce_buttons flat_buttons sitewide xo_pin_user_review_to_top track_back">

<div id="PAGE" class="filterSearch redesign_2015 non_hotels_like desktop scopedSearch">
    @include('layouts.placeHeader')

<div>
    <div class="mainBox">
        <div>
            <div style="float: right"> شما در حال انتقال به سایت ارایه دهنده هتل هستید </div>
            <div style="text-align: left">
                <a href="{{session('backURL')}}" style=" color: #0c0593 !important;"> << بازگشت به صفحه اطلاعات هتل </a>
            </div>
        </div>

        <div style="border-bottom: 1.5px solid #aeaeae; margin: 7px 0;"></div>

        <div style="direction: rtl; font-size: 1.2em;"> یک گام پیش از خرید بلیط </div>
        <div  style="direction: rtl; font-size: 0.9em;"> شما به پروفایل کاربری خود وارد نشده اید. در مورد عضویت در شازده فکر کرده اید </div>
        <center style="margin: 5px 0">
            <div class="fourBox" style="background: url('{{URL::asset('images/preTicket1.png')}}') 100% 100% no-repeat no-repeat; background-size: contain; background-color: lightgrey">
                <div class="textFourBox"> آیا می دانید با عضویت در شازده با هم بهترین لحظات را خلق می کنیم </div>
                <div></div>
            </div>
            <div class="fourBox" style="background: url('{{URL::asset('images/preTicket2.png')}}') 100% 100% no-repeat no-repeat; background-size: contain; background-color: var(--koochita-light-green)">
                <div class="textFourBox"> آیا می دانید با عضویت در سایت هیشه بهترین قیمت ها و پیشنهادات برای شماست </div>
                <div></div>
            </div>
            <div class="fourBox" style="background: url('{{URL::asset('images/preTicket3.png')}}') 100% 100% no-repeat no-repeat; background-size: contain; background-color: lightgrey">
                <div class="textFourBox"> آیا می دانید هر کار شما در شازده برای ما ارزشمند است و ما قدر آن را می دانیم </div>
                <div></div>
            </div>
            <div class="fourBox" style="background: url('{{URL::asset('images/preTicket4.png')}}') 100% 100% no-repeat no-repeat; background-size: contain; background-color: var(--koochita-light-green)">
                <div class="textFourBox"> آیا می دانید با عضویت در سایت دیگر نیاز به وارد کردن اطلاعات برای هر بار خرید نمی باشید </div>
                <div></div>
            </div>
        </center>
    </div>
    <div class="underMainBox">
        @if(!Auth::check())
            <div class="threeHiddenBox" style="float: left; line-height: 85px">
                <a href="{{url('hotelPas/1')}}"> فعلا نه </a>
            </div>
            <div class="threeHiddenBox">
                <div> می خواهم عضو شوم </div>
                <button onclick="window.location.href='{{url('hotelPas/2')}}'" class="btn loginRegister" type="button" style="background-color: #92321b"> ثبت نام کنید </button>
                <div style="font-size: 0.6em"> ما از اطلاعاتی که برای خرید بلیط وارد می کنید استفاده می کنیم </div>
            </div>
            <div class="threeHiddenBox" style="float: right">
                <div> من عضو شازده هستم </div>
                <button onclick="showHalfLogin()" class="btn loginRegister" type="button" style="background-color: var(--koochita-light-green)"> وارد شوید </button>
            </div>
        @else
            <center>
                <div class="threeHiddenBox" style="line-height: 45px">
                    <button onclick="window.location.href='{{url('hotelPas')}}'" class="btn loginRegister" type="button" style="background-color: var(--koochita-light-green)"> مرحله بعد </button>
                </div>
            </center>
        @endif
    </div>
</div>

    @include('layouts.footer.layoutFooter')
</div>

@if(!Auth::check())
    @include('layouts.loginPopUp2')
@endif

<div class="ui_backdrop dark" style="display: none; z-index: 10000000"></div>

    <script>

        $('.login-button').click(function() {
            $(".dark").show();
            showLoginPrompt(url);
        });

        function showHalfLogin() {
            var url = '{{url('buyHotel')}}';
            $(".dark").show();
            $(".registerPaneInLoginPopUp").addClass('hidden');
            $(".loginPaneInLoginPopUp").removeClass('col-xs-6').addClass('col-xs-12');
            showLoginPrompt(url);
        }
        
        function showElement(e) {
            $("#" + e).removeClass("hidden");
            $(".dark").show()
        }

        function hideElement(e) {
            $("#" + e).addClass("hidden");
            $(".dark").hide()
        }

    </script>

</body>
</html>